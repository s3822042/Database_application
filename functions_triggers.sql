--funtion to find the nearest hub id from defined latitude and longtitude
DROP FUNCTION IF EXISTS nearest_hub;
DELIMITER $$
create function nearest_hub(_Latitude float, _Longitude float)
returns int not deterministic
begin
	declare nearest_hubID int;
	SELECT HubID into nearest_hubID
	FROM (
	    SELECT HubID, SQRT(POW(Hub.Latitude - _Latitude, 2) + POW(Hub.longitude - _Longitude, 2)) As Distance
        FROM Hub
        GROUP BY HubID
        ORDER BY Distance
        limit 1
         ) AS T;
  return nearest_hubID;
end $$
select nearest_hub(34.64, 0.454);

-- trigger insert vendor
DROP TRIGGER IF EXISTS before_insert_vendor;
DELIMITER $$
CREATE TRIGGER before_insert_vendor
BEFORE INSERT
ON vendor FOR EACH ROW
BEGIN
    DECLARE nearestHub INT;

    SELECT nearest_hub(NEW.Latitude, NEW.Longitude)
    INTO nearestHub;

    SET NEW.HubID = nearestHub;

END$$
DELIMITER ;

--trigger customer
DROP TRIGGER IF EXISTS before_insert_customer;
DELIMITER $$
CREATE TRIGGER before_insert_customer
BEFORE INSERT
ON customer FOR EACH ROW
BEGIN
    DECLARE nearestHub INT;

    SELECT nearest_hub(NEW.Latitude, NEW.Longitude)
    INTO nearestHub;

    SET NEW.HubID = nearestHub;

END$$
DELIMITER ;

-- trigger update vendor
DROP TRIGGER IF EXISTS before_update_vendor;
DELIMITER $$
CREATE TRIGGER before_update_vendor
BEFORE UPDATE
ON vendor FOR EACH ROW
BEGIN
    DECLARE nearestHub INT;
    IF(NEW.Longitude <> OLD.Longitude AND NEW.Latitude <> OLD.Latitude)
    THEN
        SELECT nearest_hub(NEW.Latitude, NEW.Longitude)
        INTO nearestHub;
         SET NEW.HubID = nearestHub;
    END IF;
    IF (NEW.Longitude <> OLD.Longitude AND NEW.Latitude = OLD.Latitude)
    THEN
        SELECT nearest_hub(OLD.Latitude, NEW.Longitude)
        INTO nearestHub;
         SET NEW.HubID = nearestHub;
    END IF;
    IF (NEW.Longitude = OLD.Longitude AND NEW.Latitude <> OLD.Latitude)
    THEN
        SELECT nearest_hub(NEW.Latitude, OLD.Longitude)
        INTO nearestHub;
        SET NEW.HubID = nearestHub;
    END IF;

END$$

--trigger update customer
DROP TRIGGER IF EXISTS before_update_customer;
DELIMITER $$
CREATE TRIGGER before_update_customer
BEFORE UPDATE
ON customer FOR EACH ROW
BEGIN
    DECLARE nearestHub INT;
    IF(NEW.Longitude <> OLD.Longitude AND NEW.Latitude <> OLD.Latitude)
    THEN
        SELECT nearest_hub(NEW.Latitude, NEW.Longitude)
        INTO nearestHub;
         SET NEW.HubID = nearestHub;
    END IF;
    IF (NEW.Longitude <> OLD.Longitude AND NEW.Latitude = OLD.Latitude)
    THEN
        SELECT nearest_hub(OLD.Latitude, NEW.Longitude)
        INTO nearestHub;
         SET NEW.HubID = nearestHub;
    END IF;
    IF (NEW.Longitude = OLD.Longitude AND NEW.Latitude <> OLD.Latitude)
    THEN
        SELECT nearest_hub(NEW.Latitude, OLD.Longitude)
        INTO nearestHub;
        SET NEW.HubID = nearestHub;
    END IF;

END$$

-- store procedure transactions
-- reference from http://geekdirt.com/blog/shared-and-exclusive-locks/
DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_fail`;
CREATE PROCEDURE `sp_fail`(
        IN `CustomerID` int(11),
        IN `VendorID` int(11) ,
        IN `ShipperID` int(11),
        IN `HubID` int(11),
        IN ProductID int(11)
)
BEGIN
    DECLARE `_rollback` BOOL DEFAULT 0;
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET `_rollback` = 1;
    START TRANSACTION;

        SELECT * FROM product WHERE product.ProductID = ProductID LOCK IN SHARE MODE;
        INSERT INTO orders (CustomerID, VendorID,ShipperID,HubID, ProductID)
        VALUES
        (CustomerID, VendorID, ShipperID, HubID, ProductID);
       -- UPDATE product SET Status = 'Pending' WHERE product.ProductID = ProductID;
       -- DELETE FROM hub WHERE HubID = 3;

        SELECT SLEEP(30);
       -- UPDATE product SET Status = 'Purchases' WHERE product.ProductID = ProductID;
    IF `_rollback` THEN
        ROLLBACK;
    ELSE
        COMMIT;
    END IF;
END$$

DELIMITER ;
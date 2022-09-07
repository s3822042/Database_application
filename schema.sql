DROP DATABASE IF EXISTS lazadar;
CREATE DATABASE lazadar;
USE lazadar;

CREATE TABLE IF NOT EXISTS Hub(
    HubID int NOT NULL AUTO_INCREMENT,
    HubName varchar(50) NOT NULL,
    HubAddress varchar(50) NOT NULL,
    Latitude FLOAT NOT NULL,
    Longitude FLOAT NOT NULL,
    PRIMARY KEY (HubID)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Vendor(
    VendorID int NOT NULL AUTO_INCREMENT,
    VendorName varchar(50) NOT NULL,
    VendorAddress varchar(50) UNIQUE NOT NULL,
    VendorUsername varchar(50) UNIQUE NOT NULL,
    VendorPassword varchar(255) NOT NULL,
    Latitude FLOAT NOT NULL,
    Longitude FLOAT NOT NULL,
    HubID int,
    PRIMARY KEY (VendorID),
    FOREIGN KEY (HubID) REFERENCES Hub(HubID)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Customer(
    CustomerID int NOT NULL AUTO_INCREMENT,
    CustomerName varchar(50) NOT NULL,
    CustomerAddress varchar(50) UNIQUE NOT NULL,
    CustomerUsername varchar(50) UNIQUE NOT NULL,
    CustomerPassword varchar(255) NOT NULL,
    Latitude FLOAT NOT NULL,
    Longitude FLOAT NOT NULL,
    HubID int,
    PRIMARY KEY (CustomerID),
    FOREIGN KEY (HubID) REFERENCES Hub(HubID)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Shipper(
    ShipperID int NOT NULL AUTO_INCREMENT,
    ShipperUsername varchar(50) NOT NULL,
    ShipperPassword varchar(255) NOT NULL,
    HubID int,
    PRIMARY KEY (ShipperID),
    FOREIGN KEY (HubID) REFERENCES Hub(HubID)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Product (
  ProductID int NOT NULL AUTO_INCREMENT,
  ProductName varchar(255) NOT NULL,
  ProductDescription varchar(255) NOT NULL,
  VendorID int DEFAULT NULL,
  Price int DEFAULT NULL,
  haveExtraField varchar(255),
  added_date DATE,
  PRIMARY KEY (ProductID),
  FOREIGN KEY (VendorID) REFERENCES Vendor(VendorID)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS Orders(
    OrderID int NOT NULL AUTO_INCREMENT,
    CustomerID int,
    VendorID int,
    ShipperID int,
    HubID int,
    ProductID int,
    OrderStatus varchar(50) DEFAULT 'Ready',
    PRIMARY KEY (OrderID),
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID),
    FOREIGN KEY (VendorID) REFERENCES Vendor(VendorID),
    FOREIGN KEY (ShipperID) REFERENCES Shipper(ShipperID),
    FOREIGN KEY (HubID) REFERENCES Hub(HubID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
) ENGINE = InnoDB;




DROP ROLE IF EXISTS 'vendor';
DROP ROLE IF EXISTS 'customer';
DROP ROLE IF EXISTS 'shipper';
DROP USER IF EXISTS 'vendor'@'localhost';
DROP USER IF EXISTS 'customer'@'localhost';
DROP USER IF EXISTS 'shipper'@'localhost';

CREATE ROLE 'vendor', 'customer', 'shipper';
GRANT SELECT, INSERT ON lazadar.vendor TO 'vendor';
GRANT SELECT, UPDATE, DELETE, INSERT ON lazadar.product TO 'vendor';

GRANT SELECT, INSERT ON lazadar.customer TO 'customer';
GRANT SELECT, INSERT ON lazadar.orders TO 'customer';
GRANT SELECT, EXECUTE ON lazadar.vendor TO 'customer';
GRANT SELECT, EXECUTE ON lazadar.product TO 'customer';

GRANT SELECT, UPDATE ON lazadar.orders TO 'shipper';
GRANT SELECT, UPDATE ON lazadar.product TO 'shipper';
GRANT SELECT ON lazadar.customer TO 'shipper';


CREATE USER 'customer'@'localhost' IDENTIFIED BY '1';
GRANT 'customer' TO 'customer'@'localhost';

CREATE USER 'vendor'@'localhost' IDENTIFIED BY '1';
GRANT 'vendor' TO 'vendor'@'localhost';

CREATE USER 'shipper'@'localhost' IDENTIFIED BY '1';
GRANT 'shipper' TO 'shipper'@'localhost';


SET GLOBAL log_bin_trust_function_creators = 1;

-- indexing
CREATE INDEX productName ON product (ProductName);
CREATE INDEX productPrice ON product (Price);

-- funtion to find the nearest hub id from defined latitude and longtitude
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

-- trigger customer
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

-- trigger update customer
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
DROP PROCEDURE IF EXISTS `sp_fail`;
DELIMITER $$
CREATE PROCEDURE `sp_fail`(
        IN `CustomerID` int(11),
        IN `VendorID` int(11) ,
        IN `HubID` int(11),
        IN ProductID int(11),
        IN RandomWaitingTime int
)
BEGIN
    DECLARE `_rollback` BOOL DEFAULT 0;
    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION SET `_rollback` = 1;
    START TRANSACTION;

        -- SELECT * FROM product WHERE product.ProductID = ProductID FOR UPDATE ;
        INSERT INTO orders (CustomerID, VendorID,HubID, ProductID)
        VALUES
        (CustomerID, VendorID, HubID, ProductID);
       -- UPDATE product SET Status = 'Pending' WHERE product.ProductID = ProductID;
       -- DELETE FROM hub WHERE HubID = 3;

        SELECT SLEEP(RandomWaitingTime);
       -- UPDATE product SET Status = 'Purchases' WHERE product.ProductID = ProductID;
    IF `_rollback` THEN
        ROLLBACK;
    ELSE
        COMMIT;
    END IF;
END$$

DELIMITER ;









-- hub
insert into Hub (HubID, HubName, HubAddress, Latitude, Longitude) values (1, 'Shayna Kennermann', '9855 Nelson Terrace', -0.6256517, 100.1233396);
insert into Hub (HubID, HubName, HubAddress, Latitude, Longitude) values (2, 'Reena Ventum', '84 Maple Place', 51.4255297, -0.2050566);
insert into Hub (HubID, HubName, HubAddress, Latitude, Longitude) values (3, 'Melania McClarence', '9186 Washington Street', -5.456385, 122.612261);
insert into Hub (HubID, HubName, HubAddress, Latitude, Longitude) values (4, 'Rosaline Bosche', '013 Eastlawn Park', 21.857958, 111.982232);
insert into Hub (HubID, HubName, HubAddress, Latitude, Longitude) values (5, 'Laurence Puddan', '2845 Waywood Road', 9.3295342, 124.6133794);
insert into Hub (HubID, HubName, HubAddress, Latitude, Longitude) values (6, 'Garrot Appleton', '2077 Anzinger Junction', -6.9078713, -36.9111057);
insert into Hub (HubID, HubName, HubAddress, Latitude, Longitude) values (7, 'Penny Cairns', '75983 Arkansas Park', 58.3493356, 13.8300629);
insert into Hub (HubID, HubName, HubAddress, Latitude, Longitude) values (8, 'Christabel Twentyman', '91 Oriole Hill', 51.8610022, -8.334953);
insert into Hub (HubID, HubName, HubAddress, Latitude, Longitude) values (9, 'Arnoldo Burnhill', '2537 Little Fleur Drive', 40.1791857, 44.4991029);
insert into Hub (HubID, HubName, HubAddress, Latitude, Longitude) values (10, 'Dexter Rowth', '95 Paget Drive', 25.4105868, 68.418057);
insert into Hub (HubID, HubName, HubAddress, Latitude, Longitude) values (11, 'Fenelia Dallander', '47026 Sunnyside Pass', -11.9148486, 43.4969735);
insert into Hub (HubID, HubName, HubAddress, Latitude, Longitude) values (12, 'Amelie Schout', '5383 Hoepker Park', -6.86277, 109.6222698);
insert into Hub (HubID, HubName, HubAddress, Latitude, Longitude) values (13, 'Libby Bertome', '836 Mitchell Alley', -12.3992902, -74.8659421);
insert into Hub (HubID, HubName, HubAddress, Latitude, Longitude) values (14, 'Mirilla Mabbitt', '7 New Castle Point', 30.214647, 20.1402594);

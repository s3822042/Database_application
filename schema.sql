DROP DATABASE IF EXISTS lazadar;
CREATE DATABASE lazadar;
USE lazadar;

CREATE TABLE IF NOT EXISTS Hub(
    HubID int NOT NULL AUTO_INCREMENT,
    HubName varchar(50) NOT NULL,
    HubAddress varchar(50) NOT NULL,
    Latitude FLOAT NOT NULL,
    Longitude FLOAT NOT NU LL,
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






CREATE ROLE 'vendor', ‘customer’, ‘shipper;
GRANT SELECT, INSERT ON lazadar.vendor TO 'vendor';
GRANT SELECT, UPDATE, DELETE, INSERT ON lazadar.product TO 'vendor';

GRANT SELECT, INSERT ON lazadar.customer TO 'customer';
GRANT INSERT ON lazadar.orders TO 'customer';
GRANT SELECT ON lazadar.vendor TO 'customer';
GRANT SELECT ON lazadar.product TO 'customer';

GRANT SELECT, UPDATE ON lazadar.orders TO 'shipper';
GRANT SELECT, UPDATE ON lazadar.product TO 'shipper';
GRANT SELECT ON lazadar.customer TO 'shipper';


CREATE USER 'customer'@'localhost' IDENTIFIED BY '1';
GRANT 'customer' TO 'customer'@'localhost';

CREATE USER 'vendor'@'localhost' IDENTIFIED BY '1';
GRANT 'vendor' TO 'vendor'@'localhost';

CREATE USER 'shipper'@'localhost' IDENTIFIED BY '1';
GRANT 'shipper' TO 'shipper'@'localhost';





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

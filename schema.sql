-- DROP DATABASE db_couse;
-- CREATE DATABASE db_couse;
-- USE db_couse;
CREATE TABLE IF NOT EXISTS Vendor(
    VendorID int NOT NULL AUTO_INCREMENT,
    VendorName varchar(50) NOT NULL,
    VendorAddress varchar(50) UNIQUE NOT NULL,
    VendorUsername varchar(50) UNIQUE NOT NULL,
    VendorPassword varchar(50) NOT NULL,
    Latitude FLOAT NOT NULL,
    Longitude FLOAT NOT NULL,
    PRIMARY KEY (VendorID)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Customer(
    CustomerID int NOT NULL AUTO_INCREMENT,
    CustomerName varchar(50) NOT NULL,
    CustomerAddress varchar(50) UNIQUE NOT NULL,
    CustomerUsername varchar(50) UNIQUE NOT NULL,
    CustomerPassword varchar(50) NOT NULL,
    Latitude FLOAT NOT NULL,
    Longitude FLOAT NOT NULL,
    PRIMARY KEY (CustomerID)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Hub(
    HubID int NOT NULL AUTO_INCREMENT,
    HubName varchar(50) NOT NULL,
    HubAddress varchar(50) NOT NULL,
    Latitude FLOAT NOT NULL,
    Longitude FLOAT NOT NULL,
    PRIMARY KEY (HubID)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Shipper(
    ShipperID int NOT NULL AUTO_INCREMENT,
    ShipperUsername varchar(50) NOT NULL,
    ShipperPassword varchar(50) NOT NULL,
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
    CreatedTime TIMESTAMP NOT NULL,
    OrderStatus varchar(50) DEFAULT 'Ready',
    PRIMARY KEY (OrderID),
    FOREIGN KEY (CustomerID) REFERENCES Customer(CustomerID),
    FOREIGN KEY (VendorID) REFERENCES Vendor(VendorID),
    FOREIGN KEY (ShipperID) REFERENCES Shipper(ShipperID),
    FOREIGN KEY (HubID) REFERENCES Hub(HubID)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS OrderDetail(
    OrderID int,
    ProductID int,
    Amount int,
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID)
) ENGINE = InnoDB;

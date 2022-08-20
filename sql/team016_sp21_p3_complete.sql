



CREATE DATABASE IF NOT EXISTS cs6400_sp2021_team016;

use cs6400_sp2021_team016;

/*Store table*/

DROP TABLE IF EXISTS Store;

CREATE TABLE Store
(
	StoreNumber INT NOT NULL,
	PhoneNumber CHAR(20) NOT NULL,
	StreetAddress VARCHAR(200) NOT NULL,
    CityName VARCHAR(20) NOT NULL,
    State VARCHAR(20) NOT NULL,
	HasRestaurant INT NOT NULL,
	HasSnackBar INT NOT NULL,
	CCLimit INT NULL,
	PRIMARY KEY (StoreNumber)
);


/*ChildCareLimit table*/


DROP TABLE IF EXISTS ChildCareLimit;

CREATE TABLE ChildCareLimit
(
	CCLimit INT NOT NULL,
	PRIMARY KEY (CCLimit)
);



/*City table*/

DROP TABLE IF EXISTS City;

CREATE TABLE City
(
CityName VARCHAR(20) NOT NULL,
State VARCHAR(20) NOT NULL,
Population INT NOT NULL,
PRIMARY KEY (CityName,State)
);



/*sale table*/



DROP TABLE IF EXISTS Sale;

CREATE TABLE Sale
(
PID CHAR(10) NOT NULL,
StoreNumber INT NOT NULL,
Date DATE NOT NULL,
Quantity INT NOT NULL,
PRIMARY KEY (StoreNumber,PID,Date)
);



/*product table*/




DROP TABLE IF EXISTS Product;

CREATE TABLE Product
(
PID CHAR(10) NOT NULL,
ProductName CHAR(50) NOT NULL,
Price DECIMAL(10,2) NOT NULL,
PRIMARY KEY (PID)
);


/*category table*/



DROP TABLE IF EXISTS Category;

CREATE TABLE Category
(
CategoryName CHAR(50) NOT NULL,
PRIMARY KEY (CategoryName)
);



/*belongto table*/



DROP TABLE IF EXISTS BelongTo;

CREATE TABLE BelongTo
(
PID CHAR(10) NOT NULL,
CategoryName CHAR(50) NOT NULL,
PRIMARY KEY (PID,CategoryName)
);



/*date table*/



DROP TABLE IF EXISTS Date;

CREATE TABLE Date
(
Date DATE NOT NULL,
PRIMARY KEY (Date)
);




/*HOLIDAY table*/


DROP TABLE IF EXISTS Holiday;

CREATE TABLE Holiday
(
Date DATE NOT NULL,
HolidayName	VARCHAR(100) NOT NULL,
PRIMARY KEY (Date,HolidayName)
);






/*HasDiscountOn table*/




DROP TABLE IF EXISTS HasDiscountOn;

CREATE TABLE HasDiscountOn
(
PID CHAR(10) NOT NULL,
Date DATE NOT NULL,
DiscountPrice DECIMAL(10,2) NOT NULL,
PRIMARY KEY (PID,Date)
);



/*AdsCampaign table*/




DROP TABLE IF EXISTS AdsCampaign;

CREATE TABLE AdsCampaign
(
Description VARCHAR(200) NOT NULL,
PRIMARY KEY (Description)
);




/*HasAdsCampaign table*/


DROP TABLE IF EXISTS HasAdsCampaign;

CREATE TABLE HasAdsCampaign
(
Date DATE NOT NULL,
Description VARCHAR(200) NOT NULL,
PRIMARY KEY (Date,Description)
);


/*Create constraints*/


ALTER TABLE Store
ADD CONSTRAINT fk_Store_CityNameState_City_CityNameState FOREIGN KEY (CityName,State) REFERENCES City (CityName,State);


ALTER TABLE Store
ADD CONSTRAINT fk_Store_CClimit_ChildcareLimit_CClimit FOREIGN KEY (CClimit) REFERENCES ChildcareLimit (CClimit);


ALTER TABLE Sale
ADD CONSTRAINT fk_Sale_StoreNumber_Store_StoreNumber FOREIGN KEY (StoreNumber) REFERENCES Store (StoreNumber);

ALTER TABLE Sale
ADD CONSTRAINT fk_Sale_PID_Product_PID FOREIGN KEY (PID) REFERENCES Product (PID);

ALTER TABLE Sale
ADD CONSTRAINT fk_Sale_Date_Date_Date FOREIGN KEY (Date) REFERENCES Date (Date);

ALTER TABLE BelongTo
ADD CONSTRAINT fk_BelongTo_PID_Product_PID FOREIGN KEY (PID) REFERENCES Product (PID);

ALTER TABLE BelongTo
ADD CONSTRAINT fk_BelongTo_CategoryName_Category_CategoryName FOREIGN KEY (CategoryName) REFERENCES Category (CategoryName);

ALTER TABLE Holiday
ADD CONSTRAINT fk_Holiday_Date_Date_Date FOREIGN KEY (Date) REFERENCES Date (Date);

--ALTER TABLE HolidayName
--ADD CONSTRAINT fk_HolidayName_Date_Holiday_Date FOREIGN KEY (Date) REFERENCES Holiday (Date);

ALTER TABLE HasDiscountOn
ADD CONSTRAINT fk_HasDiscountOn_PID_Product_PID FOREIGN KEY (PID) REFERENCES Product (PID);

ALTER TABLE HasDiscountOn
ADD CONSTRAINT fk_HasDiscountOn_Date_Date_Date FOREIGN KEY (Date) REFERENCES Date (Date);

ALTER TABLE HasAdsCampaign
ADD CONSTRAINT fk_HasAdsCampaign_Date_Date_Date FOREIGN KEY (Date) REFERENCES Date (Date);

--ALTER TABLE HasAdsCampaign
--ADD CONSTRAINT fk_HasAdsCampaign_Description_AdsCampaign_Description FOREIGN KEY (Description) REFERENCES AdsCampaign (Description);












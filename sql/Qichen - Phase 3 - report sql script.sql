


SELECT COUNT(StoreNumber) FROM Store

SELECT COUNT(StoreNumber) FROM Store WHERE HasRestaurant=1 or HasSnackBar =1

SELECT COUNT(StoreNumber) FROM Store WHERE ChildcareLimit!=0

SELECT COUNT(PID) FROM Product

SELECT COUNT(Description) FROM AdsCampaign


--VIEW HOLIDAY

SELECT Date, HolidayName FROM HolidayName WHERE YEAR(Date)=$Year


--ADD HOLIDAY

INSERT INTO HolidayName

VALUES()

--update population

Select CityName,Population FROM City WHERE CityName=$city



--For each category, including those without products, display:
--Category name
--Total number of products in that category
--Minimum regular retail price
--Average regular retail price
--Maximum regular retail price of all the products in that category
--Sort the result by category name in ascending order



SELECT c.CategoryName,
	   COUNT(p.PID)  'Count of products',
	   MIN(P.Price)  'Min price',
	   AVG(P.Price)  'Average price',
	   MAX(P.Price)  'Max price'
FROM Category c 
	LEFT JOIN BelongTo b on c.CategoryName=b.CategoryName
	LEFT JOIN Product p on b.PID=p.PID
GROUP BY c.CategoryName
ORDER BY c.CategoryName ASC



--For each product in the Couches and Sofas category, return:
	--Product ID
	--Name of the product
	--Product’s retail price
	--Total number of units ever sold
	--Total number of units sold at a discount (i.e., during discount days)
	--Total number of units sold at retail price
	--Actual revenue collected from all the sales of the product
	--Predicted revenue had the product never been discounted (based on 75% volume selling at retail price)
	--Difference between the actual revenue and the predicted revenue.
--Filter the result to only display products with revenue differences greater than $5000 (positive or negative)
--Sort the result by revenue difference in descending order

;WITH CTE1 AS
(
	SELECT S.PID,
		   P.ProductName,
		   P.Price,
		   H.DiscountPrice,
	       SUM(CASE WHEN H.PID IS NULL THEN S.Quantity ELSE 0 END) 'Units_RetailPrice',
		   SUM(CASE WHEN H.PID IS NOT NULL THEN S.Quantity ELSE 0 END) 'Units_DiscountPrice'
	FROM Sale S 
			LEFT JOIN HasDiscountOn H ON S.PID=H.PID AND S.Date=H.Date
			JOIN Product P ON P.PID=S.PID
	GROUP BY S.PID,P.Price,H.DiscountPrice,P.ProductName

),
CTE2 AS
(
SELECT PID,
       ProductName,
	   Price 'RetailPrice', 
	   SUM(Units_DiscountPrice+Units_RetailPrice) 'TotalUnitsSold',
	   SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE DiscountPrice*Units_DiscountPrice END) 'ActualRevenue',
	   SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE Price*Units_DiscountPrice*0.75 END) 'PredictedRevenue',
	   SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE DiscountPrice*Units_DiscountPrice END) -
	   SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE Price*Units_DiscountPrice*0.75 END) 'Difference'
FROM CTE1
GROUP BY PID, ProductName,Price
)
SELECT C.*
FROM CTE2 C JOIN BelongTo B ON C.PID=B.PID
WHERE ABS(Difference)>5000 AND B.CategoryName = 'Couches and Sofas'
ORDER BY Difference DESC

--mysql

;WITH CTE1 AS (
SELECT S.PID,
		P.ProductName,
		P.Price,
		H.DiscountPrice,
		CASE WHEN H.PID IS NULL THEN S.Quantity ELSE 0 END 'Units_RetailPrice', 
		CASE WHEN H.PID IS NOT NULL THEN S.Quantity ELSE 0 END 'Units_DiscountPrice' 
FROM Sale S LEFT JOIN HasDiscountOn H ON S.PID=H.PID AND S.Date=H.Date JOIN Product P ON P.PID=S.PID),

CTE2 AS(
SELECT PID,ProductName 'Product Name',Price 'Retail Price', 
SUM(Units_DiscountPrice+Units_RetailPrice) 'Total Units Sold',
SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE DiscountPrice*Units_DiscountPrice END) 'Actual Revenue',
SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE Price*Units_DiscountPrice*0.75 END) 'Predicted Revenue',
SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE DiscountPrice*Units_DiscountPrice END) -
SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE Price*Units_DiscountPrice*0.75 END) 'Difference'
FROM CTE1 
GROUP BY PID, ProductName,Price) 
SELECT C.* FROM CTE2 C JOIN BelongTo B ON C.PID=B.PID 
WHERE ABS(Difference)>5000 AND B.CategoryName  = 'Couches and Sofas' ORDER BY Difference DESC


--mysql 2

;WITH CTE1 AS (
SELECT S.PID,
		P.ProductName,
		P.Price,
		H.DiscountPrice,
		CASE WHEN H.PID IS NULL THEN S.Quantity ELSE 0 END 'Units_RetailPrice', 
		CASE WHEN H.PID IS NOT NULL THEN S.Quantity ELSE 0 END 'Units_DiscountPrice' 
FROM Sale S LEFT JOIN HasDiscountOn H ON S.PID=H.PID AND S.Date=H.Date JOIN Product P ON P.PID=S.PID),

CTE2 AS(
SELECT PID,ProductName 'Product Name',Price 'Retail Price', 
SUM(Units_DiscountPrice+Units_RetailPrice) 'Total Units Sold',
SUM(Units_RetailPrice) 'Units_RetailPrice',
SUM(Units_DiscountPrice) 'Units_DiscountPrice',
SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE DiscountPrice*Units_DiscountPrice END) 'Actual Revenue',
SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE Price*Units_DiscountPrice*0.75 END) 'Predicted Revenue',
SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE DiscountPrice*Units_DiscountPrice END) -
SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE Price*Units_DiscountPrice*0.75 END) 'Difference'
FROM CTE1 
GROUP BY PID, ProductName,Price) 
SELECT C.* FROM CTE2 C JOIN BelongTo B ON C.PID=B.PID 
WHERE ABS(Difference)>5000 AND B.CategoryName  = 'Couches and Sofas' ORDER BY Difference DESC








--Users select a state from drop-down menu
--For each store in the selected state, display:
	--Store ID
	--Store address
	--City name
	--Sales year
	--Total revenue
--Sort the result by year in ascending order first and then by revenue in descending order

;WITH CTE
AS
(
	SELECT S.StoreNumber,
		   YEAR(S.Date) 'Year',
		   SUM(CASE 
		            WHEN H.PID IS NULL THEN P.Price*S.Quantity 
					ELSE H.DiscountPrice*S.Quantity 
					END) 'TotalRevenue'
	FROM Product P 
		JOIN Sale S ON P.PID=S.PID
		LEFT JOIN HasDiscountOn H ON S.PID=H.PID AND S.Date=H.Date
	GROUP BY S.StoreNumber,YEAR(S.Date)
)
SELECT C.StoreNumber,S.StreetAddress,S.CityName,C.Year,C.TotalRevenue
FROM CTE C JOIN Store S ON C.StoreNumber=S.StoreNumber
           JOIN City CT ON S.CityName=CT.Cityname
WHERE CT.State='WA'
ORDER BY Year ASC,TotalRevenue DESC





--If users click on View Furniture on Groundhog Day Report button from Main Menu:
--Implement View Furniture on Groundhog Day Report task:
--For each year, display:
	--Year
	--Total number of items sold that year in the outdoor furniture category
	--Average number of units sold per day
	--Total number of units sold on February 2nd of that year
--Sort the report by year in ascending order

;WITH CTE1 AS
(
	SELECT YEAR(S.Date) 'Year',
		   SUM(S.Quantity) 'TotalItemSold',
		   SUM(CAST(S.Quantity AS decimal(4,1)))/365 'AvgItemsSoldPerDay'
	FROM Sale S JOIN BelongTo B ON S.PID=B.PID
	WHERE B.CategoryName ='Outdoor'
	GROUP BY YEAR(S.Date)
),
CTE2 AS
(
SELECT YEAR(S.Date) 'Year',
	   SUM(S.Quantity) 'TotalItemSoldOnFeb02'
FROM Sale S JOIN BelongTo B ON S.PID=B.PID
WHERE B.CategoryName ='Outdoor' AND 
MONTH(S.Date)=2 AND DAY(S.Date)=2
GROUP BY YEAR(S.Date)
)
SELECT CTE1.Year,
       CTE1.TotalItemSold,
	   CTE1.AvgItemsSoldPerDay,
	   CTE2.TotalItemSoldOnFeb02
FROM CTE1 JOIN CTE2 ON CTE1.Year=CTE2.Year
ORDER BY CTE1.Year ASC



WITH CTE1 AS (SELECT YEAR(S.Date) 'Year', SUM(S.Quantity) 'TotalItemSold', 
SUM(CAST(S.Quantity AS decimal(4,1)))/365 'AvgItemsSoldPerDay'
FROM Sale S JOIN BelongTo B ON S.PID=B.PID WHERE  B.CategoryName ='Outdoor'
GROUP BY YEAR(S.Date)),
CTE2 AS( SELECT YEAR(S.Date) 'Year',SUM(S.Quantity) 'TotalItemSoldOnFeb02'
FROM Sale S JOIN BelongTo B ON S.PID=B.PID WHERE B.CategoryName ='Outdoor' AND 
MONTH(S.Date)=2 AND DAY(S.Date)=2 GROUP BY YEAR(S.Date))
SELECT CTE1.Year,CTE1.TotalItemSold,CTE1.AvgItemsSoldPerDay, CTE2.TotalItemSoldOnFeb02
FROM CTE1 JOIN CTE2 ON CTE1.Year=CTE2.Year ORDER BY CTE1.Year ASC


--Implement View State with Highest Volume for each Category Report task:
--Users choose a YEAR and MONTH from the dropdown menu
--For each category, display the following for the selected year and month:
	--Category name
	--State that sold the highest number of units in that category (include items sold by all stores in the state)
	--Number of units that were sold by stores in that state
--Sort the report by category name in ascending order



;WITH CTE AS(
	SELECT B.CategoryName,C.State,SUM(S.Quantity) 'Quantity',
		   RANK() OVER(PARTITION BY B.CategoryName ORDER BY SUM(S.Quantity)  DESC) R
	FROM BelongTo B 
		 JOIN Sale S ON B.PID=S.PID
		 JOIN Store SS ON SS.StoreNumber=S.StoreNumber
		 JOIN City C ON C.CityName=SS.CityName
	WHERE YEAR(S.Date)=$Year and MONTH(S.Date)=$Month
	GROUP BY B.CategoryName,C.State)
SELECT CategoryName,State,Quantity 
FROM CTE WHERE R=1
ORDER BY CategoryName ASC



--If users click on View Revenue by Population button from Main Menu:
--Implement View Revenue by Population Report task:
	--In a tabular format, for each combination of year (column) and city size category (row):
	--Find and display annual total revenue for that combination of year and city size category
--Sort the columns by year in ascending order
--Sort the rows by city size category in ascending order



WITH CTE
AS
(
SELECT YEAR(S.Date) 'Year',
       CASE WHEN C.Population<3700000 THEN 'Small' 
	        WHEN C.Population>=3700000 and C.Population<6700000 THEN 'Medium'
			WHEN C.Population>=6700000 and C.Population<9000000 THEN 'Large'
			WHEN C.Population>=9000000 THEN 'ExtraLarge'
			END 'PopulationSize',
	   CASE  
	        WHEN H.PID IS NULL THEN S.Quantity*P.Price 
			ELSE S.Quantity*H.DiscountPrice 
			END 'Revenue' 
FROM Sale S 
     JOIN Store SS ON S.StoreNumber=SS.StoreNumber
	 JOIN City C ON SS.CityName=C.CityName
	 JOIN Product P ON S.PID=P.PID
	 LEFT JOIN HasDiscountOn H ON S.PID=H.PID AND S.Date=H.Date
)
SELECT Year,
       SUM(CASE PopulationSize WHEN 'Small' THEN Revenue ELSE 0 END) 'Small',
	   SUM(CASE PopulationSize WHEN 'Medium' THEN Revenue ELSE 0 END) 'Medium',
	   SUM(CASE PopulationSize WHEN 'Large' THEN Revenue ELSE 0 END) 'Large',
	   SUM(CASE PopulationSize WHEN 'ExtraLarge' THEN Revenue ELSE 0 END) 'ExtraLarge'
FROM CTE
GROUP BY Year


--mysql

;WITH CTE AS  (
SELECT MONTH(S.Date) 'Month', 
ST.CClimit,
CASE WHEN H.PID IS NULL THEN S.Quantity*P.Price ELSE S.Quantity*H.DiscountPrice END 'Revenue' 
FROM Sale S 
LEFT JOIN Store ST ON ST.StoreNumber=S.StoreNumber 
JOIN Product P ON P.PID=S.PID 
LEFT JOIN HasDiscountOn H ON S.PID=H.PID AND S.Date=H.Date 
WHERE (select max(date) from sale) - S.Date < 365) 
SELECT Month, 
SUM(CASE CClimit WHEN 0 THEN Revenue ELSE 0 END) '0', 
SUM(CASE CClimit WHEN 30 THEN Revenue ELSE 0 END) '30', 
SUM(CASE CClimit WHEN 45 THEN Revenue ELSE 0 END) '45', 
SUM(CASE CClimit WHEN 60 THEN Revenue ELSE 0 END) '60' 
FROM CTE  GROUP BY Month ORDER BY 1 ASC







--If users click View Childcare Sales Volume Report button from Main Menu:
--Implement View Childcare Sales Volume Report task:
--In a tabular format, for each combination of month (row, past 12 months only) and childcare limit category (column): 
--Find and display the total revenue for that combination
--Sort the result by both row and column 


;WITH CTE
AS
(
	SELECT MONTH(S.Date) 'Month',ST.CCLimit,
			CASE WHEN H.PID IS NULL THEN S.Quantity*P.Price ELSE S.Quantity*H.DiscountPrice END 'Revenue'
	FROM Sale S 
	     JOIN Store ST ON ST.StoreNumber=S.StoreNumber
		 JOIN Product P ON P.PID=S.PID
		 LEFT JOIN HasDiscountOn H ON S.PID=H.PID AND S.Date=H.Date	
	WHERE DATEDIFF(DAY,S.Date,GETDATE())<=365
)
SELECT Month,
       FLOOR(SUM(CASE CCLimit WHEN 0 THEN Revenue ELSE 0 END)) 'NoChildcare',
	   FLOOR(SUM(CASE CCLimit WHEN 30 THEN Revenue ELSE 0 END)) '30',
	   FLOOR(SUM(CASE CCLimit WHEN 60 THEN Revenue ELSE 0 END)) '60',
	   FLOOR(SUM(CASE CCLimit WHEN 90 THEN Revenue ELSE 0 END)) '90',
	   FLOOR(SUM(CASE CCLimit WHEN 120 THEN Revenue ELSE 0 END)) '120'
FROM CTE
GROUP BY Month



--MYSQL

WITH CTE
AS
(
	SELECT MONTH(S.Date) 'Month',ST.CCLimit,
			CASE WHEN H.PID IS NULL THEN S.Quantity*P.Price ELSE S.Quantity*H.DiscountPrice END 'Revenue'
	FROM Sale S 
	     JOIN Store ST ON ST.StoreNumber=S.StoreNumber
		 JOIN Product P ON P.PID=S.PID
		 LEFT JOIN HasDiscountOn H ON S.PID=H.PID AND S.Date=H.Date	
	WHERE  DATEDIFF(NOW(),S.Date)<=365
)
SELECT Month,
       FLOOR(SUM(CASE CCLimit WHEN 0 THEN Revenue ELSE 0 END)) 'NoChildcare',
	   FLOOR(SUM(CASE CCLimit WHEN 30 THEN Revenue ELSE 0 END)) '30',
	   FLOOR(SUM(CASE CCLimit WHEN 60 THEN Revenue ELSE 0 END)) '60',
	   FLOOR(SUM(CASE CCLimit WHEN 90 THEN Revenue ELSE 0 END)) '90',
	   FLOOR(SUM(CASE CCLimit WHEN 120 THEN Revenue ELSE 0 END)) '120'
FROM CTE
GROUP BY Month




--If users click on View Restaurant Import On Category Sales Report button from Main Menu:
--Implement View Restaurant Import On Category Sales Report task:
--For each category, display: 
--Category name
--Store Type (Non-restaurant, Restaurant)
--Quantity sold
--Sort the report by category name in ascending order first, then by Store Type (Non-restaurant first, then Restaurant)

;WITH CTE AS
(
	SELECT B.CategoryName,
		   CASE WHEN ST.HasRestaurant= 1 THEN 'Restaurant'
				WHEN ST.HasRestaurant= 0 THEN 'Non-restaurant' END  'StoreType',
		   S.Quantity
	FROM BelongTo B
		 JOIN Sale S ON B.PID=S.PID
		 JOIN Store ST ON S.StoreNumber=ST.StoreNumber
)

SELECT CategoryName 'Category',StoreType,SUM(Quantity) 'Quantity Sold'
FROM CTE
GROUP BY CategoryName,StoreType
ORDER BY CategoryName ASC,StoreType ASC






--If users click on View Ads Campaign Report button from Main Menu:
--Implement View Ads Campaign Report task:
--For each product, find and display:
	--Product ID
	--Product name
	--Total sold when no advertising campaign was active
	--Total sold when any advertising campaign was active
	--Difference between the two totals
--Sort the results by difference in descending (highest to lowest) order
--Filter the result to only display top 10 products and bottom 10 products

;WITH CTE1 AS
(
	SELECT P.PID,
	       P.ProductName,
		   SUM(CASE WHEN H.Date IS NOT NULL THEN Quantity ELSE 0 END) 'SoldDuringCampaign',
		   SUM(CASE WHEN H.Date IS NULL THEN Quantity ELSE 0 END) 'SoldOutsideCampaign'
	FROM Product P 
		 JOIN Sale S ON P.PID=S.PID 
		 LEFT JOIN HasAdsCampaign H ON S.Date=H.Date
	GROUP BY P.PID,P.ProductName
),
CTE2 as
(
SELECT PID,
       ProductName,
	   SoldDuringCampaign,
	   SoldOutsideCampaign,
	   SoldDuringCampaign-CTE1.SoldOutsideCampaign 'Difference'
FROM CTE1
),
CTE3 AS
(
SELECT TOP 10 * FROM CTE2 ORDER BY Difference DESC
UNION
SELECT TOP 10 * FROM CTE2 ORDER BY Difference ASC
)
SELECT * FROM CTE3 ORDER BY Difference DESC


--MYSQL

WITH CTE1 AS
(
	SELECT P.PID,
	       P.ProductName,
		   SUM(CASE WHEN H.Date IS NOT NULL THEN Quantity ELSE 0 END) 'SoldDuringCampaign',
		   SUM(CASE WHEN H.Date IS NULL THEN Quantity ELSE 0 END) 'SoldOutsideCampaign'
	FROM Product P 
		 JOIN Sale S ON P.PID=S.PID 
		 LEFT JOIN HasAdsCampaign H ON S.Date=H.Date
		 LEFT JOIN HasDiscountOn HH ON HH.PID=S.PID AND HH.Date=S.Date
	WHERE HH.PID IS NOT NULL
	GROUP BY P.PID,P.ProductName
),
CTE2 as
(
SELECT PID,
       ProductName,
	   SoldDuringCampaign,
	   SoldOutsideCampaign,
	   SoldDuringCampaign-CTE1.SoldOutsideCampaign 'Difference'
FROM CTE1
),
CTE3 AS
(
	(SELECT * FROM CTE2 ORDER BY Difference DESC LIMIT 10)
	UNION
	(SELECT * FROM CTE2 ORDER BY Difference ASC LIMIT 10)
)
SELECT * FROM CTE3 ORDER BY Difference DESC



select COUNT(*)
from sale s 
left join hasadscampaign h on s.Date=H.date
left join hasdiscounton hh on hh.PID=s.PID and hh.date=s.Date
where Hh.pid IS NOT NULL AND S.PID=4011
<?php include('lib/common.php');?>
<?php include("lib/header.php");?>


<body>
		<div id="main_container">
    <?php include("lib/menu.php"); ?>
    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
				<?php print 'Report 2 – Actual versus Predicted Revenue for Couches and Sofas'; ?>
            </div>          
            <div class="features">   
                <div class="profile_section">
                    <div class="subtitle">  </div>  
                    <table>
                        <tr>
                            <td class="heading">PID</td>
                            <td class="heading">Product Name</td>
							<td class="heading">Retail Price</td>
							<td class="heading">Total Units Sold</td>
                            <td class="heading">Units Sold at RetailPrice</td>
                            <td class="heading">Units Sold at DiscountPrice</td>
							<td class="heading">Actual Revenue</td>
                            <td class="heading">Predicted Revenue</td>
                            <td class="heading">Difference</td>                            
                        </tr>							
                        <?php
									    $query = "WITH CTE1 AS ( " .
                                            "SELECT S.PID, " .
                                                    "P.ProductName, " .
                                                    "P.Price, " .
                                                    "H.DiscountPrice, " .
                                                    "CASE WHEN H.PID IS NULL THEN S.Quantity ELSE 0 END 'Units_RetailPrice',  " .
                                                    "CASE WHEN H.PID IS NOT NULL THEN S.Quantity ELSE 0 END 'Units_DiscountPrice'  " .
                                                    "FROM Sale S LEFT JOIN HasDiscountOn H ON S.PID=H.PID AND S.Date=H.Date JOIN Product P ON P.PID=S.PID), " .
                                            
                                            "CTE2 AS( " .
                                            "SELECT PID,ProductName 'Product Name',Price 'Retail Price',  " .
                                                    "SUM(Units_DiscountPrice+Units_RetailPrice) 'Total Units Sold', " .
                                                    "SUM(Units_RetailPrice) 'Units Sold at RetailPrice', " .
                                                    "SUM(Units_DiscountPrice) 'Units Sold at DiscountPrice', " .
                                                    "SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE DiscountPrice*Units_DiscountPrice END) 'Actual Revenue', " .
                                                    "SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE Price*Units_DiscountPrice*0.75 END) 'Predicted Revenue', " .
                                                    "SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE DiscountPrice*Units_DiscountPrice END) - " .
                                                    "SUM(CASE WHEN DiscountPrice IS NULL THEN Price*Units_RetailPrice ELSE Price*Units_DiscountPrice*0.75 END) 'Difference' " .
                                            "FROM CTE1  " .
                                            "GROUP BY PID, ProductName,Price)  " .
                                            "SELECT C.* FROM CTE2 C JOIN BelongTo B ON C.PID=B.PID  " .
                                            "WHERE ABS(Difference)>5000 AND B.CategoryName  = 'Couches and Sofas' ORDER BY Difference DESC";

									    $result = mysqli_query($db, $query);
                                        include('lib/show_queries.php');
                                        
                                        if (is_bool($result) && (mysqli_num_rows($result) == 0) ) {
                                                    array_push($error_msg,  "Query ERROR: Failed to get School information...<br>" . __FILE__ ." line:". __LINE__ );
                                             } 
                                             
									while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
										print "<tr>";
										print "<td>" . $row['PID'] . "</td>";
										print "<td>" . $row['Product Name'] . "</td>";
										print "<td>" . $row['Retail Price'] . "</td>";
										print "<td>" . $row['Total Units Sold'] . "</td>";
                                        print "<td>" . $row['Units Sold at RetailPrice'] . "</td>";
                                        print "<td>" . $row['Units Sold at DiscountPrice'] . "</td>";
										print "<td>" . $row['Actual Revenue'] . "</td>";
                                        print "<td>" . $row['Predicted Revenue'] . "</td>";
                                        print "<td>" . $row['Difference'] . "</td>";
										print "</tr>";
									}
								?>
                    </table>						
                </div>	
            </div> 			
        </div> 
                <?php include("lib/error.php"); ?>                    
				<div class="clear"></div> 		
			</div>    			 
		</div>
	</body>
</html>
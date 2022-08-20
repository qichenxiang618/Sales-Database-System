<?php include('lib/common.php');?>
<?php include("lib/header.php");?>




<body>
		<div id="main_container">
    <?php include("lib/menu.php"); ?>

    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
				<?php print 'Report 8 – Restaurant Impact on Category Sales'; ?>
            </div>          
            <div class="features">   
                <div class="profile_section">
                    <div class="subtitle">  </div>  
                    <table>
                        <tr>
                            <td class="heading">Category</td>
                            <td class="heading">Store Type</td>
							<td class="heading">Quantity Sold</td>              
                        </tr>							
                        <?php
									    $query = "WITH CTE AS " .
                                        "(SELECT B.CategoryName, " .
                                                   "CASE WHEN ST.HasRestaurant= 1 THEN 'Restaurant' " .
                                                        "WHEN ST.HasRestaurant= 0 THEN 'Non-restaurant' END  'StoreType', " .
                                                   "S.Quantity " .
                                            "FROM BelongTo B " .
                                                 "JOIN Sale S ON B.PID=S.PID " .
                                                 "JOIN Store ST ON S.StoreNumber=ST.StoreNumber)     " .                           
                                        "SELECT CategoryName 'Category',StoreType,SUM(Quantity) 'QuantitySold' " .
                                        "FROM CTE " .
                                        "GROUP BY CategoryName,StoreType " .
                                        "ORDER BY CategoryName ASC,StoreType ASC ";
                                        

									    $result = mysqli_query($db, $query);
                                        include('lib/show_queries.php');
                                                                                    
									while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
										print "<tr>";
										print "<td>" . $row['Category'] . "</td>";
                                        print "<td>" . $row['StoreType'] . "</td>";
										print "<td>" . $row['QuantitySold'] . "</td>";
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
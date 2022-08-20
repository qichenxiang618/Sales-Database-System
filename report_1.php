<?php include('lib/common.php');?>
<?php include("lib/header.php");?>


<body>
		<div id="main_container">
    <?php include("lib/menu.php"); ?>

    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
				<?php print 'Report 1 – Category Report'; ?>
            </div>          
            <div class="features">   
                <div class="profile_section">
                    <div class="subtitle">  </div>  
                    <table>
                        <tr>
                            <td class="heading">Category Name</td>
                            <td class="heading">Count of Product</td>
							<td class="heading">Min Price</td>
							<td class="heading">Average Price</td>
							<td class="heading">Max Price</td>
                        </tr>							
                        <?php
							$query = "SELECT c.CategoryName, 
                                             COUNT(p.PID) 'Count of Product', 
                                             MIN(P.Price) 'Min Price',
                                             AVG(P.Price) 'Average Price',
                                             MAX(P.Price) 'Max Price' " .
                                        "FROM Category c 
                                              LEFT JOIN BelongTo b on c.CategoryName=b.CategoryName 
                                              LEFT JOIN Product p on b.PID=p.PID " .
                                        "GROUP BY c.CategoryName 
                                        ORDER BY c.CategoryName ASC";

							$result = mysqli_query($db, $query);
                            include('lib/show_queries.php');                                  
                                             
									while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
										print "<tr>";
										print "<td>" . $row['CategoryName'] . "</td>";
										print "<td>" . $row['Count of Product'] . "</td>";
										print "<td>" . $row['Min Price'] . "</td>";
										print "<td>" . $row['Average Price'] . "</td>";
										print "<td>" . $row['Max Price'] . "</td>";
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
<?php include('lib/common.php');?>
<?php include("lib/header.php");?>




<body>
		<div id="main_container">
    <?php include("lib/menu.php"); ?>

    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
				<?php print 'Report 9 – Advertising Campaign Analysis'; ?>
            </div>          
            <div class="features">   
                <div class="profile_section">
                    <div class="subtitle">  </div>  
                    <table>
                        <tr>
                            <td class="heading">PID</td>
                            <td class="heading">ProductN ame</td>
							<td class="heading">Sold During Campaign</td>     
                            <td class="heading">Sold Outside Campaign</td>  
                            <td class="heading">Difference</td>           
                        </tr>							
                        <?php
									    $query = "WITH CTE1 AS " .
                                        "(SELECT P.PID, " .
                                                   "P.ProductName, " .
                                                   "SUM(CASE WHEN H.Date IS NOT NULL THEN Quantity ELSE 0 END) 'SoldDuringCampaign', " .
                                                   "SUM(CASE WHEN H.Date IS NULL THEN Quantity ELSE 0 END) 'SoldOutsideCampaign' " .
                                            "FROM Product P  " .
                                                 "JOIN Sale S ON P.PID=S.PID  " .
                                                 "LEFT JOIN HasAdsCampaign H ON S.Date=H.Date " .
                                                 "LEFT JOIN HasDiscountOn HH ON HH.PID=S.PID AND HH.Date=S.Date WHERE HH.PID IS NOT NULL " .
                                            "GROUP BY P.PID,P.ProductName), " .
                                       " CTE2 as " .
                                       "(SELECT PID, " .
                                               "ProductName, " .
                                               "SoldDuringCampaign, " .
                                               "SoldOutsideCampaign, " .
                                               "SoldDuringCampaign-CTE1.SoldOutsideCampaign 'Difference' " .
                                               "FROM CTE1), " .
                                        "CTE3 AS " .
                                        "((SELECT * FROM CTE2 ORDER BY Difference DESC LIMIT 10) " .
                                            "UNION " .
                                            "(SELECT * FROM CTE2 ORDER BY Difference ASC LIMIT 10)) " .
                                        "SELECT * FROM CTE3 ORDER BY Difference DESC ";
                                        

									    $result = mysqli_query($db, $query);
                                        include('lib/show_queries.php');
                                                                                    
									while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
										print "<tr>";
										print "<td>" . $row['PID'] . "</td>";
                                        print "<td>" . $row['ProductName'] . "</td>";
										print "<td>" . $row['SoldDuringCampaign'] . "</td>";
                                        print "<td>" . $row['SoldOutsideCampaign'] . "</td>";
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
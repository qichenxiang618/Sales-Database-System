<?php
	include('lib/common.php');  
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {$State = mysqli_real_escape_string($db, $_POST['State']);} 
?>


<?php include("lib/header.php"); ?>
	<body>
    	<div id="main_container">
        <?php include("lib/menu.php"); ?>    
			<div class="center_content">	
				<div class="center_left">  
					<div class="title_name">
						<?php print 'Report 3 – Store Revenue by Year by State'; ?>
            		</div>      
					<div class="features">   						
                        <div class="profile_section">
							<div class="subtitle"> </div>                              
							<form name="profileform" action="report_3.php" method="post">
								<table>
									<tr>
										<td class="item_label">State</td>
										<td>
											<select name="State">
												<?php 
													$sql = mysqli_query($db, "SELECT State FROM City");
													while ($row = $sql->fetch_assoc()){
													echo "<option value=" . $row['State'] . ">" . $row['State'] . "</option>";
													}
												?>
											</select>
										</td>
									</tr>
								</table>
								
								<a href="javascript:profileform.submit();" class="fancy_button">Run</a> 
							
							</form>
						</div>  



						<div class="profile_section">
                    		<div class="subtitle"> </div>  
                    			<table>
                        			<tr>
                            			<td class="heading">Store Number</td>
                            			<td class="heading">Street Address</td>
										<td class="heading">City Name</td>
										<td class="heading">Year</td>
										<td class="heading">Total Revenue</td>
                        			</tr>							

                        				<?php

										$query = "WITH CTE " .
												"AS " .
												"( " .
													"SELECT S.StoreNumber, " .
														"YEAR(S.Date) 'Year', " .
														"SUM(CASE  " .
																	"WHEN H.PID IS NULL THEN P.Price*S.Quantity  " .
																	"ELSE H.DiscountPrice*S.Quantity  " .
																	"END) 'TotalRevenue' " .
													"FROM Product P  " .
														"JOIN Sale S ON P.PID=S.PID " .
														"LEFT JOIN HasDiscountOn H ON S.PID=H.PID AND S.Date=H.Date " .
														"GROUP BY S.StoreNumber,YEAR(S.Date) " .
												") " .
												"SELECT C.StoreNumber,S.StreetAddress,S.CityName,C.Year,FLOOR(C.TotalRevenue) 'TotalRevenue' " .
												"FROM CTE C JOIN Store S ON C.StoreNumber=S.StoreNumber " .
														"JOIN City CT ON S.CityName=CT.Cityname";
										if (!isset($State)) {$query = $query . " WHERE 1=2 ORDER BY Year ASC,TotalRevenue DESC";};
										if (isset($State) && $State!=="All") {$query = $query . " WHERE CT.State= '" . $State . "' ORDER BY Year ASC,TotalRevenue DESC";};
										if (isset($State) && $State=="All") {$query = $query . " ORDER BY Year ASC,TotalRevenue DESC";};

									    $result = mysqli_query($db, $query);
                                        include('lib/show_queries.php');
                                        
                                             
									while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
										print "<tr>";
										print "<td>" . $row['StoreNumber'] . "</td>";
										print "<td>" . $row['StreetAddress'] . "</td>";
										print "<td>" . $row['CityName'] . "</td>";
										print "<td>" . $row['Year'] . "</td>";
										print "<td>" . $row['TotalRevenue'] . "</td>";
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


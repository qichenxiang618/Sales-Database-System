<?php
	include('lib/common.php');  
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {$Year = mysqli_real_escape_string($db, $_POST['Year']);} 
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {$Month = mysqli_real_escape_string($db, $_POST['Month']);} 
?>


<?php include("lib/header.php"); ?>
	<body>
    	<div id="main_container">
        <?php include("lib/menu.php"); ?>    
			<div class="center_content">	
				<div class="center_left">  
					<div class="title_name">
						<?php print 'Report 5 – State with Highest Volume for each Category'; ?>
            		</div>      
					<div class="features">   						
                        <div class="profile_section">
							<div class="subtitle"> </div>                              
							<form name="profileform" action="report_5.php" method="post">
								<table>
									<tr>
										<td class="item_label">Year</td>
										<td>
											<select name="Year">
												<?php 
													$sql = mysqli_query($db, "SELECT DISTINCT(Year(Date)) Year FROM Sale ORDER BY 1 ASC");
													while ($row = $sql->fetch_assoc()){
													echo "<option value=" . $row['Year'] . ">" . $row['Year'] . "</option>";
													}
												?>
											</select>
										</td>
									</tr>

									<tr>
										<td class="item_label">Month</td>
										<td>
											<select name="Month">
												<?php 
													$sql = mysqli_query($db, "SELECT DISTINCT(Month(Date)) Month FROM Sale ORDER BY 1 ASC");
													while ($row = $sql->fetch_assoc()){
													echo "<option value=" . $row['Month'] . ">" . $row['Month'] . "</option>";
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
                            			<td class="heading">Category Name</td>
                            			<td class="heading">State</td>
										<td class="heading">Quantity</td>
                        			</tr>							

                        				<?php

										$query_1 = "WITH CTE AS( " .
												"SELECT B.CategoryName,C.State,SUM(S.Quantity) 'Quantity', " .
												"RANK() OVER(PARTITION BY B.CategoryName ORDER BY SUM(S.Quantity)  DESC) R " .
												"FROM BelongTo B  " .
												"JOIN Sale S ON B.PID=S.PID " .
												"JOIN Store SS ON SS.StoreNumber=S.StoreNumber " .
												"JOIN City C ON C.CityName=SS.CityName ";

										$query_2 = "GROUP BY B.CategoryName,C.State) " .
												"SELECT CategoryName,State,Quantity " . 
												"FROM CTE WHERE R=1 " .
												"ORDER BY CategoryName ASC ";

												

										if (!isset($Year) && !isset($Month)) {
											$query = $query_1 . $query_2 . "LIMIT 0";
											array_push($error_msg,  "Selected year: all" );
											array_push($error_msg,  "Selected month: all" );
										};

										if ($Year == "All" && $Month == 'All') {
											$query = $query_1 . $query_2;
											array_push($error_msg,  "Selected year: all" );
											array_push($error_msg,  "Selected month: all" );
										};

										if (isset($Year) && $Year !== "All" && isset($Month) && $Month !== 'All') {
											$query = $query_1 . " WHERE YEAR(S.Date)=$Year AND MONTH(S.Date)=$Month " . $query_2;
											array_push($error_msg,  "Selected year: $Year" );
											array_push($error_msg,  "Selected month: $Month" );
										};
										if (isset($Year) && $Year !== "All" && isset($Month) && $Month == 'All') {
											$query = $query_1 . " WHERE YEAR(S.Date)=$Year " . $query_2;
											array_push($error_msg,  "Selected year: $Year" );
											array_push($error_msg,  "Selected month: all" );
										};
										if (isset($Year) && $Year == "All" && isset($Month) && $Month !== 'All') {
											$query = $query_1 . " WHERE MONTH(S.Date)=$Month " . $query_2;
											array_push($error_msg,  "Selected year: all" );
											array_push($error_msg,  "Selected month: $Month" );
										};

									    $result = mysqli_query($db, $query);
                                        include('lib/show_queries.php');
                                                                                    
									while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
										print "<tr>";
										print "<td>" . $row['CategoryName'] . "</td>";
										print "<td>" . $row['State'] . "</td>";
										print "<td>" . $row['Quantity'] . "</td>";
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


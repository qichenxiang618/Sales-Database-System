<?php
	include('lib/common.php');  
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {$Year = mysqli_real_escape_string($db, $_POST['Year']);} 
?>


<?php include("lib/header.php"); ?>
	<body>
    	<div id="main_container">
        <?php include("lib/menu.php"); ?>    
			<div class="center_content">	
				<div class="center_left">  
					<div class="title_name">
                		<?php print 'View Holiday'; ?>
            		</div>         		 
					<div class="features">   						
                        <div class="profile_section">
							<div class="subtitle"> </div>                              
							<form name="profileform" action="view_holiday.php" method="post">
								<table>
									<tr>
										<td class="item_label">Year</td>
										<td>
											<select name="Year">
												<option value="All" <?php if ($row['Year'] == "All") { print 'selected="true"';} ?>>All</option>
												<option value=2009 <?php if ($row['Year'] == 2009) { print 'selected="true"';} ?>>2009</option>
												<option value=2000 <?php if ($row['Year'] == 2000) { print 'selected="true"';} ?>>2000</option>
												<option value=2001 <?php if ($row['Year'] == 2001) { print 'selected="true"';} ?>>2001</option>
												<option value=2002 <?php if ($row['Year'] == 2002) { print 'selected="true"';} ?>>2002</option>
												<option value=2003 <?php if ($row['Year'] == 2003) { print 'selected="true"';} ?>>2003</option>
												<option value=2004 <?php if ($row['Year'] == 2004) { print 'selected="true"';} ?>>2004</option>
												<option value=2005 <?php if ($row['Year'] == 2005) { print 'selected="true"';} ?>>2005</option>
												<option value=2006 <?php if ($row['Year'] == 2006) { print 'selected="true"';} ?>>2006</option>
												<option value=2007 <?php if ($row['Year'] == 2007) { print 'selected="true"';} ?>>2007</option>
												<option value=2008 <?php if ($row['Year'] == 2008) { print 'selected="true"';} ?>>2008</option>
												<option value=2009 <?php if ($row['Year'] == 2009) { print 'selected="true"';} ?>>2009</option>
												<option value=2010 <?php if ($row['Year'] == 2010) { print 'selected="true"';} ?>>2010</option>
												<option value=2011 <?php if ($row['Year'] == 2011) { print 'selected="true"';} ?>>2011</option>
												<option value=2012 <?php if ($row['Year'] == 2012) { print 'selected="true"';} ?>>2012</option>
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
                            			<td class="heading">Date</td>
                            			<td class="heading">Holiday</td>
                        			</tr>							

                        				<?php

										$query = "SELECT Date, HolidayName FROM Holiday";
										

										if (isset($Year) && $Year !="All") {
											$query = "SELECT Date, HolidayName FROM Holiday WHERE YEAR(DATE)=$Year";
											array_push($error_msg,  "Selected all the holidays in $Year" );
										};
																		
									    $result = mysqli_query($db, $query);
                                        include('lib/show_queries.php');
                                        
                                        if (is_bool($result) && (mysqli_num_rows($result) == 0) ) {
                                                    array_push($error_msg,  "Query ERROR: Failed to get School information...<br>" . __FILE__ ." line:". __LINE__ );
                                             } 
                                             
									while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
										print "<tr>";
										print "<td>" . $row['Date'] . "</td>";
										print "<td>" . $row['HolidayName'] . "</td>";
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


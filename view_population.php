<?php
	include('lib/common.php');  
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {$city = mysqli_real_escape_string($db, $_POST['city']);} 
?>


<?php include("lib/header.php"); ?>
	<body>
    	<div id="main_container">
        <?php include("lib/menu.php"); ?>    
			<div class="center_content">	
				<div class="center_left">  
					<div class="title_name">
						<?php print 'View Population'; ?>
            		</div>      
					<div class="features">   						
                        <div class="profile_section">
							<div class="subtitle"> </div>                              
						
						</div>  



						<div class="profile_section">
                    		<div class="subtitle"> </div>  
                    			<table>
                        			<tr>
                            			<td class="heading">City</td>
										<td class="heading">State</td>
                            			<td class="heading">Population</td>
                        			</tr>							
                        				<?php

										$query = "Select CityName,State,Population FROM City";
										
										if (isset($city) && $city!="All") {$query = "Select CityName,State,Population FROM City WHERE CityName= " . "'$city'";}
										
									    $result = mysqli_query($db, $query);
										
                                        include('lib/show_queries.php');                                       
                                             
									while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
										print "<tr>";
										print "<td>" . $row['CityName'] . "</td>";
										print "<td>" . $row['State'] . "</td>";
										print "<td>" . $row['Population'] . "</td>";
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


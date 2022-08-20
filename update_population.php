<?php
	include('lib/common.php');  

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$City = mysqli_real_escape_string($db, $_POST['City']);
		$Population = mysqli_real_escape_string($db, $_POST['Population']);
	 
	if (is_numeric($Population)) {

		$query= "UPDATE City SET Population = $Population WHERE CONCAT(CityName,',',State) = " . "'$City'";
		$result = mysqli_query($db, $query);
        include('lib/show_queries.php');
		array_push($error_msg,  "Updated successfully!");

		} else {
			array_push($error_msg,  "Please enter a valid number");
		}
	}


?>


<?php include("lib/header.php"); ?>
	<body>
    	<div id="main_container">
        <?php include("lib/menu.php"); ?>    
			<div class="center_content">	
				<div class="center_left">  
					<div class="title_name">
						<?php print 'Update Population'; ?>
            		</div>      
					<div class="features">   						
                        <div class="profile_section">
							<div class="subtitle"> </div>                              
							<form name="profileform" action="update_population.php" method="post">
								<table>
									<tr>
										<td class="item_label">City</td>
										<td>
											<select name="City">
												<?php 
													$sql = mysqli_query($db, "SELECT CONCAT(CityName,\",\",State) City FROM City");
													while ($row = $sql->fetch_assoc()){
													echo "<option value=" . $row['City'] . ">" . $row['City'] . "</option>";
													}
												?>
											</select>
										</td>
									</tr>
									<tr>
										<td class="item_label">Population</td>
										<td>
											<input type="text" name="Population" value="<?php if ($row['Population']) { print $row['Population']; } ?>" />	
										</td>
									</tr>
								</table>								
								<a href="javascript:profileform.submit();" class="fancy_button">Update</a> 							
							</form>
						</div>  
					 </div> 	
				</div>                 
                <?php include("lib/error.php"); ?>                    
				<div class="clear"></div> 		
			</div>    				 
		</div>
	</body>
</html>


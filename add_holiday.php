<?php

include('lib/common.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $date = mysqli_real_escape_string($db, $_POST['date']);
        $holidayname = mysqli_real_escape_string($db, $_POST['holidayname']);  
      
        if (empty($holidayname)) {array_push($error_msg,  "Please enter a holiday name");} 
        if (!is_date($date)) {array_push($error_msg,  "Please enter a valid date ");}
        
        if ( !empty($holidayname) && is_date($date))   { 

			##check if this date and holiday name is already in holidayname table, if not, insert
			$query="SELECT * FROM Holiday WHERE Date='$date' AND HolidayName='$holidayname'";
			$result = mysqli_query($db, $query);
			$count = mysqli_num_rows($result);

			if ($count!=0) {
				array_push($error_msg,  "This holiday already exists!" );
			} else {
				$query = "INSERT INTO Holiday VALUES('$date','$holidayname')" ;
				$result = mysqli_query($db, $query);
				include('lib/show_queries.php');
				array_push($error_msg,  "Succesfully added this holiday!" );
			}

         }

    
	} 



function is_date( $str ) { 
	$stamp = strtotime( $str ); 
	if (!is_numeric($stamp)) { 
		return false; 
	} 
	$month = date( 'm', $stamp ); 
	$day   = date( 'd', $stamp ); 
	$year  = date( 'Y', $stamp ); 
  
	if (checkdate($month, $day, $year)) { 
		return true; 
	} 
	return false; 
} 

?>



<?php include("lib/header.php"); ?>
	</head>	
	<body>
    	<div id="main_container">
        <?php include("lib/menu.php"); ?>
			<div class="center_content">	
				<div class="center_left">
					<div class="title_name">
						<?php print "Add Holiday"; ?>
						</div>          
					<div class="features">   
                        <div class="profile_section">
							<div class="subtitle"> </div>      
							<form name="profileform" action="add_holiday.php" method="post">
								<table>
									<tr>
										<td class="item_label">Date (YYYY-MM-DD)</td>
										<td>
											<input type="text" name="date" value="<?php if ($row['date']) { print $row['date']; } ?>" />										
										</td>
									</tr>
									<tr>
										<td class="item_label">Holiday Name</td>
										<td>
											<input type="text" name="holidayname" value="<?php if ($row['holidayname']) { print $row['holidayname']; } ?>" />	
										</td>
									</tr>
								</table>								
								<a href="javascript:profileform.submit();" class="fancy_button">Add</a> 							
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
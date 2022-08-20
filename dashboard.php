<?php

    include('lib/common.php');

    $query = "SELECT COUNT(StoreNumber) 'Count' FROM Store";
    $result_1 = mysqli_query($db, $query);
    include('lib/show_queries.php');

    $query = "SELECT COUNT(StoreNumber) 'Count' FROM Store WHERE HasRestaurant=1 or HasSnackBar =1";
    $result_2 = mysqli_query($db, $query);
    include('lib/show_queries.php');
    
    $query = "SELECT COUNT(StoreNumber) 'Count' FROM Store WHERE CCLimit!=0";
    $result_3 = mysqli_query($db, $query);
    include('lib/show_queries.php');

    $query = "SELECT COUNT(PID) 'Count' FROM Product";
    $result_4 = mysqli_query($db, $query);
    include('lib/show_queries.php');


    $query = "SELECT COUNT(DISTINCT(Description)) 'Count' FROM AdsCampaign";
    $result_5 = mysqli_query($db, $query);
    include('lib/show_queries.php');

    
    
    $row_1 = mysqli_fetch_array($result_1, MYSQLI_ASSOC);
    $row_2 = mysqli_fetch_array($result_2, MYSQLI_ASSOC);
    $row_3 = mysqli_fetch_array($result_3, MYSQLI_ASSOC);
    $row_4 = mysqli_fetch_array($result_4, MYSQLI_ASSOC);
    $row_5 = mysqli_fetch_array($result_5, MYSQLI_ASSOC);


   
?>

<?php include("lib/header.php"); ?>

</head>

<body>
		<div id="main_container">
    <?php include("lib/menu.php"); ?>

    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
                <?php print 'Statistics'; ?>
            </div>          
            <div class="features">   
            
                <div class="profile_section">
                    <div class="subtitle"> </div>   
                    <table>
                        <tr>
                            <td class="item_label">Count of Store:</td>
                            <td>
                                <?php print $row_1['Count']; ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="item_label">Count of store with food:</td>
                            <td>
                                <?php print $row_2['Count'];?>
                            </td>
                        </tr>

                        <tr>
                            <td class="item_label">Count of store with childcare:</td>
                            <td>
                                <?php print $row_3['Count'];?>
                            </td>
                        </tr>

                        <tr>
                            <td class="item_label">Count of Product:</td>
                            <td>
                                <?php print $row_4['Count'];?>
                            </td>
                        </tr>

                        <tr>
                            <td class="item_label">Count of distinct ads campaign:</td>
                            <td>
                                <?php print $row_5['Count'];?>
                            </td>
                        </tr>


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
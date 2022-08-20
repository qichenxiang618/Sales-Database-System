<?php include('lib/common.php');?>
<?php include("lib/header.php");?>




<body>
		<div id="main_container">
    <?php include("lib/menu.php"); ?>

    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
				<?php print 'Report 4 – Outdoor Furniture on Groundhog Day'; ?>
            </div>          
            <div class="features">   
                <div class="profile_section">
                    <div class="subtitle">  </div>  
                    <table>
                        <tr>
                            <td class="heading">Year</td>
                            <td class="heading">Total Item Sold</td>
							<td class="heading">Avg Item Sold Per Day</td>
							<td class="heading">Total Item sold On Feb 02</td>                     
                        </tr>							
                        <?php
									    $query = "WITH CTE1 AS (SELECT YEAR(S.Date) 'Year', SUM(S.Quantity) 'TotalItemSold', " .
                                        "SUM(CAST(S.Quantity AS decimal(4,1)))/365 'AvgItemsSoldPerDay' " .
                                        "FROM Sale S JOIN BelongTo B ON S.PID=B.PID WHERE  B.CategoryName ='Outdoor Furniture' " .
                                        "GROUP BY YEAR(S.Date)), " .
                                        "CTE2 AS( SELECT YEAR(S.Date) 'Year',SUM(S.Quantity) 'TotalItemSoldOnFeb02' " .
                                        "FROM Sale S JOIN BelongTo B ON S.PID=B.PID WHERE B.CategoryName ='Outdoor Furniture' AND  " .
                                        "MONTH(S.Date)=2 AND DAY(S.Date)=2 GROUP BY YEAR(S.Date)) " .
                                        "SELECT CTE1.Year,CTE1.TotalItemSold 'Total Item Sold',CTE1.AvgItemsSoldPerDay 'Avg Item Sold Per Day', CTE2.TotalItemSoldOnFeb02 'Total Item sold On Feb 02' " .
                                        "FROM CTE1 JOIN CTE2 ON CTE1.Year=CTE2.Year ORDER BY CTE1.Year ASC ";
                                        

									    $result = mysqli_query($db, $query);
                                        include('lib/show_queries.php');
                                        
                                        if (is_bool($result) && (mysqli_num_rows($result) == 0) ) {
                                                    array_push($error_msg,  "Query ERROR: Failed to get School information...<br>" . __FILE__ ." line:". __LINE__ );
                                             } 
                                             
									while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
										print "<tr>";
										print "<td>" . $row['Year'] . "</td>";
										print "<td>" . $row['Total Item Sold'] . "</td>";
										print "<td>" . $row['Avg Item Sold Per Day'] . "</td>";
										print "<td>" . $row['Total Item sold On Feb 02'] . "</td>";
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
               <?php include("lib/footer.php"); ?>				 
		</div>
	</body>
</html>
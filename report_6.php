<?php include('lib/common.php');?>
<?php include("lib/header.php");?>




<body>
		<div id="main_container">
    <?php include("lib/menu.php"); ?>

    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
				<?php print 'Report 6 – Revenue by Population'; ?>
            </div>          
            <div class="features">   
                <div class="profile_section">
                    <div class="subtitle">  </div>  
                    <table>
                        <tr>
                            <td class="heading">Year</td>
                            <td class="heading">Small</td>
							<td class="heading">Medium</td>
							<td class="heading">Large</td>      
                            <td class="heading">ExtraLarge</td>                 
                        </tr>							
                        <?php
									    $query = "WITH CTE AS (SELECT YEAR(S.Date) 'Year',CASE WHEN C.Population<3700000 THEN 'Small' " .
                                        "WHEN C.Population>=3700000 and C.Population<6700000 THEN 'Medium' " .
                                        "WHEN C.Population>=6700000 and C.Population<9000000 THEN 'Large' " .
                                        "WHEN C.Population>=9000000 THEN 'ExtraLarge' END 'PopulationSize', " .
                                        "CASE WHEN H.PID IS NULL THEN S.Quantity*P.Price ELSE S.Quantity*H.DiscountPrice END 'Revenue'  " .
                                        "FROM Sale S JOIN Store SS ON S.StoreNumber=SS.StoreNumber JOIN City C ON SS.CityName=C.CityName " .
                                        "JOIN Product P ON S.PID=P.PID LEFT JOIN HasDiscountOn H ON S.PID=H.PID AND S.Date=H.Date) " .
                                        "SELECT Year, " .
                                        "SUM(CASE PopulationSize WHEN 'Small' THEN Revenue ELSE 0 END) 'Small', " .
                                        "SUM(CASE PopulationSize WHEN 'Medium' THEN Revenue ELSE 0 END) 'Medium', " .
                                        "SUM(CASE PopulationSize WHEN 'Large' THEN Revenue ELSE 0 END) 'Large', " .
                                        "SUM(CASE PopulationSize WHEN 'ExtraLarge' THEN Revenue ELSE 0 END) 'ExtraLarge' " .
                                        "FROM CTE GROUP BY Year ORDER BY Year ASC";
                                        
									    $result = mysqli_query($db, $query);
                                        include('lib/show_queries.php');                                
                                             
									while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
										print "<tr>";
										print "<td>" . $row['Year'] . "</td>";
										print "<td>" . $row['Small'] . "</td>";
										print "<td>" . $row['Medium'] . "</td>";
										print "<td>" . $row['Large'] . "</td>";
                                        print "<td>" . $row['ExtraLarge'] . "</td>";
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
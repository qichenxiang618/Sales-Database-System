<?php include('lib/common.php');?>
<?php include("lib/header.php");?>




<body>
		<div id="main_container">
    <?php include("lib/menu.php"); ?>

    <div class="center_content">
        <div class="center_left">
            <div class="title_name">
				<?php print 'Report 7 – Childcare Sales Volume'; ?>
            </div>          
            <div class="features">   
                <div class="profile_section">
                    <div class="subtitle">  </div>  
                    <table>
                        <tr>
                            <td class="heading">Year</td>
                            <td class="heading">Month</td>
                            <td class="heading">NoChildCare</td>
							<td class="heading">30 mins</td>
							<td class="heading">45 mins</td>      
                            <td class="heading">60 mins</td>                 
                        </tr>							
                        <?php
									    $query = "WITH CTE AS  ( " .
                                            "SELECT YEAR(S.Date) 'Year', MONTH(S.Date) 'Month', " .
                                            "ST.CClimit," .
                                            "CASE WHEN H.PID IS NULL THEN S.Quantity*P.Price ELSE S.Quantity*H.DiscountPrice END 'Revenue' " .
                                            "FROM Sale S " .
                                            "LEFT JOIN Store ST ON ST.StoreNumber=S.StoreNumber " .
                                            "JOIN Product P ON P.PID=S.PID " .
                                            "LEFT JOIN HasDiscountOn H ON S.PID=H.PID AND S.Date=H.Date " .
                                            "WHERE DATEDIFF((select max(date) from sale),S.date) <365) " .
                                            "SELECT Year,Month, " .
                                            "SUM(CASE CClimit WHEN 0 THEN Revenue ELSE 0 END) 'NoChildCare', " .
                                            "SUM(CASE CClimit WHEN 30 THEN Revenue ELSE 0 END) '30', " .
                                            "SUM(CASE CClimit WHEN 45 THEN Revenue ELSE 0 END) '45', " .
                                            "SUM(CASE CClimit WHEN 60 THEN Revenue ELSE 0 END) '60' " .
                                            "FROM CTE  GROUP BY Year,Month ORDER BY 1,2 ASC";
                                        

									    $result = mysqli_query($db, $query);
                                        include('lib/show_queries.php');
                                                                                    
									while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
										print "<tr>";
										print "<td>" . $row['Year'] . "</td>";
                                        print "<td>" . $row['Month'] . "</td>";
                                        print "<td>" . $row['NoChildCare'] . "</td>";
										print "<td>" . $row['30'] . "</td>";
										print "<td>" . $row['45'] . "</td>";
                                        print "<td>" . $row['60'] . "</td>";
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
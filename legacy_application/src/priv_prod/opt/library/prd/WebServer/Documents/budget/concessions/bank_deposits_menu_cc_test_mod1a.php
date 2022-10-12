<?php

$query18="SELECT SUM(amount) as 'upload_total'
FROM  `crs_tdrr_cc` 
WHERE 1";
		 
//echo "query1=$query1<br />";		 

$result18 = mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18");

$row18=mysqli_fetch_array($result18);
extract($row18);
$upload_total=number_format($upload_total,2);


echo "<br />"; 
 
echo "<table>";
echo "<tr>";

echo "<th>Step1A <font color='red'>(NEW STEP)</font>: Uploaded Deposit Total equals $upload_total &nbsp;&nbsp;&nbsp;Is this correct?</th>";

echo "<th>";
echo "<br />";
echo "<form  method='post' autocomplete='off' action='bank_deposits_menu_cc_test.php'>";
echo "<input type='hidden' name='step' value='2'>";
echo "<input type='submit' name='submit' value='YES'>";
echo "</th>";

echo "</tr>";
echo "</table>";
			


?>
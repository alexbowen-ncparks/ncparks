<?php
//echo "<td><a href='$chp_link'><font class='cartRow'>Cash<br />Handling <br />Plan</font></a><br /></td>";

echo "<table align='center' cellspacing='5' >";



$query8a="select text_code from svg_graphics where id='13'  ";
		 
//echo "query8a=$query8a<br />";		 

$result8a = mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");

$row8a=mysqli_fetch_array($result8a);
extract($row8a);	





	
echo "<tr>";

echo "<th><a href='preapproval_yearly.php'>$text_code</a></th>";
echo "</tr>";
echo "<tr>";
// class='cartRow'=cell background color per styling sheet:  /budget/menu1415_v1_style.php
//echo "<th><font class='cartRow'>Yearly<br />Approvals<br/></font></a></th>";






echo "</tr>";	
	
	
	
echo "</table>";
//if($beacnum=='60032833'){$park='DEDE';} //erin lawrence
//echo "park=$park";

?>
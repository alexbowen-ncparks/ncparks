<?php
extract($_REQUEST);
//if($fyear==''){$fyear='1718';}
//if($wex_fyear=='')
//{
//$query1="SELECT max(wex_fyear) as 'wex_max_fyear' from wex_detail ";

$query1="SELECT max(id) as 'maxid' from wex_detail ";


		 
////echo "<br />query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);

$query1a="SELECT wex_fyear as 'wex_max_fyear',month as 'wex_max_month' from wex_detail where id='$maxid' ";


		 
////echo "<br />query1a=$query1a<br />";		 

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");

$row1a=mysqli_fetch_array($result1a);
extract($row1a);





//$query1a="SELECT calyear as 'wex_calyear',month as 'wex_month' from wex_detail where id='$maxid' ";
		 
//echo "<br />query1a=$query1a<br />";		 

//$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");

//$row1a=mysqli_fetch_array($result1a);
//extract($row1a);
//}

//$query1b="SELECT fyear as 'wex_max_fyear' from fyear2calyear where $wex_month='$wex_calyear' ";
		 
//echo "<br />query1b=$query1b<br />";		 

//$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");

//$row1b=mysqli_fetch_array($result1b);
//extract($row1b);


$wex_min_fyear='1718';
$wex_default_fyear=$wex_max_fyear;
$wex_default_month=$wex_max_month;

if($wex_fyear==''){$wex_fyear=$wex_default_fyear;}
if($wex_month==''){$wex_month=$wex_default_month;}

//echo "<br />wex_calyear=$wex_calyear<br />";

////echo "<br />wex_min_fyear=$wex_min_fyear<br />";
////echo "<br />wex_max_fyear=$wex_max_fyear<br />";
////echo "<br />wex_default_month=$wex_default_month<br />";
////echo "<br />wex_month=$wex_month<br />";
////echo "<br />wex_default_fyear=$wex_default_fyear<br />";
////echo "<br />wex_fyear=$wex_fyear<br />";



//if($report_type==''){$report_type='vehicles';}



//if($fyear=='1718'){$fyear_1718_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

//$fyear_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";




echo "<table border='5' cellspacing='5' align='center'>";
echo "<tr>";


echo "<td><font color='brown'>Report Year</brown></td>";

//if($report_type=='vehicles')
//{
//echo "<td align='left'><a href='step_group.php?report_type=$report_type&fyear=1718'>1718 $fyear_check</font></a></td>";	


$query3="SELECT fyear as 'wex_fyear2' from fyear2calyear where fyear>='$wex_min_fyear' and fyear <= '$wex_max_fyear' order by wex_fyear2 desc";


////echo "query3=$query3<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);

while ($row3=mysqli_fetch_array($result3))
	{	
	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	//$rank=@$rank+1;
	extract($row3);

if($wex_fyear2==$wex_fyear){$fyear_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";} else {$fyear_check='';}

echo "<td align='left'><a href='step_group.php?report_type=vehicles&wex_fyear=$wex_fyear2&wex_month=$wex_month'>$wex_fyear2 $fyear_check </font></a></td>";	
//echo "<td align='left'><a href='step_group.php?report_type=$report_type&wex_fyear=1617'>1617 $fyear_check</font></a></td>";	

	}



echo "</tr>";

echo "</table>";






?>
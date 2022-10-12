<?php
//These are placed outside of the webserver directory for security
$database="facilities";
include("../../include/auth.inc"); // used to authenticate users
$multi_park=explode(",",$_SESSION[$database]['accessPark']);

include("../../include/connectROOT.inc"); 

extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "<pre>";print_r($_SESSION);echo "</pre>";
$level=$_SESSION[$database]['level'];

if($level<1)
	{exit;}
	
mysql_select_db("budget", $connection); // database

include("menu.php");

$order_by="t1.project_number";
if(!empty($sort))
	{
	$order_by="t2.".$sort;
	}

$where="where 1";
if(!empty($park))
	{
	$where.=" and t2.park='$park'";
	}
if(!empty($statusPer))
	{
	$where.=" and t2.statusPer='$statusPer'";
	}	
		$sql="SELECT t1.*, t2.park, t2.projName, t2.startDate, t2.statusPer, t2.commentsI, t2.div_app_amt
		from partf_spo_numbers as t1
		left join partf_projects as t2 on t1.project_number=t2.projNum
		$where
		order by $order_by
		"; //echo "$sql";

	$result = mysql_query($sql) or die ("Couldn't execute query. $sql ".mysql_error());
	$num=mysql_num_rows($result);
	
	if($num<1){$message="No record found using $arraySet";}
		
	while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		$park_array[$row['park']]=$row['park'];
		}
	if(empty($_SESSION['facilities']['park_array']))
		{
		sort($park_array);
		$_SESSION['facilities']['park_array']=$park_array;
		}
		else
		{$park_array=$_SESSION['facilities']['park_array'];}
		
	echo "<form name='projects' action='partf_project_numbers.php'>
	<table border='1'><tr>
	<td colspan='2'>Number found: $num </td>
	<td colspan='2'><select name='park' onchange=\"this.form.submit()\"><option value=\"\"></option>\n";
	foreach($park_array as $k=>$v)
		{
		if($park==$v){$s="selected";}else{$s="";}
		echo "<option value='$v' $s>$v</option>\n";
		}
	echo "</select>
	&nbsp;&nbsp;&nbsp;
	<a href='partf_project_numbers.php'>All Projects</a>
	</td></tr>";
		foreach($ARRAY[0] as $k=>$v)
			{
	if(in_array($k,$skip)){continue;}
	/*		if($k=="park")
				{$k="<a href='partf_project_numbers?sort=$k'>$k</a>";}
			if($k=="project_number")
				{$k="<a href='partf_project_numbers'>$k</a>";}
			if($k=="statusPer")
				{$k="<a href='partf_project_numbers?sort=$k'>$k</a>";}
	*/
			echo "<th>$k</th>";
			}
	echo "</tr>";
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;	
	foreach($ARRAY as $k=>$array)
		{
		echo "<tr>";
		foreach($array as $k1=>$v1)
			{
	if(in_array($k1,$skip)){continue;}
			if($k1=="div_app_amt")
				{
				@$total+=$v1;
				}
			
			if($k1=="project_number")
				{
				$v1="<a href='https://10.35.152.9/budget/partf.php?new=1&projNum=$v1&Submit=Find' target='_blank'>$v1</a>";
				$v1="<a href='https://10.35.152.9/budget/partf.php?new=1&projNum=$v1&Submit=Find' target='_blank'>$v1</a>";
				}
			
			if($k1=="spo_number")
				{
		//		$v1="<a href='http://www.ncspo.com/fis/dbBldgAsset.aspx?BldgAssetID=$v1' target='_blank'>$v1</a>";
				}
					
			echo "<td>$v1</td>";
			}
		echo "</tr>";
		}
		$total=number_format($total,2);
		echo "<tr><td colspan='8' align='right'>$total</td></tr></table></form>";

echo "</body></html>";
mysql_close($connection);

?>
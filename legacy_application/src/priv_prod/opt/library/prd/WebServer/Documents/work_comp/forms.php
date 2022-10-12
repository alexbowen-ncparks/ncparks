<?php
$database="work_comp";
include("../_base_top.php");

if($_SESSION['work_comp']['level'] <0)
	{
	echo "<br /><br />This application is still being developed."; exit;
	}
	
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

// Process Update
if($_POST)
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";
	if(!empty($_POST['pass_title']))
		{
		foreach($_POST['pass_title'] AS $number=>$value)
			{
			$clause="UPDATE web_links set ";
			$clause.="title='".$value."'";
			$sql=rtrim($clause,",")." where id='$number'";
						
		//		echo "<br />$sql";
				$result = mysqli_query($connection,$sql);
			}
			
		foreach($_POST['pass_link'] AS $number=>$value)
			{
			$clause="UPDATE web_links set ";
			$clause.="link='".$value."'";
			$sql=rtrim($clause,",")." where id='$number'";
						
		//		echo "<br />$sql";
				$result = mysqli_query($connection,$sql);
			}
		}
		if($_POST['new_title']!="")
			{
			$title=$_POST['new_title'];
			$sql="INSERT INTO web_links set title='$title', link='$_POST[new_link]'";
			//	echo "<br />$sql";
				$result = mysqli_query($connection,$sql);
			}
				
	//	exit;
		}
mysqli_select_db($connection, $database); // database 
$sql="SELECT * from link_to_find_db order by sort_order";
$result = mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_forms[]=$row;
	}
	
$skip=array("id","forumID","filename","mid");
echo "<table align='center'><tr><th colspan='2'>
<h2><font color='purple'>NC DPR Worker Compensation Tracking Application</font></h2></th></tr></table>";

echo "<table align='center' cellpadding='5'>";


echo "</table>";

$rename_array=array("sort_order"=>"","form_name"=>"Form","link"=>"Link");

echo "<hr /><table align='center' cellpadding='5'><tr>
<td>
<table border='1' cellpadding='5'><tr></tr>";

echo "<tr><th colspan='5'><h4><font color='blue'>Workers' Comp Forms</font></h4></th></tr>";
foreach($ARRAY_forms AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY_forms[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$var_fld=$fld;
			if(array_key_exists($fld, $rename_array)){$var_fld=$rename_array[$fld];}
			echo "<th>$var_fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		$display="<td>$value</td>";
		if($fld=="link")
			{
			$value="/find/".$value;
			$value="/find/".$value;
			$display="<td><a href='$value' target='_blank'>Get form</a></td>";
			}
		echo "$display";
		}
	echo "</tr>";
	}
echo "<tr><td colspan='3'>Supervisor/Manager please direct your injured employee to a local network provider based on location.  For a complete list of network providers, please visit <a href='https://www.talispoint.com/login/' target='_blank'>https://www.talispoint.com/login/</a> . Username: strata   Password: SONC99<br /><br />
Hospital Emergency Rooms should only be used for extreme injuries or after-hours treatment that cannot wait.
</td></tr>";

echo "</table>";
	
?>

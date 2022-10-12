<?php
session_start();
//echo "3<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
// echo "4<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
$pass_park=$_SESSION['fixed_assets']['select'];
if(!empty($_SESSION['fixed_assets']['accessPark']))
	{
	$temp_array=explode(",",$_SESSION['fixed_assets']['accessPark']);
	if(!empty($temp_array))
		{
		foreach($temp_array as $k=>$v)
			{
			if($v=="WARE"){$v="WAHO";}
			$accessPark_array[]="DPR".$v;
			}
		}
	}
//echo "<pre>"; print_r($accessPark_array); echo "</pre>"; // exit;
IF(@$_REQUEST['submit']=="Awaiting Action")
	{
	$loc=$_REQUEST['single_location'];
	$table=$_REQUEST['table'];
	if($_SESSION['fixed_assets']['level']==1 and empty($loc))
		{$loc="DPR".$_SESSION['fixed_assets']['select'];}
	header("Location: surplus_equip_form.php?location=$loc&act=review&table=$table");
	exit;
	}
	
IF(@$_REQUEST['submit']=="Available")
	{
	header("Location: available.php");
	exit;
	}
	

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');

$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");
       
       
$level=$_SESSION['fixed_assets']['level'];

if($level<1){exit;}
	
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

echo "<html><head>";
?>

<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />    
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>

<script>
    $(function() {
        $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker3" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });

function validateFormSEF(z)
	{
	var check=z;
	if(check==1)
		{
		var x=document.forms["sef"]["pasu_date"].value;
		if (x==null || x=="")
			{
			alert("A date must be entered.");
			return false;
			}
		}
	if(check==2)
		{
		var x=document.forms["sef"]["disu_date"].value;
		if (x==null || x=="" || x=="0000-00-00")
			{
			alert("A date must be entered.");
			return false;
			}
		}
	if(check==3)
		{
		var x=document.forms["sef"]["chop_date"].value;
		if (x==null || x=="" || x=="0000-00-00")
			{
			alert("A date must be entered.");
			return false;
			}
		}
	}
</script>
<style>
.ui-datepicker {
  font-size: 80%;
}
</style>

<?php
include("../css/TDnull.php");

//$table="inventory_2012";
//$table="inventory_2013";
if(empty($_REQUEST['table']))
	{
	$table="inventory_2017";
	if(!empty($action) or !empty($_SESSION['fixed_assets']['action']))
		{
		$table="inventory_2017";  
		if($_SESSION['fixed_assets']['action']=="surplus" and @$_REQUEST['action']!="inventory")
			{$table="inventory_december_2013";}
		}
	$_REQUEST['table']=$table;
	}
else
	{
	$table=$_REQUEST['table'];
		if($_SESSION['fixed_assets']['action']=="surplus")
			{$table="inventory_december_2013";}
	}

echo "<title>NC DPR Fixed Asset Tracking System</title><body>";


$sql="SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES 
WHERE TABLE_SCHEMA LIKE 'fixed_assets' and TABLE_NAME like 'inventory%'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
		$table_array[]=$row['TABLE_NAME'];
	}
//echo "<pre>"; print_r($table_array); echo "</pre>"; // exit;

mysqli_select_db($connection, "fixed_assets")
       or die ("Couldn't select database $database");
$sql="select distinct location as park_code from $table where 1 order by location";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 140. $sql ".mysqli_error($connection));
while ($row=mysqli_fetch_array($result))
	{
		$park_array[]=$row['park_code'];
	}
//echo "<pre>"; print_r($park_array); echo "</pre>"; // exit;
if(empty($file)){$file="find";}

$file=$file."_inventory.php";
echo "<form action='$file' method='POST'>";
echo "<div align='center'><table border='1' cellpadding='5'>";
if($_SESSION['fixed_assets']['action']=="surplus")
	{$show_action=" - <font color='magenta'>SURPLUS</font>";}
	else
	{$show_action="";}
echo "<tr><td colspan='6' align='center'>NC DPR Fixed Asset Inventory - $table $show_action</td></tr>";

$test_unit=@$_REQUEST['single_location']; 
if(empty($test_unit)){$test_unit=$_SESSION['fixed_assets']['select'];}

$rename_dist=array("EADI"=>"EAST","SODI"=>"SOUTH","NODI"=>"NORTH","WEDI"=>"WEST");

IF(array_key_exists($test_unit, $rename_dist))
	{
	$test_unit="DPR".$rename_dist[$test_unit];
	}
	else
	{
	$test_unit="DPR".$test_unit;
	}

//	echo "<pre>"; print_r($accessPark_array); echo "</pre>"; // exit;
//echo "<pre>"; print_r($park_array); echo "</pre>"; // exit;
echo "<tr>
<td><a href='home.php'>Home</a></td>
<td align='center'>Controller's Office Code<br /><select name='location'><option></option>\n";
	foreach($park_array as $k=>$v)
		{
		IF(!EMPTY($accessPark_array))
			{
			if(!in_array($v,$accessPark_array))
				{continue;}
			}
			else
			{
			$var="DPR".$pass_park;
			if($level<2)
				{
				if($var!=$v)
					{continue;}
				}
			}
		
		if($v==$test_unit){$s="selected";}else{$s="value";}
		echo "<option value='$v' $s>$v</option>\n";
		}
echo "</select></td>";

if($level>3)
	{
	echo "<td align='center'>FAS Year<br /><select name='table'><option></option>\n";
		foreach($table_array as $k=>$v)
		{
			if($v==$table or "fixed_assets.".$v==$table)
				{$s="selected";}else{$s="value";}
			echo "<option $s='$v'>$v</option>\n";
			}
	echo "</select></td>";
	}

echo "<td>";
if($level>3)
	{
//	echo "<input type='submit' name='submit' value='Electronic Items to Surplus'>";
	}
	

//if(@$_REQUEST['action']=="inventory" OR @$_REQUEST['action']=="") and //empty($_SESSION['fixed_assets']['action'])))
if(@$_REQUEST['action']=="inventory" OR @$_REQUEST['action']=="") 
	{
	$_SESSION['fixed_assets']['action']="inventory";
	echo "<input type='hidden' name='action' value='inventory'>";
	echo "<input type='submit' name='submit' value='View Inventory'>";
	
		$sql="SELECT * FROM lock_inventory";
		$result=mysqli_query($connection,$sql);
		$row=mysqli_fetch_assoc($result);
		$lock_date=$row['lock_date'];
		
	if($tempID=="Regier9340")
		{
	//	echo "";  Might need to customize for land only units
		}
	if($level>3 )
		{
		if(!empty($lock_date))
			{
			$ck="checked";
			$op="";
			}
			else
			{
			$ck="";
			$op="checked";
			}
		echo"<br />Lock <a href='lock_inventory.php?op=$op'><input type='checkbox' name='lock_inventory' value='x' $ck></a> $lock_date";
		}
	}
	else
	{
	$_SESSION['fixed_assets']['action']="surplus";
	echo "<input type='hidden' name='action' value='surplus'>";
	echo "<input type='submit' name='submit' value='Items to Surplus'>";
	echo "<input type='submit' name='submit' value='Awaiting Action'>
	";
	echo "<input type='submit' name='submit' value='Available'>";
	if($level>3)
		{
		echo "<input type='submit' name='submit' value='BO Approval'>";
		echo "<input type='submit' name='submit' value='BO Approved'>";
		}
	
	}
	
echo "</form></td>";

// echo "<td><form action='/find/forum.php' target='_blank'>";
// echo "<input type='hidden' name='searchterm' value='FAS INSTRUCTIONS-FIXED ASSETS'>";
// echo "<input type='submit' name='submit' value='Instructions'";
// echo " style=\"background-color:#C6E2FF\"></form>";
// echo "</td>";

if($level>3)
	{
	//<form action='search.php'>
	echo "<td>";
	echo "<input type='text' name='searchterm' value=\"\">";
	echo "<input type='submit' name='submit' value='Search'>";
// 	echo "</form>";
	echo "</td>";
	}

echo "</tr>";
echo "</table></div>";

?>
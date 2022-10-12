<?php
session_start();
$pass_park=$_SESSION['fixed_assets']['select'];

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');

$database="divper";
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

echo "<title>NC DPR Fixed Asset Tracking System</title><body>";

	$sql="select t1.beacon_num, t1.posTitle, t3.Fname, t3.Lname, t2.currPark, t2.tempID
	from position as t1
	left join emplist as t2 on t1.beacon_num=t2.beacon_num
	left join empinfo as t3 on t3.emid=t2.emid
	 where t1.posTitle like '%Superintendent' or t2.tempID='Tingley9265' or t2.tempID='Bridges0354' or t2.tempID='Williams5894' or t2.tempID='Chandler1195'
	 order by t2.currPark"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	while ($row=mysqli_fetch_assoc($result))
		{
		if(empty($row['currPark'])){continue;}
		if($level==1 and $pass_park!=$row['currPark'])
			{continue;}
		$login_array[$row['beacon_num']]=$row;
		}
//echo "<pre>"; print_r($login_array); echo "</pre>";  exit;	

echo "<form action='fa_home.php' method='POST'>";
echo "<div align='center'><table border='1' cellpadding='5'>";

if(empty($login_array)){exit;}

echo "<tr><td align='center'>Person to Activate<br /><select name='login_as'><option></option>";
	foreach($login_array as $k=>$v)
		{
		extract($v);
		if(($tempID."-".$v)==$login_as){$s="selected";}else{$s="value";}
		$x=1;  // level passed to POST
		if($posTitle=="Parks District Superintendent"){$x=2;}
		if($posTitle=="Chief of Operations"){$x=3;}
		if($posTitle=="Environmental Program Supv IV"){$x=3;}
		if($posTitle=="Accounting Clerk V"){$x=4;}
		if($posTitle=="Office Assistant V"){$x=4;}
		if($posTitle=="Administrative Assistant I"){$x=4;}
		
		
		$var_a=$k."-".$tempID."-$x"; 
		$var_b=$currPark."-".$posTitle."-".$Lname;
		echo "<option value='$var_a' $s>$var_b</option>";
		}
echo "</select></td>";


echo "<td>
<input type='submit' name='submit' value='Activate'>";
echo "</td>";

if($level>4)
	{echo "<td><a href='inventory.php'>Go</a></td>";}
echo "</tr>";
echo "</table></form>";


if(!empty($_POST['login_as']))
	{
	$exp=explode("-",$_POST['login_as']);
//	echo "<pre>"; print_r($exp); echo "</pre>"; // exit;
	$sql="select currPark, exhibits, tempID
	from emplist 
	 where  tempID='$exp[1]'"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	$row=mysqli_fetch_assoc($result);
	extract($row);
//	echo "<pre>"; print_r($row); echo "</pre>"; // exit;
	$_SESSION['fixed_assets']['tempID']=$exp[1];
	$_SESSION['fixed_assets']['level']=$exp[2];
	$_SESSION['fixed_assets']['select']=$currPark;
	echo "Go to form as: <a href='inventory.php?action=surplus' target='_blank'>$tempID</a>";
	}
?>
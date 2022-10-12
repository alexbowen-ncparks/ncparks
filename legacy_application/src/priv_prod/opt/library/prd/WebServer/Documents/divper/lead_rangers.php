<?php
//These are placed outside of the webserver directory for security
ini_set('display_errors',1);

$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/get_parkcodes_reg.php");

mysqli_select_db($connection,'divper'); // database

if(empty($rep))
	{include("menu.php");}


$level=$_SESSION['divper']['level'];
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
// echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;

// Add Ranger
if(@$_POST['submit']=="Update")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; //exit;
		foreach($_POST['tempID'] AS $k=>$v){
			$clause="lead_for='";
			foreach($_POST['var'] AS $key=>$val)
				{
				$area=$_POST['var'][$key];
				if($area=="x"){$area="";}
				$clause.=$area.",";
				}
			$clause=rtrim($clause,",")."' where emplist.tempID='".$v."'";
		$sql = "UPDATE emplist SET $clause"; //echo "$sql<br />"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
			}
		$_REQUEST['fi']=$_POST['tempID'][0][0];
		unset($clause);
	}


$sql = "SELECT emplist.currPark FROM emplist 
WHERE  emplist.lead_for !=''
ORDER  BY currPark";// echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$park_list[]=$row['currPark'];
	}

if(empty($rep))
	{
	echo "<form method='POST'><table cellpadding='5'>
	<tr><td>Lname: <input type='text' name='Lname'></td>";

	echo "<td>Park Code: <select name=\"park_code\"><option selected></option>";$s="value";
	foreach($parkCode as $k=>$v){
	if(!in_array($v,$park_list)){continue;}
		echo "<option $s='$v'>$v</option>";
	   }
	echo "</select></td>";


	echo "</tr></table>
	<table cellpadding='7'>
	<tr><td>
	<input type='checkbox' name='var[]' value='ie'>Interpretation & Education</td><td>
	<input type='checkbox' name='var[]' value='le'>Law Enforcement</td><td>
	<input type='checkbox' name='var[]' value='nr'>Natural Resource</td><td>
	<input type='checkbox' name='var[]' value='sa'>Safety Officer</td><td>
	<input type='checkbox' name='var[]' value='vc'>Volunteer Coordinator</td><td>
	<input type='checkbox' name='var[]' value='cc'>Centennial Coordinator</td><td>
	<input type='checkbox' name='var[]' value='ph'>Park Historian</td>
	</tr>
	<tr><td colspan='7' align='center'>
	<input type='submit' name='submit' value='Find Lead Person'><br /><br />";
//	<input type='submit' name='submit' value='Update a Person'>
	echo "</td></tr>

	</table></form>";

$sql = "SELECT emplist.tempID
FROM  emplist
LEFT  JOIN position ON emplist.beacon_num = position.beacon_num
WHERE 1
ORDER  BY emplist.tempID"; //echo "$sql<br />";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

while($row=mysqli_fetch_assoc($result)){$ARRAY[$row['tempID'][0]]=1;}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

echo "<hr /><table><tr><td>";
foreach($ARRAY as $k=>$v)
	{
	echo " <a href='lead_rangers.php?fi=$k'>[ $k ]</a>&nbsp;&nbsp;";
	}
echo "</td</tr></table><hr />";

	if(@$_POST['submit']=="Update a Person")
		{
		include("add_lead_ranger.php");
		exit;
		}

	if((@$_REQUEST['fi']!="" OR @$_REQUEST['tempID']!="") AND @$_POST['submit']=="")
		{
		include("add_lead_ranger.php");
		exit;
		}

	}

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; 
// echo "112<pre>"; print_r($_POST); echo "</pre>"; //exit;
@$test=implode("",$_POST);
//if($_REQUEST['tempID']!=""){$test="Find Individual";}

if($test=="" and empty($where))
	{
	@$pass_where=$where;
	EXIT;
	}
	else
	{
	extract($_POST);
	}

$lead_for_array=array();
if(isset($_POST['var']))
	{
	foreach($_POST['var'] as $k=>$v)
		{
		@$clause.="lead_for like '%".$v."%' or ";
		$lead_for_array[]=$v;
		}
	$clause=rtrim($clause," or ");
	}

if(@$Lname){$where="and empinfo.Lname LIKE  '$Lname%'";}  //echo "$where"; exit;

if(@$park_code){@$where.="and emplist.currPark = '$park_code' and lead_for !=''";}

if(@$clause){@$where.=" and (".$clause.")";}

if($test=="Find Lead Person")
	{
	$where="and lead_for !=''";
	}

if($test=="Find Individual")
	{
	$where="and empinfo.tempID='$tempID'";
	}
	
if(!empty($pass_where))
	{$where=$pass_where;}
$sql = "SELECT emplist.currPark, empinfo.Nname, empinfo.Fname, empinfo.Lname, empinfo.emid, empinfo.tempID, position.posTitle, emplist.lead_for, empinfo.phone, empinfo.email, dprunit.county, dprunit.ophone
FROM empinfo
LEFT  JOIN emplist ON emplist.emid = empinfo.emid
LEFT  JOIN position ON emplist.beacon_num = position.beacon_num
LEFT  JOIN dpr_system.dprunit ON emplist.currPark = dprunit.parkcode
WHERE 1
$where
ORDER  BY currPark"; //echo "$sql <br />";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
if(mysqli_num_rows($result)<1){echo "No one found using $where"; exit;}
$num=mysqli_num_rows($result);

unset($ARRAY);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$email_array[]=$row['email'];
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
//echo "<pre>"; print_r($lead_for_array); echo "</pre>"; // exit;

$skip=array("tempID","emid","ophone");

$cp_ARRAY=array($_SESSION['divper']['select']);
if(!empty($_SESSION['divper']['accessPark']))
	{
	$cp_ARRAY=explode(",",$_SESSION['divper']['accessPark']);
	}

if(empty($rep))
	{
$lead_codes=array("ie"=>"Interpretation & Education","le"=>"Law Enforcement","sa"=>"Safety Officer","nr"=>"Natural Resoruce","vc"=>"Volunteer Coordinator","cc"=>"Centennial Coordinator","ph"=>"Park Historian");

	$ua=$_SERVER['HTTP_USER_AGENT'];
	strpos($ua,"Windows")>0?$var_im=";":$var_im=",";
	$to_email="";
	if(count($lead_for_array)==1)
		{
		$to_email=implode($var_im,$email_array);
		$title=$lead_codes[$lead_for_array[0]];
		}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
echo "<hr /><table border='1' cellpadding='3'>";
// Header
	echo "<tr><td colspan='4' align='center'>$num found</td>
	<td colspan='3'>Excel <a href=\"lead_rangers.php?rep=1&where=$where\">export</a></td>";
	if(!empty($to_email))
		{
		echo "<td colspan='2'>Batch $title <a href=\"mailto:$to_email?Subject=$title\">Email</a></td>";
		}
	echo "</tr>";
	}
	else
	{
	if($rep=="1")
		{
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename=lead_persons.xls');
		}
	echo "<table>";
	}
		echo "<tr>";
foreach($ARRAY[0] as $fld=>$val){
		if(in_array($fld,$skip)){continue;}
		echo "<th>$fld</th>";}
		echo "</tr>";
foreach($ARRAY as $number=>$fields)
	{
	echo "<tr>";
	foreach($fields as $fld_name=>$value)
		{
		if(in_array($fld_name,$skip)){continue;}
		if($fld_name=="phone" and $value=="")
			{
			$value=$ARRAY[$number]['ophone'];
			}
		if($fld_name=="lead_for"){$value=strtoupper($value);}
			if($fld_name=="email")
				{
				$value="<a href='mailto:$value?subject=$fields[currPark] Lead Ranger'>$value</a>";
				}
			if($fld_name=="Lname")
				{
				$check_park="AND ";
				$cp=$fields['currPark'];
				if((in_array($cp, $cp_ARRAY) or $level>1) and empty($rep))
					{
					$value="<a href='lead_rangers.php?tempID=$fields[tempID]'>$value</a>";
					}
				}
			if($fld_name=="currPark" AND $value=="")
				{
				$value="none";
				}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
	echo "</table>";

?>
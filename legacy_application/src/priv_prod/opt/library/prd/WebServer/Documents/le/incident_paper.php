<?php
$database="le";
include("../../include/connectROOT.inc"); // database connection parameters
$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");
extract($_REQUEST);
session_start();
$level=$_SESSION['le']['level'];
//print_r($_SESSION);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
$pass_incident_desc=$pass_desc;

echo "<script language=\"JavaScript\"><!--
function setForm() {
    opener.document.pr63_paper_form.incident_code.value = document.inputForm1.inputField0.value;
    opener.document.pr63_paper_form.incident_name.value = document.inputForm1.inputField1.value;
    self.close();
    return false;
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}
//--></script>";

echo "<html><table>";

$sql="SELECT * from incident 
where (right(`incident_code`,4)='0000' OR right(`incident_code`,4)='00XX')
order by incident_code";
$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysql_fetch_array($result))
	{
	$ic_array[$row['incident_code']]=$row['incident_desc'];
	}
//print_r($ic_array); //exit;

echo "<tr><td colspan='3'>Incident Codes: <select name='incident_code' onChange=\"MM_jumpMenu('parent',this,0)\"><option value=''></option>";         
        foreach($ic_array as $k=>$v)
		{
		if($k==$incident_code)
			{$s="selected";}else{$s="value";}
		echo "<option $s='incident_paper.php?incident_code=$k'>$k - $v\n";
		}
echo "</select></td></tr>";

$sql1 = "SELECT * from xx_legend
WHERE 1"; 
$result = mysql_query($sql1) or die ("Couldn't execute query. $sql1");
while ($row=mysql_fetch_array($result))
	{
	if($row['b']=="INJURIES" OR $row['b']=="ILLNESS"){continue;}
	$legend_array[$row['a']]=$row['b'];
	}
//echo "<pre>"; print_r($legend_array); echo "</pre>"; // exit;
$show=array("250000","310000","320000","060000");

if($incident_code)
	{
	$ic=substr($incident_code,0,2);
	$sql1 = "SELECT * from incident
	WHERE incident_code like '$ic%'"; //echo "1 $sql1<br />";
	$result = mysql_query($sql1) or die ("Couldn't execute query. $sql1");
	while ($row=mysql_fetch_array($result))
		{
		$code_array[$row['incident_code']]=$row['incident_desc'];
		}
//echo "<pre>"; print_r($code_array); echo "</pre>"; // exit;
		foreach($code_array as $k=>$v)
			{
			if($k==$ic."0000" AND !in_array($k,$show)){$pass_desc=$v; continue;}
			if($k==$ic."00XX"){$pass_desc=$v; continue;}
			if(strpos($k,'XX')>0)
				{
				foreach($legend_array as $k_1=>$v_1)
					{
					$make_code=substr($k,0,4).$k_1;
					echo "<tr>
					<td><a href='incident_paper.php?incident_code=$incident_code&pass_code=$make_code&pass_desc=$v&pass_service=$v_1'>$make_code</a></td><td>$v</td><td>$k_1 $v_1</td>
					</tr>";
					}
				continue;
				}

			if(strpos($k,'2201')>-1)
				{
				if($k=="220100")
					{
					echo "<tr><td>$v</td><td></td><td></td></tr>";
					$pass_service=$v;
					continue;
					}
				echo "<tr>
				<td></td><td>$v</td><td><a href='incident_paper.php?incident_code=$incident_code&pass_code=$k&pass_desc=$v&pass_service_1=$pass_service'>$k</a></td>
					</tr>";
				continue;
				}

			if(strpos($k,'2202')>-1)
				{
				if($k=="220200")
					{
					echo "<tr><td>$v</td><td></td><td></td></tr>";
					$pass_service=$v;
					continue;
					}
				echo "<tr>
				<td></td><td>$v</td><td><a href='incident_paper.php?incident_code=$incident_code&pass_code=$k&pass_desc=$v&pass_service_2=$pass_service'>$k</a></td>
					</tr>";
				continue;
				}

			if(strpos($k,'2306')>-1)
				{
				if($k=="230600")
					{
					echo "<tr><td>$v</td><td></td><td></td></tr>";
					$pass_service=$v;
					continue;
					}
				echo "<tr>
				<td></td><td>$v</td><td><a href='incident_paper.php?incident_code=$incident_code&pass_code=$k&pass_desc=$v&pass_agency_6=$pass_service'>$k</a></td>
					</tr>";
				continue;
				}

			if(strpos($k,'2307')>-1)
				{
				if($k=="230700")
					{
					echo "<tr><td>$v</td><td></td><td></td></tr>";
					$pass_service=$v;
					continue;
					}
				echo "<tr>
				<td></td><td>$v</td><td><a href='incident_paper.php?incident_code=$incident_code&pass_code=$k&pass_desc=$v&pass_agency_7=$pass_service'>$k</a></td>
					</tr>";
				continue;
				}



			echo "<tr><td><a href='incident_paper.php?incident_code=$incident_code&pass_code=$k&pass_desc=$pass_desc'>$k</a></td><td>$v</td></tr>";
			}
	}

$note="";
//if(empty($_GET['pass_agency'])){$pass_service="";}
if($pass_code!="")
	{
	if(strpos($incident_code,'XX')<1)
		{
		$sql1 = "SELECT * from incident
		WHERE incident_code = '$pass_code'";
		$result = mysql_query($sql1) or die ("Couldn't execute query. $sql1");
		$row=mysql_fetch_array($result); extract($row);
		$pass_incident_desc=$incident_desc;
		if(substr($incident_code,0,2)=="26")
			{
			$note="<font color='red'>Note: If SAR incident results in a fatality, then use 240000 series codes as the most harmful event.  </font>";
			}
		}
	if(strpos($incident_code,'XX')>0)
		{
		$note="<font color='red'>Note: In the event of a fatality use 240000 series codes.</font>";
		$sql1 = "SELECT incident_desc from incident
		WHERE incident_code = '$incident_code'"; //echo "$sql1<br />";
		$result = mysql_query($sql1) or die ("Couldn't execute query. $sql1");
		$row=mysql_fetch_array($result); 
		extract($row);
		$var_legend=substr($pass_code,4,2);
		
		$sql1 = "SELECT b from xx_legend
		WHERE a = '$var_legend'";  //echo "$sql1<br />t $pass_incident_desc";
		$result = mysql_query($sql1) or die ("Couldn't execute query. $sql1");
		$row=mysql_fetch_array($result); extract($row);
		$incident_desc=$pass_incident_desc." - ".$b;
		$incident_code=$pass_code;
		}
	
	$i=0;
	$row=mysql_fetch_array($result);
	extract($row);
	$incident_desc=$pass_desc." - ".$incident_desc;

	if(!empty($pass_service_1)){$incident_desc=$pass_desc." ".$pass_service_1." ".$pass_incident_desc;}
	if(!empty($pass_service_2)){$incident_desc=$pass_desc." ".$pass_service_2." ".$pass_incident_desc;}

	if(!empty($pass_agency_6)){$incident_desc=$pass_desc." - ".$pass_agency_6." (".$pass_incident_desc.")";}
	if(!empty($pass_agency_7)){$incident_desc=$pass_desc." - ".$pass_agency_7." (".$pass_incident_desc.")";}

	
	echo "<form name=\"inputForm1\" onSubmit=\"return setForm();\">";
	echo "<table border='1'><tr><th>Incident Code</th><th>Incident Description</th><th>$pass_code</th></tr>";
	echo "<tr>
	<td align='center'><input name='inputField0' type='text' value=\"$incident_code\" size='7' READONLY></td>
	<td align='center'><input name='inputField1' type='text' value=\"$incident_desc\" size='80' READONLY>
	<td bgcolor='green'><input type='submit' value='Update PR-63 Code Sheet'></form></td></tr>
	</form>";

	if(!empty($note)){echo "<table border='1'><tr><th>$note</th></tr>";}

	echo "</table>";
	
	}

?>
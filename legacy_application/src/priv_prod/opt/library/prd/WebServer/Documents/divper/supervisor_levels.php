<?php
ini_set('display_errors',1);
session_start();
if(@$_SESSION['divper']['level']<0){exit;}
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
if(@$_SESSION['logname']=="Cook0058"){echo "Access not allowed.";exit;}
if(@$_SESSION['divper']['level']<2)
	{
	$exp=explode(" ", $_SESSION['position']);
	$check=$exp[0]." ".$exp[1];
	if($check!="Park Superintendent" and $check!="Office Assistant")
		{exit;}
	if(empty($_POST['park_code']))
		{
		$park_ck=$_SESSION['divper']['select'];
		if($park_ck=="MOJE"){$park_ck="NERI";}
		$_POST['park_code']=$park_ck;
		}
	}
$db="divper";
include("../../include/iConnect.inc"); // database connection parameters

//echo "c=$check<pre>"; print_r($_SESSION); echo "</pre>"; // exit; 

mysqli_select_db($connection,$db);
include("menu.php");

if(!empty($_SESSION['pass']))
	{$_POST['park_code']=$_SESSION['pass']; unset($_SESSION['pass']);}
	
extract($_POST);
if(!empty($_POST['submit']))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	$skip_post=array("park_code","supervisor_level","submit");
	foreach($_POST as $beacon_num=>$position_type)
		{
		if(in_array($beacon_num, $skip_post)){continue;}
		$string=$position_type."='$beacon_num', ";
		$string.="park_code='".$_POST['park_code']."', ";
		$string.="unique_fld='".$_POST['park_code'].$beacon_num."'";
			$query="REPLACE supervisor_chart SET $string";
			$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query ".mysqli_error($connection));
		if($position_type=="non_sup")
			{
			$query="DELETE FROM supervised_list WHERE key_field='$beacon_num'";
			$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query ".mysqli_error($connection));
			}
		}
	}

$sql = "SELECT distinct park from position
	order by park"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		IF($row['park']=="MOJE"){continue;}
		$park_array[]=$row['park'];
		}
if(@$_SESSION['divper']['level']<2)
	{
	$park_array=array($park_ck);
	}	

// ******** Enter your SELECT statement here **********

if(!empty($_GET))
	{
	extract($_GET);
	include("supervisor_levels_get.php");
	}

if(!empty($park_code))
	{
	$var_park_code="t1.park='$park_code'";
	if($park_code=="NERI")
		{$var_park_code="(t1.park='NERI' or t1.park='MOJE')";}
	$sql = "SELECT t1.posTitle, t1.park, t1.beacon_num, t3.Fname, t3.Lname
	From position as t1
	left join emplist as t2 on t2.beacon_num=t1.beacon_num
	left join empinfo as t3 on t2.emid=t3.emid
	where 1 and $var_park_code
	order by t3.Lname, t3.Fname"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
	
	$var_park_code="t1.park_code='$park_code'";
	if($park_code=="NERI")
		{$var_park_code="(t1.park_code='NERI' or t1.park_code='MOJE')";}
	$sql = "SELECT t1.*, t4.Fname, t4.Lname
	From supervisor_chart as t1
	left join position as t2 on t2.beacon_num=concat(t1.superintendent,t1.primary_sup,t1.secondary_sup,t1.non_sup)
	left join emplist as t3 on t2.beacon_num=t3.beacon_num
	left join empinfo as t4 on t3.emid=t4.emid
	where 1 and $var_park_code
	order by t4.Lname, t4.Fname";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		extract($row);
		$get_beacon_num=substr($row['unique_fld'], 4);
		$sum_array[$get_beacon_num]=$row;
		if(!empty($superintendent))
			{
			$superintendent_array[]="<b>".$Fname." ".$Lname."</b> - <a href='supervisor_levels.php?superintendent=$superintendent'>$superintendent</a>";
			}
		if(!empty($primary_sup))
			{
			$primary_sup_array[]="<b>".$Fname." ".$Lname."</b> - <a href='supervisor_levels.php?primary_sup=$primary_sup'>$primary_sup</a>";
			}
		if(!empty($secondary_sup))
			{
			$secondary_sup_array[]="<b>".$Fname." ".$Lname."</b> - <a href='supervisor_levels.php?secondary_sup=$secondary_sup'>$secondary_sup</a>";
			}
		if(!empty($non_sup))
			{
			if(empty($Lname))
				{$non_sup_array[]="Vacant - ".$non_sup;}
				else
				{$non_sup_array[]=$Fname." ".$Lname." - ".$non_sup;}
			
			//." - <a href='supervisor_levels.php?non_sup=$non_sup'>$non_sup</a>"
			}
		}
	}
	else
	{$ARRAY=array();}
	
//	echo "<pre>"; print_r($sum_array); echo "</pre>"; // exit;
?>
<style type="text/css">
    div { padding: 3px; border: 1px solid black; }
    .park_list { background-color: #c0c0c0; padding: 0; color: #335500; }
    .super { background-color: white; padding: 0; color: black; }
    .primary { background-color: white; padding: 0; color: black; }
    .secondary { background-color: white; padding: 0; color: black; }
    .non_sup { background-color: white; padding: 0; color: black; }
</style>

<?php
// Display
$level_array=array("superintendent","primary_sup","secondary_sup","non_sup");
$c=count($ARRAY);
echo "<div class=\"park_list\" style=\"position: relative; width: 1124px; \">
<table><tr><td><form method='POST' action='supervisor_levels.php'>
<select name='park_code' onchange=\"this.form.submit()\"><option value=''></option>\n";
foreach($park_array as $k=>$v)
	{
	if($v==$park_code){$s="selected";}else{$s="";}
	echo "<option value=\"$v\" $s>$v</option>\n";
	}
echo "</select></form></td><td>($c employees)</td>
<td>On this form indicate FOR EACH employee whether they are the PASU, a Primary, a Secondary, or a non-Supervisor.</td>";
echo "</tr></table>";

//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
//echo "<pre>"; print_r($sum_array); echo "</pre>"; // exit;
if(empty($sum_array)){$sum_array=array();}
echo "<form method='POST' action='supervisor_levels.php'><table>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			echo "<th>$fld</th>";
			}
		echo "<th>Level</th>";
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if($fld=="Lname")
			{
			foreach($level_array as $k=>$v)
				{
				$beacon_num=$array['beacon_num'];
				
				if(!array_key_exists($beacon_num, $sum_array))
					{
					$value="<font color='red'>$value</font>";
					$missing_value[$beacon_num]="missing";
					}
				}
			}
		echo "<td>$value</td>";
		}
	echo "<td>";
	foreach($level_array as $k=>$v)
		{
		$beacon_num=$array['beacon_num'];
		if(!empty($sum_array[$beacon_num][$v]))
			{$ck="checked";}else{$ck="";}
		$fld_name=$beacon_num;
		echo "<input type='radio' name='$fld_name' value=\"".$v."\" $ck>".$v." \n";
		}
	echo "</td>";
	echo "</tr>";
	}
if(!empty($park_code))
	{
	if(!isset($supervisor)){$supervisor="";}
	echo "<tr><td colspan='6' align='center'>
	<input type='hidden' name='park_code' value=\"$park_code\">
	<input type='hidden' name='supervisor_level' value=\"$supervisor\">
	<input type='submit' name='submit' value=\"Submit\">
	</td></tr>";
	}

if(empty($missing_value))
	{
	if(!empty($park_code)){$rep=$park_code;}else{$rep="All";}
	echo "<tr><td>Excel <a href='supervisor_export.php?rep=$rep'>export</a> $rep</td></tr>";
	}
echo "</table></form></div>";

	
$num_rows=0;
if(!empty($superintendent_array))
	{
	echo "<div class=\"super\" style=\"position: relative; width: 228px; \">Superintendent<br /><font size='-2'>click link to add supervised employee(s)</font>";
	echo "<table>";
	foreach($superintendent_array as $k=>$v)
		{
		echo "<tr><td>$v</td></tr>";
		}
	$exp=explode("=",$v); $var=explode(">",$exp[2]);
	$key_field=rtrim($var[0],"'");
	$sql="SELECT t1.*, concat(t4.Lname, ', ', t4.Fname) as name
	FROM `supervised_list` as t1 
	left join emplist as t3 on concat(t1.primary_sup, t1.secondary_sup, t1.non_sup)=t3.beacon_num
	left join empinfo as t4 on t3.emid=t4.emid
	where key_field='$key_field'
	order by name"; //echo "$sql";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	$num_rows=mysqli_num_rows($result);
	while($row=mysqli_fetch_assoc($result)){$show_sup_array[]=$row;}
	//echo "<pre>"; print_r($show_sup_array); echo "</pre>"; // exit;
	if(!empty($show_sup_array))
		{
		foreach($show_sup_array as $k=>$array)
			{
			extract($array);
			if(empty($name)){$name="<font color='brown'>vacant</font>";}
			echo "<tr><td>$primary_sup $secondary_sup $non_sup $name</td></tr>";}
		}
	echo "</table>";
	}
echo "</div>";

if(!empty($primary_sup_array))
	{
	$top=-($num_rows*30)."px";
	echo "<div class=\"primary\" style=\"position: relative; top: $top; left: 250px; width: 278px; \">Primary Supervisor<br /><font size='-2'>click link to add supervised employee(s)</font>";
//	echo "<pre>"; print_r($primary_sup_array); echo "</pre>";  exit;
	echo "<table>";
	foreach($primary_sup_array as $k=>$v)
		{
		echo "<tr><td>$v</td></tr>";
	$exp=explode("=",$v); $var=explode(">",$exp[2]);
	$key_field=rtrim($var[0],"'");
	unset($show_sup_array);
	$sql="SELECT t1.*, concat(t4.Lname, ', ', t4.Fname) as name
	FROM `supervised_list` as t1 
	left join emplist as t3 on concat(t1.primary_sup, t1.secondary_sup, t1.non_sup)=t3.beacon_num
	left join empinfo as t4 on t3.emid=t4.emid
	where key_field='$key_field'
	order by name"; //echo "$sql<br />";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	$num_rows+=mysqli_num_rows($result);
	while($row=mysqli_fetch_assoc($result)){$show_sup_array[]=$row;}
		if(!empty($show_sup_array))
			{
			foreach($show_sup_array as $k=>$v)
				{
				extract($v);
				if(empty($name)){$name="<font color='brown'>vacant</font>";}
				echo "<tr><td>$primary_sup $secondary_sup $non_sup $name</td></tr>";}
			}
		}
	echo "</table>";
	}
echo "</div>";

if(!empty($secondary_sup_array))
	{
if($num_rows>1)
	{$top=-($num_rows*27)."px";}else{$top="-270px";}
echo "<div class=\"secondary\" style=\"position: relative; top: $top; left: 555px; width: 200px; \">Secondary Supervisor<br /><font size='-2'>click link to add supervised employee(s)</font>";
	echo "<table>";
	foreach($secondary_sup_array as $k=>$v)
		{
		echo "<tr><td>$v</td></tr>";
	$exp=explode("=",$v); $var=explode(">",$exp[2]);
	$key_field=rtrim($var[0],"'");
	unset($show_sup_array);
	$sql="SELECT t1.*, concat(t4.Lname, ', ', t4.Fname) as name
	FROM `supervised_list` as t1 
	left join emplist as t3 on concat(t1.primary_sup, t1.secondary_sup, t1.non_sup)=t3.beacon_num
	left join empinfo as t4 on t3.emid=t4.emid
	where key_field='$key_field'
	order by name"; //echo "$sql<br />";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	$num_rows+=mysqli_num_rows($result);
	while($row=mysqli_fetch_assoc($result)){$show_sup_array[]=$row;}
		if(!empty($show_sup_array))
			{
			foreach($show_sup_array as $k=>$v)
				{
				extract($v);
				if(empty($name)){$name="<font color='brown'>vacant</font>";}
				echo "<tr><td>$primary_sup $secondary_sup $non_sup $name</td></tr>";}
			}
		}
	echo "</table>";
	}
echo "</div>";

if(!empty($non_sup_array))
	{
	if($num_rows>1)
		{$top=-($num_rows*32)."px";}else{$top="-20px";}
	echo "<div class=\"non_sup\" style=\"position: relative; top:$top; left: 777px; width: 300px; \">Non-Supervisory Position";
	echo "<table>";
	foreach($non_sup_array as $k=>$v)
		{
		echo "<tr><td>$v</td></tr>";
		}
	echo "</table>";
	}
echo "</div>";
?>
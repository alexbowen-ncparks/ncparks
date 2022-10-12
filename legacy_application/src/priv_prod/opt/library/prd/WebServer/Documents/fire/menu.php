<?php
$title="Fire Management Database";
$add_cal=1;
include("_base_top_fire.php");
ini_set('display_errors',1);
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  //exit;
// extract($_REQUEST);

$database="fire";
@$level=$_SESSION['fire']['level'];
@$tempID=$_SESSION['fire']['tempID'];
@$emid=$_SESSION['fire']['emid'];
date_default_timezone_set('America/New_York');


include("../../include/iConnect.inc");
include("../../include/get_parkcodes_dist.php");
mysqli_select_db($connection,'fire');

if($level<1)
	{
	echo "You do not have access to this database."; exit;
	}
	
// action_review added th_20220226
$menu_array_1=array("Burn Units & Prescriptions"=>"/fire/units.php", "Burn History"=>"/fire/burn_history.php","Search Burn History"=>"/fire/search.php","Action Review"=>"/fire/action_review.php");

$menu_array=$menu_array_1;

if($level>3)
	{
// 	$menu_array_3=array("------------"=>"","Fireline Prep"=>"/fire/fireline_prep.php");
	$menu_array_3=array("------------"=>"","Project Tracking"=>"/fire/contracts.php");
	$menu_array_3['IQS Data']="/training/data_iqs.php";
	$menu_array=array_merge($menu_array_1,$menu_array_3);
	}

if($level>4)
	{
	$menu_array_4=array("------------"=>"","Fireline Prep"=>"/fire/fireline_prep.php","After Action Reports"=>"/fire/after_action.php");
	$menu_array=array_merge($menu_array,$menu_array_4);
	}


$calling_file=$_SERVER['PHP_SELF'];
if($calling_file=="/fire/contracts_form.php"){$calling_file=="/fire/contracts.php";}

$file_array=array("/fire/contracts.php","/fire/units.php","/fire/burn_history.php","/fire/fireline_prep.php","/fire/search.php","/fire/contracts.php","/fire/contracts_form.php");

echo "<table>
<tr><td align='center' colspan='2'><font color='gray' size='+1'>Welcome to the NC State Parks System <font color='red'>Fire Management</font> Database - <a href='https://10.35.152.9/efile/file_uploads/2020/2333_Fire-Management-Guidelines-7-10-2020.pdf' target='_blank'>FM Guidelines</a></td></font></tr>
<tr><td align='center' colspan='2'><font color='gray' size='+1'>Welcome to the NC State Parks System <font color='red'>Fire Management</font> Database - <a href='https://10.35.152.9/efile/file_uploads/2020/2333_Fire-Management-Guidelines-7-10-2020.pdf' target='_blank'>FM Guidelines</a></td></font></tr>

<tr><td><form><select name='file' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''>Select a Function:</option>";
foreach($menu_array as $item=>$file)
	{
	if($calling_file==$file){$s="selected";}else{$s="";}
	echo "<option value='$file' $s>$item</option>";
	}
echo "</select></form></td>";

$location=$_SESSION['fire']['select'];
if($location=="SOMO")
	{$_SESSION['fire']['accessPark']="BOCR,SOMO";}

if(in_array($calling_file,$menu_array) )
	{
	if($level==1)
		{
		$fire_park[]=$location;
		}
		
	if(!empty($_SESSION['fire']['accessPark']) AND $level==1)
		{
		unset($fire_park);
		$var=explode(",",$_SESSION['fire']['accessPark']);
		foreach($var as $k=>$v)
			{
			$fire_park[]=$v;
			}
/* 2022-02-28: CCOOPER (thoward) - Adding HARO and SARU to Windsor's access for fire only, without giving him everything for the parks. When using the database access setting screen (adding to "list of Parks to view") or entering his beacin id in fire.php, he would have access to all database applications for all parks listed. */
		if($_SESSION['fire']['tempID']=="Windsor6679")
			{
			$fire_park[]="HARO";
			$fire_park[]="SARU";
			}
/* 2022-02-28 End CCOOPER (thoward)  */
// 		echo "<pre>"; print_r($fire_park); echo "</pre>";
		}
		
	if($level==2)
		{
		$dist_array=${"array".$location};
		foreach($dist_array as $k=>$v)
			{
			$fire_park[]=$v;
			}
		}
	
	if($level>2)
		{
		$fire_park=$parkCode;
		}

if($calling_file!="/fire/search.php")
	{
	if($calling_file=="/fire/burn_history.php")
		{
		unset($fire_park);
		$sql="SELECT distinct park_code
		from units
		where 1
		order by park_code";
// 	echo "$sql";
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ");
		while($row=mysqli_fetch_assoc($result))
			{
			$fire_park[]=$row['park_code'];
			}
		}
	echo "<td><form><select name='file' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''>Select a Park:</option>";
	foreach($fire_park as $k=>$v)
		{
		if(@$park_code==$v){$s="selected";}else{$s="";}
		echo "<option value='$calling_file?park_code=$v' $s>$v</option>\n";
		}
	echo "</select></form></td>";
	
	if($calling_file=="/fire/contracts.php")
		{
		if(!empty($park_code)){echo "<td><a href='contracts.php'>Reset</a></td>";}
		}
	}

}
if(empty($park_code)){$park_code="";}
if($calling_file=="/fire/contracts_form.php")
		{
		if(!empty($park_code))
			{
			
			echo "<td style='text-align:center'><form action='contracts.php'>
			<input type='hidden' name='park_code' value=\"$park_code\">
	<input type='submit' name='submit' value='Show All $park_code' style=\"color:#009900; font-size: 16px;\"></form></td>";
			}
		}	
echo "<td><form action='https://auth1.dpr.ncparks.gov/photos/fire_gallery.php' target='_blank'>
	<input type='submit' name='fire_gallery' value='Fire Gallery'></form></td>";


echo "</tr>";

echo "</table>";

?>
<?php
//header ("Pragma: no-cache"); 
//header ("Cache-Control: no-cache, must-revalidate, max_age=0"); 
//header ("Expires: 0");
include("menu.php");

//ini_set('display_errors',1);

if($level<1){echo "No access.";exit;}
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$beacon_num=$_SESSION['beacon_num'];
//echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;

$database="phone_bill";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database");
       
extract($_REQUEST);//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

// ******* Add raw upload file ************
// handled by addPhoneTXT_form.php


// ******* Get logs ********

//include('scan_dir.php');

$sql="SELECT * from phone_bill where 1 order by id desc";
$result=mysqli_query($connection,$sql);
while($row=mysqli_fetch_array($result))
	{
	$log_list[]=$row['bill_txt'];
	}


echo "<div align=\"center\">";

if(!empty($_SESSION['phone_bill']['accessPark']))
	{
	$park_array=explode(",",$_SESSION['phone_bill']['accessPark']);
	if(!empty($_GET['park_code']))
		{$_SESSION['phone_bill']['select']=$_GET['park_code'];}
	echo "<form><table><tr><td>Select Park: <select onChange=\"MM_jumpMenu('parent',this,0)\">
<option selected></option>";
foreach($park_array as $k=>$v)
		{
		if($v==$_SESSION['phone_bill']['select']){$s="selected";}else{$s="value";}
		echo "<option $s='phone_parse.php?park_code=$v'>$v</option>";
		}
	echo "</select></form>";
	}


echo "<form><table><tr><td><select name=\"open_file\" onChange=\"MM_jumpMenu('parent',this,0)\">
<option selected>Phone Logs</option>";

foreach($log_list as $k=>$v)
	{
		if($level==1)
		{
		$park=$_SESSION['phone_bill']['select'];
		echo "<option value='phone_center.php?open_file=$v&parkcode=$park'>$v\n";
		}
			else
				{
				$park="";
// 				if($_SESSION['beacon_num']=="60033012"){$park="WARE";}
				if($level<6)
					{
					echo "<option value='phone_center.php?open_file=$v&parkcode=$park'>$v\n";
					}
					else
					{
					echo "<option value='phone_parse.php?open_file=$v'>$v\n";
					}
				}
	}
   echo "</select></td>";
   
   if($level>4 OR $beacon_num=="60032781" )// budget officer
   	{
   	echo "Link to add alt_phone numbers: <a href='add_alt_phone.php'>here</a>";
   	}
   
   
echo "</tr></table></form>";

if(!isset($open_file)){exit;}


//$open_file="phone_large.TXT";
$fo=fopen($open_file,'r');
$bill_txt = fread($fo, filesize($open_file));
fclose($fo);

echo "$bill_txt";

exit;

$ex_sum=explode(": Bill Number    ",$bill_txt);
$c=count($ex_sum);

$gp=explode("Period ending - ",$ex_sum[0]);
$getPeriod=explode(":",$gp[1]);
$period_end=trim($getPeriod[0]);

foreach($ex_sum as $k=>$v){
		$bill_for=explode(" - ",$v);
		$billing[]=trim($bill_for[0]);
		}
		array_shift($billing);
		$phones=array_unique($billing);
		sort($phones);
		
//echo "<pre>"; print_r($phones); echo "</pre>";  exit;

	include("../../../include/get_parkcodes_reg.php");
	
// ******** Level 1 ***********
if($level==1 and $open_file==""){echo "Please select a report date.";exit;}
if($level==1 and $open_file!="" and $submit==""){
	$park=$_SESSION['divper']['select'];
	$park_name=strtoupper(substr($parkCodeName[$park],0,12));
		$park_name=str_replace("'","",$park_name); // needed for Jockey's Ridge
		
		include("exceptions.php");
		
	echo "Phone log for $link for period ending $period_end - $park_name";exit;
	}
	
// *********** Level 2 *************

if($level==2 and $open_file==""){echo "Please select a report date.";exit;}
if($level==2 and $open_file!="" and $submit==""){
	$park=$_SESSION['divper']['select'];
	$a="array";
	$parkArray=${$a.$park};
//	echo "<pre>"; print_r($parkArray); echo "</pre>";  exit;
	
		
		foreach($parkArray as $k=>$v)
			{
			if($v=="OCMO"){continue;}
			if($v=="HIGO"){continue;}
			if($v=="GRMO"){continue;}
			if($v=="SARU"){continue;}
			if($v=="BATR"){continue;}
			if($v=="BULA"){continue;}
			if($v=="CACR"){continue;}
			$no_wan="";
			$park_name=strtoupper(substr($parkCodeName[$v],0,12));
			$park_name=str_replace("'","",$park_name);
				
			include("exceptions.php");
			
			
		echo "Phone log for $link $no_wan $v for period ending $period_end.<br /><br />";
			  }
  		 

	exit;
	}


function cleanPhoneNumber($var){
		$var=str_replace(') ','-',$var);
		$var=str_replace(')','-',$var);
		$var=str_replace('.','-',$var);
		$var=str_replace('/','-',$var);
		$var=str_replace(' ','-',$var);
			if(strpos($var,"1-")===0){$var=substr_replace($var,'',0,2);}
		return $var;
		}
		
// ******** Enter your SELECT statement here **********
// Individually assigned numbers
$sql="SELECT t1.Fname,t1.Nname,t1.Lname, phone, work_cell
FROM divper.empinfo as t1
LEFT JOIN divper.emplist as t2 on t2.tempID=t1.tempID
where 1 and t2.tempID !=''"; //echo "$sql";
 $result = mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result)){
		if($row['phone']=="" AND $row['work_cell']==""){continue;}
			if($row['Nname']){$fName=$row['Nname'];}
				else{$fName=$row['Fname'];}
	if($row['phone']){
		$cleanPhone=str_replace('(','',$row['phone']);
			$cleanPhone=cleanPhoneNumber($cleanPhone);
		$cleanPhone=substr($cleanPhone,0,12);
		$phoneArray[$cleanPhone]=$row['Lname'].", ".$fName." - <font color='green'>land line</font>";}
		
	if($row['work_cell']){
		$cleanPhone=str_replace('(','',$row['work_cell']);
			$cleanPhone=cleanPhoneNumber($cleanPhone);
		$cleanPhone=substr($cleanPhone,0,12);
		$phoneArray[$cleanPhone]=$row['Lname'].", ".$fName." - <font color='orange'>work cell</font>";}
		
}

// park unit numbers
$sql="SELECT parkcode, ophone as phone_1, phone1 as phone_2, phone2 as phone_3, mphone, fax
FROM divper.dprunit 
where 1"; //echo "$sql";
 $result = mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result)){
		if($row['phone_1']==""){continue;}
		$tp="";
	if($row['phone_1']){
		$cleanPhone=str_replace('(','',$row['phone_1']);
			$cleanPhone=cleanPhoneNumber($cleanPhone);
		$cleanPhone=substr($cleanPhone,0,12);
		$phoneArray[$cleanPhone]=$row['parkcode']." - <font color='brown'>Office Phone 1</font>";}

	if($row['phone_2']){
		$cleanPhone=str_replace('(','',$row['phone_2']);
			$cleanPhone=cleanPhoneNumber($cleanPhone);
		$typePhone=substr($cleanPhone,12); if($typePhone){$tp=" - $typePhone";}
		$cleanPhone=substr($cleanPhone,0,12);
		$phoneArray[$cleanPhone]=$row['parkcode']." - <font color='brown'>Office Phone 2$tp</font>";}
		
	if($row['phone_3']){
		$cleanPhone=str_replace('(','',$row['phone_3']);
			$cleanPhone=cleanPhoneNumber($cleanPhone);
		$cleanPhone=substr($cleanPhone,0,12);
		$phoneArray[$cleanPhone]=$row['parkcode']." - <font color='brown'>Office Phone 3</font>";}
		
	if($row['mphone']){
		$cleanPhone=str_replace('(','',$row['mphone']);
			$cleanPhone=cleanPhoneNumber($cleanPhone);
		$cleanPhone=substr($cleanPhone,0,12);
		$phoneArray[$cleanPhone]=$row['parkcode']." - <font color='brown'>Park Mobile Phone</font>";}
		
	if($row['fax']){
		$cleanPhone=str_replace('(','',$row['fax']);
			$cleanPhone=cleanPhoneNumber($cleanPhone);
		$cleanPhone=substr($cleanPhone,0,12);
		$phoneArray[$cleanPhone]=$row['parkcode']." - <font color='brown'>Office Fax</font>";}
		
}
//echo "<pre>"; print_r($phoneArray); echo "</pre>"; exit;

// WAN lines
if(!$sort){$orderBy="order by location";}
$sql="SELECT * from wan_lines where 1 $orderBy";
 $result = mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result)){
		$cleanPhone=$row['wan_lines'];
		$phoneArray[$cleanPhone]=$row['location'];
		}
	
// Alternate lines
if(!$sort){$orderBy="order by location";}
$sql="SELECT * from alt_lines where 1 $orderBy";
 $result = mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result)){
		$cleanPhone=$row['alt_lines'];
		$phoneArray[$cleanPhone]=$row['location'];
		}
	
// phoneArray contains phones in tables wan_lines, dprunit and empinfo
//echo "<pre>Numbers in DPR tables: alt_lines, wan_lines, dprunit and empinfo "; //print_r($phoneArray); echo "</pre>";  exit;

// phones contains numbers coming from SIPS file
//echo "<pre>SIPS billable numbers "; print_r($phones); echo "</pre>";  exit;

echo "<table>";
echo "<tr><th>Sort by <a href='phone_parse.php?open_file=$open_file'>Name</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sort by Phone <a href='phone_parse.php?open_file=$open_file&sort=num'>Number</a></th></tr>";

if(!$sort){
// Assemble needed arrays
	foreach($phoneArray as $k=>$v){
		if(in_array($k,$phones))
			{$name_known[$k]=$v;}
			else
			{$name_unknown[$k]=$v;}
		}// end foreach
	//	echo "<pre>"; print_r($name_unknown); echo "</pre>";  exit;
	//	echo "<pre>"; print_r($name_known); echo "</pre>";  exit;
		asort($name_known);
// Display Known
	foreach($name_known as $phone_num=>$user){
		echo "<tr>";
		if($phone_num[0]=="S"){
		$park_name=$user;
		
		include("exceptions.php");
		
	$person_place="WAN Line for <a href=\"phone_summary.php?park_name=$park_name&billing_period=$period_end&open_file=$open_file\" target='_blank'>$user</a> <=Bill Summary and drilldowns";}
		else
		{$person_place=$user;}
		
		$check="<a href=\"phone_detail.php?phone_number=$phone_num&person=$person&billing_period=$period_end&open_file=$open_file\" target='_blank'>[ $phone_num ]</a> - $person_place";

	
echo "<td>$check</td></tr>";
		
		}// end foreach
		
// Display Unknown
echo "<tr><td>The following numbers do NOT show up in the SIPS phone log as billable numbers, only numbers to which calls were placed. Our folks have entered these numbers as OFFICIAL work numbers BUT they are not listed as such on the SIPS phone log.</td></tr>";
	foreach($name_unknown as $k=>$v){
	if($k=="NA" OR $k=="N-A" OR $k=="n-a"){$check=" - Either number unassigned OR person has failed to update their Contact Info in DPR Personnel database.";}
	//	if($k=="none"){continue;} // Deal with Luis Carrasco having put "none" for his work phone.
		echo "<tr>";
		
		$check="<a href=\"phone_detail.php?phone_number=$k&person=$person&billing_period=$period_end&open_file=$open_file\" target='_blank'>[ $k ]</a> - $v.";
	
echo "<td>$check</td></tr>";
		
		}// end foreach
}// end !$sort

//echo "<pre>"; print_r($name_known); print_r($name_unknown); echo "</pre>"; exit;

if($sort){
	foreach($phones as $k=>$v){// each row

		echo "<tr>";
		if($v[0]=="S"){
		$park_name=substr($phoneArray[$v],0,12);
		$park_name=str_replace("'","",$park_name); // needed for Jockey's Ridge
		
		include("exceptions.php");
		
	$person_place="<=WAN <a href=\"phone_summary.php?park_name=$park_name&billing_period=$period_end&open_file=$open_file\" target='_blank'>$phoneArray[$v]</a> <=Bill Summary and drilldowns";}
		else{
		$person_place="<font color='blue'>$phoneArray[$v]</font>";
		if($phoneArray[$v]==""){$person_place="Either number unassigned OR person has failed to update their Contact Info in DPR Personnel database.";}
		}
		
		$check="<a href=\"phone_detail.php?phone_number=$v&person=$person&billing_period=$period_end&open_file=$open_file\" target='_blank'>[ $v ]</a> - $person_place";

			if($level>4){$phoneArray[$v]=="" AND $check.="&nbsp;&nbsp;&nbsp;&nbsp;<a href='add_phone.php?pn=$v' target='_blank'>Add</a> to database.";}
	
echo "<td>$check</td></tr>";
	}
}

echo "</table></div></body></html>";

?>
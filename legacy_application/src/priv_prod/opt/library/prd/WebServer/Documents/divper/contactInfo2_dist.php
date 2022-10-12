<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);
extract($_REQUEST);
//echo "<pre>";print_r($_SESSION);echo "</pre>";
//print_r($_REQUEST);//exit;
$logemid=$_SESSION['logemid'];
$positionTitle=$_SESSION['position'];
$divperLevel=$_SESSION['divper']['level'];

/*
$sql = "SELECT * From dpr_sections order by order_by"; 
$result = mysqli_query($sql) or die ("Couldn't execute query2. $sql");
while($row=mysqli_fetch_array($result)){
$full_name[$row['code']]=$row['name'];
}
//print_r($full_name);exit;
*/

$sql = "SELECT date_format(max(updateOn),'%b %D, %Y @ %r') as maxDate From empinfo";
$result1 = mysqli_query($connection,$sql) or die ("Couldn't execute query2. $sql");
$row1=mysqli_fetch_array($result1);
extract($row1);

if(empty($rep))
	{
	echo "<html><head><STYLE TYPE=\"text/css\">
	<!--
	td
	{font-size:70%; vertical-align: top}
	th
	{font-size:80%; vertical-align: bottom}
	--> 
	</STYLE></head><body>";
	}

// CDL
$sql = "SELECT t1.beacon_num 
FROM divper.`position` as t1
where t1.cdl='y'
";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_cdl[]=$row['beacon_num'];
	}
	
IF($divperLevel>1)
	{
	$addFld=", empinfo.work_cell, empinfo.badge, empinfo.radio_call_number, empinfo.spouse, empinfo.spouse_contact";
	$addHeader="<th>Mobile</th><th>Badge</th><th>Radio</th><th>Emergency Contact Name</th><th>Emergency Contact Number</th>";
// 	$field_title="IF(position.working_title!='',concat(position.working_title,'<br />',position.beacon_title), concat(position.park,'-',position.posTitle)) as title,";
	$field_title="IF(position.working_title!='',position.working_title, concat(position.park,'-',position.posTitle)) as title,";
	}
	else
	{
	$addFld="";
	$addHeader="";
// 	$field_title="IF(position.working_title!='',position.working_title, concat(position.park,'-',position.posTitle)) as title,";
	$field_title="IF(position.working_title!='',position.working_title, concat(position.park,'-',position.posTitle)) as title,";
	}

if(@$rep=="excel")
	{
	if(@$type!="ARCH")
		{
		@$addFld2.=",concat(dprunit_district.add1,', ',dprunit_district.city,', ',dprunit_district.zip,', ',dprunit_district.county) as address";
		}
	$JOIN="
	LEFT JOIN dpr_system.dprunit_district on dpr_system.dprunit_district.parkcode=position.code";
	$field_title=" position.working_title, position.posTitle as title, position.program_code, ";
	}

if(!isset($addFld2)){$addFld2="";}
if(!isset($JOIN)){$JOIN="";}
if(!empty($type) AND $type!="ARCH")
	{$clause=" and dpr_sections.dist='$type'";}
	else
	{
	$clause="";
	if(@$type=="ARCH")
		{
		$clause="and (dpr_sections.dist!='CORE' and dpr_sections.dist!='PIRE' and dpr_sections.dist!='MORE')";
		}
	}
/* 2022-05-04: CCOOPER - query for divper - 'personnel by section' fails - reason, the query references a 'dpr_sections' table, which does not exist; it is named 'drp_sections_dist'

*/
$sql = "SELECT 
IF(dpr_sections_dist.district!='',concat(dpr_sections_dist.name,' [',dpr_sections_dist.code,']'),dpr_sections_dist.name) as name,
$field_title
empinfo.Fname, empinfo.Nname, empinfo.Lname,
position.toggle,position.beacon_num,
empinfo.phone $addFld , empinfo.email,dpr_sections_dist.district $addFld2
From position 
LEFT JOIN emplist on position.beacon_num=emplist.beacon_num
LEFT JOIN empinfo on empinfo.emid=emplist.emid
LEFT JOIN dpr_sections_dist on dpr_sections_dist.code=position.code
$JOIN
WHERE position.beacon_num!='' $clause
order by position.o_chart,empinfo.Lname";
/* 2022-05-04: End CCOOPER  */

$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
$num=mysqli_num_rows($result);
//  echo "$sql"; //exit;

while ($row=mysqli_fetch_assoc($result))
	{
	if(in_array($row['beacon_num'],$ARRAY_cdl))
		{
		$row['cdl']="Y";
		}
		else
		{
		$row['cdl']="";
		}
	$a[$row['beacon_num']]=$row;
	}
// echo "<pre>";print_r($a);echo "</pre>";exit;


$header="<tr><th>&nbsp;</th><th>Section</th><th>Section Lead</th><th>First Name</th><th>Last Name</th><th>Title</th><th>BEACON</th><th>Work</th>$addHeader<th>Email</th><th>District</th><th>CDL</th></tr>";

if(@$rep=="excel")
	{
	$ARRAY=$a;
	sort($a);
	$temp_array[]=array_keys($a[0]);
	foreach($temp_array[0] as $k=>$v)
		{
		if($v=="toggle")
			{$v="program head";}
		$new_array[]=$v;
		}
	$header_array[]=$new_array;
	header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=DPR_Personnel.csv");
	// Disable caching
	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
	header("Pragma: no-cache"); // HTTP 1.0
	header("Expires: 0"); // Proxies

	
	function outputCSV($header_array, $data) {
		$output = fopen("php://output", "w");
		foreach ($header_array as $row) {
			fputcsv($output, $row); // here you can change delimiter/enclosure
		}
		foreach ($data as $row) {
			fputcsv($output, $row); // here you can change delimiter/enclosure
		}
		fclose($output);
	}

	outputCSV($header_array, $ARRAY);

	exit;
	}

if(!isset($type))
	{
	$type="";
	$rep="rep=excel";
	}
	else
	{
	$rep="rep=excel&type=$type";
	}
$region_array=array("ARCH","CORE","PIRE","MORE");
echo "<table width='600'><tr><td>$type Listing for $num DPR employees</td><td align='center'><A HREF=\"javascript:window.print()\">
<IMG SRC=\"../inc/bar_icon_print_2.gif\" BORDER=\"0\"</A></td><td align='right'>Updated on: $maxDate</td><td><a href='contactInfo1_reg.php?$rep' target='_blank'>Excel</a></td><td><form method='POST'>
<select name='type' onchange=\"this.form.submit()\"><option value=\"\" selected></option>";
foreach($region_array as $k=>$v)
	{
	echo "<option value=$v>$v</option>\n";
	}
echo "</select></form>
</td></tr></table><hr>

<table>$header";

$checkSub="";
foreach($a as $key=>$val)
	{
	if(@$bgc){$bgc="";}else{$bgc=" bgcolor=\"#f5f5f5\"";}
	echo "<tr$bgc><td bgcolor=\"#FFFFFF\"></td>";
	
	$pass="";
	foreach($val as $k=>$v)
		{
		$f1="";$f2="";
		$value=$v;
		if($k=="title")
			{
			if($a[$key]['toggle']!="x"){
			$pass=1;
			echo "<td>&nbsp;</td>";continue;}
			}
		
		if($k=="name")
			{
			if($a[$key]['name']==$checkSub){$value="";}else {$value=$a[$key]['name'];}
			}
		
		if($k=="Fname" and $v==""){$value="VACANT";}
		if($k=="Fname" and $a[$key]['Nname']!="")
			{
			$value=$a[$key]['Nname'];
			}
		
		if($k=="toggle")
			{
			if($pass!="")
				{
				$value=$a[$key]['title'];
				}
				else
				{$value="";}
			}
		
		if($k=="Nname"){continue;}
		
		if($k=="region" and $v==""){$value="ARCH";}

		if($k=="name")
			{
			$f1="<b>";$f2="</b>";
			$checkSub=$a[$key]['name'];
			}
		
		if(($k=="Fname" OR $k=="Lname") & $pass=="")
			{
			$f1="<b>";$f2="</b>";
			}
		
		if($k=="phone" OR $k=="Mphone" OR $k=="work_cell")
			{
			$cleanPhone=str_replace('(','',$value);
					$cleanPhone=str_replace(') ','-',$cleanPhone);
					$cleanPhone=str_replace(')','-',$cleanPhone);
					$cleanPhone=str_replace('.','-',$cleanPhone);
					$cleanPhone=str_replace(' ','-',$cleanPhone);
					$cleanPhone=str_replace('/','-',$cleanPhone);
					$value=substr($cleanPhone,0,12);
					if($k=="phone"){$f1="<b>";$f2="</b>";}
			}
				
		echo "<td>$f1$value$f2</td>";
		}
	
	echo "</tr>";
	}// end foreach

?>
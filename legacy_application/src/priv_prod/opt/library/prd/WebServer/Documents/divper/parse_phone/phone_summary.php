<?php 
extract($_REQUEST);
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$level=$_SESSION['divper']['level'];


// *** $open_file="feb09.TXT";
$fo=fopen($open_file,'r');
$bill_txt = fread($fo, filesize($open_file));
fclose($fo);

	$truncate_park_name=substr($park_name,0,29); // max for some SIPS WAN names
$exp=explode($truncate_park_name,$bill_txt);
	$countExp=count($exp); //echo "c=$countExp"; //exit;
	
$var=explode("Employee Summary",$exp[0]);
// *** get last item in array
	$count=count($var)-1; //echo "c=$count";
// *** get WAN 
	//$rev_var=array_reverse($var);
	$WAN=$var[$count];

	//$WAN=$var[0];
	echo "<pre>"; print_r($WAN); echo "Wide Area Network (WAN)</pre>";  //exit;

// *** $exp[1] contains phone numbers and charges

// *** truncate to get only info for $park_name
	$sum=explode(": Total",$exp[1]);
	echo "<pre>: $park_name"; print_r($sum[0]);echo "</pre>";  

// *** reattach Totals
	$totals=explode("+----------",$sum[1]);
	echo "<pre>: Total";  print_r($totals[0]); echo "</pre>"; // exit;
	$dept=explode("- DENR PARKS & RECREATION",$totals[1]);
	echo "<pre>";  print_r($dept[0]); echo "</pre>"; // exit;
	$dept_code=explode("Department",$dept[0]);
	$dept_code=trim($dept_code[1]); 

// *** Extract all phone numbers to create links
	//echo "<pre>: $park_name"; print_r($sum[0]);echo "</pre>";  

$test=explode(":\r",$sum[0]);
foreach($test as $k=>$v){
	$cell[]=explode(" - ",$v);
	$temp=explode(": ",$cell[$k][0]);
	$trim=substr(trim($temp[1]),0,12);
	if(ereg("([0-9]{3})-([0-9]{3})-([0-9]{4})",$trim)){
	$number[$k]=$trim;}
	}
	
	$phone_list=array_unique($number);
//echo"<pre>p=";print_r($phone_list);echo"</pre>"; // exit;
	
// Match numbers with names

if($_SESSION['position']=="Park Superintendent"){$level=2;}
if($level==1){
	$tempID=$_SESSION['logname'];
	$where=" and t2.tempID='$tempID'";
	}

$database="phone_bill";
include("../../../include/connectROOT.inc"); //echo "c=$connection";
// Mobile phones
$sql="SELECT t1.Fname,t1.Lname, work_cell as Mphone
FROM divper.empinfo as t1
LEFT JOIN divper.emplist as t2 on t2.tempID=t1.tempID
where 1 and t2.tempID !=''
$where"; //echo "$sql";
 $result = MYSQL_QUERY($sql,$connection);
while($row=mysql_fetch_assoc($result)){
		if($row['Mphone']==""){continue;}
		$cleanPhone=str_replace('(','',$row['Mphone']);
		$cleanPhone=str_replace(') ','-',$cleanPhone);
		$cleanPhone=str_replace(')','-',$cleanPhone);
		$cleanPhone=str_replace('.','-',$cleanPhone);
		$cleanPhone=str_replace('/','-',$cleanPhone);
		$cleanPhone=str_replace(' ','-',$cleanPhone);
		$cleanPhone=substr($cleanPhone,0,12);
		$phoneArray[$cleanPhone]=$row['Fname']." ".$row['Lname'];
		}

// right(t1.phone,8) as 
// Land line phones
$sql="SELECT t1.Fname,t1.Lname, phone as Mphone
FROM divper.empinfo as t1
LEFT JOIN divper.emplist as t2 on t2.tempID=t1.tempID
where 1 and t2.tempID !=''
$where";
 $result = MYSQL_QUERY($sql,$connection);
while($row=mysql_fetch_assoc($result)){
		if($row['Mphone']==""){continue;}
		$cleanPhone=str_replace('(','',$row['Mphone']);
		$cleanPhone=str_replace(') ','-',$cleanPhone);
		$cleanPhone=str_replace(')','-',$cleanPhone);
		$cleanPhone=str_replace('.','-',$cleanPhone);
		$cleanPhone=str_replace('/','-',$cleanPhone);
		$cleanPhone=str_replace(' ','-',$cleanPhone);
		$cleanPhone=substr($cleanPhone,0,12);
		$phoneArray[$cleanPhone]=$row['Fname']." ".$row['Lname'];
		}
$flipArray=array_keys($phoneArray);

//echo "<pre>"; print_r($flipArray); echo "</pre>";  exit;
//echo "<pre>"; print_r($phone_list); echo "</pre>";  //exit;

if($_SESSION['position']=="Park Superintendent"){$level=2;}

foreach($phone_list as $k=>$v){
		if(in_array($v,$flipArray)){
			echo "$v - <a href=\"phone_detail.php?phone_number=$v&person=$phoneArray[$v]&billing_period=$billing_period&open_file=$open_file&dept_code=$dept_code\" target='_blank'>$phoneArray[$v]</a><br /><br />";
			}
			else
			{			
				if($level>1){echo "<a href=\"phone_detail.php?phone_number=$v&person=$phoneArray[$v]&billing_period=$billing_period&open_file=$open_file&dept_code=$dept_code\" target='_blank'>$v</a> - Name (or use) not in the database. <a href='add_phone.php?pn=$v' target='_blank'>Add</a> to database.<br /><br />";}
				}
		}
	
?>
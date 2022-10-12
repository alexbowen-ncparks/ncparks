<?php 
extract($_REQUEST);

if($phone_number==""){


include("../menu.php");

/*
// get all active RCCs
include("../../../include/connectBUDGET.inc");
$sql="SELECT  center, upper(code) as parkcode
FROM  `budget`.`center` as
FROM  `budget`.`center` as
WHERE 1  AND  `rcc`  !=  '' AND fund =  '1280' AND actcenteryn =  'y'
ORDER  BY  `parkcode`  ASC ";

$result=mysql_query($sql);
while($row=mysql_fetch_array($result))
		{$center_array[$row['parkcode']]=$row['center'];}
//echo "<pre>"; print_r($center_array); echo "</pre>";  exit;
*/

if($parkcode){
// get all phones for a parkcode
$database="divper";
include("../../../include/connectROOT.inc"); //echo "c=$connection";

// Mobile phones
	if($parkcode){$where="and t3.code='$parkcode'";}
	
$sql="SELECT t3.code as currPark, work_cell as Mphone, t1.Lname
FROM divper.empinfo as t1
LEFT JOIN divper.emplist as t2 on t2.tempID=t1.tempID
LEFT JOIN divper.position as t3 on t2.beacon_num=t3.beacon_num
where 1 and t2.tempID !='' and t1.work_cell !=''
$where
order by t1.Lname"; //echo "$sql";
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
		$index=$cleanPhone."=cell ".$row['Lname'];
		$phoneArray[$index]=$row['currPark'];
		}
		
// Land line phones for individuals
$sql="SELECT t3.code as currPark, phone as Mphone, t1.Lname
FROM divper.empinfo as t1
LEFT JOIN divper.emplist as t2 on t2.tempID=t1.tempID
LEFT JOIN divper.position as t3 on t2.beacon_num=t3.beacon_num
where 1 and t2.tempID !=''
$where
order by t1.Lname";
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
		$index=$cleanPhone."=land ".$row['Lname'];
		$phoneArray[$index]=$row['currPark'];
		}
			
// Office phones
$sql="SELECT ophone as phone0, phone1, phone2, mphone as phone3, fax
FROM divper.dprunit where parkcode='$parkcode'"; //echo "$sql";
 $result = MYSQL_QUERY($sql,$connection);
while($row=mysql_fetch_assoc($result)){
	foreach($row as $k=>$v){
			if($v==""){continue;}
		$cleanPhone=str_replace('(','',$v);
		$cleanPhone=str_replace(') ','-',$cleanPhone);
		$cleanPhone=str_replace(')','-',$cleanPhone);
		$cleanPhone=str_replace('.','-',$cleanPhone);
		$cleanPhone=str_replace('/','-',$cleanPhone);
		$cleanPhone=str_replace(' ','-',$cleanPhone);
		$cleanPhone=substr($cleanPhone,0,12);
		$index=$cleanPhone."=park ".$k;
		$phoneArray[$index]=$row['currPark'];
			}
		}
			
// "Other" phone lines
$database="phone_bill";
include("../../../include/connectROOT.inc"); //echo "c=$connection";

$sql="SELECT alt_lines as Mphone
FROM phone_bill.alt_lines as Mphone 
where location like '%$parkcode%'"; //echo "$sql";
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
		$phoneArray[$cleanPhone]=$parkcode;
		}
		
//echo "<pre>"; print_r($phoneArray); echo "</pre>";  exit;
	$unique=array_unique($phoneArray);
//echo "<pre>"; print_r($unique); echo "</pre>";  //exit;
}// end if $parkcode

// **********************
if($parkcode==""){

$database="divper";
include("../../../include/connectROOT.inc"); //echo "c=$connection";

// get all active RCCs
$sql="SELECT  distinct concat('1280',rcc) as center, upper(code) as parkcode
FROM  `divper`.`position` as t1
LEFT JOIN emplist as t2 on  t1.beacon_num=t2.beacon_num
WHERE  t2.currPark!=''
and code !=''
";

$result=mysql_query($sql);
while($row=mysql_fetch_array($result))
		{$center_array[$row['center']]=$row['parkcode'];}
		asort($center_array);
//echo "<pre>"; print_r($center_array); echo "</pre>";  exit;


echo "<table border='1'>";
foreach($center_array as $k=>$v){
	echo "<tr><td><a href='phone_center.php?open_file=$open_file&parkcode=$v' target='_blank'>$v $k</a></td></tr>";
	}
echo "</table>";
exit;
}// end $parkcode=''

echo "<table border='1'>";

	echo "<tr><td align='center'>$parkcode</td></tr>";
		foreach($phoneArray as $key=>$val){
		$pn=explode("=",$key);
			echo "<tr><td><a href='phone_center?open_file=$open_file&parkcode=$parkcode&phone_number=$pn[0]' target='_blank'>$key</a></td></tr>";
				}
echo "</table>";
}

if($phone_number=="" OR $open_file==""){exit;};

//$open_file="2009/may09.TXT";
$fo=fopen($open_file,'r');
$bill_txt = fread($fo, filesize($open_file));
fclose($fo);

//$phone_number="828-625-9945";

$thisPhone=$phone_number;
$dept_code="";
$billing_period="";
$person="";

//: Bill Number      919-218-1014
$ex1=explode(": Bill Number      $thisPhone",$bill_txt);// 6 spaces between
$count=count($ex1); //echo "c=$count";exit;
$j=2;

if($count<2){ // only 5 spaces between Bill Number and telephone number
	$j=1;
	$ex1=explode(": Bill Number     $thisPhone",$bill_txt);// 5 spaces betweeen
	$count=count($ex1); //echo "c=$count";exit;
	$ex2=explode("Report No TCS-711",$ex1[1]);
	$detail=$ex2[0];
	
	$thisPhone=$phone_number." ".$person." for the Period Ending $billing_period for Department Code: $dept_code";
	echo "$thisPhone<pre align='center'>"; 
		print_r($detail);
		echo "</pre>";  //exit;
		
	}

		
//echo "<pre>c=$count"; print_r($ex1[$j]); echo "</pre>";  exit;

	if(!$dept_code){
		$dept=explode("Department",$ex1[1]);
	$dept_code=explode("- DENR PARKS & RECREATION",$dept[1]);
	$dept_code=trim($dept_code[0]); 
		}
		
$thisPhone=$phone_number." ".$person." for the Period Ending $billing_period for Department Code: $dept_code";
echo "$thisPhone<pre>"; 
for($i=1;$i<$count-1;$i++){
print_r($ex1[$i]);
}

//echo "<pre>"; print_r($ex1[$count]); echo "</pre>"; // exit;

$count-=1;
$ex2=explode("Report No TCS-711",$ex1[$count]);
print_r($ex2[0]);
echo "</pre>"; 

// exit;


?>
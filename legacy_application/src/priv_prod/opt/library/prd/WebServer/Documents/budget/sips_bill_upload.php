<?php
//ini_set('display_errors',1);


session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$tempid=$_SESSION['budget']['tempID'];
$user_id=substr($tempid,0,-2);


include("../../include/iConnect.inc");// database connection parameters
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
//echo "line 6 <br />"; exit;
$database="budget";
  $db = mysqli_select_db($connection, $database)
       or die ("Couldn't select database");
mysqli_select_db($connection, $database);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
//NOTE A Start 
// When User first hits this page, $submit is '' which means next line is TRUE and Code will run. This Code shows the Form that allows all files (specified below in $file_array) to be displayed on Form & uploaded to budget/file_uploads DOCUMENT directory  
if(empty($submit))
	{

	echo "<html>
	<head>
	<title>Multiple file upload script</title>
	</head>
	<body>";
	
	
	
	echo "<table align='center'>";
	echo "<tr>";
	echo "<td>";
	echo "<b><font size='5'>(A) </font></b><font color='red'> Steps to Create CSV File</font>";
	
	echo "<li>select all text-Cntrl+A</li>";
	
	echo "<li>right click mouse</li>";
	
	echo "<li>select menu option export selection as</li>";
	
	echo "<li>select location to save to</li>";
	
	echo "<li>rename document accordingly</li>";
	
	echo "<li>then change document type to .csv</li>";

	echo "<li>save document as: <font color='red'>sips_phone_bill.csv</font></li>";
   
    echo "</td>";
	echo "</tr>";
	echo "</table>";
	
	
	
	
	
	
	
//$file_array=array("sips_phone_bill.txt");
$file_array=array("sips_phone_bill.csv");



	
	echo "<form method=post action=sips_bill_upload.php enctype='multipart/form-data'>";
	echo "<table border='0' width='400' cellspacing='0' cellpadding='15' align=center>";
	foreach($file_array as $k=>$v)
		{
//		$value="/Users/tomhoward/Documents/budget_trans/".$v; ??tony
		echo "<tr><td><b><font size='5'>(B) </font></b>
			<input type='file' name='file_upload[]' size='50'><br /><font size='5' color='red'>$v</font></td><th><b><font size='5'>(C) </font></b>Invoice_Number<input name='invoice_number' type='text' size='15'></th></tr>";
		}
	echo "<tr><td colspan=2 align=center><b><font size='5'>(D) </font></b><input type='submit' name='submit' value='Add Files'></td></tr>"; 

	echo "</form>";
echo "</table>";

	
	


	echo "</body></html>";
	}
//Note A End. 

//Note B Start
// Once User hits Button to Add Files, the form is submitted and $submit=Add. This means that the remaining Code below will run to the very end of PHP File
	
	
	else
	{
	//echo "<pre>"; print_r($_FILES); echo "</pre>";  exit; //brings back Array of Files Uploaded
	
// Delete any existing files so we are sure of uploading the most recent data	

//Note B1 Start	
// Gets rid of all Legitimate files in budget/file_uploads to allow NEW Files to be Uploaded into budget/file_uploads

$dir = "file_uploads";
$dh = opendir($dir);

//while statement below can be read as: Each File in directory budget/file_uploads is "read" & if file is a legitimate file (not a system file) then it is deleted via unlink
 
while (false !== ($filename = readdir($dh)))
	{
	if($filename!="."&&$filename!="..") // leave the system directory files
		{
		$uploadfile = $dir."/".$filename;
		unlink ($uploadfile);
		}
	}

//Note B1 End.
	
	$num=count($_FILES['file_upload']['name']); //counts the number of files uploaded

	for($i=0;$i<$num;$i++)
		{
		$file_name=$_FILES['file_upload']['name'][$i];
		$temp_name=$_FILES['file_upload']['tmp_name'][$i];
		if($temp_name==""){continue;} //to prevent problems if some Files on Form are not uploaded

		if(!is_uploaded_file($_FILES['file_upload']['tmp_name'][$i]))
			{
			exit;  //if file doesn't make it to budget/file_uploads then program will quit
			}
			
		$uploaddir = "file_uploads"; // make sure www has r/w permissions on this folder

		//    echo "$uploaddir"; exit;
		if (!file_exists($uploaddir)) {mkdir ($uploaddir, 0777);}

		$uploadfile = $uploaddir."/".$file_name;
		move_uploaded_file($temp_name,$uploadfile);// create file on server
		chmod($uploadfile,0777);
		}
		
$dir = "file_uploads";
$dh = opendir($dir);

//Note B2 Start
//while statement below can be read as: Each File in directory budget/file_uploads is "read" & and Array $files is populated with all legitimate files (not system files). Once Array $files has been fully populated, each of File Names are printed on Screen as verification that files were uploaded to budget/file_uploads

 while (false !== ($filename = readdir($dh)))
	 {
		if($filename!="."&&$filename!="..")
			{$files[] = $filename;}
	 }
echo "Files in the file_uploads directory <pre>"; print_r($files); echo "</pre>"; // exit;

//Note B2 End.
 
$path="/opt/library/prd/WebServer/Documents/budget/file_uploads";

//Note B3 Start
//foreach below walks thru $files Array (which has the Names of all files uploaded to budget/file_uploads) & determines the appropriated TABLE name by replacing .txt extension with '' Each TABLE is truncated and each TABLE is populated with contents of appropriate text file. Once each TABLE is populated a Select query is run to determine number of records in each TABLE & program echos back the number of records in each TABLE. 


foreach($files as $k=>$v)
	{
	$file=$path."/".$v;
 	$table=str_replace(".csv","",$v);
	$query0=" TRUNCATE TABLE $table";	
	 mysqli_query($connection, $query0) or die ("Couldn't execute query 1.  $query0");
	 
	$query1=" LOAD DATA LOCAL INFILE '$file' INTO TABLE $table 
	FIELDS TERMINATED BY '\t'  LINES TERMINATED BY '\r\n' ";	
	 mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
	$sql="select * from $table";
	$result=mysqli_query($connection, $sql) or die ("Couldn't execute query 1.  $sql");
	$num=mysqli_num_rows($result);
	echo "$v into $table records=$num<br /><br />";
	}
	
//Note B3 End


//echo "<br />Line 133"; exit;
	
/*
$query30="update budget.sips_phone_bill
          set a=trim(a) where 1 ";		  
		  
mysqli_query($connection, $query30) or die ("Couldn't execute query 30.  $query30");
*/


$query30="update budget.sips_phone_bill
          set a=trim(a) where 1 ";
		  
		  
mysqli_query($connection, $query30) or die ("Couldn't execute query 30.  $query30");


$query31="update budget.sips_phone_bill set a=replace(a,'\"','') where 1 ";
		  
		  
mysqli_query($connection, $query31) or die ("Couldn't execute query 31.  $query31");

$query32="update budget.sips_phone_bill set a=replace(a,'$','') where 1 ";
		  
		  
mysqli_query($connection, $query32) or die ("Couldn't execute query 32.  $query32");


$query33="update budget.sips_phone_bill set a=replace(a,',','') where 1 ";
		  
		  
mysqli_query($connection, $query33) or die ("Couldn't execute query 33.  $query33");





/*
$query33="update budget.sips_phone_bill set a=SUBSTRING(a,2) where 1 ";
		  
		  
mysqli_query($connection, $query33) or die ("Couldn't execute query 33.  $query33");


$query34="update budget.sips_phone_bill set a=SUBSTRING(a,1,LENGTH(a)-1) where 1 ";
		  
		  
mysqli_query($connection, $query34) or die ("Couldn't execute query 34.  $query34");


$query35="update budget.sips_phone_bill set a=replace(a,',','-') where 1 ";
		  
		  
mysqli_query($connection, $query35) or die ("Couldn't execute query 35.  $query35");
*/


$query111=" select a,mid(a,15,4) as 'fund_extract',mid(a,15,7) as 'center_extract',center,id FROM `sips_phone_bill` WHERE 1 ";
/*
if($beacnum=='60032793')
{
echo "<br />query111=$query111<br />"; //exit;
}
*/
$result111 = mysqli_query($connection, $query111) or die ("Couldn't execute query 111.  $query111");


while ($row111=mysqli_fetch_array($result111)){
extract($row111);
if($center_extract_last==''){$center_extract_last='none';}
if($fund_extract=='1680'){$center_extract_last=$center_extract;}

$query111a="update sips_phone_bill set center='$center_extract_last' where id='$id' "; 
mysqli_query($connection, $query111a) or die ("Couldn't execute query 111a.  $query111a");  

//if($fund_extract=='1680'){$center=$center_extract;}
//if($fund_extract!='1680'){$center=$center_extract_last;}
//$center=$center_extract;

//if($fund_extract=='1680'){$center_extract_last=$center_extract;}

//$fund_extract_last=$fund_extract;
//$center_extract_last=$center_extract;

//echo "<br />fund_extract=$fund_extract<br />center_extract=$center_extract <br />center_extract_last=$center_extract_last<br />id=$id<br />";

}

//echo "<br />Line 271"; exit;

$query100="SELECT id as 'first_record_delete' from sips_phone_bill where a='total' ";
$result100 = mysqli_query($connection, $query100) or die ("Couldn't execute query 100.  $query100");
$row100=mysqli_fetch_array($result100);
extract($row100);//brings back max (end_date) as $end_date

$query100a="delete from sips_phone_bill where id >= '$first_record_delete' ";
$result100a = mysqli_query($connection, $query100a) or die ("Couldn't execute query 100a.  $query100a");


// Edited on 5/26/21 (added:  or a like '%point_to_point%')
$query101="update sips_phone_bill set valid_record='y' where a like '%cellular%' or a like '%lan%' or a like '%local_service%' or a like '%wan%' or a like '%long_distance%' or a like '%point_to_point%' or a like '%install%' ";
$result101 = mysqli_query($connection, $query101) or die ("Couldn't execute query 101.  $query101");


$query101a="update sips_phone_bill set valid_record='n' where mid(a,1,4)='DNCR' ";
$result101a = mysqli_query($connection, $query101a) or die ("Couldn't execute query 101a.  $query101a");

$query101b="update sips_phone_bill set service_type='cellular' where a like '%cellular%' ";
$result101b = mysqli_query($connection, $query101b) or die ("Couldn't execute query 101b.  $query101b");

$query101c="update sips_phone_bill set service_type='lan' where a like '%lan%' ";
$result101c = mysqli_query($connection, $query101c) or die ("Couldn't execute query 101c.  $query101c");

$query101d="update sips_phone_bill set service_type='local service' where a like '%local_service%' ";
$result101d = mysqli_query($connection, $query101d) or die ("Couldn't execute query 101d.  $query101d");

$query101e="update sips_phone_bill set service_type='wan' where a like '%wan%' ";
$result101e = mysqli_query($connection, $query101e) or die ("Couldn't execute query 101e.  $query101e");


$query101f="update sips_phone_bill set service_type='long distance' where a like '%long_distance%' ";
$result101f = mysqli_query($connection, $query101f) or die ("Couldn't execute query 101f.  $query101f");

// Added on 5/26/21
$query101g="update sips_phone_bill set service_type='point to point' where a like '%point_to_point%' ";
$result101g = mysqli_query($connection, $query101g) or die ("Couldn't execute query 101g.  $query101g");


// Added on 6/22/21
$query101h="update sips_phone_bill set service_type='install_services_maintenance' where a like '%install%' ";
$result101h = mysqli_query($connection, $query101h) or die ("Couldn't execute query 101h.  $query101h");








$query102="delete from sips_phone_bill where valid_record != 'y' ";
$result102 = mysqli_query($connection, $query102) or die ("Couldn't execute query 102.  $query102");


$query103="update sips_phone_bill set amount=a where 1 ";
$result103 = mysqli_query($connection, $query103) or die ("Couldn't execute query 103.  $query103");

$query104="update sips_phone_bill set amount=replace(amount,'Cellular','') ";
$result104 = mysqli_query($connection, $query104) or die ("Couldn't execute query 104.  $query104");

$query105="update sips_phone_bill set amount=replace(amount,'LAN','') ";
$result105 = mysqli_query($connection, $query105) or die ("Couldn't execute query 105.  $query105");


$query106="update sips_phone_bill set amount=replace(amount,'Local Service','') ";
$result106 = mysqli_query($connection, $query106) or die ("Couldn't execute query 106.  $query106");

$query107="update sips_phone_bill set amount=replace(amount,'WAN','') ";
$result107 = mysqli_query($connection, $query107) or die ("Couldn't execute query 107.  $query107");

$query107a="update sips_phone_bill set amount=replace(amount,'Long Distance','') ";
$result107a = mysqli_query($connection, $query107a) or die ("Couldn't execute query 107a.  $query107a");

// Added on 5/26/21
$query107b="update sips_phone_bill set amount=replace(amount,'Point to Point','') ";
$result107b = mysqli_query($connection, $query107b) or die ("Couldn't execute query 107b.  $query107b");


// Added on 6/22/21
$query107c="update sips_phone_bill set amount=replace(amount,'Install/Services/Maintenance','') ";
$result107c = mysqli_query($connection, $query107c) or die ("Couldn't execute query 107c.  $query107c");




$query108="update sips_phone_bill set ncas_account='532814' where service_type='cellular' ";
$result108 = mysqli_query($connection, $query108) or die ("Couldn't execute query 108.  $query108");

$query109="update sips_phone_bill set ncas_account='532822' where service_type='lan' ";
$result109 = mysqli_query($connection, $query109) or die ("Couldn't execute query 109.  $query109");

$query110="update sips_phone_bill set ncas_account='532811' where service_type='local service' ";
$result110 = mysqli_query($connection, $query110) or die ("Couldn't execute query 110.  $query110");


$query111="update sips_phone_bill set ncas_account='532812' where service_type='wan' ";
$result111 = mysqli_query($connection, $query111) or die ("Couldn't execute query 111.  $query111");

$query111a="update sips_phone_bill set ncas_account='532811' where service_type='long distance' ";
$result111a = mysqli_query($connection, $query111a) or die ("Couldn't execute query 111a.  $query111a");

// Added on 5/26/21
$query111b="update sips_phone_bill set ncas_account='532811' where service_type='point to point' ";
$result111b = mysqli_query($connection, $query111b) or die ("Couldn't execute query 111b.  $query111b");


// Added on 6/22/21
$query111c="update sips_phone_bill set ncas_account='532819' where service_type='install_services_maintenance' ";
$result111c = mysqli_query($connection, $query111c) or die ("Couldn't execute query 111c.  $query111c");


//echo "<br />Line 388<br />";
//exit;

$query112="truncate table sips_phone_bill2";

$result112 = mysqli_query($connection, $query112) or die ("Couldn't execute query 112.  $query112 ");



$query113="insert into sips_phone_bill2(service_type,ncas_center,ncas_invoice_amount,invoice_total,ncas_account)
           select service_type,center,amount,amount,ncas_account from sips_phone_bill where 1 ";

$result113 = mysqli_query($connection, $query113) or die ("Couldn't execute query 113.  $query113 ");


$system_entry_date=date("Ymd");


$query114="update sips_phone_bill2 set ncas_number=mid(ncas_account,3,4) where 1 ";

$result114 = mysqli_query($connection, $query114) or die ("Couldn't execute query 114.  $query114 ");


$query115="update sips_phone_bill2 set system_entry_date='$system_entry_date' where 1 ";

$result115 = mysqli_query($connection, $query115) or die ("Couldn't execute query 115.  $query115 ");

//convert Field=system_entry_date into prepared_date (Example: 2021-03-04 into 03/04/2021
$query116="update sips_phone_bill2
           set prepared_date=concat(mid(system_entry_date,6,2),'/',mid(system_entry_date,9,2),'/',mid(system_entry_date,1,4))
		   where 1 ";

$result116 = mysqli_query($connection, $query116) or die ("Couldn't execute query 116.  $query116 ");


$query117="SELECT datesql as 'last_datesql',id from sips_phone_bill4_perm where 1 order by id desc limit 1 ";

$result117 = mysqli_query($connection, $query117) or die ("Couldn't execute query 117.  $query117 ");

$row117=mysqli_fetch_array($result117);
extract($row117);


$query118="update sips_phone_bill2
           set ncas_fund=mid(ncas_center,1,4),ncas_rcc=mid(ncas_center,5,3) where 1 ";

$result118 = mysqli_query($connection, $query118) or die ("Couldn't execute query 118.  $query118 ");


$query119="update sips_phone_bill2
           set user_id='$user_id' where 1 ";

$result119 = mysqli_query($connection, $query119) or die ("Couldn't execute query 119.  $query119 ");




////-3/10/21 echo "<br />last_datesql=$last_datesql<br />";


$current_invoice_mm_dd=substr($last_datesql,5,2).'-'.substr($last_datesql,2,2);
////-3/10/21 echo "<br />current_invoice_mm_dd=$current_invoice_mm_dd<br />";

$current_invoice_number='06-8009/'.$current_invoice_mm_dd.'/DCR';
$comments=$current_invoice_number;
////-3/10/21 echo "<br />current_invoice_number=$current_invoice_number<br />";
////-3/10/21 echo "<br />comments=$comments<br />";



$report_date3=date_create("$last_datesql");
date_sub($report_date3,date_interval_create_from_date_string("-14 days"));
$report_date5=date_format($report_date3,"Ymd");

////-3/10/21 echo "<br />report_date5=$report_date5<br />";

/*
last_datesql=2020-12-01

report_date5=20201215
*/
$yyyy_last=substr($last_datesql,0,4);
$mm_last=substr($last_datesql,5,2);
$day_last=substr($last_datesql,8,2);

////-3/10/21 echo "<br />yyyy_last=$yyyy_last<br />";
////-3/10/21 echo "<br />mm_last=$mm_last<br />";
////-3/10/21 echo "<br />day_last=$day_last<br />";
//$mm_last='12';
$mm_current=$mm_last+1;
//$mm_next=str_pad($mm_next,2,'0',str_pad_left);
$mm_current2=str_pad($mm_current, 2, '0', STR_PAD_LEFT);
if($mm_current2=='13'){$mm_current2='01';}

////-3/10/21 echo "<br />mm_current2=$mm_current2<br />";

if($mm_current=='13'){$yyyy_current=$yyyy_last+1;}else{$yyyy_current=$yyyy_last;}

////-3/10/21 echo "<br />yyyy_current=$yyyy_current<br />";

$day_current=$day_last;

////-3/10/21 echo "<br />day_current=$day_current<br />";

$ncas_invoice_date=$mm_current2.'/'.$day_current.'/'.$yyyy_current;
////-3/10/21 echo "<br />ncas_invoice_date=$ncas_invoice_date<br />";

$datesql_current=$yyyy_current.$mm_current2.$day_current;
////-3/10/21 echo "<br />datesql_current=$datesql_current<br />";

$datesql_current_DF=$yyyy_current.'-'.$mm_current2.'-'.$day_current;
////-3/10/21 echo "<br />datesql_current_DF=$datesql_current_DF<br />";

$report_date3=date_create("$datesql_current_DF");
date_sub($report_date3,date_interval_create_from_date_string("-14 days"));
$report_date4=date_format($report_date3,"Ymd");

////-3/10/21 echo "<br />report_date4=$report_date4<br />";

$due_date_yyyy=substr($report_date4,0,4);
$due_date_mm=substr($report_date4,4,2);
$due_date_day=substr($report_date4,6,2);

////-3/10/21 echo "<br />due_date_yyyy=$due_date_yyyy<br />";
////-3/10/21 echo "<br />due_date_mm=$due_date_mm<br />";
////-3/10/21 echo "<br />due_date_day=$due_date_day<br />";


$due_date=$due_date_mm.'/'.$due_date_day.'/'.$due_date_yyyy.'-ADM';
////-3/10/21 echo "<br />due_date=$due_date<br />";


$query5b="select cy,py1,py2,py3,py4,py5 from fiscal_year where active_year_sips='y' ";
//echo "<br />query5b=$query5b<br />";

$result5b = mysqli_query($connection, $query5b) or die ("Couldn't execute query 5b.  $query5b");

$row5b=mysqli_fetch_array($result5b);
extract($row5b);

if($fyear_sips==''){$fyear_sips=$cy;}
/*
$query103="update sips_phone_bill set service_type=left(a,locate('-',a)-1) where 1 ";
$result103 = mysqli_query($connection, $query103) or die ("Couldn't execute query 103.  $query103");


$query104="update sips_phone_bill set amount=substring_index(a,'-',-1) where 1 ";
$result104 = mysqli_query($connection, $query104) or die ("Couldn't execute query 104.  $query104");
*/

$current_invoice_number=$invoice_number;

$query120="update sips_phone_bill2
           set ncas_invoice_number='$current_invoice_number',comments='$current_invoice_number',ncas_invoice_date='$ncas_invoice_date',datesql='$datesql_current',due_date='$due_date',fyear_sips='$fyear_sips'
		   where 1 ";

$result120 = mysqli_query($connection, $query120) or die ("Couldn't execute query 120.  $query120 ");


$query121="insert into sips_phone_bill4_perm(ncas_invoice_date,datesql,system_entry_date,due_date,ncas_invoice_number,ncas_invoice_amount,invoice_total,user_id,comments,fyear)
           select ncas_invoice_date,datesql,system_entry_date,due_date,ncas_invoice_number,sum(ncas_invoice_amount),sum(ncas_invoice_amount),user_id,comments,fyear_sips 
		   from sips_phone_bill2
		   where 1
		   group by ncas_invoice_number  ";

$result121 = mysqli_query($connection, $query121) or die ("Couldn't execute query 121.  $query121 ");


$query18="insert into cid_vendor_invoice_payments
(prefix,ncas_number,ncas_account,ncas_budget_code,prepared_by,prepared_date,comments,ncas_company,ncas_invoice_date,datesql,system_entry_date,
 due_date,ncas_invoice_number,ncas_invoice_amount,invoice_total,ncas_remit_code,vendor_name,vendor_address,
 pay_entity,vendor_number,group_number,user_id,parkcode,ncas_fund,ncas_rcc,ncas_center,received_by)
 
 select prefix,ncas_number,ncas_account,ncas_budget_code,prepared_by,prepared_date,comments,ncas_company,ncas_invoice_date,datesql,system_entry_date,
 due_date,ncas_invoice_number,sum(ncas_invoice_amount),sum(invoice_total),ncas_remit_code,vendor_name,vendor_address,
 pay_entity,vendor_number,group_number,user_id,parkcode,ncas_fund,ncas_rcc,ncas_center,received_by 
 from sips_phone_bill2
 where 1
 group by ncas_account,ncas_center
 order by ncas_account,ncas_center
 "; 
 
	
$result18=mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18");



////-3/10/21 echo "<br />Upload Complete<br />"; //exit;


/*
$query31="truncate table sips_phone_bill2 ";
		  
		  
mysqli_query($connection, $query31) or die ("Couldn't execute query 31.  $query31");


$query32="insert into sips_phone_bill2(a,b,c,d,e,f,g,h,i,j)
          select a,b,c,d,e,f,g,h,i,j
		  from sips_phone_bill
		  where 1 ";
		  
		  
mysqli_query($connection, $query32) or die ("Couldn't execute query 32.  $query32");




$query33="update sips_phone_bill2
          set row='1' where mid(a,1,3)='460' ";		  
		  
mysqli_query($connection, $query33) or die ("Couldn't execute query 33.  $query33");

$query34="update sips_phone_bill2
          set row='2' where mid(a,1,3)='dnc' ";		  
		  
mysqli_query($connection, $query34) or die ("Couldn't execute query 34.  $query34");

$query35="delete from sips_phone_bill2
          where row != '1' and row != '2' ";		  
		  
mysqli_query($connection, $query35) or die ("Couldn't execute query 35.  $query35");


$query36="update sips_phone_bill2
set
b=mid(a,45,10),
c=mid(a,55,11),
d=mid(a,66,8),
e=mid(a,73,10),
f=mid(a,83,10),
g=mid(a,93,10),
h=mid(a,103,10),
i=mid(a,113,10)
where 1;";		  
		  
mysqli_query($connection, $query36) or die ("Couldn't execute query 36.  $query36"); 

//echo "<br />line181";  


$query37="update budget.sips_phone_bill2
set a=trim(a),b=trim(b),c=trim(c),d=trim(d),e=trim(e),f=trim(f),
g=trim(g),h=trim(h),i=trim(i),j=trim(j) where 1 ; ";		  
		  
mysqli_query($connection, $query37) or die ("Couldn't execute query 37.  $query37");

//echo "line 199 <br />"; exit;

$query38="update sips_phone_bill2
set negative_position=LOCATE('-',a)
where a like '%-%' ; ";		  
		  
mysqli_query($connection, $query38) or die ("Couldn't execute query 38.  $query38");


$query39b="update sips_phone_bill2
set negative_field='b'
where negative_position >= '45' and negative_position <= '55'  ; ";		  
		  
mysqli_query($connection, $query39b) or die ("Couldn't execute query 39b.  $query39b");


$query39c="update sips_phone_bill2
set negative_field='c'
where negative_position >= '56' and negative_position <= '65'  ; ";		  
		  
mysqli_query($connection, $query39c) or die ("Couldn't execute query 39c.  $query39c");


$query39d="update sips_phone_bill2
set negative_field='d'
where negative_position >= '66' and negative_position <= '73'  ; ";		  
		  
mysqli_query($connection, $query39d) or die ("Couldn't execute query 39d.  $query39d");


$query39e="update sips_phone_bill2
set negative_field='e'
where negative_position >= '73' and negative_position <= '82'  ; ";		  
		  
mysqli_query($connection, $query39e) or die ("Couldn't execute query 39e.  $query39e");



$query39f="update sips_phone_bill2
set negative_field='f'
where negative_position >= '83' and negative_position <= '92'  ; ";		  
		  
mysqli_query($connection, $query39f) or die ("Couldn't execute query 39f.  $query39f");


$query39g="update sips_phone_bill2
set negative_field='g'
where negative_position >= '93' and negative_position <= '102'  ; ";		  
		  
mysqli_query($connection, $query39g) or die ("Couldn't execute query 39g.  $query39g");


$query39h="update sips_phone_bill2
set negative_field='h'
where negative_position >= '103' and negative_position <= '112'  ; ";		  
		  
mysqli_query($connection, $query39h) or die ("Couldn't execute query 39h.  $query39h");



$query39i="update sips_phone_bill2
set negative_field='i'
where negative_position >= '113' and negative_position <= '122'  ;
 ";		  
		  
mysqli_query($connection, $query39i) or die ("Couldn't execute query 39i.  $query39i");


$query40b="update sips_phone_bill2
set b=-b
where negative_field='b' ; ";		  
		  
mysqli_query($connection, $query40b) or die ("Couldn't execute query 40b.  $query40b");


$query40c="update sips_phone_bill2
set c=-c
where negative_field='c' ; ";		  
		  
mysqli_query($connection, $query40c) or die ("Couldn't execute query 40c.  $query40c");


$query40d="update sips_phone_bill2
set d=-d
where negative_field='d' ; ";		  
		  
mysqli_query($connection, $query40d) or die ("Couldn't execute query 40d.  $query40d");



$query40e="update sips_phone_bill2
set e=-e
where negative_field='e' ; ";		  
		  
mysqli_query($connection, $query40e) or die ("Couldn't execute query 40e.  $query40e");



$query40f="update sips_phone_bill2
set f=-f
where negative_field='f' ; ";		  
		  
mysqli_query($connection, $query40f) or die ("Couldn't execute query 40f.  $query40f");


$query40g="update sips_phone_bill2
set g=-g
where negative_field='g' ; ";		  
		  
mysqli_query($connection, $query40g) or die ("Couldn't execute query 40g.  $query40g");


$query40h="update sips_phone_bill2
set h=-h
where negative_field='h' ; ";		  
		  
mysqli_query($connection, $query40h) or die ("Couldn't execute query 40h.  $query40h");


$query40i="update sips_phone_bill2
set i=-i
where negative_field='i' ; ";		  
		  
mysqli_query($connection, $query40i) or die ("Couldn't execute query 40i.  $query40i");

*/	


echo "<H3 ALIGN=left><a href='/budget/acs/acsFind.php?ncas_invoice_number=$current_invoice_number&submit_acs=Find' target='_blank'>VIEW CODE Sheet</a></H3>";


exit;




}



	
//Note B End.	
	
?>

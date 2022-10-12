<?php 
extract($_REQUEST);
ini_set('display_errors',1);
if(@$phone_number=="")
	{
	
	include("menu.php");
	
//	session_start();
// 	echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	$level=$_SESSION['phone_bill']['level'];
			
	// Give higher access to phone logs for these positions
	$admin_log=array("budget officer"=>"60032781","Processing Assistant V"=>"60032997","Administrative Officer I"=>"60032791","Facility Maint Manager"=>"60033012");
	//Tammy Dodd
	//Rachel Gooding
	//JoAnne Barbour
	
		$temp=$_SESSION['beacon_num'];
		if($level<5){
				if($level>2){$level=1;}
				if(in_array($temp,$admin_log)){$level=4;}
				}
	
	// get all active RCCs
	$database="divper";
	include("../../include/iConnect.inc");// database connection parameters
	mysqli_select_db($connection,$database)
		   or die ("Couldn't select database");
	$sql="SELECT  center, center_desc, upper(parkcode) as parkcode
	FROM  `budget`.`center` 
	WHERE 1  AND  `rcc`  !=  '' AND fund =  '1280' AND actcenteryn =  'y'
	ORDER  BY  `parkcode`  ASC ";
	
	$result=mysqli_query($connection,$sql);
	while($row=mysqli_fetch_array($result))
			{$center_array[$row['parkcode']]=$row['center'];}
//	echo "<pre>"; print_r($center_array); echo "</pre>";  exit;
	
	
			
	 if(@$num<1 OR @$parkcode!="")
		 {
		//echo "<pre>$result"; print_r($array); echo "</pre>";  exit;
		// get all phones for a parkcode
		
	$database="divper";
	//include("../../include/iConnect.inc");// database connection parameters
	  mysqli_select_db($connection,$database)
		   or die ("Couldn't select database");
		
		$where="";
		if($parkcode){$where="and t2.currPark='$parkcode'";}
			
		$sql="SELECT t2.currPark, work_cell as Mphone, t1.Lname
		FROM divper.empinfo as t1
		LEFT JOIN divper.emplist as t2 on t2.tempID=t1.tempID
		where 1 and t2.tempID !='' and t1.work_cell !=''
		$where
		order by t1.Lname"; //echo "$sql";
		 $result = mysqli_QUERY($connection,$sql);
		while($row=mysqli_fetch_assoc($result)){
				if($row['Mphone']==""){continue;}
				$cleanPhone=str_replace('(','',$row['Mphone']);
				$cleanPhone=str_replace(') ','-',$cleanPhone);
				$cleanPhone=str_replace(')','-',$cleanPhone);
				$cleanPhone=str_replace('.','-',$cleanPhone);
				$cleanPhone=str_replace('/','-',$cleanPhone);
				$cleanPhone=str_replace(' ','-',$cleanPhone);
				$cleanPhone=substr($cleanPhone,0,12);
				$index=$cleanPhone."=cell ".$row['Lname'];
				$active_phone[$cleanPhone]=$row['Lname'];
				$phoneArray[$index]=$row['currPark'];
				}

//	echo "$sql<pre>"; print_r($phoneArray); echo "</pre>";  exit;				
		// Land line phones for individuals
		$sql="SELECT t2.currPark, phone as Mphone, t1.Lname
		FROM divper.empinfo as t1
		LEFT JOIN divper.emplist as t2 on t2.tempID=t1.tempID
		where 1 and t2.tempID !=''
		$where
		order by t1.Lname";  
// 		echo "$sql";
		 $result = mysqli_QUERY($connection,$sql);
		while($row=mysqli_fetch_assoc($result)){
				if($row['Mphone']==""){continue;}
				$cleanPhone=str_replace('(','',$row['Mphone']);
				$cleanPhone=str_replace(') ','-',$cleanPhone);
				$cleanPhone=str_replace(')','-',$cleanPhone);
				$cleanPhone=str_replace('.','-',$cleanPhone);
				$cleanPhone=str_replace('/','-',$cleanPhone);
				$cleanPhone=str_replace(' ','-',$cleanPhone);
				$cleanPhone=substr($cleanPhone,0,12);
				$index=$cleanPhone."=land ".$row['Lname'];
				$active_phone[$cleanPhone]=$row['Lname'];
				$phoneArray[$index]=$row['currPark'];
				}
//	echo "<pre>"; print_r($active_phone); echo "</pre>";  exit;
	
		// Office phones
		$sql="SELECT ophone as phone0, phone1, phone2, mphone as mobile, fax
		FROM dpr_system.dprunit where parkcode='$parkcode'"; //echo "$sql";
		 $result = mysqli_QUERY($connection,$sql);
		while(@$row=mysqli_fetch_assoc($result)){
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
			//	$active_phone[$cleanPhone]=$row['Lname'];
				@$phoneArray[$index]=$row['Lname'];
					}
				}
//	echo "<pre>"; print_r($active_phone); echo "</pre>";  exit;
					
		// "Other" phone lines
		
	$database="phone_bill";
	mysqli_select_db($connection,$database)
		   or die ("Couldn't select database");
		
		$sql="SELECT alt_lines as Mphone, location as alt_loc
		FROM phone_bill.alt_lines 
		where location like '%$parkcode%'"; //echo "$sql";
		 $result = mysqli_QUERY($connection,$sql);
		while($row=mysqli_fetch_assoc($result)){
				if($row['Mphone']==""){continue;}
				$cleanPhone=str_replace('(','',$row['Mphone']);
				$cleanPhone=str_replace(') ','-',$cleanPhone);
				$cleanPhone=str_replace(')','-',$cleanPhone);
				$cleanPhone=str_replace('.','-',$cleanPhone);
				$cleanPhone=str_replace('/','-',$cleanPhone);
				$cleanPhone=str_replace(' ','-',$cleanPhone);
				$cleanPhone=substr($cleanPhone,0,12);
				$index=$cleanPhone."=".$row['alt_loc'];
				$active_phone[$cleanPhone]=$row['alt_loc'];
				$phoneArray[$index]=$parkcode;
				}
//	echo "<pre>"; print_r($active_phone); echo "</pre>";  exit;
				
//	echo "<pre>"; print_r($phoneArray); echo "</pre>";  exit;
		//	$unique=array_unique($phoneArray);
			$unique=$phoneArray;
		//	$unique_active=array_unique($active_phone);
			$unique_active=$active_phone;
//	echo "<pre>"; print_r($unique_active); echo "</pre>";  exit;
		}// end if park_codes do NOT exist
	
	else
		{
		$row=mysqli_fetch_array($result);
		$unique=explode(",",$row['park_codes']);
		}
	
// ********************************
echo "<div align=\"center\">";
	if($parkcode=="")
		{
		
		sort($unique);
			if($level==2)
				{
				include("../../include/get_parkcodes_reg.php");
				$dist=$_SESSION['phone_bill']['select'];
				$test=${"array".$dist};
				}
	//	if(empty($test)){echo "The array does not exist. Contact Tom Howard.";exit;}
		echo "<table border='1'>";
		
			$check="";
			IF($level>1)
				{
				foreach($unique as $k=>$v)
					{
					if($v==$check){continue;}
					if($v=="")
						{
						$v="Center Code";
						echo "<tr><td>$v</td></tr>";
						continue;
						}
					if($level==2 AND !in_array($v,$test)){continue;}
					echo "<tr><td><a href='phone_center.php?open_file=$open_file&parkcode=$v'>$v</a></td></tr>";
					$check=$v;
					}
				}
				else
				{
				echo "Contact Tammy to view phone log. Level=$level";}
		echo "</table>";
		
		$database="phone_bill";
	  	mysqli_select_db($connection,$database)
		   or die ("Couldn't select database");
		
		foreach($unique as $k=>$v)
			{
			if($v)
				{
				@$clause.=$v.",";
				}
			}
			$clause=rtrim($clause,",");
			$sql="UPDATE phone_bill set park_codes='$clause' where bill_txt='$open_file'";// echo "$sql";
			$result = mysqli_QUERY($connection,$sql);
			
		// ********************************** Check for widowed phones
		if($level>3)
			{
			include("fill_table.php");
			}
		exit;
		}
// **********************************************************	
	echo "<table border='1'>";
	
		echo "<tr><td align='center'>$parkcode</td></tr>";
			foreach($phoneArray as $key=>$val){
			$pn=explode("=",$key);
			$tr="";
			if($pn[1][0]=="c"){$tr=" bgcolor='aliceblue'";}
			if($pn[1][0]=="p"){$tr=" bgcolor='white'";}
				echo "<tr$tr><td><a href='phone_center.php?open_file=$open_file&parkcode=$parkcode&phone_number=$pn[0]' target='_blank'>$key</a></td></tr>";
					}
	
	echo "</table>";
	}

if(@$phone_number=="" OR @$open_file==""){exit;};

//$open_file="2009/may09.TXT";
$fo=fopen($open_file,'r');
$bill_txt = fread($fo, filesize($open_file));
fclose($fo);

if($bill_txt==""){echo "File $open_file did not load.";exit;}
//$phone_number="828-625-9945";

@$thisPhone=$phone_number;
$dept_code="";
$billing_period="";
$person="";

//: Bill Number      919-218-1014
$ex1=explode(": Bill Number      $thisPhone",$bill_txt);// 6 spaces between
//echo "<pre>"; print_r($bill_txt); echo "</pre>"; // exit;
$count=count($ex1); //echo "c=$count";exit;
$j=2;

if($count<2){ // only 5 spaces between Bill Number and telephone number
	$j=1;
	$ex1=explode(": Bill Number     $thisPhone",$bill_txt);// 5 spaces betweeen
	$count=count($ex1); //echo "c=$count";exit;
	@$ex2=explode("Report No TCS-711",$ex1[1]);
	$detail=$ex2[0];
	
	$thisPhone=$phone_number." ".$person." for the Period Ending $billing_period for Department Code: $dept_code";
	if($count<2)
		{
		$text="<font color='red'>Number is listed as a \"called\" number, but is not shown as a billable number on SIPS statement . The following could be the issue:<br />
&nbsp;&nbsp;&nbsp;1. Personal numbers of staff placed in the \"work only number fields\" in the What Is Your Status CONTACT INFO. <a href='http://www.dpr.ncparks.gov/wiys/index.html'>WIYS</a><br />
&nbsp;&nbsp;&nbsp;2. This number did not incur any charges during this billing cycle.<br />
&nbsp;&nbsp;&nbsp;3. Number is no longer active but may still be hardcoded in the phone bill database.<br /><br />
Contact  Tammy Dodd for resolution.</font>";
		echo "$thisPhone<br /><br />$text"; exit;
		}
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
for($i=1;$i<$count-1;$i++)
	{
	print_r($ex1[$i]);
	}

//echo "<pre>"; print_r($ex1[$count]); echo "</pre>"; // exit;

$count-=1;
$ex2=explode("Report No TCS-711",$ex1[$count]);
print_r($ex2[0]);
echo "</pre>"; 

echo "</div></body></html>";


?>
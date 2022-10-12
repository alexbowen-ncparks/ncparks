<?php 
extract($_REQUEST);

$database="divper";
	include("../../../include/connectROOT.inc"); //echo "c=$connection";
	
	//if($level==1){$parkcode=$_SESSION['divper']['level'];}
	// Mobile phones
		if($parkcode){$where="and t2.currPark='$parkcode'";}
		
	$sql="SELECT t2.currPark, work_cell as Mphone, t1.Lname
	FROM divper.empinfo as t1
	LEFT JOIN divper.emplist as t2 on t2.tempID=t1.tempID
	where 1 and t2.tempID !='' and t1.work_cell !=''
	order by t1.Lname"; //echo "$sql"; exit;
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
	//		$index=$cleanPhone."=cell ".$row['Lname'];
	//		$mobile_array[]=trim($cleanPhone);
			$xx=trim($cleanPhone);;
			$mobile_array[$xx]="mobile";
			}

//echo "<pre>";print_r($mobile_array);echo "</pre>"; exit;
	
	// Land line phones for individuals
	$sql="SELECT t2.currPark, phone as Mphone, t1.Lname
	FROM divper.empinfo as t1
	LEFT JOIN divper.emplist as t2 on t2.tempID=t1.tempID
	where 1 and t2.tempID !=''
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
	//		$index=$cleanPhone."=land ".$row['Lname'];
	//		$land_array[]=trim($cleanPhone);
			$xx=trim($cleanPhone);;
			$land_array[$xx]="land";
			}

//echo "<pre>";print_r($land_array);echo "</pre>"; exit;

	// Office phones
	$sql="SELECT ophone as phone0, phone1, phone2, mphone as mobile, fax
	FROM divper.dprunit where parkcode='$parkcode'"; //echo "$sql";
	 $result = MYSQL_QUERY($sql,$connection);
	while($row=mysql_fetch_assoc($result))
		{
		foreach($row as $k=>$v)
			{
				if($v==""){continue;}
			$cleanPhone=str_replace('(','',$v);
			$cleanPhone=str_replace(') ','-',$cleanPhone);
			$cleanPhone=str_replace(')','-',$cleanPhone);
			$cleanPhone=str_replace('.','-',$cleanPhone);
			$cleanPhone=str_replace('/','-',$cleanPhone);
			$cleanPhone=str_replace(' ','-',$cleanPhone);
			$cleanPhone=substr($cleanPhone,0,12);
	//		$index=$cleanPhone."=park ".$k;
	//		$office_array[]=trim($cleanPhone);
			$xx=trim($cleanPhone);;
			$office_array[$xx]="office";
			}
		}

//echo "<pre>";print_r($office_array);echo "</pre>"; exit;

	// "Other" phone lines
	$database="phone_bill";
	include("../../../include/connectROOT.inc"); //echo "c=$connection";
	
	$sql="SELECT alt_lines as Mphone, location as alt_loc
	FROM phone_bill.alt_lines as Mphone 
	where location like '%$parkcode%'"; //echo "$sql";
	 $result = MYSQL_QUERY($sql,$connection);
	while($row=mysql_fetch_assoc($result))
		{
			if($row['Mphone']==""){continue;}
			$cleanPhone=str_replace('(','',$row['Mphone']);
			$cleanPhone=str_replace(') ','-',$cleanPhone);
			$cleanPhone=str_replace(')','-',$cleanPhone);
			$cleanPhone=str_replace('.','-',$cleanPhone);
			$cleanPhone=str_replace('/','-',$cleanPhone);
			$cleanPhone=str_replace(' ','-',$cleanPhone);
			$cleanPhone=substr($cleanPhone,0,12);
		//	$index=$cleanPhone."=".$row['alt_loc'];
		//	$alt_line_array[]=trim($cleanPhone);
			$xx=trim($cleanPhone);;
			$alt_line_array[$xx]="alt";
		}

//echo "<pre>";print_r($alt_line_array);echo "</pre>"; exit;

			
$open_file="2011/jan11.TXT";
$fo=fopen($open_file,'r');
$bill_txt = fread($fo, filesize($open_file));
fclose($fo);

if($bill_txt==""){echo "File $open_file did not load.";exit;}


//: Bill Number      919-218-1014
$ex1=explode("\n",$bill_txt);// 6 spaces between

foreach($ex1 as $k=>$v)
	{
	$new[$k]=$v;	
	if($k>25){break;}
	}
echo "<pre>";print_r($new);echo "</pre>"; //exit;


foreach($ex1 as $k=>$v)
	{
	if(strpos($v,"Bill Number")>0)
		{
		if(strpos($v,"Service")>-1){continue;}
		if(strpos($v,"Total - Bill Number")>0){continue;}
		$i++;
		$var1=explode("Number ",$v);
		$var2=explode(" -",$var1[1]);
		$sips_phones[]=trim($var2[0]);
		}
	
//	if($k>1115){exit;}
	}


$all_array=array_merge($mobile_array,$land_array,$office_array,$alt_line_array);
$all_array_num=array_keys($all_array);

//echo "<pre>";print_r($all_array);echo "</pre>"; exit;

$sips=array_unique($sips_phones);
//echo "<pre>";print_r($sips);echo "</pre>"; exit;

foreach($sips as $k=>$v)
	{
	if(!in_array($v,$all_array_num))
		{
		$check[]=$v;
		}
	}

//echo "<pre>";print_r($check);echo "</pre>"; exit;

//$yy=": Bill Number      919-715-0078                -                                                                                   :";
$yy=":                                Standard agency vendor number - 56-2032825                                                        :";
//$yy=$new[26];
//echo $yy; exit;
$xx=array_search($yy,$ex1);
echo "<pre>";print_r($new[26]);echo "</pre>"; //exit;
echo "<pre>$yy";echo "</pre>"; //exit;
echo "<br />x=$xx";exit;
foreach($check as $k=>$v)
	{
	$x=": Bill Number      ".$v;
	$var=explode($x,$bill_txt);
	echo "<pre>";print_r($var[0]);echo "</pre>";exit;
	$var1=explode(": Department      ",$var[0]);
	$var2=explode(" ",$var1[1]);
	echo "<pre>";print_r($dept);echo "</pre>";
	$dept[$v]=$var2[0];
	exit;
	}
echo "<pre>";print_r($dept);echo "</pre>";	
?>
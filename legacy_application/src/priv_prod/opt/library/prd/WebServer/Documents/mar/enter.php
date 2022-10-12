<?php
$mar_db="mar";
$db = mysqli_select_db($connection,$mar_db)       or die ("Couldn't select database");

if(!empty($pass_where))
	{
	$to_word=2;
// 	echo "$pass_where";
	}
// echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
// echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$user=$_SESSION['mar']['tempID'];
$level=$_SESSION['mar']['level'];
if($level<1){exit;}

$accessPark_array=array();
if(!empty($_SESSION['mar']['accessPark']))
	{
	$accessPark_array=explode(",",$_SESSION['mar']['accessPark']);
	}

date_default_timezone_set('America/New_York');

$sql="SELECT distinct left(`date`,4) as year
FROM enter as t1
where 1
order by `date` desc"; 
$result = @MYSQLI_QUERY($connection,$sql) or die (mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$year_array[]=$row['year'];
	}
// echo "<pre>"; print_r($year_array); echo "</pre>"; // exit;	
$this_month=date("m");
$this_year=date("Y");
$this_year_month=date("Y-m")."%";

if(!empty($month))
	{
	$this_year_month=date("Y")."-$month%";
	}

$month_array=array("01"=>"Jan","02"=>"Feb","03"=>"Mar","04"=>"Apr","05"=>"May","06"=>"Jun","07"=>"Jul","08"=>"Aug","09"=>"Sep","10"=>"Oct","11"=>"Nov","12"=>"Dec",);


include("sections_array.php");
// $sections=array("zI&E"=>"Interpretation and Education","zE&C"=>"Engineering and Construction","zG&O"=>"Grants and Outreach","zP&NR"=>"Planning and Natural Resources Management","zLAND"=>"Land Acquisition","zTRAILS"=>"State Trails Program","zCONC"=>"Concessions","zP&W"=>"Publication and Web Development","zMARK"=>"Marketing");
// asort($sections);

if(!empty($_POST['park']))
	{
	if(array_key_exists($_POST['park'],$sections))
		{
		$sess_park=$_POST['park'];
		}
	}
	
if($level<2)
	{
	$sess_park=$_SESSION['mar']['select'];
	if(!empty($_POST['park']))
		{
		if(in_array($_POST['park'],$accessPark_array))
			{
			$sess_park=$_POST['park'];
			}
		}
	}

	
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

$where_display="";
$interval="35";
$check_day=date('d');
if($check_day>5){$interval=30+$check_day;}
if(empty($month))
	{
	$month=$this_month;
	}
	else
	{
	if($month=="any")
		{$month="";}
	
	}
$where="`date` BETWEEN NOW() - INTERVAL $interval DAY AND NOW() and `date` like '%-$this_month-%'";

IF(!empty($_POST['year']))
	{
	$where_a[]=" date like '".$year."%'";
	$where="1";
	$where_array[]="year=$year";
	}

IF(!empty($_POST['region']))
	{
	if($_POST['region']=="ADMI")
		{
		foreach($sections as $k=>$v)
			{
			$temp[]="t1.park = '$k'";
			}
		$where_a[]="(".implode(" OR ",$temp).")";
		
	$where_array[]="region=ADMI";
		}
		else
		{
		$where_a[]=" t4.region = '".$_POST['region']."'";
		$region=$_POST['region'];
		$where="1";
		$where_array[]="region=$region";
		}
// 	echo "<pre>"; print_r($where_region); echo "</pre>"; // exit;
	}
IF(!empty($_POST['park']))
	{
	if(empty($sess_park)){$sess_park=$_POST['park'];}
	$where_a[]=" park='".$sess_park."'";
	$where="1";
	
	if(substr($sess_park, 0,1)=="z")
		{
		$where_array[]="park=".str_replace("z","",$sess_park);
		}
	if(empty($_POST['year']))
		{
		$where_a[]=$where="`date` BETWEEN NOW() - INTERVAL 365 DAY AND NOW()";
		$where_array[]="within last year";
		}
	}
IF(!empty($_POST['month']) and empty($year))
	{
	$where_a[]=" date like '".$this_year_month."'";
	$where_array[]="month=$month";
	}
IF(!empty($_POST['month']) and !empty($year) and $_POST['month']!="any")
	{
	$this_year_month=$year."-"."$month%";
	$where_a[]=" date like '".$this_year_month."'";
	$where_array[]="month=$month";
	
	}
// echo "<pre>"; print_r($where_a); echo "</pre>"; // exit;
if(!empty($where_a))
	{
	$where=implode(" and ",$where_a);
	$where_display=implode(" and ",$where_array);
	}
// echo "<pre>"; print_r($where_a); echo "</pre>"; // exit;
// , 
// group_concat(distinct concat(t2.file_name, '^', t2.file_link) SEPARATOR '***') as file_link, 
// group_concat(distinct concat(t3.photo_name, '^', t3.photo_link) SEPARATOR '***') as photo_link
// LEFT JOIN enter_upload_file as t2 on t1.id=t2.enter_id_file
// LEFT JOIN enter_upload_photo as t3 on t1.id=t3.enter_id_photo


$order_by=" region, park, date desc";
if(!empty($sort))
	{
	$order_by=$sort;
	}

$where=str_replace("any", '', $where);

if(!empty($to_word))
	{
	if($to_word==2)
		{
		$where=stripslashes($pass_where);
		}
	}
$sql="SELECT if(t4.region is NULL, park, t4.region) as region,  t4.park_name, t1.*
FROM enter as t1
LEFT JOIN dpr_system.parkcode_names_region as t4 on t1.park=t4.park_code
where 
$where
group by t1.id
order by $order_by"; 
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
if($level>4)
	{
// 	echo $sql."<br />"; //exit;
	}


$result = @MYSQLI_QUERY($connection,$sql) or die (mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	if(empty($row['region']))
		{
		$row['region']=$sections[$row['park']];
		}
	$ARRAY[]=$row;
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$num=mysqli_num_rows($result);

if($num<1)
	{$c_enter= "<font color='red'>No </font>"; }
	else
	{
	$c_enter=$num;
	if(!empty($to_word))
		{
		include("word.php");
		exit;
		}
	}
	
foreach($parkCode as $k=>$v)
	{
	$new_parkCode[$v]=$v;
	}

if($level>2)
	{
	$TEMP=array_merge($new_parkCode,$sections);
	$parkCode=$TEMP;
	}
$rename=array("tempID"=>"Submitted by","comment"=>"Activity","website"=>"Web link","region"=>"Region","park_name"=>"Park / Section","park"=>"park_code","title"=>"Title","date"=>"Activity Date");	
$exclude=array("id","tempID","mark","file_name","photo_name","time_stamp","file_link","photo_link");

$month_name=substr($this_year_month,0,-1);

if(empty($park)){$post_park="";}else{$post_park=$park;}
$query_month="Posts for $post_park:<br />".$where_display;


if(empty($_POST))
	{$query_month="Posts in last 30 days.";}
if(!empty($month))
	{$query_month="Posts for $month";}
	
if(!empty($_POST['park_code']))
	{$this_park=$_POST['park_code'];}
	else
	{$this_park="";}
	
echo "<div id='enter' style='display: block'>";
echo "<table border='1' cellpadding='3'>";

echo "<tr><th colspan='3'>$c_enter  $query_month</th>
<th colspan='2'><form action='enter_action.php'>
<input type='submit' name='Submit' value=\"Post an Activity\" onClick=\"submit.this.form()\" style=\"background-color: green; font-size: 130%; color: white;\">
</form></th>";

echo "<td align='left' colspan='2'><form method='POST'>
<table><tr>";

echo "<td>Select Year: 
<select name='year' onchange=\"this.form.submit()\"><option value=\"\" selected></option>\n";
foreach($year_array as $k=>$v)
	{
	if($v==$year){$s="selected";}else{$s="";}
	echo "<option value='$v' $s>$v</option>\n";
	}
echo "</select></td>";

if($level>1)
	{
	$region_array=array("CORE","PIRE","MORE","ADMI");
	echo "<td>Select Region: 
	<select name='region' onchange=\"this.form.submit()\"><option value=\"\" selected></option>\n";
	foreach($region_array as $k=>$v)
		{
		if($v==$region){$s="selected";}else{$s="";}
		echo "<option value='$v' $s>$v</option>\n";
		}
	echo "</select></td>";
	}

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
if($level==1)
	{
	$parkCode=array($_SESSION[$database]['select']=>$_SESSION[$database]['select']);
	if($sess_park=="ARCH" or array_key_exists($sess_park, $sections))
		{
		$parkCode=$sections;
		}
	if(!empty($accessPark_array))
		{
		foreach($accessPark_array as $k=>$v)
			{
			$parkCode[$v]=$v;
			}
		}
	}
if($level==2)
	{
	if(empty($_SESSION[$database]['selectR'])){$_SESSION[$database]['selectR']=$_SESSION[$database]['select'];}
	$parkCode=${"array".$_SESSION[$database]['selectR']};	
	foreach($parkCode as $k=>$v)
		{
		$temp[$v]=$v;
		}
	$parkCode=$temp;
	}
// echo "$level <pre>"; print_r($parkCode); echo "</pre>"; // exit;
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
if(empty($_POST)){$sess_park="";}
echo "<td>Select Park/Section: 
<select name='park' onchange=\"this.form.submit()\"><option value=\"\" selected></option>\n";
foreach($parkCode as $k=>$v)
	{
	if($v==$sess_park){$s="selected";}else{$s="";}
	echo "<option value='$k' $s>$v</option>\n";
	}
echo "</select></td>";


echo "<td align='left'>Select Month: 
<select name='month' onchange=\"this.form.submit()\"><option value=\"any\" selected>Any Month</option>\n";
foreach($month_array as $k=>$v)
	{
	if($k==$month){$s="selected";}else{$s="";}
	echo "<option value='$k' $s>$v</option>\n";
	}
echo "</select></td></form>";

if($level>0)
	{
	echo "<td align='left'><form method='POST' >
	<input type='hidden' name='pass_where' value=\"$where\">
	<input type='button' name='reset' value=\"Word Doc\" onClick=\"this.form.submit()\" style=\"
	background-color: #1f7a1f; color:white; font-size: 100%;\"></form></td>";
	}

echo "<td align='left'><form method='POST' >
<input type='button' name='reset' value=\"Reset\" onClick=\"this.form.submit()\" style=\"
background-color: yellow\"></form></td>";

echo "</tr></table></td></tr>";
if($num<1){$ARRAY=array();}

// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$exclude)){continue;}
			if($fld=="id")
				{echo "<td>View</td>";}
				else
				{
				$var_fld=$rename[$fld];
				echo "<th>$var_fld</th>";
				}
			}
		echo "</tr>";
		}
	if(fmod($index,2)==0){$tr=" bgcolor='aliceblue'";}else{$tr="";}
	echo "<tr$tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$exclude)){continue;}
		if($fld=="id")
			{
			echo "<td><a href='/dprcoe/edit.php?eid=$value' target='_blank'>$value</a></td>";
			continue;
			}
		if($fld=="park")
			{
			if($ARRAY[$index]['tempID']==$user OR $level>3)
				{
				$id=$ARRAY[$index]['id'];
				$display_value=$value;
				if(substr($value, 0,1)=="z")
					{
					$display_value=substr($value,1);
					}	
				$value="<a href=enter_action.php?edit=$id>$display_value</a>";
				}
				else
				{
				if(substr($value, 0,1)=="z")
					{
					$value=substr($value,1);
					}	
				$value="<b>$value</b>";
				}
			}
		if($fld=="region")
			{
			if(substr($value, 0,1)=="z")
				{
				$value="ADMI";
				}		
			}
		
		if($fld=="park_name" and empty($value))
			{
			@$value=$sections[$array['park']];
			}
		if($fld=="title"){$value="<b>$value</b>";}
// 		if($fld=="date"){$value=substr($value,0,-9);}
		if($fld=="website" and !empty($value))
			{
			if(substr($value,0,4)!="http"){$value="http://".$value;}
			$value="<a href='$value' target='_blank'>web page</a>";
			}
		if($fld=="comment")
			{
			$value=str_replace("\r\n","<br />", $value);
			}
		if($fld=="file_link")
			{
			if(!empty($value))
				{
				$var_array=explode("***",$value);
				$var="";
				foreach($var_array as $fk=>$fv)
					{
					$pv=explode("^",$fv);
					$link=$pv[1];
					$fn=$pv[0];
					$exp=explode("/",$link);
					$exp[]="ztn.".array_pop($exp);
					$file=implode("/",$exp);
					$var.="<a href=\"$link\" target='_blank'><img src='$file'>$fn</a><br />";
					}
				$value=$var;
				}
				else
				{$value="";}	
			}
			
		if($fld=="photo_link")
			{
			if(!empty($value))
				{
				$var_array=explode("***",$value);
				$var="";
				foreach($var_array as $fk=>$fv)
					{
					$pv=explode("^",$fv);
					$link=$pv[1];
					$pn=$pv[0];
					$exp=explode("/",$link);
					$exp[]="ztn.".array_pop($exp);
					$photo=implode("/",$exp);
					//$pn
					$var.="<a href=\"$link\" target='_blank'><img src='$photo'></a>";
					}
				$value=$var;
				}
			}
		echo "<td valign='top' align='left'>$value</td>";
		}
	echo "</tr>";
	}
	echo "</table>";
echo "</div>";

if(!empty($ARRAY))
	{unset($ARRAY);}

?>
<?php
$database="inspect";
include("pm_menu.php");
$level=$_SESSION[$database]['level'];

if($level==1){$parkcode=$_SESSION[$database]['select'];}

//echo "<pre>"; print_r($_SESSION); echo "</pre>";// exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";// exit;
//These are placed outside of the webserver directory for security
if($level<1){echo "You do not have authorization for this database."; exit;} // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_parkcodes_dist.php"); // database connection parameters
mysqli_select_db($connection,"inspect");
//include("pm_menu.php");

// *********** Display ***********

echo "<form><table align='center'><tr><td colspan='6' align='center'><h2><font color='red'>Safety Activities</font> in the System by Park by Year</h2></td></tr>";

// ******** Enter your SELECT statement here **********
$sql="Select distinct left(date_inspect,4) as year  From `document` where 1 order by year desc";
 $result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result)){$yearArray[]=$row['year'];}
echo "<tr><td>Year: ";
echo "<select name='passYear'><option></option>";
foreach($yearArray as $k=>$v)
	{
	if($passYear==$v){$o="selected";}else{$o="value";}
	echo "<option $o='$v'>$v</option>";
	}
echo "</select>";
echo "</td>";

$districtArray=array("EADI","NODI","SODI","WEDI");
echo "<td>District: ";
echo "<select name='dist'><option></option>";
foreach($districtArray as $k=>$v)
	{
	if(@$dist==$v){$o="selected";}else{$o="value";}
	echo "<option $o='$v'>$v</option>";
	}
echo "</select>";
echo "</td>";

$parkCode[]="YORK";
echo "<td>Park: ";
echo "<select name='parkcode'><option></option>";
foreach($parkCode as $k=>$v)
	{
	if(@$parkcode==$v){$o="selected";}else{$o="value";}
	echo "<option $o='$v'>$v</option>";
	}
echo "</select>";
echo "</td>";

echo "<td>";
if(!empty($pr63)){echo "<input type='hidden' name='pr63' value='$pr63'>";}
echo "<input type='submit' name='submit' value='Submit'>
</td>";

echo "</tr></table></form>";


if(!$passYear){exit;}

$clause="";

if($level==1){
	$parkcode=$_SESSION['inspect']['select'];
	$clause="and parkcode='$parkcode'";	
	$orderBy="id_inspect,date_inspect desc";
	}

if($level==2){
	$distCode=$_SESSION['inspect']['select'];
	$a="array"; $distArray=${$a.$distCode};
	if($distCode=="NODI" OR $distCode=="SODI")
		{
		$distArray[]="YORK";
		}
	
		foreach($distArray as $key=>$val)
			{
			@$distList.="parkcode='".$val."' OR ";
			}
			$clause=" and (".trim($distList," OR ").")";
		
		
		if(in_array(@$parkcode,$distArray))
			{
			$clause.=" and parkcode='$parkcode'";
			}
	$orderBy="parkcode, id_inspect,date_inspect desc";
	}

if($level>2)
	{
	if(@$dist)
		{
		$a="array"; $distArray=${$a.$dist};

		foreach($distArray as $key=>$val)
			{
			@$distList.="parkcode='".$val."' OR ";
			}
		$clause=" and (".trim($distList," OR ").")";
		}
			
		if(@$parkcode){$clause.=" and parkcode='$parkcode'";}
		
		$orderBy="id_inspect,date_inspect desc";
	}

$sql="Select id,parkcode,id_inspect,UNIX_TIMESTAMP(date_inspect) as date_inspect, comments, pr63, file_link
From `document` where 1 and left(date_inspect,4)='$passYear' $clause
order by $orderBy";

//echo "$sql";

 $result = @mysqli_query($connection,$sql);
 $check="";
while($row=mysqli_fetch_assoc($result))
	{
	if($row['id_inspect']==$check){continue;}
	$ARRAY[]=$row;
	$check=$row['id_inspect'];
	}
@$num_1=count($ARRAY);
$num=mysqli_num_rows($result)."-".$num_1;

//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

if($num<1){echo "<br />$num No inspections for <font color='purple' size='+1'>$parkcode</font> where found.<br /><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='park_entry.php?parkcode=$parkcode'><font size='+2'>Add</font></a> one.";exit;}

$numFields=count($ARRAY[0])+1;
$fieldNames=array_values(array_keys($ARRAY[0]));

//$u = ($num==1 ? 'Area' : 'Areas');

$today=date('Y-m-d');
$last_week_num=date("W", strtotime("-1 week", strtotime(date("Y-m-d"))));
$this_month=date('m');
$last_month_num=date("m", strtotime("-1 month", strtotime(date("Y-m-d"))));
// see below
//$tm=mktime(0,0,0,date("n"),date("j"),date("Y"));
//$last_quarter=ceil(date("m", $tm)/3)-1;
$last_year=date('Y')-1;

echo "<table align='center' border='1' cellpadding='3'><tr>";

ECHO "<tr><td colspan='7' align='center'><font color='green' size='+1'>Only your most recent inspections/meetings are shown.</font><br />To \"Add\" a new record, or to see all previously entered records, click the parkcode for the desired inspection/meeting.</td></tr>";

ECHO "<tr><td colspan='7' align='center'>Today = $today</td></tr>";
ECHO "<tr><td>$num</td><td colspan='3' align='center'><b>Last Week = $last_week_num</b></td>
<td colspan='3' align='center'><b>Last Month = $last_month_num</b></td></tr>";

foreach($fieldNames as $k=>$v)
	{
	$v=str_replace("_"," ",$v);
	//if($v=="date inspect"){$v="<a href=overview.php>$v</a>";}
	//if($v=="id inspect"){$v="<a href=overview.php?ob=subunit>$v</a>";}
	if($v=="id inspect"){$v="Safety action documented";}
	//if($v=="comments"){continue;}
	echo "<th>$v</th>";
	}
echo "</tr>";


$sql="SELECT id,routine_inspect FROM routine order by routine_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
	$routine[$id]=$row['routine_inspect'];
	}

$sql="SELECT id,week_inspect FROM weekly order by week_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
	$week[$id]=$row['week_inspect'];
	}

$sql="SELECT id,month_inspect FROM monthly order by month_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
//	if($row['month_inspect']=="Safety Inspection Form"){continue;}
	$month[$id]=$row['month_inspect'];
	}

$sql="SELECT id,quarter_inspect FROM quarterly order by quarter_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
	$quarter[$id]=$row['quarter_inspect'];
	}

$sql="SELECT id,year_inspect FROM yearly order by year_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$id=$row['id'];
	$year[$id]=$row['year_inspect'];
	}


//****** Get email addresses ********

 // change database 
mysqli_select_db($connection,'dpr_system');
$sql="SELECT parkcode, email FROM dprunit where 1";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$pc=$row['parkcode'];
	$emailArray[$pc]=$row['email'];
	}

$mail="";
$v3="";
foreach($ARRAY as $k=>$v)
	{// each row
	
	echo "<tr>";
		foreach($v as $k1=>$v1){// each field, e.g., $tempID=$v[tempID];
		$f1="";$f2="";
		$id=$ARRAY[$k]['id'];
			
		//	if($k1=="comments"){continue;}
			
			if($k1=="parkcode")
				{
				$trackPark=$v1;
				if(!empty($v_pr63)){$v_pr="&v_pr63=$v_pr63&date_occur=$date_occur&pr_id=$pr_id";}else{$v_pr="";}
				$v1="<a href='park_entry.php?parkcode=$v1&subunit=$v[id_inspect]$v_pr'>$v1</a>";
				}
			
			if($k1=="id_inspect")
				{ //Safety action documented
				if(in_array($v1,$routine)){$v3="routine";}
				if(in_array($v1,$week)){$v3="weekly";}
				if(in_array($v1,$month)){$v3="monthly";}
				if(in_array($v1,$quarter)){$v3="quarterly";}
				if(in_array($v1,$year)){$v3="yearly";}
				}
			
			
			if($k1=="date_inspect")
			{
			if($v1=="0000-00-00"){$v1="";}
			
			
			$v2=date('Y-m-d',$v1);
			
	$compareWeek=date("W",$v1);
			if($v3=="weekly" AND $compareWeek<$last_week_num)
				{
				$f1="<font color='red'>";$f2="</font>";$email=$emailArray[$v['parkcode']];
				$mail="<br /><a href=\"mailto:$email?subject=The $v[parkcode] $v3 $v[id_inspect] is not up to date.\">email</a>";
				}
	
	$compareMonth=date("m",$v1);
	//$test=$compareMonth." ".$last_month_num;
			if($v3=="monthly")
				{
				if($compareMonth!="01")
					{
					if($compareMonth<$last_month_num)
						{
						$f1="<font color='red'>";$f2="</font>";
						$email=$emailArray[$v['parkcode']];
						$mail="<br /><a href=\"mailto:$email?subject=The $v[parkcode] $v3 $v[id_inspect] is not up to date.\">email</a>";
						}
					}
				}
	
				
	$tm=mktime(0,0,0,date("m"),date("d"),date("Y"));
	$last_quarter=ceil(date("m", $tm)/3)-1;
//	$split=explode('-',$v1);
//	$tm=mktime(0,0,0,$split[1],$split[2],$split[0]);

	$compareQuarter=ceil(date("m", $tm)/3);
//	echo "d=$last_quarter<br />c=$compareQuarter";
//	exit;
			if($v3=="quarterly" AND $compareQuarter<$last_quarter)
				{
				$f1="<font color='red'>";$f2="</font>";
				$email=$emailArray[$v['parkcode']];
				$mail="<br /><a href=\"mailto:$email?subject=The $v[parkcode] $v3 $v[id_inspect] is not up to date.\">email</a>";
				}
					
			//$thisMonth="01";$last_year="2008";
	if(@$thisMonth=="01"){$compareYear=date("Y",$v1);		
	
	if($v3=="yearly" AND $compareYear<$last_year)
		{$f1="<font color='red'>";$f2="</font>";}}
			$v1=$v2;
	}// end date_inspect
			
			if($k1=="comments" AND $v1!="")
			{
			$related=substr($v1,0,16);
			$v1="<div id=\"fieldName\"><font size='-1'>$related</font>   ... <a onclick=\"toggleDisplay('fieldDetails[$id]');\" href=\"javascript:void('')\"> details &#177</a> </div>
	
						<div id=\"fieldDetails[$id]\" style=\"display: none\"><br><textarea name='$k1' cols='35' rows='15'>$v1</textarea></div>";
			}
			
			if($k1=="file_link" AND $v1!="")
				{
				$v1=trim($v1,",");
				$var_link=explode(",",$v1);
				foreach($var_link as $kf=>$vf)
					{
					$var_file=explode("/",$vf);
					$file=array_pop($var_file);
					@$temp.="<a href='$vf'>$file</a><br />";
					}
				$v1=$temp;
				}
			
			echo "<td>$f1$v1$f2$mail</td>";
		$mail="";	$temp="";
	}
		
	echo "<td>$v3</td></tr>";
	}

?>
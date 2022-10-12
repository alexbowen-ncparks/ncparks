<?php
ini_set('display_errors',1);
include("../../include/get_parkcodes_reg.php");

$database="hr";
mysqli_select_db($connection,$database);
  
if(empty($_SESSION))
	{session_start();}
$level=$_SESSION['hr']['level'];
if($level<1){exit;}
date_default_timezone_set('America/New_York');
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
// echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
$track_user=$_SESSION['logname'];
if($_SESSION['hr']['beacon']=="60032782"){$_SESSION['hr']['select']="ADMI";}
if($_SESSION['hr']['beacon']=="60033137"){$_SESSION['hr']['select']="ADMI";} // Marketing Specialist
if($_SESSION['hr']['beacon']=="60032877"){$_SESSION['hr']['select']="DEDE";}
if($_SESSION['hr']['beacon']=="60032828")// Head of Res. Management
	{$_SESSION['hr']['select']="USBG";}
if($_SESSION['hr']['beacon']=="60032832")// East Res. Man. Spec.
	{$_SESSION['hr']['select']="USBG";}
if($_SESSION['hr']['beacon']=="60033166") // Community Planner position
	{$_SESSION['hr']['select']="DEDE";}
if($_SESSION['hr']['beacon']=="60095522") // Natural Resources and Planning OA
	{$_SESSION['hr']['select']="PAR3";}
if($_SESSION['hr']['beacon']=="60032794") // Natural Resources and Planning OA
	{$_SESSION['hr']['select']="PAR3";}

//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
// *********** Add Person to a Position *************
IF(@$_POST['submit']=="Add")
	{
	//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
		$user=$_SESSION['logname'];
		$date=date('Ymd');
		$date1=date("Y-m-d");
		// Parse beacon_num
		$bn=explode("-",$_POST['beacon_num']);
			$_POST['beacon_num']=$bn[0];
			//if($bn[1]!=$bn[2]){$position_title=$bn[1]."(".$bn[2].")";}
			//	else{
				$position_title=@$bn[1];
				//}		
			$pay_rate=@$bn[2];
			
			$skip=array("Lname","Fname","track");
		foreach($_POST as $k=>$v){
			if(in_array($k,$skip)){
					if($k=="Lname"){$Lname=$v;}
					continue;}
			if($k!="submit")
				{
				//	if($k=="effective_date"){if($v>$date1){$v=$date1;}}
				if($v==""){@$missing.="[".$k."] ";}
				@$url.="$k=".$v."&";
				if($v)
					{@$string.="$k='".$v."', ";}
				}
		}
		//$string=trim($string,", ");
	$stamp=$user."-".$date;
		$string.="position_title='$position_title', pay_rate='$pay_rate', track='$stamp'";
		$url.="position_title=$position_title&pay_rate=$pay_rate&Lname=$Lname&Fname=$Fname";
		
		if(@$missing)
			{
			echo "You forgot to enter any info for: <font color='red'>$missing</font>";
				if(strpos($missing,"driver_")>0){echo "<br />Enter \"none\" if applicant doesn't have a driver's license.";}
			}
			else
			{
			$query="INSERT into employ_position SET $string";
	//	echo "$query";exit;
			$result = mysqli_query($connection,$query) or die ("Couldn't execute query Update. $query");
			}
		
		//echo "$url";exit;
	header("Location: new_hire.php?Lname=$Lname&submit=Find");
	exit;
	}


// ******* Start Display ********
echo "<html><head>
<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"../../jscalendar/calendar-brown.css\" title=\"calendar-brown.css\" />
  <!-- main calendar program -->
  <script type=\"text/javascript\" src=\"../../jscalendar/calendar.js\"></script>
  <!-- language for the calendar -->
  <script type=\"text/javascript\" src=\"../../jscalendar/lang/calendar-en.js\"></script>
  <!-- the following script defines the Calendar.setup helper function, which makes adding a calendar a matter of 1 or 2 lines of code. -->
  <script type=\"text/javascript\" src=\"../../jscalendar/calendar-setup.js\"></script>";
  
include("../css/TDnull.php");

$sql="Select *  From `sea_employee` where tempID='$tempID' limit 1";
 $result = @mysqli_QUERY($connection,$sql);
// echo "$sql";
$row=mysqli_fetch_assoc($result); 
foreach($row as $k=>$v)
	{
	if($k=="e_verify"){continue;}
	$fields[$k]=$v;
	}
$fields['track']=$track_user;  //echo "$user";

$sql="Select parkcode,beacon_num,effective_date  From `employ_position` where 1 limit 1";
 $result = @mysqli_QUERY($connection,$sql);
// echo "$sql";
$row=mysqli_fetch_assoc($result); 
foreach($row as $k=>$v){
	$fields[$k]=$v;
	}

// Modify for Level 1
if($level==1){
	if($_SESSION['hr']['accessPark'])
		{
		@$_SESSION['hr']['parkS']=$parkcode;
			if(@$parkcode==""){$parkcode=$_SESSION['hr']['select'];}
		}
		else
		{
		$parkcode=$_SESSION['hr']['select'];
		if($parkcode=="WARE")
			{$parkcode="OPAD";}
		}
	
	$where="and parkcode='$parkcode'";
		$budget="y";
		$fields['parkcode']=$parkcode;
		}
		
// Get filled positions
if(!isset($parkcode)){$parkcode="";}
$filled_pos=array();
$sql="Select beacon_num, tempID  From `employ_position` where parkcode='$parkcode' order by tempID";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$filled_pos[$row['tempID']]=$row['beacon_num'];
	}
	
//echo "<pre>"; print_r($filled_pos); echo "</pre>"; // exit;

$numFields=count($fields)-1;

echo "<table align='center'><tr><td colspan='$numFields' align='center'><h2><font color='purple'>Seasonal Employment Tracking</font></h2></td></tr>";

echo "<tr><td colspan='3' align='center'>Return to Seasonal Employee <a href='/hr/new_hire.php'>New Hire</a> Page</td></tr>
</table>";


if(@$budget=="y")
	{
	// PREVIOUS tables
	//seasonal_payroll_next
	//seasonal_payroll_fy
	
	//seasonal_payroll_fiscal_year
		$sql="SELECT beacon_posnum,osbm_title as beacon_title,avg_rate_new as avg_rate
		FROM seasonal_payroll_next
		where center_code='$parkcode' and div_app='y' and park_approve='y'
		order by osbm_title";
// 		echo "$sql";
		$result = mysqli_query($connection,$sql);
		while($row=mysqli_fetch_assoc($result))
			{
			if($row['avg_rate']<1){continue;}
			
			$bn=$row['beacon_posnum'];
			if(in_array($bn,$filled_pos)){continue;} // ignore filled positions for park
			$beaconArray[$row['beacon_posnum']]=$row['beacon_title']."-".$row['avg_rate'];
			}
// 		echo "$sql<pre>"; print_r($beaconArray); echo "</pre>"; // exit;
	/*
	// new query to get ACA hours
		$sql="SELECT beacon_posnum,osbm_title as beacon_title,avg_rate, budget_weeks_a, budget_weeks_b, budget_hrs_a, budget_hrs_b
		FROM seasonal_payroll_next
		where center_code='$parkcode' and div_app='y' and park_approve='y'";
		$result = mysqli_query($sql,$connection);
		while($row=mysqli_fetch_assoc($result))
			{
			if($row['avg_rate']<1){continue;}
			$bn=$row['beacon_posnum'];
			if(in_array($bn,$filled_pos)){continue;} // ignore filled positions for park
			$tot_hours=($row['budget_weeks_a']*$row['budget_hrs_a']) + ($row['budget_weeks_b']*$row['budget_hrs_b']);
			if($tot_hours<1){continue;}
				if($tot_hours >1559)
					{$aca='y';}
				if($tot_hours >1040 and $tot_hours < 1560)
					{$aca='m';}
				if($tot_hours < 1041)
					{$aca='n';}
			$beaconArray[$row['beacon_posnum']]=$row['beacon_title']."-".$row['avg_rate']." (".$tot_hours."=".$aca.")";
			}
		*/
	}
//	else
//	{
//	$beaconArray=array();
//	}

if(!isset($beaconArray)){$beaconArray=array();}
// echo "l=$level";
if($level==1)
	{	
		if($_SESSION['hr']['accessPark'])
			{
			$_SESSION['hr']['parkS']=$parkcode;
			$parkArray=explode(",",$_SESSION['hr']['accessPark']);
			$multiParkMenu="<select name='parkcode' onChange=\"MM_jumpMenu('parent',this,0)\">";
			foreach($parkArray as $k=>$v){
				if($v==$parkcode){$o="selected";}else{$o="value";}
				$multiParkMenu.="<option $o='assign_to_position.php?budget=y&parkcode=$v&tempID=$tempID&submit=Find'>$v</option>";
				}
				$multiParkMenu.="</select>";
			}
			else
			{
			if(!isset($_SESSION['parkS'])){$_SESSION['parkS']="";}
			$parkcode=$_SESSION['parkS'];
// 			if($parkcode=="WARE")
// 				{$parkcode="OPAD";}
			}
	}

if($level==2)
	{
	if(!isset($parkcode)){$parkcode="";}
	$distCode=$_SESSION['hr']['select'];
	$menuList="array".$distCode;
	$parkCode=${$menuList}; sort($parkCode);
	$multiParkMenu="<select name='parkcode' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''></option>";
			foreach($parkCode as $k=>$v){
				if($v=="HIGO"){continue;}
				if($v==$parkcode){$o="selected";}else{$o="value";}
				$multiParkMenu.="<option $o='assign_to_position.php?budget=y&parkcode=$v&tempID=$tempID&submit=Find'>$v</option>";
				}
				$multiParkMenu.="</select>";
	}


if($level>2)
	{
	if(!isset($parkcode)){$parkcode="";}
	$distCode=$_SESSION['hr']['select'];
	$menuList="array".$distCode;
	$parkCode[]="ADMI";
	$parkCode[]="DEDE";
	$parkCode[]="NARA";
	$parkCode[]="OPAD";
	$parkCode[]="PAR3";
	$parkCode[]="USBG";
// 	echo "<pre>"; print_r($parkCode); echo "</pre>"; // exit;
	$multiParkMenu="<select name='parkcode'  onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''></option>";
			foreach($parkCode as $k=>$v){
				if($v=="HIGO"){continue;}
				if($v==$parkcode){$o="selected";}else{$o="value";}
				$multiParkMenu.="<option $o='assign_to_position.php?budget=y&parkcode=$v&tempID=$tempID&submit=Find'>$v</option>";
				}
				$multiParkMenu.="</select>";
	}

echo "<table align='center'><tr><td colspan='7' align='center'><h2>Assign a Person to a Position.</h2></td></tr>

<form action='' method='POST'><tr>";
$j=0;

$skip=array("id","tempID");
//if(!$hideTempID){$skip[]="tempID";}

$blank=array("beacon_num","effective_date","position_title","pay_rate");
$noPass=array("id","M_initial","ssn_last4","driver_license","Lname","Fname","beaconID");

//echo "<pre>"; print_r($fields); echo "</pre>"; // exit;
foreach($fields as $k=>$v)
	{
	$j++;
		if(in_array($k,$skip)){continue;}
		if(array_key_exists($k,$fields) AND !IN_ARRAY($k,$blank))
			{$V=$v;}
			else
			{$V="";}
		$size="";
		if($k=="M_initial"){$size="size='2'";}
		if($k=="pay_rate"){$size="size='6'";}
		if($k=="ssn_last4"){$size="size='6'";}
		
		if($j==7){echo "</tr><tr>";}
		
		if(in_array($k,$noPass)){$inputField="<b>$V</b>";}
			else
		{$inputField="<input type='text' name='$k' value='$V' $size READONLY>";}
		
		if(@$multiParkMenu and $k=="parkcode")
			{
			@$inputField=$multiParkMenu;
			}
		
		if($k=="beacon_num")
			{
			$inputField="<select name='beacon_num'><option selected=''></option>";
			if(!isset($beacon_num)){$beacon_num="";}
			foreach($beaconArray as $key=>$val)
				{
				if($key==$beacon_num){$o="selected";}else{$o="value";}
				$val=$key."-".$val;
				$inputField.="<option $o='$val'>$val</option>";
				}
			$inputField.="</select><br />";
			if(!empty($filled_pos))
				{
				$inputField.="Filled Positions:<table>";
				foreach($filled_pos as $k1=>$v1)
					{
					$inputField.="<tr><td>$k1 = $v1</td></tr>";
					}
				$inputField.="</table>"; // exit;
				}
			}
		if($k=="effective_date")
			{
			if(!isset($effective_date)){$effective_date="";}
				$inputField="<img src=\"../../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
      onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />&nbsp;<input type='text' name='effective_date' value='$effective_date' size='12' id=\"f_date_c\" READONLY>";
			}
		if($k=="effective_date"){$k="start_date";}
		echo "<td align='center' valign='top'>$k<br />$inputField</td>";
	}
$Lname=$fields['Lname'];
$Fname=$fields['Fname'];
echo "<td align='center'>
<input type='hidden' name='tempID' value='$tempID'>
<input type='hidden' name='Lname' value='$Lname'>
<input type='hidden' name='Fname' value='$Fname'>
<input type='submit' name='submit' value='Add'>
</td></tr></form>

<script type=\"text/javascript\">
    Calendar.setup({
        inputField     :    \"f_date_c\",     // id of the input field
        ifFormat       :    \"%Y-%m-%d\",      // format of the input field
        button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
        align          :    \"Tl\",           // alignment (defaults to \"Bl\")
        singleClick    :    true
	    });
	</script>
</html>";

?>

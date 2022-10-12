<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}
$purchase_center_code=$_SESSION['budget']['center_code'];
$purchase_section=$_SESSION['budget']['center_section'];

if(!@$report_date AND !@$pa_number AND !@$re_number)
	{
	$database="budget";
	$db="budget";
	include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
	mysqli_select_db($connection, $database); // database
	include("../../../include/authBUDGET.inc");
	include("../../../include/activity.php");
	include("../menu.php");
	extract($_REQUEST);
	
	$level=$_SESSION['budget']['level'];
	$thisUser=$_SESSION['budget']['tempID'];
	$center=$_SESSION['budget']['centerSess'];
	}

//if($level>4){echo "<pre>"; print_r($_REQUEST); echo "</pre>";  }
$today=date("Y-m-d");
echo "today=$today";
$sql="update purchase_approval_report_dates
      set active='y' where system_start <= '$today' ";
	  
//echo "<br />sql Line 30: $sql<br />";	  
	  
$result=mysqli_query($connection, $sql,$connection);

$sql="select max(report_date) as 'current_report_date' from purchase_approval_report_dates
      where active='y' ";
	  
$result=mysqli_query($connection, $sql,$connection);	  

$row=mysqli_fetch_array($result);
extract($row);//brings back max (end_date) as $end_date
	  
	  
if($report_date==''){$report_date=$current_report_date ;}
if($section==''){$section=$purchase_section ;}
if($center_code==''){$center_code=$purchase_center_code ;}
	  
echo "<br />report_date=$report_date<br />";	  
	  





echo "<table border='1' cellpadding='5'><tr><td colspan='5' align='center'>Pre-approval Purchase List by Report Date:";
$sql="select distinct report_date
from purchase_approval_report_dates
where 1 and active='y'
order by report_date desc;
";
$result=mysqli_query($connection, $sql,$connection);
while($row=mysqli_fetch_array($result)){
	$menuArray[]=$row['report_date'];
	$report_dateArray=$menuArray;
}

$c=count($menuArray)-1;
$date_range=$menuArray[$c]."*".$menuArray[0];

if(!isset($report_date)){$report_date="";}
if(strpos($report_date,"*")>-1){$date_range=@$report_date;}
	else{}


echo "<form method='post'><select name='report_date' onChange=\"MM_jumpMenu('parent',this,0)\">";
echo "<option></option>";
      foreach($menuArray as $k=>$v){
       if($report_date==$v){$s="selected";}else{$s="value";}
		echo "<option $s='park_purchase_request_menu.php?report_date=$v'>$v</option>";
       }
echo "</select>";

echo "</form></td>";

//if($level>3){
unset($menuArray);
	$sql="Select distinct purchase_type
	From purchase_request_3
	Order by purchase_type;
	";
	$result=mysqli_query($connection, $sql,$connection);
	while($row=mysqli_fetch_array($result)){
		$menuArray[]=$row['purchase_type'];
		$purchase_type_array=$menuArray;
	}

		echo "<td align='right'><form>
		Purchase Type: <select name='purchase_type'>";
			echo "<option></option>";
   			   foreach($menuArray as $k=>$v){
 			      if(@$purchase_type==$v){$s="selected";}else{$s="value";}
			echo "<option $s='$v'>$v</option>";
 		      }

if(!isset($section)){$section="";}
if(!isset($district)){$district="";}
if(!isset($date_range)){$date_range="";}
			echo "</select><br />
		Hyphens in date are optional. <br />
		<input type='text' name='report_date' value='$date_range'>
		<input type='hidden' name='section' value='$section'>
		<input type='hidden' name='district' value='$district'>
		<input type='submit' name='submit' value='Submit'>
		</form></td>";
//		}
		
if(@$report_date AND ($level>2)){
unset($menuArray);
$sql="select distinct section
from center
where 1
and center.actcenteryn='y'
and center like '%1280%'
order by section asc;
";
$result=mysqli_query($connection, $sql,$connection);
while($row=mysqli_fetch_array($result)){ $menuArray[]=$row['section'];
}

echo "<td><form method='post'>Section:<br /><select name='section' onChange=\"MM_jumpMenu('parent',this,0)\">";
echo "<option></option>";
      foreach($menuArray as $k=>$v){
       if($section==$v){$s="selected";}else{$s="value";}
		echo "<option $s='park_purchase_request_menu.php?report_date=$report_date&section=$v'>$v</option>";
       }
echo "</select>";

echo "</form></td>";
}

if(($level>1 AND $section=="operations") OR ($level==2)){
unset($menuArray);
$menuArray=array("east","north","south","west","STWD");

$sql="select distinct center_code
from purchase_request_3
where 1
order by center_code;
";
$result=mysqli_query($connection, $sql,$connection);
while($row=mysqli_fetch_array($result)){ $parkMenuArray[]=$row['center_code'];
}


echo "<td><form method='post'>District:<br /><select name='district' onChange=\"MM_jumpMenu('parent',this,0)\">";
echo "<option></option>";
      foreach($menuArray as $k=>$v){
       if($district==$v){$s="selected";}else{$s="value";}
		echo "<option $s='park_purchase_request_menu.php?report_date=$report_date&section=operations&district=$v'>$v</option>";
       }
echo "</select>";

echo "</form></td>";

echo "<td><form method='post'>Center Code:<br /><select name='center_code' onChange=\"MM_jumpMenu('parent',this,0)\">";
echo "<option></option>";
      foreach($parkMenuArray as $k=>$v){
       if($center_code==$v){$s="selected";}else{$s="value";}
		echo "<option $s='park_purchase_request_menu.php?report_date=$report_date&section=operations&center_code=$v'>$v</option>";
       }
echo "</select>";

echo "</form></td>";
}

echo "<td><a href='park_purchase_request.php?submit=Submit'>New Request</a></td>";

if(!isset($pa_number)){$pa_number="";}
if(!isset($re_number)){$re_number="";}
echo "<td align='right'><form action='park_purchase_request_view.php'>
PA# <input type='text' name='pa_number' value='$pa_number' size='6'><br />
RE# <input type='text' name='re_number' value='$re_number' size='6'><br />
<input type='submit' name='submit' value='Find'>
</form>
</td>";

if($level>4){

// Block 6
echo "<td align='center'><font color='red'>$message1<br />CAUTION!!</font><form method='post' action='park_purchase_request_update_Div_all.php'>Set Div. Approved Status<br /><font color='blue'>equal</font> Section Approved Status<br /><select name='division_approve'>";
echo "<option></option>";
      foreach($report_dateArray as $k=>$v){
       if($report_date==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>";
       }
echo "</select>";
echo "<input type='submit' name='submit' value='Update'>";
echo "</form></td>";


// Block 7
echo "<td align='center'><font color='red'>$message3</font><form method='post' action='park_purchase_request_update_Div_RE.php'>Update RE Values<br />by Purchase Type<br />";

echo "<select name='report_date'>";
echo "<option></option>";
      foreach($report_dateArray as $k=>$v){
       if($report_date==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>";
       }
echo "</select><br />";

echo "<select name='purchase_type'>";
echo "<option></option>";
      foreach($purchase_type_array as $k=>$v){
//       if($purchase_type==$v){$s="selected";}else{$s="value";}
		$s="value";
		echo "<option $s='$v'>$v</option>";
       }
echo "</select>";

echo "<br />RE# <input type='text' name='re_number' value='$re_number' size='6'>";


echo "<input type='submit' name='submit' value='Update'>";
echo "</form></td>";


// Block 8
echo "<td align='center'><font color='red'>$message2</font><form method='post' action='park_purchase_request_update_Div_all.php'>Update Invoice & PCARD Modules<br />for PA Approvals<br /><select name='pa_approvals'>";
echo "<option></option>";
      foreach($report_dateArray as $k=>$v){
       if($report_date==$v){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v</option>";
       }
echo "</select>";
echo "<input type='submit' name='submit' value='Update'>";
echo "</form></td>";
}// end level>4

echo "</tr></table>";

/*
if(!@$report_date AND !@$pa_number AND !@$re_number){echo "<table><tr><td bgcolor='white'><font color='red'>All Budget Contacts:
<br><br>
This NEW (Updated 2/21/14) Weekly Pre-Approval process is for purchases greater than $500 . <u><b>The following items are excluded:</b></u></font><br><br>&nbsp;&nbsp;&nbsp;1) Travel/Training/Certification Purchases (Approved thru other processes)
<br><br>&nbsp;&nbsp;&nbsp;2)Purchases for Utilities: a)water  b)sewer  c)electricity  d)gas  e)propane  f)oil  g)waste removal h)other Utilities
<br><br>
&nbsp;&nbsp;&nbsp;3)Purchases for Approved Projects (Major Maintenance, Trail Maintenance, Capital Improvement, etc)
<br><br>
&nbsp;&nbsp;&nbsp;4)Equipment items (Approved thru other processes)</td></tr>";}
*/

if(!@$report_date AND !@$pa_number AND !@$re_number){echo "<table><tr><td bgcolor='white'><font color='red'>All Budget Contacts: (Updated 4/11/14) 
<br><br>
This NEW Weekly Pre-Approval process is for ALL Purchases. <u><b>The following items are excluded:</b></u></font>
<br><br>&nbsp;&nbsp;&nbsp;1)Purchases for Utilities: a)water  b)sewer  c)electricity  d)gas  e)propane  f)oil  g)waste removal h)other Utilities <br />&nbsp;&nbsp;&nbsp;&nbsp;i) Postage
<br><br>
&nbsp;&nbsp;&nbsp;2)Purchases for Approved CI Projects (Major Maintenance, Trail Maintenance, Capital Improvement, etc)<br /><br />3)<font color='red'>Emergency purchases</font> are permitted without prior approval. However, emergency requests should be limited & must be entered into pre-approval database. Enter emergency requests with a purchase type of \"emergency\" 
</td></tr></table>";}



		if(@$district){$passDist="&district=$district";}else{$passDist="";}
		if(@$section){$passSect="&section=$section";}else{$passSect="";}
		if(@$center_code){$passCent="&center_code=$center_code";}else{$passCent="";}
		if(@$purchase_type){$passPurc="&purchase_type=$purchase_type";}else{$passPurc="";}
if($level<3){
	if($report_date)
		{
		echo "<table border='2'><tr><td><a href='park_purchase_request_view.php?view=approved&report_date=$report_date&submit=Submit$passDist$passSect$passCent$passPurc'>View Approved</a></td>
		<td><a href='park_purchase_request_view.php?view=all&report_date=$report_date&submit=Submit$passDist$passSect$passCent$passPurc'>View All</a></td>
		<td><a href='park_purchase_request_view.php?view=pending&report_date=$report_date&submit=Submit$passDist$passSect$passCent$passPurc'>View Pending</a></td>
		<td><a href='park_purchase_request_view.php?view=denied&report_date=$report_date&submit=Submit$passDist$passSect$passCent$passPurc'>View Denied</a></td>
		</tr></table>";
		}
}

if($level==3 || $level==4){
	if($report_date AND $section){
	echo "<table border='2'><tr><td><a href='park_purchase_request_view.php?view=approved&report_date=$report_date&submit=Submit$passDist$passSect$passCent$passPurc'>View Approved</a></td>
	<td><a href='park_purchase_request_view.php?view=all&report_date=$report_date&submit=Submit$passDist$passSect$passCent$passPurc'>View All</a></td>
	<td><a href='park_purchase_request_view.php?view=pending&report_date=$report_date&submit=Submit$passDist$passSect$passCent$passPurc'>View Pending</a></td>
	<td><a href='park_purchase_request_view.php?view=denied&report_date=$report_date&submit=Submit$passDist$passSect$passCent$passPurc'>View Denied</a></td>
	</tr></table>";}
}

if($level>4){
	if($report_date){
	echo "<table border='2'><tr><td><a href='park_purchase_request_view.php?view=approved&report_date=$report_date&submit=Submit$passDist$passSect$passCent$passPurc'>View Approved</a></td>
	<td><a href='park_purchase_request_view.php?view=all&report_date=$report_date&submit=Submit$passDist$passSect$passCent$passPurc'>View All</a></td>
	<td><a href='park_purchase_request_view.php?view=pending&report_date=$report_date&submit=Submit$passDist$passSect$passCent$passPurc'>View Pending</a></td>
	<td><a href='park_purchase_request_view.php?view=denied&report_date=$report_date&submit=Submit$passDist$passSect$passCent$passPurc'>View Denied</a></td>
	</tr></table>";}
}
?>




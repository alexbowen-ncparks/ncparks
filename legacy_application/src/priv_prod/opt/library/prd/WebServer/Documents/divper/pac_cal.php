<?php
extract($_REQUEST); 
//These are placed outside of the webserver directory for security
//include("../../include/authDIVPER.inc"); // used to authenticate users
$database="pac_cal";
date_default_timezone_set('America/New_York');
include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_parkcodes_reg.php");

mysqli_select_db($connection,$database);
$setDate=1;  // used in TDnull.php to enable JavaScript calendar

include("menu.php");
//session_start();
$level=$_SESSION['divper']['level'];
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

// ***** Update ******
if($_POST){//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;

	if($_POST['submit']=="Update"){
		foreach($_POST as $field=>$value){
		if($field!="submit" AND $field!="id"){
			if($field=="attending"){
				foreach($value as $attendKey=>$attendValue){
					$attend.=$attendValue.",";
					}
					$value=trim($attend,",");
				}
// 			$clause.=$field."='".mysqli_real_escape_string($value)."',";}
			$clause.=$field."='".$value."',";}
		}
			if(!$attend){$clause.="attending=''";}
		$clause=trim($clause,",");//echo "$clause";
		$id=$_POST['id'];
		$sql="UPDATE meetings SET $clause WHERE id='$id'";//echo "$sql";exit;
		$result = @mysqli_query($connection,$sql) or die("$sql<br>c=$connection". mysqli_errno($connection) . ": " . mysqli_error($connection));
		
		}
		
	if($_POST['submit']=="Add"){
	 $sql = "SELECT * FROM chop_comment";
//  echo "$sql";exit;
$result = @mysqli_query($connection,$sql);
$row=mysqli_fetch_array($result);extract($row);
		foreach($_POST as $field=>$value){
		if($field!="submit" AND $field!="id"){
			if($field=="parkcode"){if($level==2){// restrict district
					$dist=$_SESSION['parkS'];
					$a="array";
					$varArray=${$a.$dist};
					if(!in_array($parkcode,$varArray)){
						exit;
						}
					}
					
				$value=strtoupper($value);
				if(in_array($value,$arraySODI)){$clause.="dist='SODI',";}
				if(in_array($value,$arrayNODI)){$clause.="dist='NODI',";}
				if(in_array($value,$arrayEADI)){$clause.="dist='EADI',";}
				if(in_array($value,$arrayWEDI)){$clause.="dist='WEDI',";}
			}
// 			$clause.=$field."='".mysqli_real_escape_string($value)."',";}
			$clause.=$field."='".$value."',";}
		}
// 		$clause.="CHOP_comment='".mysqli_real_escape_string($chop)."'";
		$clause.="CHOP_comment='".$chop."'";
		
		$clause=trim($clause,",");//echo "$clause";
		$sql="INSERT into meetings SET $clause";//echo "$sql";
		$result = @mysqli_query($connection,$sql) or die("$sql<br>c=$connection". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
	if($_POST['submit']=="Delete"){
		$id=$_POST['id'];
		$sql="DELETE FROM meetings WHERE id='$id'";//echo "$sql";
		$result = @mysqli_query($connection,$sql) or die("$sql<br>c=$connection". mysqli_errno($connection) . ": " . mysqli_error($connection));
		}
	}// POST

// ***** Build Where ********
if(@$dist){$where="and dist='$dist'";}
if(@$parkcode){$where="and parkcode='$parkcode'";}
if(@$edit){$where="and id='$edit'";}

if($level<2){
	if($_SESSION['divper']['accessPark']){
		$checkPark=explode(",",$_SESSION['divper']['accessPark']);
		if(in_array($parkcode,$checkPark)){
		$where.=" and parkcode='$parkcode'";}
			else{
				$parkcode=$_SESSION['parkS'];
				$where.=" and parkcode='$parkcode'";}
		}
		else
		{
	$parkcode=$_SESSION['parkS'];}
	$where.=" and parkcode='$parkcode'";}

if($level==2){
	$dist=$_SESSION['parkS'];
	$where.=" and dist='$dist'";}

$sql = "SELECT * From meetings
Where 1 
Limit 1";
$result = @mysqli_query($connection,$sql) or die("$sql<br>". mysqli_errno($connection) . ": " . mysqli_error($connection));
//echo "$sql";
while($row=mysqli_fetch_assoc($result)){
		$a[]=$row;
		}


echo "<html><head><title> Calendar of PAC Meetings</title></head>
<body bgcolor='beige'>";


// ******* Add Date **********
$addArray=array("parkcode","meeting_date");
echo "<table align='center'><tr>";
foreach($a[0] as $k=>$v){	
	if(in_array($k,$addArray)){echo "<th>$k</th>";}
	}
echo "</tr>";


echo "<form method='POST'>";
echo "<tr>";
if($tempLevel<2){$v=$parkcode; $RO="READONLY";}else{$RO="";}
	
	echo "<td align='center'><img src=\"../../jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
      onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />
      <input type='text' name='meeting_date' value='' size='10' id=\"f_date_c\" READONLY></td>";
	
	echo "<td><input type='text' name='parkcode' value='$v' size='8' $RO></td>";
	
	echo "<td>
	<input type='submit' name='submit' value='Add'>
	</td>";
echo "</tr></table></form><hr>";

echo "<script type=\"text/javascript\">
    Calendar.setup({
        inputField     :    \"f_date_c\",     // id of the input field
        ifFormat       :    \"%Y-%m-%d\",      // format of the input field
        button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
        align          :    \"Tl\",           // alignment (defaults to \"Bl\")
        singleClick    :    true
    });
</script>";
// ********** Filters *************
echo "<form action='pac_cal.php'><table><tr>";

if($level>1){

$distArray=array("EADI","NODI","SODI","WEDI");
echo "<td>Filter Calendar by: </td>";

echo "<td align='center'>District<br /><select onChange=\"MM_jumpMenu('parent',this,0)\">
<option value='pac_cal.php'></option>";
foreach($distArray as $k=>$v)
	{
	if(@$dist==$v){$o="selected";}else{$o="value";}
	echo "<option $o='pac_cal.php?dist=$v'>$v</option>";
	}
	echo "</select>
</td>";


echo "<td align='center'>Park<br />
<select onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''></option>";
foreach($parkCode as $k=>$v)
	{
	if(@$parkcode==$v){$o="selected";}else{$o="value";}
	echo "<option $o='pac_cal.php?parkcode=$v'>$v</option>";
	}
	echo "</select>
</td>";
}
echo "<td>Display <a href='pac_cal.php'>All</a></td>";

if($level>3){echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Edit default CHOP <a href='pac_chop_comment.php' target='_blank'>comment</a> and file upload.</td>";}

echo "</tr></table></form>";


// ****** SELECTION **********
if(!isset($where)){$where="";}
$sql = "SELECT * From meetings
Where 1 $where
ORDER BY meeting_date desc";
$result = @mysqli_query($connection,$sql) or die("$sql<br>". mysqli_errno($connection) . ": " . mysqli_error($connection));
//echo "$sql";

if(mysqli_num_rows($result)<1){exit;}
while($row=mysqli_fetch_assoc($result))
	{
	$b[]=$row;
	}
		
echo "<hr><table border='1' cellpadding='5'><tr>";
foreach($b[0] as $k=>$v){
	if($k=="attending"){
		if(@$edit){continue;}
		}
	echo "<th>$k</th>";}
echo "</tr>";

$editArray=array("meeting_date","PASU_comment","CHOP_comment");
$textArray=array("PASU_comment","CHOP_comment");

if(@$edit!=""){echo "<form method='POST'>";}

$database="divper";
mysqli_select_db($connection,$database);

foreach($b as $i=>$val_array)
	{
		$RO="";
			echo "<tr>";
			foreach($val_array as $field=>$value)
				{
				if($field=="attending")
					{
					if(@$edit){continue;}
					}
				if($field=="meeting_date")
					{
					if(@$edit!="" AND @$edit==$b[$i]['id'])
						{
						$RO="READONLY";
//		$database="divper";
//		include("../../include/connectROOT.inc"); // database connection parameters
						$park=$b[$i]['parkcode'];
						$sql_1="SELECT labels.First_name, labels.Last_name, labels.pac_terminates,labels.interest_group
						from labels
						LEFT JOIN labels_affiliation as t1 on t1.person_id=labels.id LEFT JOIN labels_category as t2 on t2.affiliation_code=t1.affiliation_code
						where 1 and park='$park' AND (t1.affiliation_code='PAC') group by labels.id order by park,t1.affiliation_code,Last_name";
						$result_1 = @mysqli_query($connection,$sql_1);
						while($row_1=mysqli_fetch_assoc($result_1)){$c[]=$row_1;}
					//	echo "<pre>"; print_r($c); echo "</pre>"; // exit;
						}
						else
						{$adate=strftime('%b %e, %Y - %a',strtotime($b[$i][$field]));					
						if(substr("$adate", -3,-2)=="S"){$value="<font color = 'red'>$adate</font>";} ELSE {$value="<font color = 'green'>$adate</font>";}
						}
				
					}
					
				if($field=="id"){$value="<a href='pac_cal.php?edit=$value'>Edit</a>";}
				
				if(@$edit!="" AND @$edit==$b[$i]['id'] AND in_array($field,$editArray))
					{// Edit
						if(in_array($field,$textArray)){
							echo "<td><textarea name='$field' rows='35' cols='30'>$value</textarea>";}
							
							else{
					$pid=$b[$i]['id'];
					
					if($field=="meeting_date"){
					$passAttendees[$pid]=$b[$i]['attending'];
					$checkAttendees=explode(",",$passAttendees[$pid]);
					
						foreach($c as $cKey=>$cVal)
							{
							$fullName=$cVal['First_name']." ".$cVal['Last_name'];
							if(in_array($fullName,$checkAttendees)){$ck="checked";}
								else{$ck="";}
							$name="<input type='checkbox' name='attending[]' value=\"$fullName\" $ck>";
							$name.="<b>".$cVal['First_name']." ".$cVal['Last_name']."</b>";
							$name.="<br />&nbsp;&nbsp;&nbsp;".$cVal['interest_group'];
							$name.="<br />&nbsp;&nbsp;&nbsp;term ends: ".$cVal['pac_terminates'];
							
							@$addMembers.="$name<br />";
							
							}
							
							echo "<td valign='top'><input type='text' name='$field' 	value='$value' $RO><br /><br />$addMembers</td>";
						unset($addMembers);
						
						}// end field=meeting_date			
	
						}
						
					}
					else
					{// Display
					if($field=="file_link" AND $value!=""){
			$links="";
			$file_link=trim($value,",");
			$files=explode(",",$file_link);
			foreach($files as $kf=>$kv)
				{
				$f=explode("/",$kv);
				$links.="<font color='green'>$f[2]</font><br /><a href='$kv' target='_blank'>View</a>";
				if(@$edit)
					{
					$links.="&nbsp;&nbsp;&nbsp;&nbsp;<a href='dpr_pac_meet_del_file?link=$kv&id=$edit' onClick='return confirmLink()'>Delete</a>";
					}
				$links.="<br /><br />";
				}
			$value=$links;
			$links="";
			
	
						}
				echo "<td valign='top'>$value</td>";
					}
				}
				
				if(@$edit!="" AND @$edit==$b[$i]['id'])
					{
					$button="<td>
					<input type='hidden' name='id' value='$edit'>
					<input type='submit' name='submit' value='Update'><br /><br />
					<input type='submit' name='submit' value='Delete' onClick='return confirmLink()'>
					</td>";
					}
					else
					{
					$button="";
					}
				
			echo "$button</tr>";
			
			}

if(@$edit!=""){echo "</form>";}


		if(@$edit!="" AND @$edit==$b[$i]['id'])
			{
			$parkcode=$b[$i]['parkcode'];
			echo "<tr><td valign='top' colspan='8' align='center'><b>FILE UPLOAD</b>
				<form method='post' action='dpr_pac_meet_add_file.php' enctype='multipart/form-data'>
	
			<INPUT TYPE='hidden' name='id' value='$pid'>
			<br>1. Click to select your file. 
			<input type='file' name='file_upload'  size='40'><br />
			2. Then click this button. 
			<input type='hidden' name='parkcode' value='$parkcode'>
			<input type='submit' name='submit' value='Add File'>
			</form></td></tr>";
			}

echo "</table>
</body></html>";
?>
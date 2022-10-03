<?php
$database="award";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       extract($_REQUEST);
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

 if(@$del=="y")
       		{
			$sql = "SELECT $fld FROM award_list where id='$id'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); $row=mysqli_fetch_assoc($result);
			unlink($row[$fld]);
			$sql = "UPDATE award_list set $fld='' where id='$id'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
//echo "$sql"; exit;			
       			header("Location:edit.php?edit=$id&submit=edit");
       		exit;
       		}
$file_name=$_SERVER["PHP_SELF"];  		
include("menu.php");

$check_tempID=$_SESSION['award']['tempID'];
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;


if(@$_POST['submit']=="Delete")
		{
		$sql = "DELETE FROM award_list where id='$_POST[id]'";
//echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		echo "Record was successfully deleted.";exit;
		}
       
if(@$_POST['submit']=="Update")
		{
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
		$skip1=array("year","month","day","submit","id","category_standard");
		$skip2=array("submit","id");
	
	//		if($_POST['category']==3)
	//			{$_POST['category']=$_POST['category_standard'];}
				
			foreach($_POST AS $num=>$array)
				{
				
				if($_POST['category']<3 AND $num=="category_standard")
				{continue;}
				
				
				$test=explode("-",$num);
				if(in_array($test[0],$skip1)){continue;}
				if($num=="dpr"){$pass_dpr=$array;}
				
// 				$array=addslashes($array);
				if($num=="requested_by")
					{@$clause.=$num."=concat(requested_by,',','$array')";}
					else
					{@$clause.="`".$num."`='".$array."',";}			
				}
				
				// menu.php has the javascript that controls calendars				//"date_needed"=>'2',"approv_PASU"=>'3',
$date_array=array("approv_DISU"=>'1',"approv_CHOP_DIR"=>'2',"approv_PIO"=>'3',"approv_BPA"=>'4',"staff_notify"=>'5');
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;			
		foreach($_POST AS $k=>$v)
					{
				if(in_array($k,$skip2))
					{continue;}
				foreach($date_array as $k1=>$v1)
					{
					if($k=="year-field".$v1)
						{$temp=$k1."='".$v."-";}
					if($k=="month-field".$v1)
						{@$temp.=$v."-";}
					if($k=="day-field".$v1)
						{@$temp.=$v."',";}
						
					@$clause.=$temp; $temp="";
					}
		
				}	
				
				$id=$_POST['id'];
				if(!isset($blank_cat)){$blank_cat="";}
				$clause="set ".rtrim($clause,",")." $blank_cat where id='$id'";
		$sql = "Update award_list $clause";
//echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); 
		$clause="";
				
			// ****** uploads
			include("upload_code.php");
			
		$edit=$id;
		$message="<tr><td colspan='2'><font color='purple'>Update was successful.</font></td></tr>";
		}
       
$display_fields="*";

if(@$edit)
	{
	if($level<2)
		{
		$rb=$_SESSION['award']['tempID'];
	$clause1="requested_by like '$rb%'";
	@$clause.=" AND (".$clause1.")";
		}
	if(!isset($clause)){$clause="";}
	$sql = "SELECT $display_fields FROM award_list as t1 
	WHERE  id='$edit' $clause
	";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1)
		{
		echo "No record found for id=$edit. $sql"; //exit;
		}
	
	while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
	}

	$sql = "SELECT * FROM category as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$category_array[$row['name']]=$row['id'];
		}
	
	$sql = "SELECT * FROM status as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$status_array[$row['name']]=$row['name'];
		}
	
		
	$sql = "SELECT * FROM district as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$district_array[$row['name']]=$row['name'];
		}	
			
	$sql = "SELECT * FROM region as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$region_array[$row['name']]=$row['name'];
		}	
		
	$sql = "SELECT * FROM members as t1 
	WHERE  1 order by id"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No members have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$rep=trim(substr($row['represent'],0,4));
		if(strlen(rtrim($rep))<4){$rep.="_";}
		$member_array[$rep]=$row;
		}	
// echo "<pre>"; print_r($member_array); echo "</pre>";		

mysqli_select_db($connection,"divper");
$tempID=$_SESSION[$database]['tempID'];
	$sql = "SELECT Fname,Lname FROM empinfo
	WHERE  tempID='$tempID'";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	$row=mysqli_fetch_assoc($result);
	$check_men=$row['Fname']." ".$row['Lname'];
//echo "<pre>"; print_r($row); echo "</pre>"; // exit;

mysqli_select_db($connection,$database);		
echo "<body bgcolor='beige' class=\"yui-skin-sam\">";

	if(@$message==1)
		{
		echo "<font size='+2' color='red'>Your nomination has been entered.<br />Review for completeness/correctness.</font><br />If everything looks OK, you can click on the \"Track an Award Nominatin\" button to confirm its submission.";
		}
	
if(@$edit){$action="edit.php";}else{$action="add_request.php";}

ECHO "<form name='myForm' action='$action' onsubmit='return valFrm()' method='POST' enctype='multipart/form-data'>";

echo "<table><tr><td><table cellpadding='5' border='1' bgcolor='aliceblue'>";

$skip=array("id","SR","register","response","other_file_1","other_file_2","other_file_3","other_file_4","cr_form","outside_vendor_details","disu_chop_comment","SODI_rep");

// $radio=array("category","status","WEDI_rep","SODI_rep","EADI_rep","NODI_rep","Raleigh_rep","PIO_rep","DIRE_rep","I&E_rep","NARE_rep");

$radio=array("category","status","MORE_rep","PIRE_rep","CORE_rep","Raleigh_rep","PIO_rep","DIRE_rep","I&E_rep","NARE_rep","STWD_rep");

$rep_array=array("Yes","No","Abstain");

$pull_down=array("district","region");

$read_only=array("dpr","requested_by","date_of_request");

// menu.php has the javascript that controls calendars
if($level==1)
	{
	$access=$_SESSION['award']['accessPark'];
	$location_array=explode(",",$access);
	$park_count=count($location_array);
	if($park_count>1){$pull_down[]="location";}
	$read_only=array("location","id","dpr","requested_by","date_of_request","status");
	}
if($level==2)
	{
	$date_array=array("approv_DISU"=>'4',);	//,"approv_PASU"=>'3'
	$read_only=array("id","dpr","requested_by","date_of_request","status");
	}
if($level>2)
	{
	//"date_needed"=>'2',"approv_PASU"=>'3',
	$date_array=array("award_ordered_date");

$read_only=array("requested_by","date_of_request");
	}

if(empty($ARRAY)){$sql = "SHOW COLUMNS FROM award_list";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1)
		{
		echo "No record found for id=$edit."; //exit;
		}
	
	while($row=mysqli_fetch_assoc($result))
		{
		$array[$row['Field']]="";
		}
		$ARRAY[]=$array;
//	echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	}
	
foreach($ARRAY as $num=>$row)
	{
	foreach($row as $fld=>$value)
		{
		
		if(in_array($fld,$skip)){continue;}
		if($fld=="status" AND $level<2){continue;}
			if(@$edit=="")
				{
				$value="";
					if($fld=="dpr")
					{
					$sql = "SELECT $fld FROM award_list
					WHERE 1 order by $fld desc limit 1
					";// echo "$sql";
					$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
					$row=mysqli_fetch_assoc($result);
					$value=$row[$fld];
					if($value==""){$value="000";}				
				$pad=str_pad((substr($value,-3)+1),3,0,STR_PAD_LEFT);
//	echo "p=$pad";
					if($pad=="000" OR empty($pad)){$pad="001";}
					$value="AN_";
					$value.=$pad;
					$pass_dpr=$value;
					}
				}
		$RO="";						
		if(in_array($fld,$read_only))
			{
			if($fld=="status" AND $level<4)
				{$RO="disabled";}else{$RO=" readonly";}
			}
			
							
		if(in_array($fld,$radio))
			{
			if($level<4 AND !empty($ARRAY[$num]['status'])){$RO="disabled";}
			if($ARRAY[$num]['status']=="" AND $fld=="category")
				{$RO="";}
			if($submit=="Submit an Award Nomination" AND $fld=="category")
				{$RO="";}
			}
			
		$rename=$fld;
		$explain="";//	$explain="Do not enter a $ sign.";
		if($fld=="location")
			{
			$rename="4-letter park code<br />or section name of Nominee";
			if($level==1){$value=$_SESSION['award']['select'];}
			$pass_location=$value;
			}
		if($fld=="email")
			{
			$rename="nominator email";
			$explain="Necessary in order to notify you upon receipt of nomination.";
			$email=$value;
			}
		if($fld=="nom_name")
			{
			$rename="Name of nominee";
			$explain="(if nominee is not an individual, include a contact person for that group in the justification field.)";
			}
		if($fld=="phone")
			{
			$rename="nominator phone";
			}
		if($fld=="pending_BPA")
			{
			$rename="Status";
			}
		if($fld=="approv_BPA")
			{
			$rename="Received by Awards Committee";
			}
		if($fld=="requested_by")
			{
			$rename="edited_by";
			}
		if($fld=="comments")
			{
			$rename="Committee Comments";
			}
		
		echo " <tr valign='top'><td align='right'>$rename</td>";
		
		if($fld=="dpr")
			{$pass_dpr=$value;}
			
		if($fld=="date_of_request")
			{
			if($value==""){$value=date("Y-m-d");}					
			}
	
		if($fld=="year")
			{
			if($value==""){$value=date("Y");}					
			}
		if($fld=="requested_by")
			{$value=$_SESSION['award']['tempID'];}
			
			
		$item="<input type='text' name='$fld' value=\"$value\" size='37'$RO> $explain";
		if($fld=="award_ordered_date" and $level<3){$item="";}

		if(in_array($fld,$pull_down))
			{
			$pd_array=${$fld."_array"};
			$item="<select name='$fld'><option selected=''></option>";
			foreach($pd_array as $da_key=>$da_value)
				{
				if($value==$da_value)
					{
					if($fld=="district"){$pass_dist=$value;}
					if($fld=="region"){$pass_region=$value;}
					$s="selected";}else{$s="value";}
				$item.="<option $s='$da_value'>$da_value</option>";
				}
			$item.="</select>";
			}
			
		if($fld=="justification")
			{
		//	if($value){$d="block";}else{$d="none";}
			$d="block";
			$disu_chop_comment=$ARRAY[$num]['disu_chop_comment'];
			if(@$pass_source=="add"){$disu_chop_comment="";}
			$item="<div id=\"$fld\">   ... <a onclick=\"toggleDiv('fieldDetails[$fld]');\" href=\"javascript:void('')\"> toggle &#177</a> <font size='-1'></font></div>
				<div id=\"fieldDetails[$fld]\" style=\"display: $d\">
			<br />Enter justification for the award nomination.<br /><textarea name='$fld' cols='100' rows='25'>$value</textarea>";

if($level>2)
	{
	$item.="<br />DISU/CHOP comments<br /><textarea name='disu_chop_comment' cols='100' rows='10'>$disu_chop_comment</textarea><br />";
	}
//***********************					
			include("uploads.php");
				echo "</div>";
			
			}
					
		if($fld=="comments")
			{
			if($level>2)
				{
				if($value){$d="block";}else{$d="none";}
				$item="<div id=\"$fld\">   ... <a onclick=\"toggleDiv('fieldDetails[$fld]');\" href=\"javascript:void('')\"> toggle &#177</a> <font size='-1'></font></div>
				
				<div id=\"fieldDetails[$fld]\" style=\"display: $d\"><br><textarea name='$fld' cols='100' rows='15'>$value</textarea></div>";
				}
				else
				{$item="";}
			}
			
		if($fld=="presentation_comment")
			{
				if($level>2)
					{
					if($value){$d="block";}else{$d="none";}
					$item="<div id=\"$fld\">   ... <a onclick=\"toggleDiv('fieldDetails[$fld]');\" href=\"javascript:void('')\"> toggle &#177</a> <font size='-1'></font></div>
					
					<div id=\"fieldDetails[$fld]\" style=\"display: $d\"><br><textarea name='$fld' cols='100' rows='25'>$value</textarea></div>";
					}
					else{$item="";}
			}
		if(in_array($fld,$radio))
			{
			$rad=0;
			@$ck_array=${$fld."_array"};
			$ck_db_value=$value;
			if(substr($fld,-4)=="_rep")
				{
				$rep=substr($fld,0,4);
				$ck_array=$rep_array;
				$mem=$member_array[$rep]['name'];
				$mem_tempID=$member_array[$rep]['tempID'];
				echo "<td><table><tr>";  // Voting reps
				foreach($ck_array as $ck_fld=>$ck_value)
					{
					if($ck_db_value==$ck_value)
						{$ck="checked";}else{$ck="";}
					
				if($level>2)
					{
					if($level>3 OR $check_tempID==$mem_tempID)
					{if($ARRAY[$num]['status']=="Nomination Received by Awards Committee")
						{$RO="";}
						echo "<td colspan='3' align='top'><input type='radio' name='$fld' value=\"$ck_value\"$ck $RO>$ck_value</td>";
						}
					}
					else
						{
						echo "<td colspan='3' align='top'></td>";
						}
					}
				if($rename=="STWD_rep"){$mem.=" chair";}
				echo "<td>($mem)</td></tr></table></td></tr>";
				continue;
				}
				else
				{
				echo "<td><table><tr>";
				foreach($ck_array as $ck_fld=>$ck_value)
					{
					$rad++;
					$add_cat="";
					$add_vendor="";
					$add_direction="";
		
					if($ck_db_value==$ck_value)
						{$ck="checked";}else{$ck="";}
					if(($fld=="category" OR $fld=="status") AND $file_name=="/award/edit.php")
						{
						$RO="";
						if($level<4){$RO="disabled='disabled' ";}
						}
						if($ARRAY[$num]['status']=="" AND $fld=="category")
							{$RO="";}	

					echo "<tr><td colspan='3' align='top'>$rad. <input type='radio' name='$fld' value=\"$ck_value\"$ck $RO>";
if($ck=="checked" and $level<4) // needed to both prevent edit but pass correct value on edit
	{echo "<input type='hidden' name='$fld' value='$ck_value' />";}
if($ck=="checked"){$ck_fld="<b>".$ck_fld."</b>";}
echo "$ck_fld $add_cat $add_vendor $add_direction</td></tr>";
					}

			if($fld=="status" and $level>4)
				{
				$em=$ARRAY[$num]['email'];
				$send_email="<a href='mailto:$em?subject=Award Nomination&body=The Awards Committee would like to thank you for your nomination.  The Chairman of the Awards Committee will contact you with the final disposition of your nomination.'>email</a>";
				echo "<tr><td>$send_email</td></tr>";
				}

				echo "</table></td></tr>";
				continue;
				}
				
			}

		if(@in_array($fld,$date_array))
			{$item="<input id=\"datepicker1\" type=\"text\" value=\"\"/>";}
			
		if($fld=="pending_BPA")
			{
			if($level<4){$RO=" disabled";}
			if($value=="Completed"){$radio_app="checked";}
			if($value=="Pending"){$radio_pending="checked";}
			$item="<input type='radio' name='$fld' value=\"Pending\"$RO $radio_pending>Pending <input type='radio' name='$fld' value=\"Completed\"$RO $radio_app><font color='green'>Completed</font> ";
			}
		
		echo "<td>$item</td></tr>";
						
		}
	}
	
//	if(!isset($message)){$message="";}
	if(!isset($edit)){$edit="";}
	
	if($edit){$action="Update";}else{$action="Submit";}
	
	echo "<tr><th colspan='3'>$action Award Nomination</th></tr>
	<tr><td align='center' colspan='2'>
	<input type='hidden' name='id' value='$edit'>
	<input type='submit' name='submit' value='$action'>
	</td>";
	if($action=="Update" AND $level>4)
		{echo "<td>
		<input type='hidden' name='id' value='$edit'>
		<input type='submit' name='submit' value='Delete' onClick='return confirmLink()'></td>";
		}
	echo "</tr>";
	echo "</table></td></tr></form>";
/*	
	$page="http://www.dpr.ncparks.gov/award/print_report_single.php";
	
		echo "<tr bgcolor='white'><td align='center'><form method='POST' action='$page'>
		<input type='hidden' name='id' value='$edit'>
		<input type='submit' name='submit' value='Print'></form></td></tr>
*/

echo "</table></html>";

?>
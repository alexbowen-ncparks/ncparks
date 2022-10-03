<?php
if(empty($connection))
	{
	$database="award";
	include("../../include/iConnect.inc");// database connection parameters
	include("../../include/auth.inc");// database connection parameters
	
	mysqli_select_db($connection,$database);
	
	}
date_default_timezone_set('America/New_York');

extract($_REQUEST);

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
 if(@$del=="y")
       		{
			$sql = "SELECT $fld FROM award_given where id='$id'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); 
			$row=mysqli_fetch_assoc($result);
			unlink($row[$fld]);
			$sql = "UPDATE award_given set $fld='' where id='$id'";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
//echo "$sql"; exit;			
       			header("Location:edit_award_given.php?edit=$id&submit=edit");
       		exit;
       		}
       		
include("menu.php");

//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
if(@$_POST['submit']=="Delete")
		{
		$sql = "DELETE FROM award_given where id='$_POST[id]'";
//echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
		echo "Record was successfully deleted.";exit;
		}
       
if(@$_POST['submit']=="Update")
		{
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
		$skip1=array("submit","id");
		$skip2=array("submit","id");
	
			foreach($_POST AS $num=>$array)
				{
				$test=explode("-",$num);
				if(in_array($test[0],$skip1)){continue;}
				
				@$clause.=$num."='".$array."',";
				}
				
				// menu.php has the javascript that controls calendars				//"date_needed"=>'2',"approv_PASU"=>'3',


//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;			
		foreach($_POST AS $k=>$v)
			{
			if(in_array($k,$skip2))
				{continue;}					
			}	
				
				$id=$_POST['id'];
				$clause="set ".rtrim($clause,",")." $blank_cat where id='$id'";
		$sql = "Update award_given $clause";
//echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); 
		$clause="";
				
			// ****** uploads
			include("upload_code_given.php");
			
		$edit=$id;
		$message="<tr><td colspan='2'><font color='purple'>Update was successful.</font></td></tr>";
		}
       
$display_fields="*";

if(@$edit)
	{
	$clause="";
	if($level<2)
		{
		$limit_park=$_SESSION['award']['select'];
			if($_SESSION['award']['accessPark'] != "")
				{
				$limit_park=$_SESSION['award']['accessPark'];
				}
		$lp=explode(",",$limit_park);
		foreach($lp as $k=>$v)
			{
			@$clause1.=" location='$v' OR ";
			}
			$clause1=rtrim($clause1," OR ");
			@$clause.=" AND (".$clause1.")";
		}
//*** allows all Level 1 users to view previous awards
$clause="";
	$sql = "SELECT $display_fields FROM award_given as t1 
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
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$category_array[$row['name']]=$row['id'];
		}
		
		
	$sql = "SELECT * FROM members as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1){echo "No members have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$rep=trim(substr($row['represent'],0,4));
		if(strlen(rtrim($rep))<4){$rep.="_";}
		$member_array[$rep]=$row;
		}	
//echo "<pre>"; print_r($ARRAY); echo "</pre>";		
		
echo "<body bgcolor='beige' class=\"yui-skin-sam\">";

if(@$edit){$action="edit_award_given.php";}else{$action="add_award.php";}

echo "<form method='POST' name='contactForm' action='$action' enctype='multipart/form-data'>";

echo "<table><tr><td><table cellpadding='5' border='1' bgcolor='aliceblue'>";

$skip=array("id","other_file_1","other_file_2","other_file_3","other_file_4","disu_chop_comment");
//$checkbox=array("PASU_approv");
//$PASU_approv_array=array("y");
$radio=array("category");

$read_only=array("dpr","date_of_request");

// menu.php has the javascript that controls calendars
if($level==1)
	{
	$access=$_SESSION['award']['accessPark'];
	$location_array=explode(",",$access);
	$park_count=count($location_array);
	if($park_count>1){$pull_down[]="location";}
	$read_only=array("location","id","dpr","status");
	}


if($ARRAY==""){$sql = "SHOW COLUMNS FROM award_given";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
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
			if(@$edit=="")
				{
				$value="";
					if($fld=="id")
					{
					$sql = "SELECT $fld FROM award_given
					WHERE 1 order by $fld desc limit 1
					";// echo "$sql";
					$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
					$row=mysqli_fetch_assoc($result);
					$value=$row[$fld];
					if($value==""){$value="000";}								@$pad=str_pad((substr($value,-3)+1),3,0,str_pad_left);
					if($pad=="000" OR empty($pad)){$pad="001";}
					$value="AN_";
					$value.=$pad;
					$pass_dpr=$value;
					}
				}
								
		if(in_array($fld,$read_only))
			{
			if($fld=="status"){$RO="disabled";}else{$RO="readonly";}
			}
			else
			{
			$RO="";
			}
		
		$rename=$fld;
		$explain="";//	$explain="Do not enter a $ sign.";
		if($fld=="location")
			{
			$rename="4-letter park code<br />or section name";
		//	if($level==1){$value=$_SESSION['award']['select'];}
			if($level==1){$value="";}
			$pass_location=$value;
			}
		if($fld=="email")
			{
			$email=$value;
			}
		if($fld=="nom_name")
			{
			$rename="Name of recipient";
			$explain="(if recipient is not an individual, include a contact person for that group in the comments field.)";
			}
		
		echo " <tr valign='top'><td align='right'>$rename</td>";
	
			
		$item="<input type='text' name='$fld' value=\"$value\" size='37'$RO> $explain";
			
					
		if($fld=="comments")
			{
			if($value){$d="block";}else{$d="none";}
			$item="<textarea name='$fld' cols='100' rows='7'>$value</textarea><br />";
//***********************					
			include("uploads_given.php");		
			}
				
		if($fld=="presentation_comment")
			{
			$item="<textarea name='$fld' cols='100' rows='30'>$value</textarea><br />";
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
				echo "<td><table><tr>";
				foreach($ck_array as $ck_fld=>$ck_value)
					{
					if($ck_db_value==$ck_value)
						{$ck="checked";}else{$ck="";}
					echo "<td colspan='3' align='top'><input type='radio' name='$fld' value=\"$ck_value\"$ck $RO>$ck_value</td>";
					}
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
					echo "<tr><td colspan='3' align='top'>$rad. <input type='radio' name='$fld' value=\"$ck_value\"$ck $RO>$ck_fld $add_cat $add_vendor $add_direction</td></tr>";
					}
				echo "</table></td></tr>";
				continue;
				}
				
			}

			
		echo "<td>$item</td></tr>";
						
		}
	}
	
	if(!isset($message)){$message="";}
	if(!isset($edit)){$edit="";}
	
	if($message==1)
		{
		$message="<tr><td colspan='2'>Your request has been entered.<br />Review for completeness/correctness.</td></tr>";
		}
	
	if($edit){$action="Update";}else{$action="Submit";}

if($level>3)
{
	echo "<tr><th colspan='3'>$action Award Given</th></tr>
	<tr><td align='center' colspan='2'>
	<input type='submit' name='submit' value='$action'>
	</td>";
	if($action=="Update")
		{
		echo "<td>
		<input type='hidden' name='id' value='$edit'>
		<input type='submit' name='submit' value='Delete' onClick='return confirmLink()'></td>";
		}
	echo "</tr>
	$message";
	echo "</table></td></tr></form>";
}	
	$page="http://www.dpr.ncparks.gov/award/print_report_single_given.php";

if($level>4){	
		echo "<tr bgcolor='white'><td align='center'><form method='POST' action='$page'>
		<input type='hidden' name='id' value='$edit'>
		<input type='submit' name='submit' value='Print'></form></td></tr>";}

echo "</table></html>";

?>
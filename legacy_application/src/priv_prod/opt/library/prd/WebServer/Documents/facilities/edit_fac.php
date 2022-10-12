<?php
//These are placed outside of the webserver directory for security
$database="facilities";
include("../../include/auth.inc"); // used to authenticate users

//$multi_park=explode(",",$_SESSION[$database]['accessPark']);

include("../../include/get_parkcodes_reg.php");
$database="facilities";

mysqli_select_db($connection,$database); // database

$level=$_SESSION[$database]['level'];

if($level<1)
	{exit;}

//echo "<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
$file=$_SERVER['PHP_SELF'];

$ignore=array();
	
if(empty($rep))
	{
	include("menu.php");
	$not_readonly=array("comment");
		$sql = "SHOW COLUMNS FROM spo_dpr";//echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$numFlds=mysqli_num_rows($result);
		while ($row=mysqli_fetch_assoc($result))
			{
			if(@in_array($row['Field'],$ignore)){continue;}
			$fieldArray[]=$row['Field'];
			if(!in_array($row['Field'],$not_readonly))
				{$readonly[]=$row['Field'];}
			
			}
		
	}
//echo "<pre>"; print_r($fieldArray); echo "</pre>"; // exit;

echo "<table><tr>";
if(!empty($gis_id))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
	
	$sql="SELECT t1.*, t2.comment as spo_dpr_comments, group_concat(t4.pid) as fac_photo
	from spo_dpr as t1
	LEFT JOIN spo_dpr_comments as t2 on t1.gis_id=t2.gis_id
	LEFT JOIN fac_photos as t4 on t1.gis_id=t4.gis_id
	LEFT JOIN photos.images as t3 on t2.photo_num=t3.pid
	where t1.gis_id='$gis_id'
	group by t1.gis_id
	";
// 	echo "$sql<br />";
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
	
	if($num<1){$message="No record found using $arraySet";}
		
	while($row=mysqli_fetch_assoc($result))
		{
		extract($row);
		}
		
	

		echo "<td><strong>$fac_type</strong></td>";
		
	echo "</tr></table>";
	
	}// end Find

	echo "<form action='fac_update.php' method='POST' enctype='multipart/form-data'>
	<table border='1' cellpadding='5'>";
	
		include("find_form_fac_type.php");
	

	$photoname="Park facility at ".$park_abbr;
	$photo_num="photo_1";
	if(!empty($photo)){$photo_num="photo_2";}
	if(!empty($photo_2)){$photo_num="photo_3";}
	echo "<tr>
	<td colspan='2' align='center'>
	<input type='hidden' name='gis_id' value='$gis_id'>
	<input type='submit' name='submit_label' value='Update' style=\"background-color:lightgreen;width:65;height:35\"></td>
	</table></form>";
	
	if($file=="/facilities/edit_fac.php")
		{echo "<form action='find_fac_type.php' method='POST'><table><tr>";}
		else
		{echo "<form action='find_park_abbr.php' method='POST'><table><tr>";}
		
	echo "<td colspan='2' align='center'>";
	if(!empty($park_abbr))
		{
		echo "<input type='hidden' name='fac_type' value='$fac_type'>";
		echo "<input type='hidden' name='park_abbr' value='$park_abbr'>";
		}
	echo "<input type='submit' name='submit_label' value='Go to Find' style=\"background-color:lightblue;width:75;height:35\"></td></tr></table></form>";
	
	
	echo "<table><tr><td colspan='1' align='center'><form action='/photos/store.php' method='POST'>
	<input type='hidden' name='source' value='housing'>
	<input type='hidden' name='photo_num' value='$photo_num'>
	<input type='hidden' name='gis_id' value='$gis_id'>
	<input type='hidden' name='photoname' value='$photoname'>
	<input type='hidden' name='pass_cat' value='facility'>
	<input type='hidden' name='fac_type' value='$fac_type'>
	<input type='hidden' name='park' value='$park_abbr'>
	<input type='submit' name='submit' value='Add a Photo' style=\"background-color:violet;width:85;height:35\"></form>
	</td>";
	if($level>4)
		{
// 		echo "<td><form method='POST' action='id_link.php'>
// 		<input type='text' name='gis_id' value=\"$gis_id\">
// 		<input type='text' name='ID_pid' value=\"\">
// 		<input type='submit' name='submit' value=\"Add\">
// 		</form></td>";
		}
	echo "</tr></table>";
	
	if(!empty($fac_photo))
		{
		echo "<hr /><table><tr><td colspan='2'>Facility Photos: click to view</td></tr><tr>";
		$exp0=explode(",",$fac_photo);
		foreach($exp0 as $k=>$var_v)
			{
			$sql="SELECT link as photo_link from photos.images where pid='$var_v'"; //echo "$sql";
			$result = @mysqli_QUERY($connection,$sql);
			$row=mysqli_fetch_assoc($result); extract($row);
			$exp=explode("/",$photo_link);
			$tn="ztn.".array_pop($exp);
			$tn_link="/photos/".implode("/",$exp)."/".$tn;
			echo "<td><a href='/photos/$photo_link' target='_blank'><img src='$tn_link'></a><br />";
			echo "<form method='POST' action='get_photo.php' onclick=\"javascript:return confirm('Are you sure you want to delete this photo?')\"><table>
			<tr>
			<td>
			<input type='hidden' name='gis_id' value='$gis_id'>
			<input type='hidden' name='pid' value='$var_v'></td>";
			echo "<td><input type='submit' name='delete' value='Delete'></form></td>";


			echo "</tr></table>";
			}
		
		}	
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;


// *********** Display Attachments ***********
if(!isset($limit_park)){$limit_park="";}
$sql="Select gis_id, file_id, link, file_name  
From `facility_attachment` 
where 1 AND gis_id='$gis_id' $limit_park";
//  echo "$sql";
$result = @MYSQLI_QUERY($connection,$sql);
$j=1;

echo "<table border='1'>";
if($result)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		extract($row);
		if($row['link']!="")
			{
			$link="$j: <a href='$link' target='_blank'>$file_name</a>";
			if($j==1){$da="Facility Attachment(s)";}else{$da="";}
			echo "<tr><td>$da</td><td align='left'>$link</td>";

			if($level>1 or ($park_abbr==$_SESSION['facilities']['select']))
				{
				echo "<td><a href='delete_facility_attachment.php?pass_id=$file_id&gis_id=$gis_id' onclick=\"return confirm('Are you sure you want to delete this Document?')\">Delete</a></td>";
				}
			echo "</tr>";
			$j++;
			}
		}
	}


		echo "</tr>";
	
//echo "</table>";

IF($level>2)
	{
	echo "<form action='upload_form_facility.php' method='POST' enctype='multipart/form-data'>";
	include("upload_form_facility.php");
			
$forms_array=array("inspection_report"=>"Inspection Report must be a <font color='red'>Word .doc or .docx</font>");
		
		$form_name=$forms_array['inspection_report'];
		echo "<tr>
		<td colspan='5'>Upload <font color='red'>Attachment</font> - $form_name
		<input type='hidden' name='attachment_num'  value='$j'>
		<input type='hidden' name='gis_id' value='$gis_id'>
		<input type='hidden' name='fac_type' value='$fac_type'>
		<input type='file' name='file_upload[]'  size='40'>
		<input type='submit' name='submit_report' value=\"Upload Doc\">
		</td>";
$to="jerry.howerton@ncparks.gov";
$to.=";adrian.oneal@ncparks.gov";
$to.=";derrick.evans@ncparks.gov";
// $to.=";cara.hadfield@ncparks.gov";
//$to.=";maria.cucurullo@ncparks.gov";
$subject="Facility Report for $gis_id";
$body="";
$email="<a href=\"mailto:$to?Subject=$subject\">Email Interested Parties</a>";	
echo "<td>$email</td>";
	echo "</form>";
	echo "</table>";
	}
echo "</body></html>";













?>
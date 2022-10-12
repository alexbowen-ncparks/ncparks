<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
$database="retail";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc");// database connection parameters
include("../../include/get_parkcodes_dist.php");

mysqli_select_db($connection,$database);

include("/opt/library/prd/WebServer/Documents/_base_top.php");

if(@$_GET['del']==1)
	{
	$id=$_GET['id'];
	$sql="DELETE from vendors where id='$id'";
	$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	echo "Vendor has been deleted.";
	exit;
	}

echo "<table><tr><th colspan='5'><font color='gray'>DPR Vendor List</font></th></tr></table>";

// Vendors
$sql="SELECT distinct vendor_name from vendors where 1 order by vendor_name";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$vendor_array[]=$row['vendor_name'];
	}


$sql="SHOW columns from vendors";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$fld_array[]=$row['Field'];
	}		
//if(empty($a)){exit;}
//echo "<pre>"; print_r($fld_array); echo "</pre>"; exit;
$radio_array=array("nc_vendor");
$yes_no_array=array("Yes","No");

$skip=array("id");
echo "<form action='vendors.php' method='POST'><table>";
foreach($fld_array as $k=>$v)
	{
	if(in_array($k,$skip)){continue;}
	$show="<input type='text' name='$v'>";

	if($v=="vendor_name")
		{
		$show="<select name='$v'><option selected=''></option>\n";
		foreach($vendor_array as $k1=>$v1)
			{
			$s="value";
		//	if($v1==$_REQUEST[$v]){$s="selected";}else{$s="value";}
			$show.="<option $s=\"$v1\">$v1</option>\n";
			}
		$show.="</select></td><td>New Vendor=><input type='text' name='alt_vendor_name' value=''>";
		}
	if($v=="nc_vendor")
		{
		$show="<select name='$v'><option selected=''></option>\n";
		foreach($yes_no_array as $k1=>$v1)
			{
			if($v1==@$_REQUEST[$v])
				{$s="selected";}else{$s="value";}
			$show.="<option $s=\"$v1\">$v1</option>\n";
			}
		}
	if($v=="comments")
		{
		$show.="</td>
		<td><input type='submit' name='submit' value='Search'></td>
		<td><input type='submit' name='submit' value='Add'><br /><font size='-2'>First select a Vendor or enter a new one.</font></td>";
		}
	echo "<tr><td>$v</td><td>$show</td></tr>";
	}
echo "</table></form>";

$action_button="Update";
if(!empty($_REQUEST))
	{
	if(@$_REQUEST['submit']=="Add")
		{
	//	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;
		extract($_REQUEST);
		if(!empty($_REQUEST['alt_vendor_name']))
			{
			$vendor_name=$_REQUEST['alt_vendor_name'];
			$vendor_array[]=$vendor_name;
			}
			else
			{
			echo "<font color='red'>You need to enter a Vendor Name in the \"New Vendor\" box."; exit;
			}
		foreach($fld_array as $k=>$v)
			{
			if($v=="id"){continue;}
			$value=addslashes($$v);	
			$clause.=$v."='".$value."',";
			}
			$clause=rtrim($clause,",");
		$sql="INSERT into vendors SET $clause";
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$id=mysqli_insert_id($connection);
		
		$sql="SELECT * from vendors where id='$id'"; 
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		if(mysqli_num_rows($result)>0)
			{
			while($row=mysqli_fetch_assoc($result))
				{
				$ARRAY[]=$row;
				}
			}
		$_REQUEST['edit']=1;
		$action_button="Update";
		}
	else
		{
		foreach($_REQUEST AS $fld=>$value)
			{
			if($fld=="submit" OR $fld=="edit" OR $fld=="u"){continue;}
			if(empty($value)){continue;}
			$value=addslashes($value);
			if($fld=="comments")
				{@$clause.="t1.".$fld." like '%".$value."%' AND ";}
			else
				{@$clause.="t1.".$fld."='".$value."' AND ";}
			
			}
		$clause=rtrim($clause," AND ");
		if(empty($clause))
			{
			echo "<font color='red'>Nothing entered.</font>";
			exit;
			}
		if(@$_REQUEST['u']==1)
			{
			echo "<font color='green'>Update successful.</font>";
			}
			
		$sql="SELECT t1.*, group_concat(t2.link) as photo, group_concat(t2.comments) as photo_comments, group_concat(t2.id) as photo_id 
		from vendors as t1
		left join retail_images as t2 on t1.id=t2.retail_id
		where $clause 
		group by t1.id
		order by vendor_name";
		$result=mysqli_query($connection,$sql) or die ("150 Couldn't execute query. $sql ".mysqli_error($connection));
	//	echo "$sql";
		while($row=mysqli_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
		}
	}
//echo "<pre>"; print_r($array_images); echo "</pre>"; // exit;
if(empty($ARRAY))
	{
	IF(!empty($_REQUEST))
		{
		echo "<font color='red'>Nothing found.</font> Select a vendor_name.";
		}
	exit;
	}
//echo $sql;

$skip=array("id","photo","photo_comments","photo_id");
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
echo "<form action='update_vendor.php' method='POST'>";

// Display record to edit
if(@$_REQUEST['edit']==1)
	{
	echo "<hr /><table border='1' align='center' cellpadding='5'>";
	foreach($ARRAY as $index=>$array)
		{
		if($index>0){continue;}
		$id=$ARRAY[$index]['id'];
		
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$form_fld="<input type='text' name='$fld' value=\"$value\">";
				
			if($fld=="comments")
				{
				$form_fld="<textarea name='$fld' cols='90' rows='5'>$value</textarea>";
				}
				
			if($fld=="vendor_name")
				{
				if(!empty($alt_vendor_name)){$value=$alt_vendor_name;}
				$form_fld="<select name='$fld'><option selected=''></option>\n";
				foreach($vendor_array as $k=>$v)
					{
					if($v==$value){$s="selected";}else{$s="value";}
					$form_fld.="<option $s=\"$v\">$v</option>\n";
					}
				$form_fld.="</select>";
				}
				
			if($fld=="nc_vendor")
				{
				$nc_vendor_array=array("Yes","No");
				$form_fld="<select name='$fld'><option selected=''></option>\n";
				foreach($nc_vendor_array as $k=>$v)
					{
					if($v==$value){$s="selected";}else{$s="value";}
					$form_fld.="<option $s=\"$v\">$v</option>\n";
					}
				$form_fld.="</select>";
				}
			
			echo "<tr><td>$fld</td><td>$form_fld</td></tr>";
			}
		echo "<tr>";
		
		if(!empty($array['photo']))
			{
			$array_images=explode(",",$array['photo']);
			$array_comments=explode(",",$array['photo_comments']);
			$array_photo_id=explode(",",$array['photo_id']);
			echo "<td>Photo(s)<br />Click image to edit comment or delete image.</td>";
				foreach($array_images as $k=>$v)
					{
					$var_tn=explode("/",$v);
					$tn="ztn.".array_pop($var_tn);
					$tn=implode("/",$var_tn)."/".$tn;
					$com=$array_comments[$k];
					$pid=$array_photo_id[$k];
					echo "<td><a href='edit_photo.php?id=$pid' target='_blank'><img src='$tn'></a><br />$com</td>";
					if(fmod($k,2)==0){echo "</tr><tr>";}
					}
			}
		echo "</tr>";
		}
	echo "<tr><td colspan='10' align='center'>
	<input type='hidden' name='id' value='$id'>
	<input type='submit' name='submit' value='$action_button'></form>
	</td><td><a href='vendors.php?del=1&id=$id' onclick=\"return confirm('Are you sure you want this Document?')\">Delete</a></td></tr></table>";
	echo "<table><tr><td colspan='3'>
		<font color='purple'>Don't try to upload all images at once. Upload them in batches of 2 or 3.</font><br />A 3mb image will take around a half-minute (depending on your internet speed). Uploading 3 images of that size will take at least a minute and a half.</td></tr>";
		
	$num_images=3;
		echo "<table><form method='post' action='staff_image_uploads.php' enctype='multipart/form-data'>";
			for($i=1; $i<=$num_images; $i++)
				{
				echo "<tr><td align='right'>Image $i description:</td>
				<td><textarea name='comments[]' cols='65' rows='2'></textarea></td>
				<td><input type=file name='file_upload[]'></td>
				</tr>";
				}
echo "<tr><td colspan=2 align='center'>	
		<input type='hidden' name='id' value='$id'>
		<input type='hidden' name='parkcode' value='$parkcode'>
		<input type='hidden' name='form_name' value='images'>
		<input type=submit name='submit' value='Add Image(s)'></td></tr>";
		
		echo "</table></form>";
	exit;
	}

// Display search results
$skip=array("id","photo_comments","photo_id");
echo "<table border='1' align='center' cellpadding='5'>";
echo "<tr><td></td>";
foreach($ARRAY[0] as $k=>$v)
	{
	if(in_array($k,$skip)){continue;}
	$k=str_replace("_"," ",$k);
	if($k=="rate product")
		{
		$k="$k<br /><font size='-2'>(1=poor...5=very good)</font>";
		}
	echo "<th>$k</th>";
	@$header.="<th>$k</th>";
	}
echo "</tr>";

foreach($ARRAY as $index=>$array)
	{
	$id=$ARRAY[$index]['id'];
	echo "<tr><td><a href='vendors.php?edit=1&id=$id'>edit</a></td>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
			if($fld=="photo" and !empty($value))
				{
				$exp_photo=explode(",",$value);
				$exp_pc=explode(",",$array['photo_comments']);
				$var="";
				foreach($exp_photo as $k=>$v)
					{
					$com=$exp_pc[$k];
				$var_tn=explode("/",$v);
					$tn="ztn.".array_pop($var_tn);
					$tn=implode("/",$var_tn)."/".$tn;
					$var.="<a href='$v' target='_blank'><img src='$tn'></a> $com<br />";
					}
				$value=$var;
				}
					
				
		if($fld=="vendor_website"){$value="<a href='$value' target='_blank'>$value</a>";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
//echo "<tr><td></td>$header</tr>";

echo "</table></form>";

?>
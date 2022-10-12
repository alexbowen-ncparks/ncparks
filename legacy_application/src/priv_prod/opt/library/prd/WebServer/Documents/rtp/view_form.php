<?php
include("page_list_view.php");
date_default_timezone_set('America/New_York');
$database="rtp"; 
$dbName="rtp";

include_once("_base_top.php");

include("../../include/iConnect.inc");

$var_table=$var;	
mysqli_select_db($connection,$dbName);

//echo "1= $var_table";
if($var_table=="scores")
	{
	include("scores.php");
	exit;
	}

if(empty($project_file_name))
	{
	include("search_action.php");
	exit;
	}
	
if($submit_form=="Update")
	{
	include("update_table.php");
	exit;
	}

$sql = "SHOW COLUMNS FROM $var_table";
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$ARRAY_textarea=array();
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_fields[]=$row['Field'];
	$temp=$row['Type'];
	$exp=explode("(",$temp);
	if($exp[0]=="varchar")
		{
		$var_temp=substr($exp[1],0,-1);
		if($var_temp>120)
			{$ARRAY_textarea[]=$row['Field'];}
		}
	}
//echo "$var_table<pre>"; print_r($ARRAY_textarea); echo "</pre>"; // exit;
if($_SESSION['rtp']['set_cycle']=="pa")
	{$temp_table="`project_budget_pa`";}
	else
	{$temp_table="`project_budget`";}
	
$sql="SELECT  `deliv_fund_type` 
FROM  $temp_table 
GROUP BY  `deliv_fund_type` "; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$track_funds_array[]=$row['deliv_fund_type'];
	}
	
$sql="SELECT *
from rtp_objective_scores as t1
WHERE 1"; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_base_scores[$row['table_value']]=$row['table_score'];
	}

if(empty($project_file_name))
	{
	header("Location: search_form.php");
	exit;
	}

$exp=explode("_",$var_table);
foreach($exp as $k=>$v)
	{
	if($v=="pa"){continue;}
	$test_array[]=$v;
	$var_array[]=ucfirst($v);
	}
//echo "<pre>"; print_r($test_array); echo "</pre>"; // exit;
$base_table_name=implode("_",$test_array);
$show_table_name=implode(" ",$var_array);
$var_table_text=implode("_",$var_array)."_Text";

if($_SESSION['rtp']['set_cycle']=="pa" AND substr($var_table,-3)!="_pa")
	{$temp_table="`$var_table"."_pa`";}
	else
	{$temp_table="`$var_table`";}


$sql="SELECT t1.*
from field_name_text_1 as t1
 WHERE 1 and t1.table_name='$base_table_name'
 order by t1.sort_order"; 
 // ECHO "$sql"; //exit;	
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_sort_fields[]=$row['field_title'];
	$ARRAY_sort_field_text[]=$row;
	}
//echo "<pre>"; print_r($ARRAY_sort_field_text); echo "</pre>"; 
// ************
if($var_table=="project_budget")
	{$orderBy="order by deliv_num";}else{$orderBy="";}
	
$sql="SELECT t1.*
from $temp_table as t1
 WHERE t1.project_file_name='$project_file_name'
 $orderBy
 "; //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$num_rec=mysqli_num_rows($result);
if($num_rec<1)
	{
	$no_attachments[$temp_table]=1;
	echo "No records for $temp_table.";
	}
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
 //echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
// echo "129<pre>"; print_r($ARRAY_sort_fields); echo "</pre>"; // exit;

$array_no_sort=array("`attachments`","`attachments_pa`");
if(!in_array($temp_table,$array_no_sort))
	{
	$new_p=sort_by_other_array($ARRAY[0],$ARRAY_sort_fields);
	$ARRAY[0]=$new_p;
	}
//  echo "<pre>"; 
 // print_r($ARRAY_sort_fields); 
//  print_r($sort_order_array); print_r($new_p); 
//  echo "</pre>"; // exit;	

function sort_by_other_array ($input, $order) {
//echo "test<pre>"; print_r($input); echo "</pre>"; // exit;
  foreach ($order as $item=>$val) {
    $result[$val] = $input[$val];
  }
  return $result;
}

//echo "$temp_table<pre>"; print_r($ARRAY); echo "</pre>"; // exit;



$skip_table=array("Attachments_Text");

if(!in_array($var_table_text,$skip_table))
	{
	$sql="SELECT t1.*
	from $var_table_text as t1
	 WHERE 1"; //ECHO "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$num_rec=mysqli_num_rows($result);
	while($row=mysqli_fetch_assoc($result))
		{
	//	$ARRAY_table_text[$row['id']]=$row;
		}
	}
	else
	{
	$ARRAY_table_text=array();
	}
 //echo "$var_table_text<pre>"; print_r($ARRAY_table_text); echo "</pre>"; // exit;	

$skip=array("id");
$drop_down=array("trail_work_type","dot_category","state_trail","land_status","gov_body_approval", "public_communication");

include("scoring_arrays.php");

//$textarea=array("description","identifiers","where_stored","comments");
$textarea=$ARRAY_textarea;

$caption=array("identifiers"=>"Enter any number, model name, or 
other identifying marking(s).", "where_stored"=>"Where is the item being kept?", "comments"=>"<br />Contact info on potential owners and any conversations the park staff had with them. Any other info relating to the item.", "description"=>"Please describe the item.");

echo "<div><form action='edit_form.php' method='POST' enctype='multipart/form-data' >";
echo "<table class='table' border='1' cellpadding='5'>";
if($num_rec>1){$nr=$num_rec;}else{$nr="";}//$nr 

if(substr($project_file_name,-3)=="_PA")
	{$show_table_name.="  (Pre-Application)";}
	else
	{
	{$show_table_name.=" - (Final Application)";}}

echo "<tr><th colspan='8'>$show_table_name</th></tr></table>";

if($var_table=="attachments" or $var_table=="attachments_pa")
	{$width="85%";}
	else
	{$width="100%";}
echo "<table class='table' border='1' cellpadding='5' width='$width'>";

if($var_table=="project_budget" or $var_table=="project_budget_pa")
	{
	$skip[]="project_file_name";
	if($_SESSION['rtp']['set_cycle']=="pa")
		{$TABLE="project_budget_pa";}
		else
		{$TABLE="project_budget";}
	$sql="SELECT t1 . deliv_fund_type, t1.deliv_class_type , SUM( deliv_value ) AS sub_total
	FROM $TABLE AS t1
	WHERE t1.project_file_name =  '$project_file_name'
	GROUP BY deliv_fund_type, deliv_class_type
	WITH rollup"; 
	//ECHO "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_sub[]=$row;
		}
	include("display_project_budget.php");
	}
	else
	{
	$file_include="display.php";
	if($var_table=="attachments" or $var_table=="attachments_pa")
		{
		if($_SESSION['rtp']['set_cycle']=="pa")
			{$TABLE="document_verification_pa";}
			else
			{$TABLE="document_verification";}
		$sql="SELECT t1.*
		from $TABLE as t1
		 WHERE t1.project_file_name='$project_file_name'"; 
		 //ECHO "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
		$num_rec=mysqli_num_rows($result);
		while($row=mysqli_fetch_assoc($result))
			{
			$ARRAY_doc_verify[]=$row;
			}
		}
		
	include($file_include);
	}
$update_table_array=array("project_info","project_location","attachments","project_info_pa","project_location_pa","attachments_pa");

if(@$level>4 or ($var_table=="attachments" and $level>0))
	{
	if(in_array($var_table,$update_table_array))
		{
		echo "<tr><td colspan='2' align='center'>
		<input type='hidden' name='source' value=\"view_form\">
		<input type='hidden' name='var_table' value=\"$var_table\">
		<input type='hidden' name='project_file_name' value=\"$project_file_name\">
		<input type='submit' name='submit_form' value=\"Update\">
		</td>
		</tr>";
		}
	
	}
echo "</table>";
echo "</form></div>";

if($var_table=="attachments" or $var_table=="attachments_pa")
	{
	// $sql="SELECT t1.*
// 	from `Document_Verification_Text` as t1
// 	 WHERE 1"; //ECHO "$sql"; //exit;
	$sql="SELECT t1.*
	from `field_name_text_1` as t1
	 WHERE 1 and table_name='document_verification'"; //ECHO "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	$num_rec=mysqli_num_rows($result);
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_table_text[$row['id']]=$row;
		}
	foreach($ARRAY_table_text as $index=>$array)
		{
		foreach($array as $k=>$v)
			{
			if($k=="id"){continue;}
			if($k=="field_title"){$rename_field_array[$v]=$array['field_text'];}
			if($k=="field_category"){$rename_field_category_array[$array['field_title']]=$v;}
		
			}
		}
//	echo "<pre>"; print_r($ARRAY_table_text); echo "</pre>"; // exit;
	echo "<div class=\"fixed\">";
	foreach($ARRAY_doc_verify as $k1=>$array1)
		{
		echo "<table class='table' border='1' cellpadding='5'>";
		echo "<tr><th colspan='2'>Document Verification</th></tr>";
		foreach($array1 as $k2=>$v2)
			{
			($v2=="Yes" or $k2=="project_file_name")?$fc="green":$fc="red";
			$var_fld=$rename_field_array[$k2];
			echo "<tr><td>$var_fld</td><td><font color='$fc'>$v2</font></td></tr>";
			}
		echo "</table>";
		}
	
	echo "</div>";
	
	echo " <div><table><tr><td>";
      
            if (@$count > 0)
            	{
                echo "<p class='msg'>{$count} files uploaded</p>\n\n";
		}
	if($level>3)
		{
            echo "<h3>Folder/Directory Upload using HTML and PHP</h3>
            <h4>Max folder size is 100MB</h4>
            Contents of nested folders are added to the parent folder - no subfolder names/structure are retained.
            <form method=\"post\" action='folder_upload.php' enctype=\"multipart/form-data\">
            <input type='hidden' name='project_file_name' value=\"$project_file_name\">
                <input type=\"file\" name=\"files[]\" id=\"files\" multiple=\"\" directory=\"\" webkitdirectory=\"\" mozdirectory=\"\">
                <input class=\"button\" type=\"submit\" value=\"Upload\" />
            </form>";
		}
          
       echo " </td></tr></table></div>";
	}
echo "</body></html>";
//$var_table
//<td><input type='submit' name='submit_form' value=\"Delete Item\" onclick=\"return confirm('Are you sure you want to delete the item?')\"></td>
?>
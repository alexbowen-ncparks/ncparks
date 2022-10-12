<?php
ini_set('display_errors',1);
$var="summary";
include("page_list_summary.php");

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
$skip=array("submit_form","var", "use", "set_year", "set_cycle");
$table_array=array("project_file_name"=>"applicant_info","project_name"=>"applicant_info", "region"=>"project_location");

$t_array=array("region"=>"t4.rts_cnty1","project_name"=>"t2.project_name");

$set_cycle=$_SESSION['rtp']['set_cycle'];

FOREACH($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	if(empty($value)){continue;}
	if(array_key_exists($fld,$t_array))
		{$temp[]=$t_array[$fld]." like '%".$value."%'";}
		else
		{$temp[]="t1.".$fld." like '%".$value."%'";}
	
	}
if(empty($temp))
	{$clause="1";}
	else
	{$clause=implode(" and ",$temp);}
	
if(!empty($_POST['use']))
	{
	extract($_POST);
	$clause.=" and t5.".$use."='yes'";
	}
	
if(!empty($_SESSION['rtp']['set_year']))
	{
	extract($_SESSION);
	$clause.=" and left(t2.project_file_name,4)='$set_year'";
	}
	
$TABLE="account_info AS t1";
$FIELDS="t1.*";

foreach($_POST AS $k=>$v)
	{
	IF(array_key_exists($k, $table_array))
		{
		IF(empty($v)){continue;}
		$TABLE=$table_array[$k]." as t1 ";
		$FIELDS="t1.".$k;
		}
	}

if(empty($connection))
	{
	$database="rtp"; 
	$dbName="rtp";

	include("../../include/iConnect.inc");
	mysqli_select_db($connection,$dbName);
	}
// $sql="SELECT $FIELDS
// from $TABLE 
//  WHERE $clause"; //ECHO "t=$temp<br />$sql"; exit;

if($set_cycle=="fa")
	{
	$sql="SELECT distinct t1.project_file_name, t2.project_name, t5.trail_work_type, t5.state_trail, t5.dot_category, t3.land_status, t1.gov_body_approval, t1.public_communication, t4.rts_cnty1
	from project_description as t1
	left join project_info as t5 on t1.project_file_name=t5.project_file_name
	left join applicant_info as t2 on t1.project_file_name=t2.project_file_name
	left join project_location as t3 on t1.project_file_name=t3.project_file_name
	left join city_county as t4 on t3.project_county=t4.county_one
	WHERE 1 and $clause";  //ECHO "69 $sql"; //exit;
	}
if($set_cycle=="pa")
	{
	$sql="SELECT distinct t1.project_file_name, t2.project_name, t5.trail_work_type, t5.state_trail, t5.dot_category, t3.land_status, t1.gov_body_approval, t1.public_communication, t4.rts_cnty1
	from project_description_pa as t1
	left join project_info_pa as t5 on t1.project_file_name=t5.project_file_name
	left join applicant_info_pa as t2 on t1.project_file_name=t2.project_file_name
	left join project_location_pa as t3 on t1.project_file_name=t3.project_file_name
	left join city_county as t4 on t3.project_county=t4.county_one
	WHERE 1 and $clause";  //ECHO "85 $sql"; //exit;
	}
 //ECHO "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
if(mysqli_num_rows($result)>0)
	{
	$skip=array();
	$c=count($ARRAY);
	echo "<table border='1'><tr><th>$c</th></tr>";
	foreach($ARRAY AS $index=>$array)
		{
		$id=$array['id'];
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				echo "<th>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if($fld=="link" and !empty($value))
				{$value="<a href='$value' target='_blank'>photo</a>";}
			if($fld=="project_file_name")
				{$value="<a href='page_list_view.php?project_file_name=$value'>$value</a>";}
			if($fld=="comments" and strlen($value)>100)
				{$value=substr($value,0,100)."...";}
				
				
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
		echo "</table>";
}
else
{
$c=0;
echo "No item was found using $clause";
}
	
?>
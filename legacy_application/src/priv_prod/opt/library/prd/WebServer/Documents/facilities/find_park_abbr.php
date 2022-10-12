<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
$database="facilities";
include("../../include/auth.inc"); // used to authenticate users
if(!empty($_SESSION[$database]['accessPark']))
	{$multi_park=explode(",",$_SESSION[$database]['accessPark']);}
	else
	{$multi_park=array();}

include("../../include/iConnect.inc"); 
mysqli_select_db($connection,$database); // database

extract($_REQUEST);
// echo "<pre>";print_r($_REQUEST);echo "</pre>";
//  echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
$level=$_SESSION[$database]['level'];

if(!empty($fac_type))
	{$fac_type_title=$fac_type;}

$ignore=array();
if($level<2)
	{
	$ignore=array("rent_code","rent_comment","rent_fee");
	
	$ignore[]="tempID";
	if($level==1)
		{
		if(!in_array($park_abbr,$multi_park))
			{$park_abbr=$_SESSION[$database]['select'];}
		}
// 		echo "pa=$park_abbr";
	if($park_abbr!=$_SESSION[$database]['select'] AND !in_array($park_abbr,$multi_park))
		{exit;}
	}


	$sql = "SHOW COLUMNS FROM spo_dpr";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$numFlds=mysqli_num_rows($result);
	while ($row=mysqli_fetch_assoc($result))
		{
		if(in_array($row['Field'],$ignore)){continue;}
		$fieldArray[]=$row['Field'];
	//	$fieldArray_edit[]=$row['Field'];
		}

if(@$rep=="")
	{
	include("menu.php");
	if(empty($fac_type_title)){$fac_type_title="";}
	echo "<form action='find_park_abbr.php' method='POST'>
	<table border='1' cellpadding='5'><tr><td colspan='5' align='left'><font color='blue'><b>$park_abbr - $fac_type_title</b></font></td></tr>";
	
// **********************
			include("find_form_park_abbr.php");
	
	echo "<tr>
	<td colspan='2' align='center'><input type='submit' name='submit_label' value='Find' style=\"background-color:lightgreen;width:65;height:35\"></form></td>";
	
if(!empty($fac_type))
	{
	echo "<td align='center'><form action='/facilities/find_park_abbr.php?park_abbr=$park_abbr' method='POST'>
<input type='submit' name='submit' value='Reset Park' style=\"background-color:yellow;width:85;height:35\"></form>
</td>";
	}

echo "<td align='center'><form action='/facilities/find_park_abbr.php' method='POST'>
<input type='submit' name='submit' value='Clear' style=\"background-color:pink;width:85;height:35\"></form>
</td>";

echo "</tr></table>";
	}
else
	{
	$date=date('Y-m-d');
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=DPR_facilities_$date.xls");
	$sort="park_abbr";
	}

if(@$submit_label=="Go to Find" OR @$submit_label=="Find" OR @$rep!="")
	{
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "<pre>";print_r($fieldArray);echo "</pre>";
	
	$like=array("comment","doi_id");
	
	$end_with=array("doi_id");
	
$skip=array("datecreate","crs_idn");
	
if($level<2)
	{$skip[]="comment";}	
	
	
	$arraySet="1";
	$passQuery="";
	for($i=0;$i<count($fieldArray);$i++)
		{
		@$val=${$fieldArray[$i]};// force the variable
		if(in_array($fieldArray[$i],$ignore) OR $val==""){continue;}
		
		// Like
		if(in_array($fieldArray[$i],$like))
			{
			if(in_array($fieldArray[$i],$end_with))
				{
				$arraySet.=" and t1.".$fieldArray[$i]." like '%_".$val."'";
				$passQuery=$fieldArray[$i]."=".$val."&";
				}
				else
				{
				$arraySet.=" and t1.".$fieldArray[$i]." like '%".$val."%'";
				$passQuery=$fieldArray[$i]."=".$val."&";
				}
			
			}
		
			else
			{
		// Equals
			$val="'".$val."'";
			$arraySet.=" and t1.".$fieldArray[$i]."=".$val;
			$passQuery=$fieldArray[$i]."=".$val."&";
			}
		}
	
	
	//echo "<pre>"; print_r($fieldArray); echo "</pre>"; // exit;
	$field_list=implode(",",$fieldArray);
	
	if($arraySet==""){$arraySet="1";}
	
	if(@$id)
		{
		// t1 = housing
		$arraySet="1 and t1.id='$id'";
		}


	
if($arraySet=="1"){exit;}

//$field_list
		$sql="SELECT * from spo_dpr as t1
		where $arraySet
		"; //echo "$sql";

	$order_by="ORDER BY park_abbr";
	
	$sql.=" ".$order_by;

// echo "$sql<br /><br />$arraySet";
			//exit;

	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	$num=mysqli_num_rows($result);
	
	if($num<1){$message="No record found using $arraySet";}
		
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
/*
$pass_clause="<form action='ge_ID_fac_type.php' target='_blank' method='POST'>";

$var=str_replace('t1.', '',$arraySet);
$var=str_replace('1 and ', '',$var);
$pass_clause.= "<input type='hidden' name='pass_clause' value=\"$var\">";


$pass_clause.="<input type='submit' name='submit' value='Map Found Records'>";
$pass_clause.="</form>";
*/

$pass_clause="Map all $fac_type <a href='/facilities/ge_ID_feed_js.php?park_abbr=$park_abbr&fac_type=$fac_type&google_type=gm' target='_blank'>link</a>";
	echo "<table border='1'><tr><td colspan='3'>Number found: $num</td><td colspan='16' align='left'>$pass_clause</td></tr>";
		foreach($ARRAY[0] as $k=>$v)
			{
	if(in_array($k,$skip)){continue;}
			echo "<th>$k</th>";
			}
	echo "</tr>";
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;	
	foreach($ARRAY as $k=>$array)
		{
		echo "<tr>";
		foreach($array as $k1=>$v1)
			{
	if(in_array($k1,$skip)){continue;}
			if($k1=="gis_id" AND @$rep=="")
				{
				$v1="<a href='edit_fac.php?file=park_abbr&gis_id=$v1'>$v1</a>";
				}
				
			if(strpos($k1,"photo")>-1)
				{
				if($v1!="")
					{
					$link="/photos/getData.php?pid=$v1";
					$v1="<a href='$link&source=divper' target='_blank'>photo</a>";
					}
				if(@$rep!=""){$v1="photo taken";}			
				}
			
			if($k1=="lat")
				{
				$long=$array['long'];
				$test=$v1;
				$name=str_replace(" ","+",$array['fac_name'])."+-+".$array["doi_id"];
				$name=str_replace("&","and",$name);
				$name=str_replace("'","_",$name);
				$name=str_replace("(","[",$name);
				$name=str_replace(")","]",$name);
			$v1="<a href='https://maps.google.com/maps?safe=off&q=$v1,$long+($name)&um=1&ie=UTF-8&hl=en&sa=N&z=18' target='_blank'>$v1</a>";
				if($test=="0.000000"){$v1="0.000000";}
				}
			if($k1=="spo_assid" and $v1!=0)
				{
				$v1="<a href='https://www.ncspo.com/FIS/dbBldgAsset_public.aspx?BldgAssetID=$v1' target='_blank'>$v1</a>";
				}
			if($k1=="comment")
				{
				$v1=substr($v1,0,100)."...";
				if(@$rep!=""){$v1="photo taken";}			
				}
					
			echo "<td>$v1</td>";
			}
		echo "</tr>";
		}
		echo "</table>";
	}// end Find
echo "</body></html>";
mysqli_close($connection);

?>
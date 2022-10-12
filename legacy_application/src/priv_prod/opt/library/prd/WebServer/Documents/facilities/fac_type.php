<?php
//These are placed outside of the webserver directory for security
$database="facilities";
include("../../include/auth.inc"); // used to authenticate users
$multi_park=explode(",",$_SESSION[$database]['accessPark']);

include("../../include/iConnect.inc"); 
mysqli_select_db($connection,$database); // database

extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "<pre>";print_r($_SESSION);echo "</pre>";
$level=$_SESSION[$database]['level'];
if(empty($_SESSION[$database]['fac_type']))
	{$_SESSION[$database]['fac_type']=$fac_type;}
$fac_type_title=$_SESSION[$database]['fac_type'];


if($level<3)
	{
	$ignore=array("rent_code","rent_comment","rent_fee");
	
	$ignore[]="tempID";
	}


	$sql = "SHOW COLUMNS FROM spo_dpr";//echo "$sql";
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
	
	echo "<form action='fac_type.php' method='POST'>
	<table border='1' cellpadding='5'><tr><td colspan='5' align='left'><b>$fac_type_title</b></td></tr>";
	
// **********************
			include("find_form.php");
	
	echo "<tr>
	<td colspan='2' align='center'><input type='submit' name='submit_label' value='Find' style=\"background-color:lightgreen;width:65;height:35\"></form></td>
	
<td align='center'><form action='/facilities/fac_type.php' method='POST'>
<input type='submit' name='submit' value='Reset' style=\"background-color:yellow;width:85;height:35\"></form>
</td>";

echo "</tr></table>";
	}
else
	{
	$date=date('Y-m-d');
	header('Content-Type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=DPR_housing_$date.xls");
	$sort="park_code";
	}

if(@$submit_label=="Go to Find" OR @$submit_label=="Find" OR @$rep!="")
	{
//echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "<pre>";print_r($fieldArray);echo "</pre>";
	
	$like=array("comment","rent_comment","occupant","position");
	
	
$skip[]="";	
if($level<4)
	{$skip=array("salary");}
	
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
			$arraySet.=" and t1.".$fieldArray[$i]." like '%".$val."%'";
			$passQuery=$fieldArray[$i]."=".$val."&";
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


	if($level<3)
		{
		$sql="SELECT $field_list from housing as t1
		where $arraySet
		"; //echo "$sql";
		}
	
	if($level>2)
		{
		$sql="SELECT t1.* , t3.current_salary as salary
		from housing as t1
		LEFT JOIN divper.emplist as t2 on t2.tempID=t1.tempID
		LEFT JOIN divper.position as t3 on t3.beacon_num=t2.beacon_num
		where $arraySet
		"; //echo "$sql";
		}

	if(@$sort=="last_name"){$sort="tempID";}else{$sort="park_code";}
	$order_by="ORDER BY $sort";
	
	$sql.=" ".$order_by;

//echo "$sql<br /><br />";
			//exit;

	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));
	$num=mysqli_num_rows($result);
	
	if($num<1){$message="No record found using $arraySet";}
		
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	
	echo "<table border='1'><tr>";
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
			if($k1=="id" AND ($array['park_code']==$_SESSION['facilities']['select']  OR in_array($array['park_code'],$multi_park) OR $level>1) AND @$rep=="")
				{
				$v1="<a href='edit.php?id=$v1'>$v1</a>";
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
			
			if($k1=="salary")
				{
				if($level<6){$v1="";}
				}
			if($k1=="spo_bldg_asset_id" and $v1!=0)
				{
				$v1="<a href='http://www.ncspo.com/fis/dbBldgAsset.aspx?BldgAssetID=$v1' target='_blank'>$v1</a>";
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
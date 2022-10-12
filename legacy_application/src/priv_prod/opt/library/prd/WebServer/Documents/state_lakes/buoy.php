<?php
$database="state_lakes";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       
$tab="Buoys";
@$rep=$_POST['rep'];
if(@$rep==""){include("menu.php");}

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;

date_default_timezone_set('America/New_York');
if(isset($year))
	{$current_year=$year;}
	else
	{$current_year=date('Y');}
	
//!!!!!!!!!!!!!!!!!!!!!!
$table="buoy";
// !!!!!!!!!!!!!!!!!!!

// ********** Get Field Types *********
$sql="SHOW COLUMNS FROM  $table";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
			$allFields[]=$row['Field'];
		}

$sql="SELECT distinct YEAR from buoy";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$year_array[]=$row['YEAR'];
		}

$fld_array=array("park","contacts_id","buoy_number","pier_number","buoy_assoc","lat","lon","fee");
$flds=implode(",",$fld_array);

// only used in January to insert records for the new year

// First query looks for all records for $this_year
// Second query looks for any matching record ALREADY in the table for that year and 
// INSERTS a new record IF the result is null

// Comment out AFTER manual update
// Uncomment out FOR manual update

// Values for manual update
/*
 $this_year=2021; $next_year=2022;
	$sql="SELECT $flds
	FROM  $table where year='$this_year'";
// 	echo "$sql"; exit;
 	$result = @mysqli_QUERY($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
		{
		$add_records[]=$row;
		}
$count=count($add_records);
// 		echo "$count<pre>"; print_r($add_records); echo "</pre>";  exit;
	foreach($add_records as $k=>$array)
		{
		extract($array);
		$buoy_assoc=addslashes($buoy_assoc);
		
		$sql="SELECT $flds
		FROM $table 
		where year='$next_year' and park='$park' and contacts_id='$contacts_id' and buoy_number='$buoy_number' and pier_number='$pier_number' and buoy_assoc='$buoy_assoc' and lat='$lat' and lon='$lon' and fee='$fee'
		";
// 	echo "$sql"; exit;
 	$result = @mysqli_QUERY($connection,$sql) or die(mysqli_error($connection));
		if(mysqli_num_rows($result)<1)
			{
			$sql="INSERT ignore into $table set year='$next_year' , park='$park' , contacts_id='$contacts_id' , buoy_number='$buoy_number' , pier_number='$pier_number' , buoy_assoc='$buoy_assoc' , lat='$lat' , lon='$lon' , fee='$fee'";
// 	echo "$sql"; exit;
			@mysqli_QUERY($connection,$sql) or die(mysqli_error($connection));
			}
		}
*/

		
// ********** Filter row ************
	$excludeFields=array("submit","rep");
if($rep=="")
	{
	echo "<div align='center'><form action='buoy.php' method='POST'><table border='1' cellpadding='3'><tr>";
	
	$radio=array("park","entity");
	$entity_array=array("a"=>"agent","c"=>"corporation","p"=>"private");
	$pull_down=array("year");
	
	
	$allFields[]="billing_last_name";
		foreach($allFields as $k=>$v)
			{
			if(in_array($v,$excludeFields)){continue;}
			
			$v1="<input type='text' name='$v'>";
			
			if(in_array($v,$radio))
				{
					if($v=="entity")
					{
						$v1="<font color='blue'>private</font>:<input type='radio' name='$v' value='p'> ";
						$v1.="<font color='orange'>agent</font>:<input type='radio' name='$v' value='a'><br />";
						$v1.="<font color='green'>corporation</font>:<input type='radio' name='$v' value='c'> ";
					}
					if($v=="park")
					{
					$td=" colspan='2'";
					include("park_arrays.php");
					
					foreach($var_array as $k2=>$v2)
						{
						if($v2==@$_REQUEST['park'])
							{$ck="checked";}
							else
							{$ck="";}
						@$x1.="<input type='radio' name='$v' value='$v2' $ck>$v2 ";
						}
					$v="";
					$v1=$x1;
					}
				}
	
				if(in_array($v,$pull_down))
					{
					$arr=${$v."_array"};
					$v1="<select name='$v'><option selected=''></option>";
					foreach($arr as $k2=>$v2)
						{
						if(empty($v2)){continue;}
						if($current_year==$v2){$s="selected";}else{$s="";}
						$v1.="<option $s='$v2'>$v2</option>";
						}
					$v1.="</select>";
					}
					
					
			echo "<td$td>$v<br />$v1</td>";
			$td="";
			
			if(fmod($k,7)==0)
				{
					if($k==0){echo "<td colspan='7' align='center' bgcolor='aliceblue'>
					<font size='+2' color='purple'>buoy</font></td>";}
					echo "</tr><tr>";
				}
			}
	echo "<td align='center' colspan='6' align='center'>
			<table><tr><td align='left'><input type='checkbox' name='rep' value='x'> Excel &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			<td><input type='submit' name='submit' value='Find'></td></form><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			
		
			echo "<form action='add_buoy.php' method='POST' target='_blank'><td align='center'><input type='submit' name='submit' value='Add'></td></tr></table></td>";
	echo "</tr></table></form></div>";
	}

if(@$submit=="Add")
	{
	foreach($_POST AS $k=>$v)
		{
		if(in_array($k,$excludeFields)){continue;}
		if($k=="park" AND $v==""){echo "You must enter a park code."; exit;}
		if($k=="park"){$v=strtoupper($v);}
		if($v==""){continue;}
		$clause.=$k."='".$v."',";			
		}
	$clause=rtrim($clause,",");

$sql="INSERT INTO buoy SET $clause"; //echo "$sql"; exit;
 $result = @mysqli_QUERY($connection,$sql);
	}

// ******** Enter your SELECT statement here **********

foreach($_POST AS $k=>$v)
	{
	$like=array("buoy_number","buoy_comment","buoy_assoc");
	$like_start=array("billing_last_name");
	
		if(in_array($k,$excludeFields)){continue;}
		if($v==""){continue;}
		
		if(in_array($k,$like))
			{$clause.=" and t1.".$k." like '%".$v."%'";}
			else
			{
				if(in_array($k,$like_start))
					{
					$t="t1";
					if($k=="billing_last_name"){$t="t2";}
					@$clause.=" and ".$t.".".$k." like '".$v."%'";}
					else
					{@$clause.=" and t1.".$k."='".$v."'";}
			}
		
	}
	@$clause=rtrim($clause,",");  //echo "$clause"; exit;
	
	$sort_by="order by buoy_receipt";
	
	if(@$pass_clause AND @$submit=="")
		{
		$clause=str_replace("\\","",$pass_clause);
		$clause=str_replace("*","%",$clause);
		if($sort=="delinq_yrs"){$sort="delinq_yrs desc";}
		if($sort=="buoy_comment"){$sort="buoy_comment desc";}
		if($sort=="buoy_assoc"){$sort="buoy_assoc desc";}
		$sort_by="order by $sort";
		}
		
	if(@$pass_bi AND @$submit=="")
		{
		$clause=" and buoy_id='$pass_bi'";
		}
if($clause==""){exit;}


$contact_flds=",t2.billing_title,t2.billing_last_name,t2.billing_first_name,t2.billing_add_1,t2.billing_city";

$field_list="t1.park,t1.year, t1.buoy_number,t1.buoy_id,t1.buoy_receipt,t1.check_number,t1.fee,t1.buoy_comment,t1.app_fee,t1.app_date,t1.buoy_app_check,t1.delinq_yrs,t1.contacts_id,t1.buoy_assoc";

$sql="SELECT $field_list $contact_flds
FROM  buoy as t1
left join contacts as t2 on t1.contacts_id=t2.id
where 1 $clause $sort_by"; 

//echo "$sql";
 
 $result = @mysqli_QUERY($connection,$sql);
 
while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}

@$num=count($ARRAY);
if($num<1){echo "No record was found using: <b>$clause</b>";exit;}

$fieldNames=array_values(array_keys($ARRAY[0]));

if($num==1){$r="record";}else{$r="records";}

if($rep=="x")
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=state_lake_buoys.xls');
	echo "<table>";
	}
	else
	{	
	echo "<table border='1' cellpadding='2'><tr><td colspan='30' align='center'><font color='green'>Contact info for $num $r using <b>$clause</b></font></td></tr>";
	}


$sort_array=array("buoy_number","billing_last_name","buoy_id","delinq_yrs","buoy_comment","contacts_id","buoy_assoc");

	foreach($fieldNames as $k=>$v)
		{
		//	if($v=="billing_title"){$v="associated w/";}
			$v1=str_replace("_"," ",$v);
			if(in_array($v,$sort_array))
				{
					$clause=str_replace("%","*",$clause);
					$v1="<a href=\"buoy.php?sort=$v&pass_clause=$clause\">$v1</a>";
				}
			@$header.="<th>$v1</th>";
		}



$excludeFields=array("contacts_id");

$j=0;
foreach($ARRAY as $k=>$v){// each row

// $fx = font color  and  $tr = row shading
$f1="";$f2="";
if(fmod($j,2)!=0){$tr=" bgcolor='#F0FFF0'";// Honeydew1
}else{$tr="";}

	if($rep=="x")
		{
		if($j==0)
			{
			echo "<tr bgcolor='yellow'>";
			echo "$header";
			echo "</tr>";
			}
		}
		else
		{
		if(fmod($j,20)==0)
			{
			echo "<tr bgcolor='yellow'>";
			echo "$header";
			echo "</tr>";
			}
		}
$j++;	

if($ARRAY[$k]['delinq_yrs']!=""){$tr=" bgcolor='pink'";}
if($ARRAY[$k]['delinq_yrs']=="2010"){$tr=" bgcolor='orange'";}

echo "<tr$tr>";
	foreach($v as $k1=>$v1)
	{// field name=$k1  value=$v1
		$var=$v1;
			$td="<td align='left'>";
	if($k1=="contacts_id")
		{
			$td="<td align='center'>";
		$var="<a href='display.php?pass_id=$v1'>$v1</a>";
		}
	if($k1=="buoy_id")
		{
			$td="<td align='center'>";
		$var="<a href='edit_buoy.php?edit=$v1&submit=edit' target='_blank'>$v1</a>";
		}
	if($k1=="pier_number")
		{
			$td="<td align='center'>";
		$var="<a href='piers.php?sort=pier_id&pass_clause=and t1.pier_number=$v1' target='_blank'>$v1</a>";
		}
/*	if($k1=="billing_title")
		{
			$td="<td align='center'>";
		$temp=explode("*",$pier_owner[$v['pier_number']]);
		if($v1==""){$var="$temp[0]";}
		if($var==", "){$var="";}
		}
*/
		echo "$td$var</td>";
	}
	
echo "</tr>";
}

echo "</table></form></body></html>";
?>
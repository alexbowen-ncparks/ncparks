<?php
date_default_timezone_set('America/New_York');
$database="state_lakes";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

$tab="Seawalls";
include("menu.php");
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

if(@$year==""){$current_year=date('Y');}else{$current_year=$year;}

// ********** Get Field Types *********

//!!!!!!!!!!!!!!!!!!!!!!
$table="seawall";
// !!!!!!!!!!!!!!!!!!!

$sql="SHOW COLUMNS FROM  $table";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
			$allFields[]=$row['Field'];
			//$fld_list.="t1.".$row['Field'].",";
		}
			//echo "$fld_list";

$sql="SELECT distinct YEAR from $table";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$year_array[]=$row['YEAR'];
		}


$flds=" park, contacts_id";

// Seawall needs major worke
// 1 there are a LOT of duplicates because I never put a unique index on concat of park, year, contacts_id
// Need to determine if seawall number is important - If it is then add to unique index

/*
// only used in January to insert records for the new year
 $this_year=2020; $next_year=2021;

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
		
		$sql="SELECT $flds
		FROM $table 
		where year='$next_year' and park='$park' and contacts_id='$contacts_id' 
		";
// 	echo "$sql"; exit;
 	$result = @mysqli_QUERY($connection,$sql) or die();
		if(mysqli_num_rows($result)<1)
			{
		$sql="INSERT into seawall set park='$park', year='$next_year', contacts_id='$contacts_id'";
// 	echo "$sql"; exit;
		@mysqli_QUERY($connection,$sql) or die(mysqli_error($connection));
			}
		}
*/	
//echo "<pre>"; print_r($add_records); echo "</pre>"; //exit;


// ********** Filter row ************
echo "<div align='center'><form method='POST'><table border='1' cellpadding='3'><tr>";

$excludeFields=array("submit","contacts_id");

$radio=array("park","entity");
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
						if($v2==@$_REQUEST['park']){$ck="checked";}else{$ck="";}
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
						if($current_year==$v2){$s="selected";}else{$s="";}
						$v1.="<option $s='$v2'>$v2</option>";
						}
					$v1.="</select>";
					}
						
					
			echo "<td$td>$v<br />$v1</td>";
			$td="";
			
			if(fmod($k,7)==0)
				{
					if($k==0){echo "<td colspan='6' align='center' bgcolor='aliceblue'>
					<font size='+2' color='purple'>Seawalls</font></td>";}
					echo "</tr><tr>";
				}
			}
		
echo "<td align='center' colspan='6' align='center'>
			<table><tr><td><input type='submit' name='submit' value='Find'></td></form><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			
		
			echo "<form action='add_seawall.php' method='POST' target='_blank'><td align='center'><input type='submit' name='submit' value='Add'></td></tr></table></td>";
	echo "</tr></table></form></div>";	
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

$sql="INSERT INTO seawall SET $clause"; //echo "$sql"; exit;
 $result = @mysqli_QUERY($connection,$sql);
	}

// ******** Enter your SELECT statement here **********

$clause="";
foreach($_POST AS $k=>$v)
	{
	$like=array("billing_title","billing_first_name","billing_last_name","billing_add_1","comment","billing_city_state","seawall_comment");
	
		if(in_array($k,$excludeFields)){continue;}
		if($v==""){continue;}
		
		if(in_array($k,$like)){$clause.="and ".$k." like '%".$v."%',";}else{$clause.="and t1.".$k."='".$v."' ";}
		
	}
	$clause=rtrim($clause,",");
	
	$sort_by="order by seawall_number";
	
	$sort_desc=array("seawall_comment");
	
	if(!empty($pass_clause) AND empty($submit))
		{
		$clause=str_replace("\\","",$pass_clause);
		$clause=str_replace("*","%",$clause);
		if(in_array($sort,$sort_desc))
			{
			$sort="`$sort`";
			$ad="DESC, t2.billing_last_name";
			}
			else
			{$ad="";}
		$sort_by="order by $sort $ad";
		}
		
	if(@$pass_pn AND @$submit=="")
		{
		$clause=" and seawall_id='$pass_pn'";
		}
if($clause==""){exit;}

$pier_flds="t2.billing_title,t2.billing_last_name,t2.billing_first_name,t2.billing_add_1,t2.billing_city,t2.billing_state,t2.billing_zip,";

$field_list="t1.park,t1.year,t1.seawall_id,t1.seawall_comment,t1.seawall_number,t3.pier_id,".$pier_flds."t1.contacts_id";

$sql="SELECT $field_list
FROM  seawall as t1
left join contacts as t2 on t1.contacts_id=t2.id
left join piers as t3 on t1.contacts_id=t3.contacts_id
where 1 $clause 
group by t1.seawall_id
$sort_by"; 

//echo "$sql";
 $result = @mysqli_QUERY($connection,$sql);
 
while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}

@$num=count($ARRAY);
if($num<1){echo "No record was found using: <b>$clause</b>";exit;}

$fieldNames=array_values(array_keys($ARRAY[0]));

if($num==1){$r="record";}else{$r="records";}

echo "<form action='form.php' method='POST'><table border='1' cellpadding='2'><tr><td colspan='13' align='center'><font color='green'>Contact info for $num $r using <b>$clause</b></font></td></tr>";


$sort_array=array("billing_last_name","seawall_number","contacts_id","seawall_comment");

	foreach($fieldNames as $k=>$v)
		{
		$v1=str_replace("_"," ",$v);
		if(in_array($v,$sort_array))
			{
			$clause=str_replace("%","*",$clause);
			$v1="<a href=\"seawall.php?sort=$v&pass_clause=$clause\">$v1</a>";
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


if(fmod($j,20)==0){echo "<tr bgcolor='#FFE4C4'>"; // 
			echo "$header";
			echo "</tr>";}
$j++;	


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
	if($k1=="pier_id")
		{
			$td="<td align='center'>";
		$var="<a href='piers.php?pass_pi=$v1'>$v1</a>";
		}
	if($k1=="seawall_id")
		{
			$td="<td align='center'>";
		$var="<a href='edit_seawall.php?edit=$v1&submit=edit' target='_blank'>$v1</a>";
		}
	
		echo "$td$var</td>";
	}
	
echo "</tr>";
}

//echo "<tr><td><input type='submit' name='submit' value='
//Select'></td></tr>";

echo "</table></form></body></html>";
?>
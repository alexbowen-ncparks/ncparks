<?php

$database="state_lakes";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

$tab="Swim Lines";
include("menu.php");

date_default_timezone_set('America/New_York');
if(isset($year))
	{$current_year=$year;}
	else
	{$current_year=date('Y');}
	
//!!!!!!!!!!!!!!!!!!!!!!
$table="swim_line";
// !!!!!!!!!!!!!!!!!!!


// ********** Get Field Types *********
$sql="SHOW COLUMNS FROM  $table";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
			$allFields[]=$row['Field'];
		}

$sql="SELECT distinct YEAR from swim_line";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$year_array[]=$row['YEAR'];
		}
 
$fld_array=array( "park","contacts_id","pier_number", "fee");
$flds=implode(",",$fld_array);


// only used in January to insert records for the new year
/*
 $this_year=2020; $next_year=2021;
	$sql="SELECT $flds
	FROM  $table where year='$this_year'";
// 	echo "$sql"; exit;
 	$result = @mysqli_QUERY($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
		{
		$add_records[]=$row;
		}
	foreach($add_records as $k=>$array)
		{
		extract($array);
		$temp_where="";
		$temp_insert=" year='$next_year', ";
		foreach($fld_array as $k=>$v)
			{
			$temp_where.="$v='".${$v}."' and ";
			$temp_insert.="$v='".${$v}."', ";
			}
		$where_clause=rtrim($temp_where," and ");
		$insert_clause=rtrim($temp_insert,", ");
		
		$sql="SELECT $flds
	FROM  $table where year='$next_year' and $where_clause";
// 	echo "$sql<br />"; //exit;
 	$result = @mysqli_QUERY($connection,$sql);
		if(mysqli_num_rows($result)<1)
			{
			$sql="INSERT ignore into $table set $insert_clause";
// 	echo "$sql"; exit;
			@mysqli_QUERY($connection,$sql) or die(mysqli_error($conncetion));
			}
		}
*/	
//echo "<pre>"; print_r($add_records); echo "</pre>"; //exit;

//		$year_array[]=date('Y')+1;
// ********** Filter row ************
echo "<div align='center'><form method='POST'><table border='1' cellpadding='3'><tr>";

$excludeFields=array("submit","contacts_id");
$radio=array("park","entity");
$pull_down=array("year");
$entity_array=array("a"=>"agent","c"=>"corporation","p"=>"private");

$allFields[]="billing_last_name";
		foreach($allFields as $k=>$v)
			{
			if(in_array($v,$excludeFields)){continue;}
		
			@$v1="<input type='text' name='$v' $value>";
			
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
							{$ck="checked";}else{$ck="";}
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
					if($k==0){echo "<td colspan='7' align='center' bgcolor='aliceblue'>
					<font size='+2' color='purple'>swim_lines</font></td>";}
					echo "</tr><tr>";
				}
			}
			echo "<td align='center' colspan='6' align='center'>
			<table><tr><td><input type='submit' name='submit' value='Find'></td></form><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			
		
			echo "<form action='add_swim_line.php' method='POST' target='_blank'><td align='center'><input type='submit' name='submit' value='Add'></td></tr></table></td>";
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

$sql="INSERT INTO swim_line SET $clause"; //echo "$sql"; exit;
 $result = @mysqli_QUERY($connection,$sql);
	}

// ******** Enter your SELECT statement here **********

foreach($_POST AS $k=>$v)
	{
	$like=array("billing_title","billing_first_name","billing_last_name","billing_add_1","comment","billing_city_state","swim_line_comment");
		if(in_array($k,$excludeFields)){continue;}
		if($v==""){continue;}
		
		if(in_array($k,$like))
			{
			@$clause.="and ".$k." like '%".$v."%',";
			}
			else
			{
			@$clause.="and t1.".$k."='".$v."' ";
			}
		
	}
	@$clause=rtrim($clause,",");
	
	$sort_by="order by swim_line_receipt";
	
	$sort_desc=array("swim_line_comment","delinq_yrs");
	
	$ad="";
	if(@$pass_clause AND empty($submit))
		{
		$clause=str_replace("\\","",$pass_clause);
		$clause=str_replace("*","%",$clause);
		if(in_array($sort,$sort_desc))
			{
			$sort="`$sort`";
			$ad="DESC, t2.billing_last_name";
			}
		$sort_by="order by $sort $ad";
		}
		
	if(@$pass_swi AND $submit=="")
		{
		$clause=" and swim_line_id='$pass_swi'";
		}
if($clause==""){exit;}

$pier_flds="t2.billing_title,t2.billing_last_name,t2.billing_first_name,t2.billing_add_1,t2.billing_city,t2.billing_state,t2.billing_zip,";

$field_list="t1.park,t1.year,t1.swim_line_id,t1.swim_line_receipt,t1.fee,t1.swim_line_comment,t1.delinq_yrs,".$pier_flds."t1.contacts_id";

$sql="SELECT $field_list,
group_concat(distinct t1.swim_line_id) as swim_line_id
FROM  swim_line as t1
left join contacts as t2 on t1.contacts_id=t2.id
where 1 $clause
group by swim_line_id
$sort_by"; 

//echo "$sql";
 $result = @mysqli_QUERY($connection,$sql);
 
while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
if(empty($ARRAY))
	{echo "No records returned."; exit;}
$num=count($ARRAY);
if($num<1){echo "No record was found using: <b>$clause</b>";exit;}

$fieldNames=array_values(array_keys($ARRAY[0]));

if($num==1){$r="record";}else{$r="records";}

echo "<form action='form.php' method='POST'><table border='1' cellpadding='2'><tr><td colspan='14' align='center'><font color='green'>Contact info for $num $r using <b>$clause</b></font></td></tr>";


$sort_array=array("swim_line_comment","billing_last_name","pier_number","contacts_id","delinq_yrs");

	foreach($fieldNames as $k=>$v)
		{
			$v1=str_replace("_"," ",$v);
			if(in_array($v,$sort_array))
				{
					$clause=str_replace("%","*",$clause);
					$v1="<a href=\"swim_line.php?sort=$v&pass_clause=$clause\">$v1</a>";
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


if(fmod($j,20)==0){echo "<tr bgcolor='#FFB6C1'>"; // 
			echo "$header";
			echo "</tr>";}
$j++;	

if($ARRAY[$k]['delinq_yrs']!=""){$tr=" bgcolor='red'";}

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
			$temp="";
			$td="<td align='center'>";
			$pi=explode(",",$v1);
			foreach($pi as $k2=>$v2)
				{
					$temp.="<a href='piers.php?pass_pi=$v2' target='_blank'>$v2</a> ";
				}
			$var=$temp;
		}
	if($k1=="swim_line_id")
		{
			$td="<td align='center'>";
		$var="<a href='edit_swim_line.php?edit=$v1&submit=edit' target='_blank'>$v1</a>";
		}
	
		echo "$td$var</td>";
	}
	
echo "</tr>";
}

//echo "<tr><td><input type='submit' name='submit' value='
//Select'></td></tr>";

echo "</table></form></body></html>";
?>
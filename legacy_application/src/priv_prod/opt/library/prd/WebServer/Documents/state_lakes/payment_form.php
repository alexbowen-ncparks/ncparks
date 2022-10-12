<?php
$database="state_lakes";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

$tab="Payments";
include("menu.php");
if(@$year==""){$current_year=date('Y');}else{$current_year=$year;}

//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

// ********** Get Field Types *********

$allFields[]="year";
$sql="SHOW COLUMNS FROM  contacts";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
			$allFields[]=$row['Field'];
		//	$fld_list.="t1.".$row['Field'].",";
		}
		//	echo "$fld_list";
$sql="SELECT distinct YEAR from piers";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$year_array[]=$row['YEAR'];
		}
			
// ********** Filter row ************
echo "<div align='center'><form action='payment_form.php' method='POST'><table border='1' cellpadding='3'><tr>";

$excludeFields=array("submit","prefix","suffix","billing_zip","email","phone","cell_phone","fax","lake_address","lake_city","lake_state","lake_zip");

$radio=array("pier_payment","buoy_receipt","ramp_receipt","swim_line_receipt");
$pull_down=array("year");

$merger_array=array_merge($allFields,$radio);

//echo "<pre>"; print_r($merger_array); echo "</pre>"; // exit;

$td="";
$j=0;
foreach($merger_array as $k=>$v)
	{
	if(in_array($v,$excludeFields)){continue;}
	{
	
	$v1="<input type='text' name='$v'>";
	
			if($v=="entity")
			{
				$v1="<input type='radio' name='$v' value='p'><font color='blue'>private</font> ";
				$v1.="<input type='radio' name='$v' value='c'><font color='green'>corporation</font><br />";
				$v1.="<input type='radio' name='$v' value='a'><font color='orange'>agent</font> ";
				$v1.="<input type='radio' name='$v' value='s'><font color='brown'>state/federal</font>";
			}
			
			if(in_array($v,$radio))
			{
				$v1="<input type='radio' name='$v' value='n'><font color='red'>No</font> ";
				$v1.="<input type='radio' name='$v' value='y'><font color='green'>Yes</font><br />";
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
		}
		
	if($v=="billing_last_name"){$v="<font color='purple'>$v</font>";}
	if($v=="id"){$v="contact_id";}
	
	echo "<td$td>$v<br />$v1</td>";
	$td="";
	
	if(fmod($j,7)==0)
		{
			if($k==0){echo "<td colspan='7' align='center' bgcolor='aliceblue'>
			<font size='+2' color='purple'>Payments</font></td>";}
			echo "</tr><tr>";
		}
	$j++;
	}
			echo "<td align='center' colspan='7' align='center'><input type='submit' name='submit' value='Find'></td></form>";
			
	echo "</tr></table></div>";	


// ******** Enter your SELECT statement here **********

	$excludeFields[]="year";
	$like=array("billing_title","billing_first_name","billing_add_1","comment","billing_city");
	$like_start=array("park","billing_last_name");
	$yes_no=array("pier_payment"=>"t2","buoy_receipt"=>"t5","ramp_receipt"=>"t4","swim_line_receipt"=>"t6");

$clause="";	
foreach($_POST AS $k=>$v)
	{
		if(in_array($k,$excludeFields)){continue;}
		if($v==""){continue;}
		
		if(array_key_exists($k,$yes_no))
			{
				$t_num=$yes_no[$k];
					if($v=="n")
						{$clause.=" and ".$t_num.".".$k."=''";}
						else
						{$clause.=" and ".$t_num.".".$k."!=''";}
				
			continue;
			}
						
		if(in_array($k,$like))
			{$clause.=" and t1.".$k." like '%".$v."%'";}
			else
			{
				if(in_array($k,$like_start))
					{$clause.=" and t1.".$k." like '".$v."%'";}
					else
					{$clause.=" and t1.".$k."='".$v."'";}
			}
	}
	$clause=rtrim($clause,",");
	$sort_by="order by billing_last_name,billing_title";
	
	$sort_desc=array("seawall_id","comment");
	
	if(!empty($pass_clause) AND $submit=="")
		{
		$clause=str_replace("\\","",$pass_clause);
		$clause=str_replace("*","%",$clause);
		if(in_array($sort,$sort_desc))
			{
			$sort="`$sort`";
			$ad="DESC, t1.billing_last_name";
			}
		$sort_by="order by $sort $ad";
		}
		
if(!empty($contact_id)){$clause="and t1.id='$contact_id'";}
if($clause==""){exit;}

$field_list_1="t1.park,
t2.year,
t1.entity,
t1.id,
t1.billing_title,
t1.billing_last_name,
t1.billing_first_name,
t1.billing_add_1,
t1.billing_city,
t1.billing_state,
t1.comment,
group_concat(distinct t2.pier_number order by t2.pier_number separator ' ') as pier_number,
group_concat(distinct t2.pier_id) as pier_id,
group_concat(distinct t2.pier_payment separator ' ') as pier_payment,
group_concat(distinct t5.buoy_number order by t5.buoy_number separator ' ') as buoy_number,
group_concat(distinct t5.buoy_id) as buoy_id,
group_concat(distinct t5.buoy_receipt separator ' ') as buoy_receipt,
group_concat(distinct t4.ramp_id) as ramp_id,
group_concat(distinct t4.ramp_receipt separator ' ') as ramp_receipt,
group_concat(distinct t6.swim_line_id) as swim_line_id,
group_concat(distinct t6.swim_line_receipt separator ' ') as swim_line_receipt,
group_concat(distinct t3.seawall_id) as seawall_id";


$sql="SELECT $field_list_1
FROM  contacts as t1
LEFT JOIN piers as t2 on (t1.id=t2.contacts_id and t2.year='$year')
LEFT JOIN seawall as t3 on (t1.id=t3.contacts_id and t3.year='$year')
LEFT JOIN ramp as t4 on (t1.id=t4.contacts_id and t4.year='$year')
LEFT JOIN buoy as t5 on (t1.id=t5.contacts_id and t5.year='$year')
LEFT JOIN swim_line as t6 on (t1.id=t6.contacts_id and t6.year='$year')
where 1 and (t2.pier_number is not NULL OR t3.seawall_id is not NULL OR t4.ramp_id is not NULL OR t5.buoy_id is not NULL OR t6.swim_line_id is not NULL)
$clause
group by t1.id
$sort_by"; //echo "$sql";
$result1 = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");

//echo "$sql<br />";
 
$num1=mysqli_num_rows($result1);
if($num1>0)
	{
	while($row=mysqli_fetch_assoc($result1))
		{
			$ARRAY[]=$row;
			$contact_id_array[]=$row['id'];	
		}
	}
	
	
	@$num=count($ARRAY);
if($num<1)
	{
		echo "No record was found using: <b>$clause</b>";exit;
	}

	
while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}


$fieldNames=array_values(array_keys($ARRAY[0]));

if($num==1){$r="record";}else{$r="records";}

echo "<table border='1' cellpadding='2'><tr><td colspan='30' align='center'><font color='green'>Contact info for $num $r using <b>$clause</b></font></td></tr>";

$sort_array=array("id","entity","billing_title","billing_city","billing_state","billing_last_name","pier_number","comment","billing_add_1","seawall_id","ramp_receipt","buoy_receipt","swim_line_receipt","pier_payment");

	foreach($fieldNames as $k=>$v)
		{
			$v1=str_replace("_"," ",$v);
			if($v1=="id"){$v1="contact id";}
			if($v1=="comment"){$v1="comment</th><th>";}
			if(in_array($v,$sort_array))
				{	
					$clause=str_replace("%","*",$clause);
					$v1="<a href=\"payment_form.php?sort=$v&pass_clause=$clause\">$v1</a>";
				}
			@$header.="<th>$v1</th>";
		}



$editFlds=$fieldNames;
$excludeFields=array("listid","emid","tempID");

$j=0;
foreach($ARRAY as $k=>$v){// each row

// $fx = font color  and  $tr = row shading
$f1="";$f2="";
if(fmod($j,2)!=0){$tr=" bgcolor='#F0FFF0'";// Honeydew1
}else{$tr="";}


if(fmod($j,10)==0){echo "<tr bgcolor='#C1FFC1'>"; // DarkSeaGreen1
			echo "$header";
			echo "</tr>";}
$j++;	

echo "<tr$tr>";
	foreach($v as $k1=>$v1)
	{// field name=$k1  value=$v1
		$var=$v1;
		$td="<td align='left' valign='top'>";
	if($k1=="id")
		{
		$pass_id=$v1;
		$td="<td align='center' valign='top'>";
		$var="<a href='edit.php?edit=$v1&submit=edit' target='_blank'>$v1</a>";
		}
	if($k1=="billing_add_1")
		{
		$td="<td align='center' valign='top'>";
		$add=$ARRAY[$k]['billing_add_1'];
		$city=$ARRAY[$k]['billing_city'];
		$state=$ARRAY[$k]['billing_state'];
		$zip=@$ARRAY[$k]['billing_zip'];
		$var="<a href='http://www.google.com/search?rls=en&q=$add $city $state $zip' target='_blank'>$v1</a>";
		}
	if($k1=="pier_id")
		{
			$temp="";
			$td="<td align='center' valign='top'>";
			$pi=explode(",",$v1);
			foreach($pi as $k2=>$v2)
				{
					$temp.="<a href='edit_pier.php?edit=$v2&submit=edit' target='_blank'>$v2</a> ";
				}
			$var=$temp;
		}
	if($k1=="seawall_id")
		{
			$temp="";
			$td="<td align='center' valign='top'>";
			$pn=explode(",",$v1);
			foreach($pn as $k2=>$v2)
				{
					$temp.="<a href='seawall.php?pass_pn=$v2' target='_blank'>$v2</a> ";
				}
			$var=$temp;
		}
	if($k1=="ramp_id")
		{
			$temp="";
			$td="<td align='center' valign='top'>";
			$pn=explode(",",$v1);
			foreach($pn as $k2=>$v2)
				{
					$temp.="<a href='edit_ramp.php?edit=$v2&submit=edit' target='_blank'>$v2</a> ";
				}
			$var=$temp;
		}
	if($k1=="buoy_id")
		{
			$temp="";
			$td="<td align='center' valign='top'>";
			$pn=explode(",",$v1);
			foreach($pn as $k2=>$v2)
				{
					$temp.="<a href='edit_buoy.php?edit=$v2&submit=edit' target='_blank'>$v2</a> ";
				}
			$var=$temp;
		}	
	
	if($k1=="swim_line_id")
		{
			$temp="";
			$td="<td align='center' valign='top'>";
			$pn=explode(",",$v1);
			foreach($pn as $k2=>$v2)
				{
					$temp.="<a href='edit_swim_line.php?edit=$v2&submit=edit' target='_blank'>$v2</a> ";
				}
			$var=$temp;
		}
	
	if($k1=="comment")
		{
			if($ARRAY[$k]['buoy_id'].$ARRAY[$k]['pier_id'].$ARRAY[$k]['ramp_id'].$ARRAY[$k]['swim_line_id']!="")
				{
				$var="<td><form action='record_payment.php' target='_blank'>
				<input type='hidden' name='year' value='$year'>
				<input type='hidden' name='contact_id' value='$pass_id'>
				<input type='submit' name='pay' value='Payment'>
				</form>";
				}
				else
				{
				$var="<td></td>";
				}
		}
		
		echo "$td$var</td>";
	}
	
echo "</tr>";
}

echo "</table></body></html>";
?>
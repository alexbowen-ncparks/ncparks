<?php
$tab="Owners/Agents";

@$rep=$_POST['rep'];
@$delinq=$_POST['delinq'];
if(@$rep==""){include("menu.php");}

include("../../include/connectROOT.inc");// database connection parameters

$database="state_lakes";

$db = mysql_select_db($database,$connection)
       or die ("Couldn't select database $database");

//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');
if(@$_REQUEST['year']=="")
	{$current_year=date('Y');}
	else
	{$current_year=$_REQUEST['year'];}

// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM  contacts";
 $result = @MYSQL_QUERY($sql,$connection);
while($row=mysql_fetch_assoc($result))
		{
			$allFields[]=$row['Field'];
		//	$fld_list.="t1.".$row['Field'].",";
		}
		//	echo "$fld_list";

$sql="SELECT distinct YEAR from swim_line";
 $result = @MYSQL_QUERY($sql,$connection);
while($row=mysql_fetch_assoc($result))
		{
		$year_array[]=$row['YEAR'];
		}

$this_year=date('Y');
$next_year=date('Y')+1;
	$excludeFields=array("submit","delinq","rep");

// ********** Filter row ************
if($rep=="")
	{
	echo "<div align='center'><form method='POST'>";
	
	echo"<table border='1' cellpadding='3'><tr>";
	
	$radio=array("park","entity");
	$entity_array=array("a"=>"agent","c"=>"corporation","p"=>"private","s"=>"state/federal");
	
	$allFields[]="buoy_assoc";
	
			foreach($allFields as $k=>$v)
				{
				if(in_array($v,$excludeFields)){continue;}
				{
				$v1="<input type='text' name='$v'>";
					if($v=="billing_last_name" AND @$_POST['billing_last_name']!="")
						{
						$v1="<input type='text' name='$v' value='$_POST[billing_last_name]'>";
						}
				
						if($v=="entity")
						{
							$v1="<input type='radio' name='$v' value='p'><font color='blue'>private</font> ";
							$v1.="<input type='radio' name='$v' value='c'><font color='green'>corporation</font><br />";
							$v1.="<input type='radio' name='$v' value='a'><font color='orange'>agent</font> ";
							$v1.="<input type='radio' name='$v' value='s'><font color='brown'>state/federal</font>";
						}
						if($v=="park")
						{
						$td=" colspan='3'";
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
							$v1.=" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year: <select name='year'><option selected=''></option>";
							foreach($year_array as $k2=>$v2)
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
				
				if(fmod($k,7)==0)
					{
						if($k==0){echo "<td colspan='7' align='center' bgcolor='aliceblue'>
						<font size='+2' color='purple'>Owners/Agents</font></td>";}
						echo "</tr><tr>";
					}
					
				}
				echo "<td><input type='checkbox' name='delinq' value='x'> Delinquent Accounts</td><td><input type='checkbox' name='rep' value='x'>Excel</td><td align='center' colspan='3' align='center'><input type='submit' name='submit' value='Find'></td></form>";
				
				echo "<form  method='POST' action='add_owner.php' target='_blank'><td align='center'><input type='submit' name='submit' value='Add'></td>";
		echo "</tr></table></form></div>";	
	}
	
if(@$submit=="Add")
	{
		$excludeFields['id']="";
		foreach($_POST AS $k=>$v)
		{
			if(in_array($k,$excludeFields)){continue;}
			if($k=="park" AND $v==""){echo "You must enter a park code."; exit;}
			if($k=="park"){$v=strtoupper($v);}
			if($v==""){continue;}
			$clause.=$k."='".$v."',";
		
		}
			$clause=rtrim($clause,",");

		$sql="INSERT INTO contacts SET $clause"; //echo "$sql"; exit;
 		$result = @MYSQL_QUERY($sql,$connection);
		$clause="";
	}

// ******** Enter your SELECT statement here **********

foreach($_POST AS $k=>$v)
	{
	$like=array("billing_title","billing_first_name","billing_add_1","comment","billing_city","buoy_assoc");
	$like_start=array("park","billing_last_name");
	
		if(in_array($k,$excludeFields)){continue;}
		if($v=="" or $k=="year"){continue;}
		
		if(in_array($k,$like))
			{
			if($k=="buoy_assoc")
				{
				$tab="t5";
				$JOIN="LEFT JOIN buoy as t5 on t5.contacts_id=t1.id";
				}
				else
				{
				$tab="t1";
				}
			$clause.=" and $tab.".$k." like '%".$v."%'";
			}
			else
			{
			if(in_array($k,$like_start))
				{@$clause.=" and t1.".$k." like '".$v."%'";}
				else
				{@$clause.=" and t1.".$k."='".$v."'";}
			}
	}
	@$clause=rtrim($clause,",");
	$sort_by="order by billing_last_name,billing_title";
	
	$sort_desc=array("seawall_id","ramp_id","buoy_id","swim_line_id","comment","buoy_assoc");
	
	if(@$pass_clause AND @$submit=="")
		{
		$clause=str_replace("\\","",$pass_clause);
		$clause=str_replace("*","%",$clause);
		if(in_array($sort,$sort_desc))
			{
			if($sort=="buoy_assoc")
				{
				$sort="t5.`$sort`";
				$JOIN="LEFT JOIN buoy as t5 on t5.contacts_id=t1.id";
				}
				else
				{
				$sort="`$sort`";
				}
			
			$ad="DESC, t1.billing_last_name";
			}
		@$sort_by="order by $sort $ad";
		}
	
	if(@$pass_id AND @$submit=="")
		{
			$clause=" and t1.id='$pass_id'";
		}
	
	$clause1=$clause;
	
	if($delinq=="x")
		{	
			$clause.=" and (t2.delinq_yrs!='' OR t4.delinq_yrs!='' OR t5.delinq_yrs!='')"; // pier, ramp, buoy
		}
if($clause==""){exit;}

$field_list_1="t1.park,
t1.entity,
t1.id,
t1.billing_title,
t1.prefix,
t1.billing_last_name,
t1.billing_first_name,
t1.suffix,
t1.billing_add_1,
t1.billing_add_2,
t1.billing_city,
t1.billing_state,
t1.billing_zip,
t1.comment, 
t2.pier_comment, 
t5.buoy_comment, 
t4.ramp_comment, 
t3.seawall_comment, 
t6.swim_line_comment,
group_concat(distinct t2.pier_number order by t2.pier_number separator ' ') as pier_number,
if(group_concat(distinct t2.delinq_yrs)=',','',group_concat(distinct t2.delinq_yrs)) as pier_delinq,
group_concat(distinct t2.pier_id) as pier_id,
group_concat(distinct t5.buoy_number order by t5.buoy_number separator ' ') as buoy_number,
if(group_concat(distinct t5.delinq_yrs)=',','',group_concat(distinct t5.delinq_yrs)) as buoy_delinq,
group_concat(distinct t5.buoy_id) as buoy_id,
t5.buoy_assoc,
group_concat(distinct t4.ramp_id) as ramp_id,
group_concat(distinct t3.seawall_id) as seawall_id,
group_concat(distinct t6.swim_line_id) as swim_line_id,
t1.email,
t1.phone,
t1.cell_phone,
t1.fax,
t1.lake_address,
t1.lake_city,
t1.lake_state,
t1.lake_zip";

$field_list_2="t1.park,
t1.entity,
t1.id,
t1.billing_title,
t1.prefix,
t1.billing_last_name,
t1.billing_first_name,
t1.suffix,
t1.billing_add_1,
t1.billing_add_2,
t1.billing_city,
t1.billing_state,
t1.billing_zip,
t1.comment,
'' as pier_number,
'' as pier_delinq,
'' as pier_id,
'' as buoy_number,
'' as buoy_delinq,
'' as buoy_id,
'' as ramp_id,
'' as seawall_id,
'' as swim_line_id,
t1.email,
t1.phone,
t1.cell_phone,
t1.fax,
t1.lake_address,
t1.lake_city,
t1.lake_state,
t1.lake_zip";

@$cy=$_REQUEST['year'];
$sql="SELECT $field_list_1
FROM  contacts as t1 ";

if(!empty($cy))
	{
	$sql.="
	LEFT JOIN piers as t2 on (t1.id=t2.contacts_id and t2.year='$cy')
	LEFT JOIN seawall as t3 on (t1.id=t3.contacts_id and t3.year='$cy')
	LEFT JOIN ramp as t4 on (t1.id=t4.contacts_id and t4.year='$cy')
	LEFT JOIN buoy as t5 on (t1.id=t5.contacts_id and t5.year='$cy')
	LEFT JOIN swim_line as t6 on (t1.id=t6.contacts_id and t6.year='$cy')";
	}
	else
	{
	$sql.="
	LEFT JOIN piers as t2 on (t1.id=t2.contacts_id)
	LEFT JOIN seawall as t3 on (t1.id=t3.contacts_id)
	LEFT JOIN ramp as t4 on (t1.id=t4.contacts_id)
	LEFT JOIN buoy as t5 on (t1.id=t5.contacts_id)
	LEFT JOIN swim_line as t6 on (t1.id=t6.contacts_id)";
	}
$sql.="where 1 and (t2.pier_number is not NULL OR t3.seawall_id is not NULL OR t4.ramp_id is not NULL OR t5.buoy_id is not NULL OR t6.swim_line_id is not NULL)
$clause

group by t1.id
$sort_by"; 

//echo "$sql"; //exit;

$result1 = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");

//echo "<br />$sql<br /><br /><br />$clause";
 
$num1=mysql_num_rows($result1);
if($num1>0)
	{
	while($row=mysql_fetch_assoc($result1))
		{
			$ARRAY[]=$row;
			$contact_id_array[]=$row['id'];	
		}
	}
	
if($delinq=="")
	{
	//$JOIN
	$sql="SELECT $field_list_2
	FROM  contacts as t1
	where 1 
	$clause1
	$sort_by"; //echo "<br /><br />$sql";
	$result2 = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");
	$num2=mysql_num_rows($result2);
	}
if($num2>0)
	{
	while($row=mysql_fetch_assoc($result2))
		{
			if(isset($contact_id_array))
			{
				if(!in_array($row['id'],$contact_id_array))
				{
					$ARRAY[]=$row;
				}
			}
			else
			{
				$ARRAY[]=$row;
			}
		}
	}
	
	@$num=count($ARRAY);
if($num<1)
	{
		echo "No record was found using: <b>$clause</b>";exit;
	}

	
while($row=mysql_fetch_assoc($result)){$ARRAY[]=$row;}


$fieldNames=array_values(array_keys($ARRAY[0]));
$fieldNames[]="buoy_assoc";

if($num==1){$r="record";}else{$r="records";}



if($rep=="x")
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=state_lake.xls');
	echo "<table>";
	}
	else
	{	
	echo "<table border='1' cellpadding='2'><tr><td colspan='31'><font color='green'>Contact info for $num $r using <b>$clause</b></font></td></tr>";
	}
$sort_array=array("id","entity","billing_title","billing_city","billing_state","billing_last_name","pier_number","comment","billing_add_1","seawall_id","ramp_id","buoy_id","swim_line_id","buoy_assoc");

$excludeFields=array("pier_delinq","buoy_delinq");
	foreach($fieldNames as $k=>$v)
		{
		if(in_array($v,$excludeFields)){continue;}
			$v1=str_replace("_"," ",$v);
			if($v1=="id"){$v1="contact_id";}
			if(in_array($v,$sort_array))
				{	
					$clause=str_replace("%","*",$clause);
					$v1="<a href=\"display.php?sort=$v&pass_clause=$clause\">$v1</a>";
				}
			@$header.="<th>$v1</th>";
		}
$editFlds=$fieldNames;

$j=0;
$current_year=date('Y');
foreach($ARRAY as $k=>$v)
	{// each row
	
	// $fx = font color  and  $tr = row shading
	$f1="";$f2="";
	if(fmod($j,2)!=0){$tr=" bgcolor='#F0FFF0'";// Honeydew1
	}else{$tr="";}
	
	if($rep=="x")
		{
		if($j==0)
			{
			echo "<tr bgcolor='#C1FFC1'>"; // DarkSeaGreen1
			echo "$header";
			echo "</tr>";
			}
		}
		else
		{
		if(fmod($j,10)==0)
			{
			echo "<tr bgcolor='#C1FFC1'>"; // DarkSeaGreen1
			echo "$header";
			echo "</tr>";
			}
		}
	$j++;	
	
	if($rep!="x")
		{
		if($ARRAY[$k]['pier_delinq']!=""){$tr=" bgcolor='pink'";}
		if($ARRAY[$k]['buoy_delinq']!=""){$tr=" bgcolor='pink'";}
		if($ARRAY[$k]['pier_delinq']==$current_year){$tr=" bgcolor='yellow'";}
		if($ARRAY[$k]['buoy_delinq']==$current_year){$tr=" bgcolor='yellow'";}
		}
		else
		{$tr="";}
		
	echo "<tr$tr>";
	foreach($v as $k1=>$v1)
		{// field name=$k1  value=$v1
			if(in_array($k1,$excludeFields)){continue;}
			$var=$v1;
			$td="<td align='left' valign='top'>";
		if($k1=="id")
			{
			$td="<td align='center' valign='top'>";
			if($rep!="x")
				{
				$var="<a href='edit.php?edit=$v1&submit=edit' target='_blank'>$v1</a>";
				}
			}
		if($k1=="billing_add_1")
			{
			$td="<td align='center' valign='top'>";
			$add=$ARRAY[$k]['billing_add_1'];
			$city=$ARRAY[$k]['billing_city'];
			$state=$ARRAY[$k]['billing_state'];
			$zip=$ARRAY[$k]['billing_zip'];
			if($rep!="x")
				{
				$var="<a href='http://www.google.com/search?rls=en&q=$add $city $state $zip' target='_blank'>$v1</a>";
				}
				else
				{
				$var=$add." ".$city.", ".$state." ".$zip;
				}
			}
			
		if($k1=="comment")
			{
			$id=$ARRAY[$k]['id'];
			if($v1)
				{
				if($rep!="x")
					{
					$d="none";
					$var="<div id=\"fieldName\">   ... <a onclick=\"toggleDisplay_single('fieldDetails[$id]');\" href=\"javascript:void('')\"> view &#177</a></div>
					
					<div id=\"fieldDetails[$id]\" style=\"display: $d\"><br>$v1</div>";
					}
				}
			}
			
		if($k1=="pier_comment")
			{
			$id=$ARRAY[$k]['id'];
			if($v1)
				{
				if($rep!="x")
					{
					$d="none";
					$var="<div id=\"pier_comment\">   ... <a onclick=\"toggleDisplay_single('pier_comment[$id]');\" href=\"javascript:void('')\"> view &#177</a></div>
					
					<div id=\"pier_comment[$id]\" style=\"display: $d\"><br>$v1</div>";
					}
				}
			}
		
		if($k1=="seawall_comment")
			{
			$id=$ARRAY[$k]['id'];
			if($v1)
				{
				if($rep!="x")
					{
					$d="none";
					$var="<div id=\"seawall_comment\">   ... <a onclick=\"toggleDisplay_single('seawall_comment[$id]');\" href=\"javascript:void('')\"> view &#177</a></div>
					
					<div id=\"seawall_comment[$id]\" style=\"display: $d\"><br>$v1</div>";
					}
				}
			}
		
		if($k1=="ramp_comment")
			{
			$id=$ARRAY[$k]['id'];
			if($v1)
				{
				if($rep!="x")
					{
					$d="none";
					$var="<div id=\"ramp_comment\">   ... <a onclick=\"toggleDisplay_single('ramp_comment[$id]');\" href=\"javascript:void('')\"> view &#177</a></div>
					
					<div id=\"ramp_comment[$id]\" style=\"display: $d\"><br>$v1</div>";
					}
				}
			}
		
		if($k1=="buoy_comment")
			{
			$id=$ARRAY[$k]['id'];
			if($v1)
				{
				if($rep!="x")
					{
					$d="none";
					$var="<div id=\"buoy_comment\">   ... <a onclick=\"toggleDisplay_single('buoy_comment[$id]');\" href=\"javascript:void('')\"> view &#177</a></div>
					
					<div id=\"buoy_comment[$id]\" style=\"display: $d\"><br>$v1</div>";
					}
				}
			}
		
		if($k1=="swim_line_comment")
			{
			$id=$ARRAY[$k]['id'];
			if($v1)
				{
				if($rep!="x")
					{
					$d="none";
					$var="<div id=\"swim_line_comment\">   ... <a onclick=\"toggleDisplay_single('swim_line_comment[$id]');\" href=\"javascript:void('')\"> view &#177</a></div>
					
					<div id=\"swim_line_comment[$id]\" style=\"display: $d\"><br>$v1</div>";
					}
				}
			}
		
		
		if($k1=="pier_id")
			{
				$temp="";
				$td="<td align='center' valign='top'>";
				$pi=explode(",",$v1);
				foreach($pi as $k2=>$v2)
					{
					$temp.="<a href='piers.php?pass_pi=$v2' target='_blank'>$v2</a> ";
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
						$temp.="<a href='ramp.php?pass_rn=$v2' target='_blank'>$v2</a> ";
					}
				$var=$temp;
			}
		if($k1=="buoy_id")
			{
				$temp="";
				$td="<td align='center' valign='top'>";
				$pn=explode(",",$v1);
				$buoy_count=count($pn);
				foreach($pn as $k2=>$v2)
					{
					$temp.="<a href='buoy.php?pass_bi=$v2' target='_blank'>$v2</a> ";
					}
					if($buoy_count>4){$temp.="Num=".$buoy_count." ";}
				$var=$temp;
			}
			
		if($k1=="buoy_number")
			{
				$temp=$var;
				$pn=explode(" ",$v1);
				$buoy_num_count=count($pn);
				if($buoy_num_count>4)
					{$temp.="<br />Num=".$buoy_num_count." ";}
				$var=$temp;
			}
			
		if($k1=="swim_line_id")
			{
				$temp="";
				$td="<td align='center' valign='top'>";
				$pn=explode(",",$v1);
				foreach($pn as $k2=>$v2)
					{
					$temp.="<a href='swim_line.php?pass_swi=$v2' target='_blank'>$v2</a> ";
					}
				$var=$temp;
			}	
			echo "$td$var</td>";
		}
		
	echo "</tr>";
	}

echo "</table>";

//echo "</form>";

echo "</body></html>";
?>
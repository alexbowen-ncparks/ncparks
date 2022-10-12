<?php

$database="state_lakes";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

$tab="Piers";
@$rep=$_POST['rep'];
if(@$rep==""){include("menu.php");}

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;

date_default_timezone_set('America/New_York');
if(isset($year))
	{$current_year=$year;}
	else
	{$current_year=date('Y');}
	
// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM  piers";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
			$allFields[]=$row['Field'];
		}

$sql="SELECT distinct YEAR from piers";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		$year_array[]=$row['YEAR'];
		}


// First query looks for all records for $this_year
// Second query looks for any matching record ALREADY in the table for that year and 
// INSERTS a new record IF the result is null

// Comment out AFTER manual update
// Uncomment out FOR manual update

// Values for manual update
/*
 $this_year=2020; $next_year=2021;
	$sql="SELECT park, contacts_id, pier_number, fee, pier_type, pier_length, boatstall, non_conforming, lat, lon
	FROM  piers where year='$this_year'";
// 	echo "$sql<br />";
 	$result = @mysqli_QUERY($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
		{
		$add_records[]=$row;
		}
// 	echo "<pre>"; print_r($add_records); echo "</pre>"; // exit;
	foreach($add_records as $k=>$array)
		{
		extract($array);
			$pier_length=str_replace("'", "",$pier_length);
		$where="park='$park' and contacts_id='$contacts_id' and pier_number='$pier_number' and fee='$fee' and pier_type='$pier_type' and pier_length='$pier_length' and boatstall='$boatstall' and non_conforming='$non_conforming' and lat='$lat' and lon='$lon'";
		$sql="SELECT park, contacts_id, pier_number, fee, pier_type, pier_length, boatstall, non_conforming, lat, lon
	FROM  piers where year='$next_year' and $where";
// 			echo "$sql"; exit;
 	$result = @mysqli_QUERY($connection,$sql) or die(mysqli_error($connection));
		if(mysqli_num_rows($result)<1)
			{
			$pier_length=str_replace("'", "",$pier_length);
			$sql="INSERT ignore into piers set park='$park', year='$next_year', contacts_id='$contacts_id', pier_number='$pier_number',fee='$fee',pier_type='$pier_type', pier_length='$pier_length',boatstall='$boatstall',non_conforming='$non_conforming',lat='$lat',lon='$lon'";
// 			echo "$sql"; exit;
			@mysqli_QUERY($connection,$sql) or die(mysqli_error($connection));
			}
		}
*/

//echo "<pre>"; print_r($add_records); echo "</pre>"; //exit;

// ********** Filter row ************
	$excludeFields=array("submit","rep");
if($rep=="")
	{
	echo "<div align='center'><form method='POST'><table border='1' cellpadding='3'><tr>";
	
	$radio=array("park","pier_type");
	$pull_down=array("year");
	
	$checkbox=array("boatstall","non_conforming","pier_mod_y_n","transfer_y_n");
	
	$allFields[]="billing_last_name";
			foreach($allFields as $k=>$v)
				{
				if(in_array($v,$excludeFields)){continue;}
				
				$v1="<input type='text' name='$v'>";
				
				if(in_array($v,$radio))
					{
						if($v=="pier_type")
						{
							$v1="<font color='orange'>commercial</font>:<input type='radio' name='$v' value='c'> ";
							$v1.="<font color='green'>private</font>:<input type='radio' name='$v' value='p'> ";
							$v1.="<font color='blue'>state/federal</font>:<input type='radio' name='$v' value='s'>";
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
						<font size='+2' color='purple'>Piers</font></td>";}
						echo "</tr><tr>";
					}
				}
	echo "<td align='center' colspan='6' align='center'>
				<table><tr>
				<td align='left'><input type='checkbox' name='rep' value='x'> Excel &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td><input type='submit' name='submit' value='Find'></td></form><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				
			
				echo "<form action='add_pier.php' method='POST' target='_blank'><td align='center'><input type='submit' name='submit' value='Add'></td></tr></table></td>";
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

$sql="INSERT INTO piers SET $clause"; //echo "$sql"; exit;
 $result = @mysqli_QUERY($connection,$sql);
	}

// ******** Enter your SELECT statement here **********
$like=array("billing_title","billing_first_name","billing_last_name","billing_add_1","comment","billing_city_state","pier_comment","delinq_yrs");
	
foreach($_POST AS $k=>$v)
	{
	
		if(in_array($k,$excludeFields)){continue;}
		if($v==""){continue;}
		
		if(in_array($k,$like))
			{
			if($k=="billing_last_name"){$t="t2.";}else{$t="t1.";}
			@$clause.="and ".$t.$k." like '%".$v."%' ";
			}
			else
			{@$clause.="and t1.".$k."='".$v."' ";}
		
	}
//	$clause=rtrim($clause,",");
	
	$sort_by="order by pier_payment, billing_last_name";
	
	if(@$pass_clause AND @$submit=="")
		{
		$clause=str_replace("\\","",$pass_clause);
		$clause=str_replace("*","%",$clause);
		
		$sort_desc=array("pier_comment","boatstall","non_conforming","delinq_yrs","trans_pay_date","mod_pay_date");
		
		if(in_array($sort,$sort_desc)){$desc="desc";} else {$desc="";}
		
		if($sort=="billing_last_name"){$sort.=",billing_first_name";}
		$sort_by="order by $sort $desc";
		}
		
	if(@$pass_pi AND @$submit=="")
		{
		$clause=" and pier_id='$pass_pi'";
		}
if(@$clause==""){exit;}

$contact_flds="t2.billing_last_name,t2.billing_first_name,t2.billing_title,";

$field_list="t1.park,t1.year, t1.pier_number,t1.pier_id,t1.pier_type,t1.fee,t1.pier_payment,t1.check_number,t1.contacts_id,".$contact_flds."t1.pier_comment,t1.delinq_yrs,t1.transfer_fee,t1.trans_check,t1.trans_pay_date,t1.boatstall,t1.non_conforming,t1.mod_pay_date,t1.pier_mod_check,t1.mod_fee_amt,t1.pier_length";

$sql="SELECT $field_list
FROM  piers as t1
left join contacts as t2 on t1.contacts_id=t2.id
where 1 $clause $sort_by"; 

// echo "$sql";
 $result = @mysqli_QUERY($connection,$sql);
 
while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}

$num=@count($ARRAY);
if($num<1){echo "No record was found using: <b>$clause</b>";exit;}

$fieldNames=array_values(array_keys($ARRAY[0]));

if($num==1){$r="record";}else{$r="records";}

if($rep=="x")
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=state_lake_piers.xls');
	echo "<table>";
	}
	else
	{	
	echo "<table border='1' cellpadding='2'><tr><td colspan='20' align='center'><font color='green'>Contact info for $num $r using <b>$clause</b></font></td></tr>";
	}

$sort_array=array("billing_last_name","pier_id","contacts_id","pier_comment","boatstall","non_conforming","pier_payment","fee","pier_number","delinq_yrs","trans_pay_date","mod_pay_date");

$excludeFields=array("billing_title","billing_first_name");

	foreach($fieldNames as $k=>$v)
		{
			if(in_array($v,$excludeFields)){continue;}
			$v1=str_replace("_"," ",$v);
			if(in_array($v,$sort_array))
				{				
					$clause=str_replace("%","*",$clause);
					$v1="<a href=\"piers.php?sort=$v&pass_clause=$clause\">$v1</a>";
				}
			@$header.="<th>$v1</th>";
		}




$j=0;
foreach($ARRAY as $k=>$v)
	{
	// each row
	
	// $fx = font color  and  $tr = row shading
	$f1="";$f2="";
	if(fmod($j,2)!=0){$tr=" bgcolor='#F0FFF0'";// Honeydew1
	}else{$tr="";}
	
	
	if($rep=="x")
		{
		if($j==0)
			{
			echo "<tr bgcolor='#C6E2FF'>"; // SlateGray1
			echo "$header";
			echo "</tr>";
			}
		}
		else
		{
		if(fmod($j,20)==0)
			{
			echo "<tr bgcolor='#C6E2FF'>"; // SlateGray1
			echo "$header";
			echo "</tr>";
			}
		}
	$j++;	
	
	
	if($ARRAY[$k]['delinq_yrs']!=""){$tr=" bgcolor='pink'";}
	if($ARRAY[$k]['delinq_yrs']==$current_year){$tr=" bgcolor='yellow'";}
	echo "<tr$tr>";
		foreach($v as $k1=>$v1)
		{// field name=$k1  value=$v1
			
			if(in_array($k1,$excludeFields)){continue;}
			
			$var=$v1;
				$td="<td align='left'>";
		if($k1=="billing_last_name")
			{	
				$fn=$ARRAY[$k]['billing_first_name'];
			$var=$v1.", ".$fn;
				if($ARRAY[$k]['contacts_id']==0)
					{$var="<font color='red'>no owner</font>";}
			}
		if($k1=="contacts_id")
			{
				$td="<td align='center'>";
			$var="<a href='display.php?pass_id=$v1'>$v1</a>";
			}
		if($k1=="pier_id")
			{
				$td="<td align='center'>";
			$var="<a href='edit_pier.php?edit=$v1&submit=edit' target='_blank'>$v1</a>";
			}
		
			echo "$td$var</td>";
		}
		
	echo "</tr>";
	}

//echo "<tr><td><input type='submit' name='submit' value='
//Select'></td></tr>";

echo "</table></form></body></html>";
?>
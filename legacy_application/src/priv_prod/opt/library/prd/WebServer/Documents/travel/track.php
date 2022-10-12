<?php
if(@$_POST['reset']=="Reset")
	{
	header("Location: track.php?database=travel&submit=Track+a+Request"); exit;
	}

$database="travel";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

$tab="Track Request";
if(@$_POST['rep']==""){include("menu.php");}

//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$limit_park=$_SESSION['travel']['select'];
if($_SESSION['travel']['accessPark'] != "")
	{
	$limit_park=$_SESSION['travel']['accessPark'];
	}

// ********** Get Field Types *********
$excludeFields=array("submit","id","all","TA","justification","other_file_1","other_file_2","register","response","rep");
$excel_array=array("tadpr","purpose","comments");
	
	$sql="SHOW COLUMNS FROM  tal";
	 $result = @mysqli_QUERY($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
			{
				$allFields[]=$row['Field'];
			}
			
	$sql = "SELECT * FROM category as t1 
	WHERE  1 order by id_sort";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
		while($row=mysqli_fetch_assoc($result))
			{$category_array[$row['id_string']]=$row['name'];}
	
	$category_array_flip=array_flip($category_array);

if(@$_POST['rep']=="")
	{			
	$sql = "SELECT distinct location FROM tal as t1 
	WHERE  1 order by location";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
		while($row=mysqli_fetch_assoc($result))
			{$location_array[]=$row['location'];}
			
	// ********** Filter row ************
		echo "<div align='center'><form method='POST'><table border='1' cellpadding='3'><tr>";
	
	
	$checkbox=array("category");
	$dist_array=array("EADI","NODI","SODI","WEDI","STWD");
	$reg_array=array("CORE","PIRE","MORE","STWD");
	$status_array=array("Approved","Not Approved","Pending");
	$date_array=array("date_from","date_to","approv_OPS","approv_DPR_BO","approv_DIR","to_BPA","approv_BPA");

		foreach($allFields as $k=>$v)
			{
			if(in_array($v,$excludeFields)){continue;}
			{
			
			@$v1="<input type='text' name='$v' value='$_POST[$v]'>";
			
				if(in_array($v,$checkbox))
					{
					$ck_array=${$v."_array_flip"};
						$item="<table><tr><td colspan='7' align='center'>$v</td></tr><tr>";
					
					foreach($ck_array as $ck_fld=>$ck_value)
						{
						$v2=$v."[]";  @$j++;
						if(@$_POST['category']!="" AND in_array($ck_value,@$_POST['category']))
							{$ckC="checked";}else{$ckC="";}
						
						$item.="<td><input type='checkbox' name='$v2' value='$ck_value' $ckC>$ck_fld-$j</td>";
						if(fmod(($j),7)==0)
							{
							$item.="</tr><tr>";
							}
						}
						$item.="</tr></table>";
					$v1=$item;$item="";
					}
					
				If($v=="district")
					{
					$v1="<select name='$v'><option select=''></option>";
					foreach($dist_array as $i_da=>$v_da)
						{
						if(@$_POST['district']==$v_da)
							{$s="selected";}else{$s="value";}
						$v1.="<option $s='$v_da'>$v_da</option>";
						}
					$v1.="</select>";
					}
					
				If($v=="region")
					{
					$v1="<select name='$v'><option select=''></option>";
					foreach($reg_array as $i_da=>$v_da)
						{
						if(@$_POST['region']==$v_da)
							{$s="selected";}else{$s="value";}
						$v1.="<option $s='$v_da'>$v_da</option>";
						}
					$v1.="</select>";
					}
						
				If($v=="location")
					{
					$v1="<select name='$v'><option select=''></option>";
					foreach($location_array as $i_la=>$v_la)
						{
						if(@$_POST['location']==$v_la)
							{$s="selected";}else{$s="value";}
						$v1.="<option $s='$v_la'>$v_la</option>";
						}
					$v1.="</select>";
					}
					
				If($v=="pending_BPA")
					{
					$v1="<select name='$v'><option select=''></option>";
					foreach($status_array as $i_s=>$v_s)
						{
						if(@$_POST['pending_BPA']==$v_s)
							{$s="selected";}else{$s="value";}
						$v1.="<option $s='$v_s'>$v_s</option>";
						}
					$v1.="</select>";
					}
					
				if(in_array($v,$date_array))
					{
					$v1="<input type='text' name='$v' value=\"\" size='11'>";					
					}
			}
		
			if($v=="category")
				{
				echo "</tr><tr><td colspan='7'>$v1</td></tr><tr>";
				}
				else
				{
				if($v=="location"){$v="park/section";}
				if($v=="pending_BPA"){$v="Status";}
				if($v=="approv_BPA"){$v="Final Approval";}
				echo "<td>$v<br />$v1</td>";
				}
			
			$td="";
			
			if(fmod($k,7)==1)
				{
					if($k==1){echo "<td colspan='7' align='center' bgcolor='aliceblue'>
					<font size='+2' color='purple'>Track Travel Request</font></td>";}
					echo "</tr><tr>";
				}
				
			}
			if($level>3)
				{
				$excel="Excel <input type='checkbox' name='rep' value='excel'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
			if(!isset($excel)){$excel="";}
			echo "<td align='center' colspan='6' align='center'>
			$excel
			All records <input type='checkbox' name='all' value='all'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='submit' name='submit' value='Find'>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='submit' name='reset' value='Reset'>
			</td>";
			
	echo "</tr></table></form></div>";	
	}
	
// ******** Enter your SELECT statement here **********
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($category_array_flip); echo "</pre>"; // exit;
$like=array("purpose","comments","pending_BPA","email");
$like_end=array("tadpr");
$fld_array=array("category");
$clause="";
foreach($_POST AS $k=>$v)
	{
	
		if(in_array($k,$excludeFields)){continue;}
		if($v==""){continue;}
		$v=str_replace("","",$v);
		if(in_array($k,$like))
			{
			$tab="t1";
			$clause.=" and $tab.".$k." like '%".$v."%'";
			}
			else
			{
				if(in_array($k,$like_end))
					{$clause.=" and t1.".$k." like '%".$v."'";}
					else
					{
					if(in_array($k,$fld_array)) // category
						{
							$val2=" and (";
						foreach($v as $ind1=>$val1)
							{
							if(in_array($val1,$category_array_flip))
								{
								$val2.=$k." like '%$val1%' OR ";}
							
							}
							$clause.=rtrim($val2," OR ").")";
						}
						else
						{
						$v=str_replace(",","",$v); // get rid of comma in amount
						$clause.=" and t1.".$k."='".$v."'";
						}
					}
			}
	}
	@$clause=rtrim($clause,",");
	$sort_by="order by date_to DESC";
	
	$sort_desc=array("tadpr");
	
	if(@$pass_clause 	AND $submit=="")
		{
		$clause=str_replace("\\","",$pass_clause);
		$clause=str_replace("*","%",$clause);
		if(in_array($sort,$sort_desc))
			{
			$sort="`$sort`";
			}
		$sort_by="order by $sort $ad";
		}
	
	if(@$pass_id AND $submit=="")
		{
			$clause=" and t1.id='$pass_id'";
		}
	
if(@$_POST['all']=="all")
	{
	$clause=" ";
	$sort_by="order by id desc limit 100";
	$message="Showing only the most recent 100 requests.";
	}
	
if($clause==""){exit;}

$field_list_1="t1.id,
t1.tadpr,
t1.location,
t1.district,
t1.region,
t1.comments,
t1.email,
t1.amount,
t1.date_from,
t1.date_to,
t1.category,
t1.purpose,
t1.approv_OPS,
t1.approv_DPR_BO,
t1.approv_DIR,
t1.to_BPA,
t1.pending_BPA,
t1.approv_BPA,
t1.staff_notify";

if($level<2 AND @$_POST['rep']=="")
	{
	$lp=explode(",",$limit_park);
	if($tempID=="Parker6291") //Facility Maintenance Supervisor II
		{
		$lp[]="STWD";
		}
	
foreach($lp as $k=>$v)
	{
	@$clause1.=" location='$v' OR ";
	@$clause1.=" purpose like '%$v%' OR ";
	}
	$clause1=rtrim($clause1," OR ");
	$clause.=" AND (".$clause1.")";
		
	}

if($tempID=="Parker6291") //Facility Maintenance Supervisor II
	{
	$var_email=$_SESSION['travel']['email'];
	$clause.=" and email = '$var_email'";
	}
	
$sql="SELECT $field_list_1
FROM  tal as t1
WHERE 1 $clause
$sort_by"; //echo "$sql<br />";
$result1 = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");

//echo "<br />$sql<br /><br /><br />";
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
 
$num1=mysqli_num_rows($result1);
if($num1>0)
	{
	while($row=mysqli_fetch_assoc($result1))
		{
			$ARRAY[]=$row;
			$contact_id_array[]=$row['id'];	
		}
	}
	
	
	$num=@count($ARRAY);
if($num<1)
	{
		echo "No record was found using: <b>$clause</b>";exit;
	}

	
$fieldNames=array_values(array_keys($ARRAY[0]));

if($num==1){$r="record";}else{$r="records";}

if(@$_POST['rep']=="")
	{
	echo "<form action='form.php' method='POST'><table border='1' cellpadding='2'><tr><td colspan='30' align='center'><font color='green'>";
	if(empty($message))
		{
		echo "Contact info for $num $r using <b>$clause</b></font></td></tr>";
		}
		else
		{echo "$message";}
	}
	
$sort_array=array("id","entity","billing_title","billing_city","billing_state","billing_last_name","pier_number","comment","billing_add_1","seawall_id","ramp_id","buoy_id","swim_line_id","buoy_assoc");

if(@$_POST['rep']=="excel")
	{
	header('Content-Type: application/vnd.ms-excel');
	$date=date("Y-m-d"); $filename="DPR_Travel_Authorization_".$date.".xls";
	header("Content-Disposition: attachment; filename=$filename");
	echo "<table>";
	}

$excludeFields=array("id");
	foreach($fieldNames as $k=>$v)
		{
		if(in_array($v,$excludeFields)){continue;}
			if($v=="location"){$v="park/section";}
			if($v=="pending_BPA"){$v="Status";}
			if($v=="approv_BPA"){$v="Final Approval";}
			if($v=="approv_OPS"){$v="DISU Approval";}
			if($v=="approv_DPR_BO"){$v="OPS_approve";}
			$v1=str_replace("_"," ",$v);
			if(in_array($v,$sort_array))
				{	
					$clause=str_replace("%","*",$clause);
					$v1="<a href=\"display.php?sort=$v&pass_clause=$clause\">$v1</a>";
				}
			@$header.="<th>$v1</th>";
		}



$editFlds=$fieldNames;
$toggle_fields=array("purpose","comments");

$j=0;
foreach($ARRAY as $k=>$v)
	{// each row
	
	// $fx = font color  and  $tr = row shading
	$f1="";$f2="";
	if(fmod($j,2)!=0){$tr=" bgcolor='#F0FFF0'";// Honeydew1
	}else{$tr="";}
	
	if(@$_POST['rep']=="")
		{
		if(fmod($j,10)==0)
			{
			echo "<tr bgcolor='#C1FFC1'>"; // DarkSeaGreen1
					echo "$header";
					echo "</tr>";
			}
			$j++;	
		}
		else
		{
		if($k==0)
			{
			echo "<tr bgcolor='#C1FFC1'>"; // DarkSeaGreen1
					echo "$header";
					echo "</tr>";
			}
		
		}
	
	echo "<tr$tr>";
		foreach($v as $k1=>$v1)
		{// field name=$k1  value=$v1
			if(in_array($k1,$excludeFields)){continue;}
			$var=$v1;
			$td="<td align='left' valign='top'>";
		if($k1=="tadpr")
			{
			$v2=$ARRAY[$k]['id'];
			$td="<td align='center' valign='top'>";
			$var="<a href='edit.php?edit=$v2&submit=edit'>$v1</a>";
			}
		
		if($k1=="category")
			{
			$val1=explode(",",$v1);
			$val2="";
			foreach($val1 as $Nval1=>$Vval1)
				{
				if($Vval1==""){continue;}
				$val2.="[".$category_array[$Vval1]."] ";
				}
				$var=$val2;
			}
		
		if(in_array($k1,$toggle_fields))
			{
			$toggle=$k1.$k;
			if($v1!="")
				{
				$related=substr($v1,0,10)."...";
				$var="<div id=\"$k1\">&#177 <a onclick=\"toggleDiv('$toggle');\" href=\"javascript:void('')\">View</a> <font size='-1'>$related</font></div>

				<div id=\"$toggle\" style=\"display: none\"><br><textarea name='$k1' cols='55' rows='20'>$v1</textarea></div>";				
				}

			}
		if(@$_POST['rep']=="")
				{
				if($v1=="Approved"){$f1="<font color='green'>";$f2="</font>";}
				if($v1=="Not Approved"){$f1="<font color='red'>";$f2="</font>";}
				echo "$td$f1$var$f2</td>";
				}
				else
				{
				if($k1=="category"){$v1=$val2;}
				echo "<td valign='top'>$v1</td>";
				}
		}
		
	echo "</tr>";
	}
if(@$rep=="excel")
	{
	echo "</table></body></html>";
	}
	else
	{
	echo "</table></form></body></html>";
	}

?>
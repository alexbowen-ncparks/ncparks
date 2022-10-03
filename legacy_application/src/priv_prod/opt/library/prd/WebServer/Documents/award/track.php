<?php
if($_POST['reset']=="Reset")
	{
	header("Location: track.php?database=award&submit=Track+a+Request"); exit;
	}

$database="award";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

$tab="Track Request";
if(@$_POST['rep']==""){include("menu.php");}

//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$limit_park=$_SESSION['award']['select'];
if($_SESSION['award']['accessPark'] != "")
	{
	$limit_park=$_SESSION['award']['accessPark'];
	}

// ********** Get Field Types *********
	$sql="SHOW COLUMNS FROM  award_list";
	 $result = @mysqli_QUERY($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
			{
			$allFields[]=$row['Field'];
			}
			
	$sql = "SELECT * FROM category as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
		while($row=mysqli_fetch_assoc($result))
			{$category_array[$row['id']]=$row['name'];}


	$sql = "SELECT * FROM status as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
		while($row=mysqli_fetch_assoc($result))
			{$status_array[$row['name']]=$row['name'];}

	$sql = "SELECT * FROM district as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$district_array[$row['name']]=$row['name'];
		}
	
	$sql = "SELECT * FROM members as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
			{
			$represent_array[$row['represent']]=$row['tempID'];
			}
// echo "<pre>"; print_r($represent_array); echo "</pre>"; // exit;

if(@$_POST['rep']=="")
	{
	$sql = "SELECT distinct location FROM award_list as t1 
	WHERE  1 order by location";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
		while($row=mysqli_fetch_assoc($result))
			{$location_array[$row['location']]=$row['location'];}
			
	// ********** Filter row ************
	echo "<div align='center'><form method='POST'><table border='1' cellpadding='3'><tr>";
	
$excludeFields=array("submit","id","all","SR","justification","other_file_1","other_file_2","register","response","rep","cr_form","other_file_3","other_file_4");

//echo "<pre>"; print_r($represent_array); echo "</pre>"; // exit;
if($level<4)
{
foreach($represent_array as $k=>$v)
	{
	if($_SESSION['award']['tempID']!=$v)
		{
		$k=substr($k,0,4);
		$k=rtrim($k);
		if($k=="Rale"){$k="Raleigh";}
		$excludeFields[]=$k."_rep";;
		}
	}
}
// echo "<pre>"; print_r($excludeFields); echo "</pre>"; // exit;
$excel_array=array("dpr","purpose","comments");
		
$checkbox=array();
$radio=array("category","new_replace","source");
$pull_down=array("location","district","status");

//print_r($allFields);
echo "<td colspan='6' align='center' bgcolor='lightgreen'>
					<font size='+2' color='purple'>Track Award Nominations</font></td></tr>";
					
		foreach($allFields as $k=>$v)
			{
			if(in_array($v,$excludeFields)){continue;}
				{
			@$ii++;
				
				@$v1="<input type='text' name='$v' value='$_POST[$v]'>";
		
					if(in_array($v,$radio))
						{
						$ck_array=${$v."_array"};
				//		print_r($ck_array);
						$item="<table align='center' border='1'><tr><td colspan='6' align='center'>$v</td></tr><tr bgcolor='aliceblue'>";
						foreach($ck_array as $ck_fld=>$ck_value)
							{
							if($_POST[$v]==$ck_value)
								{$ckC="checked";}else{$ckC="";}
							$item.="<td><input type='radio' name='$v' value='$ck_fld' $ckC>$ck_value&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
							$ii++;					
							}
							$item.="</tr></table>";
						$v1=$item;$item="";
						}
					
				if(in_array($v,$pull_down))
					{
					$pd_array=${$v."_array"};
					$item="<select name='$v'><option selected=''></option>";
					foreach($pd_array as $da_key=>$da_value)
						{
						if(@$value==$da_value)
							{
							$pass_dist=$value;
							$s="selected";}else{$s="value";}
						$item.="<option $s='$da_value'>$da_value</option>";
						}
					$item.="</select>";
						$v1=$item;$item="";
					}
						
				if(in_array($v,$date_array))
					{
					$v1="<input type='text' name='$v' value=\"\" size='11'>";					
					}
				}
		
			if(in_array($v,$radio))
				{
				echo "</tr><tr><td colspan='6'>$v1</td></tr><tr>";
					$ii--;
				}
				else
				{
					if($v=="location"){$v="park/section";}
					if($v=="approv_BPA"){$v="received by Award Committee";}
					if($v=="status"){$v="<font color='red'>$v</font>";}
				echo "<td>$v<br />$v1</td>";
				}
			
			$td="";
			
			if($ii==14 or $ii==20 or $ii==26)
				{
				echo "</tr><tr>";
				}
			
			}
			if($level>3)
				{
				$excel="Excel <input type='checkbox' name='rep' value='excel'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
			echo "</tr><tr><td align='center' colspan='6' align='center'>
			$excel
			All records <input type='checkbox' name='all' value='all'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='submit' name='submit' value='Find'>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='submit' name='reset' value='Reset'>
			</td>";
			
	echo "</tr></table></form></div>";	
	}
	else
	{
$excludeFields=array("submit","id","all","SR","justification","other_file_1","other_file_2","register","response","rep","cr_form");
	if($level<4)
		{
		foreach($represent_array as $k=>$v)
			{
			if($_SESSION['award']['tempID']!=$v)
				{
				$k=substr($k,0,4);
				$k=rtrim($k);
				if($k=="Rale"){$k="Raleigh";}
				$excludeFields[]=$k."_rep";;
				}
			}
		}
//echo "<pre>"; print_r($excludeFields); echo "</pre>"; // exit;
	}
// ******** Enter your SELECT statement here **********
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($excludeFields); echo "</pre>"; // exit;
$clause="";
foreach($_POST AS $k=>$v)
	{
	$like=array("purpose","comments","category","email");
	$like_end=array("dpr");
//	$fld_array=array("category");
	$fld_array=array();
	
		if(in_array($k,$excludeFields)){continue;}
		if($v==""){continue;}
		
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
						$clause.=" and t1.".$k."='".$v."'";
						}
					}
			}
	}
	$clause=rtrim($clause,",");
	$sort_by="order by date_of_request";
	
	$sort_desc=array("status");
	
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
	
if(@$_REQUEST['all']=="all")
	{
	$clause=" ";
	$sort_by="order by status";
	}
	
if($clause=="" and $level>3)
	{
	$clause="and status=''";
	$sort_by="order by status, dpr";
	}

$field_list_1="t1.*";

//t1.approv_PASU,

if($level<2 AND $_POST['rep']=="")
	{
	$rb=$_SESSION['award']['tempID'];
	$clause1="requested_by like '$rb%'";
	$clause.=" AND (".$clause1.")";
	}

if(empty($clause))
	{
	$clause="and t1.status='Nomination Received by Awards Committee'";
	}
$sql="SELECT $field_list_1
FROM  award_list as t1
WHERE 1 $clause
$sort_by"; 
// echo "$sql";
$result1 = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

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
	
	
	@$num=count($ARRAY);
if($num<1)
	{
		echo "No record was found using: <b>$clause</b>";exit;
	}

	
$fieldNames=array_values(array_keys($ARRAY[0]));

if($num==1){$r="Award Request";}else{$r="Award Requests";}

if($_POST['rep']=="")
	{
	echo "<form action='form.php' method='POST'><table border='1' cellpadding='2'><tr><td colspan='30'><font color='green'> $num $r using <b>$clause</b></font></td></tr>";
	}
	
$sort_array=array("id","entity","billing_title","billing_city","billing_state","billing_last_name","pier_number","comment","billing_add_1","seawall_id","ramp_id","buoy_id","swim_line_id","buoy_assoc");

if($_POST['rep']=="excel"){header('Content-Type: application/vnd.ms-excel');
$date=date("Y-m-d"); $filename="DPR_award_Authorization_".$date.".xls";
header("Content-Disposition: attachment; filename=$filename");
echo "<table>";
}

$excludeFields=array("id","register","response","other_file_1","other_file_2","disu_chop_comment","SR","cr_form","other_file_3","other_file_4");


if($level<3)
	{
	$excludeFields[]="status";
	$excludeFields[]="comments";
	}

if($level<4)
		{
		foreach($represent_array as $k=>$v)
			{
			if($_SESSION['award']['tempID']!=$v)
				{
				$k=substr($k,0,4);
				$k=rtrim($k);
				if($k=="Rale"){$k="Raleigh";}
				$excludeFields[]=$k."_rep";;
				}
			}
		}
	foreach($fieldNames as $k=>$v)
		{
		if(in_array($v,$excludeFields)){continue;}
			if($v=="location"){$v="park/section";}
			if($v=="comments"){$v="Committee Comments";}
			if($v=="requested_by"){$v="edited_by";}
	//		if($v=="approv_BPA"){$v="Received by Award Committee";}
			$v1=str_replace("_"," ",$v);
			if(in_array($v,$sort_array))
				{	
					$clause=str_replace("%","*",$clause);
					$v1="<a href=\"display.php?sort=$v&pass_clause=$clause\">$v1</a>";
				}
			$header.="<th>$v1</th>";
		}


//print_r($fieldNames);
$editFlds=$fieldNames;
$toggle_fields=array("purpose","comments","justification","presentation_comment");

$j=0;
foreach($ARRAY as $k=>$v)
	{// each row
	
	// $fx = font color  and  $tr = row shading
	$f1="";$f2="";
	if(fmod($j,2)!=0){$tr=" bgcolor='#F0FFF0'";// Honeydew1
	}else{$tr="";}
	
	if($_POST['rep']=="")
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
		if($k1=="dpr")
			{
			$v2=$ARRAY[$k]['id'];
			$td="<td align='center' valign='top'>";
			$var="<a href='edit.php?edit=$v2&submit=edit'>$v1</a>";
			}
		if($k1=="requested_by")
			{
			$exp=explode(",",$v1);
			$temp="";
			foreach($exp as $k_exp=>$v_exp)
				{
				@$temp.=substr($v_exp,0,-4).",";
				}
			$temp=rtrim($temp,",");
			$var=$temp;
			}
		
		if($k1=="category")
			{
			$val5="";
			$val1=explode(".",$v1);
			if($val1[1]=="")
				{
				$val3=$val1[0];
				}
			else
				{
				$val3=$val1[0];
				$val4=$val1[1];
				}
			$val2="[".$category_array[$val3]."] ";
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
		if($_POST['rep']=="")
				{
				$f1="";$f2="";
				if($v1=="Completed"){$f1="<font color='green'>";$f2="</font>";}
				if($v1=="Pending"){$f1="<font color='red'>";$f2="</font>";}
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
if($rep=="excel")
	{
	echo "</table></body></html>";
	}
	else
	{
	echo "</table></form></body></html>";
	}

?>
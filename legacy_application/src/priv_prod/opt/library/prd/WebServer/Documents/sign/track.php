<?php
if(@$_POST['reset']=="Reset")
	{
	header("Location: track.php?database=sign&submit=Track+a+Request"); exit;
	}

$database="sign";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

$tab="Track Request";
if(@$_POST['rep']==""){include("menu.php");}

//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$limit_park=$_SESSION['sign']['select'];
$beacon_num=$_SESSION['sign']['beacon_num'];

if($_SESSION['sign']['accessPark'] != "")
	{
	$limit_park=$_SESSION['sign']['accessPark'];
	}

// ********** Get Field Types *********
	$sql="SHOW COLUMNS FROM  sign_list_1";
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
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
		while($row=mysqli_fetch_assoc($result))
			{$status_array[$row['name']]=$row['name'];}

	$sql = "SELECT * FROM new_replace as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
		while($row=mysqli_fetch_assoc($result))
			{$new_replace_array[$row['name']]=$row['name'];}
			
	$sql = "SELECT * FROM standard as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$standard_sign_array[$row['sign_title']]=$row['sign_title'];
		}
//		echo "<pre>"; print_r($standard_sign_array); echo "</pre>";
		
	$sql = "SELECT * FROM district as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$district_array[$row['name']]=$row['name'];
		}
	
	$sql = "SELECT * FROM region as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$region_array[$row['name']]=$row['name'];
		}
	
	$sql = "SELECT * FROM sign_type as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$sign_type_array[$row['name']]=$row['name'];
		}
	$sql = "SELECT * FROM background_color as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$background_color_array[$row['name']]=$row['name'];
		}	
		
	$sql = "SELECT * FROM letter_color as t1 
	WHERE  1 order by id";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No categories have been entered."; exit;}
		while($row=mysqli_fetch_assoc($result))
		{
		$letter_color_array[$row['name']]=$row['name'];
		}	
	
	$source_array=array("DPR Sign Shop"=>"DPR Sign Shop","Outside Vendor"=>"Outside Vendor");
	
	
	
if(@$_POST['rep']=="")
	{
	$sql = "SELECT distinct location FROM sign_list_1 as t1 
	WHERE  1 order by location";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
		while($row=mysqli_fetch_assoc($result))
			{$location_array[$row['location']]=$row['location'];}
			
	// ********** Filter row ************
	echo "<div align='center'><form method='POST'><table border='1' cellpadding='3'><tr>";
	
$excludeFields=array("submit","id","all","SR","justification","other_file_1","other_file_2","register","response","rep","cr_form","other_file_3","other_file_4");

$excel_array=array("dpr","purpose","comments");
		
	$checkbox=array();
	$radio=array("category","new_replace","source");
	$pull_down=array("location","district", "region", "background_color","letter_color","status","sign_type");
	$date_array=array("date_from","date_to","approv_DISU","approv_PIO","approv_CHOP_DIR","approv_BPA");
//print_r($allFields);
echo "<td colspan='6' align='center' bgcolor='aliceblue'>
					<font size='+2' color='purple'>Track Sign Request</font></td></tr>";
					
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
						$item="<table align='center' border='1'><tr><td colspan='6' align='center'>$v</td></tr><tr>";
						foreach($ck_array as $ck_fld=>$ck_value)
							{
							if(@$_POST['$v']==$ck_value)
								{$ckC="checked";}else{$ckC="";}
							$item.="<td><input type='radio' name='$v' value='$ck_fld' $ckC>$ck_value&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
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
							@$pass_dist=$value;
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
					if($v=="approv_BPA"){$v="received at sign shop";}
					if($v=="status"){$v="<font color='red'>$v</font>";}
				echo "<td>$v<br />$v1</td>"; //$td
				}
			
	//		$td="";
			
			if($ii==6 or $ii==15 or $ii==21)
				{
				echo "</tr><tr>";
				}
			
			}
			if($level>3)
				{
				$excel="Excel <input type='checkbox' name='rep' value='excel'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
			if(!isset($excel)){$excel="";}
			if($level>3)
				{$chop_link="<a href='track.php?link=chop'>CHOP</a>";}
				else
				{$chop_link="";}
			echo "<td align='center' colspan='6' align='center'>
			$excel
			All records <input type='checkbox' name='all' value='all'><br />
			<input type='submit' name='submit' value='Find'>
			&nbsp;&nbsp;&nbsp;
			<input type='submit' name='reset' value='Reset'>&nbsp;&nbsp;&nbsp;&nbsp;
			$chop_link</td>";
			
	echo "</tr></table></form></div>";	
	}
	else
	{	
	$excludeFields=array("submit","id","all","SR","justification","other_file_1","other_file_2","register","response","rep","cr_form");
	}
// ******** Enter your SELECT statement here **********
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($category_array_flip); echo "</pre>"; // exit;

$clause="";
foreach($_POST AS $k=>$v)
	{
	$like=array("purpose","comments","category","email","letter_size","sign_size","date_of_request");
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
	@$clause=rtrim($clause,",");
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
	
if($clause=="" and $level>1)
	{
	$clause="and status=''";
	
	// added to hopefully get Adrian to clean up the completed signs
//	if($_SESSION['sign']['tempID']=="Oneal1133")
//		{
//		$clause="and t1.status='Received at Sign Shop'";
//		}
	$sort_by="order by status, dpr";
	}

$field_list_1="t1.*";

//t1.approv_PASU,

if($level<2 AND @$_POST['rep']=="")
	{
	$lp=explode(",",$limit_park);
	foreach($lp as $k=>$v)
		{
		@$clause1.=" location='$v' OR ";
		}
		$clause1=rtrim($clause1," OR ");
		$clause.=" AND (".$clause1.")";
	}

if($level==2 AND @$_POST['rep']=="" and empty($_POST))
	{
	$clause=" and district='$limit_park' and approv_DISU='0000-00-00'";
	}

if($submit!="Find")
	{
	$CHOP_array=array("CHOP"=>"60033018","CHOP_OA"=>"60032920");
	if($level>3 AND @$_POST['rep']=="" and in_array($beacon_num,$CHOP_array) OR @$link=="chop")
		{
		$clause=" and (category=1 or category=2) and status='Received at Sign Shop' and approv_CHOP_DIR='0000-00-00'";
		}
	}
	
$sql="SELECT $field_list_1
FROM  sign_list_1 as t1
WHERE 1 $clause
$sort_by"; 
if($level>4){echo "$sql<br />";}
$result1 = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection));

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
	
	
	$num=count($ARRAY);
if($num<1)
	{
		echo "No record was found using: <b>$clause</b>";exit;
	}

//******************
function array_sum_key( $arr, $index){
    if(!is_array( $arr ) || sizeof( $arr ) < 1){
        return 0;
    }
    $ret = 0;
    foreach( $arr as $id => $data ){
        if( isset( $index )  ){
            $ret += (isset( $data[$index] )) ? $data[$index] : 0;
        }else{
            $ret += $data;
        }
    }
    return $ret;
}

$index='quantity';
$total_quantity=array_sum_key($ARRAY, $index);
//echo "t=$total_quantity";
	
$fieldNames=array_values(array_keys($ARRAY[0]));

if($num==1){$r="Sign Request";}else{$r="Sign Requests";}

if(@$_POST['rep']=="")
	{
	echo "<form action='form.php' method='POST'><table border='1' cellpadding='2'><tr><td colspan='30'><font color='green'> $num $r using <b>$clause</b></font></td></tr>";
	}
	
$sort_array=array("id","entity","billing_title","billing_city","billing_state","billing_last_name","pier_number","comment","billing_add_1","seawall_id","ramp_id","buoy_id","swim_line_id","buoy_assoc");

if(@$_POST['rep']=="excel")
	{
	header('Content-Type: application/vnd.ms-excel');
	$date=date("Y-m-d"); $filename="DPR_sign_Authorization_".$date.".xls";
	header("Content-Disposition: attachment; filename=$filename");
	echo "<table>";
	}

$excludeFields=array("id","register","response","other_file_1","other_file_2","justification","SR","cr_form","other_file_3","other_file_4");
	foreach($fieldNames as $k=>$v)
		{
		if(in_array($v,$excludeFields)){continue;}
			if($v=="location"){$v="park/section";}
			if($v=="requested_by"){$v="Updated by";}
			if($v=="approv_BPA"){$v="Received at sign shop";}
			$v1=str_replace("_"," ",$v);
			if(in_array($v,$sort_array))
				{
					$clause=str_replace("%","*",$clause);
					$v1="<a href=\"display.php?sort=$v&pass_clause=$clause\">$v1</a>";
				}
			if($v1=="quantity"){$v1.="<br />($total_quantity)";}
			@$header.="<th>$v1</th>";
		}


//print_r($fieldNames);
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
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;	
	echo "<tr$tr>";
		foreach($v as $k1=>$v1)
		{// field name=$k1  value=$v1
			if(in_array($k1,$excludeFields)){continue;}
			$var=$v1;
			$td="<td align='left' valign='top'>";
		if($k1=="dpr")
			{
			$v2=$ARRAY[$k]['id'];
			$v3=$ARRAY[$k]['category'];
			$v3=$ARRAY[$k]['category'][0];
			$file="edit_".$v3.".php";
			$td="<td align='center' valign='top'>";
			$var="<a href='$file?edit=$v2&submit=edit' target='_blank'>$v1</a>";
			$cat1="";
			if($v3==3)
				{
				$var=explode("3.",$v3); 
					$v3=3;
				$file="edit_3.php";
					$cat1="category=".@$var[1];
				$var="<a href='$file?edit=$v2&$cat1&submit=edit' target='_blank'>$v1</a>";
				}
			}
		
		if($k1=="category")
			{
			$val5="";
			$val1=explode(".",$v1);
			if(@$val1[1]=="")
				{
				$val3=$val1[0];
				}
			else
				{
				$val3=$val1[0];
				$val4=$val1[1];
				$val5="<font color='green'>".@$standard_sign_array[$val4]."</font>";
				}
			$val2="[".@$category_array[$val3]."] ";
			$var=$val2."<br />".$val5;
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
if(@$rep=="excel")
	{
	echo "</table></body></html>";
	}
	else
	{
	echo "</table></form></body></html>";
	}

?>
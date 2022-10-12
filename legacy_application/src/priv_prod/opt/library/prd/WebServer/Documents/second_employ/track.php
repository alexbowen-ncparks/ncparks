<?php
$database="second_employ";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

if(@$_POST['reset']=="Reset")
	{
	header("Location: track.php?database=second_employ&submit=Track+a+Request"); exit;
	}

$tab="Track Request";
if(@$_POST['rep']==""){include("menu.php");}

//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$limit_park=$_SESSION['second_employ']['position_code'];
if($_SESSION['second_employ']['beacon_num']=="60092637")
	{$limit_park="OPER";} // WORK AROUND for Martin Kane
	
$work_title=$_SESSION['second_employ']['working_title'];
$pass_tempID=$_SESSION['second_employ']['tempID'];
if($_SESSION['second_employ']['accessPark'] != "")
	{
	$limit_park=$_SESSION['second_employ']['accessPark'];
	}

// ********** Get Field Types *********
$excludeFields=array("submit","id","all","TA","justification","other_file_1","other_file_2","register","response","rep","request");
$excel_array=array("se_dpr","purpose","comments");
	
	$sql="SHOW COLUMNS FROM  se_list";
	 $result = @mysqli_QUERY($connection,$sql);
	while($row=mysqli_fetch_assoc($result))
			{
				$allFields[]=$row['Field'];
			}
			

if(@$_POST['rep']=="")
	{
	$sql = "SELECT distinct park_code FROM se_list as t1 
	WHERE  1 order by park_code";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
		while($row=mysqli_fetch_assoc($result))
			{$park_code_array[]=$row['park_code'];}
			
	// ********** Filter row ************
		echo "<div align='center'><form method='POST'><table border='1' cellpadding='3'><tr>";
	
	
	
	$dist_array=array("EADI","NODI","SODI","WEDI","STWD");
	$region_array=array("CORE","PIRE","MORE","STWD");
	$status_array=array("Approved","Not Approved","Pending","Void");
	$date_array=array("approv_OPS","approv_DPR_BO","approv_DIR","to_BPA","approv_BPA");

		foreach($allFields as $k=>$v)
			{
			if(in_array($v,$excludeFields)){continue;}
			{
			
			@$v1="<input type='text' name='$v' value='$_POST[$v]'>";
			
					
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
					
				If($v=="park_code")
					{
					$v1="<select name='$v'><option select=''></option>";
					foreach($park_code_array as $i_la=>$v_la)
						{
						if(@$_POST['park_code']==$v_la)
							{$s="selected";}else{$s="value";}
						$v1.="<option $s='$v_la'>$v_la</option>";
						}
					$v1.="</select>";
					}
					
				If($v=="status")
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
		
			
			if($v=="park_code"){$v="park/section";}
			if($v=="pending_BPA"){$v="Status";}
			if($v=="approv_BPA"){$v="Final Approval";}
			echo "<td>$v<br />$v1</td>";
				
			
			$td="";
			
			if(fmod($k,7)==1)
				{
					if($k==1){echo "<td colspan='7' align='center' bgcolor='aliceblue'>
					<font size='+2' color='purple'>Track Secondary Employment Request</font></td>";}
					echo "</tr><tr>";
				}
				
			}
			if($level>3)
				{
				$excel="Excel <input type='checkbox' name='rep' value='excel'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
				else
				{$excel="";}
				
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
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

$like=array("purpose","comments","pending_BPA","name");
$like_end=array("se_dpr");
$clause="";
foreach($_POST AS $k=>$v)
	{
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
				$clause.=" and t1.".$k."='".$v."'";						
				}
		}
	}
	@$clause=rtrim($clause,",");
	$sort_by="order by se_dpr DESC, notify_supervisor DESC";
	
	$sort_desc=array("se_dpr");
	
	if(@$pass_clause AND $submit=="")
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
	$sort_by="order by id desc";
	}

$pos1=strpos(strtolower($work_title),"super");	
$pos2=strpos(strtolower($work_title),"assistant");

if($tempID=="Coffman4471")
	{$pos1=1;}
	
if($level<2 AND $pos1=== false AND $pos2=== false)
	{
	$clause.=" AND t1.tempID='$pass_tempID'";
	}
	
if($pass_tempID=="Marquez2165") // a lock out for this person
	{
	$clause.=" AND t1.tempID='$pass_tempID'";
	}

if($level==2) // overview access
	{
	include("../../include/get_parkcodes_dist.php");
	$database="second_employ";
// 	$dist=$_SESSION[$database]['selectR']; 
	$dist=$_SESSION[$database]['select']; 
	echo "$dist Region<br />";
	$list=${"array".$dist};
	$subclause=" AND (";
	foreach($list as $lk=>$lv)
		{
		$subclause.="park_code='".$lv."' OR ";
		}
	$clause.=rtrim($subclause," OR ").")";
	}
	
if($clause==""){exit;}

$field_list_1="t1.id,
t1.se_dpr,
t1.park_code,
t1.email,
t1.comments,
t1.amount,
t1.date_from,
t1.date_to,
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
	foreach($lp as $k=>$v)
		{
		@$clause1.=" t1.park_code='$v' OR ";
		}
		$clause1=rtrim($clause1," OR ");
		$clause.=" AND (".$clause1.")";
	}
mysqli_select_db($connection,$database);	
$sql="SELECT *
FROM  se_list as t1
WHERE 1 $clause
$sort_by"; 
// echo "$sql";
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
	if($clause==" "){$clause="All records";}
	echo "<form action='form.php' method='POST'><table border='1' cellpadding='2'><tr><td colspan='30' align='left'><font color='green'>Contact info for $num $r using <b>$clause</b></font></td></tr>";
	}
	
$sort_array=array("id");

if(@$_POST['rep']=="excel")
	{
	header('Content-Type: application/vnd.ms-excel');
	$date=date("Y-m-d"); $filename="DPR_Sec_Employment_".$date.".xls";
	header("Content-Disposition: attachment; filename=$filename");
	echo "<table>";
	}

$excludeFields=array("id","request");
	foreach($fieldNames as $k=>$v)
		{
		if(in_array($v,$excludeFields)){continue;}
			if($v=="park_code"){$v="park/section";}
			if($v=="status"){$v="Status";}
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
		if($k1=="se_dpr")
			{
			$v2=$ARRAY[$k]['id'];
			$td="<td align='center' valign='top'>";
			$var="<a href='edit.php?edit=$v2&submit=edit'>$v1</a>";
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
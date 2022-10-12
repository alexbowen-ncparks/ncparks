<html><head>
<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>

</head>

<?php
ini_set('display_errors',1);
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//extract($_REQUEST);


if(!isset($_SESSION['le']['level']))
	{
	$_SESSION['le']['level']=$_SESSION['inspect']['level'];
	$_SESSION['le']['tempID']=$_SESSION['inspect']['tempID'];
	$_SESSION['le']['beacon']=$_SESSION['inspect']['beacon'];	
	$_SESSION['le']['accessPark']=$_SESSION['inspect']['accessPark'];	
	}

$level=$_SESSION['le']['level'];
$tempID=$_SESSION['le']['tempID'];
$beacon_num=$_SESSION['le']['beacon'];
$currPark=$_SESSION['le']['select'];
$accessPark=$_SESSION['le']['accessPark'];

	if($level<1)
		{
		exit;
		}	
include("../../include/get_parkcodes_dist.php");

$database="le";	
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
if($level>3)
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	}

// get DISU
$sql="SELECT concat(`parkcode`,'*',`location`,'*',`loc_code`) as var_location
FROM cite.location
where 1
order by parkcode,location
"; //echo "$sql";
$result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
		@$source_loc.="\"".$row['var_location']."\",";
		}
	$source_loc=rtrim($source_loc,",");
		
//echo "$source_loc";  exit;
$sql="SELECT distinct narcan
		FROM le.pr63_pio
		where 1 
		";
		$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
		$narcan_array=array();
		while($row=mysqli_fetch_assoc($result))
					{$narcan_array[]=$row['narcan'];}

$sql="SELECT distinct use_of_force
		FROM le.pr63_pio
		where 1 and use_of_force !=''
		";
		$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
		$use_of_force_array=array();
		while($row=mysqli_fetch_assoc($result))
					{
					$use_of_force_array[]=$row['use_of_force'];
					}
							
$sql="SELECT * FROM disposition order by disposition_code";
 $result = @mysqli_QUERY($connection,$sql) or die("$sql".mysqli_error($connection)); 
while($row=mysqli_fetch_assoc($result))
		{
		if($level<4 and $row['disposition_desc']=="VOID"){continue;}
		$disposition_array[$row['disposition_code']]=$row['disposition_desc'];
		}

$sql="SELECT distinct parkcode FROM pr63_pio order by parkcode";
 $result = @mysqli_QUERY($connection,$sql) or die("$sql".mysqli_error($connection)); 
while($row=mysqli_fetch_assoc($result))
		{
		$parkcode_array[]=$row['parkcode'];
		}
if(empty($parkcode_array)){array_unshift($parkcode_array,"");}
//secho "<pre>"; print_r($parkcode_array); echo "</pre>"; // exit;

$sql="SELECT distinct t1.incident_code, t2.incident_desc
FROM pr63_pio as t1
left join incident as t2 on t1.incident_code=t2.incident_code
order by t1.incident_code";
 $result = @mysqli_QUERY($connection,$sql) or die("$sql".mysqli_error($connection)); 
while($row=mysqli_fetch_assoc($result))
		{
		$var_ic=$row['incident_code']."*".$row['incident_desc'];
		@$incident_code_source.="\"".$var_ic."\",";
		}
// echo "<pre>"; print_r ($incident_code_source); echo "</pre>";  exit;

$skip=array("submit_supervisor");
$sql="SHOW COLUMNS FROM pr63_pio";
 $result = @mysqli_QUERY($connection,$sql); 
while($row=mysqli_fetch_assoc($result))
		{
		if(in_array($row['Field'],$skip)){continue;}
		$allFields[]=$row['Field'];
		}
//echo "<pre>"; print_r($allFields); echo "</pre>"; // exit;

echo "<body bgcolor='beige'  class=\"yui-skin-sam\">";

echo "<table align='center'><tr><th colspan='3'>
<h3><font color='purple'>NC DPR PR-63 / DCI for Districts</font></h3></th></tr>
<tr><th>
<a href='pr63_home.php'>PR-63 / DCI Home Page</a></th>
<th>&nbsp;&nbsp;&nbsp;</th>
<th>
<a href='find_pr63_pio.php'>Search Form</a></th>";

if($level > 4 AND !empty($_POST))
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	$skip_post=array("submit");
	foreach($_POST AS $fld=>$val)
		{
		if(array_key_exists($fld, $skip_post)){continue;}
		if(!empty($val))
			{
			$temp[]="<input type='hidden' name='$fld' value=\"$val\">";
			}
		}
	$clause=implode(" ",$temp);
	echo "<th>&nbsp;&nbsp;&nbsp;</th>";
	echo "<th><form method='POST' ACTION='export_csv.php'>";
	echo "$clause";
	echo "<input type='submit' name='submit_form' value=\"Export to CSV\">";
	echo "</form></th>";
	}
echo "</tr></table>";

echo "<div align='center'>";
echo "<form action='find_pr63_pio.php' method='POST' enctype='multipart/form-data'>";

$rename_fields=array("ci_num"=>"Case Incident Number/OCA","call_out"=>"Call Out","parkcode"=>"Park Code","location_code"=>"Location Code","loc_name"=>"Location of Incident","date_occur"=>"When did it occur?","time_occur"=>"24 hr. Time","day_week"=>"Day of Week","incident_code"=>"Incident Code","incident_name"=>"Nature of Incident","report_how"=>"How Reported","report_by"=>"Reported by","report_address"=>"Address","report_phone"=>"Phone number of person making report","report_receive"=>"Received by","report_receive_date"=>"Received date","report_investigate_date"=>"Investigated date","report_investigate_time"=>"Investigated time", "report_receive_time"=>"Received time", "weather"=>"Weather", "investigate_by"=>"Investigated by", "clear_date"=>"Date Cleared","clear_time"=>"Time Cleared","disposition"=>"Disposition","details"=>"Details of Incident<br /><font size='2'>Enter a search word or phrase.</font>","dist_approve"=>"DISU Approved","le_approve"=>"LE Reviewed","pasu_approve"=>"PASU Approved","pasu_name"=>"PASU Name","disu_name"=>"RESU Name","entered_by"=>"Entered by","narcan"=>"NALOXONE / NARCAN","use_of_force"=>"Use of Force");

//$readonly=array("ci_num","loc_name");
$radio=array("dist_approve","le_approve","pasu_approve","resistance","weapon_possession","weapon_use","pursuit");
$yes_no_array=array("Y"=>"y","N"=>"n");

// $pasu_approve_array=array("Y"=>"y","N"=>"n");
// $dist_approve_array=array("Y"=>"y","N"=>"n");
// $le_approve_array=array("Y"=>"y","N"=>"n");

$excludeFields=array("id","lat","lon");

$textarea=array("details");
$hard_fields=array("ci_num","parkcode");
$drop_down=array("parkcode","disposition","narcan","use_of_force");

if(!empty($_REQUEST['ci_num'])){$_POST['ci_num']=$_REQUEST['ci_num'];}

if($_POST)
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

$skip=array("submit","exclude_void","submit_form");	
	$clause="1 AND ";
	foreach($_REQUEST as $k=>$v)
		{
		if(in_array($k,$skip)){continue;}
		if($v)
			{
			if($k=="location_code")
				{
				$exp=explode("*",$v);
				$v=$exp[2];
				}
			if($k=="incident_code")
				{
				$exp=explode("*",$v);
				$v=$exp[0];
				}
			$pass_fld[]=$k;
			IF($k=="pasu_approve")
				{
				if($v=="y")
					{$clause.=$k." > '0000-00-00' AND "; continue;}
					else
					{$clause.=$k." = '' AND "; continue;}
				}
			IF($k=="dist_approve")
				{
				if($v=="y")
					{$clause.=$k." > '0000-00-00' AND "; continue;}
					else
					{$clause.=$k." = '' AND "; continue;}
				}
			IF($k=="le_approve")
				{
				if($v=="y")
					{$clause.=$k." = 'x' AND "; continue;}
					else
					{$clause.=$k." = '' AND "; continue;}
				}
			IF($k=="district")
				{
				$var_reg=${"array".$v};
				$temp=" (";
				foreach($var_reg as $k1=>$v1)
					{
					$temp.="parkcode ='$v1' OR ";
					}
				$clause.=rtrim($temp," OR ").") AND ";
				continue;
				}
			$clause.=$k." like '%".$v."%' AND ";
			}
		}
	
	$clause=rtrim($clause," AND ");
	if($level<2)
		{
		if(!empty($accessPark))
			{
			$access_array=explode(",",$accessPark);
			$parkcode=$_POST['parkcode'];
			IF(in_array($parkcode,$access_array))
				{$clause.=" AND parkcode='$parkcode'";}
			}
		if(empty($clause))
			{
			$eb=$_SESSION['le']['tempID'];
			if($currPark=="NERI" OR $currPark=="MOJE")
				{$clause.=" AND (parkcode='NERI' OR parkcode='MOJE' OR entered_by='$eb')";}
				else
				{$clause.=" AND (parkcode='$currPark' OR entered_by='$eb')";}
			
			}
		}
	
	if(!empty($_POST['exclude_void'])){$clause.=" and disposition!='09'";}
//	echo "<pre>"; print_r($pass_fld); echo "</pre>"; // exit;
	
	$sql="SELECT * FROM pr63_pio where $clause  order by ci_num desc";  
	//echo "$sql"; exit;
 	$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql"; exit;
 	$num=mysqli_num_rows($result); //echo "n=$num";
 		if($num==1)
 			{
			$row=mysqli_fetch_assoc($result); extract($row);
			header("Location: pr63_form_pio.php?id=$id");
			exit;
			}

// ************************* RESULTS ******************************
 		if($num>1)
 			{
			while($row=mysqli_fetch_assoc($result))
				{
				$ARRAY[]=$row;
				}

				
 			echo "<table border='1' cellpadding='5'>";
 			$f1="<font color='brown'>";$f2="</font>";
			foreach($ARRAY as $index=>$array)
				{
				@$i++;
				extract($array);
				$ci_link="<a href='pr63_form_pio.php?id=$id'>$ci_num</a>";
				IF($index==0)
					{
					echo "<tr><td></td>
					<td align='center'>CI Num</td>
					<td align='center'>Park</td>
					<td align='center'>Nature of Incident</td>
					<td align='center'>Location</td>
					<td align='center'>Date of Incident</td>
					<td align='center'>Completed by</td>
					<td align='center'>PASU Approve</td>
					<td align='center'>DISU Approve</td>
					<td align='center'>RAOF Review</td>
					";
					echo "</tr>";
					
					}
			
					echo "<tr><td>$i</td>
					<td align='center'>$f1$ci_link$f2</td>
					<td align='center'>$f1$parkcode$f2</td>
					<td align='left'>$f1$incident_name$f2</td>
					<td align='left'>$f1$loc_name$f2</td>
					<td align='center'>$f1$date_occur$f2</td>
					<td align='left'>$f1$investigate_by$f2</td>
					<td align='left'>$f1$pasu_approve$f2</td>
					<td align='left'>$f1$dist_approve$f2</td>
					<td align='left'>$f1$le_approve$f2</td>
					";
					
					echo "</tr>";
					
				}
			echo "</table>";
			exit;
			}
 		if($num<1)
 			{
			$message="No PR-63 / DCI found using $clause";
			}
	}


// ***************** Search Form ***************************

$district_array=array("EADI","NODI","SODI","WEDI");

$pio_array=array("time_pio_date","nature_of_incident","time_pio_incident","time_pio_location");
$skip_flds=array_merge($excludeFields,$pio_array);
//echo "<pre>"; print_r($row); echo "</pre>"; // exit;
if(!isset($message)){$message="";}
echo "<table border='1' cellpadding='3'>
<tr><th>$message</th></tr>
<tr><td><table>";

		foreach($allFields as $k=>$v)
			{
			@$j++;
			if(in_array($v,$skip_flds)){continue;}
			
			if(empty($rename_fields[$v]))
				{
				if(substr($v, 0,5)=="text_"){continue;}
				$v0=$v;
				}
				else
				{$v0=$rename_fields[$v];}
			
			
			@$value=${$v};
		
			$v1="<input type='text'  id=\"$v\" name='$v' value='$value' size='35'>";
			
			if($v=="incident_code")
				{
				$v1.="
				<script>
				$(function()
				{
				$( \"#incident_code\" ).autocomplete({source: [ $incident_code_source]});
				});
				</script>
				";
				}
			if($v=="location_code")
				{
				$v1.="
				<script>
				$(function()
				{
				$( \"#location_code\" ).autocomplete({source: [ $source_loc]});
				});
				</script>
				";
				}
			if(in_array($v,$drop_down))
				{
				$dd_array=${$v."_array"};
				$v1="<select name='$v'><option selected=''></option>\n";
					foreach($dd_array as $i=>$display_value)
						{
						$s="value";
						$send_value=$display_value;
						if($v=="parkcode")
							{
							if($display_value==$currPark)
								{$s="selected";}
							}
						if($v=="disposition")
							{
							$send_value=$i;
							}
						$v1.="<option $s='$send_value'>$display_value</option>";
						}
				$v1.="</select>";
				if($v=="parkcode" and $level>1)
					{
					$v1.=" District <select name='district'><option selected=''></option>\n";
					foreach($district_array as $i=>$display_value)
						{
						$s="value";
						$send_value=$display_value;
						
						$v1.="<option value='$send_value' $s>$display_value</option>";
						}
				$v1.="</select>";
					}
				}
			if(in_array($v,$textarea)) // Institution
				{	
					$str=strlen($value);
					$rows=2;
					$v1="<textarea name='$v' rows='$rows' cols='26'>$value</textarea>";
				}
				
			if($v=="call_out") // Institution
				{	
					$str=strlen($value);
					$rows=2;
					$v1="<input type='checkbox' name='$v' value='x'>";
				}
				
			if(in_array($v,$radio))
				{
				$v1="";
// 				$fld_array=${$v."_array"};
				foreach($yes_no_array as $ka=>$va)
					{
					if($value==$va){$ck="checked";}else{$ck="";}
					$v1.="<input type='radio' name='$v' value='$va' $ck>$ka ";
					}
				}	
			
			if(fmod($j,2)==0)
				{echo "<tr><td>$v0</td><td>$v1</td>";}
				else
				{echo "<td>$v0</td><td>$v1</td></tr>";}
			
			}
		
echo "</table></tr></tr></table>

<table><tr>
<td>Exclude VOID <input type='checkbox' name='exclude_void' value='x' checked></td>
<td align='center'>";
		
echo "<input type='submit' name='submit' value='Search'>
</td>";
echo "</tr></table></form>     
         </div>    ";	

echo "</body></html>";
?>
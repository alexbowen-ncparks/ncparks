<?php
ini_set('display_errors',1);
if(empty($_SESSION))
	{
	session_start();
	}
// echo "l=$level <pre>"; print_r($_SESSION); echo "</pre>";  exit;
if(empty($level))
	{$level=$_SESSION['dpr_it']['level'];}
	
if($level>4)
	{
// 	 echo "Shown only for level > 4 <pre>"; print_r($_POST); echo "</pre>";  //exit;
	}
$skip=array("select_table","submit_form");

if(empty($select_table))
	{
date_default_timezone_set('America/New_York');
	extract($_POST);
	$search_skip=array("id","division","district_section","division","search_comment");
	$equal_array=array("id","district_section","region_section","location","type","os", "make", "model", "fas", "site_id", "printer", "site_name", "current_service_provider", "vlan");
	}
	
$comment_join="";
$t2_flds="";	
FOREACH($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	if($value==NULL){continue;}
	$pass_search[$select_table][$fld]=$value;

	if($fld=="search_comment" and !empty($search_comment))
		{
		$var_fld="comments_".$select_table;
		$t2_flds=", t2.".$var_fld;
		$temp[]="t2.".$var_fld." like '%$search_comment%'";
		$join_fld=$select_table."_id";
		$comment_join="left join $var_fld as t2 on t1.id=t2.$join_fld";
		continue;
		}
	
	if(in_array($fld,$equal_array))
		{$temp[]="t1.".$fld."='".$value."'";}
		else
		{$temp[]="t1.".$fld." like '%".$value."%'";}
	}
if(empty($pass_search)){$pass_search=array();}

if(empty($temp))
	{
	$clause="1";
	$select_table=$_POST['select_table'];
	if($select_table=="computers")
		{
		$clause="1 and location=''";
		$message="<br /><font color='red'>Showing all $select_table which have not been assigned to a location.</font><br /><br />";
		}
	}
	else
	{$clause=implode(" and ",$temp);}

// modify for excel export
if(empty($select_table)){$select_table=$_POST['select_table'];}
if(@is_array($_POST['printers']))
	{
	foreach($_POST['printers'] as $fld=>$val)
		{
		if(in_array($fld,$skip)){continue;}
		$new[]="t1.".$fld."='$val'";
		}
	$clause=implode(" and ",$new);
	}

if(@$region_section=="all")
	{$clause="1";}

// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
if($select_table=="subnets")
	{
	$order_by="location";
	}
	else
	{
	$order_by="location, sn_service_tag";
	}

if(!empty($pass_clause))
	{
	$clause=stripslashes($pass_clause);
	if($submit_form!="Return")
		{
		$rename=str_replace("\\r\\n","_", $_POST['submit_form']);
		$rename=str_replace(" ","_", $_POST['submit_form']);
		$order_by=$rename." ".$pass_order_by;
		if($rename=="sn_service_tag")
			{
			$sql="SELECT COUNT(sn_service_tag) as num, t1.* from computers as t1 WHERE 1 group by sn_service_tag having num>1 order by cOUNT(sn_service_tag) desc";
			$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			while($row=mysqli_fetch_assoc($result))
				{
				$ARRAY_sn_service_tag[$row['sn_service_tag']]=$row['num'];
				}
			echo "These sn_service_tag have been assigned to more than 1 $select_table<pre>"; print_r($ARRAY_sn_service_tag); echo "</pre>"; // exit;
			}
		}
		
	$var_fld="comments_".$select_table;
		$t2_flds=", t2.".$var_fld;
		$join_fld=$select_table."_id";
		$comment_join="left join $var_fld as t2 on t1.id=t2.$join_fld";
	}	

if(empty($connection))
	{
	$database="dpr_it"; 
	include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
	mysqli_select_db($connection,"dpr_it");
	
	include("ARRAY_computer_status_rename.php");  // includes  $ARRAY_computer_status_rename
	}
	
if($level==1)
	{
	IF(!empty($temp_array))
		{
		$where="(location='".implode("' or location='",$temp_array)."')";
		}
		else
		{$where="location='$location'";}
	$sql = "SELECT * FROM confirmation where $where";  
// 	echo "$sql"; exit;
	$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_confirmation[$row['location']][$row['item']]=array("date"=>$row['date'],"confirmation_comments"=>$row['confirmation_comments']);
		}
// echo "<pre>"; print_r($ARRAY_confirmation); echo "</pre>"; // exit;
	}
		
$sql="SELECT t1.* $t2_flds
from $select_table as t1
$comment_join
WHERE $clause order by $order_by"; 

if(@$level>4)
	{
// 	ECHO "$sql"; //exit;
// 	echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	}
 
if(!empty($message))
	{
	echo "$message";
	}
	
$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
//  echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;



if($submit_form=="Excel Export")
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//  echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
 	if($level==1)
 		{
 		$skip_fld=array("district_section","PO_num","PO_date","date_received_ware","date_leaves_ware");
 		$new_ARRAY=array();
 		foreach($ARRAY as $index=>$array)
 			{
 			foreach($array as $fld=>$value)
 				{
 				if(in_array($fld, $skip_fld)){continue;}
 				if($fld=="computer_status")
 					{
 					$value=$ARRAY_computer_status_rename[$value];
 					}
				$new_ARRAY[$index][$fld]=$value;
 				}
 			}
 		$ARRAY=$new_ARRAY;
 		}

	$header_array[]=array_keys($ARRAY[0]);
	$filename=$select_table."_".date("Y-m-d").".csv";
	header("Content-Type: text/csv");
	header("Content-Disposition: attachment; filename=$filename");
	// Disable caching
	header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
	header("Pragma: no-cache"); // HTTP 1.0
	header("Expires: 0"); // Proxies

// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
	function outputCSV($header_array, $data) {
		$output = fopen("php://output", "w");
		foreach ($header_array as $row) {
			fputcsv($output, $row); // here you can change delimiter/enclosure
		}
		foreach ($data as $row) {
			fputcsv($output, $row); // here you can change delimiter/enclosure
		}
		fclose($output);
	}

	outputCSV($header_array, $ARRAY);

	exit;
	}
	
	
$skip_view=array("district_section","division");
if(mysqli_num_rows($result)<1)
	{
	echo "No record found.";
	}
	else
	{
	$skip=array("select_table","submit_form");
	$c=count($ARRAY);
	$select_table=="printers"?$colspan--:NULL;    // $colspan from search_form.php
	$singular_table=substr($select_table, 0, -1);
	if($select_table=="switches")
		{$singular_table=substr($select_table, 0, -2);}
// 	echo "$sql";
// 	echo "<pre>"; print_r($pass_search); print_r($ARRAY); echo "</pre>"; // exit;
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	echo "<div><table class='alternate'><tr><td colspan='8'>";
	$var_position=$_SESSION['position'];
	$confirm_array=array("Park Superintendent","Parks District Superintendent");
	if($level==1 and in_array($var_position,$confirm_array))
		{
		$date_value="";
		if(empty($location)){$location="";}
		$tempID=substr($_SESSION['logname'],0,-4);
		$emid=$_SESSION['logemid'];
		@$date_value=$ARRAY_confirmation[$location][$select_table]['date'];
		@$comment_value=$ARRAY_confirmation[$location][$select_table]['confirmation_comments'];
		echo "<form action='confirmation.php' method='POST'>";
		echo "$tempID <input id='datepicker1' type='text' name='date' value=\"$date_value\" size=11'>";
		echo "<br /><textarea name='confirmation_comments' rows='4' cols='100'>$comment_value</textarea>";
		echo "<input type='hidden' name='location' value=\"$location\">";
		echo "<input type='hidden' name='select_table' value=\"$select_table\">";
		echo "<input type='hidden' name='emid' value=\"$emid\">";
		echo "<br /><input type='submit' name='submit_form' value=\"Update\">";
		echo "Enter date and any comments to confirm the $location inventory of $select_table is correct.";
		echo "</form>";
		}
	
	echo "</td>";
	
		echo "<td align='center' colspan='1'><form action='search_action.php' method='POST'>";
		foreach($_POST as $k1=>$v1)
			{
			$name=$k1;
			echo "<input type='hidden' name='$name' value=\"$v1\">";
			}
		echo "<input type='hidden' name='select_table' value=\"$select_table\">
		<input type='hidden' name='$fld' value=\"$value\">
		<input type='submit' name='submit_form' value=\"Excel Export\">
		</form></td>";
	$var_y="";
	if($level>3)
		{

		$var_y="<td align='center' colspan='2'><form action='subnet_export.php' method='POST' target='_blank'>";
		$var_y.="<input type='hidden' name='select_table' value=\"$select_table\">
		<input type='hidden' name='$fld' value=\"$value\">
		<input type='submit' name='submit_form' value=\"Site ID Export\">
		</form></td>";
		if($select_table=="computers"){$var_y.="<td align='center' colspan='7'></td>";}
		}
		else
		{echo "<td align='center' colspan='$colspan'></td>";}
	
	$value=$var_y;
	echo "$value</tr>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip_view)){continue;}
				$var_fld=str_replace("_"," ",$fld);
				if($fld!="id")
					{
					@$pass_order_by=="asc"?$pob="desc":$pob="asc";
					echo "<th bgcolor='#ffc266'><form method='POST' action='search_form.php'>
					<input type='hidden' name='select_table' value=\"$select_table\">
					<input type='hidden' name='pass_clause' value=\"$clause\">
					<input type='hidden' name='pass_order_by' value=\"$pob\">
					<input type='submit' name='submit_form' value=\"$var_fld\">
					</form></th>";
					}
					else
					{
					if($c==1){$st=$singular_table;}else{$st=$select_table;}
					echo "<th>$c $st</th>";
					$var_fld="";
					
					}
				
				$header_array[]="<th>$var_fld</th>";
				}
			echo "</tr>";
			}
// 		echo "<pre>"; print_r($header_array); echo "</pre>"; // exit;
		if(fmod($index,20)==0 and $index!=0)
			{
			$header=implode("",$header_array);
			echo "<tr>$header</tr>";
			}
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip_view)){continue;}
			if($fld=="id")
				{
				$var_id=$value;
				$var_x="<form action='edit.php' method='POST'>";
				foreach($pass_search as $k=>$v)
					{
					foreach($v as $k1=>$v1)
						{
						$name=$k."[$k1]";
						$var_x.="<input type='hidden' name='$name' value=\"$v1\">";
						}
					}
				$var_x.="<input type='hidden' name='select_table' value=\"$select_table\">
				<input type='hidden' name='$fld' value=\"$value\">
				<input type='submit' name='submit_form' style=\"color:green\" value=\"Edit $singular_table\">
				</form>";
				$value=" ID=".$var_id.$var_x;
				if($level>3 and $singular_table=="computer")
					{
					$var_y="<form action='edit.php' method='POST'>";
					foreach($pass_search as $k=>$v)
						{
						foreach($v as $k1=>$v1)
							{
							$name=$k."[$k1]";
							$var_y.="<input type='hidden' name='$name' value=\"$v1\">";
							}
						}
					$var_y.="<input type='hidden' name='select_table' value=\"$select_table\">
					<input type='hidden' name='$fld' value=\"$var_id\">
					<input type='submit' name='submit_form' style=\"color:green\" value=\"BWO\">
					</form>";			
				$value.=$var_y;
					}
				}
			if($fld=="site_id" and $level>2)
				{
				$var_x="<form action='search_form.php' method='POST'>";
				$var_x.="<input type='hidden' name='select_table' value=\"subnets\">
				<input type='hidden' name='$fld' value=\"$value\">
				<input type='submit' name='submit_form' value=\"$value\">
				</form>";
				$value=$var_x;
				}
			if($fld=="computer_status" or $fld=="printer_status")
				{
				$var_x=$ARRAY_computer_status_rename[$value];
				if($var_x=="Received in Raleigh")
					{$var_x="<font color='red'>".$var_x."</font>";}
				if($var_x=="To be Surplused")
					{$var_x="<font color='orange'>".$var_x."</font>";}
				if($var_x=="Sent to Raleigh")
					{$var_x="<font color='magenta'>".$var_x."</font>";}
				$value=$var_x;
				}

			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table></div>";
	}
	
?>



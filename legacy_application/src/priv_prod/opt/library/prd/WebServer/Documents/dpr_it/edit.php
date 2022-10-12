<?php

/********************************************************************************
Name: John Carter             Related Ticket(s): Jira TIC - 33 & 34
Date: 20220916
Description: DPR-IT (Carl Jeeter) asked to have 3 options removed from the 'printer status': 'surplus','surp_tobe','surp_process'

[Include files]
- ../../include/auth.inc
- ../../include/iConnect.inc
- /dpr_it/upload_surplus_doc.php
- /dpr_it/_base_top.php
- /dpr_it/search_form.php
- /dpr_it/search_arrays.php
- /dpr_it/computer_history.php

[Arrays created/used] 
- $skip
- $alt_value_array
- $port_array
- $equal_array
- $temp
- $search_computers_dropdown
- $search_printers_dropdown
- $search_subnets_dropdown
- $search_switches_dropdown
- $date_field_array
- $ARRAY_computer_status
- $ARRAY_printer_status
- $readonly_array
- $drop_down_array
- $search_array
- $date_field_array
- $force_array

[Databases accessed]
- dpr_it
- dpr_it.switch_ports
- dpr_system.parkcode_names_district
- dpr_it.computers_history
- dpr_it.switch_ports_track

---------------------------------------------------------------------------
                                Change Log
---------------------------------------------------------------------------
{youngest}
20220916 - [TIC<34>] : removed three options for 'computer status': 'surplus', 'surplus_tobe', 'surplus process'
20220619 – [TIC<33>] : <description of change>
{oldest}
******************************************************************************/


ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="dpr_it"; 
$dbName="dpr_it";
include("../../include/auth.inc"); // include iConnect.inc with includes no_inject.php
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

if($level>4)
	{
// 	 echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	}

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$skip = array("id",
			"submit_form",
			"select_table",
			"computers",
			"printers",
			"subnets",
			"switches",
			"previous_comments",
			"comments_computers",
			"comments_printers",
			"comments_subnets",
			"comments_switches",
			"ports",
			"file_upload"
		);

$alt_value_array = array("alt_type" => "type",
						"alt_os" => "os",
						"alt_vlan" => "vlan",
						"alt_vlan" => "vlan",
						"alt_current_service_provider" => "current_service_provider",
						"alt_site_id" => "site_id",
						"alt_gateway" => "gateway"
					);


$level = $_SESSION[$database]['level'];
$location = $_SESSION[$database]['select'];
$tempID = $_SESSION[$database]['tempID'];

// echo "level = $level
// location = $location";

$sql="SELECT * FROM switch_ports"; 
$result = mysqli_query($connection,$sql) or die("$sql Error 1#");
while($row=mysqli_fetch_assoc($result))
	{
	$port_array[$row['id']]=$row['port_name'];
	}
// echo "port_array<pre>"; print_r($port_array); echo "</pre>"; // exit;

$skip_readonly=array("computer_status","printer_status");
$sql="SHOW columns from $select_table"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die("$sql");
while($row=mysqli_fetch_assoc($result))
	{
	if(in_array($row['Field'], $skip_readonly)){continue;}
	$ARRAY_flds[]=$row['Field'];
	}
// echo "<pre>"; print_r($ARRAY_flds); echo "</pre>"; // exit;
	
if($level<4)
	{
	$readonly_array=$ARRAY_flds;
	}
	else
	{
	$readonly_array=array();
	}
// echo "<pre>"; print_r($readonly_array); echo "</pre>"; // exit;

 if(!empty($_POST['submit_form']))
 	{
 	if($submit_form=="Update")
 		{
// 		 echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  //exit;
		FOREACH($_POST as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if(array_key_exists($fld, $alt_value_array)){continue;}
			$alt_fld="alt_".$fld;
			if(in_array($fld, $alt_value_array) and !empty($_POST[$alt_fld]))
				{
				$temp[]="$fld='".$_POST[$alt_fld]."'";
				continue;
				}
			$temp[]="`".$fld."`='".$value."'";
			}
		if(array_key_exists("location",$_POST))
			{
			$val=$_POST['location'];
			$sql="SELECT `district` from dpr_system.parkcode_names_district
			where park_code='$val'
			"; 
// 			echo "$sql<br />";
			$result = mysqli_query($connection,$sql) or die("$sql");
			IF(mysqli_num_rows($result)>0)
				{
				$row=mysqli_fetch_assoc($result);
				$temp[]="`district_section`='".$row['district']."'";
				}
			
			}
		$clause=implode(", ",$temp);
// 		echo "$clause"; exit;
		$sql="UPDATE $select_table
			set $clause
			where id='$id'
			"; 
// 		ECHO "level 4 $sql"; exit;
		$result = mysqli_query($connection,$sql) or die("$sql");
		$_POST['id']=$id;
		if(!empty($_POST['comments_computers']))
			{
			$author=substr($_SESSION['dpr_it']['tempID'],0,-4)."-".date('Y-m-d h:i:s');
			$var_comments=$comments_computers.": ".$author."\n\n";
			$sql="INSERT INTO comments_computers
			set comments_computers='$var_comments', computers_id='$id'
			"; 
			$result = mysqli_query($connection,$sql) or die("$sql");
			}
		if(!empty($_POST['comments_printers']))
			{
			$author=substr($_SESSION['dpr_it']['tempID'],0,-4)."-".date('Y-m-d h:i:s');
			$var_comments=$comments_printers.": ".$author."\n\n";
			$sql="INSERT INTO comments_printers
			set comments_printers='$var_comments', printers_id='$id'
			"; 
			$result = mysqli_query($connection,$sql) or die("$sql");
			}
		if(!empty($_POST['comments_subnets']))
			{
			$author=substr($_SESSION['dpr_it']['tempID'],0,-4)."-".date('Y-m-d h:i:s');
			$var_comments=$comments_subnets.": ".$author."\n\n";
			$sql="INSERT INTO comments_subnets
			set comments_subnets='$var_comments', subnets_id='$id'
			"; 
			$result = mysqli_query($connection,$sql) or die("$sql");
			}
		if(!empty($_POST['comments_switches']))
			{
			$author=substr($_SESSION['dpr_it']['tempID'],0,-4)."-".date('Y-m-d h:i:s');
			$var_comments=$comments_switches.": ".$author."\n\n";
			$sql="INSERT INTO comments_switches
			set comments_switches='$var_comments', switches_id='$id'
			"; 
			$result = mysqli_query($connection,$sql) or die("$sql".mysqli_error($connection));
			}
		if(!empty($_POST['computer_history']))
			{
			$author=substr($_SESSION['dpr_it']['tempID'],0,-4)."-".date('Y-m-d h:i:s');
			$var_comments=$computer_history;
			$sql="INSERT INTO computers_history
			set action='$var_comments', id='$id', track='$author'
			"; 
			$result = mysqli_query($connection,$sql) or die("$sql");
			}
			
		if(!empty($_POST['ports']))
			{
// 			echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
			$temp=array();
			$switch_id=$_POST['id'];
			$sql="DELETE FROM switch_ports_track
			where switch_id='$switch_id'"; 
			$result = mysqli_query($connection,$sql) or die("$sql");
			FOREACH($_POST['ports'] as $port_number=>$port_id)
				{
// 				foreach($array as $port_id=>$port_name)
// 					{
					$sql="INSERT INTO switch_ports_track
					set switch_id='$switch_id', port_number='$port_number', port_id='$port_id'"; 
// 					echo "$sql";exit;
					$result = mysqli_query($connection,$sql) or die("$sql");
// 					}
				}
			}
		if(!empty($_FILES['file_upload']['tmp_name']))
			{
// 			echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;
			$item_id=$_POST['id'];
			$item_type=$_POST['select_table'];
			$sn_service_tag=$_POST['sn_service_tag'];
			
			$sql="REPLACE surplus_docs
			set item_id='$item_id', item_type='$item_type', sn_service_tag='$sn_service_tag'
			"; 
			$result = mysqli_query($connection,$sql) or die("$sql");
			$surplus_docs_id=mysqli_insert_id($connection);
			
			include("upload_surplus_doc.php");
			
			$sql="UPDATE surplus_docs
			set link='$uploadfile'
			where id='$surplus_docs_id';
			"; 
			$result = mysqli_query($connection,$sql) or die("$sql");
			
			$sql="UPDATE $item_type
			set location='SURPLUS_D', computer_status='surplus'
			where id='$item_id';
			"; 
			$result = mysqli_query($connection,$sql) or die("$sql");
			
			$_POST['location']="SURPLUS_D";
			$_POST['computer_status']="surplus";
			}
		$message="successful.";
 		}
 		
 		
 	if($submit_form=="Delete")
 		{
		$sql="DELETE FROM $select_table
			where id='$id'
			"; 
// 		ECHO "level 4 $sql"; exit;
		$result = mysqli_query($connection,$sql) or die("$sql");
		include("_base_top.php");
		echo "That record has been removed.";
		exit;
 		}
 		
 	if($submit_form=="BWO")
 		{
		$sql="UPDATE $select_table
			set computer_status='bwo'
			where id='$id'
			"; 
		// ECHO "level 4 $sql<br /><br />"; //exit;
		$result = mysqli_query($connection,$sql) or die("$sql");
		$bwo_table="comments_".$select_table;
		$last_name=substr($tempID,0,-4);
		$comments_computers="being worked on: $last_name-".date("Y-m-d H:i:s");
		$sql="INSERT INTO $bwo_table
			set computers_id='$id', comments_computers='$comments_computers'
			
			"; 
// 		ECHO "level 4 $sql"; exit;
		$result = mysqli_query($connection,$sql) or die("$sql");
 		}
 	} // end submit_form

$switch_port_values=array();
$sql="SELECT * FROM switch_ports_track where switch_id='$_POST[id]'"; 
$result = mysqli_query($connection,$sql) or die("$sql Error 1#");
while($row=mysqli_fetch_assoc($result))
	{
	$switch_port_values[$row['port_number']]=$row['port_id'];
	}
// echo "switch_port_values<pre>"; print_r($switch_port_values); echo "</pre>"; // exit;
 
$skip = array("select_table",
				"submit_form",
				"computers",
				"printers",
				"subnets",
				"switches",
				"previous_comments",
				"comments_computers",
				"comments_printers",
				"comments_subnets",
				"comments_switches",
				"alt_os",
				"ports"
			);
$equal_array = array("id",
					"district_section",
					"region_section",
					"location",
					"type",
					"os",
					"make",
					"model",
					"fas",
					"site_id",
					"printer",
					"site_name",
					"current_service_provider",
					"vlan",
					"computer_status",
					"printer_status"
				); // in edit.php and search_form.php
$temp = array();

FOREACH ($_POST AS $fld => $value)
{
	if(in_array($fld,$skip)){continue;}
	if(empty($value)){continue;}
if(array_key_exists($fld, $alt_value_array)){continue;}
			$alt_fld="alt_".$fld;
			if(in_array($fld, $alt_value_array) and !empty($_POST[$alt_fld]))
				{
				$temp[]="$fld='".$_POST[$alt_fld]."'";
				continue;
				}
		
	if(in_array($fld,$equal_array))
		{$temp[]="t1.".$fld."='".$value."'";}
		else
		{$temp[]="t1.".$fld." like '%".$value."%'";}
	}
if(empty($temp))
	{$clause="1";}
	else
	{$clause=implode(" and ",$temp);}

$comments_table="comments_".$select_table;
$var_field="t2.comments_".$select_table;
$comments_field="group_concat($var_field separator '^') as previous_comments";

$sql="SELECT t1.*, $comments_field, t3.link
from $select_table as t1
left join $comments_table as t2 on t1.id=t2.".$select_table."_id
left join surplus_docs as t3 on t1.id=t3.item_id
WHERE $clause
group by t1.id
"; 

//    	ECHO "level 4 $sql"; //exit;

$result = mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
//  echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

include("_base_top.php");
if(mysqli_num_rows($result)<1)
	{
	echo "No record found. $sql";
	}
	else
	{
	$sql="SELECT track as track_computer from computers_history
	where id='$id' order by ch_id desc limit 1
	"; 
	$result = mysqli_query($connection,$sql) or die("$sql");
	IF(mysqli_num_rows($result)>0)
		{
		$row=mysqli_fetch_assoc($result);
		extract($row);
		}
	// echo "<pre>"; print_r($computer_history_array); echo "</pre>"; // exit;
		$skip = array("id",
					"region_section",
					"link"
				);
		$search_computers_dropdown = array("division",
											"district_section",
											"location",
											"type",
											"os",
											"make",
											"model",
											"computer_status"
										);
		$search_printers_dropdown = array("site_id",
										"printer",
										"location",
										"printer_status"
									);
		$search_subnets_dropdown = array("district_section",
										"site_id",
										"gateway",
										"site_name",
										"current_service_provider",
										"location",
										"type",
										"vlan"
									);
		$search_switches_dropdown = array("district_section",
										"host_name",
										"location",
										"make",
										"model",
										"site_id",
										"os"
									);

		$date_field_array = array("date_deployed");
	
	// ****************************************
	// $search_array=${"search_".$select_table."_dropdown"}; see above
		include("search_arrays.php");
	// echo "<pre>"; print_r($search_array); echo "</pre>"; // exit;	

// also in computer_history.php
// 20220916: jgcarter
// - removed the 'status' options of: surplus, surp_tobe, surp_process
	$ARRAY_computer_status = array("bwo" => "Being Worked On",
									"rec_p" => "Received at Park",
									"sent_r" => "Sent to Raleigh",
									"rec_r" => "Received in Raleigh",
									"sent_p" => "Sent to Park",
									// "surp_tobe" => "To be Surplused",
									// "surp_process" => "Surplus Process",
									// "surplus" => "Surplused"
								);
	$ARRAY_printer_status = array("bwo" => "Being Worked On",
								"rec_p" => "Received at Park",
								"sent_r" => "Sent to Raleigh",
								"rec_r" => "Received in Raleigh",
								"sent_p" => "Sent to Park",
								// "surp_tobe" => "To be Surplused",
								// "surp_process" => "Surplus Process",
								// "surplus" => "Surplused"
							);
	IF ($level < 3)
	{
		$ARRAY_computer_status = array("rec_p" => "Received at Park",
										"sent_r" => "Sent to Raleigh",
										//"surp_tobe" => "To be Surplused"
									);
		$ARRAY_printer_status = array("rec_p" => "Received at Park",
									"sent_r" => "Sent to Raleigh",
									//"surp_tobe" => "To be Surplused"
// 20220916: jgcarter - END
								);
	}

	echo "<div><form method='POST' action='edit.php' enctype='multipart/form-data'>";
	empty($message)?$message=substr($select_table,0,-1):NULL;
	if($select_table=="switches")
		{$message=substr($select_table, 0, -2);}
	echo "<table border='1' cellpadding='3'><tr>";
	if($message=="successful.")
		{$bgcolor="#ddff99";}
		else
		{$bgcolor="beige";}
	echo "<td bgcolor='$bgcolor'>Edit $message</td>
	<td bgcolor='#ffcccc' align='center'>
	<input type='hidden' name='select_table' value=\"$select_table\">
	<input type='hidden' name='id' value=\"$id\">";
	if($level>3)
		{
		echo "<input type='submit' name='submit_form' value=\"Delete\" onclick=\"return confirm('Are you sure you want this Item?')\">";
		}
	echo "</td>
	</tr>";
	foreach($ARRAY AS $index=>$array)
		{
		echo "<tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip))
				{continue;}
			if(in_array($fld, $readonly_array)){$ro="READONLY";}else{$ro="";}
			$line="<td><strong>$fld</strong></td>
			<td><input type='text' name='$fld' value=\"$value\" $ro></td>";
			$line="<td><strong>$fld</strong></td>
			<td><textarea name='$fld' rows='1' cols='22' $ro>$value</textarea></td>";

			if($fld=="previous_comments")
				{
				if(!empty($value))
					{
					$value=nl2br(str_replace("^","",$value));
					$line="<td><a onclick=\"toggleDisplay('previous_comments');\" href=\"javascript:void('')\">$fld</a></td>
					<td><div id=\"previous_comments\" style=\"display: block\">$value</div></td>";
					}
					else
					{continue;}
				}
			
			if($fld=="ports")
				{
				$line="<td valign='top'><a onclick=\"toggleDisplay('ports');\" href=\"javascript:void('')\">Toggle Display of ports</a></td>
				<td><div id=\"ports\" style=\"display: none\">
				<table class='alternate' >";
				
				for($i=1;$i<=24;$i++)
					{
					$line.="<tr bgcolor><td align='right'><strong>$i</strong>&nbsp;&nbsp;&nbsp;&nbsp;";
					foreach($port_array as $k=>$v)
						{
						$fld_name=$fld."[$i]";
						$ck="";
						if(!empty($switch_port_values))
							{
							foreach($switch_port_values as $port_number=>$port_id)
								{
								if($i==$port_number and $port_id==$k)
									{$ck="checked";}
								}
							}
							else
							{
							if($k==10)
								{$ck="checked";}
							}
						$line.="<input type='radio' name='$fld_name' value=\"$k\" $ck>$v";
						}
					$line.="</td></tr>";
					}
				
				$line.="</table>
				</div></td></tr>";
				}
				
			if(in_array($fld, $search_array) and !in_array($fld, $readonly_array))
				{
				$drop_down_array=${"ARRAY_".$fld};
				$line="<td><strong>$fld</strong></td><td><select name='$fld'><option value=\"\" selected></option>\n";
				foreach($drop_down_array as $k=>$v)
					{
					if(empty($v)){continue;}
					if($fld=="computer_status" OR $fld=="printer_status")
						{
						// switch $k and $v
						if(strtoupper($k)==strtoupper($value))
							{$s="selected";}else{$s="";}
						$line.="<option value='$k' $s>$v</option>$value\n";
						}
						else
						{
						if(strtoupper($v)==strtoupper($value))
							{$s="selected";}else{$s="";}
						$line.="<option value='$v' $s>$v</option>$value\n";
						}
					}
				if($fld=="computer_status" and !empty($ARRAY[$index]['computer_status']))
					{
					if(!empty($track_computer))
						{
						$line.=" by [$track_computer]";
					$line.=" <a href='computer_history.php?id=$id' target='_blank'>history</a>";
						}
// 20220916: jgcarter 
// - removed 'status' options of 'surp_process', 'surp_tobe', 'surplus'
					// if(($value=="surp_process" or $value=="surplus") and $level>2)
					IF ($value != "" AND $level > 2)
// 20220916: jgcarter - END
						{
						$line.=" <input type='file' name='file_upload'>";
						}
					if(!empty($array['link']) and $level>2)
						{
						$link=$array['link'];
						$line.=" <a href='$link' target='_blank'>Surplus Doc</a>";
						}
					}
				if($fld=="location")
					{
					if("LOANER"==strtoupper($value)){$s="selected";}else{$s="";}
					$line.="<option value='LOANER' $s>LOANER</option>\n";
					if("UNKN"==strtoupper($value)){$s="selected";}else{$s="";}
					$line.="<option value='UNKN' $s>UNKN</option>\n";
					if(!in_array($value, $drop_down_array))
						{
						if("SURPLUS_P"==strtoupper($value)){$s="selected";}else{$s="";}
						$line.="<option value='SURPLUS_P' $s>SURPLUS_P</option>\n";
						}
					if(!in_array($value, $drop_down_array))
						{
						if("SURPLUS_D"==strtoupper($value)){$s="selected";}else{$s="";}
						$line.="<option value='SURPLUS_D' $s>SURPLUS_D</option>\n";
						}
					if(!in_array("SURPLUS_D", $drop_down_array))
						{
						if("SURPLUS_D"==strtoupper($value)){$s="selected";}else{$s="";}
						$line.="<option value='SURPLUS_D' $s>SURPLUS_D</option>\n";
						}
					}
				$line.="</select>";
				if(in_array($fld, $alt_value_array))
					{
					$name="alt_".$fld;
					$line.=" add if not in drop-down==><input type='text' name='$name' value=\"\">";
					}
				$line.="</td>";
				}
			if(in_array($fld, $date_field_array))
				{
				$line="<tr><td><strong>$fld</strong></td>
				<td><input id=\"datepicker1\" type=\"text\" name='$fld' value=\"$value\"></td></tr>";
				}
			echo "$line";
			echo "</tr>";
			}
			$var_name="comments_".$select_table;
			echo "<tr><td><strong>new_comment</strong></td>
			<td><textarea name='$var_name' rows='2' cols='100'></textarea></td></tr>";
		}
	$id=$array['id'];
	echo "<tr><td colspan='2' align='center' bgcolor='#9fc69f'>";
	if(!empty(${$select_table}))
		{
		$force_array=${$select_table};
// 	echo "<pre>"; print_r($force_array); echo "</pre>"; // exit;
		foreach($force_array as $k=>$v)
			{
				$name=$select_table."[$k]";
				echo"<input type='hidden' name='$name' value=\"$v\">";
	
			}
		}
	echo "<input type='hidden' name='select_table' value=\"$select_table\">
	<input type='hidden' name='id' value=\"$id\">
	<input type='submit' name='submit_form' value=\"Update\">
	</td></tr>";
	echo "</table></form>";

		echo "<form method='POST' ACTION='search_form.php'>";
		echo "<table align='right'>";
		echo "<tr><td bgcolor='#ffcc00'>";
	if(!empty(${$select_table}))
		{
		$force_array=${$select_table};
		foreach($force_array as $k=>$v)
			{
			echo "<input type='hidden' name='$k' value=\"$v\">";
			}
		}
		echo "<input type='hidden' name='select_table' value=\"$select_table\">
		<input type='submit' name='submit_form' value=\"Return\">";
		echo "</tr></table>";
		echo "</form>";
		echo "</div>";
	}
echo "
<script>
    $(function() {";
    for($i=1;$i<=$x;$i++)
    	{
    	echo "
        $( \"#datepicker".$i."\" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd',
		yearRange: \"-5yy:+1yy\",
		maxDate: \"+1yy\" });
   ";
    }
echo " });
</script>";	
?>

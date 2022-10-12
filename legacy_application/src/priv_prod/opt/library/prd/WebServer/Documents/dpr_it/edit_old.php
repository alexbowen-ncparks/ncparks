<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
$database="dpr_it"; 
$dbName="dpr_it";
include("../../include/auth.inc"); // include iConnect.inc with includes no_inject.php
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

//  echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$skip=array("id","submit_form", "select_table", "computers", "printers", "gateways", "previous_comments", "comments_computers", "comments_printers", "comments_gateways", "alt_os");

$level=$_SESSION[$database]['level'];
$location=$_SESSION[$database]['select'];
//echo "level=$level  location=$location";

$skip_readonly=array("computer_status");
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

 if(!empty($_POST['submit_form']))
 	{
 	if($submit_form=="Update")
 		{
// 		 echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
		FOREACH($_POST as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if($fld=="os" and !empty($_POST['alt_os']))
				{
				$temp[]="`os`='".$_POST['alt_os']."'";
				continue;
				}
			$temp[]="`".$fld."`='".$value."'";
			}
		if(array_key_exists("location",$_POST))
			{
			$val=$_POST['location'];
			$sql="SELECT `region` from dpr_system.parkcode_names_region
			where park_code='$val'
			"; 
			$result = mysqli_query($connection,$sql) or die("$sql");
			IF(mysqli_num_rows($result)>0)
				{
				$row=mysqli_fetch_assoc($result);
				$temp[]="`region_section`='".$row['region']."'";
				}
			
			}
		$clause=implode(", ",$temp);
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
		if(!empty($_POST['comments_gateways']))
			{
			$author=substr($_SESSION['dpr_it']['tempID'],0,-4)."-".date('Y-m-d h:i:s');
			$var_comments=$comments_gateways.": ".$author."\n\n";
			$sql="INSERT INTO comments_gateways
			set comments_gateways='$var_comments', gateways_id='$id'
			"; 
			$result = mysqli_query($connection,$sql) or die("$sql");
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
 	}
 
$skip=array("select_table","submit_form", "computers", "printers", "gateways", "previous_comments", "comments_computers", "comments_printers", "comments_gateways","alt_os"); 
$equal_array=array("id","district_section","location","type","os", "make", "model", "fas", "site_id", "printer"); // also search_form.php
$temp=array();
FOREACH($_POST as $fld=>$value)
	{
	if(in_array($fld,$skip)){continue;}
	if(empty($value)){continue;}

	if($fld=="os" and !empty($_POST['alt_os']))
		{
		$temp[]="`os`='".$_POST['alt_os']."'";
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
$sql="SELECT t1.*, $comments_field
from $select_table as t1
left join $comments_table as t2 on t1.id=t2.".$select_table."_id
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
		$skip=array("id","division","district_section");
		$search_computers_dropdown=array("region_section","location","type","os", "make","model","computer_status");
		$search_printers_dropdown=array("site_id","printer", "location");
		$search_gateways_dropdown=array("region_section", "site_id","gateway", "site_name", "current_service_provider", "location", "type", "vlan");
		$alt_value_array=array("os");
	// ****************************************
	// $search_array=${"search_".$select_table."_dropdown"}; see above
		include("search_arrays.php");
	// echo "<pre>"; print_r($search_array); echo "</pre>"; // exit;	

// also in computer_history.php
	$ARRAY_computer_status=array("rec_p"=>"Received at Park","sent_r"=>"Sent to Raleigh","rec_r"=>"Received in Raleigh","sent_p"=>"Sent to Park","surp_tobe"=>"To be Surplused","surp_process"=>"Surplus Process","surplus"=>"Surplused");
	if($level<3)
		{
		$ARRAY_computer_status=array("rec_p"=>"Received at Park","sent_r"=>"Sent to Raleigh","surp_tobe"=>"To be Surplused");
		}


	echo "<div><form method='POST' action='edit.php'>";
	empty($message)?$message=substr($select_table,0,-1):NULL;
	echo "<table border='1' cellpadding='3'><tr>";
	if($message=="successful.")
		{$bgcolor="#ddff99";}
		else
		{$bgcolor="beige";}
	echo "<td bgcolor='$bgcolor'>Edit $message</td>
	<td bgcolor='#ffcccc' align='center'>
	<input type='hidden' name='select_table' value=\"$select_table\">
	<input type='hidden' name='id' value=\"$id\">
	<input type='submit' name='submit_form' value=\"Delete\" onclick=\"return confirm('Are you sure you want this Item?')\">
	</td>
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
					
				
			if(in_array($fld, $search_array) and !in_array($fld, $readonly_array))
				{
				$drop_down_array=${"ARRAY_".$fld};
				$line="<td><strong>$fld</strong></td><td><select name='$fld'><option value=\"\" selected></option>\n";
				foreach($drop_down_array as $k=>$v)
					{
					if(empty($v)){continue;}
					if($fld=="computer_status")
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
				if($fld=="location")
					{
					if("LOANER"==strtoupper($value)){$s="selected";}else{$s="";}
					$line.="<option value='LOANER' $s>LOANER</option>\n";
					if("SURPLUS"==strtoupper($value)){$s="selected";}else{$s="";}
					$line.="<option value='UNKN' $s>UNKN</option>\n";
					}
				$line.="</select>";
				if($fld=="computer_status" and !empty($ARRAY[$index]['computer_status']))
					{
					if(!empty($track_computer))
						{
						$line.=" by [$track_computer]";
					$line.=" <a href='computer_history.php?id=$id' target='_blank'>history</a>";
						}
					}
				if(in_array($fld, $alt_value_array))
					{
					$name="alt_".$fld;
					$line.=" add if not in drop-down==><input type='text' name='$name' value=\"\">";
					}
				$line.="</td>";
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



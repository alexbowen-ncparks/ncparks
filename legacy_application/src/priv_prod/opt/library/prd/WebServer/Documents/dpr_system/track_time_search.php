<?php
if(empty($_SESSION)){session_start();}
$database="dpr_system";
$level=$_SESSION[$database]['level'];
include("_base_top.php");

include("../../include/iConnect.inc");
mysqli_select_db($connection, $database);

if($_GET['recent']=="view")
	{
	$_POST['submit_form']="Search";
	$_POST['recent']="View";
	}
if($_POST['submit_form']=="Search")
	{
	$skip_search=array("submit_form");
	$array_t2=array("time_in_hours"=>"sum(t2.time_in_hours) as time_in_hours","notes"=>"t2.notes", "date_update"=>"t2.date_update","user_id"=>"t2.user_id","ticket_id"=>"t2.ticket_id");
	$t2_flds=implode(",",$array_t2);

	foreach($_POST as $k=>$v)
		{
		if(in_array($k, $skip_search)){continue;}
		if(empty($v)){continue;}
		if(array_key_exists($k, $array_t2))
			{
			$k=$array_t2[$k];
			}
		$temp[]="$k like '%$v%'";
		}
	$clause=implode(" and ",$temp);
	if(!empty($ticket_id)){$clause="t2.ticket_id='$ticket_id'";}
	$sql="SELECT t1.*, $t2_flds  from track_time as t1
	left join track_time_updates as t2 on t1.ticket_id=t2.ticket_id
	 where $clause group by t1.ticket_id order by  resolution desc, t2.update_id asc";
	 
	 if($_POST['client']=="*")
		{
		$clause="All clients shown regardless of status or resolution.";
		$sql="SELECT t1.*, $t2_flds  from track_time as t1
		left join track_time_updates as t2 on t1.ticket_id=t2.ticket_id
		where 1
		group by t1.client";
		}	 
	 if($_POST['recent']=="View")
		{
		$clause="<font color='green'>Most recent 100 tickets shown regardless of user_id, status, or resolution ordered by date_update desc. limit 100</font>";
		$sql="SELECT t1.*, $t2_flds  from track_time as t1
		left join track_time_updates as t2 on t1.ticket_id=t2.ticket_id
		where 1
		group by t1.ticket_id
		order by  t1.date_update desc, t1.date_update desc limit 100";
		}
// 	echo "54 $sql";
	$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_results[]=$row;
		}
	}

// gets list of databases and creates lists for jquery input values
// client, database_app, etc.
include("track_time_fill_in_source.php");


$sql="SHOW COLUMNS from track_time";
$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_flds[]=$row['Field'];
	}

$search_track_time_dropdown=array("user_id","ticket_status","location_code","employee_status","database_app","sub_application","resolution","activity");

$select_table="track_time";
$search_array=${"search_".$select_table."_dropdown"};

// echo "3<pre>"; print_r($search_array); echo "</pre>";
foreach($search_array as $index=>$fld)
	{
	$var_array=array();
	$sql = "SELECT distinct $fld from $select_table order by $fld"; 
	$result = @mysqli_query($connection,$sql) or die("$sql");
	
	while($row=mysqli_fetch_assoc($result))
		{
		if($row[$fld]==""){continue;}
		$var_array[]=$row[$fld];
		}
	${"ARRAY_".$fld}=$var_array;
	}

// echo "<pre>"; print_r($ARRAY_location_code); echo "</pre>";

$tempID=$_SESSION[$database]['tempID'];
$user_id=substr($tempID,0,-3);
$search_skip=array("date_create","time_in_hours","date_update");

// if(empty($ARRAY_results)){$display="block";}else{$display="none";}

// echo "<pre>"; print_r($_POST); echo "</pre>";
echo "<table><tr valign='top'><td><b>DPR Ticket Tracking - Search</b></td></tr>";
echo "<tr valign='top'>
<td>
</tr>";
echo "<tr><td><a onclick=\"toggleDisplay('systemalert');\" href=\"javascript:void('')\">Search Form</a>
<div id=\"systemalert\" style=\"display: block\">";

echo "<form action='track_time_search.php' method='post'>";
echo "<table>";
foreach($ARRAY_flds as $index=>$fld)
	{
	if(in_array($fld, $search_skip)){continue;}
	if($fld=="client")
		{
	$line="<th><b id='demo' onmousemove=\"myMoveFunction()\" onmouseout=\"mouseOut()\">$fld:</b> <input id='$fld' type='text' name='$fld' value=\"\" size='10'></th>";}
		else
		{
	$line="<th>$fld: <input id='$fld' type='text' name='$fld' value=\"\" size='10'></th>";}
	if(in_array($fld, $search_array))
		{
		$default_array=array("ticket_status"=>"active","resolution"=>"on-going","user_id"=>$user_id);
		$drop_down_array=${"ARRAY_".$fld};
		$line="<th>$fld: <select name='$fld'><option value=\"\" selected></option>\n";
		foreach($drop_down_array as $k=>$v)
			{
			$val=$_POST[$fld];
			if($v==$val)
				{$s="selected";}
				else
				{$s="";}
			if(array_key_exists($fld, $default_array) and empty($_POST))
				{
				$val=$default_array[$fld];
				
				if($v==$val)
					{$s="selected";}
					else
					{$s="";}
				}
			$line.="<option value='$v' $s>$v</option>\n";
			}
		$line.="</select></th>";
		}
		
	echo "$line";
	}
echo "<tr><td></td><td><input type='submit' name='submit_form' value=\"Search\"></td></tr>";
echo "</table></form>";
echo "</div>";

if(!empty($ARRAY_results))
	{
// 	echo "<pre>"; print_r($ARRAY_results); echo "</pre>";
// 	exit;
	$bold_array=array("client","database_app","sub_application");
	$skip=array();
	$c=count($ARRAY_results);
	$var_t=($c==1 ? 'ticket':'tickets');
	echo "<table valign='top'><tr><td colspan='10'>$clause</td></tr>";
	foreach($ARRAY_results AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY_results[0] AS $fld=>$value)
				{
				if(in_array($fld,$skip)){continue;}
				
				echo "<th id='$fld'>$fld</th>";
				}
			echo "</tr>";
			}
		echo "<tr valign='top'>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			if($fld=="notes")
				{
				if(strlen($value)>100)
					{
					$value=substr($value, 0, 100)."...";
					}
				}
			if($fld=="resolution")
				{
				if($value=="complete")
					{$value="<font color='magenta'>$value</font>";}
				if($value=="on-going")
					{$value="<font color='green'>$value</font>";}
				if($value=="paused")
					{$value="<font color='orange'>$value</font>";}
				}
			if($fld=="ticket_id")
				{
				$value="<a href='track_time.php?pass_ticket_id=$value'>Edit $value</a>";
				}
			if(in_array($fld, $bold_array)){$value="<strong>$value</strong>";}
			echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
	}
	else
	{
	if(!empty($_POST['submit_form']))
		{
		echo "Nothing found using $clause.<br /><br /><font color='brown'>Try setting user_id, ticket_status, and/or resolution to blank.</font>";
		}
	}
echo "
	<script>
		$(function()
			{
			$( \"#client\" ).autocomplete({
			source: [ $source_client ]
				});
			});
			var z=\"Enter * to view all <br />\";
			var x=\"client: \";
		function myMoveFunction() {
  document.getElementById(\"demo\").innerHTML = z;
}
function mouseOut() {
  document.getElementById(\"demo\").innerHTML = x;
}
		</script>";
?>
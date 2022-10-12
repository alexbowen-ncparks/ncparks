<?php
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');
$database="dpr_it"; 
$dbName="dpr_it";

include("_base_top.php");

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

echo "<style>
.head {
padding: 5px;
font-size: 22px;
color: #999900;
}
th{
padding: 5px;
    border: 1px solid #8e8e6e; 
}
td
{
padding: 3px;
}
 tr.d0 td {
  background-color: #ddddbb;
  color: black;
}
.table {
    border: 1px solid #8e8e6e; 
	margin: 5px 5px 5px 5px;
	background-color:#eeeedd;
	border-collapse:collapse;
  color: black;
}

table.alternate{
border: 1px solid #8e8e6e; 
}
table.alternate tr:nth-child(odd) td{
background-color: #ddddbb;
}
table.alternate tr:nth-child(even) td{
background-color: #eeeedd;
}

.search_box {
    border: 1px solid #8e8e6e;
	background-color:#f2e6ff;
	border-collapse:collapse;
  font-size: 70%;
  color: black;
}
.table_uno {
    border: 1px solid #8e8e6e; 
	margin: 5px 5px 5px 5px;
	background-color:#e0ebeb;
	border-collapse:collapse;
  color: black;
}
.ui-datepicker {
  font-size: 80%;
}
</style>";

include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

$sql = "SHOW COLUMNS FROM $select_table";  //echo "hello3"; exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	if($row['Field']=="region_section"){continue;}
	$search_fields[]=$row['Field'];
	}
// echo "<pre>"; print_r($search_fields); echo "</pre>";  exit;

$sql = "SELECT distinct computer_status FROM computers";  //echo "hello3"; exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_computer_status[]=$row['computer_status'];
	}

$search_computers_dropdown=array( "district_section", "location","type","os","make","model", "site_id", "computer_status");
$search_printers_dropdown=array("site_id","printer", "district_section", "location", "printer_status");
$search_subnets_dropdown=array("district_section","district_section","site_name", "location", "current_service_provider", "type", "site_id", "vlan");
$search_switches_dropdown=array("district_section","host_name", "location", "make", "model", "site_id", "os");

include("search_arrays.php");  
include("ARRAY_computer_status_rename.php");

// echo "<pre>"; print_r($ARRAY_location); echo "</pre>"; // exit;

$search_skip=array("division","region_section");
if($level<5){$search_skip[]="id";}
// "fas", 
$equal_array=array("id","district_section","region_section","location","type","os", "make", "model", "site_id", "printer", "site_name", "current_service_provider", "vlan", "computer_status", "printer_status"); // in edit.php and search_form.php

$colspan=18;
if($select_table=="printers"){$colspan=13;}
if($select_table=="subnets"){$colspan=12;}

$search_box_break=7;
if($select_table=="subnets"){$search_box_break=8;}


IF($_SESSION[$database]['level']>1)
	{
	$i=0;
	echo "<div><form method='POST'>
	<table class='search_box'><tr><td class='head' colspan='$colspan'>Search the DPR IT Equipment database for $select_table</td></tr>";
	echo "<tr>";
	foreach($search_fields as $index=>$fld)
		{
		if(in_array($fld, $search_skip)){continue;}
		in_array($fld,$equal_array)?$sym="=":$sym="%";
		$line="<th>$fld$sym <input type='text' name='$fld' value=\"\" size='10'></th>";
		if(in_array($fld, $search_array))
			{
			$drop_down_array=${"ARRAY_".$fld};
			$line="<th>$fld$sym <select name='$fld'><option value=\"\" selected></option>\n";
			foreach($drop_down_array as $k=>$v)
				{
				if(empty($v)){continue;}
				$v1=$v;
				if($fld=="computer_status")
					{
// 					echo "<pre>"; print_r($drop_down_array); echo "</pre>"; // exit;
					$v1=$ARRAY_computer_status_rename[$v];
					}
				$line.="<option value='$v'>$v1</option>\n";
				}
			if($fld=="district_section")
				{
				$line.="<option value='all'>All</option>\n";
				}
			$line.="</select></th>";
			}

		if(fmod($i,$search_box_break)==0 ){$line="</tr><tr>".$line;}
		echo "$line";
		$i++;
		}
	echo "<th>comments%<input type='text' name='search_comment' value=\"\" size='10'></th>";
	echo "<th>
	<input type='hidden' name='select_table' value=\"$select_table\">
	<input type='submit' name='submit_form' value=\"Search\">
	</th><th colspan='3'>% after a field means result \"contains\" search term<br />= means an exact match</th>";
	echo "</tr>
	</table>
	</form>
	</div>
	";


	if(empty($submit_form))
		{
		exit;
		}
	if($submit_form=="add")
		{
		$_POST=$_GET;
		}

	}
	else
	{
// 	echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
	IF(!empty($_SESSION['dpr_it']['accessPark']))
		{
		$temp_array=explode(",",$_SESSION['dpr_it']['accessPark']);
		echo "<div><form method='POST'>
		<table class='search_box'><tr><td class='head' colspan='$colspan'>Search the DPR IT Equipment database for $select_table</td></tr>";
		echo "<tr><td>Select Park: <select name='location' onChange=\"this.form.submit()\"><option value='' selected></option>\n";
		foreach($temp_array AS  $k=>$v)
			{
			if($v==$_POST['location']){$s="selected";}else{$s="";}
			echo "<option value='$v' $s>$v</option>\n";
			}
		echo "</select>";
		echo "<input type='hidden' name='select_table' value=\"$select_table\"><td></tr>";
		echo "
		</table>
		</form>
		</div>";
		IF(empty($_POST['location']) and empty($_GET['location']))
			{exit;}
			else
			{
			IF(empty($_POST['location']))
				{$_POST['location']=$_GET['location'];}
			$_SESSION[$database]['select']=$_POST['location'];
			}
	
		}
	$submit_form="Search";
	$_POST['select_table']=$select_table;
// 	$mod_region_office=array("CORE"=>"CORO","PIRE"=>"PIRO","MORE"=>"MORO");
	$mod_distrcit_office=array("EADI"=>"EADO","NODI"=>"NODO","SODI"=>"SODO","WEDI"=>"WEDO");
	if(array_key_exists($_SESSION[$database]['select'], $mod_distrcit_office))
		{
		$_SESSION[$database]['select']=$mod_distrcit_office[$_SESSION[$database]['select']];
		}
	$_POST['location']=$_SESSION[$database]['select'];
	$location=$_SESSION[$database]['select'];
	}
// **********
include("search_action.php");
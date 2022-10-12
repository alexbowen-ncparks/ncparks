<?php
ini_set('display_errors',1);
$database="dpr_proj";
$action_type="Find";
$var_act="Find";
	$title="DPR Project Tracking Application";
if(empty($_POST['export_csv']))
	{
	include("../_base_top.php");
	}
$skip[]="edits";
// also in project.php
$fld_rename=array("park_code"=>"Park Code(s)", "proj_name"=>"Project&nbsp;Name", "proj_type"=>"Project&nbsp;Type", "description"=>"Project&nbsp;Description", "justification"=>"Justification",  "proj_lead"=>"Project&nbsp;Lead", "sco"=>"Does this project require SCO review?", "cost"=>"Cost Estimate", "funding_source"=>"Funding&nbsp;Source", "proj_number"=>"Project Number", "rmr_form"=>"RMR form completed?", "tr_form"=>"Trail Review form completed?", "design"=>"Will design assistance be required?", "gmp"=>"Project identified in GMP?", "pep"=>"Project listed on PEP list?", "pac"=>"Project review with Park Advisory Committee?", "edits"=>"Edited&nbsp;by", "submitted_by"=>"Submitted&nbsp;by&nbsp;(use last name)", "proj_comments"=>"Project Comments", "how_done"=>"How will work be accommplished?", "proj_status"=>"Project Status", "proj_approval"=>"Project Approval");

$fld_rename_1=array("id"=>"DB_ID", "spo_id"=>"SPO_ID", "submitted_date"=>"Submitted Date", "mc_proj_number"=>"MoneyCounts Proj #", "pasu_date"=>"PASU Date", "disu_date"=>"", "chom_date"=>"", "ensu_date"=>"", "plnr_date"=>"", "chop_date"=>"", "dedi_date"=>"", "dire_date"=>"", "pasu_recommend"=>"", "disu_recommend"=>"", "chom_recommend"=>"", "ensu_recommend"=>"", "chop_recommend"=>"", "plnr_recommend"=>"", "dedi_recommend"=>"", "dire_recommend"=>"", "pasu_comments"=>"", "disu_comments"=>"", "chom_comments"=>"", "ensu_comments"=>"", "chop_comments"=>"", "plnr_comments"=>"", "dedi_comments"=>"", "dire_comments"=>"");
$combo_rename=array_merge($fld_rename, $fld_rename_1);

include("../../include/iConnect.inc");
mysqli_select_db($connection, $database);

// 	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
if(!empty($submit_form))
	{
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	include("find_display.php");
	exit;
	}
	
	
$sql="SELECT * from project where 1";  //echo "$sql";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_master[]=$row;
	}
// $sql="SHOW columns from project where 1";  //echo "$sql";
// $result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysqli_error($connection));
// while($row=mysqli_fetch_assoc($result))
foreach($ARRAY_master[0] as $Field=>$val)
	{
	if(in_array($Field, $skip)){continue;}
	$ARRAY[$Field]=$combo_rename[$Field];
	if(strpos($Field, "date")>0)
		{
		$exp=explode("_", $Field);
		$a=strtoupper($exp[0]);
		$b=($exp[1]);
		$ARRAY[$Field]=$a." action ".$b;
		}
	if(strpos($Field, "recommend")>0)
		{
		$exp=explode("_", $Field);
		$a=strtoupper($exp[0]);
		$b=($exp[1]);
		$ARRAY[$Field]=$a." ".$b." Yes/No";
		}
	if(strpos($Field, "comments")>0)
		{
		$exp=explode("_", $Field);
		$a=strtoupper($exp[0]);
		if($a=="PROJ"){$a="Project";}
		$b=($exp[1]);
		$ARRAY[$Field]=$a." ".$b;
		}
	}

// echo "<pre>"; print_r($ARRAY_master); echo "</pre>";  exit;

// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

$skip=array("id");

$drop_down=array("park_code");
$radio=array("proj_status", "proj_approval", "design", "gmp", "pep", "pac");
$uni=array("proj_status", "proj_approval", "park_code", "design", "gmp", "pep", "pac");

$c=count($ARRAY);
echo "<form method='post' action='find_export.php'>";
echo "<table><tr><td colspan='9'><b>Searching for a word or phrase in any appropriate field will find all Projects with that word or phrase.</b> <br />Submitting the form with no search value returns all Projects.</td></tr>";
foreach($ARRAY AS $fld=>$value)
	{
	if(strpos($fld, "recommend")>0 )
		{
		$uni[]=$fld;
		$radio[]=$fld;
		}
	if(strpos($fld, "_form")>0 )
		{
		$uni[]=$fld;
		$radio[]=$fld;
		}
	if(in_array($fld,$skip)){continue;}
	$unique[$fld]=array();
	foreach($ARRAY_master as $t_i=>$t_array)
		{
		if(!in_array($fld,$uni)){continue;}
		$unique[$fld][$t_array[$fld]]=$fld;
		}
	$line="<input type='text' name='$fld' value=\"\">";
	if(!empty($unique[$fld]))
		{
		if(in_array($fld, $drop_down))  // drop-down
			{ksort($unique[$fld]);}
			else
			{krsort($unique[$fld]);}
		
		if(in_array($fld, $radio))  // Radio
			{
			$line="";
			foreach($unique[$fld] as $val=>$obj)
				{
				$val_name=$val;
				if(empty($val)){$val_name="_blank";}
				$line.="<input type='radio' name='$fld' value=\"$val_name\">$val_name ";
				}
			}
		if(in_array($fld, $drop_down))
			{
			$line="<select name='$fld'><option value=\"\" selected></option>\n";
			foreach($unique[$fld] as $val=>$obj)
				{
				if(empty($val)){continue;}
				$val_name=$val;
				$line.="<option value='$val'>$val</option>";
				}
			$line.="</select>";
			}
		}
	echo "<tr><td>$value</td>
	<td>$line</td>
	</tr>";
	}

echo "<tr><th colspan='2'><input type='submit' name='submit_form' value=\"Find\"></th></tr>";
echo "</table></form>";

// echo "<pre>"; print_r($unique); echo "</pre>"; // exit;


?>
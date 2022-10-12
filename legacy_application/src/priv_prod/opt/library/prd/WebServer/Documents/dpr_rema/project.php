<?php
$database="dpr_rema";
$title="DPR Project Tracking Application";
include("../_base_top.php");  // echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$beacon_num=$_SESSION[$database]['beacon_num'];
$submitted_by=$_SESSION[$database]['emid'];

include("../../include/iConnect.inc");
//include("../no_inject_i.php");

//	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
//	echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;


date_default_timezone_set('America/New_York');
mysqli_select_db($connection, $database);

		if(!empty($_FILES['rmr_form']['tmp_name']))
			{include("upload_rmr_form.php");}
		if(!empty($_FILES['tr_form']['tmp_name']))
			{include("upload_tr_form.php");}
		if(!empty($_FILES['permit']['tmp_name']))
			{include("upload_permit.php");}
		if(!empty($_FILES['plan']['tmp_name']))
			{include("upload_plan.php");}
		if(!empty($_FILES['specs']['tmp_name']))
			{include("upload_specs.php");}
		if(!empty($_FILES['map']['tmp_name']))
			{include("upload_map.php");}
		if(!empty($_FILES['draw']['tmp_name']))
			{include("upload_draw.php");}
		if(!empty($_FILES['report']['tmp_name']))
			{include("upload_report.php");}
		if(!empty($_FILES['other']['tmp_name']))
			{include("upload_other.php");}
		if(!empty($_FILES['photos']['tmp_name']))
			{include("upload_photos.php");}
			
strpos($_SERVER["HTTP_USER_AGENT"],"Mac OS X")>-1?$pass_os="Mac":$pass_os="Win";
//echo "$pass_os<pre>"; print_r($_SERVER); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
// ********** Get fields from table **************
$pass_table="project";
include("table_fields.php"); // result in $fld_array
//echo "<pre>"; print_r($fld_array); echo "</pre>"; // exit;

if(@$action_type=="Find")
	{
	$req="";
	}
	else
	{$req="required";}

$skip_flds=array("id","mc_proj_number","submitted_date");
if(!empty($_GET['id']))
	{
	$_POST['id']=$_GET['id'];
	$_POST['submit']="Find";
	}
	
if(!empty($_GET['proj_id']) and $_GET['submit']=="Delete")
	{
	$_POST['proj_id']=$_GET['proj_id'];
	$_POST['submit']="Delete";
	}
if(empty($action_type))
	{
	$action_type="Add";
	$var_act="";
//	$skip_flds[]="proj_number";
	}

//	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;

$how_done_array=array("Force Account","Contracted","Other");
if(!empty($_POST))
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	if($_POST['submit']=="Add")
		{
		include("proj_add.php"); 
		if(empty($proj_status))
			{$action_type="Submit";}
			else
			{$action_type="Update";}
		$var_act="Add";
		}
	if($_POST['submit']=="Update" or $_POST['submit']=="Submit" or $_POST['submit']=="Upload")
		{
		include("proj_update.php"); $action_type="Update"; $var_act="Update";
		}
	if($_POST['submit']=="Find")
		{include("proj_find.php"); $action_type="Update"; $var_act="Update";}
	if($_POST['submit']=="Delete")
		{include("del_file.php"); $action_type="Update"; $var_act="Update";}
	}

if(empty($proj_number))
	{
	//$skip_flds[]="proj_status";
	}
if($_SERVER['PHP_SELF']=="/$database/find.php")
	{$skip_flds[]="submitted_by";}
	
	
// ************* Form **************
$fld_rename=array("park_code"=>"Park Code(s)", "proj_name"=>"Project&nbsp;Name", "proj_type"=>"Project&nbsp;Type", "description"=>"Project&nbsp;Description", "justification"=>"Justification",  "proj_lead"=>"Project&nbsp;Lead", "sco"=>"Does this project require SCO review?", "start_date"=>"Start&nbsp;Date","cost"=>"Cost Estimate", "funding_source"=>"Funding&nbsp;Source", "proj_number"=>"Project Number", "rmr_form"=>"RMR form completed?", "tr_form"=>"Trail Review form completed?", "design"=>"Will design assistance be required?", "gmp"=>"Project identified in GMP?", "pep"=>"Project listed on PEP list?", "pac"=>"Project review with Park Advisory Committee?", "edits"=>"Edited&nbsp;by", "submitted_by"=>"Submitted&nbsp;by", "proj_comments"=>"Project Comments", "how_done"=>"How will work be accommplished?", "proj_status"=>"<font color='orange'>Project Status</font>");
$fld_yes_no=array("sco","rmr_form","tr_form","design","gmp","pep","pac","proj_status");
$yes_no_array=array("Yes","No","N/A");
if($level>2)
	{$status_array=array("Active", "Completed", "Void");}
	else
	{
	$status_array=array("Active", "Completed");
	if($level==1 and $_SERVER['PHP_SELF']!="/dpr_rema/find.php")
		{$status_array=array("Active");}
	}

$yes_no_design=array("Yes-Internal","Yes-External","No");

$review_array=array("pasu"=>"Park Superintendent","enre"=>"Environmental Review Coord.", "inmo"=>"Inventory & Monitoring Biologist","nama"=>"Natural Areas Manager", "fico"=>"Fire Coordinator", "mobi"=>"Mountain Region Biologist","pibi"=>"Piedmont Region Biologist","cobi"=>"Coastal Region Biologist","rmpm"=>"REMA Program Manager");
$review_flds=array("date","recommend","comments");
$review_levels=array_keys($review_array); //echo "<pre>"; print_r($review_levels); echo "</pre>"; // exit;


$fld_size=array("park_code"=>"32","proj_name"=>"64","submitted_by"=>"4");
$fld_span=array("proj_name"=>"3","description"=>"3","proj_type"=>"3","design"=>"4", "proj_comments"=>"4","funding_source"=>"4","how_done"=>"3","justification"=>"3");
$fld_comment=array("park_code"=>"4-letter park code. If more than a single park, enter multiple codes separated by a comma.", "rmr_form"=>"Attach Resource Management Review form below, if needed.", "tr_form"=>"Attach Trail Review form below, if needed.", "funding"=>"Enter \"Unknown\" if unknown.", "spo_id"=>"Enter \"State Property Building Asset Number\" if applicable.");
$fld_drop=array();
$fld_checkbox=array("proj_type");
if($var_act=="Find"){$fld_drop[]="park_code";}
$fld_text=array("description"=>"cols='66' rows='2'", "justification"=>"cols='66' rows='2'");
$not_required=array("gis_id","spo_id");

$func_check="";
if($var_act!="Find")
	{
	$proj_type_array=array("Capital Improvement", "Change of use/or name", "Construction/Renovation", "Demolition", "Trail Construction/Renovation", "Natural Resources", "Planning");
	$func_check="onsubmit=\"return checkCheckBoxes()\"";
	@$emid=$submitted_by;
	include("get_emails.php");
	}
if(@$_POST['submit']=="Add" and !empty($id))
	{
	echo "<div id='fade_add'><h3><font color='green'>Project successfully entered.</font></h3></div>";
	}
//echo "<pre>"; print_r($review_array); echo "</pre>"; // exit;

foreach($review_array as $code=>$title)
	{
	foreach($review_flds as $k=>$v)
		{
		$rev_fld_array[]=$code."_$v";
		}
	}
//echo "<pre>"; print_r($rev_fld_array); echo "</pre>"; // exit;

if(empty($var_act) or $var_act=="Find")   // form for adding a project or searching
	{
	$rev_fld_array[]="proj_comments";
	if($var_act=="Find")
		{$rev_fld_array[]="edits";}
	
	$skip_flds=array_merge($skip_flds,$rev_fld_array);	//echo "<pre>"; print_r($rev_fld_array); echo "</pre>"; // exit;
	}
//echo "<pre>"; print_r($skip_flds); echo "</pre>"; // exit;

$var_material="<font color='red'>Support material can be uploaded after creation of project.</font>";
if(!empty($proj_number))
		{
		$var_material="<font color='green'>Support material can be uploaded. Select appropriate file(s) and click Submit or Update</font>";
		}
echo "<div id='review_form'><form name='proj_form' action='project.php' method='POST'  enctype='multipart/form-data' $func_check>";
echo "<table align='left'>";
echo "<tr><td colspan='3'><b>NC DENR - DPR Project Review and Approval Form</b> $var_material</td></tr>";
foreach($fld_array as $index=>$fld)
	{
	if(in_array($fld,$skip_flds)){continue;}
	if(in_array($fld,$not_required)){$req="";}
	@$value=${$fld};
	
	//IF(empty($var_act)){$value="test";}
	
	if(in_array($fld,$rev_fld_array))
		{
		$display_review[$fld]=$value;
		continue;
		}
	
	$fld_name=$fld;
	if(array_key_exists($fld,$fld_rename)){$fld_name=$fld_rename[$fld];}
	
	$span="";
	if(array_key_exists($fld,$fld_span)){$span="colspan='".$fld_span[$fld]."'";}
	if($var_act!="Find")
		{echo "<tr><td><b>$fld_name</b></td><td $span>";}
		else
		{echo "<tr><td><b>$fld_name</b></td><td>";}
	
	
	$size="24";
	if(array_key_exists($fld,$fld_size)){$size=$fld_size[$fld];}
	$display_input="<input type='text' name='$fld' value=\"$value\" size='$size' $req>"; // default
	
	if(in_array($fld,$fld_drop))
		{
		$select_array=${$fld."_array"}; sort($select_array);
		$display_input="<select name='$fld' $req><option value=''></option>\n";
		foreach($select_array as $k=>$v)
			{
			if($fld=="park_code")
				{
				if(!empty($_SESSION['dpr_rema']['accessPark']))
					{
					$test_park=explode(",",$_SESSION['dpr_rema']['accessPark']);
					}
					else
					{$test_park[]=$_SESSION['dpr_rema']['select'];}
				}
			if($level<2)
				{
				if(!in_array($v,$test_park)){continue;}
				}
			if($value==$v){$s="selected";}else{$s="";}
			$display_input.="<option value=\"$v\" $s>$v</option>\n";
			}
		$display_input.="</select>";
		}
	if(in_array($fld,$fld_checkbox))
		{
		$checkbox_array=${$fld."_array"}; sort($checkbox_array);
		$value_array=explode(",",$value);
		$display_input="";
		foreach($checkbox_array as $k=>$v)
			{
			if(in_array($v,$value_array)){$s="checked";}else{$s="";}
			$ck_fld=$fld."[]";
			$ck_id="cat".($k+1);
			$display_input.="<input id='$ck_id' type='checkbox' name='$ck_fld' value=\"$v\" $s>$v ";
			}
		}
		
	if(array_key_exists($fld,$fld_text))
		{
		$size=$fld_text[$fld];
		if($fld=="description")
			{
			@$display_input="Write a clear project title and a very brief description.<br />";
			}
		if($fld=="justification")
			{
			@$display_input="Write a brief justification, additional detail can be added to the Written Plan/Narrative upload.<br />";
			}
		$display_input.="<textarea name='$fld' $size $req>$value</textarea>";
		}
		
	if(in_array($fld,$fld_yes_no))
		{
		$display_input="";
		$var_array=$yes_no_array;
		if($fld=="proj_status")
			{
			if(empty($value)){$value="Active";}
			$var_array=$status_array; //echo "<pre>"; print_r($status_array); echo "</pre>"; // exit;
			if(empty($var_act))
				{
				$var_array=array("Active");
				}
			}
		if($fld=="design")
			{$var_array=$yes_no_design;}
		foreach($var_array as $k=>$v)
			{
			$b1=""; $b2="";
			if($value==$v)
				{
				$s="checked";
				$b1="<font color='brown'>";$b2="</font>";
				}
				else
				{$s="";}
			$display_input.="<input type='radio' name='$fld' value='$v' $s $req>$b1$v$b2&nbsp;&nbsp;&nbsp;";
			}
		}
		
	if($fld=="edits")
		{
		$value=substr($_SESSION['dpr_rema']['tempID'],0, -4)."@".date("Y-m-d H:i");
		$display_input="<input type='text' name='$fld' value=\"$value\" size='28' readonly>";
		}
	if($fld=="how_done")
		{
		$display_input="";
		$exp=explode(",",$value);
		foreach($how_done_array as $k=>$v)
			{
			$temp_fld="how_done[]";
			@$temp_val=$exp[$k]; $exp1=explode("*",$temp_val);
		//	echo "<pre>"; print_r($exp1); echo "</pre>"; // exit;
			if(!empty($exp1[1]))
				{$temp_val=$exp1[1];}else{$temp_val="";}
			$display_input.="$v: <input type='text' name='$temp_fld' value=\"$temp_val\" size='3'>% &nbsp;&nbsp;";
			}
		$display_input.=" If \"Other\", indicate source in Project Description.";
		}
	if($fld=="proj_number")
		{
		if($var_act=="Find"){$ro="";}else{$ro="readonly";}
		$display_input="<input type='text' name='$fld' value=\"$value\" $ro>";
		if(empty($var_act)){$display_input="Will be auto-completed.";}
		}
	if($fld=="funding_source")
		{
		$display_input="<input type='text' name='$fld' value=\"$value\" size='$size' $req>";
		@$temp_val=${"mc_proj_number"};
		$display_input.=" <b>MoneyCounts Project Number</b> (if known):<input type='text' name='mc_proj_number' value=\"$temp_val\" size='5'>";
		echo "$display_input</td>";
		continue;
		}
	if($fld=="submitted_by" and $var_act!="Find")
		{
		if(empty($value))
			{$value=$_SESSION['dpr_rema']['emid'];}
		$display_input="<input type='text' name='$fld' value=\"$value\" size='$size' readonly>";
		}
		
	if($fld=="start_date")
		{
		// datepicker1 & datepicker2 in _base_top.php
		$display_input="<input id='datepicker3' type='text' name='$fld' value=\"$value\" size='12' $req>";
?>
			<script>
			$("#fade_add").fadeOut(3500);
			$(function() {
				$( "#datepicker3" ).datepicker({
				changeMonth: true,
				changeYear: true, 
				dateFormat: 'yy-mm-dd',
				yearRange: "0yy:+1yy",
				minDate: "0yy",
				maxDate: "+1yy" });
				});
			</script>
<?php
		}
	
	if($fld=="proj_comments")
		{
		$display_input="";
		if(!empty($value))
			{
			$display_input="Previous Comments (readonly)<textarea name='$fld' cols='111' rows='5' readonly>$value</textarea>";
			}
		$display_input.="<br /> <a onclick=\"toggleDisplay('next_com');\" href=\"javascript:void('')\">
<h3>Add a Comment</h3></a> <div id=\"next_com\" style=\"display: none\"><textarea name='next_comment' cols='111' rows='5'></textarea></div>";
		}
		
	if($fld=="submitted_by" and !empty($submitter_email) and !empty($id))
		{
		$array_some['submitted_by']="submitted_by";
		$all_email['submitted_by']=$submitter_email;
		$e_content="Subject=$park_code-Project Review: $proj_name&Body=Click the link to review this project - https://10.35.152.9/dpr_rema/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: https://10.35.152.9/dpr_rema/index.html";
		$e_content="Subject=$park_code-Project Review: $proj_name&Body=Click the link to review this project - https://10.35.152.9/dpr_rema/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: https://10.35.152.9/dpr_rema/index.html";
		$e_content=htmlentities($e_content);
		$var_e="</td><td><a href=\"mailto:$submitter_email?$e_content\">$submitter_email</a>";
		$display_input.=" ".$var_e;
		}
		
	echo "$display_input";
	$comment_fld="";
	if(array_key_exists($fld,$fld_comment) and $var_act!="Find")
		{$comment_fld="<font size='-1'>".$fld_comment[$fld]."</font>";}
	echo "</td><td>$comment_fld</td></tr>";
	}

echo "</table></div>";
	
// Uploads **************
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
IF(!empty($_POST['submit']))
	{
	mysqli_select_db($connection, "dpr_rema");

	echo "<table><tr><td colspan='3'><h4>Project Materials (attach as needed)</h4></td><td>$var_material</td></tr>";
	

		include("module_rmr_form.php");
		include("module_tr_form.php");
		include("module_permit.php");
		include("module_plan.php");
		include("module_specs.php");
		include("module_map.php");
		include("module_draw.php");
		include("module_report.php");
		include("module_photos.php");
		include("module_other.php");  // the "other" module is abstracted

	echo "</table>";
	}
	
if(!empty($display_review) and $action_type!="Submit")
	{
	if($level<9)
		{
		$max_level=$level-1;
		$review_code=$review_levels[$max_level];
		}
		else
		{$review_code="Admin";$max_level=$level;}
	
	$new_array=$review_array;
	$new_code_array=array_values(array_flip($new_array));
//	echo "<pre>"; print_r($review_flds); echo "</pre>";  exit;

//	echo "<pre>"; print_r($display_review); echo "</pre>";  //exit;
	
	$all_email['pasu']=implode(",",$pasu_email);  // get_emails.php
	echo "<hr>";
	echo "<table><tr><td><font color='#9900FF'>1. Indicate either \"Yes\" or \"No\". &nbsp;&nbsp;2. Click the \"Update\" button. &nbsp;&nbsp;</font><font color='red'>3. Email the next Reviewer.</font></td></r></table>";
	echo "<table><tr><th>Reviewer <font color='brown'>$review_code</th><th>&nbsp;&nbsp;&nbsp;&nbsp;Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th>Recommend for<br />Approval</th><th>Comments</th><th><font color='red'>Email Next Reviewer</font></th></tr>";
	$i=0;
	if($level>0)
		{
		
// enre - Environmental Review coordinator - 1
// inmo - Inventory and Monitoring Biologist - 2
// nama - Natural Areas Manager and Invasive Species - 3
// fico - Fire Coordinator - 4
// mobi - Mountain Biologist - 5
// pibi - Piedmont Biologist - 6
// cobi - Coastal Biologist - 7
// rmpm - Resource Management Program Manager - 8
		$approve_array=array("enre"=>"60092633","inmo"=>"60091483", "nama"=>"65020685","fico"=>"60032832","mobi"=>"60033177","pibi"=>"60033014","cobi"=>"60032943", "rmpm"=>"60032828");
		}
	
	$position_voted=array();
	foreach($review_array as $code=>$title)
		{
		if($i<7)
			{$i++;}
	
		$var=$review_array[$code];
		foreach($review_flds as $k=>$v)
			{
			$var_fld=$code."_$v";
			$val=$display_review[$var_fld];
			if(fmod($k,3)==0)
				{
				$f1="";$f2="";
				if(strpos($var_fld,"_date")>0 and $val!="0000-00-00")
					{
					$temp_var=$code."_recommend";
					$display_review[$temp_var]=="No"?$var_color="red":$var_color="green";
					$f1="<font color='$var_color'>"; $f2="</font>";
					$array_some[$code]=$code;
					}
				
				if($code!="pasu"){$pasu_name="";}
				if($code=="pasu")
					{
					$e_content="Subject=Project Review: $proj_name&Body=Click the link to review this project - https://10.35.152.9/dpr_rema/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: https://10.35.152.9/dpr_rema/index.html&cc=$submitter_email";
					$e_content="Subject=Project Review: $proj_name&Body=Click the link to review this project - https://10.35.152.9/dpr_rema/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: https://10.35.152.9/dpr_rema/index.html&cc=$submitter_email";
				//	$exp_pasu_email=explode(",",$pasu_email);
					foreach($pasu_email as $k1=>$v1)
						{
						@$pasu_email_list.="$v1,";
						@$pasu_name_list.=$pasu_name[$k1].",";
						}
					$pasu_email_list=rtrim($pasu_email_list,",");
					$pasu_name_list=rtrim($pasu_name_list,",");
					$pasu_name="<a href='mailto:$pasu_email_list?$e_content'>$pasu_name_list</a>";
					}
				echo "</tr><tr><td>$pasu_name $f1$var$f2</td>";
				}
				
			$ro="disabled";	
			if($code==$review_code)
				{$ro="";}
			if($level>2 and !in_array($beacon_num,$approve_array))   // line 413
				{$ro="disabled";}
			if(strpos($var_fld,"_date")>0) 
				{$ro="disabled";}
			if($review_code=="Admin")
				{
				$ro="";
				$var_display="<input type='text' name='$var_fld' value=\"$val\" $ro>";
				}// Allow Admin to change date
				else
				{
				$var_display=$val;
				}
			if(strpos($var_fld,"_recommend")>0)
				{
				$cky=""; $ckn=""; $fcn=""; $fcy="";
				if(!empty($val))
					{
					$vf=explode("_",$var_fld);
					$position_voted[]=$vf[0];
					if($val=="Yes")
						{
						$cky="checked";
						$fcy="green";
						}
					if($val=="No")
						{
						$ckn="checked";
						$fcn="red";
						}
					}
				
				$var_display="<input type='radio' name='$var_fld' value=\"Yes\" $cky $ro><font color='$fcy'>Yes</font><br />";
				$var_display.="<input type='radio' name='$var_fld' value=\"No\" $ckn $ro><font color='$fcn'>No</font>";
				}
			if(strpos($var_fld,"_comments")>0)
				{
				$var_display="<textarea name='$var_fld' cols='66' rows='2' $ro>$val</textarea>";
				
				if($code=="rmpm")  // ************** REMA Prog. Manager **************
					{
					$dec="";
					if(!empty($display_review['rmpm_recommend']))
						{$display_review['rmpm_recommend']=="Yes"?$dec="approved":$dec="not approved";}
//		echo "<pre>"; print_r($all_email); echo "</pre>"; // exit;
				foreach($all_email as $var_i=>$var_y)
					{
					$exp=explode(",",$var_y);
					$exp=array_unique($exp);
					foreach($exp as $k2=>$v3)
						{
						$var_y=trim($v3);
						if($pass_os=="Mac")
							{@$temp_e.=$var_y.", ";}
							else
							{@$temp_e.=$var_y."; ";} // MS Outlook requires ; as a separator
						}
					}
					$e1=rtrim($temp_e,"; ");
					$e1=rtrim($e1,", ");
					$e_content="Subject=$park_code-Project Review: $proj_name&Body=This project has received division approval. Please review all comments, appropriate guidelines, and policies before proceeding.%0D%0A%0D%0AClick the link to review this project - https://10.35.152.9/dpr_rema/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: https://10.35.152.9/dpr_rema/index.html&cc=$submitter_email";
					$e_content="Subject=$park_code-Project Review: $proj_name&Body=This project has received division approval. Please review all comments, appropriate guidelines, and policies before proceeding.%0D%0A%0D%0AClick the link to review this project - https://10.35.152.9/dpr_rema/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: https://10.35.152.9/dpr_rema/index.html&cc=$submitter_email";
				$e_content=htmlentities($e_content);
				if(!empty($dec) and $level>7) // REMA Prog. Manager is level 8
					{
				$var_display.="</td><td><a href=\"mailto:$e1?$e_content\">Email Decision</a>";}
					echo "<td>$var_display</td>";
					break;
					}
				$var1=$new_code_array[$i]; // get next in line for review
				$var2=${$var1."_email"};
//		echo "<pre>"; print_r($var2); echo "</pre>"; // exit;
				$t="";
				
				if(is_array($var2))
					{$var2=array_unique($var2);}
				
				foreach($var2 as $ke=>$ve)
					{
					if($pass_os=="Mac")
						{
						$t.="$ve, ";
						}
						else
						{
						$t.="$ve; "; // MS Outlook requires ; as a separator
						}	
					}
				$email=rtrim($t,"; ");
				$email=rtrim($email,", "); //echo "e=$email"; 
				
				$all_email[$var1]=$email;
				$e_content="Subject=$park_code-Project Review: $proj_name&Body=Click the link to review this project - https://10.35.152.9/dpr_rema/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: https://10.35.152.9/dpr_rema/index.html&cc=$submitter_email";
				$e_content="Subject=$park_code-Project Review: $proj_name&Body=Click the link to review this project - https://10.35.152.9/dpr_rema/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: https://10.35.152.9/dpr_rema/index.html&cc=$submitter_email";
				$e_content=htmlentities($e_content);
				$var_display.="</td><td><a href=\"mailto:$email?$e_content\">$var1</a>";
				}
			echo "<td>$var_display</td>";
			}
		}
	echo "</tr></table>";
	}
//echo "<pre>"; print_r($position_voted); echo "</pre>"; // exit;
echo "<table align='center'>";
if(!empty($all_email) and !empty($array_some))
	{
echo "<tr>";
//	echo "all<pre>"; print_r($all_email); print_r($array_some); echo "</pre>some"; // exit;

	foreach($array_some as $var_k=>$var_v)
		{
		$some_email[$var_k]=$all_email[$var_k];
		}
	
	$t="";
	foreach($all_email as $ke=>$ve)
		{
		$exp=explode(",",$ve);
		if(!empty($position_voted) and !in_array($ke,$position_voted)){continue;}
		foreach($exp as $k_2=>$v_2)
			{
			if($pass_os=="Mac")
				{
				$t.="$v_2, ";
				}
				else
				{
				$t.="$v_2; "; // MS Outlook requires ; as a separator
				}
			}
		}
	$email=rtrim($t,"; ");
	$email=rtrim($email,", "); 
	if(strpos($email, $all_email['submitted_by'])==FALSE)
		{
		
			if($pass_os=="Mac")
				{
				$email.=", ".$all_email['submitted_by'];
				}
				else
				{
				$email.="; ".$all_email['submitted_by']; // MS Outlook requires ; as a separator
				}
		
		} 
//	 echo "<br />$email";

		if($pass_os=="Mac")
			{$kk=count(array_unique(array_filter(explode(",",$email))));}
			else
			{$kk=count(array_unique(array_filter(explode(";",$email))));}
	
//	$c=count(array_unique($some_email));
//	echo "<pre>"; print_r($some_email); echo "</pre>"; // exit;
	$e_content="Subject=$park_code-Project Review: $proj_name&Body=Project Number: $proj_number. Click the link to review this project - https://10.35.152.9/dpr_rema/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: https://10.35.152.9/dpr_rema/index.html";
	$e_content="Subject=$park_code-Project Review: $proj_name&Body=Project Number: $proj_number. Click the link to review this project - https://10.35.152.9/dpr_rema/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: https://10.35.152.9/dpr_rema/index.html";
	
	echo "<td colspan='2'><a href='mailto:$email?$e_content'>Email</a> the $kk who have previously submitted/reviewed. </td>";
	}
echo "<tr><td colspan='3' align='center'>";
if(!empty($id))
	{echo "<input type='hidden' name='id' value=\"$id\">";}
if(!empty($proj_number))
	{echo "<input type='hidden' name='proj_number' value=\"$proj_number\">";}
if(!empty($review_code))
	{echo "<input type='hidden' name='review_code' value=\"$review_code\">";}
echo "<input type='submit' name='submit' value=\"$action_type\" style=\"background-color:#0000FF; color:#fff; font-size:16px;\">
</td></tr>";
echo "</table></form></div>";

if(@$_POST['submit']=="Update")
	{
	echo "<script>
			$(function() {
				$( \"#datepicker3\" ).datepicker({
				changeMonth: true,
				changeYear: true, 
				dateFormat: 'yy-mm-dd',
				yearRange: \"0yy:+1yy\",
				minDate: \"0yy\",
				maxDate: \"+1yy\" });
				});
			</script>";
	}

if($_SERVER['REQUEST_URI']!="/dpr_rema/find.php")
	{
echo "Note:  If this project has not been started within (2) years of the approved date, it must be resubmitted for new review and approval.";
	}
echo "</div></body></html>";
mysqli_close ($connection);
?>
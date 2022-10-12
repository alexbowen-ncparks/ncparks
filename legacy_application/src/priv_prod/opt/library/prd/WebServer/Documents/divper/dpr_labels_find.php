<?php

$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 

include("../../include/get_parkcodes_reg.php");

mysqli_select_db($connection,'divper'); // database

$level=$_SESSION['divper']['level'];

if(@$rep=="")
	{
	include("menu.php");
if(@$_SESSION['logname']=="Cook0058"){echo "Access not allowed.";exit;}
	include("dpr_labels_base_i.php");
	}
	else
	{
	$fieldArray=array("park","affiliation_code","First_name","Last_name");
	}

//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
if(@$submit_label=="Find")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	foreach($_REQUEST AS $k=>$v)
		{
		if($k=="db_source" OR $k=="submit_label"){continue;}
		if(!empty($v)){$ok=1;}
		}
	if(!isset($ok)){echo "You must enter something to search for. Click your brower's back button."; exit;}
	$ignore=array("id","custom","affiliation_code","affiliation_name");
	
	$like=array("pac_comments","pac_nomination","general_comments","pac_nomin_comments");
	
	// Restrict PAC
	$restrictPAC=array("PAC","PAC_nomin","PAC_FORMER","pac_comments","pac_nomination","pac_term","pac_terminates","pac_nomin_month","pac_nomin_year","pac_reappoint_date","pac_replacement","dist_approve");
	
	$arraySet="1";
	$passQuery="";
	for($i=0;$i<count($fieldArray);$i++)
		{
		@$val=${$fieldArray[$i]};// force the variable
		if(in_array($fieldArray[$i],$ignore) OR $val==""){continue;}
		if($fieldArray[$i]=="pac_nomin_month"){$val=str_pad($val,2,"0", STR_PAD_LEFT);}
		// Restrict
		if(in_array($fieldArray[$i],$restrictPAC)){$show_pac_nomin_comments=1;}
		
		// Like
		if(in_array($fieldArray[$i],$like))
			{
			$arraySet.=" and ".$fieldArray[$i]." like '%".$val."%'";
			$passQuery=$fieldArray[$i]."=".$val."&";
			}
		
			else
			{
		// Equals
			$val="'".$val."'";
			$arraySet.=" and ".$fieldArray[$i]."=".$val;
			$passQuery=$fieldArray[$i]."=".$val."&";
			}
		}
	
	
	//echo "<pre>"; print_r($add_cat); echo "</pre>"; // exit;
	
	if($arraySet==""){$arraySet="1";}
	
	if(@$add_cat)
		{
		$pac_array=array("PAC","PAC_nomin","PAC_FORMER");
			$arraySet.=" AND (";
			foreach($add_cat as $key=>$value)
				{
				if(in_array($value,$pac_array)){// used in dpr_labels_many.php
				$show_pac_nomin_comments=1;}
				$arraySet.="t1.affiliation_code='".$value."' OR ";
				$passQuery.="add_cat[$key]=".$value."&";
				}
		$arraySet=trim($arraySet," OR ").")";
		}
	
	if(@$id){$arraySet="1 and labels.id='$id'";}
	
//	if($passQuery){$arraySet=urldecode($passQuery);}
	
	//$orderBy =($sort ? "order by $sort" : "order by Last_name");
	if(@in_array("PAC",$add_cat) OR @in_array("PAC_FORMER",$add_cat) OR @in_array("PAC_nomin",$add_cat) OR in_array("dist",$fieldArray))
		{
		$orderBy="order by park,t1.affiliation_code,Last_name, dist_approve desc";
		}
		else
		{
		$orderBy="order by park,t1.affiliation_code,Last_name";
		}
		
	//	$orderBy="order by park,t1.affiliation_code,Last_name";
		
	
	if($level<2 AND @$show_pac_nomin_comments=="1")
		{
		$asheArray=array("MOJE","NERI");
		$bladenArray=array("JONE","SILA");
		$rp=$_SESSION['divper']['select'];
		if($rp!="ARCH"){
		$restrictPark=" and park='$rp'";}
		if(in_array($rp,$asheArray)){
				$restrictPark=" and (park='MOJE' OR park='NERI')";}
		if(in_array($rp,$bladenArray)){
				$restrictPark=" and (park='JONE' OR park='SILA')";}
		}
	
$sql="SELECT person_id as id,affiliation_code as code from labels_affiliation";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$test=$row['code']."*".$row['id'];
		$AF_code[$test]=$row['id'];
		}
//echo "<pre>";print_r($AF_code);echo "</pre>";	exit;

//if(in_array("470",$AF_code)){echo "Hello";exit;}
// The above query is not necessay if using MySQL 4.1 or greater
// Use GROUP_CONCAT instead

if(!isset($restrictPark)){$restrictPark="";}

	$sql="SELECT labels.*, t2.affiliation_code, t2.affiliation_name
	from labels
	LEFT JOIN labels_affiliation as t1 on t1.person_id=labels.id
	LEFT JOIN labels_category as t2 on t2.affiliation_code=t1.affiliation_code
	where $arraySet $restrictPark
	group by labels.id
	$orderBy"; //echo "$sql";
	
	if($_SESSION['divper']['level']>4 AND @$rep=="")
		{
	//	echo "$sql<br /><br />";
		//exit;
		}
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
	
	if($num<1){$message="No record found using $arraySet";}
		
// ****************************************	
	if($num>1)
		{
		include("dpr_labels_many.php"); 
		exit;
		}
		
		
		
		
// ****************************************	
	if($num==1)
		{
		$sql="SELECT labels.*, t2.affiliation_code, t2.affiliation_name from labels
		LEFT JOIN labels_affiliation as t1 on t1.person_id=labels.id
		LEFT JOIN labels_category as t2 on t2.affiliation_code=t1.affiliation_code
		where $arraySet $restrictPark";
		//echo "$sql<br />s=$show_pac_nomin_comments l=$level";//exit;
		
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$num=mysqli_num_rows($result);
		while($row=mysqli_fetch_array($result))
			{
			$pass_row=$row;
			extract($row);
			$passCode[]=$row['affiliation_code'];
			}
//			echo "<pre>"; print_r($passCode); echo "</pre>"; // exit;

// *********** redirect if necessary
if(@$db_source=="donation")
	{
	$PATH="/opt/library/prd/WebServer/Documents/donation/";
	include($PATH."donors.php");

	exit;
	}


// ******* no redirect
		echo "<form action='dpr_labels_update.php' method='POST'><table border='1' cellpadding='5'>";
		
			include("dpr_labels_form.php"); 
		
		
				echo "<hr><table><tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td align='right' colspan='2'>";
		
		if($park){echo "<input type='hidden' name='park' value='$park'>";}
		
		echo "<input type='hidden' name='id' value='$id'>
		<input type='submit' name='submit_label' value='Update' style=\"background-color:lightgreen;width:65;height:35\"></form></td>";
		
		echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
		
		echo "<td><form action='dpr_labels_find.php'>
		<input type='submit' name='submit_label' value='Go to Find'></form></td>";
		
		echo "<td><form action='dpr_labels_add.php'>
		<input type='submit' name='submit_label' value='Go to Add'></form></td>";
		
		
		echo "<td><form action='dpr_labels_update.php'>
		<input type='hidden' name='id' value='$id'>
		<input type='submit' name='submit_label' value='Delete' onClick=\"return confirmLink()\"></form></td>";
		
		if($level>4){echo "<td><form action='dpr_labels_dupe.php'>
		<input type='submit' name='submit' value='Find Duplicates'></form></td>";}
		
		echo "</tr></table><hr><table border='1'>";
		
		if($file_link)
			{
			$file_link=trim($file_link,",");
			$files=explode(",",$file_link);
			foreach($files as $kf=>$kv){
				$f=explode("/",$kv);
				@$links.="<td align='center'>[<font color='brown'>$f[2]</font>]<br /><a href='$kv' target='_blank'>View</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href='dpr_labels_del_file?link=$kv&pass=$park&id=$id'  onClick='return confirmLink()'>Delete</a>";
				echo "</td>";
				}
			echo "<tr>$links</tr>";
			}
		
		echo "<tr><td colspan='4'><b>FILE UPLOAD</b>
			<form method='post' action='dpr_labels_add_file.php' enctype='multipart/form-data'>
		
		   <INPUT TYPE='hidden' name='id' value='$id'>
		   <INPUT TYPE='hidden' name='pass' value='$park'>
		  <br>1. Click the BROWSE button and select your JPEG, PDF, WORD or EXCEL file.<br>
			<input type='file' name='file_upload'  size='40'> 2. Then click this button. 
			<input type='submit' name='submit' value='Add File'>
			</form>";
		
		echo "</td>";	
		echo "</tr></table><hr>";
		
			@$flip=array_flip($_REQUEST);
			sort($flip);
		//	echo "p=$park<pre>"; print_r($flip); print_r($add_cat);echo "</pre>"; // exit;
			@$test=substr($flip[2],0,4); //echo "$test";
			if(@strlen($flip[2])==4){$test="pass";}
			
		if($test=="park" || $test=="pass")
			{			
				if($test=="park"){
			$newQuery=str_replace("_AND_"," AND ",$flip[2]);
			$newQuery=str_replace("t1_","t1.",$newQuery);
			$arraySet=" and ".$newQuery;}
				if($test=="pass"){$arraySet="and park='$park'";}
			$sql="SELECT labels.*, t2.affiliation_code, t2.affiliation_name from labels
			LEFT JOIN labels_affiliation as t1 on t1.person_id=labels.id
			LEFT JOIN labels_category as t2 on t2.affiliation_code=t1.affiliation_code
			where 1 $arraySet
			group by labels.id
			order by t2.affiliation_code,Last_name"; //echo "$sql";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
			$num=mysqli_num_rows($result);
			
			echo "PAC Members for $park";
			include("dpr_labels_many.php");
			}
		
		echo "</body></html>";
			exit;}
	
		
	}// end Find



// ****** Show Input form **********

echo "<form action='dpr_labels_find.php' method='POST'><table border='1' cellpadding='5'>";

// ********************************Checkboxes for Affliliations**************************
include("dpr_labels_form.php");

echo "<tr>
<td colspan='2' align='right'>";

if(!empty($db_source))
	{
	echo "<input type='hidden' name='db_source' value='$db_source'>";
	}
echo "<input type='submit' name='submit_label' value='Find' style=\"background-color:lightgreen;width:65;height:35\"></td></form>

<form action='dpr_labels_add.php'><td align='right'>";
if(!empty($db_source))
	{
	echo "<input type='hidden' name='db_source' value='$db_source'>";
	}
echo "<input type='submit' name='submit_label' value='Go to Add'></td></form>";

if(empty($db_source))
	{
	$print_labels_array=array("Processing Assistant III"=>"ARCH","ARCHadminTemp"=>"ARCH","Executive Assistant I"=>"ARCH","Administrative Secretary II"=>"ARCH","Community Planner"=>"ARCH");

	$print_link="<form action='dpr_labels_print.php'><td align='center'>
	<input type='submit' name='submit_label' value='Print Labels'></form>
	<form action='labels_pdf30.php'>
	<input type='submit' name='type' value='Print Custom'></form>";

	foreach($print_labels_array as $k=>$v)
		{
		if($m2==$v AND $m1==$k){echo "$print_link";}
		}
	if($level>2)
		{
		echo "$print_link";

		$dupe_link="<br /><form action='dpr_labels_dupe.php'>
		<input type='submit' name='submit' value='Find Duplicates'></form>";
		if($level>4){echo "$dupe_link";}
		echo "</td>";
		}
	}
echo "</tr></table></body></html>";
mysqli_close($connection);
?>
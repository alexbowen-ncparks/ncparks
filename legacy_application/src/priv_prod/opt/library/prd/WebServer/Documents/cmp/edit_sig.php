<?php
extract($_REQUEST);

if(@$text=="y")
	{
	$database="cmp";
	include("../../include/iConnect.inc");// database connection parameters
	$db = mysqli_select_db($connection,$database)
		   or die ("Couldn't select database $database");
	}


if(empty($text)){include("menu.php");}

if(@$edit)
	{
	$sql = "SELECT * FROM sig as t1 
	WHERE  id='$edit' 
	";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
	
	if(mysqli_num_rows($result)==1)
		{
		$row=mysqli_fetch_assoc($result);
		$park_code=$row['park_code'];
			foreach($row as $k=>$v)
				{
				$ARRAY[$k]=$v;
				}
		}
	}
	else
	{
//echo "hello"; exit;
	if(empty($park_code)){$park_code=$_SESSION['cmp']['select'];}
	$sql = "SELECT * FROM sig as t1 
	WHERE  park_code='$park_code' 
	";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	
	if(mysqli_num_rows($result)>0)
		{
		$row=mysqli_fetch_assoc($result);
		$park_code=$row['park_code'];
			foreach($row as $k=>$v)
				{
				$ARRAY[$k]=$v;
				}
		}
	}
//echo "$sql";	

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;

echo "<body bgcolor='beige' class=\"yui-skin-sam\">";

echo "<table><tr><td><table cellpadding='5' border='1' bgcolor='aliceblue'>";
	
	if(@$message==1)
		{
		echo "</td></tr><tr bgcolor='yellow'><td colspan='4' align='center'>Your report has been entered.<br />Review for completeness/correctness.</td></tr>";
		}
	

include("sig_array.php");
	

	if(empty($park_code)){$park_code=$_SESSION['cmp']['select'];}
	
	$park_item="<input type='text' name='park_code' value=\"$park_code\" size='5' READONLY>";
	
	if($level<2)
		{
		if(@$_SESSION['cmp']['accessPark'] != "")
			{
			$limit_park=$_SESSION['cmp']['accessPark'];
			$lp=explode(",",$limit_park);
			$park_item="<select name='park_code' onChange=\"MM_jumpMenu('parent',this,0)\">
			<option selected=''></option>";
			foreach($lp as $k=>$v)
				{
				if($v==$park_code){$s="selected";}else{$s="value";}
				$v1="sig.php?park_code=$v";
				$park_item.="<option $s='$v1'>$v</option>";
				}
			$park_item.="</select>";
			}
		}
	
	if($level>1)
		{
		include("../../include/get_parkcodes_dist.php");

// also in sig_check.php
$add_code=array("EADI","NODI","SODI","WEDI","BUOF","DEDE","WARE","DIRO","OPS1","OPS2","PACR","NARA","REMA","LAND","TRAI","PAR3");

		$parkCode=array_merge($parkCode,$add_code);
		$remove_code=array("BAIS","BATR","BECR","BEPA","BULA","BUMO","DERI","LEIS","LOHA","MIMI","OCMO","PIBO","RUHI","SARU","SCRI","SUMO","THRO","WOED","YEMO");
		
		$parkCodeName['BUOF']="Budget Office";
		$parkCodeName['DEDE']="Design and Development";
		$parkCodeName['DIRO']="Director's Office";
		$parkCodeName['LAND']="Land";
		$parkCodeName['NARA']="Chief of Natural Resource & Regional Planning";
		$parkCodeName['OPS1']="Chief of Operations";
		$parkCodeName['OPS2']="Facility Maintenance Manager";
		$parkCodeName['PAR3']="Grants Program Manager";
		$parkCodeName['PACR']="Park Chief Ranger";
		$parkCodeName['REMA']="Resource Management";
		$parkCodeName['TRAI']="Trails Program";
		
		sort($parkCode);
		$park_item="<select name='park_code' onChange=\"MM_jumpMenu('parent',this,0)\">
		<option selected=''></option>";
		foreach($parkCode as $k=>$v)
			{
			if(in_array($v,$remove_code))
				{continue;}
			if(@$level==2 and @$district[$v]!=$ck_park)
				{continue;}
			$park_name=$parkCodeName[$v];
			if($v==$park_code){$s="selected";}else{$s="";}
			$v1="sig.php?park_code=$v";
			$park_item.="<option value='$v1' $s>$v - $park_name</option>\n";
			}
		$park_item.="</select>";
		}


$budget_officer="60032781";
$div_director="60032778";
$user=$_SESSION['cmp']['beacon'];

$bo_only=array("s1_7","s1_8","s1_15","s1_16");
$dd_only=array("s1_13","s1_14");
	
echo "<form method='POST' name='contactForm' action='sig.php' enctype='multipart/form-data'>";
		
$skip=array("id","park_code","prime_beacon_num","sec_beacon_num","update_on","active_date");
	
echo "<tr><td colspan='2' align='right'>Park</td><td colspan='2'>$park_item</td></tr>";

$prime=$ARRAY['prime_beacon_num'];
$sec=$ARRAY['sec_beacon_num'];
echo "<tr><td></td><td align='right'><b>Copy and paste from the Position Numbers button the Name and Title:</b></td>
<td>PRIMARY<br />AUTHORIZED APPROVER<br />
<input type='text' name='prime_beacon_num' value='$prime' size='35'></td>
<td>SECONDARY<br />AUTHORIZED APPROVER<br />
<input type='text' name='sec_beacon_num' value='$sec' size='35'></td>
</tr>";
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
foreach($ARRAY as $fld=>$value)
	{
	if(strpos($fld,"s2_")===0){continue;}
	if(strpos($fld,"s1_")===0)
		{
		$i=$fld;
		$exp=explode("_",$fld);
		$var2=$exp[1];
		}
		else
		{$i="";}
	if(in_array($fld,$skip)){continue;}

	if(empty($value)){$ck="";}else{$ck="checked";}
	$item="<input type='checkbox' name='$fld' value='x' $ck>"; // prime
	$fld2="s2_".$var2;
	@$value=$ARRAY[$fld2];
	if(empty($value)){$ck="";}else{$ck="checked";}
	$item.="</td><td><input type='checkbox' name='$fld2' value='x' $ck>"; // sec

	$name=nl2br($sig_array[$fld]);
	
	if(in_array($fld,$bo_only) and $user!=$budget_officer){$item="";}
	if(in_array($fld,$dd_only) and $user!=$div_director){$item="";}

	echo "<tr><td>$i</td><td>$name</td><td>$item</td></tr>";	
	}
		
	if(@$message==1){$message="</tr><tr><td colspan='3' align='center'>Your request has been entered.<br />Review for completeness/correctness.</td></tr><tr>";}
	

if($level<2)
	{
	@$park_code_array=explode(",",$_SESSION['cmp']['accessPark']);
	}
	
if($level>0 OR in_array($park_code,$park_code_array) OR $park_code==$_SESSION['cmp']['select'])
	{
	if($level>0)
		{
		echo "<tr><th colspan='4' align='center'>Submit the Signature Authorization Form</th></tr><tr><td align='center' colspan='4'>
		<input type='hidden' name='park_code' value='$park_code'>
		<input type='submit' name='submit' value='Submit'>
		</form></td>
		";
		}
	}
	else
	{echo "</form>";}
	
	$active_date=$ARRAY['active_date'];
	if($level>4 or $_SESSION['cmp']['beacon']=="60032781" ) // Tammy Dodd
		{$fld_active_date="Active Date:<input type='text' name='active_date' value=\"$active_date\">";}
		else
		{$fld_active_date="Active Date: ".$active_date;}
	$page="/cmp/sig_form.php";
	echo "</tr><tr><td colspan='4' align='right'><form method='POST' action='$page'>
	$fld_active_date
	<input type='hidden' name='park_code' value='$park_code'>
	<input type='submit' name='submit' value='Print'></form>
	</td>";

	
	echo "</tr>";
	echo "</table></td></tr>";
	echo "</table></html>";

?>
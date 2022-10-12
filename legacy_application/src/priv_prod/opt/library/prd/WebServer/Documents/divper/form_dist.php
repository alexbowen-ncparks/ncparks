<?php
//These are placed outside of the webserver directory for security
//ini_set('display_errors',1);

session_start();
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$level=$_SESSION['divper']['level'];

if($_SESSION['logname']=="Fullwood1940")
	{
	$_SESSION['divper']['select']="ARCH"; 
// 	$_SESSION['divper']['level']=4;

	}
$database="divper";
if(empty($_SESSION[$database]['level'])){exit;}
include("../../include/iConnect.inc"); 
// include("../../include/get_parkcodes_reg.php");  // also sets parkCounty
include("../../include/get_parkcodes_dist.php");  // also sets parkCounty


$database="divper";
mysqli_select_db($connection,$database); // database

if(@$rep=="excel"){Header("Location: form_excel.php?rep=excel&parkS=$parkS");
exit;}

unset($parkCode);

$cdl_beacon_num=$_SESSION['beacon_num'];

// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;

if(!empty($_REQUEST['submit_form']))
	{
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;
	foreach($_REQUEST['mandatory'] as $beacon_num=>$value)
		{
	$sql = "UPDATE position SET mandatory='$value' where beacon_num='$beacon_num'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query.");
// 	echo "$sql<br />";
		}
	echo "Update completed.";
	}
include("css/TDnull.inc");

$sql = "SELECT DISTINCT park as park from position where 1 order by park"; //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query.");
while($row=mysqli_fetch_assoc($result))
	{
	$parkCode[]=$row['park'];
	}
// echo "<pre>"; print_r($parkCode); echo "</pre>";  exit;
$parkCounty["PRTF"]="Wake";
$parkCounty["NCMA"]="Wake";
$parkCounty["NCMA"]="Wake";

// ************ Process input
@$val = strpos($Submit, "Update");
if($val > -1)
	{  // strpos returns 0 if Edit starts as first character
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	if(!$seidA=="")
		{
		for($i=0;$i<count($seidA);$i++)
			{
			$exemptLower=strtolower($exemptA[$i]);
			$cdl_upper=strtoupper($cdlA[$i]);
			if($posNumA[$i]==""){$posNumA[$i]=substr($beacon_numA[$i],3,5);}
			$sql = "UPDATE position SET `posNum`='$posNumA[$i]',`beacon_num`='$beacon_numA[$i]',`posTitle`='$posTitleA[$i]',`posTitle_reg`='$posTitleA[$i]', `rcc`='$rccA[$i]',`current_salary`='$current_salaryA[$i]' 
			,`cdl`='$cdl_upper',`salary_grade`='$salary_gradeA[$i]',`exempt`='$exemptLower',
			`park`='$reasonA[$i]', `park`='$reasonA[$i]',`posType`='$posTypeA[$i]',`section`='$sectionA[$i]',`fund`='$fundA[$i]',`fund_source`='$fund_sourceA[$i]' WHERE seid='$seidA[$i]'";
			
			//,`fund_source_GRF`='$fund_source_GRFA[$i]' 
			
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute sql. $sql");
			
				if($reasonA[$i]!=$parkPass)
					{
					$sql2 = "UPDATE position
					SET `reason`='from $parkPass' WHERE seid='$seidA[$i]'";
					//echo "2 $sql2<br><br>";//exit;
					$result2 = mysqli_query($connection,$sql2) or die ("Couldn't execute sql2. $sql2");
					}
			}
		//exit;
		@$message.="Update successful.";
		header("Location: form_dist.php?park=$parkPass&message=$message");
		exit;
			}// end if !$seid
	} // end Update

if(@$s!="prempay"){include("menu.php");}

@$val = strpos($Submit, "Add");
if($val > -1)
	{  // strpos returns 0 if Add starts as first character
	if($park=="nonDPR"){echo "Can't add nonDPR positions.<br><br>Click your Browser's Back button."; exit;}
	if($beacon_num==""){echo "BEACON Position Number cannot be blank.<br><br>Click your Browser's Back button."; exit;}
	
	$posNum=substr($beacon_num,1,1);
	$posNum.=substr($beacon_num,4,4);
	
	//,`fund_source_GRF`='$fund_source_GRF'
	//`previous_salary`='$previous_salary', 
	$sql = "INSERT INTO position SET `park`='$park', `park`='$park',`posNum`='$posNum',`beacon_num`='$beacon_num', `posTitle`='$posTitle',`posTitle_reg`='$posTitle',`rcc`='$rcc',`current_salary`='$current_salary',`salary_grade`='$salary_grade',`exempt`='$exempt',`section`='$sectionPass',`posType`='$posType',`fund`='$fund',`fund_source`='$fund_source'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	$message="Addition successful.";
	header("Location: form_dist.php?park=$park&message=$message");
	exit;
	} // end Add

//  ************Start input form*************

if($_SESSION['divper']['select'] !="" or $park != "")
	{
	if(@$park)
		{$_SESSION['divper']['select']=$park;}
	if($_SESSION['divper']['select'])
		{$park=$_SESSION['divper']['select'];}
	
//	$testPark=$_SESSION['parkS'];
	
	$sql = "SELECT * From position WHERE park='$park' AND markDel = '' ORDER by current_salary desc";
// 	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. ");
	$num=mysqli_num_rows($result);
	
	menuStuff($park,$num);
	$parkS=$_SESSION['divper']['select'];
//	array_unshift($parkCode,"ARCH","YORK");
	SORT($parkCode);
	echo "<select name='park' onChange=\"this.form.submit()\">";         
			foreach($parkCode as $index=>$scode)
				{
					if($scode==$park)
						{$s="selected";}
						else
						{$s="";}
				echo "<option value='$scode' $s>$scode\n";
				}
	echo "</select></form>";
	
// 	echo "$level";

	if($_SESSION['divper']['level'] > 2)
		{
		
		// ************ Add New Perm. Emp.
		$parkS=$_SESSION['divper']['select'];
		$type=array("New");
		if(!isset($message)){$message="";}
		echo "<font color='red'>$message</font>";
		echo "<table><form method='post' action='form_dist.php'><tr>
		<th width='100'>Position Number</th>
		<th width='50'>BEACON Number</th>
		<th width='50'>Fund</th>
		<th width='50'>Funding Source</th>
		<th width='200'>Position Title</th>
		<th width='50'>CDL Required Y or blank</th>
		<th width='50'>RCC</th>
		<th width='50'>Current Salary</th>
		<th width='50'>Salary Grade</th>
		<th width='50'>Exempt Y/N</th>
		<th width='50'>Transfer [Change RCC & Park]</th>
		<th width='50'>Type</th>
		<th width='50'>Section</th>
		<th width='50'>County</th>
		</tr>";
		// End ************ Add New Perm. Emp.
		
		echo "<tr><td align='center'>
		<input type='text' size='7' name='posNum' value='' READONLY></td>
		<td>
		<input type='text' size='9' name='beacon_num' value=''></td>
		<td>
		<input type='text' size='9' name='fund' value=''></td>";
		/*<td>
		<input type='text' size='5' name='fund_source_GRF' value='$fund_source_GRF'></td>
		*/
		echo "<td>
		<input type='text' size='9' name='fund_source' value=''></td>
		<td>
		<input type='text' size='27' name='posTitle' value=''></td>
		<td align='right'>
		<input type='text' size='6' name='cdl' value=''></td>
		<td align='center'>
		<input type='text' size='5' name='rcc' value=''></td>
		<td align='right'>
		<input type='text' size='6' name='current_salary' value=''></td>
		<td align='right'>
		<input type='text' size='3' name='salary_grade' value=''></td>
		<td align='right'>
		<input type='text' size='2' name='exempt' value=''></td>
		<td align='right'>";
		echo "<td align='right'>
		<select name='posType'><option selected></option>";
				  for($k=0;$k<count($type);$k++){
		echo  "<option value='$type[$k]'>$type[$k]</option>";
		}
			echo "</select></td>";
			
		$sql1 = "SELECT DISTINCT section FROM position";
		$result1 = mysqli_query($connection,$sql1) or die ("Couldn't execute query. ");
		while($row1=mysqli_fetch_array($result1)){extract($row1);$sectionArray[]=$section;}
		echo "<td align='right'>
		<select name='sectionPass'><option selected></option>";
				  for($k=0;$k<count($sectionArray);$k++){
		echo  "<option value='$sectionArray[$k]'>$sectionArray[$k]</option>";
		}
			echo "</select></td>";
		
//		<input type='hidden' name='seid' value='$seid'>
		echo "<td></td><td><input type='hidden' name='park' value='$parkS'>
		<td>
		<input type='submit' name='Submit' value='Add Position'></form> for $parkS</td></tr>
		<tr><td> </td></tr>";
		
		
		// ******** Update Form *************
		echo "<form method='post' action='form_dist.php'>";
		while ($row=mysqli_fetch_array($result))
		{extract($row);
		echo "<tr><td align='center'>
		<input type='text' size='7' name='posNumA[]' value='$posNum' READONLY></td>
		<td>
		<input type='text' size='9' name='beacon_numA[]' value='$beacon_num'></td>
		
		
		<td>
		<input type='text' size='9' name='fundA[]' value='$fund'></td>";
		/*<td>
		<input type='text' size='5' name='fund_source_GRFA[]' value='$fund_source_GRF'></td>
		*/
		echo "<td>
		<input type='text' size='9' name='fund_sourceA[]' value='$fund_source'></td>
		
		<td>
		<input type='text' size='27' name='posTitleA[]' value='$posTitle'></td>
		";
		if($_SESSION['logname']=="Howard6319" or $cdl_beacon_num=="60033136" or $cdl_beacon_num=="60032785") //Tom Howard or Head of HR or Teresa
			{
			echo "<td align='right'><input type='text' size='6' name='cdlA[]' value='$cdl'>";
			}
		else
			{
			echo "<td align='right'><input type='text' size='6' name='cdlA[]' value='$cdl' READONLY>";
			}
		
		
		echo "</td>
		<td align='center'>
		<input type='text' size='5' name='rccA[]' value='$rcc'></td>
		<td align='right'>";
		if($level>3)
		{
		echo "<input type='text' size='6' name='current_salaryA[]' value='$current_salary'></td>
		<td align='right'>
		<input type='text' size='3' name='salary_gradeA[]' value='$salary_grade'></td>
		";}
		echo "<td align='right'>
		<input type='text' size='2' name='exemptA[]' value='$exempt'></td>
		<td align='right'>
		<input type='text' size='5' name='reasonA[]' value='$park'></td>
		<td align='right'>
		<input type='text' size='10' name='posTypeA[]' value='$posType'></td>
		<td align='right'>
		<input type='text' size='10' name='sectionA[]' value='$section'></td>
		<td align='right'>$parkCounty[$park]</td>
		<td><input type='hidden' name='seidA[]' value='$seid'></td></tr>";
		
		}// end while
		echo "<tr><td colspan='10' align='center'>
		<input type='hidden' name='parkPass' value='$parkS'>
		<input type='submit' name='Submit' value='Update' onClick='return confirmSubmit()'>
		</form></td></tr></table>";
		/*
		echo "<table><tr><td>To delete a position: remove the Position Number, Position Title and RCC and then click on the Update button.</td></tr></table>";
		*/
		echo "</body></html>";
		exit;
		}// end if ADMIN
	
	// Level 2 and Below
if(!isset($message)){$message="";}
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$sql = "SELECT * From position WHERE park='$park' AND markDel = '' ORDER by current_salary desc";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. ");
	echo "<font color='red'>$message</font>
	<hr><form name='newEvent' method='post' action='form_dist.php'>
	
	<table><tr>
	<th width='100'>BEACON Number</th>
	<th width='200'>Position Title</th>
	<th width='50'>RCC</th>
	<th width='50'>Exempt</th>
	<th width='50'>CDL</th>
	<th width='100'>Mandatory</th>
	</tr>";
	$update="n";
	if(empty($_SESSION['divper']['accessPark']))
		{$_SESSION['divper']['accessPark']="";}
	while ($row=mysqli_fetch_assoc($result))
		{
// 		echo "<pre>"; print_r($row); echo "</pre>"; // exit;
		extract($row);
	$a="Superintendent";
	$b=$_SESSION['position'];
		$test=strpos($b,$a);
		$access=explode(',', $_SESSION['divper']['accessPark']);
		if($test>-1 and in_array($park, $access) or ($park==$_SESSION['parkS'] and $level>=1))
			{
			$update="y";
			$cky=""; $ckn="";
			if($mandatory=="Yes"){$cky="checked";}else{$ckn="checked";}
			$mandatory="<input type='radio' name='mandatory[$beacon_num]' value=\"Yes\" $cky>Yes
			<input type='radio' name='mandatory[$beacon_num]' value=\"No\" $ckn>No";
			}
		echo "<tr><td align='center'>$beacon_num</td>
		<td>$posTitle</td>
		<td align='center'>$rcc</td>
		<td align='center'>$exempt</td>
		<td align='center'>$cdl</td>
		<td align='center'>$mandatory</td>
		";
		}// end while
		echo "</tr>";
	if($update=="y")
		{
		echo "<tr><td><input type='submit' name='submit_form' value=\"Update\"></td></tr>";
		}
	}// end part 1 $park
else
	{
	menuStuff($park,$num);
array_unshift($parkCode,"ARCH","YORK");
SORT($parkCode);
	echo "<select name='park'>";         
	foreach($parkCode as $k=>$v)
		 {
		 if($v==$parkS){$s="selected";}else{$s="value";}
		echo "<option $s='$v'>$v\n";
		  }
	echo "</select>
	<input type='submit' name='submit' value='Show Position(s)'></form>";
	}// end if $park
echo "</table></body></html>";

// *************** Display Menu FUNCTION **************
function menuStuff($park,$num)
	{
	global $parkCodeName, $level;
	$park_name=@$parkCodeName[$park];
	echo "<html><head><title>Positions</title>
	<script language='JavaScript'>
	function confirmSubmit()
	{
	 bConfirm=confirm('You are about to Update the information for ALL positions listed on this page. Do you wish to continue?')
	 return (bConfirm);
	}
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
	  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
	  if (restore) selObj.selectedIndex=0;
	}
	</script>
	</head>
	<body><font size='4' color='004400'>NC State Parks System Personnel Database</font>
	<br><font size='5' color='blue'>$num Positions at $park_name
	</font>";
	if($level>2)
		{
	echo "<font color='red'>If you need to assign Mandatory / Non-mandatory status to those you supervise, click this <a href='form_mandatory.php'>link</a>.</font>";
		}
	echo "<br><form method='post' action='form_dist.php'>";
	}

?>
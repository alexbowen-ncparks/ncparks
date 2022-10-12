<?php
ini_set('display_errors',1);
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
session_start();
$database="divper";
if(empty($_SESSION[$database]['level'])){exit;}
if(empty($_SESSION['logname']))
	{
	echo "No session variable set.";
	echo "Restart your browser and login back in.";
	echo "If the issue persists, Contact Tony or Tom";
	exit;
	}
if($_SESSION['logname']=="Howard6319")
	{
// echo "9<pre>";print_r($_SESSION);echo "<pre>";//exit;
	}
  // Convert district to region
if(!empty($_SESSION['parkR']))
	{$_SESSION['parkS']=$_SESSION['parkR'];}

//These are placed outside of the webserver directory for security
include("../../include/iConnect.inc"); 

include("../../include/get_parkcodes_dist.php");

$database="divper";
mysqli_select_db($connection,$database); // database
unset($parkCode);

$sql = "SELECT DISTINCT park as park from position where 1 order by park"; //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query.");
while($row=mysqli_fetch_assoc($result))
	{
	$parkCode[]=$row['park'];
	}
// echo "<pre>"; print_r($parkCode); echo "</pre>";  exit;
$parkCounty["PRTF"]="Wake";
$parkCounty["NCMA"]="Wake";

// $add=array("CORE","PIRE","MORE","WARE");
// $add=array("WARE");
// $parkCode=array_merge($parkCode,$add);
sort($parkCode);

// mysqli_select_db($connection,'divper'); // database
include("../../include/salt.inc");

// extract($_REQUEST);
if(@$submit!="Update" AND @$submit!="Enter")
	{
	$setDate=1;
	include("menu.php"); // used to authenticate users
	}

$level=$_SESSION['divper']['level'];
$ckPosition=strtolower($_SESSION['position']);
$ps=strpos($ckPosition,"park super");
$oa=strpos($ckPosition,"office assistant");
if($ps>-1){$ckPosition="park superintendent";}
if($oa>-1){$ckPosition="office assistant";}

	$expand_access=array("Jarid Church"=>"621"); // $emid
	

//echo "<pre>";
//print_r($_POST);
//print_r($_REQUEST);
//echo "<pre>";print_r($_SESSION);echo "</pre>";
//echo "</pre>";  //exit;

if(@$park AND $p=="u"){$_SESSION['parkS']=$park;}// used to override Session from Update screen
if(@$posNumPass){$parkS="";}
if(@$beaconNumPass){$parkS="";}

if(@$f=="park")
	{
	$submit="Submit"; 
	$parkS=$_SESSION['divper']['select'];
	}
 
if($_SESSION['logname']=="Lequire7043")
	{
// echo "63<pre>";print_r($_SESSION);echo "<pre>";//exit;
	}
//  ************Start Blank Entry form*************
if(@$submit=="New")
	{
	if(!isset($message)){$message="";}
	if(!isset($currPark)){$currPark="";}
	@reshowForm($message,$currPark); // shows blank form because no variables passed
	}
//echo "<pre>"; print_r($parkCode); echo "</pre>";
// ***********Find person form****************
$f1="";
if(@$q!="")
	{
	$h1="<form action='formEmpInfo_dist.php' method='post'><table><tr><th colspan='3'>Find Employee</th></tr>";
	
	$h2="<form action='unitContactInfo.php' method='post'><table><tr><th colspan='3'>Find State Park Unit</th></tr>";
	
	$f1="<tr><td colspan='2' align='center'><input type='submit' name='submit' value='Submit'></td></tr>";
	
	if($q=="name"){echo "$h1<tr><td align='right'><b>Person's Last Name</b></td>
		 <td><input type='text' name='Lname' size='25' maxlength='35'><font size='2'> Enter all, or just beginning, of last name.</font></td></tr>$f1";}
				   
	if($q=="unit"){echo "$h1<tr><td align='right'><b>Park or Operation Unit </b></td>
		 <td><input type='text' name='parkS' size='7' maxlength='7'></td></tr>$f1";}
	
	if($q=="park"){echo "$h2"; $parkS="";
	echo "<tr><td><select name='parkS' onChange=\"MM_jumpMenu('parent',this,0)\">";         
			for ($n=1;$n<=$numParkCode;$n++)  
			{$scode=$parkCode[$n];if($scode==$parkS){$s="selected";}else{$s="value";}
	echo "<option $s='formEmpInfo_dist.php?parkS=$scode'>$scode\n";
			  }
	echo "</select></form></td></tr>";exit;}
		 
	if($q=="num"){echo "$h1<tr><td align='right'><b>Position Number </b></td>
		 <td><input type='text' name='posNumPass' size='7' maxlength='7'></td></tr>$f1";}
				 
	if($q=="beacon"){echo "$h1<tr><td align='right'><b>BEACON Position Number </b></td>
		 <td><input type='text' name='beaconNumPass' size='9' maxlength='8'></td></tr>$f1";}
		 
	echo "</table></body></html>";
	exit;
	}

// ***************SELECT Person by Lname**********
if(@$submit=="Submit" and @$Lname!="")
	{
	echo "<tr><td align='right'><b>Person's Last Name</b></td>
		 <td colspan='3'><form action='formEmpInfo_dist.php' method='post'><input type='text' name='Lname' size='25' maxlength='35'><font size='2'><input type='submit' name='submit' value='Submit'> Enter all, or just beginning, of last name.</font></td></tr>$f1";
//	@$Lname=addslashes($Lname);
//	@$Fname=addslashes($Fname);
	$sql = "SELECT empinfo.Nname, empinfo.Fname, empinfo.Lname, empinfo.emid, emplist.currPark, empinfo.tempID, empinfo.ssn3, emplist.jobtitle,position.posTitle, position.posNum, position.beacon_num
	FROM empinfo
	LEFT  JOIN emplist ON emplist.emid = empinfo.emid
	LEFT  JOIN position ON emplist.beacon_num = position.beacon_num
	WHERE empinfo.Lname
	LIKE  '$Lname%' and emplist.currPark !=''
	ORDER  BY tempID";
	// LEFT  JOIN emplist ON emplist.tempID = empinfo.tempID
	
// 	echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$count=mysqli_num_rows($result);
@$Lname=stripslashes($Lname);
@$Fname=stripslashes($Fname);
	echo "<table><tr><th colspan='6' align='left'>List of Permanent Employees with Last Name beginning with $Lname</th></tr>
	<tr><th></th><th>Name</th><th>Position Number</th><th>Duty Station</th><th>Title</th><th colspan='3'>View/Edit</th></tr>";
	$z=1;
	
	while ($row=mysqli_fetch_array($result))
		{
		//echo "<pre>";print_r($row);echo "</pre>";  //exit;
		extract($row);
		if($emid){
		
		@$emidSalted=md5($emid.$salt);
		
		if($Nname){$NN="($Nname)";}else{$NN="";}
		
		$passPark=$_SESSION['parkS'];
		$contactInfo="<td>[<A HREF='contactInfo_dist.php?beacon_num=$beacon_num&emid=$emid&parkS=$currPark' target='_blank'>Contact Info</a>]</td>";
		
			$varCA="<td>[<a href='compAssess.php?submit=pdf&emid=$emid&emidSalted=$emidSalted'>Comp. Assess.</a>]</td>";
			$varWP="<td>[<a href='workPlan.php?submit=pdf&emid=$emid&emidSalted=$emidSalted'>Completed 2014 VIP</a>]</td>";
	//		$varWPB="<td>[<a href='workPlan_vip.php?submit=pdf&emid=$emid&emidSalted=$emidSalted' target='_blank'>VIP Link</a>]</td>";
	$varWPB="";
		$perCA="";
		$perWP="";
		$perWPB="";
		
		$log_emid=$_SESSION['logemid'];
			
		if(isset($_SESSION['divper']['supervise']))
			{
				$tempSuper=$_SESSION['divper']['supervise'];
				if(in_array($tempSuper, $parkCode)){
					$sql = "SELECT beacon_num FROM position WHERE park='$tempSuper'";
					$result1 = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
					while($row1=mysqli_fetch_assoc($result1))
					{$superviseArray[]=$row1['beacon_num'];}
						}
						else{
						$superviseArray=explode(",",$_SESSION['divper']['supervise']);
						}
			}
		
		if(@in_array($beacon_num,$superviseArray))
			{
			$perCA=$varCA;
			$perWP=$varWP;
			$perWPB=$varWPB;
			}
		
		if($level==1 and $_SESSION['logemid']==$emid)
			{
			$perCA=$varCA;
			$perWP=$varWP;
			$perWPB=$varWPB;
			}
			
		  // 610 = Pam Witt
		  // 14 = Ron Anundson
		  // 213 = James Ledgerwood
		  // also update compAssess.php, workPlan.php
		if($level==1 and ($ckPosition=="park superintendent"||$ckPosition=="office assistant" OR in_array($log_emid,$expand_access)))
			{
			$parkList=$_SESSION['divper']['select'];// Get park
			if($log_emid==$emid || $currPark==$parkList)
				{
				$perCA=$varCA;
				$perWP=$varWP;
				$perWPB=$varWPB;
				}
			
			$asheArray=array("MOJE","NERI");
			if(in_array($currPark,$asheArray) AND in_array($_SESSION['divper']['select'],$asheArray))
				{
				$perCA=$varCA;
				$perWP=$varWP;
				$perWPB=$varWPB;
				}
			
			if($ckPosition=="park superintendent" AND $currPark==$parkList) 
				{
				$perCA=$varCA;
				$perWP=$varWP;
				$perWPB=$varWPB;
				}		
				
			if(($ckPosition=="office assistant" OR in_array($log_emid,$expand_access)) AND $currPark==$parkList)
				{
				$ck_office_assit=strtolower(substr($jobtitle,0,16));
				$perCA=$varCA;
				$perWP=$varWP;
				$perWPB=$varWPB;
				if($ck_office_assit=="office assistant" AND $emid!=$log_emid)
					{
					$perCA="";$perWP="";$perWPB="";
					}
				if(strtolower($jobtitle)=="park superintendent")
					{
					$perCA="";$perWP="";$perWPB="";
					}
				}	
		
			if($log_emid=="223" AND $emid!=$log_emid) //Denise Marquez
				{
				$perCA="";$perWP="";$perWPB="";
				}
			}
		
		if($level>1)
			{
			if($_SESSION['logemid']==$emid || $level>2)
				{
				$perCA="<td>[<a href='compAssess.php?submit=pdf&emid=$emid&emidSalted=$emidSalted'>Comp. Assess.</a>]</td>"; $passCA=$perCA;
				$perWP="<td>[<a href='workPlan.php?submit=pdf&emid=$emid&emidSalted=$emidSalted'>Completed 2014 VIP</a>]</td>"; $passWP=$perWP;
		//		$perWPB="<td>[<a href='workPlan_vip.php?submit=pdf&emid=$emid&emidSalted=$emidSalted' target='_blank'>VIP Link</a>]</td>"; $passWPB=$perWPB;
				
				if($level==3)  // This locks most Raleigh office folks into just their supervisor positions
					{
					@$supervise_array=explode(",",$_SESSION['divper']['supervise']); // employees
					$supervise_array[]=$_SESSION['beacon_num']; // supervisor
					if(!in_array($beacon_num,$supervise_array))
						{$perCA="";$perWP="";$perWPB="";}
					/*
					if($_SESSION['beacon_num']=="60033165")  // Workaround for Dowdy while SODI DISU position is vacant
						{
						$parkList="SODI";// Get district
						$da=${"array".$parkList};
						if(in_array($currPark,$da))
							{$perCA=$passCA;$perWP=$passWP;$perWPB=$passWPB;}
						}
					*/
					}		
				}
			
			if($level==2)
				{
				$arrayARCH[]=""; // needed to suppress warnings for Headquarters staff
				$parkList=$_SESSION['divper']['selectR'];// Get region 
			if($parkList!="FOSC")
				{
				$da=${"array".$parkList};
				
				if(in_array($currPark,$da))
					{
					$perCA="<td>[<a href='compAssess.php?submit=pdf&emid=$emid&emidSalted=$emidSalted'>Comp. Assess.</a>]</td>";
					$perWP="<td>[<a href='workPlan.php?submit=pdf&emid=$emid&emidSalted=$emidSalted'>Completed 2014 VIP</a>]</td>";
			//		$perWPB="<td>[<a href='workPlan_vip.php?submit=pdf&emid=$emid&emidSalted=$emidSalted' target='_blank'>VIP Link</a>]</td>";
					}
			
				if(strtolower($posTitle)=="parks district superintendent" AND $ckPosition!="parks district superintendent")
					{$perCA="";$perWP="";$perWPB="";}
					}
				}
			}
		
		$perInfo="";$posInfo="";
		
		if($_SESSION['divper']['level']>3)
			{
			$perInfo="<td>[<a href='formEmpInfo_dist.php?park=$currPark&submit=Find&emid=$emid&p=u'>Personal Info</a>]</td>";
			$posInfo="<td>[<a href='formPosInfo.php?beaconNumPass=$beacon_num&submit=Find&emid=$emid&p=y'>Position Info</a>]</td>";
			}
		
		if($_SESSION['divper']['level']>4)
			{
			$dbAccess="<td>[<a href='manage_access.php?emid=$emid'>Database Access</a>]</td>";
			}
		
		if(!isset($dbAccess)){$dbAccess="";}
		echo "<tr><td align='right'>$z - </td><td>$Lname, $Fname $NN</td><td align='center'>$beacon_num</td><td> $currPark</td><td>$posTitle</td>
		$perInfo $posInfo $dbAccess $contactInfo $perCA $perWP $perWPB
		<td>[<a href='getPhoto.php?submit=Find&tempID=$tempID' target='_blank'>Photo</a>]</td>
		</tr>";
		$z++;
		}
		else
		{
		echo "<tr><td colspan='6'><b>$Fname $Lname</b> is in the master database but is not associated with any Park/Duty Stattion.</td>
		<td><a href='formEmpInfo_dist.php?submit=add&emid=$emid'>Find</a></td></tr>";
				} //  end else for IF $emid
			} //  end while
	exit;
	} //  end for IF $submit & $Lname

//echo "su=$submit p=$parkS";exit;
// ***************SELECT Persons by parkS**********
if(@$submit=="Submit" and $parkS!="")
	{
	// Override to allow anyone in the park to view CAs and WPs other than theirs.
	if(isset($_SESSION['divper']['supervise'])){
			$tempSuper=$_SESSION['divper']['supervise'];
			if(in_array($tempSuper, $parkCode)){
				$sql = "SELECT beacon_num FROM position WHERE park='$tempSuper'";
				$resultBN = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
				while($rowBN=mysqli_fetch_assoc($resultBN))
				{$superviseArray[]=$rowBN['beacon_num'];}
					}
					else{
					$superviseArray=explode(",",$_SESSION['divper']['supervise']);
					}
	
			//	echo "<pre>"; print_r($superviseArray); echo "</pre>"; // exit;
				}
	
	if(isset($_SESSION['divper']['accessPark']))
		{
		$accessArray=explode(",",$_SESSION['divper']['accessPark']);
		}			
	$_SESSION['parkStemp']=strtoupper($parkS);
	$where="position.park ='$parkS'";
	$sql = "SELECT CONCAT(empinfo.Lname,empinfo.ssn3) as tempID,empinfo.emid,listid,empinfo.Lname,empinfo.Fname,posTitle as jobtitle,emplist.beacon_num,empinfo.Nname as NN,position.park as currPark, beaconID
	From emplist 
	LEFT JOIN empinfo on emplist.emid=empinfo.emid
	LEFT JOIN position on emplist.beacon_num=position.beacon_num
	WHERE $where ORDER by Lname,Fname";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql" );
// 	echo "$sql"; //exit;
	//$var2=2;
	
	if(!isset($var2)){$var2="";}
	echo "<table cellpadding='5'>
	<tr><th colspan='6'>List of Permanent Employees for $parkS $var2</th></tr>
	<tr><td colspan='6' align='center'><select name='parkS' onChange=\"MM_jumpMenu('parent',this,0)\"><option selected=''></option>\n";
// 	array_unshift($parkCode,"ARCH");
// 	$parkCode[]="YORK";
	foreach($parkCode as $index=>$scode)
		{
		if($scode==$parkS){$s="selected";}else{$s="value";}
	echo "<option $s='formEmpInfo_dist.php?submit=Submit&parkS=$scode'>$scode\n";
		}
		echo "</select></td></tr>";
	$z=1;
	
	//$findArray=array("This Person","Entire Unit","This Position","Entire Division");
	
	while ($row=mysqli_fetch_array($result))
	{
	extract($row);
	
	@$emidSalted=md5($emid.$salt);
	
	if($NN){$NN= "(".$NN.") ";}
	$contactInfo="<td><SELECT NAME=\"findVal\" onChange=\"MM_jumpMenu('parent',this,0)\">
	<OPTION value=''>Contact Info for\n
	<OPTION value='contactInfo_dist.php?beacon_num=$beacon_num&emid=$emid&parkS=$parkS' target='_blank'>$Fname $Lname\n
	<OPTION value='contactInfo_dist.php?var=unit&parkS=$parkS&Submit=Find' target='_blank'>$parkS\n
	<OPTION value='contactInfo_dist.php?var=position&p=$jobtitle&Submit=Find' target='_blank'>This Position\n
	<OPTION value='contactInfo_dist.php?var=division&Submit=Find' target='_blank'>Entire Division\n
	</SELECT></td>";
	
	
	if($tempID)
		{
		$varCA="<td>[<a href='compAssess.php?submit=pdf&emid=$emid&emidSalted=$emidSalted'>Comp. Assess.</a>]</td>";
		$varWP="<td>[<a href='workPlan.php?submit=pdf&emid=$emid&emidSalted=$emidSalted'>Completed 2014 VIP</a>]</td>";
	//	$varWPB="<td>[<a href='workPlan_vip.php?submit=pdf&emid=$emid&emidSalted=$emidSalted' target='_blank'>VIP Link</a>]</td>";
		$perCA="";
		$perWP="";
		$perWPB="";
		
		
		$log_emid=$_SESSION['logemid'];
		if($level==1 and $log_emid==$emid)
			{
			$perCA=$varCA;
			$perWP=$varWP;
			@$perWPB=$varWPB;
			}
			
		  // 610 = Pam Witt
		  // 14 = Ron Anundson
		  // also update compAssess.php, workPlan.php
		if($level==1 and ($ckPosition=="park superintendent"||$ckPosition=="office assistant" OR in_array($log_emid,$expand_access)))
			{
			$parkList=$_SESSION['divper']['select'];// Get park
			
			$ck_office_assit=substr($jobtitle,0,16);
			if($log_emid==$emid || $currPark==$parkList)
				{
				$perCA=$varCA;
				$perWP=$varWP;
				@$perWPB=$varWPB;
				}
			
			$asheArray=array("MOJE","NERI");
			if(in_array($currPark,$asheArray))
				{
				if(in_array($currPark,$accessArray))
					{
					$perCA=$varCA;
					$perWP=$varWP;
					@$perWPB=$varWPB;
					}
				}
				
/*			$cacrArray=array("CACR","RARO");
			if(in_array($currPark,$asheArray))
				{
				if(in_array($currPark,$accessArray))
					{
					$perCA=$varCA;
					$perWP=$varWP;
					$perWPB=$varWPB;
					}
				}
*/
				
			if($ckPosition=="park superintendent" AND $currPark==$parkList)
				{
				$perCA=$varCA;
				$perWP=$varWP;
				@$perWPB=$varWPB;
				}		
					
			if(($ckPosition=="office assistant" OR $log_emid=="610") AND $currPark==$parkList)
				{
				$ck_office_assit=strtolower(substr($jobtitle,0,16));
				$perCA=$varCA;
				$perWP=$varWP;
				@$perWPB=$varWPB;
				if($ck_office_assit=="office assistant" AND $emid!=$log_emid)
					{
					$perCA="";$perWP="";$perWPB="";
					}
				if(strtolower($jobtitle)=="park superintendent")
					{
					$perCA="";$perWP="";$perWPB="";
					}
				}	
			
				if($log_emid=="223" AND $emid!=$log_emid) //Denise Marquez
					{
					$perCA="";$perWP="";$perWPB="";
					}
			}
		
				if($log_emid==179) // Lee Amos wanted a reduced list)
					{
					$perCA="";$perWP="";$perWPB="";
					}
			
				if(@in_array($beacon_num,$superviseArray)){
					$perCA="<td>[<a href='compAssess.php?submit=pdf&emid=$emid&emidSalted=$emidSalted'>Comp. Assess.</a>]</td>";
					$perWP="<td>[<a href='workPlan.php?submit=pdf&emid=$emid&emidSalted=$emidSalted'>Completed 2014 VIP</a>]</td>";
		//			$perWPB="<td>[<a href='workPlan_vip.php?submit=pdf&emid=$emid&emidSalted=$emidSalted' target='_blank'>VIP Link</a>]</td>";
					}	
				
				
		if($level>1){
		if($_SESSION['logemid']==$emid || $level>2)
			{
			$perCA="<td>[<a href='compAssess.php?submit=pdf&emid=$emid&emidSalted=$emidSalted'>Comp. Assess.</a>]</td>";  $passCA=$perCA;
			$perWP="<td>[<a href='workPlan.php?submit=pdf&emid=$emid&emidSalted=$emidSalted'>Completed 2014 VIP</a>]</td>"; $passWP=$perWP;
		//	$perWPB="<td>[<a href='workPlan_vip.php?submit=pdf&emid=$emid&emidSalted=$emidSalted' target='_blank'>VIP Link</a>]</td>"; $passWPB=$perWPB;
			
			if($level==3)  // This locks most Raleigh office folks into just their supervisor positions
				{
				@$supervise_array=explode(",",$_SESSION['divper']['supervise']); // employees
				$supervise_array[]=$_SESSION['beacon_num']; // supervisor
				if(!in_array($beacon_num,$supervise_array))
					{$perCA="";$perWP="";$perWPB="";}
				if($_SESSION['beacon_num']=="60033165")  // Workaround for Dowdy while SODI DISU position is vacant
					{
					$parkList="SODI";// Get district
					$da=${"array".$parkList};
					if(in_array($parkS,$da))
						{$perCA=$passCA;$perWP=$passWP;$perWPB=$passWPB;}
					}
				}			
			}
			
		
		if($level==2)
			{
			
			$emidSalted=md5($emid.$salt);
			$arrayARCH[]=""; // needed to suppress warnings for Headquarters staff
			$parkList=$_SESSION['divper']['selectR'];// Get district
			if($parkList!="FOSC")
				{
				$da=${"array".$parkList}; //print_r($da);
				if(in_array($currPark,$da))
					{
					$perCA="<td>[<a href='compAssess.php?submit=pdf&emid=$emid&emidSalted=$emidSalted'>Comp. Assess.</a>]</td>";
					$perWP="<td>[<a href='workPlan.php?submit=pdf&emid=$emid&emidSalted=$emidSalted'>Completed 2014 VIP</a>]</td>";
				//	$perWPB="<td>[<a href='workPlan_vip.php?submit=pdf&emid=$emid&emidSalted=$emidSalted' target='_blank'>VIP Link</a>]</td>";
					}
				}
			
			if(strtolower($jobtitle)=="parks district superintendent" AND $ckPosition!="parks district superintendent"){$perCA="";$perWP="";$perWPB="";}
			}
		}
		
		// removed --> || $_SESSION[divper]['loginS']=="DIST"
		if($_SESSION['divper']['loginS']=="ADMIN" || $_SESSION['divper']['loginS']=="SUPERADMIN")
			{
			$ad1="<td><a href='formEmpInfo_dist.php?submit=Find&emid=$emid&p=y'>Personal Info</a></td>";
			$ad2="<td><a href='formPosInfo.php?beaconNumPass=$beacon_num&submit=Find&emid=$emid&p=y'>Position Info</a></td>";}else
			{
			$ad1="<td>BEACON Employee ID Number: $beaconID</td>";
			$ad2="";
			}
		
		$ad3="<td><a href='getPhoto.php?submit=Find&tempID=$tempID' target='_blank'>Photo</a></td>$contactInfo";

		if($_SESSION['divper']['level']>4)
			{
			$beacon_num="<td>[<a href='manage_access.php?emid=$emid' target='_blank'>$beacon_num</a>]</td>";
			}
		echo "<tr><td align='right'>$z - </td><td>$Lname, $Fname $NN- $jobtitle - BEACON Position Number: $beacon_num</td>
		$ad1
		$ad2
		$ad3
		$perCA
		$perWP
		$perWPB
		</tr>";
		$z++;}else{
	echo "<tr><td>$tempID</td>
	<td>A blank record, go ahead and remove it.</td>
	<td><a href='formEmpInfo_dist.php?submit=del&listid=$listid'>Remove</a></td></tr>";}
	} //  originally in a href below -->  
	echo "</form></table><hr>";
	//print_r($da);
	
// 	$where="nondpr.currPark ='$parkS' and add1!=''";
	$where="nondpr.currPark ='$parkS'";
	$sql = "SELECT nondpr.Fname, nondpr.Lname, 'Temp. Employee' as jobtitle,nondpr.currPark, email, wphone, nondpr.listid
	From nondpr 
	WHERE $where ORDER by Lname,Fname";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql" );
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	if(empty($ARRAY)){ECHO "No temporary employees entered."; exit;}
	$c=count($ARRAY);
	if($c>0)
		{
		echo "<table><tr><td colspan='3'>Temporary Employees at $parkS</td></tr>";
			foreach($ARRAY AS $index=>$array)
				{
				if($index==0)
					{
					echo "<tr>";
					foreach($ARRAY[0] AS $fld=>$value)
						{
						echo "<th>$fld</th>";
						}
					echo "</tr>";
					}
				echo "<tr>";
				foreach($array as $fld=>$value)
					{
					if($level>4 and $fld=="listid")
						{
						$value="<a href='https://10.35.152.9/divper/nondpr_users.php?edit=$value&submit=Submit'>$value</a>";
						}
					echo "<td>$value</td>";
					}
				echo "</tr>";
				}
			echo "</table>";	
			}
	echo "</body></html>";exit;
	}

// ***************SELECT Person by posNum**********
if(@$submit=="Submit" and @$posNumPass!="")
	{
	$where="emplist.posNum ='$posNumPass'";
	$sql = "SELECT tempID,emid
	From emplist
	WHERE $where";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
	//echo "$sql s=$submit p=$posNum"; exit;
	if($num==1)
		{
		$row=mysqli_fetch_array($result);
		extract($row);
		$sql = "SELECT empinfo.Nname, empinfo.Fname, empinfo.Lname, emplist.currPark, empinfo.ssn3, position.posTitle, position.beacon_num
		FROM empinfo
		LEFT  JOIN emplist ON emplist.tempID = empinfo.tempID
		LEFT  JOIN position ON emplist.posNum = position.posNum
		WHERE empinfo.tempID='$tempID'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		
		$row=mysqli_fetch_array($result);
		extract($row);
		$contactInfo="<td><A HREF='contactInfo.php?emid=$emid' target='_blank'>Contact Info</a></td>";
		
		echo "<table><tr><th colspan='9' align='center'>Permanent Employee for Position Number: <font color='purple'>$posNumPass</font> BEACON Number: $beacon_num</th></tr>";
		if($tempID){
		if($Nname){$NN="($Nname)";}else{$NN="";}
		echo "<tr><td align='right'>&nbsp;&nbsp;</td><td>$Lname, $Fname $NN</td><td align='center'>$ssn3</td><td> $currPark</td><td>$posTitle</td>";
		
		if($_SESSION[divper]['loginS']=="ADMIN" || $_SESSION[divper]['loginS']=="SUPERADMIN"){
		$ad1="<td><a href='formEmpInfo_dist.php?submit=Find&emid=$emid&p=y'>Personal Info</a></td>";
		$ad2="<td><a href='formPosInfo.php?beaconNumPass=$beacon_num&submit=Find&emid=$emid&p=y'>Position Info</a></td>";}else{
		$ad1="";$ad2="";}
		
		echo "<td>$ad1</td>
		<td>$ad2</td><td><a href='getPhoto.php?submit=Find&tempID=$tempID'>Photo</a></td>$contactInfo
		</tr>";
		}
		exit;
		}// end if $num=1
	else
		{
		echo "No employee was found for Position Number $posNumPass.";
		$sql = "SELECT * From position WHERE position.posNum ='$posNumPass'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$row=mysqli_fetch_array($result);extract($row);
		echo "<br /><br />This position is assigned to $park.<br /><br />BEACON Number: $beacon_num";
		exit;
		}
	
	
	echo "</table><hr>";
	echo "</body></html>";exit;
	}

// ***************SELECT Person by beaconNum**********
if(@$submit=="Submit" and @$beaconNumPass!="")
	{
	$where="emplist.beacon_num ='$beaconNumPass'";
	$sql = "SELECT tempID,emid
	From emplist
	WHERE $where";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
	//echo "$sql s=$submit p=$posNum"; exit;
	if($num==1)
		{
		$row=mysqli_fetch_array($result);
		extract($row);
		$sql = "SELECT empinfo.Nname, empinfo.Fname, empinfo.Lname, emplist.currPark, empinfo.ssn3, position.posTitle
		FROM empinfo
		LEFT  JOIN emplist ON emplist.tempID = empinfo.tempID
		LEFT  JOIN position ON emplist.beacon_num = position.beacon_num
		WHERE empinfo.tempID='$tempID'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	
		$contactInfo="<td><A HREF='contactInfo.php?emid=$emid' target='_blank'>Contact Info</a></td>";
	
		echo "<table><tr><th colspan='9' align='center'>Permanent Employee for BEACON Number: <font color='purple'>$beaconNumPass</font></th></tr>";
		$row=mysqli_fetch_array($result);
		extract($row);
		if($tempID)
			{
			if($Nname){$NN="($Nname)";}else{$NN="";}
			echo "<tr><td align='right'>&nbsp;&nbsp;</td><td>$Lname, $Fname $NN</td><td align='center'>$ssn3</td><td> $currPark</td><td>$posTitle</td>";
	
			if($_SESSION['divper']['loginS']=="ADMIN" || $_SESSION['divper']['loginS']=="SUPERADMIN"){
			$ad1="<td><a href='formEmpInfo_dist.php?submit=Find&emid=$emid&p=y'>Personal Info</a></td>";
			$ad2="<td><a href='formPosInfo.php?beaconNumPass=$beaconNumPass&submit=Find&emid=$emid&p=y'>Position Info</a></td>";}else{
			$ad1="";$ad2="";}
	
			echo "<td>$ad1</td>
			<td>$ad2</td><td><a href='getPhoto.php?submit=Find&tempID=$tempID'>Photo</a></td>$contactInfo
			</tr>";
			}
		exit;
		}// end if $num=1
	else
		{
		$sql = "SELECT t1.park, t1.posTitle_reg, t2.status, t2.lastEmp as 'Last Employee'
		FROM position as t1
		left join vacant as t2 on t1.beacon_num=t2.beacon_num
		WHERE t1.beacon_num='$beaconNumPass'"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		while($row=mysqli_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
		if($level>4)
			{
			echo "line 714 $sql<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
			}
		echo "No employee was found for BEACON Number $beaconNumPass.";exit;
		}
	
	
	echo "</table><hr>";
	echo "</body></html>";exit;
	}

// ***************SELECT either by emid or currPark**********
if(@$parkS !="" and @$submit=="")
	{
	$_SESSION['parkS']=$parkS;
	if(@$emid){$sql = "SELECT * From empinfo WHERE emid ='$emid'";
	//echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	header("Location: formEmpInfo_dist.php?submit=Find&emid=$emid");
	exit;}
	$sql = "SELECT DISTINCT CONCAT(divper.empinfo.Lname,divper.empinfo.ssn3) as tempID,divper.empinfo.emid,divper.emplist.listid,divper.empinfo.Lname,divper.empinfo.Fname,empinfo.Nname,divper.position.posTitle,divper.position.beacon_num
	From emplist 
	LEFT JOIN divper.empinfo on divper.emplist.emid=divper.empinfo.emid
	LEFT JOIN divper.position on divper.emplist.beacon_num=divper.position.beacon_num
	WHERE divper.emplist.currPark ='$parkS' ORDER by Lname,Fname";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	//echo "$sql"; exit;
	
	
include("../../include/get_parkcodes_dist.php");
$parkCodeName['PRTF']="Parks and Recreation Trust Fund";
if(!isset($parkS)){$parkS="";}

echo "<font size='5' color='blue'>Personnel at $parkCodeName[$parkS]
</font><br><form method='post' action='formEmpInfo_dist.php'>";

	echo "<select name='parkS' onChange=\"MM_jumpMenu('parent',this,0)\">";         
	foreach($parkCode as $k=>$scode)
		{
		if($scode==$parkS){$s="selected";}else{$s="value";}
	echo "<option $s='formEmpInfo_dist.php?parkS=$scode'>$scode\n";
			  }
	echo "</select></form>";
	
	if(!isset($varT)){$varT="";}
	echo "<table border='1' cellspacing='5' cellpadding='3'><tr><th colspan='6'>List of Permanent Employees for $parkS $varT</th></tr>";
	$z=1;
	while ($row=mysqli_fetch_array($result))
		{
		extract($row);
		$contactInfo="<td><A HREF='contactInfo.php?emid=$emid' target='_blank'>Contact Info</a></td>";
		
		if($tempID)
			{ // removed --> || $_SESSION[divper]['loginS']=="DIST"
			if($_SESSION['divper']['loginS']=="ADMIN" || $_SESSION['divper']['loginS']=="SUPERADMIN"){
			$ad1="<td><a href='formEmpInfo_dist.php?submit=Find&emid=$emid&p=y'>Personal Info</a></td>";
			$ad2="<td><a href='formPosInfo.php?beaconNumPass=$beacon_num&submit=Find&emid=$emid&p=y'>Position Info</a></td>";}else{
			$ad1="";$ad2="";}
			$ad3="<td><a href='getPhoto.php?submit=Find&tempID=$tempID' target='_blank'>Photo</a></td>$contactInfo";
			
			if($Nname){$NN="($Nname)";}else{$NN="";}
			if($beacon_num){$PN=" [$beacon_num]";}else{$PN="";}
			echo "<tr><td align='right'>$z</td><td>$Lname, $Fname $NN</td><td>$posTitle $PN</td>
			$ad1
			$ad2
			$ad3
			</tr>";
			$z++;
			}
			else
			{
			echo "<tr><td>$tempID</td>
			<td>A blank record, go ahead and remove it.</td>
			<td><a href='formEmpInfo_dist.php?submit=del&listid=$listid'>Remove</a></td></tr>";
			}
		} //  originally in a href below -->  
	echo "</table><hr>";
	echo "</body></html>";exit;
	}


// ***** Process input  ******************************************************
if(!$submit){$_SESSION['v']="";} // v tracks update success

// *********************** Remove name from park list of emp
$val = strpos($submit, "del");
if($val > -1)
	{// strpos returns 0 if del starts as first character
	/*
	$sql = "UPDATE emplist SET `currPark`='' WHERE `listid`='$listid'";
	$result = mysqli_query($sql) or $sql = "DELETE FROM emplist WHERE `listid`='$listid'";
	*/
	$sql = "DELETE FROM emplist WHERE `listid`='$listid'";
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");;
	header("Location: formEmpInfo_dist.php");
	exit;
	}
		// *********************** Update
$val = strpos($submit, "Update");
if($val > -1)
	{  // strpos returns 0 if Update starts as first character
	if(!isset($disableArray)){$disableArray=array();}
	if (in_array("m", $disableArray) and $otherDisable=="")
		{
		header("Location: formEmpInfo_dist.php?submit=Find&emid=$emid&e=1");
		exit;
		}
	
// 	echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
	
	/*
	if($disableArray[12] != "" and $otherDisable==""){
	echo "You must specify Other Disablility";exit;}
	if(!$Fname){$message="You must enter a First Name.<br>";}
	if(!$Lname){$message.="You must enter a Last Name.<br>";}
	if(!$add1){$message.="You must enter a Street Address.<br>";}
	if(!$dbyear or !$dbmonth or !$dbday){$message.="You must enter a complete Date of Birth.<br>";}
	if(!$city){$message.="You must enter a City.<br>";}
	if(!$state){$message.="You must enter a State.<br>";}
	if(!$zip){$message.="You must enter a Zip Code.<br>";}
	*/
	if(!$ssn1){$message.="You must enter a Complete SSN.<br>";}
	if(!$ssn2){$message.="You must enter a Complete SSN.<br>";}
	if(!$ssn3){$message.="You must enter a Complete SSN.<br>";}
	//if(!$race){$message.="Select the appropriate Race radio button.<br>";}
	
	$formType="Update";
	
	$countycode=str_pad($countycode, 3, "0", STR_PAD_LEFT);
	
	@$varDisable=array($disableArray[0],$disableArray[1],$disableArray[2],
	$disableArray[3],$disableArray[4],$disableArray[5],
	$disableArray[6],$disableArray[7],$disableArray[8],
	$disableArray[9],$disableArray[10],$disableArray[11],
	$disableArray[12],$otherDisable);
	$arrayImplode=implode("*",$varDisable);
	
	@$varSkill=array($skillArray[0],$skillArray[1],$skillArray[2],
	$skillArray[3],$skillArray[4],$skillArray[5],
	$skillArray[6],$skillArray[7],$skillArray[8],
	$skillArray[9],$otherLang,$otherType,$otherShort,$otherSkill);
	$arrayImplodeSkill=implode("*",$varSkill);
	
	// Required field not completed - show message
	if(isset($message))
	//$Lname=urlencode($Lname);
	{	reshowForm($message,$Nname,$Fname,$Mname,$Lname,$suffix,$add1,$add2,$city,$state,$zip,$countycode,$sex,$handicap,$over40,$milser, $serhon,$serdis,$ssn1,$ssn2,$ssn3,$race,$formType,$emid,$cert,$cpr,$arrayImplode,$otherDisable,$dbmonth,$dbday,$dbyear,$phone,$msenter,$msexit,$msbran,$msrank,$milres,$milrestext,$radio_call_number,$sch1b,$sch1c,$sch1d,$sch1e,$sch1f,$sch2a,$sch2b,$sch2c,$sch2d,$sch2e,$sch2f,$sch3a,$sch3b,$sch3c,$sch3d,$sch3e,$sch3f,$sch4a,$sch4b,$sch4c,$sch4d,$sch4e,$sch4f,$success,$drivenum,$drivestate,$chaunum,$cdl_exp_date,$car,$arrayImplodeSkill,$recom,$refer,$p,$heightFt,$heightIn,$weight,$eyes,$hair,$beaconID);
	exit;
	} // shows Entry form with submitted variables passed to function
	
	if(!$emid=="")
		{
		$Lname=addslashes($Lname);// needed for O'Toole
		$Fname=addslashes($Fname);// needed for O'Kelly
		//$height=addslashes($height);// needed for 5' 10"
		
		$tempID=$Lname.$ssn3;
		@$sql = "UPDATE empinfo SET `Nname`='$Nname',`Fname`='$Fname',`Mname`='$Mname',`Lname`='$Lname',`suffix`='$suffix',
		`add1`='$add1',`add2`='$add2',`city`='$city',`state`='$state',`zip`='$zip',
		`countycode`='$countycode',`ssn1`='$ssn1',`ssn2`='$ssn2',`ssn3`='$ssn3',`sex`='$sex',`over40`='$over40',`handicap`='$handicap',`race`='$race',`cert`='$cert',`cpr`='$cpr',`dbyear`='$dbyear',`dbmonth`='$dbmonth',`dbday`='$dbday',`phone`='$phone',`milser`='$milser',`serhon`='$serhon',`serdis`='$serdis',`msenter`='$msenter',`msexit`='$msexit',`msbran`='$msbran',`msrank`='$msrank',`milres`='$milres',`milrestext`='$milrestext',`radio_call_number`='$radio_call_number',`sch1b`='$sch1b',`sch1c`='$sch1c',`sch1d`='$sch1d',`sch1e`='$sch1e',`sch1f`='$sch1f',`sch2a`='$sch2a',`sch2b`='$sch2b',`sch2c`='$sch2c',`sch2d`='$sch2d',`sch2e`='$sch2e',`sch2f`='$sch2f',`sch3a`='$sch3a',`sch3b`='$sch3b',`sch3c`='$sch3c',`sch3d`='$sch3d',`sch3e`='$sch3e',`sch3f`='$sch3f',`sch4a`='$sch4a',`sch4b`='$sch4b',`sch4c`='$sch4c',`sch4d`='$sch4d',`sch4e`='$sch4e',`sch4f`='$sch4f',`drivenum`='$drivenum',`drivestate`='$drivestate',`chaunum`='$chaunum',`cdl_exp_date`='$cdl_exp_date',`car`='$car',`recom`='$recom',`refer`='$refer',`tempID`='$tempID',`heightFt`='$heightFt',`heightIn`='$heightIn',`weight`='$weight',`eyes`='$eyes',`hair`='$hair',`beaconID`='$beaconID'
		WHERE emid='$emid'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		
		$Lname=stripslashes($Lname);
		$rep=str_replace("'", "-", $Lname);
		$tempID=$rep.$ssn3;
		
		$sql = "UPDATE emplist SET `tempID`='$tempID'
		WHERE `emid`='$emid'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		
		
		// Check to see if Disability record exists
// 		$sql = "SELECT emid from empdisable where emid='$emid'";
// 		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
// 		$num=mysqli_num_rows($result);
// 		if($num==1)
// 			{
// 			@$sql = "UPDATE empdisable SET `a`='$disableArray[0]',`b`='$disableArray[1]',`c`='$disableArray[2]',
// 			`d`='$disableArray[3]',`e`='$disableArray[4]',`f`='$disableArray[5]',
// 			`g`='$disableArray[6]',`h`='$disableArray[7]',`i`='$disableArray[8]',
// 			`j`='$disableArray[9]',`k`='$disableArray[10]',`l`='$disableArray[11]',
// 			`m`='$disableArray[12]',`otherDisable`='$otherDisable'
// 			WHERE emid='$emid'";
// 			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
// 			}
// 			else
// 			{
// 			@$sql = "INSERT INTO empdisable SET `a`='$disableArray[0]',`b`='$disableArray[1]',`c`='$disableArray[2]',
// 		`d`='$disableArray[3]',`e`='$disableArray[4]',`f`='$disableArray[5]',
// 		`g`='$disableArray[6]',`h`='$disableArray[7]',`i`='$disableArray[8]',
// 		`j`='$disableArray[9]',`k`='$disableArray[10]',`l`='$disableArray[11]',
// 		`m`='$disableArray[12]',`otherDisable`='$otherDisable',emid='$emid'";
// 		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");}
		
		@$sql = "UPDATE empskill SET `a`='$skillArray[0]',`b`='$skillArray[1]',`c`='$skillArray[2]',
		`d`='$skillArray[3]',`e`='$skillArray[4]',`f`='$skillArray[5]',
		`g`='$skillArray[6]',`h`='$skillArray[7]',`i`='$skillArray[8]',
		`m`='$skillArray[9]',`otherLang`='$otherLang',`otherType`='$otherType',
		`otherSkill`='$otherSkill',`otherShort`='$otherShort'
		WHERE emid='$emid'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		
		if(!isset($v)){$v="";}
		switch ($v) {
				case "1":
					$_SESSION['v']=2;break;	
				case "2":
					$_SESSION['v']=1;break;	
				default:
					$_SESSION['v']=1;
			}
		header("Location: formEmpInfo_dist.php?v=$_SESSION[v]&submit=Find&emid=$emid");
		exit;
			}// end if !$emid==""
	} // end Update


// ************  Add Existing Person to New Park
$val = strpos($submit, "add");
if($val > -1){  // strpos returns 0 if add starts as first character
$sql = "SELECT emid FROM empinfo WHERE `tempID`='$tempID'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result); extract($row);
$sql = "REPLACE emplist SET `currPark`='$parkS',`tempID`='$tempID',`emid`='$emid'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
header("Location: formEmpInfo_dist.php");
exit;}

// ************  New Entry
$val = strpos($submit, "Enter");
if($val > -1){  // strpos returns 0 if Enter starts as first character
/*
if($disableArray[12] != "" and $otherDisable==""){
echo "You must specify Other Disablility";exit;}
*/
if(!isset($message)){$message="";

if(!$Fname){$message="You must enter a First Name.<br>";}
if(!$Lname){$message.="You must enter a Last Name.<br>";}
/*
if(!$add1){$message.="You must enter a Street Address.<br>";}
if(!$dbyear or !$dbmonth or !$dbday){$message.="You must enter a complete Date of Birth.<br>";}
if(!$city){$message.="You must enter a City.<br>";}
if(!$state){$message.="You must enter a State.<br>";}
if(!$zip){$message.="You must enter a Zip Code.<br>";}
*/
//if(!$ssn1){$message.="You must enter a Complete SSN.<br>";}
//if(!$ssn2){$message.="You must enter a Complete SSN.<br>";}
if(!$ssn3){$message.="You must the last four-digits of their SSN.<br>";}

if(!isset($race)){$race="";}

$countycode=str_pad($countycode, 3, "0", STR_PAD_LEFT);
}
if($message)
	{
	@reshowForm($message,$parkS,$Nname,$Fname,$Mname,$Lname,$suffix, $add1,$add2,$city,$state,$zip,$countycode,$sex,$handicap,$over40,$milser, $serhon,$serdis,$ssn1,$ssn2,$ssn3,$race,$formType,$emid,$cert,$cpr,$arrayImplode,$otherDisable,$dbmonth,$dbday,$dbyear,$phone,$msenter,$msexit,$msbran,$msrank,$milres,$milrestext,$radio_call_number,$sch1b,$sch1c,$sch1d,$sch1e,$sch1f,$sch2a,$sch2b,$sch2c,$sch2d,$sch2e,$sch2f,$sch3a,$sch3b,$sch3c,$sch3d,$sch3e,$sch3f,$sch4a,$sch4b,$sch4c,$sch4d,$sch4e,$sch4f,$drivenum,$drivestate,$chaunum,$cdl_exp_date,$car,$arrayImplodeSkill,$recom,$refer,$heightFt,$heightIn,$weight,$eyes,$hair,$beaconID);
	exit;
	} 

// shows Entry form with submitted variables passed to function
$rep=str_replace("'", "", $Lname);
$tempID=$rep.$ssn3;
$LnameS=addslashes($Lname);
$FnameS=addslashes($Fname);
//$height=addslashes($height);
$sql = "INSERT INTO empinfo SET `Nname`='$Nname',`Fname`='$Fname',`Mname`='$Mname',`Lname`='$LnameS',`suffix`='$suffix',
`add1`='$add1',`add2`='$add2',`city`='$city',`state`='$state',`zip`='$zip',
`countycode`='$countycode',`ssn1`='$ssn1',`ssn2`='$ssn2',`ssn3`='$ssn3',`sex`='$sex',`over40`='$over40',`handicap`='$handicap',`race`='$race',`cert`='$cert',`cpr`='$cpr',`dbyear`='$dbyear',`dbmonth`='$dbmonth',`dbday`='$dbday',`phone`='$phone',`milser`='$milser',`serhon`='$serhon',`serdis`='$serdis',`msenter`='$msenter',`msexit`='$msexit',`msbran`='$msbran',`msrank`='$msrank',`milres`='$milres',`milrestext`='$milrestext',`radio_call_number`='$radio_call_number',`sch1b`='$sch1b',`sch1c`='$sch1c',`sch1d`='$sch1d',`sch1e`='$sch1e',`sch1f`='$sch1f',`sch2a`='$sch2a',`sch2b`='$sch2b',`sch2c`='$sch2c',`sch2d`='$sch2d',`sch2e`='$sch2e',`sch2f`='$sch2f',`sch3a`='$sch3a',`sch3b`='$sch3b',`sch3c`='$sch3c',`sch3d`='$sch3d',`sch3e`='$sch3e',`sch3f`='$sch3f',`sch4a`='$sch4a',`sch4b`='$sch4b',`sch4c`='$sch4c',`sch4d`='$sch4d',`sch4e`='$sch4e',`sch4f`='$sch4f',`drivenum`='$drivenum',`drivestate`='$drivestate',`chaunum`='$chaunum',`cdl_exp_date`='$cdl_exp_date',`car`='$car',`recom`='$recom',`refer`='$refer',`tempID`='$tempID'";
$result = mysqli_query($connection,$sql) or die ("A person has been previously entered with a Last Name of $Lname and last four digits of their SSN = $ssn3.<br><br>If you would like to add this person to the $parkS list of permanent employees, click <a href='formEmpInfo_dist.php?parkS=$parkS&submit=add&tempID=$tempID'>here</a>.<br><br>To view the previously entered employee info for $Lname$ssn3 click <a href='formEmpInfo_dist.php?parkS=$parkS&submit=&tempID=$tempID'>here</a>.");
$x = mysqli_insert_id($connection);// gets emid

/*    //  Populated emplist with a Park
$sql = "INSERT INTO emplist SET `currPark`='$_SESSION[parkS]',tempID='$tempID', `emid`='$x'";
*/
  //  Doesn't Populate emplist with a Park
$sql = "INSERT INTO emplist SET tempID='$tempID', `emid`='$x'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");

/*
$sql = "INSERT INTO empdisable SET `a`='$disableArray[0]',`b`='$disableArray[1]',`c`='$disableArray[2]',
`d`='$disableArray[3]',`e`='$disableArray[4]',`f`='$disableArray[5]',
`g`='$disableArray[6]',`h`='$disableArray[7]',`i`='$disableArray[8]',
`j`='$disableArray[9]',`k`='$disableArray[10]',`l`='$disableArray[11]',
`m`='$disableArray[12]',`emid`='$x',`otherDisable`='$otherDisable'";
// echo "$sql"; exit;
$result1 = mysqli_query($sql) or die ("Couldn't execute query. $sql"); 

$sql = "INSERT INTO empskill SET `a`='$skillArray[0]',`b`='$skillArray[1]',`c`='$skillArray[2]',
`d`='$skillArray[3]',`e`='$skillArray[4]',`f`='$skillArray[5]',
`g`='$skillArray[6]',`h`='$skillArray[7]',`i`='$skillArray[8]',
`m`='$skillArray[9]',`otherLang`='$otherLang',`otherType`='$otherType',
`otherSkill`='$otherSkill',`otherShort`='$otherShort',`emid`='$x'";
$result2 = mysqli_query($sql) or die ("Couldn't execute query. $sql");
*/

header("Location: formPosInfo.php?submit=Find&emid=$x&success=Employee Added");
// header("Location: formEmpInfo_dist.php?submit=Find&Lname=$Lname&success=Employee Added");
} // end Enter

//  ************Start Edit form after Find*************

// print_r($_SESSION);EXIT;
//print_r($_REQUEST);
$val = strpos($submit, "Find");
if($val > -1){  // strpos returns 0 if Find starts as first character
if(!$emid){
if($_SESSION[divper]['loginS']!= "ADMIN" AND $_SESSION[divper]['loginS']=="SUPERADMIN"){

		if($parkS){$p="and emplist.currPark='$parkS'";}
		if($not){$p="and emplist.currPark!='$parkS'";}

	}//end $loginS
/*
$sql = "SELECT * From emplist WHERE tempID LIKE '$Lname%' $p ORDER by tempID";
*/
/*
$sql = "SELECT emid,tempID,Fname,Lname From empinfo WHERE Lname LIKE \"$Lname%\" $p ORDER by tempID";
*/
$sql = "SELECT empinfo.emid,empinfo.tempID,empinfo.Fname,empinfo.Lname,emplist.currPark
From empinfo
LEFT JOIN emplist on empinfo.emid=emplist.emid
WHERE empinfo.Lname LIKE \"$Lname%\" $p ORDER by emplist.currPark,empinfo.Lname,empinfo.Fname";
//echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
$_SESSION[v]=""; 
if($num < 1){
if($_SESSION[divper]['loginS']=="ADMIN" || $_SESSION[divper]['loginS']=="SUPERADMIN"){$F="found";}else
	{if($prev){$F="found";}
	else{$F="found at $parkS";}
	}
echo "No employee with a last name of <b>$Lname</b>, or beginning with <b>$Lname</b>, was $F.";exit;} // end if $num<1
}// end1 !$emid
else
{$numFound=1;} //end2 !$emid

// Shows name(s) to potentially add to a Park
if(@$new=="y" and $num==1)
	{
	$row=mysqli_fetch_array($result); extract($row);
	$sql = "SELECT Fname,Lname,emid,tempID From emplist WHERE tempID = '$tempID'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
	if($num<1){
	$sql = "SELECT empinfo.emid,empinfo.tempID,empinfo.Fname,empinfo.Lname
	From empinfo
	WHERE empinfo.Lname LIKE \"$Lname%\" $p";}
	else{
	$sql = "SELECT empinfo.emid,empinfo.tempID,empinfo.Fname,empinfo.Lname,emplist.currPark
	From empinfo
	LEFT JOIN emplist on empinfo.emid=emplist.emid
	WHERE empinfo.Lname LIKE \"$Lname%\" $p";
	}
	//echo "$sql";
	echo "<table>";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	if($currPark==$_SESSION[parkStemp]){echo "<tr><td>$tempID - $Lname, $Fname is already listed for $currPark</td></tr>";
	//print_r($_SESSION);
	//echo "$sql";
	}
	else
	{
	if($currPark==""){$at=" is not currently assigned to a park.";}else{$at=" is currently at $currPark";}
	echo "<tr><td>$tempID - $Lname, $Fname  $at</td>
	<td><a href='formEmpInfo_dist.php?submit=Find&emid=$emid'>View/Edit</a></td>
	</tr><table>
	<tr><td><font size='3' color='green'>Change this person to $_SESSION[parkStemp]</font></td></tr><tr><td><form method='post' action='formEmpInfo_dist.php'>
	<input type='hidden' name='parkS' value='$_SESSION[parkStemp]'>
	<input type='hidden' name='emid' value='$emid'>
	<input type='hidden' name='tempID' value='$tempID'>
	<input type='submit' name='submit' value='add'></form></td></tr>";
	}
	echo "</table><hr>";
	exit;
	}

if($numFound==1)
	{
	$p="y";
	if($emid){$sql = "SELECT * From empinfo WHERE emid='$emid'";}else{
	$sql = "SELECT * From empinfo WHERE Lname LIKE '$Lname%' ORDER by Lname";}
	//echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if(@$_SESSION['v']==1){$success="<font color='red'>Update was successful.</font>";}
	if(@$_SESSION['v']==2){$success="<font color='green'>Again, the update was successful.</font>";}
	if(@$e==1){$success="<h2>Please specify the <font color='red'>Other Disability.</font></h2>";}
	$row=mysqli_fetch_array($result);
	extract($row);
	// get Disability info
	$arrayImplode=array();
// 	$sql = "SELECT * From empdisable WHERE emid='$emid'";
// 	$result1 = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
// 	$arrayImplode=mysqli_fetch_array($result1);
	// get Skill info - INSERT code added to allow previous employee entries to still work after the SKILL table and code was created
	$sql = "SELECT * From empskill WHERE emid='$emid'";
	$result2 = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result2);
	if($num>0){
	$arrayImplodeSkill=mysqli_fetch_array($result2);
	}
	else
	{
	$sql = "INSERT INTO empskill SET `emid`='$emid'";
	$result2 = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	$sql = "SELECT * From empskill WHERE emid='$emid'";
	$result2 = mysqli_query($connection,$sql) or die ("Couldn't execute query 2. $sql");
	$arrayImplodeSkill=mysqli_fetch_array($result2);
	}
	
	$formType="Found";
	$Lname=urlencode($Lname);// necessary for O'Neal
	$Fname=urlencode($Fname);// necessary for O'Kelly
	
	if(!isset($message)){$message="";}
	if(!isset($otherDisable)){$otherDisable="";}
	if(!isset($success)){$success="";}
	reshowForm($message,$currPark,$Nname,$Fname,$Mname,$Lname,$suffix,$add1,$add2,$city,$state,$zip,$countycode,$sex,$handicap,$over40,$milser,$serhon,$serdis,$ssn1,$ssn2,$ssn3,$race,$formType,$emid,$cert,$cpr,$arrayImplode,$otherDisable,$dbmonth,$dbday,$dbyear,$phone,$msenter,$msexit,$msbran,$msrank,$milres,$milrestext,$radio_call_number,$sch1b,$sch1c,$sch1d,$sch1e,$sch1f,$sch2a,$sch2b,$sch2c,$sch2d,$sch2e,$sch2f,$sch3a,$sch3b,$sch3c,$sch3d,$sch3e,$sch3f,$sch4a,$sch4b,$sch4c,$sch4d,$sch4e,$sch4f,$success,$drivenum,$drivestate,$chaunum,$cdl_exp_date,$car,$arrayImplodeSkill,$recom,$refer,$p,$heightFt,$heightIn,$weight,$eyes,$hair,$beaconID);
	exit;} // shows Entry form with submitted variables passed to function

if($num > 1){
//echo "$sql";
echo "<table>";
while ($row=mysqli_fetch_array($result))
{extract($row);
echo "<tr><td>$Lname, $Fname [$tempID] $currPark</td>
<td><a href='formEmpInfo_dist.php?submit=Find&emid=$emid'>View/Edit</a></td>
</tr><tr><td>Presently at $currPark</td></tr>
<tr><td><font size='3' color='green'>Change this person to $_SESSION[parkS]</font></td></tr><tr><td><form method='post' action='formEmpInfo_dist.php'>
<input type='hidden' name='parkS' value='$_SESSION[parkS]'>
<input type='hidden' name='tempID' value='$tempID'>
<input type='submit' name='submit' value='add'></form></td></tr>";
}
echo "</table>";exit;
}// end > 1
}// if $submit ="Find"


//  ************Start Blank Entry form*************
if($submit=="Add"){
reshowForm($message,$currPark); // shows blank form because no variables passed
}
// ************* Find unParked Personnel Function
function prevEmpForm()
{ // start prevEmpForm function
global $parkS;
echo "
<br><font size='2' color='blue'>Find any Previously Entered Div. Temp. Employee NOT Presently listed for $parkS
</font><br><form method='post' action='formEmpInfo_dist.php'>
<input type='text' size='35' name='Lname' value=''>
<input type='hidden' name='new' value='y'>
<input type='hidden' name='not' value='$parkS'>
<input type='submit' name='submit' value='Find Employee'></form>
<font size='2'>Enter all, or just beginning, of last name.</font><hr>";
}

// *************Entry Form Function
function reshowForm($message,$currPark,$Nname,$Fname,$Mname,$Lname,$suffix,$add1,$add2,$city,$state,$zip,$countycode,$sex,$handicap,$over40,$milser,$serhon,$serdis,$ssn1,$ssn2,$ssn3,$race,$formType,$emid,$cert,$cpr,$arrayImplode,$otherDisable,$dbmonth,$dbday,$dbyear,$phone,$msenter,$msexit,$msbran,$msrank,$milres,$milrestext,$radio_call_number,$sch1b,$sch1c,$sch1d,$sch1e,$sch1f,$sch2a,$sch2b,$sch2c,$sch2d,$sch2e,$sch2f,$sch3a,$sch3b,$sch3c,$sch3d,$sch3e,$sch3f,$sch4a,$sch4b,$sch4c,$sch4d,$sch4e,$sch4f,$success,$drivenum,$drivestate,$chaunum,$cdl_exp_date,$car,$arrayImplodeSkill,$recom,$refer,$p,$heightFt,$heightIn,$weight,$eyes,$hair,$beaconID)
	{ // start reshowForm function
	global $parkCode, $parkName,$p,$level ;
	
	$ID=$Lname.$ssn3;
	if($formType=="Update")
		{
		$disableArray=explode("*",$arrayImplode);
		$skillArray=explode("*",$arrayImplodeSkill);
		}
	else
		{
		$disableArray=$arrayImplode;
		$skillArray=$arrayImplodeSkill;
		}
//	 print_r($disableArray);  exit;
	
	$Lname=urldecode($Lname);
	$Fname=urldecode($Fname);
	echo "<font size='4' color='004400'>NC State Parks System Permanent Payroll</font>";
	if($state=="NC" or $state==""){$s="NC";}else{$s=$state;}
	if($message){$m="<font color='red' size='4'>Submission Failed:<br>$message</font>";}
	echo "
	<table><tr><td><font size='3' color='blue'>Employee Info</font>";
	//echo "<input type='button' value='Printable Version' onClick=\"location='formEmpInfoPrint.php?emid=$emid'\">";
	if(!isset($m)){$m="";}
	echo "<br>$m</td></tr>
	</table>";
	if($level>5)
		{echo "<form method='post' name='formEmpInfo' action='formEmpInfo_dist.php'>";}
		else
		{echo "<form method='post' name='formEmpInfo' action='formEmpInfo_dist.php' onsubmit=\"return checkBID();\">";}
	
	echo "$success
	<table>
	<tr><th colspan='8' align='center'>BEACON Employee ID Number<br />
	<input type='text' size='11' name='beaconID' value='$beaconID' ></th></tr>
	<tr><th>Nickname (optional)</th><th>First Name</th><th>MI</th><th>Last Name</th><th>Suffix</th></tr>
	<tr>
	<td align='center'>
	<input type='text' size='15' name='Nname' value=\"$Nname\"></td>
	<td align='center'>
	<input type='text' size='20' name='Fname' value=\"$Fname\"></td>
	<td>
	<input type='text' size='1' name='Mname' value='$Mname' maxlength='1'></td>
	<td align='center'>
	<input type='text' size='20' name='Lname' value=\"$Lname\"></td>
	<td align='center'>
	<input type='text' size='7' name='suffix' value='$suffix'></td></tr>
	</table>
	<table>
	<tr><th>Address 1</th><th>Address 2</th></tr>
	<tr><td align='center'>
	<input type='text' size='37' name='add1' value='$add1'></td>
	<td>
	<input type='text' size='37' name='add2' value='$add2'></td>
	<td align='center'></tr></table>
	<table><tr><th>City</th><th>State</th>
	<th>Zip</th><th>County Code</th></tr>
	<tr><td>
	<input type='text' size='37' name='city' value='$city'></td>
	<td align='center'>
	<input type='text' size='3' name='state' value='$s'></td>
	<td align='center'>
	<input type='text' size='7' name='zip' value='$zip'></td>
	<td align='center'>
	<input type='text' size='7' name='countycode' value='$countycode'></td>
	</tr></table>
	
	<table><tr><th colspan='3'>Date of Birth</th>
	<th>Phone</th></tr>
	<tr><td>Month
	<input type='text' size='3' name='dbmonth' value='$dbmonth'></td>
	<td align='center'>Day
	<input type='text' size='3' name='dbday' value='$dbday'></td>
	<td align='center'><font color='orange'>4-digit</font> Year
	<input type='text' size='5' name='dbyear' value='$dbyear'></td>
	<td align='center'>
	<input type='text' size='15' name='phone' value='$phone'></td></tr>
	</table>
	
	<table>
	<tr><th colspan='3'>Social Security Number</th>
	<th colspan='2' width='100'>Sex</th>
	<th colspan='2' width='100'>Handicap</th>
	<th width='100'>Over 40</th>
	<th width='50'>Height</th>
	<th width='50'>Weight</th>
	<th width='50'>Eyes</th>
	<th width='50'>Hair</th>
	</tr>
	<tr>
	
	<td align='center'>
	<input type='text' size='3' name='ssn1' value='xxx' maxlength='3'></td>
	<td align='center'>-
	<input type='text' size='2' name='ssn2' value='xx' maxlength='2'></td>";
	
	echo "
	<td>-<input type='text' size='4' name='ssn3' value='$ssn3' maxlength='4'></td>
	<td align='center'>";
	$checkf="";$checkm="";
	if($sex =="f"){$checkf="checked";}else{$checkm="checked";};echo"
	<td><input type='radio' name='sex' value='f' $checkf>Female<br>
	<input type='radio' name='sex' value='m' $checkm>Male</td>
	<td align='center'>";
	$checkHy="";$checkHn="";
	if($handicap =="y"){$checkHy="checked";}else{$checkHn="checked";}
	echo "
	<td><input type='radio' name='handicap' value='y' $checkHy>Yes<br><input type='radio' name='handicap' value='n' $checkHn>No</td>";
	
	$checkOy=""; $checkOn="";
	if($over40 =="y"){$checkOy="checked";}else{$checkOn="checked";}
	echo"
	<td><input type='radio' name='over40' value='y' $checkOy>Yes<br>
	<input type='radio' name='over40' value='n' $checkOn>No</td>";
	
	//$height=htmlentities($height);
	echo"
	<td>
	<input type='text' name='heightFt' value='$heightFt' size='3'> feet
	<input type='text' name='heightIn' value='$heightIn' size='3'> inches
	</td>
	<td><input type='text' name='weight' value='$weight' size='5'></td>";
	
	$eyeColor=array("green","blue","brown","hazel");
	$hairColor=array("brown","black","blonde","red","gray","bald");
	echo "<td><select name='eyes'>
			  <option selected></option>";
			  foreach($eyeColor as $k=>$v){
			  if($v==$eyes){$s="selected";}else{$s="value";}
			 echo "<option $s=$v>$v</option>";
			  }
		   echo "</select></td>";
	
	echo "<td><select name='hair'>
			  <option selected></option>";
			  foreach($hairColor as $k=>$v){
			  if($v==$hair){$s="selected";}else{$s="value";}
			 echo "<option $s=$v>$v</option>";
			  }
		   echo "</select></td>";
	
	
	echo"</tr></table>";
	
	echo "<div id=\"hide_this\" style=\"display: none\">";
	echo "<table>
	<tr><th width='75'>Military Service</th>
	<th width='85'>Served Honorably</th>
	<th width='85'>Service-connected Disability</th>
	<th colspan='2'>Qualifying Active Military Service</th>
	<th width='85'>Military Reserve Member</th>
	</tr>
	<tr>";
	$checkMSy="";$checkMSn="";
	if($milser =="y"){$checkMSy="checked";}else{$checkMSn="checked";};
	echo "<td><input type='radio' name='milser' value='y' $checkMSy>Yes<br>
	<input type='radio' name='milser' value='n' $checkMSn>No</td>";
	$checkSHy="";$checkSHn="";
	if($serhon =="y"){$checkSHy="checked";}else{$checkSHn="checked";};
	echo"
	<td><input type='radio' name='serhon' value='y' $checkSHy>Yes<br>
	<input type='radio' name='serhon' value='n' $checkSHn>No</td>";
	$checkSDy="";$checkSDn="";
	if($serdis =="y"){$checkSDy="checked";}else{$checkSDn="checked";};
	echo"
	<td><input type='radio' name='serdis' value='y' $checkSDy>Yes<br>
	<input type='radio' name='serdis' value='n' $checkSDn>No</td>";
	echo"
	<td>&nbsp;&nbsp;&nbsp;&nbsp;Entered: <input type='text' name='msenter' value='$msenter'><br>
	Separated: <input type='text' name='msexit' value='$msexit'></td>";
	echo"
	<td>Branch: <input type='text' name='msbran' value='$msbran'><br>
	&nbsp;&nbsp;&nbsp;Rank: <input type='text' name='msrank' value='$msrank'></td>";
	$checkMRy="";$checkMRn="";
	if($milres =="y"){$checkMRy="checked";}else{$checkMRn="checked";};
	echo"
	<td><input type='radio' name='milres' value='y' $checkMRy>Yes&nbsp;
	<input type='radio' name='milres' value='n' $checkMRn>No";
	echo "<br>Branch: <input type='text' name='milrestext' value='$milrestext'></td>";
	
	echo "</tr></table>
	<table border='1'>
	<tr><th width='35'>Race</th>
	<th>Disability</th>
	</tr>";
	
	$check1="";$check2="";$check3="";$check4="";$check5="";
	switch ($race) {
			case "1":
				$check1="checked";
				break;	
			case "2":
				$check2="checked";
				break;
			case "3":
				$check3="checked";
				break;
			case "4":
				$check4="checked";
				break;
			case "5":
				$check5="checked";
				break;	
		}
	echo "<tr>
	<td>
	<input type='radio' name='race' value='1' $check1> White<br>
	<input type='radio' name='race' value='2' $check2> African American<br>
	<input type='radio' name='race' value='3' $check3> Hispanic (Mexican, Puerto Rican, Cuban, Central or South American,<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;other Spanish origin regardless of race)            
	<br>
	<input type='radio' name='race' value='4' $check4> Asian (including Pacific Islander)<br>
	<input type='radio' name='race' value='5' $check5> Native American (including Alaskan native)<br>
	</td>";
	
$checkedA="";$checkedB="";$checkedC="";$checkedD="";$checkedE="";$checkedF="";
	$checkedG="";$checkedH="";$checkedI="";$checkedJ="";$checkedK="";$checkedL="";
	$checkedM="";
	
	if($_REQUEST['submit']=="Find"){$disableArray=array(" "=>" ");}
	
	if (in_array("a", $disableArray)) {$checkedA="checked";}
	if (in_array("b", $disableArray)) {$checkedB="checked";}
	if (in_array("c", $disableArray)) {$checkedC="checked";}
	if (in_array("d", $disableArray)) {$checkedD="checked";}
	if (in_array("e", $disableArray)) {$checkedE="checked";}
	if (in_array("f", $disableArray)) {$checkedF="checked";}
	if (in_array("g", $disableArray)) {$checkedG="checked";}
	if (in_array("h", $disableArray)) {$checkedH="checked";}
	if (in_array("i", $disableArray)) {$checkedI="checked";}
	if (in_array("j", $disableArray)) {$checkedJ="checked";}
	if (in_array("k", $disableArray)) {$checkedK="checked";}
	if (in_array("l", $disableArray)) {$checkedL="checked";}
	if (in_array("m", $disableArray)) {$checkedM="checked";}
	@$otherDisable=$disableArray['otherDisable'];
	echo"<td>
	<input type='checkbox' name='disableArray[]' value='a' $checkedA> None/Prefer not to report<br>
	<input type='checkbox' name='disableArray[]' value='b' $checkedB> Blind or severely visually impaired<br>
	<input type='checkbox' name='disableArray[]' value='c' $checkedC> Deaf or severely hearing impaired<br>
	
	<input type='checkbox' name='disableArray[]' value='d' $checkedD> Loss or limited use of arms and/or hands<br>
	<input type='checkbox' name='disableArray[]' value='e' $checkedE> Non-ambulatory (must use wheelchair)<br>
	<input type='checkbox' name='disableArray[]' value='f' $checkedF> Other orthopedic impairment (including amputation, arthritis, back injury, cerebral palsy, spinal bifida, etc.)<br>
	
	<input type='checkbox' name='disableArray[]' value='g' $checkedG> Respiratory impairment<br>
	<input type='checkbox' name='disableArray[]' value='h' $checkedH> Nervous system/Neurological disorder<br>
	<input type='checkbox' name='disableArray[]' value='i' $checkedI> Mentally restored<br>
	
	<input type='checkbox' name='disableArray[]' value='j' $checkedJ> Mental retardation<br>
	<input type='checkbox' name='disableArray[]' value='k' $checkedK> Learning Disability<br>
	<input type='checkbox' name='disableArray[]' value='l' $checkedL> Others (heart disease, diabetes, speech impairment)<br>
	<input type='checkbox' name='disableArray[]' value='m' $checkedM> Other (please specify)
	<input type='text' size='50' name='otherDisable' value='$otherDisable'></td></tr>
	<tr><th>Certification(s)</th><th>CPR and Dates Completed</th></tr>
	<tr align='center'>
	<td><textarea name='cert' cols='60' rows='5'>$cert</textarea></td>
	<td align='center'>
	<textarea name='cpr' cols='60' rows='5'>$cpr</textarea></td>
	</tr></table>";
	
	echo "<table border='1'><tr>
	<th>Schools</th>
	<th>Name and Location</th>
	<th>Dates Attended</th>
	<th>Grad?</th>
	<th>S/Q hrs.</th>
	<th>Major/Minor</th>
	<th>Type of degree</th>
	</tr>
	<tr>
	<td>High School</td>";
	
	// radio_call_number changed to radio_call_number
// 	echo "<td><textarea name='radio_call_number' cols='20' rows='2'>$radio_call_number</textarea></td>";
	echo "<td><textarea name='sch1b' cols='10' rows='2'>$sch1b</textarea></td>
	<td><textarea name='sch1c' cols='10' rows='2'>$sch1c</textarea></td>
	<td><textarea name='sch1d' cols='10' rows='2'>$sch1d</textarea></td>
	<td><textarea name='sch1e' cols='10' rows='2'>$sch1e</textarea></td>
	<td><textarea name='sch1f' cols='10' rows='2'>$sch1f</textarea></td>
	</tr>
	<tr>
	<td>College/Univ.</td>
	<td><textarea name='sch2a' cols='20' rows='2'>$sch2a</textarea></td>
	<td><textarea name='sch2b' cols='10' rows='2'>$sch2b</textarea></td>
	<td><textarea name='sch2c' cols='10' rows='2'>$sch2c</textarea></td>
	<td><textarea name='sch2d' cols='10' rows='2'>$sch2d</textarea></td>
	<td><textarea name='sch2e' cols='10' rows='2'>$sch2e</textarea></td>
	<td><textarea name='sch2f' cols='10' rows='2'>$sch2f</textarea></td>
	</tr>
	<tr><td>Graduate<br> or Professional</td>
	<td><textarea name='sch3a' cols='20' rows='2'>$sch3a</textarea></td>
	<td><textarea name='sch3b' cols='10' rows='2'>$sch3b</textarea></td>
	<td><textarea name='sch3c' cols='10' rows='2'>$sch3c</textarea></td>
	<td><textarea name='sch3d' cols='10' rows='2'>$sch3d</textarea></td>
	<td><textarea name='sch3e' cols='10' rows='2'>$sch3e</textarea></td>
	<td><textarea name='sch3f' cols='10' rows='2'>$sch3f</textarea></td>
	</tr>
	<tr><td>Other educ., voc. school,<br>internships, etc.</td>
	<td><textarea name='sch4a' cols='20' rows='2'>$sch4a</textarea></td>
	<td><textarea name='sch4b' cols='10' rows='2'>$sch4b</textarea></td>
	<td><textarea name='sch4c' cols='10' rows='2'>$sch4c</textarea></td>
	<td><textarea name='sch4d' cols='10' rows='2'>$sch4d</textarea></td>
	<td><textarea name='sch4e' cols='10' rows='2'>$sch4e</textarea></td>
	<td><textarea name='sch4f' cols='10' rows='2'>$sch4f</textarea></td>
	</tr>
	</table>";
	echo "</div>";
	
	echo "<table><tr>
	<td>Driver's License
	<input type='text' size='10' name='drivenum' value='$drivenum'></td>
	<td>State
	<input type='text' size='3' name='drivestate' value='$drivestate'></td>
	<td>CDL/Chauffeur's License
	<textarea name='chaunum' cols='20' rows='2'>$chaunum</textarea>
	<td>CDL Expiration Date
	<input type='text' name='cdl_exp_date' value='$cdl_exp_date' id=\"f_date_c\" size='12'>
<img src=\"/jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
		  onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" />
	</td></tr>";
echo "<script type=\"text/javascript\">
		Calendar.setup({
			inputField     :    \"f_date_c\",     // id of the input field
			ifFormat       :    \"%Y-%m-%d\",      // format of the input field
			button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
			align          :    \"Tl\",           // alignment (defaults to \"Bl\")
			singleClick    :    true
		});
	</script>";

	$checkCy="";$checkCn="";
	if($car =="y"){$checkCy="checked";}else{$checkCn="checked";};
	echo "<tr><td>Car for use at work:<input type='radio' name='car' value='y' $checkCy>Yes&nbsp;&nbsp;
	<input type='radio' name='car' value='n' $checkCn>No</td>
	</tr></table>";
	if (in_array("a", $skillArray)) {$skillA="checked";}
	if (in_array("b", $skillArray)) {$skillB="checked";}else{$skillArray['otherLang']="";}
	if (in_array("c", $skillArray)) {$skillC="checked";}
	if (in_array("d", $skillArray)) {$skillD="checked";}else{$skillArray['otherType']="";}
	if (in_array("e", $skillArray)) {$skillE="checked";}else{$skillArray['otherShort']="";}
	if (in_array("f", $skillArray)) {$skillF="checked";}
	if (in_array("g", $skillArray)) {$skillG="checked";}
	if (in_array("h", $skillArray)) {$skillH="checked";}
	if (in_array("i", $skillArray)) {$skillI="checked";}
	if (in_array("m", $skillArray)) {$skillM="checked";}else{$skillArray['otherSkill']="";}
	$otherLang=$skillArray['otherLang'];
	$otherType=$skillArray['otherType'];
	$otherShort=$skillArray['otherShort'];
	$otherSkill=$skillArray['otherSkill'];
	
	$skillA="";$skillB="";$skillC="";$skillD="";$skillE="";$skillF="";$skillG=""; $skillH="";$skillI="";$skillM="";
	
	echo "<div id=\"hide_this_also\" style=\"display: none\">";
	echo "<table><tr><td><b>Special Skills:</b></td></tr>
	<tr><td>
	<input type='checkbox' name='skillArray[]' value='a' $skillA> Sign language<br>
	<input type='checkbox' name='skillArray[]' value='b' $skillB> Foregin language (specify)  
	<input type='text' size='15' name='otherLang' value='$otherLang'><br>
	<input type='checkbox' name='skillArray[]' value='c' $skillC> Adding machine/calculator<br>
	
	<input type='checkbox' name='skillArray[]' value='d' $skillD> Typing (specify WPM) 
	<input type='text' size='10' name='otherType' value='$otherType'><br>
	<input type='checkbox' name='skillArray[]' value='e' $skillE> Shorthand/speedwriting (specify WPM)  
	<input type='text' size='10' name='otherShort' value='$otherShort'><br>
	<input type='checkbox' name='skillArray[]' value='f' $skillF> Legal transcription<br>
	
	<input type='checkbox' name='skillArray[]' value='g' $skillG> Medical transcription<br>
	<input type='checkbox' name='skillArray[]' value='h' $skillH> Braille<br>
	<input type='checkbox' name='skillArray[]' value='i' $skillI> Word processing<br>
	<input type='checkbox' name='skillArray[]' value='m' $skillM> Other (please specify)
	<input type='text' size='50' name='otherSkill' value='$otherSkill'></td>
	</tr></table>";
	echo "<table>
	<tr><td>Reason for, or against, recommending:</td></tr>
	<tr><td><textarea name='recom' cols='60' rows='3'>$recom</textarea></td>
	</tr>
	<tr><td>Referral Source:</td></tr>
	<tr><td><textarea name='refer' cols='60' rows='3'>$refer</textarea></td>
	</tr></table>";
	echo "</div>";
	
	if($formType=="Update" or $formType=="Found"){$t="Update";}else{$t="Enter";}
	echo "<table><tr><td>
	<input type='hidden' name='emid' value='$emid'>
	<input type='submit' name='submit' value='$t'></form></td></tr>";
	echo "</table></body></html>";
	} // end reshowForm function

?>
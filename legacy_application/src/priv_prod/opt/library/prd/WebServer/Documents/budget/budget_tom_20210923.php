<?php
//print_r($_REQUEST); exit;
//session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";EXIT;
// called from Secure Server login.php

//$level=5;

//ini_set('display_errors',1);

// 060520 ETG php7_upgrade
// $new_inlcude_path = '/opt/library/prd/WebServer/include';
$new_include_path = '/opt/library/prd/WebServer/include'; // spelling correction TEH_20200827
set_include_path(get_include_path() . PATH_SEPARATOR . $new_include_path);


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

extract($_REQUEST);
//if($tempID=='Bass3278')
//{	
//print_r($_REQUEST); //exit;
//}
session_start();
//emplist.posNum
$sql = "SELECT $database as 'level',t1.currPark,t2.Nname,t2.Fname,t2.Lname,t3.posTitle,t2.tempID,accessPark, t3.beacon_num,t3.rcc,t2.emid as ck_emid
FROM divper.emplist as t1
LEFT JOIN divper.empinfo as t2 on t2.emid=t1.emid
LEFT JOIN divper.position as t3 on t3.beacon_num=t1.beacon_num
WHERE t1.emid = '$emid'";

// echo "$sql";
// exit;


$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysql_errno() . ": " . mysqli_error());
$num = @mysqli_num_rows($result);
$row=mysqli_fetch_array($result);extract($row);
//echo "$num";exit;
if($num<1){
mysqli_select_db($connection, "divper"); // database 
$sql = "SELECT $db as 'level',divper.nondpr.currPark, divper.nondpr.Fname, divper.nondpr.Lname, divper.nondpr.tempID as new_tempID
FROM divper.nondpr 
WHERE nondpr.tempID = '$tempID'";
//echo "sql=$sql<br />";
$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysql_errno() . ": " . mysqli_error());
//echo "$sql"; //exit;
$num_nondpr = @mysqli_num_rows($result);
$row=mysqli_fetch_array($result);
$test=$row['currPark'];  //echo "t=$test";
$level=$row['level']; 
$tempID=$row['new_tempID']; 
include_once("../../include/get_parkcodes.php");

	if(in_array($test, $parkCode)){
		mysqli_select_db($connection, $database); // database 
		$sql = "SELECT rcc FROM center 
				WHERE parkCode = '$test'"; 
		$result1 = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysql_errno() . ": " . mysqli_error());
		$row=mysqli_fetch_assoc($result1);
		$rcc=$row['rcc']; //echo "s=$rcc";
		$level=$row['level'];
		}
if($num_nondpr<1)
	{
	echo "Access denied";exit;

	}




}

//if($tempID=='Cook4712'){echo "Hello Line 83. Where next?<br />. num_nondpr=$num_nondpr";}
//echo "r=$num_nondpr<pre>"; print_r($row); echo "</pre>id=$tempID";  exit;
//echo "$num<br />$emid";exit;
include("../../include/salt.inc"); // salt phrase
$ck_s=md5($salt.$ck_emid);

//if($tempID=='Bass3278')
//{	
//echo "<br />Line 103: $ck_s<br />"; exit;
//}



if($ck!=$ck_s AND $num_nondpr<1){exit;}

$posNum=@$beacon_num;
//if($emid=='876')
//{
//echo "<br />Line103<br />"; //exit;
//}
if($level>1)
	{
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['tempID'] = $tempID;
	$_SESSION[$db]['position'] = strtolower($posTitle);
	$_SESSION[$db]['posNum']=$posNum;
	$_SESSION[$db]['beacon_num']=$beacon_num;
		if($currPark=="ARCH"){$_SESSION[$db]['select']="ADM";
		$posOA=strpos(strtolower($posTitle),"office assistant");
		if($posOA !== false){$_SESSION[$db]['partf'] = "CONS";}
		}
		else
		{$_SESSION[$db]['select']=$currPark;}
		
		//NRC Seasonal Maria Cucurullo
		if($tempID== "Cucurullo1234")
		{
		$level = '4';
		$_SESSION[$db]['level'] = $level;
		$_SESSION[$db]['beacon_num'] = "60096024";
		//$_SESSION[$db]['select']="FALA";
		$_SESSION[$db]['select']="ADMI";
		} // a FA
		
		
		//DENR Auditor Joseph Debragga
		if($tempID== "debragga1235")
		{
		$level = '4';
		$_SESSION[$db]['level'] = $level;
		$_SESSION[$db]['beacon_num'] = "20150001";
		$_SESSION[$db]['select']="ADMI";
		} // a FA
		
		
	}
else
	{
				
		
	$level=0; // used to prevent most users from gaining access
	
	$_SESSION[$db]['tempID'] = $tempID;
	$_SESSION[$db]['select']=@$currPark;
	$_SESSION[$db]['posNum']=$posNum;
	$_SESSION[$db]['accessPark']=@$accessPark;
	$_SESSION[$db]['beacon_num']=@$beacon_num;
	// added on 09/21/14
	$_SESSION[$db]['position'] = strtolower($posTitle);
	//if($posNum=='09006'){// Lead I&E Spec.
	if(@$beacon_num=='60032780'){// Lead I&E Spec.
	$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";}
	
	//if($posNum=='09512'){// Concessions Enterprise Manager
	if(@$beacon_num=='60033162'){// Concessions Enterprise Manager
	$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";}
	
	
	if(@$beacon_num=='60033136'){// HR Supervisor
	$level = '1';
	$_SESSION[$db]['level'] = $level;
	}
	
	$posTitle=strtolower($posTitle);
		
	
	$suptString="law enforcement supervisor";
	$posSupt=strpos($posTitle,$suptString);
	if($posSupt !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";}
	
	$suptString="park ranger";
	$posSupt=strpos($posTitle,$suptString);
	if($posSupt !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";}	


	$suptString="park superintendent";
	$posSupt=strpos($posTitle,$suptString);
	if($posSupt !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";}
	
	$oaString="office assistant";
	$posOA=strpos($posTitle,$oaString);
	if($posOA !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";
	}
	
	$dsString="processing assistant";
	$posDS=strpos($posTitle,$dsString);
	if($posDS !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";}
	
	$dsString="administrative assistant";
	$posDS=strpos($posTitle,$dsString);
	if($posDS !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";}
	
	$dsString="administrative specialist";
	$posDS=strpos($posTitle,$dsString);
	if($posDS !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";}
	
	$oaString="technology support analyst";
	$posTSA=strpos($posTitle,$oaString);
	if($posTSA !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";}
	
	$dsString="art exhibit technician";
	$posAET=strpos($posTitle,$dsString);
	if($posAET !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report'][0]="prtf_center_budget";}
	
	$suptString="facility maintenance supv";
	$posFMS=strpos($posTitle,$suptString);
	if($posFMS !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";}
	
	$dsString="facility engineering spec";
	$posFES=strpos($posTitle,$dsString);
	if($posFES !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	if($Nname!=""){$Fname=$Nname;}
	$_SESSION[$db][manager]=strtolower($Fname."_".$Lname);
	$_SESSION[$db]['report'][]="prtf_center_budget";
	$_SESSION[$db]['report'][]="DPR_Contract_Balances";}
	
	$dsString="facility construction eng ii";
	$posFES=strpos($posTitle,$dsString);
	if($posFES !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	if($Nname!=""){$Fname=$Nname;}
	$_SESSION[$db][manager]="fac_con_eng";
	$_SESSION[$db]['report'][]="prtf_center_budget";
	$_SESSION[$db]['report'][]="DPR_Contract_Balances";}
	
	$dsString="community planner ii";
	$posFES=strpos($posTitle,$dsString);
	if($posFES !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	if($Nname!=""){$Fname=$Nname;}
	$_SESSION[$db][manager]=strtolower($Fname."_".$Lname);
	$_SESSION[$db]['report'][]="prtf_center_budget";
	$_SESSION[$db]['report'][]="DPR_Contract_Balances";}
	
	
	
	
	$dsString="maintenance mechanic i";
	$posMM=strpos($posTitle,$dsString);
	if($posMM !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";
	//$_SESSION[$db]['report'][]="prtf_center_budget";
	}
	
	
	
	
	$dsString="maintenance mechanic ii";
	$posMM=strpos($posTitle,$dsString);
	if($posMM !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";
	//$_SESSION[$db]['report'][]="prtf_center_budget";
	}
	
	$dsString="maintenance mechanic iii";
	$posMM=strpos($posTitle,$dsString);
	if($posMM !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";
	//$_SESSION[$db]['report'][]="prtf_center_budget";
	}
	
	
	$dsString="maintenance mechanic iv";
	$posMM4=strpos($posTitle,$dsString);
	if($posMM4 !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";
	//$_SESSION[$db]['report'][]="prtf_center_budget";
	}
	
	
	$dsString="mechanic";
	$posMM4=strpos($posTitle,$dsString);
	if($posMM4 !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";
	//$_SESSION[$db]['report'][]="prtf_center_budget";
	}
	
	$dsString="maintenance/construction supervisor i";
	$posMM4=strpos($posTitle,$dsString);
	if($posMM4 !== false){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";
	//$_SESSION[$db]['report'][]="prtf_center_budget";
	}
	
	
// echo "<pre>"; print_r($_SESSION); echo "</pre>";
	
	if($posTitle== "park chief naturalist"){$level = '1';
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['select']="INED";}
	


}
if($level==0)
{
$sql = "SELECT $db as 'level',divper.nondpr.currPark, divper.nondpr.Fname, divper.nondpr.Lname, divper.nondpr.tempID as new_tempID
FROM divper.nondpr 
WHERE nondpr.tempID = '$tempID'";
//if($emid=='876')
//{
echo "<br />Line 345: sql=$sql<br />";
//}
$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysql_errno() . ": " . mysqli_error());
//echo "$sql"; //exit;
$num_nondpr = @mysqli_num_rows($result);
$row=mysqli_fetch_array($result);
extract($row);//brings back max (end_date) as $end_date
if($currPark=='ARCH'){$currPark='ADMI';}
//if($emid=='876')
//{
//echo "<br />level=$level<br />";
//}
//echo "<br />currPark=$currPark<br />";
//echo "<br />new_tempID=$new_tempID<br />";
//exit;


$query0="select count(myreports_only) as 'myreports_user' from cash_handling_roles where tempid='$tempID'
         and myreports_only='y'
";
if($tempID=='Gardner8759')
{
echo "<br />Line 377: query0=$query0"; exit;
}
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);

if($myreports_user>0)	
{		
$level='1';
}	

/*
if($tempID== "Autry6219"){$level = '1';// 
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['beacon_num'] = "60033127";
	$_SESSION[$db]['select']="JORD";
	//$_SESSION[$db]['report']="park_project_balances";	
	}		
*/



}


if($level > 0)
{
$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['select'] = $currPark;
/*	
if($tempID== "Carter5486")   //added to TABLE=cash_handling_roles.  $page assigned on Line 1030  11/20/16
{
$_SESSION[$db]['beacon_num']="60096141";

}  

*/







}
else
{
echo "Access denied.<br />If Access required: Please Contact <a href=mailto:database.support@ncparks.gov'>database.support@ncparks.gov</a> and the DPR - Budget Office.";exit;}

	
	
	
	if($tempID== "Royall8845"){$level = '1';// a HARI employee
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['select']="HARI";

	if($tempID== "sigmon"){$level = '1';// a Temp OA with access
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['beacon_num'] = "20140003";
	$_SESSION[$db]['select']="SOMO";
	//$_SESSION[$db]['report']="park_project_balances";	
	}	
	
	if($tempID== "Buff1308"){$level = '1';// a Temp OA with access
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['beacon_num'] = "60095175";
	$_SESSION[$db]['select']="LAJA";
	//$_SESSION[$db]['report']="park_project_balances";
	}	


	
	
	if($tempID=="Haben5887") // a temp OA @ MEMI with access to park_projects
	{
		$level = '1';
		$_SESSION[$db]['level']=$level;
		$_SESSION[$db]['select']="MEMI";
		$_SESSION[$db]['beacon_num']="60095403";
		$_SESSION[$db]['report']="park_project_balances";
	}
	
	
	
	if($tempID== "Emerson5020"){$level = '1';// Maintenance Mechanic III @ MEMO
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['select']="GORG";
	$_SESSION[$db]['report']="park_project_balances";
	}
	
	
	
	
	if($tempID== "Taylor3946"){$level = '1';// Maintenance Mechanic III @ MEMO
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['select']="MEMO";
	$_SESSION[$db]['report']="park_project_balances";
	}

	}// end level = 1

if($level<1 and $num_nondpr<1)
	{
	echo "You do not have access privileges for this database [$db] $level for position $posTitle $beacon_num. Contact Tony Bass tony.p.bass@ncdenr.gov if you wish to gain access.<br><br>budget.php<br>t=$tempID<br />line 287";exit;
	}

$database=$db;


mysqli_select_db($connection, $database); // database 
$makeCenter="1280".$rcc;
$posTitle=ucwords($posTitle);
if(!isset($currPark)){$currPark="";}


//insert ignore added by tbass on 2/17/13. Whenever a User accessed Budget DB for the first time, there tempid will be added to Budget Table=tempid_centers. Line 310 update will provide additional info needed for Budget Table=tempid_centers

$sql = "insert ignore into tempid_centers(tempid)
        values('$tempID')";

 $result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysql_errno() . ": " . mysqli_error());


/*
$sql = "UPDATE tempid_centers set rcc='$rcc', center='$makeCenter', level='$level', currpark='$currPark', postitle='$posTitle', posnum='$posNum',  pcard_admin='$currPark' WHERE tempid = '$tempID'";
	//echo "$sql";exit;
	
*/
/*	
if($tempID=="King3993")
{
echo "<br />budget.php Line 938<br /><pre>";print_r($_SESSION);echo "</pre>";
echo "<br />makeCenter=$makeCenter<br />";

exit;	
}
*/
$sql = "UPDATE tempid_centers set rcc='$rcc', center='$makeCenter', level='$level', currpark='$currPark', postitle='$posTitle', posnum='$posNum',  pcard_admin='$currPark' WHERE tempid = '$tempID'";
	//echo "$sql";exit;	
	
	
$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysql_errno() . ": " . mysqli_error());


// added 1/26/16
$sql = "UPDATE tempid_centers
        set center='12802858', rcc='2858'
		where tempid='barnett8880' ";

$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysql_errno() . ": " . mysqli_error());


// added 10/26/15

$sql = "UPDATE tempid_centers,center_appropi_new
        set tempid_centers.new_center=center_appropi_new.new_center,
		    tempid_centers.center_code=center_appropi_new.parkcode,
    		tempid_centers.center_section=center_appropi_new.section	
		    where tempid_centers.center=center_appropi_new.old_center";
		
//echo "line 564 query=$sql"; exit;
$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysql_errno() . ": " . mysqli_error());

// added 10/26/15
/*
$sql = "SELECT new_center as 'center'
FROM tempid_centers WHERE tempid = '$tempID'";
*/

/*
if($tempID=='Wagner9210' or $tempID=='Dillard6097')
{
//echo "$tempID";
$sql = "SELECT center,new_center
FROM tempid_centers WHERE tempid = '$tempID'";

}
if($tempID!='Wagner9210' and $tempID!='Dillard6097')
{
$sql = "SELECT center
FROM tempid_centers WHERE tempid = '$tempID'";
}
*/


$sql = "SELECT center, new_center,center_code,center_section
FROM tempid_centers WHERE tempid = '$tempID'";




//echo "line 573 query=$sql"; exit;

$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysql_errno() . ": " . mysqli_error());
$row=mysqli_fetch_array($result);extract($row);
$_SESSION['budget']['centerSess']=$center;
$_SESSION['budget']['centerSess_new']=$new_center;
$_SESSION['budget']['center_code']=$center_code;
$_SESSION['budget']['center_section']=$center_section;

$us=$_SERVER['REMOTE_ADDR'];
$sql = "Insert into login set loginName='$tempID', loginTime=NOW(), userAddress='$us', level='$level'";
//echo "$sql";exit;
$result = @mysqli_query($connection, $sql) or die("$sql Error 1# c=$connection". mysql_errno() . ": " . mysqli_error());


$page="menu.php?forum=blank";
//echo "menu=$menu";exit;

// Don Reuter - Business Officer III
//if($_SESSION['budget']['beacon_num']=="60032779"){$page="menuAssistDirect.php";}
if($_SESSION['budget']['beacon_num']=="60032779"){$page="menu1314.php";}

// Brian Strong - Head Natural Resources
//if($_SESSION['budget']['beacon_num']=="60033160"){$page="menuNatRes.php";}
if($_SESSION['budget']['beacon_num']=="60033160"){$page="menu1314.php";}

// Sue Regier - Land Acquisition
//if($_SESSION['budget']['beacon_num']=="60032790"){$page="menuLandRes.php";}
//if($_SESSION['budget']['beacon_num']=="60032790"){$page="menu1314.php";}

// Carol Tingley-Deputy Director
//if($_SESSION['budget']['beacon_num']=="60033202"){$page="home.php";}
if($_SESSION['budget']['beacon_num']=="60033202"){$page="menu1314.php";}

// Tara Gallagher-Concession Manager
//if($_SESSION['budget']['beacon_num']=="60033162"){$page="home.php";}
if($_SESSION['budget']['beacon_num']=="60033162"){$page="menu1314.php";}

// Denise Williams-Chop Adiministrative Assistant
//if($_SESSION['budget']['beacon_num']=="60032920"){$page="home.php";}
if($_SESSION['budget']['beacon_num']=="60032920"){$page="menu1314.php";}

// Tammy Dodd-Administrative Officer III
//if($_SESSION['budget']['beacon_num']=="60032781"){$page="home.php";}
if($_SESSION['budget']['beacon_num']=="60032781"){$page="menu1314.php";}

// Jerry Howerton-Facility MaintManager I
//if($_SESSION['budget']['beacon_num']=="60033012"){$page="home.php";}
if($_SESSION['budget']['beacon_num']=="60033012"){$page="menu1314.php";}

// Tony Bass-Accounting Specialist I
//if($_SESSION['budget']['beacon_num']=="60032793"){$page="home.php";}
if($_SESSION['budget']['beacon_num']=="60032793"){$page="menu1314.php";}

//Sue Regier-Parks Resource Mgmt Spec
if($_SESSION['budget']['beacon_num']=="60032790"){$page="menu1314.php";}

// Siobhan Oneal-Curator of Exhibits Design
if($_SESSION['budget']['beacon_num']=="60032877"){$page="menu1314.php";}

// Kelly Chandler-Warehouse Office Assistant
//if($_SESSION['budget']['beacon_num']=="60033009"){$page="home.php";}
if($_SESSION['budget']['beacon_num']=="60032786"){$page="menu1314.php";}

// Jessie Summers (warehouse OA).  Added on 10/25/17
if($_SESSION['budget']['beacon_num']=="60033009"){$page="menu1314.php";}

// Mike Lambert-CHOP
//if($_SESSION['budget']['beacon_num']=="60033018"){$page="home.php";}
if($_SESSION['budget']['beacon_num']=="60033018"){$page="menu1314.php";}

// Rachel Gooding-Budget Office Accounting
//if($_SESSION['budget']['beacon_num']=="60032997"){$page="home.php";}
if($_SESSION['budget']['beacon_num']=="60032997"){$page="menu1314.php";}


// Rebecca Owen-Budget Office Accounting

if($_SESSION['budget']['beacon_num']=="60033242")
{
$_SESSION[$db]['select']="ADM";
$page="menu1314.php";
}

//if($_SESSION['budget']['beacon_num']=="60033242"){$page="menu1314.php";}





// Joanne Barbour-Budget Office
//if($_SESSION['budget']['beacon_num']=="60032791"){$page="home.php";}
if($_SESSION['budget']['beacon_num']=="60032791"){$page="menu1314.php";}

// Rod Bridges-Budget Office
//if($_SESSION['budget']['beacon_num']=="60036015"){$page="home.php";}
if($_SESSION['budget']['beacon_num']=="60036015"){$page="menu1314.php";}

//Jennifer Goss- Design and Development
if($_SESSION['budget']['beacon_num']=="60032787"){$page="menu1314.php";}

//Erin Lawrence- Design and Development
if($_SESSION['budget']['beacon_num']=="60032833"){$page="menu1314.php";}

//Jon Blanchard
if($_SESSION['budget']['beacon_num']=="60032828"){$page="menu1314.php";}

//Mike Murphy-Director
if($_SESSION['budget']['beacon_num']=="60032778"){$page="menu1314.php";}

//sean higgins
if($_SESSION['budget']['beacon_num']=="60032780"){$page="menu1314.php";}

//carl jeeter
if($_SESSION['budget']['beacon_num']=="60032945"){$page="menu1314.php";}


//keith bilger
if($_SESSION['budget']['beacon_num']=="60033189"){$page="menu1314.php";}

//martin kane
if($_SESSION['budget']['beacon_num']=="60092637"){$page="menu1314.php";}

//bryan dowdy
if($_SESSION['budget']['beacon_num']=="60033165"){$page="menu1314.php";}


//jan trask
if($_SESSION['budget']['beacon_num']=="60092634"){$page="menu1314.php";}


//rosalyn mcnair
if($_SESSION['budget']['beacon_num']=="60033136"){$page="menu1314.php";}

//teresa mccall
if($_SESSION['budget']['beacon_num']=="60032785"){$page="menu1314.php";}

//steve livingstone
if($_SESSION['budget']['beacon_num']=="60033138"){$page="menu1314.php";}

//adrienne eikinas
if($_SESSION['budget']['beacon_num']=="60032784"){$page="menu1314.php";}

//talivia brodie
if($_SESSION['budget']['beacon_num']=="60095522"){$page="menu1314.php";}

//charlie peek
if($_SESSION['budget']['beacon_num']=="60032788"){$page="menu1314.php";}


//scott crocker
if($_SESSION['budget']['beacon_num']=="60032942"){$page="menu1314.php";}


//catherine locke
if($_SESSION['budget']['beacon_num']=="60033137"){$page="menu1314.php";}


//cara hadfield
if($_SESSION['budget']['beacon_num']=="60033199"){$page="menu1314.php";}


if($_SESSION['budget']['beacon_num']=="60095488"){$page="menu1314.php";}


//jody reavis
if($_SESSION['budget']['beacon_num']=="65020599"){$page="menu1314.php";}
//dwayne parker
if($_SESSION['budget']['beacon_num']=="65020598"){$page="menu1314.php";}


//DENR Auditor  Joseph Debragga
if($tempID== "debragga1235"){$page="menu1314.php";}



//howard6319
if($tempID== "Howard6319"){$page="menu1314.php";}
/*
if($tempID== "Cucurullo1234")
{
echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;

}
*/
if($tempID== "Cucurullo1234"){$page="menu1314.php";}
//if($tempID== "money"){$page="home.php";}

//if($tempID== "brodie2030"){$page="menu1314.php";}

//if($tempID== "Knott"){$page="menu1314.php";}
//if($tempID== "Knott"){$page="infotrack/position_reports.php?menu=1";}
if($tempID== "Avery0475"){$page="infotrack/position_reports.php?menu=1";}
if($tempID== "Beeghly6343"){$page="infotrack/position_reports.php?menu=1";}
if($tempID== "Sanford5534"){$page="infotrack/position_reports.php?menu=1";}
if($tempID== "Hiatt1271"){$page="infotrack/position_reports.php?menu=1";}
//if($tempID== "Carter5486"){$page="infotrack/position_reports.php?menu=1";}

//Natural Resources Administration OA Lisa Benz. Changes select=PRTF to select=NARA
/*
if($_SESSION['budget']['beacon_num']=="60033242")
{
$_SESSION[$db]['select']="NARA";
}
*/

//Natural Resources Administration Accounting Clerk (Talivia Brodie-7/1/15)
if($_SESSION['budget']['beacon_num']=="60032794")
{
//$_SESSION[$db]['select']="NARA";
$page="menu1314.php";
}

//Resource Management Environmental Senior Spec  (Jon Blanchard)

if($_SESSION['budget']['beacon_num']=="60032828")
{
$_SESSION[$db]['select']="REMA";
}


//brian strong

if($_SESSION['budget']['beacon_num']=="60033160")
{
$_SESSION[$db]['select']="NARA";
}


//scott crocker

if($_SESSION['budget']['beacon_num']=="60032942")
{
$_SESSION[$db]['select']="STPA";
}















if($_SESSION['budget']['tempID']=="Howard6319")
{
$_SESSION[$db]['beacon_num'] = "20150002";
}


if($_SESSION['budget']['tempID']=="Grunder0429")
{
$_SESSION[$db]['beacon_num'] = "20200001";
}






if($_SESSION['budget']['tempID']=="Siler1222")
{
$_SESSION[$db]['tempID']="Deaton1222";
}






if($_SESSION['budget']['tempID']=="Barbour3953")
{
$_SESSION[$db]['tempID']="Hunt3953";
}


if($_SESSION['budget']['tempID']=="Rumble9889")
{
$_SESSION[$db]['tempID']="Rumble2030";
}
/*
if($_SESSION['budget']['tempID']=="Cook4712")
{
$_SESSION[$db]['tempID']="Greenwood3841";
}
*/
/*
if($_SESSION['budget']['tempID']=="Hadfield7628")
{
$_SESSION[$db]['tempID']="Mitchener8455";
}
*/
/*
if($_SESSION['budget']['tempID']=="Brown4109" and $_SESSION['logname']=='mitchener1234')
{
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$_SESSION[$db]['tempID']="Mitchener1234";
}
*/
/*
if($_SESSION['budget']['tempID']=="Quinn0398")
{
echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//$_SESSION[$db]['tempID']="Meeks1234";
}
*/
if($_SESSION['budget']['tempID']=="Meeks1234")
{

$_SESSION[$db]['level']="1";
$_SESSION[$db]['select']="CLNE";
$_SESSION[$db]['tempID']="Meeks1234";
$_SESSION[$db]['position']="office assistant v";
$_SESSION[$db]['posNum']="60032891";
$_SESSION[$db]['beacon_num']="60032891";
$_SESSION[$db]['centerSess']="12802807";
$_SESSION[$db]['centerSess_new']="1680514";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}


if($_SESSION['budget']['tempID']=="Davis1111")
{

$_SESSION[$db]['level']="2";
$_SESSION[$db]['select']="EADI";
$_SESSION[$db]['tempID']="Davis1111";
$_SESSION[$db]['position']="office assistant v";
$_SESSION[$db]['posNum']="60032892";
$_SESSION[$db]['beacon_num']="60032892";
$_SESSION[$db]['centerSess']="12802805";
$_SESSION[$db]['centerSess_new']="1680512";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}
















if($_SESSION['budget']['tempID']=="kendrick1234")
{

$_SESSION[$db]['level']="2";
$_SESSION[$db]['select']="EADI";
$_SESSION[$db]['tempID']="kendrick1234";
$_SESSION[$db]['position']="parks district superintendent";
$_SESSION[$db]['posNum']="60032912";
$_SESSION[$db]['beacon_num']="60032912";
$_SESSION[$db]['centerSess']="12802805";
$_SESSION[$db]['centerSess_new']="1680512";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}


if($_SESSION['budget']['tempID']=="Fullwood1234")
{

$_SESSION[$db]['level']="4";
$_SESSION[$db]['select']="ADM";
$_SESSION[$db]['tempID']="Fullwood1234";
$_SESSION[$db]['position']="chief of operations";
$_SESSION[$db]['posNum']="60033018";
$_SESSION[$db]['beacon_num']="60033018";
$_SESSION[$db]['centerSess']="12802801";
$_SESSION[$db]['centerSess_new']="1680508";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}


if($_SESSION['budget']['tempID']=="McElhone1111")
{

$_SESSION[$db]['level']="4";
$_SESSION[$db]['select']="ADM";
$_SESSION[$db]['tempID']="McElhone1111";
$_SESSION[$db]['position']="chief of operations";
$_SESSION[$db]['posNum']="60033018";
$_SESSION[$db]['beacon_num']="60033018";
$_SESSION[$db]['centerSess']="12802801";
$_SESSION[$db]['centerSess_new']="1680508";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}

/*
if($_SESSION['budget']['tempID']=="Owen1111")
{

$_SESSION[$db]['level']="4";
$_SESSION[$db]['select']="ADM";
$_SESSION[$db]['tempID']="Owen1111";
$_SESSION[$db]['position']="office assistant iv";
$_SESSION[$db]['posNum']="65027688";
$_SESSION[$db]['beacon_num']="65027688";
$_SESSION[$db]['centerSess']="12802903";
$_SESSION[$db]['centerSess_new']="1680571";
$_SESSION[$db]['partf']="CONS";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}

*/


if($_SESSION['budget']['tempID']=="Owen1111")
{

$_SESSION[$db]['level']="4";
$_SESSION[$db]['select']="ADM";
$_SESSION[$db]['tempID']="Owen1111";
$_SESSION[$db]['position']="office assistant iv";
$_SESSION[$db]['posNum']="60033242";
$_SESSION[$db]['beacon_num']="60033242";
$_SESSION[$db]['centerSess']="12802751";
$_SESSION[$db]['centerSess_new']="1680504";
//$_SESSION[$db]['partf']="CONS";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}













if($_SESSION['budget']['tempID']=="Livingstone1111")
{

$_SESSION[$db]['level']="4";
$_SESSION[$db]['select']="ADM";
$_SESSION[$db]['tempID']="Livingstone1111";
$_SESSION[$db]['position']="administrative assistant i";
$_SESSION[$db]['posNum']="60032920";
$_SESSION[$db]['beacon_num']="60032920";
$_SESSION[$db]['centerSess']="12802801";
$_SESSION[$db]['centerSess_new']="1680508";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}



















if($_SESSION['budget']['tempID']=="Woodruff1234")
{

$_SESSION[$db]['level']="2";
$_SESSION[$db]['select']="SODI";
$_SESSION[$db]['tempID']="Woodruff1234";
$_SESSION[$db]['position']="parks district superintendent";
$_SESSION[$db]['posNum']="60033019";
$_SESSION[$db]['beacon_num']="60033019";
$_SESSION[$db]['centerSess']="12802830";
$_SESSION[$db]['centerSess_new']="1680531";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}


if($_SESSION['budget']['tempID']=="Woodruff1111")
{

$_SESSION[$db]['level']="2";
$_SESSION[$db]['select']="NODI";
$_SESSION[$db]['tempID']="Woodruff1111";
$_SESSION[$db]['position']="parks district superintendent";
$_SESSION[$db]['posNum']="65030652";
$_SESSION[$db]['beacon_num']="65030652";
$_SESSION[$db]['centerSess']="12802901";
$_SESSION[$db]['centerSess_new']="1680569";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}


if($_SESSION['budget']['tempID']=="Coffey1111")
{

$_SESSION[$db]['level']="2";
$_SESSION[$db]['select']="WEDI";
$_SESSION[$db]['tempID']="Coffey1111";
$_SESSION[$db]['position']="parks district superintendent";
$_SESSION[$db]['posNum']="60032913";
$_SESSION[$db]['beacon_num']="60032913";
$_SESSION[$db]['centerSess']="12802850";
$_SESSION[$db]['centerSess_new']="1680541";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}


















if($_SESSION['budget']['tempID']=="Greenwood1111")
{

$_SESSION[$db]['level']="2";
$_SESSION[$db]['select']="NODI";
$_SESSION[$db]['tempID']="Greenwood1111";
$_SESSION[$db]['position']="parks district superintendent";
$_SESSION[$db]['posNum']="65030652";
$_SESSION[$db]['beacon_num']="65030652";
$_SESSION[$db]['centerSess']="12802901";
$_SESSION[$db]['centerSess_new']="1680569";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}







//310
if($_SESSION['budget']['tempID']=="Mitchener1111")
{

$_SESSION[$db]['level']="2";
$_SESSION[$db]['select']="NODI";
$_SESSION[$db]['tempID']="Mitchener1111";
$_SESSION[$db]['position']="office assistant v";
$_SESSION[$db]['posNum']="65030652";
$_SESSION[$db]['beacon_num']="65030652";
$_SESSION[$db]['centerSess']="12802901";
$_SESSION[$db]['centerSess_new']="1680569";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}








if($_SESSION['budget']['tempID']=="Evans12345")
{

$_SESSION[$db]['level']="2";
$_SESSION[$db]['select']="WEDI";
$_SESSION[$db]['tempID']="Evans12345";
$_SESSION[$db]['position']="office assistant v";
$_SESSION[$db]['posNum']="60032931";
$_SESSION[$db]['beacon_num']="60032931";
$_SESSION[$db]['centerSess']="12802850";
$_SESSION[$db]['centerSess_new']="1680541";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}

if($_SESSION['budget']['tempID']=="Hall1234")
{

$_SESSION[$db]['level']="4";
$_SESSION[$db]['select']="ADM";
$_SESSION[$db]['tempID']="Hall1234";
$_SESSION[$db]['position']="administrative assistant I";
$_SESSION[$db]['posNum']="60032920";
$_SESSION[$db]['beacon_num']="60032920";
$_SESSION[$db]['centerSess']="12802801";
$_SESSION[$db]['centerSess_new']="1680508";

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}










/*
if($_SESSION['budget']['tempID']=="Carter5486")
{

$_SESSION[$db]['level']="3";
$_SESSION[$db]['select']="ADMI";
$_SESSION[$db]['tempID']="Carter5486";
$_SESSION[$db]['position']="none";
$_SESSION[$db]['posNum']="20170913";
$_SESSION[$db]['beacon_num']="20170913";
$_SESSION[$db]['centerSess']="12802961";
$_SESSION[$db]['centerSess_new']="1680579";


//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;



}

*/


















/*
if($_SESSION['budget']['tempID']=="Brown4109" and $_SESSION['logname']!='mitchener1234')
{
//echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;
$_SESSION[$db]['select']="SODI";

}
*/


if($_SESSION['budget']['tempID']=="Brown4109")
{
//echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;
$_SESSION[$db]['select']="WIUM";
$_SESSION[$db]['level']="1";
$_SESSION[$db]['centerSess']="12802839";
$_SESSION[$db]['centerSess_new']="1680539";
$_SESSION[$db]['posNum']="60032894";
$_SESSION[$db]['beacon_num']="60032894";

}




if($_SESSION['budget']['tempID']=="summers1234")
{
//echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;
$_SESSION[$db]['select']="RARO";
$_SESSION[$db]['level']="1";
$_SESSION[$db]['centerSess']="12802835";
$_SESSION[$db]['centerSess_new']="1680536";
$_SESSION[$db]['posNum']="65009867";
$_SESSION[$db]['beacon_num']="65009867";

}


if($_SESSION['budget']['tempID']=="Carter5486")
{
//echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;
$_SESSION[$db]['select']="ADM";
$_SESSION[$db]['level']="5";
$_SESSION[$db]['centerSess']="12802953";
$_SESSION[$db]['centerSess_new']="1680574";
$_SESSION[$db]['posNum']="60032793";
$_SESSION[$db]['beacon_num']="60032793";

}








/*
if($_SESSION['budget']['tempID']=="Noel4543")
{
//echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;
$_SESSION[$db]['select']="SODI";
$_SESSION[$db]['centerSess']="12802830";
$_SESSION[$db]['centerSess_new']="1680531";

}
*/

//if($_SESSION['budget']['tempID']=="Becker7900")
if($_SESSION['budget']['tempID']=="Bischof7900")
{
$_SESSION[$db]['select']="WEDI";
}

/*
if($_SESSION['budget']['beacon_num']=="60032780")
{
$_SESSION[$db]['center_code']="INED";

}
*/


$query0="select count(myreports_only) as 'myreports_user' from cash_handling_roles where tempid='$tempID'
         and myreports_only='y'
";

if($tempID=='Gardner8759')
{
echo "<br />Line 1544: query0=$query0"; //exit;
}



//echo "<br />Line 377: query0=$query0"; exit;

$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);


if($myreports_user>0)	
{		
$page="infotrack/position_reports.php?menu=1";
}	


$query0a="select count(myreports_only) as 'regular_user' from cash_handling_roles where tempid='$tempID'
         and myreports_only='n'
";





//echo "<br />Line 377: query0=$query0"; exit;

$result0a = mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a.  $query0a");

$row0a=mysqli_fetch_array($result0a);
extract($row0a);

if($tempID=='Gardner8759')
{
echo "<br />Line 1544: query0a=$query0a";
echo "<br />Line 1570: regular_user=$regular_user<br />";
//exit;
}



if($menu=="mmc"){$page="mymoneycounts.php";}
//if($emid==79){echo "Line 856<br />";}

//if($_SESSION['budget']['beacon_num']=="60032988" and $myreports_user < 1){$page="menu1314.php";}
//if($_SESSION['budget']['level']=="1" and $myreports_user < 1){$page="menu1314.php";}

if($_SESSION['budget']['tempID']=="Davis9471"){$_SESSION[$db]['report']="park_project_balances";}
if($_SESSION['budget']['tempID']=="Howerton3639"){$_SESSION[$db]['beacon_num']="60033012";}
if($_SESSION['budget']['tempID']=="Deutsch1615"){$_SESSION[$db]['beacon_num']="20200819";}
//if($_SESSION['budget']['beacon_num']=="60032981"){echo "tbass: testing access for Bonita Meeks";  echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;}
//if($_SESSION['budget']['beacon_num']=="60033019"){echo "tbass: testing access for Kristen Woodruff"; echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;}

//MORE OA  Annette Hall 2/17/20
if($_SESSION['budget']['beacon_num']=="60032931"){$_SESSION[$db]['select']="WEDI";}
if($_SESSION['budget']['beacon_num']=="60032977"){$_SESSION[$db]['select']="NODI";}

//fix for WEDI Maintenance Mgr
if($_SESSION['budget']['beacon_num']=="60032958"){$_SESSION[$db]['select']="WEDI";}

//fix for WEDI Interpretation Specialist
if($_SESSION['budget']['beacon_num']=="60032875"){$_SESSION[$db]['select']="WEDI";}

if($myreports_user < 1 or $regular_user > 0){$page="menu1314.php";}

// $_SESSION[$db]['report']="park_project_balances";
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; exit;


//echo "<br />Line 1602<br />"; exit;
/*
if($_SESSION['budget']['beacon_num']=="60032988")
{
echo "<br />myreports_user=$myreports_user<br />";
echo "<br />regular_user=$regular_user<br />";
exit;
}

if($_SESSION['budget']['beacon_num']=="60033021")
{
echo "<br />myreports_user=$myreports_user<br />";
echo "<br />regular_user=$regular_user<br />";
exit;
}
*/
/*
if($_SESSION['budget']['tempID']=="Grunder0429")
{$beacnum=$_SESSION['budget']['beacon_num'];
echo "beacnum=$beacnum"; exit;
}
*/

//if($_SESSION['budget']['beacon_num']=="60032793" or $_SESSION['budget']['beacon_num']=="60032988" or $_SESSION['budget']['beacon_num']=="60032842" or $_SESSION['budget']['beacon_num']=="60036015" or $_SESSION['budget']['beacon_num']=="60032930" or $_SESSION['budget']['beacon_num']=="60032850" or $_SESSION['budget']['beacon_num']=="60032781")
//echo "<br />Line 1927: tempid_original=$tempid_original<br />";
if($tempid_original != ''){$_SESSION['budget']['tempID_player']=$_SESSION['budget']['tempID'];}
if($tempid_original != ''){$_SESSION['budget']['tempID_original']="$tempid_original";}	
if($tempid_original != ''){$_SESSION['budget']['tempID']="$tempid_original";}	
//Forces $tempID Variable to be the same as the Original Tempid.  Example Bass3278 logs in. 
//Goes to PlayerView Drop-down and Selects: Dodd3454
// This Code maintains $tempID as Bass3278  instead of Dodd3454
//echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;
//{
header("Location: $page");
//}
//else
	/*
{
echo "<br /><font size='10'>MoneyCounts not available from 4:00-6:00 on Saturday, June 6th (Tony Bass). Sorry for inconvenience<br />";	exit;
	
	
}	
*/
?>

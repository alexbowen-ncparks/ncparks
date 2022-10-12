<?php

/****
	INCLUDE file inventory
include("/opt/library/prd/WebServer/include/iConnect.inc")
include_once("../../include/get_parkcodes.php")
include("../../include/salt.inc")
*/

//print_r($_REQUEST); //exit;
//session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";//EXIT;
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
// 10/06/22 Cole Goodnight - Changed to select by tempID instead of emid in order to prevent overlap
// emids over 1000 have potential to overlap with the nondpr table
$sql = "SELECT $database as 'level',t1.currPark,t2.Nname,t2.Fname,t2.Lname,t3.posTitle,t2.tempID,accessPark, t3.beacon_num,t3.rcc,t2.emid as ck_emid
FROM divper.emplist as t1
LEFT JOIN divper.empinfo as t2 on t2.emid=t1.emid
LEFT JOIN divper.position as t3 on t3.beacon_num=t1.beacon_num
WHERE t1.tempID = '$tempID' ";

//if($tempID=='Ayers2629'){echo "$sql"; exit;}	
//echo "$sql";
 //exit;


$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysql_errno() . ": " . mysqli_error());
$num = @mysqli_num_rows($result);
$row=mysqli_fetch_array($result);extract($row);
$level_access=$level;
//echo "Line50: level_access=$level_access<br />"; 
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
$level_access=$level; 
$currPark=$row['currPark'];
//if($tempID=='Tigue5683'){echo "Line66: level_access=$level_access<br />"; exit;}
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
	
			{
			echo "Access denied";exit;
			}

}




}


include("../../include/salt.inc"); // salt phrase
$ck_s=md5($salt.$ck_emid);



if($ck!=$ck_s AND $num_nondpr<1){exit;}

$posNum=@$beacon_num;


//if($tempID=='Tigue5683'){$level_access=0;}
//echo "Line 135:level_access=$level_access<br />";
if($level_access<1)
	{
	echo "Line 138: You do not have access privileges for this database [$db] $level for position $posTitle $beacon_num. Contact <a href='mailto:database.support@ncparks.gov'>database.support@ncparks.gov</a> if you wish to gain access.<br><br>budget.php<br>t=$tempID<br />line 138";exit;
	}



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
		
		
	}
else
	{
		
	
		
	$level=1; // used to prevent most users from gaining access
	
	$_SESSION[$db]['tempID'] = $tempID;
	$_SESSION[$db]['select']=@$currPark;
	$_SESSION[$db]['posNum']=$posNum;
	$_SESSION[$db]['accessPark']=@$accessPark;
	$_SESSION[$db]['beacon_num']=@$beacon_num;
	$_SESSION[$db]['position'] = strtolower($posTitle);
	$_SESSION[$db]['level'] = $level;
	$_SESSION[$db]['report']="park_project_balances";
	

	$posTitle=strtolower($posTitle);
	

/*
{
	


if($level > 0)
{
$_SESSION[$db]['level'] = $level;
$_SESSION[$db]['select'] = $currPark;


}
else
{echo "Access denied.<br />If Access required: Please Contact <a href:'mailto:database.support@ncparks.gov'>database.support@ncparks.gov</a> or DPR Budget Office. Line 466";exit;}
}

*/

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

/*
if($level<1 and $num_nondpr<1)
	{
	echo "You do not have access privileges for this database [$db] $level for position $posTitle $beacon_num. Contact <a href='mailto:database.support@ncparks.gov'>database.support@ncparks.gov</a> if you wish to gain access.<br><br>budget.php<br>t=$tempID<br />line 945";exit;
	}
*/

$database=$db;


mysqli_select_db($connection, $database); // database 


//TBass-9/13/22-Start

//$makeCenter="1280".$rcc;

$center1='1280'.$rcc;  $center2='1680'.$rcc;


$query0a="SELECT center as 'makeCenter' FROM budget.center where (center='$center1' or new_center='$center2') ";
$result0a = mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a.  $query0a");
$row0a=mysqli_fetch_array($result0a);
extract($row0a);
//echo "<br />Line 228: query0a=$query0a";

/*
if($tempID=='Matheson2236')
{
echo "<br />makeCenter=$makeCenter<br />"; 

echo "<br />Line 228: query0a=$query0a <br />";

exit;
}
*/



if($currPark=='REMO'){$makeCenter='1680599'; $rcc='599';}
if($currPark=='PIVI'){$makeCenter='1680598'; $rcc='598';}
if($currPark=='BOCR'){$makeCenter='1680591'; $rcc='591';}



//TBass-9/13/22-End



$posTitle=ucwords($posTitle);
if(!isset($currPark)){$currPark="";}


//insert ignore added by tbass on 2/17/13. Whenever a User accessed Budget DB for the first time, there tempid will be added to Budget Table=tempid_centers. Line 310 update will provide additional info needed for Budget Table=tempid_centers

$sql = "insert ignore into tempid_centers(tempid)
        values('$tempID')";

 $result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysql_errno() . ": " . mysqli_error());



$sql = "UPDATE tempid_centers set rcc='$rcc', center='$makeCenter', level='$level', currpark='$currPark', postitle='$posTitle', posnum='$posNum',  pcard_admin='$currPark' WHERE tempid = '$tempID'";
//if($tempID=='McElhone8290'){echo "$sql"; exit;}	
	
	
$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysql_errno() . ": " . mysqli_error());


// added 1/26/16

//TBass-9/13/22-Start
/*
$sql = "UPDATE tempid_centers
        set center='12802858', rcc='2858'
		where tempid='barnett8880' ";

$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysql_errno() . ": " . mysqli_error());
*/

// added 10/26/15



/*
$sql = "UPDATE tempid_centers,center_appropi_new
        set tempid_centers.new_center=center_appropi_new.new_center,
		    tempid_centers.center_code=center_appropi_new.parkcode,
    		tempid_centers.center_section=center_appropi_new.section	
		    where tempid_centers.center=center_appropi_new.old_center";
*/

//TBass-9/13/22-End



//TBass-9/13/22-Start

$sql = "UPDATE tempid_centers,center
        set tempid_centers.new_center=center.new_center,
		    tempid_centers.center_code=center.parkcode,
    		tempid_centers.center_section=center.section	
		    where tempid_centers.center=center.center and tempid_centers.tempid='$tempID' ";

//if($tempID=='Ayers2629'){echo "$sql"; exit;}	
//TBass-9/13/22-End


		
//echo "line 564 query=$sql"; exit;
$result = @mysqli_query($connection, $sql) or die("$sql Error 1#". mysql_errno() . ": " . mysqli_error());



$sql = "SELECT center, new_center,center_code,center_section
FROM tempid_centers WHERE tempid = '$tempID'";


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


//$page="menu.php?forum=blank";
//echo "menu=$menu";exit;



// Angela Boggus-Budget Office Accounting
if ($_SESSION['budget']['beacon_num'] == "60033242")
{
	$_SESSION[$db]['select'] = "ADM";
	$_SESSION[$db]['centerSess'] = "12802751";
	$_SESSION[$db]['centerSess_new'] = "1680504";
	$_SESSION[$db]['center_code'] = "ADMI";
	$_SESSION[$db]['center_section'] = "administration";
	$_SESSION['parkS'] = "ARCH";
	$page = "menu1314.php";
}



//howard6319
//if($tempID== "Howard6319"){$page="menu1314.php";}
/*
if($tempID== "Cucurullo1234")
{
echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;

}
*/



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


if($_SESSION['budget']['tempID']=="Siler1222")
{
$_SESSION[$db]['tempID']="Deaton1222";
}



/* 2022-03-23: CCOOPER - try to see this does 
   2022-06-24: reinstated this code to try to fix Heidi's deposit
               approval issue Ticket 343*/
 if($_SESSION['budget']['tempID']=="Rumble9889")
{
	$_SESSION[$db]['tempID']="Rumble2030";
} 
   /* 2022-03-23 End CCOOPER*/


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
$posTitle="Parks District Superintendent";
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

//JGC 20220111: added cathy cooper (other app developer) to have same level of access as TonyBass
if($_SESSION['budget']['tempID']=="Cooper8546")
{
	//echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;
	$_SESSION[$db]['select']="ADM";
	$_SESSION[$db]['level']="5";
	$_SESSION[$db]['centerSess']="12802953";
	$_SESSION[$db]['centerSess_new']="1680574";
	$_SESSION[$db]['posNum']="60032793";
	$_SESSION[$db]['beacon_num']="60032793";
}

if ($_SESSION['budget']['tempID'] == "Pollina7832")
{
	$_SESSION[$db]['select'] = "ADM";
	$_SESSION[$db]['centerSess'] = "12802953";
	$_SESSION[$db]['centerSess_new'] = "1680574";
	$_SESSION[$db]['posNum'] = "60096141";
	$_SESSION[$db]['beacon_num'] = "60096141";
	$_SESSION[$db]['center_section'] = "administration";	
}



//if($_SESSION['budget']['tempID']=="Becker7900")
if($_SESSION['budget']['tempID']=="Bischof7900")
{
$_SESSION[$db]['select']="WEDI";
}


/*
$query0="select count(myreports_only) as 'myreports_user' from cash_handling_roles where tempid='$tempID'
         and myreports_only='y' ";


$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");

$row0=mysqli_fetch_array($result0);
extract($row0);


if($myreports_user>0)	
{		
$page="infotrack/position_reports.php?menu=1";
}	


$query0a="select count(myreports_only) as 'regular_user' from cash_handling_roles where tempid='$tempID'
         and myreports_only='n' ";


$result0a = mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a.  $query0a");

$row0a=mysqli_fetch_array($result0a);
extract($row0a);
*/


//if($menu=="mmc"){$page="mymoneycounts.php";}
//if($emid==79){echo "Line 856<br />";}

//if($_SESSION['budget']['beacon_num']=="60032988" and $myreports_user < 1){$page="menu1314.php";}
//if($_SESSION['budget']['level']=="1" and $myreports_user < 1){$page="menu1314.php";}

if($_SESSION['budget']['tempID']=="Davis9471"){$_SESSION[$db]['report']="park_project_balances";}
//if($_SESSION['budget']['tempID']=="Howerton3639"){$_SESSION[$db]['beacon_num']="60033012";}
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

//if($myreports_user < 1 or $regular_user > 0){$page="menu1314.php";}
//echo "Line 1854 page=menu1314.php removed";

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



$_SESSION[$db]['org_group']="";
$_SESSION[$db]['org_group_mgr']="";

//echo "<br />posTitle=$posTitle<br />"; exit;
//8/5/22-TB-START:  Create Session Variables:  org_group for Park Users
if($level==1){$_SESSION[$db]['org_group']="pa_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Park Users
$posTitle=strtolower($posTitle);
$suptString="park superintendent";
	$posSupt=strpos($posTitle,$suptString);
//echo "Line 1904: posTitle=$posTitle  suptString=$suptString"; exit;	
	if($posSupt !== false){$_SESSION[$db]['org_group_mgr']="y";}
//8/5/22-TB-END


//8/5/22-TB-START:  Create Session Variables:  org_group for District Users
if($level==2){$_SESSION[$db]['org_group']="di_group"; $_SESSION[$db]['org_group_mgr']="n";}  //District Users
$posTitle=strtolower($posTitle);
$disuString="parks district superintendent";
	$posDisu=strpos($posTitle,$disuString);
//echo "Line 1915: posTitle=$posTitle  disuString=$disuString"; exit;	
	if($posDisu !== false){$_SESSION[$db]['org_group_mgr']="y";}
//8/5/22-TB-END



//8/5/22-TB-START:  Create Session Variables:  org_group for Budget Office 

if($_SESSION['budget']['beacon_num']=="60032781"){$_SESSION[$db]['org_group']="fs_group"; $_SESSION[$db]['org_group_mgr']="y";}  //Budget Manager Tammy Dodd
if($_SESSION['budget']['beacon_num']=="65032850"){$_SESSION[$db]['org_group']="fs_group"; $_SESSION[$db]['org_group_mgr']="y";}  //Budget Manager Mahnaz Rouhani
if($_SESSION['budget']['beacon_num']=="60036015"){$_SESSION[$db]['org_group']="fs_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Budget Office Heide Rumble
if($_SESSION['budget']['beacon_num']=="65032827"){$_SESSION[$db]['org_group']="fs_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Budget Office Carmen Williams
if($_SESSION['budget']['beacon_num']=="60033242"){$_SESSION[$db]['org_group']="fs_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Budget Office Angela Boggus
if($_SESSION['budget']['beacon_num']=="60032997"){$_SESSION[$db]['org_group']="fs_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Budget Office Rachel Gooding
//if($_SESSION['budget']['beacon_num']=="60036015"){echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;}

//8/5/22-TB-END


//8/5/22-TB-START:  Create Session Variables:  org_group for (administration_operations) and org_group for (administration_financial_services_group)

if($_SESSION['budget']['beacon_num']=="60033018"){$_SESSION[$db]['org_group']="admin_ops"; $_SESSION[$db]['org_group_mgr']="y";}  //CHOP Kathy Capps
if($_SESSION['budget']['beacon_num']=="60033202"){$_SESSION[$db]['org_group']="admin_fsg"; $_SESSION[$db]['org_group_mgr']="y";}  //Eric Estes
//if($_SESSION['budget']['beacon_num']=="60033202"){echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;}

//8/5/22-TB-END


//8/5/22-TB-START:  Create Session Variable:  org_group for "Design and Development" Group


if($_SESSION['budget']['beacon_num']=="60032833"){$_SESSION[$db]['org_group']="dd_group"; $_SESSION[$db]['org_group_mgr']="y";}  //Facility Engineer Mgr (howerton3639-8/6/22)
if($_SESSION['budget']['beacon_num']=="60032787"){$_SESSION[$db]['org_group']="dd_group"; $_SESSION[$db]['org_group_mgr']="n";}  //VACANT Admin
if($_SESSION['budget']['beacon_num']=="60092636"){$_SESSION[$db]['org_group']="dd_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Facility Engineer (blount4858-8/6/22)
if($_SESSION['budget']['beacon_num']=="60032830"){$_SESSION[$db]['org_group']="dd_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Facility Engineer (parker6291-8/6/22)
if($_SESSION['budget']['beacon_num']=="65027687"){$_SESSION[$db]['org_group']="dd_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Facility Engineer (lyons4112-8/6/22)
if($_SESSION['budget']['beacon_num']=="60032789"){$_SESSION[$db]['org_group']="dd_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Facility Engineer (williamson8085-8/6/22)
//if($_SESSION['budget']['beacon_num']=="60032833"){echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;}

//8/5/22-TB-END


//8/5/22-TB-START:  Create Session Variable:  org_group for "Facility Maintenance" Group


if($_SESSION['budget']['beacon_num']=="60033012"){$_SESSION[$db]['org_group']="fm_group"; $_SESSION[$db]['org_group_mgr']="y";}  //Facility Maintenance Mgr (reavis6725-8/6/22)
if($_SESSION['budget']['beacon_num']=="60032956"){$_SESSION[$db]['org_group']="fm_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Maintenance Mechanic South District (autry6219-8/6/22)
if($_SESSION['budget']['beacon_num']=="60032957"){$_SESSION[$db]['org_group']="fm_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Maintenance Mechanic East District (johnson4374-8/6/22)
if($_SESSION['budget']['beacon_num']=="60032977"){$_SESSION[$db]['org_group']="fm_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Maintenance Mechanic North District (noel4543-8/6/22)
if($_SESSION['budget']['beacon_num']=="60032958"){$_SESSION[$db]['org_group']="fm_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Maintenance Mechanic West District (felts9831-8/6/22)
if($_SESSION['budget']['beacon_num']=="65020599"){$_SESSION[$db]['org_group']="fm_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Facility Maintenance Supervisor (ayers2629-8/6/22)
if($_SESSION['budget']['beacon_num']=="65020598"){$_SESSION[$db]['org_group']="fm_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Facility Maintenance Supervisor (shea4229-8/6/22)
if($_SESSION['budget']['beacon_num']=="60032877"){$_SESSION[$db]['org_group']="fm_group"; $_SESSION[$db]['org_group_mgr']="n";}  //Curator (sawyer6913-8/6/22)


//8/5/22-TB-END



//if($_SESSION['budget']['beacon_num']=="60032793"){echo "<pre>";print_r($_SESSION);echo "</pre>"; exit;}


//8/5/22-TB-START:  Create Session Variables:  org_group for MC Users which have ONLY MyReports Access

//if($_SESSION['budget']['tempID']=="Cox6207")
{
//echo "Line 986:<br />"; 
$query0="select count(myreports_only) as 'myreports_yes' from cash_handling_roles where tempid='$tempID' and myreports_only='y' ";
$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");
$row0=mysqli_fetch_array($result0);
extract($row0);
//echo "query0=$query0<br />";
/*
if($myreports_user>0)	
{		
$page="infotrack/position_reports.php?menu=1";
}	
*/

$query0a="select count(myreports_only) as 'myreports_no' from cash_handling_roles where tempid='$tempID' and myreports_only='n' ";
$result0a = mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a.  $query0a");
$row0a=mysqli_fetch_array($result0a);
extract($row0a);
//echo "query0a=$query0a<br />";
//echo "Line 1006: myreports_yes=$myreports_yes<br />myreports_no=$myreports_no<br />";
if($myreports_yes>0 and $myreports_no==0){$mr_only='y';} else {$mr_only='n';}

//echo "Line 1009 : mr_only=$mr_only<br />";
//echo "page=$page";

if($mr_only=='y'){$_SESSION[$db]['org_group']="mr_only"; $_SESSION[$db]['org_group_mgr']="n";}  //MC Users which have ONLY MyReports Access

//echo "Line 1013: page=$page<br />";
//exit;
}

if($mr_only=='y'){$_SESSION[$db]['org_group']="mr_only"; $_SESSION[$db]['org_group_mgr']="n";}  //MC Users which have ONLY MyReports Access

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
	
if($mr_only=='y'){$page="infotrack/position_reports.php?menu=1";} else {$page="menu1314.php";}



$query0a="select report_year as 'current_fiscal_year' from budget.fiscal_year where active_year='y' ";
$result0a = mysqli_query($connection, $query0a) or die ("Couldn't execute query 0a.  $query0a");
$row0a=mysqli_fetch_array($result0a);
extract($row0a);
$_SESSION[$db]['current_fiscal_year']=$current_fiscal_year;





	
/*
if($_SESSION['budget']['tempID']=="Woodruff1234")
{
echo "Line 1044: page=$page"; 

echo "<pre>";print_r($_SESSION);echo "</pre>";

exit;}
*/

header("Location: $page");
//}
//else
	/*
{
echo "<br /><font size='10'>MoneyCounts not available from 4:00-6:00 on Saturday, June 6th (Tony Bass). Sorry for inconvenience<br />";	exit;
	
	
}	
*/
?>

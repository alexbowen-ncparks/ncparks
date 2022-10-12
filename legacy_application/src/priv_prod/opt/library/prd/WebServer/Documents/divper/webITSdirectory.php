<?php
// extract($_REQUEST);
//echo "test<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
include ("/opt/library/prd/WebServer/include/iConnect.inc");
include ("/opt/library/prd/WebServer/include/get_parkcodes_reg.php");
mysqli_select_db($connection,"divper");
// Default email
$emailFld="dprunit.email";

if(@$parkcode || @$Lname)
	{
	
	$parkCodeName["ARCH"]="Administrative Offices"; 
	if(@$parkcode)
		{
		$pc=strtoupper($parkcode);
	$pc=stripslashes(htmlspecialchars(htmlentities($pc)));
		$where="where emplist.currPark='$pc'";
		$parkName=$parkCodeName[$pc];}
	
	if($pc=="ARCH" || $pc=="YORK")
		{
		$emailFld="empinfo.email";
		$where="where (emplist.currPark='ARCH' || emplist.currPark='YORK')";
		}
	
	if(@$Lname)
		{
		//$testName=$Lname;
// 		$Lname = mysqli_real_escape_string($connection,$Lname);
//	$Lname=stripslashes(htmlspecialchars(htmlentities($Lname)));
		$emailFld="empinfo.email";
		$where="where empinfo.Lname='$Lname'";
		}
	
	
	$distArray=array("EADI","NODI","SODI","WEDI",);
	
	$sql2 = "SELECT empinfo.Nname,empinfo.Fname,empinfo.Lname, position.working_title as jobtitle, emplist.jobtitle as web_jobtitle, emplist.currPark,dprunit.ophone,empinfo.phone, dprunit.email as parkEmail, empinfo.email as empEmail
	FROM empinfo
	LEFT JOIN emplist on emplist.emid=empinfo.emid 
	LEFT JOIN position on position.beacon_num=emplist.beacon_num 
	LEFT JOIN dpr_system.dprunit on emplist.currPark=dpr_system.dprunit.parkcode 
	$where and emplist.jobtitle!='NULL'
	order by empinfo.Lname,empinfo.Fname";
	$result = @mysqli_query($connection,$sql2) or die();
//	   echo "$sql2";exit;
	$numrow = mysqli_num_rows($result);
	if($numrow<1)
		{
		$where=str_replace("empinfo","nondpr",$where);
		$sql2 = "SELECT Fname, Lname, currPark, email as empEmail
		FROM nondpr
		$where 
		";
	$result = @mysqli_query($connection,$sql2) or die();
	//  echo "$sql2";exit;
	$numrow = mysqli_num_rows($result);
		}
	if($numrow<1)
		{
		$Lname=stripslashes(htmlspecialchars(htmlentities($Lname)));
		echo "No one with the last name [$Lname] was found. Please check your spelling.";exit;
		}
//echo "p=$pc";
	while($row = mysqli_fetch_assoc($result))
			{
			$ARRAY[]=$row;	
			}
		
	// add nondpr from YORK
		if(@$pc=="ARCH")
			{
			$ARRAY[]=array("Fname"=>"","Lname"=>"","empEmail"=>"","phone"=>"","jobtitle"=>"Temp Employees");
			$sql = "SELECT Fname, Lname, currPark, email as empEmail, wphone as phone, photoID as jobtitle
			FROM nondpr
			where 
			(currPark='ARCH' OR currPark='YORK') and email !=''
			order by Lname, Fname
			";  //echo "$sql";
			$result2 = @mysqli_query($connection,$sql) or die();
			$numrow = mysqli_num_rows($result2);
			if($numrow>0)
				{
				while($row = mysqli_fetch_assoc($result2))
					{
					$ARRAY[]=$row;	
					}
				}
		
			}
		
		}
?>
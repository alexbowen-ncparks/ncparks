<?php
// *************** Project FUNCTIONS **************
// Update Projects
//print_r($_REQUEST);EXIT;




function updateProjects($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$div_app_amt,$res_proj,$partfyn,$partf_approv_num,$femayn,$fema_proj_num,$mult_proj,$bond_fund,$state_appro,$reserve_proj,$design,$construction,$partfid,$cwmtf_fund,$num,$passSQL,$user_id,$showpa,$state_prop_num)
	{
	// statusProj='$statusProj',percentCom='$percentCom', removed to preserve orignial values

	global $connection;

	$projName=addslashes($projName);
	$comments=addslashes($comments);
	$commentsI=addslashes($commentsI);
	//$query = "UPDATE partf_projects set projNum='$projNum',projYN='$projYN', reportDisplay='$reportDisplay', projCat='$projCat', projSCnum='$projSCnum', projDENRnum='$projDENRnum', Center='$Center', budgCode='$budgCode',comp='$comp', projsup='$projsup', manager='$manager', fundMan='$fundMan', YearFundC='$YearFundC', YearFundF='$YearFundF',fullname='$fullname', dist='$dist',county='$county', section='$section',park='$park', projName='$projName',active='$active',startDate='$startDate',endDate='$endDate', statusPer='$statusPer',comments='$comments',commentsI='$commentsI',dateadded='$dateadded',brucefy='$brucefy',proj_man='$proj_man',secondCounty='$secondCounty', div_app_amt='$div_app_amt', res_proj='$res_proj',partfyn='$partfyn',partf_approv_num='$partf_approv_num',femayn='$femayn',fema_proj_num='$fema_proj_num', mult_proj='$mult_proj', bond_fund='$bond_fund', state_appro='$state_appro',reserve_proj='$reserve_proj',design='$design',construction='$construction',cwmtf_fund='$cwmtf_fund',showpa='$showpa',user_id='$user_id',state_prop_num='$state_prop_num' WHERE partfid='$partfid'";
	$query = "UPDATE partf_projects set projNum='$projNum',projYN='$projYN', projCat='$projCat', projSCnum='$projSCnum', projDENRnum='$projDENRnum', Center='$Center', new_center='$Center', budgCode='$budgCode',comp='$comp', projsup='$projsup', manager='$manager', fundMan='$fundMan', YearFundC='$YearFundC', YearFundF='$YearFundF',fullname='$fullname', dist='$dist',county='$county', section='$section',park='$park', projName='$projName',active='$active',startDate='$startDate',endDate='$endDate', statusPer='$statusPer',comments='$comments',commentsI='$commentsI',dateadded='$dateadded',brucefy='$brucefy',proj_man='$proj_man',secondCounty='$secondCounty', div_app_amt='$div_app_amt', res_proj='$res_proj',partfyn='$partfyn',partf_approv_num='$partf_approv_num',femayn='$femayn',fema_proj_num='$fema_proj_num', mult_proj='$mult_proj', bond_fund='$bond_fund', state_appro='$state_appro',reserve_proj='$reserve_proj',design='$design',construction='$construction',cwmtf_fund='$cwmtf_fund',showpa='$showpa',user_id='$user_id',state_prop_num='$state_prop_num' WHERE partfid='$partfid'";
	//echo "q=$query";exit;
	$result = mysqli_query($connection, $query) or die ("update.php/updateProjects() Couldn't execute query. $query");
	
$query2="select ceid from center where center='$Center' or new_center='$Center' ";
//echo "<br />update.php Line 24: query2=$query2<br />";

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query2.  $query2");

$record_count=mysqli_num_rows($result2);
//echo "<br />update.php Line 29: record_count=$record_count<br />";
if($record_count <1)
{
$system_entry_date=date("Ymd");
	
$query2a = "insert ignore into center set center='$Center',new_center='$Center',type='project',center_add_by='$user_id',center_add_date='$system_entry_date' ";
//echo "<br />update.php Line 34: query2a=$query2a<br />";

$result2a = mysqli_query($connection, $query2a) or die ("update.php/updateProjects() Couldn't execute query2a. $query2a");
	
	
}
	}

function updateActive($partfid,$active,$displaySQL)
	{
	global $connection;
	$query = "UPDATE partf_projects set active='$active' WHERE partfid='$partfid'";
	//echo "q=$query";exit;
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
	}

function updateShowPA($partfid,$showPA,$displaySQL)
	{
	global $connection;
	$query = "UPDATE partf_projects set showPA='$showPA' WHERE partfid='$partfid'";
	//echo "q=$query";exit;
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
	}
?>

<?php
// *************** Project FUNCTIONS **************
// Update Projects
//print_r($_REQUEST);EXIT;
function updateProjects($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$div_app_amt,$res_proj,$partfyn,$partf_approv_num,$femayn,$fema_proj_num,$mult_proj,$bond_fund,$state_appro,$reserve_proj,$design,$construction,$partfid,$cwmtf_fund,$num,$passSQL,$user_id,$showpa,$state_prop_num)
	{
	// statusProj='$statusProj',percentCom='$percentCom', removed to preserve orignial values

	$projName=addslashes($projName);
	$comments=addslashes($comments);
	$commentsI=addslashes($commentsI);
	$query = "UPDATE partf_projects set projNum='$projNum',projYN='$projYN', reportDisplay='$reportDisplay', projCat='$projCat', projSCnum='$projSCnum', projDENRnum='$projDENRnum', Center='$Center', budgCode='$budgCode',comp='$comp', projsup='$projsup', manager='$manager', fundMan='$fundMan', YearFundC='$YearFundC', YearFundF='$YearFundF',fullname='$fullname', dist='$dist',county='$county', section='$section',park='$park', projName='$projName',active='$active',startDate='$startDate',endDate='$endDate', statusPer='$statusPer',comments='$comments',commentsI='$commentsI',dateadded='$dateadded',brucefy='$brucefy',proj_man='$proj_man',secondCounty='$secondCounty', div_app_amt='$div_app_amt', res_proj='$res_proj',partfyn='$partfyn',partf_approv_num='$partf_approv_num',femayn='$femayn',fema_proj_num='$fema_proj_num', mult_proj='$mult_proj', bond_fund='$bond_fund', state_appro='$state_appro',reserve_proj='$reserve_proj',design='$design',construction='$construction',cwmtf_fund='$cwmtf_fund',showpa='$showpa',user_id='$user_id',state_prop_num='$state_prop_num' WHERE partfid='$partfid'";
	//echo "q=$query";exit;
	$result = mysql_query($query) or die ("Couldn't execute query. $query");
	}

function updateActive($partfid,$active,$displaySQL)
	{
	$query = "UPDATE partf_projects set active='$active' WHERE partfid='$partfid'";
	//echo "q=$query";exit;
	$result = mysql_query($query) or die ("Couldn't execute query. $query");
	}

function updateShowPA($partfid,$showPA,$displaySQL)
	{
	$query = "UPDATE partf_projects set showPA='$showPA' WHERE partfid='$partfid'";
	//echo "q=$query";exit;
	$result = mysql_query($query) or die ("Couldn't execute query. $query");
	}
?>
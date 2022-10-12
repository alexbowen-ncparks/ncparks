<?php

//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/authBUDGET.inc");
include("../../../include/activity.php");
extract($_REQUEST);

if(!isset($rep)){$rep="";}
if(!isset($center)){$center="";}
$level=$_SESSION['budget']['level'];
$thisUser=$_SESSION['budget']['tempID'];
if($level<2 AND !$center){
$pay_center=$_SESSION['budget']['centerSess_new'];
$center=$pay_center;}

$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];

/*
if($beacnum == '60032910') 
{
echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";//exit;
}
*/


// CHOP-Adrian Oneal
/*
if($beacnum == '60033018')
{


if($appall == 'y')
{


$query_chop_appall = "update budget.purchase_request_3
                      set section_approved='y'
                      where section='operations'
                      and report_date='$report_date'
                      and section_approved='u' ";	
					  

					  

mysqli_query($connection, $query_chop_appall) or die ("Couldn't execute query_chop_appall. $query_chop_appall") ;

echo "<table><tr><td><font color='red'>Update Successful</font></td></table>";
}
}
*/

/*
if(
$beacnum == '60032912' or  //east disu
//$beacnum == '60033104' or  //north disu
$beacnum == '60033019' or  //south disu
$beacnum == '60032913'     //west disu
 )
{


if($appall == 'y')
{
//echo "<table><tr><td>update database budget.purchase_request_3</td></table>";
//$fund_change=substr($center_change,0,4);
//$rcc_change=substr($center_change,4,4);

if($concession_location=='EADI'){$district='east' ;}
if($concession_location=='NODI'){$district='north' ;}
if($concession_location=='SODI'){$district='south' ;}
if($concession_location=='WEDI'){$district='west' ;}

$query_disu_appall = "update budget.purchase_request_3
                      set district_approved='y'
                      where section='operations'
					  and district='$district'
                      and report_date='$report_date'
                      and district_approved='u' ";	
					  
//echo "<table><tr><td>query_disu_appall=$query_disu_appall</td></table>";
					  

mysqli_query($connection, $query_disu_appall) or die ("Couldn't execute query_disu_appall. $query_disu_appall") ;

echo "<table><tr><td><font color='red'>Update Successful</font></td></table>";
}

}
*/

if(@$del!="")
	{
	$sql="DELETE from purchase_request_3 where pa_number='$del' and division_approved !='y'";
	
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$sql="OPTIMIZE  TABLE  `purchase_request_3`";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	}



if($_POST['submit']=="Update"){
//echo "139<pre>"; print_r($_POST); echo "</pre>"; //exit;

		if($edit){
	
			$dateSQL=date("Y-m-d",strtotime($purchase_date));
			if($_POST['purchase_type']=="emergency"){
			if($_POST['purchase_date']<$dateSQL){
				$pd=$_POST['purchase_date'];
		echo "When making an emergency purchase, you MUST specify a 'purchase date' AFTER today. Please click you browser's BACK button and resubmit.  $pd $dateSQL"; exit;}
								}
		foreach($_POST as $k=>$v)
		{
			if($k!="submit" AND $k!="edit")
				{
				IF(!is_array($v))
					{
					$clause.=$k."='".$v."', ";
					}
					else
					{
					$clause.=$k."='".$v[$edit]."', ";
					}
				}	
		
		}
			$clause=trim($clause,", ");
		$sql="UPDATE purchase_request_3 set $clause where pa_number='$edit'"; 
//		echo "$sql"; exit;
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
			//echo "$sql";exit;
		header("Location: park_purchase_request_view.php?view=all&report_date=$report_date&submit=Submit");
		}// end $edit


$ignoreKey=array("report_date","purchase_description","requested_amount","purchase_date","justification","edit","submit");
foreach($_POST as $k=>$v){
	if(!in_array($k,$ignoreKey)){$fldArray[]=$k;}
	}
//	echo "<pre>"; print_r($fldArray); echo "</pre>";  //exit;

$pa_numberArray=array_keys($_POST[$fldArray[0]]);
//echo "<pre>"; print_r($pa_numberArray); echo "</pre>"; // exit;

foreach($pa_numberArray as $k=>$v){
$dc="UPDATE purchase_request_3 set ";
	foreach($fldArray as $key=>$value){
		$fld=$_POST[$value][$v];
		$dc.=" $value='$fld', ";		
	}// end fldArray
	
		$dc=trim($dc,", ");
		$sql="$dc where pa_number='$v'";//	echo "$sql<br>";
			$result = mysqli_query($connection, $sql) or die ("Couldn't execute query UPDATE. $sql");
}// end pa_numberArray
	//	exit;
	
	
		$sql="Update purchase_request_3,coa
Set purchase_request_3.account_description=coa.park_acct_desc
Where purchase_request_3.ncas_account=coa.ncasnum";//	echo "$sql<br>";
			$result = mysqli_query($connection, $sql) or die ("Couldn't execute query UPDATE. $sql");
	
		$sql="update approved_re,purchase_request_3 
set approved_re.ncas_account=purchase_request_3.ncas_account 
where approved_re.pa_number=purchase_request_3.pa_number";//	echo "$sql<br>";
			$result = mysqli_query($connection, $sql) or die ("Couldn't execute query UPDATE. $sql");
			
		$rd=$_POST['report_date']; //echo "r=$rd";exit;
		header("Location: park_purchase_request_view.php?view=all&report_date=$rd&submit=Submit");

}// end submit

// Construct Query to be passed to Excel Export
foreach($_REQUEST as $k => $v){
if($v and $k!="PHPSESSID" and $k!="del"){@$varQuery.=$k."=".$v."&";}
}
$passQuery=@$varQuery;
   @$varQuery.="rep=excel";    


if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=park_purchase_request.xls');
}

// Get f_year
include("../~f_year.php");

if($rep==""){
			//include_once("../menu.php");
			//include_once("../menu1314.php");
			include_once("park_purchase_request_menu.php");

if($level==2){
switch ($_SESSION['budget']['select']) {
		case "SODI":
			$w="and district='south'";
			$pu="and (district='south')";
$distCode="south";
			break;	
		case "NODI":
			$w="and district='north'";
			$pu="and (district='north')";
$distCode="north";
			break;	
		case "EADI":
			$w="and district='east'";
			$pu="and (district='east')";
$distCode="east";
			break;	
		case "WEDI":
			$w="and district='west'";
			$pu="and (district='west')";
$distCode="west";
			break;	
	}// end switch
	
$D=$distCode."-NCAS";
$DP=$distCode."-PARK";

$array1=array($D,$DP);

$where=" and section='operations'";

/*
if($rep==""){
$sql="SELECT section,parkcode,center as varCenter from center $where order by section,parkcode,center";

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_array($result)){
extract($row);$pc[]=$parkcode;$c[]=$varCenter;$sec[]=$section;}

echo "<table align='center'><form><tr>";

echo "<td><select name=\"center\"><option selected>Select Center</option>";
for ($n=0;$n<count($c);$n++){
$con=$c[$n];
if($center==$con){$s="selected";}else{$s="value";}
		echo "<option $s='$con'>$sec[$n]-$pc[$n]-$c[$n]\n";
       }
   echo "</select> <input type='submit' name='submit' value='Submit'></td></form></tr></table>";}
   */
}// end level=2


}

if($submit=="Find"){$submit="Submit";}

if($submit!="Submit"){exit;}

// ********* Body Queries ***************

$today=date("Y-m-d");
$sql="Select start_date,end_date
 from budget_request_acceptable_dates
 where budget_group='equipment'
 order by budget_group";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_array($result);
extract($row);
if($today>=$start_date and $today<=$end_date){}else{$menuList=1;}


$pay_center=$_SESSION['budget']['centerSess_new']; //echo "<br /><br />Line 302: pay_center=$pay_center<br /><br />";
if($center){$pay_center=$center;}// override

if(!isset($view)){$view="";}
if(!isset($where)){$where="";}
if($level==1 AND $view=="approved"){$where=" and pay_center='$pay_center' and division_approved='y'";}
if($level==1 AND $view=="pending"){$where=" and pay_center='$pay_center' and division_approved='u'";}
if($level==1 AND $view=="denied"){$where=" and pay_center='$pay_center' and division_approved ='n'";}
if($level==1 AND $view=="all"){$where=" and pay_center='$pay_center'";}

if($level>2){
		if($district){$where=" and district='$district'";}
		if($section){$where.=" and section='$section'";}
		
		}

if($level==2 AND $view=="approved"){$where.=" $w and division_approved='y'";}
if($level==2 AND $view=="pending"){$where.=" $w and division_approved='u'";}
if($level==2 AND $view=="denied"){$where.=" $w and (division_approved ='n')";}
if($level==2 AND $view=="all"){$where.=" $w";}

if(($level==3 || $level==4) AND $view=="approved"){$where.=" and section='$section' and division_approved='y'";}
if(($level==3 || $level==4) AND $view=="pending"){$where.=" and section='$section' and division_approved='u'";}
if(($level==3 || $level==4) AND $view=="denied"){$where.=" and section='$section' and (division_approved ='n')";}
if(($level==3 || $level==4) AND $view=="all"){$where.=" and section='$section'";}

if(($level>4) AND $view=="approved"){$where.=" and division_approved='y'";}
if(($level>4) AND $view=="pending"){$where.=" and division_approved='u'";
$orderBy="district_approved,";}
if(($level>4) AND $view=="denied"){$where.=" and (division_approved ='n')";}
if(($level>4) AND $view=="all"){$where.="";}

if($level==1 and @$edit!=""){
	$center=$_SESSION['budget']['centerSess_new'];
	$where.=" and pay_center='$center'";}

$report_date_clause="and report_date='$report_date'";
if(strpos($report_date,"*")>-1){
	$var=explode("*",$report_date);
		$report_date_clause="and (report_date>='$var[0]' AND report_date<='$var[1]')";
		}

if(@$purchase_type){$where.=" and purchase_type='$purchase_type'";}
if(@$center_code){$where.=" and center_code='$center_code'";}

if(@$re_number AND @$pa_number){$where.=" and (re_number='$re_number' OR pa_number='$pa_number')";
	$report_date_clause="";
	}
	else{
if(@$re_number){$where.=" and (re_number='$re_number')";
	$report_date_clause="";
	}
	
if(@$pa_number){$where.=" and (pa_number='$pa_number')";
	$report_date_clause="";
	}
}
if(!empty($edit)){$where.=" and (pa_number='$edit')";
	}	

if(!isset($orderBy)){$orderBy="";}
/*select query for center budgets*/


//65020598 (facility maint supervisor) as of 7/12/20  (vacant-previously dwayne parker)
//65020599 (facility maint supervisor) as of 7/12/20 (randy ayers)
if($beacnum=='65020598' or $beacnum=='65020599')
{	
	
if($view=="approved"){$where=" and center_code='fama' and division_approved='y' ";}	
if($view=="pending"){$where=" and center_code='fama' and division_approved='u' ";}	
if($view=="denied"){$where=" and center_code='fama' and division_approved='n' ";}	
if($view=="all"){$where=" and center_code='fama' ";}	

	
}



//60032956(south district MM) as of 7/12/20  (craig autry)
//60032977(north district MM) as of 7/12/20 (patrick noel)
//60032957 (east district MM) as of 7/12/20 (johnny johnson)
//60032958 (west district MM) as of 7/12/20 (shane felts)

if($beacnum=='60032956'){$where=" and (center_code='fama' or center_code='sodi') ";} 
if($beacnum=='60032977'){$where=" and (center_code='fama' or center_code='nodi') ";} 
if($beacnum=='60032957'){$where=" and (center_code='fama' or center_code='eadi') ";} 
if($beacnum=='60032958'){$where=" and (center_code='fama' or center_code='wedi') ";} 


//60032881 mike deturo
//60033146 chris fox
//60033165 keith nealson


if($beacnum=='60032881'){$where=" and (center_code='rale') ";} 
if($beacnum=='60033146'){$where=" and (center_code='rale') ";} 
if($beacnum=='60033165'){$where=" and (center_code='rale') ";} 






/*
{
	
	
if($view=="approved"){$where=" and center_code='fama' and division_approved='y' ";}	
if($view=="pending"){$where=" and center_code='fama' and division_approved='u' ";}	
if($view=="denied"){$where=" and center_code='fama' and division_approved='n' ";}	
if($view=="all"){$where=" and center_code='fama' ";}	

	
	
}

*/



if($beacnum=='60033012') //jerry howerton
{
	
	
//if($view=="approved"){$where=" and (center_code='fama' or center_code='ware') and division_approved='y' ";}	
//if($view=="pending"){$where=" and (center_code='fama' or center_code='ware') and division_approved='u' ";}	
//if($view=="denied"){$where=" and (center_code='fama' or center_code='ware') and division_approved='n' ";}	
//if($view=="all"){$where=" and (center_code='fama' or center_code='ware') ";}		
	




$level='2';
}





if($beacnum=='60032877' //amy sawyer
   or $beacnum=='60092637' //tim rayworth
   or $beacnum=='60032875' //randy bechtel
   or $beacnum=='60032907' //britney hurtado
   or $beacnum=='60033135' //brian bockhahn
   
)
{
	
if($view=="approved"){$where=" and (center_code='ined' or purchaser='iema') and division_approved='y' ";}	
if($view=="pending"){$where=" and (center_code='ined' or purchaser='iema') and division_approved='u' ";}	
if($view=="denied"){$where=" and (center_code='ined' or purchaser='iema') and division_approved='n' ";}	
if($view=="all"){$where=" and (center_code='ined' or purchaser='iema') ";}		
	
	
	
}

if($beacnum=='60032780') //sean higgins
{
		
if($view=="approved"){$where=" and center_code='ined' and division_approved='y' ";}	
if($view=="pending"){$where=" and center_code='ined' and division_approved='u' ";}	
if($view=="denied"){$where=" and center_code='ined' and division_approved='n' ";}	
if($view=="all"){$where=" and center_code='ined' ";}	


$level='2';	
}


if($beacnum=='60033009') //warehouse mrg (kelly chandler)
{
		
if($view=="approved"){$where=" and center_code='ined' and division_approved='y' ";}	
if($view=="pending"){$where=" and center_code='ined' and division_approved='u' ";}	
if($view=="denied"){$where=" and center_code='ined' and division_approved='n' ";}	
if($view=="all"){$where=" and center_code='ware' ";}	


$level='2';	
}






/*
$sql="select
report_date,
pa_number,
section,
district,
center_code,
center_description,
pay_center,
user_id,
system_entry_date,
purchase_description,
ncas_account,
account_description,
sum(unit_quantity*unit_cost) as 'requested_amount',
purchase_type,
purchase_date,
justification,
district_approved,
disu_comments,
section_approved,
section_comments,
division_approved,
bo_comments,
osbm_approved,
re_number
from purchase_request_3
where 1
$where
$report_date_clause
group by pa_number
order by $orderBy section,district,center_code
";
*/

$sql="select
report_date,
pa_number,
section,
district,
center_code,
center_description,
pay_center,
user_id,
system_entry_date,
purchase_description,
ncas_account,
account_description,
sum(unit_quantity*unit_cost) as 'requested_amount',
purchase_type,
purchase_date,
justification,
district_approved,
disu_comments,
section_approved,
section_comments,
division_approved,
bo_comments,
osbm_approved,
re_number
from purchase_request_3
where 1
$where
$report_date_clause
group by pa_number
order by center_code asc
";

















//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "Line 478: $sql";
//TBASS-4/12/14
//if($level>4 and $rep==""){echo "<br />$sql<br />";}//exit;

//if($showSQL=="1"){
//echo "<br /><br />where=$where<br><br />";
//echo "<br />Line 402: $sql<br>";
//}
//TBASS-4/12/14
/*
$headerArray=array("pa_number","report_date","section","district","center_code","center_description","pay_center","user_id","system_entry_date","purchase_description","ncas_account","account_description","requested_amount","purchase_type","purchase_date","justification","district_approved","disu_comments","section_approved","division_approved","bo_comments","osbm_approved","re_number");
*/

////echo "level=$level<br />";
////echo "where=$where<br />";
////echo "report_date_clause=$report_date_clause<br />";
////echo "line 407=$sql<br />";

//$headerArray=array("pa_number","user_id","center_code","purchase_type","ncas_account","account_description","requested_amount","purchase_description","justification","district_approved","disu_comments","section_approved","section_comments","division_approved","bo_comments");
$headerArray=array("pa_number","user_id","center_code","purchase_type","requested_amount","purchase_description","justification");


//,"status","pasu_priority","disu_priority","pasu_ranking"
//"funding_source","category",


$count=count($headerArray);
for($i=0;$i<$count;$i++){
$h=$headerArray[$i];
//TBASS-changed on 8/8/14
//if($h=="division_approved"){$h=str_replace("_","&nbsp;",$h);}
if($h=="division_approved"){$h=str_replace("_","<br />",$h);}
@$header.="<th>".$h."</th>";}

$header=str_replace("_"," ",$header);

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);

$b=array();
while($row=mysqli_fetch_array($result))
	{
	$b[]=$row;
	}// end while
//echo "<pre>";print_r($b);echo "</pre>";exit;

$view1=strtoupper($view);

echo "<html>";

include ("../../budget/menu1415_v1.php");

echo "<script language='JavaScript'>
function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}
</script>";

//062920-delete
/*
if($rep==""){
echo "<tr bgcolor='lightgray'><th colspan='6'><font color='red'>$view1 Requests = $num</font> for Report Date: $report_date</th><td colspan='2'> Excel <a href='park_purchase_request_view.php?$varQuery'>Export</a></td>";
// CHOP Feature allowing CHOP to Approve ALL for a Specific Report Date
if($beacnum=='60033018')
{
echo "<td></td><td></td><td align='center'><a href='park_purchase_request_view.php?view=all&report_date=$report_date&submit=Submit&section=$section&appall=y'>CHOP Approve All</all></td>";
}
// DISU Feature allowing DISU to Approve ALL for a Specific Report Date (east/north/south/west)
if($beacnum == '60032912' or $beacnum == '60033104' or $beacnum == '60033019' or $beacnum == '60032913')
{
echo "<td align='center'><a href='park_purchase_request_view.php?view=all&report_date=$report_date&submit=Submit&appall=y'>DISU Approve All</all></td>";
}
echo "</tr>";
}
else{echo "<tr><th colspan='6'><font color='red'>$view1 Requests = $num</font> for Report Date: $report_date</th></tr><tr>$header</tr>";}
*/

//062920-add
echo "<br />";
{echo "<table align='center'><tr><th colspan='7'>Report Date: $report_date<font color='red'> ($num Requests)<br /><br /> <a href='park_purchase_request.php?submit=Submit'>New Request</a></font><br /></th></tr></table>";}

if($num==0){exit;}

echo "<form method='POST'><table border='1' align='center'>";






// *************** Non-excel *************

$editFlds=array("purchase_description","requested_amount","purchase_date","justification");
$x=2;
$yy=10;
//$b is the "data row" Array
for($i=0;$i<count($b);$i++)
	{
	//$r=fmod($i,$x);if($r==0){$bc=" bgcolor='cornsilk'";}else{$bc="";}
	
	if(fmod($i,$yy)==0 and $rep==""){echo "<tr>$header</tr>";}
	if($b[$i]['requested_amount']<=500){$bc=" bgcolor='lightgreen'";}
	if($b[$i]['requested_amount']>1000){$bc=" bgcolor='lightpink'";}
	if($b[$i]['requested_amount']>500 and $b[$i]['requested_amount']<=1000){$bc=" bgcolor='yellow'";}
	
	echo "<tr$bc>";
	// for statement below insures that the the number of <td></td> for each "data row" matches the number of <td></td> in the "header row"  (see line 510)
	for($j=0;$j<count($headerArray);$j++){
	// $var is assigning a VALUE to every Cell in the "data rows". first ROW:  $var=$b[0][pa_number]=ROW 1 value for pa_number   $var=$b[0][center_code]=ROW 1 value for center_code, etc....
	$var=$b[$i][$headerArray[$j]];
	
	$passPA_number=$b[$i]['pa_number'];
	
	$fieldName=$headerArray[$j];
	$f1="<font color='red'>";$f2="</font>";
	
	
	$report_date=$b[$i]['report_date'];
	$checkDist=$b[$i]['district_approved'];
	$checkSect=$b[$i]['section_approved'];
	$checkDiv=$b[$i]['division_approved'];
	//Bass 2018-0310
	//$center_codeV=$b[$i]['center_code'];
	//Bass 2018-0310
	//$user_idV=$b[$i]['user_id'];
	
	if($fieldName=="pa_number" and $checkDist=="u" and $checkSect=="u" and $checkDiv=="u")
	{
	if(@$district){$passDist="&district=$district";}
	if(@$center_code){$passCent="&center_code=$center_code";}
	if(!isset($passDist)){$passDist="";}
	if(!isset($passCent)){$passCent="";}
	$var="<a href='park_purchase_request_view.php?center=$center&report_date=$report_date&edit=$var&submit=Submit'>$var</a> <a href='park_purchase_request_view.php?center=$center&del=$passPA_number&view=all&report_date=$report_date&submit=Submit$passDist$passCent' onClick='return confirmLink()'><img src='button_drop.png'></a>";}
	
	if($fieldName=="pa_number" and @$rep!=""){$var=$b[$i][$headerArray[$j]];}
	
	if(@$edit==$passPA_number and $checkDist=="u" and $checkSect=="u" and $checkDiv=="u"){
		if(in_array($fieldName,$editFlds)){
		$var="<input type='text' name='$fieldName' value=\"$var\">";}
		}	
	
	
	if($level==2){
		if($fieldName=="district_approved")
		{$ckU="";$ckY="";$ckN="";
		if($var=="u"){$ckU="checked";}
		if($var=="n"){$ckN="checked";}
		if($var=="y"){$ckY="checked";}
		$var="
		Y<input type='radio' name='district_approved[$passPA_number]' value='y'$ckY>
		$f1 N$f2<input type='radio' name='district_approved[$passPA_number]' value='n'$ckN>
		U<input type='radio' name='district_approved[$passPA_number]' value='u'$ckU>
		";
		if($rep!=""){$var=$b[$i][$headerArray[$j]];}
		}
	
		if($fieldName=="disu_comments" and $rep=="")
		{
		$var="<textarea name='disu_comments[$passPA_number]' cols='15' rows='3'>$var</textarea>";
		}
	} // >level1
	
	if($level==3 || $level==4){
		if($fieldName=="section_approved")
		{$ckU="";$ckY="";$ckN="";
		if($var=="u"){$ckU="checked";}
		if($var=="n"){$ckN="checked";}
		if($var=="y"){$ckY="checked";}
		$var="
		Y<input type='radio' name='section_approved[$passPA_number]' value='y'$ckY>
		$f1 N$f2<input type='radio' name='section_approved[$passPA_number]' value='n'$ckN>
		U<input type='radio' name='section_approved[$passPA_number]' value='u'$ckU>
		";
		
		if($rep!=""){$var=$b[$i][$headerArray[$j]];}
		}
		
		if($fieldName=="section_comments" and $rep=="")
		{
		$var="<textarea name='section_comments[$passPA_number]' cols='15' rows='3'>$var</textarea>";
		}		
		
	}
	
	
	if($level>3){
		if($fieldName=="ncas_account")
		{
		$var="<input type='text' name='ncas_account[$passPA_number]' value='$var' size='10'>";
		
		if($rep!=""){$var=$b[$i][$headerArray[$j]];}
		}	
	}// end level>3
	
	if($level>4){
	
	if($fieldName=="purchase_type")
		{
		//$menuArray=array("","service_contracts"=>"service_contracts","purchase4resale"=>"purchase4resale","mission_critical"=>"mission_critical","emergency"=>"emergency");
		$menuArray=array("","purchase4resale"=>"purchase4resale","mission_critical"=>"mission_critical","emergency"=>"emergency");
		$kv=$b[$i][$headerArray[$j]];


		$var="<select name='purchase_type[$passPA_number]'>";
		foreach($menuArray as $k=>$v)
			{
			if($v==$kv){$s="selected";}else{$s="value";}
			$var.="<option $s='$v'>$v</option>\n";
			}
		$var.= "</select>";
		
		$var_purchase_date=$b[$i]['purchase_date'];
		if($kv=="emergency")
			{$var.="<br />$var_purchase_date";}
		
		}
		
		
		if($rep!=""){$var=$b[$i][$headerArray[$j]];}
		
		
		if($fieldName=="division_approved")
		{$ckU="";$ckY="";$ckN="";
		if($var=="u"){$ckU="checked";}
		if($var=="n"){$ckN="checked";}
		if($var=="y"){$ckY="checked";}
		$var="
		Y<input type='radio' name='division_approved[$passPA_number]' value='y'$ckY>
		$f1 N$f2<input type='radio' name='division_approved[$passPA_number]' value='n'$ckN>
		U<input type='radio' name='division_approved[$passPA_number]' value='u'$ckU>
		";
		
		if($rep!=""){$var=$b[$i][$headerArray[$j]];}
		}
	
		if($fieldName=="section_approved")
		{$ckU="";$ckY="";$ckN="";
		if($var=="u"){$ckU="checked";}
		if($var=="n"){$ckN="checked";}
		if($var=="y"){$ckY="checked";}
		$var="
		Y<input type='radio' name='section_approved[$passPA_number]' value='y'$ckY>
		$f1 N$f2<input type='radio' name='section_approved[$passPA_number]' value='n'$ckN>
		U<input type='radio' name='section_approved[$passPA_number]' value='u'$ckU>
		";
		
		if($rep!=""){$var=$b[$i][$headerArray[$j]];}
		}
	
		if($fieldName=="osbm_approved")
		{$ckU="";$ckY="";$ckN="";
		if($var=="u"){$ckU="checked";}
		if($var=="n"){$ckN="checked";}
		if($var=="y"){$ckY="checked";}
		$var="
		Y<input type='radio' name='osbm_approved[$passPA_number]' value='y'$ckY>
		$f1 N$f2<input type='radio' name='osbm_approved[$passPA_number]' value='n'$ckN>
		U<input type='radio' name='osbm_approved[$passPA_number]' value='u'$ckU>
		";
		
		if($rep!=""){$var=$b[$i][$headerArray[$j]];}
		}
	
		if($fieldName=="bo_comments")
		{
		$var="<textarea name='bo_comments[$passPA_number]' cols='15' rows='3'>$var</textarea>";
		
		if($rep!=""){$var=$b[$i][$headerArray[$j]];}
		}
		
		if($fieldName=="pay_center")
		{
		$var="<input type='text' name='pay_center[$passPA_number]' value='$var' size='8'>";
		
		if($rep!=""){$var=$b[$i][$headerArray[$j]];}
		}	
		
		if($fieldName=="justification")
		{
		$var="<textarea name='justification[$passPA_number]' cols='15' rows='3'>$var</textarea>";
		
		if($rep!=""){$var=$b[$i][$headerArray[$j]];}
		}
		
		if($fieldName=="re_number")
		{
		$var="<input type='text' name='re_number[$passPA_number]' value='$var' size='8'>";
		
		if($rep!=""){$var=$b[$i][$headerArray[$j]];}
		}
	} // >level4
	
	
	if($fieldName=="requested_amount"){
	@$total+=$var;
	$al=" align='right'";}else{$al="";}
	
	
	if(@$edit==$passPA_number AND $headerArray[$j]=="purchase_type"){
	//if($level>2 AND $headerArray[$j]=="purchase_type"){
	$passVar=$var;
	$menuArray=array("purchase4resale","mission_critical","emergency");
	$var="<select name='$headerArray[$j]'>";
	foreach($menuArray as $k=>$v){
		//if($var=='center_code'){$v=$v.'1';}
		if($passVar==$v){$s="selected";}else{$s="value";}
		$var.="<option $s='$v'>$v</option>\n";}
		//$var.="<option $s='$v'></option>\n";}
	$var.="</select>";
	}
	
	//if($headerArray[$j]=="center_code"){$var.="tony";}
	
	
	
	
	
	
	
//$center_codeV=$b[$i]['center_code'];
	//Bass 2018-0310
//$user_idV=$b[$i]['user_id'];	
//if($center_codeV != ''){$var=$var.'tony';} else {$var=$var;}
	echo "<td$al>$var</td>";
	
			}
	echo "</tr>";	
	}

	
/*
if(isset($total))
	{
	$total=number_format($total,2);
	echo "<tr>
	<td colspan='5' align='right'>$total</td></tr>";
	}
*/
	if(isset($total))
	{
	$total=number_format($total,2);
	echo "<tr>
	<td colspan='4' align='right'>Total Requests</td>
	<td align='right'>$total</td>	
	</tr>";
	}
	
	
	
	
	
	

if(@$rep==""){
echo "<tr><td colspan='9' align='right'>";

if(@$edit){echo "<input type='hidden' name='edit' value='$edit'>";}

echo "<input type='hidden' name='report_date' value='$report_date'>
<input type='submit' name='submit' value='Update'>
</td></tr>";}

echo "</table></form></html>";
?>




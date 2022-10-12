<?php
/*   *** INCLUDE file inventory ***
include("/opt/library/prd/WebServer/include/iConnect.inc")
include("../../../include/auth.inc")
include("../../../include/activity.php")
include("edit_pcardholders_update.php")
include ("../../budget/menu1415_v1.php")
include("pcard_new_menu1.php")
 [if($level==2){
   include_once("../../../include/parkcodesDiv.inc")
 ]

*/
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}


extract($_REQUEST);

//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;


session_start();
//echo "<pre>";print_r($_SERVER);echo "</pre>"; //exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>"; //exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$tempID=$_SESSION['budget']['tempID'];
$database="budget";

//$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$menu='VCard';

include("../../../include/auth.inc");

include("../../../include/activity.php");

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);


if($submit_acs=="Delete")
	{
	$sql = "Delete from pcard_users where id='$id'";
	echo "<br />Line 24: query=$sql<br />"; exit;
	//$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$m="pcard";
	header("Location: /budget/acs/editPcardHolders.php?m=$m&parkcode=$parkcode&submit_acs=Find");
	exit;
	}
if(!isset($rep)){$rep="";}

		//print_r($_REQUEST);
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$parkcodeACS=$_SESSION['budget']['select'];
$level=$_SESSION['budget']['level'];
$beacnum=$_SESSION['budget']['beacon_num'];
if($level==1){$submit_acs='Find';}
//echo "<br />Line 38:beacnum=$beacnum<br />";
if($level>1){$parkcodeACS=strtoupper($parkcode);}

if($level==1){$_REQUEST['parkcode']=strtoupper($parkcodeACS);}
$sql = "SHOW COLUMNS from pcard_users";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_array($result)){
$fields[]=$row[0];
}

if(!$message){$message="Find/Add Pcard Holder";}

if($submit_acs=="Update"||$submit_acs=="Submit"||$submit_acs=="Add"){
// ****** Any modifications to variables **********
$last_name=addslashes($last_name);
$first_name=addslashes($first_name);
$parkcode=$parkcodeACS;

for($i=0;$i<count($fields);$i++){
if($fields[$i]!="id"){
$val=${$fields[$i]};// force the variable
if($fields[$i]=="monthly_limit"){$val=str_replace(",","",$val);}
if($fields[$i]=="monthly_limit"){$val=str_replace("$","",$val);}
$val=mysqli_real_escape_string($val);
$val="'".$val."'";

if($i!=0) {$arraySet.=",".$fields[$i]."=".$val;}else{$arraySet.=$fields[$i]."=".$val;}
}
}

if($submit_acs=="Add"){

$query = "INSERT into pcard_users SET $arraySet";
//echo $query; exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
$id=mysql_insert_id();
header("Location:/budget/acs/editPcardHolders.php?m=$m&parkcode=$parkcode&submit_acs=Find");
exit;
}

if($submit_acs=="Update"){
$monthly_limit=str_replace(",","",$monthly_limit);	
$monthly_limit=str_replace("$","",$monthly_limit);	
	
//$query = "UPDATE pcard_users SET $arraySet where id='$id'";
$query = "UPDATE pcard_users
 SET admin='$admin',location='$location',center='$center',position_number='$position_number',employee_number='$employee_number',last_name='$last_name',first_name='$first_name',phone_number='$phone_number',justification='$justification',job_title='$job_title',comments='$comments',card_number='$card_number',monthly_limit='$monthly_limit',act_id='$act_id' 
 where id='$id'";
echo "Line119: $query"; //exit;
$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
include("edit_pcardholders_update.php");
}

//header("Location:/budget/acs/editPcardHolders.php?m=$m&parkcode=$parkcode&submit_acs=Find");
header("Location:/budget/acs/editPcardHolders.php?m=pcard&admin=$admin&submit_acs=Find&act_id=$act_id");
exit;
// ******************************** end Add Update
}

function makeQuery(&$item1,$key){
global $query,$fields;
if($item1 AND in_array($key,$fields)){
if($key=="last_name"||$key=="first_name"){
$item1=addslashes($item1);
$query.=" and ".$key." like '%".$item1."%'";}else
{$query.=" and ".$key."='".$item1."'";}
}
}

//if($rep==""){include("../menu.php");}
//$menu_new='LTran';
$menu=='VCard';
include ("../../budget/menu1415_v1.php");
//include("1418.html");
//echo "<style>";
//echo "input[type='text'] {width: 200px;}";

//echo "</style>";


echo "<br />";

include("pcard_new_menu1.php");
echo "<br />";
				// *********** Find ***************
if($submit_acs=="Find"||$id){

//print_r($_SESSION);

if($level>2){
$findArray=$_REQUEST;
array_walk($findArray, 'makeQuery');
$WHERE="Where 1 ".$query;
}else{$WHERE="Where 1 ";}

if($level==1){$WHERE.=" and admin='$parkcodeACS' and act_id != 'p' and act_id != 'n' ";}

if($level==2){
include_once("../../../include/parkcodesDiv.inc");
$parkSession=$_SESSION[budget][select];// Get district
//echo "parkcode=$parkcode<br /><br />";
//echo "parkSession=$parkSession<br />";
if(!$parkcode){$parkcode=$parkSession;}
//echo "parkcode=$parkcode<br /><br />";
$da=${"array".$parkSession}; //print_r($da);exit;

/*
if(in_array($parkSession,$da)){
$parkcode=strtoupper($parkcode);
if(in_array($parkcode,$da)){
$WHERE.="and parkcode='$parkcode'";}else{echo "<br>No access for $parkcode";exit;}
}else{echo "<br><br>You do not have access privileges for this dist=$parkSession $distPark";exit;}

*/

$parkcode=strtoupper($parkcode);
//$WHERE.="and parkcode='$parkcode'";
//$WHERE.="and admin='$parkcode'";
$WHERE.="and admin='$admin'";

//echo "<br />where=$WHERE<br />";



}

$sql = "SELECT * From pcard_users $WHERE 
order by last_name,first_name";

//echo "Line 139: $sql";

if($rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=pcard_holders.xls');
}

$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);


echo "<table cellpadding='5' align='center'>";
/* 2022-02-22: CCOOPER - adding a comment for existing code, and addition of:
                A Boggus (60033242) and C Williams (65032827)   R Goodson = 60032997
        original: if($rep=="" and $beacnum=='60032997'){  

   2022-03-11: CCOOPER - adding more Bus Off personnel: H Rumble (60036015) & M Rouhani (65032850)
*/
if(($rep=="") AND 
  (($beacnum=='60032997') OR
   ($beacnum=='60033242') OR 
   ($beacnum=='65032827') OR
   ($beacnum=='60036015') OR 
   ($beacnum=='65032850')))
{
/* 2022-02-22: End CCOOPER
   2022-03-11: End CCOOPER  */

//if($rep==""){
//	echo "<br />Hello Line 165<br />";
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	$cou=count($_POST);
if($cou==0){$m="";}else{$m="pcard";}
echo "<form name=\"acsForm\" action='editPcardHolders.php' method='POST'>
<tr><td>admin</td><td>";
//echo "<input type='text' name='parkcode' value='$parkcode' size='5'>";
echo "<input type='text' name='admin' value='$admin' size='5'>";
echo "<input type='hidden' name='m' value='$m'>
<input type='submit' name='submit_acs' value='Find'></form>
</td><td><font color='red'>$num Records</font></td>";
//echo "<td><a href='editPcardHolders?parkcode=$parkcode&act_id=y&submit_acs=Find&rep=excel'>Excel</a></td>";
echo "</tr>";}

//echo "$sql";//EXIT;
//$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
//$num=mysqli_num_rows($result);

if($num<1){Header("Location: editPcardHolders.php?m=pcard&message=Nothing Found.");exit;}
if($num>0){
echo "<tr><td><font color='red'>$num Cards</font></td></tr>";
echo "<tr><th>admin</th><th>location</th><th>center</th><th>first_name</th><th>MI</th><th>last_name</th><th>Suff</th><th>job_title</th><th>phone_number</th><th>card#</th><th>monthly_limit</th><th>comments</th><th>active</th></tr>";
while($row=mysqli_fetch_array($result)){
extract($row);
$parkcode=strtoupper($parkcode);
$last_name=strtoupper($last_name);
$first_name=strtoupper($first_name);
$admin=strtoupper($admin);
$monthly_limit=number_format($monthly_limit,2);
if($rep=="excel"){$card_number="'".$card_number;}
//$tr="";
$table_bg2="cornsilk";

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}
//if($location=="1669" and $rep==""){$tr=" bgcolor='goldenrod'";}
//if($location=="1656" and $rep==""){$tr=" bgcolor='coral'";}
$td="";
if($act_id=="y" and $rep==""){$td=" bgcolor='lime'";}
if($act_id=="n" and $rep==""){$td=" bgcolor='pink'";}
if($act_id=="p" and $rep==""){$td=" bgcolor='yellow'";}
if($location=="1656" and $rep==""){$loc_text="reg";}
if($location=="1669" and $rep==""){$loc_text="ci";}


echo "<tr$t><td align='center'>$admin</td><td align='center'>$location-$loc_text</td><td align='center'>$center</td><td align='center'>$first_name</td><td align='center'>$middle_initial</td><td align='center'>$last_name</td><td>$suffix</td><td align='center'>$job_title</td><td align='center'>$phone_number</td>
<td align='center'>$card_number</td><td align='center'>$monthly_limit</td><td align='center'>$comments</td><td align='center'$td>$act_id</td>";

//if($level>2 and $rep==""){echo "<td><a href='editPcardHolders.php?m=pcard&id=$id&parkcode=$parkcode'>View</a></td></tr>";}else{echo "</tr>";}
if($level>2 and $rep==""){echo "<td><a href='editPcardHolders.php?m=pcard&id=$id&admin=$admin'>View</a></td></tr>";}else{echo "</tr>";}

}
if($level<3){
echo "<tr><td colspan='6'>Contact<a href='mailto:rachel.r.gooding@ncparks.gov?subject=$parkcodeACS Pcard'> Rachel Gooding</a> if changes are needed.</td></tr>";}
echo "</table>";
if($num>1){exit;}
}
$soleRecord="y";
}

session_start();
//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>";//EXIT;

$userName=$_SESSION['budget']['acsName'];
if(!$userName)
	{
	//include("../../../include/connectDIVPER.62.inc");// database connection parameters
	mysqli_select_db($connection, "divper"); // database 
	$userID=$_SESSION['budget']['tempID'];
	$sql = "SELECT Nname,Fname,Lname From empinfo where tempID='$userID'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	$row=mysqli_fetch_array($result);
	extract($row);
	if($Nname){$Fname=$Nname;}
	$userName=$Fname." ".$Lname;
	$_SESSION['budget']['acsName']=$userName;
	}
mysqli_select_db($connection, $database); // database 
/*
//These are placed outside of the webserver directory for security
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$sql1 = "SHOW COLUMNS from pcard_users";
$result1 = mysqli_query($connection, $sql1) or die ("Couldn't execute query. $sql1");
while($row1=mysqli_fetch_array($result1)){
$fields[]=$row1[0];
}

//print_r($fields);
*/

if($id){$formType="Update";$message="Edit Pcard Holder";}else{$formType="Find";}
if($soleRecord=="y"){$formType="Update";$message="Edit Pcard Holder";}

//include("/budget/parkRCC.inc");
$parkcodeACS=strtoupper($_SESSION['budget']['select']);

$row=mysqli_fetch_array($result);
extract($row);

//if($level>1){$parkcodeACS=strtoupper($parkcode);}
if($level>1){$parkcodeACS=strtoupper($admin);}
$passID=$id;

echo "<html><header>
</header><body><table cellpadding='1' align='center'><tr><td> </td><td><font color='green' size='+1'>$message</font></td></tr>";
//echo "parkcode=$parkcode<br /><br />";
//echo "<br />Line 272: SQL=$sql<br />";
echo "<form name=\"acsForm\" action='editPcardHolders.php' method='POST'>";
//echo "<tr><td>parkcode</td><td><input type='text' name='parkcode' value='$parkcodeACS' size='5'></tr>";
echo "<tr><td><font color=red>admin</font></td><td><input type='text' name='admin' value='$parkcodeACS' size='5' autocomplete='off'></tr>";
/////////echo "<br />Line 278: formType=$formType<br />";
if($level>2)
	{
	//echo "	<tr><td>admin</td><td><input type='text' name='admin' value='$admin' size='5'></td></tr>";
	echo "<tr><td title='reg=1656 ci=1669'><font color='red'>location</font></td><td><input type='text' name='location' value='$location' size='5' autocomplete='off'></td></tr>";
	
	echo "<tr><td><font color='red'>Employee#</font></td><td><input type='text' name='employee_number' value='$employee_number' size='5' autocomplete='off'></td></tr>";	
	echo "<tr><td><font color='red'>Position#</font></td><td><input type='text' name='position_number' value='$position_number' size='5' autocomplete='off'></td></tr>";
	
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	
	
	
	
	 echo "<tr><td>first name<br />middle initial</td><td><input type='text' name='first_name' value='$first_name' readonly='readonly' autocomplete='off'><br /><input name=\"middle_initial\" type=\"text\" value=\"$middle_initial\" size='1' readonly='readonly' autocomplete='off'></td></tr>";
	
	
	
	
	

    if($formType=='Update')
	{
	echo "<tr><td>last name<br />suffix</td><td><input name=\"last_name\" type=\"text\" value=\"$last_name\" size='15' readonly='readonly' autocomplete='off'><br /><input name=\"suffix\" type=\"text\" value=\"$suffix\" size='1' readonly='readonly' autocomplete='off'>
	</td></tr>";
	}
	
	if($formType=='Find')
	{
	echo "<tr><td>last_name</td><td><input name=\"last_name\" type=\"text\" value=\"$last_name\"  autocomplete='off'>
	</td></tr>";
	}
	
	
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	
	
	
 
   

	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td>Job Title</td><td><textarea name='job_title' rows='2' cols='40' readonly='readonly'>$job_title</textarea></td></tr>";
	
	
	
	echo "<tr><td>phone_number</td><td><input type='text' name='phone_number' value='$phone_number' size='10' readonly='readonly' autocomplete='off'></td></tr>";
	
	
	//echo "<tr><td></td><td>Reg=1656 CI=1669</td></tr>";
	//echo "<tr><td>admin</td><td><input type='text' name='admin' value='$admin' size='5'></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	echo "<tr><td></td><td></td></tr>";
	
	
	
	
	//echo "<tr><td>Justification</td><td><input type='text' name='justification' value='$justification' autocomplete='off' size='50'></td></tr>";
	echo "<tr><td>Manager Justification</td><td><textarea name='justification_manager' rows='5' cols='40' readonly='readonly'>$justification_manager</textarea></td></tr>";
		
	if($formType=='Update')
	{	
	//echo "<tr><td>Comments</td><td><input type='text' name='comments' value='$comments'  autocomplete='off' size='50' autocomplete='off' ></td></tr>";
	
	echo "<tr><td><font color='red'>BUOF Comments</font></td><td><textarea name='comments' rows='2' cols='40' >$comments</textarea></td></tr>";
	
	}
	
	
	if($formType=='Find')
	{	
	//echo "<tr><td>Comments</td><td><input type='text' name='comments' value='$comments' readonly='readonly' autocomplete='off' size='50' autocomplete='off' ></td></tr>";
	
	echo "<tr><td><font color='red'>BUOF Comments</font></td><td><textarea name='comments' rows='2' cols='40' readonly='readonly'>$comments</textarea></td></tr>";
	
	
	}
	
	
	
	


	
	echo "<tr><td>last_four</td><td><input type='text' name='card_number' value=\"$card_number\" size='5'  autocomplete='off'></td></tr>";
	echo "<tr><td><font color='red'>monthly_limit</font></td><td><input type='text' name='monthly_limit' value='$monthly_limit' size='5' autocomplete='off' ></td></tr>";
	if($beacnum != '60032781')
	{
     echo "<tr><td>center</td><td><input type='text' name='center' value='$center' size='5' readonly='readonly' autocomplete='off'></td></tr>";	
	}

    if($beacnum == '60032781')
	{
     echo "<tr><td>center</td><td><input type='text' name='center' value='$center' size='5' autocomplete='off'></td></tr>";	
	}




	
	$act_id=strtolower($act_id);
	//if($act_id=="n"){$ckN="checked";$ckY="";}else{$ckN="";$ckY="checked";}
	if($act_id=="n"){$ckN="checked";$ckY="";$ckS="";}
	if($act_id=="y"){$ckY="checked";$ckN="";$ckS="";}
	if($act_id=="s"){$ckS="checked";$ckN="";$ckY="";}
	echo "<tr>";
	echo "<td>card valid</td>";
	echo "<td>N<input type='radio' name='act_id' value='n'$ckN> Y<input type='radio' name='act_id' value='y'$ckY>   S<input type='radio' name='act_id' value='s'$ckS></td>";
	echo "</tr>
	<tr><td>id$id</td><td></td></tr>";
	
	
	
	
	
	// echo "<tr><td>park</td><td><input type='text' name='park' value='$park' size='5'></td></tr>";
	//echo "<tr><td>location</td><td><input type='text' name='location' value='$location' size='12'></td></tr>";
	//echo "<tr><td>admin</td><td><input type='text' name='admin' value='$admin' size='5'></td></tr>";
	//echo "<tr><td>last_four</td><td><input type='text' name='card_number' value=\"$card_number\" size='25'></td></tr>";
	//echo "<tr><td>last_four</td><td><input type='text' name='last_four' value='$last_four' size='5'></td></tr>";
	
	}

echo "<tr><td>";
//echo "<input type='hidden' name='m' value='pcard'>";
echo "<input type='hidden' name='message' value='$message'>
<input type='hidden' name='id' value='$passID'>";
/*
echo "<input type='hidden' name='dncr' value='$dncr'>
<input type='hidden' name='employee' value='$employee'>
<input type='hidden' name='document_location' value='$document_location'>";
*/

echo "</td>";
//Tammy Dodd (60032781),Rachel Gooding (60032997)  unknown-> 60033019
/* 2022-02-22: CCOOPER - adding Boggus (60033242) and Williams (65032827)  
   2022-03-11: CCOOPER - adding Rumble (60036015) and Rouhani (65032850) */

 if($beacnum=='60032781'
 or $beacnum=='60032997'
 or $beacnum=='60033019'
 or $beacnum=='60036015'
 or $beacnum=='60033242'
 or $beacnum=='65032827'
 or $beacnum=='65032850')
/* 2022-02-22: End CCOOPER
   2022-03-11: End CCOOPER*/
{
echo "<td><input type='submit' name='submit_acs' value='$formType'>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";


//echo "</form><td>";
echo "</td>";
}
//Jennifer Goss

if((($beacnum=='60032787' or $beacnum=='60032794') and $formType=='Find'))
{

echo "<td><input type='submit' name='submit_acs' value='$formType'>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";


//echo "</form><td>";
echo "</td>";
}


if((($level==2) and $formType=='Find'))
{

echo "<td><input type='submit' name='submit_acs' value='$formType'>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ";


//echo "</form><td>";
echo "</td>";
}




echo "</form>";
//Tammy Dodd (60032781)  Rachel Gooding (60032997)
/* 2022-03-11: CCOOPER - adding addtl Bus Off personnel:
   Rumble (60036015), Boggus (60033242), Carmen Williams (65032827), and Rouhani (65032850)
*/
if($formType=='Update' and 
	($beacnum=='60032781' or 
	 $beacnum=='60032997' or
	 $beacnum=='60036015' or
   $beacnum=='60033242' or
   $beacnum=='65032827' or
   $beacnum=='65032850'))
{	
/* 2022-03-11: End CCOOPER */
echo "<td><form action='edit_pcardholders_duplicate.php'><input type='hidden' name='id_duplicate' value='$id'><input type='hidden' name='admin' value='$admin'><input type='submit' name='submit_duplicate' value='Duplicate'></form></td>";
}



/*
echo "<td><form action=''> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<input type='hidden' name='parkcode' value='$parkcode'>
<input type='hidden' name='m' value='pcard'>
<input type='hidden' name='id' value='$id'>
<input type='submit' name='submit_acs' value='Delete'>
</form></td>";
*/
echo "</tr></table></body></html>";
?>
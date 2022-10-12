<?php
/*   *** INCLUDE file inventory ***
include("/opt/library/prd/WebServer/include/iConnect.inc")
include("../../../include/activity.php")
include("../../budget/~f_year.php")
include ("../../budget/menu1415_v1.php")
include("pcard_new_menu1.php")
include("../../budget/infotrack/slide_toggle_procedures_module2_pid74.php")
include("dpr_tempid_menu.php")

*/

session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

//if($tempID=='Turner2317' and $concession_location=='MEMI'){$posTitle='park superintendent';}
//echo "$tempID=$posTitle=$concession_location";

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

if($concession_location=='ADM'){$concession_location='ADMI';}

//$system_entry_date=date("Ymd");

extract($_REQUEST);
$menu='RCard';
$system_entry_date=date("Ymd");
$today_date=$system_entry_date;
$today_date2=date('m-d-y', strtotime($today_date));
//$edit='y';
//$deposit_id='104885853';

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";  //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
/*
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
*/
//echo "<br />";
//echo $filegroup;


echo "<html>";
echo "<head>
<title>MoneyTracker</title>";
echo "<script language='JavaScript'>

function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete PCARD Request?')
 return (bConfirm);
}

function confirmLink2()
{
 bConfirm=confirm('Are you sure you want to approve this score?')
 return (bConfirm);
}


";
echo "</script>";


//echo "<link rel='stylesheet' type='text/css' href='1533d.css' />";

echo "</head>";

//include("../../budget/menu1314.php");
//echo "<br />Line 99: concession_location=$concession_location<br />";
include ("../../budget/menu1415_v1.php");
//echo "<br />Line 101: concession_location=$concession_location<br />";
/*
if($beacnum=='60033093'){$concession_location='PIRE';}  //valerie mitchener
if($beacnum=='60033019'){$concession_location='PIRE';}  //jay greenwood

if($beacnum=='60032892'){$concession_location='CORE';}  //sherry quinn
if($beacnum=='60032912'){$concession_location='CORE';}  //john fullwood


if($beacnum=='60032931'){$concession_location='MORE';}  //julie bunn
if($beacnum=='60032913'){$concession_location='MORE';}  //sean mcelhone
*/


// Changes made 06/20/20-TBASS (Start)


if($beacnum=='60033093'){$concession_location='SOUTH';}  //South District OA
if($beacnum=='60033019'){$concession_location='SOUTH';}  //South District Super

if($beacnum=='60032892'){$concession_location='EAST';}  //East District OA
if($beacnum=='60032912'){$concession_location='EAST';}  //East District Super


if($beacnum=='60032931'){$concession_location='WEST';}  //West District OA
if($beacnum=='60032913'){$concession_location='WEST';}  //West District Super

if($beacnum=='65030652'){$concession_location='NORTH';}  //North District Super
if($beacnum=='60032920'){$consession_location='NORTH';}  //North District OA


// Changes made 06/20/20-TBASS (End)



//if($beacnum=='60032920'){$concession_location='OPAD';}  //derrick evans(beacnum was chop oa); now beacnum is NODI OA
if($beacnum=='60033148'){$concession_location='OPAD';} // DDofOps OA
//if($beacnum=='65027688'){$concession_location='FAMA';}  //matthew davis (beacnum was MM OA)
if($beacnum=='65027688'){$concession_location='FAMA';}  //matthew davis - needs to be changed to DDofOps OA




//include("1418.html");
echo "<style>";
echo "input[type='text'] {width: 200px;}";

echo "</style>";


echo "<br />";
//if($beacnum=='60033093'){echo "Line 113: concession_location=$concession_location<br />";}
include("pcard_new_menu1.php");
//if($beacnum=='60033093'){echo "Line 115: concession_location=$concession_location<br />";}
echo "<br />";
include("../../budget/infotrack/slide_toggle_procedures_module2_pid74.php");
if($posTitle=='park superintendent'){$pasu_role='y';} else {$pasu_role='n';}

if($posTitle!='park superintendent')
{
	
$query1a="select count(id) as 'manager_count'
          from cash_handling_roles
		  where role='manager' and tempid='$tempid' ";	

//echo "query1a=$query1a<br /><br />";		  

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);
//echo "<br />Line 145: concession_location=$concession_location<br />";
if($manager_count==1){$pasu_role='y';}	
	
	} 

//echo "pasu_role=$pasu_role<br />";
//echo "hello cash_imprest_count2_report.php<br />";
$query1a="select count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	

//echo "query1a=$query1a<br /><br />";		  

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);
//echo "Line 60: cashier_count=$cashier_count<br />";


$query1b="select count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	

//echo "query1b=$query1b<br /><br />";		  

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
//echo "manager_count=$manager_count<br />";
if($beacnum=='60033093'){$cashier_count=1;}  // SODI OA
if($beacnum=='60033019'){$manager_count=1; $pasu_role='y';}  //NODI DISU

if($beacnum=='60032892'){$cashier_count=1;}  //EADI OA
if($beacnum=='60032912'){$manager_count=1; $pasu_role='y';}  //NODI DISU

if($beacnum=='60032931'){$cashier_count=1;}  //WEDI OA
if($beacnum=='60032913'){$manager_count=1; $pasu_role='y';}  //WEDI DISU

if($beacnum=='60032920'){$cashier_count=1;} // NODI OA
if($beacnum=='65030652'){$manager_count=1;} // NODI DISU

//echo "<br />Line 188: concession_location=$concession_location<br />";
if($report_type=='form')
{
if($beacnum=='60033138'){$concession_location='ADMN';}  //steve livingstone

//if($beacnum=='60095523')
{
$no_posnum_dropdown=array("ADMI","ADMN","DEDE","EADI","FAMA","CORE","MORE","PIRE","NARA","NODI","OPAD","PIRE","REMA","SODI","STPA","WAHO","WEDI");

if(in_array($concession_location,$no_posnum_dropdown)){$posnum_dropdown="no";} else {$posnum_dropdown="yes";}	

echo "<br />posnum_dropdown=$posnum_dropdown<br />";	
echo "<br />concession_location=$concession_location<br />";
if($posnum_dropdown=="yes")
{	
//include("beacon_posnumber_menu.php");	
include("dpr_tempid_menu.php");	
}
	
	
}
//{
//echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='bank_deposit_slip_update.php'>";
//if($beacnum!='60095523')
if($posnum_dropdown!='yes')
{
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='pcard_request2.php'>";
}

//if($beacnum=='60095523')
if($posnum_dropdown=='yes')
{
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='pcard_request2a.php'>";
}







//echo "<tr><td>parkcode</td><td><input type='text' name='parkcode' value='$parkcodeACS' size='5'></tr>";
//echo "<table align='center'><tr><th>admin</th><td><input type='text' name='admin' value='$parkcodeACS' size='5' autocomplete='off'></tr>";
echo "<br />";
echo "<table align='center'><tr><th><font color='red'>Employee PCARD Request</font></th></tr></table>";
echo "<br />";
echo "<table align='center' >";
//echo "<tr><th colspan='2'>Employee PCARD Request</th></tr>";

// Laura fuller (natural resources oa)  //derrick evans (chop oa)  //matthew davis (chief of maintenance oa) //tammy dodd (budget officer)
//if($beacnum != '60032794'  and $beacnum != '60032920' and $beacnum != '65027688' and $beacnum != '60032781')

// Laura fuller (natural resources oa)  //pacita grimes (Deputy Dir of Ops OA)  //matthew davis (chief of maintenance oa) //tammy dodd (budget officer)

/* 2022-06-20: CCOOPER added Rouhani (65032850) access -- code added: and $beacnum != '65032850' */
if($beacnum != '60032794'  and $beacnum != '60033148' and $beacnum != '65027688' and $beacnum != '60032781' and $beacnum != '65032850')
/* 2022-06-20: End CCOOPER */
{
echo "<tr><th>admin</th><td><input type='text' name='admin' value='$concession_location' size='5' readonly='readonly' autocomplete='off'></tr>";
}
// Laura Fuller (natural resources oa)
if($beacnum == '60032794')
{
//echo "<tr><th>admin</th><td><input type='text' name='admin' value='$concession_location' size='5' readonly='readonly' autocomplete='off'></tr>";
echo "<tr><th>admin</th><td><select name='admin'>
  <option value=''></option>
  <option value='nara'>nara</option>
  <option value='rema'>rema</option>
  <option value='stpa'>stpa</option>
 </select></td></tr>";	

}

/*
// Derrick Evans (chop oa); now NODI OA
if($beacnum == '60032920')
{
	echo "<tr><th>admin</th><td><select name='admin'>
  <option value=''></option>
  <option value='opad'>opad</option>
  <option value='fama'>fama</option>
  </select></td></tr>";	 
}
*/

// was Derrick Evans (chop oa); now Deputy Dir of Ops OA
//if($beacnum == '60032920') // beacon number was moved to NODI OA
if($beacnum == '60033148')
{
//echo "<tr><th>admin</th><td><input type='text' name='admin' value='$concession_location' size='5' readonly='readonly' autocomplete='off'></tr>";
echo "<tr><th>admin</th><td><select name='admin'>
  <option value=''></option>
  <option value='opad'>opad</option>
  <option value='fama'>fama</option>
  </select></td></tr>";	

}


// Matthew Davis (chief of maintenance oa)
if($beacnum == '65027688')
{
//echo "<tr><th>admin</th><td><input type='text' name='admin' value='$concession_location' size='5' readonly='readonly' autocomplete='off'></tr>";
echo "<tr><th>admin</th><td><select name='admin'>
  <option value=''></option>
  <option value='opad'>opad</option>
  <option value='fama'>fama</option>
  </select></td></tr>";	

}


// Tammy Dodd (budget officer)
/* 2022-06-20: CCOOPER added Rouhani (65032850) access -- code added: or $beacnum == '65032850'*/
if($beacnum == '60032781' or $beacnum == '65032850')
/* 2022-06-20: End CCOOPER */
{
//echo "<tr><th>admin</th><td><input type='text' name='admin' value='$concession_location' size='5' readonly='readonly' autocomplete='off'></tr>";
echo "<tr><th>admin</th><td><select name='admin'>
  <option value=''></option>
  <option value='admn'>admn</option>
  </select></td></tr>";	

}



	
	//echo "	<tr><td>admin</td><td><input type='text' name='admin' value='$admin' size='5'></td></tr>";
	//echo "<tr><th title='reg=1656 ci=1669'>location</th><td><input type='text' name='location' value='$location' size='5' autocomplete='off'></td></tr>";
	//echo "<tr><th>center</th><td><input type='text' name='center' value='$center' size='5' autocomplete='off'></td></tr>";	
	/*
	echo "<tr><th>last_name</th><td><input name=\"last_name\" type=\"text\" value=\"$last_name\" autocomplete='off'>
	</td></tr>";
	echo "<tr><th>first_name + middle initial</th><td><input type='text' name='first_name' value='$first_name' autocomplete='off'></td></tr>";
	*/
	
	

//if($beacnum=='60095523')
if($posnum_dropdown=='yes')
{
echo "<tr>";
echo "<th><font color='brown'>Employee ID</font></th>";
//echo "<td><input type='text' name='position_number' value='$position_number' size='10' autocomplete='off'></td>";

//echo "<td>";
echo "<td>";
echo "<select name=\"tempid_name\"><option value=''></option>";

for ($n=0;$n<count($tempidArray);$n++){
$con=$tempidArray[$n];
if($tempid_name==$con){$s="selected";}else{$s="value";}
//echo "<option $s='$con'>$locationArray[$n]</option>\n";
echo "<option $s='$con'>$tempidArray[$n]</option>\n";
       }

echo "</select>";
echo "</td>"; 
//echo "Input Box";
//echo "</td>";


echo "</tr>";


}

	
	
	
//if($beacnum!='60095523')
if($posnum_dropdown!='yes')	
{
echo "<tr><th>Beacon <font color='red'>employee number</font></th><td><input type='text' name='employee_number' value='$employee_number' size='10 autocomplete='off'></td></tr>";

echo "<tr><th>Beacon <font color='red'>position number</font></th><td><input type='text' name='position_number' value='$position_number' size='10' autocomplete='off'></td></tr>";

}	
	
	

	




	
	//echo "<tr><th>phone_number</th><td><input type='text' name='phone_number' value='$phone_number' size='10' autocomplete='off'></td></tr>";
	//echo "<tr><th>Justification</th><td><textarea name='justification' rows='5' cols='40'>$justification</textarea></td></tr>";
		
	echo "<tr><th>card_type</th><td><select name='card_type'>
  <option value=''></option>
  <option value='reg'>regular</option>
  <option value='ci'>capital_improvement</option>
 </select></td></tr>";	
 echo "<tr>";
 echo "<th>Upload *Completed* DNCR Form (PDF Only)</th>";
 echo "<td>";
 echo "<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'>";
/* 
echo "<input type='hidden' name='orms_deposit_id' value='$orms_deposit_id'>
<input type='hidden' name='id' value='$id'>";
*/
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<th></th>";
echo "<td>";
//if($beacnum=='60095523')
{
echo "<input type='submit' name='submit' value='Submit'>";
}
/*
if($beacnum!='60095523')
{
echo "<input type='submit' name='submit' value='Submit'>";
}
*/


echo "</td>";
echo "</tr>";

	
	
	
	
	
	
	
	echo "</table>";
echo "</form>";
exit;

}	

// Rachel Gooding (60032997) or Tammy Dodd (60032781)
/* 2022-02-21: CCOOPER adding A Boggus (60033242) and Carmen Williams (65032827) to "Card Request"

   2022-03-14: CCOOPER adding H Rumble (60036015) and M Rouhani (65032850) */
if($beacnum=='60032997' or 
	 $beacnum=='60032781' or 
	 $beacnum=='60033242' or 
	 $beacnum=='65032827' or
	 $beacnum=='60036015' or
	 $beacnum=='65032850')  
	/* 2022-02-21: End CCOOPER  
	   2022-03-14: End CCOOPER*/
{

$query11="SELECT * from pcard_users
WHERE 1
and act_id='p' 
and manager != ''
order by admin ";	

/*
$query11="SELECT * from pcard_users
WHERE 1
and (act_id='p') or (act_id='y' and fs_approver != '')
and manager != ''
order by admin ";
*/

}
else
{
	/*
$query11="SELECT * from pcard_users
WHERE 1
and (admin='$concession_location' and act_id='p') or (admin='$concession_location' and act_id='y' and fs_approver != '') ";
*/
if($beacnum != '60032794' and $beacnum != '60033138' and $beacnum != '60033160')  //laura fuller  //steve livingstone //brian strong
{	
	if ($beacnum == '65030652')
	{
		
		$query11 = "SELECT *
								FROM pcard_users
								WHERE (admin = 'NORTH' or admin = 'nodi')
									AND act_id =  'p'
								";
		
	}
	else
	{
			$query11 = "SELECT *
									FROM pcard_users
									WHERE admin = '$concession_location'
											AND act_id = 'p'
									";
	}
}

if($beacnum == '60032794')  //laura fuller
{	
$query11="SELECT * from pcard_users
WHERE 1
and ((admin='nara' or admin='rema' or admin='stpa') and (act_id='p')) ";
}


if($beacnum == '60033138')  //steve livingstone
{	
$query11="SELECT * from pcard_users
WHERE 1
and ((admin='admn' or admin='fama' or admin='opad') and (act_id='p')) ";
}


if($beacnum == '60033160')  //brian strong
{	
$query11="SELECT * from pcard_users
WHERE 1
and ((admin='nara') and (act_id='p')) ";
}

/*
if($beacnum == '60032920' or $beacnum == '65027688')  //derrick evans // matthew davis
{	
$query11="SELECT * from pcard_users
WHERE 1
and ((admin='opad' or admin='fama') and (act_id='p')) ";
}
*/

if($beacnum == '60033148' or $beacnum == '65027688') // DD of Ops OA and MM OA
{	
$query11="SELECT * from pcard_users
WHERE 1
and ((admin='opad' or admin='fama') and (act_id='p')) ";
}




}
echo "query11=$query11<br /><br />";
//echo "<pre>";print_r($_SESSION);"</pre>";  //exit;



if($beacnum=='60033018' //adrian o'neal
 or $beacnum=='60032779' //reuter
 or $beacnum=='60033202' //tingley
 or $beacnum=='60033012'  //howerton
 )
{
/*
$query11="SELECT * from pcard_users
WHERE 1
and (act_id='p') or (act_id='y' and fs_approver != '')
and manager != ''
and (admin='dede' or admin='admn' or admin='nara')
order by admin ";
*/

$query11="SELECT * from pcard_users
WHERE 1
and (act_id='p') 
and (admin='dede' or admin='admn' or admin='nara' or admin='opad' or admin='fama')
order by admin ";



}





 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		
//echo "query11=$query11<br />";
echo "<br />";
echo "<table align='center' ><tr><th><font size='5' color='brown' ><b>Cards Requested: $num11</font></th></tr></table><br />";
//echo "<br />cashier_count=$cashier_count<br />";
if($cashier_count==1)
{
echo "<table align='center' ><tr><th><font><b><a href='pcard_request4.php?report_type=form'>New Request</a></font></th></tr></table><br />";
}
if($num11>0)
{	
echo "<table  align='center'>";
//echo "<br />student_score=$student_score<br />";

echo 

"<tr>"; 
//if($cashier_count=='1' or $beacnum=='60032997')
if($cashier_count=='1')
       {
       echo "<th></th>";
	   }
	  	   
       echo "<th align=left><font color=brown>Admin <br />Request#</font></th>
	   <th align=left><font color=brown>Cashier<br />Requestor</font></th>
       <th align=left><font color=brown>Employee Info</font></th>       
       
	   <th align=left><font color=brown>Employee<br />verifies knowledge of<br />Purchasing Guidelines</font></th>
	   <th align=left><font color=brown>Manager<br />Approver</font></th>
	   
	   <th align=left><font color=brown>BUOF<br />Approver</font></th>
	   <th align=left><font color=brown>Completed<br />DNCR Form</font></th>  ";
	  
	   
	  
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
//$park_oob=$cashier_amount-$manager_amount;
$cashier3=substr($cashier,0,-2);
$pcard_holder3=substr($pcard_holder,0,-2);
$student_id=substr($student_id,0,-2);
$manager3=substr($manager,0,-2);
$manager_comment_name3=substr($manager_comment_name,0,-2);
$fs_comment_name3=substr($fs_comment_name,0,-2);
$fs_approver1a=substr($fs_approver,0,-2);
$fs_approver2a=substr($fs_approver2,0,-2);
$manager_comment_date_dow=date('l',strtotime($manager_comment_date));

if($cashier_date=='0000-00-00')
{$cashier_date_dow='';}
else
{$cashier_date_dow=date('l',strtotime($cashier_date));}


if($manager_date=='0000-00-00')
{$manager_date_dow='';}
else
{$manager_date_dow=date('l',strtotime($manager_date));}


if($fs_approver_date=='0000-00-00')
{$fs_approver_date_dow='';}
else
{$fs_approver_date_dow=date('l',strtotime($fs_approver_date));}


if($fs_approver_date2=='0000-00-00')
{$fs_approver_date2_dow='';}
else
{$fs_approver_date2_dow=date('l',strtotime($fs_approver_date2));}








$cashier_date2=date('m-d-y', strtotime($cashier_date));
$pcard_holder_date2=date('m-d-y', strtotime($pcard_holder_date));
$student_test_date=date('m-d-y', strtotime($student_test_date));
$manager_date2=date('m-d-y', strtotime($manager_date));
$manager_comment_date2=date('m-d-y', strtotime($manager_comment_date));
$fs_comment_date2=date('m-d-y', strtotime($fs_comment_date));
$fs_approver_date1a=date('m-d-y', strtotime($fs_approver_date));
$fs_approver_date2a=date('m-d-y', strtotime($fs_approver_date2));


if($record_complete == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
echo "<tr$t>";
if($cashier_count=='1' and $pcard_holder == '')
{
echo "<td bgcolor='lightgreen'><a href=\"pcard_request_delete_rec.php?id=$id\" onClick='return confirmLink()'><img height='25' width='25' src='/budget/infotrack/icon_photos/mission_icon_photos_218.png' alt='picture of trash can' title='Delete Record'></img></a></td>";
}
if($cashier_count=='1' and $pcard_holder != '')
{
echo "<td bgcolor='lightgreen'></td>";
}


echo "<td bgcolor='lightgreen'>$admin$id</td>"; 

 //Cashier Count has 3 possible outcomes 
		   if($cashier=='' and $cashier_count==1)
			{
		   echo "<td bgcolor='lightpink'><a href='cash_count_cashier.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear' >Update</a></td>";
		   }  
		   //if 1)TABLE cash_imprest_count_detail.cashier is blank and 2)tempid is not a Cashier in cash_handling_roles.role
		   if($cashier=='' and $cashier_count != 1)
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }
		   if($cashier != '')
		   {
		   //echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		   echo "<td bgcolor='lightgreen'>";
		   
		   
		   // $cashier_count==1 gets the magnify glass to edit
		   if($cashier_count==1)
		   {
		   echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		   }
		   echo "<br />$cashier3<br />$cashier_date2<br />$cashier_date_dow<br /></td>";	
	       }
 
echo "<td bgcolor='lightgreen'>$first_name $middle_initial $last_name $suffix<br />Emp# $employee_number<br />Pos# $position_number<br />Title: $job_title<br />Phone# $phone_number<br />Location# $location</td>";


if($pcard_holder == '')
		   {
		   
		   echo "<td bgcolor='lightpink'></td>";
		   
		   
		   
	       }




if($pcard_holder != '')
		   {
		  
		   echo "<td bgcolor='lightgreen'>";
		   
		   
		  
		   echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$pcard_holder3<br />$pcard_holder_date2</td>";	
	       }
		
		
		   /*
if($student_score == '100.00')
{			
		    echo "<td bgcolor='lightgreen'>";		
			echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		   echo "<br />$student_id<br />$student_score<br />$student_test_date<br /></td>";	
			echo "</td>";		
}
*/


			
			//echo "<td>PASU</td>";
		   //Manager Count has 3 possible outcomes 
	
	  
	   if($manager=='' and $pasu_role == 'y' and $pcard_holder != '')//(manager_count == 1)
			{		   
		   echo "<td bgcolor='lightpink'><a href='pcard_manager_approval.php?id=$id' >Update</a></td>";
		   } 
		   /*
		   if($manager=='' and $pasu_role == 'y' and $student_score!='100.00')//(manager_count == 1)
			{		   
		   echo "<td bgcolor='lightpink'></td>";
	  */
	  
	  
	   if($manager=='' and $pasu_role == 'y' and $pcard_holder == '')
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }
	  
	  
	  
	  
		   
		  
		   if($manager=='' and $pasu_role != 'y')
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }

		  		   
		   
		   
		   if($manager != '')
		   {
		  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		  
		  if($manager_count==1)
		   {
		   //echo "<a href='cash_count_cashier.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear'><img height='25' width='25' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of green check mark'></img></a>";
		   }
		  
		  echo "<br />$manager3<br />$manager_date2<br />$manager_date_dow</td>";
	       }


//what Rachel (60032997) sees
/* 2022-02-21: CCOOPER adding A Boggus (60033242) and Carmen Williams (65032827) to "Card Request"

   2022-03-14: CCOOPER adding H Rumble (60036015) and M Rouhani (65032850) */

if($beacnum=='60032997' OR 
	 $beacnum=='60033242' OR 
	 $beacnum=='65032827' OR
	 $beacnum=='60036015' OR 
   $beacnum=='65032850')
	/* 2022-02-21: End CCOOPER
	   2022-03-14: End CCOOPER*/
{
if($fs_approver=='' or $fs_approver2=='')
{
if($fs_approver=='')
{	
echo "<td><a href='pcard_buof_approval.php?id=$id'>Update</a></td>";
}

if($fs_approver!='')
{	
echo "<td bgcolor='lightyellow'>Step11 of 12:<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$fs_approver1a<br />$fs_approver_date1a<a href='pcard_buof_approval.php?id=$id'><br /><br />Update</a></td>";
}



}

if($fs_approver!='' and $fs_apprver2!='')
{	
echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
echo "<br />$fs_approver2a<br />$fs_approver_date2a</td>";



}


}
//rachel (60032997) ends

/* 2022-02-21: CCOOPER - adding Boggus (60033242) and C Williams (65032827)
       // what everybody else sees
   2022-03-14: CCOOPER adding H Rumble (60036015) and M Rouhani (65032850)
*/

  if(($beacnum!='60032997') AND 
  	($beacnum!='60033242') AND 
  	($beacnum!='65032827') AND
  	($beacnum!='60036015') AND
  	($beacnum!='65032850'))
{
/* END 2022-02-21: End CCOOPER
	 END 2022-03-14: End CCOOPER*/

 /* if($fs_approver=='' and $fs_approver2=='')
    {
      echo "<td bgcolor='lightpink'>1</td>";
    }	
 */

  if($fs_approver=='' or $fs_approver2=='')
  {
    if($fs_approver=='')
    {	
      echo "<td bgcolor='lightpink'>1</td>";
    }

    if($fs_approver!='')
    {	
      echo "<td bgcolor='lightyellow'>Step11 of 12:<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$fs_approver1a<br />$fs_approver_date1a</td>";
    }
  }

  if($fs_approver!='' and $fs_apprver2!='')
  {	
    echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
    echo "<br />$fs_approver2a<br />$fs_approver_date2a</td>";
  }
}
//everybody else ends

/*
if($fs_approver=='' or $fs_approver2=='')
{
echo "<td><a href='$document_location' target='_blank'>VIEW</a></td>";		   
}		 



if($fs_approver!='' and $fs_approver2!='')
{
echo "<td><a href='$document_location_final' target='_blank'>VIEW</a></td>";		   
}		 
*/
if($document_location != '' or $document_location_final != '')
{
	
if($document_location_final != '')
{
echo "<td><a href='$document_location_final' target='_blank'>VIEW</a></td>";
}	
else	
{
echo "<td><a href='$document_location' target='_blank'>VIEW</a></td>";
}		
	
}	

if($document_location=='' and $document_location_final=='')
{
echo "<td></td>";
}			  

/* 2022-06-20: CCOOPER added Rouhani (65032850) access -- code added: or $beacnum=='65032850' */
if(($beacnum=='60032781' or $beacnum=='60032793' or $beacnum=='65032850') and ($act_id=='p') and ($fs_approver==''))
/* 2022-06-20: End CCOOPER */
{
echo "<td bgcolor='lightgreen'><a href=\"pcard_request_delete_rec.php?id=$id\" onClick='return confirmLink()'><img height='25' width='25' src='/budget/infotrack/icon_photos/mission_icon_photos_218.png' alt='picture of trash can' title='Delete Record'></img></a></td>";
}
echo "</tr>";

}

 echo "</table>";
 
}


?>
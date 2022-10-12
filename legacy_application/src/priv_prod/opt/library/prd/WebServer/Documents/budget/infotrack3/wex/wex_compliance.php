<?php

//if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$system_entry_date=date("Ymd");
$system_entry_date2=date('m-d-y', strtotime($system_entry_date));
$system_entry_date_dow=date('l',strtotime($system_entry_date));
//if($tempID=='McGrath9695'){echo "hello $posTitle Nora Coffey";} else {echo "hello world";}



//if($tempID=='Robinson8024' and $concession_location=='STMO'){$posTitle='park superintendent';}
//if($tempID=='Church9564' and $concession_location=='LANO'){$posTitle='park superintendent';}
//if($tempID=='Crider2443' and $concession_location=='GOCR'){$posTitle='park superintendent';}
//if($tempID=='Rogers2949' and $concession_location=='PETT'){$posTitle='park superintendent';}
//if($tempID=='Newsome1830' and $concession_location=='MEMO'){$posTitle='park superintendent';}
//if($tempID=='Kendrick3113' and $concession_location=='HABE'){$posTitle='park superintendent';}
//if($tempID=='Murr7025' and $concession_location=='MOMO'){$posTitle='park superintendent';}


//echo "$tempID=$posTitle=$concession_location";
if($posTitle=='park superintendent'){$pasu_role='y';} else {$pasu_role='n';}
/*
if($posTitle=='park superintendent'){echo "<font color='brown'><b>hello park superintendent</b></font>";}
*/

if($posTitle=='park superintendent'){$pasu_role='y';}
$menu='pci';

extract($_REQUEST);

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

//if(@$f_year==""){include("../~f_year.php");}
//echo "f_year=$f_year";
//if($wex_year==''){$wex_fyear='1819';}

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");
//echo "concession_location=$concession_location<br />";
//echo "park=$park<br />";
if($park != ''){$concession_location=$park;}
$query1b="select count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempID' ";	 

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
//echo "query1b=$query1b<br />";
//echo "manager_count=$manager_count<br />";

if($manager_count==1){$pasu_role='y';}


include ("../../../budget/menu1415_v1.php");
echo "<br />";


if($park!=''){$parkcode=$park;}
if($park==''){$parkcode=$concession_location;}


//include ("concessions_main_menu.php");
//include ("concessions_pci_menu.php");

$query8a="select text_code from svg_graphics where id='10'  ";
		 
//echo "query8a=$query8a<br />";		 

$result8a = mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");

$row8a=mysqli_fetch_array($result8a);
extract($row8a);	

echo "<br /><table align='center'><tr><th>$text_code <br />Monthly Fuel Verification</font></b></th></tr></table>";




//include("concessions1_instructions.php");
include("wex_compliance_instructions.php");

echo "<br />";
/*
echo "<table align='center'><tr><td><font color='red' size='6'>PCI Compliance Under Construction (Target Date:  June 1, 2017)</td></tr></table><br />";
*/
//echo "<br />";
//include ("concessions1_fyear.php");
include ("wex_compliance_fyear.php");
echo "<br />";
$wex_fyear=$fyear;

if($park!=''){$concession_location=$park;}
$query1="SELECT sum(score) as 'score_total'
from wex_vehicle_compliance
WHERE 1
and park='$concession_location'
and wex_fyear='$wex_fyear'
and valid='y'
";

//echo "<br />query1=$query1<br />";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);


$query2="SELECT count(id) as 'score_records'
from wex_vehicle_compliance
WHERE 1
and park='$concession_location'
and wex_fyear='$wex_fyear'
and valid='y'
";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$row2=mysqli_fetch_array($result2);
extract($row2);



$score=$score_total/$score_records;

$score=round($score);









//echo "hello cash_imprest_count2_report.php<br />";
$query1a="select count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	 

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);
//if($tempid=='McGrath9695'){echo "cashier_count=$cashier_count<br />";}

/*
$query1b="select count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	 

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
*/


//echo "manager_count=$manager_count<br />";

/*
if($pasu_comment != '')
{
$pasu_comment=addslashes($pasu_comment);
$pasu_comment_query="update wex_vehicle_compliance set manager_comment='$pasu_comment',manager_comment_name='$tempID',manager_comment_date='$system_entry_date' where id='$comment_id' ";

$result_pasu_comment_query=mysqli_query($connection, $pasu_comment_query) or die ("Couldn't execute query pasu comment query. $pasu_comment_query");


//echo "comment_update_query=$comment_update_query<br />";
}
*/



/*
if($fs_comment != '')
{
$fs_comment=addslashes($fs_comment);
$fs_comment_query="update wex_vehicle_compliance set fs_comment='$fs_comment',fs_comment_name='$tempID',fs_comment_date='$system_entry_date' where id='$comment_id' ";

$result_fs_comment_query=mysqli_query($connection, $fs_comment_query) or die ("Couldn't execute query fs comment query. $fs_comment_query");


//echo "comment_update_query=$comment_update_query<br />";
}
*/



if($beacnum!='60032794' and $beacnum != '60032920' and $beacnum != '60033012' and $beacnum != '60033018')
{
$query11="SELECT park as 'parkcode',center,wex_fyear,wex_month,wex_month_number,wex_month_calyear,cashier,cashier_amount,cashier_date,manager,manager_date,score,valid,id
from wex_vehicle_compliance
WHERE 1
and park='$parkcode'
and wex_fyear='$wex_fyear'
and valid='y'
group by id
order by wex_month_number desc ";
}

//laura fuller
if($beacnum=='60032794')
{
$query11="SELECT park as 'parkcode',center,wex_fyear,wex_month,wex_month_number,wex_month_calyear,cashier,cashier_amount,cashier_date,manager,manager_date,score,valid,id
from wex_vehicle_compliance
WHERE 1
and (park='nara' or park='rema')
and wex_fyear='$wex_fyear'
and valid='y'
group by id
order by wex_month_number desc ";
}


//derrick evans
if($beacnum=='60032920')
{
$query11="SELECT park as 'parkcode',center,wex_fyear,wex_month,wex_month_number,wex_month_calyear,cashier,cashier_amount,cashier_date,manager,manager_date,score,valid,id
from wex_vehicle_compliance
WHERE 1
and (park='fama' or park='ined' or park='opad' or park='rale')
and wex_fyear='$wex_fyear'
and valid='y'
group by id
order by wex_month_number desc ";
}

//adrian oneal
if($beacnum=='60033018')
{
$query11="SELECT park as 'parkcode',center,wex_fyear,wex_month,wex_month_number,wex_month_calyear,cashier,cashier_amount,cashier_date,manager,manager_date,score,valid,id
from wex_vehicle_compliance
WHERE 1
and (park='ined' or park='opad' or park='rale')
and wex_fyear='$wex_fyear'
and valid='y'
group by id
order by wex_month_number desc ";
}

// jerry howerton
if($beacnum=='60033012')
{
$query11="SELECT park as 'parkcode',center,wex_fyear,wex_month,wex_month_number,wex_month_calyear,cashier,cashier_amount,cashier_date,manager,manager_date,score,valid,id
from wex_vehicle_compliance
WHERE 1
and (park='fama')
and wex_fyear='$wex_fyear'
and valid='y'
group by id
order by wex_month_number desc ";
}







//echo "query11=$query11<br />";

 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		
//echo "query11=$query11<br />";

/*
$start_date2=date('m-d-y', strtotime($start_date));
$end_date2=date('m-d-y', strtotime($end_date));

$start_date_dow=date('l',strtotime($start_date));
$end_date_dow=date('l',strtotime($end_date));
*/

//echo "<br /><br />";
/*
echo "<table align='center' border='1'>";
echo "<tr><th>cashier_count=$cashier_count</th><th>pasu_role=$pasu_role</th></tr>";

echo "</table>";
*/
//echo "<br /><br />";
echo "<table align='center'><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score: &nbsp;&nbsp; $score</b></font></th></tr></table><br />";
/*
echo "<table align='center'>";
echo "<tr><th><img height='25' width='25' src='/budget/infotrack/icon_photos/info2.png' alt='reports icon' title='Wex Verification'></img> WEX Fuel Verification is not available until <font color='red'>March 1, 2018</font></th></tr>";
echo "</table>";
echo "<br />";
*/

echo "<table align='center'>";

echo 

"<tr> 
       <th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Center</font></th>       
       <th align=left><font color=brown>Month</font></th>
       <th align=left><font color=brown>Cashier</font></th>
	   <th align=left><font color=brown>Manager</font></th>";
	   /*
	   echo "<th align=left><font color=brown>Park<br />Match</font></th>
	   <th align=left><font color=brown>Authorized<br />Match</font></th>
	   <th align=left><font color=brown>BUOF<br />Comments</font></th>";
	   */
	   //echo "<th align=left><font color=brown>BUOF<br />Verify</font></th>";
	   echo "<th align=left><font color=brown>Score</font></th>";
	   //echo "<th align=left><font color=brown>Document</font></th>";
	//echo "<th align=left><font color=brown>Cash<br />Receipts<br />Journal</font></th>";
	   
       
      
       
              
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
$manager3=substr($manager,0,-2);
$refund_total=number_format($refund_total,2);

if($cashier_date=='0000-00-00')
{$cashier_date_dow='';}
else
{$cashier_date_dow=date('l',strtotime($cashier_date));}


if($manager_date=='0000-00-00')
{$manager_date_dow='';}
else
{$manager_date_dow=date('l',strtotime($manager_date));}

/*
if($fs_approver_date=='0000-00-00')
{$fs_approver_date_dow='';}
else
{$fs_approver_date_dow=date('l',strtotime($fs_approver_date));}

*/

$cashier_date2=date('m-d-y', strtotime($cashier_date));
$manager_date2=date('m-d-y', strtotime($manager_date));
//$manager_comment_date2=date('m-d-y', strtotime($manager_comment_date));

if($record_complete == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
echo 

"<tr$t>
		   	<td bgcolor='lightgreen'>$parkcode</td>  
		    <td bgcolor='lightgreen'>$center</td>
		    <td bgcolor='lightgreen'>$wex_month</td>";
		    //echo "<td>$deposit_date2<br />$deposit_date_dow</td>";
		    //echo "<td>$bank_deposit_date2<br /></td>";
			
			// changed on 09/15/14
			/*
			if($cashier=='')
			{
		   echo "<td bgcolor='lightpink'><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' >Cashier<br />Update</a></td>";
		   }
		   */
		   
		   //Cashier Count has 3 possible outcomes 
		   if($cashier=='' and $cashier_count==1)
			{
		   echo "<td bgcolor='lightpink'><a href='wex_compliance_vehicles.php?parkcode=$parkcode&wex_month=$wex_month&wex_fyear=$wex_fyear&wex_month_calyear=$wex_month_calyear' >Cashier<br />Update</a></td>";
		   }  
		   //if 1)TABLE concessions_pci_compliance.cashier is blank and 2)tempid is not a Cashier in cash_handling_roles.role
		   if($cashier=='' and $cashier_count != 1)
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }
		   if($cashier != '')
		   {
		   echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		   
		   // $cashier_count==1 gets the magnify glass to edit
		   if($cashier_count==1)
		   {
		   echo "<a href='wex_compliance_vehicles.php?parkcode=$parkcode&wex_month=$wex_month&wex_fyear=$wex_fyear&wex_month_calyear=$wex_month_calyear&wex_month_number=$wex_month_number'><img height='25' width='25' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of green check mark'></img></a>";
		   }
		   echo "<br />$cashier3<br />$cashier_date2<br />$cashier_date_dow</td>";	
	       }
		   /*
		   echo "<td>$controllers_deposit_id<br /><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";
		   */
		  
		   
		   // echo "<td>manager=$manager<br />pasu_role=$pasu_role<br />cashier=$cashier</td>";  
		   //Manager Count has 3 possible outcomes 
		   if($manager=='' and $pasu_role == 'y' and $cashier != '')//(manager_count == 1)
			{		   
		   echo "<td bgcolor='lightpink'><a href='wex_compliance_vehicles.php?parkcode=$parkcode&wex_month=$wex_month&wex_fyear=$wex_fyear&wex_month_calyear=$wex_month_calyear' >Manager<br />Update</a></td>";
		   } 
		   
		   if($manager=='' and $pasu_role == 'y' and $cashier == '')//(manager_count == 1)
			
		    {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }
		   
		   
		   
		   if($manager=='' and $pasu_role == 'n')
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }

		  		   
		   
		   
		   if($manager != '')
		   {
		  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		  
		  if($manager_count==1)
		   {
		   echo "<a href='wex_compliance_vehicles.php?parkcode=$parkcode&wex_month=$wex_month&wex_fyear=$wex_fyear&wex_month_calyear=$wex_month_calyear'><img height='25' width='25' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of green check mark'></img></a>";
		   }
		  
		  echo "<br />$manager3<br />$manager_date2<br />$manager_date_dow</td>";
	       }
		   
	
	      if($score=='0')
		  {
           echo "<td bgcolor='lightpink'>$score</td>";
		   }
		   else
		   {
		    echo "<td bgcolor='lightgreen'>$score</td>";	

		   }
		   
		   /*
		   
		    if($cashier == '' and $manager == '')
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   }
		   
		   
		   
		    if($cashier != '' and $manager == '')
		   {
		   echo "<td bgcolor='lightpink'><a href='pci_documents/concessions_pci_compliance_$id.pdf' target='_blank'>View</a></td>";
		   }
		   
		   
		     if($cashier != '' and $manager != '')
		   {
		   echo "<td bgcolor='lightgreen'><a href='pci_documents/concessions_pci_compliance_$id.pdf' target='_blank'>View</a></td>";
		   }
		  
		 
		*/
	
/*
if(
$beacnum=='60033160' //brian strong NARA (Natural Resources)
or $beacnum=='60032781' //tammy dodd ADMI (Administration)
or $beacnum=='60033012' //jerry howerton FAMA (Facilities Maintenance)
or $beacnum=='60033018' //adrian oneal OPAD  (Operations Administration)
or $beacnum=='60032912' //john fullwood (Coastal Region Manager)
or $beacnum=='60033019' //jay greenwood (Piedmont Region Manager)
or $beacnum=='60032913' //sean mcelhone (Mountain Region Manager)
or $beacnum=='60032833' //erin lawrence DEDE (Design & Development)
or $beacnum=='60032828' //jon blanchard REMA (Resource Management)
or $beacnum=='60036015' //heide rumble  Budget/Accounting Office
or $beacnum=='60033242' //rebecca owen  Budget/Accounting Office
)
{
echo "<td><a href='wex_compliance_vehicles.php?parkcode=$parkcode&wex_month=$wex_month&wex_fyear=$wex_fyear&wex_month_calyear=$wex_month_calyear'>Report</a></td>";
}	
 */         
echo "</tr>";




}

 echo "</table>";
 



?>
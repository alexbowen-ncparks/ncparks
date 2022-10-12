<?php

//if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://auth.dpr.ncparks.gov/login_form.php?db=budget");
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
if($concession_location=='ADM'){$concession_location='ADMI';}

//if($tempID=='Robinson8024' and $concession_location=='STMO'){$posTitle='park superintendent';}
if($tempID=='Church9564' and $concession_location=='LANO'){$posTitle='park superintendent';}
//if($tempID=='Crider2443' and $concession_location=='GOCR'){$posTitle='park superintendent';}
if($tempID=='Rogers2949' and $concession_location=='PETT'){$posTitle='park superintendent';}
if($tempID=='Newsome1830' and $concession_location=='MEMO'){$posTitle='park superintendent';}
if($tempID=='Kendrick3113' and $concession_location=='HABE'){$posTitle='park superintendent';}
if($tempID=='Murr7025' and $concession_location=='MOMO'){$posTitle='park superintendent';}


//echo "$tempID=$posTitle=$concession_location";
if($posTitle=='park superintendent'){$pasu_role='y';} else {$pasu_role='n';}
/*
if($posTitle=='park superintendent'){echo "<font color='brown'><b>hello park superintendent</b></font>";}
*/

if($posTitle=='park superintendent'){$pasu_role='y';}
$menu_new='MAppr';
//echo "<br />pasu_role=$pasu_role<br />";
extract($_REQUEST);

//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

//if(@$f_year==""){include("../~f_year.php");}
//echo "f_year=$f_year";


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
//echo "concession_location=$concession_location<br />";
//echo "park=$park<br />";
if($park != ''){$concession_location=$park;}

$query1b="select count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempID' ";	 
//echo "<br />query1b=$query1b";
$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
//echo "query1b=$query1b<br />";


$query1c="select region from center
          where fund='1280' and parkcode='$concession_location'  ";	 

$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

extract($row1c);
//echo "query1c=$query1c<br />";
if($region=='CORE' and $concession_location != 'EADI'){$region2='EADI';}
if($region=='PIRE' and $concession_location != 'SODI'){$region2='SODI';}
if($region=='MORE' and $concession_location != 'WEDI'){$region2='WEDI';}



//echo "<br />concession_location=$concession_location<br />";
//echo "<br />admin_num=$admin_num<br />";
//echo "<br />region=$region<br />";
//echo "<br />region2=$region2<br />";









//echo "manager_count=$manager_count<br />";

if($manager_count==1){$pasu_role='y';}


$menu_new='MAppr';

//include("1418.html");
//echo "<style>";
//echo "input[type='text'] {width: 200px;}";

//echo "</style>";


//echo "<br />";


if($beacnum=='60032833'){$park='DEDE'; $manager_count=1; $pasu_role='y';} //erin lawrence
if($beacnum=='60033160'){$park='NARA'; $manager_count=1; $pasu_role='y';} //brian strong
if($beacnum=='60032786'){$park='WAHO'; $manager_count=1; $pasu_role='y';} //kelly chandler
if($beacnum=='60033012'){$park='FAMA'; $manager_count=1; $pasu_role='y';} //jerry howerton
if($beacnum == '60033138'){$cashier_count=1;} //steve livingstone


if($park!=''){$parkcode=$park;}
if($park==''){$parkcode=$concession_location;}


//if($beacnum=='60032781' and $park=='EADI'){$manager_count=1; $pasu_role='y';} //tammy dodd
//if($beacnum=='60032781' and $park=='SODI'){$manager_count=1; $pasu_role='y';} //tammy dodd
//if($beacnum=='60032781' and $park=='WEDI'){$manager_count=1; $pasu_role='y';} //tammy dodd






//if($beacnum=='60033018' and $park=='EADI'){$manager_count=1; $pasu_role='y';} //adrian oneal
//if($beacnum=='60033018' and $park=='SODI'){$manager_count=1; $pasu_role='y';} //adrian oneal
//if($beacnum=='60033018' and $park=='WEDI'){$manager_count=1; $pasu_role='y';} //adrian oneal
if($beacnum=='60033018' or $beacnum=='60032779' or $beacnum=='60033202' or $beacnum=='60032781'){$manager_count=1; $pasu_role='y';} //adrian oneal/don reuter/carol tingley





$system_entry_date=date("Ymd");

//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;
if($cashier_approved=='y')
{
$query1="update pcard_report_dates_compliance
         set cashier='$cashier',cashier_date='$system_entry_date'
         where admin_num='$admin_num' and report_date='$report_date' ";	 
		 
//echo "<br />query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");	
{header("location: pcard_recon.php?report_date=$report_date&admin_num=$admin_num&submit=Find&rec_comp=y");}	
	
}


if($manager_approved=='y')
{
$query1="update pcard_report_dates_compliance
         set manager='$manager',manager_date='$system_entry_date'
         where admin_num='$admin_num' and report_date='$report_date' ";	 
		 
//echo "<br />query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");	
	
	
}



/*
echo "<table align='center'><tr><td><font color='red' size='6'>PCI Compliance Under Construction (Target Date:  June 1, 2017)</td></tr></table><br />";
*/
//echo "<br />";
//include ("concessions1_fyear.php");
//include ("concessions_pci_fyear.php");
echo "<br />";


if($park!=''){$concession_location=$park;}




//echo "hello cash_imprest_count2_report.php<br />";
$query1a="select count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempid' ";	

//echo "query1a=$query1a";		  

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);
//if($tempid=='McGrath9695'){echo "cashier_count=$cashier_count<br />";}


$query1b="select count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempid' ";	 

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
//echo "manager_count=$manager_count<br />";
//echo "<br />park=$park<br />";
//echo "<br />parkcode=$parkcode<br />";
//echo "<br />concession_location=$concession_location<br />";




include ("../../budget/menu1415_v1.php");
include("pcard_new_menu1.php");
echo "<br />";
include("../../budget/infotrack/slide_toggle_procedures_module2_pid76.php");
include("pcard_recon_yearly_fyear.php");












//if($beacnum=='60032912'){$where=" or manager='$tempID' ";}  //john fullwood
//if($beacnum=='60033019'){$where=" or manager='$tempID' ";}  //jay greenwood
//if($beacnum=='60032913'){$where=" or manager='$tempID' ";}  //sean mcelhone

//echo "<br />park=$park<br />";

//and (admin_num='$parkcode' $where )  replaced with: and (admin_num='$parkcode')

//everyone except steve livingstone/jennifer goss/laura fuller/tammy dodd/adrian oneal/don reuter/carol tingley

if($beacnum != '60033138' and $beacnum != '60032787' and $beacnum != '60032794' and $beacnum != '60032781' and $beacnum != '60033018' and $beacnum != '60032779' and $beacnum != '60033202' )
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date,fs_approver,fs_approver_date,deadline_ok2
from pcard_report_dates_compliance
WHERE 1
and (admin_num='$parkcode' )
and fiscal_year='$fyear'
order by report_date desc ";
//echo "<br />query11==$query11<br />";
$query="SELECT count(id) as 'yes_deadline' from pcard_report_dates_compliance where 1 
        and admin_num='$parkcode' and fiscal_year='$fyear'
		and deadline_ok2='y'";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
$row=mysqli_fetch_array($result);
extract($row);

$query="SELECT count(id) as 'total_deadline' from pcard_report_dates_compliance where 1 
        and admin_num='$parkcode' and fiscal_year='$fyear'
		and deadline_ok2 != '' ";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
$row=mysqli_fetch_array($result);
extract($row);

//echo "<br />yes_deadline=$yes_deadline<br />";
//echo "<br />total_deadline=$total_deadline<br />";
$score=($yes_deadline/$total_deadline)*100;
if($total_deadline==0){$score='100.00';}
$score=number_format($score,0);
//echo "<br />score=$score<br />";


//$score='100';
echo "<table align='center'><tr><th><font size='5' color='brown' ><b>Score<br /> $score</b></font></th></tr></table><br />";
echo "<br />";




}

//steve livingstone
if($beacnum == '60033138')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date,fs_approver,fs_approver_date,deadline_ok2
from pcard_report_dates_compliance
WHERE 1
and (admin_num='admn' or admin_num='fama' or admin_num='opad')
and fiscal_year='$fyear'
order by report_date desc ";

}

//jennifer goss
if($beacnum == '60032787')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date,fs_approver,fs_approver_date,deadline_ok2
from pcard_report_dates_compliance
WHERE 1
and (admin_num='admn' or admin_num='fama' or admin_num='nara' or admin_num='dede' or admin_num='rema' or admin_num='opad' or admin_num='stpa')
and fiscal_year='$fyear'
order by report_date desc ";
}


//laura fuller
if($beacnum == '60032794')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date,fs_approver,fs_approver_date,deadline_ok2
from pcard_report_dates_compliance
WHERE 1
and (admin_num='admn' or admin_num='fama' or admin_num='nara' or admin_num='dede' or admin_num='rema' or admin_num='opad' or admin_num='stpa')
and fiscal_year='$fyear'
order by report_date desc ";
}


//laura fuller
if($beacnum == '60033012')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date,fs_approver,fs_approver_date,deadline_ok2
from pcard_report_dates_compliance
WHERE 1
and (admin_num='waho' or admin_num='fama')
and fiscal_year='$fyear'
order by report_date desc ";
}













//tammy dodd/adrian oneal/don reuter/carol tingley
if($beacnum == '60032781' or $beacnum == '60033018' or $beacnum == '60032779' or $beacnum == '60033202' )
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date,fs_approver,fs_approver_date,deadline_ok2
from pcard_report_dates_compliance
WHERE 1
and (admin_num='admn' or admin_num='fama' or admin_num='nara' or admin_num='dede' or admin_num='rema' or admin_num='opad' or admin_num='stpa' or admin_num='waho' or admin_num='$park')
and fiscal_year='$fyear'
order by report_date desc ";
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
/*
echo "<table align='center'><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score: &nbsp;&nbsp; $score</b></font></th></tr></table><br />";
*/
if($region2=='EADI' or $region2=='SODI' or $region2=='WEDI')
{
echo "<table align='center' border='1'><tr><th><a href='pcard_recon_yearly_pasu.php?m=pcard&menu_new=MAppr'>PCARD Charges-Reconciled by Region Office</a></th></tr></table>";
}
echo "<br />";
//echo "<br />pasu_role=$pasu_role<br />";
echo "<table align='center'><tr><th><font color='red'>Weekly Reconcilement Approvals ($parkcode)</font></th></tr></table>";

//echo "<br /><br />";
echo "<table align='center'>";

echo 

"<tr> 
       
       <th align=left><font color=brown>Report Date</font></th>       
       <th align=left><font color=brown>Admin#</font></th>       
       <th align=left><font color=brown>Transactions</font></th>
       <th align=left><font color=brown>Cashier<br />Approval</font></th>
	   <th align=left><font color=brown>Manager<br />Approval</font></th>
	   <th align=left><font color=brown>BUOF<br />Deadline OK</font></th>";
	   /*
	   if($region2=='EADI' or $region2=='SODI' or $region2=='WEDI')
	   {
	   echo "<th align=left><font color=brown>Park Charges<br />(Excluding PASU)</font></th>";
	   }
	   if($region2=='EADI' or $region2=='SODI' or $region2=='WEDI')
	   {
	   echo "<th align=left><font color=brown>PASU Charges<br />(Reconciled by Region)</font></th>";
	   }
	   */
	   /*
	   echo "<th align=left><font color=brown>Park<br />Match</font></th>
	   <th align=left><font color=brown>Authorized<br />Match</font></th>
	   <th align=left><font color=brown>BUOF<br />Comments</font></th>";
	   */
	   //echo "<th align=left><font color=brown>BUOF<br />Verify</font></th>";
	   //echo "<th align=left><font color=brown>Score</font></th>";
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
$fs_approver3=substr($fs_approver,0,-2);
$refund_total=number_format($refund_total,2);
//$manager_comment_name3=substr($manager_comment_name,0,-2);
//$fs_comment_name3=substr($fs_comment_name,0,-2);
//$fs_approver3=substr($fs_approver,0,-2);
//$manager_comment_date_dow=date('l',strtotime($manager_comment_date));
/*
if($deposit_date == '0000-00-00')
{
$deposit_date2='';
}
else
{
$deposit_date2=date('m-d-y', strtotime($deposit_date));
}
//$deposit_date=date('m-d-y', strtotime($deposit_date));
//$deposit_date=date('m-d-y', strtotime($deposit_date));



if($deposit_date=='0000-00-00')
{$deposit_date_dow='';}
else
{$deposit_date_dow=date('l',strtotime($deposit_date));}
*/
$cashier_date=str_replace("-","",$cashier_date);
$manager_date=str_replace("-","",$manager_date);

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
//$fs_comment_date2=date('m-d-y', strtotime($fs_comment_date));
//$fs_approver_date2=date('m-d-y', strtotime($fs_approver_date));

/*
echo "cashier=$cashier<br />";
echo "cashier_count=$cashier_count<br />";
echo "manager=$manager<br />";
echo "manager_count=$manager_count<br />";
*/



//$dow=date("1",$timestamp);
//$deposit_date=date('m-d-y', strtotime($deposit_date));
//$deposit_id2 = substr($deposit_id, 0, 8);
//$deposit_idL8 = substr($deposit_id, -8, 8);
//if($deposit_idL8=="GiftCard"){$GC='y';}else{$GC='n';}
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($record_complete == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
echo 

"<tr$t>
		   	
		    <td bgcolor='lightgreen'>$report_date</td>
		    <td bgcolor='lightgreen'>$admin_num</td>
		    <td bgcolor='lightgreen'>$record_count</td>";
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
		   //if($cashier=='' and $cashier_count==1)
			//{echo "<td bgcolor='lightpink'></td>";
		
		    if($cashier=='' and $cashier_count==1)
			{echo "<td bgcolor='lightpink'><a href='pcard_recon.php?report_date=$report_date&admin_num=$admin_num&submit=Find' >Update</a></td>";
		
		
		  // echo "<td bgcolor='lightpink'><a href='concessions_pci_form.php?parkcode=$parkcode&cash_month=$cash_month&fyear=$fyear&cash_month_calyear=$cash_month_calyear' >Cashier<br />Update</a></td>";
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
		   
		   echo "<br />$cashier3<br />$cashier_date2<br />$cashier_date_dow</td>";	
	       }
		   /*
		   echo "<td>$controllers_deposit_id<br /><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";
		   */
		  
	//echo "<br />manager=$manager<br />pasu_role=$pasu_role<br />cashier=$cashier";   
		      
		   //Manager Count has 3 possible outcomes 
		   if($manager=='' and $pasu_role == 'y' and $cashier != '')
			{		   
		   echo "<td bgcolor='lightpink'><a href='pcard_recon_weekly.php?report_date=$report_date&admin_num=$admin_num' >Manager<br />Update</a></td>";
		   } 
		   
		   if($manager=='' and $pasu_role == 'y' and $cashier == '')			
		    {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }
		   
		   
		   
		   if($manager=='' and $pasu_role == 'n')
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }

		  		   
		   
		   
		   if($manager != '')
		   {
		  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$manager3<br />$manager_date2<br />$manager_date_dow</td>";
		   }
		 
		  
		   if($fs_approver == '')
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   }
		 
		   if($fs_approver != '' and $deadline_ok2 == 'y')
		   {	
	    	  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$fs_approver3</td>";  		   
		 
		   }
		  
		   if($fs_approver != '' and $deadline_ok2 == 'n')
		   {	
	    	  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of red x mark'></img><br />$fs_approver3</td>";  		   
		 
		   }
		  
		   
		  
		  
		   
		   if($manager != '')
		   {
		  echo "<td bgcolor='lightgreen'><a href='pcard_recon_weekly.php?report_date=$report_date&admin_num=$admin_num&app=y'>VIEW</a></td>";
	       }
		   
		   /*
		   if($region2=='EADI' or $region2=='SODI' or $region2=='WEDI')
			 {
		  echo "<td bgcolor='lightgreen'><a href='pcard_recon_weekly.php?report_date=$report_date&admin_num=$region2&app=no'>VIEW</a></td>";
	       }   
		   
		  */
			  
           
echo "</tr>";




}

 echo "</table>";
 



?>
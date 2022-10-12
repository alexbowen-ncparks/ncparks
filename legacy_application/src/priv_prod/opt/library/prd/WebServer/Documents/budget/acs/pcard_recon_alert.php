<?php

//if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}
//echo "<br />pcard_recon_alert.php  Line 9<br />";
/*
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
if($tempID=='Church9564' and $concession_location=='LANO'){$posTitle='park superintendent';}
//if($tempID=='Crider2443' and $concession_location=='GOCR'){$posTitle='park superintendent';}
if($tempID=='Rogers2949' and $concession_location=='PETT'){$posTitle='park superintendent';}
if($tempID=='Newsome1830' and $concession_location=='MEMO'){$posTitle='park superintendent';}
if($tempID=='Kendrick3113' and $concession_location=='HABE'){$posTitle='park superintendent';}
if($tempID=='Murr7025' and $concession_location=='MOMO'){$posTitle='park superintendent';}
*/

//echo "$tempID=$posTitle=$concession_location";
if($posTitle=='park superintendent'){$pasu_role='y';} else {$pasu_role='n';}
//echo "<br />cashier_count=$cashier_count<br />";
//echo "<br />manager_count=$manager_count<br />";

/*
if($posTitle=='park superintendent'){echo "<font color='brown'><b>hello park superintendent</b></font>";}
*/

//if($posTitle=='park superintendent'){$pasu_role='y';}
//$menu_new='MAppr';

extract($_REQUEST);

//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

if(@$f_year==""){include("../~f_year.php");}
//echo "f_year=$f_year";


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");



//if($beacnum=='60032833'){$park='DEDE'; $manager_count=1; $pasu_role='y';} //erin lawrence
//if($beacnum=='60033160'){$park='NARA'; $manager_count=1; $pasu_role='y';} //brian strong

if($park!=''){$parkcode=$park;}
if($park==''){$parkcode=$concession_location;}
//echo "<br />beacnum=$beacnum<br />";
//echo "<br />tempid=$tempid<br />";
//if($beacnum=='60032833'){$parkcode='DEDE'; $manager_count=1; $pasu_role='y';} //erin lawrence
if($beacnum=='60033012' and $tempid=='Howerton3639'){$parkcode='DEDE'; $manager_count=1; $pasu_role='y';} //erin lawrence
if($beacnum=='60033160'){$parkcode='NARA'; $manager_count=1; $pasu_role='y';} //brian strong
if($beacnum=='60032942'){$parkcode='STPA'; $manager_count=1; $pasu_role='y';} //scott crocker
if($beacnum=='60032828'){$parkcode='REMA'; $manager_count=1; $pasu_role='y';} //jon blanchard
if($beacnum=='60033018'){$parkcode='OPAD'; $manager_count=1; $pasu_role='y';} //adrian oneal
if($beacnum=='60032912'){$parkcode='EADI'; $manager_count=1; $pasu_role='y';} //john fullwood
if($beacnum=='60033019'){$parkcode='SODI'; $manager_count=1; $pasu_role='y';} //jay greenwood
if($beacnum=='60032913'){$parkcode='WEDI'; $manager_count=1; $pasu_role='y';} //sean mcelhone
if($beacnum=='60032786'){$parkcode='WAHO'; $cashier_count=1;} //kelly chandler

if($manager_count==1){$pasu_role='y';}

$system_entry_date=date("Ymd");

//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;

// 2022-07-01: ccooper - change for FYR rollover
$fiscal_year='2223';

echo "<br />";

if($park!=''){$concession_location=$park;}

//everyone except steve livingstone/laura fuller/tammy dodd/jerry howerton/bonita meeks/gaylene goodwin
if($beacnum!='60033138' and $beacnum!='60032794' and $beacnum!='60032781' and $beacnum!='65032850' and $beacnum!='60033012' and $beacnum != '60032981' and $beacnum != '60033110' and $beacnum != '65027688')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date
from pcard_report_dates_compliance
WHERE 1
and admin_num='$parkcode'
and (cashier='' or manager='')
and fiscal_year='$fiscal_year'
group by report_date 
order by report_date desc ";
}

//bonita meeks
if($beacnum=='60032981')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date
from pcard_report_dates_compliance
WHERE 1
and (admin_num='clne' or admin_num='eadi')
and (cashier='' or manager='')
and fiscal_year='$fiscal_year'
group by report_date,admin_num 
order by report_date desc ";
}

//gaylene goodwin  JORD and backup for WAHO
if($beacnum=='60033110')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date
from pcard_report_dates_compliance
WHERE 1
and (admin_num='jord' or admin_num='waho')
and (cashier='' or manager='')
and fiscal_year='$fiscal_year'
group by report_date,admin_num 
order by report_date desc ";
}

//steve livingstone
if($beacnum=='60033138')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date
from pcard_report_dates_compliance
WHERE 1
and (admin_num='admn' or admin_num='fama' or admin_num='opad')
and (cashier='' or manager='')
and fiscal_year='$fiscal_year'
group by report_date,admin_num 
order by report_date desc ";
}

//derrick evans
if($beacnum=='60032920')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date
from pcard_report_dates_compliance
WHERE 1
and (admin_num='fama' or admin_num='opad')
and (cashier='' or manager='')
and fiscal_year='$fiscal_year'
group by report_date,admin_num 
order by report_date desc ";
}

//Pacita Grimes; DD of Ops OA
if($beacnum=='60033148')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date
from pcard_report_dates_compliance
WHERE 1
and (admin_num='fama' or admin_num='opad')
and (cashier='' or manager='')
and fiscal_year='$fiscal_year'
group by report_date,admin_num 
order by report_date desc ";
}

//matthew davis
if($beacnum=='65027688')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date
from pcard_report_dates_compliance
WHERE 1
and (admin_num='fama')
and (cashier='' or manager='')
and fiscal_year='$fiscal_year'
group by report_date,admin_num 
order by report_date desc ";
}

//laura fuller
if($beacnum=='60032794')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date
from pcard_report_dates_compliance
WHERE 1
and (admin_num='nara' or admin_num='rema' or admin_num='stpa')
and (cashier='' or manager='')
and fiscal_year='$fiscal_year'
group by report_date,admin_num 
order by report_date desc ";
}

//tammy dodd
if($beacnum=='60032781')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date
from pcard_report_dates_compliance
WHERE 1
and (admin_num='admn' or admin_num='opad' or admin_num='nara' or admin_num='rema' or admin_num='fama' or admin_num='waho')
and (cashier='' or manager='')
and fiscal_year='$fiscal_year'
group by report_date,admin_num 
order by report_date desc ";
}

//mahnaz rouhani
if($beacnum=='65032850')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date
from pcard_report_dates_compliance
WHERE 1
and (admin_num='admn' or admin_num='opad' or admin_num='nara' or admin_num='rema' or admin_num='fama' or admin_num='waho')
and (cashier='' or manager='')
and fiscal_year='$fiscal_year'
group by report_date,admin_num 
order by report_date desc ";
}

//jerry howerton
if($beacnum=='60033012' and $tempid=='Howerton3639')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date
from pcard_report_dates_compliance
WHERE 1
and (admin_num='fama' or admin_num='dede')
and (cashier='' or manager='')
and fiscal_year='$fiscal_year'
group by report_date,admin_num 
order by report_date desc ";
}

//jody reavis
if($beacnum=='60033012' and $tempid!='Howerton3639')
{
$query11="SELECT admin_num,report_date,record_count,cashier,cashier_date,manager,manager_date
from pcard_report_dates_compliance
WHERE 1
and (admin_num='fama')
and (cashier='' or manager='')
and fiscal_year='$fiscal_year'
group by report_date,admin_num 
order by report_date desc ";
}

//echo "query11=$query11<br />";

 $result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);		
//echo "query11=$query11<br />";
//echo "cashier=$cashier<br />";

if($num11==0)
{
echo "<table align='center'><tr><th>Weekly Reconcilement Approvals</th><th><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></th></tr></table>";

	
	
}
if($num11!=0)
{
echo "<br />";
echo "<table align='center'><tr><th><font color='red'>Weekly Reconcilement Approvals ($parkcode)</font></th></tr></table>";
echo "<table align='center' border='1'>";

echo "<tr>";
echo "<th align=left><font color=brown>Report Date</font></th>";       
echo "<th align=left><font color=brown>Admin#</font></th>";       
echo "<th align=left><font color=brown>Transactions</font></th>";
echo "<th align=left><font color=brown>Cashier</font></th>";
echo "<th align=left><font color=brown>Manager</font></th>";        
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

$cashier_date2=date('m-d-y', strtotime($cashier_date));
$manager_date2=date('m-d-y', strtotime($manager_date));

if($record_complete == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}
echo "<tr$t>";
echo "<td bgcolor='lightgreen'>$report_date</td>";
echo "<td bgcolor='lightgreen'>$admin_num</td>";
echo "<td bgcolor='lightgreen'>$record_count</td>";
		   		   
		   //Cashier Count has 3 possible outcomes 
		   if($cashier=='' and $cashier_count==1)
			{echo "<td bgcolor='lightpink'><a href='acs/pcard_recon.php?report_date=$report_date&admin_num=$admin_num&submit=Find' >Update</a></td>";
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
		   
		   //Manager Count has 3 possible outcomes 
		   if($manager=='' and $pasu_role == 'y' and $cashier != '')//(manager_count == 1)
			{		   
		   echo "<td bgcolor='lightpink'><a href='acs/pcard_recon_weekly.php?report_date=$report_date&admin_num=$admin_num' >Manager<br />Update</a></td>";
		   } 
		   
		   if($manager=='' and $pasu_role == 'y' and $cashier == '')//(manager_count == 1)
			
		    {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }

		   if($manager=='' and $pasu_role == 'n')
		   {
		   echo "<td bgcolor='lightpink'></td>";
		   
		   }

		  /* 
		   if($manager != '')
		   {
		  echo "<td bgcolor='lightgreen'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		  
		 
		  
		  echo "<br />$manager3<br />$manager_date2<br />$manager_date_dow</td><td bgcolor='lightgreen'><a href='acs/pcard_recon_weekly.php?report_date=$report_date&admin_num=$admin_num&app=y'>VIEW</a></td>";
	       }
		   */	  
           
echo "</tr>";

}

 echo "</table>";
 
}

?>
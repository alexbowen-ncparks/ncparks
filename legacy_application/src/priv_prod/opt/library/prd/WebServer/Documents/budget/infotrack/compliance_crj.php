<?php

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
$system_entry_date=date("Y-m-d");
if($posTitle=='park superintendent'){$pasu_role='y';} else {$pasu_role='n';}
if($posTitle=='parks district superintendent'){$disu_role='y';} else {$disu_role='n';}
if($concession_location=='ADM'){$concession_location='ADMI';}
echo "<html>";
echo "<head>";



echo "</head>";
/*
echo "<table>
<tr><td>tempID</td><td>pasu_role</td><td>disu_role</td></tr>
<tr><td>$tempID</td><td>$pasu_role</td><td>$disu_role</td></tr>
</table>";
*/
extract($_REQUEST);
//if($level==1){$parkcode=$concession_location;}
//echo "$report_date<br />";exit;


//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "active file=$active_file<br />";
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");
echo "Line 58: f_year=$f_year<br />";
$query1a="select count(id) as 'cashier_count'
          from cash_handling_roles
		  where park='$concession_location' and role='cashier' and tempid='$tempID' ";	

//echo "query1a=$query1a<br /><br />";		  

$result1a = mysqli_query($connection, $query1a) or die ("Couldn't execute query 1a.  $query1a");
		  
$row1a=mysqli_fetch_array($result1a);

extract($row1a);
//if($tempid=='McGrath9695')
//echo "cashier_count=$cashier_count<br />";


$query1b="select count(id) as 'manager_count'
          from cash_handling_roles
		  where park='$concession_location' and role='manager' and tempid='$tempID' ";	

//echo "query1b=$query1b<br /><br />";		  

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");
		  
$row1b=mysqli_fetch_array($result1b);

extract($row1b);
//echo "manager_count=$manager_count<br />";



$query1c="select count(id) as 'fs_approver_count'
          from cash_handling_roles
		  where park='$concession_location' and role='fs_approver' and tempid='$tempID' ";	

//echo "query1c=$query1c<br /><br />";		  

$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");
		  
$row1c=mysqli_fetch_array($result1c);

extract($row1c);
//echo "fs_approver_count=$fs_approver_count<br />";


if($pasu_comment != '')
{
//echo "<table><tr><th>Under Construction. Not ready for use.</th></tr></table>";

$pasu_comment=addslashes($pasu_comment);
$pasu_comment_query="update crs_tdrr_division_deposits set crj_pasu_comment='$pasu_comment',crj_pasu_player='$tempID',crj_pasu_comment_date='$system_entry_date' where id='$comment_id' ";

$result_pasu_comment_query=mysqli_query($connection, $pasu_comment_query) or die ("Couldn't execute query pasu comment query. $pasu_comment_query");


//echo "comment_update_query=$comment_update_query<br />";
}


if($disu_comment != '')
{
$disu_comment=addslashes($disu_comment);
$disu_comment_query="update crs_tdrr_division_deposits set crj_disu_comment='$disu_comment',crj_disu_player='$tempID',crj_disu_comment_date='$system_entry_date' where id='$comment_id' ";

$result_disu_comment_query=mysqli_query($connection, $disu_comment_query) or die ("Couldn't execute query disu comment query. $disu_comment_query");


//echo "comment_update_query=$comment_update_query<br />";
}

/*
if($buof_comment != '')
{
$buof_comment=addslashes($buof_comment);
$buof_comment_query="update cash_summary set buof_comment='$buof_comment',buof_player='$tempID',buof_comment_date='$system_entry_date' where id='$comment_id' ";

$result_buof_comment_query=mysqli_query($connection, $buof_comment_query) or die ("Couldn't execute query buof comment query. $buof_comment_query");


//echo "comment_update_query=$comment_update_query<br />";
}
*/









//echo "f_year=$f_year";
//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}
/*
if($level=='5' and $tempID !='Dodd3454')
{

echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}
*/
//$table="rbh_multiyear_concession_fees3";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";
//echo "query10=$query10<br />";
$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

//echo "body_bg:$body_bg";
//echo "<br />";
//echo "table_bg:$table_bg";
//echo "<br />";
//echo "table_bg2:$table_bg2";

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
//echo "<br />";
//echo $filegroup;

/*
echo "<html>";
echo "<head>
<title>Concessions</title>";
*/
//include ("test_style.php");
//include ("test_style.php");

//echo "</head>";

//include("../../../budget/menus2.php");
//include("menu1314_cash_receipts.php");
//include ("test_style.php");
include ("../../../budget/menu1415_v1.php");
echo "<br />";
//include ("park_deposits_report_menu_v3.php");
//if($level==1 or $beacnum=='60036015'){include ("park_deposits_report_menu_v3.php");}

/*
if($beacnum=='60036015')
{include ("park_deposits_report_menu_v3_division.php");}
else
{include ("park_deposits_report_menu_v3.php");}
*/

if($level==1)
{
include ("park_deposits_report_menu_v3.php");
}








include("../../../budget/~f_year.php");
//include("../../../budget/menu1314.php");
//if($center==''){$center=$concession_center;}
//if($park==''){$park=$concession_location;}
//include ("park_deposits_report_menu_v2.php");
//include("/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php");
//include ("park_posted_deposits_widget1.php");

//include("../../../budget/park_deposits_report_menu_v3.php");

//include ("park_deposits_report_menu_v3.php");

echo "<br />";





//include ("park_posted_deposits_fyear_header2_v2.php");
//include("park_posted_transactions_report_menu.php");
//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";


if($park!=''){$parkcode=$park;}
if($park==''){$parkcode=$concession_location;}
//echo "park=$park<br />";
//echo "parkcode=$parkcode<br />";
/*
if($parkcode=='')
{
$query5="select center,park,effect_date,beg_bal,deposit_amount,transaction_amount,end_bal,days_elapsed2,compliance,id,pasu_comment,pasu_player,pasu_comment_date,disu_comment,disu_player,disu_comment_date
from cash_summary
where valid='y'
and weekend='n'
group by park,effect_date desc
";
}
else
{
*/

$query2="select center_desc,center from center where parkcode='$parkcode'   ";	
//$query2="select center_desc,new_center as 'center' from center where parkcode='$parkcode'   ";	

//echo "query1d=$query1d<br />";//exit;		  

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);


$query4="select park,count(id) as 'complianceYes' 
from crs_tdrr_division_deposits
where download_date >= '20140702'
and crj_compliance='y'
and version3_active='y'
and park='$parkcode'
and f_year='$fyear'
group by park
";
echo "Line 303: query4=$query4<br />";
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$row4=mysqli_fetch_array($result4);
extract($row4);
echo "Line 308: complianceYes=$complianceYes<br />";
if($complianceYes==''){$complianceYes='0';}

$query4a="select park,count(id) as 'complianceNo' 
from crs_tdrr_division_deposits
where download_date >= '20140702'
and crj_compliance='n'
and version3_active='y'
and park='$parkcode'
and f_year='$fyear'
group by park
";
echo "Line 320: query4a=$query4a<br />";
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");

$row4a=mysqli_fetch_array($result4a);
extract($row4a);
echo "Line 325: complianceNo=$complianceNo<br />";
if($complianceNo==''){$complianceNo='0';}

$total_scorable_recs=$complianceYes+$complianceNo;

$score=($complianceYes/$total_scorable_recs)*100;
$score=number_format($score,0);

echo "Line 333: score=$score<br />";


/*
$query5="select center,park,effect_date,beg_bal,deposit_amount,transaction_amount,end_bal,days_elapsed2,compliance,id,pasu_comment,pasu_player,pasu_comment_date,disu_comment,disu_player,disu_comment_date
from cash_summary
where valid='y'
and weekend='n'
and park='$parkcode'
group by park,effect_date desc
";



$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
*/



echo "<table><tr><th><img height='25' width='25' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img><font color='brown'></b>Cash Receipt Journals&nbsp;&nbsp;</font><font color='green'>$center_location</font></b></th></tr></table>";
include("../../../budget/infotrack/slide_toggle_procedures_module2_pid64.php");
//echo "<br />";
//echo "<table><tr><th><font color='red'>Under Construction $system_entry_date</font></th></tr></table>";
//echo "<br />";
echo "Line 358: fyear=$fyear<br />";
include("compliance_crj_fyear_module.php");

//echo "<br />";
/*
echo "<table><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score: $score</b></font></font></th></tr>
              <tr bgcolor='lightgreen'><td>yes</td><td align='center'>$complianceYes</td></tr>
              <tr bgcolor='lightpink'><td>no</td><td align='center'>$complianceNo</td></tr>";


              
echo "</table><br />";
*/
echo "<table><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score<br /> $score</b></font></th><td bgcolor='lightgreen'>yes<br />$complianceYes</td><td bgcolor='lightpink'>no<br />$complianceNo</td></tr></table><br />";





include("crs_deposits_crj_unapproved_module2.php");
/*
echo "<br /><br />";

echo "<table>";

echo "<table><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score: $score</b></font></font></th></tr>
              <tr bgcolor='lightgreen'><td>yes</td><td align='center'>$complianceYes</td></tr>
              <tr bgcolor='lightpink'><td>no</td><td align='center'>$complianceNo</td></tr>";


              
echo "</table><br />";



exit;
$header_array=array("Park","Date","Beg Balance","Deposit Amount","Transaction Amount","End Balance","Days Elapsed (earliest undeposited transaction) ","PASU<br />Compliance<br />Comments","DISU<br />Compliance<br />Comments","ID");
echo "<table>";
echo "<tr>"; 
 
       	   
foreach($header_array as $index=>$fld)
	{
	echo "<th align='left'><font color=brown>$fld</font></th>";
	}   
	   
	   
       
   
       
              
echo "</tr>";



$i=0;
while ($row=mysqli_fetch_array($result5)){


extract($row);
$pasu_player2=substr($pasu_player,0,-2);
$disu_player2=substr($disu_player,0,-2);

$amount=number_format($amount,2);


$effect_date_dow=date('l',strtotime($effect_date));


if($compliance == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}


if(fmod($i,10)==0 and $i!=0)
	{
	 echo "<tr>"; 	   
	foreach($header_array as $index=>$fld)
		{
		echo "<th align='left'><font color=brown>$fld</font></th>";
		}   
	echo "</tr>";
	}
echo 

"<tr$t>";

      
     echo "<td>$park</td>		   
           <td>$effect_date<br />$effect_date_dow</td>		   
           <td>$beg_bal</td>		   
           <td>$deposit_amount</td>		   
           <td>$transaction_amount</td>	           		   
           <td>$end_bal</td>
		   <td>$days_elapsed2</td>"; 
		   //PASU Comments column
           echo "<td>";
		   
		   if($compliance=='n' and $pasu_comment=='')
		   {echo "<form action='compliance.php'><textarea rows='7' cols='20' name='pasu_comment' placeholder='Enter Park Justification for non-compliance. Then click PASU_Update'>$pasu_comment</textarea><br /><input type='hidden' name='parkcode' value='$park'><input type='hidden' name='comment_id' value='$id'>";
		   if($pasu_role=='y')
		   {
		   echo "<input type=submit name=submit value=PASU_Update></form>";
		   }
		   }
		   
		    if($compliance=='n' and $pasu_comment!='')
		   {echo "$pasu_comment_date($pasu_player2)";echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$pasu_comment";}
		   		   
		   echo "</td>"; 
		   
		   //DISU Comments column
		   echo "<td>";
		   
		   if($compliance=='n' and $disu_comment=='')
		   {echo "<form action='compliance.php'><textarea rows='7' cols='20' name='disu_comment' placeholder='Enter DISU Comment. Then click DISU_Update'>$disu_comment</textarea><br /><input type='hidden' name='parkcode' value='$park'><input type='hidden' name='comment_id' value='$id'>";
		   
		   if($disu_role=='y' and $pasu_comment != '')
		   {
		   echo "<input type=submit name=submit value=DISU_Update></form>";
		   }
		   }
		   
		    if($compliance=='n' and $disu_comment!='')
		   {echo "$disu_comment_date<br />$disu_player2";echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$disu_comment";}
		   		   
		   echo "</td>"; 
		   
		 
		   
           echo "<td>$id</td>";   
              
           	   
             
        
              
           
echo "</tr>";

$i++;


}



while ($row6=mysqli_fetch_array($result6)){





extract($row6);

$total=number_format($total,2);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 



"<tr$t>   

           	

           <td></td> 	
           <td></td> 	
           <td></td> 	
           <td></td> 	
           <td>Total</td> 	

           <td>$total</td> 
           
         
           
           

           		  

</tr>";



}



 echo "</table>";
 */
 
 echo "</body></html>";




?>


 


























	















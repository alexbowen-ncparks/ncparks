<?php

/*   *** INCLUDE file inventory ***
include("/opt/library/prd/WebServer/include/iConnect.inc")
include("../../../include/activity.php");// database connection parameters
include("../../budget/~f_year.php");
include ("../../budget/menu1415_v1.php")
include("pcard_new_menu1.php")

*/
//if($level=="5" and $tempid !="Dodd3454"){echo "<pre>";print_r($_REQUEST);echo "</pre>";}//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}



//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$tempID=$_SESSION['budget']['tempID'];
$posTitle=$_SESSION['budget']['position'];
$beacon_num=$_SESSION['budget']['beacon_num'];
$pcode=$_SESSION['budget']['select'];
$centerSess=$_SESSION['budget']['centerSess'];
//echo $tempid;
extract($_REQUEST);
$menu='VDocu';

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");

if($submit=='submit_empnum' and $employee_number != '')
{
$query1="update pcard_users set employee_number='$employee_number' where id='$id' ";
//echo "query1=$query1"; exit;	
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");		
}

//echo "submit1=$submit1";echo "submit2=$submit2";exit;


//$rand = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
//    $color = "#".$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
/*
$query2="insert into affirmations1
         set affirmation='$affirmation_abundance',color='$color',admin='$admin_new',first_name='$first_name',last_name='$last_name',employee_number='$employee_number',job_title='$job_title',dayb='$dayb' ";
*/		 
//echo "query2=$query2"; //exit;	
//$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");	
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


echo "<html>";
echo "<head>";
/*
echo "<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>";
*/

echo "</head>";
$menu='VCard';
include ("../../budget/menu1415_v1.php");
//include("1418.html");
echo "<style>";
echo "input[type='text'] {width: 200px;}";

echo "</style>";
//echo "<H1 ALIGN=LEFT > <font color=brown><i>Cardholder Documents</font></i></H1>";
/*
echo "<table>";
echo "<tr><td><font color='$color'><i>$first_name $last_name $job_title at $admin_new on $dayb</font></i></td></tr>";
echo "<tr><td><font color='$color'><i>$affirmation_abundance($color)</font></i></td></tr>";
echo "</table>";
*/
//echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Budget-Home </A></font></H2>";
echo "<br />";


include("pcard_new_menu1.php");
echo "<br />";


//if($level=="1"){$location=$pcode;}
if($level < '2' and $admin==''){$admin=$pcode;}
/*
if($beacon_num=='60032781' or $beacon_num=='60032997')
{
echo "<table>";
echo "<tr>";

//echo "<font size=5>"; 
echo "<th>Admin Code</th></tr>";
echo "<tr>";
echo "<form method='post' action='cardholder_documents.php'>";


echo "<td><input name='admin' type='text' value='$admin'></td>";

echo "<td><input type='submit' name='submit' value='search'></td>";
echo "</form>";
echo "</tr>";
echo "</table>";
}
*/



$header_var_admin="$admin";
//$header_var_center="&center=$center";
//$header_var_account="&account=$account";
//$header_var_calyear="&calyear=$calyear";


/*
echo
"<form method='post' action='cardholder_documents.php'>";
echo "<td>";
echo "<input type='hidden' name='time_period_start'  value=''>";
echo "<input type='hidden' name='time_period_end'  value=''>";
echo "<input type='hidden' name='account'  value='' >";
echo "<input type='hidden' name='location'  value='' >";
echo "<input type='submit' name='submit' value='reset'>";
echo "</td>" 
echo "</form>";
echo "</tr>";
echo "</table>";
*/


if($submit==""){exit;}
//if($submit=="reset"){exit;}

if($admin != ""){$where1=" and admin = '$admin' ";}
if($level==1)
{
$query3g="select 
admin,last_name,first_name,position_number,employee_number,job_title,photo_location,location,act_id,card_number,comments,justification,justification_manager,document_location,document_location_final,id
from pcard_users where 1 and (act_id='y' or act_id='p') $where1
order by admin,last_name,first_name,location";
}	
//echo "Line 161 Query3g=$query3g";

if($level==2 and $pcode=='EADI'){$dist_where=" and dist='east' and fund='1280' and actcenteryn='y' ";}

if($level==2 and $pcode=='NODI'){$dist_where=" and dist='north' and fund='1280' and actcenteryn='y' and center.parkcode != 'mtst' and center.parkcode != 'harp' ";}

if($level==2 and $pcode=='SODI'){$dist_where=" and dist='south' and fund='1280' and actcenteryn='y' and center.parkcode != 'boca' ";}

if($level==2 and $pcode=='WEDI'){$dist_where=" and dist='west' and fund='1280' and actcenteryn='y' ";}

if($level==2){$dist_join=" left join center on pcard_users.admin=center.parkcode ";}

if($level==2)

{
$query3g="select 
admin,last_name,first_name,job_title,location,act_id,card_number,comments,justification,justification_manager,document_location,id
from pcard_users
$dist_join
where 1 and (act_id='y' or act_id='p') $dist_where  $where1
order by admin,last_name,first_name,location";
//echo "query3g=$query3g";
}
if($level>2)
{
$query3g="select 
admin,last_name,first_name,position_number,employee_number,job_title,affirmation_abundance,photo_location,location,act_id,card_number,comments,justification,justification_manager,document_location,document_location_final,id
from pcard_users 
where 1 and (act_id='y' or act_id='p') $where1
order by admin,last_name,first_name,location";
//echo "query3g=$query3g";
}		  
$result3g = mysqli_query($connection, $query3g) or die ("Couldn't execute query 3g.  $query3g");		  
		  
$record_count=mysqli_num_rows($result3g);



//change document_location to employee_number    4/24/17

$query_1656_yes="select count(location) as 'yes_1656'
          from pcard_users
		  $dist_join
		  where 1 and act_id='y' $dist_where $where1 
		  and location='1656'
		  and document_location_final != ''
		  
		  ";		  
		  
$result_query1656_yes = mysqli_query($connection, $query_1656_yes) or die ("Couldn't execute query 1656 yes.  $query_1656_yes");
		  
$row_1656_yes=mysqli_fetch_array($result_query1656_yes);

extract($row_1656_yes);



$query_1669_yes="select count(location) as 'yes_1669'
          from pcard_users
		  $dist_join
		  where 1 and act_id='y' $dist_where $where1 
		  and location='1669'
		  and document_location_final != ''
		  
		  ";		  
		  
$result_query1669_yes = mysqli_query($connection, $query_1669_yes) or die ("Couldn't execute query 1669 yes.  $query_1669_yes");
		  
$row_1669_yes=mysqli_fetch_array($result_query1669_yes);

extract($row_1669_yes);



$query_1656_no="select count(location) as 'no_1656'
          from pcard_users
		  $dist_join
		  where 1 and act_id='y' $dist_where $where1 
		  and location='1656'
		  and document_location_final = ''
		  
		  ";		  
		  
$result_query1656_no = mysqli_query($connection, $query_1656_no) or die ("Couldn't execute query 1656 no.  $query_1656_no");
		  
$row_1656_no=mysqli_fetch_array($result_query1656_no);

extract($row_1656_no);



$query_1669_no="select count(location) as 'no_1669'
          from pcard_users
		  $dist_join
		  where 1 and act_id='y' $dist_where $where1 
		  and location='1669'
		  and document_location_final = ''
		  
		  ";		  
		  
$result_query1669_no = mysqli_query($connection, $query_1669_no) or die ("Couldn't execute query 1669 no.  $query_1669_no");
		  
$row_1669_no=mysqli_fetch_array($result_query1669_no);

extract($row_1669_no);


//echo "yes_1656=$yes_1656<br />";
//echo "yes_1669=$yes_1669<br />";
$total_cardholders=$yes_1656+$yes_1669+$no_1656+$no_1669;
//echo "total_cardholders=$total_cardholders<br />";

//echo "<h2><font color='red'>Cardholders-$total_cardholders</font></h2>";	


		  
//if($level=="5" and $tempID !="Dodd3454"){echo "Query3g=$query3g";}	


//echo "<h2><font color='red'>Cardholder Documents-$record_count</font></h2>";	
$total_1656=$yes_1656+$no_1656;
$total_1669=$yes_1669+$no_1669;

$total_yes=$yes_1656+$yes_1669;
$total_no=$no_1656+$no_1669;
if($total_yes != 0 and $total_no ==0 ){$completed="yes";} else {$completed="no";}
echo "<br />";

/* 2022-02-22: CCOOPER - adding Boggus (60033242) and Williams (65032827) to give them the 
                         "Active Card totals" table on the form
             // Dodd (60032781)  Gooding (60032997)

   2022-03-14: CCOOPER - adding Rumble (60036015) and Rouhani (65032850)
*/
if($beacon_num=='60032781' or
   $beacon_num=='60032997' or
   $beacon_num=='60033242' or
   $beacon_num=='60036015' or
   $beacon_num=='65032850')
	
	/* END CCOOPER */
{	
echo "<table align='center'>";
echo "<tr>";

//echo "<font size=5>"; 
//echo "<th>Admin Code</th></tr>";
echo "<tr>";
echo "<th>Admin#</th>";
echo "<form method='post' action='cardholder_documents.php'>";


echo "<td><input name='admin' type='text' value='$admin'></td>";

echo "<td><input type='submit' name='submit' value='search'></td>";
echo "</form>";
echo "</tr>";
echo "</table>";  
echo "<table align='center'><tr><th colspan='4'><font color='red'>Active Card Totals</font></th></tr><tr><th></th><th><font color=brown>Reg</font></th><th><font color=brown>CI</th><th><font color=brown>Total</th></tr>
              <tr bgcolor='lightgreen'><td>yes</td><td align='center'>$yes_1656</td><td align='center'>$yes_1669</td><td align='center'>$total_yes</td></tr>";
			  if($completed=='no')
			  {
			  echo "<tr bgcolor='lightpink'><td>no</td><td align='center'>$no_1656</td><td align='center'>$no_1669</td><td align='center'>$total_no</td></tr>";
			  }

			  /*
			  echo "<tr><th></th><th><font color='brown'>$total_1656</font></th><th><font color='brown'>$total_1669</font></th><th><font color='brown'>$total_cardholders</font></th></tr>";
			  */

              
	   echo "</table><br />";
}
 echo "<br />";
echo "<table align='center' cellspacing='5'><tr><th><font color='red'>Purchasing Guideline Documents</th></tr></table>";
echo "<table align='center' cellspacing='5'>";
echo "<tr><th><a href='purchasing_guidelines.docx' target='_blank'>(1) Purchasing Guidelines</a></th><th><a href='best_price_form.xls' target='_blank'>(2) Best Price Form</a></th><th><a href='ci_mm_trails_purchasing_guidelines.pdf' target='_blank'>(3) Capital Improvement Purchasing Guidelines</a></th></tr>";
echo "</table>";
echo "<br />";  
   
echo "<table align='center'>";
 
echo "<tr>"; 

  
  echo " <th><font color=blue>Admin</font></th>"; 
 echo " <th><font color=blue>Last Name</font></th>"; 
 echo " <th><font color=blue>First Name</font></th>";
 echo " <th><font color=blue>Employee#</font></th>";
 echo " <th><font color=blue>Position#</font></th>";
 echo " <th><font color=blue>Job Title</font></th>";
 echo " <th><font color=blue>CardType</font></th>";
 echo " <th><font color=blue>Active</font></th>";
 echo " <th><font color=blue>Card Number</font></th>";
 //echo " <th><font color=blue>Comments</font></th>";
 echo " <th><font color=blue>Justification</font></th>";
  echo " <th><font color=blue>DNCR Form</font></th>";
  echo " <th><font color=blue>ID</font></th>";
  echo "</tr>";
//echo  "<form method='post' autocomplete='off' action='stepH9b_update_all.php'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row3g=mysqli_fetch_array($result3g)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3g);

//if($document_location != ""){$document="yes";} else {$document="";}
//if($document_location != ""){$bgc="lightgreen";} else {$bgc="lightpink";}

if($document_location_final != "" and $act_id=='y'){$document="yes";} else {$document="";}
if($document_location_final != "" and $act_id=='y'){$bgc="lightgreen";} else {$bgc="lightpink";}



//if($employee_number != ""){$bgc="lightgreen";} else {$bgc="lightpink";}




if($location=='1656'){$location="reg";}
if($location=='1669'){$location="ci";}

//echo "document_location=$document_location";
//echo "<br />";
//echo "document=$document";


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
   
//echo "<form method=post action=stepG5_update.php>";	
 echo "<tr bgcolor='$bgc'>";  
echo  "<td align='center'>$admin";
/*
if($position_number != '')
{
echo "<br /><img height='75' width='75' src='$photo_location' alt='picture of green check mark'></img>";
}
*/
echo "</td>";
echo  "<td align='center'>$last_name</td>";
echo  "<td align='center'>$first_name</td>";
echo  "<td align='center'>$employee_number</td>";
echo  "<td align='center'>$position_number</td>";
echo  "<td align='center'>$job_title</td>";
echo  "<td align='center'>$location</td>";
echo  "<td align='center'>$act_id</td>";
echo  "<td align='center'>$card_number</td>";
//echo  "<td>$comments</td>";
echo  "<td align='center'>$justification_manager</td>";

if($level>='4')
{

if($document=="yes"){
echo "<td align='center'><a href='$document_location_final' target='_blank'>View</a><br /><a href='cardholder_document_add.php?source_id=$id&header_var_admin=$header_var_admin' target='_blank'>Reload</a></td>";}

if($document!="yes"){
echo "<td align='center'><a href='cardholder_document_add.php?source_id=$id&header_var_admin=$header_var_admin' target='_blank'>Upload</a></td>";}

}
else
{

if($document=="yes"){
echo "<td align='center'><a href='$document_location_final' target='_blank'>View</a></td>";}

if($document!="yes"){
echo "<td align='center'></td>";}



}




//if($document!="yes")
//{echo "<td>$source</td>";}
/* 2022-03-14: CCOOPER - Gooding (60032997)
				Add 'submit_empnum' button in View Doc table for the rest of the BUOFF:
				Rumble (60036015), Boggus (60033242), Williams (65032827), & Rouhani (65032850)

if($level=='5' or $beacon_num=='60032997')
*/
if($level=='5' or 
	  ($beacon_num=='60032997') or
	  ($beacon_num=='60036015') or
	  ($beacon_num=='60033242') or
  	($beacon_num=='65032827') or
    ($beacon_num=='65032850'))

	/* 2022-03-14: End CCOOPER    */
{
echo  "<td align='center'><a href='editPcardHolders.php?card_number=$card_number&submit_acs=Find' target='_blank'>$id</a></td>";
echo "<td>";
echo "<form method='post' action='cardholder_documents.php'>";
//echo "<input type='text' name='position_number' value='$position_number'><br />";
echo "<input type='text' name='employee_number' value='$employee_number'><br />";
//echo "<input type='text' name='dayb'><br />";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='hidden' name='first_name' value='$first_name'>";
echo "<input type='hidden' name='last_name' value='$last_name'>";
echo "<input type='hidden' name='admin_new' value='$admin'>";
echo "<input type='hidden' name='job_title' value='$job_title'>";
//echo "<textarea rows='4' cols='50' name='affirmation_abundance'>$affirmation_abundance</textarea>";
echo "<input type='submit' name='submit' value='submit_empnum'>";
echo "</form>";
//echo "<br /><img height='75' width='75' src='$photo_location' alt='picture of green check mark'></img>";
echo "</td>";
}
else
{
echo "<td>$id</td>";
}	
//echo  "<td><a href='pcard_fixed_assets_document_add.php?id=$id&load_doc=y&report_date=$report_date&admin_num=$admin_num'>Upload Invoice</a></td>";
  
echo "</tr>";
//$document='';
}
echo "</table>";

echo "</html>";
?>
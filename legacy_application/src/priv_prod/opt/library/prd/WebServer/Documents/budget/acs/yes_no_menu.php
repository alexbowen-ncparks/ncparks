<?php

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}



//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$tempID=$_SESSION['budget']['tempID'];
$posTitle=$_SESSION['budget']['position'];
$beacon_num=$_SESSION['budget']['beacon_num'];
$pcode=$_SESSION['budget']['select'];
$centerSess=$_SESSION['budget']['centerSess'];
//echo $tempid;
extract($_REQUEST);

include("connect_budget.php");
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
//echo "submit1=$submit1";echo "submit2=$submit2";exit;
echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: #FFF8DC; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>

</head>";

echo "<H1 ALIGN=LEFT > <font color=brown><i>Yes-No Menu</font></i></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Budget-Home </A></font></H2>";
echo "<br />";
//if($level=="1"){$location=$pcode;}
if($level < '2' and $admin==''){$admin=$pcode;}


echo "<table>";
echo "<tr>";

//echo "<font size=5>"; 
echo "<th>Admin Code</th></tr>";
echo "<tr>";
echo "<form method='post' action='yes_no_menu.php'>";
if($level==1)
{
echo "<td><input name='admin' type='text' value='$admin' readonly='readonly'></td>";
}
else
{
echo "<td><input name='admin' type='text' value='$admin'></td>";
}
echo "<td><input type='submit' name='submit' value='search'></td>";
echo "</form>";
echo "</tr>";
echo "</table>";

//$header_var_admin="$admin";

if($submit==""){exit;}
//if($submit=="reset"){exit;}

if($admin != ""){$where1=" and admin = '$admin' ";}
if($level==1)
{
$query3g="select 
admin,last_name,first_name,location,act_id,card_number,comments,justification,document_location,id
from pcard_users where 1 and act_id='y' $where1
order by admin,last_name,first_name,location";
}	


if($level==2 and $pcode=='EADI'){$dist_where=" and dist='east' and fund='1280' and actcenteryn='y' ";}

if($level==2 and $pcode=='NODI'){$dist_where=" and dist='north' and fund='1280' and actcenteryn='y' and center.parkcode != 'mtst' and center.parkcode != 'harp' ";}

if($level==2 and $pcode=='SODI'){$dist_where=" and dist='south' and fund='1280' and actcenteryn='y' and center.parkcode != 'boca' ";}

if($level==2 and $pcode=='WEDI'){$dist_where=" and dist='west' and fund='1280' and actcenteryn='y' ";}

if($level==2){$dist_join=" left join center on pcard_users.admin=center.parkcode ";}

if($level==2)

{
$query3g="select 
admin,last_name,first_name,location,act_id,card_number,comments,justification,document_location,id
from pcard_users
$dist_join
where 1 and act_id='y' $dist_where  $where1
order by admin,last_name,first_name,location";
//echo "query3g=$query3g";
}
if($level>2)
{
$query3g="select 
admin,last_name,first_name,location,act_id,card_number,comments,justification,document_location,id
from pcard_users 
where 1 and act_id='y' $where1
order by admin,last_name,first_name,location";
//echo "query3g=$query3g";
}		  
$result3g = mysqli_query($connection, $query3g) or die ("Couldn't execute query 3g.  $query3g");		  
		  
$record_count=mysqli_num_rows($result3g);



$query_1656_yes="select count(location) as 'yes_1656'
          from pcard_users
		  $dist_join
		  where 1 and act_id='y' $dist_where $where1 
		  and location='1656'
		  and document_location != ''
		  
		  ";		  
		  
$result_query1656_yes = mysqli_query($connection, $query_1656_yes) or die ("Couldn't execute query 1656 yes.  $query_1656_yes");
		  
$row_1656_yes=mysqli_fetch_array($result_query1656_yes);

extract($row_1656_yes);



$query_1669_yes="select count(location) as 'yes_1669'
          from pcard_users
		  $dist_join
		  where 1 and act_id='y' $dist_where $where1 
		  and location='1669'
		  and document_location != ''
		  
		  ";		  
		  
$result_query1669_yes = mysqli_query($connection, $query_1669_yes) or die ("Couldn't execute query 1669 yes.  $query_1669_yes");
		  
$row_1669_yes=mysqli_fetch_array($result_query1669_yes);

extract($row_1669_yes);



$query_1656_no="select count(location) as 'no_1656'
          from pcard_users
		  $dist_join
		  where 1 and act_id='y' $dist_where $where1 
		  and location='1656'
		  and document_location = ''
		  
		  ";		  
		  
$result_query1656_no = mysqli_query($connection, $query_1656_no) or die ("Couldn't execute query 1656 no.  $query_1656_no");
		  
$row_1656_no=mysqli_fetch_array($result_query1656_no);

extract($row_1656_no);



$query_1669_no="select count(location) as 'no_1669'
          from pcard_users
		  $dist_join
		  where 1 and act_id='y' $dist_where $where1 
		  and location='1669'
		  and document_location = ''
		  
		  ";		  
		  
$result_query1669_no = mysqli_query($connection, $query_1669_no) or die ("Couldn't execute query 1669 no.  $query_1669_no");
		  
$row_1669_no=mysqli_fetch_array($result_query1669_no);

extract($row_1669_no);


//echo "yes_1656=$yes_1656<br />";
//echo "yes_1669=$yes_1669<br />";
$total_cardholders=$yes_1656+$yes_1669+$no_1656+$no_1669;

if($level=="5" and $tempID !="Dodd3454"){
echo "doc_no=$doc_no<br />";}

$total_1656=$yes_1656+$no_1656;
$total_1669=$yes_1669+$no_1669;

$total_yes=$yes_1656+$yes_1669;
$total_no=$no_1656+$no_1669;
echo "<br />";

  
	   
echo "<table><tr><th></th><th><font color=blue>Reg</font></th><th><font color=blue>CI</th><th><font color=blue>Total</th></tr>
              <tr bgcolor='lightgreen'><td>yes</td><td align='center'>$yes_1656</td><td align='center'>$yes_1669</td><td align='center'>$total_yes</td></tr>
              <tr bgcolor='lightpink'><td>no</td><td align='center'>$no_1656</td><td align='center'>$no_1669</td><td align='center'>$total_no</td></tr>
			  <tr><th><font color='blue'>total</font></th><th><font color='blue'>$total_1656</font></th><th><font color='blue'>$total_1669</font></th><th><font color='blue'>$total_cardholders</font></th></tr>

              
	   </table><br />";

   
   
echo "<table border=1>";
 
echo "<tr>"; 

  
  echo " <th><font color=blue>Admin</font></th>"; 
 echo " <th><font color=blue>Last Name</font></th>"; 
 echo " <th><font color=blue>First Name</font></th>";
 echo " <th><font color=blue>CardType</font></th>";
 echo " <th><font color=blue>Active</font></th>";
 echo " <th><font color=blue>Card Number</font></th>";
 //echo " <th><font color=blue>Comments</font></th>";
 echo " <th><font color=blue>Justification</font></th>";
  echo " <th><font color=blue>Document</font></th>";
  echo " <th><font color=blue>ID</font></th>";
  echo "</tr>";
//echo  "<form method='post' autocomplete='off' action='stepH9b_update_all.php'>";

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	

while ($row3g=mysqli_fetch_array($result3g)){

extract($row3g);

if($document_location != ""){$document="yes";} else {$document="";}
if($document_location != ""){$bgc="lightgreen";} else {$bgc="lightpink";}

if($location=='1656'){$location="reg";}
if($location=='1669'){$location="ci";}


 echo "<tr bgcolor='$bgc'>";  
echo  "<td align='center'>$admin</td>";
echo  "<td align='center'>$last_name</td>";
echo  "<td align='center'>$first_name</td>";
echo  "<td align='center'>$location</td>";
echo  "<td align='center'>$act_id</td>";
echo  "<td align='center'>$card_number</td>";
//echo  "<td>$comments</td>";
echo  "<td align='center'>$justification</td>";

if($document=="yes"){
echo "<td align='center'><a href='$document_location' target='_blank'>View</a><br /><a href='cardholder_document_add.php?source_id=$id&header_var_admin=$header_var_admin' target='_blank'>Reload</a></td>";}

if($document!="yes"){
echo "<td align='center'><a href='cardholder_document_add.php?source_id=$id&header_var_admin=$header_var_admin' target='_blank'>Upload</a></td>";}

echo  "<td align='center'><a href='editPcardHolders.php?card_number=$card_number&submit_acs=Find' target='_blank'>$id</a></td>";

  
echo "</tr>";
//$document='';
}
echo "</table>";

echo "</html>";
?>


























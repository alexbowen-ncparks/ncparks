<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
$step_variables="fiscal_year=$fiscal_year&project_category=$project_category&project_name=$project_name&start_date=$start_date&end_date=$end_date&step_group=$step_group&step_num=$step_num";
echo "<br />step_variables=$step_variables<br />";
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
.normal {background-color:#ffffff;}
.highlight {background-color:#ff0000;} 
</style>

<script type=\"text/javascript\"> function onRow(rowID)
{var row=document.getElementById(rowID);
var curr=row.className;
if(curr.indexOf(\"normal\")>=0)row.className=\"highlight\";else row.className=\"normal\";
 } 
</script>
</head>";

//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H1>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";
echo "<H2 ALIGN=center>"; 
//echo  "<form method='post' action='stepG5_update_all.php'>";
//echo "<input type='submit' name='submit2' value='UpdateAllRecords'>";
//echo   "</form>";
echo "</H3>";

/*<font color=blue>StepName-$step_name</font></H1>";
echo "<br />";
echo
"<form>";
echo "<font size=5>"; 
echo "fiscal_year:<input name='fiscal_year' type='text' value='$fiscal_year' readonly='readonly'>";
echo "<br />";
echo "start_date:<input name='start_date' type='text' value='$start_date' readonly='readonly'>";
echo "<br />";
echo "end_date:<input name='end_date' type='text' value='$end_date' readonly='readonly'>";
//echo "today_date:<input name='today_date'";  echo "type='text'"; echo "value= date('Y-m-d')"; echo "readonly='readonly'>";
echo "</form>";
*/
echo "<br />";
if($center != ''){$and1=" and pcard_extract_worksheet.center='$center'" ;}

$query3="select 
center.new_company as 'company',
pcard_extract_worksheet.acct,
pcard_extract_worksheet.center,
pcard_extract_worksheet.calendar_acctdate,
pcard_extract_worksheet.amount,
pcard_extract_worksheet.sign,
pcard_extract_worksheet.pcard_trans_id,
pcard_extract_worksheet.transid_verified,
pcard_extract_worksheet.id
from pcard_extract_worksheet
left join center on pcard_extract_worksheet.center=center.new_center
where correction='m'
and denr_paid != 'y'
$and1
order by pcard_extract_worksheet.center,
pcard_extract_worksheet.amount,
pcard_extract_worksheet.sign;
";



// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
echo "<br />query3=$query3<br />";
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysqli_num_rows($result3);
echo "<font size='5'>Records: $num3</font>";//exit;
//////mysql_close();

echo "<table border=1 align='center'>";
 
echo "<tr>"; 
    
 //echo " <th><font color=blue>Company</font></th>";
 
 
 echo " <th><font color=blue>Account</font></th>";
 
 echo " <th><font color=blue>Amount</font></th>";
 //echo " <th><font color=blue>Sign</font></th>";
 echo " <th><font color=blue>Pcard_transid</font></th>";
 echo " <th><font color=blue>Center</font></th>";
 echo " <th><font color=blue>PostDate</font></th>";
 echo " <th><font color=blue>Transid_verified</font></th>";
 echo " <th><font color=blue>Id</font></th>";           
// echo " <th><font color=blue>Action</font></th>";           
       
 

echo "</tr>";
echo  "<form method='post' autocomplete='off' action='stepG5_update_all.php'>";
//exit;
// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$row3=mysqli_fetch_array($result3);
//extract($row3);$companyarray[]=$company;$acctarray[]=$acct;$centerarray[]=$center;
//$calendar_acctdatearray[]=$calendar_acctdate;$amountarray[]=$amount;$signarray[]=$sign;
//$pcard_trans_idarray[]=$pcard_trans_id;$transid_verifiedarray[]=$transid_verified;
//$idarray[]=$id;}
// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);$idarray[]=$id;$pcard_trans_idarray[]=$pcard_trans_id;$transid_verifiedarray[]=$transid_verified;
//extract($row3);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row3);
if($sign=='credit'){$amount=-$amount;}

//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";	      
//echo "<form method=post action=stepG5_update.php>";	   
//echo  "<td><input type='text' size='10 name='company[]' value='$company'</td>";


echo  "<td><input type='text' size='10' name='acct[]' value='$acct'></td>";

echo  "<td><input type='text' size='10' name='amount[]' value='$amount'></td>";
//echo  "<td><input type='text' size='10' name='sign[]' value='$sign'</td>";
echo  "<td><input type='text' size='15' name='pcard_trans_id[]' value='$pcard_trans_id'></td>";
echo  "<td><a href='stepG5.php?$step_variables&center=$center'>$center</a></td>";
echo  "<td><input type='text' size='10' name='calendar_acctdate[]' value='$calendar_acctdate'></td>";
echo  "<td><input type='text' size='10' name='transid_verified[]' value='$transid_verified'></td>";
echo  "<td><input type='text' size='10' name='id[]' value='$id'></td>";
   
	      
echo "</tr>";

}

echo "<tr><td colspan='8' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>
	   <input type='hidden' name='num3' value='$num3'>";
echo   "</form>";	 
echo "</table>";


$today_date=date("Ymd");
$today_date2=strtotime($today_date);
$today_90=($today_date2-60*60*24*90);
echo "<br />today_90=$today_90<br />";;


	
$query4="select admin_num,vendor_name,amount,transid_new,transdate_new,ncas_yn,ncasnum,id
         from pcard_unreconciled
         where center='$center'
         and transdate_new >= '20171026'
         and transdate_new <= '20180126'
         order by amount  ";		 
	
	
echo "<br />query4=$query4<br />";
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysqli_num_rows($result4);	
	
echo "<table border='1' align='center'>";	
echo "<tr>";
echo "<th colspan='7'>Records: $num4</th>";
echo "</tr>";
echo "<tr>";


echo "<th>ncasnum</th>";
echo "<th>amount</th>";
echo "<th>admin_num</th>";
echo "<th>vendor_name</th>";
echo "<th>transdate_new</th>";
echo "<th>transid_new</th>";
echo "<th>ncas_yn</th>";
echo "<th>id</th>";
echo "</tr>";




while ($row4=mysqli_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";		


echo "<td>$ncasnum</td>";	
echo "<td>$amount</td>";
echo "<td>$admin_num</td>";	
echo "<td>$vendor_name</td>";		
echo "<td>$transdate_new</td>";	
echo "<td>$transid_new</td>";	
echo "<td>$ncas_yn</td>";	
echo "<td>$id</td>";	

echo "</tr>";	
	
	
}

echo "</table>";	
	
	
	
	
	
	
	
	
	

echo "</html>";

?>
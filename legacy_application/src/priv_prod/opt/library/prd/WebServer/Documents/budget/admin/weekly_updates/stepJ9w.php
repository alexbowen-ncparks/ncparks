<?php
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//$start_date=str_replace("-","",$start_date);
//$end_date=str_replace("-","",$end_date);
//$today_date=date("Ymd");
//echo "start_date=$start_date";
//echo "<br />";
//echo "end_date=$end_date";//exit;
//echo "<br />";
//echo "today_date=$today_date";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//echo "submit1=$submit1";echo "submit2=$submit2";exit;

$start_date=str_replace("-","",$start_date);
$end_date=str_replace("-","",$end_date);
$today_date=date("Ymd");

//$start_date='20150701';
//echo "<br />start_date=$start_date<br />";
//echo "<br />end_date=$end_date<br />";
//exit;




//echo "<br />";

$query10="select
proj_out,
fund_out,
proj_in,
fund_in,
amount,
comments,
ncas_in,
ncas_out,
datenew,
fid
from partf_fund_trans
where 1
and datenew >= 
'$start_date'
and datenew <= 
'$end_date'
and (proj_in='' and proj_out='')
;
";
//echo "<br />query10=$query10<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result10 = mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");
$num10=mysqli_num_rows($result10);
//echo $num10;exit;
//////mysql_close();
//echo "Records: $num10";


if($num10>0)
{

echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}

</style>
	


</head>";

//echo "<body bgcolor=>";

//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-StepGroup $step_group-$step</font></i></H1>";
echo "<H3 ALIGN=LEFT > <font color=blue>StepName-$step_name</font></H3>";
echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/weekly_updates/main.php?project_category=fms&project_name=weekly_updates> Return Weekly Updates-HOME </A></font></H2>";







echo "<table border=1>";
 
echo "<tr>"; 
    
 echo " <th><font color=blue>proj_out</font></th>";
 echo "<th>proj_out<br />lookup</th>";
 echo " <th><font color=blue>fund_out</font></th>";
 echo " <th><font color=blue>proj_in</font></th>";
 echo "<th>proj_in<br />lookup</th>";
 echo " <th><font color=blue>fund_in</font></th>";
 echo " <th><font color=blue>amount</font></th>";
 echo " <th><font color=blue>comments</font></th>";
 echo " <th><font color=blue>ncas_in</font></th>";
 echo " <th><font color=blue>ncas_out</font></th>";
 echo " <th><font color=blue>datenew</font></th>";
 echo " <th><font color=blue>fid</font></th>";           
          
       
 

echo "</tr>";
echo  "<form method='post' autocomplete='off' action='stepJ9w_update_all.php'>";
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
if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//while ($row3=mysqli_fetch_array($result3)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
//extract($row3);
while ($row10=mysqli_fetch_array($result10)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row10);


//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr$t>";	      
//echo "<form method=post action=stepJ9_update.php>";	   
echo  "<td><input type='text' size='10' name='proj_out[]' value='$proj_out'</td>";
//if($fund_out != '' and $proj_out=='')
{	
echo "<td><a href='stepJ9w.php?fund=$fund_out&start_date=$start_date&end_date=$end_date&projout_look=y'>projlist</a></td>";
}
echo  "<td><input type='text' size='20' readonly='readonly' name='fund_out[]' value='$fund_out'</td>";
echo  "<td><input type='text' size='25'  name='proj_in[]' value='$proj_in'</td>";

//if($fund_in != '' and $proj_in=='')
{	
echo "<td><a href='stepJ9w.php?fund=$fund_in&fiscal_year=$fiscal_year&project_category=$project_category&project_name=$project_name&step_group=$step_group&step_num=$step_num&start_date=$start_date&end_date=$end_date&projin_look=y'>projlist</a></td>";
}

echo  "<td><input type='text' size='5' readonly='readonly' name='fund_in[]' value='$fund_in'</td>";
echo  "<td><input type='text' size='10' readonly='readonly' name='amount[]' value='$amount'</td>";
echo  "<td><input type='text' size='25' readonly='readonly' name='comments[]' value='$comments'</td>";
echo  "<td><input type='text' size='10' readonly='readonly' name='ncas_in[]' value='$ncas_in'</td>";
echo  "<td><input type='text' size='25' readonly='readonly' name='ncas_out[]' value='$ncas_out'</td>";
echo  "<td><input type='text' size='25' readonly='readonly' name='datenew[]' value='$datenew'</td>";
echo  "<td><input type='text' size='5' readonly='readonly' name='fid[]' value='$fid'</td>";
   
	      
echo "</tr>";

}

echo "<tr><td colspan='15' align='right'><input type='submit' name='submit2' value='Update'></td></tr>";
echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>
	   <input type='hidden' name='num10' value='$num10'>";
echo   "</form>";	 
echo "</table>";
if($projin_look=='y' or $projout_look=='y')
{echo "<br />Query to lookup Projects<br />";
//echo "<br />";

$query11="select partf_projects.projnum,partf_projects.funding_default_project,partf_projects.projcat,partf_projects.park,partf_projects.projname,partf_projects.statusper,partf_projects.div_app_amt as 'approve_amount',sum(partf_payments.amount) as 'payments_amount'
          from partf_projects
          left join partf_payments on partf_projects.projnum=partf_payments.charg_proj_num
		  where partf_projects.center='$fund' and reportdisplay='y'
          group by partf_projects.projnum  ";


/*
$query11="select partf_projects.projnum,partf_projects.projcat,partf_projects.park,partf_projects.projname,partf_projects.statusper,partf_projects.div_app_amt
          from partf_projects
          where partf_projects.center='$fund' and reportdisplay='y' ";

*/




		  
		  
		  
echo "<br />query11=$query11<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");
echo "<table border='1' align='center'>";
if($projin_look=='y'){echo "<tr><th>fund_in: <font color='green'>$fund</font>  proj_in Lookup</th></tr>";}
if($projout_look=='y'){echo "<tr><th>fund_out:<font color='red'> $fund</font>  proj_out Lookup</th></tr>";}
echo "</table>";
echo "<table border='1' align='center'>";

echo "<tr>"; 
    
 echo "<th><font color=blue>proj#</font></th>";
 echo "<th><font color=blue>funding_proj</font></th>";
 echo "<th><font color=blue>proj_cat</font></th>";
 echo "<th><font color=blue>status</font></th>";
 echo "<th><font color=blue>park</font></th>";
 echo "<th><font color=blue>projname</font></th>";
 echo "<th><font color=blue>approve_amount</font></th>";
 echo "<th><font color=blue>payments_amount</font></th>";


echo "</tr>"; 
          
while ($row11=mysqli_fetch_array($result11)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row11);
$approve_amount=number_format($approve_amount,2);
$payments_amount=number_format($payments_amount,2);

//echo "<pre>";print_r($row3);echo "</pre>";//exit;
echo "<tr>";
echo "<td>$projnum</td>";
echo "<td>$funding_default_project</td>";	          
echo "<td>$projcat</td>";	      
echo "<td>$statusper</td>";	      
echo "<td>$park</td>";	      
echo "<td>$projname</td>";	      
echo "<td>$approve_amount</td>";	      
echo "<td>$payments_amount</td>";	      
  
 

echo "</tr>";


}
echo "</table>";	
}
echo "</html>";

}
else
{
//echo "<br />Exceptions: $num10<br />";	


$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");


{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&submit=Update");}




}

?>
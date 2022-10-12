<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;}

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$project_category='ITS';
$project_name='wex_bill';
$step_group='B';


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters





if($reset=='y')
{
$query23a="update budget.project_steps_detail set status='pending' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group'  ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");


}

$query1="SELECT highlight_color from infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysql_fetch_array($result1);
extract($row1);


include("../../../budget/menu1314.php");
echo "<html>";

echo "<head>";

echo "</head>";


if($report_type=='form'){$report_form="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
if($report_type=='reports'){$report_reports="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}

echo "<style>
td {
    padding: 10px;
}

th {
    padding: 10px;
}



</style>";



echo "<br /><table align='center' border='1' align='left'><tr><th><font color='brown'>$project_name</font></th><th><a href='step_group.php?fyear=$fyear&report_type=reports'>Reports</a><br />$report_reports </th><th><a href='step_group.php?fyear=$fyear&report_type=form&reset=y'>Form</a><br />$report_form</th></tr></table>";

echo "<br />";

if($report_type=='form')
{


echo "<br />";

$query3="SELECT * from project_steps_detail where 1 and project_category='$project_category'
        and project_name='$project_name' and step_group='$step_group' order by step_num asc";


//echo "query3=$query3<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysql_num_rows($result3);


echo "<table align='center' border=1>";
 
echo 

"<tr> 
       
       <td align='center'><font color='brown'>StepNum</font></td>
       <td align='center'><font color='brown'>StepName</font></td>
       <td align='center'><font color=red>Action</font></td>";
   
                 
       
 

echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysql_fetch_array) at a time
while ($row3=mysql_fetch_array($result3))
	{	
	// The extract function automatically creates individual variables from the array $row
	//These individual variables are the names of the fields queried from MySQL
	//$rank=@$rank+1;
	extract($row3);
	//$rank=$rank+1;
	
	
	//echo $status;
	//$rand = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
    //$color = "#".$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];
	//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
	
	if($status=='complete'){$t=" bgcolor='#95e965'";}else{$t=" bgcolor='#B4CDCD'";}
	//echo "t=$t<br />";
	if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
	//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
	
	//echo $status;
	
	echo 
		
	"<tr$t>";	
	
		   
		   
		//echo "<td>$rank</td>";   
		echo "<td align='center'>$step_num</td>
		   <td>$step_name</td>
		   <td>
		   <form method='post' action='step$step_group$step_num.php'>
		   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
		   <input type='hidden' name='project_category' value='$project_category'>	   
		   <input type='hidden' name='project_name' value='$project_name'>	   
		   <input type='hidden' name='start_date' value='$start_date'>	   
		   <input type='hidden' name='end_date' value='$end_date'>	   
		   <input type='hidden' name='step_group' value='$step_group'>	   
		   <input type='hidden' name='step_num' value='$step_num'>	   
		   <input type='hidden' name='step' value='$step'>	   
		   <input type='hidden' name='step_name' value='$step_name'>	   
		   <input type='hidden' name='link' value='$link'>	   
		   <input type='submit' name='submit1' value='Execute'>
		   </form>
		   </td>";
		
				  
						 
	echo "</tr>";
	
	
	
	}

echo "</table>";

if($report=='y') //{echo "create check report" ;}

{
echo "<br />";


$query4="select center,center_code,ncas_account,sum(amount) as 'amount'
          from wex_report where valid='n'
         group by center,ncas_account
         order by center,ncas_account		 ";

echo "query4=$query4<br />";
		 
$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4 ");		 
		 
		 
		 
$query4_total="SELECT sum(amount) as 'total_amount1'
          from wex_report
		  where valid='n' ";
		  
echo "query4_total=$query4_total<br />";		  
		 
$result4_total = mysql_query($query4_total) or die ("Couldn't execute query 4 total.  $query4_total ");		
$row4_total=mysql_fetch_array($result4_total);

extract($row4_total);




$total_amount1=number_format($total_amount1,2);
echo "total_amount1=$total_amount1 <br />";



echo "<table align='center' border='1'>";
echo "<tr><td align='center'><font color='brown'>line#</font></td><td align='center'><font color='brown'>center</font></td><td align='center'><font color='brown'>center_code</font></td><td align='center'><font color='brown'>account</font></td><td align='center'><font color='brown'>amount</font></td></tr>";
                 
       
 while ($row4=mysql_fetch_array($result4))
	{	
	
extract($row4);	
$rank=@$rank+1;
$amount=number_format($amount,2);

//if($account=='532819' and $center_change != 'y'){$t=" bgcolor='salmon' ";}else{$t=" bgcolor='lightgreen' ";}

echo "<tr$t>";
echo "<td>$rank</td>";
echo "<td>$center</td>";
echo "<td>$center_code</td>";
echo "<td>$ncas_account</td>";
echo "<td>$amount</td>";

echo "</tr>";

}
echo "<tr><td></td><td></td><td></td><td>Total</td><td>$total_amount1</td></tr>";
}
}


echo "</body></html>";

?>


























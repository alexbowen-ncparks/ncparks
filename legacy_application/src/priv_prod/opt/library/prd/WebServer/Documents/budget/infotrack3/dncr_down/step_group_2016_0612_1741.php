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
$project_category='xtnd';
$project_name='dncr_down';
$step_group='B';


$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters



/*

if($reset=='y')
{
$query23a="update budget.project_steps_detail set status='pending' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group'  ";
			 
mysql_query($query23a) or die ("Couldn't execute query 23a.  $query23a");


}
*/
$query1="SELECT highlight_color from infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysql_query($query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysql_fetch_array($result1);
extract($row1);


include("../../../budget/menu1314.php");

echo "<table align='center'>";
echo "<tr>";



echo "</tr>";
echo "</table>";


//echo "<html>";

echo "<head>";
?>
<script language="javascript" type="text/javascript">
<!-- 
//Browser Support Code
function ajaxFunction(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
		var ajaxDisplay = document.getElementById("ajaxDiv");
			ajaxDisplay.innerHTML = ajaxRequest.responseText;	
		}
	}
	//var age = document.getElementById("age").value;
	//var wpm = document.getElementById("wpm").value;
	//var sex = document.getElementById("sex").value;
	//var queryString = "?age=" + age + "&wpm=" + wpm + "&sex=" + sex;
	//ajaxRequest.open("GET", "ajax-example2_update.php" + queryString, true);
	ajaxRequest.open("GET", "ajax-example2_update.php", true);
	ajaxRequest.send(null); 
}

//-->
</script>
<form name="myForm" align='center'>
<!--<input type="button" onclick="ajaxFunction()" value="Query MySQL" />-->
<input type="button" onclick="ajaxFunction()" value="Change highlight_color" />
</form>
<div id="ajaxDiv" align='center'>Your result will display here</div>
<?php
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
echo "<table align='center'><tr><td><font color='red'><b>Counter: $num3</b></font></td><td>";

include("../../infotrack/scoring/scoreG15.php");
include("../../infotrack/charts/bright_idea_chart.php");
echo "</td></tr></table>";
if($report_type=='form')
{


echo "<br />";

$query3="SELECT * from project_steps_detail where 1 and project_category='$project_category'
        and project_name='$project_name' and step_group='$step_group' order by step_num asc";


echo "query3=$query3<br />";
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result3 = mysql_query($query3) or die ("Couldn't execute query 3.  $query3");
$num3=mysql_num_rows($result3);


echo "<table align='center' border=1>";
 
echo 

"<tr> 
       
       <th><font color=red>StepNum</font></th>
       <th><font color=red>StepName</font></th>
       <th><font color=red>Action</font></th>";
   
      echo "<th><font color=red>Record</font></th>";
    echo "<th><font color=red>Edit</font></th>";
    echo "<th><font color=red>Delete Record</font></th>";
    echo "<th><font color=red>Duplicate Record</font></th>";            
       
 

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
	
	if($status=='complete'){$t=" bgcolor='$highlight_color'";}else{$t=" bgcolor='#B4CDCD'";}
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
		   
		   
echo "<td>
				  <form method='post' action='status_change.php'>
				  <input type='hidden' name='status' value='$status'>
				  <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
				  <input type='hidden' name='project_category' value='$project_category'>	   
				  <input type='hidden' name='project_name' value='$project_name'>	   
				  <input type='hidden' name='start_date' value='$start_date'>	   
				  <input type='hidden' name='end_date' value='$end_date'>	   
				  <input type='hidden' name='step_group' value='$step_group'>	   
				  <input type='hidden' name='step_num' value='$step_num'>	   
				  <input type='hidden' name='step' value='$step'>	   
				  <input type='hidden' name='step_name' value='$step_name'> 
				  <input type='submit' name='submit2' value='change_status'>
				  </form></td>
				  <td>
				  <form method='post' action='edit_record.php'>
				  <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
				  <input type='hidden' name='project_category' value='$project_category'>	   
				  <input type='hidden' name='project_name' value='$project_name'>	   
				  <input type='hidden' name='start_date' value='$start_date'>	   
				  <input type='hidden' name='end_date' value='$end_date'>	   
				  <input type='hidden' name='step_group' value='$step_group'>	   
				  <input type='hidden' name='step_num' value='$step_num'>	   
				  <input type='hidden' name='step' value='$step'>	   
				  <input type='hidden' name='step_name' value='$step_name'> 
				  <input type='hidden' name='cid' value='$cid'> 
				  <input type='submit' name='submit2' value='Edit'>
				  </form></td>
		
		   <td>
		   <form method='post' action='edit_record_delete_verify.php'>
		   <input type='hidden' name='cid' value='$cid'>
		   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
		   <input type='hidden' name='project_category' value='$project_category'>	   
		   <input type='hidden' name='project_name' value='$project_name'>	   
		   <input type='hidden' name='start_date' value='$start_date'>	   
		   <input type='hidden' name='end_date' value='$end_date'>	   
		   <input type='hidden' name='step_group' value='$step_group'>	   
		   <input type='hidden' name='step' value='$step'>  
		   <input type='submit' name='submit' value='DeleteRecord-$cid'>
		   </form></td>
		   <td>
		   <form method='post' action='edit_record_duplicate.php'>
		   <input type='hidden' name='cid' value='$cid'>
		   <input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
		   <input type='hidden' name='project_category' value='$project_category'>	   
		   <input type='hidden' name='project_name' value='$project_name'>	   
		   <input type='hidden' name='start_date' value='$start_date'>	   
		   <input type='hidden' name='end_date' value='$end_date'>	   
		   <input type='hidden' name='step_group' value='$step_group'>	   
		   <input type='hidden' name='step' value='$step'>  
		   <input type='hidden' name='link' value='$link'>  
		   <input type='hidden' name='weblink' value='$weblink'>  
		   <input type='hidden' name='status' value='$status'>  
		   <input type='submit' name='submit' value='DuplicateRecord-$cid'>
		   </form>	
		  
				  </td>";		   
		
				  
						 
	echo "</tr>";
	
	
	
	}

echo "</table>";
/*
if($report=='y') //{echo "create check report" ;}

{
echo "<br />";


$query4="select center,center_code,invoice_number,invoice_date,ncas_account,sum(amount) as 'amount',sum(rebate_adjust) as 'rebate_adjust',sum(amount-rebate_adjust) as 'adjusted_amount'
          from wex_report where valid='n'
         group by center,ncas_account
         order by center,ncas_account		 ";

//echo "query4=$query4<br />";
		 
$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4 ");		 
		 
		 
		 
$query4_total="SELECT sum(amount) as 'total_amount1',sum(rebate_adjust) as 'rebate_adjust_total',sum(amount-rebate_adjust) as 'adjusted_amount_total'
          from wex_report
		  where valid='n' ";



		  
//echo "query4_total=$query4_total<br />";		  
		 
$result4_total = mysql_query($query4_total) or die ("Couldn't execute query 4 total.  $query4_total ");		
$row4_total=mysql_fetch_array($result4_total);

extract($row4_total);


$rebate_adjust_total=number_format($rebate_adjust_total,2);
$adjusted_amount_total=number_format($adjusted_amount_total,2);








	


$total_amount1=number_format($total_amount1,2);
echo "total_amount1=$total_amount1 <br />";



echo "<table align='center' border='1'>";
echo "<tr><td align='center'><font color='brown'>line#</font></td><td align='center'><font color='brown'>invoice date</font></td><td align='center'><font color='brown'>invoice#</font></td><td align='center'><font color='brown'>center</font></td><td align='center'><font color='brown'>center_code</font></td><td align='center'><font color='brown'>account</font></td><td align='center'><font color='brown'>purchase </font></td><td align='center'><font color='brown'>rebate</font></td><td align='center'><font color='brown'>owed</font></td></tr>";
                 
       
 while ($row4=mysql_fetch_array($result4))
	{	
	
extract($row4);	
$rank=@$rank+1;
$amount=number_format($amount,2);

//if($account=='532819' and $center_change != 'y'){$t=" bgcolor='salmon' ";}else{$t=" bgcolor='lightgreen' ";}

$table_bg2="cornsilk";

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}



echo "<tr$t>";
echo "<td>$rank</td>";
echo "<td>$invoice_date</td>";
echo "<td>$invoice_number</td>";
echo "<td>$center</td>";
echo "<td>$center_code</td>";
echo "<td>$ncas_account</td>";
echo "<td>$amount</td>";
echo "<td>$rebate_adjust</td>";
echo "<td>$adjusted_amount</td>";

echo "</tr>";

}
echo "<tr><td></td><td></td><td></td><td></td><td></td><td>Total</td><td>$total_amount1</td><td>$rebate_adjust_total</td><td>$adjusted_amount_total</td></tr>";
}
*/
}
/*
if($report_type=='reports')
{






include("fyear_head_wex_bill.php");// database connection parameters
echo "<br />";
$report_listing="SELECT system_entry_date,user_id,ncas_invoice_number,month,calyear,sum(ncas_invoice_amount) as 'monthly_bill_total'
                  from wex_report
		          where 1 and fyear='$fyear'
				  and active='y'
		          group by ncas_invoice_number
		          order by system_entry_date desc   ";

	
//echo "report_listing=$report_listing <br />";
	
$result_report_listing = mysql_query($report_listing) or die ("Couldn't execute report listing.  $report_listing");
$num_report_listing=mysql_num_rows($result_report_listing);  
				  
echo "<table align='center' border='1' padding='5'>";
echo "<tr><th>Invoice<br />Number</th><th>Total<br />Amount</th><th>Entered<br />by</th></tr>";				  
			  
				  
 while ($row_report_listing=mysql_fetch_array($result_report_listing))
	{	
	
extract($row_report_listing);	

$monthly_bill_total2=number_format($monthly_bill_total,2);
if($table_bg2==''){$table_bg2='cornsilk';}
if($color==''){$t=" bgcolor='$table_bg2' ";$color=1;}else{$t='';$color='';}

echo "<tr$t>";
echo "<td><font color='brown'>$ncas_invoice_number</font> <a href='/budget/acs/acsFind.php?ncas_invoice_number=$ncas_invoice_number&submit_acs=Find' target='_blank'><img height='40' width='40' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of home'></img></a><br />$month-$calyear</td>";
echo "<td>$monthly_bill_total2</td>";
echo "<td>$user_id</td>";
//echo "<td><a href='/budget/acs/acsFind.php?ncas_invoice_number=$ncas_invoice_number&submit_acs=Find' target='_blank'>CDCS</a></td>";

	
	
	
echo "</tr>";				  
}

echo "</table>";	
}
*/
echo "</body></html>";

?>


























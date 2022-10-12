<?php
//ini_set('display_errors',1);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
session_start();
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
//echo $tempid;
extract($_REQUEST);
$end_date=str_replace("-","",$end_date);
//echo $end_date; exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters

//echo "<br />fiscal_year=$fiscal_year<br />"; //exit;

$query="insert into bd725_dpr_receipt_type_by_fund_ws(center,f_year)
select distinct(center),f_year from bd725_dpr_account_detail3_exp 
where 1 and f_year='$fiscal_year' ";
		
		
//echo "<br />query=$query<br />"; exit;		
			 
mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");



$query1="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.approp=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account_description='appropriation'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query1=$query1<br />"; exit;		
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query1.  $query1");


$query2="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.437127_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='437127'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query2=$query2<br />"; exit;		
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query2.  $query2");


$query3="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.438101_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='438101'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query3=$query3<br />"; exit;		
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query3.  $query3");


$query4="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.438123_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='438123'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query4=$query4<br />"; exit;		
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query4.  $query4");


$query5="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.436200_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='436200'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query5=$query5<br />"; exit;		
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query5.  $query5");

$query6="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.434500002_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='434500002'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query6=$query6<br />"; exit;		
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query6.  $query6");


$query7="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.437995_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='437995'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query7=$query7<br />"; exit;		
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query7.  $query7");

$query8="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.438106_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='438106'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query8=$query8<br />"; exit;		
			 
mysqli_query($connection, $query8) or die ("Couldn't execute query8.  $query8");


$query9="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.437990_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='437990'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query9=$query9<br />"; exit;		
			 
mysqli_query($connection, $query9) or die ("Couldn't execute query9.  $query9");


$query10="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.538315_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='538315'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query10=$query10<br />"; exit;		
			 
mysqli_query($connection, $query10) or die ("Couldn't execute query10.  $query10");

$query11="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.434500004_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='434500004'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query11=$query11<br />"; exit;		
			 
mysqli_query($connection, $query11) or die ("Couldn't execute query11.  $query11");

$query12="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.434320_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='434320'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query12=$query12<br />"; exit;		
			 
mysqli_query($connection, $query12) or die ("Couldn't execute query12.  $query12");

$query13="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.438122_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='438122'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query13=$query13<br />"; exit;		
			 
mysqli_query($connection, $query13) or die ("Couldn't execute query13.  $query13");


$query14="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.434180002_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='434180002'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query14=$query14<br />"; exit;		
			 
mysqli_query($connection, $query14) or die ("Couldn't execute query14.  $query14");


$query15="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.436203_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='436203'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query15=$query15<br />"; exit;		
			 
mysqli_query($connection, $query15) or die ("Couldn't execute query15.  $query15");


$query16="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.437113_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='437113'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query16=$query16<br />"; exit;		
			 
mysqli_query($connection, $query16) or die ("Couldn't execute query16.  $query16");


$query17="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.432512_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='432512'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query17=$query17<br />"; exit;		
			 
mysqli_query($connection, $query17) or die ("Couldn't execute query17.  $query17");


$query18="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.`432e08_amt`=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='432e08'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query18=$query18<br />"; exit;		
			 
mysqli_query($connection, $query18) or die ("Couldn't execute query18.  $query18");


$query19="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.438054_amt=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='438054'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query19=$query19<br />"; exit;		
			 
mysqli_query($connection, $query19) or die ("Couldn't execute query19.  $query19");


$query20="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.`432e09_amt`=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='432e09'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query20=$query20<br />"; exit;		
			 
mysqli_query($connection, $query20) or die ("Couldn't execute query20.  $query20");

$query21="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_account_detail3_rec
set bd725_dpr_receipt_type_by_fund_ws.`432e11_amt`=bd725_dpr_account_detail3_rec.ptd
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_account_detail3_rec.center
and bd725_dpr_account_detail3_rec.account='432e11'
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_account_detail3_rec.f_year='$fiscal_year' ";
		
		
//echo "<br />query21=$query21<br />"; exit;		
			 
mysqli_query($connection, $query21) or die ("Couldn't execute query21.  $query21");


$query21a="update bd725_dpr_receipt_type_by_fund_ws,bd725_dpr_transfers2
set bd725_dpr_receipt_type_by_fund_ws.net_transfer=bd725_dpr_transfers2.net_transfer
where bd725_dpr_receipt_type_by_fund_ws.center=bd725_dpr_transfers2.center
and bd725_dpr_receipt_type_by_fund_ws.f_year='$fiscal_year'
and bd725_dpr_transfers2.f_year='$fiscal_year' ";
		
		
//echo "<br />query21a=$query21a<br />"; exit;		
			 
mysqli_query($connection, $query21a) or die ("Couldn't execute query21a.  $query21a");



$query21b="update bd725_dpr_receipt_type_by_fund_ws
set total_funding=approp+437127_amt+438101_amt+438123_amt+436200_amt+434500002_amt+437995_amt+438106_amt+437990_amt+538315_amt+434500004_amt+434320_amt+438122_amt+434180002_amt+436203_amt+437113_amt+432512_amt+`432e08_amt`+438054_amt+`432e09_amt`+`432e11_amt`+net_transfer
where f_year='$fiscal_year' ";
		
		
//echo "<br />query21b=$query21b<br />"; exit;		
			 
mysqli_query($connection, $query21b) or die ("Couldn't execute query21b.  $query21b");



$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category' and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");


/*

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}

*/


////mysql_close();

/*

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0) 
//{echo "num24 not equal to zero";}

*/

{header("location: naspd_annual.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&f_year=$fiscal_year&report_type=form");}

 ?>
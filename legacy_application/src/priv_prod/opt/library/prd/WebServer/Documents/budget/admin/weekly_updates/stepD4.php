<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
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

$query1="update budget.xtnd_po_encumbrances set center=trim(center),
buying_entity=trim(buying_entity),
po_number=trim(po_number),
blanket_release_number=trim(blanket_release_number),
po_line_number=trim(po_line_number),
vendor_short_name=trim(vendor_short_name),
first_line_item_description=trim(first_line_item_description),
po_remaining_encumbrance=trim(po_remaining_encumbrance),
po_line_entered_date=trim(po_line_entered_date),
acct=trim(acct),
balance_date=trim(balance_date),
datenew=trim(datenew);";
			 
mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$query2="CREATE TABLE `budget`.`xtnd_po_encumbrances2` (
`first_line_item_description` varchar( 100 ) NOT NULL default '',
`xtnd_po_encumbrances_id` varchar( 10 ) NOT NULL default '',
`start_id` varchar( 10 ) NOT NULL default '',
`stop_id` varchar( 10 ) NOT NULL default '',
`id` int( 10 ) unsigned NOT NULL AUTO_INCREMENT ,
`next_id` int( 10 ) NOT NULL default '0',
`acct` varchar( 20 ) NOT NULL default '',
PRIMARY KEY ( `id` )
) ENGINE = MyISAM; ";
			 
mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$query3="insert into budget.xtnd_po_encumbrances2(
first_line_item_description,
xtnd_po_encumbrances_id)

SELECT first_line_item_description, id
FROM budget.xtnd_po_encumbrances
WHERE first_line_item_description
LIKE '%total for account%'
ORDER BY id;";
			 
mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$query4="update budget.xtnd_po_encumbrances2
set stop_id=xtnd_po_encumbrances_id
where 1;";
			 
mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$query5="update budget.xtnd_po_encumbrances2
set next_id=id+1
where 1;";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$query6="update budget.xtnd_po_encumbrances2
set start_id='1'
where id='1';";
			 
mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$query7="CREATE TABLE `budget`.`xtnd_po_encumbrances3` (
`id` varchar( 10 ) NOT NULL default '',
`start_id` varchar( 10 ) NOT NULL default ''
) ENGINE = MyISAM;";
			 
mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

$query8="insert into budget.xtnd_po_encumbrances3 (id,start_id)
select
next_id,stop_id+1
from xtnd_po_encumbrances2
where 1;";
			 
mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

$query9="update budget.xtnd_po_encumbrances2,xtnd_po_encumbrances3
set xtnd_po_encumbrances2.start_id=xtnd_po_encumbrances3.start_id
where xtnd_po_encumbrances2.id=xtnd_po_encumbrances3.id;";
			 
mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");

$query10="update budget.xtnd_po_encumbrances2
set first_line_item_description=trim(first_line_item_description)
where 1;";
			 
mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");

$query11="update budget.xtnd_po_encumbrances2
set acct=mid(first_line_item_description,19,15)
where 1;";
			 
mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");

$query12="update budget.xtnd_po_encumbrances,xtnd_po_encumbrances2
set xtnd_po_encumbrances.acct=xtnd_po_encumbrances2.acct
where xtnd_po_encumbrances.id >= xtnd_po_encumbrances2.start_id
and xtnd_po_encumbrances.id <= xtnd_po_encumbrances2.stop_id;";
			 
mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");

$query13="delete from budget.xtnd_po_encumbrances
where po_line_number like '%line%';";
			 
mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");

$query14="delete from budget.xtnd_po_encumbrances
where po_line_number like '%number%';";
			 
mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");

$query15="delete from budget.xtnd_po_encumbrances
where po_line_number like '%-%';";
			 
mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15");

$query16="delete from budget.xtnd_po_encumbrances
where po_line_number='';";
			 
mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16");

$query17="update budget.xtnd_po_encumbrances
set datenew='$end_date' where 1; ";
			 
mysqli_query($connection, $query17) or die ("Couldn't execute query 17.  $query17");

$query18="update budget.xtnd_po_encumbrances
set balance_date=concat(mid(datenew,5,2),'/',mid(datenew,7,2),'/',mid(datenew,3,2))
where 1;";
			 
mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18");

$query19="update budget.xtnd_po_encumbrances
set enter_date_new=concat(mid(po_line_entered_date,5,4),mid(po_line_entered_date,1,2),mid(po_line_entered_date,3,2))
where 1;";
			 
mysqli_query($connection, $query19) or die ("Couldn't execute query 19.  $query19");

$query20="update budget.xtnd_po_encumbrances
set ponum_line=concat(po_number,'0',po_line_number)
where 1;";
			 
mysqli_query($connection, $query20) or die ("Couldn't execute query 20.  $query20");

$query21="replace INTO budget.xtnd_po_vitals
SELECT *  
FROM  budget.xtnd_po_encumbrances
WHERE 1;";
			 
mysqli_query($connection, $query21) or die ("Couldn't execute query 21.  $query21");

$query22="drop table budget.xtnd_po_encumbrances2;";
			 
mysqli_query($connection, $query22) or die ("Couldn't execute query 22.  $query22");

$query23="drop table budget.xtnd_po_encumbrances3;";
			 
mysqli_query($connection, $query23) or die ("Couldn't execute query 23.  $query23");

$query23a="update budget.project_steps_detail set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' and step_num='$step_num' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");

$query24="select * from budget.project_steps_detail
         where project_category='$project_category' and project_name='$project_name'
		 and step_group='$step_group'  and status='pending' "; 

$result24=mysqli_query($connection, $query24) or die ("Couldn't execute query 24.  $query24");

$num24=mysqli_num_rows($result24);

//echo "pending_items=$num4";exit;

//if($num4==0){echo "done"}; if ($num4!=0){echo "$num4 pending items"}; exit;
if($num24==0)

{$query25="update budget.project_steps set status='complete' where project_category='$project_category'
         and project_name='$project_name' and step_group='$step_group' ";
mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25");}
////mysql_close();

if($num24==0)

{header("location: main.php?project_category=$project_category&project_name=$project_name ");}

if($num24!=0)

{header("location: step_group.php?project_category=$project_category&project_name=$project_name
      &step_group=$step_group&step_name=$step_name&fiscal_year=$fiscal_year&start_date=$start_date
	  &end_date=$end_date");}

 ?>





















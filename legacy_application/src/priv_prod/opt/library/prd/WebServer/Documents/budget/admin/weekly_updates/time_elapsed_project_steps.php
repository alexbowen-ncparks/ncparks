<?php
//echo "time_elapsed_project_steps.php";
$query1="SELECT time_start as 'ts_stepa', time_complete as 'tc_stepa' from project_steps
         where project_category='$project_category' and project_name='$project_name'
         and step_group='a' ";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (fiscal_year) as $fiscal_year


$query2="SELECT time_complete as 'tc_stepb' from project_steps
         where project_category='$project_category' and project_name='$project_name'
         and step_group='b' ";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$row2=mysqli_fetch_array($result2);
extract($row2);//brings back max (fiscal_year) as $fiscal_year

$query3="SELECT time_complete as 'tc_stepc' from project_steps
         where project_category='$project_category' and project_name='$project_name'
         and step_group='c' ";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);//brings back max (fiscal_year) as $fiscal_year

$query4="SELECT time_complete as 'tc_stepd' from project_steps
         where project_category='$project_category' and project_name='$project_name'
         and step_group='d' ";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$row4=mysqli_fetch_array($result4);
extract($row4);//brings back max (fiscal_year) as $fiscal_year

$query5="SELECT time_complete as 'tc_stepe' from project_steps
         where project_category='$project_category' and project_name='$project_name'
         and step_group='e' ";

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$row5=mysqli_fetch_array($result5);
extract($row5);//brings back max (fiscal_year) as $fiscal_year

$query6="SELECT time_complete as 'tc_stepg' from project_steps
         where project_category='$project_category' and project_name='$project_name'
         and step_group='g' ";

$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$row6=mysqli_fetch_array($result6);
extract($row6);//brings back max (fiscal_year) as $fiscal_year


$query7="SELECT time_complete as 'tc_steph' from project_steps
         where project_category='$project_category' and project_name='$project_name'
         and step_group='h' ";

$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

$row7=mysqli_fetch_array($result7);
extract($row7);//brings back max (fiscal_year) as $fiscal_year

$query8="SELECT time_complete as 'tc_stepi' from project_steps
         where project_category='$project_category' and project_name='$project_name'
         and step_group='i' ";

$result8 = mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

$row8=mysqli_fetch_array($result8);
extract($row8);//brings back max (fiscal_year) as $fiscal_year


$query9="SELECT time_complete as 'tc_stepj' from project_steps
         where project_category='$project_category' and project_name='$project_name'
         and step_group='j' ";

$result9 = mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");

$row9=mysqli_fetch_array($result9);
extract($row9);//brings back max (fiscal_year) as $fiscal_year
/*
echo "<br />time_comp stepa=$tc_stepa";
echo "<br />time_comp stepb=$tc_stepb";
echo "<br />time_comp stepc=$tc_stepc";
echo "<br />time_comp stepd=$tc_stepd";
echo "<br />time_comp stepe=$tc_stepe";
echo "<br />time_comp stepg=$tc_stepg";
echo "<br />time_comp steph=$tc_steph";
echo "<br />time_comp stepi=$tc_stepi";
echo "<br />time_comp stepj=$tc_stepj";
*/

if($ts_stepa != '' and $tc_stepa != '')
{
$query9a="update project_steps
         set time_elapsed_sec=$tc_stepa-$ts_stepa where project_category='$project_category' and project_name='$project_name'
         and step_group='a' ";

$result9a = mysqli_query($connection, $query9a) or die ("Couldn't execute query 9a.  $query9a");
}


if($tc_stepb != '' and $tc_stepa != '')
{
$query10="update project_steps
         set time_elapsed_sec=$tc_stepb-$tc_stepa where project_category='$project_category' and project_name='$project_name'
         and step_group='b' ";

$result10 = mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");
}

if($tc_stepc != '' and $tc_stepb != '')
{
$query11="update project_steps
         set time_elapsed_sec=$tc_stepc-$tc_stepb where project_category='$project_category' and project_name='$project_name'
         and step_group='c' ";

$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11");
}

if($tc_stepd != '' and $tc_stepc != '')
{
$query12="update project_steps
         set time_elapsed_sec=$tc_stepd-$tc_stepc where project_category='$project_category' and project_name='$project_name'
         and step_group='d' ";
$result12 = mysqli_query($connection, $query12) or die ("Couldn't execute query 12.  $query12");
}

if($tc_stepe != '' and $tc_stepd != '')
{
$query13="update project_steps
         set time_elapsed_sec=$tc_stepe-$tc_stepd where project_category='$project_category' and project_name='$project_name'
         and step_group='e' ";

$result13 = mysqli_query($connection, $query13) or die ("Couldn't execute query 13.  $query13");
}
/*
if($tc_stepg != '' and $tc_stepe != '')
{
$query14="update project_steps
         set time_elapsed_sec=$tc_stepg-$tc_stepe where project_category='$project_category' and project_name='$project_name'
         and step_group='g' ";

$result14 = mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");
}
*/

if($tc_stepg != '' and $tc_stepc != '')
{
$query14="update project_steps
         set time_elapsed_sec=$tc_stepg-$tc_stepc where project_category='$project_category' and project_name='$project_name'
         and step_group='g' ";

$result14 = mysqli_query($connection, $query14) or die ("Couldn't execute query 14.  $query14");
}










if($tc_steph != '' and $tc_stepg != '')
{
$query15="update project_steps
         set time_elapsed_sec=$tc_steph-$tc_stepg where project_category='$project_category' and project_name='$project_name'
         and step_group='h' ";

$result15 = mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15");
}


if($tc_stepi != '' and $tc_steph != '')
{
$query16="update project_steps
         set time_elapsed_sec=$tc_stepi-$tc_steph where project_category='$project_category' and project_name='$project_name'
         and step_group='i'  ";

$result16 = mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16");
}
/*
if($tc_stepj != '' and $tc_stepi != '')
{
$query17="update project_steps
         set time_elapsed_sec=$tc_stepj-$tc_stepi where project_category='$project_category' and project_name='$project_name'
         and step_group='j' ";

$result17 = mysqli_query($connection, $query17) or die ("Couldn't execute query 17.  $query17");
}
*/

if($tc_stepj != '' and $tc_steph != '')
{
$query17="update project_steps
         set time_elapsed_sec=$tc_stepj-$tc_steph where project_category='$project_category' and project_name='$project_name'
         and step_group='j' ";

$result17 = mysqli_query($connection, $query17) or die ("Couldn't execute query 17.  $query17");
}







$query18="update project_steps
         set time_elapsed_min=time_elapsed_sec/60 where project_category='$project_category' 
		 and project_name='$project_name' and time_elapsed_sec != '' ";

$result18 = mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18");



?>
<?php
//echo "hello world";exit;
/*
$query4="select count(cid) as 'total'
from mission_bright_ideas2
where cid='$cid'";
//echo "query4=$query4";exit;
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
$row4=mysqli_fetch_array($result4);
extract($row4);
//echo "total=$total<br />";

$query4a="update mission_bright_ideas
          set complete='$total'
          where cid='$cid'		  ";
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
//$row4a=mysqli_fetch_array($result4a);
//extract($row4a);
*/

$query4b="select complete,total_points,incrementor from mission_bright_ideas
         where cid='$cid' ";
$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");
$row4b=mysqli_fetch_array($result4b);
extract($row4b);
//echo "complete=$complete<br />";
//echo "total_points=$total_points<br />";

//echo "line 26 complete=$complete<br />";
//echo "line 27 total_points=$total_points<br />";
//echo "line 28 incrementor=$incrementor<br />";
//exit;

/*
if($complete > $total_points)

{

$total_points=$total_points+$incrementor;

$query4c="update mission_bright_ideas
          set total_points=$total_points where  cid='$cid' ";
$result4c = mysqli_query($connection, $query4c) or die ("Couldn't execute query 4c.  $query4c");

}
*/

//echo "total_points line30=$total_points<br />";


//echo "mission_bright_ideas Updated<br />cid=$cid<br />complete=$total<br />total=$total_points";






/*
$query5="select count(cid) as 'complete'
from project_steps_detail
where project_category='fms'
and status='complete' 
and fiscal_year='$fiscal_year' ";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$row5=mysqli_fetch_array($result5);
extract($row5);
echo "completed $complete of $total";

$query6="update mission_scores
         set complete='$complete',total='$total',percomp=complete/total*100
		 where gid='5'
		 and playstation='admi' ";
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");
*/



 ?>
 
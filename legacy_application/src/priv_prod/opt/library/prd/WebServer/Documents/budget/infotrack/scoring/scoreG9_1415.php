<?php
$query7="truncate table mission_scoring;";

$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query7. $query7");

$query8="insert into mission_scoring(gid,playstation,complete)
         select '9',park,count(id) as 'complete'
		 from cash_summary
		 where valid='y'
		 and weekend='n'
		 and compliance='y'
		 and fyear='1415'
		 group by park;";

$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query8. $query8");


$query9="insert into mission_scoring(gid,playstation,total)
         select '9',park,count(id) as 'total'
		 from cash_summary
		 where valid='y'
		 and weekend='n'
		 and fyear='1415'
		 group by park;";

$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query9. $query9");

/*
$query8a="insert into mission_scoring(gid,playstation,complete)
         select '8',playstation,count(gid) as 'complete'
		 from survey_scores_summary
		 where record_complete='y'
		 group by playstation;";

$result8a=mysqli_query($connection, $query8a) or die ("Couldn't execute query8a. $query8a");
*/

/*
$query9a="insert into mission_scoring(gid,playstation,total)
         select '8',playstation,count(gid) as 'total'
		 from survey_scores_summary
		 where 1
		 group by playstation;";

$result9a=mysqli_query($connection, $query9a) or die ("Couldn't execute query9a. $query9a");
*/


$query10="truncate table mission_scoring2;";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query10. $query10");

/*
$query11="insert into mission_scoring2(gid,playstation,complete,total)
          select gid,playstation,sum(complete),sum(total)
		  from mission_scoring
		  where gid='9'
		  group by gid,playstation;";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query11. $query11");
*/
$query11="insert into mission_scoring2(gid,playstation,complete,total)
          select gid,playstation,sum(complete),sum(total)
		  from mission_scoring
		  where 1
		  group by gid,playstation;";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query11. $query11");
/*

$query12="update mission_scores,mission_scoring2
          set mission_scores.complete=mission_scoring2.complete,
		  mission_scores.total=mission_scoring2.total
		  where mission_scores.gid='9'
		  and mission_scoring2.gid='9'
		  and mission_scores.playstation=mission_scoring2.playstation;";

$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query12. $query12");
*/

/*
$query11a="update mission_scoring2
          set complete='1',
		  total='1000'
		  where gid='8'
		  and complete='0'; ";

$result11a=mysqli_query($connection, $query11a) or die ("Couldn't execute query11a. $query11a");
*/


/*

$query12="update mission_scores,mission_scoring2
          set mission_scores.complete=mission_scoring2.complete,
		  mission_scores.total=mission_scoring2.total
		  where mission_scores.gid=mission_scoring2.gid
		  and mission_scores.playstation=mission_scoring2.playstation;";

$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query12. $query12");
*/


$query12="update mission_scores,mission_scoring2
          set mission_scores.complete=mission_scoring2.complete,
		  mission_scores.total=mission_scoring2.total
		  where mission_scores.gid='9' and mission_scoring2.gid='9'
		  and mission_scores.fyear='1415'
		  and mission_scores.playstation=mission_scoring2.playstation;";

$result12=mysqli_query($connection, $query12) or die ("Couldn't execute query12. $query12");



$query13="update mission_scores
set percomp=complete/total*100
where gid = '9'
and fyear='1415' ";



$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query13. $query13");



$query14="update mission_scores
set percomp='.01'
where gid='9'
and complete='0'
and total >= '1'
and fyear='1415' ;";



$result14=mysqli_query($connection, $query14) or die ("Couldn't execute query14. $query14");









/*

$query13="update mission_scores
          set complete='1',
		  total='1000'
		  where gid='8'
		  and percomp='0'; ";

$result13=mysqli_query($connection, $query13) or die ("Couldn't execute query13. $query13");


*/


//echo "gid=$gid";//exit;


//echo "query13=$query13";exit;

?>
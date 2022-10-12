<?php
$query7="truncate table survey_scoring_summary;";

$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query7. $query7");

$query8="insert into survey_scoring_summary(gid,playstation,complete,player,completion_date)
select gid,playstation,count(gid) as 'complete',player,system_entry_date
from survey_scores
where park_answer != ''
group by gid,playstation;";

$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query8. $query8");


$query9="update survey_scores_summary,survey_scoring_summary
         set survey_scores_summary.complete=survey_scoring_summary.complete,
		 survey_scores_summary.player=survey_scoring_summary.player,
		 survey_scores_summary.completion_date=survey_scoring_summary.completion_date
		 where survey_scores_summary.gid=survey_scoring_summary.gid
		 and survey_scores_summary.playstation=survey_scoring_summary.playstation;";

$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query9. $query9");



$query10="update survey_scores_summary,survey_games
          set survey_scores_summary.total=survey_games.qcount
		  where survey_scores_summary.gid=survey_games.gid;";

$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query10. $query10");


$query11="update survey_scores_summary
          set record_complete='y'
          where complete=total;";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query11. $query11");




?>
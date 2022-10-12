<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters


//include("../../../budget/menu1314.php");

//$start_date2=str_replace("-","",$start_date);
//$end_date2=str_replace("-","",$end_date);

	
include("../../budget/menu1314.php");	
//include("service_contracts_menu.php");
include("money_quotes_menu.php");

$query4a="select favorite_qid as 'favorite_qid2' from money_quotes_scores
          where tempid='$tempid' and calmonth='$calmonth' and calyear='$calyear'
		   ";
		   
//echo "<br />query4a=$query4a<br />";	
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");

$row4a=mysqli_fetch_array($result4a);
extract($row4a);



//echo "<br />cardholder3=$cardholder3";
//echo "<br />card_number3=$card_number3";
echo "<html>";
echo "<head>";
echo "<script type=\"text/javascript\" src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.js\"></script>";

echo "<style>";

echo "table { background-color: burlywood; font-color: blue; font-size: 15;}";

if($favorite_qid2=='' and $score!='y')
{
echo "tr:hover {background: yellow}";
}
echo "</style>";


echo "</head>";


echo "<br /><br />";
echo "<table align='center' cellspacing='8'><tr><th><i>$calmonth  $calyear Quote of the Day (VOTE)</i></th></tr></table>";


echo "<br />";





if($score=='y')
{
	
$query2e="insert ignore into money_quotes_scores
          set calmonth='$calmonth',calyear='$calyear',tempid='$tempid',favorite_qid='$favorite'
		   ";
	



	
//echo "<br />query2e=$query2e<br />";	
$result2e = mysqli_query($connection, $query2e) or die ("Couldn't execute query 2e.  $query2e");


$query3="select favorite_qid,count(favorite_qid) as 'score' from money_quotes_scores
          where favorite_qid='$favorite' and calmonth='$calmonth' and calyear='$calyear'
		   ";
		   
//echo "<br />query3=$query3<br />";	
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");

$row3=mysqli_fetch_array($result3);
extract($row3);

//echo "favorite_qid: $favorite (score=$score)";

if($score != 0)
{
$query4="update money_quotes set score='$score' where id='$favorite_qid'  ";	
//echo "<br />query4=$query4<br />";
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");	
	
	
}	

}


$query4a="select favorite_qid as 'favorite_qid2' from money_quotes_scores
          where tempid='$tempid' and calmonth='$calmonth' and calyear='$calyear'
		   ";
		   
//echo "<br />query4a=$query4a<br />";	
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");

$row4a=mysqli_fetch_array($result4a);
extract($row4a);

//echo "<br />favorite_qid2=$favorite_qid2<br />";

$query4b="select count(favorite_qid) as 'total_votes' from money_quotes_scores
          where 1 and calmonth='$calmonth' and calyear='$calyear'
		   ";
		   
//echo "<br />query4b=$query4b<br />";	
$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");

$row4b=mysqli_fetch_array($result4b);
extract($row4b);

//echo "<br />total_votes=$total_votes<br />";




$query5="SELECT mq_month_name,mq_day,quote_comment,author,author_last_name,score as 'quote_score',id  from money_quotes
         where mq_month='$month_number' and mq_calyear='$calyear'	
         order by mq_date asc		 ";


//echo "<br />Query5=$query5<br /><br />";;
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
//echo "num5=$num5";
//////mysql_close();


//if($num5==0){echo "<table align='center'><tr><td>NO Cardholders Missing</td></tr></table>"; exit;}
echo "<table align='center' border='1'>";
 
echo 

"<tr>";        
 //echo "<th>xtnd_report_date</th>";
 echo "<th>Quote</th>";
 //echo "<th>Author</th>";
 echo "<th>Author</th>";
 //echo "<th>% of Vote</th>";
 //echo "<th>Division</th>";
 
 echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row5=mysqli_fetch_array($result5)){


extract($row5);

$table_bg2="cornsilk";

//if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}
//echo $status;
$last_name=strlen($author_last_name);
//echo "<tr$t>";

$vote_yes="<svg width='200' height='100'>
  <ellipse cx='100' cy='50' rx='80' ry='40'
  style='fill:lightgreen;stroke:purple;stroke-width:2' />
  <text x='60' y='55' fill='black' font-size='20'>$author_last_name</text>
</svg>";




//echo "vote_yes=$vote_yes";

//$id2=$id*5;
$quote_percent=round($quote_score/$total_votes*100,0);
$quote_score2=$quote_percent*10*.5;
$text_x=$quote_score2*.40;

//echo "<br />quote_score=$quote_score<br />";
//echo "<br />quote_score2=$quote_score2<br />";
//echo "<br />text_x=$text_x<br />";

echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";
echo "<td><i><b>$quote_comment</b></i></td>";

echo "<td><a href='money_quotes_scores.php?score=y&favorite=$id&calmonth=$calmonth&calyear=$calyear&month_number=$month_number&menu=$menu'>$vote_yes</a></td>"; 




	
echo "</tr>";


}

echo "</table>";
echo "<br /><br />";


echo "</body></html>";



?>


























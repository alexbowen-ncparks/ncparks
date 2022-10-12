<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
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






//if($beacnum != '60032793')
{	
include ("../../budget/menu1415_v1.php");	

include("money_polls_menu.php");

}
//include("../../budget/menu1314.php");	
//include("service_contracts_menu.php");
//if($menu==3){$shade_menu3="class=cartRow";$calmonth='march';$month_number='03';$calyear='2018';}

/*
if($menu==3)
{
include("poll_instructions.php");	
}
*/

//if($menu==1){$round=1;}
//if($menu==2){$round=1;}





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


	
//echo "<table align='center'><tr><th><i><a href='mq_votes.php?calyear=$calyear&calmonth=$calmonth&round=$round'  target='_blank'>Leaderboard</i></th></tr></table>";


//}
//echo "<H1 ALIGN=LEFT > <font color=brown><i>XTND Report Date: $xtnd_report_date</font></i></H1>";
//echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Return HOME </A></font></H2>";

echo "<br />";





$query4a="select poll_name from polls
          where id='$poll_id'  ";
		   
//echo "<br />query4a=$query4a<br />";	
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");

$row4a=mysqli_fetch_array($result4a);
extract($row4a);

//echo "<br />poll_name=$poll_name<br />";










$query4b="select sum(choice_points) as 'total_votes' from poll_choices
          where 1 and poll_id='$poll_id'  ";
		   
//echo "<br />query4b=$query4b<br />";	
$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");

$row4b=mysqli_fetch_array($result4b);
extract($row4b);

//echo "<br />total_votes=$total_votes<br />";


echo "<table align='center'><tr><th><font class='cartRow'>POLL: $poll_name (total votes: $total_votes)</font></th></tr></table>";


$query5="SELECT choice_name as 'quote_comment',choice_points as 'quote_score' from poll_choices
         where poll_id='$poll_id'	 ";


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
 
 {
 echo "<th>Choice</th>";
 }
 //echo "<th>Author</th>";
 //echo "<th>MyFavorite</th>";
 
 echo "<th>% of Total</th>";
 //echo "<th>Division</th>";
 
 echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row5=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5);

$table_bg2="cornsilk";

//if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}
//echo $status;



//echo "vote_yes=$vote_yes";

//$id2=$id*5;
$quote_percent=round($quote_score/$total_votes*100,0);
$quote_score2=$quote_percent*10*.5;
/*
if($beacnum=='60032793')
{
$quote_score2=$quote_percent*10*.25/2;
}	
*/
$text_x=$quote_score2*.40;

//echo "<br />quote_score=$quote_score<br />";
//echo "<br />quote_score2=$quote_score2<br />";
//echo "<br />text_x=$text_x<br />";

echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";
//if($beacnum != '60032793')
{	
echo "<td><i><b>$quote_comment</b></i><br />votes: $quote_score</td>";
}
//echo "<td><b>$author</b></td>";
//if($score=='')
//{
//if($id==$favorite_qid2)	
//echo "<td><a href='money_quotes_scores.php?score=y&favorite=$id&calmonth=$calmonth&calyear=$calyear&month_number=$month_number&round=$round&menu=$menu'>$vote_yes</a></td>"; 

/*
if($menu==3)
{
//echo "<td>$round_score</td>";
echo "<td></td>";
}
*/



//} 

//if($beacnum != '60032793')
	
/*
{
if($quote_score!=0 and $favorite_qid2 != '')
{
echo "<td> 
<svg width='500' height='100' xmlns='http://www.w3.org/2000/svg' version='1.1'>
<rect x='0' y='0' width='$quote_score2' height='100' fill='lightgreen'/>
 <text x='$text_x' y='50' fill='black' font-size='20'>$quote_percent</text></svg></td>";
}
else
{
echo "<td></td>";


}	

}
*/
echo "<td> 
<svg width='500' height='100' xmlns='http://www.w3.org/2000/svg' version='1.1'>
<rect x='0' y='0' width='$quote_score2' height='100' fill='lightgreen'/>
 <text x='$text_x' y='50' fill='black' font-size='20'>$quote_percent</text></svg></td>";







	
echo "</tr>";


//$i++;



//$cardholder2=$cardholder;

}

echo "</table>";
echo "<br /><br />";
/*
echo "<table align='center'>";
echo "<tr><th><font color='red'>WARNING! ONLY Click Submit when \"DPR Employee Status\" of each Cardholder has been MARKED with Checkmark or Xmark</font></th></tr>";
echo "</table>";
echo "<br /><br />";
*/
/*
echo "<form action='stepL3e2c1a.php' align='center'><input type='submit' name='submit' value='Submit'><input type='hidden' name='dpr_update' value='y'></form>";
*/
//echo "</table>";

echo "</body></html>";




?>
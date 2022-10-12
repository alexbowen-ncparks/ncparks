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


$query1="update money_quotes_scores,money_quotes
set money_quotes_scores.favorite_qid_descript=concat(money_quotes.quote_comment,' (',money_quotes.author_last_name,' )')
where money_quotes_scores.favorite_qid=money_quotes.id";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

if($round==''){$round='3';}

//if($beacnum != '60032793')
{	
include ("../../budget/menu1415_v1.php");	

include("money_quotes_menu.php");

}
//include("../../budget/menu1314.php");	
//include("service_contracts_menu.php");
if($menu==3){$shade_menu3="class=cartRow";$calmonth='march';$month_number='03';$calyear='2018';}

/*
if($menu==3)
{
include("poll_instructions.php");	
}
*/

if($menu==1){$round=1;}
if($menu==2){$round=1;}

$query4a="select favorite_qid as 'favorite_qid2' from money_quotes_scores
          where tempid='$tempid' and calmonth='$calmonth' and calyear='$calyear' and round='$round'	
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
//echo ".normal {background-color:#B4CDCD;}";
//echo ".normal {background-color:peachpuff;}";
//echo ".normal2 {background-color:yellow;}";
//echo ".highlight {background-color:#ff0000;}"; 
if($favorite_qid2=='' and $score!='y')
{
echo "tr:hover {background: yellow}";
}
echo "</style>";
/*
echo "<script type=\"text/javascript\"> function onRow(rowID)
{var row=document.getElementById(rowID);
var curr=row.className;
if(curr.indexOf(\"normal\")>=0)row.className=\"highlight\";else row.className=\"normal\";
 } 
</script>";
*/

echo "</head>";




//echo "<body bgcolor=>";
//include("../../../budget/menu1314.php");
//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
/*
echo "<br /><br />";
echo "<table align='center' cellspacing='8'><tr><th><i>$calmonth  $calyear Poll </i></th></tr></table>";
echo "<br />";
*/
//if($level=='5' or $beacnum=='60032842' or $beacnum=='60033012')
//{
	
	
echo "<table align='center'><tr><th><i><a href='mq_votes.php?calyear=$calyear&calmonth=$calmonth&round=$round'  target='_blank'>Leaderboard</i></th></tr></table>";


//}
//echo "<H1 ALIGN=LEFT > <font color=brown><i>XTND Report Date: $xtnd_report_date</font></i></H1>";
//echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Return HOME </A></font></H2>";

echo "<br />";





if($score=='y')
{
	
$query2e="insert ignore into money_quotes_scores
          set calmonth='$calmonth',calyear='$calyear',tempid='$tempid',round='$round',favorite_qid='$favorite'
		   ";
	

//echo "<br />query2e=$query2e<br />";	
$result2e = mysqli_query($connection, $query2e) or die ("Couldn't execute query 2e.  $query2e");


$query2f="insert ignore into money_quotes_ncaa_summary(`calyear`, `calmonth`, `tempid`)
select `calyear`, `calmonth`, `tempid`
from money_quotes_scores
where calyear='2018' and calmonth='march'  ";
	

//echo "<br />query2f=$query2f<br />";	
$result2f = mysqli_query($connection, $query2f) or die ("Couldn't execute query 2f.  $query2f");








$query3="select favorite_qid,count(favorite_qid) as 'score' from money_quotes_scores
          where favorite_qid='$favorite' and calmonth='$calmonth' and calyear='$calyear' and round='$round'
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
          where tempid='$tempid' and calmonth='$calmonth' and calyear='$calyear' and round='$round'
		   ";
if($beacnum == '60032793')
{			   
//echo "<br />query4a=$query4a<br />";	
}
$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");

$row4a=mysqli_fetch_array($result4a);
extract($row4a);

//echo "<br />favorite_qid2=$favorite_qid2<br />";

$query4b="select count(favorite_qid) as 'total_votes' from money_quotes_scores
          where 1 and calmonth='$calmonth' and calyear='$calyear' and round='$round'
		   ";
		   
//echo "<br />query4b=$query4b<br />";	
$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");

$row4b=mysqli_fetch_array($result4b);
extract($row4b);

//echo "<br />total_votes=$total_votes<br />";




$query5="SELECT mq_month_name,mq_day,quote_comment,author,author_last_name,score as 'quote_score',round_score,id  from money_quotes
         where mq_month='$month_number' and mq_calyear='$calyear' and round='$round'	
         order by mq_date,quote_comment		 ";


//echo "<br />Query5=$query5<br /><br />";;
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
//echo "num5=$num5";
//////mysql_close();

/*
$query="SELECT synonym as 'word' from mission_synonyms where 1 and term='yes' and id >= '10' and id <= '19' ";


$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");

while ($row=mysqli_fetch_assoc($result))
{
    $column[] = $row['word'];
//Edited - added semicolon at the End of line.1st and 4th(prev) line

}

*/

//echo "<pre>"; print_r($column); echo "</pre>";  exit;

//$affirmative=$column[array_rand($column)]; 
//echo "affirmative=$affirmative";
//exit;














//if($num5==0){echo "<table align='center'><tr><td>NO Cardholders Missing</td></tr></table>"; exit;}
echo "<table align='center' border='1'>";
 
echo 

"<tr>";        
 //echo "<th>xtnd_report_date</th>";
 
 {
 echo "<th></th>";
 }
 //echo "<th>Author</th>";
 echo "<th>MyFavorite</th>";
 /*
 if($menu==3)
 {
if($round==1)
{
 echo "<th>Sweet16 Score</th>";
}
if($round==2)
{
 echo "<th>Final4 Score</th>";
}


 }
 */
 echo "<th>% of Vote</th>";
 //echo "<th>Division</th>";
 
 echo "</tr>";

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
while ($row5=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row5);
//echo $status;
//if($cardholder2==$cardholder){$cardholder2="\"";}else {$cardholder2=$cardholder;}
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($status=='complete'){$t=" bgcolor='yellow'";}else{$t=" bgcolor='#B4CDCD'";}
//if($status=='complete'){$fcolor1='red';}else{$fcolor1='black';}	
//if($status=='complete'){$bgc='yellow'";}else{$bgc='#B4CDCD';}
//$affirmative=$column[array_rand($column)]; 



/*
if($i==''){$i=0;}
$affirmative=$column[$i]; 
if($affirmative==''){$i=0; $affirmative=$column[$i];}
*/


//echo "affirmative=$affirmative";
//exit;
$table_bg2="cornsilk";

//if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}
//echo $status;
$last_name=strlen($author_last_name);
//echo "<tr$t>";
//if($beacnum != '60032793')
{	
if($id==$favorite_qid2)	
{
$vote_yes="<svg width='200' height='100'>
  <ellipse cx='100' cy='50' rx='80' ry='40'
  style='fill:lightgreen;stroke:purple;stroke-width:2' />
  <text x='60' y='55' fill='black' font-size='20'>$author_last_name</text>
</svg>";
}

if($id!=$favorite_qid2)	
{
$vote_yes="<svg width='200' height='100'>
  <ellipse cx='100' cy='50' rx='80' ry='40'
  style='fill:crimson;stroke:purple;stroke-width:2' />
  <text x='60' y='55' fill='black' font-size='20'>$author_last_name</text>
</svg>";
}

}

/*
if($beacnum == '60032793')
{	
if($id==$favorite_qid2)	
{
$vote_yes="<svg width='100' height='50'>
  <ellipse cx='50' cy='25' rx='40' ry='20'
  style='fill:lightgreen;stroke:purple;stroke-width:2' />
  <text x='30' y='30' fill='black' font-size='10'>$quote_comment</text>
</svg>";
}

if($id!=$favorite_qid2)	
{
$vote_yes="<svg width='100' height='50'>
  <ellipse cx='50' cy='25' rx='40' ry='20'
  style='fill:crimson;stroke:purple;stroke-width:2' />
  <text x='30' y='30' fill='black' font-size='10'>$quote_comment</text>
</svg>";
}

}

*/




















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
echo "<td><i><b>$quote_comment</b></i></td>";
}
//echo "<td><b>$author</b></td>";
//if($score=='')
//{
//if($id==$favorite_qid2)	
echo "<td><a href='money_quotes_scores.php?score=y&favorite=$id&calmonth=$calmonth&calyear=$calyear&month_number=$month_number&round=$round&menu=$menu'>$vote_yes</a></td>"; 

/*
if($menu==3)
{
//echo "<td>$round_score</td>";
echo "<td></td>";
}
*/



//} 
/*
if($score=='y')
{
echo "<td> 
<svg width='$quote_score2' height='50' xmlns='http://www.w3.org/2000/svg' version='1.1'>
<rect x='0' y='0' width='$quote_score2' height='50' fill='lightgreen'/>
 <text x='$text_x' y='25' fill='black' font-size='20'>$quote_score</text></svg></td>";
}
*/
//if($beacnum != '60032793')
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

/*
if($beacnum == '60032793')
{
if($quote_score!=0 and $favorite_qid2 != '')
{
echo "<td> 
<svg width='125' height='25' xmlns='http://www.w3.org/2000/svg' version='1.1'>
<rect x='0' y='0' width='$quote_score2' height='100' fill='lightgreen'/>
 <text x='$text_x' y='25' fill='black' font-size='20'>$quote_percent</text></svg></td>";
}
else
{
echo "<td></td>";


}	

}

*/
























/*	
if($division2=='DPR_MANUAL')
{
echo "<td><a href='stepL3e2c1a.php?cardholder3=$cardholder&card_number3=$card_number2'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></a></td>"; 
}  
*/
/*
if($division2=='OTHER')
{
echo "<td><a href='stepL3e2c1a.php?cardholder3=$cardholder&card_number3=$card_number2'><img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of green check mark'></img></a></td>"; 
}  
*/

	
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

/*
if($dpr_update=='y')
{



$query22="update pcard_unreconciled_xtnd_temp2
          set division=division2
          where division=''		  ";
		  
		  
//echo "<br />Query22: $query22<br />"; exit;			  
			 
mysqli_query($connection, $query22) or die ("Couldn't execute query 22.  $query22");


$query22a="update pcard_unreconciled_xtnd_temp2
          set dpr='y'
          where division='DPR_MANUAL'		  ";
		  
		  
//echo "<br />Query22: $query22<br />"; exit;			  
			 
mysqli_query($connection, $query22a) or die ("Couldn't execute query 22a.  $query22a");





	
$query23a="update budget.project_substeps_detail set status='complete' where project_category='FMS'
         and project_name='pcard_updates' and step_group='L' and step_num='3e' and substep_num='2c1a' ";
			 
mysqli_query($connection, $query23a) or die ("Couldn't execute query 23a.  $query23a");


{header("location: stepL3e.php?project_category=fms&project_name=pcard_updates&step_group=L&step_num=3e ");}



}
*/


?>


























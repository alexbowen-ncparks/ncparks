<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}



$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
extract($_REQUEST);
echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters


//include("../../../budget/menu1314.php");

//$start_date2=str_replace("-","",$start_date);
//$end_date2=str_replace("-","",$end_date);

	
include("../../budget/menu1314.php");	
//echo "<br />cardholder3=$cardholder3";
//echo "<br />card_number3=$card_number3";
echo "<html>";
echo "<head>";
echo "<script type=\"text/javascript\" src=\"https://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.js\"></script>";

echo "<style>";

echo "table { background-color: white; font-color: blue; font-size: 15;}";
//echo ".normal {background-color:#B4CDCD;}";
echo ".normal {background-color:peachpuff;}";
echo ".normal2 {background-color:yellow;}";
echo ".highlight {background-color:#ff0000;}"; 
echo "tr:hover {background: yellow}";
echo "</style>
<script type=\"text/javascript\"> function onRow(rowID)
{var row=document.getElementById(rowID);
var curr=row.className;
if(curr.indexOf(\"normal\")>=0)row.className=\"highlight\";else row.className=\"normal\";
 } 
</script>";


echo "</head>";




//echo "<body bgcolor=>";
//include("../../../budget/menu1314.php");
//echo "<H3 ALIGN=CENTER > <A href=welcome.php> Return HOME </A></H3>";
echo "<br /><br />";
echo "<table align='center' cellspacing='8'><tr><th><i>April 2017 Quote of the Day (VOTE)</i></th></tr></table>";
//echo "<H1 ALIGN=LEFT > <font color=brown><i>XTND Report Date: $xtnd_report_date</font></i></H1>";
//echo "<H2 ALIGN=center><font size=4><b><A href=/budget/menu.php?forum=blank> Return HOME </A></font></H2>";

echo "<br />";





if($score=='y')
{
$query2e="insert into money_quotes_scores
          set calmonth='april',calyear='2017',tempid='$tempid',favorite_qid='$favorite'
		   ";
		   
echo "<br />query2e=$query2e<br />";		   
}




$query5="SELECT mq_month_name,mq_day,quote_comment,author,author_last_name,id  from money_quotes
         where mq_month='04' and mq_calyear='2017'	
         order by mq_date asc		 ";


echo "<br />Query5=$query5<br /><br />";;
// The variable $result is a PHP resource containing the results of the MySQL query. Its contents can only be used by PHP.
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);
//echo "num5=$num5";
//////mysql_close();


$query="SELECT synonym as 'word' from mission_synonyms where 1 and term='yes' and id >= '10' and id <= '19' ";


$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");

while ($row=mysqli_fetch_assoc($result))
{
    $column[] = $row['word'];
//Edited - added semicolon at the End of line.1st and 4th(prev) line

}

//echo "<pre>"; print_r($column); echo "</pre>";  exit;

//$affirmative=$column[array_rand($column)]; 
//echo "affirmative=$affirmative";
//exit;














//if($num5==0){echo "<table align='center'><tr><td>NO Cardholders Missing</td></tr></table>"; exit;}
echo "<table align='center' border='1'>";
 
echo 

"<tr>";        
 //echo "<th>xtnd_report_date</th>";
 echo "<th>Quote</th>";
 echo "<th>Author</th>";
 echo "<th>MyFavorite</th>";
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
$vote_yes="<svg width='400' height='100'>
  <ellipse cx='200' cy='50' rx='100' ry='40'
  style='fill:crimson;stroke:purple;stroke-width:2' />
  <text x='160' y='55' fill='black' font-size='20'>$author_last_name</text>
</svg>";



$id2=$id*10;
$text_x=$id2*.40;

echo "<tr class=\"normal\" id=\"row$id\" onclick=\"onRow(this.id)\">";
echo "<td><i><b>$quote_comment</b></i></td>
<td><b>$author</b></td>
";
if($score=='')
{
echo "<td><a href='money_quotes_scores.php?score=y&favorite=$id'>$vote_yes</a></td>"; 
} 
/*
echo "<td> 
<svg width='$id2' height='50' xmlns='http://www.w3.org/2000/svg' version='1.1'>
<rect x='0' y='0' width='$id2' height='50' fill='lightgreen'/>
 <text x='$text_x' y='25' fill='black' font-size='20'>$id</text></svg></td>";
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
echo "<table align='center'>";
echo "<tr><th><font color='red'>WARNING! ONLY Click Submit when \"DPR Employee Status\" of each Cardholder has been MARKED with Checkmark or Xmark</font></th></tr>";
echo "</table>";
echo "<br /><br />";
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


























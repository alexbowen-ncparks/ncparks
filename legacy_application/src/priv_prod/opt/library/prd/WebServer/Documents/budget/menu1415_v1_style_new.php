<?php

//$database="budget";
//$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
//mysqli_select_db($connection,$database); // database
//include("../../include/activity.php");
//include("../../../include/activity_new.php");// database connection parameters



//$tempid='Bass3278';


$query1="SELECT body_bgcolor as 'bgcolor' from budget.infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "Line 20:query1=$query1<br /><br />";	


 

$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1.  $query1");
$num=mysqli_num_rows($result1);
$row1=mysqli_fetch_array($result1);

extract($row1);
//echo "bgcolor=$bgcolor<br /><br />n=$num<br ><br />"; //exit;


if(!empty($row1))
	{
	extract($row1);
	}
if(empty($bgcolor)){$bgcolor='darkseagreen';}
if(empty($table_bg)){$table_bg='bisque';}

$rand = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
//$bgcolor = "#".$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)].$rand[rand(0,15)];


//$rand2 = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "a", "b", "c", "d", "e", "f");
//$table_bg = "#".$rand2[rand(0,15)].$rand2[rand(0,15)].$rand2[rand(0,15)].$rand2[rand(0,15)].$rand2[rand(0,15)].$rand2[rand(0,15)];

//echo "bgcolor=$bgcolor";
//$bgcolor="coral";




echo "<style type='text/css'>";

//echo "body { background-color: $body_bg; }";
echo "body { background-color: $bgcolor; }";

//echo "table { background-color: $table_bg; font-color: blue; font-size: 10;}";
echo "table { background-color: $table_bg; font-color: blue; font-size: 10;}";

echo "th {

   

   color: brown;   
   text-align:center;
}


td {

   font-family: Verdana;

   color: #5C4033;

   font-size: 10pt;
   padding: 8px;
   text-align:center;
  
}

   .cartRow{

      background-color: yellow;

   } 

   

   .cartRow2{

      background-color: cornsilk;

   } 
  

TH{font-family: Arial; font-size: 15pt;}

TD{font-family: Arial; font-size: 15pt;}

input[type=text] {
    font-size:20px
}


a:link {
    text-decoration: none;
}

a:visited {
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

a:active {
    text-decoration: underline;


</style>";

?>
<?php

$query1="SELECT body_bgcolor as 'bgcolor' from infotrack_customformat
         where user_id='$tempID' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
if(!empty($row1))
	{
	extract($row1);
	}
if(empty($bgcolor)){$bgcolor='darkseagreen';}
if(empty($table_bg)){$table_bg='lightcyan';}
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
   text-align:left;
  
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
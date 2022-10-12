<?php

$query="SELECT body_bgcolor as 'bgcolor' from budget.infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query=$query<br />";		 

$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");
$row=mysqli_fetch_array($result);
if(!empty($row))
	{
	extract($row);
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
<?php

$query1="SELECT body_bgcolor as 'bgcolor' from infotrack_customformat
         where user_id='$tempid' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
if(!empty($row1))
	{
	extract($row1);
	}
if(empty($bgcolor)){$bgcolor='darkseagreen';}
//echo "bgcolor=$bgcolor<br />";
?>

   


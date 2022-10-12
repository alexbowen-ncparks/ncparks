<?php
//echo "hello world";//exit;
echo "<br />";
//echo "<table>";
//echo "<tr>";
//echo "<th><font color='brown'>Comment</font></th>";
//echo "</tr>";

echo "<td>";

echo "<script language='javascript' type='text/javascript'>
      window.onload = function() {
      document.getElementById('input3').focus();
}

function validateForm()
{
var x=document.forms['form3']['input3'].value;
if (x==null || x=='')
  {
  alert('Bright Idea missing');
  return false;
  }
}

</script>


";

echo "<form method='post' action='comment_add_procedures.php' name='form3' onsubmit='return validateForm()'  >";
echo "<td><textarea name= 'comment_note' rows='3' cols='100' placeholder='Bright Idea' id='input3' ></textarea><br />";         
      
	  
//echo "<td><input type=submit name=submit value=Add_Comment></td>";
echo "<input type=submit name=submit value=Share></td>";
	  echo "<input type='hidden' name='pid' value='$pid'>";	   
	 echo "</form>";
echo "</tr>";
      
	 
echo "</table>";


$query4b="select * from procedures_comments where 1 and pid='6' $order2 ";

//echo "$query4b";		 
$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");
$num4b=mysqli_num_rows($result4b);
echo "query4b=$query4b";//exit;

echo "<table>";
/*
echo "<tr>";
//echo "<td><font color='brown'>Location</font></td>";
echo "<td align='center'><font color='brown'>Player</font></td>";
//echo "<td align='center'><font color='brown'>Date</font></td>";
echo "<td align='center'><font color='brown'>Comment</font></td>";
echo "<td><font color='brown'>Status</font></td>";
echo "<td><font color='brown'>ID</font></td>";

echo "</tr>";
*/
echo  "<form method='post' autocomplete='off' action='comment_update_procedures.php'>";
while ($row4b=mysqli_fetch_array($result4b)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4b);
$countid=number_format($countid,0);
$rank=$rank+1;

if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
$user2=substr($user,0,-2);
//echo "tempID=$tempID <br />";
//echo "user=$user <br />";
//echo "user2=$user2 <br />";
//if($status=='fi'){$color='light green';}else{$color='light pink';}
if($status=="fi"){$bgc="lightgreen";} else {$bgc="lightpink";}

echo "<tr bgcolor='$bgc'>"; 
//echo "<tr$t>"; 
//echo "<td>$rank</td>";
 //echo "<td><font color='brown'>$park</font></td>";
 //echo "<td><font color='brown'>$user2</font></td>";
 //echo "<td>$system_entry_date</font></td>"; 
 if($tempID==$user)
 {
 echo "<td>$user2<br /><textarea name='comment_note[]' cols='120' rows='3'>$comment_note</textarea></td> ";
 }
 else
 {
 echo "<td><textarea name='comment_note[]' cols='120' rows='3' readonly='readonly'>$comment_note</textarea></td> ";
 }
  
 
//echo "<td>$comment_note</td>"; 
if($tempID==$user)
{
echo "<td><font color=$color><input type='text' size='1' name='status[]' value='$status'></font></td>";
}
else
{
echo "<td><font color=$color><input type='text' size='1' name='status[]' value='$status' readonly='readonly'></font></td>";
}


echo "<td><input type='text' size='1' name='cid[]' value='$cid' readonly='readonly'</td>";
echo "<td>$color</td>";


//echo "<td>$status</td>"; 

	          
echo "</tr>";

}
echo "<tr><th align='left'><input type='submit' name='submit2' value='Update'></th></tr>";
echo "<input type='hidden' name='pid' value='$pid'>";
echo "<input type='hidden' name='num4b' value='$num4b'>";
echo   "</form>";
 echo "</table>";













 ?>
 
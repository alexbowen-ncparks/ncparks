<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

extract($_REQUEST);

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../budget/~f_year.php");
//echo "f_year=$f_year<br />";

$query5="SELECT parkcode,other,id
FROM report_budget_history_inc_stmt_by_fyear_net
WHERE f_year = '1314'
and scope='park'
order by id";

//echo "query5=$query5";
$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

echo "<html>";
?>
<head>
<script>
function showUser(str, pass_id)
	{
	  if (str=="") {
	  var divs = document.getElementsByTagName('div');
	  for (var i = 0; i < divs.length; i++)
		  {
	
			document.getElementById("txtHint_"+i).innerHTML="";
			return;
		}

	  } 
	  if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	  } else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() 
		  {
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			
			  document.getElementById("txtHint_"+pass_id).innerHTML=xmlhttp.responseText;
			}
		  }
	  xmlhttp.open("GET","getuser.php?q="+str,true);
	  xmlhttp.send();
	}
</script>
</head>

<?php
echo "<table border=1 align='left'>";

echo "<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>parkcode</font></th> ";
  echo "<th align=left><font color=brown>other</font></th> ";
  echo "<th align=left><font color=brown>id</font></th> ";
      
 $i=0;   
echo "</tr>";


while ($row=mysqli_fetch_array($result5))
{
$i++;
extract($row);

echo "<tr>";
echo "<td>$parkcode</td><td>$other</td>";	
		   
echo "<td>$id $i
	  <form>
      <select name='users' onchange='showUser(this.value, $i)'>
      <option value=''>Select a person:</option>
      <option value='1'>Tammy</option>
      <option value='2'>Tom</option>
      <option value='3'>Tony</option>
      </select>
      </form>
	  <br>
      <div id='txtHint_$i'><b>Person info will be listed here.</b></div> 		   
      </td>";			   
                       
           
echo "</tr>";

}

 echo "</table>";
  
 
 echo "</body></html>";

?>








<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
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

include ("../../budget/menu1415_v1.php");
$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";
//echo "query10=$query10<br />";
$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

$query5="select rank,center_name,visitation,expenditures,receipts,receipt_percent,campsites_total,campsites_full_hookup,campsites_other_driveup,campsites_primitive,campsites_group,campsites_occupancy,cabins,cabins_occupancy,camping_cabin_revenues,concession_revenues,other_revenues,parkcode,center,fyear
from mike_ss2
where 1
order by rank;";

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
if($version==2){$version2_check="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}






echo "<br /><table border='1' align='center'><tr><th>Mike Spreadsheet</th><th><a href='mike_ss2.php?version=2'>Version2<br >Jan 21, 2015 (1:48PM)</a>$version2_check</th></table>";
echo "<br /><br />";

if($version==2)

{

echo "<table border=1 align='left'>";

echo "<tr>"; 
       //echo "<th align=left><font color=brown>Category</font></th>";
  echo "<th align=left><font color=brown>rank</font></th> ";
  echo "<th align=left><font color=brown>center name<br />   [Version2 changes <img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>]</font></th> ";
  echo "<th align=left><font color=brown>visitation</font></th> ";
  echo "<th align=left><font color=brown>expenditures</font></th> ";
  echo "<th align=left><font color=brown>receipts</font></th> ";
  echo "<th align=left><font color=brown>receipt percent</font></th> ";
  echo "<th align=left><font color=brown>campsites total</font></th> ";
  echo "<th align=left><font color=brown>campsites full hookup</font></th> ";
  echo "<th align=left><font color=brown>campsites other driveup</font></th> ";
  echo "<th align=left><font color=brown>campsites primitive</font></th> ";
  echo "<th align=left><font color=brown>campsites group</font></th> ";
  echo "<th align=left><font color=brown>campsites occupancy</font></th> ";
  echo "<th align=left><font color=brown>cabins</font></th> ";
  echo "<th align=left><font color=brown>cabins occupancy</font></th> ";
  echo "<th align=left><font color=brown>camping<br />&<br /> cabin revenues</font></th> ";
  echo "<th align=left><font color=brown>concession revenues</font></th> ";
  echo "<th align=left><font color=brown>other revenues</font></th> ";
  
      
 $i=0;   
echo "</tr>";


while ($row=mysqli_fetch_array($result5))
{
$i++;
extract($row);

$visitation=number_format($visitation,0);
$expenditures=number_format($expenditures,0);
$receipts=number_format($receipts,0);
$camping_cabin_revenues=number_format($camping_cabin_revenues,0);
$concession_revenues=number_format($concession_revenues,0);
$other_revenues=number_format($other_revenues,0);




if($parkcode=='hari' or $parkcode=='sila' or $parkcode=='lawa' or $parkcode=='grmo' or $parkcode=='elkn')
{$version2_change="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
else
{$version2_change="";}






if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}


echo "<tr$t>";
echo "<td>$rank</td>";
echo "<td>$center_name $version2_change</td>";
echo "<td>$visitation</td>";
echo "<td>$expenditures</td>";
echo "<td>$receipts</td>";
echo "<td>$receipt_percent</td>";
echo "<td>$campsites_total</td>";
echo "<td>$campsites_full_hookup</td>";
echo "<td>$campsites_other_driveup</td>";
echo "<td>$campsites_primitive</td>";
echo "<td>$campsites_group</td>";
echo "<td>$campsites_occupancy</td>";
echo "<td>$cabins</td>";
echo "<td>$cabins_occupancy</td>";
echo "<td>$camping_cabin_revenues</td>";
echo "<td>$concession_revenues</td>";
echo "<td>$other_revenues</td>";







/*		   
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
 */                      
           
echo "</tr>";

}

 echo "</table>";
}  
 
 echo "</body></html>";

?>








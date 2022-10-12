<?php

$database="ware";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
   or die ("Couldn't select database $database");
	
ini_set('display_errors',1);

echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
// RESET
if(@$_POST['reset']=="Reset"){unset($_POST);}	

	$title="Warehouse Inventory";
	include("../_base_top.php");
echo "<script>
$(\"form[action$='Search']\").submit(function (event) {
    event.preventDefault();
    $.post( $(this).attr(\"action\") , $(this).serialize() );
    return false;
});

function showUser(str, pass_id)
		{
	
		  if (str==\"\") {
		  var divs = document.getElementsByTagName('input');
		  for (var i = 0; i < divs.length; i++)
			  {
	
				document.getElementById(\"center_desc\"+i).innerHTML=\"\";
				return;
			}

		  } 
		  if (window.XMLHttpRequest) {
	  
//		alert(\"I am an alert box \" + str);
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		  } else { // code for IE6, IE5
			xmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");
		  }
		  xmlhttp.onreadystatechange=function() 
			  {
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
				var s=xmlhttp.responseText;
				var temp1 = s.split(\"__\");
//	alert(\"I am an alert box \" + temp1[1]);
//				var temp2 = temp1[1].split(\"~\");
				var hidden = \"<input type='text' name='park_code' value=''>\";
				  document.getElementById(\"center_desc\"+pass_id).innerHTML = temp1[0];
//				  document.getElementsByName(\"park_code\").innerHTML = temp2[1];
				  
				}
			  }
		
		  xmlhttp.open(\"GET\",\"get_rcc.php?q=\"+str,true);
		  xmlhttp.send();
	
		return !(window.event && window.event.keyCode == 13);  
		}
	</script>";

	echo "<title>NC DPR Warehouse Inventory</title><body>";
	
echo "<form method='POST'><table border='1' cellpadding='3'>";
echo "<tr><td colspan='2'>Place Order for RCC or Park: 
<input type='text' name='search' onchange='showUser(this.value, 1)'></td>

<td colspan='6'><div id='center_desc1'></div></td>";

	
		echo "<td><input type='submit' name='submit' value='Search'>
		<input type='submit' name='reset' value='Reset'></td>
		";
		
		echo "</tr>";	

echo "</table></form></body></html>";
?>
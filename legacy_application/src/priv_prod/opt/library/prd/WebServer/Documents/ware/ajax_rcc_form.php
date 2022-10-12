<?php
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//if(strpos($_SERVER['HTTP_USER_AGENT'], "Firefox")){$ajax_yes=1;}else{$ajax_yes="";}
ini_set('display_errors',1);

//$ajax_yes=1;
$ajax_yes="";
echo "<table cellpadding='5'><tr>";
if(!empty($ajax_yes))
	{
	if($level<2)
		{
		$temp_rcc=$_SESSION['ware']['select'];
		if(!empty($_SESSION['ware']['accessPark']))
			{
			$park_array=explode(",",$_SESSION['ware']['accessPark']);
			}
			else
			{$park_array=array($temp_rcc);}
		echo "<td>Enter select a Park Code: ";
		}
		else
		{echo "<td>Enter either a RCC or a Park Code: ";}
	
	if(!empty($temp_rcc))
		{
		$value=$temp_rcc;
		echo "<select name='search' onchange=\"showUser(this.value,1)\">
		<option value=\"\" selected></option>\n";
		foreach($park_array as $k=>$v)
			{
			echo "<option value=\"$v\">$v</option>\n";
			}
		echo "</select>";
		
		}
	else
		{
		echo "<input type='text' name='search' value=\"\" size='8' onchange=\"showUser(this.value,1)\">";
		}

	echo " for Order.</td>";
	if($var_brow=="win" and empty($temp_rcc))
		{echo "<td><button>Select Park</button></td>";}
	echo "</tr><tr><td> </td></tr>
	<tr><td align='center'>
	<form><div id='center_desc1'></div></form></td></tr>";
	}
	else
	{ // used if ajax does not work
	echo "<form method='POST'><td>Enter either a RCC or a Park Code: <input type='text' name='search' value=\"\">";
	echo "</td><td align='center'><input type='submit' name='place_order' value=\"Select Unit for Order\"></td></form></tr>";
	if(!empty($_POST['place_order']))
		{
		extract($_POST);
		$sql="SELECT parkCode, rcc, center_desc
		FROM budget.`center`
		WHERE fund = '1280' AND actCenterYN = 'y' and (parkCode='$search' OR rcc='$search')";
		// added by Tom for testing
		$sql="SELECT parkCode, rcc, center_desc FROM budget.`center` WHERE (fund = '1280' OR fund='1680') AND actCenterYN = 'y' and (parkCode='$search' OR rcc='$search') ";
		
// 		echo "$sql"; //exit;
		$result = mysqli_query($connection, $sql) or die ("Couldn't execute select query. $sql ".mysql_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{
			$park_code=$row['parkCode'];
			$center_desc=$row['center_desc'];
			$rcc=$row['rcc'];
			}
if(empty($park_code))
	{
	echo "No code is associated with $search."; exit;
	}
		echo "<form method='GET' action='base_inventory.php'><tr><td>Park Code:<input type='text' name='park_code' value=\"$park_code\" size='8' readonly>
		RCC:<input type='text' name='rcc' value=\"$rcc\" size='8' readonly>&nbsp;&nbsp;&nbsp;$center_desc</td></tr>";
	echo "<tr><td align='center'><input type='submit' name='submit' value=\"Submit\"></td></tr>
	</form>";
		}
	}

echo "</table>";

echo "<script>
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
	  
//	alert(\"I am an alert box \" + str);
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
//	alert(\"I am an alert box \" + s);
				  document.getElementById(\"center_desc\"+pass_id).innerHTML = s;
				}
			}
		
		  xmlhttp.open(\"GET\",\"get_rcc.php?q=\"+str,true);
		  xmlhttp.send();
		}
	</script>";

?>
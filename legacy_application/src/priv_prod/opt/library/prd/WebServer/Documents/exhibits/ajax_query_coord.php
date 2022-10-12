<script language="javascript" type="text/javascript">
<!-- 
//Browser Support Code
function ajaxFunction(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		if(ajaxRequest.readyState == 4){
		var ajaxDisplay = document.getElementById("ajaxDiv");
			ajaxDisplay.innerHTML = ajaxRequest.responseText;	
		}
	}
	var park_code = document.getElementById("park_code").value;
	var queryString = "?park_code=" + park_code;
	ajaxRequest.open("GET", "ajax_query.php" + queryString, true);
	ajaxRequest.send(null); 
}

//-->
</script>

<?php
$database="dpr_system";
$db="dpr_system";
$table="dprunit";
include("../../include/iConnect.inc");


//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
mysqli_select_db($connection,$database) or die( "Unable to select database ".mysqli_error($connection));
	// Retrieve data from Query String
$pc = $_GET['park_code'];
$pi = $_GET['pass_id'];
	
// Check for existing coords


	//Query
$query = "SELECT latoff as lat, lonoff as lon FROM dprunit WHERE parkcode = '$pc'";
$qry_result = mysqli_query($connection,$query) or die(mysqli_error($connection));
$row = mysqli_fetch_array($qry_result);
extract($row);


	//Query  This should override the default coords with any previously entered.
$query = "SELECT lat, lon FROM exhibits.work_order WHERE work_order_id = '$pi'";
$qry_result = mysqli_query($connection,$query) or die(mysqli_error($connection));
if(mysqli_num_rows($qry_result))
	{
	$qry_row=mysqli_fetch_assoc($qry_result);
	extract($qry_row);
	}
/*
	//Build Result String
$display_string = "<table>";
$display_string .= "<tr>";
$display_string .= "<th>Park</th>";
$display_string .= "<th>Lat</th>";
$display_string .= "<th>Lon</th>";
$display_string .= "</tr>";

	// Insert a new row in the table for each person returned
while($row = mysqli_fetch_array($qry_result)){
	$display_string .= "<tr>";
	$display_string .= "<td>$pc</td>";
	$display_string .= "<td><input type='text' name='lat' value='$row[lat]'></td>";
	$display_string .= "<td><input type='text' name='lon' value='$row[lon]'></td>";
	$display_string .= "</tr>";
	
}
//echo "Query: " . $query . "<br />";
$display_string .= "</table>";
if(!empty($pc))
	{echo $display_string;}
*/

echo "<td>Location <input type='button' style=\"background-color:lightgreen\" value='Map It!' onclick=\"return popitLatLon('lat_long.php?&park_code=$pc&lat=$lat&lon=$lon')\"><br />Latitude: &nbsp;&nbsp<input type='text' name='lat' value='$lat'><br />Longitude: <input type='text' name='lon' value='$lon'></td>";
?>
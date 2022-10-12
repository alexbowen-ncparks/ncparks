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
	ajaxRequest.open("GET", "ajax_query_coord.php" + queryString, true);
	ajaxRequest.send(null); 
}

//-->
</script>

<?php
$database="dpr_system";
$db="dpr_system";
$table="dprunit";
include("../../include/iConnect.inc");

echo "
Park: <select id=\"park_code\" name='park_code' onchange=\"ajaxFunction()\">
 <option value='' selected ></option>
<option value='CABE'>CABE</option>
<option value='WIUM'>WIUM</opton>
</select>
<div id=\"ajaxDiv\">Your result will display here</div>";


?>
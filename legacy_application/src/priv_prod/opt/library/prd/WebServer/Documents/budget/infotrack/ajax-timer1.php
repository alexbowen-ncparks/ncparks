<?php
echo "<form name='myForm'>
<input type='button' onclick='ajaxFunction1()' value='StartTimer' />
</form>
<div id='ajaxDiv'></div>";
/*
echo "<form name='myForm'>
<input type='button' onclick='ajaxFunction2()' value='EndTimer' />
</form>
<div id='ajaxDiv2'></div>";
*/






//$cid='312';
?>
<script language="javascript" type="text/javascript">
<!-- 
//Browser Support Code
function ajaxFunction1(){
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
	//var age = document.getElementById("age").value;
	//var wpm = document.getElementById("wpm").value;
	//var sex = document.getElementById("sex").value;
	var queryString = "?cid=" + <?php echo "$cid"?>;
	ajaxRequest.open("GET", "ajax-timer1_update.php" + queryString, true);
	//ajaxRequest.open("GET", "ajax-timer1_update.php", true);
	ajaxRequest.send(null); 
}



//-->
</script>






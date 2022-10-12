<?php
echo "<td><form name='myForm'>
<textarea id='message' cols='30' rows='6'>$message</textarea>
<input type='button' onclick='ajaxFunction()' value='Record Game Notes' />
</form>
<div id='ajaxDiv'></div></td>";


echo "<td><form name='myForm2'>
<input type='button' onclick='ajaxFunction2()' value='Query MySQL' />
</form>
<div id='ajaxDiv2'></div></td>";


//$cid='312';
?>

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
	//var age = document.getElementById("age").value;
	//var wpm = document.getElementById("wpm").value;
	var message = document.getElementById("message").value;
	var queryString = "?message=" + message + "&cid=" + <?php echo "$cid";?>;
	ajaxRequest.open("GET", "ajax-timer1_record_update.php" + queryString, true);
	ajaxRequest.send(null); 
}

function ajaxFunction2(){
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
		var ajaxDisplay = document.getElementById("ajaxDiv2");
			ajaxDisplay.innerHTML = ajaxRequest.responseText;	
		}
	}
	//var age = document.getElementById("age").value;
	//var wpm = document.getElementById("wpm").value;
	//var sex = document.getElementById("sex").value;
	var queryString = "?cid=" + <?php echo "$cid";?>;
	ajaxRequest.open("GET", "ajax-timer1_record_view.php" + queryString, true);
	ajaxRequest.send(null); 
}


//-->
</script>





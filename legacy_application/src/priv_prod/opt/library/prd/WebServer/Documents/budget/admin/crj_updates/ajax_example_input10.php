<html><br />
<head>
<script  type="text/javascript" src="http://ajax.googleapis.com/ajax/
libs/jquery/1.3.0/jquery.min.js"></script>
</head>
<body>
<script language="javascript" type="text/javascript">
//document.getElementById("myForm2").reset();
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
		
		var ajaxDisplay = document.getElementById("ajaxDiv");
			ajaxDisplay.innerHTML = ajaxRequest.responseText;	
		
	}
	var age = document.getElementById("age").value;
	var wpm = document.getElementById("wpm").value;
	var sex = document.getElementById("sex").value;
	var queryString = "?age=" + age + "&wpm=" + wpm;
	ajaxRequest.open("GET", "ajax_example_output7.php" + queryString, true);
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
		
		var ajaxDisplay = document.getElementById("ajaxDiv");
			ajaxDisplay.innerHTML = ajaxRequest.responseText;	
		
	}
	var age2 = document.getElementById("age2").value;
	var wpm2 = document.getElementById("wpm2").value;
	var sex2 = document.getElementById("sex2").value;
	var name2 = document.getElementById("name2").value;
	var queryString = "?age2=" + age2 + "&wpm2=" + wpm2 + "&sex2=" + sex2 + "&name2=" + name2;
	ajaxRequest.open("POST", "ajax_example_input8_add.php" + queryString, true);
	ajaxRequest.send(null); 
	$("#myForm2").reset();
	

		

}


setInterval(ajaxFunction, 5000); // five minutes, in milliseconds
//-->
//document.getElementById("myForm2").reset();

</script>




<!--
<table><tr><td>Automatic Call Jquery Ajax</td></tr></table>
<div id="ajaxDiv">Your result will display here</div>-->



<form id="myForm2">
Name: <input type="text" id="name2" /> <br />
Max Age: <input type="text" id="age2" /> <br />
Max WPM: <input type="text" id="wpm2" />
<br />
Sex: <select id="sex2">
<option>m</option>
<option>f</option>
</select>
<input type="button" onclick="ajaxFunction2()" value="Add Record" />
<input type="button" onclick="submitForm()" value="Clear" />
<script>

</script>
</form>


















<!--
<div id="ajaxDiv">Your result will display here</div>-->



<form name="myForm">
Max Age: <input type="text" id="age" /> <br />
Max WPM: <input type="text" id="wpm" />
<br />
Sex: <select id="sex">
<option>m</option>
<option>f</option>
</select>
<input type="button" onclick="ajaxFunction()" value="Query MySQL" />
</form>
<div id="ajaxDiv">Your result will display here</div>



</body>
</html>
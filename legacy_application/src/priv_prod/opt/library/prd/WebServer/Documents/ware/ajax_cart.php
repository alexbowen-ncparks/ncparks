<?php

// *********** Form ***********
$i=1;
$index=2;
$new_fld="quantity";	
echo "<html><head><script>
function updateQuantity(str, pass_id)
	{
	  if (window.XMLHttpRequest) {
	  
 //	alert(\"I am an alert box \" + str + pass_id);
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	  } else { // code for IE6, IE5
		xmlhttp=new ActiveXObject(\"Microsoft.XMLHTTP\");
	  }

	  xmlhttp.open(\"GET\",\"ajax_cart_sql.php?q=\"+ str + \"&id=\" + pass_id,true);
	  xmlhttp.send();
	  this.form.submit();
	}
</script></head>

<input type='text' id='$new_fld' name='$new_fld' value=\"$value\" size='3' onchange=\"updateQuantity(this.value,$index);\">
</html>";
	
?>
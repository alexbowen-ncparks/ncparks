<html><head>
<script type="text/javascript">

function checkCheckBoxes()
	{
	
	var boxeschecked=0;
	

	for(var i=1; i<4; i++)
		{
			document.getElementById("cat"+String(i)).checked == true ? boxeschecked++: null;
		}
	if(boxeschecked>0)
		{
		
		return true;	
		}
	else
		{
		alert("Please select at least one Category type.");
		return false;
		}
	}
</script>
</head>
<body>
<form name='frmTest' action="test_checkbox.php" method="post" onsubmit="return checkCheckBoxes()">
<input type='checkbox' id='cat1' name='cat[]' value="1">1
<input type='checkbox' id='cat2' name='cat[]' value="2">2
<input type='checkbox' id='cat3' name='cat[]' value="3">3
<input type='submit' name='submit' value="Submit">
</form>
</body></html>
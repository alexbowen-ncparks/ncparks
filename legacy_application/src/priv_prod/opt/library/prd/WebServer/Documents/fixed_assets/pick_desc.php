<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
$database="fixed_assets";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
       or die ("Couldn't select database $database");

extract($_REQUEST);

echo "<html>";

/*
http://www.dpr.ncparks.gov/fixed_assets/pick_desc.php?passForm=assetForm&name=corrected_standard_description314&alpha=AIR&beta=02500%20AIR%20COMPRESSORS%20&%20ACCESSORIES
*/
	echo "<head><script language=\"JavaScript\">
function updateParent()
	{
	opener.document.assetForm.$name.value = document.childForm.cf1.value;
	self.close();
	return false;
	}

	
	function MM_jumpMenu(targ,selObj,restore){ //v3.0
	  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
	  if (restore) selObj.selectedIndex=0;
	}
	</script>
	</head>";

	
if(!empty($alpha)){$alpha=str_replace(",","",$alpha);}
echo "<table><tr><td>
<form method='POST' action='pick_desc.php'>Enter a search term: <input type='text' name='alpha' value='$alpha'>
<input type='hidden' name='name' value='$name'>
<input type='submit' name='submit' value='Find'>
</form>
</td></tr></table>";

if(@$alpha!="" AND @$beta=="")
	{
	$new_alpha=explode("/",$alpha);
	$alpha=$new_alpha[0];
	echo "<table cellpadding='8'><form>";
	$sql = "SELECT *
	FROM `standard_description`
	where `a` like '%$alpha%'";
	//echo "$sql";//exit;
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
	
	while($row=mysqli_fetch_array($result))
		{
		extract($row); 
	
		echo "<tr><td colspan='2'>";
		$aa=urlencode($a);
		echo "<a href='pick_desc.php?passForm=assetForm&name=$name&alpha=$alpha&beta=$aa'>$a</a>";
			   
		   echo "</td></tr>";
		}
	echo "</form></table>";
	}

if(@$beta!="")
	{
	echo "<body><form name=\"childForm\" onSubmit=\"return updateParent();\">";
	$sql = "SELECT *
	FROM `standard_description`
	where `a` = '$beta'";
//	echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
	$row=mysqli_fetch_array($result);
	extract($row);
	echo "<hr><table>
	<tr><td><input name='cf1' type='text' value='$a' size='64' READONLY></td></tr>";
	echo "
	<tr><td>
	<input type='submit' name='submit' value='Update Asset'>
	</form></td></tr></table></body></html>";
	}
?>
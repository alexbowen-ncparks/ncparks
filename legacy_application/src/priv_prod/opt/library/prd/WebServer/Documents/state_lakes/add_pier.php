<?php
date_default_timezone_set('America/New_York');
session_start();
$level=$_SESSION['state_lakes']['level'];
if($level<3){$pass_park=$_SESSION['state_lakes']['select'];}


$database="state_lakes";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       extract($_REQUEST);
       
       
       if($_POST['submit']=="Add Pier")
       		{
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
       		
       		$cy=date('Y');
       		if($_POST['park']==""){echo "You must designate a Park. Click your back button.";exit;}
       		if($_POST['year']==""){echo "You must designate a year. Click your back button.";exit;}
       		if($_POST['year']<$cy){echo "Adding PIERS for $cy has been locked. Contact Tom Howard if you need to add one at this late date.";exit;}
       		
       		if($_POST['contacts_id']==""){echo "You must designate an Owner/Agent. Click you back button.";exit;}
       		$skip=array("submit","form","billing_title","billing_last_name","billing_first_name","billing_add_1","billing_city","billing_state");
       		foreach($_POST AS $field=>$value)
       				{
       					if(in_array($field,$skip)){continue;}      					
				@$clause.=$field."='".$value."',";
				if($field=="year"){$value=$value+1;}
				@$clause2.=$field."='".$value."',";
       				}
       						$id=$_POST['contacts_id'];
       			$clause="set ".rtrim($clause,",");
       			$clause2="set ".rtrim($clause2,",");
			$sql = "INSERT into piers $clause";//echo "$sql <br />$clause"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
			$sql = "INSERT into piers $clause2";//echo "$sql <br />$clause2"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
			$clause=""; $clause2="";
			$edit=$pier_number;
			$message="Update was successful.<br />Close window when done.";
       		}
       
$sql="SHOW COLUMNS FROM  piers";
 $result = @mysqli_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
		{
			$allFields[]=$row['Field'];
		}

echo "<html><head><script language=\"JavaScript\">

// single item
function toggleDisplay(objectID) {
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}
function popitup(url)
{   newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=800,width=800,menubar=1,toolbar=1');
        if (window.focus) {newwindow.focus()}
        return false;
}
</script></head>
";

echo "<body bgcolor='beige'><form method='POST' name='pierForm'><div align='center'><table><tr><td><table cellpadding='5' border='1' bgcolor='lightyellow'>";

$exclude=array("pier_id");
$radio=array("park","pier_type");
$pier_type_array=array("p"=>"private","c"=>"commercial","s"=>"state/federal");
$checkbox=array("boatstall","non_conforming","pier_mod_y_n","transfer_y_n");
$park_array=array("BATR","LAWA","PETT","WHLA");

foreach($allFields as $num=>$fld)
	{
	if(in_array($fld,$exclude)){continue;}
					$RO="";
					if($fld=="contacts_id"){$RO="disabled";}
			
	$fld_name=$fld;
	$value="";
		if($fld=="year")
			{
			$fld_name="<font color='red'>$fld</font>";
			$value=date('Y');
			}
			
					echo " <tr valign='top'><td align='right'>$fld_name</td>";
					
			$fld_array=$fld;
					$item="<input type='text' name='$fld_array' value=\"$value\" size='37'$RO>";
					
				if(in_array($fld,$checkbox))
					{	
					$item="<input type='checkbox' name='$fld' value='x'> ";		
					}
					
				if(in_array($fld,$radio))
					{	
						$var_array=${$fld."_array"};
						// restrict parks
						if($fld=="park"){include("park_arrays.php");}
						
						foreach($var_array as $k=>$v)
							{
								if($fld=="park")
									{
									$val=$v; $ck="";
									if($pass_park==$v)
										{
										$ck="checked";
										}
									}
									else
									{$val=$k;}
								$var_item.="<input type='radio' name='$fld' value='$val' $ck>$v ";
								$ck="";
							}
							$item=$var_item; $var_item="";
					}
					
					
					if($fld=="pier_comment"){
						if($value){$d="block";}else{$d="none";}
						$item="<div id=\"fieldName\">   ... <a onclick=\"toggleDisplay('fieldDetails[$id]');\" href=\"javascript:void('')\"> toggle &#177</a></div>
	
						<div id=\"fieldDetails[$id]\" style=\"display: $d\"><br><textarea name='$fld_array' cols='55' rows='15'>$value</textarea></div>";
					}
					
					if($fld=="contacts_id")
						{
							$item="<input type='text' name='$fld' value=\"$value\" size='4' readonly>
							<input type='button' value='Pick Owner/Agent' onclick=\"return popitup('pick_owner.php?form=pier')\">
							<br />billing_title<br />
							<input type='text' name='billing_title' value=\"$row[billing_title]\" readonly>
							<br />billing_last_name<br />
							<input type='text' name='billing_last_name' value=\"$row[billing_last_name]\" readonly>
							<br />billing_first_name<br />
							<input type='text' name='billing_first_name' value=\"$row[billing_first_name]\" readonly>
							<br />billing_add_1<br />
							<input type='text' name='billing_add_1' value=\"$row[billing_add_1]\" readonly>
							<br />billing_city<br />
							<input type='text' name='billing_city' value=\"$row[billing_city]\" readonly>
							<br />billing_state<br />
							<input type='text' name='billing_state' value=\"$row[billing_state]\" readonly>";
						}
					
				echo "<td>$item</td></tr>";
				if($fld=="transfer_y_n"){echo "</table></td><td><table cellpadding='5' border='1'><tr bgcolor='lightyellow'>";}
							
				}
		
	echo "<td align='center'>
	<input type='submit' name='submit' value='Add Pier'>
	</td>";
	if($message){echo "<td>$message</td>";}
	echo "</tr></table></div></form></body></html>";

?>
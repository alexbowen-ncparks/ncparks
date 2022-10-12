<?php

session_start();
$level=$_SESSION['state_lakes']['level'];
if($level<3){$pass_park=$_SESSION['state_lakes']['select'];}

$database="state_lakes";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       extract($_REQUEST);
       
       
       if($_POST['submit']=="Add Owner/Agent")
       		{
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
       		
       		if(@$_POST['park']=="")
       			{echo "You must designate a park. Click you back button.";exit;}
       		if(@$_POST['entity']=="")
       			{echo "You must designate an entity. Click you back button.";exit;}
       		
       		$skip=array("submit","form");
       		foreach($_POST AS $field=>$value)
       				{
//        					$value=mysqli_real_escape_string($value);
       					if(in_array($field,$skip)){continue;}       					
       					@$clause.=$field."='".$value."',";
       				}
       				
       			$clause="set ".rtrim($clause,",");
			$sql = "INSERT into contacts $clause";
//echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); 
			$clause="";
       				$contacts_id=mysqli_insert_id($connection);
			$edit=$contacts_id;
			$message="Addition was successful.<br />Close window when done.";
       		}
       
$sql="SHOW COLUMNS FROM contacts";
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

$exclude=array("id");

$park_array=array("BATR","LAWA","PETT","WHLA");
$sila_array=array("BATR","WHLA");
$sodi_array=array("BATR","WHLA","LAWA");
$lawa_array=array("LAWA");
$pett_array=array("PETT");

$radio=array("park","entity");
$entity_array=array("p"=>"private","a"=>"agent","c"=>"corporation","s"=>"state/federal");

			foreach($allFields as $num=>$fld){
				if(in_array($fld,$exclude)){continue;}
				$RO="";
		
				echo " <tr valign='top'><td align='right'>$fld</td>";
				
		$fld_array=$fld;
				$item="<input type='text' name='$fld_array' size='37'>";
				
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
							@$var_item.="<input type='radio' name='$fld' value='$val' $ck>$v ";
							$ck="";
						}
						$item=$var_item; $var_item="";
				}
				
				if($fld=="comment")
					{
					if(@$value){$d="block";}else{$d="none";}
					$item="<div id=\"fieldName\">   ... <a onclick=\"toggleDisplay('fieldDetails[$id]');\" href=\"javascript:void('')\"> toggle &#177</a></div>
					
					<div id=\"fieldDetails[$id]\" style=\"display: $d\"><br><textarea name='$fld_array' cols='55' rows='15'>$value</textarea></div>";
					}
				
				
			echo "<td>$item</td></tr>";
			if($fld=="lake_zip"){echo "</table></td><td><table cellpadding='5' border='1'><tr bgcolor='lightyellow'>";}
						
			}
	if(!isset($message)){$message="";}	
	echo "<td align='center'>
	<input type='submit' name='submit' value='Add Owner/Agent'></td>";
	if($message){echo "<td>$message</td>";}
	echo "</tr></table></div></form></body></html>";

?>
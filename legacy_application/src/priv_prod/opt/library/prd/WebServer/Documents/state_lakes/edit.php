<?php
session_start();
$level=$_SESSION['state_lakes']['level'];
$tempID=$_SESSION['state_lakes']['tempID'];
$database="state_lakes";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
//        extract($_REQUEST);
//  echo "<pre>"; print_r($_POST); echo "</pre>";  exit;      
       if(@$_POST['submit']=="Check Objects")
       		{
       		//concat('pier_id=<a href=\'edit_pier.php?edit=\'>',pier_id,'</a>') as object  FROM `piers` WHERE `contacts_id` = $id
       		$id=$_POST['id'];
			$sql = "SELECT concat('pier_id=',pier_id) as object  FROM `piers` WHERE `contacts_id` = $id
			union
			SELECT concat('buoy_id=',buoy_id)  FROM `buoy` WHERE `contacts_id` = $id
			union
			SELECT concat('ramp_id=',ramp_id)  FROM `ramp` WHERE `contacts_id` = $id
			union
			SELECT concat('seawall_id=',seawall_id)  FROM `seawall` WHERE `contacts_id` = $id
			union
			SELECT concat('swim_line_id=',swim_line_id)  FROM `swim_line` WHERE `contacts_id` = $id";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
			while($row=mysqli_fetch_assoc($result)){$object[]=$row;}
			echo "<pre>"; print_r($object); echo "</pre>"; // exit;
       		}
       		
       if(@$_POST['submit']=="Delete")
       		{
//        		if($level<3){echo "Contact either Tom if you need to delete this Owner/Agent.";exit;}
			$sql = "DELETE FROM contacts where id='$_POST[id]'";
// echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
       		echo "Record was successfully deleted. You may close this window.";exit;
       		}
       
       if(@$_POST['submit']=="Update")
       		{
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
       		$skip=array("submit","id");
       			foreach($_POST AS $num=>$array)
       				{
       				if(!is_int($num)){continue;}  
       					foreach($array as $k=>$v)
       						{
       						if(in_array($k,$skip)){continue;}
       						$v=htmlspecialchars_decode($v);
       						@$clause.=$k."='".$v."',";
       						}
       						$id=$_POST[$num]['id'];
       			$clause="set ".rtrim($clause,",")." where id='$id'";
			$sql = "Update contacts $clause";
//echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); 
			$clause="";
       				}
			$edit=$id;
			$message="Update was successful.<br />Close window when done.";
       		}
       
$display_fields="*";

$sql = "SELECT $display_fields FROM contacts as t1 
WHERE  id='$edit'
";// echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}

while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}

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

function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}
</script></head>
";

echo "<body bgcolor='beige'><form method='POST' name='contactForm'><div align='center'><table><tr><td><table cellpadding='5' border='1' bgcolor='#FFF0F5'>";

$radio=array("entity");
$entity_array=array("a"=>"agent","c"=>"corporation","p"=>"private","s"=>"state/federal");
	
	foreach($ARRAY as $num=>$row)
		{ 
			foreach($row as $fld=>$value){
				$id=$row['id'];
					if($fld=="id"){
					$fld_array=$num."[id]";
					echo "<input type='hidden' name='$fld_array' value='$id'>";}
				if($fld=="park" || $fld=="id"){$RO="disabled";}else{$RO="";}
		
				echo " <tr valign='top'><td align='right'>$fld</td>";
				
				$fld_array=$num."[$fld]";
				if(!isset($img)){$img="";}
				$item="<input type='text' name='$fld_array' value=\"$value\" size='37'$RO>$img";
					
				if($fld=="comment"){
					if($value){$d="block";}else{$d="none";}
					$item="<div id=\"fieldName\">   ... <a onclick=\"toggleDisplay('fieldDetails[$id]');\" href=\"javascript:void('')\"> toggle &#177</a></div>

					<div id=\"fieldDetails[$id]\" style=\"display: $d\"><br><textarea name='$fld_array' cols='55' rows='15'>$value</textarea></div>";
				}
				
				if($fld=="billing_add_1"){
					$item="<textarea name='$fld_array' cols='37' rows='1'>$value</textarea>";
				}
				
				if(in_array($fld,$radio))
					{
					foreach($entity_array as $var_k=>$var_val)
						{
						${"ck".$var_k}="";
						}
					${"ck".$value}="checked";
					$item="<input type='radio' name='$fld_array' value='a'$cka>agent ";
					$item.="<input type='radio' name='$fld_array' value='p'$ckp>private ";
					$item.="<input type='radio' name='$fld_array' value='c'$ckc>corporation ";
					$item.="<input type='radio' name='$fld_array' value='s'$cks>state/federal";
					}
				
			echo "<td>$item</td></tr>";
			if($fld=="lake_zip"){echo "</table></td><td><table cellpadding='5' border='1' bgcolor='#FFF0F5'>";}
			
			
			}
		}
	if(!isset($message)){$message="";}
	echo "<tr><th colspan='2'>Owner/Agent</th></tr><tr><td align='center'>
	<input type='submit' name='submit' value='Update'>
	</td><td>$message";
	if($level>2 or $tempID=="Stevens9213")
		{
		echo "<input type='hidden' name='id' value='$edit'>
		<input type='submit' name='submit' value='Delete' onClick='return confirmLink()'>";
		}
	echo "</td></tr>";
	if($level>2)
		{
		echo "<tr><td colspan='2' align='center'>
		<input type='hidden' name='id' value='$edit'>
		<input type='submit' name='submit' value='Check Objects'>
		</td></tr>";
		}
	echo "</table></td></tr>";
	echo "</table></div></form></html>";

?>
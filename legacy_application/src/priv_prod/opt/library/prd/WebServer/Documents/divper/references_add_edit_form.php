<?php

if(!empty($submit_form))
	{
	$message="Check for correctness. If needed, make any changes, click Update.";
	$skip_edit=array("appID");
	}
	else
	{
	$message="After checking References, the person can be added.";
	$skip_edit=array("appID");
	}
	
if(empty($submit_form))
	{
	$bk_color="#ccccff";
	}
	else
	{
	$bk_color="#ecffb3";}
echo "<div class=\"column_2\" style=\"background-color: $bk_color;\">";

echo "<form method='post'>";
echo "<h3>$message</h3>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<p>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			$var_fld=$fld;
			if (array_key_exists($fld,$rename))
				{
				$var_fld=$rename[$fld];
				}
			
			if($fld=="appID")
				{			
				echo "<input type='hidden' name='$fld' value=\"$val\" >";
				}
				
			if(in_array($fld,$skip_add)){continue;}
			if(in_array($fld,$skip_edit)){continue;}
			$val="";
			if(!empty($submit_form))
				{
				$val=$value;
				}
			$ro="";
			if($fld=="checked_by")
				{
				$val=$tempID;
				$ro="READONLY";
				}
			if($fld=="date_c")
				{
				$val=date("Y-m-d");
				$ro="READONLY";
				$var_fld="Date entered.";
				}
			if($fld=="park_code" and empty($submit_form))
				{
				$val=$var_park_code;
				}
			if($fld=="comments")
				{
				echo "<textarea name='$fld' cols='65', rows='4'>$val</textarea> $var_fld <br />";
				continue;
				}
				
			echo "<input type='text' name='$fld' value=\"$val\" size='15' $ro> $var_fld <br />";
			}
		echo "</p>";
		}
	}
	if(empty($submit_form))
		{$action="Add";}
		else
		{
		$action="Update";
		$del_button="<p class='right'><input type='submit' name='submit_form' value=\"Delete\" style='color: red' onclick=\"return confirm('Are you sure you want to delete this Record?')\"></p>";
		$reset_button="<p class='left'>If no change is needed then go <input type='submit' name='reset' value=\"Home\" style='color: black'></p>";
		}
	echo "<p class='center'>
	<input type='hidden' name='id' value=\"".$ARRAY[0]['id']."\">
	<input type='submit' name='submit_form' value=\"$action\" style='color: blue'></p>";
	if($action=="Update")
		{
		echo "$reset_button";
		echo "$del_button";
		}
	echo "</form></div>";
	echo "</div>
</div>";
?>
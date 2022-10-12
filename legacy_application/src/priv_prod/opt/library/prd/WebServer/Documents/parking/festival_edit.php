<?php
unset($ARRAY);


if((isset($month) AND isset($year)) OR $pass_edit=="")
	{
	exit;
	}

$sql="SELECT * from festival_dates where date_id like '$pass_edit'"; //echo "$sql";
$result = @mysqli_query($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[$row['space']]=$row;
	}
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;

$edit_array=array("all_day");
$log_name=@$_SESSION['parking']['log_name'];
echo "<hr />
<table align='center'>
<tr><td><a href='https://www.google.com/maps/place/12700+Bayleaf+Church+Rd,+Raleigh,+NC+27614/@35.9668227,-78.6344719,17z/data=!3m1!4b1!4m5!3m4!1s0x89ac566b15952633:0x2984f32d6cd94379!8m2!3d35.9668227!4d-78.6322832?hl=en' target='_blank'>Map</a> to Yorkshire Center
&nbsp;</td></tr>
<tr><td>
<form method='POST'>
<table align='center' border='1'>";
echo "<tr>";

	echo "<td valign='top'>
	<table border='1' cellpadding='5' cellspacing='5' align='center' bgcolor='beige'>
	<tr><th>Festival Trailer</th></tr>";

if(empty($ARRAY) AND isset($pass_edit) AND !empty($_SESSION['parking']))
	{
	echo "<tr><td>Reserve the Festival Trailer for this park: <select name='space' onchange=\"this.form.submit()\"><option value=\"\"></option>\n";
	foreach($space_array as $index=>$parkcode)
		{
		echo "<option value='$parkcode'>$parkcode</options>\n";
		}
	echo "</select>
	<input type='hidden' name='tempID' value=\"$tempID\">
	<input type='hidden' name='pass_edit' value='$pass_edit'>
	<input type='hidden' name='all_day' value='$log_name'>
	</td>
	</tr>";
	}
	else
	{
	if(empty($ARRAY))
		{
		// do nothing
		}
		else
		{
		foreach($ARRAY as $parkcode=>$array)
			{
			extract($array);
			echo "<tr><td>Reserved for $parkcode for $date_id by $all_day</td></tr>";
			}
		}
	}
	echo "</table>

	</td>";
	
echo "</tr>";

if(@$_SESSION['parking']['level']<1)
	{
	echo "<font color='red'>While you can view the Festival Trailer reservation database without logging in, you must login in order to make changes.</font><br /> Click <a href='parking.html'>here</a> to login.";
exit;
	}

if(!isset($log_name)){$log_name=@$_SESSION['parking']['log_name'];}

if(empty($date_id))
	{$date_id=$pass_edit;}
	
$var_comment=@$ARRAY[$space]['comment'];

if($level>3 or $_SESSION['parking']['tempID']==$tempID)
	{
	if(!empty($space))
		{
		echo "<tr><td align='center'>Comment for Festival Trailer: <textarea name='comment[$date_id]' cols='70' rows='2'>$var_comment</textarea></td></tr>";
		echo "<tr><td align='center' bgcolor='green'>
		<input type='hidden' name='space' value='$space'>
		<input type='submit' name='submit_form' value='Submit'>
		";
		}
	echo "
	<input type='hidden' name='all_day' value='$log_name'>
	<input type='hidden' name='pass_edit' value='$pass_edit'>
		<input type='hidden' name='cal_type' value='festival'>
		</td></tr><tr><td><input type='submit' name='submit_form' value='Release Festival Trailer' style='background-color:#ffcccc' onclick=\"return confirm('Are you sure you want to release the Festival Trailer for this date?')\"></td></tr></table></td></tr></table>";
	}
	
echo "</form>";
?>
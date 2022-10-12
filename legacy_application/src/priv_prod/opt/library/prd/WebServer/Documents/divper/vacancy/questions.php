<?php
echo "<table cellpadding='8'><tr><th colspan='2'>Questions for Structured Interview for MMI</th>";

echo "<tr><td colspan='6'>General Information</td></tr>";

echo "<tr><td>* Position Description</td><td>* Staff</td><td>* Schedule</td><td>* Facility and maintenance operations</td></tr></table>";

echo "<table border='1'><tr><td colspan='6'>Rating Scale</td></tr>
<tr>
<td>1-2<br />Very Poor</td>
<td>3-4<br />Acceptable</td>
<td>5-6<br />Satisfactory</td>
<td>7-8<br />Good</td>
<td>9-10<br />Excellent</td>
</tr></table>";

if(!isset($request_data['q1'])){$q1="";}else{$q1=$request_data['q1'];}
if(!isset($request_data['q2'])){$q2="";}else{$q2=$request_data['q2'];}
if(!isset($request_data['q3'])){$q3="";}else{$q3=$request_data['q3'];}
if(!isset($request_data['q4'])){$q4="";}else{$q4=$request_data['q4'];}
echo "<table border='1'><tr><td>1.</td><td>If you were given the task of unloading a warehouse truck, which required extended lifting and carrying of material in excess of 50 pounds, would you be able to complete this task?<br /><input type='text' name='q1' value='$q1' size='2'></td></tr>";

echo "<tr><td>2.</td><td>If it was necessary to prune some limbs above normal height, would you be able to carry, set up, and use a ladder to complete this task?<br /><input type='text' name='q2' value='$q2' size='2'></td></tr>";

echo "<tr><td>3.</td><td>Why did you apply for this position?<br /><input type='text' name='q3' value='$q3' size='2'></td></tr>";

echo "<tr><td>4.</td><td>Give me a brief history of your experience related to tasks assigned to this position.<br /><input type='text' name='q4' value='$q4' size='2'></td></tr>";
echo "</table>";
?>
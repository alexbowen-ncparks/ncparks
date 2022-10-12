<?php
date_default_timezone_set('America/New_York');
function itemShow($row)
	{
	global $level,$fieldArray,$numFlds;
	
	//echo "<pre>";print_r($row);echo "</pre>";//exit;
	
	extract($row);
	$link="";
	$linkFile="";
	if($web_link)
		{
		$web=explode(",",$web_link);
		for($l=0;$l<count($web);$l++)
			{
			$trimWeb=trim($web[$l]);
			
			$pre=substr($trimWeb,0,4);$n=$l+1;
			if($pre=="http"){$link.="<a href='".$web[$l]."' target='_blank'>$web[$l]</a><br /><br />";}else{
			$link.="<a href='http://".$web[$l]."' target='_blank'>$web[$l]</a><br /><br />";}
			}
		}
	
	
	echo "<tr><td bgcolor='darkblue' align='center'><font color='white'><b>NC P&R News</b></font></td>
	<td bgcolor='lavender' width='80%'><b>$core_subject</b></td>";
	
	if($level>3){
	echo "<th bgcolor='lavender'><a href='edit_item.php?submit=edit&id=$id'>Edit</a></th>";}
	
	echo "</tr>";
	
	
	$entered_by=substr($entered_by,0,-4);
	$d=explode("-",$in_date);
	$in_date=date("l, F jS, Y", mktime(0,0,0,$d[1],$d[2],$d[0]));
	
	$subject_instruct=nl2br($subject_instruct);
	echo "<div id=\"topicTitle\" ><tr><td colspan='10'>Posted: $in_date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ... <a onclick=\"toggleDisplay('forumDetails[$id]');\" href=\"javascript:void('')\"> details &#177</a>
	</td></tr></div>
	
	<tr><td colspan='10'><div id=\"forumDetails[$id]\" style=\"display: none\">
	<br><b>Abstract:</b> $subject_instruct<br><br>Link to complete article:<br />$link $linkFile<br><font size='1'>Last modified by: $entered_by [$date_create]</font></div></td></tr>";
	}
?>
<?php

function itemShow($row,$numrow)
	{
	global $fieldArray,$numFlds;
	
	//echo "<pre>";print_r($row);echo "</pre>";//exit;
	
	if($numrow==1){$display="block";}else{$display="none";}
	extract($row);
	
	if(@$web_link)
		{
		$web=explode(",",$web_link);
		for($l=0;$l<count($web);$l++)
			{
			$trimWeb=trim($web[$l]);
			
			$pre=substr($trimWeb,0,4);$n=$l+1;
			if($pre=="http")
				{
				@$link.="<a href='".$web[$l]."' target='_blank'>$web[$l]</a><br /><br />";
				}
				else
					{
				$link.="<a href='http://".$web[$l]."' target='_blank'>$web[$l]</a><br /><br />";
				}
			}
		}
	
	if(@$file_link)
		{
		$file=explode(",",$file_link);
		for($l=0;$l<count($file);$l++)
			{
			$trimFile=trim($file[$l]);
			@$linkFile.="<a href=\"https://auth.dpr.ncparks.gov/div_cor/".$trimFile."\" target='_blank'>$trimFile</a><br /><br />";
			}
		}
	
	if(@$cor_link)
		{
		$file=explode(",",$cor_link);
		for($l=0;$l<count($file);$l++)
			{
			$trimFile=trim($file[$l]);
			@$linkFile.="Related correspondence entry: <a href='https://auth.dpr.ncparks.gov/div_cor/search.php?submit=Search&id=$trimFile' target='_blank'>$trimFile</a><br /><br />";
			}
		}
	
	
	echo "<tr><td bgcolor='darkviolet' align='center'><font color='white'><b>$section</b> [$id]</font></td>
	<td bgcolor='lavender' width='80%'><b>$core_subject</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To: <font color='blue'><b>$to_whom</b></font> &nbsp;&nbsp;&nbsp;From: <b>$from_whom</b> &nbsp;&nbsp;&nbsp;Location: <b>$location</b></td>
	
	<th bgcolor='lavender'><a href='edit_item.php?submit=edit&id=$id'>Edit</a></th>
	</tr>";
	
	if($route_status=="pending"){$f1="<font color='red'>";}else{$f1="<font color='green'>";}
	
	echo "<tr><td colspan='10'>";
	if(!isset($link)){$link="";}
	if(!isset($linkFile)){$linkFile="";}
	echo "<div id=\"topicTitle\">$f1$route_status</font>  &nbsp;&nbsp; IN: $in_date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ... <a onclick=\"toggleDisplay('forumDetails[$id]');\" href=\"javascript:void('')\"> details &#177</a>
	</div>
	
	<div id=\"forumDetails[$id]\" style=\"display: $display\">
	<br><b>Type:</b> $core_type<br>
	<br><b>Instructions:</b> $subject_instruct<br><br><b>Routing comments:</b> $route_comment<br><br><b>Routing OUT date:</b> $route_out_date<br><br><b>File type:</b> $file_type &nbsp;&nbsp;&nbsp;<b>File location:</b> $file_loc<br><br>$link $linkFile<br><font size='1'>Last modified by: $entered_by [$date_create]</font></div></td></tr>";
	}
?>
<?php
$war_db="war";
$db = mysqli_select_db($connection,$war_db)       or die ("Couldn't select database");

$user=$_SESSION['war']['tempID'];
ini_set('display_errors',1);
$last_week.=" 00:00:00";
$today.=" 23:59:59";
$sql="SELECT t4.district, t1.*, 
group_concat(distinct concat(t2.file_name, '^', t2.file_link) SEPARATOR '***') as file_link, 
group_concat(distinct concat(t3.photo_name, '^', t3.photo_link) SEPARATOR '***') as photo_link
FROM centennial as t1
LEFT JOIN centennial_upload_file as t2 on t1.id=t2.centennial_id_file
LEFT JOIN centennial_upload_photo as t3 on t1.id=t3.centennial_id_photo
LEFT JOIN dpr_system.parkcode_names as t4 on t1.park=t4.park_code
where date >= '$prev_month' and date <= '$today'
group by t1.id
order by district, date desc, park"; //echo $sql;
$result = @MYSQLI_QUERY($connection,$sql) or die (mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$fam_dist[]=$district[$row['park']];
	}
$num=mysqli_num_rows($result);

if($num<1)
	{$c_centennial=0; }
	else
	{$c_centennial=$num;}

$exclude=array("id","tempID","mark","file_name","photo_name");

echo "<div id='centennial' style='display: none'>";
	echo "<table border='1' cellpadding='3'><tr><th colspan='3'>$c_centennial Posts in the last 30 days</th>
	<th colspan='2'><a href='centennial_action.php'>Post</a></th>
	<th>List of Coordinators <a href='/annual_report/get_100_coordinators.php' target='_blank'>link</a></th>
	</tr>";
if($num<1){$ARRAY=array();}

	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(in_array($fld,$exclude)){continue;}
				if($fld=="id")
					{echo "<td>View</td>";}
					else
					{echo "<th>$fld</th>";}
				}
			echo "</tr>";
			}
		if(fmod($index,2)==0){$tr=" bgcolor='aliceblue'";}else{$tr="";}
		echo "<tr$tr>";
		foreach($array as $fld=>$value)
			{
			if(in_array($fld,$exclude)){continue;}
			if($fld=="id")
				{
				echo "<td><a href='/dprcoe/edit.php?eid=$value' target='_blank'>$value</a></td>";
				continue;
				}
			if($fld=="park")
				{
				if($ARRAY[$index]['tempID']==$user OR $level>4)
					{
					$id=$ARRAY[$index]['id'];
					$value="<a href='centennial_action.php?edit=$id'>$value</a>";
					}
					else
					{$value="<b>$value</b>";}
				}
			if($fld=="title"){$value="<b>$value</b>";}
			if($fld=="date"){$value=substr($value,0,-9);}
			if($fld=="comment")
				{
				$sub=substr($value,0,200)."...<br /><br />";
				$var_temp=" <a onclick=\"toggleDisplay('comment');\" href=\"javascript:void('')\">toggle</a> ";
				$var_temp.=$sub."<div id=\"comment\" style=\"display: none\">";
				$var_temp.=nl2br($value);
				$var_temp.="</div>";
				$value=$var_temp;
				}
			if($fld=="website" and !empty($value))
				{
				if(substr($value,0,4)!="http"){$value="http://".$value;}
				$value="<a href='$value' target='_blank'>web page</a>";
				}
			if($fld=="file_link")
				{
				if(!empty($value))
					{
					$var_array=explode("***",$value);
					$var="";
					foreach($var_array as $fk=>$fv)
						{
						$pv=explode("^",$fv);
						$link=$pv[1];
						$fn=$pv[0];
						$exp=explode("/",$link);
						$exp[]="ztn.".array_pop($exp);
						$file=implode("/",$exp);
						$var.="<a href=\"$link\" target='_blank'><img src='$file'>$fn</a><br />";
						}
					$value=$var;
					}
					else
					{$value="";}	
				}
				
			if($fld=="photo_link")
				{
				if(!empty($value))
					{
					$var_array=explode("***",$value);
					$var="";
					foreach($var_array as $fk=>$fv)
						{
						$pv=explode("^",$fv);
						$link=$pv[1];
						$pn=$pv[0];
						$exp=explode("/",$link);
						$exp[]="ztn.".array_pop($exp);
						$photo=implode("/",$exp);
						//$pn
						$var.="<a href=\"$link\" target='_blank'><img src='$photo'></a>";
						}
					$value=$var;
					}
				}
				
			echo "<td valign='top' align='left'>$value</td>";
			}
		echo "</tr>";
		}
	echo "</table>";
echo "</div>";

if(!empty($ARRAY))
	{unset($ARRAY);}

?>
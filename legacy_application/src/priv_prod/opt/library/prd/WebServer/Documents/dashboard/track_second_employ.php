<?php
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$database="second_employ";
mysqli_select_db($connection, $database);

$db_name=$db_name_array['second_employ'];

$limit_array=array("60033018"=>"chop");

if(empty($beacon_num))
	{
	$beacon_num="60033018";  // testing for CHOP
	}
$title=$limit_array[$beacon_num];
$fld=strtoupper($title)."_approval";
$restrict_to="and $fld='0000-00-00' AND PASU_approval>'2016-00-00'";

$review_flds=array("date","recommend","comments");

$review_array=array("pasu"=>"Park Superintendent","disu"=>"District Superintendent","chom"=>"Chief of Maintenance","ensu"=>"Engineering Supervisor","plnr"=>"Chief of Planning & Natural Resources","chop"=>"Chief of Operations","dedi"=>"Deputy Director","dire"=>"Director");
$review_flds=array("date","recommend","comments");

$sql="SELECT  id, se_dpr, name, park_code, $fld  FROM `se_list` 
WHERE `status` = 'Pending' $restrict_to
order by id"; 
// echo "$sql";  //exit;
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));

$ARRAY=array();
$date_array=array();
$skip=array("supervisor_approval");
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		$var_array_park_code[]=$row['park_code'];
		foreach($row as $fld=>$value)
			{
			if(substr($fld,-9)=="_approval")
				{
				if(in_array($fld,$skip)){continue;}
				$date_array[$row['se_dpr']][$fld]=$value;
				}
			}
		}
// echo "<pre>"; print_r($ARRAY[0]); echo "</pre>";  //exit;
//  echo "$sql<pre>";  print_r($date_array); echo "</pre>"; // exit;

$park_code=implode(",",array_unique($var_array_park_code));

$show_array=array("id");
		
	$c=count($ARRAY);
	$span=count($ARRAY[0]);
	$limit_array=array("edits","description","justification");
?>
<style>
table.alternate tr:nth-child(odd) td{
background-color: #fff2e6;
}
table.alternate tr:nth-child(even) td{

}
</style>
<?php
	echo "<a onclick=\"toggleDisplay('$v');\" href=\"javascript:void('')\">[ Show $db_name</a> $c ]
<div id=\"$v\" style=\"display: none\">";

	echo "<table class='alternate' border='1'><tr><td colspan='$span'>$c projects</td></tr>";
	foreach($ARRAY AS $index=>$array)
		{
		if($index==0)
			{
			echo "<tr>";
			foreach($ARRAY[0] AS $fld=>$value)
				{
				if(!in_array($fld, $show_array)){continue;}
				$header_array[]="<th>$fld</th>";
				echo "<th>$fld</th>";
				}
			echo "<th>CoC</th></tr>";
			}
		if(fmod($index,10)==0 and $index!=0)
			{
			$ha=implode("",$header_array);
			echo "<tr>$ha</tr>";
			}
		echo "<tr valign='top'>";
		foreach($array as $fld=>$value)
			{
			if(!in_array($fld,$show_array)){continue;}
			
			if($fld=="id")
				{
				$value="<form method='POST' action='/second_employ/edit.php' target='_blank' onclick=\"this.form.submit()\">
				<input type='hidden' name='edit' value='$value'>
				<input type='submit' name='submit' value='edit'>
				</form>";
				
				}
			
			echo "<td>$value</td>";
			}
			$acted_person="";
			$acted_date="";
			$next_person="";
		foreach($date_array[$array['se_dpr']] as $k=>$v)
			{
			if($k=="submitted_date"){continue;}
			if($v!="0000-00-00")
				{
				$k=substr($k,0,4);
				$lower_k=strtolower($k);
				$k=$review_array[$lower_k];
				if(empty($k) and $array['submitted_date']==$v){$k="Submitted";}
				$acted_person=$k;
				$acted_date=$v;
				}
				else
				{
				$var_email="";
				$proj_name=$array['se_dpr']." - ".$array['name'];
				$id=$array['id'];
				$e_content="Subject=Project Review: $proj_name&Body=Click the link to review this project - /dpr_proj/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: /dpr_proj/index.html";
				$e_content="Subject=Project Review: $proj_name&Body=Click the link to review this project - /dpr_proj/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: /dpr_proj/index.html";
				$e_content=htmlentities($e_content);
				$k=substr($k,0,4);
			// 	if($k=="pasu")
// 					{
// 					$var_pc=$array['park_code'];
// 					if($var_pc=="BATR"){$var_pc="SILA";}  // see get_emails.php
// 					if($var_pc=="MOJE"){$var_pc="NERI";}
// 					IF(empty($pasu_email_park[$var_pc]))
// 						{$var_email="Vacant - no email for PASU";}
// 						else
// 						{
// 						$var_email_add=$pasu_email_park[$var_pc];
// 						$var_email="<a href='mailto:$var_email_add?$e_content'>$var_email_add</a>";
// 						}
// 					
// 					}
// 				if($k=="disu")
// 					{
// 					$var_pc=$array['park_code'];
// 					$var_dist=$district[$var_pc];
// 					
// 					$var_email_add=$all_disu_email[$var_dist];
// 					$var_email="<a href='mailto:$var_email_add?$e_content'>$var_email_add</a>";
// 					}
// 				if($k=="chom")
// 					{
// 					$var_email=$chom_email[0];
// 					$var_email="<a href='mailto:$var_email?$e_content'>$var_email</a>";
// 					}
// 				if($k=="ensu")
// 					{
// 					$var_email=$ensu_email[0];
// 					$var_email="<a href='mailto:$var_email?$e_content'>$var_email</a>";
// 					}
// 				if($k=="plnr")
// 					{
// 					$var_email=$plnr_email[0];
// 					$var_email="<a href='mailto:$var_email?$e_content'>$var_email</a>";
// 					}
// 				if($k=="chop")
// 					{
// 					$var_email=$chop_email[0];
// 					$var_email="<a href='mailto:$var_email?$e_content'>$var_email</a>";
// 					}
// 				if($k=="dedi")
// 					{
// 					$var_email=$dedi_email[0];
// 					$var_email="<a href='mailto:$var_email?$e_content'>$var_email</a>";
// 					}
// 				if($k=="dire")
// 					{
// 					$var_email=$dire_email[0];
// 					$var_email="<a href='mailto:$var_email?$e_content'>$var_email</a>";
// 					}
// 					
				$lower_k=strtolower($k);
				$k=$review_array[$lower_k];
				$next_person=$k;
	
				break;
				}
			}
		if($lower_k=="disu")
			{
			continue;
			}
		if($acted_person=="Director")
			{$na="Determine Status";}
			else
			{$na="<font color='red'>$next_person</font> $var_email";}
		echo "<td>Last Action:<br /><font color='green'>$acted_person $acted_date</font><br />Next Action: $na $lower_k</td></tr>";
		}
	echo "</table></div>";
//echo "<pre>"; print_r($pasu_email); echo "</pre>"; // exit;
//echo "<pre>"; print_r($date_array); echo "</pre>"; // exit;
	
	}
	else
	{
	echo "<a onclick=\"toggleDisplay('$v');\" href=\"javascript:void('')\">[ Show $db_name</a> ]
<div id=\"$v\" style=\"display: none\">";
	echo "No Secondary Employment requests awaiting approval by $title.</div>";
	}
		echo "</body></html>";
?>
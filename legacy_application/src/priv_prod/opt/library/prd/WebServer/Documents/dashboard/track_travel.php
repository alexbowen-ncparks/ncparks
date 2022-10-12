<?php
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$database="travel";
mysqli_select_db($connection, $database);


// $limit_array=array("60033018"=>"chop");

if(empty($beacon_num))
	{
	$beacon_num="60033018";  // testing for CHOP
	}
// $title=$limit_array[$beacon_num];
// $fld=$title."_date";
$restrict_to="";

$review_flds=array("date","recommend","comments");

$review_array=array("OPS"=>"Operations","DPR_BO"=>"Budget Office","DIR"=>"Director");
$review_flds=array("date","recommend","comments");

$sql="SELECT  *, concat(date_from, ' to ', date_to) as date_from_to  FROM `tal` 
WHERE `pending_BPA` = 'Pending' $restrict_to
order by date_from"; 
// echo "$sql";  //exit;
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));

if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		$var_array_park_code[]=$row['location'];
		foreach($row as $fld=>$value)
			{
			if(substr($fld,0, 7)=="approv_")
				{
				$date_array[$row['tadpr']][$fld]=$value;
				}
			}
		}
//  echo "<pre>"; print_r($review_array); print_r($date_array); echo "</pre>";  exit;

$park_code=implode(",",array_unique($var_array_park_code));

$show_array=array("id","tadpr","proj_name","location","date_from_to", "purpose", "amount");
		
	$c=count($ARRAY);
	$span=count($ARRAY[0]);
	$limit_array=array("purpose");
?>
<style>
table.alternate tr:nth-child(odd) td{
background-color: #fff2e6;
}
table.alternate tr:nth-child(even) td{

}
</style>
<?php
// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
$db_name=$db_name_array[$v];
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
				$value="<form method='POST' action='/travel/edit.php' target='_blank' onclick=\"this.form.submit()\">
				<input type='hidden' name='edit' value='$value'>
				<input type='submit' name='submit' value='Find'>
				</form>";
				}
			
			echo "<td>$value</td>";
			}
			$acted_person="";
			$acted_date="";
			$next_person="";
		foreach($date_array[$array['tadpr']] as $k=>$v)
			{
			if($k=="submitted_date"){continue;}
			if($v!="0000-00-00")
				{
				$k=substr($k,7);
				$k=$review_array[$k];
				if(empty($k) and $array['submitted_date']==$v){$k="Submitted";}
				$acted_person=$k;
				$acted_date=$v;
				}
				else
				{
				$var_email="";
				$proj_name=$array['tadpr'];
				$id=$array['id'];
				$e_content="Subject=Project Review: $proj_name&Body=Click the link to review this project - /dpr_proj/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: /dpr_proj/index.html";
				$e_content="Subject=Project Review: $proj_name&Body=Click the link to review this project - /dpr_proj/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: /dpr_proj/index.html";
				$e_content=htmlentities($e_content);
				$k=substr($k,7);
				
					
				$k=$review_array[$k];
				$next_person=$k;
	
				break;
				}
			}
		if($acted_person=="Director")
			{$na="Determine Status";}
			else
			{$na="<font color='red'>$next_person</font> $var_email";}
		echo "<td>Last Action:<br /><font color='green'>$acted_person $acted_date</font><br />Next Action: $na</td></tr>";
		}
	echo "</table></div>";
//echo "<pre>"; print_r($pasu_email); echo "</pre>"; // exit;
//echo "<pre>"; print_r($date_array); echo "</pre>"; // exit;
	
	}
	else
	{
	echo "<a onclick=\"toggleDisplay('$v');\" href=\"javascript:void('')\">[ Show $db_name</a> ]
<div id=\"$v\" style=\"display: none\">";
	echo "No DPR TAs requests awaiting approval.</div>";
	}
		echo "</body></html>";
?>
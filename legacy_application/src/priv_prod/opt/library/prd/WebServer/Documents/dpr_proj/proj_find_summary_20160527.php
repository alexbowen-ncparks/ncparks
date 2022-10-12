<?php

ini_set('display_errors',1);

	$database="dpr_proj";
	$title="DPR Project Tracking Application - Summary";
	include("../_base_top.php");
	
include("../../include/iConnect.inc");

date_default_timezone_set('America/New_York');
$database="dpr_proj";
mysqli_select_db($connection, $database);


$review_array=array("pasu"=>"Park Superintendent","disu"=>"District Superintendent","chom"=>"Chief of Maintenance","ensu"=>"Engineering Supervisor","plnr"=>"Chief of Planning & Natural Resources","chop"=>"Chief of Operations","dedi"=>"Deputy Director","dire"=>"Director");
$review_flds=array("date","recommend","comments");

$sql="SELECT  *  FROM `project` WHERE `proj_status` = 'active' order by submitted_date";
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));

if(mysqli_num_rows($result)>1)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		$var_array_park_code[]=$row['park_code'];
		foreach($row as $fld=>$value)
			{
			if(substr($fld,-5)=="_date")
				{
				$date_array[$row['proj_number']][$fld]=$value;
				}
			}
		}
//echo "<pre>"; print_r($review_array); print_r($date_array); echo "</pre>";  exit;

$park_code=implode(",",array_unique($var_array_park_code));

include("get_emails.php");
//echo "<pre>"; print_r($pasu_email); echo "</pre>"; // exit;
//echo "<pre>"; print_r($pasu_email_park); echo "</pre>"; // exit;
//echo "<pre>"; print_r($var_dist_park); echo "</pre>"; // exit;
// echo "<pre>"; print_r($all_disu_email); echo "</pre>"; // exit;


include("../../include/get_parkcodes_i.php");
// echo "<pre>"; print_r($district); echo "</pre>"; // exit;

$show_array=array("id","proj_number","proj_name","park_code","submitted_date","proj_lead");
		
	$c=count($ARRAY);
	$span=count($ARRAY[0]);
	$limit_array=array("edits","description","justification");
?>
<style>
table.alternate tr:nth-child(odd) td{
background-color: #fff2e6;
}
table.alternate tr:nth-child(even) td{
background-color: #ffffff;
}
</style>
<?php

	echo "<div>1<table class='alternate' border='1'><tr><td colspan='$span'>$c projects</td></tr>";
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
			echo "<tr>$ha.</tr>";
			}
		echo "<tr valign='top'>";
		foreach($array as $fld=>$value)
			{
			if(!in_array($fld,$show_array)){continue;}
			if($fld=="id")
				{
				$value="<form method='POST' action='project.php' onclick=\"this.form.submit()\">
				<input type='hidden' name='id' value='$value'>
				<input type='submit' name='submit' value='Find'>
				</form>";
				}
			
			echo "<td>$value</td>";
			}
			$acted_person="";
			$acted_date="";
			$next_person="";
		foreach($date_array[$array['proj_number']] as $k=>$v)
			{
			if($k=="submitted_date"){continue;}
			if($v!="0000-00-00")
				{
				$k=substr($k,0,4);
				$k=$review_array[$k];
				if(empty($k) and $array['submitted_date']==$v){$k="Submitted";}
				$acted_person=$k;
				$acted_date=$v;
				}
				else
				{
				$var_email="";
				$proj_name=$array['proj_name'];
				$id=$array['id'];
				$e_content="Subject=Project Review: $proj_name&Body=Click the link to review this project - https://10.35.152.9/dpr_proj/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: https://10.35.152.9/dpr_proj/index.html";
				$e_content="Subject=Project Review: $proj_name&Body=Click the link to review this project - https://10.35.152.9/dpr_proj/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: https://10.35.152.9/dpr_proj/index.html";
				$k=substr($k,0,4);
				if($k=="pasu")
					{
					$var_pc=$array['park_code'];
					if($var_pc=="BATR"){$var_pc="SILA";}  // see get_emails.php
					if($var_pc=="MOJE"){$var_pc="NERI";}
					IF(empty($pasu_email_park[$var_pc]))
						{$var_email="No email for PASU";}
						else
						{
						$var_email_add=$pasu_email_park[$var_pc];
						$var_email="<a href='mailto:$var_email_add?$e_content'>$var_email_add</a>";
						}
					
					}
				if($k=="disu")
					{
					$var_pc=$array['park_code'];
					$var_dist=$district[$var_pc];
					
					$var_email_add=$all_disu_email[$var_dist];
					$var_email="<a href='mailto:$var_email_add?$e_content'>$var_email_add</a>";
						
					
					}
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
		echo "</body></html>";
		exit;
	}
?>
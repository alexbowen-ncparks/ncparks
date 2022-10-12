<?php

ini_set('display_errors',1);

	$database="dpr_proj";
	$title="DPR Project Tracking Application - Summary";
	include("../_base_top.php");
	
//include("../../include/iConnect.inc");

include("../../include/get_parkcodes_reg.php");
// echo "<pre>"; print_r($district); echo "</pre>"; // exit;
// echo "<pre>"; print_r($region); echo "</pre>"; // exit;

date_default_timezone_set('America/New_York');

$database="dpr_system";
mysqli_select_db($connection, $database);
$sql="SELECT  park_code, region, admin_by  
FROM `parkcode_names_region` 
where admin_by !=''
order by admin_by"; //echo "$sql";
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_parks[$row['admin_by']][$row['park_code']]=$row['region'];
	$ARRAY_region[$row['park_code']]=$row['region'];
	$ARRAY_admin[$row['admin_by']]=$row['region'];
	}
//  echo "<pre>"; print_r($ARRAY_parks); echo "</pre>"; // exit;

$database="dpr_proj";
mysqli_select_db($connection, $database);

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$level=$_SESSION['dpr_proj']['level'];
if($level<1)
	{exit;}
$restrict_to="";

if($level<2)
	{
	$park_code=$_SESSION['dpr_proj']['select'];
	$restrict_to=" and park_code='$park_code'";
	if(array_key_exists($park_code,$ARRAY_parks))
		{
		$var[]="park_code='$park_code'";
		$restrict_to=" and (";
		foreach($ARRAY_parks[$park_code] as $k=>$v)
			{
			$var[]="park_code='$k'";
			}
		$restrict_to.=implode(" OR ",$var).")";
		}
// 	echo "r=$restrict_to";
	}
if($level==2)
	{
// 	echo "<pre>"; print_r($district); echo "</pre>"; // exit;
	$park_code=$_SESSION['dpr_proj']['select'];

	foreach($ARRAY_admin as $k=>$v)
		{
		if($v==$park_code)
			{
			$this_region[]=$k;
			}
		}
	foreach($ARRAY_region as $k=>$v)
		{
		if($v==$park_code)
			{
			$this_region[]=$k;
			}
		}
//  	echo "<pre>"; print_r($this_region); echo "</pre>"; // exit;
	$restrict_to=" and (park_code='".implode("' OR park_code='",$this_region)."'";
	$restrict_to.=")";
	}

$review_array=array("pasu"=>"Park Superintendent","disu"=>"Regional Superintendent","chom"=>"Chief of Maintenance","ensu"=>"Engineering Supervisor","plnr"=>"Chief of Planning & Natural Resources","chop"=>"Chief of Operations","dedi"=>"Deputy Director","dire"=>"Director");
$review_flds=array("date","recommend","comments");

$sql="SELECT * FROM `project` WHERE `proj_status` = 'active' and dire_date!='0000-00-00'  order by park_code, submitted_date"; 
// echo "$sql";  exit;
$result = @mysqli_query($connection, $sql) or die("$sql Error ". mysqli_error($connection));

if(mysqli_num_rows($result)>0)
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
// echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

$park_code=implode(",",array_unique($var_array_park_code));

include("get_emails.php");
//echo "<pre>"; print_r($pasu_email); echo "</pre>"; // exit;
//echo "<pre>"; print_r($pasu_email_park); echo "</pre>"; // exit;
//echo "<pre>"; print_r($var_dist_park); echo "</pre>"; // exit;
// echo "<pre>"; print_r($all_disu_email); echo "</pre>"; // exit;


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

}
</style>
<?php

	echo "<div><table class='alternate' border='1'><tr><td colspan='$span'>$c projects with uncertain status. Are approved by Director but </td></tr>";
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
			echo "<th>Email</th></tr>";
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
				$value="<form method='POST' action='project.php' onclick=\"this.form.submit()\">
				<input type='hidden' name='id' value='$value'>
				<input type='submit' name='submit' value='Find'>
				</form>";
				}
			if($fld=="proj_lead")
				{
				$em_link="";
				$em="</td>";
				$pc=$array['park_code'];
				if($pc=="MOJE")
					{$pc="NERI";}
				if($pc=="SARU")
					{$pc="CLNE";}
				if(!empty($pasu_email_park[$pc]))
					{			
					$em=$pasu_email_park[$pc];
					$em_link="<a href='mailto:$em?subject=DPR Project Tracking&body=$pc has one or more projects which were approved by the Director and have a status of ACTIVE. If this project has been competed or is no longer active, please login to the Project Trackiing app and update the status.%0A%0A/login_form.php?db=dpr_proj%0A%0AThanks'>$em</a>";
					$em_link="<a href='mailto:$em?subject=DPR Project Tracking&body=$pc has one or more projects which were approved by the Director and have a status of ACTIVE. If this project has been competed or is no longer active, please login to the Project Trackiing app and update the status.%0A%0A/login_form.php?db=dpr_proj%0A%0AThanks'>$em</a>";
					}
				$value=$value."</td><td>$em_link";
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
				if($acted_person=="Director")
					{
					$value.= "<td>$acted_person $acted_date</td>";
					}
				}
			}
		echo "</tr>";
		}
	echo "</table></div>";
// echo "<pre>"; print_r($pasu_email_park); echo "</pre>"; // exit;
	
	}
	
		echo "</body></html>";
?>
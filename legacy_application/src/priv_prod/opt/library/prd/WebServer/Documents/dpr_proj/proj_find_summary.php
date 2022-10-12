<?php
/*   *** INCLUDE file inventory ***
	
	include("../_base_top.php")
	include("../../include/get_parkcodes_dist.php")
	include("get_emails.php")

*/

ini_set('display_errors',1);

	$database="dpr_proj";
	$title="DPR Project Tracking Application - Summary";
	include("../_base_top.php");
	
include("../../include/get_parkcodes_dist.php");
// echo "<pre>"; print_r($district); echo "</pre>"; // exit;
// echo "<pre>"; print_r($region); echo "</pre>"; // exit;

date_default_timezone_set('America/New_York');

$database="dpr_system";
mysqli_select_db($connection, $database);
/* 2022-09-13: cooper - why does this select (sql) only look at parks that are administered by another park ('admin_by')? do we still need to worry about park administration if we know the district? use the District Array.

*/
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

// cooper +3 lines
//  echo "<pre>"; print_r($ARRAY_parks); echo "</pre>";  exit;
//  echo "<pre>"; print_r($ARRAY_region); echo "</pre>";  exit;
//  echo "<pre>"; print_r($ARRAY_admin); echo "</pre>";  exit;


$database="dpr_proj";
mysqli_select_db($connection, $database);

/* 2022-09-14: Cooper - what do we have session-wise (need district)?
 session variable "parkS" gives us district for DISU:
 EADI - shimel, NODI - woodruff, SODI - greenwood, WEDI - mcelhone
 all DISU are at level 2 for dpr_proj
 */
 //cooper echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
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
 	/*2022-09-15: Cooper 
 	echo "<pre> District Array"; print_r($district); echo "</pre>"; // exit;
	echo print_r($_SESSION['parkS']);  <--- DISTRICT
	20220915: Cooper - switch from region to use the DISTRICT array
		$park_code=$_SESSION['dpr_proj']['select']; 
	*/
	// assign parkS (district) to park_code
	$park_code=$_SESSION['parkS'];	
	
	/* cooper - abandon the admin and region arrays
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
	*/
	// cooper - compare district array to session var parkS to build 'this_region' array
	foreach($district as $k=>$v)
	{
		if($v==$park_code)
			{$this_region[]=$k;}
	}

//cooper - list the created 'region' array
 //echo "<pre>"; print_r($this_region); echo "</pre>";
	$restrict_to=" and (park_code='".implode("' OR park_code='",$this_region)."'";
	$restrict_to.=")";

	IF(!empty($limit_to))
		{
		$rl="disu_date='0000-00-00'";
		$prev_rev="pasu_date !='0000-00-00'";
		$restrict_to.="and ".$rl."and ".$prev_rev;
		}
	}

$review_array=array("pasu"=>"Park Superintendent","disu"=>"Regional Superintendent","chom"=>"Chief of Maintenance","ensu"=>"Engineering Supervisor","plnr"=>"Chief of Planning & Natural Resources","chop"=>"Chief of Operations","dedi"=>"Deputy Director","dire"=>"Director","disu"=>"Regional Superintendent");
$review_flds=array("date","recommend","comments");

	$rl=$_SESSION['dpr_proj']['review_level'];
	$position_level=$rl;
	@$prev_rev=$_SESSION['dpr_proj']['previous_reviewer'];
	if($prev_rev=="resu"){$prev_rev="disu";}  // original table structure used district, not regional super.
	@$review_name=$review_array[$rl];
// 	echo "r=$review_name";
// echo "p=$prev_rev";
IF($level>2 and !empty($limit_to))
	{
	$rl.="_date='0000-00-00'";
	$prev_rev.="_date !='0000-00-00'";
	$restrict_to="and ".$rl."and ".$prev_rev;
	}
$sql="SELECT  *  FROM `project` 
WHERE `proj_status` = 'active' $restrict_to
order by submitted_date"; 
// echo "$sql";  //exit;
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
//echo "<pre>"; print_r($review_array); print_r($date_array); echo "</pre>";  exit;

$park_code=implode(",",array_unique($var_array_park_code));

include("get_emails.php");
//echo "<pre>"; print_r($pasu_email); echo "</pre>"; // exit;
//echo "<pre>"; print_r($pasu_email_park); echo "</pre>"; // exit;
// echo "<pre>"; print_r($plnr_email); echo "</pre>"; // exit;
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
	echo "<div><table class='alternate' border='1'><tr><td colspan='$span'>$c projects";
if(!empty($review_name)){echo "- Limit to <a href='proj_find_summary.php?limit_to=plnr'>$review_name</a>";} 
	echo "</td></tr>";

if($level==1)
	{
// 	echo "<pre>"; print_r($date_array); echo "</pre>"; // exit;
	$na="";
	foreach($date_array as $proj_number=>$array)
			{
			foreach($array as $k=>$v)
				{
				if($k=="submitted_date"){continue;}
				if($v!="0000-00-00")
					{
					$k=substr($k,0,4);
					$k=$review_array[$k];
				// 	if(empty($k) and $array['submitted_date']==$v){$k="Submitted";}
	// 				$acted_person=$k;
					if($k=="Director")
						{$na="<strong>For those projects where \"<font color='magenta'>Next Action is Determine Status</font>\", please review and correct status if necessary. Thanks.</strong>";}
					}
				}
		}
		if(!empty($na))
			{
			echo "<tr><td colspan='7'>$na</td></tr>";
			}
	}
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
				$value="<form method='POST' action='project.php' onclick=\"this.form.submit()\">
				<input type='hidden' name='id' value='$value'>
				<input type='submit' name='submit' value='Find'>
				</form>";
				}
			if($fld=="park_code" and $level>3)
				{
				$value="$value<form method='POST' action='project_email_pasu.php' onclick=\"this.form.submit()\" target='_blank'>
				<input type='hidden' name='$fld' value='$value'>
				<input type='submit' name='submit' value='Request Status Update'>
				</form>";
				}
			
			echo "<td>$value</td>";
			}
			
			// Last column in display - CoC - Chain of Command
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
				$e_content="Subject=Project Review: $proj_name&Body=Click the link to review this project - /dpr_proj/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: /dpr_proj/index.html";
				$e_content="Subject=Project Review: $proj_name&Body=Click the link to review this project - /dpr_proj/project.php?id=$id%0D%0A%0D%0AYou will need to be logged in to Project Tracking-DPR: /dpr_proj/index.html";
				$e_content=htmlentities($e_content);
				$k=substr($k,0,4);
				if($k=="pasu")
					{
					$var_pc=$array['park_code'];
					if($var_pc=="BATR"){$var_pc="SILA";}  // see get_emails.php
					if($var_pc=="MOJE"){$var_pc="NERI";}
					IF(empty($pasu_email_park[$var_pc]))
						{$var_email="Vacant - no email for PASU";}
						else
						{
						$var_email_add=$pasu_email_park[$var_pc];
						$var_email="<a href='mailto:$var_email_add?$e_content'>$var_email_add</a>";
						}
					
					}
				if($k=="disu")
					{
					$var_pc=$array['park_code'];
// 					$var_dist=$region[$var_pc];
					$var_dist=$district[$var_pc];
					IF($var_dist=="CORE"){$var_dist="EADI";}
					IF($var_dist=="MORE"){$var_dist="WEDI";}
					IF($var_dist=="PIRE"){$var_dist="SODI";}
					$var_email_add=$all_disu_email[$var_dist];
					$var_email="<a href='mailto:$var_email_add?$e_content'>$var_email_add</a>";
					}
				if($k=="chom")
					{
					$var_email=$chom_email[0];
					$var_email="<a href='mailto:$var_email?$e_content'>$var_email</a>";
					}
				if($k=="ensu")
					{
					$var_email=$ensu_email[0];
					$var_email="<a href='mailto:$var_email?$e_content'>$var_email</a>";
					}
				if($k=="plnr")
					{
					$var_email=$plnr_email[0];
					$var_email="<a href='mailto:$var_email?$e_content'>$var_email</a>";
					}
				if($k=="chop")
					{
					$var_email=$chop_email[0];
					$var_email="<a href='mailto:$var_email?$e_content'>$var_email</a>";
					}
				if($k=="dedi")
					{
					$var_email=$dedi_email[0];
					$var_email="<a href='mailto:$var_email?$e_content'>$var_email</a>";
					}
				if($k=="dire")
					{
					$var_email=$dire_email[0];
					$var_email="<a href='mailto:$var_email?$e_content'>$var_email</a>";
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
//echo "<pre>"; print_r($date_array); echo "</pre>"; // exit;
	
	}
	else
	{
	$temp=$review_array[$position_level];
	echo "<div>No active projects are in the system for $temp for <strong>\"$restrict_to.\"</strong></div>";
	}
		echo "</body></html>";
?>
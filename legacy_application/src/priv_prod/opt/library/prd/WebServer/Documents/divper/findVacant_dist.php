<?php
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/get_parkcodes_dist.php");
$database="divper";
if($level>3)
	{
	ini_set('display_errors',1);
	}
mysqli_select_db($connection,$database); // database
include("menu.php");
//print_r($_REQUEST);
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
// ************ Process input
// extract($_REQUEST);

$level=$_SESSION['divper']['level']; 
$tempID=$_SESSION['logname']; 
@$supervise_position_array=explode(",",$_SESSION['divper']['supervise']);
//echo "<pre>"; print_r($supervise_position_array); echo "</pre>"; // exit;
$pass_level=$level;
$real_level=$level;
IF($tempID=="Cook0058")
	{
	$real_level=1;
	$pass_level=1;
	}
$where="";

if($pass_level>1){$pass_field=",vacant.chop_comments";}

//$acting=array("Anthony8436"); // bump a park ranger to allow them to track a vacancy

$acting=array();
$pass_position="";
if($level==1)
	{
	$p=$_SESSION['parkS'];
	$where="and position.park='$p'";
	$test=strtolower(substr($_SESSION['position'],0,8));
	if($test=="park sup" || $test=="office a")
		{
		$level=2;
		$pass_level=2;
		$pass_position=$test;
		}
	if(in_array($tempID,$acting))
		{
		$level=2;
		$pass_level=2;
		}
	}

if(@$_SESSION['divper']['accessPark']!="")
	{
	$where="";
		$test=explode(",",$_SESSION['divper']['accessPark']);
		foreach($test as $k=>$v){
			$where.=" position.park='$v' OR";
			}
			$where=rtrim($where," OR");
			$where="and".$where;
	}

$sql = "SELECT beacon_num From position
WHERE 1 $where
ORDER by beacon_num";
// echo "l=$level p=$pass_level<br />$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$posArray=array();
while ($row=mysqli_fetch_array($result))
	{
	extract($row);
	$posArray[]=$beacon_num;
	}

// echo "$sql<pre>"; print_r($posArray); echo "</pre>"; // exit;

$sql = "SELECT beacon_num From emplist ORDER by beacon_num";
//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$empArray=array();
while ($row=mysqli_fetch_array($result))
	{
	extract($row);
	$empArray[]=$beacon_num;
	}
// echo "<pre>"; print_r($empArray); echo "</pre>"; // exit;

$sql = "SELECT * From vacant_admin ORDER by beacon_num";
//echo "$sql";exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$num=mysqli_num_rows($result);
if($num>0)
	{
	while ($row=mysqli_fetch_array($result))
		{
		extract($row);
		$makeVacant[]=$beacon_num;
		}
	$vacArray=array_diff($empArray,$makeVacant);
	}
else
{$vacArray=$empArray;}

//  echo "<pre>"; print_r($vacArray); echo "</pre>"; // exit;

$vacantArray=array();
@$sortArray=$sort;
$diffArray=array_diff($posArray,$vacArray);
if($level>4)
	{
	$var=count($diffArray);
// 	 echo "diffArray = $var <pre>"; print_r($diffArray); echo "</pre>";   exit;
	}

if(empty($diffArray))
	{
	echo "Fantastic!!! No vacant positions."; exit;
	}
$show_comments="";
if($real_level>1){$show_comments=",vacant.comments";}
foreach($diffArray as $k=>$beacon_num)
	{
	$vid="";
	@$sql = "SELECT park,posTitle_reg,vid,position.beacon_num, position_desc
	$pass_field $show_comments
	From position
	LEFT JOIN vacant on vacant.beacon_num=position.beacon_num
	LEFT JOIN B0149 on vacant.beacon_num=B0149.position 
	where position.beacon_num=$beacon_num and status!='Filled'
	";
	if($beacon_num=="65035200")
		{
// 		echo "$sql";  exit;
		}
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	if($level>4)
		{
// 		echo "$sql<br />";   exit;
		}

	if(mysqli_num_rows($result)<1){continue;}
	$row=mysqli_fetch_array($result);

	extract($row);
	if($beacon_num=="65031813") // for testing purposes
		{
// 		echo "<pre>"; print_r($row); echo "</pre>";  exit;
		}
	if($vid and $beacon_num!="lost"){$vid="Being Tracked";}
	$dist="";
	$reg="";
	
	if(in_array($park,$arrayEADI)){$reg="EADI";}
	if(in_array($park,$arrayNODI)){$reg="NODI";}
	if(in_array($park,$arraySODI)){$reg="SODI";}
	if(in_array($park,$arrayWEDI)){$reg="WEDI";}
	
	if($sortArray=="park" || $sortArray=="")
		{	$sort="park";
			if($real_level>1)
			{			$vacantArray[]=$park."~".$reg."~".$beacon_num."-".$posNum."~".$position_desc."~".$vid."~".$comments."~".$chop_comments;
			}
		else
			{			@$vacantArray[]=$park."~".$reg."~".$beacon_num."-".$posNum."~".$position_desc."~".$vid."~".$comments;
			}
		}
	if(empty($comments)){$comments="";}
	if($sortArray=="pos")
	{$vacantArray[]=$beacon_num."-".$posNum."~".$park."~".$reg."~".$position_desc."~".$vid."~".$comments;}
	if($sortArray=="title")
	{$vacantArray[]=$position_desc."~".$beacon_num."-".$posNum."~".$park."~".$reg."~".$vid."~".$comments;}
	if($sortArray=="reg")
	{$vacantArray[]=$reg."~".$park."~".$position_desc."~".$beacon_num."-".$posNum."~".$vid."~".$comments;}
	if($sortArray=="comments")
	{$vacantArray[]=$comments."~".$reg."~".$beacon_num."~".$position_desc."~".$park."-".$posNum."~".$vid;}
	
	
	}// end for
sort($vacantArray);
//echo "<pre>"; print_r($vacantArray); echo "</pre>";  exit;

foreach($vacantArray as $k=>$v){
	$bn=explode("~",$v);
	$bea_num[]=substr($bn[2],0,8);
	}

$sql = "Truncate table vacant_excel";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
foreach($bea_num as $k=>$v){
	$sql="Insert into vacant_excel set beacon_num='$v'";
	$result = mysqli_query($connection,$sql);
	}

menuStuff($vacantArray,$sort,$level,$supervise_position_array,$pass_level,$real_level,$pass_position);


// *************** Display Menu FUNCTION **************
function menuStuff($vacantArray,$sort,$level,$supervise_position_array,$pass_level,$real_level,$pass_position)
	{
	$count=count($vacantArray);
	if($sort=="park")
		{
		$header="
		<th>&nbsp;</th>
		<th><a href='findVacant_dist.php?sort=park'>Park</a></th>
		<th><a href='findVacant_dist.php?sort=reg'>District</a></th>
		<th><a href='findVacant_dist.php?sort=pos'>Position<br>Number</a></th>
		<th><a href='findVacant_dist.php?sort=title'>Position Title</a></th>
		<th>Status</th>
		<th>HR Comment</th>
		";
		if($real_level>1){$header.="<th>CHOP Comment</th>";}
		$sortPrint="Park";
		}
	
	if($sort=="pos"){$header="
	<th>&nbsp;</th>
	<th><a href='findVacant_dist.php?sort=pos'>Position<br>Number</a></th>
	<th><a href='findVacant_dist.php?sort=park'>Park</a></th>
	<th><a href='findVacant_dist.php?sort=reg'>District</a></th>
	<th><a href='findVacant_dist.php?sort=title'>Position Title</a></th>";$sortPrint="Position Number";}
	
	if($sort=="title"){$header="
	<th>&nbsp;</th>
	<th><a href='findVacant_dist.php?sort=title'>Position Title</a></th>
	<th><a href='findVacant_dist.php?sort=pos'>Position<br>Number</a></th>
	<th><a href='findVacant_dist.php?sort=park'>Park</a></th>
	<th><a href='findVacant_dist.php?sort=reg'>District</a></th>";$sortPrint="Position Title";}
	
	if($sort=="reg"){$header="
	<th>&nbsp;</th>
	<th><a href='findVacant_dist.php?sort=reg'>District</a></th>
	<th><a href='findVacant_dist.php?sort=park'>Park</a></th>
	<th><a href='findVacant_dist.php?sort=title'>Position Title</a></th>
	<th><a href='findVacant_dist.php?sort=pos'>Position<br>Number</a></th>";$sortPrint="Region";}
	
	$header.="</tr>";
	
	echo "<html><head><title>Positions</title>
	
	<STYLE TYPE=\"text/css\">
	<!--
	body
	{font-family:sans-serif;background:beige}
	td
	{font-size:90%;background:beige}
	th
	{font-size:95%; vertical-align: bottom}
	--> 
	</STYLE></head>
	<body><font size='4' color='004400'>NC State Parks System Personnel Database</font>
	<br><font size='5' color='blue'>The $count Vacant Positions sorted by $sortPrint
	</font>";
	
	if($real_level>1)
		{
		echo "View as <a href='form_csv_dist.php'>spreadsheet</a>";
		}
	
	
	echo "<table border='1' cellpadding='5'><tr>";
	
	if($level>3)
		{
		echo "<tr><td align='center' colspan='6'><a href='vacant_admin.php'>Pre-vacate</a> a position.</td>";
		echo "<td>View <a href='ninety.php'>Ninety Day</a></td>";
		}
	if($level>4)
		{
		echo "<td><a href='vacate_a_position.php'>Vacate</a> a position.</td>";
		}
	echo "</tr>";
	
//	echo "$header";
	//echo "<pre>"; print_r($vacantArray); echo "</pre>";  exit;
	
	for($j=0;$j<count($vacantArray);$j++)
		{
		
		$cell=explode("~",$vacantArray[$j]);
		if(fmod($j,10)==0){echo "$header";}
		echo "<tr>";
		
		if($sort=="park")
			{
			$exPosNum=explode("-",$cell[2]);
			$ckPosition=$cell[3];
			if(in_array($exPosNum[0],$supervise_position_array))
				{$level=2;}
				else
				{$level=$pass_level;}
//				IF($_SESSION['logname']=="Anundson9926" AND $exPosNum[0]=="60032890"){$level=2;}
			if(strpos($ckPosition, "Parks Super")>-1 and $pass_position=="office a")
				{$level=1;} // Prevent Office Assist. from tracking PASU
			if($level>1)
				{
				$track="<a href='trackPosition_dist.php?beacon_num=$exPosNum[0]' target='_blank'>Track</a>";
				if($real_level>1)
					{$add_cell="<td>$cell[6]</td>";}
					else
					{$add_cell="";}
				}
				else
				{
				$track="<font color='green'>Track --></green> ";
				$add_cell="";
				}
			// $cell[3] is Position Title
			echo "<td>$track</td>
			<td align='center'>$cell[0]</td>
			<td align='center'>$cell[1]</td>
			<td>$cell[2]</td>
			<td>$cell[3]</td>
			<td>$cell[4]</td>
			<td>$cell[5]</td>
			$add_cell
			</tr>";
			}
			
		if($sort=="pos")
			{
			$exPosNum=explode("-",$cell[0]);
		//	echo "<pre>"; print_r($exPosNum); echo "</pre>";  exit;
			if($level>1)
				{			
				$track="<a href='trackPosition_dist.php?beacon_num=$exPosNum[0]' target='_blank'>Track</a>";
				}
				else
				{
				$track="<font color='green'>Track --></green>";
				}
			echo "<td>$track</td>
			<td align='center'>$cell[0]</td>
			<td align='center'>$cell[1]</td>
			<td>$cell[2]</td>
			<td>$cell[3]</td>
			<td>$cell[4]</td>
			<td>$cell[5]</td>
			</tr>";}
		
		if($sort=="title")
			{
			if($level>1){
			$exPosNum=explode("-",$cell[1]);
			$track="<a href='trackPosition_dist.php?beacon_num=$exPosNum[0]' target='_blank'>Track</a>";}else{$track="<font color='green'>Track --></green>";}
			echo "<td>$track</td>
			<td>$cell[0]</td>
			<td align='center'>$cell[1]</td>
			<td align='center'>$cell[2]</td>
			<td>$cell[3]</td>
			<td>$cell[4]</td>
			<td>$cell[5]</td>
			</tr>";
			}
		
		
		if($sort=="reg")
			{
			if($level>1){
			$exPosNum=explode("-",$cell[3]);
			$track="<a href='trackPosition_dist.php?beacon_num=$exPosNum[0]' target='_blank'>Track</a>";}else{$track="<font color='green'>Track --></green>";}
			echo "<td>$track</td>
			<td align='center'>$cell[0]</td>
			<td align='center'>$cell[1]</td>
			<td>$cell[2]</td>
			<td>$cell[3]</td>
			<td>$cell[4]</td>
			<td>$cell[5]</td>
			</tr>";
			}
		
		if($sort=="comments")
			{
			if($level>1){
			$exPosNum=explode("-",$cell[2]);
			$track="<a href='trackPosition_dist.php?beacon_num=$exPosNum[0]' target='_blank'>Track</a>";}else{$track="<font color='green'>Track --></green>";}
			echo "<td>$track</td>
			<td align='center'>$cell[0]</td>
			<td align='center'>$cell[1]</td>
			<td>$cell[2]</td>
			<td>$cell[3]</td>
			<td>$cell[4]</td>
			<td>$cell[5]</td>
			</tr>";
			}
		}
	
	}
	
if($real_level>1)
	{
		$sql = "SELECT * From find_vacant_forms ORDER by upload_date";
		//echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		while ($row=mysqli_fetch_array($result))
			{
			extract($row);
			$l=explode("/",$file_link);
			$link="<a href='$file_link'>$l[2]</a>";
			echo "<tr>
			<td>Uploaded File =></td>
			<td colspan='4'>$link</td>";
					
			if($real_level>3)
				{
				echo "<td colspan='4'>Delete <a href='findVacant_add_file?id=$id'>file</a></td>
				";
				}
			echo "</tr>";
		}
		echo "<tr><form method='post' action='findVacant_add_file.php' enctype='multipart/form-data'>
		<td align='right'></td>
		<td></td>
		<td colspan='6'>Click to select your file. 
		<input type='file' name='file_upload'  size='40'> Then click this button. 
		<input type='submit' name='submit' value='Add File'>
		</form></td></tr>";
	 }
echo "</table></body></html>";
?>
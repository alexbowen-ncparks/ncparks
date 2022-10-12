<?php
//ini_set('display_errors',1);
$database="eeid";
include("../../include/auth.inc");
include("../../include/iConnect.inc");
mysqli_select_db($connection,$database);
include("menu.php");
//print_r($_REQUEST);
//print_r($_SESSION);

extract($_REQUEST);
// Rename variable so they can be passed and not overwritten by the Find
@$categoryX=$category;
@$distX=$dist;
@$progtitleX=$progtitle;
@$presenterX=$presenter;
@$countyX=$county;
@$locationX=$location;
@$ageX=$age;
@$commentsX=$comments;
@$resourcesX=$resources;

date_default_timezone_set('America/New_York');

if(@$Submit)
	{
	$display_number = $display;
	
	if($location){$where="mark !='x' and location = '$location'";}
	else
	{$where="mark !='x'";}
	
	if(isset($parkX)){$park=$parkX;}
	if(@$park)
		{
		//$a1=$park;// used to pass var if orderx = Lepidoptera
		$where .=" and park='$park'";
		$parkX=$park;
		}
	
	if(@$dateprogramE)
		{
		if(@$dateprogramS)
			{
			$where .=" and (dateprogram >= '$dateprogramS' and dateprogram <= '$dateprogramE')";
			}
		}
	else
		{
		if(@$dateprogramS)
			{
			$d=explode("-",$dateprogramS);
			if(@checkdate ($d[1], $d[2], $d[0]))
				{
				$where .=" and dateprogram = '$dateprogramS'";
				}
			else
				{
				if(@$d[1]<1)
					{$dateprogramS=$d[0];}
					else
					{
					$monthPad=str_pad($d[1], 2, "0", STR_PAD_LEFT);
					$dateprogramS=$d[0]."-".$monthPad;
					}
				$where .=" and dateprogram LIKE '$dateprogramS%'";
				}
			}
		}
	
	if($category){
	$where .=" and category = '$category'";}
	if($county){
	$where .=" and county = '$county'";}
	if(@$dist){
	$where .=" and dist = '$dist'";}
	
	if($presenter){
	$where .=" and presenter LIKE '%$presenter%'";}
	if($comments){
	$where .=" and comments LIKE '%$comments%'";}
	if($resources){
	$where .=" and resources LIKE '%$resources%'";}
	if($progtitle){
	$where .=" and progtitle LIKE '%$progtitle%'";}
	if($age){
	$where .=" and age = '$age'";}
	
	if($where=="mark !='x'" || $where=="mark !='x' and location = '$location'"){
	echo "<br>You must pick at least one criterium in addition to Location.";
	exit;}
	else
		{
		// If we don't know how many pages there are, make that calculation.
		if (!isset($num_pages))
			{
			$sql="SELECT * FROM eedata
			WHERE $where";
			
			//echo "$sql"; //exit;
			$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
			
			$numrow = mysqli_num_rows($result);
			
				// Calculate the number of pages required.
			$t=$numrow;
				if ($numrow > $display_number)
					{
						$num_pages = ceil ($numrow/$display_number);
					}
					elseif ($numrow > 0)
						{
						$num_pages = 1;
						}
				else
				{
				if(!isset($dateprogram)){$dateprogram="";}
				if(!isset($dist)){$dist="";}
				echo "<font color='red'>No record found using this search:</font> $park $category $county $dist $location $presenter $comments $resources $progtitle $dateprogram<hr>$sql";
			//echo "<br>$sql";
				}
				
				$start = 0; // Currently at item 0.
			}// end if !isset
		
		$sql="SELECT * FROM eedata
		WHERE $where 
		ORDER BY dist, park, dateprogram DESC, category
		LIMIT $start, $display_number";
		 
		$result = @mysqli_query($connection,$sql) or die("$sql Error 2#". mysqli_errno($connection) . ": " . mysqli_error($connection));
//		 echo "$sql";
		
		$numrow = mysqli_num_rows($result);
		} // end else where=="mark !='x'
	
	//*******************
	if($numrow>1){$p="records";}else{$p="record";}
	if(!isset($park)){$park="";}
	if(!isset($dist)){$dist="";}
	if(!isset($t)){$t="";}
	if(!isset($dateprogram)){$dateprogram="";}
	echo "<htm><head><title></title></head>
	<body>
	<table>
	<tr><td colspan='5'>$numrow $p shown of $t $p found using: $park $category $county $dist $location $presenter $comments $resources $progtitle $dateprogram</td></tr>
	</table>
	<hr>
	<table border='1' cellpadding='5'><tr><th>Dist.</th><th>County</th><th>Park</th><th>Date</th><th>Category</th><th>Title</th><th>Presenter</th><th>Location</th><th>Audience</th><th>Given</th><th>Attendance</th><th>Comments</th><th>Resources</th></tr>";
	
	while ($row = mysqli_fetch_array($result))
		{
		extract($row);
		if(!$progtitle){$progtitle="Edit/Delete this record";}
		echo "
		<tr><td>$dist</td>
		<td>$county</td><td>$park</td><td>$dateprogram</td><td>$category</td>
		<td><a href='edit.php?submit=Edit Record&eeid=$eeid&e=1'>$progtitle</a></td>
		<td>$presenter</td><td>$location</td><td>$age</td><td>$timegiven</td>
		<td>$attend</td><td>$comments</td><td>$resources</td></tr>";
		}
	echo "<table align='center'>";
	if (@$num_pages > 1)
		{
		if(!isset($parkX)){$parkX="";}
		
			echo "<tr align='center'>
				<td align='center' colspan='2'>";
				
			// Determine what page the script is on.	
			if ($start == 0) {
				$current_page = 1;
			} else {
				$current_page = ($start/$display_number) + 1;
			}
		// Set the variables for other page Links
			$baseLink="<a href=\"search.php?";
			$numPageLink="&num_pages=".$num_pages;
			$parkLink="&park=".$parkX;
			$categoryLink="&category=".$categoryX;
			$countyLink="&county=".$countyX;
			if(@$dateprogramS)
				{
				$dateProgStartLink="&dateprogramS=".$dateprogramS;
				}
			if(@$dateprogramE)
				{
				$dateProgEndLink="&dateprogramE=".$dateprogramE;
				}
			$distLink="&dist=".$distX;
			$locationLink="&location=".$locationX;
			$progTitleLink="&progtitle=".$progtitleX;// like
			$presenterLink="&presenter=".$presenterX;// like
			$audienceLink="&age=".$ageX;
			$commentLink="&comments=".$commentsX;// like
			$resourcesLink="&resources=".$resourcesX;// like
			$displayLink="&display=".$display;
			
			// If it's not the first page, make a Previous button.
			if ($start != 0) {
			$startLink="start=".($start - $display_number);
			$submitLink="&Submit=1\">Previous</a> ";
			
		@$previousLink=$baseLink.$startLink.$numPageLink.$parkLink.$categoryLink.$countyLink.$dateProgStartLink.$dateProgEndLink.$distLink.$locationLink.$progTitleLink.$presenterLink.$audienceLink.$commentLink.$resourcesLink.$displayLink.$submitLink;
		echo "$previousLink";
			}
		
			// Make all the numbered pages.
			for ($i = 1; $i <= $num_pages; $i++) {
			//	$next_start = $start + $display_number;
			$startLink="start=".($display_number * ($i - 1));
			$submitLink="&Submit=1\">$i</a> ";
			
			if($i<($current_page+10) and $i>($current_page-10)){
			
				if ($i != $current_page) { // Don't link the current page.
						
		@$numLink=$baseLink.$startLink.$numPageLink.$parkLink.$categoryLink.$countyLink.$dateProgStartLink.$dateProgEndLink.$distLink.$locationLink.$progTitleLink.$presenterLink.$audienceLink.$commentLink.$resourcesLink.$displayLink.$submitLink;
		
		echo "$numLink";
		
				} else {
					echo $i . ' ';
				}
			}
		}	
			// If it's not the last page, make a Next button.
			if ($current_page != $num_pages) {
			$startLink="start=".($start + $display_number);
			$submitLink="&Submit=1\">Next</a> ";
					
		@$nextLink=$baseLink.$startLink.$numPageLink.$parkLink.$categoryLink.$countyLink.$dateProgStartLink.$dateProgEndLink.$distLink.$locationLink.$progTitleLink.$presenterLink.$audienceLink.$commentLink.$resourcesLink.$displayLink.$submitLink;
		echo "$nextLink";
			}
			
			echo '</td>
			</tr>';
		}
	echo "</table></body></html>";
	exit;
	//	}// end else
	}// end $Submit

// **********************


?>

<html>
<head>
<title>Search EEID</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#CCCCCC">
<form method="post" action="search.php">
  <p align="center"><font size="5" color="#336633"><b><font color="#630B17">EEID Search Page</font></b></font></p>
  <table width="63%">
    <tr> 
      <td width="18%" align="right"> 
        <b>Park:</b>
      </td>
      <td width="20%" colspan="4"> 

<?php
include("../../include/get_parkcodes_reg.php");;
$parkCode[]="ARCH";
$parkCode[]="YORK";
sort($parkCode);
$district['ARCH']="STWD";
$district['YORK']="STWD";
$parkCodeName['ARCH']="Statewide";
$parkCodeName['YORK']="Yorkshire Center";
$i="";
echo "<select name=\"parkX\"><option selected=''></option>";
if(!isset($parkC)){$parkC="";}
foreach($parkCode as $num=>$park_code)
	{
	if($park_code==$parkC)
		{$v="selected";}else{$v="value";}
		 echo "<option $v=\"$park_code\">$park_code</option>";
	}

echo "</select>\n</td></tr><tr><td align='right'><b>Category: </b></td><td colspan='6'>";

$catArray  = array('', '1 --> Component I Workshop, EE Certification', '2 --> Other I&E Workshop/Training', '3 --> EELE Program', '4 --> Other Structured EE or Inter. Program', '5 --> Events/Organizations hosted by park', '6 --> Short orientations & spontaneous Inter.', '7 --> Exhibits Outreach', '8 --> Jr. Ranger Program');
$arrayNum = count($catArray);

echo "<select name=\"category\">\n";
foreach($catArray as $num=>$cat)
	{
	if(@$category == $num)
		{$ck="selected";}else{$ck="value";}
		 echo "<option $ck=\"$num\">$cat</option>";
	}
echo "</select>\n
  </td></tr>
  
<tr><td align='right'><b>District: </b></td>
<td><input type='radio' name='dist' value='EADI'>East
<input type='radio' name='dist' value='NODI'>North
<input type='radio' name='dist' value='SODI'>South
<input type='radio' name='dist' value='WEDI'>West</td>";
?>
    </tr>
   
    <tr> 
      <td width="18%" align="right"> 
      <b>County:</b>
      </td>
      <td width="21%" colspan='2'> 
        <input type="text" name="county" size="15">
      </td>
    </tr>
    <tr> 
      <td width="18%" align="right"> 
      <b>~ Program Date:</b>
      </td>
      <td width="21%" colspan='2'> 
        <input type="text" name="dateprogramS" size="15">
      <input type="text" name="dateprogramE" size="15">
      </td>
    </tr>
    <tr> 
      <td width="18%" align="right"> 
      <b>*Program Title:</b>
      </td>
      <td width="71%"> 
        <input type="text" name="progtitle" size="40">
      </td>
    </tr>
    
    <tr> 
      <td width="18%" align="right"> 
      <b>*Presenter:</b>
      </td>
      <td width="71%"> 
        <input type="text" name="presenter" size="40">
      </td>
    </tr>
    <tr><td align='right'><b>Location: </b></td>
<td><input type='radio' name='location' value='Park'>Park
<input type='radio' name='location' value='Outreach'>Outreach
<input type='radio' name='location' value='' checked>Both
</td></tr>
    <tr> 
    <tr><td align='right'><b>Audience: </b></td>
<td><input type='radio' name='age' value='school'>School-age
<input type='radio' name='age' value='adult'>Adults
<input type='radio' name='age' value='public'>General Public
<input type='radio' name='age' value='' checked>Everybody
</td></tr>
    <tr> 
      <td width="18%" align="right"> 
      <b>*Comment:</b>
      </td>
      <td width="71%"> 
        <input type="text" name="comments" size="45">
      </td>
    </tr>
    <tr> 
      <td width="18%" align="right"> 
      <b>*Resources:</b>
      </td>
      <td width="71%"> 
        <input type="text" name="resources" size="45">
      </td>
    </tr>
    <tr> 
      <td width="18%" align="right"> 
      
      </td>
      <td width="71%"> 
        <input type="text" name="display" value="50" size="5"> <b>Number of Records to Display per page</b>
      </td>
    </tr>
  </table>
  <p> 
    <input type="reset" name="Reset" value="Clear Form">
    &nbsp; &nbsp; 
    <input type="submit" name="Submit" value="Submit Query">  </p>
  </form>
<p><b>~ Options for searching dates.</b><br>
1. For a specific date enter YYYY-M-D in first box. e.g., 2004-7-12<br>
2. For a specific year and month enter YYYY-M in first box. e.g., 2004-7<br>
3. For a range of dates enter start date in first box and end date in second. e.g., 2004-7-1  to  2005-6-30<br>
</p>
<p><b>*Partial search terms are acceptable.</b><br>
You could enter any letter(s) of a word contained in either the Program Title, Presenter, Comment or Resources.</p>
</body>
</html>

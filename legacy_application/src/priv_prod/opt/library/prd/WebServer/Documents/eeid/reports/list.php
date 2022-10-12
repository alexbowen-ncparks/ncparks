<?php
//ini_set('display_errors',1);
$database="eeid";
include("../../../include/auth.inc");
include("../../../include/iConnect.inc");
include("../menu.php");
date_default_timezone_set('America/New_York');
// echo "<pre>";print_r($_REQUEST);echo "</pre>";
//echo "<pre>";print_r($_SESSION);echo "</pre>";

if($_SESSION['eeid']['level']<2)
	{$defaultPark=$_SESSION['eeid']['parkS'];}
	else
	{$defaultPark="";}

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

$catArray  = array('', '1 --> Component I Workshop, EE Certification', '2 --> Other I&E Workshop/Training', '3 --> EELE Program', '4 --> Other Structured EE or Inter. Program', '5 --> Events/Organizations hosted by park', '6 --> Short orientations & spontaneous Inter.', '7 --> Exhibits Outreach', '8 --> Jr. Ranger Program');

if(@$Submit)
	{
	
	if($location){$where="mark !='x' and location = '$location'";}
	else
	{$where="mark !='x'";}
	
	if($parkX){$park=$parkX;}
	if(@$park)
		{
		//$a1=$park;// used to pass var if orderx = Lepidoptera
		$where .=" and park='$park'";
		$parkX=$park;
		}
	
	if($dateprogramE)
	{
	if($dateprogramS)
		{
		$where .=" and (dateprogram >= '$dateprogramS' and dateprogram <= '$dateprogramE')";
		}
	}
	else
	{
	if($dateprogramS)
		{
		$d=explode("-",$dateprogramS);
		$ck1=@$d[1];
		$ck2=@$d[2];
		$ck3=@$d[0];
		if(checkdate ( $ck1, $ck2, $ck3))
			{
			$where .=" and dateprogram = '$dateprogramS'";
			}
		else
			{
			if(@$d[1]<1)
				{
				$dateprogramS=@$d[0];
				}
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
	
//A modification suggestion to prevent SQL injection:
        // *********** Group by **********
      //   if (isset($_REQUEST["gb1"]) && is_array($_REQUEST["gb1"]) && count($_REQUEST["gb1"]) > 0) {
//             echo "<br>Debug gb1";
//             print_r($_REQUEST["gb1"]);
//         }
        // Allow only lowercase letters in the parameter (quick fix for injection)
        if (!preg_match("/^[a-z]*$/",$gb1[0])) { unset($gb1); }
        if (!preg_match("/^[a-z]*$/",$gb2[0])) { unset($gb2); }
        if (!preg_match("/^[a-z]*$/",$gb3[0])) { unset($gb3); }
        //echo "<br>Debug groupby - GB1: ".$gb1[0]."<br>GB2: ".$gb2[0]."<br>GB3: ".$gb3[0];}

        unset($groupby);
        unset($displayFields);
	
 // For this type of radio array there will be only one item per radio
        // group name, so no need to loop through array.
        if (isset($gb1[0])) {
          $displayFields=$gb1[0];
          $groupby="GROUP BY ".$gb1[0];
        }
        if (isset($gb2[0])) {
          if (isset($displayFields)) {
            $displayFields.=","; // only add comma if needed
            $groupby.=",";       // to prevent SQL error
          }
          $displayFields.=$gb2[0];
          $groupby.=$gb2[0];
        }
        if (isset($gb3[0])) {
          if (isset($displayFields)) {
            $displayFields.=",";
            $groupby.=",";
          }
          $displayFields.=$gb3[0];
          $groupby.=$gb3[0];
        }
	
// 	echo "d=$displayFields<br />$groupby<br />";  //exit;
	if($n1<1){
	if($where=="mark !='x'" || $where=="mark !='x' and location = '$location'"){
	echo "<br>You must pick at least one criterium in addition to Location.";
	exit;}
	}
	
	if(@!$displayFields)
		{
		$defaultFields="park,presenter,progtitle,dateprogram,timegiven,attend";
		$displayFields="";
		$maxFields="";
		}
	else
		{
		$defaultFields="";
		$maxFields=", sum(timegiven) as given, sum(attend) as attend";
		}
	
	if(@$Xrov){$where.=" and category != '6'";}
	
	mysqli_select_db($connection,$database);
	$sql="SELECT $displayFields $defaultFields $maxFields FROM eedata
	WHERE $where 
	$groupby
	ORDER BY $displayFields $defaultFields
	";
	 
	$result = @mysqli_query($connection,$sql) or die();
	
// 	 echo "$sql";
	
	$numrow = mysqli_num_rows($result);
	
	
	//*******************
	if($numrow>1){$p="records";}else{$p="record";}
	
	$using="";
	if(@$park){$using="Park=$park";}
	if($category)
		{
		@$using.="[Category=".$catArray[$category]."]<br />";
		}
	if($county){$using.="[County=$county] ";}
	if(@$dist){$using.="[Dist=$dist] ";}
	if($location){$using.="[Location=$location] ";}
	if($presenter){$using.="[Presenter like $presenter] ";}
	if($progtitle){$using.="[Title like $progtitle] ";}
	if(@$dateprogram){$using.="[Dateprogram=$dateprogram] ";}
	if($using==""){$using="All Records";}
	
	if($displayFields){$d=$displayFields;}else{$d=$defaultFields;}
	$arrayHead=explode(",",$d);
	$ahc=count($arrayHead);
	for($j=0;$j<$ahc;$j++)
		{
		@$header.="<td>$arrayHead[$j]</td>";
		}
	
	$using=stripslashes($using);
	echo "<htm><head><title></title></head>
	<body>
	<table align='center'>
	<tr><td colspan='5'>Report based on: <b>$using</b>";
	if($groupby){echo " and <b>$groupby</b>";}
	if(@$Xrov){echo " and <b>Cat 6 excluded</b>";}
	echo "</td></tr>
	</table>
	<hr>
	<table border='1' cellpadding='5' align='center'><tr>";
	
	if($ahc>1)
		{
		$addHeader="<th>Running Total<br>Times Given</th><th>Running Total<br>Attendance</th>";
		}
	if($displayFields)
		{
		if(!isset($addHeader)){$addHeader="";}
		echo "$header<th>Times Given</th><th>Attendance</th>
		$addHeader</tr>";
		}
		else
		{
		if(isset($header)){echo "$header";}
		}
	
	$i=0;
	while ($row = mysqli_fetch_array($result))
		{
		extract($row);
		if(@$varSub==${$arrayHead[0]})
			{$subX="1";}
			else
			{$subGiven="";$subAttend="";}
		
		// Load display variable
		$i++;
		$cell="<td>$i</td>";
		for($k=0;$k<$ahc;$k++){
		$display=${$arrayHead[$k]};
		$cell.="<td>$display</td>";
		}
		
		$varSub=${$arrayHead[0]};
		
		@$totGiven=$totGiven+$given;
		@$totGivenNoGroup=$totGivenNoGroup+$timegiven;
		@$subGiven=$subGiven+$given;
		@$totAttend=$totAttend+$attend;
		@$subAttend=$subAttend+$attend;
		@$given=number_format($given);
		@$attend=number_format($attend);
		$subGivenF=number_format($subGiven);
		$subAttendF=number_format($subAttend);
		
		// Echo display variable depending on whether Groupby is in play
		// Check subTotals
		if(@$subX=="1"){$showSub="<td align='right'>$subGivenF</td><td align='right'>$subAttendF $varSub</td>";}else{$showSub="";}
		
		// Display
		if($displayFields){echo "<tr>$cell
		<td align='right'>$given</td><td align='right'>$attend</td>$showSub</tr>";}
		else{echo "<tr>$cell</tr>";}
		$subX="";
		}// end while
	
	// Load Final Totals variable
	$cell="<td></td>";
	for($k=0;$k<$ahc;$k++)
		{
		$display="";
		if($arrayHead[$k]=="timegiven")
			{
// 			if($category==6)
// 				{$totGivenNoGroup=$numrow;}
			@$display="Num programs: ".$totGivenNoGroup;
			}
		if($arrayHead[$k]=="attend")
			{@$display=number_format($totAttend);}
		
		$cell.="<td align='right'>$display</td>";
		}
	
	// Echo Final Totals depending on whether Groupby is in play
	if($displayFields){// in play
	$totGiven=number_format($totGiven);
	$totAttend=number_format($totAttend);
	echo "<tr>$cell
	<td align='right'>$totGiven</td><td align='right'>$totAttend</td></tr>";}
	else{// not in play
	echo "<tr>$cell</tr>";}
	
	echo "</table></body></html>";
	exit;
	}// end $Submit

// **********************

?>

<html>
<head>
<title>Search EEID</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#CCCCCC">
<form method="post" action="list.php">
  <p align="center"><font size="5" color="#336633"><b><font color="#630B17">EEID Reports Page</font></b></font></p>
  <table align='center'>
  <tr><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;1st 2nd 3rd</td></tr>
    <tr><td>Group by:
    <input type='radio' name='gb1[]' value='park'>
    <input type='radio' name='gb2[]' value='park'>
    <input type='radio' name='gb3[]' value='park'></td>
      <td align="right"> 
        <b>Park:</b>
      </td>
      

<?php
include("../../../include/get_parkcodes_i.php");

echo "<td><select name=\"parkX\"><option selected=''></option>";
foreach($parkCode as $num=>$park_code)
	{
	if($park_code==$defaultPark){$v="selected";}else{$v="value";}
		 echo "<option $v=\"$park_code\">$park_code</option>";
	}

echo "</select></td>
</tr>

<tr><td>Group by:
<input type='radio' name='gb1[]' value='category'>
<input type='radio' name='gb2[]' value='category'>
<input type='radio' name='gb3[]' value='category'>
</td><td align='right'><b>Category: </b></td><td>";

$arrayNum = count($catArray);

echo "<select name=\"category\">";
foreach($catArray as $num=>$title)
	{
	if(@$category == $num){$ck="selected";}else{$ck="value";}
		 echo "<option $ck=\"$num\">$title</option>";
	}
echo "</select>\n
 Exclude Cat 6:<input type='checkbox' name='Xrov' value='x'></td></tr>
  
<tr><td>Group by:
<input type='radio' name='gb1[]' value='dist'>
<input type='radio' name='gb2[]' value='dist'>
<input type='radio' name='gb3[]' value='dist'>
</td><td align='right'><b>District: </b></td>
<td><input type='radio' name='dist' value='EADI'>East
<input type='radio' name='dist' value='NODI'>North
<input type='radio' name='dist' value='SODI'>South
<input type='radio' name='dist' value='WEDI'>West</td>
";
?>
    </tr>
   
    <tr><td>Group by:
    <input type='radio' name='gb1[]' value='county'>
    <input type='radio' name='gb2[]' value='county'>
    <input type='radio' name='gb3[]' value='county'>
    </td> 
      <td align="right"> 
      <b>County:</b>
      </td>
      <td> 
        <input type="text" name="county" size="15">
      </td>
    </tr>
    <tr><td>Group by:
    <input type='radio' name='gb1[]' value='dateprogram'>
    <input type='radio' name='gb2[]' value='dateprogram'>
    <input type='radio' name='gb3[]' value='dateprogram'>
    </td> 
      <td align="right"> 
      <b>~ Program Date:</b>
      </td>
      <td>
<?php
$firstDate=(date("Y"))."-01-01";
$firstDate_fy=(date("Y")-1)."-07-01";
$secDate_fy=date("Y")."-06-31";
$secDate=date("Y-m-d");
echo "<input type=\"text\" name=\"dateprogramS\" size=\"15\" value=\"$firstDate\">
      <input type=\"text\" name=\"dateprogramE\" size=\"15\" value=\"$secDate\">
      </td>";
?>
    </tr>
    <tr><td>Group by:
    <input type='radio' name='gb1[]' value='progtitle'>
    <input type='radio' name='gb2[]' value='progtitle'>
    <input type='radio' name='gb3[]' value='progtitle'>
    </td> 
      <td align="right"> 
      <b>*Program Title:</b>
      </td>
      <td> 
        <input type="text" name="progtitle" size="40">
      </td>
    </tr>
    
    <tr><td>Group by:
    <input type='radio' name='gb1[]' value='presenter'>
    <input type='radio' name='gb2[]' value='presenter'>
    <input type='radio' name='gb3[]' value='presenter'>
    </td> 
      <td align="right"> 
      <b>*Presenter:</b>
      </td>
      <td> 
        <input type="text" name="presenter" size="40">
      </td>
    </tr>
    <tr><td>Group by:
    <input type='radio' name='gb1[]' value='location'>
    <input type='radio' name='gb2[]' value='location'>
    <input type='radio' name='gb3[]' value='location'>
    </td><td align='right'><b>Location: </b></td>
<td><input type='radio' name='location' value='Park'>Park
<input type='radio' name='location' value='Outreach'>Outreach
<input type='radio' name='location' value='' checked>Both
</td></tr>
    <tr> 
    <tr><td>Group by:
    <input type='radio' name='gb1[]' value='age'>
    <input type='radio' name='gb2[]' value='age'>
    <input type='radio' name='gb3[]' value='age'>
    </td><td align='right'><b>Audience: </b></td>
<td><input type='radio' name='age' value='school'>School-age
<input type='radio' name='age' value='adult'>Adults
<input type='radio' name='age' value='public'>General Public
<input type='radio' name='age' value='' checked>Everybody
</td></tr>
    <tr><td></td>
      <td align="right"> 
      <b>*Comment:</b>
      </td>
      <td> 
        <input type="text" name="comments" size="45">
      </td>
    </tr>
    <tr><td></td> 
      <td align="right"> 
      <b>*Resources:</b>
      </td>
      <td> 
        <input type="text" name="resources" size="45">
      </td>
    </tr>
  </table>
<table align='center'><tr><td>
    <input type="reset" name="Reset" value="Clear Form">
    &nbsp; &nbsp;</td><td>
    <input type="submit" name="Submit" value="Submit Query">
  </form></td></tr></table>
<table><tr><td><b>~ Options for searching dates.</b><br>
1. For a specific date enter YYYY-M-D in first box. e.g., 2004-7-12<br>
2. For a specific year and month enter YYYY-M in first box. e.g., 2004-7<br>
3. For a range of dates enter start date in first box and end date in second. e.g., 2004-7-1  to  2005-6-30</td></tr>
<tr><td>
<b>*Partial search terms are acceptable.</b><br>
You could enter any letter(s) of a word contained in either the Program Title, Presenter, Comment or Resources.</td></tr></table>
</body>
</html>

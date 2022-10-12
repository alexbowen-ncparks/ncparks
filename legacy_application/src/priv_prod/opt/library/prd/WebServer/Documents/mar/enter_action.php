<?php
ini_set('display_errors',1);
$database="mar";
date_default_timezone_set('America/New_York');

// Also in enter.php
include("sections_array.php");
// $sections=array("zI&E"=>"Interpretation and Education","zE&C"=>"Engineering and Construction","zG&O"=>"Grants and Outreach","zP&NR"=>"Planning and Natural Resources Management","zLAND"=>"Land Acquisition","zTRAILS"=>"State Trails Program","zCONC"=>"Concessions","zP&W"=>"Publication and Web Development","zMARK"=>"Marketing");
// asort($sections);

$db="mar";
include("../../include/iConnect.inc"); // database connection parameters

// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

include("../../include/get_parkcodes_reg.php"); // database connection parameters

	
$db="mar";
$db = mysqli_select_db($connection,$database)       or die ("Couldn't select database");

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
//************ FORM ****************
//TABLE
$TABLE="enter";

// *********** INSERT *************
IF(!empty($_POST))
	{
// echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  exit;
	if($submit=="Delete")
		{	
		$sql="DELETE FROM enter where id='$edit'"; //echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
		header("Location: main.php");
		exit;
		}
		
		

// 	echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  //exit;
	if(!empty($_POST['park']))
		{$sess_park=$_POST['park'];}

	$chr_map = array(
   // Windows codepage 1252
   "\xC2\x82" => "'", // U+0082⇒U+201A single low-9 quotation mark
   "\xC2\x84" => '"', // U+0084⇒U+201E double low-9 quotation mark
   "\xC2\x8B" => "'", // U+008B⇒U+2039 single left-pointing angle quotation mark
   "\xC2\x91" => "'", // U+0091⇒U+2018 left single quotation mark
   "\xC2\x92" => "'", // U+0092⇒U+2019 right single quotation mark
   "\xC2\x93" => '"', // U+0093⇒U+201C left double quotation mark
   "\xC2\x94" => '"', // U+0094⇒U+201D right double quotation mark
   "\xC2\x9B" => "'", // U+009B⇒U+203A single right-pointing angle quotation mark

   // Regular Unicode     // U+0022 quotation mark (")
                          // U+0027 apostrophe     (')
   "\xC2\xAB"     => '"', // U+00AB left-pointing double angle quotation mark
   "\xC2\xBB"     => '"', // U+00BB right-pointing double angle quotation mark
   "\xE2\x80\x98" => "'", // U+2018 left single quotation mark
   "\xE2\x80\x99" => "'", // U+2019 right single quotation mark
   "\xE2\x80\x9A" => "'", // U+201A single low-9 quotation mark
   "\xE2\x80\x9B" => "'", // U+201B single high-reversed-9 quotation mark
   "\xE2\x80\x9C" => '"', // U+201C left double quotation mark
   "\xE2\x80\x9D" => '"', // U+201D right double quotation mark
   "\xE2\x80\x9E" => '"', // U+201E double low-9 quotation mark
   "\xE2\x80\x9F" => '"', // U+201F double high-reversed-9 quotation mark
   "\xE2\x80\xB9" => "'", // U+2039 single left-pointing angle quotation mark
   "\xE2\x80\xBA" => "'", // U+203A single right-pointing angle quotation mark
);
$chr = array_keys  ($chr_map); // but: for efficiency you should
$rpl = array_values($chr_map); // pre-calculate these two arrays
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	$skip=array("attachment_num","website");
	foreach($_POST as $k=>$v)
		{
		if(in_array($k,$skip)){continue;}
		if(empty($v))
			{
			$error[]=$k;
			continue;
			}
		if($k!="submit")
			{
$v = str_replace($chr, $rpl, html_entity_decode($v, ENT_QUOTES, "UTF-8"));
if(strpos($v, "'")>0 and strpos($v, "\\'")==FALSE)
	{$v = str_replace("'","\'", $v);}

			@$string.="$k='$v', ";
			}
			else
			{
			if($v=="Submit")
				{$verb="INSERT"; $where="";}
				else
				{
				$verb="UPDATE";
				$where="where id='$edit'";
				}
			}
		}
	$string=trim($string,", ");

	if(empty($error))
		{
//	echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;
		$sql="$verb $TABLE SET $string $where"; 
// 		echo "$sql";exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query Update. $sql ".mysqli_error($connection));
		
		if($verb=="INSERT")
			{
			$id=mysqli_insert_id($connection);
			}
			else
			{$id=$edit;}
		
// 		IF($_FILES['file_upload_photo']['error']=="image/jpeg")
// 			{INCLUDE("img_magic.php");}
// 		IF($_FILES['file_upload_file']['type']==0)
// 			{INCLUDE("file_upload.php");}
		
		
		
		header("Location: main.php?sort=date desc, park");
		}
		else
		{
// 		echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
		echo "Record was not entered. You must include:<br />";
		foreach($error as $k=>$v)
			{
			echo "<font color='red'>$v</font><br />";
			}
		}
	}

include_once("_base_top_mar.php");// includes session_start();
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$sess_park=$_SESSION['mar']['select'];
$sess_sect=$_SESSION['mar']['sect_prog'];
if(isset($_SESSION['mar']['accessPark']))
	{
	$accessPark_array=explode(",",$_SESSION['mar']['accessPark']);
	}
	else
	{$accessPark_array=array();}

$level=$_SESSION['mar']['level'];

if($level<2)
	{
	$sess_park=$_SESSION['mar']['select'];
	
	}

if(empty($park))
	{
	$park=$sess_park;
	}
foreach($parkCode as $k=>$v)
	{
	$new_parkCode[$v]=$v;
	}

if($level==2)
	{
	if(empty($_SESSION[$database]['selectR'])){$_SESSION[$database]['selectR']=$_SESSION[$database]['select'];}
	$parkCode=${"array".$_SESSION[$database]['selectR']};	
	foreach($parkCode as $k=>$v)
		{
		$temp[$v]=$v;
		}
	$parkCode=$temp;
	$sess_park=$_SESSION[$database]['selectR'];
	}
	
if($level==3)
	{
	$parkCode=$sections;
	}
	
if($level>3)
	{
	$TEMP=array_merge($new_parkCode,$sections);
	$parkCode=$TEMP;
	}


// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM  $TABLE"; //echo "$sql";
$result = @MYSQLI_QUERY($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$allFields[]=$row['Field'];
	$allTypes[]=$row['Type'];
	if(strpos($row['Type'],"decimal")>-1){
		$decimalFields[]=$row['Field'];
		$tempVar=explode(",",$row['Type']);
		$decPoint[$row['Field']]=trim($tempVar[1],")");
		}
	if(strpos($row['Type'],"char")>-1 || strpos($row['Type'],"varchar")>-1){
		$charFields[]=$row['Field'];
		$tempVar=explode("(",$row['Type']);
		$charNum[$row['Field']]=trim($tempVar[1],")");
		}
	if(strpos($row['Type'],"text")>-1){
		$textFields[]=$row['Field'];
		}
	}
//print_r($charNum);

// ******** Show Form here **********
include("nav.php");

$exclude=array("id","time_stamp");
$rename=array("tempID"=>"Submitted by","comment"=>"Activity","website"=>"Web link","park"=>"Park / Section");

$include=array_diff($allFields,$exclude);
// echo "<pre>";print_r($allFields); print_r($include);echo "</pre>";
		
echo "<table border='1' align='center' cellpadding='2' bgcolor='#c2c2a3'>";
echo "<tr><th colspan='2'>Contribute to the State Park Monthly Activity Report</th></tr>";
echo "<form method='POST' enctype='multipart/form-data'>";

if(!empty($_GET["edit"]))
	{
	$id=$_GET['edit'];
	$enter_id=$id;
	
// 	, t2.file_link, t2.file_name
// 	LEFT JOIN enter_upload_file as t2 on t1.id=t2.enter_id_file
	$sql="SELECT t1.*
	FROM  enter as t1 
	where t1.id='$id'"; 
// 	echo "$sql<br />";
	$result = @MYSQLI_QUERY($connection,$sql);
	$row=mysqli_fetch_assoc($result);
	extract($row);  //print_r($row);
	$sess_park=$park;
	}

// echo "<pre>"; print_r($row); echo "</pre>"; // exit;

foreach($include as $k=>$v)
	{
	if($v=="website"){continue;}
	$type=$allTypes[$k];
	if(array_key_exists($v,$rename))
		{$r=$rename[$v];}else{$r=$v;}
	$r=strtoupper(str_replace("_"," ",$r));
//	$value="";
	if(!empty($id))
		{$value=${$v};}
		else
		{
		
		@$value=$_POST[$v];
		if($v=="comment")
			{
			$order   = array("\\r\\n", "\\n", "\\r");
			$replace = "
";
			$value=str_replace($order, $replace, $value);
			}
		}
		
		
	if(in_array($v,$charFields))
		{$size=$charNum[$v];}
		else
		{$size=10;}
	
	if($v=="title"){$size=100;}
	if($v=="website"){$size=100;}
	
	$display="<tr><th align='right'>$r</th><td align='left'><input type='text' name='$v' value=\"$value\" size='$size'></td></tr>";
	if($type=="text")
		{
		$len=strlen($value);
		if($len==0)
			{$rows=15;}
			else
			{$rows=$len/100;}
		
		$display="<tr><th align='right'>$r</th><td><textarea name='$v' cols='140' rows='$rows'>$value</textarea></td></tr>";
		}
		
	if($type=="date")
		{
		
// 		if ($value >= strtotime("today"))
//         echo "Today";
//     else if ($value <= strtotime("- 5 days"))
//         echo "Yesterday";
		$today=date("Y-m-d");
		$date1 = new DateTime($today);
		$date2 = new DateTime($value);

		$diff = $date2->diff($date1)->format("%a");
		if($diff>31)
			{$no_change=1;}
			else
			{$no_change="";}
		$display="<tr><th align='right'>$r</th><td align='left'><input type='text' id='datepicker1' name='date' value=\"$value\"></td></tr>";
		}
		
	if($v=="tempID")
		{
		$value=$_SESSION['mar']['tempID'];
		$val=substr($_SESSION['mar']['tempID'],0,-4)." - ".$sess_sect;
		$display="<tr><th align='right'>$r</th>
		<td align='left'>
		$val
		<input type='hidden' name='$v' value=\"$value\" size='$size' READONLY>
		</td></tr>";
		}
	if($v=="park")
		{
// 		echo "<pre>"; print_r($parkCode); echo "</pre>"; // exit;
		if($level==1)
			{
			$parkCode=array($sess_park=>$sess_park);
			
			if(!empty($accessPark_array))
				{
				foreach($accessPark_array as $k1=>$v1)
					{
					$parkCode[$v1]=$v1;
					}
				}
			if($sess_park=="ARCH" or array_key_exists($sess_park, $sections))
				{
				$parkCode=$sections;
				}
// 			echo "<pre>"; print_r($parkCode); echo "</pre>"; // exit;
			}
// 			echo "$sess_park $park";
		$display="<tr><th align='right'>$r</th><td align='left'><select name='$v'><option selected=''></option>\n";
		foreach($parkCode as $pc=>$pv)
			{
			$test=substr($pc,1,8);
			if($sess_park==$pc or $park==$test){$s="selected";}else{$s="";}
			$display.="<option value='$pc' $s>$pv</option>\n";
			}
		
		$display.="</select></td></tr>";
		}
			
		echo "$display";
	}

@$pass_record_id=$id;
// include("upload_form_file.php");
// 
// include("upload_form_photo.php");

if(empty($id))
	{$action="Submit"; $delete=""; $span=2;}
	else
	{
	$action="Update";
	$delete="<td align='center'><input type='submit' name='submit' value='Delete' onClick=\"return confirmLink();\"></td>";
	$span=1;
	}
	
if(empty($no_change))
	{
		echo "<tr>";
	echo "$delete";
	echo "<td colspan='$span' align='center'>";
	echo "<input type='submit' name='submit' value='$action'>";
	echo "</td></tr>";
	}
echo "</form></table>";


echo "</body></html>";
?>
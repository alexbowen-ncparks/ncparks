<?php
ini_set('display_errors',1);
$outfilename = "";
$tf = 0;
$llx1= 50; $lly1=50; $urx1=560; $ury1=800;

$optlist0 = "fontname=Helvetica-Bold fontsize=10 encoding=unicode " ;
$optlist1 = "fontname=Helvetica fontsize=8 encoding=unicode leading=10" ;
$optlist2 = "fontname=Helvetica-Oblique fontsize=8 encoding=unicode ";
define ("PAGE_WIDTH", 612); // 8.5 inches
define ("PAGE_HEIGHT",820); // 11 inches

session_start();
if(empty($db)){$db="le";}
$level=@$_SESSION[$db]['level'];
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database)       or die ("Couldn't select database1");

date_default_timezone_set('America/New_York');
$date=date("Y-m-d");
$sql="SELECT *
		FROM le.incident
		where 1 
		order by incident_code
		";
		$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql";
		while($row=mysqli_fetch_assoc($result))
			{
			$incident_array[$row['incident_code']]=$row['incident_desc'];
			if($row['incident_code']>"300000" and $row['incident_code']<=300500)
				{
				$use_of_force_array[]=$row['incident_code'];
			$incident_array[$row['incident_code']]=$row['incident_desc'];
				}
			}
		
$id="16748";
$sql="SELECT * FROM arrested_person_pio where ci_id='$id'"; //echo "$sql";  //exit;
 $result = @mysqli_QUERY($connection,$sql);
 $person_num_arrest=mysqli_num_rows($result);

while($row=mysqli_fetch_assoc($result))
		{$var_persons_arrest[$row['row_num']]=$row;}
// echo "<pre>"; print_r($var_persons_arrest); echo "</pre>";	exit;	
		
$pio_flds="t1.ci_num, t2.park_name as 'State Park', t1.loc_name as Location, t1.date_occur as Date, t1.time_occur as Time, t1.incident_code as 'Incident Code', t1.incident_name as 'Incident Type', if(t1.narcan='','not used',t1.narcan) as NARCAN, if(t1.use_of_force='','none',t1.use_of_force) as 'Use of Force'";

$pio_flds.=", t1.time_pio_incident as 'Time of Incident', t1.time_pio_date as 'Date of Incident',  t1.time_pio_arrest as 'Time of Arrest', t1.time_pio_date_arrest as 'Date of Arrest', t1.nature_of_incident as 'Details of Incident', t1.text_arrest as 'Details of Arrest', t1.resistance as Resistance, t1.text_resistance, t1.weapon_possession as 'Weapon Possession', t1.text_weapon_possession, t1.weapon_use as 'Weapon Use', t1.text_weapon_use, t1.pursuit as Pursuit, t1.text_pursuit, t1.text_items as 'Description of any items seized in connection with the arrest.'";
// $pio_flds.=", ";

$sql = "SELECT $pio_flds
FROM pr63_pio as t1
left join dpr_system.parkcode_names_district as t2 on t2.park_code=t1.parkcode
where id='$id'
";
$result = @mysqli_query($connection, $sql) or die("$sql Error #3". mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY_pr63[]=$row;
	}
// $text="";
// foreach($ARRAY_pr63 as $index=>$array)
// 	{
// 	extract($array);
// 	if(!empty($quick_link)){$ql="\n".$quick_link;}else{$ql="";}
// 	$text.=$ci_num." ".$parkcode." ".$loc_name." ".$nature_of_incident." ".$text_arrest."\n\n";
// 	}
// echo "<pre>"; print_r($ARRAY_pr63); echo "</pre>";  exit;
// $text= implode("\n\n",$ARRAY_ref);

$skip=array("id","majorGroup","dateM");

$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

if (PDF_begin_document($pdf,  "", "") == 0) {
    die("Error: " . PDF_get_errmsg($pdf));
}

   pdf_set_info ($pdf, "Authors", "NC DPR");
pdf_set_info ($pdf, "Title", "PR-63");
pdf_set_info ($pdf, "Creator", "See Author");

    /* Create some amount of dummy text and feed it to a Textflow
     * object with alternating options. 
     */
$tf = pdf_create_textflow($pdf,"","");
 
$text="NC Division of Parks and Recreation Public Information Disclosure\n\n";
PDF_add_textflow($pdf, $tf, $text, $optlist0);

$para_array=array("Details of Incident", "Details of Arrest", "Resistance", "Weapon Possession", "Weapon Use", "Pursuit","Description of any items seized in connection with the arrest.");
$para_array_skip=array("text_resistance","text_weapon_possession", "text_weapon_use", "text_pursuit", "text_resistance","text_items");
// echo "<pre>"; print_r($ARRAY_pr63); echo "</pre>"; exit;
   foreach($ARRAY_pr63 as $index=>$array)
	{
	foreach($array as $fld=>$val)
		{
		if(in_array($fld, $skip)){continue;}
			if($val=="\n"){continue;}
		$text=$fld.": ".$val."\n";
		if($fld=="ci_num" and !empty($val))
			{$text="Case Number: ".$val."\n";}
		if($fld=="Use of Force" )
			{$text="Use of Force: ".$incident_array[$val]."\n";}
		if(in_array($fld, $para_array))
			{
			$text="\n".$fld."\n";
			if($fld=="Details of Arrest")   // unsure why this is needed
				{$text="\n".$text;}
			PDF_add_textflow($pdf, $tf, $text, $optlist0);
			$text=$val;
			if($fld=="Details of Arrest")
				{$text.="\n";}
			if($text=="Yes"){$text="";}
			PDF_add_textflow($pdf, $tf, $text, $optlist1);
			}
			else
			{
			if(in_array($fld, $para_array_skip))
				{
				$text=$val."\n";
				}
			PDF_add_textflow($pdf, $tf, $text, $optlist1);
			}
		}
// 	$tf = $p->add_textflow($tf, "\n\n", $optlist1);
			PDF_add_textflow($pdf, $tf, "\n\n", $optlist1);


    }
    
$text="Arrested Individuals:\n";
PDF_add_textflow($pdf, $tf, $text, $optlist0);

$skip=array("ci_id","row_num","id");
   foreach($var_persons_arrest as $index=>$array)
	{
	
	foreach($array as $fld=>$val)
		{
		if(in_array($fld, $skip)){continue;}
			if($val=="\n"){continue;}
		$text=$fld.": ".$val."\n";
			PDF_add_textflow($pdf, $tf, $text, $optlist1);
		}
	}

    /* Loop until all of the text is placed; create new pages
     * as long as more text needs to be placed. 
     */
    do {
	/* Add "showborder to visualize the fitbox borders */
	$optlist = "verticalalign=justify linespreadlimit=120% ";
	$optlist="showborder";

// 	$p->begin_page_ext(0, 0, "width=a4.width height=a4.height");
	PDF_begin_page_ext ($pdf, PAGE_WIDTH, PAGE_HEIGHT,"");

	/* Fill the page */
// 	$result = $p->fit_textflow($tf, $llx1, $lly1, $urx1, $ury1, $optlist);
	$result = PDF_fit_textflow($pdf, $tf,  $llx1, $lly1, $urx1, $ury1,'');


// 	$p->end_page_ext("");
	PDF_end_page_ext ($pdf, "");
	
	/* "_boxfull" means we must continue because there is more text;
	 * "_nextpage" is interpreted as "start new column"
	 */
    } while ($result == "_boxfull" || $result == "_nextpage");

    /* Check for errors */
    if (!$result == "_stop") {
	/* "_boxempty" happens if the box is very small and doesn't
	 * hold any text at all.
	 */
	if ($result == "_boxempty") {
	    die("Error: Textflow box too small");
	} else {
	    /* Any other return value is a user exit caused by
	     * the "return" option; this requires dedicated code to
	     * deal with.
	     */
	    die("User return '" . $result . "' found in Textflow");
	}
    }

PDF_delete_textflow($pdf, $tf);

//     $p->end_document("");
    PDF_end_document($pdf,"");

//     $buf = $p->get_buffer();
    $buf=PDF_get_buffer($pdf);
    $len = strlen($buf);
// exit;
    header("Content-type: application/pdf");
    header("Content-Length: $len");
    header("Content-Disposition: inline; filename=starter_textflow.pdf");
    echo $buf;

mysqli_close($connection);

?>
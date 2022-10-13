<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

extract($_REQUEST);
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; exit;
include("../../include/get_parkcodes_dist.php");
include("f_year.php");
$database="system_plan";
include("../../include/iConnect.inc"); // database connection parameters
//echo "c1=$connection";//exit;

$pdf = PDF_new(); include("/opt/library/prd/WebServer/include/pdf_key_23.php");

if (PDF_begin_document($pdf, "", "") == 0) {
    die("Error: " . PDF_get_errmsg($pdf));
}

PDF_set_info($pdf, "Creator", "hello.php");
PDF_set_info($pdf, "Author", "Tom Howard");
PDF_set_info($pdf, "Title", "System Plan");

$helvetica_bold = PDF_load_font($pdf, "Helvetica-Bold", "winansi", "");
$helvetica = PDF_load_font($pdf, "Helvetica", "winansi", "");
$times = PDF_load_font($pdf, "Times-Roman", "winansi", "");
 
foreach($_POST['parkcode'] as $k=>$v)
	{
	PDF_begin_page_ext($pdf, 595, 842, "");

	PDF_setfont($pdf, $helvetica_bold, 14.0);


	$parkcode=$k;
	$parkName=$parkCodeName[$k];

	$text=$parkCodeName[$parkcode];
	PDF_set_text_pos($pdf, 50, 810);
	PDF_show($pdf, $text);

	 unset($ARRAY);
	 unset($FAC_DISPLAY);

mysqli_select_db($connection,"facilities")
       or die ("Couldn't select database");
       
	// Get display name for facilities
	$pn=str_replace("'","",$parkName);
	$sql="SELECT t1.fac_type, count(t1.fac_name) as num
	from facilities.spo_dpr as t1
	left join system_plan.spo_dpr_visitor as t2 on t1.fac_type=t2.fac_type and t2.visitor_facility='x'
	where t1.`park_abbr`='$parkcode' and t2.visitor_facility is not NULL
	group by t1.fac_type
	";
// 	echo "$sql"; exit;
	$result = @mysqli_QUERY($connection,$sql);	
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[$row['fac_type']]=$row['num'];
		}
	$sql="SELECT t1.`Parks With > 5 Mi Hiking Trails`, t1.`Parks With Bicycle Trails`, t1.`Parks With Equestrian Trails`, t1.`Parks With Paddle Trails`, t1.`Parks With Interpretive Trails`
	from  system_plan.fac_inventory_2015 as t1
	where t1.`park_code`='$parkcode'
	";
	$result = @mysqli_QUERY($connection,$sql) or die("$sql ".mysqli_error($connection));	
//   	echo "$sql"; exit;
	while($row=mysqli_fetch_assoc($result))
		{
		foreach($row as $k=>$v)
			{
			if($v>0){$ARRAY[$k]=$v;}
			}
		
		}
// 	echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;
		$valueReplace=array("Parks With > 5 Mi Hiking Trails"=>"Park has > 5 mi of Hiking Trails","Parks With Equestrian Trails"=>"Park has Equestrian Trails","Parks With Interpretive Trails"=>"Park has Interpretive Trails","Parks With Bicycle Trails"=>"Park has Bicycle Trails","Parks With Paddle Trails"=>"Park has Paddle Trails");
	foreach($ARRAY as $k=>$v1)
		{
		
			IF(array_key_exists($k,$valueReplace) )
				{
				$v1=$valueReplace[$k];
				}
			$FAC_DISPLAY[$k]=$v1;
			
		
		}

// 	echo "<pre>"; print_r($FAC_DISPLAY); echo "</pre>";  exit;
	  mysqli_select_db($connection,"dpr_system")
		   or die ("Couldn't select database");
	//echo "c2=$connection";exit;

	$where="";
	if($parkcode=="JONE"){$where="OR t1.parkcode='SALA'";}

	 unset($PARK_INFO);
// 	$sql="SELECT county, class, class_type, sum(acres_land) as acres_land, sum(acres_water) as acres_water, sum(length_miles) as length_miles, note_1, note_2, park_purpose, inter_themes, park_summary, trail_summary
// 	from dpr_acres as t1
// 	LEFT JOIN dprunit as t2 on t2.parkcode=t1.parkcode
// 	where t1.parkcode='$parkcode' $where
// 	group by t1.parkcode,class,class_type
// 	order by class";
		$sql="SELECT county, class, class_type, sum(acres_land) as acres_land, sum(acres_water) as acres_water, sum(length_miles) as length_miles, note_1, note_2, park_purpose, inter_themes, park_summary, trail_summary
	from dpr_acres as t1
	LEFT JOIN dprunit as t2 on t2.parkcode=t1.parkcode
	where t1.parkcode='$parkcode' $where
	group by t1.parkcode,class,class_type
	order by class";
	//if($parkcode=="LAJA"){
// 	echo "$sql"; exit;
	//}

	$result = @mysqli_QUERY($connection,$sql) or die(mysqli_error($connection));	
	while($row=mysqli_fetch_assoc($result)){$PARK_INFO[]=$row;}
	//echo "<pre>"; print_r($PARK_INFO); echo "</pre>"; exit;

	 unset($FACILITY);
	$sql="SELECT fac_name, fac_desc, sum(number) as number
	from facility_desc as t1
	LEFT JOIN dprunit as t2 on t2.parkcode=t1.parkcode
	where t1.parkcode='$parkcode'
	group by t1.parkcode,fac_name
	order by fac_name";

	$result = @mysqli_QUERY($connection,$sql);	
	while($row=mysqli_fetch_assoc($result)){$FACILITY[]=$row;}
//	echo "<pre>$sql"; print_r($FACILITY); echo "</pre>";  exit;


	  mysqli_select_db($connection,"divper")
		   or die ("Couldn't select database");
	 unset($POSITION1);
	// Staff
	$sql="SELECT working_title as position, count(seid) as num
	from position
	where park='$parkcode' AND code='$parkcode'
	group by position order by current_salary desc";

	$result = @mysqli_QUERY($connection,$sql);	
	while($row=mysqli_fetch_assoc($result)){$POSITION1[]=$row;}
	//echo "<pre>$sql"; print_r($POSITION1); echo "</pre>";  exit;


	  mysqli_select_db($connection,"hr")
		   or die ("Couldn't select database");
	 unset($POSITION2);
	 $f_year="0809";
	$sql="SELECT osbm_title as position, osbm_title as position_beacon, count(id) as num
	from seasonal_payroll
	where center_code='$parkcode' and osbm_title!=''
	group by osbm_title order by num desc";
	$result = @mysqli_QUERY($connection,$sql);
	//echo "$sql r=$result"; exit;
	while($row=mysqli_fetch_assoc($result)){$POSITION2[]=$row;}
	//echo "<pre>$sql"; print_r($POSITION2); echo "</pre>";  exit;

	$database="photos";
	mysqli_select_db($connection,$database)
		   or die ("Couldn't select database");
	$sql="SELECT link
	from photos.images
	where park='$parkcode' and sys_plan='x'";
	$result = @mysqli_QUERY($connection,$sql);
	//echo "$sql r=$result"; //exit;
	$row=mysqli_fetch_assoc($result);

	if($row['link']!="")
		{
		$var=explode("/",$row['link']);
		$var640="640.".$var[3];
		$link="http://www.dpr.ncparks.gov/photos/".$var[0]."/".$var[1]."/".$var[2]."/".$var640;
	//	echo "$link"; exit;
		}


	$database="park_use";
	mysqli_select_db($connection,$database)
		   or die ("Couldn't select database");
	   
	$sql="SELECT fld_name as fac_name, category_desc as fac_desc
	FROM `categories`
	left join park_category on park_category.category=categories.category_id
	WHERE park_id='$parkcode'";
	//echo "$sql"; //exit;
	$result = @mysqli_QUERY($connection,$sql);	
	while($row=mysqli_fetch_assoc($result)){$FACILITY[]=$row;}

	//echo "<pre>"; print_r($FACILITY); echo "</pre>";  exit;


	$database="park_use";
	mysqli_select_db($connection,$database)
		   or die ("Couldn't select database");
	$sql="SELECT sum(attend_tot) as visit_prev
	from stats_day
	where park like '$parkcode%' and left(year_month_day,4)='$prev_yr'
	group by left(year_month_day,4)";
	$result = @mysqli_QUERY($connection,$sql);	
	$row=mysqli_fetch_assoc($result);
	if($row){extract($row);}  //echo "$sql"; exit;

	$sql="SELECT sum(attend_tot) as visit_pent
	from stats
	where park='$parkcode' and left(year_month_week,4)='$pent_yr'
	group by left(year_month_week,4)";
	$result = @mysqli_QUERY($connection,$sql);	
	$row=mysqli_fetch_assoc($result);
	if($row){extract($row);}

	$text="Summary";
	PDF_setfont($pdf, $helvetica_bold, 11.0);
	PDF_set_text_pos($pdf, 50, 790);
	PDF_show($pdf, $text);

	$width=108;
	$text=$PARK_INFO[0]['park_summary'];

	if($text=="")
		{$text="The summary information for this park has not yet been entered.\n\n";}
	

	PDF_setfont($pdf, $times, 11.0);
	PDF_set_text_pos($pdf, 50, 777);

		$mod_summary=array("HARI");
		 if(in_array($parkcode,$mod_summary))
			 {
			 include("mod_park_summary.inc");
			 $text.=${$parkcode};
			 }
			 $text=str_replace("  "," ",$text);
	$var=explode(" ",$text);

	$i=0;
	$ii=0;
	$para="";
	$y=777;
	$c=count($var);
	foreach($var as $index=>$word)
		{
		$test_nl=explode("\n",$var[$i]);
		if(count($test_nl)>1)
			{
			PDF_set_text_pos($pdf, 50, $y);
			$next=explode("\n",$var[$i]);
		//	echo "<pre>"; print_r($next); echo "</pre>";  exit;
			$para.=$next[0];
			$next_word=@$next[2]." ";
					$para=ltrim($para," ");
			PDF_show($pdf, $para);
			$y-=22;
			$para=$next_word;
			$i++;
			continue;
			}
		$para.=$var[$i]." ";
		$i++;
		if(strlen($para)>$width or $i==$c)
			{	
			PDF_set_text_pos($pdf, 50, $y);
					$para=ltrim($para," ");
			PDF_show($pdf, $para);
			$y-=13;
			$para="";
			}
		}
	$texty = pdf_get_value($pdf, "texty", 0);
	//echo "$texty"; exit;



	// Interpretive themes
	$it=$PARK_INFO[0]['inter_themes'];

	$text="Interpretive Themes";
	PDF_setfont($pdf, $helvetica_bold, 11.0);
	$texty-=20;
	PDF_set_text_pos($pdf, 50, $texty);
	PDF_show($pdf, $text);

	$text=$PARK_INFO[0]['inter_themes'];
	
			 $text=str_replace("  "," ",$text);
	if($text=="" OR $text=="The interpretive themes for this park have not yet been entered.")
		{
		$text="The interpretive themes for this park have not yet been entered.";
		$no_theme=1;
		}
		else
		{$no_theme="";}
	

	PDF_setfont($pdf, $times, 11.0);
	PDF_set_text_pos($pdf, 50, 767);
	$var=explode("\n",$text);

	//echo "<pre>"; print_r($var); echo "</pre>";  exit;
	$i=0;
	$para="";   $col_shift="";
	$y=$texty-13;
	$c=count($var);
//	echo "<pre>"; print_r($var); echo "</pre>";  exit;
	foreach($var as $index=>$line)
		{
		$check_width=$width;
		if($no_theme==""){$check_width-=55;}
		if(strlen($line)<$check_width or $index==0)
			{
			if($no_theme==""){$line=strtoupper($line);}  // Theme Title
					$line=ltrim($line);
			PDF_set_text_pos($pdf, 50, $y);
			PDF_show($pdf, $line);
			$y-=13;
			continue;
			}
			$para="";
			$line_array=explode(" ",$line);
			foreach($line_array as $i=>$word)
				{
				$para.=$word." ";
				if(strlen($para)>$width OR (strlen($para)+(strlen(@$line_array[$i+1])-4))>$width)
					{
					PDF_set_text_pos($pdf, 50, $y);
					$para=ltrim($para);
					PDF_show($pdf, $para." ");
					$y-=13;
					$para="";
					}
				
				}
			if($index>0)
				{
				$test=trim($var[$index-1]);
				 if($test==""){$para=strtoupper($para);}  // Theme Title
				//	$para.=$index;
				PDF_set_text_pos($pdf, 50, $y);
				PDF_show($pdf, $para);
				$lead=13;
				if($parkcode=="JORD"){$lead=7;}
				if(!empty($para)){$y-=$lead;}
				}
		}
	
	$texty = pdf_get_value($pdf, "texty", 0);

	//Acreage
	$land="";$water="";
	if($PARK_INFO!="")
		{
		foreach($PARK_INFO as $k=>$v){
			foreach($v as $k1=>$v1){
				if($k1=="acres_land"){$land+=$v1;}
				if($k1=="acres_water"){$water+=$v1;}
				}
			}
		}
	$acres_water="";$acres_land="";
	$texty-=20;
	if($land>0)
		{
		PDF_setfont($pdf, $helvetica_bold, 11.0);
		$acreage="Acreage: ";
			PDF_set_text_pos($pdf, 50, $texty);
			PDF_show($pdf, $acreage);
	$textx = pdf_get_value($pdf, "textx", 0);
		PDF_setfont($pdf, $times, 11.0);
		$acreage=number_format($land,0)." land acres";
			PDF_set_text_pos($pdf, $textx, $texty);
			PDF_show($pdf, $acreage);
	$textx = pdf_get_value($pdf, "textx", 0);
		}
	if($water>0)
		{
		$w_acreage=" / ".number_format($water,0)." water acres";
			PDF_set_text_pos($pdf, $textx, $texty);
			PDF_show($pdf, $w_acreage);
	$textx = pdf_get_value($pdf, "textx", 0);
		}

		
	//echo "<pre>"; print_r($PARK_INFO); echo "</pre>";  exit;
	// Miles for State Rivers and State Trails
	$type=""; $varType=""; $pdfType="";

	if($PARK_INFO!="")
		{
		foreach($PARK_INFO AS $k=>$v)
			{
			foreach($v as $k1=>$v1)
				{
				if($k1=="class_type" and $PARK_INFO[$k]['length_miles']>0)
					{
					$val=number_format($PARK_INFO[$k]['length_miles'],1);
					$type[]=$v1." - ".$val;
					}
				}
			}
				if($type){$type=array_unique($type);
				foreach($type as $k=>$v){
					$varType.="$v miles<br />";
					$pdfType.="$v miles ";
					}
		$varType="<b>State River</b><br />".$varType;
					}
		}
	

	$note_1=$PARK_INFO[0]['note_1'];
	$note_2=$PARK_INFO[0]['note_2'];


	if($pdfType!="")
		{

		$text="State River: $pdfType";

		PDF_set_text_pos($pdf, 50, $texty-13);
		PDF_show($pdf, $text);

		}

	$textx = pdf_get_value($pdf, "textx", 0);
	//$texty = pdf_get_value($pdf, "texty", 0);
	//County
	$county=$PARK_INFO[0]['county'];
	//Visitation
	$visitation1="Visitation ($prev_yr): ".number_format($visit_prev,0);

		PDF_setfont($pdf, $helvetica_bold, 11.0);
		$visitation1="Visitation ($prev_yr): ";
			PDF_set_text_pos($pdf, $textx+10, $texty);
			PDF_show($pdf, $visitation1);
	$textx = pdf_get_value($pdf, "textx", 0);
		PDF_setfont($pdf, $times, 11.0);
	
	$visitation1=number_format($visit_prev,0);
			PDF_set_text_pos($pdf, $textx, $texty);
			PDF_show($pdf, $visitation1);

	$textx = pdf_get_value($pdf, "textx", 0);
	$texty = pdf_get_value($pdf, "texty", 0);
	 
	$split=explode(",",$county);
	$split1=explode("/",$county);
		if(count($split)>1 OR count($split1)>1)
			{
		PDF_setfont($pdf, $helvetica_bold, 11.0);
		$varCounty="Counties: ";
			PDF_set_text_pos($pdf, $textx+10, $texty);
			PDF_show($pdf, $varCounty);
	$textx = pdf_get_value($pdf, "textx", 0);
			$var=implode(", ",$split);
			$var=str_replace("  "," ",$var);
		PDF_setfont($pdf, $times, 11.0);
			PDF_set_text_pos($pdf, $textx, $texty);
			PDF_show($pdf, $var);
			}
			else
			{
		PDF_setfont($pdf, $helvetica_bold, 11.0);
		$varCounty="County: ";
			PDF_set_text_pos($pdf, $textx+10, $texty);
			PDF_show($pdf, $varCounty);
	$textx = pdf_get_value($pdf, "textx", 0);
		PDF_setfont($pdf, $times, 11.0);
			PDF_set_text_pos($pdf, $textx, $texty);
			PDF_show($pdf, $county);
			}
	



	// Facilities

	$textx = pdf_get_value($pdf, "textx", 0);
	$texty = pdf_get_value($pdf, "texty", 0);
	$pass_texty=$texty;

	if($pdfType!="")
		{
		$fudge=38;
		}
		else
		{$fudge=26;}
			PDF_set_text_pos($pdf, 50, $texty-$fudge);
		PDF_setfont($pdf, $helvetica_bold, 11.0);
			PDF_show($pdf, "Visitor Facilities");

		PDF_setfont($pdf, $times, 11.0);
// 	echo "<pre>"; print_r($FAC_DISPLAY); echo "</pre>";  exit;


		   unset($fac_cell);
		
	if(@$FAC_DISPLAY!="")
		{
		$skip=array("id");
		$j=1;
		foreach($FAC_DISPLAY as $k=>$value)
			{
			if($value=="" OR $k=="FACILITY TYPE" OR $k=="1"){continue;}
				if(in_array($value,$valueReplace)){$k="";}

						$val=$value." ".$k;
			$j++;
	$textx = pdf_get_value($pdf, "textx", 0);
	$texty = pdf_get_value($pdf, "texty", 0);
				if($texty<30)
					{
					$ii++;
					if($ii==1)
						{
						$col_shift=240;}
						else
						{$col_shift=420;}
					
					$texty=112;
					if($parkcode=="ENRI" or $parkcode=="LURI")
						{$texty=160;}
					if($parkcode=="RARO")
						{$texty=100;}
					}
			$fac_display_x=65;
			if(!empty($col_shift))
				{
				$fac_display_x=$col_shift;
				if($parkcode=="ENRI" or $parkcode=="LURI")
					{
					$fac_display_x=220;
					}
				}
			$fac_display_y=$texty;
			PDF_set_text_pos($pdf, $fac_display_x, $fac_display_y-13);
			PDF_show($pdf, $val);
				}// end foreach

		}
	
	
	

	if($FACILITY[1]){
		

	$textx = pdf_get_value($pdf, "textx", 0);
	$texty = pdf_get_value($pdf, "texty", 0);
	$pass_textx=300;
					if($parkcode=="ENRI" or $parkcode=="LURI")
						{
						$pass_texty=194;
						$pass_textx=400;
						}
	$text="Permanent Staff";

		PDF_setfont($pdf, $helvetica_bold, 11.0);
			PDF_set_text_pos($pdf, $pass_textx, $pass_texty-$fudge);
			PDF_show($pdf, $text);

		PDF_setfont($pdf, $times, 11.0);
		if(@$POSITION1!="")
			{
			foreach($POSITION1 as $k=>$v)
				{
				$text="";
				foreach($v as $fld=>$value)
					{
					if($fld=="position"){$value=$value." -";}
						$text.=$value." ";
					}
			
				$texty = pdf_get_value($pdf, "texty", 0);
				PDF_set_text_pos($pdf, $pass_textx+15, $texty-13);
				PDF_show($pdf, $text);
				}
			}
		
	$text="Seasonal Staff";

	$texty = pdf_get_value($pdf, "texty", 0);
	$pass_textx=300;
					if($parkcode=="ENRI" or $parkcode=="LURI")
						{
						$pass_textx=400;
						}
			PDF_set_text_pos($pdf, $pass_textx, $texty-26);
		PDF_setfont($pdf, $helvetica_bold, 11.0);
			PDF_show($pdf, $text);

		PDF_setfont($pdf, $times, 11.0);
	$textx = pdf_get_value($pdf, "textx", 0);
	$texty = pdf_get_value($pdf, "texty", 0);

	if(@$POSITION2!="")
		{
		foreach($POSITION2 as $k=>$v)
			{
				$text="";
				foreach($v as $fld=>$value)
					{
					if($fld=="position_beacon"){continue;}
					if($fld=="position")
						{
						if($value=="none")
							{$value=$POSITION2[$k]['position_beacon'];}
						$value=ucwords(strtolower($value))." -";
						}
					$text.=$value." ";
					}
		
				$texty = pdf_get_value($pdf, "texty", 0);
				PDF_set_text_pos($pdf, $pass_textx+15, $texty-13);
				PDF_show($pdf, $text);
			}
		}


		}// end $FACILITY[1]


	PDF_end_page_ext($pdf, "");
	}

// exit;


PDF_end_document($pdf, "");

$buf = PDF_get_buffer($pdf);
$len = strlen($buf);

$filename="NC_State_Park_".$parkcode."_profile.pdf";
header("Content-type: application/pdf");
header("Content-Length: $len");
header("Content-Disposition: inline; filename=$filename");
print $buf;

PDF_delete($pdf);

?>
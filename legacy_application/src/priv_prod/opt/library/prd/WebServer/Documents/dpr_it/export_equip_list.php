<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('America/New_York');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
// require_once dirname(__FILE__) . '/../Classes/PHPExcel.php';
require_once('/opt/library/prd/WebServer/Documents/Classes/PHPExcel.php');

// Create new PHPExcel object
// echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = new PHPExcel();

// Set document properties
// echo date('H:i:s') , " Set document properties" , EOL;
$setTitle="DPR Equiment List";
$objPHPExcel->getProperties()->setCreator("Tom Howard")
							 ->setLastModifiedBy("Tom Howard")
							 ->setTitle($setTitle);
// 							 ->setTitle("PHPExcel Test Document")
// 							 ->setSubject("PHPExcel Test Document")
// 							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
// 							 ->setKeywords("office PHPExcel php")
// 							 ->setCategory("Test result file");


// Add some data
$database="dpr_it";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_query($connection,"set names utf8;");

include("_base_top.php"); // database connection parameters
// limit 10
$sql="SELECT * FROM computers "; //echo "$sql";
$result=mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$c=count($ARRAY);
//   echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
$objPHPExcel->setActiveSheetIndex(0);
$num_flds=count($ARRAY[0]);
$col_names=array_keys($ARRAY[0]);
//  echo "<pre>"; print_r($col_names); echo "</pre>";  exit;
for($i=0; $i<$num_flds; $i++)
	{
	$r=1;
	$value=$col_names[$i];
// 	echo "$r  $j $value $num_flds<br />";
	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($i, $r,$value);

	}
foreach($ARRAY as $index=>$array)
	{
	$j=0;
	foreach($array as $fld=>$value)
		{
		$k=$index+2;
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($j,$k,$value);
		$j++;
		}
	}
// 
// $k=$c+3;
// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0,$k,"Codes:");
// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$k,"State Rank:");
// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(9,$k,"State Status:");
// $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(10,$k,"US Status:");
// 
// $code_array=array("S1"=>"Critically imperiled in the state","S2"=>"Imperiled in the state","S3"=>"Rare or uncommon in the state","S4"=>"Apparently secure in the state","S5"=>"Demonstrably secure in the state","SH"=>"Of historical occurrence, last record over 30 years ago", "SA"=>"Accidental or casual","SE"=>"Exotic, presumed not native to the state","SU"=>"Undetermined - need more information on status and trends", "T"=>"global rank of the subspecies/taxon","Q"=>"questionable taxonomic assignment","NR"=>"not yet ranked");
// 
// // "Global Rank - Global ranks are similar to state ranks except \"in the state\" is replaced by \"globally\". 
// // Additional global ranks are: 
// 
// $j=$k;
// foreach($code_array as $code=>$text)
// 	{
// 	$j++;
// 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1,$j,$code);
// 	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2,$j,$text);
// 	}

// Rename worksheet
// echo date('H:i:s') , " Rename worksheet" , EOL;
$objPHPExcel->getActiveSheet()->setTitle('DPR Equipment List');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Save Excel 2007 file
// echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xlsx', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

// echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
$file_link=str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME));
// echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
// echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Echo done
// echo date('H:i:s') , " Done writing files" , EOL;
$link="<a href='$file_link'>Link</a>";


echo "<div name='basic_search' >
<table class='search_box'>";
$c=number_format($c);
echo "<tr><td class='exporttext'>$c taxa have been exported to an Excel (.xlsx) file.</td></tr>";
echo "<tr><td class='exporttext'>$link</td></tr>";

echo "</table></div>";

?>
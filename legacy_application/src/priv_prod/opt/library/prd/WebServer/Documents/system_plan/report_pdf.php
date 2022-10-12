<?php

require('../../fpdf16/fpdf.php');

require('../../fpdf16/extend_FPDF.php');


$html='You can now easily print text mixing different styles: <b>bold</b>, <i>italic</i>,
<u>underlined</u>, or <b><i><u>all at once</u></i></b>!<br><br>You can also insert links on
text, such as <a href="http://www.fpdf.org">www.fpdf.org</a>, or on an image: click on the logo.';

$pdf=new PDF();
//First page
$pdf->AddPage();
$pdf->SetFont('Arial','',18);
$pdf->Write(1,'To find out what\'s new in this tutorial, click here');
$pdf->SetFont('','U');
$link=$pdf->AddLink();
$pdf->Write(5,'here',$link);
$pdf->SetFont('');
//Second page
$pdf->AddPage();
$pdf->SetLink($link);
//$pdf->Image('logo.png',10,12,30,0,'','http://www.fpdf.org');
$pdf->SetLeftMargin(45);
$pdf->SetFontSize(14);
$pdf->WriteHTML($html);
$pdf->Output();


?>
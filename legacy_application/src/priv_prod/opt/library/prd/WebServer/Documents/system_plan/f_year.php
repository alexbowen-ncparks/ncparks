<?php
if(@$f_year=="")
	{
	$testMonth=date('n');
	if($testMonth >0 and $testMonth<8){$year2=date('Y')-1;}
	if($testMonth >7){$year2=date('Y');}
	$yearNext=$year2+1;
	$yx=substr($year2,2,2);
	$year3=$yearNext;$yy=substr($year3,2,2);
	$f_year=$yx.$yy;

	if(@$prev_year=="prev")
		{$yx=substr(($year2-1),2,2);$yy=substr(($year3-1),2,2);$f_year=$yx.$yy;}

	$pf_year=$yx=substr(($year2-1),2,2);
	$yy=substr(($year3-1),2,2);
	$pf_year=$yx.$yy;
	}

$prev_yr=date('Y')-1; 
$pent_yr=$prev_yr-1;
?>
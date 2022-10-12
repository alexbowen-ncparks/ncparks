<?php

echo "<br />Line3(score_dates.php)<br />";

//$calyear1='20'.substr($compliance_fyear,0,2);


{
if
(
$compliance_month == 'july' or 
$compliance_month == 'august' or 
$compliance_month == 'september' or 
$compliance_month == 'october' or 
$compliance_month == 'november' or 
$compliance_month == 'december'
)
{$calyear_start='20'.substr($compliance_fyear,0,2);}


if
(
$compliance_month == 'january' or 
$compliance_month == 'february' or 
$compliance_month == 'march' or 
$compliance_month == 'april' or 
$compliance_month == 'may' or 
$compliance_month == 'june'
)
{$calyear_start='20'.substr($compliance_fyear,2,2);}

if($compliance_month != 'december'){$calyear_start2=$calyear_start;}
if($compliance_month == 'december'){$calyear_start2=$calyear_start+1;}

//echo "<br />Line30(score_dates.php): calyear_start=$calyear_start<br />";

$calyear_end=$calyear_start; 
if($compliance_month != 'december'){$calyear_end2=$calyear_end;}
if($compliance_month == 'december'){$calyear_end2=$calyear_end+1;}

//echo "<br />Line30(score_dates.php): calyear_end=$calyear_end<br />";

if($compliance_month == 'november' or $compliance_month == 'december'){$calyear_start3=$calyear_start+1;} else {$calyear_start3=$calyear_start;}
if($compliance_month == 'november' or $compliance_month == 'december'){$calyear_end3=$calyear_end+1;} else {$calyear_end3=$calyear_end;}



$query="update cash_imprest_count_scoring
        set calyear_start='$calyear_start',calyear_end='$calyear_end',calyear_start2='$calyear_start2',calyear_end2='$calyear_end2',calyear_start3='$calyear_start3',calyear_end3='$calyear_end3'
		where fyear='$compliance_fyear'
		and cash_month='$compliance_month' ";


//echo "<br />Line30(score_dates.php): query=$query<br />";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query ");	

//echo "<br />Line48(score_dates.php): Query Sucessful<br />";


if($compliance_month=='january'){$month_start='01'; $month_end='01';}
if($compliance_month=='february'){$month_start='02'; $month_end='02';}
if($compliance_month=='march'){$month_start='03'; $month_end='03';}
if($compliance_month=='april'){$month_start='04'; $month_end='04';}
if($compliance_month=='may'){$month_start='05'; $month_end='05';}
if($compliance_month=='june'){$month_start='06'; $month_end='06';}
if($compliance_month=='july'){$month_start='07'; $month_end='07';}
if($compliance_month=='august'){$month_start='08'; $month_end='08';}
if($compliance_month=='september'){$month_start='09'; $month_end='09';}
if($compliance_month=='october'){$month_start='10'; $month_end='10';}
if($compliance_month=='november'){$month_start='11'; $month_end='11';}
if($compliance_month=='december'){$month_start='12'; $month_end='12';}


$month_start2=$month_start+1;
$month_end2=$month_end+1;

$month_start2=str_pad($month_start2,2,'0', STR_PAD_LEFT);
$month_end2=str_pad($month_end2,2,'0', STR_PAD_LEFT);

if($month_start2=='13'){$month_start2='01';}
if($month_end2=='13'){$month_end2='01';}



//echo "<br />Line74(score_dates.php): month_start2=$month_start2<br />";
//echo "<br />Line75(score_dates.php): month_end2=$month_end2<br />";

//exit;


$month_start3=$month_start+2;
$month_end3=$month_end+2;

$month_start3=str_pad($month_start3,2,'0', STR_PAD_LEFT);
$month_end3=str_pad($month_end3,2,'0', STR_PAD_LEFT);

if($month_start3=='13'){$month_start3='01';}
if($month_start3=='14'){$month_start3='02';}


if($month_end3=='13'){$month_end3='01';}
if($month_end3=='14'){$month_end3='02';}







$query="update cash_imprest_count_scoring
        set month_start='$month_start',month_end='$month_end',
		month_start2='$month_start2',month_end2='$month_end2',
		month_start3='$month_start3',month_end3='$month_end3'
		where fyear='$compliance_fyear'
		and cash_month='$compliance_month' ";


//echo "<br />Line75(score_dates.php): query=$query<br />";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query ");	


$query="update cash_imprest_count_scoring
        set day_start='01',day_end='10',day_start2='01',day_end2='10',day_start3='01',day_end3='10'
		where fyear='$compliance_fyear'
		and cash_month='$compliance_month'
        and score='100'		";


echo "<br />Line100(score_dates.php): query=$query<br />";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query ");	


$query="update cash_imprest_count_scoring
        set day_start='11',day_end='15',day_start2='11',day_end2='15',day_start3='11',day_end3='15'
		where fyear='$compliance_fyear'
		and cash_month='$compliance_month'
        and score='90'		";


//echo "<br />Line100(score_dates.php): query=$query<br />";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query ");	


$query="update cash_imprest_count_scoring
        set day_start='16',day_end='20',day_start2='16',day_end2='20',day_start3='16',day_end3='20'
		where fyear='$compliance_fyear'
		and cash_month='$compliance_month'
        and score='80'		";


//echo "<br />Line100(score_dates.php): query=$query<br />";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query ");	


$query="update cash_imprest_count_scoring
        set day_start='21',day_end='25',day_start2='21',day_end2='25',day_start3='21',day_end3='25'
		where fyear='$compliance_fyear'
		and cash_month='$compliance_month'
        and score='70'		";


//echo "<br />Line100(score_dates.php): query=$query<br />";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query ");	


$query="update cash_imprest_count_scoring
        set day_start='26',day_start2='26',day_start3='26'
		where fyear='$compliance_fyear'
		and cash_month='$compliance_month'
        and score='60'		";


//echo "<br />Line100(score_dates.php): query=$query<br />";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query ");	


if($compliance_month=='january'){$day_end='31'; $day_end2='28'; $day_end3='31';}
if($compliance_month=='february'){$day_end='28'; $day_end2='31'; $day_end3='30';}
if($compliance_month=='march'){$day_end='31'; $day_end2='30'; $day_end3='31';}
if($compliance_month=='april'){$day_end='30'; $day_end2='31'; $day_end3='30';}
if($compliance_month=='may'){$day_end='31'; $day_end2='30'; $day_end3='31';}
if($compliance_month=='june'){$day_end='30'; $day_end2='31'; $day_end3='31';}
if($compliance_month=='july'){$day_end='31'; $day_end2='31'; $day_end3='30';}
if($compliance_month=='august'){$day_end='31'; $day_end2='30'; $day_end3='31';}
if($compliance_month=='september'){$day_end='30'; $day_end2='31'; $day_end3='30';}
if($compliance_month=='october'){$day_end='31'; $day_end2='30'; $day_end3='31';}
if($compliance_month=='november'){$day_end='30'; $day_end2='31'; $day_end3='31';}
if($compliance_month=='december'){$day_end='31'; $day_end2='31'; $day_end3='28';}


$query="update cash_imprest_count_scoring
        set day_end='$day_end',day_end2='$day_end2',day_end3='$day_end3'
		where fyear='$compliance_fyear'
		and cash_month='$compliance_month'
        and score='60'		";


//echo "<br />Line100(score_dates.php): query=$query<br />";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query ");	


$start_date=$calyear_start.$month_start.$day_start;
$end_date=$calyear_end.$month_end.$day_end;

$start_date2=$calyear_start2.$month_start2.$day_start2;
$end_date2=$calyear_end2.$month_end2.$day_end2;


$query="update cash_imprest_count_scoring
        set start_date=concat(calyear_start,month_start,day_start),
		    end_date=concat(calyear_end,month_end,day_end),
		    start_date2=concat(calyear_start2,month_start2,day_start2),
		    end_date2=concat(calyear_end2,month_end2,day_end2),
            start_date3=concat(calyear_start3,month_start3,day_start3),
		    end_date3=concat(calyear_end3,month_end3,day_end3)			
		    where fyear='$compliance_fyear'
		    and cash_month='$compliance_month'   ";


//echo "<br />Line100(score_dates.php): query=$query<br />";

$result = mysqli_query($connection, $query) or die ("Couldn't execute query .  $query ");	




//echo "<br />Line79(score_dates.php): Query Sucessful<br />";


//echo "<br />Line82(score_dates.php): month_start=$month_start<br />";
//echo "<br />Line83(score_dates.php): month_end=$month_end<br />";






}

//echo "<br />Line94(score_dates.php)<br />";
//exit;





?>
<?php

$m=12;
$n=144;
$R=.11;
$pmt=38000;
echo $pmt;
function  FVsingle  ($m,$n,$R,$pmt))  { 

        return  $pmt  *  pow((1  +  $R/$m),$n) as $result; 

} 

echo $result;
?>
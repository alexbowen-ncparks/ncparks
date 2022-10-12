<?php
extract($_REQUEST);
include("../../include/salt.inc");

$emidSalted=md5($emid.$salt); // salt.inc
$uploadfile1=$emidSalted;

echo "$emidSalted";

?>
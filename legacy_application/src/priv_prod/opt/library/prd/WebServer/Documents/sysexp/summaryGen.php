<?php
// called from theme.php
// include("../../include/auth.inc");
include("../../include/iConnect.inc");

session_start();
if($_SESSION['sysexp']['level']<1){exit;}
mysqli_select_db($connection,"sysexp");
// would prefer a single query, but couldn't write one
// so the workaround is to use intermediate tables
$sql = "DROP TABLE IF EXISTS tempbio,tempsce,tempgeo,temparc";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
// exit;
$where="WHERE potential = ''";
$sql = "create table temparc
select sid, potential, sum(priority) as arcP, sum(rarity) as arcR, sum(quality) as arcQ, sum(threat) as arcT
from arc $where
group by sid";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

$sql = "create table tempbio
select sid, potential,sum(priority) as bioP, sum(rarity) as bioR, sum(quality) as bioQ, sum(threat) as bioT
from bio $where
group by sid";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

$sql = "create table tempgeo
select sid, potential, sum(priority) as geoP, sum(rarity) as geoR, sum(quality) as geoQ, sum(threat) as geoT
from geo $where
group by sid";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

$sql = "create table tempsce
select sid, potential, sum(priority) as sceP, sum(rarity) as sceR, sum(quality) as sceQ, sum(threat) as sceT
from sce $where
group by sid";
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));

$sort = "site.name";
if($s=="u"){$sort="type DESC, site.name";}
include("createTableGen.php");

?>
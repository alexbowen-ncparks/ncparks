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
$sql = "SELECT site.name,site.sid,site.threat,site.interconnect,site.demand,
site.type,
temparc.arcP,temparc.arcR,temparc.arcQ,temparc.arcT,
tempbio.bioP,tempbio.bioR,tempbio.bioQ,tempbio.bioT,
tempgeo.geoP,tempgeo.geoR,tempgeo.geoQ,tempgeo.geoT,
tempsce.sceP,tempsce.sceR,tempsce.sceQ,tempsce.sceT,
sum(spe.score) as spscore, ((fishfresh*10)+(camptent*10)+(beach*10)+(picnick*10)+(cultural*10)+(natArea*7)+(hisArea*7)+(bike*5)+(hike*4)+(openArea*4)+(swim*4)+(fishSalt*4)+(scenic*4)+(campPrim*2.5)+(horse*1)+(boat*0.5)+(nature*0.5)+(canoe*0.5)+(ski*0.5)+(sail*0.5)) as recTotal

FROM site
left join temparc on temparc.sid=site.sid and temparc.potential=''
left join tempbio on tempbio.sid=site.sid and tempbio.potential=''
left join tempgeo on tempgeo.sid=site.sid and tempgeo.potential=''
left join tempsce on tempsce.sid=site.sid and tempsce.potential=''
left join spe on spe.sid=site.sid and spe.potential=''
left join rec on rec.sid=site.sid
group by site.sid
order by $sort";
// echo "$sql"; exit;
$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));
$number = @mysqli_num_rows($result);
if($number > 0){

echo "<div align='center'>NC DPR System Expansion - Unit Summary</div><table border='1'><tr>
<td width='270' align='center'><a href='summary.php?s=n'>Site Name:</a></td><td><a href='summary.php?s=u'>Unit</a></td>
<td>Threat </td><td>Intercon</td><td>Demand </td>
<td>arcP </td><td>arcT</td><td>arcR </td><td>arcQ </td>
<td>bioP </td><td>bioT</td><td>bioR </td><td>bioQ </td>
<td>geoP </td><td>geoT</td><td>geoR </td><td>geoQ </td>
<td>sceP </td><td>sceT</td><td>sceR </td><td>sceQ </td>
<td>Species </td><td>Rec</td><td>Total</a></td>
</tr>";
while ($row = mysqli_fetch_array($result))
{extract($row);
switch ($type) {
    case "State Park":
        $type="SP";
        break;
    case "Natural Area":
        $type="NA";
        break;
    case "State Rec. Area":
        $type="SRA";
        break;
}
$total=$arcP+$arcT+$arcR+$arcQ+$bioP+$bioT+$bioR+$bioQ+$geoP+$geoT+$geoR+$geoQ+$sceP+$sceT+$sceR+$sceQ+$spscore+$recTotal+$threat+$demand+$interconnect;
$recTotal=round($recTotal);
$total=round($total);
echo "<tr><td><a href='edit.php?sid=$sid'>$name</a></td>
<td align='center'>$type</td>
<td align='right'>$threat</td>
<td align='right'>$interconnect</td>
<td align='right'>$demand</td>
<td align='right'>$arcP</td>
<td align='right'>$arcT</td>
<td align='right'>$arcR</td>
<td align='right'>$arcQ</td>
<td align='right'>$bioP</td>
<td align='right'>$bioT</td>
<td align='right'>$bioR</td>
<td align='right'>$bioQ</td>
<td align='right'>$geoP</td>
<td align='right'>$geoT</td>
<td align='right'>$geoR</td>
<td align='right'>$geoQ</td>
<td align='right'>$sceP</td>
<td align='right'>$sceT</td>
<td align='right'>$sceR</td>
<td align='right'>$sceQ</td>
<td align='right'>$spscore</td>
<td align='right'>$recTotal</td>
<td align='right'><b>$total</b></td>
</tr>";
$sumTotal += $total;
} // end while
}// end if $number
?>

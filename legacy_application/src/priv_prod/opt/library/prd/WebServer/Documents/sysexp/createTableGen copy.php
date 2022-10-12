<?php// Empty table temptotal (don't DROP it, we want to keep this table structure// especially the default values of 0 and not null for most fields)$sql="TRUNCATE TABLE temptotalgen";$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());// Update table temptotal (execSum is just a place holder for rowtotal)$sql="INSERT INTO temptotalgen SELECT site.name,site.sid,site.threat,site.interconnect,site.demand,site.type,temparc.arcP+temparc.arcR+temparc.arcQ+temparc.arcT as arcT,tempbio.bioP+tempbio.bioR+tempbio.bioQ+tempbio.bioT as bioT,tempgeo.geoP+tempgeo.geoR+tempgeo.geoQ+tempgeo.geoT as geoT,tempsce.sceP+tempsce.sceR+tempsce.sceQ+tempsce.sceT as sceT,sum(spe.score) as spscore, ((fishfresh*10)+(camptent*10)+(beach*10)+(picnick*10)+(cultural*10)+(natArea*7)+(hisArea*7)+(bike*5)+(hike*4)+(openArea*4)+(swim*4)+(fishSalt*4)+(scenic*4)+(campPrim*2.5)+(horse*1)+(boat*0.5)+(nature*0.5)+(canoe*0.5)+(ski*0.5)+(sail*0.5)) as recTotal,execSum as rowtotalFROM siteleft join temparc on temparc.name=site.name and temparc.potential=''left join tempbio on tempbio.name=site.name and tempbio.potential=''left join tempgeo on tempgeo.name=site.name and tempgeo.potential=''left join tempsce on tempsce.name=site.name and tempsce.potential=''left join spe on spe.name=site.name and spe.potential=''left join rec on rec.name=site.namegroup by site.nameorder by $sort";$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());// Now create our final General Summary Table$sql="UPDATE temptotalgen SET rowtotal=(threat+interconnect+demand+arcT+bioT+geoT+sceT+spscore+recTotal)";$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());// Display table results	switch ($s) {		case "n":			$sort="ORDER BY name";			$sortP="ORDER BY Site Name";			break;			case "u":			$sort="ORDER BY type DESC";			$sortP="ORDER BY Unit Type";			break;			case "at":			$sort="ORDER BY arcT DESC";			break;			case "bt":			$sort="ORDER BY bioT DESC";			break;			case "gt":			$sort="ORDER BY geoT DESC";			break;			case "st":			$sort="ORDER BY sceT DESC";			break;			case "sp":			$sort="ORDER BY spscore DESC";			$sortP="ORDER BY Species DESC";			break;			case "rt":			$sort="ORDER BY recTotal DESC";			$sortP="ORDER BY recTotal DESC";			break;			case "t":			$sort="ORDER BY rowtotal DESC";			$sortP="ORDER BY Total DESC";			break;		default:			$sort="";	}	$sql="SELECT * from temptotalgen $sort";$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());echo "<table border='1'><tr><td colspan='12' align='center'>NC DPR System Expansion - General Unit Summary<br>$sortP</tr><tr><td width='270' align='center'><a href='summaryGen.php?s=n'>Site Name:</a></td><td><a href='summaryGen.php?s=u'>Unit</a></td><td>Threat</td><td>Intercon</td><td>Demand</td><td><a href='summaryGen.php?s=at'>arcTotal</a></td><td><a href='summaryGen.php?s=bt'>bioTotal</a></td><td><a href='summaryGen.php?s=gt'>geoTotal</a></td><td><a href='summaryGen.php?s=st'>sceTotal</a></td><td><a href='summaryGen.php?s=sp'>Species</a></td><td><a href='summaryGen.php?s=rt'>recTotal</a></td><td><a href='summaryGen.php?s=t'>Total</a></td></tr>";while ($row = mysql_fetch_array($result)){extract($row);switch ($type) {    case "State Park":        $type="SP";        break;    case "Natural Area":        $type="NA";        break;    case "State Rec. Area":        $type="SRA";        break;}$arcTotal=$arcT;$bioTotal=$bioT;$geoTotal=$geoT;$sceTotal=$sceT;echo "<tr><td><a href='edit.php?sid=$sid'>$name</a></td><td align='center'>$type</td><td align='center'>$threat</td><td align='center'>$interconnect</td><td align='center'>$demand</td><td align='right'>$arcTotal</td><td align='right'>$bioTotal</td><td align='right'>$geoTotal</td><td align='right'>$sceTotal</td><td align='right'>$spscore</td><td align='right'>$recTotal</td><td align='right'><b>$rowtotal</b></td></tr>";} // end whileecho "</table></body></html>";?>
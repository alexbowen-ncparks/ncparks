<?php//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;$colHeaders=array("Section","Center<br>Name","center","NCAS #","Description","Spent $fy1","Spent $fy2","Spent $fy3","Inc/Dec Amt","Request $fy4","Explanation");$reportFlds=array("parkcode","center","acct","park_acct_desc","spent_1","spent_2","spent_3","park_req","park_just");//$reportFlds=array_flip($reportFlds);if($beginDate!="" and $endDate!=""){$dateRange=$beginDate."*".$endDate;}$linkVars=array("1","2",$dateRange);if($fiscal_year){$linkVars=array("1","2",$fiscal_year);}$join1="LEFT JOIN coa ON coa.ncasnum = exp_rev.acct";$join2="LEFT JOIN center ON center.center = exp_rev.center";$join3="LEFT JOIN inc_dec ON center.center = inc_dec.center AND inc_dec.ncas_acct = exp_rev.acct";$where="WHERE 1";if($center AND $center!="Select Center"){$where.=" AND exp_rev.center = '$center'";}if($rccYN=="Y"){$where.=" AND coa.track_rcc =  'Y' AND exp_rev.fund =  '1280'";}if($rccYN=="N"){$where.=" AND coa.track_rcc =  'N' AND exp_rev.fund =  '1280'";}//if($rccYN=="All"){$where.=" not needed";}/*if($fiscal_year!="Select FY"){$fy=explode("*",$fiscal_year);$where.=" AND exp_rev.acctdate >= '$fy[0]' AND exp_rev.acctdate <= '$fy[1]'";}*/if($beginDate){$where.=" AND exp_rev.acctdate >= '$beginDate' AND exp_rev.acctdate <= '$endDate'";}//$g="GROUP  BY center.center, acct";$g="GROUP  BY section,center.center, acct  ORDER BY acct,section,parkcode";//echo "w=$where";if(!$submit){exit;};// ******** Get Amount Spent in Year 1$fromSQL1="section,exp_rev.acct,exp_rev.center,sum( credit )  - sum( debit )  AS total FROM exp_rev";$where1=$where." and f_year='$fy1'";$sql1 = "SELECT $fromSQL1 $join1 $join2 $join3 $where1 $g";$result1 = mysql_query($sql1) or die ("Couldn't execute query 1. $sql1");$num=mysql_num_rows($result1);while ($row1=mysql_fetch_array($result1)){extract($row1);$conKey=$section.$acct.$center;$spent_1_array[$conKey]=$total;}//echo "$sql1<br>";exit;//echo "$sql1<pre>";print_r($spent_1_array);echo "</pre>";exit;// ******** Get Amount Spent in Year 2$fromSQL2="section,exp_rev.acct,exp_rev.center,sum( credit )  - sum( debit )  AS total FROM exp_rev";$where2=$where." and f_year='$fy2'";$sql2 = "SELECT $fromSQL2 $join1 $join2 $join3 $where2 $g";$result2 = mysql_query($sql2) or die ("Couldn't execute query 2. $sql2");$num=mysql_num_rows($result2);while ($row2=mysql_fetch_array($result2)){extract($row2);$conKey=$section.$acct.$center;$spent_2_array[$conKey]=$total;}//echo "$sq2<pre>";print_r($spent_2_array);echo "</pre>";exit;// ******** Get Amount Spent in Year 3// For test purposes$fromSQL3="section,parkcode, center.center, exp_rev.acct, coa.park_acct_desc, sum( credit )  - sum( debit )  AS total,park_req,park_just, inc_decid FROM exp_rev";$where3=$where." and f_year='$fy3'";$sql3 = "SELECT $fromSQL3 $join1 $join2 $join3 $where3 $g";$result3 = mysql_query($sql3) or die ("Couldn't execute query 3. $sql3");$num=mysql_num_rows($result3);while ($row3=mysql_fetch_array($result3)){extract($row3);$conKey=$section.$acct.$center;array_unshift($row3, $conKey);$spent_3_array[]=$row3;}//echo "$sql3<pre>";print_r($spent_3_array);echo "</pre>";exit;// *************** PMIS FUNCTIONS **************function portalHeader($passSQL,$colHeaders){global $numOfColumns;$fld=explode(",",$colHeaders);// Put Field Names in an Array$c=count($fld)-1;$lastFld=$fld[$c];$numOfColumns=count($colHeaders);echo "<table border='1' cellpadding='3'><tr>";for($x=0;$x<$numOfColumns;$x++){$var=strtoupper($colHeaders[$x]);echo "<th>$var</th>";}echo "</tr>";}function itemShow($key,$val){//echo "$key[$ff]  $val[$ff]<br>";}// end Function?>
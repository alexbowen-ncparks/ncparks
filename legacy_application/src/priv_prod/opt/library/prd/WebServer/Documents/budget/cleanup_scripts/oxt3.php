<?php$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaseextract($_REQUEST);session_start();$fy=$_SESSION[budget][fy];$p=$s+1;//$dbTable="exp_rev_test";//$dbTable="exp_rev_fyear";//$hostURL="http://localhost";$hostURL="http://www.dpr.ncparks.gov";if($s=="1"){//   Delete ALL records $sql =  "Truncate table `oxt3`";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");//exit;echo "<html><head><title></title><meta  HTTP-EQUIV=\"REFRESH\" content=\"2;  url=$hostURL/budget/cleanup_scripts/oxt3.php?s=2\"></head><body>Step $s of 10 completed.<br><br>$sql<br><br>Please wait while we perform step $p .</body></html>";exit;}// end s=1//exit;if($s=="2"){//$action="Update records by finding appropriate ACCT number and adding it to each record.";$sql =  "INSERT  INTO oxt3( ncasnum,center,spent0203, spent0304, spent0405, spent0506, parkinc0506, distinc0506, ware0405, ware0506 ) SELECT exp_rev.acct AS ncas_num, exp_rev.center, sum( debit - credit )  AS spent0203,  '',  '',  '',  '',  '',  '',  ''FROM  `exp_rev` LEFT  JOIN coa ON exp_rev.acct = coa.ncasnumWHERE 1  AND coa.track_rcc =  'y' AND exp_rev.fund =  '1280' AND exp_rev.acct NOT LIKE  '534%' AND f_year =  '0203'GROUP  BY exp_rev.acct, exp_rev.center";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");//exit;echo "<html><head><title></title><meta  HTTP-EQUIV=\"REFRESH\" content=\"2;  url=$hostURL/budget/cleanup_scripts/oxt3.php?s=3\"></head><body>Step $s of 10 completed.<br><br>$sql<br><br>Please wait while we perform step $p.</body></html>";exit;}// end s=1if($s=="3"){//   Delete ALL records where DEBIT AND CREDIT are zero$sql =  "INSERT  INTO oxt3( ncasnum,center,spent0203, spent0304, spent0405, spent0506, parkinc0506, distinc0506, ware0405, ware0506 ) SELECT exp_rev.acct AS ncas_num, exp_rev.center, '',sum( debit - credit )  AS spent0304,'','','','','',''FROM  `exp_rev` LEFT  JOIN coa ON exp_rev.acct = coa.ncasnumWHERE 1  AND coa.track_rcc =  'y' AND exp_rev.fund =  '1280' AND exp_rev.acct NOT LIKE  '534%' AND f_year =  '0304'GROUP  BY exp_rev.acct, exp_rev.center";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");//exit;echo "<html><head><title></title><meta  HTTP-EQUIV=\"REFRESH\" content=\"2;  url=$hostURL/budget/cleanup_scripts/oxt3.php?s=4\"></head><body>Step $s of 10 completed.<br><br>$sql<br><br>Please wait while we perform step $p .</body></html>";exit;}if($s==4){$sql ="INSERT  INTO oxt3( ncasnum,center,spent0203, spent0304, spent0405, spent0506, parkinc0506, distinc0506, ware0405, ware0506 ) SELECT exp_rev.acct AS ncas_num, exp_rev.center, '','',sum( debit - credit )  AS spent0405,'','','','',''FROM  `exp_rev` LEFT  JOIN coa ON exp_rev.acct = coa.ncasnumWHERE 1  AND coa.track_rcc =  'y' AND exp_rev.fund =  '1280' AND exp_rev.acct NOT LIKE  '534%' AND f_year =  '0405'GROUP  BY exp_rev.acct, exp_rev.center";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");echo "<html><head><title></title><meta  HTTP-EQUIV=\"REFRESH\" content=\"2;  url=$hostURL/budget/cleanup_scripts/oxt3.php?s=5\"></head><body>Step $s of 10 completed.<br><br>$sql<br><br>Please wait while we perform step $p.</body></html>";exit;}// end s=4if($s=="5"){//   Update ALL new records with Fiscal Year$sql =  "INSERT  INTO oxt3( ncasnum,center,spent0203, spent0304, spent0405, spent0506, parkinc0506, distinc0506, ware0405, ware0506 ) SELECT exp_rev.acct AS ncas_num, exp_rev.center, '','','',sum( debit - credit )  AS spent0506,'','','',''FROM  `exp_rev` LEFT  JOIN coa ON exp_rev.acct = coa.ncasnumWHERE 1  AND coa.track_rcc =  'y' AND exp_rev.fund =  '1280' AND exp_rev.acct NOT LIKE  '534%' AND f_year =  '0506'GROUP  BY exp_rev.acct, exp_rev.center";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql"); //exit;echo "<html><head><title></title><meta  HTTP-EQUIV=\"REFRESH\" content=\"2;  url=$hostURL/budget/cleanup_scripts/oxt3.php?s=6\"></head><body>Step $s of 10 completed.<br><br>$sql<br><br>Please wait while we perform step $p.</body></html>";exit;}// end s=5if($s==6){$sql =  "INSERT  INTO oxt3( ncasnum,center,spent0203, spent0304, spent0405, spent0506, parkinc0506, distinc0506, ware0405, ware0506 ) SELECT inc_dec.ncas_acct AS ncas_num, inc_dec.center, '','','','',sum( park_req )  AS parkinc0506,'','',''FROM  `inc_dec` LEFT  JOIN coa ON inc_dec.ncas_acct = coa.ncasnumWHERE 1  AND coa.track_rcc =  'y' AND inc_dec.disu_app !=  '1'GROUP  BY inc_dec.ncas_acct, inc_dec.center";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");echo "<html><head><title></title><meta  HTTP-EQUIV=\"REFRESH\" content=\"2;  url=$hostURL/budget/cleanup_scripts/oxt3.php?s=7\"></head><body>Step $s of 10 completed.<br><br>$sql<br><br>Please wait while we perform step $p.</body></html>";exit;}// end s=6if($s==7){$sql =  "INSERT  INTO oxt3( ncasnum,center,spent0203, spent0304, spent0405, spent0506, parkinc0506, distinc0506, ware0405, ware0506 ) SELECT inc_dec.ncas_acct as ncas_num, inc_dec.center, '','','','','',sum( disu_req )  AS distinc_0506,'',''FROM  `inc_dec` LEFT  JOIN coa ON inc_dec.ncas_acct = coa.ncasnumWHERE 1  AND coa.track_rcc =  'y' AND inc_dec.disu_app =  '1'GROUP  BY inc_dec.ncas_acct, inc_dec.center";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");echo "<html><head><title></title><meta  HTTP-EQUIV=\"REFRESH\" content=\"2;  url=$hostURL/budget/cleanup_scripts/oxt3.php?s=8\"></head><body>Step $s of 10 completed.<br><br>$sql<br><br>Please wait while we perform step $p.</body></html>";exit;}// end s=7if($s==8){$sql =  "INSERT  INTO oxt3( ncasnum,center,spent0203, spent0304, spent0405, spent0506, parkinc0506, distinc0506, ware0405, ware0506 ) SELECT warehouse_billings_0405.ncasnum, warehouse_billings_0405.center, '','','','','','',sum( warehouse_billings_0405.pricexquantity )  AS ware0405,''FROM  `warehouse_billings_0405` LEFT  JOIN coa ON warehouse_billings_0405.ncasnum = coa.ncasnumWHERE 1  AND coa.track_rcc =  'y'GROUP  BY warehouse_billings_0405.ncasnum, warehouse_billings_0405.center";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");echo "<html><head><title></title><meta  HTTP-EQUIV=\"REFRESH\" content=\"2;  url=$hostURL/budget/cleanup_scripts/oxt3.php?s=9\"></head><body>Step $s of 10 completed.<br><br>$sql<br><br>Please wait while we perform step $p.</body></html>";exit;}// end s=8if($s==9){$sql =  "INSERT  INTO oxt3( ncasnum,center,spent0203, spent0304, spent0405, spent0506, parkinc0506, distinc0506, ware0405, ware0506 ) SELECT warehouse_billings_0506.ncasnum, warehouse_billings_0506.center, '','','','','','','',sum( warehouse_billings_0506.pricexquantity )  AS ware0506FROM  `warehouse_billings_0506` LEFT  JOIN coa ON warehouse_billings_0506.ncasnum = coa.ncasnumWHERE 1  AND coa.track_rcc =  'y'GROUP  BY warehouse_billings_0506.ncasnum, warehouse_billings_0506.center";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");echo "<html><head><title></title><meta  HTTP-EQUIV=\"REFRESH\" content=\"2;  url=$hostURL/budget/cleanup_scripts/oxt3.php?s=10\"></head><body>Step $s of 10 completed.<br><br>$sql<br><br>Please wait while we perform step $p.</body></html>";exit;}// end s=9if($s==10){$sql =  "SELECT oxt3.ncasnum, coa.park_acct_desc AS description, center.section, center.dist, center.parkcode, oxt3.center, sum( oxt3.spent0203 )  AS spent0203, sum( oxt3.spent0304 )  AS spent0304, sum( oxt3.spent0405 )  AS spent0405, sum( oxt3.ware0405 )  AS ware0405, sum( oxt3.spent0405 )  + sum( oxt3.ware0405 )  AS total_spent0405, sum( oxt3.spent0405 )  + sum( oxt3.parkinc0506 )  + sum( oxt3.distinc0506 )  - sum( oxt3.spent0405 )  - sum( oxt3.ware0405 )  AS inc0506, round( ( ( sum( oxt3.spent0405 )  + sum( oxt3.parkinc0506 )  + sum( oxt3.distinc0506 )  - sum( oxt3.spent0405 )  - sum( oxt3.ware0405 )  )  / ( sum( oxt3.spent0405 )  + sum( oxt3.ware0405 )  + sum(  '.01'  )  )  ) *100 ) AS inc0506_perc, sum( oxt3.spent0405 )  + sum( oxt3.parkinc0506 )  + sum( oxt3.distinc0506 )  AS request0506, sum( oxt3.spent0506 )  AS spent0506, sum( oxt3.ware0506 )  AS ware0506, sum( oxt3.spent0506 )  + sum( oxt3.ware0506 )  AS total_spent0506, sum( oxt3.spent0405 )  + sum( oxt3.parkinc0506 )  + sum( oxt3.distinc0506 )  - sum( oxt3.spent0506 )  - sum( oxt3.ware0506 )  AS availableFROM  `oxt3`LEFT  JOIN center ON oxt3.center = center.centerLEFT  JOIN coa ON oxt3.ncasnum = coa.ncasnumWHERE 1  AND coa.track_rcc =  'y' AND oxt3.ncasnum NOTLIKE  '534%'GROUP  BY oxt3.ncasnum, oxt3.center";$resultDB = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");include("../menu.php");echo "<table border='1'>";echo "<tr><th>ncasnum</th><th>park_acct_desc</th><th>section</th><th>dist</th><th>parkcode</th><th>center</th><th>spent0203</th><th>spent0304</th><th>spent0405</th><th>ware0405</th><th>NWinc0506</th><th>inc0506</th><th>request0506</th><th>spent0506</th><th>ware0506</th><th>total_spent0506</th><th>remaining</th></tr>";while($row=mysqli_fetch_array($resultDB)){extract($row);echo "<tr><td>$ncasnum</td><td>$park_acct_desc</td><td>$section</td><td>$dist</td><td>$parkcode</td><td>$center</td><td>$spent0203</td><td>$spent0304</td><td>$spent0405</td><td>$ware0405</td><td>$NWinc0506</td><td>$inc0506</td><td>$request0506</td><td>$spent0506</td><td>$ware0506</td><td>$total_spent0506</td><td>$remaining</td></tr>";}echo "</table></body></html>";}// end 10?>
<?php//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;extract($_REQUEST);if($ncasnum){include("../../../../include/connectBUDGET.inc");// database connection parameters$sql1 = "SELECT * from warehouse_billings_0405 where center='$center' and ncasnum='$ncasnum'";//echo "$sql1<br>";//EXIT;$result1 = mysql_query($sql1) or die ("Couldn't execute query 1. $sql1");$colHeaders=array("NCAS<br>Number","Invoice<br>Number","Product<br>Number","Product<br>Name","Price","Quantity","Price<br>x<br>Quantity");portalHeader($colHeaders,$center);while ($row1=mysql_fetch_array($result1)){extract($row1);$totalWH=$totalWH+$PricexQuantity;echo "<tr><td>$ncasnum</td><td>$InvoiceNum</td><td>$ProductNum_0405</td><td>$ProductName</td><td align='right'>$Price</td><td align='right'>$Quantity</td><td align='right'>$PricexQuantity</td></tr>";}echo "<tr><td colspan='6'>&nbsp;</td><td align='right'>$totalWH</td></tr><tr><td colspan='7' align='center'>Close this window when done viewing.</td></tr></table></body></html>";exit;}include("menu.php");$colHeaders=array("Park Code","NCAS #","Description","Spent Last Year");$join1="LEFT JOIN coa ON coa.ncasnum = warehouse_billings_0405.ncasnum";$join2="LEFT JOIN center ON center.center = warehouse_billings_0405.center";$where="WHERE 1";if($center AND $center!="Select Center"){$where.=" AND warehouse_billings_0405.center = '$center'";}$g="GROUP  BY coa.ncasnum";//echo "w=$where";if(!$submit){exit;};// ******** Get Amount Spent in Last Year$fromSQL1="center.center,description,parkcode,coa.ncasnum,sum(price * quantity) as pq FROM `warehouse_billings_0405`";$where1=$where;portalHeader($colHeaders,$center);$sql1 = "SELECT $fromSQL1 $join1 $join2 $where1 $g";//echo "$sql1<br>";//EXIT;$result1 = mysql_query($sql1) or die ("Couldn't execute query 1. $sql1");$num=mysql_num_rows($result1);while ($row1=mysql_fetch_array($result1)){extract($row1);$totalWH=$totalWH+$pq;$link="<a href=\"portalReports/a/warehouse.php?center=$center&ncasnum=$ncasnum\" onClick=\"popup = window.open('portalReports/a/warehouse.php?center=$center&ncasnum=$ncasnum', 'PopupPage', 'height=800,width=700,scrollbars=yes,resizable=yes'); return false\" target=\"_blank\"> $ncasnum</a>";echo "<tr><td>$parkcode</td><td>$link</td><td>$description</td><td align='right'>$pq</td></tr>";}echo "<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td align='right'>$totalWH</td></tr><tr><td colspan='4' align='center'>Click your browser's Back button when done viewing.</td></tr><td colspan='4' align='center'>Click on the NCAS # to view all purchases for that account for last year.</td></tr></table></body></html>";// *************** CID FUNCTIONS **************function portalHeader($colHeaders,$center){global $numOfColumns;$fld=explode(",",$colHeaders);// Put Field Names in an Array$c=count($fld)-1;$lastFld=$fld[$c];$numOfColumns=count($colHeaders);echo "Warehouse Purchases for $center<table border='1' cellpadding='3'><tr>";for($x=0;$x<$numOfColumns;$x++){$var=strtoupper($colHeaders[$x]);echo "<th>$var</th>";}echo "</tr>";}?>
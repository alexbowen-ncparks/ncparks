<?php
if($menu_sc=='SC1'){$shade_SC1="class='cartRow'";}
if($menu_sc=='SC2'){$shade_SC2="class='cartRow'";}
if($menu_sc=='SC3'){$shade_SC3="class='cartRow'";}
if($menu_sc=='SC4'){$shade_SC4="class='cartRow'";}
if($menu_sc=='SC5'){$shade_SC5="class='cartRow'";}
if($menu_sc=='SC6'){$shade_SC6="class='cartRow'";}
echo "<table align='center' border='1'>";	
echo "<tr>";
echo "<th><a href='/budget/service_contracts/service_contracts1.php?menu_sc=SC1'><img height='75' width='125' src='dumpster.jpg' alt='picture of trash dumpster'></img><br />Service Contracts</a></th>";
//echo "<th><a href='service_contracts1.php?menu_sc=SC1'><font $shade_SC1>Contracts</font></a></th>";
echo "<th><a href='service_contracts1.php?menu_sc=SC1'><font $shade_SC1>PurchaseOrder<br />Lines</font></a></th>";
//echo "<th><a href='service_contracts2.php?menu_sc=SC2'><font $shade_SC2>SC2</font></a></th>";
//echo "<th><a href='service_contracts.php?menu_sc=SC3'><font $shade_SC3>SC3</font></a></th>";
//echo "<th><a href='current_invoice.php?menu_sc=SC4'><font $shade_SC4>SC4</font></a></th>";
//echo "<th><a href='all_invoices.php?menu_sc=SC5'><font $shade_SC5>SC5</font></a></th>";
//echo "<th><a href='all_invoices.php?menu_sc=SC5'><font $shade_SC5>Invoices</font></a></th>";
//echo "<th><a href='service_contracts6.php?menu_sc=SC6'><font $shade_SC6>SC6</font></a></th>";
//echo "<th><a href='service_contracts.php' target='_blank'><font $shade_SC7>SC7</font></a></th>";
echo "</tr>";	
echo "</table>";
?>
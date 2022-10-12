<?php


// class=cartRow comes from StyleSheet in following File:   include ("../../budget/menu1415_v1_new.php");


if($menu_sc=='search'){$shade_search="class='cartRow'";}
if($menu_sc=='add'){$shade_add="class='cartRow'";}
if($menu_sc=='update'){$shade_update="class='cartRow'";}
if($menu_sc=='po_lines'){$shade_po_lines="class='cartRow'";}
if($menu_sc=='po_invoice'){$shade_po_invoice="class='cartRow'";}
if($menu_sc=='po_invoice_update'){$shade_po_invoice_update="class='cartRow'";}
if($menu_sc=='invoice_search'){$shade_invoice_search="class='cartRow'";}


if($menu_sc=='search' or $menu_sc=='add' or $menu_sc=='update' or $menu_sc=='invoice_search')
{
echo "<table align='center' border='1'>";	
echo "<tr>";
echo "<th><a href='/budget/service_contracts/service_contracts1_search.php'><img height='75' width='125' src='dumpster.jpg' alt='picture of trash dumpster'></img><br />Service Contracts</a></th>";
echo "<th><font $shade_search><a href='service_contracts1_search.php?menu_sc=search'>Search</a></font></th>";
echo "<th><font $shade_add><a href='service_contracts1_add.php?menu_sc=add'>Add</a></font></th>";
echo "<th><font $shade_invoice_search><a href='service_contracts1_invoice_search.php?menu_sc=invoice_search'>Invoices</a></font></th>";
echo "</tr>";
echo "</table>";
}

if($menu_sc=='search_results')
{
echo "<table align='center' border='1'>";
echo "<tr>";
echo "<th>";
echo "<a href='/budget/service_contracts/service_contracts1_search.php'><img height='75' width='125' src='dumpster.jpg' alt='picture of trash dumpster'></img><br />Service Contracts</a>";
echo "</th>";
echo "</tr>";
echo "</table>";		
}

if($menu_sc=='po_lines')
{
echo "<table align='center' border='1'>";	
echo "<tr>";
echo "<th><a href='/budget/service_contracts/service_contracts1_search.php'><img height='75' width='125' src='dumpster.jpg' alt='picture of trash dumpster'></img><br />Service Contracts</a></th>";
echo "<th><font $shade_po_lines>PurchaseOrder<br />Lines</font></th>";
echo "</tr>";	
echo "</table>";
}


if($menu_sc=='po_invoice')
{
echo "<table align='center' border='1'>";	
echo "<tr>";
echo "<th><a href='/budget/service_contracts/service_contracts1_search.php'><img height='75' width='125' src='dumpster.jpg' alt='picture of trash dumpster'></img><br />Service Contracts</a></th>";
echo "<th><font $shade_po_invoice>PurchaseOrder<br />Pay</font></th>";
echo "</tr>";	
echo "</table>";
}

if($menu_sc=='po_invoice_update')
{
echo "<table align='center' border='1'>";	
echo "<tr>";
echo "<th><a href='/budget/service_contracts/service_contracts1_search.php'><img height='75' width='125' src='dumpster.jpg' alt='picture of trash dumpster'></img><br />Service Contracts</a></th>";
echo "<th><font $shade_po_invoice_update>PurchaseOrder<br />Pay</font></th>";
echo "</tr>";	
echo "</table>";
}




?>
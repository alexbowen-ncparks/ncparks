<?php
include("_base_top.php");

	
	echo "<table>";
	
	echo "<tr><form action='section_work_orders.php' method='POST' target='_blank'><td colspan='3'>Graph <strong>number</strong> of Work Orders by Section.</td>";
	echo "<td>
	<input type='submit' name='submit' value='Submit'></td></form></tr>";
	
	echo "<tr><form action='num_hrs_project_work_orders.php' method='POST' target='_blank'><td colspan='3'>Graph Work Order by <strong>Number of work orders by hours reported</strong>.</td>";
	echo "<td>
	<input type='submit' name='submit' value='Submit'></td></form></tr>";
	
	echo "<tr><form action='hrs_section_work_orders.php' method='POST' target='_blank'><td colspan='3'>Graph Work Order <strong>hours</strong> by Section.</td>";
	echo "<td>
	<input type='submit' name='submit' value='Submit'></td></form></tr>";
	echo "</table></div></body></html>";


?>
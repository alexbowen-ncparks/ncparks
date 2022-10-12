<?php
ini_set('display_errors',1);
$database="dpr_it";
include("../../include/auth.inc");
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
include("../../include/iConnect.inc");

mysqli_select_db($connection,$database);

include("_base_top.php");
echo "<style>
.head {
font-size: 22px;
color: #999900;
}
</style>";
echo "<div>";
echo "<table>";
echo "<tr><td class='head'>Welcome to the DPR/MNS IT website.</td></tr>";
echo "<tr>
		<td>
			<p>
				<font color='#99cc00' size='+1'>Inventory Validation</font>
			</p>
			<p>Each park Superintendent will have to check the inventory at his/her park and then validate whether the inventory shown in the database is correct. 
			</p>
			<p>1.  The Superintendent or his/her designee will do a physical check of the computer and printer inventory at the park and compare it to what is reported in the database.
			</p>
			<p>2.  If there is a discrepancy, it will be discussed with DPR/MNS IT.  The discrepancies will be researched to an agreed upon conclusion.
			</p>
			<p>3.  The inventory will then be confirmed by the Superintendent.  To confirm the inventory, the Superintendent will place the current date in the date field on the confirm inventory tab, then click the “Confirm” button.
			</p>
			<p>4.  The process will be completed for printers.
			</p>
			<p>5.  When inventory is moved in or out of the park, this process will be completed again at that time.</p>
			<p>
			</p>
		<!--
			<p>
				<font color='#99cc00' size='+1'>Surplus</font>
			</p>
			<p>1.  The Superintendent or Superintendent’s designee will begin the surplus process for a computer or printer by changing the status to “To Be Surplused”. </p>
			<p>2.  The Superintendent will then upload the completed DPR/MNS IT Surplus form (<a href='DPR_IT_Suplus_Form_bb.xlsx'>download</a>) to the database.  This form contains the Superintendent’s dated signature.
			</p>
			<p>3.  The DPR/MNS IT staff will check the database at least once per week to review any inventory items marked as “To Be Surplused”.  The items will be evaluated for whether they will be surplused or transferred to a new location.  If they are to be surplused the status for their item will be changed from “To Be Surplused” to “Surplus Process”.  Park staff will not be able to do this.
			</p>
			<p>4.  The computer/printer will be sent to YORK for completion of Surplus Processing.
			</p>
			<p>5.  When a computer is received by DPR/MNS IT staff, the user name for the computer will be changed to the name “Surplus” plus a month and year, e.g., “Surplus: 5 18”.  The name will represent the surplus batch that is being done at that time.  All computers being surplused at that time will have this user name.  For printers, the “Name Used by Print Server” field will be used for the surplus batch name.
			</p>
			<p>6.  The items will be inventoried at YORK by the DPR/MNS IT staff.   Hard drives will be removed from any items containing them, and DPR/MNS IT staff will signature appropriate documents to validate that the drives were removed. 
			</p>
			<p>7.  The items to be surplused will be submitted to DPR budget staff for review and submission to the state property office for surplus stickers. 
			</p>
			<p>8.  Once the surplus stickers have been received, DPR/MNS IT staff will plan a date to place stickers on the items and transport them to the state surplus center.
			</p>
			<p>9.  After the items are delivered to the State Surplus Center and a receipt is received for the batch, the database location fields for the items in the batch will be changed from the Park where they previously resided, to “Surplus” and the status filed will be changed from “Surplus Process” to “Suplused”.  
			</p>
			<p>10.  The receipt from State Surplus center will be uploaded to the database and associated with each item's surplus batch.
			</p>
		-->
		
		</td>
	</tr>";
//echo "<tr><td>To add an item, click on the \"Add Item\" tab to the left.</td></tr>";
echo "<tr><td></td></tr>";
echo "</table>";
echo "</div>";
?>
<?php

/********************************************************************************
Name: John Carter             Related Ticket(s): Jira TIC - 33 & 34
Date: 20220916
Description: DPR-IT (Carl Jeeter) asked to have 3 options removed from the 'printer status': 'surplus','surp_tobe','surp_process'

[Include files]
- NONE

[Arrays created/used] 
- $ARRAY_computer_status_rename
- $ARRAY_printer_status_rename
- $search_printers_dropdown
- 

[Databases accessed]
- NONE

---------------------------------------------------------------------------
                                Change Log
---------------------------------------------------------------------------
{youngest}
20220916 - [TIC<34>] : removed three options for 'computer status': 'surplus', 'surplus_tobe', 'surplus process'
20220619 – [TIC<33>] : <description of change>
{oldest}
******************************************************************************/

$ARRAY_computer_status_rename=array("" => "blank",
									"bwo" => "Being Worked On",
									"rec_p" => "Received at Park",
									"sent_r" => "Sent to Raleigh",
									"rec_r" => "Received in Raleigh",
									"sent_p" => "Sent to Park",
									"deploy" => "Deployed",
									"WAHO_I" => "WAHO Inventory",
// 20220916: jgcarter
// - commented out the 3 options requested to no longer show
									"surp_tobe" => "To be Surplused",
									"surp_process" => "Surplus Process",
									"surplus" => "Surplused"
// 20220916: jgcarter - END
								);

$ARRAY_printer_status_rename = $ARRAY_computer_status_rename;


?>
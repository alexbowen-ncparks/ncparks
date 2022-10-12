<?php
extract($_GET);
$text="PARK SUPERINTENDENTS
1.  Identify the seasonal positions needed to operate during this cycle (".$s." and ".$e.").
2.  Check the checkbox next to all positions needed and those currently working that you wish to retain in the next cycle.
3.  Enter a start date for each position (REQUIRED)
4.  Enter budgeted hours each week (REQUIRED)
5.  Enter budgeted weeks following the pay periods shown in the payroll calendar. (REQUIRED) <a href='http://www.osc.nc.gov/BEST/support/payroll/PY_Calendar_Jan_Dec_Ind_2013.pdf' target='_blank'>link to calendar</a>
6.  If this position will be used as an 11 month position indicate “y” or “n” (REQUIRED)
7.  Type a <b>brief detailed justification</b> in the Park Justification block (REQUIRED)
8.  Email the District Superintendent and District Office Assistant when all of your position requests are ready for district review and approval.
 
DISTRICT SUPERINTENDENTS
1.  Review all required steps listed above.  Please assist the park with incomplete requests or questions.  Once you review and approve all district park requests email a message to Denise Williams at denise.williams@ncparks.gov to prepare a report for the CHOP to review and approve.  If you have questions or need further assistance contact me at 919-707-9341 or email your questions.  
 
CHOP will notify the District Superintendents when the seasonal budget is approved for hire.  The DISU will email all parks.
 ";

$new=nl2br($text);

echo "$new";
?>
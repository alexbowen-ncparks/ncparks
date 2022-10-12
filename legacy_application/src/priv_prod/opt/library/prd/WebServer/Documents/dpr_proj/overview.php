<?php
// session_start();
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$database="dpr_proj";
$title="DPR Project Tracking Application";
include("../_base_top.php");
echo "<p>Welcome to the internal <b>DPR Project Application Tracking</b> application for the Division of Parks and Recreation. This application will be utilized to track the following components of projects at NC State Parks:</p>
<p>The program tracks the approval process; it does not track the project beyond the approval process.</p>

<p>
&nbsp;&nbsp;&nbsp;Project name</p>
&nbsp;&nbsp;&nbsp;GIS identifier</p>
&nbsp;&nbsp;&nbsp;Project type</p>
&nbsp;&nbsp;&nbsp;Summary of project</p>
&nbsp;&nbsp;&nbsp;Project lead person</p>
&nbsp;&nbsp;&nbsp;<b>Approvals</b></p>
&nbsp;&nbsp;&nbsp;Start date</p>
&nbsp;&nbsp;&nbsp;Estimated cost</p>
&nbsp;&nbsp;&nbsp;Funding source<br />

<br />
Support material uploads include:
<p>
&nbsp;&nbsp;&nbsp;Project Description</p>
&nbsp;&nbsp;&nbsp;Drawings (water control structures, traps, etc)</p>
&nbsp;&nbsp;&nbsp;Map(s)</p>
&nbsp;&nbsp;&nbsp;Resource Management Review form</p>
&nbsp;&nbsp;&nbsp;Trails Review Form
";

?>
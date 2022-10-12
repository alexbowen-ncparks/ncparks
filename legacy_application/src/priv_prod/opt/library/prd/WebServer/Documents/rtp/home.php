<?php
ini_set('display_errors',1);
$database="rtp";
//echo "Hello"; exit;
include("../../include/iConnect.inc");

mysqli_select_db($connection,$database);

include("_base_top.php");
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$level=$_SESSION['rtp']['level'];
echo "<style>
.head {
font-size: 22px;
color: #999900;
}
</style>";

if($level<1)
	{
	include("home_nctc.php");
	exit;
	}
	
echo "<div>";
echo "<p><strong>RTP Grants</strong></p>
<p>Using the menu column on the left side of the screen, one is linked to view Projects or Scores. Selecting \"Home\" will always return you to this page.</p>

<p>By selecting \"Projects,\" one is taken to a table view of the projects for the cycle year. Each row shows a project with a short summary. Selecting \"Show/Hide\" allows one to expand or minimize the given section. See below on how to \"view projects\" & \"attachments.\"</p>

<p>By selecting \"Scores,\" one is taken to a table view of the project's scores. Each row shows a project's cumulative objective & subjective score. Selecting a project shows one the scoring options. See below on how to \"score projects.\"</p>

<p>Searching: (within Projects or Scores):<br />
Search options can be used in conjunction with one another: Year, File Name, Project Name, Region, or Project User.</p>

<p>Once search criteria have been chosen, select \"Search\", and projects are returned according to chosen criteria parameters.
Selecting \"Reset\" will clear search options previously selected.</p>

<p>Viewing Projects:<br />
In the left column, each project can be selected in order to view the entire project's application. 
Once a project has been selected, you will be shown options across the top of the page. By selecting an option, one can view the projects information.</p>

<p>Viewing attachments:<br />
Within each Project, the included documents supporting a project can be viewed by selecting \"Attachments.\"
The Attachments section allows one to view the included documents with each project & compare the list to the list submitted by an Applicant with their application. </p>

<p>Scoring Projects:<br />
Objective Scores<br />
Staff are able to adjust Objective Scores with a justification for the change in each category.
This adjusts the information in the Projects section. The original information is already backed up. This does not change the information on the .pdf application. </p>
<p>Subjective Scores<br />
Staff are able to view others scores, but can only enter/edit their own. Three types of comment options are provided at the bottom of the screen. </p>
<p>IMPORTANT: \"Comments to NCTC\" are viewable by the committee members. </p>

<p><strong>IMPORTANT:</strong> For security reasons the website automatically logs you out after 25 minutes of inactivity. Be sure to update any form that you are using before leaving your computer for longer than 25 minutes.</p>
<p>
If you have any questions, comments, or need help; 
please contact 919-707-9316 or database.support@ncparks.gov</p>";
echo "</div>";
?>
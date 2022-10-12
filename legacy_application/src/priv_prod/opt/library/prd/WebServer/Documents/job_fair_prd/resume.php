
<?php

$database="job_fair";

error_reporting(-1);
ini_set('display_errors', true);

require($_SERVER['DOCUMENT_ROOT'] . "/job_fair/_common.php");

page_header("Resume Viewer");

if (isset($_REQUEST['rowid']))
 {
  show_resume($_REQUEST['rowid']);
 } else {
  $rowid=0;
 }

site_footer();

?>


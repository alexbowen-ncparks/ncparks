<?php

$database="job_fair";

error_reporting(-1);
ini_set('display_errors', true);

require($_SERVER['DOCUMENT_ROOT'] . "/job_fair/_common.php");

page_header("Job Fair applications home");

search_box();

mktable(@$_GET['search']);

site_footer();

?>

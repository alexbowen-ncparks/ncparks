<?php
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
$database="dpr_tests"; 
$dbName="dpr_tests";
include("_base_top.php");

echo "<style>
.head {
padding: 5px;
font-size: 22px;
color: #999900;
}

td
{
padding: 3px;
}
 tr.d0 td {
  background-color: #ddddbb;
  color: black;
}
.table {
    border: 1px solid #8e8e6e; 
	margin: 5px 5px 5px 5px;
	background-color:#eeeedd;
	border-collapse:collapse;
  color: black;
}

table.alternate tr:nth-child(odd) td{
background-color: #ddddbb;
}
table.alternate tr:nth-child(even) td{
background-color: #eeeedd;
}

.search_box {
    border: 1px solid #8e8e6e;
	background-color:#f2e6ff;
	border-collapse:collapse;
  color: black;
}
.table_uno {
    border: 1px solid #8e8e6e; 
	margin: 5px 5px 5px 5px;
	background-color:#e0ebeb;
	border-collapse:collapse;
  color: black;
}
.ui-datepicker {
  font-size: 80%;
}
</style>";

ini_set('display_errors',1);
date_default_timezone_set('America/New_York');
include("../../include/iConnect.inc"); // include iConnect.inc with includes no_inject.php
mysqli_select_db($connection,$dbName);

$question_type_array=array("multiple_choice","true_false","fill_in","cross_match","double_multiple_choice","checkbox");
$rename_array=array("qid"=>"","question_order"=>"Question Order","question"=>"Question","a"=>"A","b"=>"B","c"=>"C","d"=>"D","e"=>"E","answer"=>"Answer","comment"=>"Comment","question_type"=>"Question Type");


// echo "test.php<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;

if($page=="test")
	{
	if(!empty($test_id) and !empty($take))
		{
		include("take_test.php");
// 		echo "t=$take";
		}
		else
		{
		if(!empty($com))
			{
// 			echo "edit_completed_test";
			include("edit_completed_test.php");
			}
			else
			{
			include("show_test.php");
			}
		}
	}
if($page=="search")
	{
	include("search_tests.php");
	}
if($page=="add")
	{
	include("add_test.php");
	}
if($page=="edit_question")
	{
	include("edit_question.php");
	}
if($page=="add_question")
	{
	include("add_question.php");
	}
if($page=="nondpr")
	{
	include("nondpr.php");
	}

?>
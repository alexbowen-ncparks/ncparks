<?php$database="budget";$db="budget";$table="pcard_holders_dncr2";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // database//include("../../budget/menu1314.php");?><head> <link type="text/css" href="/css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />    <script type="text/javascript" src="/js/jquery-1.8.0.min.js"></script><script type="text/javascript" src="/js/jquery-ui-1.8.23.custom.min.js"></script>  </head> <?php$query7="SELECT distinct last_name as 'search_keywords'FROM pcard_holders_dncr2_testwhere 1ORDER BY park";$result7 = mysqli_query($connection, $query7) or die ("Couldn't execute query 7. $query7");$values=array();while ($row7=mysqli_fetch_array($result7))	{	$choices7[]=$row7['search_keywords'];	}	//print_r($choices1);exit;		$choices7a = implode(",",$choices7);//exit;$choices7a = "'".$choices7a."'";$choices7a = str_replace(",","','",$choices7a);//echo "$choices3a<br />";echo "<script>";echo "$(function(){	$('#last_name').autocomplete({		source: [$choices7a],		close: function(event, ui) {			$('#search_keyword_form').submit();		}	});});";echo "</script>";/*echo "<form name='search_keyword_form' id='search_keyword_form' method='post' action='notes.php'>";*/echo "<form name='search_keyword_form' id='search_keyword_form' method='post' action='notes.php'>";echo "<input type='text' id='last_name' name='keyword_chosen' placeholder='Search by keyword' size='30' /><input type='hidden' name='project_note' value='note_tracker' />";//echo "<input type='submit' name='submit' value='submit'>";echo "</form>";?>
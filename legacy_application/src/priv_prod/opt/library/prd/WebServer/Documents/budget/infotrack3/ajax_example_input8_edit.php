<?phpsession_start();if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;//header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");}$tempID=$_SESSION['budget']['tempID'];$tempID2=substr($tempID,0,-2);$system_entry_date=date("Ymd");//echo "<pre>";print_r($_REQUEST);"</pre>";exit;$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // database 	// Retrieve data from Query String$comment_note2 = $_GET['comment_note2'];$project_category = $_GET['project_category'];$project_name = $_GET['project_name'];$note_group = $_GET['note_group'];$project_note_id = $_GET['project_note_id'];	// Escape User Input to help prevent SQL Injection$comment_note2 = mysqli_real_escape_string($comment_note2);	//build query//$query = "SELECT * FROM ajax_example WHERE 1";//$query = "insert ignore into infotrack_projects_community (user,system_entry_date,project_category,project_name,project_note,weblink,note_group,comment_note,comment_id) values ('$myusername','$system_entry_date','science_fiction','knight_rider', '','','web','$comment_note2','219')";/*$query = "insert ignore into infotrack_projects_community4 (user,system_entry_date,project_category,project_name,project_note,weblink,note_group,comment_note,comment_id) values ('$tempID2','$system_entry_date','$project_category','$project_name', '','','$note_group','$comment_note2','$project_note_id')";*/$query = "insert ignore into infotrack_projects_community4 (user,system_entry_date,project_category,project_name,project_note,weblink,note_group,comment_note,comment_id) values ('$tempID2','$system_entry_date','$project_category','$project_name', '','','$note_group','edit note 1950','$project_note_id')";	/*if(is_numeric($age))	$query .= " AND ae_age <= $age";if(is_numeric($wpm))	$query .= " AND ae_wpm <= $wpm";	//Execute query*/$qry_result = mysqli_query($connection, $query) or die(mysqli_error());	//Build Result String	/*$display_string = "<table>";$display_string .= "<tr>";$display_string .= "<th>Name</th>";$display_string .= "<th>Age</th>";$display_string .= "<th>Sex</th>";$display_string .= "<th>WPM</th>";$display_string .= "</tr>";	// Insert a new row in the table for each person returnedwhile($row = mysqli_fetch_array($qry_result)){	$display_string .= "<tr>";	$display_string .= "<td>$row[ae_name]</td>";	$display_string .= "<td>$row[ae_age]</td>";	$display_string .= "<td>$row[ae_sex]</td>";	$display_string .= "<td>$row[ae_wpm]</td>";	$display_string .= "</tr>";	}echo "Query: " . $query . "<br />";$display_string .= "</table>";echo $display_string;*/?>

<?phpsession_start();$myusername=$_SESSION['myusername'];$lines_needed=$_POST['lines_needed'];$project_category=$_POST['project_category'];$project_name=$_POST['project_name'];$user_id=$_POST['user_id'];$system_entry_date=date("Ymd");if(!isset($myusername)){header("location:index.php");}//extract($_REQUEST);//echo "<pre>";print_r($_SESSION);print_r($_POST);echo "</pre>";exit;include("../../include/connect.php");$database="mamajone_cookiejar";////mysql_connect($host,$username,$password);@mysql_select_db($database) or die( "Unable to select database");$query1="INSERT INTO project_notes (user,author,system_entry_date,project_category,project_name)         values ('$user_id','$myusername','$system_entry_date','$project_category','$project_name')";		 	//mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");	 		for($j=1;$j<=$lines_needed;$j++){mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $queryl");}	?>
<?phpextract($_REQUEST); session_start(); if($name=="logout"){$_SESSION['loginS'] = '';$_SESSION['parkS'] = '';header("Location: main.php?logout=1"); exit;  }       include("../../include/connectDIVPER.62.inc"); // new login method /*echo "<pre>";print_r($_REQUEST); echo "</pre>";exit;*/if($submit=="Change Password"){if($npassword0==$npassword1){$query = "UPDATE divper.emplist SET password='$npassword0' WHERE tempID='$ftempID'";$result = mysql_query($query) or die ("Couldn't execute query. $query");$fpassword=$npassword0;// execution then passes beyond else}else{$message_new = "You did not enter the same password for New and Retype.<br>";header("Location: changePassword.php?message_new=$message_new&ftempID=$ftempID&fpassword=password&dbName=$dbName");exit;}}//$park = strtoupper($park);$upperID = strtoupper($ftempID);$sql = "SELECT * FROM divper.emplist where tempID='$ftempID'";$result = mysql_query($sql) or die("Error 1: $sql");//echo "$sql"; exit;$row=mysql_fetch_array($result); /*echo "<pre>";print_r($row); echo "</pre>";exit; */extract($row);$UtempID = strtoupper($tempID);if($upperID==$UtempID){// login is correctif($password=="password"){header("Location: changePassword.php?dbName=$dbName&ftempID=$ftempID&fpassword=password");exit;}if($fpassword!=$password){ $message_new = "The Username and/or Password you entered is/are not correct! Make sure of your spelling. If the problem persists, send an email to the contact person listed below.<br>";         include("login_form.php"); exit;}                  // Login Correctinclude("../../include/connectPHOTOS.inc"); // database connection parametersenterLogin($tempID,$dbName);// function to log usercreateMember($tempID,$currPark,$dbName); // function to create member tracking// $$dbName = a variable variable  (db name comes from login_form.php)// access privileges are set in divper.emplistif ($$dbName == 3){           $_SESSION['loginS'] = 'ADMIN';           header("Location: adminMenu.php");exit;}if ($$dbName == 2){           $_SESSION['loginS'] = 'DIST';           header("Location: distMenu.php");$_SESSION['parkS'] = $currPark;exit;}$_SESSION['parkS'] = $currPark;$_SESSION['loginS'] = 'OKed';    header("Location: menu.php");exit;               }      else  // login not correct      {            unset($do);                                            // 53         $message_new = "The Username and/or Password you entered is/are not correct! Make sure of your spelling. If the problem persists, send an email to the contact person listed below.<br>";         include("login_form.php");  }  function enterLogin($tempID,$dbName){ $today = date("Y-m-d H:i:s");           $userAddress = $_SERVER['REMOTE_ADDR'];           $sql = "INSERT INTO $dbName.login (loginName,loginTime,userAdd)                   VALUES ('$tempID','$today','$userAddress')";           mysql_query($sql) or die("Can't execute query 3. $sql");           $_SESSION['logname']=$tempID;}function createMember($tempID,$currPark,$dbName){           $sql = "INSERT INTO $dbName.member (loginName,park)                   VALUES ('$tempID','$currPark')";           mysql_query($sql);           // [No record inserted if dupe of name and park] or die("Can't execute query 4. $sql")}?>
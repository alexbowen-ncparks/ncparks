<?php if(empty($_SESSION)){session_start();}if($_SESSION['sysexp']['level']<1){exit;}include("../../include/iConnect.inc");// Edit inputif($Submit =="Update"){//print_r($_REQUEST); exit;$question=addslashes($question);$execSum=addslashes($execSum);$siteComment=addslashes($siteComment);$superComment=addslashes($superComment);$superCommentExec=addslashes($superCommentExec);mysqli_select_db($connection, "sysexp");$query = "UPDATE site SET quad='$quad',county='$county',region='$region',sizeMax='$sizeMax',sizeMin='$sizeMin',ownerCP='$ownerCP',ownerPP='$ownerPP',`sensitive`='$sensitive',included='$included',siteNum='$siteNum',threat='$threat',interconnect='$interconnect',demand='$demand',type='$type',question='$question',execSum='$execSum',siteComment='$siteComment',superComment='$superComment',superCommentExec='$superCommentExec',completed='$completed',threatExecSum='$threatExecSum' WHERE sid=$sid";// echo "$query"; exit;$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");$ok = mysqli_affected_rows($connection);echo "<form><input type='button' value='Go Back' onclick=\"location='edit.php?sid=$sid'\"></form></body>"; header("Location:edit.php?sid=$sid&v=e"); exit;} // end Update// Delete Recordif($Submit =="Delete"){// $query = "SELECT name from site WHERE sid=$sid";// $result = mysqli_query($query) or die ("Couldn't execute query. $query");// $row = mysqli_fetch_array($result);// extract($row);$query = "DELETE from arc WHERE sid='$sid'";$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");$query = "DELETE from bio WHERE sid='$sid'";$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");$query = "DELETE from geo WHERE sid='$sid'";$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");$query = "DELETE from sce WHERE sid='$sid'";$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");$query = "DELETE from site WHERE sid='$sid'";$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");$query = "DELETE from spe WHERE sid='$sid'";$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");$query = "DELETE from rec WHERE sid='$sid'";$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");header("Location:editMenu.php"); exit;  }echo "</body></html>";?>
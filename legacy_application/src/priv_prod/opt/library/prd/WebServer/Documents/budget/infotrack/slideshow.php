<?php//$beacnum='60032793';//$level='5';session_start();//echo "<pre>";print_r($_SESSION);"</pre>";exit;if(!$_SESSION["budget"]["tempID"]){header("location: https://legacypriv36.dev.dpr.ncparks.gov/login_form.php?db=budget");}$active_file=$_SERVER['SCRIPT_NAME'];$level=$_SESSION['budget']['level'];$posTitle=$_SESSION['budget']['position'];$tempID=$_SESSION['budget']['tempID'];$beacnum=$_SESSION['budget']['beacon_num'];$concession_location=$_SESSION['budget']['select'];$concession_center=$_SESSION['budget']['centerSess'];$player=$_SESSION['budget']['tempID'];//echo "<pre>";print_r($_REQUEST);"</pre>";exit;extract($_REQUEST);$comment="y";$add_comment="y";$folder="community";$category_selected="y";$name_selected="y";$database="budget";$db="budget";//echo "hid=$hid";echo "<br />";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // database$today=date("Y-m-d");$query1="SELECT max(hid)as 'hidmax' from slideshow where 1 and date <= '$today' ";//echo "query1=$query1<br />";$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");$row1=mysqli_fetch_array($result1);extract($row1);//brings back max (end_date) as $end_date//echo "hidmax=$hidmax<br />";//echo "hid=$hid<br />";if($hid==''){$hid=$hidmax;}//echo "hid=$hid<br />";$hidback=$hid-1;$hidforward=$hid+1;if($hid<'1'){$hid='1';}if($hidforward > $hidmax){$hidforward=$hidmax;}if($hidback=='0'){$hidback='1';}//echo "hidback=$hidback<br />";$query2="select header_message,message from slideshow where hid=$hid";$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");$row2=mysqli_fetch_array($result2);extract($row2);//brings back max (end_date) as $end_date//echo "header_message: $header_message<br />";//echo "message: $message<br />";//echo "<br />";echo "<html>";echo "<head>";echo "</head>";echo "<body>";//echo "beacnum=$beacnum";if($beacnum=='60032781' or $beacnum=='60032793' or $beacnum=='60032920' or $beacnum=='60033018' or $beacnum=='60032787'){echo "<br />";echo "<table align='center'><tr><th><a href='/budget/infotrack/slideshow_view.php'>view all Slides</a><br /><a href='slideshow.php?hid=$hidback' title='previous headlines'><<</a>Slideshow: $header_message<a href='slideshow.php?hid=$hidforward' title='Todays headline'>>></a><br /><a href='slideshow.php?hid=$hid&edit_headline=y'>Edit hid($hid)</a></th></tr></table>";if($edit_headline==''){echo "<table align='center'><tr><td>$message</td></tr></table>";}if($edit_headline=='y'){$query4c="select header_message,message from slideshow where hid=$hid";//echo $query4a;echo "<br />";		 $result4c = mysqli_query($connection, $query4c) or die ("Couldn't execute query 4c.  $query4c");$num4c=mysqli_num_rows($result4c);$row4c=mysqli_fetch_array($result4c);extract($row4c);echo "<table>";echo "<form method='post' action='slideshow_edit.php'>";//echo "<td><input type='text' name= 'alert_location' placeholder='kela,jord,etc'></input></td>";  echo "<tr><td><textarea name= 'message' rows='100' cols='120' >$message</textarea></td></tr>";                  	  echo "<tr><td><input type='submit' name='submit' value='Update_Headline'></td></tr>";	       echo "<input type='hidden' name='hid' value='$hid'>";	   	 echo "</form>";//echo "</tr>";      	 echo "</table>";}}echo "</body></html>";?>

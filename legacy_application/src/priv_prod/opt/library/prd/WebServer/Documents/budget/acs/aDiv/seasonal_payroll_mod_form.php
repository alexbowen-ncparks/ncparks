<?php$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaserequire("shown_fields.inc");extract($_REQUEST); $query = "SHOW COLUMNS FROM seasonal_payroll_form;"; $result = @mysqli_query($connection, $query,$connection); while($row=mysqli_fetch_array($result)){$headerArray[]=$row[Field]; }  $shown=explode(",",$show); //print_r($shown); echo "<html><body><form method='POST'><table><tr><td colspan='2' align='center'>FIELDS FROM Table seasonal_payroll_form</td></tr><tr><td colspan='2'>Fields with a check and in <font color='orange'>ORANGE</font> will be SHOWN</td></tr>";foreach($headerArray as $k=>$v){if(in_array($v,$shown)){$ck="checked";$td=" bgcolor='orange'";}else{$ck="";$td="";}echo "<tr><td align='right' $td>$v</td><td><input type='checkbox' name='$v'$ck></td></tr>";}echo "<tr><td></td><td><input type='submit' name='submit' value='Update'></td></tr>";echo "<tr><td></td><td><a href='seasonal_payroll.php'>Return to Seasonal Payroll</a></td></tr>";echo "</table></form></body></html>";if($submit){$somecontent="<?php \$show=\"";foreach($_POST as $k=>$v){if($k!="submit"){$somecontent.=$k.",";}	}$somecontent=trim($somecontent,",")."\"; ?>";//echo "$somecontent"; exit;$filename = 'shown_fields.inc';// Let's make sure the file exists and is writable first.if (is_writable($filename)) {  // The file pointer is at the start of the file and will  //replace any existing content.   if (!$handle = fopen($filename, 'w')) {     echo "Cannot open file ($filename)";     exit;  }   // Write $somecontent to our opened file.   if (fwrite($handle, $somecontent) === FALSE) {    echo "Cannot write to file ($filename)";    exit;  }   // echo "Success, wrote ($somecontent) to file ($filename)";     fclose($handle);//exit; } else {  echo "The file $filename is not writable"; }header("Location: seasonal_payroll_mod_form.php");}?>
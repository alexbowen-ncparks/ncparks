<?php$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // database $sql =  "DROP  TABLE  IF  EXISTS  `wholetemp`";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql"); $sql =  "CREATE  TABLE  `budget`.`wholetemp` (  `center` varchar( 8  )  NOT  NULL default  '', `fund` varchar( 4  )  NOT  NULL default  '', `acctdate` varchar( 20  )  NOT  NULL default  '', `invoice` varchar( 25  )  NOT  NULL default  '', `pe` varchar( 6  )  NOT  NULL default  '', `description` varchar( 20  )  NOT  NULL default  '', `debit` decimal( 10, 2  )  NOT  NULL default  '0.00', `credit` decimal( 10, 2  )  NOT  NULL default  '0.00', `sys` varchar( 15  )  NOT  NULL default  '', `acct` varchar( 20  )  NOT  NULL default  '', `whid` mediumint( 8  ) unsigned NOT  NULL  AUTO_INCREMENT , PRIMARY  KEY (  `whid`  )  ) TYPE  =  MYISAM"; $result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");header("Location:uploadTextFileForm.php"); ?>
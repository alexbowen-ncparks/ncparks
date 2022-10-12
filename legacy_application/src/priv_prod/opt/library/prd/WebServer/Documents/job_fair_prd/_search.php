<?php

if (isset($_GET['search']))
 {
  $_SESSION[$database]['search'] = preg_replace("/[^A-Za-z0-9 ]/", '', $_GET['search']);
 }

function search_box() 
 {
  global $database;
  global $sitewidth;
  echo "
   <div id=\"search_box\">
    <center>
    <table width=\"$sitewidth\">
    <tr><td>
    </center>
    <form id=\"search\" method=\"get\" action=\"index.php\">
     Search: <br><input type=\"text\" name=\"search\" value=\"" . $_SESSION[$database]['search'] . "\">
     <input type=\"submit\" class=\"sign-brown\" value=\"I'm feelin lucky\">
     <a href=index.php?reset_search=1>Reset Search</a>
    </form>
    </td></tr>
   </div>
  ";
 }

?>

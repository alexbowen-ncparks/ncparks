

<?php

include("_common.php");

page_header("Add a note");

extract($_GET);

$rowid=preg_replace("/[^A-Za-z0-9 ]/", '', $rowid);

// show add note form

if ($rowid == "" or $rowid == 0)
 {
  die("rowid could not be found");
 }

echo "
 <table width=" . $_SESSION[$database]['sitewidth'] . ">
 <tr>
  <form action=\"edit.php\" method=\"post\">
  <input type=\"hidden\" id=\"rowid\" name=\"rowid\" value=\"$rowid\">
  <div>
    <textarea rows=20 cols=80 id=\"note\" name=\"note\"></textarea>
  </div>
  <div>
   <button id=\"submit\" name=\"submit\">Submit</button>
  </div>
  </form>
 </tr>
 </table>
 ";

site_footer();

?>

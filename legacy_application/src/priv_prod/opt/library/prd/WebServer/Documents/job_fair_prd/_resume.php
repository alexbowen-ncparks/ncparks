<?php


function show_resume($rowid)
 {

  global $connection;
  global $sitewidth;

  $sql = "
   SELECT microtime
   FROM resume
   WHERE row = " . $rowid . "
   AND row IS NOT NULL
   UNION
   SELECT microtime
   FROM resume
   WHERE row IS NULL
   AND microtime = " . $rowid . "
  ";

  $resumedir="/opt/library/prd/WebServer/resume";
  $result = mysqli_query($connection,$sql);

  if (mysqli_num_rows($result)==0)
   {
    echo "<center><h3>This resume could not be found.  (Has it been scanned?)</h3></center>";
   } else {
    while ($row = $result->fetch_assoc())
     {
      echo "
       <br><br><br>
       <table width=\"$sitewidth\">
        <tr>
      ";
      $fil=$resumedir . "/" . $row['microtime'] . ".jpg";
      $inline = chunk_split(base64_encode(file_get_contents($fil)));
      echo "
        <img style=\"max-width:200%; max-height:200%;\" src=\"data:image/jpg;base64," . $inline . "\" alt=\"" . $row['microtime'] . "\" ><br><br><br>
        ";
      echo "
        </tr>
       </table>
      ";
     }
   }
 }

?>



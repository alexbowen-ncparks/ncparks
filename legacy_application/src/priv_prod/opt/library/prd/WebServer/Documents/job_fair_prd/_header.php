<?php

function page_header($page = "UNTITLED PAGE CALL")
 {

  global $sitewidth;
  global $connection;

  $database = $_SESSION['database'];

  echo "

  <html>

   <head>
    <!-- <meta http-equiv=\"Refresh\" content=\"5; url=job_fair.php\" /> -->
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"view.css\" media=\"all\">
    <link rel=\"stylesheet\" type=\"text/css\" href=\"w3.css\" media=\"all\">
    <script src=\"https://cdn.jsdelivr.net/gh/google/code-prettify@master/loader/run_prettify.js\"></script>
    <title>
     " . $page . "
    </title>
   </head>

  <body>


 <div class=\"header-image\" width=\"100%\">
  <div class=\"header\" width=\"100%\">
   <center>
   <table width=\"$sitewidth\" align=\"center\">
    <tr width=\"100%\">
     <td>
      <br>
      <br>
      <div class=\"w3-tag w3-round sign-brown sign-padding\" style=\"padding-left: 0px; padding-right:0px; \">
       <div class=\"w3-tag w3-round sign-brown w3-border w3-border-white sign-shadow\"> 
        <center>
         <a href=index.php?page=index.php><img src=\"ncsp-bw.png\" width=\"300\"></a>
        <br>
         <a href=index.php>Job Fair home</a> | 
         <a href=index.php?hidden=1>Show hidden</a> | 
         <a href=report.php>Reports</a> | 
         <a href=index.php?logout=1>Logout</a>
        <br>
         User: " . $_SESSION[$database]['tempID'] . " | 
         emid: " . $_SESSION[$database]['emid'] . " | 
         Level: " . $_SESSION[$database]['level'] . " 
       </div>
      </div>
     </td>
    </tr>
   </table>
   <center>
  </div>
 </div>

 <br>
 <br>
 </center>
 <div class=\"body\">

  ";

 }

?>

<?php

function page_footer()
 {
  site_footer();
 }

function site_footer()
 {
  global $sitewidth;
  global $dom;
  global $buttonsz;
  echo "
   </div>
   <div class=\"footer\" width=\"100%\">
   <center>
   <table class=\"middle\"  width=\"$sitewidth\">
    <tr class=\"middle\">
     <td class=\"middle\" width=\"100%\">
     </center>
     <div class=\"middle\">
   ";
  echo mklink("https://legacypriv20.dev.dpr.ncparks.gov", "&copy; 2019, NC Division of Parks and Recreation | ", 
   "Go to homepage");
  echo mklink("mailto:database.support@ncparks.gov", "Get Support",
   "Click here to send an email to the database support team",
   " ", "
     </div>
    </td>
     <td halign=\"right\" class=\"middle\" width=\"100%\">
     </center>
     <div class=\"middle\">" . 
      mklink("","<img height=\"$buttonsz\" width=\"$buttonsz\" src=recycle.png>",
       "Made from 20% post-consumer recycled websites")
     . "
     </div>
    </td>
   </tr>
  </table>
  </div>
  </div>
   <br><br><br><br>
  </body>
 </html>
   ");

 if (1 == 2)
  {
   libxml_use_internal_errors( TRUE );
   $dom = new DOMDocument();
   $dom->validateOnParse = FALSE;
   $dom->preserveWhiteSpace = TRUE;
   $dom->formatOutput = TRUE;
   $dom->loadHTML( mb_convert_encoding( ob_get_contents(), 'UTF-8' ) );
   libxml_clear_errors();
   $buffer = $dom->saveHTML();
   ob_end_clean();
   echo trim( $buffer );
  }
 }

?>

<?php

echo "

<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN'
'http://www.w3.org/TR/XHTML1/DTD/XHTML1-strict.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' lang='en' xml:lang='en'>

<head>

<title>N.C. Division of Parks and Recreation: Education - Training</title>


";


echo "

<link rel='stylesheet'
    type='text/css' 
    media='screen'href='../style_body_bkg2.css'>

<link rel='stylesheet'
    type='text/css' 
    media='screen'href='../style_site.css'>

<link rel='stylesheet'
    type='text/css'
    media='print' href='../print_style.css'>

<script type='text/javascript' src='../jscript/alljs.js'></script> 

</head>


<body class='section-2'>


<div id='contents'>

";



echo "



   <div id='leftside'>

";

date_default_timezone_set('America/New_York');
$cm=date('F');
$cy=date('Y');
$ny=$cy+1;
echo "      
    
   </div>


   <div id='rightside'>

      <h3>Welcome to the NC State Parks System Teacher Workshop Search</h3>

      
      <fieldset><legend><b>Workshop Search</b></legend>      
      

      To view classes open to the public, select the search period and click the 'Search' button.

      <form method='get' action='http://www.dpr.ncparks.gov/dprcal/findpub.php'>

      

      <p><input type='radio' name='yearRadio' value='cm'>Current Month: $cm</p>

      <p><input type='radio' name='yearRadio' value='cy' checked>Current Year: $cm and beyond</p>

      <p><input type='radio' name='yearRadio' value='ny'>Next Year: $ny</p>


      <p><input type='submit' name='Submit' value='Search'></p>

      </form>

      </fieldset>



     <p><b>EE Certification:</b>  This certification is offered by the Department of Environment and Natural 
        Resources and administered through the Office of Environmental Education</a>.  Most of the workshops on this 
        calendar can be applied toward EE certification in one of three categories:  Criteria I, II or III.</p>

     <img src='pics/art_vs_craft.jpg' width='250' height='165' alt='Educators at work in an environmental education workshop.'>


     <p><b>Advanced Interpretive Training (AIT):</b>  This certification is offered only to employees within the 
        Division of Parks and Recreation.  However, other educators are welcome to attend the AIT workshops listed 
        in this calendar.</p>

     <div id='navset'>     

     <p>For questions or problems regarding workshops on this calendar, please contact:</p>

     <p>Lead Interpretation and Education Specialist<br />
     <b>Phone:</b> (919) 707-9348<br />
     <b>Email:</b> <a href='mailto:sean.higgins@ncparks.gov'>sean.higgins@ncparks.gov</a></p>

     </div>



";


echo " 
   
   </div>

   <div id='dummy'>
   </div>

</div> 
 

 
</body>
</html>

";
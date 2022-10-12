<?php

if (isset($_GET['export']))
 { $export=1; } else { $export=0; }

if (
    (isset($_GET['reset_search']) and $_GET['reset_search'] == 1)
    or 
    (! isset($_SESSION[$database]['searchparms']))
   )
 {
  bl("reset_search");
    $_SESSION[$database]['search'] = "";
    $_SESSION[$database]['limit'] = 0;
    $_SESSION[$database]['sort'] = "date";
    $_SESSION[$database]['order'] = "desc";
    unset($_SESSION[$database]['searchparms']);
    $_SESSION[$database]['searchparms'] = 
     array( // nm                // nm                  // subtype   //_GET()  //operator
      'college'         => array('college',             'text',         '',     '=',    'College'),
      'gpa' 		=> array('gpa',			'float',	'',	'>=',	'Grade point average'),
      'hbcu' 		=> array('hbcu',		'bool',		'',	'=',	'HBCU schools'),
      'hidden' 		=> array('hidden',		'bool', 	'',	'=',	'Show hidden records'),
      'internship' 	=> array('internship',		'bool',		'',	'=',	'Interested in internship'),
      'last_note_st'    => array('last_note_st',        'text',         '',     '>=',   'Followup since '),
      'major'           => array('major',               'text',         '',     '=',    'Major'),
      'volunteer' 	=> array('volunteer',		'bool',		'',	'=',	'Interested in volunteering'),
      'eventsignup' 	=> array('eventsignup',		'bool',		'',	'=',	'Interested in DPR Job Fair events'),
      'year_status' 	=> array('year_status',		'text',		'',	'=',	'Current college year'),
      'year_graduated' 	=> array('year_graduated',	'int',		'',	'=',	'Graduation year'),
     );
 }

// set new sort
if (isset($_GET['sort']))
 {
  if ($_SESSION[$database]['sort']==$_GET['sort'])
   { // flop the order
    if ($_SESSION[$database]['order']=='asc')
     {
      $_SESSION[$database]['order']='desc';
     } else {
      $_SESSION[$database]['order']='asc';
     }
   } else {
    $_SESSION[$database]['sort']=$_GET['sort'];
   }
 }


function mktable()
 {

  global $tempID;
  global $connection;
  global $debug;
  global $database;
  global $export;
  global $hidelevel;
  global $editlevel;
  global $addnotelevel;
  global $devlevel;
  global $level;
  global $viewlevel;
  global $viewallnoteslevel;
  global $unitword;
  global $sitewidth;
  global $buttonsz;
  bl(print_r($_SESSION[$database],True));

  # for the mail merge
  $email_addrs="";

/*
  if ($_SESSION[$database]['limit'] == 0) 
   {
    $limitstr="    LIMIT 999 ";
   } else {
    $limitstr="    LIMIT " . $_SESSION[$database]['limit'] . "";
   }
*/

  # override limit str w resperpage
  $limitstr="   LIMIT " . $_SESSION[$database]['resperpage'] . "";

     // sanitized search str
  if ($search = &$_SESSION[$database]['search'] == "") 
   {
    $searchstr=" ";
   } else {
    $searchstr="
     AND 
      (    
          lower(first)         LIKE '%" . $search . "%'
       OR last                 LIKE '%" . $search . "%'
       OR college              LIKE '%" . $search . "%'
       OR major                LIKE '%" . $search . "%'
       OR comments             LIKE '%" . $search . "%'
       OR job_interest         LIKE '%" . $search . "%'
       OR ocr_text             LIKE '%" . $search . "%'
      )
    ";
   }

  // sql WHERE / AND
  $andstr="  
  ";

  $parmstr="
   <table width=\"$sitewidth\">
  ";

  // alias
  $a = &$_SESSION[$database]['searchparms'];

  function parmstr_pack(&$s, &$v)
   {
    global $buttonsz;
    $sz=$buttonsz;
    $sz=15;
    $s .= mklink("index.php?" . $v[0], "<img height=\"$sz\" width=\"$sz\" src=x.png>",
     "Remove filter on " . $v[0], 
     " <tr><td> ", $v[4] . " is set to " . $v[3] . " " . $v[2] . " </tr></td> ");

   }

  // build the search paramaters of sql query
  // TODO: fix this so it properly uses named arrays
  foreach ($a as $k => $v)
   {
    if (isset($_GET[$k]))
     {
      bl("p[2] get " . $_GET[$k]);
      $a[$k][2] = trim(urldecode($_GET[$k]));
     }
    if ((isset($a[$k][2])) and ($a[$k][2] == "1"))
     {
      switch ($a[$k][1])
       {
        case "bool":
         $andstr .= "
          AND ( " . $a[$k][0] . " " . $a[$k][3] . " 1 ) ";
   	  parmstr_pack($parmstr, $a[$k]);
         break;
       }
     } elseif ($a[$k][2] == "" and isset($a[$k][2]))
     {
      if (($k == "hidden") and ( (isset($a[$k][2]) == False) or ($a[$k][2] == "") ) )
       {
        $andstr .= 
         "  AND ( hidden = false ) ";
       }
     } else {
      switch ($a[$k][1])
       {
        case ("text"):
         $andstr .= " AND (" . $a[$k][0] . " " . $a[$k][3] . " '" . $a[$k][2] . "' ) ";
         parmstr_pack($parmstr, $a[$k]);
         break;
        case "float":
         $andstr .= "
          AND ( " . $a[$k][0] . " REGEXP '^[0-9]+\\\.?[0-9]*$' )
          AND ( " . $a[$k][0] . " " . $a[$k][3] . " '" . $a[$k][2] . "' ) ";
          parmstr_pack($parmstr, $a[$k]);
         break;
       } 
      if (($k == "year_graduated") and ($a[$k][2] !== ""))
       {
        if ($a[$k][2] < date("Y"))
         {
          $a[$k][3] = ">=";
         } else {
          $a[$k][3] = "<=";
         }
        parmstr_pack($parmstr, $a[$k]);
       }
     }
   }

  $sort = $_SESSION[$database]['sort'];
  $order = $_SESSION[$database]['order'];

  $parmstr .= "
     <tr>
      <td>
       Sorted by " . $sort . " " . $order . " - <a href=index.php?sort=" . $sort . ">Reverse</a>
      </td>
     </tr>
    </table>
    ";

  bl($parmstr);

  $orderstr="
   ORDER BY " . $_SESSION[$database]['sort'] . " " . $_SESSION[$database]['order'] . " ";

  $sql_total="
   SELECT 1
   FROM job_fair.v_contact
   ";

  $sql="
   SELECT *
   FROM job_fair.v_contact
   WHERE pinned = TRUE
    UNION 
   SELECT * 
   FROM job_fair.v_contact
   WHERE pinned = FALSE
   " . $andstr . "
   " . $searchstr . "
   " . $orderstr . " 
   " . $limitstr . "
   ;
   ";

  if ($level >= $devlevel) 
   {
    echo "
       </center>
       <pre class=\"prettyprint lang-sql\">
        </center>
        <code class=\"language-sql\">
        </center>
        " . $sql . "
        </code>
       </pre>
    ";
   }

  bl($sql);
  $result = mysqli_query($connection,$sql);
  $count = mysqli_num_rows($result);
  bl("row count: " . strval($count));


  $result_total = mysqli_query($connection,$sql_total);
  $count_total = mysqli_num_rows($result_total);

  // print the search parameters box
  if ($export==0) {
   echo $parmstr;
  }

  if ($count < 1)
   {
    echo "
    <center>
    <table width=\"$sitewidth\">
     <tr>
      No results.
      " . mklink("index.php?reset_search=1","Reset","Reset the search parameters") . "
     </tr>
    </table>
    </center>
    ";

   } else {


    if ($export == 1) {
     #$export_str=array_keys(array($result));
     # | id  | hidden | pinned | st                  | row | date                | microtime  | ip_addr      | first  | last   | addr1         | addr2 | city       | state | zip   | country       | area_code | exchange | extension | email                    | sex  | college      | major      | gpa  | year_status | year_graduated | degree     | hbcu | job_interest | internship | volunteer | referred_by | comments | last_note_st | last_note_text | ocr_text |

     $export_str="id,hidden,pinned,import_date,row,signup_date,unixt,ip_addr,first,last,addr1,addr2,city,state,zip,country,area,prf,ext,email,sex,college,major,gpa,year_status,grad_year,degree,hbcu,job_interest,intern,volunteer,referred,comments,last_note_date,last_note,ocr_text,event_signup\n";
     while ($row = $result->fetch_assoc())
     {
      $export_str .= implode(",",$row) . "\n";
     }
     header("Content-type: text/plain");
     header("Content-Disposition: attachment; filename=result" . time() . ".csv");
     echo $export_str;
     die();
    }


    echo "
    <center>
    <table width=\"$sitewidth\">
     <tr>
      <td>
       <b>Displaying top " . $count . " of " . $count_total . " results.  Show ";

        echo mklink("index.php?resperpage=50","50","Show 50 results",""," | ");
        echo mklink("index.php?resperpage=100","100","Show 100 results",""," | ");
        echo mklink("index.php?resperpage=500","500","Show 500 results",""," | ");
        echo mklink("index.php?resperpage=1000","1000","Show 1000 results",""," ");

	echo "
       </b>
      </td>
     </tr>
    </table>

    <br>
    <br>

    <table width=\"$sitewidth\">
     <tr>
      <td valign=\"top\" halign=\"left\" width=\"20%\"><b>
       ";

       echo mklink("index.php?sort=last","Name","Sort by last name",""," | ");
       echo mklink("index.php?sort=hbcu","HBCU","Sort by HBCU",""," | ");
       echo mklink("index.php?sort=major","Major","Sort results by Major",""," | ");
       echo mklink("index.php?sort=year_status","Year","Sort by the year status of the " . $unitword);

       echo "
       <br>
      </td>
      <td valign=\"top\" halign=\"left\" width=\"10%\">
       <b>
        <!-- Controls -->
      </td>
      <td valign=\"top\" halign=\"left\" width=\"10%\">
      " . mklink("index.php?sort=gpa","GPA","Sort by grade point average","<b>") . "
      </td>
      <td valign=\"top\" halign=\"left\" width=\"20%\">
       <b>
        Contact
      </td>
      <td valign=\"top\" halign=\"left\" width=\"20%\">
       <b>
        Interests
      </td>
      <td valign=\"top\" halign=\"left\" width=\"20%\">
       <b>
        Comments | 
      ";
 
      echo mklink("index.php?sort=date","Signup","Sort by date the " . $unitword . " signed up using the form",
       ""," | ");
      echo mklink("index.php?sort=last_note_st","Followup","Sort by last followup date");

      echo "
         </td>
        </tr>
       </table>
     ";


    while ($row = $result->fetch_assoc())
     {

      //bl(print_r($row,True));

      if (strpos($row['email'], '@')) 
       { $email_addrs = $email_addrs . ";" . $row['email']; }

      echo "
       <center>
       <table width=\"$sitewidth\">
        <tr>
         <td halign=\"left\" valign=\"top\" width=\"20%\">
        ";

        if ($row['pinned'])
         {
          echo "<b class=\"pinned\">";
         } else {
          echo "<b>";
         }

        echo trim($row["last"]) . ", " . trim($row["first"]) . "</b>";

        echo mklink("index.php?major=" . urlencode($row['major']), $row['major'],
         "Show only " . $row['major'] . " majors", "<br></b><i>");

        echo mklink("index.php?year_status=" . $row['year_status'], $row['year_status'], 
         "Show only " . $unitword . "s in their " . $row['year_status'] . " year", "<br>");

        if ((is_numeric($row['year_graduated'])) and ($row['year_graduated'] >= 1890))
         {
          if ($row['year_graduated'] < date("Y"))
           {
            $suffix="ed";
           } else {
            $suffix="ing";
           }
           echo mklink("index.php?year_graduated=" . $row['year_graduated'], $row['year_graduated'] . ")", 
            "Show only " . $unitword . "s graduat" . $suffix . " in or after " . $row['year_graduated'], 
            " (graduat" . $suffix, "<br>");
         }

        echo mklink("index.php?college=" . urlencode($row['college']), trim($row['college']),
          "Show only " . $unitword . "s who are currently or did attend " . $row['college']);

        if ($row['hbcu'])
         { 
          echo mklink("index.php?hbcu=1","<b> (HBCU)</b>","Show only " . $unitword . "s at HBCU schools");
         }

        if ($row['eventsignup'])
         { 
          echo mklink("index.php?eventsignup=1","<b>Event</b>","Show only " . $unitword . "s signed up for DPR events");
         }
        echo "
        <br>
        <br>
        <br>
       </td>
       <td valign=\"top\" halign=\"left\" width=\"10%\">
        ";
       if ($level >= $editlevel)
        {
         echo mklink("edit.php?rowid=" . $row["row"], 
          "<img src=edit.png height=\"" . $buttonsz . "\" width=\"" . $buttonsz . "\">", "Edit this record");
        }
       if ($level >= $hidelevel) 
        {
         if ($row['hidden'])
          {
           echo mklink("edit.php?rowid=" . $row['row'] . "&hide=0",
            "<img src=show.png height=\"" . $buttonsz . "\" width=\"" . $buttonsz . "\">",
            "Remove the 'hidden' flag from this record"); 
          } else {
           echo mklink("edit.php?rowid=" . $row['row'] . "&hide=1",
            "<img src=hide.png height=\"" . $buttonsz . "\" width=\"" . $buttonsz . "\">","Hide this record"); 
          }
         if ($row['pinned'])
          {
           echo mklink("edit.php?rowid=" . $row['row'] . "&pin=0",
            "<img src=unpin.png height=\"" . $buttonsz . "\" width=\"" . $buttonsz . "\">",
            "Remove the 'pinned' flag from this record"); 
          } else {
           echo mklink("edit.php?rowid=" . $row['row'] . "&pin=1",
            "<img src=pin.png height=\"" . $buttonsz . "\" width=\"" . $buttonsz . "\">",
            "Pin this record (it will always be visible regardless of search parameters)"); 
          }
        }

       if ($level >= $viewlevel)
        {
         echo mklink("resume.php?rowid=" . $row['row'],
          "<img src=doc.png height=\"" . $buttonsz . "\" width=\"" . $buttonsz . "\">",
          "Show this " . $unitword . "'s resume");
        }

       if ($level >= $addnotelevel)
        {
         echo mklink("note.php?rowid=" . $row["row"], 
          "<img src=add_note.png height=\"" . $buttonsz . "\" width=\"" . $buttonsz . "\">", 
          "Add a note to this record");
        }
       echo "
       </td>
       <td valign=\"top\" halign=\"left\" width=\"10%\">
        ";
       if (is_numeric($row['gpa']) and ($row['gpa'] >= 0.1) and ($row['gpa'] <= 5) )
        {
         echo mklink("index.php?gpa=" . $row['gpa'], $row['gpa'], 
          "Show only " . $unitword . "s with GPA " . $row['gpa'] . " and higher"); 
        }
        echo "
       </td>
       <td valign=\"top\" halign=\"left\" width=\"20%\">
        ".$row["addr1"]." ".$row["addr2"]."<br>".$row["city"]."  
         ".$row["state"]." ".$row["zip"]."<br>
         "; 
         $telnum="" . $row["area_code"]." ".$row["exchange"]." ".$row["extension"];
         $tel=$row["area_code"] . $row["exchange"] . $row["extension"];
         echo mklink("mailto:" . $row['email'], $row['email'], 
             "Send an email to " . $row['first'] . " " . $row['last'], " ", "<br>");
         echo mklink("tel:" . trim($tel), $telnum, "Call " . $row['first'] . " " . $row['last']);
         echo "
         <br><br>
         </td>
         <td valign=\"top\" halign=\"left\" width=\"20%\">
       ";

        if ($row['internship'])
         { 
          echo mklink("index.php?internship=1","Internship",
           "Show only " . $unitword . "s who are interested in an internship"); 
         }
        if ($row['volunteer'])
         { 
          echo mklink("index.php?volunteer=1","Volunteer",
           "Show only " . $unitword . "s who are interested in volunteering"); 
         }
        if (trim($row['job_interest']) != "")
         { echo "<br>Job interests: " . $row['job_interest']; }
        if ($row['eventsignup'])
         { 
          echo mklink("index.php?eventsignup=1","Event Signup",
           "Show only " . $unitword . "s who are interested in DPR Job Fair events"); 
         }

       echo "
       </td>
       <td valign=\"top\" halign=\"left\" width=\"20%\"> 
        "; 

        if (trim($row["comments"]) != "")
         {
          echo $row['date'] . " " . $unitword . " comments: " . trim($row['comments']);
         } else {
          if ($row['first'] == "Resume")
           {
            echo "";
           } else {
            echo $row["date"] . " " . $unitword . " signed up";
           }
         }

        echo "
	<br>
        <br>
        <br>
       </td>
      </tr>
     </table>
      ";

      if ($row['last_note_st'] != "") 
       {

        if ($level >= $viewallnoteslevel)
         {
          $tempidstr=" AND tempID <> '1' ";
         } else {
          $tempidstr=" AND tempID = '" . $tempID . "' ";
         }

        $sql="
         SELECT CAST(st AS date) AS st, tempID, note_text
         FROM note
         WHERE rowid = " . $row['row'] . "
         " . $tempidstr . "
         ORDER BY st DESC
          ;
        ";

        echo "

         <table width=\"$sitewidth\">
        ";

        $notes = mysqli_query($connection,$sql);
        while ($note = $notes->fetch_assoc())
         {
          echo "
           <tr>
            <td width=\"20%\">  
            </td>
            <td width=\"10%\">" . $note['st'] . "
            </td>
            <td wdith=\"10%\">" . $note['tempID'] . "
            </td>
            <td width=\"60%\">" . $note['note_text'] . "
            </td>
          </tr>
          ";
         }

        echo "
         </table>


         <br>
         <br>
        ";
       }

     // display the matching part[s] of the search term in the resume text
      // allows more than 1024 char return on group_concat() func
     $numwords=5;
     $o = $row['ocr_text']; 
     if (($o != "") and (isset($o)) and (isset($search)) and ($search != ""))
      {
       if (strpos(strtolower($o), strtolower($search)) > -1)
        {
         echo "
          <table width=\"$sitewidth\">
           <tr>
            <td>
         ";
         $j = explode(" ", $o);

         $idx=0;
         for ($idx = 1; ($idx <= max(array_keys($j)) and $idx <= 500); $idx++)
          {
           if (strpos(strtolower($j[$idx]), strtolower($search)) > -1)
            {
             echo " ... ";
             for (($idy = ($idx - $numwords)); $idy < $idx; $idy++)
              {
               echo @$j[$idy] . " ";
              }
             echo " <font style=\" color:red; background-color:yellow; \">" . $j[$idx] . "</font> ";
             for (($idy = ($idx + 1)); $idy <= ($idx + $numwords); $idy++)
              {
               echo @$j[$idy] . " ";
              }
             echo " ... <br>";
            }
          }

          echo "
             <br><br>
             </td>
            </tr>
           </table>
          ";
        }
      }
    }

    echo "
    </table>
    ";
   }

  echo "
   <br>
   <br>
   ";

  if ($email_addrs !== "")
   {
    echo "
    <table width=\"$sitewidth\">
    <tr>
     <td>
     ";
     echo mklink("mailto:?bcc=" . $email_addrs, "Email these individuals",
      "This link will open a new email message to the selected individuals");
     echo "<br><br>";
     echo mklink("export.php?export=1", "Export this result", "Download this result");
     echo "
     </td>
    </tr>
    </table>
    <br><br><br><br>
   ";
   }
 }


?>

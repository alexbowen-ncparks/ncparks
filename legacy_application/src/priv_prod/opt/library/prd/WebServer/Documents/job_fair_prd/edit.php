

<?php

require_once("_common.php");
bl("edit.php top");

extract($_REQUEST);
$rowid=preg_replace("/[^0-9 ]/", '', $rowid);

bl("edit.php rowid " . $rowid);

if (isset($hide))
 {
  if ($level < $hidelevel)
   { die("level must be " . $editlevel . " or higher"); }
  if ($hide=="1")
   {
    $sql="
     UPDATE contact
     SET hidden = 1
     WHERE row = " . $rowid . ";
    ";

    mysqli_query($connection,$sql);
    header("Location: index.php"); 

   } 
  if ($hide=="0") {
    $sql="
     UPDATE contact
     SET hidden = 0
     WHERE row = " . $rowid . ";
    ";

    mysqli_query($connection,$sql);
    header("Location: index.php?hidden=1"); 

   } 
 }

if (isset($pin))
 {  // hidelevel also used for pinning
  if ($level < $hidelevel)
   { die("level must be " . $editlevel . " or higher"); }
  if ($pin=="1")
   {
    $sql="
     UPDATE contact
     SET pinned = 1
     WHERE row = " . $rowid . ";
    ";

    mysqli_query($connection,$sql);
    header("Location: index.php?hidden=0"); 

   } 
  if ($pin=="0") {
    bl($sql);
    $sql="
     UPDATE contact
     SET pinned = 0
     WHERE row = " . $rowid . ";
    ";

    mysqli_query($connection,$sql);
    header("Location: index.php?hidden=0"); 

   } 
 }

if (isset($note))
 {
  if ($level < $addnotelevel)
   { die("must be level " . $addnotelevel . " or higher"); }
  bl("note text: " . $note);
  $note = str_ireplace(";", " ", $note);
  $sql="
   INSERT INTO note
    (rowid,tempID,emid,note_text)
   VALUES
    ('" . $rowid . "','" . $tempID . "','" . $emid . "','" . $note . "');
  ";
  bl($sql);

  mysqli_query($connection,$sql);
  header("Location: index.php");

 }

// show edit form


$updated=false;
if (isset($college))
 {
  $query="
   INSERT IGNORE INTO college (nm)
   SELECT '" . $_POST['college'] . "'
    ;
   UPDATE contact 
   SET college = ( 
    SELECT id 
    FROM college 
    WHERE nm = '" . $_POST['college'] . "' ) 
   WHERE rowid = " . $_POST['rowid'] . " 
   ;
  ";
  bl($query); 
  $res1=mysqli_query($connection,$query);
  $updated=true; 
 }

if ($updated)
 {
  bl("edit.php UPDATED");
  Header("Location: edit.php?rowid=" . $rowid );
  die();
 }

if ($level < $editlevel)
 { die("level must be " . $editlevel . " or higher"); }

page_header('Edit');

 $sql="
  SELECT *
  FROM job_fair.v_contact
  WHERE row = " . $rowid . "
  ;
  ";

 bl($sql);
 $result = mysqli_query($connection,$sql);
# $count = mysqli_num_rows($result);

# while ($row = $result->fetch_assoc())
#  {
#   $rowdata=(explode($row));
#  }

 $rowdata=$result->fetch_assoc();

 if ( $level >= 4 ) {
  echo "<br><br>";
  print_r($rowdata);
 }

echo "

<script type=\"text/javascript\" src=\"autocomplete.js\"></script>
<script type=\"text/javascript\" src=\"college.js\"></script>
<script type=\"text/javascript\" src=\"major.js\"></script>


 <br><br>
 <center>

 <table width=" . $_SESSION[$database]['sitewidth'] . ">
 <tr>
  <form action=\"edit.php\" method=\"post\" autocomplete=off>

  <input type=\"hidden\" id=\"rowid\" name=\"rowid\" value=\"$rowid\">

  <table>
   <tr>
    <td width=30%>
     Name:
    </td>
    <td width=70%>  " . $rowdata['first'] . " " . $rowdata['last'] . " 
    </td>
   </tr>
   <br>

   <tr>
    <td width=30%>
     College:
    </td>
    <td width=70%>
     <input type=textarea rows=1 cols=40 id=\"college\" name=\"college\">" . $rowdata['college'] . "</textarea>
    </td>
   </tr>
   <br>
 
   <tr>
    <td width=30%>
     Major:
    </td>
    <td width=70%>
     <input type=textarea rows=1 cols=40 id=\"major\" name=\"major\">" . $rowdata['major'] . "</textarea>
    </td>
   </tr>
   <br>

  </table>
  <br>


   <button id=\"submit\" name=\"submit\">Submit</button>

  </form>
 </tr>
 </table>

<script>
autocomplete(document.getElementById(\"college\"), college);
autocomplete(document.getElementById(\"major\"), major);
</script>


 ";

page_footer();


?>

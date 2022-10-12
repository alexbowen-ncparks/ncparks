<?php
ini_set('display_errors',1);
$database="war";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/connectROOT.inc"); 
include_once("../../include/get_parkcodes.php");
mysql_select_db($database,$connection);
date_default_timezone_set('America/New_York');
include_once("menu.php");

extract($_REQUEST);

//echo "<pre>";print_r($_SESSION);echo "</pre>";
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

$weekThis = date('W'); 
$week_1 = $weekThis-1;
$warLevel=$_SESSION['war']['level'];
$checkPark=$_SESSION['war']['parkS'];
$positionTitle=$_SESSION['war']['position'];
$sectCheck=$_SESSION['war']['sect_prog'];
if($sectCheck=="CONS"){$sectCheck="CON";}


if (@$section.@$weekFind.@$weekTest.@$month.@$yearText.@$park.@$dist.@$title.@$body == ""){
echo "<h3>Warning</h3>You are attempting to find ALL records, for editing, for the entire year; this is not a normal situation. <br><br>If this is not your intention, click your BACK button and enter additional search terms. <br><br>If this is your intention, then to bypass this warning, enter the year to search for in the year TEXT box. "; exit;}

$compare="and";

if (@$section=="" AND @$dist=="" AND @$park=="" AND @$section=="" AND @$title=="" AND @$weekTest=="" AND @$weekFind=="" AND @$yearRadio=="" AND @$yearText=="" AND @$month=="" ){echo "You did not enter any search item(s).<br><br>Click your Back button."; exit;}

// reformat any variables
if ($month != ""){$month=substr("00$month",-2);} // add a zero before single digit months
if ($yearRadio != "") {$year = "$yearRadio";}// order of if statements is important
if ($yearText != "") {$year = "$yearText";}// Text needs to override Radio

if ($weekTest != "") {$weekFind = "$weekTest";}// Text needs to override weekTest

if(@$ignore){$weekFind="";}

//  create the WHERE clause using variables passed from index.php
if (@$section != ""){$var1 = "(section = '$section') $compare ";}
if (@$dist != ""){$var2 = "(dist = '$dist') $compare ";}
if (@$park != ""){$var3 = "(park = '$park') $compare ";}
if (@$title != ""){$var4 = "(title LIKE '%$title%') $compare ";}
//if ($weekRadio != ""){$var5 = "(week = '$weekRadio') $compare ";$var6="";}
if (@$weekFind != ""){$var5="";$var6 = "(weekentered = '$weekFind') $compare ";}
if (@$body != ""){$var7 = "(body LIKE '%$body%') $compare ";}
if (@$year != "" and $month ==""){$var8 = "(date LIKE '$year%') $compare ";}
if (@$month != "" and $year==""){echo "Please select a Year with the Month.<br><br>Click your Back button."; exit;} ELSEIF ($month != "" and $year!="") {$var9 = "(date LIKE '$year-$month%') $compare ";} // must use ELSEIF in this IF statement

$find = @$var1.@$var2.@$var3.@$var4.@$var5.@$var6.@$var7.@$var8.@$var9; // concat the search terms

$varFind = substr_replace($find, '', -4, -1); // removes the last OR or AND from WHERE clause

//distApprov='' AND sectApprov='' AND direApprov=''

if($warLevel==1){
if($checkPark=="FOMA" AND $park=="THRO"){$checkPark="THRO";}
$parkOnly="and park='$checkPark' and distApprov='' AND sectApprov='' AND direApprov=''";
}

if($warLevel==2){
include("../../include/parkcodesDiv.inc");
$text="array".$checkPark; $distArray=${$text};
for($i=0;$i<count($distArray);$i++){
if($i==0){$distOnly="AND (park='".$distArray[$i]."'";}else
{$distOnly.=" OR park='".$distArray[$i]."'";}
}
$distOnly.=") AND week='$weekThis'";
}

if($warLevel==3){$sectOnly="AND section='$sectCheck' AND week='$weekThis'";}

if($warLevel==4){$direOnly="week='$weekThis'";}

if(!isset($parkOnly)){$parkOnly="";}
if(!isset($distOnly)){$distOnly="";}
if(!isset($sectOnly)){$sectOnly="";}
if(!isset($direOnly)){$direOnly="";}
$sql = "SELECT * FROM report WHERE
$varFind  $parkOnly $distOnly $sectOnly $direOnly
ORDER BY section, dist, park, title";

// echo "$sql"; //exit;
 
$total_result = @mysql_query($sql, $connection) or die("Error #". mysql_errno() . ": " . mysql_error());
$total_found = @mysql_num_rows($total_result);

if ($total_found <1)
          {  $sql = "SELECT date FROM report ORDER BY date LIMIT 1";
             $total_result = @mysql_query($sql, $connection) or 
                                     die("Error #". mysql_errno() . ": " . mysql_error());
                                     $row=(mysql_fetch_array($total_result)); extract($row);
                                     $earlyDate = $date;
             $sql = "SELECT date FROM report ORDER BY date DESC LIMIT 1";
             $total_result = @mysql_query($sql, $connection) or 
                                     die("Error #". mysql_errno() . ": " . mysql_error());
                                     $row=(mysql_fetch_array($total_result)); extract($row);
                                     $lateDate = $date;

              if (isset($weekRadio) OR isset($weekFind) OR isset($year) OR isset($month))
                  {
                    echo "Results of search:  <b>Nothing found for: $varFind</b><br><br>";
                    $newEarlyDate = date("l, j F Y", strtotime($earlyDate));
                    $newLateDate = date("l, j F Y", strtotime($lateDate));
                    echo "No entries have been made prior to $newEarlyDate or after $newLateDate.<br><br>";
                    echo "Click the Back button.";
                    exit;
                  }
           }

echo "<font color='red' size='-1'> To edit, or delete a report, click its Title, if it is a link.</font>";
while ($row = mysql_fetch_array($total_result))
  { extract($row);
                      include("section.inc");
                      include("distLong.inc");
                     
$xyz= nl2br($body);
$section = strtoupper($section);
$sectLong = strtoupper($sectLong);
$dist = strtoupper($dist);

if($distApprov){$distApprov="[District]";}
if($sectApprov){$sectApprov="[Section]";}
if($direApprov){$direApprov="[Director]";}
if($distApprov.$sectApprov.$direApprov){
$approved=" <font color='purple'>Approved by: ".$distApprov." ".$sectApprov." ".$direApprov."</font>";
}else{$approved="";}
// ********** Validate *************
$canEdit="";

$findme="Office Assistant";
$x=strpos($positionTitle,$findme);
$findme="Law Enforcement Supervisor";
$y=strpos($positionTitle,$findme);
$z=$x+$y;

if($z>-1)
	{
	if(@in_array($park,$distArray)){$canEdit="1";}
	else {
	if($checkPark==$park){$canEdit="1";}else{
	$canEdit="";}
	}
	if($approved){$canEdit="";}// not editable if approved
	}

if($warLevel==2){
if($x>-1 AND $checkPark=="YORK" AND $section=="CON"){$canEdit="1";}
}

if($warLevel>2){$canEdit="1";}

if($title==""){$title="Title was deleted.";}
if($canEdit=="1"){$title = "$park - <a href=\"#\"
onClick=\"window.open('update.php?id=$id&thisWeek=$weekFind&s=$section','newWindow','height=600,width=825','scrollbars=yes','alwaysRaised=yes');\">$title</a>";}
else {$title=$park." - ".$title;}


 if ($section == "OPE")  //    /*removed $park*/ 
        {
             if (@$sectionC != $section)
                  { $counterOPE = 1; 
                             echo "<table><tr><td colspan='5'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td></tr><tr>
                             <td></td> <td></td>
                   <td valign='top' align='right' width='30'>$counterOPE.</td>
                               <td><b>$title</b><br>$xyz</td></tr></table>";
                                $sectionC = $section;
                                $distC = $dist;
                                $parkC = $park;
                                $counterOPE++;
                    } // end section format

               elseif ($sectionC == $section)
                          {     
                                if ($distC != $dist)
                                     {    $counterOPE = 1;     //    /*removed $park*/ 
                                         if ($parkC != $park)
                                               { 
                                                       echo "<br><table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                            <td valign='top' align='right' width='30'>$counterOPE.</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                                            $counterOPE++;
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                  <td valign='top' align='right' width='25'>$counterOPE.</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                                           $counterOPE++;
                                                      }
                                     }
                                  elseif ($distC == $dist)
                                         //  { 
                                         /*      if ($parkC != $park)
                                                    {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'></td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                             <td valign='top' align='right' width='25'>$counterOPE.</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                                           $counterOPE++;
                                                     }*/
                                          //      /*removed $park*/     elseif ($parkC == $park)
                                                     {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'></td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                   <td valign='top' align='right' width='25'>$counterOPE.</td> <td></td> 
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                                           $counterOPE++;
                                                      }
                                          //  }
                           }
               
         }// end OPE section test **********************************
             
 if ($section == "CON")
      { 
             if ($sectionC != $section)
                  { 
$counterCON = 1;        echo "<br><table><tr><td colspan='4'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td><tr>
                              <td></td><td valign='top' align='center'>$park</td>
                               <td valign='top'>$counterCON</td>
                               <td><b>$title</b><br>$xyz</td></tr></table>";
                                $sectionC = $section;
                                $distC = $dist;
                                $parkC = $park;
                                $counterCON++;
                    } // end section format

               elseif ($sectionC == $section)
                          {     
                             //   if ($distC != $dist)
                             //        { 
                                         if ($parkC != $park)
                                               {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                                          <td valign='top'>$counterCON</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterCON++;
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top'>$counterCON</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterCON++;
                                                      }
                                 //    }
                                
                           }
               
         }// end CON section test*********************************

 if ($section == "ADM")
       {
             if ($sectionC != $section)
                  { 
 $counterADM = 1; echo "<table><tr><td colspan='4'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td><tr>
                              <td></td><td valign='top' align='center'>$park</td>
                               <td valign='top'>$counterADM</td>
                               <td><b>$title</b><br>$xyz</td></tr></table>";
                                $sectionC = $section;
                                $distC = $dist;
                                $parkC = $park;
                                $counterADM++;
                    } // end section format

               elseif ($sectionC == $section)
                          {     
                           //     if ($distC != $dist)
                            //         { 
                                         if ($parkC != $park)
                                               {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                                          <td valign='top'>$counterADM</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterADM++;
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top'>$counterADM</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterADM++;
                                                      }
                                 //    }
                                
                           }
               
         }// end ADM section test*********************************

 if ($section == "PLA")
       { 
             if ($sectionC != $section)
                  { 
$counterPLA = 1; echo "<br><table><tr><td colspan='4'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td><tr>
                              <td></td><td valign='top' align='center'>$park</td>
                               <td valign='top'>$counterPLA</td>
                               <td><b>$title</b><br>$xyz</td></tr></table>";
                                $sectionC = $section;
                                $distC = $dist;
                                $parkC = $park;
                                $counterPLA++;
                    } // end section format

               elseif ($sectionC == $section)
                          {     
                              //  if ($distC != $dist)
                                   //  { 
                                         if ($parkC != $park)
                                               {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                                          <td valign='top'>$counterPLA</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                           $counterPLA++;
                                                          /*$distC = $dist;
                                                          $parkC = $park;*/
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top'>$counterPLA</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                           $counterPLA++;
                                                         /* $distC = $dist;
                                                          $parkC = $park;*/
                                                      }
                                  //   }
                                
                           }
               
         }// end PLA section test*********************************

 if ($section == "RES")
       { 
             if ($sectionC != $section)
                  { 
$counterRES = 1; echo "<br><table><tr><td colspan='4'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td><tr>
                              <td></td><td valign='top' align='center'>$park</td>
                               <td valign='top'>$counterRES</td>
                               <td><b>$title</b><br>$xyz</td></tr></table>";
                                $sectionC = $section;
                                $distC = $dist;
                                $parkC = $park;
                                $counterRES++;
                    } // end section format

               elseif ($sectionC == $section)
                          {     
                            //    if ($distC != $dist)
                             //        { 
                                         if ($parkC != $park)
                                               {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                                          <td valign='top'>$counterRES</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterRES++;
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top'>$counterRES</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterRES++;
                                                      }
                                 //    }
                                
                           }
               
         }// end RES section test*********************************

 if ($section == "NAT")
       {
             if ($sectionC != $section)
                  {
 $counterNAT = 1; echo "<br><table><tr><td colspan='4'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td><tr>
                              <td></td><td valign='top' align='center'>$park</td>
                               <td valign='top'>$counterNAT</td>
                               <td><b>$title</b><br>$xyz</td></tr></table>";
                                $sectionC = $section;
                                $distC = $dist;
                                $parkC = $park;
                                $counterNAT++;
                    } // end section format

               elseif ($sectionC == $section)
                          {     
                            //    if ($distC != $dist)
                            //         { 
                                         if ($parkC != $park)
                                               {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                                          <td valign='top'>$counterNAT</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterNAT++;
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top'>$counterNAT</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterNAT++;
                                                      }
                                 //    }
                                
                           }
               
         }// end NAT section test*********************************

 if ($section == "TRA")
       { 
             if ($sectionC != $section)
                  {
 $counterTRA = 1; echo "<br><table><tr><td colspan='4'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td><tr>
                              <td></td><td valign='top' align='center'>$park</td>
                               <td valign='top'>$counterTRA</td>
                               <td><b>$title</b><br>$xyz</td></tr></table>";
                                $sectionC = $section;
                                $distC = $dist;
                                $parkC = $park;
                                $counterTRA++;
                    } // end section format

               elseif ($sectionC == $section)
                          {     
                            //    if ($distC != $dist)
                             //        { 
                                         if ($parkC != $park)
                                               {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                                          <td valign='top'>$counterTRA</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterTRA++;
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top'>$counterTRA</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterTRA++;
                                                      }
                                 //    }
                                
                           }
               
         }// end TRA section test*********************************


 if ($section == "I&E")
       {
             if ($sectionC != $section)
                  {
 $counterIE = 1; echo "<br><table><tr><td colspan='4'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td><tr>
                              <td></td><td valign='top' align='center'>$park</td>
                               <td valign='top'>$counterIE</td>
                               <td><b>$title</b><br>$xyz</td></tr></table>";
                                $sectionC = $section;
                                $distC = $dist;
                                $parkC = $park;
                                $counterIE++;
                    } // end section format

               elseif ($sectionC == $section)
                          {     
                            //    if ($distC != $dist)
                             //        { 
                                         if ($parkC != $park)
                                               {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                                          <td valign='top'>$counterIE</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterIE++;
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top'>$counterIE</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterIE++;
                                                      }
                                  //   }
                                
                           }
               
         }// end I&E section test*********************************

 if ($section == "EXH")
       {
             if ($sectionC != $section)
                  {
 $counterEXH = 1; echo "<br><table><tr><td colspan='4'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td><tr>
                              <td></td><td valign='top' align='center'>$park</td>
                               <td valign='top'>$counterEXH</td>
                               <td><b>$title</b><br>$xyz</td></tr></table>";
                                $sectionC = $section;
                                $distC = $dist;
                                $parkC = $park;
                                $counterEXH++;
                    } // end section format

               elseif ($sectionC == $section)
                          {     
                            //    if ($distC != $dist)
                             //        { 
                                         if ($parkC != $park)
                                               {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                                          <td valign='top'>$counterEXH</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterEXH++;
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table><tr><td colspan='4'><h5></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top'>$counterEXH</td>
                                                          <td><b>$title</b><br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterEXH++;
                                                      }
                                  //   }
                                
                           }
               
         }// end Exh section test*********************************
    } // end of WHILE

?>

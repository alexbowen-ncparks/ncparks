<?php
$cY1="<font color='green'>";$cY2="</font>";
$cN1="<font color='purple'>";$cN2="</font>";


while ($row = mysqli_fetch_array($total_result))
  { extract($row);
if($section=="IE"){$section="I&E";}
$flagWeek="";
if($week>$previousWeek){$flagWeek="x";}
if($week<$previousWeek){$flagWeek="y";}

echo "<input type='hidden' name='arrayID[]' value='$id'>";
                      include("section.inc");
                      include("distLong.inc");
switch ($displayLevel) {
		case "dist":
if($distApprov){$appVal="checked";}else{$appVal=$app;}
if($sectApprov){$noEdit=1;}
if($direApprov){$noEdit=1;}
			break;	
		case "sect":			
if($sectApprov){$appVal="checked";}else{$appVal=$app;}
if($direApprov){$noEdit=1;}
			break;		
		case "dire":	
if($direApprov){$appVal="checked";}else{$appVal=$app;}
			break;				
}


if($checkAll=="0"){$appVal="";}
$xyz= nl2br($body);
$section = strtoupper($section);
$sectLong = strtoupper($sectLong);
$dist = strtoupper($dist);

if(!$noEdit){$title = "<a href='update.php?id=$id'>$title</a>";}

if($flagWeek){
if($flagWeek=="x"){
$title = "<font color='red'>Entered for NEXT week's WAR?</font> <a href='update.php?id=$id'>$title</a>";}
if($flagWeek=="y"){
$title = "<font color='orange'>Entered for a PREVIOUS week's WAR?</font> <a href='update.php?id=$id'>$title</a>";}
}

$approve="<input type='checkbox' name='appEntry[$id]' value='$id' $appVal>";

if($distApprov=="x"){$ca="x";}else{$ca="-";}
$approve.="<br>$ca";

if($sectApprov=="x"){$cb="x";}else{$cb="-";}
$approve.="$cb";

if($direApprov=="x"){$cc="x";}else{$cc="-";}
$approve.="$cc";

 if ($section == "OPE")  //    /*removed $park*/ 
        {
             if ($sectionC != $section)
                  { $counterOPE = 1; 
                             echo "<table cellpadding='2'><tr><td colspan='4'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td></tr>
                              <tr>
                             <td></td>
                               <td valign='top' align='right' width='30'>$counterOPE.</td><td valign='top' width='30'>$approve</td>
                               <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
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
                                                       echo "<br><table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top' align='right' width='25'>$counterOPE.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                                            $counterOPE++;
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top' align='right' width='15'>$counterOPE.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                                           $counterOPE++;
                                                      }
                                     }
                                  elseif ($distC == $dist)
                                          //      /*removed $park*/     elseif ($parkC == $park)
                                                     {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'></td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top' align='right' width='25'>$counterOPE.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                                           $counterOPE++;
                                                      }
                                        
                           }// end OPE section test **********************************
               
         }
             
 if ($section == "CON")
      { 
             if ($sectionC != $section)
                  { 
$counterCON = 1;        echo "<br><table cellpadding='2'><tr><td colspan='5'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td><tr>
                              <td></td><td valign='top' align='center'>$park</td>
                               <td valign='top' align='right' width='25'>$counterCON.</td><td valign='top' width='30'>$approve</td>
                               <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
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
                                               {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                                          <td valign='top' align='right' width='25'>$counterCON.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterCON++;
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top' align='right' width='25'>$counterCON.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
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
 $counterADM = 1; echo "<table cellpadding='2'><tr><td colspan='5'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td><tr>
                              <td></td><td valign='top' align='center'>$park</td>
                               <td valign='top' align='right' width='25'>$counterADM.</td><td valign='top' width='30'>$approve</td>
                               <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
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
                                               {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                                          <td valign='top' align='right' width='25'>$counterADM.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterADM++;
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top' align='right' width='25'>$counterADM.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
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
$counterPLA = 1; echo "<br><table cellpadding='2'><tr><td colspan='5'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td><tr>
                              <td></td><td valign='top' align='center'>$park</td>
                               <td valign='top' align='right' width='25'>$counterPLA.</td><td valign='top' width='30'>$approve</td>
                               <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
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
                                               {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                                          <td valign='top' align='right' width='25'>$counterPLA.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
                                                           $counterPLA++;
                                                          /*$distC = $dist;
                                                          $parkC = $park;*/
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top' align='right' width='25'>$counterPLA.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
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
$counterRES = 1; echo "<br><table cellpadding='2'><tr><td colspan='4'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td><tr>
                              <td></td><td valign='top' align='center'>$park</td>
                               <td valign='top' align='right' width='25'>$counterRES.</td><td valign='top' width='30'>$approve</td>
                               <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
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
                                               {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                                          <td valign='top' align='right' width='25'>$counterRES.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterRES++;
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top' align='right' width='25'>$counterRES.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterRES++;
                                                      }
                                 //    }
                                
                           }
               
         }// end RES section test*********************************

 if ($section == "TRA")
       { 
             if ($sectionC != $section)
                  {
 $counterTRA = 1; echo "<br><table cellpadding='2'><tr><td colspan='5'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td><tr>
                              <td></td><td valign='top' align='center'>$park</td>
                               <td valign='top' align='right' width='25'>$counterTRA.</td><td valign='top' width='30'>$approve</td>
                               <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
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
                                               {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                                          <td valign='top' align='right' width='25'>$counterTRA.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterTRA++;
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top' align='right' width='25'>$counterTRA.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
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
 $counterIE = 1; echo "<br><table cellpadding='2'><tr><td colspan='5'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td><tr>
                              <td></td><td valign='top' align='center'>$park</td>
                               <td valign='top' align='right' width='25'>$counterIE.</td><td valign='top' width='30'>$approve</td>
                               <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
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
                                               {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                                          <td valign='top' align='right' width='25'>$counterIE.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterIE++;
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top' align='right' width='25'>$counterIE.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
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
 $counterEXH = 1; echo "<br><table cellpadding='2'><tr><td colspan='5'>$sectLong</td></tr>
                              <tr><td colspan='5'>$dist</td><tr>
                              <td></td><td valign='top' align='center'>$park</td>
                               <td valign='top' align='right' width='25'>$counterEXH.</td><td valign='top' width='30'>$approve</td>
                               <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
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
                                               {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'>$park</td>
                                                          <td valign='top' align='right' width='25'>$counterEXH.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterEXH++;
                                                }
                                          elseif ($parkC == $park)
                                                     {echo "<table cellpadding='2'><tr><td colspan='4'></td></tr>
                                                          <tr><td colspan='5'>$dist</td><tr>
                                                          <td></td><td valign='top' align='center'></td>
                                                          <td valign='top' align='right' width='25'>$counterEXH.</td><td valign='top' width='30'>$approve</td>
                                                          <td><b>$title</b>&nbsp;&nbsp;&nbsp;Entered on: <font color='brown'>$dateEntered</font>&nbsp;&nbsp;&nbsp;$da<br>$xyz</td></tr></table>";
                                                          $distC = $dist;
                                                          $parkC = $park;
                                $counterEXH++;
                                                      }
                                  //   }
                                
                           }
               
         }// end Exh section test*********************************
  
    } // end of WHILE
    
$link1=$link."checkAll=1";
$link0=$link."checkAll=0";
 echo "<table><tr><td width='35'></td> 
<td><a href='$link1'>Check All</a></td>
<td> &nbsp;&nbsp;&nbsp;&nbsp;<a href='$link0'>UnCheck All</a></td>
<td width='225' align='right'>
<input type='submit' name='Submit' value='Approve Checked Entries'></td>
</tr></table></form></body></html>";
?>
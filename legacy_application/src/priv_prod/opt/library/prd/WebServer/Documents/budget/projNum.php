<?php
// *************** Show Project FUNCTIONS **************
// Individual Project
extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
echo "<br />WELCOME to projNum.php<br />";

function permitShow0($projNum,$projYN,$reportDisplay,$projCat,$projSCnum,$projDENRnum,$Center,$budgCode,$comp,$projsup,$manager,$fundMan,$YearFundC,$YearFundF,$fullname,$dist,$county,$section,$park,$projName,$active,$startDate,$endDate,$statusProj,$percentCom,$statusPer,$comments,$commentsI,$dateadded,$brucefy,$proj_man,$secondCounty,$div_app_amt,$res_proj,$partfyn,$partf_approv_num,$femayn,$fema_proj_num,$mult_proj,$bond_fund,$state_appro,$reserve_proj,$design,$construction,$partfid,$cwmtf_fund,$num,$passSQL,$user_id,$showpa,$state_prop_num)

     {
     global $a1,$a2,$user_name,$pj_timestamp, $pass_park_list;
     $temp=array("Y","N");
     $manager_drop=array("amy_sawyer","craig_autry","daron_blount","dwayne_parker","george_norris","jerry_howerton","jody_reavis","johnny_johnson","justin_williamson","mark_lyons","neal_pate","patrick_noel","randy_ayers","shane_felts","vinnie_shea","jon_blanchard");
     $district_drop=array("east","north","south","west","stwd");
     $projcat_drop=array("ci","de","en","er","nr","la","mi","mm","tm");
     if($pj_timestamp)
          {
          $sub="Update";
          if($dateadded==""){$dateadded=date("YmdHis");}
          $hid="<input type='hidden' name='dateadded' value='$dateadded'><input type='hidden' name='partfid' value='$partfid'>";
          }
          else
          {
     $dateadded=date("YmdHis");
     $hid="<input type='hidden' name='dateadded' value='$dateadded'>";
     $sub="Add Data";
          }
     //if($passSQL){$link="<a href='conReportDPR.php?$sql'>Return</a>";}
     echo "<table>
     <tr><td>$link</td></tr></table>";

     echo "<hr><table>
     <form method='post' action='partf.php'>";

     if($level>4){$ro="";}else{$ro="READONLY";}
     echo "<tr><td>Project Number <input type='text' name='projNum' size='5' value='$projNum' $ro></td>
     <td>Project Y or N <select name='projYN'>";
     echo "<option value=''>\n";
       for ($zz=0;$zz<=1;$zz++){
      $scode=$temp[$zz];if($scode==strtoupper($projYN)){$s="selected";}else{$s="value";}
               echo "<option $s='$scode'>$scode\n";
               }
     echo "</select></td></tr>
     <tr><td>Park Code <select name='park'><option selected=''></option>\n";
     asort($pass_park_list);
          foreach($pass_park_list as $k_park=>$v_park)
               {
               if($v_park==$park){$s="selected";}else{$s="value";}
               echo "<option $s='$v_park'>$v_park</option>\n";
               }
     
          echo "</select></td>";
     
     echo "<td>
     Project Name <input type='text' name='projName' size='36' value=\"$projName\"></td></tr>";
     
     //echo "<tr>";
     /*
     echo "<td>
     DEDE Report <select name='reportDisplay'>";
     echo "<option value=''>\n";
       for ($zz=0;$zz<=1;$zz++){
      $scode=$temp[$zz];if($scode==strtoupper($reportDisplay)){$s="selected";}else{$s="value";}
               echo "<option $s='$scode'>$scode\n";
               }
     echo "</select></td>";
     */
     /*
     echo "<td>
     Proj. Category <input type='text' name='projCat' size='5' value='$projCat'></td>";
     */
     
     echo "<tr><td>
     Project Category <select name='projCat'>";
     echo "<option value=''>\n";
       for ($zz=0;$zz<=8;$zz++){
     $scode=$projcat_drop[$zz];if($scode==strtolower($projCat)){$s="selected";}else{$s="value";} echo "<option $s='$scode'>$scode\n";
               }
     echo "</select></td></tr>";
     
     
     echo "</tr>
     <tr><td>
     Center <input type='text' name='Center' size='6' value='$Center'></td>
     <td>
     Budget Code <input type='text' name='budgCode' size='6' value='$budgCode'></td>
     </tr><tr><td>
     Company <input type='text' name='comp' size='6' value='$comp'></td></tr>
     <tr><td>
     State Property Number <input type='text' name='state_prop_num' size='16' value='$state_prop_num'></td></tr>";
//   echo "<tr><td>Proj. Manager <input type='text' name=\"manager\" size='16' value='$manager'></td></tr>";



echo "<tr><td>
     Manager <select name='manager'>";
     echo "<option value=''>\n";
       for ($zz=0;$zz<=15;$zz++){
     $scode=$manager_drop[$zz];if($scode==strtolower($manager)){$s="selected";}else{$s="value";} echo "<option $s='$scode'>$scode\n";
               }
     echo "</select></td></tr>";


     
     
/*   
$a3=array("Shane_Felts","Randy_Ayers","Patrick_Noel","Johnny_Johnson","Craig_Autry");
$a4=array("Shane_Felts","Randy_Ayers","Patrick_Noel","Johnny_Johnson","Craig_Autry");

echo "<tr>";
echo "<td>Proj. Manager<form>
 <select name=\"manager\" <option selected></option>";
for ($n=0;$n<count($a3);$n++){$scode=$a3[$n];$s="value";
          echo "<option $s='partf.php?manager=$scode'>$a4[$n]\n";
       }
   echo "</select></form></td>";
echo "<td><form action='partf.php'>
Find/Edit Project: <input type='text' name='projNum' size='5'>
<input type='Submit' name='Submit' value='Find'></form></td>";
echo "</tr>";
*/   
     
     
     //echo "<tr><td>Manager initials<input type='text' name='proj_man' size='6' value='$proj_man'></td></tr>";
     echo "<tr>
     <td>
     Calendar Year Init. Fund <input type='text' name='YearFundC' size='6' value='$YearFundC'></td>
     </tr><tr><td>
     Fiscal Year Init. Fund <input type='text' name='YearFundF' size='6' value='$YearFundF'></td>
     </tr>
     <tr><td>
     Show DPR <select name='active'>";
     echo "<option value=''>\n";
       for ($zz=0;$zz<=1;$zz++){
     $scode=$temp[$zz];if($scode==strtoupper($active)){$s="selected";}else{$s="value";} echo "<option $s='$scode'>$scode\n";
               }
     echo "</select></td></tr>
     <tr><td>
     Show PA <select name='showpa'>";
     echo "<option value=''>\n";
       for ($zz=0;$zz<=1;$zz++){
     $scode=$temp[$zz];if($scode==strtoupper($showpa)){$s="selected";}else{$s="value";} echo "<option $s='$scode'>$scode\n";
               }
     echo "</select></td></tr>

     <tr><td>Park Name <input type='text' name='fullname' size='25' value='$fullname'></td>";
     /*
     echo "<td>
     District <input type='text' name='dist' size='25' value='$dist'></td>"
     */
     
     echo "<td>
     District <select name='dist'>";
     echo "<option value=''>\n";
       for ($zz=0;$zz<=4;$zz++){
     $scode=$district_drop[$zz];if($scode==strtolower($dist)){$s="selected";}else{$s="value";} echo "<option $s='$scode'>$scode\n";
               }
     echo "</select></td>";
     
     echo "</tr><tr><td>
     County <input type='text' name='county' size='25' value='$county'></td></tr>
     <tr><td>
     Section <input type='text' name='section' size='25' value='$section'></td>
     </tr></table>
     <table><tr>
     <td>
     Est. Construct. Start Date <input type='text' name='startDate' size='10' value='$startDate'></td>
     </tr><tr><td>
     Est. Construct. End Date <input type='text' name='endDate' size='10' value='$endDate'></td></tr>
     <tr><td>
     Design % <input type='text' name='design' size='6' value='$design'></td>
     </tr><tr><td>
     Construction % <input type='text' name='construction' size='6' value='$construction'></td>
     </tr><tr><td>
     Current Status: <select name=\"statusPer\"><option value=''></option>";
     for ($n=0;$n<count($a1);$n++){
     $scode=$a1[$n];if($scode==$statusPer){$s="selected";}else{$s="value";}
               echo "<option $s='$scode'>$a2[$n]\n";
             }
     $timestamp=$pj_timestamp;
       $year = substr($timestamp, 0, 4);
          $month = substr($timestamp, 4, 2);
          $day = substr($timestamp, 6, 2);
          $hour = substr($timestamp, 8, 2);
          $min = substr($timestamp, 10, 2);
          $sec = substr($timestamp, 12, 2);
          $pubdate = date('D, d M Y H:i:s', mktime($hour, $min, $sec, $month, $day, $year));

        echo "</select> Not Started,In Progress,On Hold,Finished</td>
     </tr>
     <tr><td>
     Comments Internal <textarea name=\"commentsI\" cols='55' rows='2'>$commentsI</textarea></td></tr>
     <tr><td>
     Date Added: $dateadded</td>
     </tr><tr><td>
     Orig. DPR App. Amt.<input type='text' name='div_app_amt' size='16' value='$div_app_amt'></td>
     </tr><tr><td>
     Entered By / Last Modified By: $user_id $pubdate</td></tr>
     <TR><td>Will be modified by: $user_name</td>
     </tr>
     <tr><td>$hid<input type='hidden' name='user_id' value='$user_name'>
     <input type='submit' name='submit' value='$sub'></form></td></tr>
     </table>";
     }

?>
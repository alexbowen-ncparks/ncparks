<?php

$database="budget";
$db="budget";

include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters

mysqli_select_db($connection, $database); // database

/*
$park_lower=strtolower($concession_location);
if($park_lower == 'adm'
    OR $park_lower == 'admi'
    OR $park_lower == 'york'
    OR $park_lower == 'ware'
    OR $park_lower == 'nara'
    OR $park_lower == 'rema')
{
    $park_lower = 'clne' ;
    $park_title = 'cliffs of neuse';
}
if($park_lower == 'eadi')
{
    $park_lower = 'clne';
    $park_title = 'cliffs of neuse';
}
// if($tempid == 'Fullwood1940')
    // {
        // $park_lower = 'memi';
        // $park_title = 'merchants millpond';
    // }
if($park_lower == 'nodi')
{
    $park_lower = 'enri';
    $park_title = 'eno river';
}
if($park_lower == 'sodi')
{
    $park_lower = 'momo';
    $park_title = 'morrow mountain';
}
if($park_lower == 'wedi')
{
    $park_lower = 'neri';
    $park_title = 'new river';
}
*/
// $park_lower_pic = "/budget/infotrack/icon_photos/".$park_lower.".jpg";
// PASSPORT $park_lower_pic = "/budget/infotrack/icon_photos/mission_icon_photos_236.jpg";
// $park_lower_pic = "/budget/infotrack/icon_photos/snow1.gif";
// $park_title = '100 Mile Challenge';
// PASSPORT $park_title='Passport';

// echo "park_lower_pic = $park_lower_pic<br />";
// $headline_photo_link = "http://ncparks.gov/100/100-mile-challenge";
// PASSPORT $headline_photo_link = "http://www.ncparks.gov/passport-program";

// if($beacnum == '60032793') // Tony Bass's beacon position number
// {
        /*
        $park_lower_pic = $home_photo;

        $park_title = $home_label;

        $headline_photo_link = $home_photo_link;

        $weather_add = "<a href='$headline_photo_link' target='_blank'>".$home_label."</a>";

        */
// }
// $today_poll = "poll_form_6.php";
// $today_poll = "favorite_class1.php";
//echo "<br />concession_location = $concession_location<br />";

$query100 = "SELECT zip,
                    weather_add2
            FROM energy_park_addresses
            WHERE parkcode = '$concession_location'
            ";
$result100 = mysqli_query($connection, $query100)
            OR
            die ("Line 82. Couldn't execute query 100.<br/>
                query100");
$row100 = mysqli_fetch_array($result100);
extract($row100);   // brings back MAX(end_date) AS $end_date

// if($concession_location == 'ADM')
    // {
            // $zip = '27601';
// }
// echo "concession_location = $concession_location<br />
    // zip = $zip<br />
        //";
// echo "query100 = $query100<br />";
// echo "$weather_add2";
//exit;

$today=date("Y-m-d");

$query1 = "SELECT MAX(hid) AS 'hidmax'
            FROM mission_headlines
            WHERE date <= '$today'
            ";
$result1 = mysqli_query($connection, $query1)
        OR
            die ("Line 106. Couldn't execute query 1.  $query1");
$row1 = mysqli_fetch_array($result1);
extract($row1); // brings back MAX(end_date) AS $end_date
//echo "hidmax=$hidmax";


if($hid==''){$hid=$hidmax;}

$hidback=$hid-1;

$hidforward=$hid+1;

if($hid<'1'){$hid='1';}

if($hidforward > $hidmax){$hidforward=$hidmax;}

if($hidback=='0'){$hidback='1';}

//echo "hidback=$hidback";

if($hid < 1565)

{

//$today_poll="poll_form_6.php";

$today_poll="favorite_season1.php";

}



if($hid >= 2221 and $hid <= 2228)

{

$today_poll="favorite_class1.php";

//$today_poll="favorite_recreation1.php";

}



if($hid >= 2229 and $hid <= 2236)

{

$today_poll="favorite_movie1.php";

//$today_poll="favorite_recreation1.php";

}







if($hid >= 1572 and $hid <= 1578)

{

//$today_poll="favorite_class1.php";

$today_poll="favorite_recreation1.php";

}





if($hid >= 1579 and $hid <= 1585)

{

//$today_poll="favorite_class1.php";

$today_poll="favorite_animal3_headline.php";

}





if($hid == 2187)

{

//$today_poll="favorite_class1.php";

$today_poll="favorite_sitcom1.php";

}







if($hid > 2188 and $hid < 2192)

{

//$today_poll="favorite_class1.php";

$today_poll="favorite_animal1.php";

}



if($hid == 2192)

{

//$today_poll="favorite_class1.php";

$today_poll="favorite_music1.php";

}



if($hid == 2202)

{

//$today_poll="favorite_class1.php";

$today_poll="favorite_pie1.php";

}







if($hid == 2194)

{

//$today_poll="favorite_class1.php";

$today_poll="favorite_park1.php";

}









/*

if($hid >= 2185 and $hid <= 2191)

{

//$today_poll="favorite_class1.php";

$today_poll="favorite_sitcom1.php";

}

*/



//if($beacnum=='60032793')

//{

    

//if($hid >= 1593 and $hid <= 1599)

if($hid >= 1761 and $hid <= 1767)

{

//$today_poll="favorite_class1.php";

$today_poll="favorite_service1.php";

}   

/*  

if($hid >= 1768)

{

//$today_poll="favorite_class1.php";

$today_poll="favorite_gratitude1.php";

}       

*/  

    

//} 



if($hid >= 1863 and $hid <= 1864)

{

//$today_poll="favorite_class1.php";

$today_poll="favorite_basketball1.php";

}   



$query_trivia="select gid as 'gid_trivia',game_name as 'game_name_trivia',game_quote as 'game_quote_trivia',qcount as 'qcount_trivia' from games where headline='y' order by gid desc limit 1";

//echo "<br />query2=$query2<br />";

$result_trivia = mysqli_query($connection, $query_trivia) or die ("Couldn't execute query trivia.  $query_trivia");



$row_trivia=mysqli_fetch_array($result_trivia);

extract($row_trivia);//brings back max (end_date) as $end_date



//echo "<br />gid_trivia=$gid_trivia<br />game_name_trivia=$game_name_trivia<br />game_quote_trivia=$game_quote_trivia<br />qcount_trivia=$qcount_trivia<br />";









$query2="select date as 'todaysdate',header_message,message from mission_headlines where hid=$hid";

//echo "<br />query2=$query2<br />";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");



$row2=mysqli_fetch_array($result2);

extract($row2);//brings back max (end_date) as $end_date

//echo "header_message: $header_message<br />";

//echo "message: $message<br />";

//echo "<br />";





$query2a="select pcard_message from pcard_report_dates where active_date='$todaysdate' ";

//echo "<br />query2a=$query2a<br />";

$result2a = mysqli_query($connection, $query2a) or die ("Couldn't execute query 2a.  $query2a");



$row2a=mysqli_fetch_array($result2a);

extract($row2a);//brings back max (end_date) as $end_date

//echo "<br />query2a=$query2a<br />";

//echo "<br />pcard_message=$pcard_message<br />";



$query2b="select quote_comment,author from money_quotes where mq_date='$todaysdate' ";

$result2b = mysqli_query($connection, $query2b) or die ("Couldn't execute query 2b.  $query2b");



$row2b=mysqli_fetch_array($result2b);

extract($row2b);//brings back max (end_date) as $end_date



//echo "<br />query2b=$query2b<br />";

//echo "<br />quote_comment=$quote_comment<br />";

/*

if($quote_comment != '')

{

echo "<br /><table align='center'><tr><th>Quote of the Day:</th><td><i>$quote_comment  ($author)</i></td></tr></table>";

echo "<br />";

}

*/















//if($quote_comment != '')

{

$query3="SELECT ncas_end_date2 from project_steps_final
         where 1 "; 



$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");



$row3=mysqli_fetch_array($result3);

extract($row3);//brings back max (fiscal_year) as $fiscal_year  

//$ncas_end_date=str_replace("-","",$ncas_end_date);
//$ncas_end_date2=date('m-d-y', strtotime($ncas_end_date));
    

echo "<br /><table align='center'><tr><th>NCAS (Receipts and Charges)</th><td><font color='brown' class='cartRow'>Last Update: $ncas_end_date2</font></td></tr></table>";

echo "<br /><br />";

}

if($gid_trivia != '')

{

echo "<br /><table align='center'><tr><th><img height='50' width='50' src='/budget/infotrack/icon_photos/target_dart1.png' alt='runner icon' title='Players'></img></th><th>$game_name_trivia ($qcount_trivia questions)<br /><a href='/budget/games/multiple_choice/games.php?gid2=$gid_trivia&gidS=none&game_overview=y' target='_blank'>PLAY</a></th></tr></table>";

echo "<br />";

}

/*

if($beacnum=='60032781')

{

include("money_quotes_scores_headline2.php");       

}   

*/

if($level<3)

{

echo "<br />";

echo "<table align='center' border='1'>";

echo "<tr><th colspan='3'><a href='/budget/headlines_view.php'>view all Headlines</a><br /><a href='/budget/menu.php?forum=blank&hid=$hidback' title='previous headlines'><<</a>Headline: $header_message<a href='/budget/menu.php?forum=blank&hid=$hidforward' title='Todays headline'>>></a></th></tr>";

echo "<tr><td colspan='2'>$message</td>";

//echo "<td>$weather_add2</td>";

echo "<td>";

//include("poll_form_6.php");

if($today_poll != '')

{

include($today_poll);

}

//include("money_quotes_scores_headline2.php");

echo "</td>";

echo "</tr>";

//echo "<tr><td colspan='3'>$weather_add2</td></tr>";



if($pcard_message != '')

{

echo "<tr><td colspan='2'><img height='40' width='40' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><font color='brown'><b>$pcard_message</b></font></td></tr>";

}



/*

echo "<tr><th><a href='$headline_photo_link' target='_blank'><img src='$park_lower_pic' title='$park_title' alt='park picture' height='200' width='600'></img></a></th><th>$weather_add</th></tr><tr><th colspan='2'>$message</th></tr>";

*/

echo "</table>";

echo "<br />";



//echo "<br />cashier_count=$cashier_count<br />";



if($cashier_count==1 or $manager_count==1)

{

//echo "<table><tr><td>hello world</td></tr></table>";

include("acs/pcard_recon_alert.php");   

}


if($level==1)
{
if($manager_count==1)

{

//echo "<table><tr><td>hello world</td></tr></table>";

include("aDiv/preapproval_weekly_alert.php");   

}
}


}







if($beacnum=='60032913' or $beacnum=='60032931'){include("infotrack/missions_1.php"); } //west office (DISU/Admin)

if($beacnum=='60032912' or $beacnum=='60032892'){include("infotrack/missions_1.php"); } //east office (DISU/Admin)

if($beacnum=='65030652' or $beacnum=='60032920'){include("infotrack/missions_1.php"); } //north office (DISU/Admin)

if($beacnum=='60033019' or $beacnum=='60033093'){include("infotrack/missions_1.php"); } //south office (DISU/Admin)


if($level=='1'){include("infotrack/missions.php"); } //south office



if($level==3)

{

echo "<br />";

echo "<table align='center' border='1'>";

echo "<tr><th colspan='3'><a href='/budget/headlines_view.php'>view all Headlines</a><br /><a href='/budget/menu.php?forum=blank&hid=$hidback' title='previous headlines'><<</a>Headline: $header_message<a href='/budget/menu.php?forum=blank&hid=$hidforward' title='Todays headline'>>></a></th></tr>";

echo "<tr><td colspan='2'>$message</td>";

echo "<td>";

//include("poll_form_6.php");

if($today_poll != '')

{

include($today_poll);

}

//include("money_quotes_scores_headline2.php");

echo "</td>";

echo "</tr>";

echo "<tr><td colspan='3'>$weather_add2</td></tr>";

if($pcard_message != '')

{

echo "<tr><td colspan='2'><img height='40' width='40' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><font color='brown'><b>$pcard_message</b></font></td></tr>";

}

/*

echo "<tr><th><a href='$headline_photo_link' target='_blank'><img src='$park_lower_pic' title='$park_title' alt='park picture' height='200' width='600'></img></a></th><th>$weather_add</th></tr><tr><th colspan='2'>$message</th></tr>";

*/

echo "</table>";

echo "<br />";







}





if($level==4)



{
//echo "$cashier_count";


/*

if($beacnum=='60036015' or $beacnum=='60032791' or $beacnum=='60033242' or $beacnum=='60032997')  //heide,joanne,rebecca,rachel

{

echo "<table align='center'>";

echo "<tr>";

echo "<th>";

echo "<a href='infotrack3/flag1.php?type=search&flag_search=search' target='_blank'>

<img height='25' width='25' src='/budget/infotrack/icon_photos/mission_icon_photos_259.png' alt='red trash can' title='red flag'></img><br /><font color='brown'>Flags</font>

</a>";

echo "</th>";

echo "</tr>";

echo "</table>";

}   

*/





//echo "tempid=$tempid<br />";

echo "<br />";

echo "<table align='center' border='1' >";

echo "<tr><th colspan='3'><a href='/budget/headlines_view.php'>view all Headlines</a><br /><a href='/budget/menu1314.php?forum=blank&hid=$hidback' title='previous headlines'><<</a>Headline: $header_message<a href='/budget/menu1314.php?forum=blank&hid=$hidforward' title='Todays headline'>>></a></th></tr>";

echo "<tr><td colspan='2'>$message</td>";

echo "<td>";

//include("poll_form_6.php");

if($today_poll != '')

{

include($today_poll);

}

//include("money_quotes_scores_headline2.php");

echo "</td>";

echo "</tr>";

echo "<tr><td colspan='3'>$weather_add2</td></tr>";

if($pcard_message != '')

{

echo "<tr><td colspan='2'><img height='40' width='40' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><font color='brown'><b>$pcard_message</b></font></td></tr>";

}

echo "</table>";







}



//echo "beacnum=$beacnum";



/*($beacnum=='60032781' or $beacnum=='60032793' or $beacnum=='60032920' or $beacnum=='60033018' or $beacnum=='60032778' or $beacnum=='60032787' or $beacnum=='60032779' or $beacnum=='60033160' or $beacnum=='60033012')*/

//echo "level=$level<br />";

if($level > 4)

{

$query4b="select park as 'message_park',message_read,comment_id,user,concat(LEFT(comment_note,300),'  ....') as 'comment_note' from infotrack_projects_community_com where 1 and system_entry_date = '$todaysdate' and park !='admi' and pid = '' and message_read != 'y'  order by park,comment_id ";

//echo "query4b<br />";

$result4b = mysqli_query($connection, $query4b) or die ("Couldn't execute query 4b.  $query4b");

$num4b=mysqli_num_rows($result4b);

echo "<br />";

echo "<table align='center' border='1' >";

echo "<tr><th colspan='3'><a href='/budget/headlines_view.php'>view all Headlines</a><br /><a href='/budget/menu1314.php?forum=blank&hid=$hidback' title='previous headlines'><<</a>Headline: $header_message<a href='/budget/menu1314.php?forum=blank&hid=$hidforward' title='Todays headline'>>></a></th></tr>";

/*

echo "<tr><th><a href='$headline_photo_link' target='_blank'><img src='$park_lower_pic' title='$park_title' alt='park picture' height='200' width='600'></img></a></th>";

*/

/*

if($beacnum=='60032793')

{

echo "<th><a href='infotrack/icons.php' target='_blank'>Edit Photo</a></th>";

}

*/

//echo "</tr>";



echo "<tr><td colspan='2'>$message</td>";

//if($beacnum=='60032781')

//{

echo "<td>";

//include("money_quotes_scores_headline2.php");

if($today_poll != '')

{

include($today_poll);

}

echo "</td></tr>";

echo "<tr><td colspan='3'>$weather_add2</td></tr>";

//}

if($pcard_message != '')

{

echo "<tr><td colspan='2'><img height='40' width='40' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><font color='brown'><b>$pcard_message</b></font></td></tr>";

}

echo "</table>";



echo "<br />";



if($num4b==0)

{

echo "<table border='1' align='center'><tr><th colspan='4'>No Messages for $header_message</th></tr></table>";

}

else

{

echo "<table border='1' align='center'><tr><th colspan='4'>Messages: $header_message  <a href='/budget/infotrack/notes.php?project_note=note_tracker'><img height='40' width='40' src='/budget/infotrack/icon_photos/message_green1.png' alt='picture of home'></img></a></th></tr>";

while ($row4b=mysqli_fetch_array($result4b)){



// The extract function automatically creates individual variables from the array $row

//These individual variables are the names of the fields queried from MySQL

extract($row4b);



$user=substr($user,0,-2);

$comment_note=str_replace('  ','&nbsp;&nbsp;',$comment_note);

$comment_note=nl2br($comment_note);



if($message_read=="y"){$bgc="#c2efbc";} else {$bgc="lightsalmon";}



echo "<tr bgcolor=$bgc><td align='center' ><font color='brown'>$message_park<br />$user</font></td><td>$comment_note<a href='/budget/infotrack/note_tracker_noteprint.php?comment_id=$comment_id'><img height='20' width='20' src='/budget/infotrack/icon_photos/magnify.png' alt='picture of home'></img></a></tr>";





}



echo "</table>";

}





}



if($level > 2 and ($cashier_count==1 or $manager_count==1)) //erin lawrence, brian strong

//if($cashier_count==1 or $manager_count==1)

//if($beacnum=='60032781')  

{

include("acs/pcard_recon_alert.php");   

}





if($beacnum=='60032793'){include("infotrack/missions_1.php"); } //accountant-bass

if($beacnum=='60032781'){include("infotrack/missions_1.php"); } //budget officer-dodd

if($beacnum=='65032850'){include("infotrack/missions_1.php"); } //budget officer-mahnaz

if($beacnum=='60032778'){include("infotrack/missions_1.php"); } //director-murphy

if($beacnum=='60033018'){include("infotrack/missions_1.php"); } //chop-lambert

//if($beacnum=='60032920'){include("infotrack/missions_1.php"); } //chop admin-d.williams

if($beacnum=='60033148'){include("infotrack/missions_1.php"); } // Deputy Director of Operations OA

if($beacnum=='60036015'){include("infotrack/missions_1.php"); } //heidi rumble

if($beacnum=='60032779'){include("infotrack/missions_1.php"); } //don reuter

if($beacnum=='60033160'){include("infotrack/missions_1.php"); } //brian strong

if($beacnum=='60033202'){include("infotrack/missions_1.php"); } //carol tingley

if($beacnum=='60033162'){include("infotrack/missions_1.php"); } //tara gallagher

if($beacnum=='60033012'){include("infotrack/missions_1.php"); } //jerry howerton

if($beacnum=='60032790'){include("infotrack/missions_1.php"); } //sue regier

if($beacnum=='60032877'){include("infotrack/missions_1.php"); } //siobhan oneal

if($beacnum=='60032786'){include("infotrack/missions_1.php"); } //kelly chandler

if($beacnum=='60033009'){include("infotrack/missions_1.php"); } //jessie summers

if($beacnum=='60032997'){include("infotrack/missions_1.php"); } //rachel gooding

if($beacnum=='60033242'){include("infotrack/missions_1.php");} // Angela Boggus

if($beacnum=='65032827'){include("infotrack/missions_1.php");} // Cameron Williams

if($beacnum=='60032791'){include("infotrack/missions_1.php"); } //vernon price

if($beacnum=='60032780'){include("infotrack/missions_1.php"); } //sean higgins

if($beacnum=='60032945'){include("infotrack/missions_1.php"); } //carl jeeter

if($beacnum=='60033189'){include("infotrack/missions_1.php"); } //keith bilger

if($beacnum=='60092637'){include("infotrack/missions_1.php"); } //martin kane

if($beacnum=='60032787'){include("infotrack/missions_1.php"); } //jennifer goss

if($beacnum=='60032833'){include("infotrack/missions_1.php"); } //erin lawrence

if($beacnum=='60032828'){include("infotrack/missions_1.php"); } //jon blanchard

if($beacnum=='60092634'){include("infotrack/missions_1.php"); } //jan trask

if($beacnum=='60033136'){include("infotrack/missions_1.php"); } //rosilyn mcnair

if($beacnum=='60032785'){include("infotrack/missions_1.php"); } //teresa mccall

if($beacnum=='60033138'){include("infotrack/missions_1.php"); } //steve livingstone

if($beacnum=='60032784'){include("infotrack/missions_1.php"); } //adrienne eikinas

if($beacnum=='60095522'){include("infotrack/missions_1.php"); } //vincent newman-brooks

if($beacnum=='60032788'){include("infotrack/missions_1.php"); } //charlie peek

if($beacnum=='60032942'){include("infotrack/missions_1.php"); } //darrell mcbane

if($beacnum=='60033137'){include("infotrack/missions_1.php"); } //catherine locke

if($beacnum=='60032794'){include("infotrack/missions_1.php"); } //laura fuller NARA

if($beacnum=='65027689'){include("infotrack/missions_1.php"); } //john carter

if($tempid=='Howard6319'){include("infotrack/missions_1.php"); } //tom howard

//if($tempid=='Grunder0429'){include("infotrack/missions_1.php"); } //erech grunder

if($tempid=='Cucurullo1234'){include("infotrack/missions_1.php"); } //maria cucurullo

if($tempid=='brodie2030'){include("infotrack/missions_1.php"); } //talivia brodie

if($tempid=='debragga1235'){include("infotrack/missions_1.php"); } //denr audit joseph debragga





$query1="select header_message as 'header_message_max',header_message2,header_message2_date,undeposited_message,weekend,headline_mission_file from mission_headlines where hid=$hidmax";

//echo "query1=$query1";

//$query1="select max(date) as 'maxdate' from mission_headlines where 1 ";

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);

extract($row1);









//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>";//exit;



$park_code=$_SESSION['budget']['select'];

//echo "park_code=$park_code";

if($park_code=='ADM'){$park_code='ADMI';}

$query2="select date as 'maxdate' from mission_headlines where hid='$hidmax' ";

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");

$row2=mysqli_fetch_array($result2);

extract($row2);//brings back max (fiscal_year) as $fiscal_year





//if($level==5)

    



//if($beacnum=='60032793')

{



include("$headline_mission_file");



}



echo "<br />";

// 9/18/14







echo "<br />";

//echo "$concession_location";

if($level < 2)

{

$query3="SELECT pid

         from procedures

         where park='$concession_location'

         ";



//echo "query3=$query3";

$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");



$row3=mysqli_fetch_array($result3);

extract($row3);

}

if($level < 2)

{

include("admin/crj_updates/crs_deposits_crj_listing3_division.php");

include("admin/crj_updates/crs_deposits_crj_listing2_final_unapproved.php");

}





if($beacnum=='60036015' or $beacnum=='60032997' or $beacnum=='60032791' or $beacnum=='60033242' or $beacnum=='65032827')

{

include("admin/crj_updates/crs_deposits_crj_listing3_division.php");
//echo "<br />hello world<br />";
include("admin/crj_updates/crs_deposits_crj_listing2_final_unapproved.php");

}











echo "<br /><br />";

IF ($level == 1
   AND ($cashier_count == 1
      OR $manager_count == 1
      )
   AND ($beacnum <> '60032846')
   )

//{echo "<table align='center'><tr><th><a href='/budget/concessions/park_inc_stmts_by_fyear_v2.php?fyear=1920&scope=park&report_type=pfr'><font color='brown'>RETAIL Results-Fiscal Year 1920</font><br /><img height='200' width='200' src='/budget/infotrack/icon_photos/mission_icon_photos_265.jpg' alt='cabe marina store'></img><br /></a></th></tr></table>";}
{echo "<table align='center'><tr><th><a href='/budget/concessions/park_inc_stmts_by_fyear_v2.php?fyear=2223&scope=park&report_type=pfr'><font color='brown'>RETAIL Results-Fiscal Year 2223</font><br /><img height='200' width='200' src='/budget/infotrack/icon_photos/mission_icon_photos_265.jpg' alt='cabe marina store'></img><br /></a></th></tr></table>";}





// East District Mgr, South District Mgr, West District Mgr, North District Manager

if ($beacnum=='60032912'
   or $beacnum=='60033019'
   or $beacnum=='60032913'
   or $beacnum=='65030652')
{echo "<table align='center'><tr><th><a href='/budget/concessions/park_inc_stmts_by_fyear_v2.php?fyear=2223&scope=park&report_type=pfr'><font color='brown'>RETAIL Results-Fiscal Year 2223</font><br /><img height='200' width='200' src='/budget/infotrack/icon_photos/mission_icon_photos_265.jpg' alt='cabe marina store'></img><br /></a></th></tr></table>";}



// 1)Budget Officer, Budget analyst 2)Concessions Manager, 3)CHOP, 4)Director, 5)Don Reuter, 6)Carol Tingley, 
// 7)Brian Strong, 8)John Carter 9)Accounting Specialist

if ($beacnum=='60032781'
    or $beacnum=='65032850'
    or $beacnum=='60033162'
    or $beacnum=='60033018'
    or $beacnum=='60032778'
    or $beacnum=='60032779'
    or $beacnum=='60033202'
    or $beacnum=='60033160'
    or $beacnum=='65027689'
    or $beacnum=='60032793'
    or $beacnum == '60032846'
   )
{
   echo "<table align='center'>
            <tr>
               <th>
                  <a href='/budget/concessions/park_inc_stmts_by_fyear_v2.php?fyear=2223&scope=all&report_type=pfr'>
                     <font color='brown'>
                        RETAIL Results-Fiscal Year 2223
                     </font>
                     <br />
                     <img height='200' width='200' src='/budget/infotrack/icon_photos/mission_icon_photos_265.jpg' alt='cabe marina store'>
                     </img>
                     <br />
                  </a>
               </th>
            </tr>
         </table>
      ";
}



echo "<br /><br />";







?>


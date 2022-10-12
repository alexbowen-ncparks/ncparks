<?php
//echo "<table><tr><td>beacnum</td><td>$beacnum</td></tr></table>";
//echo "Line3<br />"; exit;
//if($concession_location=='ADM'){$concession_location='ADMI';}
if($team=='ADM'){$team='ADMI';}
if($team=='ARCH'){$team='ADMI';}
//echo "Line 7: <br />team=$team<br />";
//if($beacnum=='60033138'){$concession_location='ADMI';}
//if($beacnum=='60032787'){$concession_location='DEDE';}
//if($beacnum=='60032794'){$concession_location='NARA';}


echo "<table align='center'>";
echo "<tr>";	
	
echo "<th>
<a href='/conference/conference_list.php'>
<img height='50' width='50' src='/conference/icon_photos/home1.png' alt='picture of home' title='Home'></img>	<br /><font color='brown'>Home</font>
</a></th>";




//if($concession_location=='ADM'){$concession_location='ADMI';}
//10-25-14
//$query2="select center_desc,center from center where parkcode='$concession_location' and fund='1280'   ";	
$query="select center_desc from center where parkcode='$team' and fund='1280'   ";	
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");
$num=mysqli_num_rows($result);
//echo "query2=$query2<br />";//exit;		  


		  
$row=mysqli_fetch_array($result);

extract($row);

$center_location = str_replace("_", " ", $center_desc);

//echo "center_location=$center_location<br />";
	
	
//echo "<td colspan='8' align='center'><font size='+1'><b>2017 ASSPD Conference</b><br /><img height='75' width='125' src='icon_photos/pimo.jpg' alt='picture of pilot mountain'></img></font></td>";

echo "<th>2017<br /><img height='75' width='125' src='icon_photos/oa_conference.jpg' alt='picture of HARO Conference Center'></img><br />Office Staff Conference</th>";



$tempid2=substr($tempid,0,-2);
//if($concession_location=='ADM'){$concession_location2='ADMI';} else {$concession_location2=$concession_location;}
echo "<th>
<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br /><font color='green'>$team<br /> $tempid2 </font>
</th>";




	
	echo "</tr>";
	
	echo "</table>";
	
	//echo "parkcode=$parkcode<br />";
?>
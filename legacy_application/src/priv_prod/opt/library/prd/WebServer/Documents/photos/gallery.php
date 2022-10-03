<?php
include("galleryMenu.php");
//include("parkcodes.inc");
//if(empty($_SESSION)){session_start();} // moved to galleryMenu.php

if(@$_SESSION['loginS'] || @$_SESSION['admin']){$source="nrid";}
else{$source="pub";}

extract($_REQUEST);
//print_r($_SESSION);//EXIT;

if($parkX=="")
	{
	exit;
	}
	
$parkX=mysql_real_escape_string($parkX);

 // ***************** Check The ID **************
// First get the complete list of images
$display_number = "12";
if (!isset($num_pages))
	{
	$sql4 = "SELECT * FROM images where images.cat like '%scenic%' and park='$parkX' and mark=''
	ORDER BY park";
	$result4 = @mysql_query($sql4, $connection) or die("Error2 $sql4 #". mysql_errno() . ": " . mysql_error());
	$numrow = mysql_num_rows($result4);
		// Calculate the number of pages required.
	$t=$numrow;
		if ($numrow > $display_number) {
			$num_pages = ceil ($numrow/$display_number);
		} elseif ($numrow > 0) {
			$num_pages = 1;
		}
		
		$start = 0; // Currently at item 0.
	}

$sql4 = "SELECT * FROM images where images.cat like '%scenic%' and park='$parkX'
and mark='' 
ORDER BY park, dateM desc LIMIT $start, $display_number";
$result4 = @mysql_query($sql4, $connection) or die("Error2 $sql4 #". mysql_errno() . ": " . mysql_error());
	
echo "<hr><table border='1'><font color='green' size='-1'>Any photo shown below is also available in a higher resolution.</font><br>Click on thumbnail to see a 640 pixel size.";

 while ($row = mysql_fetch_array($result4))
	 {
	extract($row);
	$linkHiRez="<a href='http://www.dpr.ncparks.gov/photos/forPublic.php?pid=$pid' target='_blank'>";
	
	$newPID="ztn.".$pid;
	$tnLink=str_replace($pid,$newPID,$link);
	$link="http://www.dpr.ncparks.gov/photos/".$tnLink;
	
	if($lat>0)
		{
		$google="<form name=\"frm\" action='google_earth/ge_ID_1.php' METHOD='POST'><input type='hidden' name='passWhere' value=\"$pid\">
		Google Map <input type='radio' name='google_type' value=\"gm\" checked>
		 Earth <input type='radio' name='google_type' value=\"ge\"><br /><input type='submit' name='submit' value='Google It'>
		</form>";}else{$google="";}
	
	@$z=fmod($j,4);
	if($z==0){$t1="<tr>";}else{$t1="";}
	if($z==3){$t2="</tr>";}else{$t2="";}
	
	echo "$t1<td width='25%' align='center'>$linkHiRez<img src=$link></a><br />$parkCodeName[$park]";
	if($photoname){echo "<br /><i>$photoname</i>";}
	if($comment){echo "<br />$comment";}
	if($photog){echo "<br />$photog";}
	if($date){echo " ($date)";}
		if($width>640 OR $height>640)
			{
			echo "<br />Request #$pid <a href='mailto:database.support@ncparks.gov?subject=Request%20for%20high%20resolution%20photo%20from%20The%20ID&body=Please%20send%20me%20info%20on%20obtaining%20a%20hi-res%20version%20of%20photo%20ID=$pid'>hi-res</a> [$width x $height]$google</td>$t2";
			}
	@$j++;
	}// end while


  echo "</table>";

// ********** Page Links **************
if (@$num_pages > 1)
	{
	
		echo "<tr align='center'>
			<td align='center' colspan='2'>";
			
		// Determine what page the script is on.	
		if ($start == 0) {
			$current_page = 1;
		} else {
			$current_page = ($start/$display_number) + 1;
		}
	// Set the variables for other page Links
		$baseLink="<a href=\"gallery.php?";
		$numPageLink="&num_pages=".$num_pages;
		$tLink="&t=".$t;
		if($parkX){$parkLink="&parkX=".$parkX;}
		
		// If it's not the first page, make a Previous button.
		if ($start != 0) {
		$startLink="start=".($start - $display_number);
		$submitLink="&Submit=1\">Previous</a> ";
		
	$previousLink=$baseLink.$startLink.$numPageLink.$tLink.$parkLink.$submitLink;
	echo "$previousLink";
		}
	
		// Make all the numbered pages.
		for ($i = 1; $i <= $num_pages; $i++) {
		//	$next_start = $start + $display_number;
		$startLink="start=".($display_number * ($i - 1));
		$submitLink="&Submit=1\">$i</a> ";
		
		if($i<($current_page+10) and $i>($current_page-10)){
		
			if ($i != $current_page) { // Don't link the current page.
					
	$numLink=$baseLink.$startLink.$numPageLink.$tLink.$parkLink.$submitLink;
	
	//$current_page = ($start/$display_number) + 1;
	
	
	echo "$numLink";
	
			} else {
				echo $i . ' ';
			}
		}
	}	
		// If it's not the last page, make a Next button.
		if ($current_page != $num_pages) {
		$startLink="start=".($start + $display_number);
		$submitLink="&Submit=1\">Next</a> ";
				
	$nextLink=$baseLink.$startLink.$numPageLink.$tLink.$parkLink.$submitLink;
	echo "$nextLink";
		}
		
		echo '</td>
		</tr>';
	}


echo "</div></body></html>";

?>
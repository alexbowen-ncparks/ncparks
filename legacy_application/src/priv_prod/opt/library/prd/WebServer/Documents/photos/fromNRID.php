<?php
include("../../include/connectROOT.inc");//$connection
include("../../include/get_parkcodes.php");
//echo "<pre>";print_r($_SERVER);echo "</pre>";
//@$refer=explode("=",$_SERVER['HTTP_COOKIE']);//echo "ref=$refer[0]";
@$refer=$_SERVER['HTTP_COOKIE'];//echo "ref=$refer[0]";
extract($_REQUEST);

$withThis="http:";
@$pos=strpos($sciName,$withThis);
@$pos1=strpos($pid,$withThis);
@$pos2=strpos($location,$withThis);
if($pos>-1 OR $pos1>-1 OR ($pos2>-1 and is_int($pid)))
	{
//var_dump(is_int($pid)); exit;
	header("Location: http://www.fbi.gov");
	exit;
	}
@$pos=strpos($_SERVER['QUERY_STRING'],"../");
if($pos>-1)
	{
//	header("Location: http://www.fbi.gov");
	exit;
	}
	
@$pid=mysql_real_escape_string($pid);
@$sciName=mysql_real_escape_string($sciName);
@$location=mysql_real_escape_string($location);
if($pid.$sciName.$location==""){exit;}

if(@$sciName)
	{
//	include("../../include/parkcodes.inc");
	
	$where="sciName='$sciName'";
	
	mysql_select_db('nrid',$connection);
	$sql = "select dprspp.comName,dprspp.majorGroup as mg,dprspp.orderX,dprspp.family,dprspp.authSp,dprspp.authSsp,synonym
	from dprspp 
	where $where";
//	echo "1 $sql";   //exit;
	$result = mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	$num_sn=mysql_num_rows($result);
	if($num_sn<1){exit;}
	$row=MYSQL_FETCH_ARRAY($result);
	extract($row);
/*	
	//$sciName = urldecode($sciName);
	$getWords = explode(" ", $sciName);
	$first2Words = $getWords[0]." ".$getWords[1];
	$pidTest = $pid;
	$sql2 = "SELECT * FROM nrid.photos WHERE nrid.photos.sciName LIKE '$first2Words%' and photos.mark !='x'";
	
	$result2 = @mysql_query($sql2, $connectionNR) or die("Error 2# ".$sql2);
	$numrow2 = mysql_num_rows($result2);
	//echo "n=$numrow2";exit;
	
	// ****** Get any Fun Fact for majorGroup **********
	$sql2a = "SELECT funFact,sciName as ffmg FROM nrid.fact where sciName='$mg'";
	$result2a = @mysql_query($sql2a, $connectionNR) or die("Error #". mysql_errno() . ": " . mysql_error());
	$total_found2a = @mysql_num_rows($result2a);
	if($total_found2a > 0){
	while ($row2a = mysql_fetch_array($result2a)){
	extract($row2a);$funFactArrayMG[]=strtoupper($ffmg);}
	}
	//print_r($funFactArrayMG); echo "$mg";
	
	// ****** Get any Fun Fact for sciName **********
	$sql2c = "SELECT funFact,sciName FROM nrid.fact where sciName LIKE '$first2Words%'";
	$result2c = @mysql_query($sql2c, $connectionNR) or die("Error #". mysql_errno() . ": " . mysql_error());
	$total_found2c = @mysql_num_rows($result2c);
	if($total_found2c > 0){
	while ($row2c = mysql_fetch_array($result2c)){
	extract($row2c);
	$sciNameSearch=explode(" var ",$sciName);//echo "s=$sciNameSearch[0]";
	
	$funFactArraySN[]=$sciNameSearch[0];}
	}
	//print_r($funFactArraySN); echo "2 $sciName $sql2c";
	
	// ****** Get any Fun Fact for Genus **********
	$sql2d = "SELECT funFact,sciName FROM nrid.fact where sciName = '$getWords[0]'";
	$result2d = @mysql_query($sql2d, $connectionNR) or die("Error #". mysql_errno() . ": " . mysql_error());
	$total_found2d = @mysql_num_rows($result2d);
	if($total_found2d > 0){
	while ($row2d = mysql_fetch_array($result2d)){
	extract($row2d);
	$sciNameSearch=explode(" var ",$sciName);//echo "s=$sciNameSearch[0]";
	
	$funFactArrayGenus[]=$sciNameSearch[0];}
	}
	//print_r($funFactArrayGenus); echo "2 $getWords[0] $sql2d";
	
	// ****** Get any ID Note **********
	$genus=$getWords[0];
	$species=$getWords[1];
	$sql2c = "SELECT noteid,text,sciName as sciNameCheck FROM nrid.note where sciName LIKE '$genus%' and nrid.note.mark=''";
	//echo "$sql2c";
	$result2c = @mysql_query($sql2c, $connectionNR) or die("$sql2c Error #". mysql_errno() . ": " . mysql_error());
	$total_found2c = @mysql_num_rows($result2c);
	if($total_found2c > 0){
	while($row2c = mysql_fetch_array($result2c)){
	extract($row2c);
	$testText=strpos($text,$species);
	if($sciNameCheck==$genus." ".$species){$IDnote=1;$IDnoteArray[]=$noteid;}
	if($testText>-1 and $sciNameCheck!=$genus." ".$species){$IDnote=1;$IDnoteSimilarArray[]=$noteid;}
			}// end while
	}// end if > 0
*/
	}// if sciNmae

mysql_select_db('photos',$connection);

if($pid)
	{
	$sql = "select t1.* , t2.comName, t2.majorGroup as mg, t2.orderx as orderX, t2.family, t2.synonym, t2.authSp
	from photos.images as t1
	left join nrid.dprspp as t2 on t1.sciName=t2.sciName
	where t1.pid='$pid'";
//	echo "$sql";
//	echo "p=$pid";exit;
	$result1 = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	$num_pid=mysql_num_rows($result1);
	if($num_pid<1){exit;}
	$row1=MYSQL_FETCH_ARRAY($result1);
	extract($row1);
//echo "<pre>"; print_r($row1); echo "</pre>"; // exit;
		$linkOriginal=$link; //used to pass file location from database
		$otherLinks[]=$link;
	$CATgroup = strtoupper(str_replace(",", " ", $cat));
	}

Header( "Content-type: text/html; charset=utf-8");
    echo "
<HTML>
<HEAD>
    <meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\" />

<TITLE>ID (Image Database)</TITLE>

<script language='JavaScript'>
function confirmLink()
{bConfirm=confirm('Are you sure you want to delete this Photo?')
 return (bConfirm);}
</script></HEAD>
<BODY bgcolor='beige'><div align='center'";

if(!isset($CATgroup)){$CATgroup="";}
if(!isset($photoname)){$photoname="";}
echo "<hr>
<table border='1' cellpadding='3'><tr><td>Category: $CATgroup</td><td>Photo Title: $photoname</td>";
$park_name=@$parkCodeName[$park];

if(!isset($width)){$width="";$height="";}
if(!isset($filename)){$filename="";}
if(!isset($park)){$park="";}
echo "<td>$park: $park_name </td></tr>
<tr><td>File Name: $filename [pid $pid]</td><td>Original File Size: $width x $height pixels</td></tr>";

if(!isset($photog)){$photog="";}
echo "<tr><td>Photographer: $photog</td>";
if(!isset($date)){$date="";}
if($date != "0000-00-00"){echo "<td>Date photo taken: $date </td>";}

if(@$mg){echo "</tr><tr><td>Group: $mg </td><td>Order: $orderX</td><td>Family: $family</td></tr>";}
if($sciName)
	{
	if(@$authSp){$authSp1=" $authSp ";}
	$sciName1=$sciName;
	
	$pos1=strpos($sciName,' var. ');
	if($pos1>0){$sciNameArray=explode(" var. ",$sciName);
	$sciName1=$sciNameArray[0]; $sciNameVar=" <i>var. ".$sciNameArray[1]."</i>";
	}
	$pos2=strpos($sciName,' var ');
	if($pos2>0){$sciNameArray=explode(" var ",$sciName);
	$sciName1=$sciNameArray[0]; $sciNameVar=" <i>var. ".$sciNameArray[1]."</i>";
	}
	$pos3=strpos($sciName,' ssp ');
	if($pos3>0){$sciNameArray=explode(" ssp ",$sciName);
	$sciName1=$sciNameArray[0]; $sciNameVar=" <i>ssp. ".$sciNameArray[1]."</i>";
	}
	$pos4=strpos($sciName,' ssp. ');
	if($pos4>0){$sciNameArray=explode(" ssp. ",$sciName);
	$sciName1=$sciNameArray[0]; $sciNameVar=" <i>ssp. ".$sciNameArray[1]."</i>";
	}
	
	if(!isset($authSp1)){$authSp1="";}
	if(!isset($authSsp)){$authSsp="";}
	if(!isset($sciNameVar)){$sciNameVar="";}
	echo "<tr><td>SciName: <i>$sciName1</i>$authSp1 $sciNameVar $authSsp</td>";}

if(@$comName){echo "<td>ComName: $comName </td>";}
if(@$synonym){echo "<td>Synonym: <i>$synonym</i></td>";}


//if(@$level>0)
//if($refer[0]=="PHPSESSID")
if(strpos($refer,"PHPSESSID")>-1)
	{
	//$source="nrid";
	$linkFull="<a href='fromNRID.php?pid=$pid&location=$link&size=max&source=nrid'>$width x $height</a>";
	if($width > "1024" || $height > "1024"){
	$link1024="<a href='fromNRID.php?pid=$pid&location=$link&size=1024&source=nrid'>1024</a>";}
	if($width > "800" || $height > "800"){
	$link800="<a href='fromNRID.php?pid=$pid&location=$link&size=800&source=nrid'>800</a>";}
	if($width > "640" || $height > "640"){
	$link640="<a href='fromNRID.php?pid=$pid&location=$link&size=640&source=nrid'>640</a>";}
	
	if(!isset($name)){$name="";}
	if(!isset($NScomment)){$NScomment="";}
	$editLink="<form action='edit.php' method='POST'><td>
	<input type='hidden' name='category' value='$cat'>
	<input type='hidden' name='park' value='$park'>
	<input type='hidden' name='pid' value='$pid'>
	<input type='hidden' name='photog' value='$photog'
	<input type='hidden' name='cd' value='$cd'>
	<input type='hidden' name='date' value='$date'>
	<input type='hidden' name='name' value='$name'>
	<input type='hidden' name='photoname' value='$photoname'>
	<input type='hidden' name='comment' value='$NScomment'>
	<input type='submit' name='submit' value='Edit the Photo Info'></form></td><td><font size='-1'><a href='deletePh.php?pid=$pid' onClick='return confirmLink()'>Delete this Photo</a></font></td>";
	}
else
	{
	if(!isset($photog)){$photog="";}
	if($photog=="Donald L. Barnett")
		{
		$linkFull="Click for full resolution of: <a href='$linkOriginal'>$width x $height</a>";
		}
		else
		{
		if(!isset($width)){$width="";}
		if(!isset($height)){$height="";}
		if(!isset($park)){$park="";}
		echo "Also available in sizes up to <b>$width x $height</b><br>Contact the site <a href='mailto:tom.howard@ncdenr.gov?subject=Request%20for%20NRID%20photo&body=Hi-rez Photo%20of%20$sciName%20from%20$park%20with%20ID=$pid'>admin</a> for info on obtaining a higher resolution of photo <font color='red'>#$pid</font>.";
		}
	}

echo "</tr></table>";
if(@$comment)
	{
	echo "<table><tr><td>Comment: $comment</td></tr></table>";
	
	}

if(!isset($linkFull)){$linkFull="";}
if(!isset($link1024)){$link1024="";}	
if(!isset($link800)){$link800="";}	
if(!isset($link640)){$link640="";}	
if(!isset($editLink)){$editLink="";}	
echo "<table><tr><td align='center'>$linkFull</td><td>$link1024</td><td>$link800</td><td>$link640</td>$editLink</tr>";


if(!isset($funFactArrayMG)){$funFactArrayMG="";}
if(!isset($funFactArraySN)){$funFactArraySN="";}
if(!isset($IDnote)){$IDnote="";}
if(!isset($funFactArrayGenus)){$funFactArrayGenus="";}

if($funFactArrayMG||$funFactArraySN||$IDnote||$funFactArrayGenus)
	{
	echo "<tr>";
	if($funFactArrayMG){echo "<td align='center' colspan='3'>";
	$nKey=array_search($mg,$funFactArrayMG);
	if($nKey>-1){$searchTerm=$mg;}
	echo "[<a href=\"#\" onClick=\"window.open('/nrid/getFactPub.php?sciName=$searchTerm','FunFact','height=600,width=500,scrollbars=1,resizable=1');\"><font size='+1'>$mg</font>-Fun Fact</a>]";}
	
	if($funFactArraySN){
	//print_r($funFactArraySN);
	$pos=strpos($sciName,' var. ');
	if($pos===false){$v=" var ";}else{$v=" var. ";}
	$sciNameSearch=explode($v,$sciName);//echo "s=$sciNameSearch[0]";
	$nKey=array_search($sciNameSearch[0],$funFactArraySN);
	if($nKey>-1){$searchTerm=$sciNameSearch[0];} else{$searchTerm=$first2Words;}
	
	echo "[<a href=\"#\" onClick=\"window.open('/nrid/getFactPub.php?sciName=$searchTerm','FunFact','height=600,width=500,scrollbars=1,resizable=1');\"><font size='+1'><i>$sciName</i></font>-Fun Fact</a>] ";
	echo "</td>";
	}// end funfact
	
	if($funFactArrayGenus){
	//print_r($funFactArrayGenus);
	$sciNameSearch=explode(" ",$sciName);//echo "s=$sciNameSearch[0]";
	$nKey=array_search($sciNameSearch[0],$funFactArrayGenus);
	if($nKey>-1){$searchTerm=$sciNameSearch[0];}
	echo "[<a href=\"#\" onClick=\"window.open('/nrid/getFactPub.php?genus=$searchTerm','FunFact','height=600,width=500,scrollbars=1,resizable=1');\"><font size='+1'>$sciNameSearch[0] -Fun Fact</a>]  ";
	echo "</td>";
	}// end funfact
	
	
	if($IDnote)
		{
		if($IDnoteArray)
			{
			echo "<td align='center' colspan='3'>ID Note for Species";$endTD1="</td>";}
		for($nn=0;$nn<count($IDnoteArray);$nn++)
			{
			echo "&nbsp;&nbsp;&nbsp;[<a href=\"#\" onClick=\"window.open('/nrid/getNoteID.php?noteid=$IDnoteArray[$nn]','FunFact','height=600,width=500,scrollbars=1,resizable=1');\"><font size='+1'>v-$nn</font></a>]";
			}
		echo "$endTD1";
		
		if($IDnoteSimilarArray){echo "<td align='center' colspan='3'>ID Note Similar Species";$endTD2="</td>";}
		for($nn=0;$nn<count($IDnoteSimilarArray);$nn++){
		echo "&nbsp;&nbsp;&nbsp;[<a href=\"#\" onClick=\"window.open('/nrid/getNoteID.php?noteid=$IDnoteSimilarArray[$nn]','FunFact','height=400,width=400,scrollbars=1,resizable=1');\"><font size='+1'>v-$nn</font></a>]";}
		echo "$endTD2";
		}// end IDnote
	
	echo "</tr>";
	}// end if funfact or IDnote
echo "</table>";

// Works with either photo stored in db or as a file
@$cn=urlencode($comName);
if(@!$location)
	{
	include("getPhoto.php");
	}
	else
	{
	if(!empty($linkOriginal)){$location=$linkOriginal;}
	$loc=explode("/",$location); 
	if(!isset($size)){$size="640";}
	
	switch ($size)
		{
				case "max":
		echo "<img src='$location'>";
					break;
				case "1024":
				// code to resize to 800  resize.php
		$wid=1024; $hei=1024;
		$tn=$loc[0]."/".$loc[1]."/".$loc[2]."/1024.".$pid.".jpg";
		if (file_exists($tn)) {
			echo "<img src='$tn'>";
		} else {
		include("resize.php");
		createthumb($location,$tn,$wid,$hei);
		echo "<img src='$tn'>";
		}
					break;
				case "800":
				// code to resize to 800  resize.php
		$wid=800; $hei=800;
		$tn=$loc[0]."/".$loc[1]."/".$loc[2]."/800.".$pid.".jpg";
		if (file_exists($tn)) {
			echo "<img src='$tn'>";
		} else {
		include("resize.php");
		createthumb($location,$tn,$wid,$hei);
		echo "<img src='$tn'>";
		}
					break;
				case "640":
				// code to resize to 640  resize.php
		$wid=640; $hei=640;
		$tn=$loc[0]."/".$loc[1]."/".$loc[2]."/640.".$pid.".jpg";
		if(file_exists($tn))
			{
			@$pn=$parkCodeName[$park];
			echo "<img src='$tn' alt=\"$cn (<I>$sciName</I>), $pn, North Carolina, United States\">";
			}
		else {
			include("resize.php");
			createthumb($location,$tn,$wid,$hei);
			echo "<img src='$tn'>";
			}
					break;
				default:
				$tn=$loc[0]."/".$loc[1]."/".$loc[2]."/640.".$pid.".jpg";
					echo "<img src='$tn'>";
		}
	}	

if(@$source=="pub"){echo "<br>Close window when done.";//exit;
//<br><br><a href='http://www.dpr.ncparks.gov/nrid/gallery.php'>Search</a> Photo Gallery
}


if($sciName)
	{
	$split_sn=explode(" ",$sciName);
	$find_sciName="t2.sciName='".$sciName."'";
	if(count($split_sn)>2){$find_sciName="t2.sciName like '$split_sn[0] $split_sn[1]%'";}
	$sql = "select t1.* 
	from nrid.natinv as t2
	LEFT JOIN photos.images as t1 on t2.sciName=t1.sciName and t2.park=t1.park
	where $find_sciName and t2.mark='' and t2.hidden='' and t1.mark='' and t1.park is not NULL
	order by park";
	$result1 = @mysql_query($sql, $connection) or die("$sql Error 370#". mysql_errno() . ": " . mysql_error());
	$num=mysql_num_rows($result1);
//	echo "$sql";
	$j=0;
	$k=4;
	$show_num=20;
	
	if($num>1)
		{
		$num_pages=ceil($num/$show_num);
		$pass_pid=$pid;
		if(isset($page))
			{
			$start=($page*$show_num)-$show_num;
			$x=$start;
			$end=$start+($show_num-1);
			if($end>$num)
				{
				$show=$num-($end-$show_num)-1;
				$other="";
				}
				else
				{
				$show=$show_num;
				$other="Click link at bottom of page for additional photos.";
				}
			}
			else
			{
			$x=0;
			$page=1;
			$start=(1*$show_num)-$show_num;
			$end=$start+($show_num-1);		
			if($end>$num)
				{
				$show=$num-($end-$show_num)-1;
				$other="";
				}
				else
				{
				$show=$show_num;
				$other="Click link at bottom of page for additional photos.";
				}
			}
		
		if(!isset($comName)){$comName="";}
		echo "<hr><table><tr><th colspan='$k'>Page $page - showing $show of $num photos for $comName - <i>$sciName</i>. $other</td></tr>";		
		while ($row1=MYSQL_FETCH_ARRAY($result1))
			{
			$ARRAY[]=$row1;
			}
		
		foreach($ARRAY AS $index=>$array)
		{
		if($index>=$start AND $index<=$end)
				{
			//	let script run to show these photos
				}
			else
				{
			//	Pass over these photos
				continue;
				}

			extract($array);
			$x++;
			$base="/photos/";
			if(@$source=="nrid" OR $refer[0]=="/nrid/recentAddPH.php")
				{	$newLink="/photos/fromNRID.php?sciName=$sciName&pid=$pid&source=nrid";
				}
			else
				{
				$newLink="/photos/fromNRID.php?sciName=$sciName&pid=$pid&source=pub&page=$page";
				}
			$iLink=explode("/",$link);
			$tempA=array($iLink[0],$iLink[1],$iLink[2]);
			$jLink=implode("/",$tempA);
			$tnLink=$base.$jLink."/ztn.".$iLink[3];
			
			$z=fmod($j,$k);
			if($z==0){$t1="<tr>";}else{$t1="";}
			if($z==3){$t2="</tr>";}else{$t2="";}
			
			echo "$t1<td width='25%' align='center'><a href='$newLink'><img src='$tnLink'><br>Photo $x</a> $park<BR />$comment</td>$t2";
			$j++;
			}
		echo "<tr><td colspan='4' align='center'><font size='+1'>";
		if(@$other!="")
			{
			for($i=1;$i<=$num_pages;$i++)
				{
				echo "<a href='fromNRID.php?pid=$pass_pid&page=$i'>[ $i ]</a> ";
				}
			echo "</font></td></tr>";
			}
		echo "</table>";
		}
	}
	
echo "</div></body></html>";
?>
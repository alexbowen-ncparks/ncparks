<?php
ini_set('display_errors',1);
$database="div_cor";
include("../../include/auth.inc");// database connection parameters
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database);


date_default_timezone_set('America/New_York');

include("menu.php");

$entered_by=$_SESSION['div_cor']['tempID'];
extract($_REQUEST);

if($level<1){exit;}

//  access_list.php controls who has access to what

// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
// echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

require_once("functions.php");

// ********** This displays all entries in DESC order **********
echo "<table border='1' cellpadding='5' align='center'>";

$where="WHERE 1";
if(!isset($x)){$x="";}
if($x=="all" OR $x=="vacant" OR $x=="hire")
	{
	$range="<font color='green'>Complete</font> or <font color='red'>Pending</font>";
	}
	else
	{
	$range="<font color='red'>Pending</font>";
	$where.=" and route_status='pending'";
	}

$allow="no";
@$section=$passSection;
if(!empty($menuItem))
	{$section=$menuItem;}
if(@$_SESSION['div_cor']['station_temp'])
	{
	$section=$_SESSION['div_cor']['station_temp'];
	if(empty($_REQUEST))
		{
		if($_SESSION['div_cor']['tempID']=="Pearson2659")
			{
			$section=$_SESSION['div_cor']['station'];
			}
		}
	}

if(!empty($section))
	{
	$allow="yes";
	$where.=" and section='$section'";
		if($section=="Operations"){
			if(@$x=="vacant"){$where.=" and hr_status='vacancy'";}
			if(@$y=="hire"){$where.=" and hr_status='hiring'";}
			}
	}


if(!$section)
	{
	$allow="yes";
	if(@$_SESSION['div_cor']['station_temp'])
		{
		$section=$_SESSION['div_cor']['station_temp'];
		}
		else
		{
		$section=$_SESSION['div_cor']['station'];
		}

	$where.=" and section='$section'";
	}

if(!$section){exit;}

if($level>4)
	{
	$allow="yes";
	if($x=="all"){$where="WHERE 1 and section='$section'";}else{$where="WHERE 1 and route_status='pending' and section='$section'";}
	}

if(@$nn)
	{
	if($nn>0){$start=($nn-1)*50;}else{$start=1;}
	$end=50; $displayEnd=$start+50;
	if($displayEnd>$passNum){$displayEnd=$passNum;}
	$limit="LIMIT $start, $end ";}
else{$start=1; $end=50;
}

if($section=="ACCO" and $level==1){$where.=" and entered_by='$entered_by'";}

if(!isset($limit)){$limit="";}
$sql1 = "SELECT corre.*
from corre
$where
order by route_status desc, in_date desc, date_create desc
$limit";

// echo "$sql1";

if($allow=="yes"){
$result = mysqli_query($connection,$sql1) or die ("Couldn't execute query SQL1. $sql1");}

$num=mysqli_num_rows($result);
if(@$passNum){$num=$passNum;}
if(!$limit){
	$displayEnd=($num>50? "50" : $num);
	}
	if($start>1){$start+=1;}

if($num==0){$start=0;}
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Displaying $start to $displayEnd of $num $range items for $section";

$i=0;
while ($row=mysqli_fetch_array($result))
	{
	$i++;
	if($i<51){itemShow($row,$num);}
	}

echo "<tr><td align='center' colspan='4'>";
$numLink=ceil($num/50);
for($j=1;$j<=$numLink;$j++)
	{
	if(@$nn==$j){$links.="<b>$j</b>&nbsp;&nbsp;&nbsp;";}
	else
		{
		@$links.="<a href='display_item.php?x=$x&passNum=$num&nn=$j'>$j</a>&nbsp;&nbsp;&nbsp;";
		if($j==1)
			{
			if(@!$nn)
				{
				$links="<b>$j</b>&nbsp;&nbsp;&nbsp;";
				}
				else
				{
				$links="<a href='display_item.php?x=$x'>$j</a>&nbsp;&nbsp;&nbsp;";}
			}
		}
	}
	
if(isset($links)){echo "$links";}

echo "</td></tr>";


echo "</table></body></html>";

?>
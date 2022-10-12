<?php
//ini_set('display_errors',1);
$database="pr_news";
$table="news";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database);
//session_start();
//print_r($_SESSION);exit;
//print_r($_REQUEST);//exit;

//if($level<1){exit;}
include("../no_inject.php");
foreach($_REQUEST AS $key=>$val)
		{
		if(strpos($val, "..")>-1){exit;}
		}
extract($_REQUEST);
		if(strpos($val, "..")){exit;}
if(!isset($passDate)){include("menu.php");}
if(isset($nn))
	{
	if($nn>1){$start=($nn-1)*50+1;}else{$start=1;}
	$end=$start+49;
	$limit="LIMIT $start, $end ";}
else{$start=1; $end=50;}


// ********** This displays all entries in DESC order **********
echo "<table border='1' cellpadding='5' width='1024' align='center'>";

require_once("functions.php");

$where="WHERE 1";

if(!isset($limit)){$limit="";}
if(@$passDate){$where.=" and in_date='$passDate'";}
$sql1 = "SELECT $table.*
from $table
$where
order by in_date desc,date_create desc
$limit
";

//echo "$sql1 l=$nn";

if(!isset($nn)){$nn="";}
$result = mysqli_query($connection,$sql1) or die ("Couldn't execute query SQL1. $sql1");
$num=mysqli_num_rows($result);
if(@$passNum){$num=$passNum;}
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Displaying $start to $end of $num items";
$i=0;
while ($row=mysqli_fetch_array($result))
	{
	$i++;
	if($i<51){itemShow($row);}
	}

echo "<tr><td align='center' colspan='4'>";
$numLink=ceil($num/50);
for($j=1;$j<=$numLink;$j++)
	{
	if($j>=($nn-10) AND $j<=($nn+10))
		{
		@$links.="<a href='display_item.php?passNum=$num&nn=$j'>$j</a>&nbsp;&nbsp;&nbsp;";
		if($j==1){$links="<a href='display_item.php'>$j</a>&nbsp;&nbsp;&nbsp;";}
		}
	}
echo "$links</td></tr>";
echo "</table></body></html>";

?>
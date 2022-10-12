<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

if($posTitle=='park superintendent'){$pasu_role='y';} else {$pasu_role='n';}
if($posTitle=='parks district superintendent'){$disu_role='y';} else {$disu_role='n';}
echo "<table>
<tr><td>tempID</td><td>pasu_role</td><td>disu_role</td></tr>
<tr><td>$tempID</td><td>$pasu_role</td><td>$disu_role</td></tr>
</table>";
extract($_REQUEST);
if($level==1){$parkcode=$concession_location;}
//echo "$report_date<br />";exit;


//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");

if($pasu_comment != '')
{
$pasu_comment=addslashes($pasu_comment);
$comment_update_query="update cash_summary set pasu_comment='$pasu_comment',pasu_player='$tempID' where id='$comment_id' ";

$result_comment_update_query=mysql_query($comment_update_query) or die ("Couldn't execute query comment_update. $comment_update_query");


//echo "comment_update_query=$comment_update_query<br />";
}

//echo "f_year=$f_year";
//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}
/*
if($level=='5' and $tempID !='Dodd3454')
{

echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}
*/
//$table="rbh_multiyear_concession_fees3";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";
//echo "query10=$query10<br />";
$result10=mysql_query($query10) or die ("Couldn't execute query 10. $query10");

$row10=mysql_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

//echo "body_bg:$body_bg";
//echo "<br />";
//echo "table_bg:$table_bg";
//echo "<br />";
//echo "table_bg2:$table_bg2";

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysql_query($query11) or die ("Couldn't execute query 11. $query11");

$row11=mysql_fetch_array($result11);

extract($row11);
//echo "<br />";
//echo $filegroup;

/*
echo "<html>";
echo "<head>
<title>Concessions</title>";
*/
//include ("test_style.php");
//include ("test_style.php");

//echo "</head>";

//include("../../../budget/menus2.php");
//include("menu1314_cash_receipts.php");
include ("test_style.php");

include("../../../budget/menu1314.php");
//if($center==''){$center=$concession_center;}
//if($park==''){$park=$concession_location;}
//include ("park_deposits_report_menu_v2.php");
//include("/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php");
//include ("park_posted_deposits_widget1.php");

//include("../../../budget/park_deposits_report_menu_v3.php");

//include ("park_deposits_report_menu_v3.php");

echo "<br />";





//include ("park_posted_deposits_fyear_header2_v2.php");
//include("park_posted_transactions_report_menu.php");
//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";


if($park!=''){$parkcode=$park;}


if($parkcode=='')
{
$query5="select center,park,effect_date,beg_bal,deposit_amount,transaction_amount,end_bal,days_elapsed2,compliance,id,pasu_comment
from cash_summary
where valid='y'
and weekend='n'
group by park,effect_date desc
";
}
else
{


$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query1d=$query1d<br />";//exit;		  

$result2 = mysql_query($query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysql_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);


$query4="select park,count(id) as 'complianceYes' 
from cash_summary
where valid='y'
and weekend='n'
and compliance='y'
and park='$parkcode'
group by park
";

$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");

$row4=mysql_fetch_array($result4);
extract($row4);
if($complianceYes==''){$complianceYes='0';}

$query4a="select park,count(id) as 'complianceNo' 
from cash_summary
where valid='y'
and weekend='n'
and compliance='n'
and park='$parkcode'
group by park
";

$result4a = mysql_query($query4a) or die ("Couldn't execute query 4a.  $query4a");

$row4a=mysql_fetch_array($result4a);
extract($row4a);

if($complianceNo==''){$complianceNo='0';}

$total_scorable_recs=$complianceYes+$complianceNo;

$score=($complianceYes/$total_scorable_recs)*100;
$score=number_format($score,0);

$query5="select center,park,effect_date,beg_bal,deposit_amount,transaction_amount,end_bal,days_elapsed2,compliance,id,pasu_comment
from cash_summary
where valid='y'
and weekend='n'
and park='$parkcode'
group by park,effect_date desc
";
}

$result5 = mysql_query($query5) or die ("Couldn't execute query 5.  $query5");


while($row=mysql_fetch_assoc($result5))
	{
	$ARRAY[]=$row;
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

$c=count($ARRAY);

$skip=array("beg_bal", "id");
$skip=array();
echo "<table><tr><td>$c</td></tr>";
foreach($ARRAY AS $index=>$row)
	{
	if(fmod($index,10)==0)
		{
		echo "<tr bgcolor>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld, $skip))
				{continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($row as $fld=>$value)
		{
			if(in_array($fld, $skip))
				{continue;}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
?>


 


























	















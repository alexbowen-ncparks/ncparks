<?php
include("pm_menu.php");

extract($_REQUEST);
//echo "<pre>"; print_r($_SESSION); echo "</pre>";// exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";// exit;
//These are placed outside of the webserver directory for security
if($_SESSION['inspect']['level']=="")
	{
	echo "You do not have authorization for this database."; 
	exit;
	} // used to authenticate users
$database="inspect";
include("../../include/iConnect.inc"); // database connection parameters
mysqli_select_db($connection,$database);

$level=$_SESSION[$database]['level'];

// *********** Display ***********

echo "<table align='center'><tr><td align='center'><h2><font color='red'>Safety Activities</font> for $parkcode</h2></td></tr>
<tr><td>View all <a href='park.php?parkcode=$parkcode'>$parkcode</a> entries.</td><td width='300'><marquee behavior='slide' direction='left'>
Add an inspection/meeting by clicking its link.</marquee>
</marquee></td></tr></table>";

echo "<table border='1' align='center'><tr valign='top'>";

$sql="SELECT routine_inspect FROM routine order by routine_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$routine[]=$row['routine_inspect'];
	}

echo "<td>Daily Inspection: ";
foreach($routine as $k=>$v)
	{
	echo "<table><tr><td align='right'></td><td><a href='park_entry.php?parkcode=$parkcode&subunit=$v'>$v</a></td></tr></table>";
	}
echo "</td>";

$sql="SELECT week_inspect FROM weekly order by week_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$week[]=$row['week_inspect'];
	}

echo "<td>Weekly: ";
foreach($week as $k=>$v)
	{
	echo "<table><tr><td align='right'></td><td><a href='park_entry.php?parkcode=$parkcode&subunit=$v'>$v</a></td></tr></table>";
	}
echo "</td>";

$sql="SELECT month_inspect FROM monthly order by month_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	if($row['month_inspect']==" Safety Inspection Form"){continue;}
	$month[]=$row['month_inspect'];
	}

echo "<td>Monthly: ";
foreach($month as $k=>$v)
	{
	echo "<table><tr><td align='right'></td><td><a href='park_entry.php?parkcode=$parkcode&subunit=$v'>$v</a></td></tr></table>";
	}
echo "</td>";

$sql="SELECT quarter_inspect FROM quarterly order by quarter_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$quarter[]=$row['quarter_inspect'];
	}

echo "<td>Quarterly: ";
foreach($quarter as $k=>$v)
	{
	echo "<table><tr><td align='right'></td><td><a href='park_entry.php?parkcode=$parkcode&subunit=$v'>$v</a></td></tr></table>";
	}
echo "</td>";

$sql="SELECT year_inspect FROM yearly order by year_inspect";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result))
	{
	$year[]=$row['year_inspect'];
	}

echo "<td>Yearly: ";
foreach($year as $k=>$v)
	{
	echo "<table><tr><td align='right'></td><td><a href='park_entry.php?parkcode=$parkcode&subunit=$v'>$v</a></td></tr></table>";
	}
echo "</td></tr></table>";


// ******** Enter your SELECT statement here **********

//if(!$subunit){exit;}

$clause="Where 1";

if($parkcode){$clause.=" and parkcode='$parkcode'";}
if(@$subunit!="blank"){@$clause.=" and id_inspect='$subunit'";}

if($level==1)
	{
	$parkcode=$_SESSION[$database]['select'];
	@$where.=" and t1.parkcode='$parkcode'";
	}

$orderBy="order by t2.modified desc, t1.parkcode";


$sql="SELECT *  From `document` 
$clause
order by date_inspect DESC"; 
//echo "$sql";
 $result = @mysqli_query($connection,$sql);
while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
$num=mysqli_num_rows($result);

if($num<1)
	{
		if(@$subunit=="blank")
			{
			echo "No $parkcode Safety Activities where found. Click one of the links under Routine, Weekly, Monthly, or Yearly.<br /><br />";
			}
			else
			{
			@$su=$subunit;
			echo "No $parkcode Safety Activities for <font color='purple'>$su</font> where found.<br /><br />";
			}
	if(@$subunit!="blank"){echo "Add one.";}

	include_once("add_park_form.php");exit;
	}
	else
	{
	include_once("add_park_form.php");
	}

$numFields=count($ARRAY[0])+1;
$fieldNames=array_values(array_keys($ARRAY[0]));

//$u = ($num==1 ? 'Area' : 'Areas');

echo "<table align='center' border='1'><tr>";
foreach($fieldNames as $k=>$v){$v=str_replace("_"," ",$v);
//if($v=="date inspect"){$v="<a href=park_entry.php>$v</a>";}
//if($v=="parkcode"){$v="<a href=park_entry.php?ob=parkcode>$v</a>";}
if($v=="id inspect"){$v="Safety action documented";}
echo "<th>$v</th>";}
echo "</tr>";

foreach($ARRAY as $k=>$v)
	{// each row
	echo "<tr>";
		foreach($v as $k1=>$v1)
			{// each field, e.g., $tempID=$v[tempID];
			
			if($k1=="id")
				{
				if(!isset($passYear)){$passYear="";}
				$v1="<a href='delete_record.php?parkcode=$v[parkcode]&id=$v1&passYear=$passYear' onClick='return confirmLink()'>delete</a>";
				}
			
			if($k1=="comments")
				{
				$passYear=substr($v['date_inspect'],0,4);
				if(!empty($v_pr63) and $v['date_inspect']==$date_occur)
					{$var_pr="&v_pr63=$v_pr63&date_occur=$date_occur&pr_id=$pr_id";}else{$var_pr="";}
				$v1="<a href='add_park_comments.php?parkcode=$parkcode&passYear=$passYear&id=$v[id]$var_pr'>edit</a> $v1";
				}
			
			if($k1=="date_inspect")
				{
				if($v1=="0000-00-00"){$v1="";}
				}
			
			if($k1=="file_link")
				{
				if(!empty($v['pr63']) AND empty($v['file_link']))
					{
					$pr63=$v['pr63'];
					$v1.="<a href='https://10.35.152.9/le/find_pr63_reg.php?ci_num=$pr63&submit=Go' target='_blank'>PR-63 #$pr63</a>";
					$v1.="<a href='https://10.35.152.9/le/find_pr63_reg.php?ci_num=$pr63&submit=Go' target='_blank'>PR-63 #$pr63</a>";
					echo "<td align='CENTER'>$v1</td>";
					continue;
					}
				$fl_array=explode(",",$v1);
				$v1="";
				foreach($fl_array as $k2=>$v2)
					{
					$v1.="<a href='$v2'>$v2</a><br />";
					}
				}
			
			echo "<td align='CENTER'>$v1</td>";
			}
		
	echo "</tr>";
	}

echo "</table></body></html>";

?>
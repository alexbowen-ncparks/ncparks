<script>function toggleDisplay(objectID) {
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
}
</script>
<?php
session_start();
// echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
// echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
include("../../include/iConnect.inc"); 
include("../../include/get_parkcodes_dist.php");  // also sets parkCounty

$state_wide=array("USBG","PAR3","OPAD","NCBG","NARA","ADMI");
foreach($state_wide as $k=>$v)
	{
	array_unshift($parkCode, $v);
	}
// echo "<pre>"; print_r($parkCode); echo "</pre>"; // exit;
include("css/TDnull.inc");

$database="hr";
if(empty($_SESSION[$database]['level'])){exit;}
$level=$_SESSION[$database]['level'];
if(empty($park)){$park=$_SESSION['parkS'];}
if(!empty($_SESSION[$database]['accessPark']))
	{
	$accessPark=explode(",",$_SESSION[$database]['accessPark']);
	}
if(empty($message)){$message="";}


include("menu_mandatory.php");
	
mysqli_select_db($connection,$database); // database

if(!empty($_POST['submit_form']))
	{
// echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
	foreach($_POST['mandatory'] as $beacon_num=>$value)
		{
		$mc=$_POST['mandatory_comments'][$beacon_num];
		$sql = "REPLACE mandatory 
		SET mandatory='$value', mandatory_comments='$mc', beacon_number='$beacon_num'";
// 		echo "$sql<br />"; //exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query.".mysqli_error($connection));
		}
	ECHO "Update completed.";
	}


$where="1 and t1.div_app='y' ";
if(empty($accessPark))
	{
	$where.=" and t1.center_code='$park'";
	}
	else
	{
	$where.=" and (";
	foreach($accessPark as $k=>$v)
		{
		$t[]="t1.center_code='$v'";
		}
	$where.=implode(" or ", $t).")";
	}

if($level>1)
	{
	$where=1;
	if(!empty($park_code)){$where="t1.center_code='$park_code'";}
	if(!empty($district_code))
		{
		$where="t4.district='$district_code'";
		if($district_code=="STWD")
			{
			foreach($state_wide as $k=>$v)
				{
				$t[]="t1.center_code='$v'";
				}
			$where="(".implode(" or ", $t).") ";
			}
		}
	}

$ARRAY=array();
$sql = "SELECT t4.district as district_code, t3.mandatory, t1.center_code ,t2.position_desc as HR_position_title  ,t1.osbm_title ,t1.beacon_posnum, t1.budget_hrs_a ,t1.budget_weeks_a ,t1.month_11 ,t1.aca ,t1.avg_rate_new ,t1.six_month, t1.park_comments, t3.mandatory_comments
FROM seasonal_payroll_next as t1 
left join divper.B0149 as t2 on t1.beacon_posnum=t2.position 
left join hr.mandatory as t3 on t3.beacon_number=t1.beacon_posnum 
left join dpr_system.parkcode_names_district as t4 on t4.park_code=t1.center_code
WHERE $where and t1.div_app='y'
ORDER BY t1.center_code, t3.mandatory desc, t1.osbm_title
";  
// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$skip=array();
$c=count($ARRAY);
echo "<table border='1'><tr>
<td>$c</td>
<td><form method='post' action='form_mandatory_seasonal.php'>
Park <select name='park_code' onchange=\"this.form.submit()\"><option value=\"\" selected></option>\n";
foreach($parkCode as $k=>$v)
	{
	if($level<2 and $_SESSION['position']!="Park Superintendent")
		{
		continue;
		}
	if($level<2 and $_SESSION['parkS']!=$v)
			{
			continue;
			}
	echo "<option value='$v'>$v</option>\n";
	}
echo "</select></form></td>";

if($level>1)
	{
	echo "<td><form method='post' action='form_mandatory_seasonal.php'>
District <select name='district_code' onchange=\"this.form.submit()\"><option value=\"\" selected></option>\n";
$dist_array=array_unique($district);
foreach($dist_array as $k=>$v)
	{
// 	if($v=="STWD"){continue;}
	echo "<option value='$v'>$v</option>\n";
	}
	echo "</select></form></td>";
	}
	if($level>1)
		{
		echo "<td><a href='form_mandatory_report_seasonal.php'>Summary Report</a></td>";
		}
echo "</tr>";

if(empty($_POST))
	{
	echo "</table>"; exit;
	}
	
// 	if(!empty($_SESSION['hr']['supervise']))
if($level<2)
	{
	$update="n";
// 	echo "<pre>"; print_r($_SESSION); print_r($accessPark); echo "</pre>"; // exit;
// 	if()
// 		{}
	}
	else
	{
	$update="y";
	}

// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
echo "<form method='post' action='form_mandatory_seasonal.php'><table border='1'>";

foreach($ARRAY AS $index=>$array)
	{
			
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$var_fld=str_replace('_', ' ', $fld);
			echo "<th>$var_fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="mandatory")
			{
			$beacon_num=$array['beacon_posnum'];
			$cky=''; $ckn='';
			if($value=="Yes")
				{
				$cky="checked";
				$fc="green";
				}
				else
				{
				$ckn="checked";
				$fc="red";
				}
			$value="<input type='radio' name='mandatory[$beacon_num]' value=\"Yes\" $cky><font color='$fc'>Yes</font><br />
			<input type='radio' name='mandatory[$beacon_num]' value=\"No\" $ckn><font color='$fc'>No</font>";
			}
			
			if($fld=="park_comments")
				{
				$x=substr($value, 0,100);
				if(empty($value)){$val="blank";}else{$val="";}
				$value="<div id=\"topicTitle\" ><a onclick=\"toggleDisplay('div1[$index]');\" href=\"javascript:void('')\"> hide/show</a><br />$val</div>
		<div id=\"div1[$index]\" style=\"display: none\"> $value</div>";
				}
				
			if($fld=="mandatory_comments")
				{
				$var_fld=$fld."[".$array['beacon_posnum']."]";
				$value="<textarea name='$var_fld' cols='30' rows='6'>$value</textarea>";
				}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
	
if($update=="y")
	{
	echo "<tr>
	<td colspan='14' align='center'>";
	if(!empty($_POST['park_code']))
		{
		echo "<input type='hidden' name='park_code' value=\"$_POST[park_code]\">";
		}
	echo "<input type='hidden' name='submit_form' value=\"Update\">
	<input type='submit' name='submit_form' value=\"Update\">
	</td>
	</tr>";
	}
echo "</table>"; 
?>
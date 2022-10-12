<?php
ini_set('display_errors',1);
extract($_REQUEST);
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;
	// check for malicious redirect
		$findThis="http:";
		$testThis=strtolower($_SERVER['REQUEST_URI']);
	$pos=stripos($testThis,$findThis);
		if($pos>-1){
		header("Location: http://www.fbi.gov");
		exit;}

		$findThis="havij"; // SQL injection 
		$testThis=strtolower($_SERVER['HTTP_USER_AGENT']);
	$pos=stripos($testThis,$findThis);
		if($pos>-1){
		header("Location: http://www.fbi.gov");
		exit;}
		
		$findThis="select"; // SQL injection 
		$testThis=strtolower($_SERVER['QUERY_STRING']);
	$pos=stripos($testThis,$findThis);
		if($pos>-1){
		header("Location: http://www.fbi.gov");
		exit;}

if(empty($_POST['rep']))
	{
	$database="work_comp";
	$title="Worker's Comp";
	include_once("../_base_top.php");// includes session_start();
	}
//echo "<pre>"; print_r($_SERVER); print_r($_REQUEST);print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;

if(empty($_SESSION)){session_start();}
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
$level=@$_SESSION['work_comp']['level'];

if($level<1)
	{echo "You do not have access to view the submitted WC Forms. Contact your Regional Office if you need assistance."; exit;}
	

$user=strtolower(@$_SESSION['work_comp']['tempID']);
//$level=4;

$db="work_comp";
include("../../include/iConnect.inc"); // database connection parameters
$db = mysqli_select_db($connection,$database)       or die ("Couldn't select database");

if(empty($_POST['rep']))
	{
	echo "<table cellpadding='5'>
	<tr><th colspan='3' align='left'>DPR Workers' Comp - Search</th></tr>
	</table>";
	$rep="";
	}
	else
	{
	$rep=1;
	}


if($_REQUEST==""){exit;}

$this_user=@$_SESSION['work_comp']['tempID'];

		@$employee_name=$_POST['employee_name'];
		@$park_code=$_POST['park_code'];
		@$employee_status=$_POST['employee_status'];
		@$site=$_POST['site'];
		
		if(empty($_POST) or @$_POST['submit']=="Reset")
			{
			$employee_name="";
			$park_code="";
			$employee_status="";
			}
		$sql="SELECT distinct t1.park_code
		FROM form19 as t1
		where 1 
		order by t1.park_code "; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die(mysqli_error($connection));
		if(mysqli_num_rows($result)>0)
			{
		while($row=mysqli_fetch_assoc($result))
				{
				$park_code_array[]=$row['park_code'];
				}
			if($level<2)
				{
				if(!empty($_SESSION['work_comp']['accessPark']))
					{
					$exp=explode(",",$_SESSION['work_comp']['accessPark']);
					foreach($exp as $k=>$v)
						{
						if(!in_array($v, $park_code_array)){continue;}
						$temp_park_array[]=$v;
						}
					if(empty($temp_park_array))
						{echo "No entries have been made for your park."; exit;}
					}
				}
				else
				{$temp_park_array=$park_code_array;}
			}
			else
			{echo "There are no WC entries."; exit;}
			
	 echo "<form method='POST' action='search.php'><table>
	 <tr><td>Employee Last Name</td><td><input id=\"name_sn\"  type='text' name='employee_name' value='$employee_name'></td></tr>";
	 
	 
	 echo "<tr><td>Park</td><td><select name='park_code'><option selected=''></option>\n";
	 foreach($temp_park_array as $k=>$v)
	 	{
	 	echo "<option value='$v'>$v</option>\n";
	 	}
	 echo "</select></td></tr>";
	 	
	 echo "<tr><td>Entered into Corvel</td>
	 <td><input type='radio' name='wc_approved' value='Yes'> Yes <input type='radio' name='wc_approved' value='No'> No</td></tr>";
	 
	 echo "<tr><td>Employee Status</td>
	 <td><input type='radio' name='employee_status' value='Permanent'> Permanent <input type='radio' name='employee_status' value='Seasonal'> Seasonal</td></tr>
	 
	 <tr><td>Date Range</td><td>
	 Start <input type='text' id='datepicker1' name='date_start' value=''>
	 End <input type='text' id='datepicker2' name='date_end' value=''>
	 </td></tr>"
	 ?>
	 <script>
    $(function() {
        $( "#datepicker1" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd' });
        $( "#datepicker2" ).datepicker({
		changeMonth: true,
		changeYear: true, 
		dateFormat: 'yy-mm-dd',
		yearRange: "-50yy:+0yy",
		maxDate: "+0yy" });
    });
</script>
<style>
.ui-datepicker {
  font-size: 80%;
}
</style>

<?php
	 
	 echo "<tr><td>Park Comments</td><td><input type='text' name='park_comments' value=''></td></tr>";
	 
	 if($level>2)
	 	{
	 	echo " <tr><td>HR Comments</td><td><input type='text' name='hr_comments' value=''>";
		echo "</td></tr>";
	 	}
	
	 echo "<tr><td colspan='2' align='center'>
	 <input type='submit' name='submit' value='Find' style='background-color:#66FF33'></td>
	 <td><input type='submit' name='submit' value='Reset'>
	 </td></tr>";
	
	echo "</table></form><hr />";

	
// ************************************************************
if(!empty($_GET)){$_POST=$_GET;}
if(isset($_POST['submit']) and $_POST['submit']=="Find")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	$skip_post=array("submit","direction","date_start","date_end");
	$t2_array=array("comName");
	$like=array("employee_name","park_comments","hr_comments");
	foreach($_POST AS $fld=>$val)
		{
		if(in_array($fld,$skip_post)){continue;}
		if(empty($val)){continue;}
		$t="t1";
		if(in_array($fld, $t2_array)){$t="t2";}
		if(in_array($fld, $like))
			{@$clause.=$t.".$fld like '%$val%' and ";}
			else
			{@$clause.=$t.".$fld='$val' and ";}
		
		}
	if(!empty($clause))
		{$clause=" and ".rtrim($clause," and ");}
		else
		{$clause="";}
	
	}

if(!empty($_POST['date_start']))
	{
	$ds=$_POST['date_start'];
	$de=$_POST['date_end'];
	$clause.=" and (date_of_injury>='$ds' and date_of_injury<='$de')";
	}
		
if(!empty($_POST['clause']))
	{
	$clause=$_POST['clause'];
	}
//	echo "$clause";

$direction="";
if(!empty($_POST['direction']))
	{
	$direction=$_POST['direction'];
	}
	
$order_by="order by t1.timestamp DESC";	
	if(isset($clause))
		{
		if(!empty($sort_by))
			{
			$order_by="order by $sort_by";
			}
			
		$sql="SELECT t1.wc_id, t1.park_code, t1.wc_approved as entered_into_Corvel, t1.employee_name, t1.employee_id, t1.employee_status, t1.timestamp
		FROM form19 as t1
		where 1 $clause
		$order_by $direction"; 
// 		echo "$sql";
	
		$result = mysqli_query($connection,$sql) or die(mysqli_error($connection)."<br />$sql");
		while($row=mysqli_fetch_assoc($result))
				{
				$ARRAY[]=$row;
				}
		}

if(!isset($ARRAY)){echo "</div></body></html>";exit;}

//echo "c=$clause";

$skip=array("method","date_c","enter_by","");
$c=count($ARRAY);

if($c>1000){$limited="but only the first 1,000 are shown.";}else{$limited="are shown.";}

if(!empty($rep))
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=nc_moth_records.xls');
	echo "<table>";
	}
else
	{
	$c<2?$records="record":$records="records";
	$c<2?$limited="is shown.":$limites="are shown.";
	echo "<table border='1'><tr><td colspan='5'>".number_format($c,0)." $records $limited</td>
	<td><form method='POST' action='search.php'>
	<input type='hidden' name='clause' value=\"$clause\">
	<input type='submit' name='rep' value='Excel Export $c $records'>
	</form></td></tr>";
	}
foreach($ARRAY AS $index=>$array)
	{
	if($index>1000 and empty($rep)){break;}
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$new_fld=str_replace("_"," ",$fld);
			if(@$_POST['direction']=="ASC")
				{
				$direction="DESC";
				$color="Yellow";
				}
				else
				{
				$direction="ASC";
				$color="Tan";
				}
			$sort_col="<form action='search.php' method='POST'>
			<input type='hidden' name='sort_by' value=\"$fld\">
			<input type='hidden' name='direction' value=\"$direction\">
			<input type='hidden' name='clause' value=\"$clause\">
			<input type='submit' name='submit' value='$new_fld' style=\"background:$color\">
			</form>";
			echo "<th valign='bottom'>$sort_col</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="wc_id")
			{
			if($level>1)  // > level 4
				{$value="<a href='review_submission.php?wc_id=$value'>[ $value ]</a>";}
			} 
		echo "<td valign='top'>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";

if(empty($rep))
	{
	echo "</div>
	</div></body></html>";
	}

?>
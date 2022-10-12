<?php
$database="state_lakes";
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;

if(@$_REQUEST['report']=="delinquent_amounts")
	{
	header("Location: delinq_yrs_totals.php?park=$_REQUEST[park]&end_date=$_REQUEST[end_date]");
	exit;
	}
	
$tab="Reports";
if(@$_REQUEST['rep']=="")
	{
	include("menu.php");
	
	echo "<div align='center'>";
	
	echo "<form action='report.php' method='POST'><table border='1' cellpadding='3'><tr>";
	
	$allFields=array("park");
	$find_array=array("reports");
	$merger_array=array_merge($allFields,$find_array);
	
	$report_array=array("payments_by_pier_owner"=>"payments_by_pier_owner","payments_by_buoy_owner"=>"payments_by_buoy_owner","delinquent_amounts"=>"delinquent_amounts","find_missing_objects"=>"find_missing_objects");
	
	$start_year=date('Y')."-01-01";
	$today=date("Y-m-d");
	$past_week=date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")-7,   date("Y")));
	$past_weekday=date("D, Y-m-d",mktime(0, 0, 0, date("m"), date("d")-7,   date("Y")));
	
	if(@$_REQUEST['start_date']){$start_year=$_REQUEST['start_date'];}
	if(@$_REQUEST['end_date']){$today=$_REQUEST['end_date'];}

$j=0;
	foreach($merger_array as $k=>$v)
		{					
				if($v=="reports")
				{	$td=" colspan='4' align='center'";
					$v1="Start date: <input type='text' name='start_date' value='$start_year' size='11'>
					End date: <input type='text' name='end_date' value='$today' size='11'>		";				
				}
				
				if($v=="park")
				{
				$td=" colspan='2'";
				include("park_arrays.php");
				
				foreach($var_array as $k2=>$v2)
					{
					if($v2==@$_REQUEST['park'])
						{$ck="checked";}
						else
						{$ck="";}
					@$x1.="<input type='radio' name='$v' value='$v2' $ck>$v2 ";
					}
				$v="";
				$v1=$x1;
				}

		
		echo "<td$td>$v1</td>";
		$td="";
		
		if(fmod($j,7)==0)
			{
				if($k==0)
					{
					echo "<td><select name='report'><option selected=''></option>";
					foreach($report_array as $k1=>$v1)
						{
						if(@$report==$k1){$s="selected";}else{$s="value";}
						echo "<option $s='$k1'>$v1</option>";
						}
					
					echo "</select></td>";
					echo "<td colspan='7' align='center' bgcolor='aliceblue'>
					<font size='+2' color='purple'>$tab</font></td>";
					}
				echo "</tr><tr>";
			}
		$j++;
		}
				echo "</tr><tr><td align='center' colspan='7' align='center'>
				<input type='submit' name='submit' value='Submit'>
				</td>";
				
		echo "</tr></table></form></div>";	
	}

if(@$_REQUEST['rep']=="1")
	{
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
	$fn=$_REQUEST['report'];
	$park=$_REQUEST['park'];
	$filename="Content-Disposition: attachment; filename=".$park."_".$fn.".xls;";
	header('Content-Type: application/vnd.ms-excel');
	header("$filename");
	}
	
if(@$_REQUEST['report']=="" or $_REQUEST['park']=="")
	{
	echo "Both a Park and a Report must be specified."; exit;
	}
	
if(@$_REQUEST['report']=="find_missing_objects")
	{
	include("find_missing_objects.php");
	exit;
	}	
	unset($allFields);
//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;

//**************
$sql_array=array("payments_by_pier_owner"=>"SELECT t2.pier_id,t2.pier_number,concat(t1.billing_first_name,' ', t1.billing_last_name) as billing_name,'Agent',concat(t1.billing_add_1,' ',t1.billing_add_2,' ',t1.billing_city,', ',t1.billing_state,' ',t1.billing_zip) as billing_address, t1.lake_address,t2.fee,t2.pier_payment,t2.pier_comment
FROM `contacts` as t1
LEFT JOIN piers as t2 on t1.id=t2.contacts_id
",
"payments_by_buoy_owner"=>"SELECT t2.buoy_id,t2.buoy_number,concat(t1.billing_first_name,' ', t1.billing_last_name) as billing_name,'Agent',concat(t1.billing_add_1,' ',t1.billing_add_2,' ',t1.billing_city,', ',t1.billing_state,' ',t1.billing_zip) as billing_address, t1.lake_address,t2.fee,t2.buoy_receipt,t2.buoy_comment
FROM `contacts` as t1
LEFT JOIN buoy as t2 on t1.id=t2.contacts_id
");

$order_by_array=array("payments_by_pier_owner"=>" order by t1.billing_last_name","payments_by_buoy_owner"=>" order by t1.billing_last_name");

if($_REQUEST)
	{
	foreach($_POST as $field=>$value)
		{
		@$pass_query.=$field."=".$value."&";
		}
	EXTRACT($_REQUEST);
		$pass_query.="rep=1";
	$sql_statement=$sql_array[$report];
	
	$clause="where 1";
	$sql_statement.=$clause;
	
	$where_clause=array("payments_by_pier_owner"=>" and t1.park='$park' and t2.pier_id is not NULL","payments_by_buoy_owner"=>" and t1.park='$park' and t2.buoy_id is not NULL");
	$sql_statement.=$where_clause[$report];
	$date_clause=array("payments_by_pier_owner"=>" and pier_payment>='$start_date' and pier_payment<='$end_date'","payments_by_buoy_owner"=>" and buoy_receipt>='$start_date' and buoy_receipt<='$end_date'");
	$sql_statement.=$date_clause[$report];
	
	$sql_statement.=$order_by_array[$report];
//	echo "$sql_statement";

 $result = @mysqli_QUERY($connection,$sql_statement);
 $num=mysqli_num_rows($result);
 
 if($num<1){echo "No records were found for that search."; exit;}
 
while($row=mysqli_fetch_assoc($result))
		{
			$allFields[]=$row;
		}
	}
	else{exit;}
	
	$num_records=count($allFields);
	if(@$rep==""){$excel="<a href='report.php?$pass_query'>Excel</a> Export";}
	
	if(@$_REQUEST['rep']=="")
		{echo "<table><tr><th>$num_records Records $excel</th></tr></table>";}
	
	echo "<table border='1'><tr>";
	foreach($allFields[0] as $key=>$value)
		{
		$key=str_replace("_"," ",$key);
		echo "<th>$key</th>";
		}
		echo "</tr>";
		
		foreach($allFields as $num=>$array)
			{
				echo "<tr>";
				foreach($array as $key=>$value)
					{
					$td="";
					if($key=="Agent"){$value="";}
					if($key=="pier_comment")
						{
						$td=" width='20%'";
						}
					echo "<td$td>$value</td>";
					}
				echo "</tr>";			
			}
echo "</table></div></body></html>";
?>
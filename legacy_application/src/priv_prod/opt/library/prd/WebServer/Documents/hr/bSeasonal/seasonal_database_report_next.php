<?php
ini_set('display_errors',1);
session_start();
$level=$_SESSION['hr']['level'];
$new_request_date=@$_SESSION['hr']['new_request_date'];
if($level<1){echo "You do not have access to this database. <a href='https://auth.dpr.ncparks.gov/hr/'>login</a>";exit;}

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

$database="hr";
include("../../../include/iConnect.inc"); // database connection parameters
include("../../../include/biglog.php"); 

if(!empty($submit_form))
	{
	Header("Location: seasonal_database_report_next.php");
	exit;
	}

mysqli_select_db($connection,$database);

if(@!$_POST['div_app'] AND @!$_POST['park_approve'])
	{
	$_POST['div_app']="y";$div_app="y";
	$_POST['park_approve']="y";$park_approve="y";
	$submit="Find";
	}

if(empty($period)){$period="a";}


if(empty($pay_rate)){$pay_rate="avg_rate_new";}else{$pay_rate="avg_rate_new";}

$display=array("district","center_code","beacon_posnum","osbm_title","start_date",$pay_rate,"ncas_account","div_app","park_approve","comments","park_comments","budget_hrs_a");
$display_1=array("budget_weeks","budget_hrs",);

foreach($display as $k=>$v)
	{
	@$hard_fields.="t1.".$v.",";
	}
foreach($display_1 as $k=>$v)
	{
	$var=$v."_".$period;
	@$hard_fields.="t1.".$var.",";
	}

$hard_fields=rtrim($hard_fields,",");

if(empty($adjust)){$adjust=0;}


$sql = "SELECT sum(t1.budget_hrs_".$period."*(budget_weeks_".$period."+($adjust))*avg_rate_new) as total
FROM seasonal_payroll_next as t1
WHERE (park_approve='y' AND (district='EADI' OR  district='NODI' OR  district='SODI' OR  district='WEDI')) OR (t1.center_code='OPAD' AND park_approve='y' and start_date!='')"; //echo "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_assoc($result);{$operations=$row['total'];}

$sql = "SELECT sum(t1.budget_hrs_".$period."*(budget_weeks_".$period."+($adjust))*avg_rate_new) as total
FROM seasonal_payroll_next as t1
WHERE (park_approve='y') AND (district='EADI' OR  district='NODI' OR  district='SODI' OR  district='WEDI') AND t1.center_code!='OPAD'"; //echo "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
$row=mysqli_fetch_assoc($result);{$others=$row['total'];}

$district_array=array();
$sql = "SELECT upper(district) as district,ncas_account, sum(t1.budget_hrs_".$period."*(budget_weeks_".$period."+($adjust))*avg_rate_new) as total
FROM seasonal_payroll_next as t1
WHERE 1 and park_approve='y'
group by district,t1.ncas_account
order by district"; //echo "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$district_array[$row['district']][$row['ncas_account']]=$row['total'];
	}
// echo "<pre>"; print_r($district_array); echo "</pre>"; //exit;



//  GROUP TOTAL TABLE

$sql = "SELECT center,center_code,sum(t1.budget_hrs_".$period."*(budget_weeks_".$period."+($adjust))*avg_rate_new) as total
FROM seasonal_payroll_next as t1
WHERE 1 and park_approve='y'
group by center
order by center_code"; 
// echo "$sql"; //exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result)){
	$park_array[$row['center_code']]=$row['total'];
	$center_array[$row['center_code']]=$row['center'];
	}
// echo "<pre>"; print_r($park_array); echo "</pre>"; //exit;

$div_array=array("y","n");
$skipFind=array("PHPSESSID","submit","adjust","rep","sort","details","period");

if($submit=="Find")
	{
	//		echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
		if($_POST)
			{
			foreach($_POST AS $k=>$v)
				{
				if($v==""){continue;}
				if($k=="adjust"){$passQuery.="&$k=$v";}
				
				if(in_array($k,$skipFind)){continue;}
				@$passQuery.="&$k=$v";
				if($k=="budget_hrs_a"){
					@$where.=" and t1.$k !='0.00'";
					continue;}
				
				if($k=="comments")
					{
					@$where.="and t1.$k like '%$v%' ";
					}
					else
					{@$where.=" and t1.$k='$v'";}		
				}
			}
			
		else
			{
			if($_REQUEST)
				{
					//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;
				foreach($_REQUEST AS $k=>$v)
					{
					if(in_array($k,$skipFind)){continue;}
					if($k=="budget_hrs_a"){
						@$where.=" and t1.$k !='0.00'";
						continue;}
					
					if($k=="comments")
						{
						@$where.="and t1.$k like '%$v%' ";
						}
						else
						{@$where.=" and t1.$k='$v'";}		
					}
				}
			}
	
		if(@$sort=="")
			{$orderBy="t1.district,t1.center_code,t1.osbm_title";}
		else
			{$orderBy="t1.osbm_title";}
	if(!isset($where1)){$where1="";}
	$sql = "SELECT $hard_fields
	FROM seasonal_payroll_next as t1
	WHERE 1 $where $where1
	ORDER  BY $orderBy"; 
// 	echo "<br /><br />$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	$num=mysqli_num_rows($result);
	while($row=mysqli_fetch_assoc($result))
		{$result_array[]=$row;}
//	echo "$sql<pre>"; print_r($result_array); echo "</pre>"; //exit;
	
	}


// ******** Menu **********
if($level>3 AND @$rep==""){
	include("menu_next.php");
	echo "<div align='center'><form method='POST'><table cellpadding='5'><tr><td>Excel <a href=\"seasonal_database_report_next.php?submit=Find&rep=excel$passQuery\">export</a></td>";
// 	if($period=="b")
// 		{$ckb="checked"; $cka=""; $half="Second Half of Year";}
// 		else
// 		{$cka="checked";$ckb=""; $half="First Half of Year";}
// 		echo "<td align='center'>Hiring Period<br />
// 		<input type='radio' name='period' value=\"a\" $cka>1st Half<br />
// 		<input type='radio' name='period' value=\"b\" $ckb>2nd Half
// 		</td>";
		
		echo "<td align='center'>District<br /><select name='district'><option select=''></option>";
		foreach($district_array as $k=>$v){
			if($k==@$district){$s="selected";}else{$s="";}
			echo "<option value='$k' $s>$k</option>";
			}
		echo "</select></td>";
		
		echo "<td align='center'>Center Code<br /><select name='center_code'><option select=''></option>";
		foreach($park_array as $k=>$v){
			if($k==@$center_code){$s="selected";}else{$s="";}
			echo "<option value='$k' $s>$k</option>";
			}
		echo "</select></td>";
		
		if(!isset($comments)){$comments="";}
		echo "<td align='center'>Comments<br /><input type='text' name='comments' value='$comments'></td>";
		
		echo "<td align='center'>Div Approve<br /><select name='div_app'><option select=''></option>";
		foreach($div_array as $k=>$v){
			if($v==$div_app){$s="selected";}else{$s="value";}
			echo "<option $s='$v'>$v</option>";
			}
		echo "</select></td>";
		
		echo "<td align='center'>Park Approve<br /><select name='park_approve'><option select=''></option>";
		foreach($div_array as $k=>$v){
			if($v=="n"){continue;}
			if($v==$park_approve){$s="selected";}else{$s="value";}
			echo "<option $s='$v'>$v</option>";
			}
		echo "</select></td>";
		
		echo "<td align='center'>Adjust Weeks (+ -)<br /><input type='text' name='adjust' value='$adjust' size='2'></td>";
		
		if(@$_POST['budget_hrs_a']=="0"){$ck0=" checked";}else{$ck0="";}
		echo "<td align='center'>Hide 0 request<br /><input type='checkbox' name='budget_hrs_a' value='0'$ck0></td>";
		
		if(@$_POST['sort']=="x"){$ckS=" checked";}else{$ckS="";}
		echo "<td align='center'>Sort by OSBM Title<br /><input type='checkbox' name='sort' value='x'$ckS></td>";
		
		if(@$_POST['details']=="x"){$ckD=" checked";}else{$ckD="";}
		echo "<td align='center'>Expand Details<br /><input type='checkbox' name='details' value='x'$ckD></td>";
		
		echo "<td><input type='submit' name='submit' value='Find'></td>";
		echo "<td><input type='submit' name='submit_form' value='Reset'></td>";
		echo "</tr></table></form>";
		}



if(@$rep=="excel"){header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=seasonal_database_report.xls');
	if($scope=="centers"){
		echo "<table>";
		echo "<tr><td>center_code</td><td>amount</td><td>center</td></tr>";
		foreach($park_array as $k=>$v){
		$v=number_format($v,2);
		$c=$center_array[$k];
			echo "<tr><td>$k</td><td>$v</td><td>$c</td></tr>";
			}
		echo "</table>";
		exit;
		}
}



// Header


IF(@$rep=="")
	{
	$gt=number_format(($operations+$others),2);
	$operations=number_format($operations,2);
	$others=number_format($others,2);
	echo "<table border='1' cellpadding='3'><tr><td colspan='11' align='center'>$num positions </td></tr><tr><td colspan='11' align='center'>Operations: (EADI, NODI, SODI, WEDI) <b>$operations</b> + Others: (ADMI, DEDE, NARA, NRTF, PAR3, USBG) <b>$others</b> = <b>$gt</b> - <font size='-1'>Scroll to bottom for 1311/1312 subtotals</font></td></tr>";
	
	// district
		echo "<tr><td colspan='11' align='center'>";
		foreach($district_array as $k=>$v)
			{
			foreach($v as $account=>$amount)
				{
				$a=number_format($amount,2);
				if($account=="531312")
					{$f1="<font color='blue'>";$f2="</font>";}
					else
					{$f1="<font color='green'>";$f2="</font>";}
				$a="[<b>$k</b> - $f1$account$f2 = $a]";
				if(($k." - ".$account)=="STWD - 531311")
					{echo "<br />";}
				echo "$a&nbsp;&nbsp;&nbsp;";
				}
			}
		echo "</td></tr>";
	// Parks	
		echo "<tr><td colspan='10' align='left'>";
		echo "<table border='1' cellpadding='2'><tr>";
		echo "<td>";
		foreach($park_array as $k=>$v)
			{
			@$i++;
			$v=number_format($v,2);
				echo "<b>$k</b>=$v<br />";
				if(fmod($i,5)==0){echo "</td><td>";}
			}
			if($adjust){$aa="&adjust=$adjust";}else{$aa="";}
		echo "</td></tr></table></td><td align='center'><a href='seasonal_database_report_next?rep=excel&scope=centers$aa'>export</a><br />Centers</td></tr></table>";
	}


if(!$submit){exit;}



bl(print_r($result_array,true)); 




// MAIN TABLE


$details=@$_POST['details'];
		echo "<table border='1' cellpadding='3'><tr>";
foreach($display as $fld=>$val)
	{
	$testHeader[]=$val;
		if($val=="budget_hrs_a"){$val="hrs * weeks * rate";}
		if($val=="park_approve"){$val="park app";}
		if($val=="budget_weeks_a"){$val="weeks & hrs";}
		$val=str_replace("_"," ",$val);
		echo "<th>$val</th>";
	}
		echo "</tr>";


	
	$varHeader=0;


foreach($result_array as $number=>$fields)
	{
	
		echo "<tr>";
		foreach($fields as $fld_name=>$value){
			if(in_array($fld_name,$display)){
				
					$td="";
					
					if($fld_name=="park_comments")
						{
						if($value AND @$rep=="")
							{
							if(@$details=="x")
								{$block="block";}else{$block="none";}
							$value="<div id=\"fieldName\"><a onclick=\"toggleDisplay('fieldDetails[$number]');\" href=\"javascript:void('')\"> details &#177</a> </div><div id=\"fieldDetails[$number]\" style=\"display: $block\">$value</div>";
							}
						}
						
					if($fld_name=="district")
						{
						$value=strtoupper($value);
						if(@$track_district!=$value)
							{
							$td=" bgcolor='yellow'";
							$track_district=$value;
							$reg_total=array_sum($district_array[$value]);
							$value.="<br />".number_format($reg_total,2);
							}
						}
					
					if($fld_name=="center_code")
						{
						if(@$track_center_code!=$value)
							{
							$td=" bgcolor='yellow'";
							$track_center_code=$value;
							$value.="<br />".number_format($park_array[$value],2);
							}
						}
						
					if($fld_name=="budget_hrs_a")
						{
							$td=" align='right'";
						$rate=$result_array[$number]['avg_rate_new'];
						$hours=$result_array[$number]['budget_hrs_a'];
// 						echo "h=$hours"; exit;
						$weeks=$result_array[$number]['budget_weeks_a']+($adjust);
						
						$Cost=$weeks*$rate*$hours;
						@$totalCost+=$Cost;
							$tempVar=number_format($Cost,2); 
							if($result_array[$number]['ncas_account']=="531311"){
							@$subtotalCost1311+=$Cost;
							@$total1311+=$Cost;}
							if($result_array[$number]['ncas_account']=="531312"){
							@$subtotalCost1312+=$Cost;
							@$total1312+=$Cost;}
							
							$value=$tempVar;
							}
					//ETG	
					if($fld_name=="budget_dollars_a")
						{
							$td=" align='right'";
						$rate=$result_array[$number]['avg_rate_new'];
						$hours=$result_array[$number]['budget_hrs_a'];
// 						echo "h=$hours"; exit;
						$weeks=$result_array[$number]['budget_weeks_a']+($adjust);
						
						$Cost=$weeks*$rate*$hours;
						@$totalCost+=$Cost;
							$tempVar=number_format($Cost,2); 
							if($result_array[$number]['ncas_account']=="531311"){
							@$subtotalCost1311+=$Cost;
							@$total1311+=$Cost;}
							if($result_array[$number]['ncas_account']=="531312"){
							@$subtotalCost1312+=$Cost;
							@$total1312+=$Cost;}
							
							$value=$tempVar;
							}
							
						
					if($fld_name=="budget_weeks_a")
						{
						$value="wks=$value, hrs=$fields[budget_hrs_a]";
						}
					echo "<td$td>$value</td>";
				
				}
				else{continue;}
			}
			@$ii++;
		echo "</tr>";
		}
		@$subtotalCost1311=number_format($subtotalCost1311,2);
		echo "<tr bgcolor='aliceblue'><td colspan='6' align='right'>Subtotal 1311: $subtotalCost1311<br />";
		if(@$subtotalCost1312>0)
			{
			$subtotalCost1312=number_format($subtotalCost1312,2);
			echo "Subtotal 1312: $subtotalCost1312";
			}
		echo "</td></tr>";


		@$tc=number_format($totalCost,2);
		@$tc1311=number_format($total1311,2);
		@$tc1312=number_format($total1312,2);
		echo "<tr><td colspan='6' align='right'>Total 1311: $$tc1311</td></tr>";
		echo "<tr><td colspan='6' align='right'>Total 1312: $$tc1312</td></tr>";
		
		echo "<tr><td colspan='6' align='right'>Grand Total: $$tc</td></tr>";
	echo "</table>";
?>

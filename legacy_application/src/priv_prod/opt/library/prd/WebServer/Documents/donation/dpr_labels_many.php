<?php
// modified after dpr_labels_many.php in divper

if(!isset($_REQUEST['rep'])){$rep="";}else{$rep=$_REQUEST['rep'];}

if($rep=="")
	{
	echo "<table border='1' cellpadding='5'>";
	$passQuery=str_replace("'","",$passQuery);

$form_action="dpr_labels_find.php";
$db_source="donation";
	if($db_source=="donation")
		{
		$PATH="/donation/";
		$form_action=$PATH."form.php";
		}

	echo "<tr>
	<td colspan='5' align='center'><form action='$form_action'>Using: $arraySet</td>
	<td colspan='4' align='center'>
	<input type='submit' name='submit_label' value='Go to Find'></form>
	</td>";
	if($level>3)
		{
	echo "<td colspan='5' align='center'>
	<a href='donation_find.php?$passQuery";
	echo "rep=excel&submit_label=Find'>Export</a>";
	echo "</td>";
	}
	echo "</tr>";
	}
	else
	{
	header("Content-Type: text/csv");
		header("Content-Disposition: attachment; filename=donation_db_export.csv");
		// Disable caching
		header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
		header("Pragma: no-cache"); // HTTP 1.0
		header("Expires: 0"); // Proxies
		
		
		function outputCSV($header_array, $data) {
		
			$output = fopen("php://output", "w");

			foreach ($header_array as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
			foreach ($data as $row) {
				fputcsv($output, $row); // here you can change delimiter/enclosure
			}
		fclose($output);
		}

		$header_array[]=array_keys($ARRAY[0]);
// 		echo "<pre>"; print_r($header_array); print_r($comment_line); echo "</pre>";  exit;
		outputCSV($header_array, $ARRAY);
		exit;
	}
//echo "$sql";

echo "<tr>";
if($rep=="")
	{
	echo "<th>$num</th>";
	
	}
echo "
<th>Donation to Park</th>
<th>Date</th>
<th>Donor Type</th>";
//<th>Affiliation</th>

if($rep=="")
	{
	echo "<th><a href='donation_find.php?$passQuery"."submit_label=Find&sort=donor_organization'>Donor Organization</a></th>";
	}
else
	{
	echo "<th>Donor Organization</th>";
	}
echo "<th>First Name</th>
<th>Last Name</th>
";

if($rep=="")
	{
	echo "<th>Contacts</th>";
	}
	else
	{
	echo "<th>address</th><th>phone</th><th>email</th>";
	}
	

echo "<th>General Comments</th>";

echo "<th>Financial</th><th>Material</th><th>Land</th>";

echo "</tr>";

//if($park){$type="&".$park;}
$checkPark=$_SESSION['parkS'];

if($arraySet){
$arraySet=trim($arraySet," and ");
$type="&".urlencode($arraySet);}

if($rep=="")
	{
	echo "<form action='dpr_labels_print.php' method='POST'>";
	}
// echo "$sql<br />";
while($row=mysqli_fetch_array($result))
	{
	extract($row);
	
	if(!empty($park)){$type="&pass=".$park;}
	
	if(!empty($Nickname))
		{
		if($rep=="")
			{
			$First_name=$First_name."<br />(".$Nickname.")";
			}
		else	
			{
			$First_name=$First_name." (".$Nickname.")";
			}

		
		}
	
if(@$db_source=="donation")
	{
	$redirect_edit="/donation/form.php";
	}

	echo "<tr>";
	
if($rep=="")
	{
	if(!isset($type)){$type="";}
	echo "<td><a href='$redirect_edit?id=$id&submit_label=Find$type'>Edit</a></td>
	";
	}

	echo "
	<td>$park_code</td>
";
//		<td>$affiliation_code</td>
	if(!empty($donor_type))
		{$donor_type="<font color='magenta'>DONOR=".$donor_type."</font>";}
	echo "<td>$date_donation_received</td>
	<td>$donor_type</td>
	<td>$donor_organization</td>
	<td>$First_name</td>";
	
if($rep=="")
	{
	echo "<td>$Last_name</td>";
	}
	else
	{
	echo "<td>$Last_name</td>";
	}
	
if($rep=="")
	{
	echo "<td>$address, $city, $state $zip<br />$phone<br />$email<br />$website</td>";
	}
	else
	{
	echo "<td>$address, $city, $state $zip</td><td>$phone</td><td>$email</td>";
	}
	
	echo "<td>$general_comments</td>";

	if($financial=="0.00")
		{$financial="";}
		else
		{
		@$tot_financial+=$financial;
		$financial=number_format($financial,2);
		}
	if($material=="0.00"){$material="";}else{
		@$tot_material+=$material;
		$material=number_format($material,2);}
	if($land=="0.00"){$land="";}else{
		@$tot_land+=$land;
		$land=number_format($land,2);}
	echo "<td>$financial</td>";
	echo "<td>$material</td>";
	echo "<td>$land</td>";
	echo "</tr>";
}
@$tot_financial=number_format($tot_financial,2);
@$tot_material=number_format($tot_material,2);
@$tot_land=number_format($tot_land,2);
echo "<tr><td colspan='10' align='right'>$tot_financial</td><td align='right'>$tot_material</td><td align='right'>$tot_land</td></tr>";
echo "</table>";

?>
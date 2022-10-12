<?php
//echo "$arraySet";
//$passQuery=urlencode($arraySet);

if(!isset($rep)){$rep="";}

if($rep=="")
	{
	echo "<table border='1' cellpadding='5'>";
	if(!isset($passQuery)){$passQuery="";}
	$passQuery=str_replace("'","",$passQuery);
	echo "<tr>
	<td colspan='5' align='center'><form action='form.php'>Using: $arraySet</td>";
/*	echo "<td colspan='4' align='center'>
	<input type='submit' name='submit_label' value='Go to Find'></form>
	</td>
	<td colspan='5' align='center'>
	<a href='dpr_labels_find.php?$passQuery";
	echo "rep=excel&submit_label=Find' target='_blank'>Excel</a>
	</td>";
*/
	echo "</tr>";
	}
	else
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=DPR_Donors.xls');
	echo "<table border='1' cellpadding='5'>";
	}
//echo "$sql";

echo "<tr>";
if($rep=="")
	{
	echo "<th>$num</th>";
	}
echo "
<th>Donation to Park</th>
<th>Affiliation</th>
<th>Donor Type</th>
<th>Donor Organization</th>
<th>First Name</th>
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
	
echo "<th>General Comments</th>
</tr>";

//if($park){$type="&".$park;}
$checkPark=$_SESSION['parkS'];

if($park AND $arraySet)
	{
	$arraySet=trim($arraySet," and ");
	$type="&".urlencode($arraySet);
	}

//echo "<pre>"; print_r($pass_row); echo "</pre>"; // exit;


//	extract($pass_row);
	
	if($park){$type="&pass=".$park;}
	
	if($Nickname)
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
	
//	<td>$add1 $city $state, $zip</td>
	echo "<tr>";
	
if($rep=="")
	{
	if(!isset($type)){$type="";}
	echo "<td><a href='/donation/form.php?id=$id&submit_label=Find$type'>Edit</a></td>";
	}
	
	if(in_array($id,$affiliation_code_array))
		{
		$affiliation_code="";
		foreach($affiliation_code_array as $key_1=>$val_1)
			{
			if($val_1==$id)
				{
				$exp=explode("*",$key_1);
				$affiliation_code.="[".$exp[0]."] ";
				}
			}
		}
	echo "
	<td>$park_code</td>
	<td>$affiliation_code</td>
	<td>$donor_type</td>
	<td>$donor_organization</td>
	<td>$First_name</td>";
	
	echo "<td>$Last_name</td>";
	
	
if($rep=="")
	{
	$email=str_replace(" ","\n", $email);
	$exp=explode("\n",$email);
//	echo "<pre>"; print_r($exp); echo "</pre>"; // exit;
	$link_email="";
	foreach($exp as $k_e=>$k_v)
		{
		$link_email.="[<a href='mailto:$k_v'>$k_v</a>] ";
		}
	echo "<td>$address, $city, $state $zip<br />$phone<br />$link_email</td>";
	}
	else
	{
	echo "<td>$address, $city, $state $zip</td><td>$phone</td><td>$email</td>";
	}
	
	
	if($park==$checkPark OR $level>1)
		{
		echo "<td>$general_comments</td>";
		}
	
	echo "</tr>";

echo "</table>";

?>
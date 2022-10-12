<?php
//echo "$arraySet";
//$passQuery=urlencode($arraySet);

if(!isset($rep)){$rep="";}

if($rep=="")
	{
	echo "<table border='1' cellpadding='5'>";
	$passQuery=str_replace("'","",$passQuery);

$form_action="dpr_labels_find.php";
	if(@$db_source=="donation")
		{
		$PATH="/donation/";
		$form_action=$PATH."form.php";
		}

	echo "<tr>
	<td colspan='5' align='center'><form action='$form_action'>Using: $arraySet</td>
	<td colspan='4' align='center'>
	<input type='submit' name='submit_label' value='Go to Find'></form>
	</td>
	<td colspan='5' align='center'>
	<a href='dpr_labels_find.php?$passQuery";
	echo "rep=excel&submit_label=Find' target='_blank'>Excel</a>
	</td>
	</tr>";
	}
	else
	{
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=DPR_PAC_Members.xls');
	echo "<table border='1' cellpadding='5'>";
	}
//echo "$sql";

echo "<tr>";
if($rep=="")
	{
	echo "<th>$num</th>
	<th>Dist<br />Approve</th>";
	}
echo "<th>Park</th>
<th>Affiliation</th>
<th>First Name</th>
<th>Last Name</th>
<th>PAC Chair</th>";

if($rep=="")
	{
	echo "<th>Contacts</th>";
	}
	else
	{
	echo "<th>address</th><th>phone</th><th>email</th>";
	}
	

echo "<th>Interest</th>";
if($rep=="")
	{
	echo "<th>1_PAC_Term<br />2_Ends<br />3_Replaces</th>";
	}
	else
	{
	echo "<th>1_PAC_Term*2_Ends*3_Replaces</th>";
	}
//<th>Address</th>

//$level>3 AND 
if(@$show_pac_nomin_comments !="" OR $level>4)
	{echo "<th>PAC Nomin Comments</th>";}
echo "<th>General Comments</th>
</tr>";

//if($park){$type="&".$park;}
$checkPark=$_SESSION['parkS'];

if(@$park AND $arraySet){
$arraySet=trim($arraySet," and ");
$type="&".urlencode($arraySet);}

echo "<form action='dpr_labels_print.php' method='POST'>";
while($row=mysql_fetch_array($result))
	{
	extract($row);
	
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
	
if(@$db_source=="donation")
	{
	$redirect_edit="/donation/form.php";
	}
	else
	{
	$redirect_edit="dpr_labels_find.php";
	}

	echo "<tr>";
	
if($rep=="")
	{
	if(!isset($type)){$type="";}
	echo "<td><a href='$redirect_edit?id=$id&submit_label=Find$type'>Edit</a></td>
	<td>$dist_approve</td>";
	}
	
	// The below foreach is not necessay if using MySQL 4.1 or greater
	// Use GROUP_CONCAT in original query instead	
	if(in_array($id,$AF_code))
		{
		$affiliation_code="";
		foreach($AF_code as $key_1=>$val_1)
			{
			if($val_1==$id)
				{
				$exp=explode("*",$key_1);
				$affiliation_code.=" ".$exp[0];
				}
			}
		}
	echo "<td>$park</td>
	<td>$affiliation_code</td>
	<td>$First_name</td>";
	
if($rep=="")
	{
	echo "<td><input type='checkbox' name='custom[]' value='$id'>$Last_name</td>";
	}
	else
	{
	echo "<td>$Last_name</td>";
	}
	echo "<td>$pac_chair</td>";
	
if($rep=="")
	{
	echo "<td>$address, $city, $state $zip<br />$phone<br />$email</td>";
	}
	else
	{
	echo "<td>$address, $city, $state $zip</td><td>$phone</td><td>$email</td>";
	}
	
	echo "<td>$interest_group</td>";

if($rep=="")
	{
	echo "<td>1_$pac_term<br />2_$pac_terminates<br />3_$pac_replacement</td>";
	}
	else
	{
	echo "<td>1_$pac_term*2_$pac_terminates*3_$pac_replacement</td>";
	}
	
	
	if(@$show_pac_nomin_comments !="" OR $level>4)
		{
		echo "<td>$pac_nomin_comments</td>";
		}
	if($park==$checkPark OR $level>1)
		{
		echo "<td>$general_comments</td>";
		}
	
	echo "</tr>";
}

if($rep=="")
	{
	echo "<tr><td colspan='5' align='right'><input type='submit' name='submit' value='Mark for Custom Printing'></td></tr></form>";
	if(@$db_source=="donation")
		{
		echo "<tr><td colspan='7'>If the Donor is not in the above list of names, click <a href='/donation/donor_add.php?submit_label=Add+a+Donor'>here</a>.</td></tr>";
		}
	}
echo "</table>";

?>
<?php
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;

if(!isset($rep)){$rep="";}
if(!isset($arraySet)){$arraySet="";}

if($rep=="")
	{
	echo "<table border='1' cellpadding='5'>";
	$passQuery=@str_replace("'","",$passQuery);
	if(!isset($park_code)){$park_code="";}
	$source=$_SERVER['PHP_SELF'];
	
	$home_button="";
	$change="";
	$new_nomin="";
	$col_span=13;
	$page_title="$num Current <font color='green'>PAC Members</font> and any <font color='red'>Nominees</font>";

/*	
	if($source=="/pac/admin.php")
		{
		$home_button="<td colspan='2'><form action='admin.php?submit_label=Home+Page'>
		<input type='submit' name='submit' value='Home'  style=\"background-color:#E9967A\"></form></td>";

		$home_button.="<td><form action='admin.php' name='form_1'>
		<select name='park_code'><option selected=''></option>";
		foreach($parkCode as $k=>$v)
			{
			if(@$park_code==$v){$s="selected";}else{$s="value";}
			$home_button.="<option $s='$v'>$v</option>\n";
			}
		$home_button.="</select>
		<input type='submit'>
		</form></td>";
		}
*/		
	if($source=="/pac/all_nomin.php")
		{
		$page_title="$num Current PAC Nominees";
		$home_button="<td colspan='2'><form action='home.php?submit_label=Home+Page'>
		<input type='submit' name='submit' value='Home'  style=\"background-color:#E9967A\"></form></td>";
		}
	if($source=="/pac/change_current_pac.php")
		{
		if(@$term_type=="pac_former")
			{
			$page_title="Change Current PAC Member to Former (click on Edit and on next page click the Former PAC Member link)";
			}
		if(@$term_type=="pac_nom")
			{
			$page_title="Change Current PAC Member to PAC_nominee (click on Edit and on next page click the PAC Nominee link)";
			}
		$new_nomin="<td colspan='3'><a href='add_new.php?new=1&park_code=$park_code'>Nominate a New PAC Member</a></td>";
		}
	if($source=="/pac/former_pac.php")
		{
		$page_title="Former PAC Members";
		}
	if($source=="/pac/add_new.php")
		{
		$col_span=8;
		$new_nomin="<td colspan='3'><a href='add_new.php?new=1&park_code=$park_code'>Nominate a New PAC Member</a></td>";
		}
		
	echo "<tr>$home_button
	<td colspan='$col_span' align='center'><form action='dpr_labels_find.php'><font size='+1' color='brown'>$page_title</font></td>$new_nomin";
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
	<th>PAC<br />Terminates</th><th>PAC Reappoint Date</th>";
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
if(@$show_pac_nomin_comments !="" OR $level>0)
	{echo "<th>PAC Nomin Comments</th>";}

if(@$pac_ex_officio !="" OR $level>0)
	{echo "<th>PAC Ex Officio</th>";}

echo "</tr>";

//$checkPark=$_SESSION['parkS'];
$checkPark=$_SESSION['pac']['select'];

if($park_code AND $arraySet)
	{
	$arraySet=trim($arraySet," and ");
	$type="&".urlencode($arraySet);
	}

echo "<form action='dpr_labels_print.php' method='POST'>";
while($row=mysqli_fetch_array($result))
	{
	extract($row);
	
	if(@$park_code){$type="&park_code=".$park_code;}
	
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
	$href=$pass_file;
	if($affiliation_code=='PAC')
		{$pass_file="current_pac.php";}
		
	if($affiliation_code=='PAC_nomin')
		{
		$pass_file="add_new.php";
		}
	if($source=="/pac/admin.php")
		{$type="&park_code=".$park;}
	if($source=="/pac/all_nomin.php")
		{$type="&park_code=".$park;}
	if($source=="/pac/search.php")
		{$type="&park_code=".$park;}
	if($source=="/pac/add_old.php")
		{
		$pass_file="add_old.php";
		$type="&change=renominee&park_code=".$park;}
	if($source=="/pac/change_current_pac.php")
		{
		if(@$term_type=="pac_former")
			{$type="&change=former&park_code=".$park;}
		if(@$term_type=="pac_nom")
			{$type="&change=nominee&park_code=".$park;}
		}
	echo "<td valign='top'><a href='$pass_file?id=$id&submit_label=Find$type'>Edit</a></td>";
	}
	
	echo "<td valign='top'>$pac_terminates</td>";
	
	echo "<td valign='top'>$pac_reappoint_date</td>";
	
	echo "<td valign='top'>$park</td>";
	
	if($affiliation_code=='PAC'){$color='green';}else{$color='red';}
	echo "<td valign='top'><font color='$color'>$affiliation_code</font></td>
	<td valign='top'>$First_name</td>";
	
	echo "<td valign='top'>$Last_name</td>";
	
	echo "<td valign='top'>$pac_chair</td>";
	
if($rep=="")
	{
	echo "<td valign='top'>$address, $city, $state $zip<br />$phone<br />$email</td>";
	}
	else
	{
	echo "<td valign='top'>$address, $city, $state $zip</td><td>$phone</td><td>$email</td>";
	}
	
	echo "<td valign='top'>$interest_group</td>";

if($rep=="")
	{
	echo "<td valign='top'>1_$pac_term<br />2_$pac_terminates<br />3_$pac_replacement</td>";
	}
	else
	{
	echo "<td valign='top'>1_$pac_term*2_$pac_terminates*3_$pac_replacement</td>";
	}
	
if(@$show_pac_nomin_comments !="" OR $level>0)
	{
	$temp=substr($pac_nomin_comments, 0, 50)."...";
	echo "<td align='left'>$temp</td>";
	}
	
if(@$pac_ex_officio !="" OR $level>0)
	{
	echo "<td align='left'>$pac_ex_officio</td>";
	}
	
	echo "</tr>";
}

echo "</table></body></html>";

?>
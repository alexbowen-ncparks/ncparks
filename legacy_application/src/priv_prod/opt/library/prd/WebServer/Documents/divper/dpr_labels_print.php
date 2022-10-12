<?php
$database="divper";
//include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
mysqli_select_db($connection,'divper'); // database

extract($_REQUEST);

if(!$submit){include("menu.php");}
//else{
//echo "<A HREF=\"javascript:window.close()\">Close</A> the popup.";}

if(@$submit=="Mark for Custom Printing")
	{
	//echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
	foreach($_POST['custom'] as $k=>$v)
		{
		$sql = "UPDATE labels set custom='x' where id='$v'";
		//echo "$sql<br>"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		}
	
	header("Location: dpr_labels_find.php");
	exit;
	}// end submit Print


$sql = "SELECT DISTINCT t2.affiliation_code,t3.affiliation_name
from labels as t1
LEFT JOIN labels_affiliation as t2 on t1.id=t2.person_id
LEFT JOIN labels_category as t3 on t3.affiliation_code=t2.affiliation_code
where t1.id=t2.person_id order by t2.affiliation_code";//echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
//$numFlds=mysqli_num_rows($result);
while ($row=mysqli_fetch_assoc($result))
{extract($row);//print_r($row);
$codeArray[]=$affiliation_code;$nameArray[]=$affiliation_name;
}
//print_r($codeArray);exit;

// ****** Show Menu of Choices **********
if(@$submit=="")
	{
	echo "<form name='frm'><table border='1' cellpadding='5'>";
	for($i=0;$i<count($codeArray);$i++){
	$val=$nameArray[$i];
	if($val==""){$error="<font color='red'>Blank</font> - needs correcting.";}else{$error="";}
	
	if($codeArray[$i]==""){$val="<a href='dpr_labels_dupe.php?last_name=blank'>$error</a>";}
	
	echo "<tr>
	<td><input type='checkbox' name='printThis[]' value='$codeArray[$i]' checked></td>
	<td>$codeArray[$i]</td><td>$val</td>
	</tr>";}
	
	echo "<tr><td colspan='3' align='center'><input name='btn' type='button' onclick='CheckAll()' value='Check All'> 
	<input name='btn' type='button' onclick='UncheckAll()' value='Uncheck All'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' name='submit' value='Print'>";
	/*
	&nbsp;&nbsp;&nbsp;<input type='submit' name='submit' value='Custom Print'>
	*/
	echo "</td></tr></table></form>"; exit;
	}

//print_r($printThis);exit;
// ****** Find Labels **********
if($submit=="Print")
	{
	// ****** Create Array of couplets for Find **********
	for($i=0;$i<count($printThis);$i++)
		{
		$val="'".$printThis[$i]."'";
		if($i==0)
			{$where= "where affiliation_code=".$val;}
			else
			{$where.=" or affiliation_code=".$val;}
		}
	//echo "yes";exit;
	if(count($printThis)<2){$where.=" order by Last_name";}else{$where.=" order by affiliation_code,Last_name";}
	//echo "$where";exit;
	header("Location: labels_pdf30.php?where=$where");
	exit;
	}// end submit Print

?>
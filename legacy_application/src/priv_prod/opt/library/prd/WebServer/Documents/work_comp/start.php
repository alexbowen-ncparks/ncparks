<?php
$database="work_comp";
include("../_base_top.php");

if($_SESSION['work_comp']['level'] <0)
	{
	echo "<br /><br />This application is still being developed."; exit;
	}
	
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database 

// Process Update
if($_POST)
	{
// echo "<pre>"; print_r($_POST); echo "</pre>"; exit;
	if(!empty($_POST['pass_title']))
		{
		foreach($_POST['pass_title'] AS $number=>$value)
			{
			$clause="UPDATE web_links set ";
			$clause.="title='".$value."'";
			$sql=rtrim($clause,",")." where id='$number'";
						
		//		echo "<br />$sql";
				$result = mysqli_query($connection,$sql);
			}
			
		foreach($_POST['pass_link'] AS $number=>$value)
			{
			$clause="UPDATE web_links set ";
			$clause.="link='".$value."'";
			$sql=rtrim($clause,",")." where id='$number'";
			$result = mysqli_query($connection,$sql);
			}
		foreach($_POST['sort_order'] AS $number=>$value)
			{
			$clause="UPDATE web_links set ";
			$clause.="sort_order='".$value."'";
			$sql=rtrim($clause,",")." where id='$number'";
			$result = mysqli_query($connection,$sql);
			}
		}
		if(!empty($_POST['new_title']))
			{
			$title=$_POST['new_title'];
			$sql="INSERT INTO web_links set title='$title', link='$_POST[new_link]'";
			//	echo "<br />$sql";
				$result = mysqli_query($connection,$sql);
			}
				
	//	exit;
		}

echo "<table align='center'><tr><th>
<h2><font color='purple'>NC DPR Worker Compensation Tracking Application</font></h2></th></tr></table>";

echo "<table align='center' cellpadding='5'>";


echo "</table>";

if($level>3){echo "<form method='POST'>";}

echo "<hr /><table align='center' cellpadding='5'><tr>
<td>
<table border='1' cellpadding='5'><tr></tr>";

echo "<tr><td></td><td colspan='2'><h4><font color='blue'>As you navigate through the WC claim process, each step has a dropdown link with instructions specific to that step.<br /><br />Before starting Step 1, please be sure you have <font color='red'>completed</font> the following standard forms - where needed.</font></h4>
NOTE: We are in the process of updating many of these forms. Each form will have the relevant information required <font color='#e6e600'>highlighted in yellow</font>. Download the form and complete the required information. If the new form doesn't match the \"Answered\" - \"Not Answered\" section, complete those entries that are required and submit. It will take some time before the on-screen questions match the form, but the <strong>new forms must be used</strong>. If you have any questions, please contact HR.
</td></tr>";
$i=0;
$sql="SELECT * from link_to_find_db where 1 order by sort_order";
		$result = mysqli_query($connection,$sql);
		while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY_forms[]=$row;
		}
	
$skip=array("id","forumID","filename","mid");

$rename_array=array("sort_order"=>"","form_name"=>"Form","link"=>"Link");
foreach($ARRAY_forms AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY_forms[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			$var_fld=$fld;
			if(array_key_exists($fld, $rename_array)){$var_fld=$rename_array[$fld];}
			echo "<th>$var_fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		$display="<td>$value</td>";
		$temp=pathinfo($array['link']);
// 		echo "$value<pre>"; print_r($temp); echo "</pre>"; exit;
		if($temp['extension']=="pdf")
			{$link_name="Get form";}
			else
			{$link_name="Get Document";}
		
		if($fld=="link")
			{
			$value="https://10.35.152.9/find/".$value;
			$value="https://10.35.152.9/find/".$value;
			$display="<td><a href='$value' target='_blank'>$link_name</a></td>";
			}
		if($fld=="link" and $array['form_name']=="Safety Policy")
			{
			$value="https://10.35.152.9/find/".$value;
			$value="https://10.35.152.9/find/".$value;
			$display="<td><a href='$value' target='_blank'>$link_name</a></td>";
			}
		echo "$display";
		}
	echo "</tr>";
	}
echo "</table>";


if($level>6)
	{
	echo "<table align='center'><tr><td colspan='2'>Add a new link.</td></tr><tr>
	<tr><td></td><td>Title<br /><input type='text' name='new_title' value='' size='80'></td>
	<td>Link<br /><input type='text' name='new_link' value='' size='80'></td>
	</tr><tr><td></td><td><input type='submit' name='submit' value='Update'></form></td></tr>";
	}
	else
	{echo "</form>";}
	
if($_SESSION['work_comp']['level'] > 0)
	{	
	if($_SESSION['work_comp']['level'] > 4)
		{
		echo "<hr /><table align='center' cellpadding='5'><tr><th>Step 1 
		<form action='new_wc_request_1.php'>
		<input type='submit' name='submit' value='Submit a Request'>
		</form></th></tr>
		</table>";}
		else
		{
		echo "<hr /><table align='center' cellpadding='5'><tr><th>Step 1 
		<form action='new_wc_request_1.php'>
		<input type='submit' name='submit' value='Submit a Request'>
		</form></th></tr>
		</table>";
		}
	}

echo "</table>";
?>

<?php 
extract($_REQUEST);
ini_set('display_errors',1);
include("menu.php");

$database="phone_bill";
include("../../include/connectROOT.inc");// database connection parameters
  $db = mysql_select_db($database,$connection)
	   or die ("Couldn't select database");
   
if(@$submit=="Delete")
	{
	$clause="";
	$sql="DELETE from agreement_park  where id='".$_POST['id']."'"; 
	//echo "$sql"; exit;
	$result=mysql_query($sql);
	}
	
$skip=array("id","park_code","submit");	   
if(@$submit=="Save")
	{
	$clause="";
	$sql="update agreement_park set ";
//	echo "<pre>"; print_r($_POST); echo "</pre>";
	foreach($_POST AS $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		$clause.=$fld."='".$value."',";
		}
		$clause=rtrim($clause,",");
		$sql.=$clause." where id='".$_POST['id']."'"; //echo "$sql"; exit;
	$result=mysql_query($sql);
	}

$order_by="t1.park_code";
//if(@$sort=="park"){$order_by="t3.currPark,t2.Lname";}
$sql="SELECT  t1.*
from agreement_park as t1
order by $order_by";

$result=mysql_query($sql);
while($row=mysql_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
//	echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
$num=count($ARRAY);
echo "<form method='POST'>";
echo "<table border='1' cellpadding='5'><tr><th colspan='12'>
Electronic Device Employee Acknowledgement - <b>Park Assigned</b> - $num phones</th></tr>";

foreach($ARRAY as $index=>$array)	
	{
	echo "<tr>";
	if($index==0)
		{
		echo "<td> <a href='agreement_add.php'>Add</a> </td>";
		foreach($array as $col=>$value)
			{
			if($col=="tempID"){continue;}
			if($col=="currPark"){$col="<a href='agreement.php?sort=park'>$col</a>";}
			echo "<td>$col</td>";
			}
		echo "</tr>";
		}
	
	$line="<tr><td><a href='agreement_park.php?edit=$array[id]'>Edit</a></td>";
	foreach($array as $fld=>$value)
		{
		if($fld=="tempID"){continue;}
		if($fld=="file_link")
			{
				if(isset($array['park_code']))
					{
					$pc="&park_code=$array[park_code]";
					}
					else{$pc="";}
			if($value!="")
				{
				$line.="<td><a href='agreements/$value'>$value</a><br />";
				
				$line.="<a href='add_agreement_form.php?id=$array[id]$pc'>Upload</a></td>";
				}
				else
				{
				$line.="<td><a href='add_agreement_form.php?id=$array[id]$pc'>Upload</a></td>";
				}
			}
			else
			{
			if(isset($edit) and $array['id']==$edit and !in_array($fld,$skip))
				{
				$line.="<td><input type='text' name='$fld' value='$value'></td>";
				
				$save_link="<tr><td colspan='6' align='center'>
				<input type='hidden' name='id' value='$edit'>
				<input type='submit' name='submit' value='Save'>
				</td>
				<td align='center'><input type='submit' name='submit' value='Delete' onClick=\"return confirmLink()\"></td>
				</tr></form>";
				}
				else
				{
				$line.="<td>$value</td>";
				$save_link="";
				}
			}
		}
	$line.="</tr>";
	echo "$line";
	echo "$save_link";
	}
echo "</table>";
echo "</div></body></html>";


?>
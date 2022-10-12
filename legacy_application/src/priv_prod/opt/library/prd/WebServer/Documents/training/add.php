<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
ini_set('display_errors',1);
$database="training";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/connectROOT.inc");// database connection parameters
include("../../include/get_parkcodes.php");


include("/opt/library/prd/WebServer/Documents/_base_top.php");

if(@$_GET['del']==1)
	{
	$id=$_GET['id'];
	$sql="DELETE from vendors where id='$id'";
//	$result=mysql_query($sql) or die ("Couldn't execute query. $sql");
	echo "Vendor has been deleted.";
	exit;
	}

if($level>3)
	{
mysql_select_db('divper',$connection);
	$sql="SELECT concat(t1.Lname,', ',t1.Fname,' ',t1.Mname,'-',t2.currPark,'*',t1.emid) as name
	from empinfo as t1
	LEFT JOIN emplist as t2 on t1.emid=t2.emid
	where t2.currPark !=''
	order by t1.Lname, t1.Fname";
	$result=mysql_query($sql) or die ("Couldn't execute query. $sql");
	$source_name="";
	while($row=mysql_fetch_assoc($result))
		{
		$source_name.="\"".$row['name']."\",";
		}
	$source_name=rtrim($source_name,",");
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

mysql_select_db($database,$connection);
extract($_REQUEST);

echo "<table><tr><th colspan='5'><font color='gray'>Add / Update DPR Training</font></th></tr></table>";

// Classes
$sql="SELECT distinct title from class where 1 order by title";
$result=mysql_query($sql) or die ("Couldn't execute query. $sql");
	$source_title="";
while($row=mysql_fetch_assoc($result))
	{
	$source_title.="\"".$row['title']."\",";
	}
	$source_title=rtrim($source_title,",");
//echo "$source_title";  exit;


$fld_array=array("name","class","date_completed","comments");


$radio_array=array("nc_vendor");
$yes_no_array=array("Yes","No");

if(!isset($name)){$name="";}
echo "<form action='track.php' method='POST'><table>";

echo "<tr><td>name</td><td><input type='text' id=\"name\" name='name' value=\"$name\" size='44'></td>";

	echo "<td colspan='2' align='center'>
	<input type='submit' name='submit' value='Find'>
	</td></tr>";

echo "</table></form>";

echo "	<script>
		$(function()
			{
			$( \"#name\" ).autocomplete({
			source: [ $source_name]
				});
			});
		</script>

		<script>
		$(function()
			{
			$( \"#class\" ).autocomplete({
			source: [ $source_title ]
				});
			});
		</script>";
		
if(empty($name)){exit;}

$action_button="Update";
if(!empty($_REQUEST))
	{
	if(@$_REQUEST['submit']=="Add")
		{
	//	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; //exit;
		extract($_REQUEST);
		foreach($fld_array as $k=>$v)
			{
			if($v=="id"){continue;}
			$value=addslashes($$v);	
			$clause.=$v."='".$value."',";
			}
			$clause=rtrim($clause,",");
		$sql="INSERT into vendors SET $clause";
		$result=mysql_query($sql) or die ("Couldn't execute query. $sql");
		$id=mysql_insert_id();
		
		$sql="SELECT * from vendors where id='$id'"; 
		$result=mysql_query($sql) or die ("Couldn't execute query. $sql");
		if(mysql_num_rows($result)>0)
			{
			while($row=mysql_fetch_assoc($result))
				{
				$ARRAY[]=$row;
				}
			}
		$_REQUEST['edit']=1;
		$action_button="Update";
		}
	else
		{
		$clause="id='".$_REQUEST['id']."'";
		$sql="SELECT * from track where $clause ";
		$result=mysql_query($sql) or die ("Couldn't execute query. $sql");
		//echo "$sql";
		while($row=mysql_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
		}
	}

if(empty($ARRAY))
	{
	IF(!empty($_REQUEST))
		{
		echo "<font color='red'>Nothing found.</font> Select a vendor_name.";
		}
	exit;
	}
//echo $sql;


echo "<form action='update.php' method='POST'>";

// Display record to edit
if(@$_REQUEST['edit']==1)
	{
	echo "<hr /><table border='1' align='center' cellpadding='5'>";
	foreach($ARRAY as $index=>$array)
		{
		$id=$ARRAY[$index]['id'];
		
		foreach($array as $fld=>$value)
			{
			if($fld=="id"){continue;}
			$form_fld="<input type='text' name='$fld' value=\"$value\">";
				
			if($fld=="comments")
				{
				$form_fld="<textarea name='$fld' cols='90' rows='15'>$value</textarea>";
				}
				
			if($fld=="vendor_name")
				{
				if(!empty($alt_vendor_name)){$value=$alt_vendor_name;}
				$form_fld="<select name='$fld'><option selected=''></option>\n";
				foreach($vendor_array as $k=>$v)
					{
					if($v==$value){$s="selected";}else{$s="value";}
					$form_fld.="<option $s=\"$v\">$v</option>\n";
					}
				$form_fld.="</select>";
				}
				
			if($fld=="nc_vendor")
				{
				$nc_vendor_array=array("Yes","No");
				$form_fld="<select name='$fld'><option selected=''></option>\n";
				foreach($nc_vendor_array as $k=>$v)
					{
					if($v==$value){$s="selected";}else{$s="value";}
					$form_fld.="<option $s=\"$v\">$v</option>\n";
					}
				$form_fld.="</select>";
				}
			
			echo "<tr><td>$fld</td><td>$form_fld</td></tr>";
			}
		}
	echo "<tr><td colspan='10' align='center'>
	<input type='hidden' name='id' value='$id'>
	<input type='submit' name='submit' value='$action_button'></form>
	</td><td><a href='vendors.php?del=1&id=$id' onclick=\"return confirm('Are you sure you want this Document?')\">Delete</a></td></tr>";
	echo "</table>";
	exit;
	}

// Display search results
echo "<table border='1' align='center' cellpadding='5'>";
echo "<tr><td></td>";
foreach($ARRAY[0] as $k=>$v)
	{
	if($k=="id"){continue;}
	$k=str_replace("_"," ",$k);
	if($k=="rate product")
		{
		$k="$k<br /><font size='-2'>(1=poor...5=very good)</font>";
		}
	echo "<th>$k</th>";
	@$header.="<th>$k</th>";
	}
echo "</tr>";

foreach($ARRAY as $index=>$array)
	{
	$id=$ARRAY[$index]['id'];
	echo "<tr><td><a href='vendors.php?edit=1&id=$id'>edit</a></td>";
	foreach($array as $fld=>$value)
		{
		if($fld=="id"){continue;}
		if($fld=="vendor_website"){$value="<a href='$value' target='_blank'>$value</a>";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
//echo "<tr><td></td>$header</tr>";

echo "</table></form>";

?>
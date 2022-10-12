<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
$database="retail";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc");// database connection parameters
include("../../include/get_parkcodes_i.php");
$database="retail";
mysqli_select_db($connection,$database);

$title="Retail Sales";
include("/opt/library/prd/WebServer/Documents/_base_top.php");

echo "<table><tr><th colspan='5'><font color='gray'>DPR Items for Resale</font></th></tr></table>";

// Categories
$sql="SELECT * from category where 1 order by cat_name";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$cat_array[$row['id']]=$row['cat_name'];
	}

// items
$sql="SELECT vendor_name,id from vendors where 1 order by vendor_name";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$vendor_array[$row['id']]=$row['vendor_name'];
	}
//echo "<pre>"; print_r($vendor_array); echo "</pre>";

$sql="SHOW columns from items";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$fld_array[]=$row['Field'];
	}		
//if(empty($a)){exit;}
//echo "<pre>"; print_r($fld_array); echo "</pre>"; exit;
$radio_array=array("nc_vendor");
$yes_no_array=array("yes","no","-");

$skip=array("id");
echo "<form action='items.php' method='POST'><table>";
foreach($fld_array as $k=>$v)
	{
	if(in_array($v,$skip)){continue;}
	$show="<input type='text' name='$v'>";
	if($v=="category")
		{
		$show="<select name='$v'><option selected=''></option>\n";
		foreach($cat_array as $k1=>$v1)
			{
			$show.="<option value=\"$k1\">$v1</option>\n";
			}
		$show.="</select></td><td colspan='2'><font size='-2'>If a new category is needed, contact Tara.</font>";
		}
	if($v=="vendor_name")
		{
		$show="<select name='$v'><option selected=''></option>\n";
		foreach($vendor_array as $k1=>$v1)
			{
			if($v1==@$_REQUEST[$v])
				{$s="selected";}else{$s="value";}
			$show.="<option $s=\"$v1\">$v1</option>\n";
			}
		$show.="</select></td>";
		}
	if($v=="comments")
		{
		$show.="</td>
		<td><input type='submit' name='submit' value='Search'></td>
		<td><input type='submit' name='submit' value='Add'> <font size='-2'>Enter relevant info before clicking \"Add\".</font></td>";
		}
	echo "<tr><td>$v</td><td>$show</td></tr>";
	}
echo "</table></form>";

$action_button="Update";
if(!empty($_REQUEST))
	{
	if($_REQUEST['submit']=="Add")
		{
		extract($_REQUEST);
// 		echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
		foreach($fld_array as $k=>$v)
			{
			if($v=="id"){continue;}
			$value=$$v;	
			$clause.=$v."='".$value."',";
			}
			$clause=rtrim($clause,",");
		$sql="INSERT into items SET $clause";
// 		echo "$sql"; exit;
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$id=mysqli_insert_id();
		
		$sql="SELECT * from items where id='$id'"; 
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		if(mysqli_num_rows($result)>0)
			{
			while($row=mysqli_fetch_assoc($result))
				{
				$ARRAY[]=$row;
				}
			}
		$_REQUEST['edit']=1;
		$action_button="Update";
		}
	else
		{
		foreach($_REQUEST AS $fld=>$value)
			{
			if($fld=="submit" OR $fld=="edit" OR $fld=="u"){continue;}
			if(empty($value)){continue;}
			@$clause.=$fld." like '%".$value."%' AND ";
			}
		$clause=rtrim($clause," AND ");
		if(empty($clause))
			{
			echo "<font color='red'>Nothing entered.</font>";
			exit;
			}
		if(@$_REQUEST['u']==1)
			{
			echo "<font color='green'>Update successful.</font>";
			}
		$sql="SELECT * from items where $clause order by vendor_name";
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		while($row=mysqli_fetch_assoc($result))
			{
			$ARRAY[]=$row;
			}
		}
	}

if(empty($ARRAY))
	{
	IF(!empty($_REQUEST))
		{
		echo "<font color='red'>No item found.</font> Either perform a new search or add an item for a vendor.";
		}
	exit;
	}
//echo $sql;


echo "<form action='update_item.php' method='POST'>";

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
			if($fld=="rate_product")
				{
				$form_fld.=" (1=poor...5=very good)";
				}
				
			if($fld=="comments")
				{
				$form_fld="<textarea name='$fld' cols='70' rows='5'>$value</textarea>";
				}
				
			if($fld=="category")
				{
				$form_fld="<select name='$fld'><option selected=''></option>\n";
				foreach($cat_array as $k=>$v)
					{
					$var_v=$v;
					if($value==$k)
						{
						$s="selected";
						$var_v=$k."-".$v;
						}
						else
						{
						$s="value";
						$var_v=$k."-".$v;
						}
					$form_fld.="<option $s=\"$k\">$var_v</option>\n";
					}
				$form_fld.="</select>";
				}
				
			if($fld=="vendor_name")
				{
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
	<input type='submit' name='submit' value='$action_button'>
	</td></tr>";
	echo "</table></form>";
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
	echo "<tr><td><a href='items.php?edit=1&id=$id'>edit</a></td>";
	foreach($array as $fld=>$value)
		{
		if($fld=="id"){continue;}
		if($fld=="category"){$value=$cat_array[$value];}
		if($fld=="vendor_name")
			{
			$vendor_id=array_search($value,$vendor_array);
			$value="<a href='vendors.php?id=$vendor_id' target='_blank'>$value</a>";
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
//echo "<tr><td></td>$header</tr>";

echo "</table></form>";

?>
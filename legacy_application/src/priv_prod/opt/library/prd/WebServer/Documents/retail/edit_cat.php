<?php
//echo "<pre>"; print_r($_POST); echo "</pre>";

// Update Categories
if($_POST['submit']=="Update")
	{
	$skip=array("new","edit","submit");
	foreach($_POST as $id=>$value)
		{
		if(in_array($id,$skip)){continue;}
		if(!empty($value))
			{
// 			$value=addslashes($value);
			$sql="REPLACE category set id='$id', cat_name='$value'";
			$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
			}
		}
	if(!empty($_POST['new']))
		{
		$cat=$_POST['new'];
		$sql="INSERT category set cat_name='$cat'";
		$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		}
	}

// Get Categories
$sql="SELECT * from category where 1 order by cat_name";
$result=mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$cat_array[$row['id']]=$row['cat_name'];
	}

echo "<form action='admin.php' method='POST'><table>";

echo "<tr><th>Category</th><th>Change Category to:</th></tr>";
foreach($cat_array as $k=>$v)
	{
	$show="<input type='text' name='$k'>";
	
	echo "<tr><td>$v</td><td>$show</td></tr>";
	}
	
echo "<tr><td>Add a new category ==></td>
<td>
<input type='text' name='new' value=''>
</td></tr>";

echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='edit' value='cat'>
<input type='submit' name='submit' value='Update'>
</td></tr>";
echo "</table></form>";


?>
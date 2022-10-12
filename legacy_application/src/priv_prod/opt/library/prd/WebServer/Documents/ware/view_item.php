<?php
$database="ware";
include("../../include/auth.inc");
include("../../include/iConnect.inc");// database connection parameters
mysqli_select_db($connection, $database)
   or die ("Couldn't select database $database");

//echo "POST<pre>"; print_r($_POST); echo "</pre>";  //exit;
//echo "GET<pre>"; print_r($_GET); echo "</pre>";  //exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_SERVER); echo "</pre>";  exit;
extract($_REQUEST);

if(!is_numeric($product_number)){exit;}

$sql="SELECT t1.*, t2.link, t3.link as msds FROM base_inventory as t1
	left join photos as t2 on t2.product_number=t1.product_number
	left join msds as t3 on t3.product_number=t1.product_number
	where t1.product_number='$product_number'";
// 	echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
if(empty($ARRAY))
	{
	echo "<p>No item for product number $product_number was found. Notify Kelly Chandler of this issue. Thanks.</p><p><font color='red'>Clost tab/window when done.</font></p>";
	exit;
	}
$c=count($ARRAY);
$skip=array("id","sort_order","hide","material_safety_data_sheets","photo");
echo "<table><tr><td colspan='2'><font color='red'>Clost tab/window when done.</font></td></tr>";
foreach($ARRAY AS $index=>$array)
	{
	foreach($array as $fld=>$value)
		{
		IF(in_array($fld,$skip)){continue;}
	echo "<tr>";
	if(strpos($fld,"product_link")===0 and !empty($value))
		{$value="<a href='$value'>product link</a>";}
	if($fld=="see_also")
		{
		$temp=str_replace("Product# ","",$value);
		$temp=str_replace("Product # ","",$value);
		$temp=str_replace("Product#","",$temp);
		$temp=str_replace("Product #","",$temp);
		$temp=str_replace(" &  ",",",$temp);
		$temp=str_replace("& ",",",$temp);
		$temp=str_replace(" ","",$temp);
		$exp=explode(",",$temp);
		foreach($exp as $k=>$v)
			{
			@$var.="<a href='/ware/view_item.php?product_number=$v'>$v</a>&nbsp;&nbsp;";
			}
		$value=$var;
		}
	if($fld=="msds")
		{$fld="safety_data_sheets";
		$value="<a href='$value'>SDS</a>";}
	if($fld=="link")
		{
		$fld="photo";
		$value="<img src='$value' width='50%'>";}
		echo "<td>$fld</td><td>$value</td>";
	echo "</tr>";
		}
	}
echo "</table>";
?>
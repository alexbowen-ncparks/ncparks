<?php
	
$sql="SHOW COLUMNS from loss"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while ($row=mysqli_fetch_assoc($result))
	{
	$COLS[0][$row['Field']]="";
	@$col++;
	}
$sql="SELECT * from loss order by loss_id desc limit 1"; //echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	$limit=1;
	}


$like=array("product_title","product_description","comments");

	$sql="select distinct product_title from loss where 1 and product_title!='' order by product_title";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_array($result))
		{
		$product_title_array[]=$row['product_title'];
		}
		
$t1_flds="t1.*";


$like=array("loss_number","loss_by","receive_by","loss_comments");

// SEARCH **************************************
if((!empty($_POST) AND $_POST['submit']=="Search") )
	{
   	$skip=array("submit","op","sort","direction","pass_submit","pass_query","status");

//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
	
	$clause="";
	$op=@$_POST['op'];
	foreach($_POST as $fld=>$val)
		{
		if(in_array($fld, $skip)){continue;}
// 		$val=mysqli_real_escape_string($connection,$val);
		if(!empty($val))
			{
			if(in_array($fld, $like))
				{$clause.="t1.".$fld." like '%".$val."%' $op ";}
				else
				{$clause.="t1.".$fld."='".$val."' $op ";}			
			}
		}
	$clause=rtrim($clause, " $op ");
	if(!empty($clause)){$clause="and ".$clause;}
	if(!empty($_POST['status']))
		{
		if($_POST['status']=="receive"){$clause.=" and receive_date!='0000-00-00'";}
		if($_POST['status']=="not_receive"){$clause.=" and receive_date='0000-00-00'";}
		}
	if(!empty($_POST['sort']) or @$_REQUEST['rep']==1)
		{
		$clause=$_REQUEST['pass_query'];
		$sort_fld=@$_POST['submit'];
		$direction=@$_POST['direction'];
		if(empty($sort_fld))
			{
			$sort_fld="product_number";
			$direction="";
			}
		if($sort_fld=="user_name")
			{
			$sort_fld="substring_index(user_name,' ',-1)";
			}
		$order_by="order by $sort_fld $direction";
		}
		else
		{
		$order_by="";
		}
		
	// ************* Query ************
	
	$sql="select $t1_flds
	from loss as t1
	where 1 $clause $order_by"; 
	//echo "$sql<br /><br />c=$clause<br />";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
	unset($ARRAY);
	
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		$new_flds=array_keys($row);
		}
	
if(empty($ARRAY)){echo "No records found using $clause"; exit;}

	$COLS=$new_flds;
	//echo "<pre>"; print_r($COLS); echo "</pre>"; // exit;
	@$c=count($ARRAY);
	extract($_POST);
	$display_sql=str_replace("%","",$sql);
//	IF(empty($_REQUEST['rep'])){echo "$display_sql";}
	}
	
 mysqli_free_result($result);

$c=count($ARRAY);
echo "<table><tr><td colspan='3'>$c</td></tr></table>";

echo "<table border='1' cellpadding='3' align='center'><tr>";
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<form method='POST' action='loss.php'><tr>";
		foreach($array as $fld=>$val)
			{
			$size=12;
			$fld_name=$fld;
			$th="<th>";
			if(in_array($fld,$like)){$th="<th bgcolor='lightgreen'>";}
			if($fld=="loss_id")
				{
				$val="";
				$fld_name="id";
				$size=4;
				}
			

		$val=@$_POST[$fld];
		if(empty($val))
			{
			$val=@$query_val[$fld];
			$val=str_replace("%","",$val);
			}
	
		echo "$th $fld_name<input type='text' name='$fld' value=\"\" size='$size'></th>";
		}
		
		echo "</tr><tr><td colspan='3'>DPR Warehouse Losses: ";
	if(!empty($c))
		{
		$items="items";
		if($c==1){$items="item";}
		if($limit==1 and empty($_POST)){$items="most recent item";}
		echo "<font color='brown'>$c $items</font>";
		}
			
		echo "</td>
		<td colspan='5'>";
		if(@$op=="and" or empty($op))
			{$cka="checked";$cko="";}
			else
			{$cka="";$cko="checked";}
			if(!empty($_POST['pass_query']))
				{
				if(strpos($_POST['pass_query'],"OR")>0)
					{$cka="";$cko="checked";}
					else
					{$cka="checked";$cko="";}
				}
		
	//	echo "<input type='radio' name='op' value='and' $cka>AND
	//	<input type='radio' name='op' value='OR' $cko>OR";
	if(empty($clause)){$clause="";}
	$clause=str_replace("t1.","",$clause);
	$clause=str_replace("%","",$clause);
		echo "<input type='hidden' name='op' value='and'>";
		echo " &nbsp;<input type='submit' name='submit' value='Search'> $clause </td>
		";
		@$excel_query=urlencode($clause);
	
	//	echo "<td colspan='8'>Excel <a href=\"view_loss_form.php?rep=1&pass_query=$excel_query\">Export</a></td>";
		echo "</tr></form>";	
		
		}
		
		
// Display results
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if($fld=="loss_id")
			{$value="<a href='loss.php?loss_id=$value&submit=Edit Loss'>[&nbsp;$value&nbsp;]</a>";}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
echo "</body></html>";
?>
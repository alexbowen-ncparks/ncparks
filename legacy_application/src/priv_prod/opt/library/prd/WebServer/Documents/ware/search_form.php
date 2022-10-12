<?php
//echo "yes";
ini_set('display_errors',1);
//echo "<pre>"; print_r($COLS); echo "</pre>"; // exit;
	if(empty($COLS))
		{
		$flds_2=", t2.link as photo, t3.link as msds";
		$join_2="left join photos as t2 on t1.product_number=t2.product_number";
		$join_2.=" left join msds as t3 on t1.product_number=t3.product_number";
		$sql="select $t1_flds $flds_2
		from base_inventory as t1
		$join_2
		where 1 limit 1"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
		while($row=mysqli_fetch_assoc($result))
			{
			$new_flds=array_keys($row);
			}
		$COLS=$new_flds;
		}
	if(@$_GET['act']=="edit")
		{
		$COLS=array("product_number","product_title","product_description","item_group");
		}
	$skip_these=array("sort_order");
	echo "<form method='POST' action='base_inventory.php'><tr>";
	foreach($COLS AS $index=>$fld)
		{  // search fields
		if(in_array($fld,$skip_these)){continue;}
		if($fld=="item_group")
			{
			echo "<th bgcolor='aliceblue'>$fld<select name='$fld'><option value=\"\" selected></option>\n";
			foreach($item_group_array as $k=>$v)
				{
				if(@$_POST[$fld]==$v){$s="selected";}else{$s="";}
				echo "<option value=\"$v\" $s>$v</option>\n";
				}
			
			echo "</select></th>";
			continue;
			}
		if($fld=="sub_group_1")
			{
			echo "<th bgcolor='aliceblue'>$fld<select name='$fld'><option value=\"\" selected></option>\n";
			foreach($sub_group_1_array as $k=>$v)
				{
				if(@$_POST[$fld]==$v){$s="selected";}else{$s="";}
				echo "<option value=\"$v\" $s>$v</option>\n";
				}
			
			echo "</select></th>";
			continue;
			}
		if($fld=="sub_group_2")
			{
			echo "<th bgcolor='aliceblue'>$fld<select name='$fld'><option value=\"\" selected></option>\n";
			foreach($sub_group_2_array as $k=>$v)
				{
				if(@$_POST[$fld]==$v){$s="selected";}else{$s="";}
				echo "<option value=\"$v\" $s>$v</option>\n";
				}
			
			echo "</select></th>";
			continue;
			}
		if($fld=="sold_by_unit")
			{
			echo "<th>$fld<select name='$fld'><option value=\"\" selected></option>\n";
			foreach($sold_by_array as $k=>$v)
				{
				echo "<option value=\"$v\">$v</option>\n";
				}
			
			echo "</select></th>";
			continue;
			}
		if(array_key_exists($fld, $size_array))
			{$size=$size_array[$fld];}
			else
			{$size='12';}
		$val=@$_POST[$fld];
		if(empty($val))
			{
			$val=@$query_val[$fld];
			$val=str_replace("%","",$val);
			}
	
			$th="<th>$fld<br />";
			if(in_array($fld,$like)){$th="<th bgcolor='lightgreen'>$fld";}
			if($fld=="id"){$val="";}
		echo "$th<input type='text' name='$fld' value=\"$val\" size='$size'></th>";
		}

	echo "<tr><td colspan='5'>DPR Warehouse Inventory ";
		if(!empty($c))
			{
			if(empty($clause))
				{echo "<br /><font color='brown'>Only first $c items shown. Select an \"item_group\" from drop-down.</font>";}
				else
				{
				
				if($cart_level>0)
					{
					echo "<font color='brown'>$c items</font><br />Enter a number greater than 0 in the Number box and click the button at bottom of form.";
					}
					
				}
			}
			
		echo "</td>
		<td colspan='5' align='center'>";
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
		
		echo "<input type='radio' name='op' value='and' $cka>AND
		<input type='radio' name='op' value='OR' $cko>OR";
		
		if(!empty($_REQUEST['act']))
			{echo "<input type='hidden' name='act' value='edit'> ";}
		echo " &nbsp;<input type='submit' name='submit' value='Search'>";
		
		if(!empty($_REQUEST['park_code']))
			{echo "<input type='hidden' name='park_code' value='$_REQUEST[park_code]'> ";}
		if(!empty($_REQUEST['rcc']))
			{echo "<input type='hidden' name='rcc' value='$_REQUEST[rcc]'> ";}
		
		echo "<input type='submit' name='submit' value='Reset'></td>
		";
		@$excel_query=urlencode($clause);
	//	echo "<td colspan='1'><a href='add_it.php'>Add</a></td>";
		echo "<td colspan='8'>Excel <a href=\"base_inventory.php?rep=1&pass_query=$excel_query\">Export</a></td>";
		echo "</tr></form>";	

	 // Headers
	$rename=array();

	if(empty($sort_fld_array)){$sort_fld_array=array();}
	if(empty($skip_these)){$skip_these=array("sort_order");}
	echo "<tr>";
	foreach($COLS as $index=>$fld)
		{
		if(in_array($fld,$skip_these)){continue;}
		if(!empty($rep) and in_array($fld,$skip_excel)){continue;}
		$pass_sort=$fld;
		if(array_key_exists($fld,$rename)){$fld=$rename[$fld];}
		if(!in_array($pass_sort,$sort_fld_array))
			{
			if(empty($rep) and !empty($_POST))
				{
				$temp="\n<form method='POST'>";
				if(!empty($pass_criteria))
					{
					foreach($pass_criteria as $k=>$v)
						{
						if(is_array($v))
							{
							foreach($v as $k1=>$v1)
								{
								$name=$k."[]";
								$temp.="<input type='hidden' name='$name' value=\"$v1\">";
								}
							}
							else
							{$temp.="<input type='hidden' name='$k' value=\"$v\">";}
				
						}
					}
				if(empty($direction) OR $direction=="DESC")
					{
					$direct="ASC";
					$tab_color="#407340";
					}
					else
					{
					$direct="DESC";
					$tab_color="#007A99";
					}
				if(!isset($clause)){$clause="";}
				$temp.="<input type='hidden' name='sort' value='$pass_sort'>
				<input type='hidden' name='direction' value='$direct'>
				<input type='hidden' name='pass_query' value=\"$clause\">
				<input type='hidden' name='pass_submit' value='Find'>
				<input type='submit' name='submit' value='$fld' style=\"background:$tab_color; color: #FFFFFF;\">
				</form>\n";
				@$header_row.="<th bgcolor='beige' align='center'>$fld</th>";
				$fld=$temp;
				}
				else
				{
				// excel export 
				}
			}
		
		echo "<th bgcolor='beige' align='center'>$fld</th>";
		}
	echo "</tr>";


	if(!empty($_GET['product_number']))
		{
		$product_number=@$_GET['product_number'];
		$sql="select id from base_inventory where product_number='$product_number'"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
		$row=mysqli_fetch_assoc($result);
		$_GET['id']=$row['id'];
		}
	
	if(!empty($_GET['id']))
		{
		$id=@$_GET['id'];
		$size_array['see_also']="15";
		$size_array['product_title']="45";
		$size_array['sustainable_recycled']="70";
		$size_array['product_description']="170";
		$size_array['product_link_1']="170";
		$size_array['product_link_2']="170";
		$size_array['material_safety_data_sheets']="170";
		
		$link_flds=array("product_link_1","product_link_2");
		$readonly=array("id");
		$sql="select t1.*, group_concat(distinct concat(t2.photo_id,'*',t2.link)) as link, group_concat(distinct concat(t3.msds_id,'*',t3.link)) as msds  
		from base_inventory as t1
		left join photos as t2 on t1.product_number=t2.product_number
		left join msds as t3 on t1.product_number=t3.product_number
		where id='$id'
		group by t1.product_number"; //echo "$sql";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql ".mysqli_error($connection));
		$row=mysqli_fetch_assoc($result);
// 		echo "<pre>"; print_r($row); echo "</pre>"; // exit;
		
	if($temp_level>$edit_level)
		{
		echo "<form method='POST' action='base_inventory.php' enctype='multipart/form-data'>";
		$temp_hide=array();
		}
		else
		{$temp_hide=array("hide");}
		echo "</table><table>";
		foreach($row as $fld=>$val)
			{
			$var_fld=$fld;
			if(in_array($fld, $temp_hide)){continue;}
			if(in_array($fld, $link_flds) and !empty($val))
				{
				if($temp_level>$edit_level)
					{
					$var_fld="<a href='$val' target='_blank'>$fld</a>";
					}
					else
					{
					$var_fld="<a href='$val' target='_blank'>$fld</a>";
					$val="";
					}
				}
			if(($fld=="see_also") and !empty($val))
				{
				$exp=explode(" ",$val);
				$val_link="base_inventory.php?product_number=$exp[1]";
				$var_fld="<a href='$val_link' target='_blank'>$fld</a>";
				}
			if($fld=="link")
				{
				if( empty($val)){continue;}
				$var_fld="";
				}
			if($fld=="msds")
				{
				if( empty($val)){continue;}
				$var_fld="Material Safety Data Sheet";
				}
				
			echo "<tr><td><b>$var_fld</b></td>";
			if($fld=="item_group")
				{
				if($temp_level>$edit_level)
					{
					echo "<td><select name='$fld'><option value=\"\" selected></option>\n";
					foreach($item_group_array as $k=>$v)
						{
						if($val==$v){$s="selected";}else{$s="";}
						echo "<option value=\"$v\" $s>$v</option>\n";
						}
					echo "</select></td>";
					}
					else
					{echo "<td>$val</td>";}
				continue;
				}	
			if($fld=="sub_group_1")
				{
				if($temp_level>$edit_level)
					{
					echo "<td><select name='$fld'><option value=\"\" selected></option>\n";
					foreach($sub_group_1_array as $k=>$v)
						{
						if($val==$v){$s="selected";}else{$s="";}
						echo "<option value=\"$v\" $s>$v</option>\n";
						}
					echo "</select></td>";
					}
					else
					{echo "<td>$val</td>";}
				continue;
				}	
			if($fld=="sub_group_2")
				{
				if($temp_level>$edit_level)
					{
					echo "<td><select name='$fld'><option value=\"\" selected></option>\n";
					foreach($sub_group_2_array as $k=>$v)
						{
						if($val==$v){$s="selected";}else{$s="";}
						echo "<option value=\"$v\" $s>$v</option>\n";
						}
					echo "</select></td>";
					}
					else
					{echo "<td>$val</td>";}
				continue;
				}	
			
			if($fld=="sold_by_unit")
				{
				if($temp_level>$edit_level)
					{
					echo "<td><select name='$fld'><option value=\"\" selected></option>\n";
					foreach($sold_by_array as $k=>$v)
						{
						if($val==$v){$s="selected";}else{$s="";}
						echo "<option value=\"$v\" $s>$v</option>\n";
						}
					echo "</select></td>";
					}
					else
					{echo "<td>$val</td>";}
				continue;
				}
				
			if($fld=="comments")
				{
				if($temp_level>$edit_level)
					{
					echo "<td><textarea name='$fld' cols='80' rows='3'>$val</textarea></td>";
					}
					else
					{echo "<td>$val</td>";}
				continue;
				}
				
			if($fld=="photo")
				{
				if($temp_level>$edit_level)
					{
					echo "<td><input type='file' name='files[]'></td>";
					continue;
					}
				}
				
			if($fld=="material_safety_data_sheets")
				{
				if($temp_level>$edit_level)
					{
					echo "<td><input type='file' name='msds[]'></td>";
					continue;
					}
				}
				
			if($fld=="hide")
				{
				if($temp_level>$edit_level)
					{
					$val!=''?$ck="checked":$ck="";
					echo "<td><input type='checkbox' name='$fld' value=\"x\" $ck> Check to hide from field staff.</td>";
					continue;
					}
				}
				
			if($fld=="link")
				{
				echo "<td><table><tr>";
				$exp1=explode(",",$val);
				foreach($exp1 as $k=>$v)
					{
					$exp2=explode("/",$v);
					$tn="http://www.dpr.ncparks.gov/ware/photos/ztn_".$exp2[1];
					$exp3=explode("*",$exp2[0]);   // group concated on line 429
					$pid=$exp3[0];
					$img="http://www.dpr.ncparks.gov/ware/photos/".$exp2[1];
					echo "<td><a href='$img' target='_blank'><img src='$tn' style=\"vertical-align: top;\"></a>";
					if($temp_level>$edit_level)
						{echo "<br /><a href='ware_photo.php?id=$id&pid=$pid&del=Delete' onclick=\"return confirm('Are you sure you want to delete this Photo?')\">delete</a></td>";}
					}
				echo "</tr></table></td>";
				continue;
				}
			if($fld=="msds")
				{
				echo "<td><table><tr>";
				$exp1=explode(",",$val);
				foreach($exp1 as $k=>$v)
					{
					$exp2=explode("/",$v);
			//		$tn="msds/ztn_".$exp2[1];
					$exp3=explode("*",$exp2[0]);   // group concated on line 429
					$msds_id=$exp3[0];
					$img="msds/".$exp2[1];
					echo "<td><a href='$img' target='_blank'>Material Safety Data Sheet</a>";
					if($temp_level>$edit_level)
						{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='msds_file.php?id=$id&msds_id=$msds_id&del=Delete' onclick=\"return confirm('Are you sure you want to delete this MSDS?')\">delete</a></td>";}
					}
				echo "</tr></table></td>";
				continue;
				}
			if(array_key_exists($fld, $size_array))
				{$size=$size_array[$fld];}
				else
				{$size='12';}
				
				
			if(in_array($fld, $readonly)){$ro="readonly";}else{$ro="";}
			if($fld=="entered_service"){$elem_id="datepicker1";}else{$elem_id=$fld;}
			 $cart="";
			 $sbu="";
			if($fld=="current_cost")
				{
				include("park_order_form.php");
				}
				else
				{$cc="";}
				
			if($temp_level>$edit_level)
				{
				$val=htmlspecialchars($val);
				echo "<td>$cc<input id=\"$elem_id\" type='text' name='$fld' value=\"$val\" size='$size' $ro></td>";}
				else
				{echo "<td colspan='4'>$cc$val &nbsp; $cart</td>";}
			
		echo "</tr>";
			}
		if($temp_level>$edit_level)
			{
			echo "<tr><td colspan='14' align='center'>
			<input type='submit' name='update' value='Update'>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type='submit' name='submit' value='Delete' onclick=\"return confirm('Are you sure you want to delete this Item?')\"></td></tr>";
			echo "</form>";
			}	
		}
	

?>
<?php
if(empty($rep))
	{
	echo "
	<script>
	function item_tot_id(cost,index)
		{
		var number = \"\";
		var lol = document.getElementsByTagName('input');
		for( var x = 0; x < lol.length; x++ )
			{
			var number = document.getElementById(\"quantity_\" + x).value;
			var str_rep=number.replace(/,/, \"\");  // remove any commas
			var tot=(cost*str_rep).toFixed(2);
			if(x==index)
				{
				document.getElementById(\"total_cost_id_\" + x).value=tot;
				}
			}
		}
	</script>
	";
	}
// $ARRAY created in search_query.php - line 93

//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;
if(empty($skip_these)){$skip_these=array("sort_order","material_safety_data_sheets");}
if(!empty($rep))
	{
	date_default_timezone_set('America/New_York');
 	$filename="warehouse_inventory_".date("Y-m-d").".xls";
 	header('Content-Type: application/vnd.ms-excel');
 	header("Content-Disposition: attachment; filename=$filename");
	}
	else
	{
	echo "<form method='POST' name='search_result' action='base_inventory.php'>";
	}
if(!empty($rep))
	{echo "<table border='1'>";}

foreach($ARRAY AS $index=>$array)
		{
		if(fmod($index,10)==0 and $index>0 and empty($rep)){echo "<tr>$header_row</tr>";}

		echo "<tr>";
		foreach($array as $fld=>$value)
			{
		$td="";
			if(in_array($fld,$skip_these)){continue;}
			
			if($fld=="product_number" and empty($_REQUEST['rep']))
				{
				$prod_num=$value;
				$cost=$array['current_cost'];
				$id=$array['id'];
				$ref="id=$id&park_code=$temp_parkCode";
				if(!empty($_REQUEST['act']))
					{$ref.="&act=edit";}
		//		$cost=$array['current_cost'];
				if($cart_level>0)
					{
					$value="<a href='view_item.php?product_number=$prod_num' target='_blank'>$value</a>";
					$value.="<br />$$cost/".$array['sold_by_unit'];
					$name="quantity_".$index;
					$value.="<br /><font color='brown'>Number:</font> 
					<input type='hidden' name='cost[]' value='$cost'>
					<input type='hidden' name='prod_num[]' value='$prod_num'>
					<input type='text' id='$name' name='$name' value=\"\" size='3' onchange=\"item_tot_id($cost,$index);\">";
					$name1="total_cost_id_".$index;
					$value.="<br />Total <input type='text' id='$name1' name='$name1' value=\"\" size='8' readonly>";
					}
				}
				
			if($fld=="photo")
				{
				if(!empty($value))
					{
// 					echo "$value<br />"; //exit;
					$exp1=explode(",",$value);
					$temp="";
					foreach($exp1 as $k=>$v)
						{
						$exp2=explode("/",$v);
						$tn="https://10.35.152.9/ware/photos/ztn_".$exp2[1];
						$tn="https://10.35.152.9/ware/photos/ztn_".$exp2[1];
						$exp3=explode("*",$exp2[0]);
						$pid=$exp3[0];
						$img="https://10.35.152.9/ware/photos/".$exp2[1];
						$img="https://10.35.152.9/ware/photos/".$exp2[1];
						
						$temp.="<a href='$img' target='_blank'>
						<img src='$tn' style=\"vertical-align: top;\"></a>";
						}
					$value=$temp;
					}
					else
					{
					$td=" align='center'";
					$value="--";
					}
				}
				
			if($fld=="msds")
				{
				if(!empty($value))
					{
				//	echo "$value"; exit;
					$exp1=explode(",",$value);
					$temp="";
					foreach($exp1 as $k=>$v)
						{
						$exp2=explode("/",$v);
// 						$tn="msds/ztn_".$exp2[1];
						$exp3=explode("*",$exp2[0]);
						$msds_id=$exp3[0];
						$img="msds/".$exp2[1];
						
						$temp.="<a href='$img' target='_blank'>MSDS</a>";
						}
					$value=$temp;
					}
					else
					{
					$td=" align='center'";
					$value="--";
					}
				}
			if($fld=="product_link_1" or $fld=="product_link_2")
				{
				if(!empty($value))
					{$value="<a href='$value' target='_blank'>link</a>";}
				}
			if($fld=="material_safety_data_sheets")
				{
				if(!empty($value))
					{
					$value="<a href='$value' target='_blank'>MSDS</a>";
					}
				}
				
			if($fld=="see_also")
				{
				if(!empty($value))
					{
					$temp=str_replace("Product# ","",$value);
					$temp=str_replace("Product # ","",$value);
					$temp=str_replace("Product#","",$temp);
					$temp=str_replace("Product #","",$temp);
					$temp=str_replace(" &  ",",",$temp);
					$temp=str_replace("& ",",",$temp);
					$temp=str_replace(" ","",$temp);
					$exp=explode(",",$temp);
					$var="";
					foreach($exp as $k=>$v)
						{
						$var.="<a href='https://10.35.152.9/ware/view_item.php?product_number=$v' target='_blank'>$v</a><br /><br />";
						$var.="<a href='https://10.35.152.9/ware/view_item.php?product_number=$v' target='_blank'>$v</a><br /><br />";
						}
					$value=$var;
					}
				}
			echo "<td$td>$value</td>";
			}
		echo "</tr>";
		}
		if($cart_level>0 and empty($rep))
			{
			echo "<tr><td colspan='10' align='center'>
			<input type='hidden' name='park_code' value=\"$temp_parkCode\">
			<input type='submit' name='cart_items' value=\"Place the Indicated Items in Your Cart\">
			</td></tr>";
			}
	
	echo "</table></form></body></html>";
?>
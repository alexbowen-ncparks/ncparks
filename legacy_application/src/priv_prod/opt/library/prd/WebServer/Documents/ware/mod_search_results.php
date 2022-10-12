<script>
function item_tot_id(cost,index)
	{
	var number = "";
	var lol = document.getElementsByTagName('input');
	for( var x = 0; x < lol.length; x++ )
		{
		var number = document.getElementById("quantity_" + x).value;
		var str_rep=number.replace(/,/, "");  // remove any commas
		var tot=(cost*str_rep).toFixed(2);
		if(x==index)
			{
			document.getElementById("total_cost_id_" + x).value=tot;
			}
		}
	}
</script>
<?php
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
//echo "<pre>"; print_r($skip_these); echo "</pre>"; // exit;
$skip_these[]="sort_order";
echo "<form method='POST' name='search_result' action='base_inventory.php'>";
foreach($ARRAY AS $index=>$array)
		{
		if(fmod($index,10)==0 and $index>0){echo "<tr>$header_row</tr>";}

		echo "<tr>";
		foreach($array as $fld=>$value)
			{
		$td="";
			if(in_array($fld,$skip_these)){continue;}
			
			if($fld=="product_number" and empty($_REQUEST['rep']))
				{
				$id=$array['id'];
				$ref="id=$id";
				if(!empty($_REQUEST['act']))
					{$ref.="&act=edit";}
				$value="<a href='base_inventory.php?$ref'>$value</a>";
				$value.="<br /><font size='-1'>".$ARRAY[$index]['sort_order']."</font>";
				}
				
			if($fld=="photo")
				{
				if(!empty($value))
					{
					
					$exp1=explode(",",$value);
					$temp="";
					foreach($exp1 as $k=>$v)
						{
						$exp2=explode("/",$v);
						$tn="photos/ztn_".$exp2[1];
						$exp3=explode("*",$exp2[0]);
						$pid=$exp3[0];
						$img="photos/".$exp2[1];
						
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
			echo "<td$td>$value</td>";
			}
		echo "</tr>";
		}
	/*
	echo "<tr><td colspan='10' align='center'>
	<input type='hidden' name='park_code' value=\"$temp_parkCode\">
	<input type='submit' name='cart_items' value=\"Place the Indicated Items in Your Cart\">
	</td></tr>";
	*/
	echo "</table></form></body></html>";
?>
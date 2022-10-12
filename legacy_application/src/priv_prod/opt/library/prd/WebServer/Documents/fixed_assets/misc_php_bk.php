<?php
// ***************** Misc. (not on FAS inventory) ***********************
echo "<table cellpadding='5' align='center'>";
echo "<tr><td><a onclick=\"toggleDisplay('systemalert');\" href=\"javascript:void('')\">

       Misc. items not on $center_code FAS inventory</a>

      <div id=\"systemalert\" style=\"display: none\">

      <table border='1'>";
      echo "<tr><th>Misc.</th>";
      foreach($field_forms as $header1=>$header2)
	{
	if($header1=="id"){continue;}
	if($header1=="source"){continue;}
	echo "<th>$header1</th>";
	}
	echo "</tr>";
//      echo "<pre>"; print_r($location); echo "</pre>"; // exit;
      for($j=1; $j<6; $j++)
      	{
      	echo "<tr>";
      	echo "<td align='right'>$j <input type='hidden' name='misc[$j]' value='misc'></td>";
      	foreach($field_forms as $header1=>$header2)
		{
		if($header1=="id"){continue;}
		if($header1=="source"){continue;}
		$value="";
		if($header1=="fas_num"){$value="NA";}
		if($header1=="location")
			{
			if(is_array($location))
				{$value=$location['misc'][$j];}
				else
				{$value=$location;}
			
			}
		$fld_name=$header1."[misc][$j]";
		
		$line="<td><input type='text' name='$fld_name' value=\"$value\" size='$header2'></td>";
		if($header1=="comments")
			{
			$line="<td><textarea name='$fld_name' cols='30' rows='2'></textarea></td>";
			}
		if($header1=="condition")
			{
			echo "<td><select name='$fld_name'><option value='' selected></option>\n";
			foreach($condition_array as $k=>$v)
				{
				if($value==$v){$s="selected";}else{$s="";}
				echo "<option value='$v' $s>$v</option>\n";
				}
			echo "</select></td>";
			}
			else
			{echo "$line";}
		
		}
      	echo "</tr>";
      	}
      
      echo "</table>
     
         </div></td></tr>";

echo "</table>";
?>
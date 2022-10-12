BE VERY CAREFULL TO CHANGE THE TABLE FROM swim_line to whatever
do a search to to find swim

Add year to table

backup these:
buoy
contacts
piers
ramp
seawall
swim_line

************** ramp.php, buoy.php ****************
line 11
if($year==""){$current_year=date('Y');}else{$current_year=$year;}


line 26
$sql="SELECT distinct YEAR from swim_line";
 $result = @MYSQL_QUERY($sql,$connection);
while($row=mysql_fetch_assoc($result))
		{
		$year_array[]=$row['YEAR'];
		}

$this_year=date('Y');
$next_year=date('Y')+1;
if(!in_array($next_year,$year_array))
	{
	$sql="SELECT swim_line_id as id, park, contacts_id, pier_number FROM  swim_line where year='$this_year'";
 	$result = @MYSQL_QUERY($sql,$connection);
	while($row=mysql_fetch_assoc($result))
		{
			$add_records[]=$row;
		}
	foreach($add_records as $k=>$array)
		{
		extract($array);
		$sql="INSERT into swim_line set park='$park', year='$next_year', contacts_id='$contacts_id', pier_number='$pier_number',fee='30.00'";
		@MYSQL_QUERY($sql,$connection);
		}
	}
//echo "<pre>"; print_r($add_records); echo "</pre>"; //exit;


line 58
$pull_down=array("year");

line 91
				if(in_array($v,$pull_down))
					{
					$arr=${$v."_array"};
					$v1="<select name='$v'><option selected=''></option>";
					foreach($arr as $k2=>$v2)
						{
						if($current_year==$v2){$s="selected";}else{$s="";}
						$v1.="<option $s='$v2'>$v2</option>";
						}
					$v1.="</select>";
					}
					
line 114
echo "<td align='center' colspan='6' align='center'>
			<table><tr><td><input type='submit' name='submit' value='Find'></td></form><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
			
		
			echo "<form action='add_swim_line.php' method='POST' target='_blank'><td align='center'><input type='submit' name='submit' value='Add'></td></tr></table></td>";
	echo "</tr></table></form></div>";	

line 175
add t1.year,   to $field_list


************** edit_ramp.php, edit_buoy.php ****************
line 51
t1.park,t1.year,t1.swim_line_id,

line 98
$readonly=array("swim_line_id","park","contacts_id","year");


***************** add_seawall.php, etc. *****************
line 72
$fld_name=$fld;
	if($fld=="year")
		{
		$fld_name="<font color='red'>$fld</font>";
		$value=date('Y');
		}
		else
		{$value="";}











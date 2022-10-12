<?php
/*
//  WHERE position.posTitle='Park Ranger' OR position.posTitle='Park Superintendent'
$sql = "SELECT emplist.tempID
FROM  emplist
LEFT  JOIN position ON emplist.beacon_num = position.beacon_num
WHERE 1
ORDER  BY emplist.tempID"; //echo "$sql<br />";
$result = mysqli_query($sql) or die ("Couldn't execute query. $sql");

while($row=mysqli_fetch_assoc($result)){$ARRAY[$row['tempID'][0]]=1;}
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

echo "<hr /><table><tr><td>";
foreach($ARRAY as $k=>$v)
	{
	echo " <a href='lead_rangers.php?fi=$k'>[ $k ]</a>&nbsp;&nbsp;";
	}
echo "</td</tr></table><hr />";
*/
extract($_REQUEST);
if(@$_REQUEST['fi']!="" OR @$_REQUEST['tempID']!="")
	{
	if(@$_REQUEST['fi']!="")
		{
		$sql = "SELECT emplist.currPark, empinfo.Nname, empinfo.Fname, empinfo.Lname, empinfo.emid, empinfo.tempID, position.posTitle, emplist.lead_for
		FROM empinfo
		LEFT  JOIN emplist ON emplist.emid = empinfo.emid
		LEFT  JOIN position ON emplist.beacon_num = position.beacon_num
		WHERE  left(empinfo.Lname,1)='$fi' and emplist.currPark!='' 
		ORDER  BY currPark"; //echo "$sql";
		// and (position.posTitle='Park Ranger' OR position.posTitle='Park Superintendent' or position.working_title='Maintenance Mechanic' or position.beacon_title='Maintenance Mechanic V')
		}
	if(@$_REQUEST['tempID']!="")
		{
		$sql = "SELECT emplist.currPark, empinfo.Nname, empinfo.Fname, empinfo.Lname, empinfo.emid, empinfo.tempID, position.posTitle, emplist.lead_for
		FROM empinfo
		LEFT  JOIN emplist ON emplist.emid = empinfo.emid
		LEFT  JOIN position ON emplist.beacon_num = position.beacon_num
		WHERE  empinfo.tempID='$tempID' and emplist.currPark!=''
		ORDER  BY currPark"; //echo "$sql";
		}
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	
	while($row=mysqli_fetch_assoc($result))
		{
		$names[]=$row;
		}
	//echo "<pre>"; print_r($names); echo "</pre>"; // exit;
	$num=count($names);
	$skip=array("tempID","emid");
	echo "<form action='lead_rangers.php' method='POST'><table border='1' cellpadding='5'>";
	// Header
			echo "<tr><th>$num</th>";
	foreach($names[0] as $fld=>$val)
		{
		if(in_array($fld,$skip)){continue;}
		echo "<th>$fld</th>";
		}
		echo "</tr>";
	foreach($names as $number=>$fields)
		{
		$tempID=$names[$number]['tempID'];
		if($num==1){$ck="checked";}else{$ck="";}
		echo "<tr>";
		if($level>6)
			{echo "<td>
		<input type='checkbox' name='tempID[]' value='$tempID' $ck>
		</td>";}
			else
			{echo "<td><input type='hidden' name='tempID[]' value='$tempID' $ck></td>";}
		foreach($fields as $fld_name=>$value)
			{
			if(in_array($fld_name,$skip)){continue;}
			if($fld_name=="Lname")
				{
				$tempID=$names[$number]['tempID'];
				$value="<a href='lead_rangers.php?tempID=$tempID'>$value</a>";
				}
					echo "<td>$value</td>";
			}
		echo "</tr>";
		}
	
	if($num==1)
		{
		$exp=explode(",",$names[0]['lead_for']);
			echo "</table><table><tr><td>";
			in_array("ie",$exp)?$ck1="checked":$ck1="";;
			in_array("le",$exp)?$ck2="checked":$ck2="";;
			in_array("sa",$exp)?$ck3="checked":$ck3="";;
			in_array("nr",$exp)?$ck4="checked":$ck4="";;
			in_array("vc",$exp)?$ck5="checked":$ck5="";;
			in_array("cc",$exp)?$ck6="checked":$ck6="";;
			in_array("ph",$exp)?$ck7="checked":$ck7="";;
	echo "<input type='checkbox' name='var[]' value='ie' $ck1>Interpretation & Education</td><td>";
	echo "<input type='checkbox' name='var[]' value='le' $ck2>Law Enforcement</td><td>";
	echo "<input type='checkbox' name='var[]' value='sa' $ck3>Safety Officer</td><td>";
	echo "<input type='checkbox' name='var[]' value='nr' $ck4>Natural Resoruce</td><td>";
	echo "<input type='checkbox' name='var[]' value='vc' $ck5>Volunteer Coordinator</td><td>";
	echo "<input type='checkbox' name='var[]' value='cc' $ck6>Centennial Coordinator</td><td>";
	echo "<input type='checkbox' name='var[]' value='ph' $ck7>Park Historian</td><td>";
	echo "<input type='checkbox' name='var[]' value='x'>none</td>
	</tr>";
		}		
			
			echo "<tr><td colspan='6' align='center'>
			<input type='submit' name='submit' value='Update'></td></tr></form>";
		echo "</table>";
		}
exit;

?>
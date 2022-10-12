<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";

//echo "<pre>"; print_r($ARRAY); echo "</pre>";	
if(@$submit=="Find")
	{
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";
	$search_these=array("applicant","region","county","milestone","milestonestatus");
	$where="where 1 and (";
	foreach($_POST AS $fld=>$value)
		{
		if(!in_array($fld,$search_these) OR $value==""){continue;}
		$where.=$fld." like '%".$_POST[$fld]."%' AND ";
		}
	$where=rtrim($where," AND ").") ";
	
	if($where=="where 1 and () "){$where="where 1 ";}
	

	$sql="SELECT *
	from inspections
	$where order by applicant, region, county"; //echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("<br />Couldn't execute query. $sql<br /><br />$where");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	IF(!empty($ARRAY)>0)
		{
		$num=count($ARRAY);
		$where=str_replace("%","",$where);
		echo "<div align='center'>$num Inspections(s) found using <font color='blue'>$where</font></div>";
		$display_search="block";
		}
		else
		{
		$where=str_replace("%","",$where);
		echo "<div align='center'>No file found using <font color='red'>$where</font></div>";
		$display_search="block";
		}
	}
	
if(@$submit=="Show All")
	{
	$sql="SELECT *
	from inspections
	where 1
	order by applicant, region, county"; //echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql<br /><br />$where");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	IF(!empty($ARRAY)>0)
		{
		$num=count($ARRAY);
		echo "<div align='center'>$num inspections found.</div>";
		$display_search="block";
		}
	}


//echo "<pre>";print_r($ARRAY); echo "</pre>$sql"; //exit;


//if(@$level<3){$skip=array("id","grant_status");}else{$skip=array();}

if((@$submit=="Find" OR @$submit=="Show All") AND !empty($ARRAY))
		{
	echo "<div align='center'><table border='1' cellpadding='5'>";
	echo "<tr>";
	foreach($ARRAY[0] AS $fld=>$val)
		{
	//	if(in_array($fld,$skip)){continue;}
		$fld=strtoupper(str_replace("_"," ",$fld));
		echo "<th>$fld</th>";
		}

	foreach($ARRAY AS $index=>$array)
		{
		echo "<tr>";
		$total="";
		foreach($array as $fld=>$value)
			{
		
		//	if(in_array($fld,$skip)){continue;}
			$td=" align='left'";
			if($fld=="id")
			{$value="<a href='inspections.php?submit=Update&id=$value'>$value</a>";}
			
			echo "<td$td>$value</td>";
			}
		
		echo "</tr>";
		}
	

	
	if($submit=="Show All")
		{
		// withdrawn
		echo "<tr>
		<th colspan='$col' align='right'>inspections Withdrawn: </th>
		<th align='right'>$tot_withdrawn_grant_amount</th>
		<th align='right'>$tot_withdrawn_local_match</th>";
		if(@$level>3){echo "<th></th>";}
		echo "<th align='right'>$grand_total_withdrawn</th></tr>";
		// Final
		echo "<tr>
		<th colspan='$col' align='right'>Grant Totals: </th>
		<th align='right'>$grand_grant_amount_actual</th>
		<th align='right'>$grand_local_match_actual</th>";
		if(@$level>3){echo "<th></th>";}
		echo "<th align='right'>$grand_total_actual</th></tr>";
		echo "</table>";
		}
	}

echo "</html>";

?>
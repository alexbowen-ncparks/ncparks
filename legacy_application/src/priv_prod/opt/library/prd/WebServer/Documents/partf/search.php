<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";

//echo "<pre>"; print_r($ARRAY); echo "</pre>";	
if(@$submit=="Find")
	{
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";
	$search_these=array("sponsor","county","year");
	$where="where 1 and (";
	foreach($_POST AS $fld=>$value)
		{
		if(!in_array($fld,$search_these) OR $value==""){continue;}
		$where.=$fld." like '%".$_POST[$fld]."%' AND ";
		}
	$where=rtrim($where," AND ").") ";
	
	if($where=="where 1 and () "){$where="where 1 ";}
	
	if(!empty($_POST['n']))
		{
		$where.=" and (";
		foreach($_POST['n'] AS $index=>$value)
			{
			$where.="grant_status='$value' OR ";
			}
		$where=rtrim($where," OR ").") ";
		}
		

	if($where=="where 1 and () "){exit;}

	$sql="SELECT *
	from grants
	$where order by sponsor, county, year"; //echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("<br />Couldn't execute query. $sql<br /><br />$where");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	IF(!empty($ARRAY)>0)
		{
		$num=count($ARRAY);
		$where=str_replace("%","",$where);
		echo "<div align='center'>$num Grant(s) found using <font color='blue'>$where</font></div>";
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
	from grants
	where 1
	order by sponsor, county, year"; //echo "$sql"; //exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql<br /><br />$where");
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	IF(!empty($ARRAY)>0)
		{
		$num=count($ARRAY);
		echo "<div align='center'>$num Grants found.</div>";
		$display_search="block";
		}
	}


//echo "<pre>";print_r($ARRAY); echo "</pre>$sql"; //exit;

// Input Form
		
if(@$submit=="Add")
		{
		$skip_add=array("id");
		$sql="SELECT *
		from grants
		where 1 limit 1"; //echo "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql<br /><br />$where");
		while($row=mysqli_fetch_assoc($result))
			{
			$field_array=array_keys($row);
			}
		$sql="SELECT distinct sponsor
		from grants
		where 1 order by sponsor"; //echo "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql<br /><br />$where");
		while($row=mysqli_fetch_assoc($result))
			{
			$sponsor_array[]=$row['sponsor'];
			}
		$sql="SELECT distinct county
		from grants
		where 1 order by county"; //echo "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql<br /><br />$where");
		while($row=mysqli_fetch_assoc($result))
			{
			$county_array_add[]=$row['county'];
			}
			$county_array_add[]="Washington";
			sort($county_array_add);
			
		$status_array=array("Active","Closed","Withdrawn");
		//	echo "<pre>"; print_r($county_array_add); echo "</pre>";
		echo "<form action='add_grant.php' method='POST'>";
		echo "<table align='center'>";
		foreach($field_array as $index=>$fld)
			{
			if(in_array($fld,$skip_add)){continue;}
			echo "<tr><td>$fld</td>";
			
			$input="<td><input type='text' name='$fld'></td>";
				if($fld=="sponsor")
				{
				$input="<td><select name='$fld'><option selected=''></option>\n";
				foreach($sponsor_array as $k=>$v)
					{
					$input.="<option value='$v'>$v</option>\n";
					}
				$input.="</select></td>
				<td>New Sponsor: <input type='text' name='new_sponsor' size='45'></td>";
				}
				
			if($fld=="county")
				{
				$input="<td><select name='$fld'><option selected=''></option>\n";
				foreach($county_array_add as $k=>$v)
					{
					$input.="<option value='$v'>$v</option>\n";
					}
				$input.="</select></td>";
				}
				
			if($fld=="grant_status")
				{
				$input="<td><select name='$fld'><option selected=''></option>\n";
				foreach($status_array as $k=>$v)
					{
					$input.="<option value='$v'>$v</option>\n";
					}
				$input.="</select></td>";
				}
				
			echo "$input</tr>";
			}
		echo "<tr><td colspan='2' align='center'>
		<input type='submit' name='submit' value='Add'>
		</td></tr>";
		echo "</table></form>";
		}

if(@$level<3){$skip=array("id","grant_status");}else{$skip=array();}

if((@$submit=="Find" OR @$submit=="Show All") AND !empty($ARRAY))
		{
	echo "<div align='center'><table border='1' cellpadding='5'>";
	echo "<tr>";
	foreach($ARRAY[0] AS $fld=>$val)
		{
		if(in_array($fld,$skip)){continue;}
		$fld=strtoupper(str_replace("_"," ",$fld));
		echo "<th>$fld</th>";
		}
	echo "<th>TOTAL PROJECT</th></tr>";

	foreach($ARRAY AS $index=>$array)
		{
		echo "<tr>";
		$total="";
		foreach($array as $fld=>$value)
			{
			if($fld=="grant_status" and $value=="Withdrawn")
				{
				@$tot_withdrawn_grant_amount+=$array['grant_amount'];
				@$tot_withdrawn_local_match+=$array['local_match'];
				}
			if(in_array($fld,$skip)){continue;}
			$td=" align='left'";
			if($fld=="id")
			{$value="<a href='grants.php?submit=Update&id=$value'>$value</a>";}
			
			if($fld=="grant_amount" OR $fld=="local_match")
				{
				@${"grand_".$fld}+=$value;
				$total+=$value;
				$td=" align='right'";
				$value=number_format($value,0);
				}
			echo "<td$td>$value</td>";
			}
			
			$total="$".number_format($total,0);
		echo "<td align='right'>$total</td></tr>";
		}
	$grand_total_original="$".number_format(($grand_grant_amount+$grand_local_match),0);
	$grand_grant_amount_original="$".number_format($grand_grant_amount,0);
	$grand_local_match_original="$".number_format($grand_local_match,0);
	@$grand_grant_amount_actual="$".number_format($grand_grant_amount-$tot_withdrawn_grant_amount,0);
	@$grand_local_match_actual="$".number_format($grand_local_match-$tot_withdrawn_local_match,0);
	
	@$grand_total_actual="$".number_format(($grand_grant_amount+$grand_local_match)-($tot_withdrawn_grant_amount+$tot_withdrawn_local_match),0);	@$grand_total_withdrawn="($".number_format(($tot_withdrawn_grant_amount+$tot_withdrawn_local_match),0).")";
	
	@$tot_withdrawn_grant_amount="($".number_format($tot_withdrawn_grant_amount,0).")";	@$tot_withdrawn_local_match="($".number_format($tot_withdrawn_local_match,0).")";
	
	
	if(@$level<3){$col=4;}else{$col=5;}
	$var_title="Grants Awarded:";
	if(@$_POST['n'][0]=="Withdrawn"){$var_title="Grant Requests Withdrawn:";}
	echo "<tr>
	<th colspan='$col' align='right'>$var_title </th>
	<th align='right'>$grand_grant_amount_original</th>
	<th align='right'>$grand_local_match_original</th>";
	if(@$level>3){echo "<th></th>";}
	echo "<th align='right'>$grand_total_original</th>
	</tr>";
	
	if($submit=="Show All")
		{
		// withdrawn
		echo "<tr>
		<th colspan='$col' align='right'>Grants Withdrawn: </th>
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
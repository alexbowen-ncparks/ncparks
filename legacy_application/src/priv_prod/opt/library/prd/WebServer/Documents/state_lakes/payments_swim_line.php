<?php$t2="swim_line";$swim_line_fees=array("swim_line_fee_array");$swim_line_fee_array=array("date"=>"swim_line_receipt","fee"=>"sum(`t2`.`fee`) as swim_line_fee, count(`t2`.`fee`) as num_swim_lines","check"=>"check_number");foreach($swim_line_fees as $k0=>$v0)	{	$field_list_1=$default_fields;	$fields=${$v0};	foreach($fields as $k1=>$v1)		{		$field_list_1.=$v1.",";		}	$field_list_1=rtrim($field_list_1,",");		$receipt_clause="t2.".$fields['date']." >= '$start_date' AND t2.".$fields['date']." <= '$end_date'";	$JOIN="LEFT JOIN $t2 as t2 on t1.id=t2.contacts_id ";	$WHERE="t2.pier_number is not NULL";		if(@$unpaid=="x")		{		$receipt_clause=" and (t2.pier_payment = '' OR t4.swim_line_receipt = '' OR t5.swim_line_receipt = '' OR t6.swim_line_receipt = '')";		}		$sql="SELECT $field_list_1	FROM  contacts as t1	$JOIN	where 1 	and 	$WHERE	and $receipt_clause	$clause	group by t1.id	ORDER BY billing_last_name"; //	echo "$k0 = $sql<br />"; 	//EXIT;	$result1 = mysql_query($sql) or die ("Couldn't execute query. $sql c=$connection");		$num_pay=mysql_num_rows($result1);	//if($num_pay<1){echo "No records found for $park $start_date.";exit;}		while($row=mysql_fetch_assoc($result1))		{		$HEADERS[]=array_keys($row);		$ARRAY[]=$row;		}	}?>
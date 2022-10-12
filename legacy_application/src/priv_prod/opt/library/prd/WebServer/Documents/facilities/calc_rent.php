<?php
ini_set('display_errors',1);
// $database="facilities";
// include("../../include/auth.inc"); // used to authenticate users
// include("../../include/iConnect.inc");
// 
// $database="facilities";
// mysqli_select_db($connection,$database); // database
// 
// // $gis_id="CABE0087";

// $sql="SELECT sum(t1.bedrms+t1.bathrms+2) as rooms, t1.rent_code, t1.rent_fee, t2.current_salary
// from housing as t1
// left join divper.position as t2 on t1.position=t2.beacon_num
// where gis_id='$gis_id'"; 
// 	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
// 	while($row=mysqli_fetch_assoc($result))
// 		{
// 		$ARRAY_housing=$row;
// 		}
// echo "<pre>"; print_r($ARRAY_housing); echo "</pre>"; // exit;

$sql="SELECT * from housing_rent_calc"; 
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$index=$row['housing_level'].$row['building_class'];
		$ARRAY_rent_calc[$index]=$row;
		}
//  echo "salary = $salary<pre>"; print_r($ARRAY_rent_calc); echo "</pre>"; // exit;

switch($salary)
	{
	case $salary>41999:
		$temp="salary_42000_plus";
		break;
	case $salary>36000 and $salary<42000:
		$temp="salary_36001to42000";
		break;
	case $salary>31000 and $salary<36000:
		$temp="salary_31001to36000";
		break;
	case $salary<31001:
		$temp="salary_27000to31000";
		break;
	}
//  echo "v=$salary t=$temp<br />";

$rent_code=substr($rent_code,0,2);
// $rent_code="1A";

foreach ($ARRAY_rent_calc as $key => $array) {
	foreach($array as $key1=>$val)
			if ($key1 === $temp and $key==$rent_code)
			{
			$pass_rent_fee=number_format($val,2);
			
			}
       }

// echo "<br />$temp v=$salary";
?>
<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];

extract($_REQUEST);
if($level==1){$parkcode=$concession_location;}

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;

$database="budget";
$db="budget";
$table="pcard_holders_dncr2";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
echo "<html><body>";
echo "<h2>TABLE: $table</h2>";

include("style1.html");
echo "<table class='center'><tr><td><a href='pcard_holders_dncr18.php?add=y'>ADD Record</a></td></tr></table>"; 
//$skip_array=array("");
//$decimalFields=array("");
$skip_array=array("submit");
$primaryFieldA=array("id");
$primaryField="id";
echo "primaryField=$primaryField<br />";
//$order_by=" order by employee";
if($order_by==''){$order_by='last_name';}
if($asc_desc==''){$asc_desc='asc';}
echo "order_by=$order_by<br />"; //exit;
$order_by2=" order by ". $order_by." ". $asc_desc;
echo "order_by2=$order_by2<br />"; //exit;


if($submit=='Update'){
$skip_array=array("submit");



foreach($_REQUEST as $k=>$v)
	{// each row
	       if(in_array($k,$skip_array)){continue;}
			if(in_array($k,$primaryField)){continue;}
			//echo "<tr><td>$k1</td><td><input type='text' name='$k1' value='$v1'></td></tr>";
			$query="update $table set $k='$v' where id='$id' ";
			//echo "query=$query<br />";
			$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");	
			
	}
echo "Update Successful<br />";
//exit;
}


if($submit=='Add'){
$skip_array=array("submit");


foreach($_REQUEST as $k=>$v)
	{// each row
	       if(in_array($k,$skip_array)){continue;}
			if(in_array($k,$primaryField)){continue;}
			//echo "<tr><td>$k1</td><td><input type='text' name='$k1' value='$v1'></td></tr>";
			$query=" $k='$v',";
			//echo "query=$query<br />";
			//$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");	
	$query1.=$query;
	
	}
$query2=rtrim($query1,",");	
$query3="insert into $table set".$query2;	
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query3.  $query3");	
//echo "query1=$query1<br /><br />";	
//echo "query2=$query2<br /><br />";	
//echo "query3=$query3<br /><br />";	
echo "Add Successful<br />";

//exit;
}


if($add=='y'){


$query="SELECT * from $table
        where 1
         ";

echo "query=$query<br />";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");




while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
$num=count($ARRAY);
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

$fieldNames=array_keys($ARRAY[0]);

//$fieldNames=array_values(array_keys($ARRAY[0]));


//echo "<pre>"; print_r($fieldNames); echo "</pre>";  exit;

$count=count($fieldNames);
//$skip_array=array("id");
//$color='red';
//$f1="<font color='$color'>"; $f2="</font>";
//include("park_inc_stmts_district_header.php"); // connection parameters
//if($district==''){exit;}
echo "<form method='post' action='pcard_holders_dncr18.php'>";
echo "<table border='1' cellpadding='2'>";

echo "<tr><td colspan='2' ><font color='red'>$num</font> records</td></tr>";

foreach($fieldNames as $k=>$v){
//$v=str_replace("_"," ",$v);
if(in_array($v,$primaryField)){continue;}
echo "<tr>";
echo "<th>$v</th><td><input type='text' name='$v'></input></td> ";
echo "</tr>";
}
echo "<tr>";
echo "<td><input type='submit' name='submit' value='Add'></td>";
echo "</tr>";
echo "</table>";
echo "</form>";



exit;
}


if($edit=='y'){
//$primaryField=array("coaid");
echo "Code to Edit Table record=$id<br /><br />"; //exit;

$query="SELECT * from $table
        where 1 and $primaryField='$id'
         ";

echo "query=$query<br />";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");

while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
$num=count($ARRAY);
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;

$fieldNames=array_keys($ARRAY[0]);

//$fieldNames=array_values(array_keys($ARRAY[0]));

//echo "<pre>"; print_r($fieldNames); echo "</pre>";  //exit;

$count=count($fieldNames);
echo "<form method='post' action='pcard_holders_dncr18.php'>";
echo "<table border='1' cellpadding='2' >";
foreach($ARRAY as $k=>$v)
	{// each row
	
	
	
	echo "<tr>";
	    //$k1 is the field name.  $v1 is the field value 
		foreach($v as $k1=>$v1){// each field, e.g., $tempID=$v[tempID];
			//if(in_array($k1,$skip_array)){continue;}
			//if(in_array($k1,$primaryField)){continue;}
			echo "<tr><td>$k1</td><td><input type='text' name='$k1' value='$v1'></td></tr>";
			
			
			} 
		
	echo "</tr>";
	}

echo "</table>";
echo "<input type='hidden' name='id' value='$id'>";
echo "<input type='submit' name='submit' value='Update'>";
echo "</form>";
exit;
}
//Shows ALL Records
$query="SELECT * from $table
        where 1 $order_by2
         ";

echo "query=$query<br />";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");

while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}

// Counts the # of RECORDS in the TABLE
$num=count($ARRAY);

//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

$fieldNames=array_keys($ARRAY[0]);

//$fieldNames=array_values(array_keys($ARRAY[0]));


//echo "<pre>"; print_r($fieldNames); echo "</pre>";  exit;

// Counts the # of FIELDS in the TABLE
$count=count($fieldNames);

//$color='red';
//$f1="<font color='$color'>"; $f2="</font>";
//include("park_inc_stmts_district_header.php"); // connection parameters
//if($district==''){exit;}

echo "<table border='1' cellpadding='2' >";

echo "<tr><td colspan='2' ><font color='red'>$num</font> records</td></tr>";
echo "<tr>";
foreach($fieldNames as $k=>$v){
//$v=str_replace("_"," ",$v);
if(in_array($v,$skip_array)){continue;}
if($v==$order_by)
{
echo "<th>$v<br />sorted $asc_desc</th>";
}
else
{
echo "<th>$v</th>";
}
}
echo "</tr>";

$j=0;
foreach($ARRAY as $k=>$v)
	{// each row
	
	$j++;
	if(fmod($j,2)!=0){$tr=" bgcolor='cornsilk'";}else{$tr="";}
	
	echo "<tr$tr>";
	    //$k1 is the field name.  $v1 is the field value 
		foreach($v as $k1=>$v1){// each field, e.g., $tempID=$v[tempID];
			if(in_array($k1,$skip_array)){continue;}
			if(in_array($k1,$decimalFields)){
			$total[$k1]+=$v1;   //if $k1=cy_amount:    $total[cy_amount] = total amount of values ($v1)
			}
			if($k1==$primaryField){echo "<td>$v1 <a href='pcard_holders_dncr18.php?edit=y&$k1=$v1'>Edit</a></td>";} else  {echo "<td>$v1</td>";}
			
			
			} 
		
	echo "</tr>";
	}

	
	echo "<tr>";


foreach($fieldNames as $k=>$v){
if(in_array($v,$skip_array)){continue;}
$v2=number_format($total[$v],2);  //if $v=cy_amount:    $total[cy_amount] = TOTAL Amount produced in LINE 93 above
if(in_array($v,$decimalFields)){echo "<th>$v2</th>";}else{echo "<th></th>";}
}
echo "</tr>";

	
	
	
	
	
	
	
	
	
//echo "<tr>";



echo "</table></body></html>";


















?>


 


























	















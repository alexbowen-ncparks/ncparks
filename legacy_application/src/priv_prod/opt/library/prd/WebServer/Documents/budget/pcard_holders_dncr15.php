<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
//header("location: /login_form.php?db=budget");
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
echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;





$database="budget";
$db="budget";
$table="pcard_holders_dncr2";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
echo "<html><body>";

//include("../../budget/menu1314.php");
echo "<table><tr><td><a href='pcard_holders_dncr15.php?add=y'>ADD Record</a></td></tr></table>"; 
//$skip_array=array("");
//$decimalFields=array("");
$LinkFields=array("id");


if($submit=='Update'){
$skip_array=array("submit");
$primaryField=array("id");


foreach($_REQUEST as $k=>$v)
	{// each row
	       if(in_array($k,$skip_array)){continue;}
			if(in_array($k,$primaryField)){continue;}
			//echo "<tr><td>$k1</td><td><input type='text' name='$k1' value='$v1'></td></tr>";
			$query="update pcard_holders_dncr2 set $k='$v' where id='$id' ";
			echo "query=$query<br />";
			$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");	
			
	}
echo "Update Successful<br />";
//exit;
}


if($submit=='Add'){
$skip_array=array("submit");
$primaryField=array("id");


foreach($_REQUEST as $k=>$v)
	{// each row
	       if(in_array($k,$skip_array)){continue;}
			if(in_array($k,$primaryField)){continue;}
			//echo "<tr><td>$k1</td><td><input type='text' name='$k1' value='$v1'></td></tr>";
			$query=" $k='$v',";
			echo "query=$query<br />";
			//$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");	
	$query1.=$query;
	
	}
$query2=rtrim($query1,",");	
$query3="insert into pcard_holders_dncr2 set".$query2;	
$result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query3.  $query3");	
echo "query1=$query1<br /><br />";	
echo "query2=$query2<br /><br />";	
echo "query3=$query3<br /><br />";	
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
$skip_array=array("id");
//$color='red';
//$f1="<font color='$color'>"; $f2="</font>";
//include("park_inc_stmts_district_header.php"); // connection parameters
//if($district==''){exit;}
echo "<form method='post' action='pcard_holders_dncr15.php'>";
echo "<table border='1' cellpadding='2'>";

echo "<tr><td colspan='2' align='center'><font color='red'>$num</font> records</td></tr>";

foreach($fieldNames as $k=>$v){
//$v=str_replace("_"," ",$v);
if(in_array($v,$skip_array)){continue;}
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
$primaryField=array("id");
echo "Code to Edit Table record=$id<br /><br />"; //exit;

$query="SELECT * from $table
        where 1 and id='$id'
         ";

echo "query=$query<br />";
$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");

while($row=mysqli_fetch_assoc($result)){$ARRAY[]=$row;}
$num=count($ARRAY);
echo "<pre>"; print_r($ARRAY); echo "</pre>";  //exit;

$fieldNames=array_keys($ARRAY[0]);

//$fieldNames=array_values(array_keys($ARRAY[0]));

//echo "<pre>"; print_r($fieldNames); echo "</pre>";  //exit;

$count=count($fieldNames);
echo "<form method='post' action='pcard_holders_dncr15.php'>";
echo "<table border='1' cellpadding='2'>";
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

//$color='red';
//$f1="<font color='$color'>"; $f2="</font>";
//include("park_inc_stmts_district_header.php"); // connection parameters
//if($district==''){exit;}

echo "<table border='1' cellpadding='2'>";

echo "<tr><td colspan='2' align='center'><font color='red'>$num</font> records</td></tr>";
echo "<tr>";
foreach($fieldNames as $k=>$v){
//$v=str_replace("_"," ",$v);
if(in_array($v,$skip_array)){continue;}
echo "<th>$v</th>";}
echo "</tr>";

$j=0;
foreach($ARRAY as $k=>$v)
	{// each row
	
	
	
	echo "<tr>";
	    //$k1 is the field name.  $v1 is the field value 
		foreach($v as $k1=>$v1){// each field, e.g., $tempID=$v[tempID];
			if(in_array($k1,$skip_array)){continue;}
			if(in_array($k1,$decimalFields)){
			$total[$k1]+=$v1;   //if $k1=cy_amount:    $total[cy_amount] = total amount of values ($v1)
			}
			if(in_array($k1,$LinkFields)){echo "<td>$v1 <a href='pcard_holders_dncr15.php?edit=y&id=$v1'>Edit</a></td>";} else  {echo "<td>$v1</td>";}
			
			
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


 


























	















<?php

session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
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
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;

$database="budget";
$db="budget";
//$table="pcard_holders_dncr2";
$table="pcard_holders_dncr2";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
echo "<html><body>";
echo "<h2>TABLE: $table</h2>";

include("style1.html");
echo "<table class='center'><tr><td><a href='table9.php?add=y'>ADD Record</a></td></tr></table>"; 
//$decimalFields=array("");
$skip_array=array("");
echo "<pre>"; print_r($skip_array); echo "</pre>";  //exit;
$count_skip=count($skip_array);
echo "<br />fieldnames_skip=$count_skip<br />";


$primaryField="id";
echo "primaryField=$primaryField<br />";
//$fieldNames_skip=array_keys($skip_array[0]);
//$count=count($fieldNames_skip);

//special formatting arrays (start)

$font_red_array=array("active","pcard_num");

//$cars=array("Volvo","BMW","Toyota");
//echo "<pre>"; print_r($cars); echo "</pre>";  //exit;
//$cars2=count($cars);
//echo "cars2=$cars2<br />";





//special formatting arrays (end)




//$order_by=" order by employee";
if($order_by==''){$order_by='park';}
if($asc_desc==''){$asc_desc='asc';}
echo "order_by=$order_by<br />"; //exit;
echo "asc_desc=$asc_desc<br />"; //exit;
$order_by2=" order by ". $order_by." ". $asc_desc;
if($fs=='y'){$order_by2=" and ".$order_by."="."'".$keyword_chosen."'"." order by ". $order_by." ". $asc_desc;}
echo "order_by2=$order_by2<br />"; //exit;


if($submit=='Update'){




foreach($_REQUEST as $k=>$v)
	{// each row
	       //if(in_array($k,$skip_array)){continue;}
	       if($k=='submit'){continue;}
	       if($k=='order_by'){continue;}
	       if($k=='keyword_chosen'){continue;}
	       if($k=='fs'){continue;}
	       if($k=='pf'){continue;}
			$query="update $table set $k='$v' where $primaryField='$pf' ";
			//echo "query=$query<br />";
			$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");	
			
	}
echo "Update Successful<br />";
//exit;
}


if($submit=='Add'){



foreach($_REQUEST as $k=>$v)
	{// each row
	       if($k=='submit'){continue;}
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


//echo "<pre>"; print_r($fieldNames); echo "</pre>";  //exit;

$count=count($fieldNames);
//$skip_array=array("id");
//$color='red';
//$f1="<font color='$color'>"; $f2="</font>";
//include("park_inc_stmts_district_header.php"); // connection parameters
//if($district==''){exit;}
echo "<form method='post' action='table9.php'>";
echo "<table border='1' cellpadding='2'>";

echo "<tr><td colspan='2' ><font color='red'>$num</font> records</td></tr>";

foreach($fieldNames as $k=>$v){
//$v=str_replace("_"," ",$v);
//if(in_array($v,$primaryFieldA)){continue;}
if(in_array($v,$skip_array)){continue;}
if($v==$primaryField){continue;}
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
        where 1 and $primaryField='$pf'
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
echo "<form method='post' action='table9.php'>";
echo "<table border='1' cellpadding='2' >";
foreach($ARRAY as $k=>$v)
	{// each row
	
	
	
	echo "<tr>";
	    //$k1 is the field name.  $v1 is the field value 
		foreach($v as $k1=>$v1){// each field, e.g., $tempID=$v[tempID];
			if(in_array($k1,$skip_array)){continue;}
			if($k1==$primaryField){continue;}
			//if(in_array($k1,$primaryField)){continue;}
			echo "<tr><td>$k1</td><td><input type='text' name='$k1' value='$v1'></td></tr>";
			
			
			} 
		
	echo "</tr>";
	}

echo "</table>";
echo "<input type='hidden' name='pf' value='$pf'>";
echo "<input type='hidden' name='order_by' value='$order_by'>";
echo "<input type='hidden' name='keyword_chosen' value='$keyword_chosen'>";
echo "<input type='hidden' name='fs' value='$fs'>";
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
echo "<br />fieldnames=$count<br />";
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

if($asc_desc=='asc'){$asc_desc2='desc';}
if($asc_desc=='desc'){$asc_desc2='asc';}


echo "<th><a href='table9.php?order_by=$v&asc_desc=$asc_desc2'>$v</a><br />sorted $asc_desc <br />";include('autocomplete_table9.php'); echo"</th>";
}
else
{
echo "<th><a href='table9.php?order_by=$v'>$v</a></th>";
}
}
echo "</tr>";

$j=1;
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
			if($k1==$primaryField){echo "<td>$v1 <a href='table9.php?edit=y&order_by=$order_by&keyword_chosen=$keyword_chosen&fs=$fs&pf=$v1'>Edit</a></td>";}
			else  {echo "<td>";
			if(in_array($k1,$font_red_array) and $v1=='n'){echo "<font color='red' class='cartRow'>$v1</font>";} else {echo "$v1";}
			echo "</td>";}
			
			
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
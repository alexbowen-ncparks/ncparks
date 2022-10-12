<?php
header ("Pragma: no-cache"); 
header ("Cache-Control: no-cache, must-revalidate, max_age=0"); 
header ("Expires: 0");

//echo "<pre>"; print_r($_FILES); echo "</pre>";  exit;
$database="phone_bill";
include("../../../include/connectROOT.inc"); //echo "c=$connection";
//include("connectROOT.inc"); //echo "c=$connection";
extract($_REQUEST);//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

// ******* Add raw upload file ************
if ($submit == "Add File") {
exit;
extract($_FILES);
$size = $_FILES['file_upload']['size'];
$type = $_FILES['file_upload']['type'];
$file = $_FILES['file_upload']['name'];

//$ext = substr(strrchr($file, "."), 1);// find file extention, png e.g.
//print_r($_FILES); print_r($_REQUEST);exit;
if(!is_uploaded_file($file_upload['tmp_name'])){print_r($_FILES);  print_r($_REQUEST);
exit;}

$upload=$file_upload['tmp_name'];
  $sql = "UPDATE phone_bill set bill_txt='$upload' where id='1'";
//  echo "$sql";exit;
$result = @mysql_query($sql, $connection) or die("c=$connection $sql Error 1#". mysql_errno() . ": " . mysql_error());
}

// ******* Start parse ********
/*
$sql="SELECT * from phone_bill where id='1'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
extract($row);
*/

//$open_file="phone_large.TXT";
$fo=fopen($open_file,'r');
$bill_txt = fread($fo, filesize($open_file));
fclose($fo);


//$ex_sum=explode(": Expense Summary",$bill_txt);
//echo "<pre>"; print_r($ex[0]); echo "</pre>";exit;
//echo "<pre>"; print_r($ex[1]); echo "</pre>"; exit;


//foreach($ex_sum as $countES=>$bill_txt){
//if($countES==0){continue;}
	$ex=explode(": Total",$bill_txt);
//	echo "<pre>"; print_r($ex[0]); echo "</pre>"; exit;

// Get Total of Bill
$grand1=explode("Total.........................",$ex[0]);
$grand2=explode(":",$grand1[1]);
$grand_total=trim($grand2[0]); $grand_total=trim($grand_total,"$");
		//echo "$grand_total"; exit;
$grand_total=str_replace(",","",$grand_total);

$billing_period=explode("Period ending -",$grand1[0]); 
$billing_period=explode(":",$billing_period[1]);
$billing_period=trim($billing_period[0]);
//echo "<pre>"; print_r($billing_period[0]); echo "</pre>";  exit;

$var1=explode($grand_total,$bill_txt);

// $var1[0] is summary of all DPR charged numbers
$var2=explode("Employee Summary",$var1[0]); 
$var2[0]="";
//	echo "<br><br><br>$count<br><br><br>";
//	echo "<pre>"; print_r($var2); echo "</pre>"; // exit;
	
$var4="";
foreach($var2 as $k=>$v){
	if(!$v){continue;}
	$var3=explode("Report",$v);
	$var4[]=$var3[0];
	}
	//echo "<pre>"; print_r($var4); echo "</pre>"; // exit;
	
// Service type header $var5
// Array of charges by service type for all phone numbers $var7
$var6="";
foreach($var4 as $k=>$v){
	if(!$v){continue;}
	$var5=explode(": :",$v);
	$var6[]=$var5[1];
	}
	//echo "<pre>"; print_r($var5[0]); echo "</pre>"; // exit; 
	$var7=str_replace(":                                                                                                                                  :","",implode("",$var6));
	//$var7=str_replace(" :\r\n\r\n\r\n","",$var7);
	$var7=str_replace("\f","",$var7);
	//echo "<pre>"; print_r($var7); echo "</pre>"; // exit;
	
	// Totals by service type
	$Totals=explode(": Total",$var7);
	//echo "<pre>"; print_r($Totals[1]); echo "</pre>"; // exit;
	
	$var8=explode(" 919-",$var7);
	//echo "<pre>"; print_r($var8); echo "</pre>"; // exit;
	
	$var9=str_replace(":\r\n:","",$var8);
	
$var10="";	
	foreach($var9 as $k=>$v){
		$varTemp=str_replace(":\r\n\r\n:","",$v);
		$varTemp=str_replace(":\r\n\r\n\r\n:","",$varTemp);
		$varTemp=str_replace("                                                           ","\t",$varTemp);
		$varTemp=str_replace("                               ","\t",$varTemp);
		$varTemp=str_replace("         ","\t",$varTemp);
		$varTemp=str_replace("       ","\t",$varTemp);
		$varTemp=str_replace("      ","\t",$varTemp);

		$varTemp=str_replace("     ","\t",$varTemp);
				$varTemp=str_replace("-    ","-\t",$varTemp);
		
		$var10[]=$varTemp;
		}
//secho "<pre>"; print_r($var10); echo "</pre>"; // exit;

$fldArray=array("`phone_number`","`local`","`ism`","`voice`","`wan`","`sna`","`p2p`","`dialup`","`long_distance`","`virtual`","`one800`","`calling_card`","`cellular`","`ncih`","`misc_passthru`","`erate`","`lan`","`total`");

//echo "<pre>"; print_r($var10);  echo "</pre>"; // exit;

			$sql="TRUNCATE table charges";// echo "$sql";exit;
				$result=mysql_query($sql);
$clause="";
$lines=count($var10);
foreach($var10 as $k=>$v){
	if($v==0){continue;}
		$values=explode("\t",$v);
			foreach($values as $key=>$val){
				if($fldArray[$key]==""){continue;}
			//	if($fldArray[$key]=="`phone_number`"){$val="919-".trim($val);}
				if($fldArray[$key]=="`total`"){$gt+=trim($val);}
				$clause.=$fldArray[$key]."='".trim($val)."',";
				}
				$clause=trim($clause,",");
			$sql="INSERT INTO charges SET $clause";// echo "$sql";exit;
				$result=mysql_query($sql);
			//	echo "$clause<br>";
				$clause="";
				}
	$temp=explode(" -	-	-	",$var10[0]);
$temp=$temp[1];
	$temp=explode(" ",$temp);
	$temp=explode("\t",$temp[0]);
	$t=$temp[0];
	$gt=$gt+$t;

	$sql="INSERT INTO charges SET `phone_number`='YORK T1', `total`='$t'";
	// echo "$sql";exit;
				$result=mysql_query($sql);

//}// end array from phone_large.TXT


// ********** Get Field Types *********

$sql="SHOW COLUMNS FROM charges";
 $result = @MYSQL_QUERY($sql,$connection);
while($row=mysql_fetch_assoc($result)){
$allFields[]=$row[Field];
if(strpos($row[Type],"decimal")>-1){
	$decimalFields[]=$row['Field'];
	$tempVar=explode(",",$row[Type]);
	$decPoint[$row['Field']]=trim($tempVar[1],")");
	}
}

// ********** Edit row ************

$editFlds=$fieldNames;
$excludeFields=array("id");

		if(!in_array($k1,$excludeFields) AND $edit==$v['listid']){
		$v1="<input type='text' name='$k1' value='$v1'>";}
		
		
// ******** Enter your SELECT statement here **********
$sql="SELECT t1.Fname,t1.Lname, right(t1.Mphone,8) as Mphone
FROM divper.empinfo as t1
LEFT JOIN divper.emplist as t2 on t2.tempID=t1.tempID
where t2.currPark='ARCH' OR t2.currPark='YORK' OR t2.currPark='SODI' OR t2.currPark='NODI' OR t2.currPark='EADI' OR t2.currPark='WEDI'";
 $result = @MYSQL_QUERY($sql);
while($row=mysql_fetch_assoc($result)){
		if($row[Mphone]==""){continue;}
		$phoneArray[$row[Mphone]]=$row['Fname']." ".$row['Lname'];
		}
		
$sql="SELECT t1.Fname,t1.Lname, right(t1.phone,8) as Mphone
FROM divper.empinfo as t1
LEFT JOIN divper.emplist as t2 on t2.tempID=t1.tempID
where t2.currPark='ARCH' OR t2.currPark='YORK' OR t2.currPark='SODI' OR t2.currPark='NODI' OR t2.currPark='EADI' OR t2.currPark='WEDI'";
 $result = @MYSQL_QUERY($sql);
while($row=mysql_fetch_assoc($result)){
		if($row[Mphone]==""){continue;}
		$phoneArray[$row[Mphone]]=$row['Fname']." ".$row['Lname'];
		}
//echo "<pre>"; print_r($phoneArray); echo "</pre>";  //exit;


$sql="SELECT * FROM charges order by total desc,cellular desc, long_distance desc, local desc";
 $result = @MYSQL_QUERY($sql); // echo "$sql";
while($row=mysql_fetch_assoc($result)){$ARRAY[]=$row;}
$num=count($ARRAY); $colspan=8;
$fieldNames=array_values(array_keys($ARRAY[0]));

echo "<html><table border='1' cellpadding='2'><tr>
<td colspan='$colspan' align='center'><font color='red'>$num PHONE numbers (ARCH and YORK)</font></td><td colspan='8'>Upload raw report
<a href='phone_parse.php?open_file=phone_small.TXT'>small</a> <a href='phone_parse.php?open_file=phone_large.TXT'>large</a>
 <form method='post' action='phone_parse.php' enctype='multipart/form-data'>

   <INPUT TYPE='hidden' name='source' value='CHOP'>
  <br>1. Click to select your file. 
    <input type='file' name='file_upload'  size='40'><br />
    2. Then click this button. 
    <input type='hidden' name='parkcode' value='CHOP'>
	<input type='submit' name='submit' value='Add File'>
    </form>
    </td></tr>";

echo "<tr>";
foreach($fieldNames as $k=>$v){$v=str_replace("_"," ",$v);echo "<th>$v</th>";}
echo "</tr>";


//$editFlds=$fieldNames;
$excludeFields=array("id","emid","tempID");

//echo "<form method='POST'>"; /// Optional

foreach($ARRAY as $k=>$v){// each row

// $fx = font color  and  $tr = row shading
$f1="";$f2="";$j++;
if(fmod($j,2)!=0){$tr=" bgcolor='aliceblue'";}else{$tr="";}


echo "<tr$tr>";
	foreach($v as $k1=>$v1){// field name=$k1  value=$v1
		$var=$v1;
		
	if($k1=="phone_number"){
		$check="<font color='green'>".$phoneArray[$v1]."</font>";
		$var=$v1."<br />".$check;
		}
		
	if($k1=="id"){
	$person=$phoneArray[$v[phone_number]];
		$check="<a href='phone_detail.php?phone_number=$v[phone_number]&person=$person&billing_period=$billing_period&open_file=$open_file' target='_blank'>[ $var ]</a>";
		$var=$check;
		}
		
		if(in_array($k1,$decimalFields)){
			$total[$k1]+=$v1;
			$var=number_format($v1,$decPoint[$k1]);
			if($var=="0.00"){$var="-";}
							}
							

		echo "<td align='right'>$var</td>";}
	
echo "$update</tr>";
$update="";
}

echo "<tr>";
foreach($fieldNames as $k=>$v){
echo "<th>$total[$v]</th>";
}
echo "</tr>";

echo "</table></body></html>";

?>
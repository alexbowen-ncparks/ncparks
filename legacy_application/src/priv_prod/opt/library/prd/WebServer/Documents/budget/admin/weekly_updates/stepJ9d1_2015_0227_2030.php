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
/*
if($posTitle=='park superintendent'){$pasu_role='y';} else {$pasu_role='n';}
if($posTitle=='parks district superintendent'){$disu_role='y';} else {$disu_role='n';}
echo "<table>
<tr><td>tempID</td><td>pasu_role</td><td>disu_role</td></tr>
<tr><td>$tempID</td><td>$pasu_role</td><td>$disu_role</td></tr>
</table>";
*/
extract($_REQUEST);
if($level==1){$parkcode=$concession_location;}
//echo "$report_date<br />";exit;


//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database


$query="SELECT * FROM `bd725_dpr_new_extract` WHERE 1";


$result = mysql_query($query) or die ("Couldn't execute query.  $query");

echo "<html>";
echo "<head>";
echo "<style>";


echo "input[type='text'] {width: 80px;}
                         ";


?>
table, th, td {
    border: 1px solid black;
	}
.normal {background-color:#B4CDCD;}
.highlight {background-color:#ff0000;} 	
	
<?php


echo "</style>";


echo "<script type=\"text/javascript\"> function onRow(rowID)
{var row=document.getElementById(rowID);
//alert(rowID);
var curr=row.className;
//alert(curr);
if(curr.indexOf(\"normal\")>=0)
{
//alert(curr.indexOf(\"normal\"));
row.className=\"highlight\";
}
else {
row.className=\"normal\";
}
 } 
</script>";


echo "</head>";
echo "<body>";


while($row=mysql_fetch_assoc($result)){$ARRAY[]=$row;}
$num=count($ARRAY);
//echo "<pre>"; print_r($ARRAY); echo "</pre>";  exit;

$skip_array=array("BC","center","f_year","company","actcenteryn","xtnd_cip","cyinitfund","division","stateparkyn","xtnd_location","type","od_ok","fyear1","fyear2");
$decimalFields=array("cy_amount","py1_amount");
$textareaFields=array("Fund_Descript","projname");
$count=count($fieldNames);

$color='red';
$f1="<font color='$color'>"; $f2="</font>";
echo  "<form method='post' autocomplete='off' action='stepJ9d1_update_all.php'>";
echo "<table border='0' cellpadding='0'>";

echo "<tr><td colspan='10' align='center'><font color='red'>$num records<br />fund_descript=(EAST_MM,NORTH_MM,SOUTH_MM,WEST_MM,STWD_DEMOLITION,STWD_MM_RESERVE,STWD_Exhibit_Maintenance) or (XTND Description)<br />manager=erin_lawrence,jerry_howerton,dwayne_parker,pete_mitchell,etc <br />fullname=STONE MOUNTAIN,LAKE NORMAN,south district,STATEWIDE etc.<br />dist=EAST,NORTH,STWD,etc.<br />county=moore,nash,na,etc.<br />section=construction,operations,natural_resources<br />park=CABE,CACR,EADI,NODI,STWD,etc.<br />projname=XTND Description<br />proj_man=JH(jerry),EL(erin),etc. </font></td></tr>";
echo "<tr>";
foreach($ARRAY[0] as $fld=>$val)
	{
	//$fld=str_replace("_"," ",$fld);
	if(in_array($fld,$skip_array)){continue;}
	echo "<th>$fld</th>";
	}
echo "</tr>";

$j=0;
foreach($ARRAY as $index=>$array)
	{// each row
	
	// $fx = font color  and  $tr = row shading
	
	$f1="";$f2="";
	$j++;
	//if(fmod($j,2)!=0){$tr=" bgcolor='aliceblue'";}else{$tr="";}
	
	
	//echo "<tr$tr onMouseOver=\"this.bgColor='lightgreen'\" onMouseOut=\"this.bgColor='white'\">";
	echo "<tr class=\"normal\" id=\"row$j\" onclick=\"onRow(this.id)\">";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip_array)){continue;}	
		if(in_array($fld,$decimalFields))
			{
			$total[$fld]+=$value; 
			$value=number_format($value,2);
			$td=" align='right'";
			}
			else
			{
			$td=" align='left'";
			$value=strtoupper($value);
			}

		//echo "<td$td><input type='text' value='$value'></input></td>";}
		$fld_name=$fld."[]";
		  if(in_array($fld,$textareaFields))
			  {echo "<td$td><textarea name='$fld_name' rows='4' cols='30'>$value</textarea></td>";}
			  else
			  {echo "<td$td><input type='text' name='$fld_name' value='$value'></td>";}
  
		  }
			  
	echo "</tr>";
	}

	
	echo "<tr>";


foreach($ARRAY[0] as $fld=>$val){
$v2=number_format($total[$fld],2);  //if $v=cy_amount:    $total[cy_amount] = TOTAL Amount produced in LINE 93 above
if(in_array($fld,$decimalFields)){echo "<th>$v2</th>";}else{echo "<th></th>";}
}
echo "</tr>";
	
echo "<tr><td><input type='submit' name='submit2' value='Update'></td></tr>";


echo "</table>";

echo "<input type='hidden' name='fiscal_year' value='$fiscal_year'>	   
	   <input type='hidden' name='project_category' value='$project_category'>	   
	   <input type='hidden' name='project_name' value='$project_name'>	   
	   <input type='hidden' name='start_date' value='$start_date'>	   
	   <input type='hidden' name='end_date' value='$end_date'>	   
	   <input type='hidden' name='step_group' value='$step_group'>	   
	   <input type='hidden' name='step_num' value='$step_num'>	   
	   <input type='hidden' name='step' value='$step'>	   
	   <input type='hidden' name='step_name' value='$step_name'>";
	

echo "</form>";

echo "</body></html>";

?>

<?php
$database="divper";
include("../../include/auth.inc"); // used to authenticate users

$level=$_SESSION['divper']['level'];
$test=$_SESSION['logname'];
$emp_beacon_num=$_SESSION['beacon_num'];
$accessPark=@$_SESSION['divper']['accessPark'];
if(empty($accessPark))
	{
	$this_park=$_SESSION['parkS'];
	}
$position_title=@$_SESSION['position'];

//echo "<pre>"; print_r($_SESSION); echo "</pre>";
//echo "<pre>"; print_r($_POST); echo "</pre>";    exit;

include("menu.php"); 

include("../../include/iConnect.inc");
include("../../include/get_parkcodes_reg.php");

mysqli_select_db($connection,'divper'); // database
;

if(!empty($_POST))
	{
	foreach($_POST['supervisor'] AS $beacon_num=>$name)
		{
		if(empty($name)){continue;}
		$beacon_title=$_POST['beacon_title'][$beacon_num];
		$name=addslashes($_POST['supervisor'][$beacon_num]);
		$sql="REPLACE supervisors set beacon_num='$beacon_num', beacon_title='$beacon_title', name='$name'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
		}
	if(!empty($_POST['beacon_num_new']))
		{
		$beacon_title=$_POST['beacon_title_new'];
		$name=addslashes($_POST['supervisor_new']);
		$beacon_num=$_POST['beacon_num_new'];
		$sql="REPLACE supervisors set beacon_num='$beacon_num', beacon_title='$beacon_title', name='$name'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
		}
	}
$sql="SELECT t1.beacon_num as id, t1.beacon_num, concat( t3.Lname, ', ' ,t3.Fname) as supervisor, t1.beacon_title
	FROM divper.`supervisors` as t1
	LEFT JOIN divper.emplist as t2 on t1.beacon_num=t2.beacon_num
	LEFT JOIN divper.empinfo as t3 on t3.tempID=t2.tempID
	WHERE 1
	order by t3.Lname"; //echo "$sql";
	;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{$ARRAY[]=$row;}


echo "<form method='POST'><table cellpadding='5' border='1'>";
	echo "<tr><th></th>";
	foreach($ARRAY[0] as $k=>$v){
					if($k=="id"){continue;}
					echo "<th>$k</th>";
					}
	echo "</tr>";
	
	foreach($ARRAY as $num=>$row){ $num=$num+1;
			echo " <tr valign='top'><td align='right'>$num</td>";
			$test_blank_record="";
				foreach($row as $fld=>$value){
					$id=$row['id'];
					if($fld=="id"){continue;}
					$test_blank_record+=$value;
					
					if($fld=="justification"){
					$fld=$fld."[$id]";
					$toggle="<div id=\"fieldName\">   ... <a onclick=\"toggleDisplay('fieldDetails[$num]');\" href=\"javascript:void('')\"> details &#177</a> <font size='-1'>$related</font></div>

					<div id=\"fieldDetails[$id]\" style=\"display: none\"><br><textarea name='$fld' cols='55' rows='15'>$value</textarea></div>";
					echo "<td>$toggle</td>";
					}
					else{
						if($fld=="beacon_title"){
							$img=" <a href='position_justification.php?del=$id' onClick='return confirmLink()'><img src='../../button_drop.png'></a>";
						} else{$img="";}		
					$fld=$fld."[$id]";
					echo "<td><input type='text' name='$fld' value=\"$value\" size='17'>$img</td>";}
				}
			echo "</tr>";
			}
	if($test_blank_record>0){
		$id++;
	foreach($ARRAY[0] as $k=>$v){
					if($k=="id"){continue;}
					$fld=$k."_new";
					@$new_record.="<td><input type='text' name='$fld'></td>";
					}		
			echo "<tr><td></td>$new_record</tr>";
			}
echo "<tr><td colspan='4' align='center'>
<input type='submit' name='submit' value='Submit'>
</td></tr>";

	echo "</form></table>";
	

?>
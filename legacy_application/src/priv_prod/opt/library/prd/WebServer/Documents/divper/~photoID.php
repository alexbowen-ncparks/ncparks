<?php
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
//These are placed outside of the webserver directory for security
//ini_set('display_errors',1);
// ***********Find person form****************
//These are placed outside of the webserver directory for security
$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); // database connection parameters
include("../../include/get_parkcodes_dist.php"); // database connection parameters

mysqli_select_db($connection,$database);
include("menu.php");


$level=$_SESSION['divper']['level'];
echo "<table align='center'><tr>";

// Menu 1
unset($menuArray1);
$sql="select distinct left(tempID,1) as initial from emplist  order by tempID";
$result = mysqli_query($connection,$sql) or die ();
while ($row=mysqli_fetch_array($result))
	{$menuArray1[]=$row['initial'];}
$arrayInitial_c=array_unique($menuArray1);
sort($arrayInitial_c);
echo "<td align='center'><b>Last Name</b> begins with:<br>";
for ($n=0;$n<count($arrayInitial_c);$n++)
	{
	echo "<a href=\"~photoID.php?init_c=$arrayInitial_c[$n]\" target=\"_parent\">[ $arrayInitial_c[$n] ]</a>&nbsp;&nbsp;";
       }
   echo "</td></tr></table>";

if(@!$init_c AND @!$sel){exit;}


// ******** Enter your SELECT statement here **********

if(@$init_c){$where="left(t1.tempID,1) like '$init_c%' order by Lname,Fname";}

if(!isset($sel)){$sel="";}

if($sel=="x")
	{
	if(empty($_POST['passTempID'])){$_POST['passTempID']=array();}
	foreach($_POST['passTempID'] as $k=>$v)
		{
		$sql="UPDATE emplist set photoID='x' where tempID='$v'";
		$result = mysqli_query($connection,$sql);
		$sql="UPDATE nondpr set photoID='x' where tempID='$v'";
		$result = mysqli_query($connection,$sql);
		}
	$where="photoID = 'x'
	LIMIT 10";
	}

if($sel=="y")
	{
	$sql="UPDATE emplist set photoID='' where photoID='x'";
	$result = mysqli_query($connection,$sql);
	$sql="UPDATE nondpr set photoID='' where photoID='x'";
	$result = mysqli_query($connection,$sql);
	
	exit;
	}

$sql="SELECT t1.tempID, t1.photoID as photo,t2.Lname,t2.Nname,t2.Fname,t2.Mname, (t2.emid + 10000) as Number, t3.working_title, t1.currPark
FROM emplist as t1
LEFT JOIN empinfo as t2 on t1.tempID=t2.tempID
LEFT JOIN position as t3 on t1.beacon_num=t3.beacon_num
WHERE $where";
//echo "$sql<BR />"; //exit;
$result = mysqli_query($connection,$sql) or die ();
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}

$sql="SELECT t1.tempID, t1.add2 as photo,t1.Lname,t1.zip as Nname,t1.Fname,t1.zip as Mname, (t1.emid + 10000) as Number, 'nonDPR' as working_title, t1.currPark
FROM nondpr as t1
WHERE  currPark !='nonDPR' AND $where ";
//echo "$sql";
$result = mysqli_query($connection,$sql) or die ();
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	}
//echo "<pre>";print_r($ARRAY);echo "</pre>";exit;

if(!isset($init_c)){$init_c="";} // this results in ALL sigs being returned
// this happens when $sel=="x"

if(!empty($del_sig) and $del_sig=="y")
	{
	$sql="DELETE
	FROM photos.signature 
	WHERE personID='$tempID'";
	//echo "$sql";
	$result = mysqli_query($connection,$sql) or die ();
	}
$sql="SELECT t1.personID as tempID, t1.link as sig_link
FROM photos.signature as t1
WHERE left(t1.personID,1) like '$init_c%'";
// echo "$sql";
$result = mysqli_query($connection,$sql) or die ();
$num=mysqli_num_rows($result);
if(mysqli_num_rows($result)>0)
	{
	while($row=mysqli_fetch_assoc($result))
		{
		$SIG_ARRAY[$row['tempID']]=$row['sig_link'];
		}
	}
//echo "$num<pre>"; print_r($SIG_ARRAY); echo "</pre>";	exit;
if(empty($ARRAY)){echo "No one was added to the Print list."; exit;}
$fieldNames=array_values(array_keys($ARRAY[0]));
$fieldNames[]="Signature";
// $num=count($SIG_ARRAY);
$num_emp=count($ARRAY);


if(@$init_c)
	{
	$page="~photoID.php?sel=x";
	}
else
	{
	$page="/IDcard/printPhotoID.php";
	$page="/IDcard/printPhotoID.php";
	}

echo "<form name='frm' method='POST' action='$page'>";
//$num signatures
echo "<table border='1' cellpadding='2'><tr><td colspan='$num' align='center'>$num_emp employees <font color='red'></font></td></tr>";

echo "<tr><td></td>";
foreach($fieldNames as $k=>$v)
	{
	if(@$init_c){$type="Select";}else{$type="Print";}
	if($v=="tempID"){$v="$type";}
	$v=str_replace("_"," ",$v);
	echo "<th>$v</th>";
	}
echo "</tr>";

$j=0;
foreach($ARRAY as $k=>$v)
	{// each row
		// $fx = font color  and  $tr = row shading
	$f1="";$f2="";$j++;
	if(fmod($j,2)!=0){$tr=" bgcolor='aliceblue'";}else{$tr="";}
	
	
	echo "<tr><td>$j</td>";
		foreach($v as $k1=>$v1){// each field, e.g., $tempID=$v[tempID];
		$a="";
		if($k1=="photo"){
		$a=" align='center'"; $tempID=$v['tempID'];
		$v1="[ <a href='~viewPhotoID.php?tempID=$tempID' target='_blank'>view</a> ]";}
		
		if($k1=="tempID")
			{
			if($sel=="x"){$ck=" checked";}else{$ck="";}
			$a=" align='center'"; $v1="<input type='checkbox' name='passTempID[]' value='$v1'$ck>";
			}
		
		echo "<td$a>$v1</td>";
			}
		$fullName=$v['Fname']."_".$v['Lname'];
		if(array_key_exists($tempID,$SIG_ARRAY))
			{
			@$link=$SIG_ARRAY[$tempID];
			$v2="[ <a href='/divper/$link' target='_blank'>VIEW</a> ] [<a href='/divper/~photoID.php?init_c=$init_c&del_sig=y&tempID=$tempID'>Delete</a>]";
			$v2="[ <a href='/divper/$link' target='_blank'>VIEW</a> ] [<a href='/divper/~photoID.php?init_c=$init_c&del_sig=y&tempID=$tempID'>Delete</a>]";
			}
		else
			{
			$v2="[ <a href='/divper/addSig.php?tempID=$tempID&fullName=$fullName' target='_blank'>add</a> ]";
			$v2="[ <a href='/divper/addSig.php?tempID=$tempID&fullName=$fullName' target='_blank'>add</a> ]";
			}
		
		echo "<td align='center'>$v2</td>";
		
	echo "</tr>";
	}

if(@$init_c){$button="Add To List";}
if($sel)
	{
	$button="Print";
	$clear="<td colspan='2' align='center'>
	<FORM>
	<INPUT TYPE='button' name='submit' value='Clear Print List' onClick=\"parent.location='~photoID.php?sel=y'\">
	</FORM></td>";
	}
	else
	{$clear="";}

echo "<tr><td></td>
<td><input name='btn' type='button' onclick='CheckAll()' value='Check All'> </td>
<td><input name='btn' type='button' onclick='UncheckAll()' value='Uncheck All'> </td>
<td colspan='2' align='center'><input type='submit' name='submit' value='$button'></td></tr>";

echo "</table></form>$clear</body></html>";
?>
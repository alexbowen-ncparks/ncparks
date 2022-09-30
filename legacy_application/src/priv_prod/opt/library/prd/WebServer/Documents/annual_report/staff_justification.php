<?php
$database="annual_report";
include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       
//echo "<pre>"; print_r($_POST); print_r($_FILES); echo "</pre>";  exit;
//echo "<pre>";print_r($_FILES); echo "</pre>";  //exit;

session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$level=$_SESSION['annual_report']['level'];
if($level<2 and $_SESSION['annual_report']['tempID']!="King3993")
	{
	echo "The app has been locked while the DISUs and CHOP are reviewing. If you need access, let Tom H. know.";
	exit;}
echo "<html><head>";

echo "  <script language='JavaScript'>

<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+\".location='\"+selObj.options[selObj.selectedIndex].value+\"'\");
  if (restore) selObj.selectedIndex=0;
}

function confirmLink()
{
 bConfirm=confirm('Are you sure you want to delete this record?')
 return (bConfirm);
}

function toggleDisplay(objectID)
	{
	var inputs=document.getElementsByTagName('div');
		for(i = 0; i < inputs.length; i++)
		{
		
		var object = inputs[i];
		state = object.style.display;
			if (state == 'block')
		object.style.display = 'none';	
		}
		
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
	}

function toggleDiv(objectID)
	{	
	var object = document.getElementById(objectID);
	state = object.style.display;
	if (state == 'none')
		object.style.display = 'block';
	else if (state != 'none')
		object.style.display = 'none'; 
	}
function popitup(url) {
        newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=800,width=950');
        if (window.focus) {newwindow.focus()}
        return false;
}

function checkRadio (frmName, rbGroupName) { 
 var radios = document[frmName].elements[rbGroupName]; 
 for (var i=0; i <radios.length; i++) { 
  if (radios[i].checked) { 
   return true; 
  } 
 } 
 return false; 
} 

//-->
</script>
</head>";

extract($_REQUEST);

echo "<title>Staff Justification</title>";
@include("../css/TDnull.inc");
	
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
echo "<body><div>";


echo "<img src='test6.jpg'>";

$sql = "SELECT * FROM dpr_system.parkcode_names where status='independent' or park_code='MOJE'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql  ".mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$park_array[]=$row;
	}
//echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
if(@$_POST['submit']=="Submit" or @$_POST['submit']=="Update")
       		{
 //echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
       		$skip1=array("year","month","day","submit","id");
       			foreach($_POST AS $k=>$v)
       				{
				if(in_array($k,$skip1))
					{continue;}
				
				$v=addslashes($v);
				$clause.=$k."='".$v."',";
				}
				
       			$clause="set ".rtrim($clause,",");
			$sql = "REPLACE staff_just $clause";
//echo "$sql"; exit;
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ".mysqli_error($connection)); 
       		}
 


//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
if(@$_POST['submit']=="Delete")
		{
		$sql = "DELETE FROM tal where id='$_POST[id]'";
//echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		echo "Record was successfully deleted.";exit;
		}
       

if(!empty($_REQUEST['park_code']))
		{
		$sql = "SELECT * FROM staff_just where park_code='$_REQUEST[park_code]'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		$row=mysqli_fetch_assoc($result);
		extract($row);
		}
		

if(empty($_POST['justification']))
	{$action="Submit";}
	else
	{$action="Update";}
ECHO "<table>
<tr><td>Park: </td><td><select name='park_code' onChange=\"MM_jumpMenu('parent',this,0)\">
<option value='' selected></option>\n";
foreach($park_array as $index=>$array)
	{
	if($array['park_code']==$park_code){$s="selected";}else{$s="";}
	echo "<option value='staff_justification.php?park_code=$array[park_code]' $s>$array[park_name]</option>\n";
	}
echo "</select></td></tr>";

if(empty($park_code)){exit;}

echo "<form method='POST' action='staff_justification.php'>
<tr><td>Work Load Factors: </td>
<td><textarea name='justification' cols='130' rows='30'>$justification</textarea></td>
</tr>
<tr><td colspan='2' align='center'>
<input type='hidden' name='park_code' value='$park_code'>
<input type='submit' name='submit' value='$action'>
</td></tr>
</form>
</table>";
if($level>5)
	{echo "<a href='http://www.dpr.ncparks.gov/system_plan/print_pdf_work_load.php?parkcode=$park_code&rep=1' target='_blank'>Create PDF";}
if($level>4)
	{echo "<br />Long format <a href='http://www.dpr.ncparks.gov/system_plan/print_pdf_work_load_two.php?parkcode=$park_code&rep=1' target='_blank'>Create PDF";}
echo "</div></body></html>";
?>
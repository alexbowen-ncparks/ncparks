<html><head>
<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.23.custom.css" rel="Stylesheet" />
<script type="text/javascript" src="../js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../js/jquery-ui-1.8.23.custom.min.js"></script>

<script>
    $(function() {
        $( "#datepicker1" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker2" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker3" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker4" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker5" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker6" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $( "#datepicker7" ).datepicker({ dateFormat: 'yy-mm-dd' });
    });
</script>
<style>
.ui-datepicker {
  font-size: 80%;
}
</style>

<script type="text/javascript">	
function toggleDisplay(objectID)
	{
		var object = document.getElementById(objectID);
		state = object.style.display;
		if (state == 'none')
			object.style.display = 'block';
		else if (state != 'none')
			object.style.display = 'none'; 
	}
function confirmLink()
		{
		 bConfirm=confirm('Are you sure you want to delete this item?')
		 return (bConfirm);
		}

function confirmFile()
		{
		 bConfirm=confirm('Are you sure you want to delete this file?')
		 return (bConfirm);
		}
function open_win(url)
{
window.open(url)
}

function popitLatLon(url)
{   newwindow=window.open(url);
        if (window.focus) {newwindow.focus()}
        return false;
}
function popitup(url)
	{   newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=1024,width=1024,menubar=1,toolbar=1');
			if (window.focus) {newwindow.focus()}
			return false;
	}

function validateForm()
	{
	var x1=document.forms["pr63_form"]["date_occur"].value;
	if (x1==null || x1=="")
		  {
		  alert("INCIDENT DATE must be filled out.");
		  return false;
		  }
	var x2 = document.getElementById('loc_code');
	if (x2.selectedIndex == 0)
		  {
		  alert("LOCATION CODE must be filled out.");
		  return false;
		  }
	var x3=document.forms["pr63_form"]["report_by"].value;
	if (x3==null || x3=="")
		  {
		  alert("REPORTED BY must be filled out.");
		  return false;
		  }
	var x4=document.forms["pr63_form"]["incident_code"].value;
	if (x4==null || x4=="")
		  {
		  alert("INCIDENT CODE must be filled out.");
		  return false;
		  }
	var x5=document.forms["pr63_form"]["investigate_by"].value;
	if (x5==null || x5=="")
		  {
		  alert("COMPLETED BY must be filled out.");
		  return false;
		  }
	var x6 = document.getElementById('dpr_disp');
	if (x6.selectedIndex == 0)
		  {
		  alert("DPR DISPOSITION must be filled out.");
		  return false;
		  }
	
	}


function MM_jumpMenu(targ,selObj,restore)
	{ //v3.0
	  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
	  if (restore) selObj.selectedIndex=0;
	}

</script>
</head>
<title>NC DPR Incident / Action Database</title>
<?php
ini_set('display_errors',1);
session_start();
// echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//extract($_REQUEST);
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;

@$level=$_SESSION['le']['level'];
if($level<1)
	{
	echo "To view a PR-63 you must be logged into the PR-63 / DCI / CITE database - <a href='https://10.35.152.9/le/index.html'>login</a>.";
	echo "To view a PR-63 you must be logged into the PR-63 / DCI / CITE database - <a href='https://10.35.152.9/le/index.html'>login</a>.";
	exit;
	}
$tempID=$_SESSION['le']['tempID'];
$beacon_num=$_SESSION['le']['beacon'];
@$beacon_title=$_SESSION['le']['beacon_title'];
@$at_park=$_SESSION['le']['select'];

$database="le";
// include("../../include/get_parkcodes_reg.php");
include("../../include/get_parkcodes_dist.php");

mysqli_select_db($connection,"le");




$sql="Select id as image_id, parkcode, image_name, link From `le_images` where pr63_id='$id'";
 $result = @mysqli_QUERY($connection,$sql) or die(mysqli_error($connection));
while($row=mysqli_fetch_assoc($result))
	{
	$ARRAY[]=$row;
	}
$skip=array();
$c=count($ARRAY);
echo "<table>";
if(empty($full))
	{
	echo "<tr><td>$c</td><td><a href='pr63_images.php?id=$id&full=yes'>Export Images</a> for PDF / printing</td></tr>";
	}
foreach($ARRAY AS $index=>$array)
	{
	if($index==0)
		{
		echo "<tr>";
		foreach($ARRAY[0] AS $fld=>$value)
			{
			if(in_array($fld,$skip)){continue;}
			echo "<th>$fld</th>";
			}
		echo "</tr>";
		}
	echo "<tr>";
	foreach($array as $fld=>$value)
		{
		if(in_array($fld,$skip)){continue;}
		if($fld=="link")
			{
// 			$im=$ARRAY[$index]['image_id'];
			$full_link=$value;
			$path_parts=pathinfo($value);
			$tn=$path_parts['dirname']."/ztn.".$path_parts['basename'];
			$tn=str_replace(".pdf",".jpg",$tn);  // if original image was a PDF

			$value="view full-size <a href='$value' target='_blank'>image</a>&nbsp;&nbsp;&nbsp;<img src='$tn'><br /><br />";
			if(!empty($full))
				{
				$value="<img src='$full_link'>";
				}
			}
		echo "<td>$value</td>";
		}
	echo "</tr>";
	}
echo "</table>";
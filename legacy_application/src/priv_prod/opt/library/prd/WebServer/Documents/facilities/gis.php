<?php
ini_set('display_errors',1);
//These are placed outside of the webserver directory for security
//include("../../include/authDIVPER.inc"); // used to authenticate users
//include("../../include/connectDIVPER.inc"); // database connection parameters
extract($_REQUEST);

//print_r($_REQUEST);

//echo "id=$id";
//Exit;

//$level=$_SESSION['divper']['level'];

if(@$source=="gis"){@$level=1;}

if(@$level<3)
	{		$ignore=array("Link");
	$readonly=array("GIS_ID","PARK_ABBR","FAC_NAME","SUB_UNIT","FAC_TYPE");
	}
	else
	{	
	$readonly=array("GIS_ID");
	}
	
if(@$rep=="")
	{
	$database="facilities";
include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parameters
mysql_select_db($database, $connection); // database 

	
		$sql = "SHOW COLUMNS FROM gis";//echo "$sql";
		$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
		$numFlds=mysql_num_rows($result);
		while ($row=mysql_fetch_assoc($result))
		{
		if(in_array($row['Field'],$ignore)){continue;}
		$fieldArray[]=$row['Field'];
		}
		
	}

if(@$GIS_ID!="")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
	
	
	$field_list=implode(",",$fieldArray);
	$like=array("pac_comments","pac_nomination","general_comments","pac_nomin_comments");
	
	$sql="SELECT $field_list from gis
	where GIS_ID='$GIS_ID'
	"; //echo "$sql";
	
	$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
	$num=mysql_num_rows($result);
	
	if($num<1){$message="No record found using $arraySet";}
		
	while($row=mysql_fetch_assoc($result))
		{
		extract($row);
		}
	
	}// end Find
else
{
exit;
}

echo "<form action='gis_update.php' method='POST'>
	<table border='1' cellpadding='5'>";
	
		include("gis_form.php");

if(!isset($GIS_ID)){$GIS_ID="";}	
echo "<tr>
	<td colspan='5' align='center'>
	<input type='hidden' name='GIS_ID' value='$GIS_ID'>
	<input type='submit' name='submit_label' value='Update' style=\"background-color:lightgreen;width:65;height:35\"></td>
	</form>";
/*	
	echo "<form action='find.php'>
	<td colspan='2' align='center'>
	<input type='submit' name='submit_label' value='Go to Find' style=\"background-color:lightblue;width:75;height:35\"></td>
	</tr></form>";
*/
echo "</table></body></html>";

?>
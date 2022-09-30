<?php
// ini_set('display_errors',1);
if(@$_POST['reset']=="Reset")
	{
	header("Location: track.php?database=annual_report&submit=Track+a+Request"); exit;
	}

$tab="Track Request";
if(@$_POST['rep']==""){include("menu.php");}

//echo "<pre>"; print_r($_POST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
@$limit_park=$_SESSION['annual_report']['select'];
if(@$_SESSION['annual_report']['accessPark'] != "")
	{
	$limit_park=$_SESSION['annual_report']['accessPark'];
	}

$database="annual_report";
include("../../include/iConnect.inc");// database connection parameters


$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");


			
if(@$_POST['rep']=="")
	{
	if(@$f_year==""){$f_year="0910";}
	$sql = "SELECT distinct park_code FROM task as t1 
	WHERE  1 and f_year='$f_year' order by park_code"; //echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
		while($row=mysqli_fetch_assoc($result))
			{$location_array[]=$row['park_code'];}
			
	$sql = "SELECT distinct f_year FROM task as t1 
	WHERE  1 order by f_year";// echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
		while($row=mysqli_fetch_assoc($result))
			{$f_year_array[]=$row['f_year'];}		
	// ********** Filter row ************
		echo "<div align='center'><form method='POST' action='edit.php'><table border='1' cellpadding='3'><tr>";
	
	
	$dist_array=array("EADI","NODI","SODI","WEDI","STWD");
	$status_array=array("Approved","Not Approved","Pending");

					echo "<td align='center'>Year<br /><select name='f_year' onChange=\"MM_jumpMenu('parent',this,0)\"><option select=''></option>";
					foreach($f_year_array as $i_da=>$v_da)
						{
						if($f_year==$v_da)
							{$s="selected";}else{$s="value";}
						echo "<option $s='find.php?database=annual_report&f_year=$v_da'>$v_da</option>";
						}
					echo "</select><td>";
		
	/*	
					echo "<td><select name='district'><option select=''></option>";
					foreach($dist_array as $i_da=>$v_da)
						{
						if($_POST['district']==$v_da)
							{$s="selected";}else{$s="value";}
						echo "<option $s='$v_da'>$v_da</option>";
						}
					echo "</select><td>";
	*/	
				if($f_year!=""){
					echo "<td align='center'>Park<br /><select name='park_code'><option select=''></option>";
					foreach($location_array as $i_la=>$v_la)
						{
						if(@$_POST['park_code']==$v_la)
							{$s="selected";}else{$s="value";}
						echo "<option $s='$v_la'>$v_la</option>";
						}
					echo "</select></td>";
					}
				echo "</tr>";
					
		
			if($level>3)
				{
				$excel="Excel <input type='checkbox' name='rep' value='excel'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				}
			echo "<tr><td align='center' colspan='6' align='center'>
			<input type='submit' name='submit' value='Find'>
			</td>";
			
	echo "</tr></table></form></div>";	
	}
	
?>
<?php
//ini_set("display_errors",1);
// extract($_REQUEST);

session_start();

$p=@$_SESSION['sap']['select'];
$multi_park_array=explode(",",@$_SESSION['sap']['accessPark']);
$lev=@$_SESSION['sap']['level'];
if($lev<1){exit;}

include("../../include/iConnect.inc");// database connection parameters
$database="sap";
mysqli_select_db($connection,$database)
       or die ("Couldn't select database");

// Forms to be dowloaded are stored in FIND #271
$dbTable="permits";
$file=$dbTable.".php";
$fileMenu=$dbTable."_menu.php";

//echo "<pre>";print_r($_REQUEST);print_r($_SESSION);echo "</pre>"; //exit;

// ******** Update Record ***********
if(isset($submit) and $submit=="delete")
	{
	$sql = "SELECT link as delete_this FROM $dbTable WHERE id='$id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 3. ");
		$row = mysqli_fetch_assoc($result);
		extract($row); //echo " $id $delete_this";exit;
		if($delete_this!="")
			{ 
			unlink($delete_this);
			$sql = "UPDATE $dbTable set link='' WHERE id='$id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 3.");
			}
	}
// ******** Update Record ***********
if(isset($submit) and $submit=="Update")
	{
// 	echo "<pre>";print_r($_REQUEST);echo "</pre>"; exit;
	// FIELD NAMES are stored in $fieldArray
	$sql = "SHOW COLUMNS FROM $dbTable";//echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. ");
	while ($row=mysqli_fetch_assoc($result))
		{
		if($row['Field']=="link"){continue;}   // the loop below will blank out link if this isn't skipped
		$fieldName[]=$row['Field'];
		}
	
	$updateFields="SET ";
	for($i=0;$i<count($fieldName);$i++)
		{
		$tf=str_replace(".","_",$fieldName[$i]);
		@$eField=${$tf};
		$eField=html_entity_decode($eField);
		
		if($fieldName[$i]!="id" AND $fieldName[$i]!="permit_number"){
		if($i==1){$updateFields.="`".$fieldName[$i]."`='".$eField."'";}
		else{$updateFields.=",`".$fieldName[$i]."`='".$eField."'";}
		}// end if fieldName
		}// end for
	//echo "$updateFields";exit;
	
	$query="UPDATE $dbTable $updateFields where id=$editID";
// 	echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query 1. ");
	header("Location: permits.php?e=1&id=$editID");
	exit;
	}

// ******** Add Record ***********
if(isset($submit) and $submit=="Add")
	{
	date_default_timezone_set('America/New_York');
	$checkEntry="You must complete the entry for: <br>";
	$nb="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	if($begin_date==""){$a="$nb the beginning date<br>";}
	if($coord==""){$b="$nb the coordinator for the permit<br>";}
	if($activity==""){$c="$nb the type of activity<br>";}
	$ckYear=date("Y");
	//if($permit_year!=$ckYear){$d="$nb the year is incorrect";}
	@$x=$a.$b.$c.$d;
	if($x!=""){$checkEntry.=$x;
	echo "$checkEntry<br>Click your Browser's Back Button.";exit;}
	
	//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
	// FIELD NAMES are stored in $fieldArray
	$sql = "SHOW COLUMNS FROM $dbTable";//echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. $sql");
	while ($row=mysqli_fetch_assoc($result))
	{$fieldName[]=$row['Field'];}
	//extract($row);
	// Get last permit number
	$sql = "SELECT permit_number from $dbTable where permit_year='$permit_year' order by id desc limit 1";
	//echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 1. ");
	$numFlds=mysqli_num_rows($result);
	
	while ($row=mysqli_fetch_assoc($result))
	{extract($row);$permit_number=$permit_number+1;}
	If($numFlds<1){$permit_number=1;}
	
	$updateFields="SET ";
	for($i=0;$i<count($fieldName);$i++)
		{
		$tf=str_replace(".","_",$fieldName[$i]);
		@$eField=${$tf};
		// if($fieldName[$i]=="activity"){$eField=addslashes($eField);}
// 		if($fieldName[$i]=="coord"){$eField=addslashes($eField);}
		$permit_status="approved";// makes it the default
		
		if($fieldName[$i]!="id")
			{
			if($i==0){$updateFields.="`".$fieldName[$i]."`='".$eField."'";}
			else{$updateFields.=",`".$fieldName[$i]."`='".$eField."'";}
			}// end if fieldName
		}// end for
	//echo "$updateFields";exit;
	
	$query="INSERT INTO $dbTable $updateFields";
//	echo "$query";exit;
	$result = mysqli_query($connection,$query) or die ("Couldn't execute query 1. ");
	header("Location: $file?findYear=$permit_year&permit_number=$permit_number&submit=Find");
	exit;}

include("$fileMenu");// necessary to place this AFTER update script

// ******** Show Record to Edit ***********
if(isset($e) and $e==1)
	{
	// FIELD NAMES are stored in $fieldArray
	// FIELD TYPES and SIZES are stored in $fieldType
	$sql = "SHOW COLUMNS FROM $dbTable";//echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 2. ");
	$numFlds=mysqli_num_rows($result);
	while ($row=mysqli_fetch_assoc($result))
	{extract($row);$fieldName[]=$row['Field'];$fieldType[]=$row['Type'];}
	
	
	echo "<table border='1' cellpadding='3' align='center'>
	<form>";
	$sql = "SELECT * FROM $dbTable WHERE id='$id'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 3. ");
		$row = mysqli_fetch_array($result);
// 		echo "$sql";
	//echo "<pre>";print_r($row);echo "</pre>";// extract($row); 
	
	for($i=0;$i<count($fieldName);$i++)
		{
		$tf=$row[$i];
		$fnu=strtoupper($fieldName[$i]);
		if($fnu=="PERMIT_NUMBER"){$permit_number=$tf;}
		if($fnu=="PARK"){$parkcode=$tf;}
		if($fnu=="LINK")
			{
			if(!$tf){continue;}
			$tf="<a href='$tf' target='_blank'>$tf</a>  &nbsp;&nbsp;&nbsp;<a href='/sap/permits.php?e=1&id=$id&submit=delete' onClick='return confirmLink()'>delete</a> ";
			}
		echo "<tr><td><b>$fnu</b></td>";
		if($fieldName[$i]!="id" AND $fieldName[$i]!="permit_number" AND $fieldName[$i]!="link")
			{
			if($fieldName[$i]=="permit_status")
				{
				if($tf=="approved"){$val1="checked";}else{$val1="";}
				if($tf=="denied"){$val2="checked";}else{$val2="";}
				if($tf=="revoked"){$val3="checked";}else{$val3="";}
				if($tf=="void"){$val4="checked";}else{$val4="";}
				$tf1="<input type='radio' name='permit_status' value='approved' $val1>";
				$tf2="<input type='radio' name='permit_status' value='denied' $val2>";
				$tf3="<input type='radio' name='permit_status' value='revoked' $val3>";
				$tf4="<input type='radio' name='permit_status' value='void' $val4>";
				echo "<td>$tf1 Approved $tf2 Denied $tf3 Revoked $tf4 Void</td>";
				}
			else {
				echo "<td><input type='text' name='$fieldName[$i]' value=\"$tf\" size='75'></td></tr>";
				}
			}
		else
			{echo "<td>$tf</td></tr>";}
		}
	
    
	echo "<tr><td>&nbsp;</td><td align='center'>
	<input type='hidden' name='editID' value='$id'>
	<input type='hidden' name='permit_number' value='$permit_number'>
	<input type='submit' name='submit' value='Update'>
	</form></td></tr></table>";
	
	echo "<table><tr><form method='post' action='upload_file.php' enctype='multipart/form-data'>
	<td></td>
	<td>Upload a scanned PDF copy of the SAP.
	<INPUT TYPE='hidden' name='id' value='$id'>
    <input type='file' name='file_upload'  size='40'> Then click this button. 
    <input type='hidden' name='permit_number' value='$permit_number'>
    <input type='hidden' name='parkcode' value='$parkcode'>
	<input type='submit' name='submit' value='Add File'>
    </form></td></tr></table>";
	exit;}

// ******* Blank Form *************
if(isset($submit) and $submit=="Obtain a Permit Number")
	{
	// FIELD NAMES are stored in $fieldArray
	// FIELD TYPES and SIZES are stored in $fieldType
	$sql = "SHOW COLUMNS FROM $dbTable";//echo "$sql";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 2. ");
	
	$permit_year=date("Y");
	
	while ($row=mysqli_fetch_assoc($result))
		{
		if($row['Field']=="link"){continue;}
		$fieldName[]=$row['Field'];
		$fieldType[]=$row['Type'];
		}
	
	echo "<table border='1' cellpadding='3' align='center'><form>";
	
	for($i=0;$i<count($fieldName);$i++)
		{
		if($fieldName[$i]=="id" || $fieldName[$i]=="permit_status"){}
		else
			{
			$fnu=strtoupper($fieldName[$i]);
			
			if($fieldName[$i]=="end_date"){$fn="<b>$fnu</b><br>Leave blank if only for a day";}else{$fn="<b>$fnu</b>";}
			if($fieldName[$i]=="coord"){$fn="<b>DIVISION COORDINATOR</b>";}
			echo "<tr><td align='right'>$fn</td>";
			
			if($fieldName[$i]=="permit_year" AND $level<4 AND @$ny!="new")
				{
				$tf=$permit_year;
				$tSize="4";
				$RO="READONLY";
				}
				else
				{
				$tf="";$tSize="45";$RO="";
				}
			
			if($fieldName[$i]=="park"){$tf=$p;}
			
			if($fieldName[$i]=="permit_number")
				{
				echo "<td>Complete this form and Click the \"Add\" Button.</td></tr>";
				}
			else
				{
				if($fieldName[$i]=="permit_year")
					{
					if(@$ny=="new")
						{
						$tf=$permit_year+1;
						$tSize="4";
						}
						else
						{$tf=$permit_year;}
			//		
					$py="<br />If you need to issue a permit for a year later than $permit_year,<br />click this <a href='permits.php?ny=new&submit=Obtain a Permit Number'>link</a>.";
					}
					else
					{
					$py="";
					}
				echo "<td><input type='text' name='$fieldName[$i]' value='$tf' size='$tSize'$RO>$py</td></tr>";
				}
			}// end if else $fieldName == id or permit_status
		}// end for
	
	if(!isset($id)){$id="";}
	echo "<tr><td>&nbsp;</td><td align='center'>
	<input type='hidden' name='editID' value='$id'>
	<input type='submit' name='submit' value='Add'>
	</form></td></tr></table>";
	//print_r($fieldType);
	exit;}


// ******** Show Results ***********
// FIELD NAMES are stored in $fieldArray
// FIELD TYPES and SIZES are stored in $fieldType
$sql = "SHOW COLUMNS FROM $dbTable";//echo "$sql";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 4. ");
$numFlds=mysqli_num_rows($result);
while ($row=mysqli_fetch_assoc($result))
	{
	$fieldName[]=$row['Field'];
	$fieldType[]=$row['Type'];
	}

if(!isset($submit))
	{
	$park=$_SESSION['sap']['select'];
	if($park=="ARCH"||$park=="YORK")
		{
//		$submit="Show All";
		$park1="";
		}
		else
		{
		$submit="Find";
		$park1=$park;
		}
//	echo "1";exit;
	}
	else
	{
	$submit="Find";
	$park1=$park;
	}
//print_r($fieldName);

if(isset($submit) and ($submit=="Find"||$submit=="Show All"))
	{
	if(empty($order)){$order="";}
	$where="Where 1";
	if($park1!=""){$where.=" and park='$park1'";}
	if(strtoupper($park)=="FALA" AND $order=="bd") // Begin date
		{
		$where="where park='FALA'
		and length(substring_index(begin_date,'/',-1))=4";
		}
	if(isset($permit_number)){$where.=" and permit_number='$permit_number'";}
	if(!empty($activity)){$where.=" and activity like '%$activity%'";}
	
	if(@!$findYear)
		{
		$findYear=date('Y');
		}
	if(@$order)
		{
		$orderBy="order by park,permit_number";
		if($order=="bd" and strtoupper($park)=="FALA")
			{
			$orderBy="order by substring_index(begin_date,'/',-1) desc, substring(lpad(begin_date,2,0), 1,2) desc, mid(begin_date, 4,2) desc";
			}
		}
		else
		{
		$orderBy="order by permit_number DESC";
		}
	
	$query = "SELECT * FROM $dbTable $where and permit_year='$findYear' $orderBy";
	
// echo "$query"; // ************ 
	
	$result = @mysqli_QUERY($connection,$query);
	
	if(strtoupper($park)==strtoupper($p)){$lev=4;}
	
	$c=mysqli_num_rows($result);
	
	echo "<table border='1' cellpadding='3' align='center'>
	<tr><td colspan='10'>$c permits</td></tr><tr>";
	for($i=0;$i<count($fieldName);$i++)
		{
		$fn=strtoupper($fieldName[$i]);
		$fn=str_replace("_"," ",$fn);
		echo "<th>$fn</th>";
		}
	echo "</tr>";
	
	//$y=date("y");
	while($row = mysqli_fetch_assoc($result))
		{
//		echo "<pre>";print_r($row);echo "</pre>";exit;
		echo "<tr>";
		foreach($row as $key=>$value)
			{
			$tf=$value;
			if($key=="permit_number")
				{
				$y=substr($row['permit_year'],2,2);
				$t=str_pad($value,3,"0",STR_PAD_LEFT);
				$tf="<font color='blue'>S".$y."-".$value."</font>";
				}
			
			if($key=="id")
				{
				if(($lev>0 AND $row['park']==$p) OR ($lev>1) OR in_array($row['park'],$multi_park_array))
					{$tf="<a href='permits.php?e=1&id=$value'>$value</a>";}
				}
				
				
			if($key=="link")
				{
				$tf="<a href='$tf' target='_blank'>$tf</a>";
				}
			echo "<td align='center'>$tf</td>";
			}
		echo "</tr>";
		}// end while
	
	echo "</table>";
	}// end if

echo "</div></body></html>";

?>
<?php

$database="partf";

//echo "<pre>"; print_r($_REQUEST); echo "</pre>";

include("../../include/auth.inc"); // used to authenticate users

include("../../include/iConnect.inc");// database connection parameters
$db = mysqli_select_db($connection,$database)
   or die ("Couldn't select database");

if($level<3){exit;}

if(!empty($_POST))
	{
	$clause="set ";
	$skip=array("id","submit");
	
	foreach($_POST AS $fld=>$v)
		{
		if(in_array($fld,$skip)){continue;}
		$v=str_replace(",","",$v);
		$v=str_replace("$","",$v);
		$v=addslashes($v);
		$clause.="`$fld`='".$v."',";
		}
	$clause=rtrim($clause,",");
	$id=$_POST['id'];
	$sql="UPDATE `grants` $clause where id='$id'"; //echo "$sql";exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	header("Location: grants.php?submit=Update&id=$id&m=1");
	}
	
extract($_REQUEST);

/*		$sql="SELECT distinct sponsor
		from grants
		where 1 order by sponsor"; //echo "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql<br /><br />$where");
		while($row=mysqli_fetch_assoc($result))
			{
			$sponsor_array[]=$row['sponsor'];
			}
*/
		$sql="SELECT distinct county
		from grants
		where 1 order by county"; //echo "$sql"; //exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql<br /><br />$where");
		while($row=mysqli_fetch_assoc($result))
			{
			$county_array_add[]=$row['county'];
			}
			$county_array_add[]="Washington";
			sort($county_array_add);
			
	
		$status_array=array("Active","Closed","Withdrawn");
		
if(!empty($m)){echo " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color='green'>Update successful.</font>";}

$no_edit=array("id");

echo "<form action='edit_grant.php' method='POST'><table align='center'>";
$sql="SELECT * from `grants` where id='$id'";
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
while($row=mysqli_fetch_assoc($result))
	{
	foreach($row as $fld=>$value)
		{
		if(!in_array($fld,$no_edit))
			{
			$input="<input type='text' name='$fld' value='$value' size='45'>";
				
			if($fld=="county")
				{
				$input="<select name='$fld'><option selected=''></option>\n";
				foreach($county_array_add as $k=>$v)
					{
					if($v==$value){$s="selected";}else{$s="";}
					$input.="<option $s='$v'>$v</option>\n";
					}
				$input.="</select>";
				}
			if($fld=="grant_status")
				{
				$input="<select name='$fld'><option selected=''></option>\n";
				foreach($status_array as $k=>$v)
					{
					if($v==$value){$s="selected";}else{$s="";}
					$input.="<option $s='$v'>$v</option>\n";
					}
				$input.="</select>";
				}
			}
			else
			{$input=$value;}
			
		echo "<tr><td>$fld</td><td>$input</td></tr>";
		}
	}
echo "<tr><td colspan='2' align='center'>
<input type='hidden' name='id' value='$id'>
<input type='submit' name='submit' value='Update'>
</td></tr>";
echo "</table><form></body></html>";	
	
?>
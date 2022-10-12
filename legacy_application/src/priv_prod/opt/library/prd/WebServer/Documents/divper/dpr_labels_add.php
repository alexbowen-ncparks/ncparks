<?php
ini_set('display_errors',1);
$database="divper";
//include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
include("../../include/get_parkcodes_reg.php"); 
mysqli_select_db($connection,'divper'); // database
// extract($_REQUEST);

if($submit_label=="Add")
	{
//	echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
	// ****** Create Array of couplets for Insert/Update **********

	if(!$_POST['add_cat'])
		{
			//$fieldArray=$_POST;
			$message="The record was NOT added. You must select at least one Affiliation.";
			}
	
	else
		{
		$ignore=array("id","custom","affiliation_code","affiliation_name");
		
		if(empty($fieldArray))
			{
			$sql = "SHOW COLUMNS FROM labels";//echo "$sql";
			$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
			$numFlds=mysqli_num_rows($result);
			while ($row=mysqli_fetch_assoc($result))
				{
			//	extract($row);//print_r($row);
				$check=substr($row['Field'],0,4);
				if($check!="pac_"){$fieldArray[]=$row['Field'];}
				}
			}

		for($i=0;$i<count($fieldArray);$i++){
		@$val=${$fieldArray[$i]};// force the variable
		$val=trim($val," ");
		if($fieldArray[$i]=="pac_nomin_month"){$val=str_pad($val,2,"0", STR_PAD_LEFT);}
		$val="'".$val."'";
		if(in_array($fieldArray[$i],$ignore)){continue;}
		@$arraySet.=",".$fieldArray[$i]."=".$val;
			}
		$arraySet=trim($arraySet,",");
		$query = "INSERT into labels SET $arraySet";
	//	echo $query; exit;
		$result = mysqli_query($connection,$query) or die ("Couldn't execute query. $query");
		$id=mysqli_insert_id($connection);
		
		foreach($add_cat as $k=>$v){
		$sql="INSERT into labels_affiliation set person_id='$id', affiliation_code='$v'";
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
		}
// 		exit;
			header("Location: dpr_labels_find.php?message=Submission successful.&id=$id&submit_label=Find");
			exit;
			}
		
	}// end submit_label

include("menu.php");

include("dpr_labels_base.php");


// ****** Show Input form **********

echo "<form action='dpr_labels_add.php' method='POST'><table border='1' cellpadding='5'>";

include("dpr_labels_form.php");

echo "<tr>
<td colspan='2' align='right'><input type='submit' name='submit_label' value='Add' style=\"background-color:lightgreen;width:65;height:35\"></td>
</form>";

$target_file="dpr_labels_find.php";
if(@$db_source=="donation")
	{
	$target_file="/donation/donor_add.php";
	}
echo "<form action='$target_file'><td align='right'>";
echo "<input type='submit' name='submit_label' value='Go to Find'></td></tr></form>
</table></body></html>";

?>
<?php

$database="divper";
include("../../include/auth.inc"); // used to authenticate users
include("../../include/iConnect.inc"); 
include("../../include/get_parkcodes_dist.php");
mysqli_select_db($connection,'divper'); // database

//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
//	echo "<pre>"; print_r($_SERVER); echo "</pre>";  //exit;
extract($_REQUEST);

$level=$_SESSION['divper']['level'];

if(@$rep=="")
	{
	include("menu.php");
//	include("base_form.php");
	}
	else
	{
	$fieldArray=array("park","affiliation_code","First_name","Last_name");
	}

if(@$submit_label=="Find")
	{
// echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
	
	$ignore=array("id","custom","affiliation_code","affiliation_name");
	
	$like=array("date_donation_received","donor_organization","pac_comments","pac_nomination","general_comments","pac_nomin_comments","material_donation_description");
	
	$arraySet="1";
	$passQuery="";

if(!isset($fieldArray))
	{
	$sql="SELECT labels.*, t2.affiliation_code, t2.affiliation_name
				from labels
				LEFT JOIN labels_affiliation as t1 on t1.person_id=labels.id
				LEFT JOIN labels_category as t2 on t2.affiliation_code=t1.affiliation_code
				where 1
				limit 1";
	
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));
		$row=mysqli_fetch_assoc($result);
	
		foreach($row as $k=>$v)
			{
			$fieldArray[]=$k;
			}
	}
$fieldArray[]="date_donation_received";
//echo "<pre>"; print_r($_GET); echo "</pre>"; // exit;
	for($i=0;$i<count($fieldArray);$i++)
		{
		@$val=${$fieldArray[$i]};// force the variable
		if(in_array($fieldArray[$i],$ignore) OR $val==""){continue;}
		
		
		// Like
		if(in_array($fieldArray[$i],$like))
			{
			$arraySet.=" and ".$fieldArray[$i]." like '%".$val."%'";
			$passQuery=$fieldArray[$i]."=".$val."&";
			if($fieldArray[$i]=="date_donation_received")
				{
				$arraySet.=" and donation_recipient!='To a Friends Group'";
				$passQuery.="donation_recipient!=To a Friends Group&";
				}
			}
		
			else
			{
		// Equals
			$val="'".$val."'";
			$var_park="";
			if($fieldArray[$i]=="park")
				{
				$var_park="and t3.park_code=$val";
				$fieldArray[$i]="t3.park_code";
				$arraySet.=" and (t3.park_code=".$val." or t4.park_code=".$val.")" ;
				continue;
				}
			if($fieldArray[$i]=="donor_type"){$val=str_replace("_"," ",$val);}
			$arraySet.=" and ".$fieldArray[$i]."=".$val;
			$passQuery=$fieldArray[$i]."=".$val."&";
			}
		}
	
	//echo "<pre>"; print_r($add_cat); echo "</pre>"; // exit;
	
	if($arraySet==""){$arraySet="1";}
//	echo "a=$arraySet";
	
	if(@$add_cat)
		{
		$pac_array=array("PAC","PAC_nomin","PAC_FORMER");
			$arraySet.=" AND (";
			foreach($add_cat as $key=>$value)
				{
				if(in_array($value,$pac_array)){// used in dpr_labels_many.php
				$show_pac_nomin_comments=1;}
				$arraySet.="t1.affiliation_code='".$value."' OR ";
				@$passQuery.="add_cat[$key]=".$value."&";
				}
		$arraySet=trim($arraySet," OR ").")";
		}
	
	if(@$id){$arraySet="1 and labels.id='$id'";}
	
//	if($passQuery){$arraySet=urldecode($passQuery);}
	

		$orderBy="order by park_code,t1.affiliation_code,Last_name";
	
	//	$orderBy="order by park,t1.affiliation_code,Last_name";
		
	
	if($level<2 AND @$show_pac_nomin_comments=="1")
		{
		$asheArray=array("MOJE","NERI");
		$bladenArray=array("JONE","SILA");
		$rp=$_SESSION['divper']['select'];
		if($rp!="ARCH"){
		$restrictPark=" and park='$rp'";}
		if(in_array($rp,$asheArray)){
				$restrictPark=" and (park='MOJE' OR park='NERI')";}
		if(in_array($rp,$bladenArray)){
				$restrictPark=" and (park='JONE' OR park='SILA')";}
		}
	
$sql="SELECT person_id as id,affiliation_code as code from labels_affiliation";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql");
	while($row=mysqli_fetch_assoc($result))
		{
		$test=$row['code']."*".$row['id'];
		$affiliation_code_array[$test]=$row['id'];
		}
//echo "<pre>";print_r($affiliation_code_array);echo "</pre>";	exit;

//if(in_array("470",$affiliation_code_array)){echo "Hello";exit;}
// The above query is not necessay if using MySQL 4.1 or greater
// Use GROUP_CONCAT instead

if(!empty($sort)){$orderBy="order by donor_organization ";}

if(!isset($restrictPark)){$restrictPark="";}

$where="";
if(isset($source))
	{
	if($source=="graph")
		{
		$where="and (t3.financial_donation_amount!='0.00' or t3.material_donation_amount!='0.00' or t3.land_donation_amount!='0.00')";
		}
	}

//echo "a=$arraySet    ";// exit;
	if($arraySet=="1")
		{
		$arraySet="1 and t1.affiliation_code='DONOR'";
		}
	$join_t2="";
	if(@$source_db=="donation")
		{
		$join_t2="and t1.affiliation_code='DONOR'";
		if(!empty($_REQUEST['material_donation_description']))
			{
			$join_t2.="and t3.material_donation_description LIKE '%$_REQUEST[material_donation_description]%'";
			}
		if(!empty($_REQUEST['financial_donation_description']))
			{
			$join_t2.="and t3.financial_donation_description LIKE '%$_REQUEST[financial_donation_description]%'";
			}
		}
//echo "b=$arraySet"; exit;

if(!isset($var_park)){$var_park="";}

$donor_donation_amt="and (t3.material_donation_amount>0 or t3.land_donation_amount>0 or t3.financial_donation_amount>0)";
if(!empty($_POST['material_donation_description']))
	{
	$donor_donation_amt="";
	}

$order_by="date_donation_received desc";
if(!empty($sort)){$order_by="$sort";}
	$sql="SELECT  temp.id, temp.donor_type, temp.park_code, sum(temp.financial) as financial, sum(temp.material) as material,  sum(temp.land) as land,  temp.First_name, temp.Last_name, temp.donor_organization, temp.address, temp.city, temp.state, temp.zip, temp.phone, temp.email, temp.website, 
	if(temp.material_desc!='', concat(temp.general_comments, '<br />', temp.material_desc), temp.general_comments) as general_comments, temp.date_donation_received
	

from
	(
	SELECT distinct t0.id, t0.First_name, t0.Last_name, t0.donor_organization, t0.donor_type, t3.park_code, (t3.financial_donation_amount) as financial, (t3.material_donation_amount) as material, (t3.material_donation_description) as material_desc, (t3.land_donation_amount) as land, t0.address, t0.city, t0.state, t0.zip, t0.phone, t0.email, t0.website, t0.general_comments , t3.date_donation_received

	from labels as t0

	LEFT JOIN labels_affiliation as t1 on t1.person_id=t0.id 

	LEFT JOIN donor_donation as t3 on t3.id=t1.person_id $donor_donation_amt $var_park

	LEFT JOIN donor_contact as t4 on t4.id=t1.person_id 
	where $arraySet $restrictPark
	$where $join_t2
	)
	as temp
	group by temp.id
	order by $order_by
	"; 
// echo "$sql"; //exit;

	
if($_SESSION['divper']['level']>6 AND @$rep=="")
	{
	echo "$sql<br />";

	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 181. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
	echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	exit;
	}
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 181. $sql ".mysqli_error($connection));
	$num=mysqli_num_rows($result);
if(!empty($rep))
	{
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 181. $sql ".mysqli_error($connection));
	while($row=mysqli_fetch_assoc($result))
		{
		$ARRAY[]=$row;
		}
// 	echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
	
		include("dpr_labels_many.php"); 
		exit;
	}
	
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query 181. $sql ".mysqli_error($connection));
	$num=mysqli_num_rows($result);
		
	if($num<1)
		{
		
$how_contact_array=array("Phone","Email","Letter","Meeting");
$donor_typeArray=array("Individual/Family","Civic Group/Club","Non-Profit","Corporation/Business","Foundation","General Public","Sponsor"); // also used in divper/form.php
$donation_type_array=array("Financial","Land","Material");
$donation_recipient_array=array("Park","Division","PARTF","Friends Group");
$recognition_array=array("Public Recognition","Anonymous");
$fund_array=array("1280"=>"State Parks","2235"=>"PARTF");

$calling_app=$database;
$calling_page=$_SERVER['PHP_SELF'];
echo "<form name='donor_form' action='donor_add.php' onsubmit=\"return validateForm()\">";

include("base_form.php");

		$submit_label="Add a Donor";
// 		$message="No person/organization found using $arraySet $where";
		$message="No person/organization found. You can add this.";
	echo "<table><tr><td>";
		ECHO "$message</tr></tr>";
		echo "<tr><td><font color='red'>By completing the form and clicking the \"Add a Donor\" button you will add this person/organization to the Donor database.</font></td></tr><tr><td>";
			echo "<input type='hidden' name='db_source' value='$database'>";
			echo "<input type='submit' name='submit_label' value='Add a Donor' style=\"background-color:lightgreen;width:85;height:35\">
</form></td>";

echo "<td><form action='form.php'><input type='submit' name='submit_label' value='Go to Find'></form></td>";
echo "</tr></table></html>";
		exit;
		}
	
// ****************************************	
	if($num>0)
		{
		include("dpr_labels_many.php"); 
		exit;
		}
	
		
	}// end Find
?>
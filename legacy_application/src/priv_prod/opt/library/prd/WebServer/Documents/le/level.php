<?php
include("menu.php");
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
date_default_timezone_set('America/New_York');
// include("../../include/get_parkcodes_i.php");
$database="le";
// include("../../include/get_parkcodes_reg.php");
include("../../include/get_parkcodes_dist.php");

$database="le";
//include("../../include/connectROOT.inc"); // database connection parameters
mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

$level=$_SESSION['le']['level'];
$beacon=$_SESSION['le']['beacon'];

if($level<1)
	{
	echo "You do not have access to this page."; exit;
	}

if($level>1)
	{
	if(!empty($_POST['approve_id']))
		{
		include("le_batch_approve.php");  // short-cut approval by Raleigh
		}
	}
	
$action="approval";
$var_status="awaiting";

if($level==1)
	{
	if(!empty($_SESSION['le']['accessPark']))
		{
		$where="(";
		$ex=explode(",",$_SESSION['le']['accessPark']);
		foreach($ex as $k=>$v)
			{
			$where.="parkcode='$v' OR ";
			@$pass_where.="[".$v."] ";
			}
		$where=rtrim($where," OR ");
		$where.=")";
		}
		else
		{
		$parkcode=$_SESSION['le']['select'];
		$where="parkcode='$parkcode'";
		}
	$parkcode=$_SESSION['le']['select'];
	$sql="SELECT * FROM pr63
	where pasu_approve ='' and $where
	 order by ci_num desc"; //echo "$sql";
	}

if($level==2)
	{
	// $action="DISU approval";
	$district=${"array".$_SESSION['le']['select']};
// echo "<pre>"; print_r($district); echo "</pre>"; // exit;
	$action="DISU approval";
// 	$region=${"array".$_SESSION['le']['selectR']};
	$where="(";
		foreach($district as $k=>$v)
			{
			$where.="parkcode='$v' OR ";
			@$pass_where.="[".$v."] ";
			}
		$where=rtrim($where," OR ");
		$where.=")";
	$sql="SELECT * FROM pr63
	where pasu_approve !='' and dist_approve='' and $where
	 order by ci_num desc";
// 	 echo "$sql";
	}

if($level>2)
	{
	$action="Raleigh Office Review";
	$pass_where="any park";
	$sql="SELECT * FROM pr63
	where le_approve='' and dist_approve!=''
	 order by ci_num desc";
	}

$safety_consult="";
if($beacon=="60033189") // Safety Consultant position
	{
// 	$past=date("Y-m-d",strtotime('-180 days'));  //echo "$past";
// 	$action="submitted since $past";
// 	$var_status="";
// 	$sql="SELECT * FROM pr63
// 	where date_occur>'$past'
// 	 order by ci_num desc";
	$_SESSION['fuel']['safety_consult']="1";
	$safety_consult=1;
	include("find_pr63_reg.php");
	exit;
	}

// echo "$sql<br />";
$result = @mysqli_QUERY($connection,$sql); 
$num=mysqli_num_rows($result);
while($row=mysqli_fetch_assoc($result))
		{
		if($level==2)
			{
			if(!in_array($row['parkcode'],$district) AND $level<3){continue;}
			}
		
		$allFields[]=$row;
		}

if(!isset($allFields))
	{
// 	echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
// 	$dist=$_SESSION['le']['select'];
	if(empty($pass_where)){$pass_where=$parkcode;}
	echo "There are presently no PR-63s that need approval for:<br />$pass_where"; exit;
	}

// ********** Filter row ************

if($level>1)
	{
	echo "<form name='' method='POST' action='level.php'>";
	}


echo "<table border='1' cellpadding='3'><tr><td colspan='33'>Number $var_status $action: $num</td></tr>";


$rename_fields=array("le_approve"=>"le review");

if($level<4)
	{
// 	$excludeFields=array("id");   // see line 21
	$excludeFields=array();   // see line 21
	}
	else
	{$excludeFields=array();}



extract($_REQUEST);

// echo "<pre>"; print_r($allFields); echo "</pre>"; // exit;
echo "<tr>";
foreach($allFields[0] as $k=>$v)
	{
	if(in_array($k,$excludeFields)){continue;}
	if(array_key_exists($k,$rename_fields)){$k=$rename_fields[$k];}
	$k=str_replace("_"," ",$k);
	echo "<th>$k</th>";
	}
echo "</tr>";

foreach($allFields as $k=>$v)
	{
	echo "<tr>";
		foreach($v as $fld=>$value)
			{
			if(in_array($fld,$excludeFields)){continue;}
		//	$v0=$rename_fields[$fld];
			$td="";
				
			if($fld=="id")
				{
				$id=$allFields[$k]['id'];
				$value="<input type='checkbox' name='approve_id[$id]' value=\"x\">";
				}
			if($fld=="ci_num")
				{
				$id=$allFields[$k]['id'];
				$value="<a href='pr63_form_reg.php?id=$id'>[&nbsp;$value&nbsp;]</a>";
// 				$value="<a href='pr63_form.php?id=$id'>[&nbsp;$value&nbsp;]</a>";
				}
			if($fld=="details")
				{
				$value=substr($value,0,50);
				}
								
			echo "<td$td>$value</td>";
					
			}
	echo "</tr>";
	}
if($level>1)
	{
	echo "<tr><td colspan='2'><input type='submit' name='submit_form' value=\"Approve\"></td></tr>";
	echo "</table>";
	echo "</form>";
	}
	else
	{echo "</table>";}
echo "</body></html>";
?>
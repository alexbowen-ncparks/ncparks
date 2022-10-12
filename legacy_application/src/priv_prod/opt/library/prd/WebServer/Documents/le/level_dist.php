<?php
include("menu.php");
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

include("../../include/get_parkcodes_i.php");

$database="le";
//include("../../include/connectROOT.inc"); // database connection parameters
$db = mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");

$level=$_SESSION['le']['level'];

if($level<1)
	{
	echo "You do not have access to this page."; exit;
	}

$action="approval";

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
	$action="DISU approval";
	$district=${"array".$_SESSION['le']['select']};
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
	}

if($level>2)
	{
	$action="Raleigh Office Review";
	$pass_where="any park";
	$sql="SELECT * FROM pr63
	where le_approve='' and dist_approve!=''
	 order by ci_num desc";
	}

//echo "$sql<br />";
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
	$dist=$_SESSION['le']['select'];
	echo "There are presently no PR-63s that need approval for:<br />$pass_where"; exit;
	}

// ********** Filter row ************
	echo "<table border='1' cellpadding='3'><tr><td colspan='33'>Number awaiting $action: $num</td></tr>";
//include("cell_color.php");

$rename_fields=array("le_approve"=>"le review");

$excludeFields=array("id");


extract($_REQUEST);

//echo "<pre>"; print_r($allFields); echo "</pre>"; // exit;
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

echo "</body></html>";
?>
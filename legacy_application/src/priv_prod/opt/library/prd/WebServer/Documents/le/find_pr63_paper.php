<html><head>

</head>

<?php
ini_set('display_errors',1);
session_start();
//echo "<pre>"; print_r($_SESSION); echo "</pre>";  //exit;
//extract($_REQUEST);

$level=$_SESSION['le']['level'];
$tempID=$_SESSION['le']['tempID'];
$beacon_num=$_SESSION['le']['beacon'];

include("../../include/get_parkcodes_dist.php");
$database="le";
if(empty($connection))
	{
	include("../../include/iConnect.inc"); // database connection parameters
	}
	mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");
       

$level=$_SESSION['le']['level'];
$currPark=$_SESSION['le']['select'];
	if($level<1)
		{
		exit;
		}
		
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;

$sql="SELECT distinct left(date_occur,4) as year FROM pr63_paper order by date_occur";
 $result = @mysqli_QUERY($connection,$sql) or die("$sql".mysqli_error($connection)); 
while($row=mysqli_fetch_assoc($result))
		{
		$year_array[]=$row['year'];
		}
	
$month_array=range(1,12);
$day_array=range(1,31);

$parkcode_array=array();
$sql="SELECT distinct parkcode FROM pr63_paper order by parkcode";
 $result = @mysqli_QUERY($connection,$sql) or die("$sql".mysqli_error($connection)); 
while($row=mysqli_fetch_assoc($result))
		{
		$parkcode_array[]=$row['parkcode'];
		}
if(empty($parkcode_array)){array_unshift($parkcode_array,"");}
//secho "<pre>"; print_r($parkcode_array); echo "</pre>"; // exit;

$skip=array("submit_supervisor");
$sql="SHOW COLUMNS FROM pr63_paper";
 $result = @mysqli_QUERY($connection,$sql); 
while($row=mysqli_fetch_assoc($result))
		{
		if(in_array($row['Field'],$skip)){continue;}
		$allFields[]=$row['Field'];
		}
//echo "<pre>"; print_r($allFields); echo "</pre>"; // exit;

echo "<body bgcolor='beige'  class=\"yui-skin-sam\">";

echo "<table align='center'><tr><th colspan='3'>
<h3><font color='purple'>NC DPR PR-63 Paper</font></h3></th></tr>
<tr><th>
<a href='pr63_home.php'>PR-63 / DCI Home Page</a></th>
<th>&nbsp;&nbsp;&nbsp;</th>
<th>
<a href='find_pr63_paper.php'>Search Form</a></th>
</tr></table>";

echo "<div align='center'>";
echo "<form action='find_pr63_paper.php' method='POST' enctype='multipart/form-data'>";

$rename_fields=array("ci_num"=>"Case Incident Number","parkcode"=>"Park Code","date_occur"=>"When did it occur?","old_ci_code"=>"DPR Code","old_dci_code"=>"DCI Code","incident_name"=>"Nature of Incident","file_link"=>"File Link");

$excludeFields=array("id","file_link","year","month","day","submit");

$hard_fields=array("ci_num","parkcode");
$drop_down=array("parkcode");

if(!empty($_REQUEST['ci_num'])){$_POST['ci_num']=$_REQUEST['ci_num'];}

$date_clause="";
if($_POST)
	{
//	echo "<pre>"; print_r($_REQUEST); echo "</pre>";  exit;
	extract($_POST);
	if(!empty($year) AND !empty($month) AND !empty($day))
		{
		$date_clause=" and `date_occur`='$year-$month-$day'";
		}
	if(!empty($year) AND !empty($month) AND empty($day))
		{
		$date_clause=" and `date_occur` like '$year-$month-%'";
		}
	if(!empty($year) AND empty($month) AND empty($day))
		{
		$date_clause=" and `date_occur` like '$year-%'";
		}
		
	if(empty($year) AND !empty($month) AND empty($day))
		{
		$date_clause=" and `date_occur` like '%-$month-%'";
		}
	if(empty($year) AND empty($month) AND !empty($day))
		{
		$date_clause=" and `date_occur` like '%-$day'";
		}
	
	if(!empty($year) AND empty($month) AND !empty($day))
		{
		$date_clause=" and (`date_occur` like '$year-%' AND `date_occur` like '%-$day')";
		}
		
	if(empty($year) AND !empty($month) AND !empty($day))
		{
		$date_clause=" and (`date_occur` like '%-$month-$day')";
		}
		
	$clause="1 AND ";
	foreach($_REQUEST as $k=>$v)
		{
		if(in_array($k,$excludeFields)){continue;}
		if($v)
			{
			$pass_fld[]=$k;
			if(!empty($var_day) AND $k=="date_occur")
				{
				$clause.=$k." like '%".$v."' AND ";
				}
				else
				{
			$clause.=$k." like '%".$v."%' AND ";
				}
			}
		}
	
	$clause=rtrim($clause," AND ");
	if($level<2 and $tempID!="Windsor6679")  // Matt Windsor given access _20150131
		{
		if($currPark=="NERI" OR $currPark=="MOJE")
			{$clause.=" AND (parkcode='NERI' OR parkcode='MOJE')";}
			else
			{$clause.=" AND parkcode='$currPark'";}
		$eb=$_SESSION['le']['tempID'];
		$clause.=" OR (entered_by='$eb')";
		}
	
//	echo "<pre>"; print_r($pass_fld); echo "</pre>"; // exit;
	
	$sql="SELECT * FROM pr63_paper where $clause $date_clause order by ci_num"; // echo "$sql";
 	$result = @mysqli_QUERY($connection,$sql); //ECHO "$sql"; exit;
 	$num=mysqli_num_rows($result); //echo "n=$num";
 		if($num==1)
 			{
			$row=mysqli_fetch_assoc($result); extract($row);
			header("Location: pr63_paper_form.php?id=$id");
			exit;
			}

// ************************* RESULTS ******************************
 		if($num>1)
 			{
 			echo "<table border='1' cellpadding='5'>";
 			$f1="<font color='brown'>";$f2="</font>";
			while($row=mysqli_fetch_assoc($result))
				{
				$ARRAY[]=$row;
				}
			foreach($ARRAY as $index=>$array)
				{
				@$i++;
				extract($array);
				$ci_link="<a href='pr63_paper_form.php?id=$id' target='_blank'>$ci_num</a>";
				IF($index==0)
					{
					echo "<tr><td></td>
					<td align='center'>CI Num</td>
					<td align='center'>Park</td>
					<td align='center'>Date of Incident</td>
					<td align='center'>DPR Code/Description</td>
					<td align='center'>DCI Code/Description</td>
					";
					echo "</tr>";
					
					}
			
					echo "<tr><td>$i</td>
					<td align='center'>$f1$ci_link$f2</td>
					<td align='center'>$f1$parkcode$f2</td>
					<td align='center'>$f1$date_occur$f2</td>
					<td align='left'>$f1$old_ci_code$f2</td>
					<td align='left'>$f1$old_dci_code$f2</td>
					";
					
					echo "</tr>";
					
				}
			echo "</table>";
			exit;
			}
 		if($num<1)
 			{
			$message="No PR-63 / DCI found using $clause";
			}
	}


// ***************** Search Form ***************************

//echo "<pre>"; print_r($row); echo "</pre>"; // exit;
if(!isset($message)){$message="";}
echo "<table border='1' cellpadding='3'>
<tr><th>$message</th></tr>
<tr><td><table>";

		foreach($allFields as $k=>$v)
			{
			@$j++;
			if(in_array($v,$excludeFields)){continue;}
			
			$v0=$rename_fields[$v];
			
			@$value=${$v};
		
			$v1="<input type='text' name='$v' value='$value' size='35'>";
				
			if(in_array($v,$drop_down)){
				$dd_array=${$v."_array"};
				$v1="<select name='$v'><option selected=''></option>\n";
					foreach($dd_array as $i=>$display_value)
						{
						$s="value";
						$send_value=$display_value;
						if($v=="parkcode")
							{
							if($display_value==$currPark)
								{$s="selected";}
							}
						$v1.="<option $s='$send_value'>$display_value</option>";
						}
				$v1.="</select>";
				}
			
			if($v=="date_occur")
				{
				$v1="Year:<select name='year'><option selected=''></option>\n";
				foreach($year_array as $i=>$display_value)
					{
					$v1.="<option $s='$display_value'>$display_value</option>";
					}
				$v1.="</select>";
				$v1.=" Month:<select name='month'><option selected=''></option>\n";
				foreach($month_array as $i=>$display_value)
					{
					$display_value=str_pad($display_value,2,0,STR_PAD_LEFT);
					$v1.="<option $s='$display_value'>$display_value</option>";
					}
				$v1.="</select>";
				$v1.=" Day:<select name='day'><option selected=''></option>\n";
				foreach($day_array as $i=>$display_value)
					{
					$display_value=str_pad($display_value,2,0,STR_PAD_LEFT);
					$v1.="<option $s='$display_value'>$display_value</option>";
					}
				$v1.="</select>";
				}
			if(fmod($j,2)==0)
				{echo "<tr><td>$v0</td><td>$v1</td>";}
				else
				{echo "<td>$v0</td><td>$v1</td></tr>";}
			
			}
		
			echo "</table></tr></tr></table><table><tr><td align='center'>";
		
echo "<input type='submit' name='submit' value='Search'>
</td>";
echo "</tr></table></form>     
         </div>    ";	

echo "</body></html>";
?>
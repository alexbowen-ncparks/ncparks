<?php

// Used to develop a new version designed for Public Info requests

date_default_timezone_set('America/New_York');
$database="le";
include("../../include/iConnect.inc");// database connection parameters
// echo "<pre>"; print_r($_POST); print_r($_FILES);echo "</pre>"; exit;
session_start();
$level=$_SESSION['le']['level'];
if($level<1){exit;}

mysqli_select_db($connection,$database)
       or die ("Couldn't select database $database");


/*
$date_array=array("date_occur"=>1,"report_receive_date "=>2,"report_investigate_date"=>3,"clear_date"=>4);
*/

function GetAge($Birthdate)
{
      //explode the date to get month, day and year
         $birthDate = explode("-", $Birthdate);
         //get age from date and birthdate
         $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y")-$birthDate[0])-1):(date("Y")-$birthDate[0]));
        return $age;
}

if($submit=="Submit" || $submit=="Update")
	{
	// PR63 info
// 	echo "<pre>"; print_r($_POST); echo "</pre>";  exit;
       	if($_POST['parkcode']==""){echo "Please specify a park.";exit;}
	$pass_parkcode=$_POST['parkcode'];
       		$skip1=array("year","month","day","submit","loc_name","Name","Address","Phone","Sex","Race","Age","Phone","DOB","occur_min","receive_min","investigate_min","clear_min","le_approve","call_out","submit_supervisor","attachment_num");
$skip2=array("Name_arrest","Address_arrest","Phone_arrest");
  	$clause="";
       		foreach($_POST AS $field=>$value)
       				{
       					if(in_array($field,$skip1)){continue;} // skip submit
       					if(in_array($field,$skip2)){continue;} // skip submit
				
					$test=explode("-",$field);
					if(in_array($test[0],$skip1)){continue;} // skip date fields			    	
			
				    	if($field=="day_week")
				    		{
				    		$value=date("l",strtotime($date_occur));
 						$clause.="day_week='".$value."',";
 						continue;
				    		}
				    	if($field=="occur_hr")
				    		{
				    		$value=$value.$_POST['occur_min'];
 						$clause.="time_occur='".$value."',";
 						continue;
				    		}
				    	if($field=="receive_hr")
				    		{
				    		$value=$value.$_POST['receive_min'];
 						$clause.="report_receive_time='".$value."',";
 						continue;
				    		}
				    	if($field=="investigate_hr")
				    		{
				    		$value=$value.$_POST['investigate_min'];
 						$clause.="report_investigate_time='".$value."',";
 						continue;
				    		}
				    	if($field=="clear_hr")
				    		{
				    		$value=$value.$_POST['clear_min'];
 						$clause.="clear_time='".$value."',";
 						continue;
				    		}
				    		
				 
				    	if($field=="ci_num" AND $value=="auto-generated")
				    		{
				    		$sql="SELECT ci_num from pr63_pio where 1 order by id desc limit 1"; //echo "$sql<br />";   //exit;
						 $result = @mysqli_QUERY($connection,$sql);
 						$row=mysqli_fetch_assoc($result);
 						$ci_array=explode("-",$row['ci_num']);
				//		echo "<pre>"; print_r($ci_array); echo "</pre>"; // exit;
				if(empty($ci_array[1]))
				{
				echo "There was a problem creating the CI Number. Contact Tom Howard"; exit;
				}
 						$c1=$ci_array[1];
						$c1++; //echo "$c1<br />";
						$c0=$ci_array[0];
						$c2=date('y');
						if($c0 != $c2){$c1=1;}
						$value=date('y')."-".str_pad($c1,5,"0",STR_PAD_LEFT);
						$ci_num=$value;
 				//		echo "ci=$ci  c1=$c1date c2=$c2date c=$ci_num";   exit;
				    		}

				    	if($field=="location_code")
				    		{
				    		$lc=explode(" - ",$value);
				    		$value=$lc[0];
 						$clause.="loc_name='".$lc[1]."',";
				    		}
				    	
				    	if($field=="pasu_approve")
				    		{
				    		$pasu_value="";
				    		if(!empty($pasu_approve))
				    			{
							foreach($pasu_approve as $k_pasu=>$v_pasu)
								{
								if(empty($v_pasu)){continue;}
								@$pasu_value.=$k_pasu."=".$v_pasu."*";			
								}
							$value=rtrim($pasu_value,"*");
							$pass_pasu_approve=$value;
				    			}
				    		}
				    	
 
// 				    	$value=mysqli_real_escape_string($value);
       					$clause.=$field."='".$value."',";
       				}
 
if(isset($_POST['le_approve']))
	{$clause.="le_approve='x'";}
	else
	{$clause.="le_approve=''";}

if(isset($_POST['call_out']))
	{$clause.=",call_out='x'";}
	else
	{$clause.=",call_out=''";}

if(isset($_POST['submit_supervisor']))
	{
	$clause.=",submit_supervisor='x'";
	}
	else
	{$clause.=",submit_supervisor=''";}

// allow RESU office to approve in absence of PASU
if(isset($_POST['dist_approve']))
	{
	if(empty($_POST['pasu_name']))
		{
		$value=$_POST['entered_by']."=".$_POST['dist_approve'];
		}
	if($level==2 and empty($pass_pasu_approve))
		{
		$value=$_POST['entered_by']."=".$_POST['dist_approve'];
		$clause.=", pasu_approve='".$value."'";
		}
	}
	
	$clause=rtrim($clause,",");
	
if($_POST['id'])
	{
	$command="UPDATE";
	$where="where id='$id'";
	$new="";
	}
	else
	{
	$where="";
	$command="INSERT";
	$new=1;
	}

$sql="$command  pr63_pio SET $clause $where";
$var=$pass_pasu_approve;
// echo "$sql<pre>"; print_r($_POST); echo "</pre>";  exit;
// echo "$sql<br />n=$new<br />level=$level<br />var=$var";  exit;
$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql".mysqli_error($connection));

 	if($new){$id=mysqli_insert_id($connection);}

$skip_age=array("unknown","refused");
foreach($_POST['Name'] as $k=>$v)
	{
	if($_POST['DOB'][$k]!="")
		{
		$test=explode("-",$_POST['DOB'][$k]);
		$month=$test[1]+0;
		$day=$test[2]+0;
		if(checkdate($month,$day,$test[0]) and $_POST['DOB'][$k]< date("Y-m-d"))
			{$age=GetAge($_POST['DOB'][$k]);}
			else
			{$age="?";}
		
		}
	else{$age="";}
	
	$clause="ci_id='".$id."',";
	$clause.="row_num='".$k."',";
	$clause.="Name='".$v."',";

	$clause.="Address='".$_POST['Address'][$k]."',";
	$clause.="Phone='".$_POST['Phone'][$k]."',";
	$clause.="Sex='".$_POST['Sex'][$k]."',";
	$clause.="Race='".$_POST['Race'][$k]."',";
	$clause.="Age='".$age."',";
	$clause.="DOB='".$_POST['DOB'][$k]."',";
$clause=rtrim($clause,",");
$sql="REPLACE involved_person_pio SET $clause"; //echo "<br />$sql";  exit;
 $result = @mysqli_QUERY($connection,$sql);
$sql="DELETE FROM involved_person_pio WHERE Name='' and Address='' and Phone='' and Sex='' and Race='' and DOB=''"; //echo "<br />$sql";  exit;
 $result = @mysqli_QUERY($connection,$sql);
}

// Arrested persons
if(!empty($_POST['Name_arrest']))
	{
	foreach($_POST['Name_arrest'] as $k=>$v)
		{
		$clause="ci_id='".$id."',";
		$clause.="row_num='".$k."',";
		$clause.="Name_arrest='".$v."',";

		$clause.="Address_arrest='".$_POST['Address_arrest'][$k]."',";
		$clause.="Phone_arrest='".$_POST['Phone_arrest'][$k]."',";
		
		$clause=rtrim($clause,",");
		$sql="REPLACE arrested_person_pio SET $clause"; //echo "<br />$sql";  exit;
		$result = @mysqli_QUERY($connection,$sql);
		$sql="DELETE FROM arrested_person_pio WHERE Name_arrest='' and Address_arrest='' and Phone_arrest='' "; //echo "<br />$sql";  exit;
		$result = @mysqli_QUERY($connection,$sql);
		}
	}
if(!empty($_FILES['file_upload']['name']) AND $_FILES['file_upload']['error']==0)
	{
	$attachment_num=$_POST['attachment_num'];
	include("staff_uploads_pio.php");
	}

if(!empty($_FILES['file_upload']['name']) AND $_FILES['file_upload']['error']!=0)
	{
	$var_file=$_POST['file_upload']['name'];
	echo "There was a problem uploading the file $var_file. Contact Tom Howard";
	}
//echo "i=$id"; exit;
$_SESSION['le']['pass_parkcode']=$_POST['parkcode'];
header("Location: pr63_form_pio.php?id=$id");
}

?>
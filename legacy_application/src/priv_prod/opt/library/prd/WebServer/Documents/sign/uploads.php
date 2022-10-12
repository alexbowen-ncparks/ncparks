<?php
//echo "<pre>"; print_r($row); echo "</pre>"; // exit;

if($row['justification']!="")
	{
	$pur=str_replace('&',' and ',$row['purpose']);
	if($level==2)
		{
		$db = mysqli_select_db($connection,'divper')
     	  	or die ("Couldn't select database $database");
     	  	$sql="SELECT t1.email from empinfo as t1
     	  	LEFT JOIN emplist as t2 on t2.tempID=t1.tempID
     	  	LEFT JOIN position as t3 on t3.beacon_num=t2.beacon_num
     	  	where t3.beacon_num ='60032920' OR t3.beacon_num ='60033018'";
     	  	//OR t3.posTitle like '%Assis%')
     	  	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql c=$connection");
		while($row1=mysqli_fetch_assoc($result))
			{extract($row1);
			if($email!=""){$to.=$email.";";}
			}
			$to=rtrim($to,";");
		}
	if($level==1)
		{
	// get District
	// get Region
		$db = mysqli_select_db($connection,'divper')
     	  	or die ("Couldn't select database $database");
	if(!isset($pass_dist)){$pass_dist="";}
     	  	$sql="SELECT t1.email from empinfo as t1
     	  	LEFT JOIN emplist as t2 on t2.tempID=t1.tempID
     	  	LEFT JOIN position as t3 on t3.beacon_num=t2.beacon_num
     	  	where t2.currPark='$pass_dist' AND t3.posTitle like '%Super%'";
     	  	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql c=$connection");
		$row1=mysqli_fetch_assoc($result);
	//	echo "<pre>$sql"; print_r($row1); echo "</pre>";  exit;
		@extract($row1);
			if(@$email!=""){$to=$email;}

		}
	
	if(!isset($pass_location)){$pass_location="";}
	$subject="$pass_dist $pass_location Request for Sign $pass_dpr";
	$request_file=$_SERVER['REQUEST_URI'];
	$link="https://10.35.152.9".$request_file;
	$link="https://10.35.152.9".$request_file;
	$order   = array("\r\n", "\n", "\r");
	$replace = '%0A';
	$newstr = str_replace($order, $replace, $pur);
	
	$body="body=$pass_location is requesting a sign entitled:%0A%0A $newstr .%0A%0AIf you are already logged into the Sign database, clicking this link will take you to the request:%0A$link";
			
			$body=htmlentities($body);
	if(!isset($to)){$to="";}
	$item.="<br /><font color='green'>View</font> <a href='".$row['justification']."' target='_blank'>Sketch of Sign</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='edit.php?del=y&id=$row[id]&fld=justification'><font size='-2' onClick='return confirmLink()'>Delete</font></a><br /><font color='red'>Park will email the District. . . . District will email CHOP if necessary. <a href=\"mailto:$to?subject=$subject&$body\">email</a><br />";
	}
	else
	{
	
	$item.= "<font color='brown'>Upload a Sketch of the sign (as a PDF) showing how it should look.</font> &nbsp;&nbsp;&nbsp;
			<input type='file' name='file_upload[justification]' size='10'>";
	}
		
if($row['other_file_1']!="")
	{
	$item.="<br /><font color='green'>View</font> <a href='".$row['other_file_1']."' target='_blank'>Photo of existing sign</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='edit.php?del=y&id=$row[id]&fld=other_file_1' onClick='return confirmLink()'><font size='-2'>Delete</font></a>
	<br /><br />";
	}
	else
	{
	$item.= "<br /><font color='brown'>Upload Photo of existing sign (if one exists)</font>&nbsp;&nbsp;&nbsp;
			<input type='file' name='file_upload[other_file_1]' size='10'>";
	}	
	
if($row['other_file_2']!="")
	{
	$item.="<br /><font color='green'>View</font> <a href='".$row['other_file_2']."' target='_blank'>Photo of finished sign</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='edit.php?del=y&id=$row[id]&fld=other_file_2' onClick='return confirmLink()'><font size='-2'>Delete</font></a>
	<br /><br />";
	}
	else
	{
	$item.= "<br /><font color='brown'>Upload Photo of finished sign (sign shop will do this)</font>&nbsp;&nbsp;&nbsp;
			<input type='file' name='file_upload[other_file_2]' size='10'>";
	}	
	
if($row['other_file_3']!="")
	{
	$item.="<br /><font color='green'>View</font> <a href='".$row['other_file_3']."' target='_blank'>Other File A</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='edit.php?del=y&id=$row[id]&fld=other_file_3' onClick='return confirmLink()'><font size='-2'>Delete</font></a>
	<br /><br />";
	}
	else
	{
	$item.= "<br /><font color='brown'>Upload Other File A</font>&nbsp;&nbsp;&nbsp;
			<input type='file' name='file_upload[other_file_3]' size='10'>";
	}	
	
if($row['other_file_4']!="")
	{
	$item.="<br /><font color='green'>View</font> <a href='".$row['other_file_4']."' target='_blank'>Other File B</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='edit.php?del=y&id=$row[id]&fld=other_file_4' onClick='return confirmLink()'><font size='-2'>Delete</font></a>
	<br /><br />";
	}
	else
	{
	$item.= "<br /><font color='brown'>Upload Other File B</font>&nbsp;&nbsp;&nbsp;
			<input type='file' name='file_upload[other_file_4]' size='10'>";
	}	
?>
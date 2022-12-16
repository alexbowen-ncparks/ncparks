<?php
//echo "<pre>"; print_r($row); echo "</pre>"; // exit;
if(@$row['TA']!="")
	{
	$item.="<font color='green'>View</font> <a href='".$row['TA']."' target='_blank'>TA</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='edit.php?del=y&id=$row[id]&fld=TA' onClick='return confirmLink()'><font size='-2'>Delete</font></a>
	<br />";
	}
	else
	{
	$item.= "<font color='brown'>Upload TA (PDF w/signature).</font> &nbsp;&nbsp;&nbsp;
			<input type='file' name='file_upload[TA]' size='10'>";
	}

// if(@$row['justification']!="")
if(@$row['purpose']!="")
	{
// 	echo "p=$pass_dist";
	$pur=str_replace('&',' and ',$row['purpose']);
// 	if($level==2)
// 		{
				// Admin Assit.
		if($pass_dist=="EADI")
			{
// 			$dist_email="60032892"; // formerly Bonita Meeks
			$dist_email="60032912"; // Joe Shimel will Admin Assit. position vacant
			}
		if($pass_dist=="NODI"){$dist_email="60032920";}
		if($pass_dist=="SODI"){$dist_email="60033093";}
		if($pass_dist=="WEDI"){$dist_email="60032931";}
		mysqli_select_db($connection,'divper')
     	  	or die ("Couldn't select database $database");
     	  	$sql="SELECT t1.email from empinfo as t1
     	  	LEFT JOIN emplist as t2 on t2.tempID=t1.tempID
     	  	LEFT JOIN position as t3 on t3.beacon_num=t2.beacon_num
     	  	where t3.beacon_num ='$dist_email'
     	  	";
     	  	//t3.beacon_num ='60032920'
     	  	//  OR t3.beacon_num ='60033018'
     	  	//OR t3.posTitle like '%Assis%')
     	  	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
		while($row1=mysqli_fetch_assoc($result))
			{
			extract($row1);
			if($email!="")
				{@$to.=$email.";";}
			}
			$to=rtrim($to,";");
// 		}
	if($level==1)
		{
	// get District
	// switch REGION
	$pass_reg=$row['district'];
			if($pass_reg=="MORE"){$pass_reg="WEDI";}
			if($pass_reg=="PIRE"){$pass_reg="SODI";}
			if($pass_reg=="CORE"){$pass_reg="EADI";}
// 		$pass_reg="WEDI";
		
		mysqli_select_db($connection,'divper')
     	  	or die ("Couldn't select database $database");
     	  	$sql="SELECT t1.email from empinfo as t1
     	  	LEFT JOIN emplist as t2 on t2.tempID=t1.tempID
     	  	LEFT JOIN position as t3 on t3.beacon_num=t2.beacon_num
     	  	where t2.currPark='$pass_reg' AND t3.posTitle like '%Super%'";
     	  	//OR t3.posTitle like '%Assis%')
     	  	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql ");
		$row1=mysqli_fetch_assoc($result);
// 	echo "$pass_reg<pre>$sql"; print_r($row1); echo "</pre>";  exit;
		extract($row1);
			if($email!=""){$to=$email;}

		}
	
if(!isset($pass_dist)){$pass_dist="";}
	$subject="$pass_dist $pass_location Request for Travel Authorization $pass_tadpr Amount=$pass_amount ";
	
	$item.="<br /><font color='green'>View</font> <a href='".$row['justification']."' target='_blank'>Justification</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='edit.php?del=y&id=$row[id]&fld=justification'><font size='-2' onClick='return confirmLink()'>Delete</font></a>";
	}
	else
	{
	$item.= "<br /><font color='brown'>Upload Justification (Word or PDF)</font>&nbsp;&nbsp;&nbsp;
			<input type='file' name='file_upload[justification]' size='10'>";
	}
	

if(@$row['register']!="")
	{
	$item.="<br /><font color='green'>View</font> <a href='".$row['register']."' target='_blank'>Registration/Agenda</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='edit.php?del=y&id=$row[id]&fld=register' onClick='return confirmLink()'><font size='-2'>Delete</font></a>
	<br />";
	}
	else
	{
	$item.= "<br /><font color='brown'>Upload Registration/Agenda </font>&nbsp;&nbsp;&nbsp;
			<input type='file' name='file_upload[register]' size='10'>";
	}	

if(@$row['other_file_1']!="")
	{
	$item.="<br /><font color='green'>View</font> <a href='".$row['other_file_1']."' target='_blank'>Other File 1</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='edit.php?del=y&id=$row[id]&fld=other_file_1' onClick='return confirmLink()'><font size='-2'>Delete</font></a>
	<br /><br />";
	}
	else
	{
	$item.= "<br /><font color='brown'>Upload Other File 1 (if needed)</font>&nbsp;&nbsp;&nbsp;
			<input type='file' name='file_upload[other_file_1]' size='10'>";
	}	
	
if(@$row['other_file_2']!="")
	{
	$item.="<br /><font color='green'>View</font> <a href='".$row['other_file_2']."' target='_blank'>Other File 2</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='edit.php?del=y&id=$row[id]&fld=other_file_2' onClick='return confirmLink()'><font size='-2'>Delete</font></a>
	<br /><br />";
	}
	else
	{
	$item.= "<br /><font color='brown'>Upload Other File 2 (if needed)</font>&nbsp;&nbsp;&nbsp;
			<input type='file' name='file_upload[other_file_2]' size='10'>";
	}	

// mod tom_20221216
// 	if(!isset($to)){$to="";}
// 	if(!isset($cc)){$cc="";}
// 	if(!isset($pur)){$pur="";}
// 	$link="  /travel/edit.php?edit=$edit&submit=edit'";
// 	$link="  /travel/edit.php?edit=$edit&submit=edit'";
// 	$item.="<br /><font color='red'>Park will email the District: <a href='mailto:$to?subject=$subject&body=$pur$cc$link'>email</a><br />All other section staff will email tammy.dodd@ncparks.gov: </font><a href='mailto:tammy.dodd@ncparks.gov?subject=$subject&body=$pur$link'>email</a>
// 		<br />";
// end mod

if(@$row['response']!="")
	{
	$item.="<br /><font color='green'>View</font> <a href='".$row['response']."' target='_blank'>FINAL TA</a>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='edit.php?del=y&id=$row[id]&fld=response' onClick='return confirmLink()'><font size='-2'>Delete</font></a>
	<br /><br />";
	}
	else
	{
	$item.= "<br /><font color='brown'>Upload FINAL TA</font>&nbsp;&nbsp;&nbsp;
			<input type='file' name='file_upload[response]' size='10'>";
	}	
		
?>
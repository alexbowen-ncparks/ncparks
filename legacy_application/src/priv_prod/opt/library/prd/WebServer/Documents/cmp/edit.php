<?php
extract($_REQUEST);

if(@$text=="y")
	{
	$database="cmp";
	include("../../include/iConnect.inc");// database connection parameters
	$db = mysqli_select_db($connection,$database)
		   or die ("Couldn't select database $database");
	}

 if(@$del=="y")
	{
	$sql = "SELECT $fld FROM tal where id='$id'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); 
	$row=mysqli_fetch_assoc($result);
	unlink($row[$fld]);
	$sql = "UPDATE tal set $fld='' where id='$id'";
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); 
	//echo "$sql"; exit;			
		header("Location:edit.php?edit=$id&submit=edit");
	exit;
	}
  		
//echo "<pre>"; print_r($_POST); echo "</pre>";  //exit;
if(@$_POST['submit']=="Delete")
		{
		$sql = "DELETE FROM tal where id='$_POST[id]'";
//echo "$sql"; exit;
		$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); 
		echo "Record was successfully deleted.";exit;
		}



if(empty($text)){include("menu.php");}

if(@$edit)
	{
	$sql = "SELECT * FROM form as t1 
	WHERE  id='$edit' 
	";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); 
	if(mysqli_num_rows($result)<1){echo "No record found for id=$edit."; exit;}
	
	if(mysqli_num_rows($result)==1)
		{
		$row=mysqli_fetch_assoc($result);
		$park_code=$row['park_code'];
			foreach($row as $k=>$v)
				{
				$ARRAY[$k]=$v;
				}
		}
	}
	else
	{
	if(empty($park_code)){$park_code=$_SESSION['cmp']['select'];}
	$sql = "SELECT * FROM form as t1 
	WHERE  park_code='$park_code' 
	";  //echo "$sql"; exit;
	$result = mysqli_query($connection,$sql) or die ("Couldn't execute query. $sql"); 
	
	if(mysqli_num_rows($result)==1)
		{
		$row=mysqli_fetch_assoc($result);
		$park_code=$row['park_code'];
			foreach($row as $k=>$v)
				{
				$ARRAY[$k]=$v;
				}
		}
	}
//echo "$sql";	

if(@$text=="y")
	{
	include("rename_fields.php");
	$pd=$ARRAY['park_code']."_cash_management_plan";
		$fp = fopen("doc_files/$pd.doc", 'w+'); 
		$str = "";		
		foreach($ARRAY AS $fld=>$value)
			{
			if($fld=="id"){continue;}
			$value=str_replace("’","'",$value);
			$v=$cat1_array[$fld];
			$v=str_replace("<b>","",$v);
			$v=str_replace("</b>","",$v);
			
			$str.="\r\n".$v."\r\nANSWER: $value\r\n";
			}
		
		fwrite($fp, $str); 
	
		fclose($fp);
		$loc="$pd.doc";
	echo "Click this <a href='/cmp/doc_files/$loc'>link to download the Word document.";
	exit;
	}
	
//echo "<pre>"; print_r($_REQUEST); echo "</pre>"; // exit;

if(empty($submit)){exit;}

echo "<body bgcolor='beige' class=\"yui-skin-sam\">";

echo "<table><tr><td><table cellpadding='5' border='1' bgcolor='aliceblue'>";
	
	if(@$message==1)
		{
		echo "</td></tr><tr bgcolor='yellow'><td colspan='3' align='center'>Your report has been entered.<br />Review for completeness/correctness.</td></tr>";
		}
	

		$page="http://www.dpr.ncparks.gov/cmp/print_pdf.php";
		
		if(!isset($edit))
			{$edit="";}
			else
			{
			echo "</td></tr><tr bgcolor='white'><td align='center'><form method='POST' action='$page'>
			<input type='hidden' name='park_code' value='$park_code'>
			<input type='hidden' name='id' value='$edit'>
			<input type='submit' name='submit' value='Print'></form></td>
			";
			echo "</tr>";
			}


include("rename_fields.php");
	

	if(empty($park_code)){$park_code=$_SESSION['cmp']['select'];}
	
	$park_item="<input type='text' name='park_code' value=\"$park_code\" size='5' READONLY>";
	
	if($level<2)
		{
		if(@$_SESSION['cmp']['accessPark'] != "")
			{
			$limit_park=$_SESSION['cmp']['accessPark'];
			$lp=explode(",",$limit_park);
			$park_item="<select name='park_code' onChange=\"MM_jumpMenu('parent',this,0)\">
			<option selected=''></option>";
			foreach($lp as $k=>$v)
				{
				if($v==$park_code){$s="selected";}else{$s="value";}
				$v1="form.php?park_code=$v&submit=Cash+Management+Plan";
				$park_item.="<option $s='$v1'>$v</option>";
				}
			$park_item.="</select>";
			}
		}
	
	if($level>1)
		{
		include("../../include/get_parkcodes_dist.php");
// 	echo "<pre>"; print_r($parkCode); echo "</pre>"; // exit;
		$add_code=array("EADI","NODI","SODI","WEDI","BUOF","DEDE","WARE");
		$remove_code=array("BAIS","BATR","BECR","BEPA","BULA","BUMO","DERI","LEIS","LOHA","MIMI","OCMO","PIBO","RUHI","SARU","SCRI","SUMO","THRO","WOED","YEMO");
		
		$parkCodeName['BUOF']="Budget Office";
		$parkCodeName['DEDE']="Design and Development";
		
		$parkCode=array_merge($parkCode,$add_code);
		sort($parkCode);
		$park_item="<select name='park_code' onChange=\"MM_jumpMenu('parent',this,0)\">
		<option selected=''></option>";
		foreach($parkCode as $k=>$v)
			{
			if(in_array($v,$remove_code))
				{continue;}
			if(@$level==2 and @$district[$v]!=$ck_park)
				{continue;}
			$park_name=$parkCodeName[$v];
			if($v==$park_code){$s="selected";}else{$s="";}
			$v1="form.php?park_code=$v&submit=Cash+Management+Plan";
			$park_item.="<option value='$v1' $s>$v - $park_name</option>\n";
			}
		$park_item.="</select>";
		}
	
echo "<form method='POST' name='contactForm' action='form.php' enctype='multipart/form-data'>";
		
$skip=array("id","park_code","update_date","emid","auditor_date");

$var_field=array("pasu"=>"35","f_year"=>"5");
	
	
echo "<tr><td></td><td>Park</td><td>$park_item</td></tr>";

foreach($ARRAY as $fld=>$value)
	{
	if(strpos($fld,"q_")===0){$i=$fld;}else{$i="";}
	if(in_array($fld,$skip)){continue;}
	$RO="";
	$item="<textarea name='$fld' rows='3' cols='95'>$value</textarea>";
	
	if(array_key_exists($fld,$var_field))
		{
		
		if($fld=="pasu")
			{
			if($value==""){$value=@$pasu_name;}
			}
			
		$item="<input type='text' name='$fld' value=\"$value\" size='$var_field[$fld]' $RO>";
		}
	$name=$fld;
	
	if($fld=="q_1")
		{
		$ro="READONLY";
		$item="<textarea name='$fld' rows='3' cols='95' READONLY>Whenever Funds held at a PARK exceeds $250, a Bank Deposit is required. The Deadline for Deposit is the Next Business Day prior to Bank Cutoff for Same Day Credit. A Deposit must be made at least once per week (every 7 calendar days) even if total funds held is less than $250.</textarea>";
		}
	if($fld=="q_3")
		{
		$ro="READONLY";
		$item="<textarea name='$fld' rows='3' cols='95' READONLY>Most parks do not receive cash/checks via the US Mail. However, the DENR Daily Receipt Log will be adapted to be used by all parks for receiving cash/checks. The staff responsible for this are listed as the Primary and Secondary Contact.
</textarea>";
		}
	if($fld=="q_4")
		{
		$ro="READONLY";
		$item="<textarea name='$fld' rows='3' cols='95' READONLY>Most parks do not receive cash/checks via the US Mail. However, the DENR Daily Receipt Log will be adapted to be used by all parks for receiving cash/checks.  The staff responsible for this are listed in the Answer to Question #6.</textarea>";
		}
		
	if($fld=="q_13")
		{
		$ro="READONLY";
		$item="<textarea name='$fld' rows='3' cols='95' READONLY>NO DPR PERSONNEL ENTER INVOICES INTO NCAS FOR PAYMENT.  THIS IS DONE BY THE DENR CONTROLLER'S OFFICE.</textarea>";
		}

	if($fld=="q_14")
		{
		$ro="READONLY";
		$item="<textarea name='$fld' rows='3' cols='95' READONLY>THE DPR BUDGET OFFICER (Dodd, Tammy [60032781] * Budget Officer * 919-707-9359 * tammy.dodd@ncparks.gov) IS THE FINAL SIGNATURE ON THESE TYPE OF PROCESSES ONCE PAPERWORK IS RECEIVED FROM EACH PARK AND/OR DIV SECTION. JOANNE BARBOUR IS THE BACKUP (Barbour, JoAnne [60032791] * Purchasing Officer * (919)707-9353 * joanne.k.barbour@ncparks.gov)</textarea>";
		}
	if($fld=="q_15")
		{
		$ro="READONLY";
		$item="<textarea name='$fld' rows='3' cols='95' READONLY>NO DPR PERSONNEL ENTER INVOICES INTO NCAS FOR PAYMENT.  THIS IS DONE BY THE DENR CONTROLLER'S OFFICE.</textarea>";
		}
	if($fld=="q_17")
		{
		$ro="READONLY";
		$item="<textarea name='$fld' rows='3' cols='95' READONLY>The DPR Budget Officer, (Dodd, Tammy [60032781] * Budget Officer * 919-707-9359 * tammy.dodd@ncparks.gov) is the primary person responsible for auditing and requesting the necessary paperwork to account for petty cash each fiscal year and the DPR Accounts Receivable Clerk is the backup (??? [60036015] * Accounting Clerk * 919-707-9352 * ???)</textarea>";
		}
	if($fld=="q_21")
		{
		$ro="READONLY";
		$item="<textarea name='$fld' rows='3' cols='95' READONLY>EACH PARK AND/OR SECTION IS REQUIRED TO COMPLETE FAS PAPERWORK TO SEND TO THE DPR FIXED ASSET OFFICER  (??? [60036015] * Accounting Clerk * 919-707-9352 * ???) TO ENSURE FIXED ASSETS ARE ACCOUNTED FOR.</textarea>";
		}
	if($fld=="q_11")
		{
		echo "<tr><th colspan='2'>CASH MANAGEMENT OVER DISBURSEMENTS:</th></tr>";}
	$name=nl2br($cat1_array[$fld]);
	
	echo "<tr><td>$i</td><td>$name</td><td>$item</td></tr>";
					
	
	}
		
	if(@$message==1){$message="</tr><tr><td colspan='3' align='center'>Your request has been entered.<br />Review for completeness/correctness.</td></tr><tr>";}
	

if($level<2)
	{
	@$park_code_array=explode(",",$_SESSION['cmp']['accessPark']);
	}

//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
$cmp_title=$_SESSION['cmp']['title'];
if(strpos($cmp_title,"District Superintendent")>0){$cmp_title="District Superintendent";}

$title_array=array("Park Ranger","Park Superintendent","District Superintendent","Engineering, Program Manager");
//echo "t=$cmp_title";
if($level>0 OR in_array($park_code,$park_code_array) OR $park_code==$_SESSION['cmp']['select'])
	{
	$emid=$_SESSION['cmp']['emid'];
	if($level>1 OR in_array($cmp_title,$title_array))
		{
		if((in_array($cmp_title,$title_array) OR $level>2)  AND $emid!="1166"){
		// 1166 is Joseph Debragga
			echo "<tr><th colspan='3' align='center'>Submit the Cash Management Plan</th></tr>
			<tr><td align='center' colspan='3'>";
			date_default_timezone_set('America/New_York');
			if(empty($ARRAY['update_date']))
				{$update_date=date("Y-m-d");}
			else
				{$update_date=$ARRAY['update_date'];}
			echo "Managerial Level Approval: <input type='text' name='update_date' value='$update_date' id=\"f_date_c\" size='12'>
			<img src=\"/jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
			onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" /><script type=\"text/javascript\">
			Calendar.setup({
			inputField     :    \"f_date_c\",     // id of the input field
			ifFormat       :    \"%Y-%m-%d\",      // format of the input field
			button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
			align          :    \"Tl\",           // alignment (defaults to \"Bl\")
			singleClick    :    true
			});
			</script>";

			echo "<input type='hidden' name='park_code' value='$park_code'>
			<input type='hidden' name='emid' value='$emid'>
			<input type='submit' name='submit' value='Submit'>
			</form></td>
			";
			}
			
		if($level>2)
			{
			$update_date=$ARRAY['update_date'];
		//	echo "<tr><th colspan='3' align='center'>Submit the Cash Management Plan</th></tr>";
			echo "<tr><td colspan='3' align='center'>Park Superintendent Approval: $update_date</td></tr>
			<tr><td align='center' colspan='3'>";
			date_default_timezone_set('America/New_York');
			if(empty($ARRAY['auditor_date']))
				{$auditor_date=date("Y-m-d");}
			else
				{$auditor_date=$ARRAY['auditor_date'];}
			if($emid=="1166")
				{
			echo "DENR Internal Auditor : <input type='text' name='auditor_date' value='$auditor_date' id=\"f_date_c\" size='12'>
			<img src=\"/jscalendar/img.gif\" id=\"f_trigger_c\" style=\"cursor: pointer; border: 1px solid red;\" title=\"Date selector\"
			onmouseover=\"this.style.background='red';\" onmouseout=\"this.style.background=''\" /><script type=\"text/javascript\">
			Calendar.setup({
			inputField     :    \"f_date_c\",     // id of the input field
			ifFormat       :    \"%Y-%m-%d\",      // format of the input field
			button         :    \"f_trigger_c\",  // trigger for the calendar (button ID)
			align          :    \"Tl\",           // alignment (defaults to \"Bl\")
			singleClick    :    true
			});
			</script>";
//echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
		//	$emid=$_SESSION['cmp']['emid'];
			echo "<input type='hidden' name='park_code' value='$park_code'>
			<input type='hidden' name='emid' value='$emid'>
			<input type='submit' name='submit' value='Submit'>
			</form></td>
			";
				}
				else
				{
				echo "DENR Internal Auditor : $auditor_date";
				}
			}
	//	echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
		}
	}
	else
	{echo "</form>";}
	
	
	$page="/cmp/print_pdf.php";
	echo "</tr><tr><td colspan='4' align='center'><form method='POST' action='$page'>
	<input type='hidden' name='park_code' value='$park_code'>
	<input type='hidden' name='id' value='$edit'>
	<input type='submit' name='submit' value='View/Print'></form>
	</td>";

	
	echo "</tr>";
	echo "</table></td></tr>";
	echo "</table></html>";

?>
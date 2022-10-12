<?php
//if($level=="5" and $tempid !="Dodd3454"){echo "<pre>";print_r($_REQUEST);echo "</pre>";}//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$level=$_SESSION['budget']['level'];
$tempID=$_SESSION['budget']['tempID'];
$posTitle=$_SESSION['budget']['position'];
$beacon_num=$_SESSION['budget']['beacon_num'];
$pcode=$_SESSION['budget']['select'];
$centerSess=$_SESSION['budget']['centerSess'];
//echo $tempid;
extract($_REQUEST);
$menu='SC1';
//echo "<pre>";print_r($_REQUEST);echo "</pre>"; //exit;
$database="budget";
$db="budget";
//include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
//mysqli_select_db($connection, $database); // database
mysqli_select_db($connection,$database); // database
include("../../../include/activity_new.php");// database connection parameters
include("../../budget/~f_year.php");


echo "<html>";
echo "<head>";
echo "<link rel=\"stylesheet\" href=\"/js/jquery_1.10.3/jquery-ui.css\" />
<script src=\"/js/jquery_1.10.3/jquery-1.9.1.js\"></script>
<script src=\"/js/jquery_1.10.3/jquery-ui.js\"></script>
<link rel=\"stylesheet\" href=\"/resources/demos/style.css\" />";
//echo "<link rel=\"stylesheet\" href=\"test_style_1657.css\" />";
echo "<link rel='stylesheet' type='text/css' href='1533d.css' />";

echo "
<script>
$(function() {
$( \"#datepicker\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker2\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker3\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker4\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker5\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker6\" ).datepicker({dateFormat: 'yy-mm-dd'});
$( \"#datepicker7\" ).datepicker({dateFormat: 'yy-mm-dd'});
});
</script>";


echo "<script language='JavaScript'>

function confirmLink()
{
 bConfirm=confirm('WARNING!!! Are you sure you want to delete this Record?')
 return (bConfirm);
}


";
echo "</script>";



echo "</head>";


//include("1418.html");
echo "<style>";
//echo "input[type='text'] {width: 200px;}";

echo "</style>";

//echo "<br />";

include ("../../budget/menu1415_v1_new.php");
echo "<br />";
include("service_contracts_menu.php");
echo "<br />";

if($delrec==='y'){echo "write code to mark record as delrec"; exit;}

if($id != '')
{
$query2="select park,active,record_complete,contract_type,service_type,vendor,contract_num,po_num,po_original_total,buy_entity,monthly_cost,yearly_cost,original_contract_start_date,original_contract_end_date,comments,center,ncas_account,company,fid_num,group_num,vendor,remit_address from service_contracts where id='$id' ";

echo "query2=$query2<br /><br />";

$result2=mysqli_query($connection,$query2) or die ("Couldn't execute query 2. $query2");

$row2=mysqli_fetch_array($result2);

extract($row2);	
	
}
if($id=='')
{
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='service_contract_add_record.php'>";	
//echo "<form  method='post' autocomplete='off' action='service_contract_add_record.php'>";
}

if($id!='')
{
//echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='pcard_request2.php'>";	
//echo "<form  method='post' autocomplete='off' action='service_contract_edit_record.php'>";
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='service_contract_edit_record.php'>";	

}





echo "<table border=1 align='center'>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr>";
	   echo "<th><font color='brown'>Park</font></th><td><input name='park' type='text' size='25' value='$park' id='park' autocomplete='off'></td>";
	   echo "</tr>";
	  
	  echo "<tr>";
	  echo "<th>Contract Type</th>";
	  echo "<td>";
	 // $contract_type='second_renewal';
	  echo "<select name='contract_type'>";
	  echo "<option value=''></option>";
	if($contract_type=='original')
	{echo "<option selected='original'>original</option>";} else {echo "<option value='original'>original</option>";}		
	if($contract_type=='first_renewal')
	{echo "<option selected='first_renewal'>first_renewal</option>";} else {echo "<option value='first_renewal'>first_renewal</option>";}
    if($contract_type=='second_renewal')
	{echo "<option selected='second_renewal'>second_renewal</option>";} else {echo "<option value='second_renewal'>second_renewal</option>";}

     if($contract_type=='bid')
	{echo "<option selected='bid'>bid</option>";} else {echo "<option value='bid'>bid</option>";}




	 echo "</select>";
		echo "</td>";
        echo "</tr>";   
	   
	   echo "<tr>";
	  echo "<th>Service Type</th>";
	  echo "<td>";
	 //$service_type='waste_normal';
	  echo "<select name='service_type'>";
	   echo "<option value=''></option>";
	   
	    if($service_type=='agriculture')
	{echo "<option selected='agriculture'>agriculture</option>";} else {echo "<option value='agriculture'>agriculture</option>";}
	 if($service_type=='crs')
	{echo "<option selected='crs'>crs</option>";} else {echo "<option value='crs'>crs</option>";}  
	  if($service_type=='elevator_service')
	{echo "<option selected='elevator_service'>elevator_service</option>";} else {echo "<option value='elevator_service'>elevator_service</option>";}  
	  
	   if($service_type=='janitorial')
	{echo "<option selected='janitorial'>janitorial</option>";} else {echo "<option value='janitorial'>janitorial</option>";}  
	  
	  if($service_type=='personal_services')
	{echo "<option selected='personal_services'>personal_services</option>";} else {echo "<option value='personal_services'>personal_services</option>";}   
	if($service_type=='pest_control')
	{echo "<option selected='pest_control'>pest_control</option>";} else {echo "<option value='pest_control'>pest_ control</option>";}
	if($service_type=='portajon')
	{echo "<option selected='portajon'>portajon</option>";} else {echo "<option value='portajon'>portajon</option>";}

    if($service_type=='revenue_bearing')
	{echo "<option selected='revenue_bearing'>revenue_bearing</option>";} else {echo "<option value='revenue_bearing'>revenue_bearing</option>";}


	if($service_type=='septic_pumping')
	{echo "<option selected='septic_pumping'>septic_pumping</option>";} else {echo "<option value='septic_pumping'>septic_pumping</option>";}
     if($service_type=='snow_removal')
	{echo "<option selected='snow_removal'>snow_removal</option>";} else {echo "<option value='snow_removal'>snow_removal</option>";}     


	if($service_type=='waste_debris')
	{echo "<option selected='waste_debris'>waste_debris</option>";} else {echo "<option value='waste_debris'>waste_debris</option>";}
	if($service_type=='waste_normal')
	{echo "<option selected='waste_normal'>waste_normal</option>";} else {echo "<option value='waste_normal'>waste_normal</option>";}
    if($service_type=='water_testing')
	{echo "<option selected='water_testing'>water_testing</option>";} else {echo "<option value='water_testing'>water_testing</option>";}
     echo "</select>";
	/*	
		echo " <option value='portajon'>Port A Jon</option>
			 <option value='septic_pumping'>Septic Pumping</option>
			 <option value='waste_debris'>Waste Debris</option>
            <option value='waste_normal'>Waste Normal</option>           
            <option value='water_testing'>Water Testing</option>           
            </select>";
			*/
		echo "</td>";
        echo "</tr>";   
	   
	 
	   echo "<tr>";
	echo "<th><font color='brown'>Contractor Name</font></th><td><input name='vendor' type='text' size='35' value='$vendor' id='vendor'></td>";
	    //echo "<th><font color='brown'>Contractor Name</font></th><td><textarea rows='4' cols='50' name='vendor'>$vendor</textarea></td>"; 
	   echo "</tr>";
	  
	   echo "<tr>";
	   echo "<th><font color='brown'>Contract Num</font><td><input name='contract_num' type='text' size='25' value='$contract_num' id='contract_num'></td></th>";
	   echo "</tr>";
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>PO Number</font></th><td><input name='po_num' type='text' size='25' value='$po_num' id='po_num'></td>";
	   echo "</tr>";
	   
	  
	  /*
	    echo "<tr>";
	   echo "<th><font color='brown'>PO Original Grand Total</font></th><td><input name='po_original_total' type='text' size='15' value='$po_original_total' id='po_original_total' ></td> ";
	   echo "</tr>";
	   
	  */ 
	  
	   
	   echo "<tr><th><font color='brown'>Buy Entity</font></th><td><input name='buy_entity' type='text' size='15' value='$buy_entity' id='buy_entity' ></td> </tr>";
	   echo "<tr><th><font color='brown'>NCAS Center</font></th><td><input name='center' type='text' size='15' value='$center' id='center' ></td> </tr>";
	   echo "<tr><th><font color='brown'>NCAS Account</font></th><td><input name='ncas_account' type='text' size='15' value='$ncas_account' id='ncas_account' ></td> </tr>";
	   echo "<tr><th><font color='brown'>NCAS Company</font></th><td><input name='company' type='text' size='15' value='$company' id='company' ></td> </tr>";
	   //echo "<tr><th><font color='brown'>Remit to Address</font></th><td><input name='remit_address' type='text' size='15' value='$remit_address' id='remit_address' ></td> </tr>";
	    echo "<tr><th><font color='brown'>Remit to Address</font></th><td><textarea rows='4' cols='50' name='remit_address' id='remit_address'>$remit_address</textarea></td></tr>"; 
	   echo "<tr><th><font color='brown'>FID#</font></th><td><input name='fid_num' type='text' size='15' value='$fid_num' id='fid_num' ></td> </tr>";
	   echo "<tr><th><font color='brown'>Group#</font></th><td><input name='group_num' type='text' size='15' value='$group_num' id='group_num' ></td> </tr>";
	   
	    
	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Monthly Cost</font></th><td><input name='monthly_cost' type='text' size='25' value='$monthly_cost' id='monthly_cost'></td>";
	   echo "</tr>";
	   echo "<tr>";
	   echo "<th><font color='brown'>Yearly Cost</font></th><td><input name='yearly_cost' type='text' size='25' value='$yearly_cost' id='yearly_cost'></td>";
	   echo "</tr>";
	   
	 	   
	   echo "<tr>";
	   echo "<th><font color='brown'>Original Contract Start Date</font></th><td><input name='original_contract_start_date' type='text' size='25' value='$original_contract_start_date' id='datepicker4'></td>";
	   echo "</tr>";
	   echo "<tr>";
	   echo "<th><font color='brown'>Original Contract End Date</font></th><td><input name='original_contract_end_date' type='text' value='$original_contract_end_date' size='25' id='datepicker5'></td>";
	   echo "</tr>";
	   
/*	
	   echo "<tr>";
	   echo "<th><font color='brown'>Initiate Renewal Bid Date<br />(90 days prior to end of Original Contract End Date)</font></th><td>$first_renewal_date</td>";
	   echo "</tr>";
*/
	  
	   echo "<tr>";
	   //echo "<th><font color='brown'>Comments</font></th><td><input name='comments' type='text' size='25' id='comments'></td>"; 
	   echo "<th><font color='brown'>Comments</font></th><td><textarea rows='4' cols='50' name='comments'>$comments</textarea></td>"; 
	   echo "</tr>";
	   
if($id=='')
{	
	   echo "<tr>";
	   echo "<th><font color='brown'>Document Upload</font></th>";
	   echo "<td>";
	   echo "<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'>";
	   echo "</td>"; 
	   echo "</tr>";
}
/*
if($id!='')
{	
	   echo "<tr>";
	   echo "<th><font color='brown'>Document Upload</font></th>";
	   echo "<td>";
	   echo "<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'>";
	   echo "</td>"; 
	   echo "</tr>";
}

*/





if($id=='')
{
//$active=strtolower($active);
if($active==''){$active='y';}
if($active=="n"){$ckN="checked";$ckY="";}else{$ckN="";$ckY="checked";}	
echo "<tr>";
echo "<th>Contract Active</th>";

echo "<th>";
echo "N <input type='radio' name='active' value='n'$ckN><br />Y <input type='radio' name='active' value='y'$ckY>";
echo "</th>";

echo "</tr>";
}







if($id=='')
{	
//echo "<td><input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'></td>";
echo "<tr>";
echo "<th></th><th><input type=submit name=record_search submit value=search>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name=record_insert submit value=add></th></tr>";
}





	

if($id!='')
{
$active=strtolower($active);
if($active=="n"){$ckN="checked";$ckY="";}else{$ckN="";$ckY="checked";}
if($active=='n'){$active_N="<font color='red'>N</font>"; $active_Y="<font color='grey'>Y</font>";}	
if($active=='y'){$active_N="<font color='grey'>N</font>"; $active_Y="<font color='green'>Y</font>";}	

//if($active=='y'){$active_Y="<font color='green'>Y</font>";} else {$active_Y="<font color='brown'>N</font>";}	
echo "<tr>";
echo "<th>Contract Active";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//echo "<th>";
echo "$active_N<input type='radio' name='active' value='n'$ckN>&nbsp;&nbsp;&nbsp;&nbsp;$active_Y <input type='radio' name='active' value='y'$ckY>";
echo "</th>";


$record_complete=strtolower($record_complete);
if($record_complete=="n"){$rcN="checked";$rcY="";}else{$rcN="";$rcY="checked";}
if($record_complete=='n'){$complete_N="<font color='red'>N</font>"; $complete_Y="<font color='grey'>Y</font>";}	
if($record_complete=='y'){$complete_N="<font color='grey'>N</font>"; $complete_Y="<font color='green'>Y</font>";}


echo "<th>Record Complete";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//echo "<th>";
echo "$complete_N<input type='radio' name='record_complete' value='n'$rcN>&nbsp;&nbsp;&nbsp;&nbsp;$complete_Y <input type='radio' name='record_complete' value='y'$rcY>";
echo "</th>";




echo "</tr>";
}

if($id!='')
{
echo "<tr>";
echo "<th><a href='po_lines.php?scid=$id'>PO Lines (scid=$id)</a></th>";
echo"<th>";
echo "<input type='hidden' name='id' submit value='$id'></form>";
echo "<input type=submit name=submit submit value=update></form>";
echo "</th>";
echo "</tr>";
}
echo "</table>";	 

echo "</html>";
?>
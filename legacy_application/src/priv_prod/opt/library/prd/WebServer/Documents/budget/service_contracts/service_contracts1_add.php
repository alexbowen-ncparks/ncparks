<?php
//if($level=="5" and $tempid !="Dodd3454"){echo "<pre>";print_r($_REQUEST);echo "</pre>";}//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: https://10.35.152.9/login_form.php?db=budget");
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
include("head1.php");
include ("../../budget/menu1415_v1_new.php");
echo "<br />";
$menu_sc='add';
include("service_contracts_menu.php");
echo "<br />";

//if($delrec==='y'){echo "write code to mark record as delrec"; exit;}



echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='service_contract_add_record.php'>";	
//echo "<form  method='post' autocomplete='off' action='service_contract_add_record.php'>";


echo "<table border=1 align='center'>";
echo "<tr>";echo "<th><font color='brown'>Park</font></th><td><input name='park' type='text' size='15' value='$park' id='park' autocomplete='off'></td>";echo "</tr>";
echo "<tr>";echo "<th><font color='brown'>Administrator (UserID)</font></th><td><input name='contract_admin_tempid' type='text' size='15' value='$contract_admin_tempid' id='park' autocomplete='off'></td>";echo "</tr>";
echo "<tr><th>Contract Type</th>";
echo "<td>";
echo "<select name='contract_type'>";
echo "<option value=''></option>";
	if($contract_type=='original'){echo "<option selected='original'>original</option>";} else {echo "<option value='original'>original</option>";}		
	if($contract_type=='first_renewal'){echo "<option selected='first_renewal'>first_renewal</option>";} else {echo "<option value='first_renewal'>first_renewal</option>";}
    if($contract_type=='second_renewal'){echo "<option selected='second_renewal'>second_renewal</option>";} else {echo "<option value='second_renewal'>second_renewal</option>";}
    if($contract_type=='bid'){echo "<option selected='bid'>bid</option>";} else {echo "<option value='bid'>bid</option>";}
echo "</select>";
echo "</td>";
echo "</tr>";   
	   
echo "<tr>";
echo "<th>Service Type</th>";
echo "<td>";
echo "<select name='service_type'>";
echo "<option value=''></option>";	   
   if($service_type=='agriculture'){echo "<option selected='agriculture'>agriculture</option>";} else {echo "<option value='agriculture'>agriculture</option>";}
   if($service_type=='crs'){echo "<option selected='crs'>crs</option>";} else {echo "<option value='crs'>crs</option>";}  
   if($service_type=='elevator_service'){echo "<option selected='elevator_service'>elevator_service</option>";} else {echo "<option value='elevator_service'>elevator_service</option>";}  
   if($service_type=='janitorial'){echo "<option selected='janitorial'>janitorial</option>";} else {echo "<option value='janitorial'>janitorial</option>";}  
   if($service_type=='personal_services'){echo "<option selected='personal_services'>personal_services</option>";} else {echo "<option value='personal_services'>personal_services</option>";}   
   if($service_type=='pest_control'){echo "<option selected='pest_control'>pest_control</option>";} else {echo "<option value='pest_control'>pest_ control</option>";}
   if($service_type=='portajon'){echo "<option selected='portajon'>portajon</option>";} else {echo "<option value='portajon'>portajon</option>";}
   if($service_type=='revenue_bearing'){echo "<option selected='revenue_bearing'>revenue_bearing</option>";} else {echo "<option value='revenue_bearing'>revenue_bearing</option>";}
   if($service_type=='septic_pumping'){echo "<option selected='septic_pumping'>septic_pumping</option>";} else {echo "<option value='septic_pumping'>septic_pumping</option>";}
   if($service_type=='snow_removal'){echo "<option selected='snow_removal'>snow_removal</option>";} else {echo "<option value='snow_removal'>snow_removal</option>";}     
   if($service_type=='waste_debris'){echo "<option selected='waste_debris'>waste_debris</option>";} else {echo "<option value='waste_debris'>waste_debris</option>";}
   if($service_type=='waste_normal'){echo "<option selected='waste_normal'>waste_normal</option>";} else {echo "<option value='waste_normal'>waste_normal</option>";}
   if($service_type=='water_testing'){echo "<option selected='water_testing'>water_testing</option>";} else {echo "<option value='water_testing'>water_testing</option>";}
echo "</select>";	
echo "</td>";
echo "</tr>";   
	 
echo "<tr><th><font color='brown'>Contractor Name</font></th><td><input name='vendor' type='text' size='35' value='$vendor' id='vendor'></td></tr>";	  
echo "<tr><th><font color='brown'>Contract Num</font><td><input name='contract_num' type='text' size='25' value='$contract_num' id='contract_num'></td></th></tr>";	   
echo "<tr><th><font color='brown'>PO Number</font></th><td><input name='po_num' type='text' size='25' value='$po_num' id='po_num'></td></tr>";	   
echo "<tr><th><font color='brown'>Buy Entity</font></th><td><input name='buy_entity' type='text' size='15' value='$buy_entity' id='buy_entity' ></td></tr>";
echo "<tr><th><font color='brown'>NCAS Center</font></th><td><input name='center' type='text' size='15' value='$center' id='center' ></td></tr>";
echo "<tr><th><font color='brown'>NCAS Account</font></th><td><input name='ncas_account' type='text' size='15' value='$ncas_account' id='ncas_account' ></td></tr>";
echo "<tr><th><font color='brown'>NCAS Company</font></th><td><input name='company' type='text' size='15' value='$company' id='company' ></td></tr>";
echo "<tr><th><font color='brown'>Remit to Address</font></th><td><textarea rows='4' cols='50' name='remit_address' id='remit_address'>$remit_address</textarea></td></tr>"; 
echo "<tr><th><font color='brown'>FID#</font></th><td><input name='fid_num' type='text' size='15' value='$fid_num' id='fid_num' ></td></tr>";
echo "<tr><th><font color='brown'>Group#</font></th><td><input name='group_num' type='text' size='15' value='$group_num' id='group_num' ></td></tr>";
echo "<tr><th><font color='brown'>Monthly Cost</font></th><td><input name='monthly_cost' type='text' size='25' value='$monthly_cost' id='monthly_cost'></td></tr>";
echo "<tr><th><font color='brown'>Yearly Cost</font></th><td><input name='yearly_cost' type='text' size='25' value='$yearly_cost' id='yearly_cost'></td></tr>";
echo "<tr><th><font color='brown'>Original Contract Start Date</font></th><td><input name='original_contract_start_date' type='text' size='25' value='$original_contract_start_date' id='datepicker4'></td></tr>";
echo "<tr><th><font color='brown'>Original Contract End Date</font></th><td><input name='original_contract_end_date' type='text' value='$original_contract_end_date' size='25' id='datepicker5'></td></tr>";
echo "<tr><th><font color='brown'>Comments</font></th><td><textarea rows='4' cols='50' name='comments'>$comments</textarea></td></tr>";
echo "<tr>";
	   echo "<th><font color='brown'>Document Upload</font></th>";
	   echo "<td><input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'></td>"; 
echo "</tr>";

if($active==''){$active='y';}
if($active=="n"){$ckN="checked";$ckY="";}else{$ckN="";$ckY="checked";}
	
echo "<tr><th>Contract Active</th><th>N<input type='radio' name='active' value='n'$ckN><br />Y <input type='radio' name='active' value='y'$ckY></th></tr>";

echo "<tr>";
echo "<th></th>";
//echo "<th><input type=submit name=record_search submit value=search>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type=submit name=record_insert submit value=add></th>";
echo "<th><input type=submit name=record_insert submit value=add></th>";
echo "</tr>";

echo "</table>";	 

echo "</html>";
?>
<?php
//if($level=="5" and $tempid !="Dodd3454"){echo "<pre>";print_r($_REQUEST);echo "</pre>";}//exit;
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
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
$menu_fa='fa1';
$source_table='fixed_assets';
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
include("fixed_assets_menu.php");
if($type==''){$type='add';}
if($type=='add'){$shade_add="class='cartRow'";}
if($type=='search'){$shade_search="class='cartRow'";}
echo "<br />";
/*
echo "<table ALIGN='center' ><tr><th><font color=brown><i>FAS#</font></i></th><td><font $shade_add><a href='fixed_assets1.php?menu_fa=fa1&type=add'>Add</a></font></td><td><font $shade_search><a href='fixed_assets1.php?menu_fa=fa1&type=search'>Search</a></font></td></tr></table>";
echo "<br />";
*/
//if($delrec==='y'){echo "write code to mark record as delrec"; exit;}


if($type=='add')
{
echo "<table ALIGN='center' ><tr><th><font color=brown><i>FAS#</font></i></th><td><font $shade_add><a href='fixed_assets1.php?menu_fa=fa1&type=add'>Add</a></font></td><td><font $shade_search><a href='fixed_assets1.php?menu_fa=fa1&type=search'>Search</a></font></td></tr></table>";
echo "<br />";	
	
	
if($id != '')
{
$query1="select park,fas_num,fas_description,payment_source,source_id,document_location,sed,entered_by
         from fixed_assets where id='$id' ";
          
$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1. $query1");	

$row1=mysqli_fetch_array($result1);

extract($row1);
	
echo "<table align='center'>";
echo "<tr><th><font color='brown'>Park:  </font><font color='green'>$park</font></th></tr>";	
echo "<tr><th><font color='brown'>FAS#:  </font><font color='green'>$fas_num</font></th></tr>";	
echo "<tr><th><font color='brown'>Payment Source:  </font><font color='green'>$payment_source</font></th></tr>";	
echo "<tr><th><font color='brown'>Source ID:  </font><font color='green'>$source_id</font></th></tr>";	
echo "<tr><th><font color='brown'>Document:  </font><font color='green'><a href='$document_location' target='_blank'>View</a></font></th></tr>";	
echo "<tr><th><font color='brown'><img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><font color='green'>Record added to Database. Thanks!</th></tr>";	
	
	
}
else
{	
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='fixed_assets_add_record.php'>";	
//echo "<form  method='post' autocomplete='off' action='service_contract_add_record.php'>";



echo "<table border=1 align='center'>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr>";
	   echo "<th><font color='brown'>Park</font></th><td><input name='park' type='text' size='10' value='$park' id='park' autocomplete='off'></td>";
	   echo "</tr>";
	  
	  echo "<tr>";
	   echo "<th><font color='brown'>FAS#</font></th><td><input name='fas_num' type='text' size='10' value='$fas_num' id='fas_num' autocomplete='off'></td>";
	   echo "</tr>";
	  
	   echo "<tr>";
	   echo "<th><font color='brown'>FAS Description</font></th><td><input name='fas_description' type='text' size='30' value='$fas_description' id='fas_description' autocomplete='off'></td>";
	   echo "</tr>";
	  
	  
	  echo "<tr>";
	  echo "<th>Payment Source</th>";
	  echo "<td>";
	 // $payment_type='second_renewal';
	  echo "<select name='payment_source'>";
	  echo "<option value=''></option>";
	if($payment_type=='cdcs')
	{echo "<option selected='cdcs'>cdcs</option>";} else {echo "<option value='cdcs'>cdcs</option>";}		
	if($payment_type=='pcard')
	{echo "<option selected='pcard'>pcard</option>";} else {echo "<option value='pcard'>pcard</option>";}
     echo "</select>";
		echo "</td>";
        echo "</tr>";   
	   
	     
	 
	   echo "<tr>";
	echo "<th><font color='brown'>Source ID</font></th><td><input name='source_id' type='text' size='10' value='$source_id' id='source_id' autocomplete='off'></td>";
	    //echo "<th><font color='brown'>Contractor Name</font></th><td><textarea rows='4' cols='50' name='vendor'>$vendor</textarea></td>"; 
	   echo "</tr>";

	   echo "<tr>";
	   echo "<th><font color='brown'>Document Upload</font></th>";
	   echo "<td>";
	   echo "<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'>";
	   echo "</td>"; 
	   echo "</tr>";




//echo "<td><input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'></td>";
echo "<tr>";
echo "<th></th><th><input type=submit name=record_insert submit value=add></th></tr>";


/*
if($id!='')
{
echo "<tr>";
echo "<th>";
echo "</th>";
echo"<th>";
echo "<input type='hidden' name='id' submit value='$id'></form>";
echo "<input type=submit name=submit submit value=update></form>";
echo "</th>";
echo "</tr>";
}
*/

echo "</table>";
exit;
}
}	 
if($type=='search')
{
echo "<table ALIGN='center' ><tr><th><font color=brown><i>FAS#</font></i></th><td><font $shade_add><a href='fixed_assets1.php?menu_fa=fa1&type=add'>Add</a></font></td><td><font $shade_search><a href='fixed_assets1.php?menu_fa=fa1&type=search'>Search</a></font></td></tr></table>";
echo "<br />";	
echo "<form method='post' autocomplete='off' action='fixed_assets1.php'>";	
//echo "<form  method='post' autocomplete='off' action='service_contract_add_record.php'>";



echo "<table border=1 align='center'>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr>";
	   echo "<th><font color='brown'>Park</font></th><td><input name='park' type='text' size='10' value='$park' id='park' autocomplete='off'></td>";
	   echo "</tr>";
	  
	  echo "<tr>";
	   echo "<th><font color='brown'>FAS#</font></th><td><input name='fas_num' type='text' size='10' value='$fas_num' id='fas_num' autocomplete='off'></td>";
	   echo "</tr>";
	   echo "<th></th><th><input type=submit name=fas_search submit value=search></th></tr>";
	   echo "</table>";
echo "<input type='hidden' name='type' value='search'>";
echo "</form>";

if($fas_search=='search')
{

if($park != ''){$where_park=" and park='$park'";}	
if($fas_num != ''){$where_fas_num=" and fas_num='$fas_num'";}
$query1="select id,park,fas_num,fas_description,payment_source,source_id,document_location,sed,entered_by
         from fixed_assets where 1 $where_park $where_fas_num order by park,fas_num ";
//echo "<br />query1=$query1<br />";          
$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1. $query1");	
$record_count=mysqli_num_rows($result1);
//echo "<br />record_count=$record_count<br />";
//$row1=mysqli_fetch_array($result1);
//extract($row1);	
echo "<table align='center'>";
echo "<tr>";
echo "<th>Results: $record_count</th>";
//echo "<th>Edit</th>";
echo "</tr>";
echo "</table>";	
echo "<table align='center' border='1'>";
//echo "<tr><th>Park</th><th>FAS#</th><th>FAS Description</th><th>Payment Source</th><th>Source ID</th><th>FAS Document</th></tr>";
echo "<tr><th>Park</th><th>FAS#</th><th>FAS Description</th><th>Payment Source</th><th>FAS Document</th></tr>";
while ($row1=mysqli_fetch_array($result1)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row1);
$table_bg2="cornsilk";

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}
echo "<tr$t>";
echo "<td>$park</td>";
echo "<td>$fas_num</td>";
echo "<td>$fas_description</td>";

echo "<td><a href='acs.php?id=$source_id&m=invoices' target='_blank'>$payment_source</a><br />$source_id</td>";
//echo "<td>$source_id</td>";
echo "<td><a href='$document_location' target='_blank'>View</a></td>";
echo "<td><a href=fixed_assets1.php?menu_fa=fa1&type=edit&id=$id>edit</a></td>";
echo "</tr>";

}
echo "</table>";



	
}
	
}


if($type=='edit')
{
//echo "type=$type";
echo "<table ALIGN='center' ><tr><th><font color=brown><i>FAS#</font></i></th><td><font class='cartRow'>Edit</font></td></tr></table>";
echo "<br />";	
if($comp=='yes')
{
echo "<table ALIGN='center' ><tr><th><font color=brown><i>FAS# Update Complete <img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img></font></i></th></tr></table>";
echo "<br />";

}	
$query1="select park,fas_num,fas_description,payment_source,source_id,document_location,sed,entered_by
         from fixed_assets where id='$id' ";
		 
echo "Line 280: query1=$query1";
          
$result1=mysqli_query($connection,$query1) or die ("Couldn't execute query 1. $query1");	

$row1=mysqli_fetch_array($result1);

extract($row1);	
echo "<form enctype='multipart/form-data' method='post' autocomplete='off' action='fixed_assets_update_record.php'>";	
//echo "<form  method='post' autocomplete='off' action='service_contract_add_record.php'>";



echo "<table border=1 align='center'>";
       //echo "<form name='form1' method='post' action='duplicate_notes_insert.php'>";
	   echo "<tr>";
	   echo "<th><font color='brown'>Park</font></th><td><input name='park' type='text' size='10' value='$park' id='park' autocomplete='off'></td>";
	   echo "</tr>";
	  
	  echo "<tr>";
	   echo "<th><font color='brown'>FAS#</font></th><td><input name='fas_num' type='text' size='10' value='$fas_num' id='fas_num' autocomplete='off'></td>";
	   echo "</tr>";
	    echo "<tr>";
	   echo "<th><font color='brown'>FAS Description</font></th><td><input name='fas_description' type='text' size='30' value='$fas_description' id='fas_description' autocomplete='off'></td>";
	   echo "</tr>";
	   /*
	   echo "<tr>";
	   echo "<th><font color='brown'>Payment Source</font></th><td><input name='payment_source' type='text' size='10' value='$payment_source' id='$payment_source' autocomplete='off'></td>";
	   echo "</tr>";
	   echo "<tr>";
	   */
	    echo "<tr>";
	  echo "<th>Payment Source</th>";
	  echo "<td>";
	 // $payment_type='second_renewal';
	  echo "<select name='payment_source'>";
	  echo "<option value=''></option>";
	if($payment_source=='cdcs')
	{echo "<option selected='cdcs'>cdcs</option>";} else {echo "<option value='cdcs'>cdcs</option>";}		
	if($payment_source=='pcard')
	{echo "<option selected='pcard'>pcard</option>";} else {echo "<option value='pcard'>pcard</option>";}
     echo "</select>";
		echo "</td>";
        echo "</tr>";   
	   echo "<th><font color='brown'>Source ID</font></th><td><input name='source_id' type='text' size='10' value='$source_id' id='$source_id' autocomplete='off'></td>";
	   echo "</tr>";
	    echo "<tr>";
		echo "<th>Re-Load Document.<br /><font color='red'>Warning! Existing Document will be Over-written</font></th>"; 
	   echo "<td>";
	   echo "<input type='file' id='document' name='document'><input type='hidden' name='content_mode' value='$content_mode' /><input type='hidden' name='MAX_FILE_SIZE' value='2000000'>";
	   echo "</td>"; 
	    echo "</tr>";
	   
	   
	   echo "<th></th><th><input type=submit name=submit submit value=Update></th></tr>";
	   echo "</table>";
echo "<input type='hidden' name='type' value='$type'>";
echo "<input type='hidden' name='id' value='$id'>";
echo "</form>";
}



















echo "</html>";
?>
<?php

/*    *** INCLUDE file inventory ***
   include("/opt/library/prd/WebServer/include/iConnect.inc")
   include ("test_style_overshort.php")
   include("../../../budget/menu1314_tony.html")
*/

session_start();

if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempid=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
extract($_REQUEST);
$ctdd_id=$id;
//echo "ctdd_id=$ctdd_id<br />";
//echo $concession_location;

//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;

//echo "<pre>";print_r($_SESSION);"</pre>"; //exit;
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$query1="select count(id) as 'manager_count'
         from cash_handling_roles
         where role='manager' and tempid='$tempid'	 ; ";
	 
//echo "query1=$query1<br />";
		 
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
		  
$row1=mysqli_fetch_array($result1);

extract($row1);

//echo "manager_count=$manager_count<br />";

if($manager_overshort_comment != '')
{
  $manager_overshort_comment2=htmlspecialchars_decode($manager_overshort_comment);

  $query3="update crs_tdrr_division_deposits
           set manager_overshort_comment='$manager_overshort_comment2'
           where id='$id'	 ; ";

  //echo "query3=$query3<br />";
		 
  $result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
  //echo "Line 59 exit<br />"; exit;

}

if($fs_approver_overshort_comment != '')
{
  $query3="update crs_tdrr_division_deposits
           set fs_approver_overshort_comment='$fs_approver_overshort_comment'
           where id='$id'	 ; ";

  //echo "query3=$query3<br />";
		 
  $result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3");
}

$query4="select orms_deposit_id,controllers_deposit_id,bank_deposit_date,cashier,f_year as 'fiscal_year'
         from crs_tdrr_division_deposits
         where id='$id'	 ; ";

		 
//echo "query4=$query4<br />";
		 
$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");
		  
$row4=mysqli_fetch_array($result4);

extract($row4);
$bank_deposit_date2=date('m-d-y', strtotime($bank_deposit_date));
$query4a="select sum(amount) as 'total_check_amount'
         from crs_tdrr_division_deposits_checklist
         where orms_deposit_id='$orms_deposit_id'	 ; ";

$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");
		  
$row4a=mysqli_fetch_array($result4a);

extract($row4a);

$query11="select cashier,cashier_overshort_comment,cashier_date,manager,manager_overshort_comment,manager_date,fs_approver,fs_approver_overshort_comment,fs_approver_date,accountant_comment_name,accountant_comment,accountant_comment_date from crs_tdrr_division_deposits
          where orms_deposit_id='$orms_deposit_id' order by id ";
//echo "query11=$query11";//exit;
$result11 = mysqli_query($connection, $query11) or die ("Couldn't execute query 11.  $query11 ");
 $num11=mysqli_num_rows($result11);	
 echo "<html>";
   echo "<head>
           <title>MoneyTracker</title>";

//include ("test_style.php");
include ("test_style_overshort.php");
     echo "<style>";
       echo "#table1{
                     width:800px;
	                 margin-left:auto; 
                     margin-right:auto;
	                 }";
       echo "</style>";
   echo "</head>";

include("../../../budget/menu1314_tony.html");

$query1="SELECT park as 'parkcode' from crs_tdrr_division_deposits
         where id='$id' ";
		 
//echo "query1=$query1<br />";		 

$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);


$query11e="select center_desc from center where parkcode='$parkcode'   ";	

//echo "query1d=$query1d<br />";//exit;		  

$result11e = mysqli_query($connection, $query11e) or die ("Couldn't execute query 11e.  $query11e");
		  
$row11e=mysqli_fetch_array($result11e);

extract($row11e);

$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query1d=$query1d<br />";//exit;		  

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);

//$center_location = str_replace("_", " ", $center_desc);
//echo "center location=$center_location";
 
 /*
 echo "<div class='mc_header'>";
echo "<table><tr><th><img height='50' width='50' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img></th><th><font color='blue'>MoneyCounts-$center_location</font></th></tr></table>";
echo "</div>";
 */
 echo "<br /><br />";
 echo "<table align='center'>
         <tr>
           <td><img height='25' width='25' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'><font color='blue'><b>$center_location $center</b></font></img><br /><font color='brown' size='5'><b>Over/Short Comments</b></font>
           </td>
         </tr>
       </table>";
 
 
echo "<br /><br /><br />";
 echo "<table align='center'>";
 //echo "<tr><td>ORMS ID $orms_deposit_id</td></tr>";
 echo "  <tr bgcolor='lightcyan'>
           <td><font color='red' size='5'>Bank Deposit $controllers_deposit_id</font>
           </td>
        </tr>";
  echo "<tr bgcolor='lightcyan'>
          <td>Bank Deposit Date $bank_deposit_date2
          </td>
        </tr>"; 
 //echo "<tr><td>Cashier $cashier</td></tr>";
 echo "</table>";
 echo "<br />";
 echo "<br />";
 // 6/1/15: LAWA Seasonal employee Paula Wagner,  Budget Officer Tammy Dodd,  Accountant Tony Bass
 /*
 if($tempid=='Wagner9210' or $beacnum=='60032781' or $beacnum=='60032793')
 {
 echo "<table align='center'><tr><td><a href='check_listing.php?id=$id&edit=y'>Edit Check Listing</a></td></tr></table>";
 }
 */
 if($edit!='y')
 {
 //echo "<div id='table1'>";
 
 
 
 
 
 echo "<table border=1  align='center' id='table1'>";
//echo "<tr><th colspan='5'>DENR Daily Receipt Check Log</th></tr>";
   echo "<tr>"; 
//echo "<th align=left><font color=brown>ORMS Deposit ID</font></th>";
//echo "<th align=left><font color=brown>Controllers Deposit ID</font></th>";       
     echo "<th align=left><font color=brown>Deposit Cashier</font>
           </th>";
     echo "<th align=left><font color=brown>Park Manager</font>
           </th>";
     echo "<th align=left><font color=brown>Budget Office</font>
           </th>";
     echo "<th align=left><font color=brown>Accountant</font>
           </th>";

//echo "<th align=left><font color=brown>Bank<br />Deposit<br />Date</font></th>";
//echo "<th align=left><font color=brown>Cashier</font></th>";      
  echo "</tr>";

//$row=mysqli_fetch_array($result);

// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row11=mysqli_fetch_array($result11))
{
  extract($row11);
  if($fs_approver_date=='0000-00-00')
  {
    $fs_approver_date='';
  }
  $table_bg2='cornsilk';
  if($c=='')
  {
    $t=" bgcolor='$table_bg2'";
    $c=1;
  }
  else
  {
    $t='';
    $c='';
  }
echo "<tr$t>";
 
 //echo "<td><a href='crs_deposits_cashier_deposit.php?deposit_id=$deposit_id2&GC=$GC' '>Update</a></td>";		   
//echo "<td>$orms_deposit_id</td>";		   
  echo "<td>
          <font color='red'>$cashier</font>
          <br />$cashier_overshort_comment<br />$cashier_date
        </td>";   
if($manager_count==1 and $man_edit=='y')
{
  echo "<td>";
    echo "<form action='overshort_comments.php'>";
    echo "<textarea rows='17' cols='35' name='manager_overshort_comment'
                    placeholder='Budget Comments for Over/Short Amount'>$manager_overshort_comment</textarea>";
      echo "<input type='hidden' name='id' value='$id'>";
      echo "<input type='submit' name='submit' value='Submit'>
      </tr>";
    echo "</form>";
echo "</td>";
}
else
{  
  $manager_overshort_comment2=str_replace('  ','&nbsp;&nbsp;',$manager_overshort_comment);
  $manager_overshort_comment2=htmlspecialchars_decode($manager_overshort_comment2);
  $manager_overshort_comment2=nl2br($manager_overshort_comment2);
                 
echo "<td>
        <font color='red'>$manager</font><br />$manager_overshort_comment2<br />$manager_date<br /><br />"; 
  if($manager_count==1)
  {
  echo "<a href=overshort_comments.php?id=$id&man_edit=y>Edit Comments</a>";
  }
echo "</td>";} 

if($fs_edit=='y')                 
{
  echo "<td>";
    echo "<form action='overshort_comments.php'>";
      echo "<textarea rows='11' cols='25' name='fs_approver_overshort_comment' placeholder='Budget Comments for Over/Short Amount'>$fs_approver_overshort_comment</textarea>";
    echo "<input type='hidden' name='id' value='$id'>";
    echo "<input type='submit' name='submit' value='Submit'>
      </tr>";
   echo "</form>";
   echo "</td>
      </tr>";
  }
 else
 {
  echo "<td>
          <font color='red'>$fs_approver</font><br />$fs_approver_overshort_comment<br />$fs_approver_date<br />";
    /* 2022-02-25: CCOOPER - adding access for C Williams (827) and R Gooding (997), access already granted in the IF statement for Rumble (015), Dodd (781), and Boggus (242)

    */
    if($beacnum=='60036015' or 
       $beacnum=='60032781' or 
       $beacnum=='60033242' or
       $beacnum=='65032827' or
       $beacnum=='60032997')
    {
    /* 2022-02-25: End CCOOPER */
     echo "<a href=overshort_comments.php?id=$id&fs_edit=y>Edit</a>";
    }
  echo "</td>";}                     
  echo "<td><font color='red'>$accountant_comment_name</font><br />$accountant_comment<br />$accountant_comment_date</td>";                      
              
//echo "<td>$bank_deposit_date</td>";                      
//echo "<td>$cashier</td>";                      
            
echo "</tr>";

 }
 //echo "<tr><td></td><td></td><td></td><td><td>Detail Total Debits</td></tr>";
 //echo "<tr><td></td><td></td><td></td><td>$total_check_amount</td><td>Detail Total Credits</tr>";
  echo "</table>";
 //echo "</div>";
 }

 echo "</body></html>";
 
?>
<?php

/********************************************************************************
Name:           Related Ticket(s):
Date: 
Description:

-- if applicable:
[Include files]

[Arrays created/used]  

[Databases accessed]

---------------------------------------------------------------------------
                                Change Log
---------------------------------------------------------------------------
{youngest}
20220929 – [TIC-55] : jgcarter - grant Angela Boggus BUOF Exception ability
					: ccooper - grant C Williams (65032827) and R Gooding (60032997) BUOF Exception ability
MM/DD/YYYY – [TIC<#>] : <description of change>
{oldest}
******************************************************************************/



session_start();
if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

$active_file=$_SERVER['SCRIPT_NAME'];

$level=$_SESSION['budget']['level'];
$posTitle=$_SESSION['budget']['position'];
$tempID=$_SESSION['budget']['tempID'];
$beacnum=$_SESSION['budget']['beacon_num'];
$concession_location=$_SESSION['budget']['select'];
$concession_center=$_SESSION['budget']['centerSess'];
$system_entry_date=date("Ymd");
if($posTitle=='park superintendent'){$pasu_role='y';} else {$pasu_role='n';}
if($tempID=='Cooke2603'){$pasu_role='y';}
if($posTitle=='parks district superintendent'){$disu_role='y';} else {$disu_role='n';}
echo "<html>";
echo "<head>";



echo "</head>";
/*
echo "<table>
<tr><td>tempID</td><td>pasu_role</td><td>disu_role</td></tr>
<tr><td>$tempID</td><td>$pasu_role</td><td>$disu_role</td></tr>
</table>";
*/
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);"</pre>"; exit;
//echo "<br />fyear=$fyear<br />";
if($level==1){$parkcode=$concession_location;}
//echo "$report_date<br />";exit;


//echo $concession_location;
/*
if($level=='5' and $tempID !='Dodd3454')
{
//echo "<pre>";print_r($_SERVER);"</pre>";//exit;
echo "<pre>";print_r($_SESSION);"</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);"</pre>";exit;
}
*/
//echo "<pre>";print_r($_REQUEST);"</pre>";//exit;
//echo "<pre>";print_r($_SESSION);"</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
//include("../budget/~f_year.php");
include("../../../budget/~f_year.php");

if($pasu_comment != '')
{
$pasu_comment=($pasu_comment);
$pasu_comment_query="update cash_summary set pasu_comment='$pasu_comment',pasu_player='$tempID',pasu_comment_date='$system_entry_date',justified='1' where id='$comment_id' ";

$result_pasu_comment_query=mysqli_query($connection, $pasu_comment_query) or die ("Couldn't execute query pasu comment query. $pasu_comment_query");


//echo "comment_update_query=$comment_update_query<br />";
}


if($disu_comment != '')
{
$disu_comment=($disu_comment);
$disu_comment_query="update cash_summary set disu_comment='$disu_comment',disu_player='$tempID',disu_comment_date='$system_entry_date' where id='$comment_id' ";

$result_disu_comment_query=mysqli_query($connection, $disu_comment_query) or die ("Couldn't execute query disu comment query. $disu_comment_query");


//echo "comment_update_query=$comment_update_query<br />";
}

if($buof_comment != '')
{
//echo "<pre>";print_r($_REQUEST);"</pre>"; //exit;	
if($compliance==''){$compliance='n';}	
$buof_comment=($buof_comment);


$buof_comment_query="update cash_summary set buof_comment='$buof_comment',buof_player='$tempID',buof_comment_date='$system_entry_date' where id='$comment_id' ";

//echo "<br />buof_comment_query=$buof_comment_query<br />";


$result_buof_comment_query=mysqli_query($connection, $buof_comment_query) or die ("Couldn't execute query buof comment query. $buof_comment_query");




// Re-Score
if($compliance=='y')
{
	
	
$query0="update cash_summary set compliance='y' where id='$comment_id'     ";

//echo "<br />query0=$query0<br />";

$result0 = mysqli_query($connection, $query0) or die ("Couldn't execute query 0.  $query0");	
	

$query1b="select max(effect_date) as 'max_effectdate' from cash_summary where park='$parkcode' and weekend='n' and fyear='$fyear_edit' ";

//echo "<br />query1b=$query1b<br />";

$result1b = mysqli_query($connection, $query1b) or die ("Couldn't execute query 1b.  $query1b");

$row1b=mysqli_fetch_array($result1b);
extract($row1b);

/*
$query1c="select id from cash_summary where park='$parkcode' and effect_date='$max_effectdate' ";

echo "<br />query1c=$query1c<br />";


$result1c = mysqli_query($connection, $query1c) or die ("Couldn't execute query 1c.  $query1c");

$row1c=mysqli_fetch_array($result1c);
extract($row1c);
*/
	
$query1d="select count(id) as 'count_complete' from cash_summary where weekend='n' and compliance='y' and park='$parkcode' and fyear='$fyear_edit' ";

//echo "<br />query1d=$query1d<br />";

$result1d = mysqli_query($connection, $query1d) or die ("Couldn't execute query 1d.  $query1d");

$row1d=mysqli_fetch_array($result1d);
extract($row1d);//brings back max (end_date) as $end_date

//echo "<br />count_complete=$count_complete<br />";


$query1e="select count(id) as 'count_exception' from cash_summary where weekend='n' and compliance='n' and park='$parkcode' and fyear='$fyear_edit' ";

//echo "<br />query1e=$query1e<br />";

$result1e = mysqli_query($connection, $query1e) or die ("Couldn't execute query 1e.  $query1e");

$row1e=mysqli_fetch_array($result1e);
extract($row1e);//brings back max (end_date) as $end_date

//echo "<br />count_exception=$count_exception<br />";


$query1e1="update cash_summary set exceptions='$count_exception' where park='$parkcode' and effect_date='$max_effectdate' ";

//echo "<br />query1e1=$query1e1<br />";

$result1e1 = mysqli_query($connection, $query1e1) or die ("Couldn't execute query 1e1.  $query1e1");




$query1f="select count(id) as 'count_total' from cash_summary where weekend='n' and park='$parkcode' and fyear='$fyear_edit' ";

//echo "<br />query1f=$query1f<br />";


$result1f = mysqli_query($connection, $query1f) or die ("Couldn't execute query 1f.  $query1f");

$row1f=mysqli_fetch_array($result1f);
extract($row1f);//brings back max (end_date) as $end_date


$new_score=(100*round(($count_complete/$count_total),2));

//echo "<br />new_score=$new_score<br />";

$query1g="update mission_scores set complete='$count_complete',total='$count_total',percomp='$new_score' where playstation='$parkcode' and fyear='$fyear_edit' and gid='9' ";

//echo "<br />query1g=$query1g<br />";


$result1g = mysqli_query($connection, $query1g) or die ("Couldn't execute query 1g.  $query1g");


}
//echo "<br />Line 175<br />";
//exit; 
//echo "comment_update_query=$comment_update_query<br />";
}


//echo "f_year=$f_year";
//if($beacnum !="60032793" and $beacnum != '60033162'){echo "<font color='red' size='5'>Message:"; print_r($_SESSION['budget']['tempID']);echo " does not have access to this report</font>";exit;}
/*
if($level=='5' and $tempID !='Dodd3454')
{

echo "beacon_number:$beacnum";
echo "<br />";
echo "concession_location:$concession_location";
echo "<br />";
echo "concession_center:$concession_center";
echo "<br />";
}
*/
//$table="rbh_multiyear_concession_fees3";

$query10="SELECT body_bgcolor,table_bgcolor,table_bgcolor2
from concessions_customformat
WHERE 1 
";
//echo "query10=$query10<br />";
$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10. $query10");

$row10=mysqli_fetch_array($result10);

extract($row10);

$body_bg=$body_bgcolor;
$table_bg=$table_bgcolor;
$table_bg2=$table_bgcolor2;

//echo "body_bg:$body_bg";
//echo "<br />";
//echo "table_bg:$table_bg";
//echo "<br />";
//echo "table_bg2:$table_bg2";

$query11="SELECT filegroup
from concessions_filegroup
WHERE 1 and filename='$active_file'
";

$result11=mysqli_query($connection, $query11) or die ("Couldn't execute query 11. $query11");

$row11=mysqli_fetch_array($result11);

extract($row11);
//echo "<br />";
//echo $filegroup;

/*
echo "<html>";
echo "<head>
<title>Concessions</title>";
*/
//include ("test_style.php");
//include ("test_style.php");

//echo "</head>";

//include("../../../budget/menus2.php");
//include("menu1314_cash_receipts.php");
//include ("test_style.php");
include ("../../../budget/menu1415_v1.php");
echo "<br />";
if($level==1){include ("park_deposits_report_menu_v3.php");}
include("../../../budget/~f_year.php");
//include("../../../budget/menu1314.php");
//if($center==''){$center=$concession_center;}
//if($park==''){$park=$concession_location;}
//include ("park_deposits_report_menu_v2.php");
//include("/budget/admin/crj_updates/park_posted_deposits_drilldown1_v2.php");
//include ("park_posted_deposits_widget1.php");

//include("../../../budget/park_deposits_report_menu_v3.php");

//include ("park_deposits_report_menu_v3.php");

echo "<br />";





//include ("park_posted_deposits_fyear_header2_v2.php");
//include("park_posted_transactions_report_menu.php");
//include("widget1.php");


//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";


if($park!=''){$parkcode=$park;}


if($parkcode=='')
{
$query5="select center,park,effect_date,beg_bal,deposit_amount,transaction_amount,end_bal,days_elapsed2,compliance,id,pasu_comment,pasu_player,pasu_comment_date,disu_comment,disu_player,disu_comment_date,buof_comment,buof_player,buof_comment_date
from cash_summary
where valid='y'
and weekend='n'
group by park,effect_date desc
";
}
else
{


$query2="select center_desc,center from center where parkcode='$parkcode'   ";	

//echo "query1d=$query1d<br />";//exit;		  

$result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2");
		  
$row2=mysqli_fetch_array($result2);

extract($row2);

$center_location = str_replace("_", " ", $center_desc);


echo "<table><tr><th><img height='25' width='25' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'></img><font color='brown'><b>Deposit Compliance&nbsp;&nbsp;</b></font><font color='green'><b>$center_location</b></font></th></tr></table>";

include("../../../budget/infotrack/slide_toggle_procedures_module2_pid63.php");


//echo "<br /><br />";


include("compliance_fyear_module.php");








$query4="select park,count(id) as 'complianceYes' 
from cash_summary
where valid='y'
and weekend='n'
and compliance='y'
and park='$parkcode'
and fyear='$fyear'
group by park
";

$result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4");

$row4=mysqli_fetch_array($result4);
extract($row4);
if($complianceYes==''){$complianceYes='0';}

$query4a="select park,count(id) as 'complianceNo' 
from cash_summary
where valid='y'
and weekend='n'
and compliance='n'
and park='$parkcode'
and fyear='$fyear'
group by park
";

$result4a = mysqli_query($connection, $query4a) or die ("Couldn't execute query 4a.  $query4a");

$row4a=mysqli_fetch_array($result4a);
extract($row4a);
$total_records=$complianceYes+$complianceNo;
if($complianceNo==''){$complianceNo='0';}

$total_scorable_recs=$complianceYes+$complianceNo;

$score=($complianceYes/$total_scorable_recs)*100;
if($total_scorable_recs==0){$score='100.00';}
$score=number_format($score,0);

$query5="select center,park,effect_date,beg_bal,deposit_amount,transaction_amount,end_bal,days_elapsed2,compliance,id,pasu_comment,pasu_player,pasu_comment_date,disu_comment,disu_player,disu_comment_date,buof_comment,buof_player,buof_comment_date
from cash_summary
where valid='y'
and weekend='n'
and park='$parkcode'
and fyear='$fyear'
group by park,effect_date desc
";

//echo "query5=$query5<br />";
}
/*
if($level==1) 

{

$query5="SELECT *
FROM $table
WHERE 1 
and park='$concession_location'
order by park,vendor ";

}
*/

$result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");
$num5=mysqli_num_rows($result5);



//echo "<table border=5 cellspacing=5>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

//echo "<th align=left><A href='articles_community_edit.php'>Download from Community</A></th><th><A href='article_add.php?&add_your_own=y'>Add your own</A></th>";
//echo "<tr><th align=left><A href='articles_community_edit.php'>Community</A></th></tr>";
//echo "<tr><th><A href='document_add.php?&project_category=$project_category&add_your_own=y'>Add your own</A></th></tr>";	

 	  
//echo "</table>";
//echo "<h2 ALIGN=left><font color=brown>Documents:$num5</font></h2>";

/*
$query6="SELECT sum(crs_tdrr_division_history_parks.amount) as 'total'
FROM crs_tdrr_division_history_parks
WHERE crs_tdrr_division_history_parks.deposit_id='$deposit_id'";
		 
$result6 = mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$num6=mysqli_num_rows($result6);	
*/
/*
echo "<table><tr><th><img height='25' width='25' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'><font color='blue'>$center_location $center</font></img><br /><font color='brown' size='5'><b><img height='25' width='25' src='/budget/infotrack/icon_photos/bank.jpg' alt='picture of bank'><font color='brown'>Bank Deposit Compliance Report (Daily)</b></font></img></th></tr></table>";
*/


//echo "<br />";
//echo "<td><font size=4 color=brown >$park-$center</font></td>";
/*
echo "<table><tr><td><font color='red'>Records: $num5</font></td></tr></table>";
*/

//echo "<table>";

echo "<table><tr><th align='center' colspan='2'><font size='5' color='brown' ><b>Score<br /> $score</b></font></th><td bgcolor='lightgreen'>yes<br />$complianceYes</td><td bgcolor='lightpink'>no<br />$complianceNo</td></tr></table><br />";
/*
  echo "<table>
  <tr bgcolor='lightgreen'><td>yes</td><td align='center'>$complianceYes</td></tr>
              <tr bgcolor='lightpink'><td>no</td><td align='center'>$complianceNo</td></tr>
			  <tr><td> <font color='brown'>Total</font></td><td><font color='brown'>$total_records</font></td></tr>";
//echo "<tr><th><font color='blue'>total</font></th><th><font color='blue'>$num5</font></th></tr>";

              
echo "</table>";
*/
echo "<br />";

$header_array=array("Park","Date","Start<br />Balance","Deposit<br />Amount","Transaction<br />Amount","End<br />Balance","Days Elapsed<br /> (earliest undeposited transaction) ","PASU<br />Compliance<br />Comments","DISU<br />Compliance<br />Comments","BUOF<br />Compliance<br />Comments","ID");
echo "<table>";
echo "<tr>"; 
    /*
 echo "<th align=left><font color=brown>Park</font></th>
	   <th align=left><font color=brown>Date</font></th>
       <th align=left><font color=brown>Beg Balance</font></th>
       <th align=left><font color=brown>Deposit Amount</font></th>
       <th align=left><font color=brown>Transaction Amount</font></th>
       <th align=left><font color=brown>End Balance</font></th>
       <th align=left><font color=brown>Days Elapsed (earliest undeposited transaction) </font></th>
       <th align=left><font color=brown>PASU<br />Compliance<br />Comments</font></th>
       <th align=left><font color=brown>ID</font></th>";
       
   */   
       	   
foreach($header_array as $index=>$fld)
	{
	echo "<th align='left'><font color=brown>$fld</font></th>";
	}   
	   
	   
       
   //echo"<th align=left><font color=brown>Fees</font></th>";
       
              
echo "</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;

$i=0;
while ($row=mysqli_fetch_array($result5)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row);
$pasu_player2=substr($pasu_player,0,-2);
$disu_player2=substr($disu_player,0,-2);
$buof_player2=substr($buof_player,0,-2);

$amount=number_format($amount,2);
//$amount_2751=number_format($amount_2751,2);
//$amount_1000=number_format($amount_1000,2);
//$amount_total=number_format($amount_total,2);

$effect_date_dow=date('l',strtotime($effect_date));
$buof_comment=htmlspecialchars_decode($buof_comment);

//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

if($compliance == "y"){$t=" bgcolor='lightgreen'";} else {$t=" bgcolor='lightpink'";}


if(fmod($i,10)==0 and $i!=0)
	{
	 echo "<tr>"; 	   
	foreach($header_array as $index=>$fld)
		{
		echo "<th align='left'><font color=brown>$fld</font></th>";
		}   
	echo "</tr>";
	}
echo 

"<tr$t>";

       //echo "<td>$category</td>";
     //echo "<td>$f_year</td>";
     echo "<td>$park</td>		   
           <td>$effect_date<br />$effect_date_dow</td>		   
           <td>$beg_bal</td>		   
           <td>$deposit_amount</td>		   
           <td>$transaction_amount</td>	           		   
           <td>$end_bal</td>
		   <td>$days_elapsed2</td>"; 
		   //PASU Comments column
           echo "<td>";
		   
		   if($compliance=='n' and $pasu_comment=='')
		   {echo "<form action='compliance.php'><textarea rows='7' cols='20' name='pasu_comment' placeholder='Enter PASU Justification for non-compliance. Then click PASU_Update'>$pasu_comment</textarea><br /><input type='hidden' name='parkcode' value='$park'><input type='hidden' name='comment_id' value='$id'>";
		   if($pasu_role=='y')
		   {
		   echo "<input type=submit name=submit value=PASU_Update></form>";
		   }
		   }
		   
		    if($compliance=='n' and $pasu_comment!='')
		   {echo "$pasu_comment_date($pasu_player2)";echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$pasu_comment";}
		   	
            if($compliance=='y' and $pasu_comment!='')
		   {echo "$pasu_comment_date($pasu_player2)";echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$pasu_comment";}


			
		   echo "</td>"; 
		   
		   //DISU Comments column
		   echo "<td>";
		   
		   if($compliance=='n' and $disu_comment=='')
		   {echo "<form action='compliance.php'><textarea rows='7' cols='20' name='disu_comment' placeholder='Enter DISU Comment. Then click DISU_Update'>$disu_comment</textarea><br /><input type='hidden' name='parkcode' value='$park'><input type='hidden' name='comment_id' value='$id'>";
		   
		   if($disu_role=='y' and $pasu_comment != '')
		   {
		   echo "<input type=submit name=submit value=DISU_Update></form>";
		   }
		   }
		   
		    if($compliance=='n' and $disu_comment!='')
		   {echo "$disu_comment_date($disu_player2)";echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$disu_comment";}
		   
		    if($compliance=='y' and $disu_comment!='')
		   {echo "$disu_comment_date($disu_player2)";echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$disu_comment";}
		   
		   
		   
		   		   
		   echo "</td>"; 
		   
		    echo "<td>";
		   
		   IF ($compliance == 'n' AND $buof_comment == '')
		   {
		   		echo "<form action='compliance.php'>
		   				<textarea rows='7' cols='20' name='buof_comment' placeholder='Enter BUOF Comment. Then click BUOF_Update'>$buof_comment
		   				</textarea>
		   				<br />
		   				<input type='hidden' name='parkcode' value='$park'>
		   				<input type='hidden' name='comment_id' value='$id'> 
		   				<input type='hidden' name='fyear_edit' value='$fyear'>
		   			";
			   //2022-07-13: ccooper - giving Heide R access to exceptions
			   //20220929: jgcarter - giving Angela Boggus access to exceptions
		   	// 2022-09-29: ccooper - give Williams 65032827 and Gooding 60032997 access to exceptions
			   IF ($level == '5'
			   		OR $beacnum == '60036015'
			   		OR $beacnum == '60033242'
			   		OR $beacnum == '65032827'
			   		OR $beacnum == '60032997'
			   		)
			   {
				   echo "Remove Exception:<input type='checkbox' name='compliance' value='y'>";
				   echo "<br />";
				   echo "<input type=submit name=submit value=BUOF_Update></form>";
			   }
			   
		   }
		   
		    if($compliance=='n' and $buof_comment!='')
		   {echo "$buof_comment_date($buof_player2)";echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br /><br />$buof_comment";}
		   
		    if($compliance=='y' and $buof_comment!='')
		   {echo "$buof_comment_date($buof_player2)";echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img><br />$buof_comment";}
		   
		   
		   
		   		   
		   echo "</td>";    
		   
		   
		   
		   /*
		   echo "<td>";
		   
		   if($compliance=='n' and $disu_compliance_comment=='')
		   {echo "<form action='compliance.php'><textarea rows='7' cols='20' name='disu_compliance_comment' placeholder='Enter DISU Comments for non-compliance. Then click DISU_Update'>$disu_compliance_comment</textarea><br /><input type='hidden' name='parkcode' value='$park'><input type='hidden' name='comment_id' value='$id'>";
		   if($disu_role=='y')
		   {
		   echo "<input type=submit name=disu_submit value=DISU_Update></form>";
		   }
		   }
		   
		    if($compliance=='n' and $disu_compliance_comment!='')
		   {echo "$disu_compliance_comment";echo "<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";}
		   		   
		   echo "</td>"; 	   
		   */
		   
           echo "<td>$id</td>";   
              
           	   
             
         // echo "<td><a href='park_posted_deposits_drilldown1.php?f_year=$f_year&park=$park&center=$center' target='_blank'>more</a></td>";
                    
      
           
              
           
echo "</tr>";

$i++;


}
//if($level>1)
//{


while ($row6=mysqli_fetch_array($result6)){





extract($row6);

$total=number_format($total,2);
//$amount_2751T=number_format($amount_2751T,2);
//$amount_1000T=number_format($amount_1000T,2);
//$grand_total=number_format($grand_total,2);

if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo 



"<tr$t> 

               

           	

           <td></td> 	
           <td></td> 	
           <td></td> 	
           <td></td> 	
           <td>Total</td> 	

           <td>$total</td> 
           
         
           
           

           		  

</tr>";



}

//}

 echo "</table>";
 // echo "<h3><A href='webpage_add.php?&add_your_own=y&project_category=$project_category'>ADD</A></h3>";
 
 echo "</body></html>";


 



//echo "<H1 ALIGN=left><font color=brown><i>$myusername-Articles</i></font></H1>";

//echo "<br />";


?>
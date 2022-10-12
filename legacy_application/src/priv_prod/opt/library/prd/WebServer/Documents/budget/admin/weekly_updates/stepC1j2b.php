<?php


//echo "<br />stepC1j2b.php<br />";
//exit;

$query5="update budget.bd725_dpr_temp_pre3
set bc=trim(bc),
fund=trim(fund),
fund_descript=trim(fund_descript),
account=trim(account),
account_descript=trim(account_descript),
total_budget=trim(total_budget),
unallotted=trim(unallotted),
total_allotments=trim(total_allotments),
current=trim(current),
ytd=trim(ytd),
ptd=trim(ptd),
allotment_balance=trim(allotment_balance),
dpr=trim(dpr) ";
			 
mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5");

$query5a="truncate table bd725_dpr_temp_pre4; ";
			 
mysqli_query($connection, $query5a) or die ("Couldn't execute query 5a.  $query5a");

$query5b="insert into bd725_dpr_temp_pre4(bc,fund,fund_descript,account,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance,dpr)
select bc,fund,fund_descript,account,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance,dpr
from bd725_dpr_temp_pre3
where 1 ";
			 
mysqli_query($connection, $query5b) or die ("Couldn't execute query 5b.  $query5b");




$query6="select min(id) as 'start_id' from bd725_dpr_temp_pre4 where 1; ";
			 
$result6=mysqli_query($connection, $query6) or die ("Couldn't execute query 6.  $query6");

$row6=mysqli_fetch_array($result6);

extract($row6); //brings back id value for first record in table=exp_rev_down_temp2

$query7="select max(id) as 'end_id' from bd725_dpr_temp_pre4 where 1; ";
			 
$result7=mysqli_query($connection, $query7) or die ("Couldn't execute query 7.  $query7");

$row7=mysqli_fetch_array($result7);

extract($row7); //brings back id value for first record in table=exp_rev_down_temp2

//echo "<br />";
//echo "start_id=$start_id";echo "<br />"; echo "end_id=$end_id";//exit;
$record2=$start_id+1;
//echo "<br />";
//echo "record2=$record2"; exit;

$query8="select * from bd725_dpr_temp_pre4 where 1 and id >= '$record2' order by id asc ";
$result8=mysqli_query($connection, $query8) or die ("Couldn't execute query 8.  $query8");

while ($row8=mysqli_fetch_array($result8))
{

extract($row8);

$previous_record=$id-1;


$query9="update bd725_dpr_temp_pre4,bd725_dpr_temp_pre3
         set bd725_dpr_temp_pre4.fund=bd725_dpr_temp_pre3.fund,bd725_dpr_temp_pre4.fund_descript=bd725_dpr_temp_pre3.fund_descript,bd725_dpr_temp_pre4.bc=bd725_dpr_temp_pre3.bc
		 where bd725_dpr_temp_pre4.id='$id' and bd725_dpr_temp_pre3.id='$previous_record'
		 and bd725_dpr_temp_pre4.fund='' ";
		 
$result9=mysqli_query($connection, $query9) or die ("Couldn't execute query 9.  $query9");	

$query10="update bd725_dpr_temp_pre3,bd725_dpr_temp_pre4
         set bd725_dpr_temp_pre3.fund=bd725_dpr_temp_pre4.fund,bd725_dpr_temp_pre3.fund_descript=bd725_dpr_temp_pre4.fund_descript,bd725_dpr_temp_pre3.bc=bd725_dpr_temp_pre4.bc
		 where bd725_dpr_temp_pre3.id='$id' and bd725_dpr_temp_pre4.id='$id'
		 and bd725_dpr_temp_pre3.fund='' ";
		 
$result10=mysqli_query($connection, $query10) or die ("Couldn't execute query 10.  $query10");


}

$query6a="select min(id) as 'start_id' from bd725_dpr_temp_pre4 where 1; ";
			 
$result6a=mysqli_query($connection, $query6a) or die ("Couldn't execute query 6a.  $query6a");

$row6a=mysqli_fetch_array($result6a);

extract($row6a); //brings back id value for first record in table=exp_rev_down_temp2

$query7a="select max(id) as 'end_id' from bd725_dpr_temp_pre4 where 1; ";
			 
$result7a=mysqli_query($connection, $query7a) or die ("Couldn't execute query 7a.  $query7a");

$row7a=mysqli_fetch_array($result7a);

extract($row7a); //brings back id value for first record in table=exp_rev_down_temp2

//echo "<br />";
//echo "start_id=$start_id";echo "<br />"; echo "end_id=$end_id";//exit;
$record2=$start_id+1;
//echo "<br />Line 103: Update Successful<br />";
$query8a="select * from bd725_dpr_temp_pre4 where 1 and id >= '$record2' order by id asc ";
$result8a=mysqli_query($connection, $query8a) or die ("Couldn't execute query 8a.  $query8a");

while ($row8a=mysqli_fetch_array($result8a))
{

extract($row8a);

$previous_record=$id-1;


$query9a="update bd725_dpr_temp_pre4,bd725_dpr_temp_pre3
         set bd725_dpr_temp_pre4.bc=bd725_dpr_temp_pre3.bc
		 where bd725_dpr_temp_pre4.id='$id' and bd725_dpr_temp_pre3.id='$previous_record'
		 and bd725_dpr_temp_pre4.bc='' ";
		 
$result9a=mysqli_query($connection, $query9a) or die ("Couldn't execute query 9a.  $query9a");	

$query10a="update bd725_dpr_temp_pre3,bd725_dpr_temp_pre4
         set bd725_dpr_temp_pre3.bc=bd725_dpr_temp_pre4.bc
		 where bd725_dpr_temp_pre3.id='$id' and bd725_dpr_temp_pre4.id='$id'
		 and bd725_dpr_temp_pre3.bc='' ";
		 
$result10a=mysqli_query($connection, $query10a) or die ("Couldn't execute query 10a.  $query10a");


}

/*
$query="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
$result=mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");	
*/




 ?>
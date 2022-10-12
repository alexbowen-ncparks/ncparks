<?php

//echo "<br />stepC1j2c.php<br />";
//exit;


$query="truncate table bd725_dpr_temp";
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");		  
		  

$query="insert into bd725_dpr_temp(bc,fund,fund_descript,account,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance,dpr)
        select bc,fund,fund_descript,account,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance,dpr
		from bd725_dpr_temp_pre4
		where 1 and account != ''
        order by id	";
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");			  
		  
/*
$query="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	
*/




//{header("location: step_group.php?project_category=$project_category&project_name=$project_name&step_group=$step_group&fiscal_year=$fiscal_year&start_date=$start_date&end_date=$end_date&report_type=form");}




 
 ?>
<?php

//echo "<br />stepC1j2a.php<br />";
//exit;


////


$query2i="update bd725_dpr_temp_pre 
          set account=trim(account),account_descript=trim(account_descript),total_budget=trim(total_budget),unallotted=trim(unallotted),total_allotments=trim(total_allotments),current=trim(current),ytd=trim(ytd),ptd=trim(ptd),allotment_balance=trim(allotment_balance)
		  where 1 ";
		  
		  
mysqli_query($connection, $query2i) or die ("Couldn't execute query 2i.  $query2i");


$query2ia="update bd725_dpr_temp_pre set total_budget=replace(total_budget,',',''),unallotted=replace(unallotted,',',''),total_allotments=replace(total_allotments,',',''),current=replace(current,',',''),ytd=replace(ytd,',',''),ptd=replace(ptd,',',''),allotment_balance=replace(allotment_balance,',','')
           where 1 ";
		  
		  
mysqli_query($connection, $query2ia) or die ("Couldn't execute query 2ia.  $query2ia");




$query2e="update bd725_dpr_temp_pre set account=REPLACE(account, '=', '') ";
		  
		  
mysqli_query($connection, $query2e) or die ("Couldn't execute query 2e.  $query2e");


$query2f="update bd725_dpr_temp_pre set account=REPLACE(account, '\"', '') ";
		  
		  
mysqli_query($connection, $query2f) or die ("Couldn't execute query 2f.  $query2f");


$query2g="update bd725_dpr_temp_pre set account_descript=REPLACE(account_descript, '=', '') ";
		  
		  
mysqli_query($connection, $query2g) or die ("Couldn't execute query 2g.  $query2g");


$query2h="update bd725_dpr_temp_pre set account_descript=REPLACE(account_descript, '\"', '') ";
		  
		  
mysqli_query($connection, $query2h) or die ("Couldn't execute query 2h.  $query2h");


///
$query2j="update bd725_dpr_temp_pre set amount1_neg='yes' where right(total_budget,1)='-' and right(total_budget,2) != '--' ";

		  
mysqli_query($connection, $query2j) or die ("Couldn't execute query 2j.  $query2j ");


$query3j="update bd725_dpr_temp_pre set amount1_neg='no' where amount1_neg != 'yes' ";

		  
mysqli_query($connection, $query3j) or die ("Couldn't execute query 3j.  $query3j ");


$query4j="update bd725_dpr_temp_pre set amount1_correct=concat('-',(LEFT(total_budget,LENGTH(total_budget)-1))) where amount1_neg='yes' ";
		  
		  
mysqli_query($connection, $query4j) or die ("Couldn't execute query 4j.  $query4j");


$query5j="update bd725_dpr_temp_pre set total_budget=amount1_correct where amount1_neg='yes' ";
		  
		  
mysqli_query($connection, $query5j) or die ("Couldn't execute query 5j.  $query5j");








$query2k="update bd725_dpr_temp_pre set amount2_neg='yes' where right(unallotted,1)='-' and right(unallotted,2) != '--' ";

		  
mysqli_query($connection, $query2k) or die ("Couldn't execute query 2k.  $query2k ");


$query3k="update bd725_dpr_temp_pre set amount2_neg='no' where amount2_neg != 'yes' ";

		  
mysqli_query($connection, $query3k) or die ("Couldn't execute query 3k.  $query3k ");

$query4k="update bd725_dpr_temp_pre set amount2_correct=concat('-',(LEFT(unallotted,LENGTH(unallotted)-1))) where amount2_neg='yes' ";
		  
		  
mysqli_query($connection, $query4k) or die ("Couldn't execute query 4k.  $query4k");

$query5k="update bd725_dpr_temp_pre set unallotted=amount2_correct where amount2_neg='yes' ";
		  
		  
mysqli_query($connection, $query5k) or die ("Couldn't execute query 5k.  $query5k");






$query2L="update bd725_dpr_temp_pre set amount3_neg='yes' where right(total_allotments,1)='-' and right(total_allotments,2) != '--' ";

		  
mysqli_query($connection, $query2L) or die ("Couldn't execute query 2L.  $query2L ");


$query3L=" update bd725_dpr_temp_pre set amount3_neg='no' where amount3_neg != 'yes'";

		  
mysqli_query($connection, $query3L) or die ("Couldn't execute query 3L.  $query3L ");

$query4L="update bd725_dpr_temp_pre set amount3_correct=concat('-',(LEFT(total_allotments,LENGTH(total_allotments)-1))) where amount3_neg='yes' ";
		  
		  
mysqli_query($connection, $query4L) or die ("Couldn't execute query 4L.  $query4L");


$query5L="update bd725_dpr_temp_pre set total_allotments=amount3_correct where amount3_neg='yes' ";
		  
		  
mysqli_query($connection, $query5L) or die ("Couldn't execute query 5L.  $query5L");





$query2m="update bd725_dpr_temp_pre set amount4_neg='yes' where right(current,1)='-' and right(current,2) != '--' ";

		  
mysqli_query($connection, $query2m) or die ("Couldn't execute query 2m.  $query2m ");


$query3m=" update bd725_dpr_temp_pre set amount4_neg='no' where amount4_neg != 'yes'";

		  
mysqli_query($connection, $query3m) or die ("Couldn't execute query 3m.  $query3m ");


$query4m="update bd725_dpr_temp_pre set amount4_correct=concat('-',(LEFT(current,LENGTH(current)-1))) where amount4_neg='yes' ";
		  
		  
mysqli_query($connection, $query4m) or die ("Couldn't execute query 4m.  $query4m");


$query5m="update bd725_dpr_temp_pre set current=amount4_correct where amount4_neg='yes' ";
		  
		  
mysqli_query($connection, $query5m) or die ("Couldn't execute query 5m.  $query5m");







$query2n="update bd725_dpr_temp_pre set amount5_neg='yes' where right(ytd,1)='-' and right(ytd,2) != '--' ";

		  
mysqli_query($connection, $query2n) or die ("Couldn't execute query 2n.  $query2n ");


$query3n=" update bd725_dpr_temp_pre set amount5_neg='no' where amount5_neg != 'yes'";

		  
mysqli_query($connection, $query3n) or die ("Couldn't execute query 3n.  $query3n ");


$query4n="update bd725_dpr_temp_pre set amount5_correct=concat('-',(LEFT(ytd,LENGTH(ytd)-1))) where amount5_neg='yes' ";
		  
		  
mysqli_query($connection, $query4n) or die ("Couldn't execute query 4n.  $query4n");


$query5n="update bd725_dpr_temp_pre set ytd=amount5_correct where amount5_neg='yes' ";
		  
		  
mysqli_query($connection, $query5n) or die ("Couldn't execute query 5n.  $query5n");





$query2p="update bd725_dpr_temp_pre set amount6_neg='yes' where right(ptd,1)='-' and right(ptd,2) != '--' ";

		  
mysqli_query($connection, $query2p) or die ("Couldn't execute query 2p.  $query2p ");


$query3p=" update bd725_dpr_temp_pre set amount6_neg='no' where amount6_neg != 'yes'";

		  
mysqli_query($connection, $query3p) or die ("Couldn't execute query 3p.  $query3p ");


$query4p="update bd725_dpr_temp_pre set amount6_correct=concat('-',(LEFT(ptd,LENGTH(ptd)-1))) where amount6_neg='yes' ";
		  
		  
mysqli_query($connection, $query4p) or die ("Couldn't execute query 4p.  $query4p");


$query5p="update bd725_dpr_temp_pre set ptd=amount6_correct where amount6_neg='yes' ";
		  
		  
mysqli_query($connection, $query5p) or die ("Couldn't execute query 5p.  $query5p");





$query2r="update bd725_dpr_temp_pre set amount7_neg='yes' where right(allotment_balance,1)='-' and right(allotment_balance,2) != '--' and allotment_balance != '-' ";

		  
mysqli_query($connection, $query2r) or die ("Couldn't execute query 2r.  $query2r ");


$query3r=" update bd725_dpr_temp_pre set amount7_neg='no' where amount7_neg != 'yes'";

		  
mysqli_query($connection, $query3r) or die ("Couldn't execute query 3r.  $query3r ");


$query4r="update bd725_dpr_temp_pre set amount7_correct=concat('-',(LEFT(allotment_balance,LENGTH(allotment_balance)-1))) where amount7_neg='yes' ";
		  
		  
mysqli_query($connection, $query4r) or die ("Couldn't execute query 4r.  $query4r");


$query5r="update bd725_dpr_temp_pre set allotment_balance=amount7_correct where amount7_neg='yes' ";
		  
		  
mysqli_query($connection, $query5r) or die ("Couldn't execute query 5r.  $query5r");



///


$query="truncate table bd725_dpr_temp_pre2";
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");		  
		  



$query="insert into bd725_dpr_temp_pre2(bc_fu_fud_acc,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance)
        select account,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance
		from bd725_dpr_temp_pre
		where 1 ";
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");			  
		  


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=trim(bc_fu_fud_acc)
		where 1 ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	




$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='rmdsid46' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='----------' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='460   DEPT' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='461   DEPT' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	



$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='ACCOUNT' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='BD725-01' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='BD725-02' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='BUDGET COD' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='EXCESS' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='EXCESS OF' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	



$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='EXPENDITUR' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	



$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='FRU TOTALS' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc=''
		where bc_fu_fud_acc='REVENUES -' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set account=bc_fu_fud_acc
		where mid(bc_fu_fud_acc,1,2)='43' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	

$query="update bd725_dpr_temp_pre2
        set account=bc_fu_fud_acc
		where mid(bc_fu_fud_acc,1,2)='53' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	



$query="update bd725_dpr_temp_pre2
        set account_len=char_length(account)
		where account != '' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set account_valid='y'
		where (account_len='6' or account_len='9') ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc2=mid(bc_fu_fud_acc,1,5)
        where account_valid!='y'		";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc2=trim(bc_fu_fud_acc2)
        where 1		";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc_fu_fud_acc2_len=char_length(bc_fu_fud_acc2)
		where 1 ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="delete from bd725_dpr_temp_pre2
        where bc_fu_fud_acc2_len='0'
		and account_valid != 'y' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc=bc_fu_fud_acc2
		where bc_fu_fud_acc2_len='5' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	



$query="update bd725_dpr_temp_pre2
        set fund=bc_fu_fud_acc2
		where bc_fu_fud_acc2_len='4' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	



$query="update bd725_dpr_temp_pre2
        set fund_descript_pre=SUBSTR(bc_fu_fud_acc,5) 
        WHERE 1  
        AND fund !=  '' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set fund_descript=concat(fund_descript_pre,account_descript)
        WHERE 1  
        AND fund !=  '' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	



$query="update bd725_dpr_temp_pre2
        set bc=mid(bc_fu_fud_acc,1,5)
		where 1 ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set fund=mid(bc_fu_fud_acc,1,4)
		where 1 ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set fund_descript=bc_fu_fud_acc
		where 1 ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set bc=''
		where bc_fu_fud_acc2_len != '5' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set fund=''
		where bc_fu_fud_acc2_len != '4' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	


$query="update bd725_dpr_temp_pre2
        set fund_descript=concat(fund_descript_pre,account_descript)
		where fund != '' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");



$query="update bd725_dpr_temp_pre2
        set fund_descript=trim(fund_descript)
		where fund != '' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");


$query="update bd725_dpr_temp_pre2
        set fund_descript=''
		where fund = '' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");




$query="truncate table bd725_dpr_temp_pre3";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");


$query="insert into bd725_dpr_temp_pre3(bc,fund,fund_descript,account,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance,dpr)
select bc,fund,fund_descript,account,account_descript,total_budget,unallotted,total_allotments,current,ytd,ptd,allotment_balance,dpr 
from bd725_dpr_temp_pre2 ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");




/*
$query="update budget.project_steps_detail set status='complete' 
          where project_category='$project_category' and project_name='$project_name'
		  and step_group='$step_group' and step_num='$step_num' ";
		  
		  
$result = mysqli_query($connection,$query) or die ("Couldn't execute query.  $query");	

*/
 
 ?>
<?php
echo "Welcome to Step6";
$deposit_dates='06060606';
$deposit_id='9000';
/*
$query1="truncate table crs_tdrr_cc_adj;";
 echo "<br />Query1=$query1";		
 $result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1 ");
 */
 $query2="insert into crs_tdrr_cc_adj
           (center,ncas_account,amount)
		   select center,'000211940',sum(oob)
		   from crs_taxes2
		   where 1 group by center ; 
		   "; 
		   
	echo "<br />Query2=$query2";			   
			
 $result2 = mysqli_query($connection, $query2) or die ("Couldn't execute query 2.  $query2 ");
 
 $query3="insert into crs_tdrr_cc_adj
           (center,ncas_account,amount)
		   select center,'434410003',-sum(oob)
		   from crs_taxes2
		   where 1 group by center ; 
		   "; 
		   
	echo "<br />Query3=$query3";			   
			
 $result3 = mysqli_query($connection, $query3) or die ("Couldn't execute query 3.  $query3 ");
 
 
 
 
 $query4="update crs_tdrr_cc_adj
           set depositid_cc='$deposit_dates',
           deposit_id='$deposit_id' where 1; ";
		   
echo "<br />Query4=$query4";		   
			
 $result4 = mysqli_query($connection, $query4) or die ("Couldn't execute query 4.  $query4 "); 
 
 
 $query5="update crs_tdrr_cc_adj,center_taxes
            set crs_tdrr_cc_adj.parkcode=center_taxes.parkcode
            where crs_tdrr_cc_adj.center=center_taxes.center; ";
		   
echo "<br />Query5=$query5";		   
			
 $result5 = mysqli_query($connection, $query5) or die ("Couldn't execute query 5.  $query5 ");  
?>
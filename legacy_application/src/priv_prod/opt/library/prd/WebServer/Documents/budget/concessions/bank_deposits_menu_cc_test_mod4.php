<?php

 $query15="insert into crs_tdrr_cc_adj
           (center,ncas_account,amount)
		   select center,'000300000',-sum(amount)
		   from crs_tdrr_cc
		   where ncas_account='000300000'
		   group by center,ncas_account;";
//echo "<br />Query15=$query15";			   
			
 $result15 = mysqli_query($connection, $query15) or die ("Couldn't execute query 15.  $query15 ");
 
 $query16="insert into crs_tdrr_cc_adj
           (center,ncas_account,amount)
		   select center,'434410003',sum(amount)
		   from crs_tdrr_cc
		   where ncas_account='000300000'
		   group by center,ncas_account;";
		   
//echo "<br />Query16=$query16";			   
			
 $result16 = mysqli_query($connection, $query16) or die ("Couldn't execute query 16.  $query16 ");
 
// query 16a added on 10/23/17  to fix FOFI adjustment (FOFI does not have camping)
 
 $query16a="update crs_tdrr_cc_adj
           set ncas_account='435700006'
		   where parkcode='fofi' and ncas_account='434410003' ;";
		   
//echo "<br />Query16a=$query16a";			   
			
 $result16a = mysqli_query($connection, $query16a) or die ("Couldn't execute query 16a.  $query16a ");
 
 
 
 
 
 
 
 $query17="update crs_tdrr_cc_adj
           set depositid_cc='$deposit_dates'
		   where 1; ";
		   
//echo "<br />Query17=$query17";		   
			
 $result17 = mysqli_query($connection, $query17) or die ("Couldn't execute query 17.  $query17 "); 
 
 
 $query17a="update crs_tdrr_cc_adj,center_taxes
            set crs_tdrr_cc_adj.parkcode=center_taxes.parkcode
            where crs_tdrr_cc_adj.center=center_taxes.center; ";
		   
//echo "<br />Query17a=$query17a";		   
			
 $result17a = mysqli_query($connection, $query17a) or die ("Couldn't execute query 17a.  $query17a ");  
 
 
 $query18="update crs_tdrr_cc
           set depositid_cc='$deposit_dates'
           where 1; ";
		   
//echo "<br />Query18=$query18";		   
			
 $result18 = mysqli_query($connection, $query18) or die ("Couldn't execute query 18.  $query18 "); 
  
 //echo "ok"; 
 
 {include ("bank_deposits_menu_cc_test_mod5.php");} 

?>
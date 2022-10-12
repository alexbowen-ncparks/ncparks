<?php

$deposit_dates='06060606';
$deposit_id='9000';

$query25="truncate table crs_taxes1; ";
echo "<br />Query25=$query25";		   
			
 $result25 = mysqli_query($connection, $query25) or die ("Couldn't execute query 25.  $query25 ");

  
 $query25a="insert into crs_taxes1(center,taxbal)
		    select revenue_location_id,sum(amount)
		    from crs_tdrr_cc_import
		    where (revenue_code='434410004' or revenue_code='000434420' or revenue_code='434150004'
		           or revenue_code='434140003') and product_name != 'fuel-gasoline'
		    group by revenue_location_id;		 
		    ";
		   
echo "<br />Query25a=$query25a";		   
			
 $result25a = mysqli_query($connection, $query25a) or die ("Couldn't execute query 25a.  $query25a ");
 
 
 $query26="insert into crs_taxes1(center,taxes_import)
           select center,sum(amount)
		   from crs_tdrr_cc_all 
		   where ncas_account='000211940' 
		   and depositid_cc='$deposit_dates'
		   group by center; ";
		   
echo "<br />Query26=$query26";		   
			
 $result26 = mysqli_query($connection, $query26) or die ("Couldn't execute query 26.  $query26 "); 
 
 
 $query27="truncate table crs_taxes2; ";
 
 echo "<br />Query27=$query27";		   
			
 $result27 = mysqli_query($connection, $query27) or die ("Couldn't execute query 27.  $query27 "); 
 
 
 $query27a="insert into crs_taxes2(center,taxbal,taxes_import)
		   select center,sum(taxbal),sum(taxes_import)
		   from crs_taxes1
		   where 1
		   group by center; ";
		   
		   
echo "<br />Query27a=$query27a";		   
			
 $result27a = mysqli_query($connection, $query27a) or die ("Couldn't execute query 27a.  $query27a "); 

 $query28="update crs_taxes2,center_taxes
           set crs_taxes2.parkcode=center_taxes.parkcode
		   where crs_taxes2.center=center_taxes.center; ";
		   
		   
echo "<br />Query28=$query28";		   
			
 $result28 = mysqli_query($connection, $query28) or die ("Couldn't execute query 28.  $query28 "); 
 
 
 
 $query29="update crs_taxes2,center_taxes
           set crs_taxes2.taxrate=center_taxes.tax_rate_total
		   where crs_taxes2.center=center_taxes.center; ";
		   
		   
echo "<br />Query29=$query29";		   
			
 $result29 = mysqli_query($connection, $query29) or die ("Couldn't execute query 29.  $query29 "); 
 
 
 
 
 $query30="update crs_taxes2
           set taxes_calc=taxbal*taxrate/100
		   where 1; ";
		   
		   
echo "<br />Query30=$query30";		   
			
 $result30 = mysqli_query($connection, $query30) or die ("Couldn't execute query 30.  $query30 "); 
 
 
 $query31="update crs_taxes2
           set oob=taxes_calc-taxes_import
		   where 1; ";
		   
		   
echo "<br />Query31=$query31";		   
			
 $result31 = mysqli_query($connection, $query31) or die ("Couldn't execute query 31.  $query31 "); 

 
 
 echo "hello world"; 
 
 
 $query31a="SELECT sum(taxbal) as 'taxbal_total' 
            from crs_taxes2
			WHERE 1 ";
			
			
echo "<br />Query31a=$query31a";			

$result31a = mysqli_query($connection, $query31a) or die ("Couldn't execute query 31a.  $query31a");

$row31a=mysqli_fetch_array($result31a);
extract($row31a);//brings back max (start_date) as $start_date
$taxbal_total=number_format($taxbal_total,2);


 $query32="SELECT sum(taxes_import) as 'taxes_import_total' 
            from crs_taxes2
			WHERE 1 ";
			
echo "<br />Query32=$query32";	
			
			

$result32 = mysqli_query($connection, $query32) or die ("Couldn't execute query 32.  $query32");

$row32=mysqli_fetch_array($result32);
extract($row32);//brings back max (start_date) as $start_date
$taxes_import_total=number_format($taxes_import_total,2);


$query32a="SELECT sum(taxes_calc) as 'taxes_calc_total' 
            from crs_taxes2
			WHERE 1 ";
			
echo "<br />Query32a=$query32a";	
			
			

$result32a = mysqli_query($connection, $query32a) or die ("Couldn't execute query 32a.  $query32a");

$row32a=mysqli_fetch_array($result32a);
extract($row32a);//brings back max (start_date) as $start_date
$taxes_calc_total=number_format($taxes_calc_total,2);



$query33="SELECT sum(oob) as 'oob_total' 
            from crs_taxes2
			WHERE 1 
			 ";
			 
echo "<br />Query33=$query33";				 
			 
			 
			
 $result33 = mysqli_query($connection, $query33) or die ("Couldn't execute query 33.  $query33 "); 
 $row33=mysqli_fetch_array($result33);
 $num33=mysqli_num_rows($result33);
extract($row33);
$oob_total=number_format($oob_total,2);


 {echo "<br />";  echo "<table border=1><tr><th>DepositID</th><th> $deposit_id</th></tr><tr><th> Total</th><th>$taxes_import_total</th></tr><tr><th>Adjustments</th><th>$oob_total</th></table>";}
 {echo "<form  method='post' autocomplete='off' action='bank_deposits_menu_cc_test.php'>";
  echo "<br />"; 
  echo "<table><tr><th>Step3: Pass Adjustments to 434410003-campsite rentals</th>
       <th><input type=submit name=pass_adjustments submit value=YES></th></table>";
  echo "<input type='hidden' name='menu_id' value='a'>";
  echo "<input type='hidden' name='menu_selected' value='y'>";
  echo "<input type='hidden' name='step' value='6'>";
  echo "<input type='hidden' name='deposit_id' value='$deposit_id'>";
  echo "<input type='hidden' name='deposit_dates' value='$deposit_dates'>";
  echo "</form>";}		   
  

 {$query34="SELECT center,parkcode,taxbal,taxes_import,taxrate,taxes_calc,oob 
            from crs_taxes2
			WHERE 1 order by parkcode";
			
echo "<br />Query34=$query34";			
			
 $result34 = mysqli_query($connection, $query34) or die ("Couldn't execute query 34.  $query34 ");
 $num34=mysqli_num_rows($result34);	
 
 

echo "<br />";
echo "<table border=1>";

echo 

"<tr> 
       <th align=left><font color=brown>Line#</font></th>
       <th align=left><font color=brown>Park</font></th>
       <th align=left><font color=brown>Center</font></th>       
       <th align=left><font color=brown>TaxBalances</font></th>
       <th align=left><font color=brown>TaxRate</font></th>
       <th align=left><font color=brown>TaxesCalc</font></th>
       <th align=left><font color=brown>TaxesImport</font></th>
       <th align=left><font color=brown>OOB</font></th>
       
       
      
              
       
              
</tr>";

//$row=mysqli_fetch_array($result);


// The while statement steps through the $result variable one row ($row, which is an array created by mysqli_fetch_array) at a time
//$c=1;
while ($row34=mysqli_fetch_array($result34)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row34);
$taxbal=number_format($taxbal,2);
$taxes_import=number_format($taxes_import,2);
$taxrate=number_format($taxrate,2);
$taxes_calc=number_format($taxes_calc,2);
//if($ncas_account=='000211940'){$center=$taxcenter;}
//if($ncas_account=='000211940'){$account_name=$tax_note;}
//if($amount < '0'){$sign="debit";} else {$sign="credit";}
//if($ncas_account=='000200000'){$ncas_account="";}
//if($ncas_account=='000300000'){$ncas_account="";}


//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($amount != '0.00')
{
@$rank=$rank+1;

echo 

"<tr$t> 
		    <td>$rank</td>
		    <td>$parkcode</td>			
		    <td>$center</td>
		    <td>$taxbal</td>
		    <td>$taxrate</td>
		    <td>$taxes_calc</td>
		    <td>$taxes_import</td>
		    <td>$oob</td>
		    
		    		    
		    
              
           
</tr>";
}
}


//$adjustment_total=number_format($adjustment_total,2);
//if($adjustment_total < '0'){$sign="debit";} else {$sign="credit";}
//if($amount < '0'){$sign="credit";} else {$sign="debit";}
//@$rank=$rank+1;
//if($c==''){$t=" bgcolor='#B4CDCD'";$c=1;}else{$t='';$c='';}
if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}

echo 

"<tr$t> 
		    
		    <td></td>
		    <td></td>
		    <td></td>
		    <td></td>
		    <td>Total</td>
		    <td>$taxes_calc_total</td>
		    <td>$taxes_import_total</td>
		    <td>$oob_total</td>
		    
		   
           
</tr>";

}


 echo "</table>";
 
//echo "Query12=$query12"; 
 
 //}
 
  
 
 
 

?>
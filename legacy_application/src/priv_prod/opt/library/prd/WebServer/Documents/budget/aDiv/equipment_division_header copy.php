<?php//$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/connectROOT.inc"); // connection parametersmysql_select_db($database, $connection); // database//include("../../../include/authBUDGET.inc");include("../~f_year.php");if($_REQUEST){extract($_REQUEST);if($change=="Change"){//print_r($_REQUEST);$totBudget=str_replace(",","",$budget);$sql="UPDATE equipment_request_3SET unit_cost='$totBudget' where equipment_description='BUDGET' and division_approved='y' and f_year='$f_year'";//ECHO "$sql";exit;$result = mysql_query($sql) or die ("Couldn't execute UPDATE query e_d_h_1. $sql");header("Location: /budget/aDiv/equipment_division.php");//exit;}}if($level>4){$sql="truncate table equipment_authorized;";$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");//echo "$sql<br><br>";$sql="insert into equipment_authorized(authorized,total_budget,f_year)select sum(authorized),'',f_yearfrom authorized_budgetwhere 1and f_year='$f_year'and account like '534%'group by f_year";$result = mysql_query($sql) or die ("Couldn't execute query 2. $sql");if($showSQL){echo "$sql<br><br>";}$sql="insert into equipment_authorized(authorized,total_budget,f_year)select '',sum(unit_quantity*unit_cost),f_yearfrom equipment_request_3where 1and f_year='$f_year'and division_approved='y'and equipment_description = 'budget'group by f_year";$result = mysql_query($sql) or die ("Couldn't execute query 2. $sql");if($showSQL){echo "$sql<br><br>";}$sql="select sum(authorized) as 'authorized',sum(total_budget) as 'total_budget',sum(authorized-total_budget) as 'division_reserve'from equipment_authorizedgroup by f_year;";$result = mysql_query($sql) or die ("Couldn't execute query 2. $sql");if($showSQL){echo "$sql<br><br>";}$row=mysql_fetch_array($result);extract($row);$division_reserve=$authorized-$total_budget;$total_budget=number_format($total_budget,2);$authorized=number_format($authorized,2);$division_reserve=number_format($division_reserve,2);echo "<table border='1'><tr><th>f_year</th><th>authorized</th><th>total_budget</th><th>division_reserve</th></tr>";echo "<tr><td align='center'>$f_year</td><td align='center'>$authorized</td><td align='center'>$total_budget</td><td align='center'>$division_reserve</td></tr></table>";}$sql="TRUNCATE  TABLE equipment_division_summary";$result = mysql_query($sql) or die ("Couldn't execute query 1. $sql");if($showSQL){echo "b1 $sql<br><br>";}$sql="INSERT  INTO equipment_division_summary( scope, funds_allocated, ordered_amount, unordered_amount, ordered_count, unordered_count, budget ) SELECT  'division', sum( unit_quantity*unit_cost ) ,  '',  '',  '',  '',  ''FROM equipment_request_3WHERE 1  AND f_year =  '$f_year' AND division_approved =  'y' AND equipment_description !=  'budget'GROUP  BY f_year";$result = mysql_query($sql) or die ("Couldn't execute query 2. $sql");if($showSQL){echo "b2 $sql<br><br>";}$sql="INSERT  INTO equipment_division_summary( scope, funds_allocated, ordered_amount, unordered_amount, ordered_count, unordered_count, budget ) SELECT  'division',  '', sum( ordered_amount ) ,  '',  '',  '',  ''FROM equipment_request_3WHERE 1  AND f_year =  '$f_year' AND division_approved =  'y' AND order_complete =  'y'GROUP  BY f_year";$result = mysql_query($sql) or die ("Couldn't execute query 3. $sql");if($showSQL){echo "b3 $sql<br><br>";}$sql="INSERT  INTO equipment_division_summary( scope, funds_allocated, ordered_amount, unordered_amount, ordered_count, unordered_count, budget ) SELECT  'division',  '',  '', sum( unit_quantity*unit_cost ) ,  '',  '',  ''FROM equipment_request_3WHERE 1  AND f_year =  '$f_year' AND division_approved =  'y' AND order_complete =  'n' AND equipment_description !=  'budget'GROUP  BY f_year";$result = mysql_query($sql) or die ("Couldn't execute query 4. $sql");if($showSQL){echo "b4 $sql<br><br>";}$sql="INSERT  INTO equipment_division_summary( scope, funds_allocated, ordered_amount, unordered_amount, ordered_count, unordered_count, budget ) SELECT  'division',  '',  '',  '', count( id ) ,  '',  ''FROM equipment_request_3WHERE 1  AND f_year =  '$f_year' AND division_approved =  'y' AND order_complete =  'y' AND equipment_description !=  'budget'GROUP  BY f_year";$result = mysql_query($sql) or die ("Couldn't execute query 5. $sql");if($showSQL){echo "b5 $sql<br><br>";}$sql="INSERT  INTO equipment_division_summary( scope, funds_allocated, ordered_amount, unordered_amount, ordered_count, unordered_count, budget ) SELECT  'division',  '',  '',  '',  '', count( id ) ,  ''FROM equipment_request_3WHERE 1  AND f_year =  '$f_year' AND division_approved =  'y' AND order_complete =  'n' AND equipment_description !=  'budget'GROUP  BY f_year";$result = mysql_query($sql) or die ("Couldn't execute query 6. $sql");if($showSQL){echo "b6 $sql<br><br>";}$sql="INSERT  INTO equipment_division_summary( scope, funds_allocated, ordered_amount, unordered_amount, ordered_count, unordered_count, budget ) SELECT  'division',  '',  '',  '',  '',  '', sum( unit_quantity*unit_cost ) FROM equipment_request_3WHERE 1  AND f_year =  '$f_year' AND division_approved =  'y' AND equipment_description =  'budget'GROUP  BY f_year";$result = mysql_query($sql) or die ("Couldn't execute query 7. $sql");if($showSQL){echo "b7 $sql<br><br>";}$sql="SELECT sum( budget )  AS  'total_budget', sum( budget-funds_allocated )  AS  'reserve', sum( funds_allocated )  AS  'funds_allocated', sum( ordered_amount )  AS  'ordered_amount', sum( unordered_amount )  AS  'unordered_amount' ,sum(funds_allocated-ordered_amount-unordered_amount) as 'surplus_deficit', sum(budget-funds_allocated+funds_allocated-ordered_amount-unordered_amount) as 'available_funds', sum( ordered_count )  AS  'ordered_count', sum( unordered_count )  AS  'unordered_count', sum( ordered_count + unordered_count )  AS  'total_count'FROM equipment_division_summaryWHERE 1 GROUP  BY scope";if($showSQL){echo "b8 $sql<br>";}$result = mysql_query($sql) or die ("Couldn't execute query 8. $sql");$row=mysql_fetch_array($result);extract($row);$total_budget=number_format($total_budget,2);$reserve=number_format($reserve,2);$funds_allocated=number_format($funds_allocated,2);$ordered_amount=number_format($ordered_amount,2);$unordered_amount=number_format($unordered_amount,2);$surplus_deficit=number_format($surplus_deficit,2);$available_funds=number_format($available_funds,2);echo "<table border='1'><tr><th>f_year</th><th>total_budget</th><th>reserve</th><th>funds_allocated</th><th>ordered_amount</th><th>unordered_amount</th><th>surplus_deficit</th><th>available_funds</th><th>ordered_count</th><th>unordered_count</th><th>total_count</th></tr>";echo "<form><tr><td align='center'><input type='text' name='f_year' value='$f_year' size='5'><td align='center'><input type='text' name='budget' value='$total_budget'></td><td align='center'>$reserve</td><td align='center'>$funds_allocated</td><td align='center'>$ordered_amount</td><td align='center'>$unordered_amount</td><td align='center'>$surplus_deficit</td><td align='center'>$available_funds</td><td align='center'>$ordered_count</td><td align='center'>$unordered_count</td><td align='center'>$total_count</td><td><input type='submit' name='change' value='Change'></td></tr></form></table>";?>
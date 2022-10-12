<?php
//session_start();
//echo "<br />park=$park<br />";
//echo "<br />level=$level<br />";

//echo "<br />tempid=$tempid<br />";
if($level < 3)
{
	//7/27/22-Start TB: Added "lead_superintendent" to query below.  If lead_superintendent Role=y, we will asign user to:  pasu_role=y.   This is necessary for District Superintendents which are not PASU's
$query1="select count(id) as 'manager_count',lead_superintendent from cash_handling_roles where tempid='$tempid' and park='$park' and role='manager' ";
//echo "<br />query1=$query1<br />";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");

$row1=mysqli_fetch_array($result1);
extract($row1);//brings back max (end_date) as $end_date

//echo "Line 17:  lead_superintendent=$lead_superintendent";

if($lead_superintendent=='y'){$pasu_role='y';}

//echo "Line 21:  pasu_role=$pasu_role";
}
//7/27/22-End TB

echo "<br />manager_count=$manager_count<br />";
if($manager_count > 0)
{
$manager_role='y';	
$manager_name=$tempid;
}
//echo "<br />manager_role=$manager_role<br />";
/*
$query = "select park,role,tempid,beacnum,first_name,last_name
           from cash_handling_roles
		   where role='cashier' and park='$park'
		   order by park,role,tempid asc";
$result = @mysqli_query($connection, $query,$connection);
$num=mysqli_num_rows($result);	
*/
// $num=mysql_found_rows();
//echo "<br><br />$query<br />";//exit;
/*
echo "<table align='center'>";
echo "<tr><th>Records: <font color='red'>$num</font></th></tr><tr><th>Last Update: <font color='red'>5/21/17</font></th></tr>";
echo "</table>";
*/
if($role_edit != 'y')
{
$query = "select park,role,tempid,beacnum,first_name,last_name
           from cash_handling_roles
		   where role='cashier' and park='$park' and player_view='n'
		   order by park,role,tempid asc";
		   
//echo "<br />cashiers query=$query<br />";		   
$result = @mysqli_query($connection, $query);
$num=mysqli_num_rows($result);	
	
echo "<table align='center' border='1'>";
//$header="<tr><th>first name</th><th>last name</th><th>Beacon<br />Posnum</th></tr>";
//echo "$header";

//$j=1;
//echo "<br />manager_role=$manager_role<br />";
echo "<tr><th colspan='5'>Cashiers";

// manager_role==y or heide rumble or becky owen or rachel gooding
/*
if($beacnum=='60036015' or $beacnum=='60033242' or $beacnum=='60032997')
{	
echo "<br /><a href='procedures_crj.php?park=$park&role_edit=y'>Edit</a>";
}
*/


//tammy dodd, tony bass
if($beacnum2=='60032781' or $beacnum2=='60032793')
{	
echo "<br /><a href='procedures_crj.php?park=$park&role_edit=y'>Edit</a>";
}

// park superintendents only
if($manager_role=='y' and $pasu_role=='y')
{	
echo "<br /><a href='procedures_crj.php?park=$park&role_edit=y'>Edit</a>";
}


echo "</th></tr>";
echo "<tr>";
echo "<th>First<br />Name</th>";
echo "<th>Last<br />Name</th>";
echo "<th>tempid</th>";
echo "<th>beacon<br />position#</th>";
echo "<th>role</th>";
echo "</tr>";

while($row = mysqli_fetch_array($result)){
extract($row);
//if(fmod($j,10)==0){echo "$header";}$j++;

//if($table_bg2==''){$table_bg2='cornsilk';}
//    if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}


echo "<tr>";

//$tempid=substr($tempid,0,-2);


echo
"<td align='center'>$first_name</td>";
echo "<td align='center'>$last_name</td>";
echo "<td align='center'>$tempid</td>";
echo "<td align='center'>$beacnum</td>";
echo "<td align='center'>$role</td>";

echo "</tr>";
	}// end while


echo "</table>";
}


if($role_edit == 'y')
{
	
$query = "select park,role,tempid,beacnum,first_name,last_name,id
           from cash_handling_roles
		   where role='cashier' and park='$park' and player_view='n'
		   order by park,role,tempid asc";
$result = @mysqli_query($connection, $query);
$num=mysqli_num_rows($result);		
	
echo "<table align='center' border='1'>";
//$header="<tr><th>first name</th><th>last name</th><th>Beacon<br />Posnum</th></tr>";
//echo "$header";

echo "<tr>";
echo "<th>First<br />Name</th>";
echo "<th>Last<br />Name</th>";
echo "<th>tempid</th>";
echo "<th>beacon<br />position#</th>";
echo "<th>Role</th>";


while($row = mysqli_fetch_array($result)){
extract($row);
//if(fmod($j,10)==0){echo "$header";}$j++;

//if($table_bg2==''){$table_bg2='cornsilk';}
//    if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}

echo "<form action='cashiers_update.php' autocomplete='off'>";
echo "<tr>";

//$tempid=substr($tempid,0,-2);


echo
"<td align='center'><input type='text' name='first_name' value='$first_name' size='10'></td>";
echo "<td align='center'><input type='text' name='last_name' value='$last_name' size='10'></td>";
echo "<td align='center'><input type='text' name='tempid' value='$tempid' size='10'></td>";
echo "<td align='center'><input type='text' name='beacnum' value='$beacnum' size='10'></td>";
//echo "<td align='center'><input type='text' name='role' value='$role' size='10'></td>";
echo "<td align='center'>";
echo "<select name='role'>";
if($role=='cashier'){echo "<option selected='cashier'>cashier</option>";} else {echo "<option value='cashier'>cashier</option>";}
if($role=='none'){echo "<option selected='none'>none</option>";} else {echo "<option value='none'>none</option>";}
echo "</select>";
echo "</td>";
echo "<td><input type='submit' name='submit' value='update'><input type='hidden' name='idS' value='$id'></td>";
echo "</tr>";
echo "<input type='hidden' name='manager_name' value='$manager_name'>";
echo "<input type='hidden' name='park' value='$park'>";
echo "</form>";

	}// end while
echo "<form action='cashiers_update.php' autocomplete='off'>";
echo "<tr>";
echo "<td><input type='text' name='first_name' size='10'></td>";
echo "<td><input type='text' name='last_name' size='10'></td>";
echo "<td><input type='text' name='tempid' size='10'></td>";
echo "<td><input type='text' name='beacnum' size='10'></td>";
echo "<td><input type='text' name='role' size='10' value='cashier' readonly='readonly'></td>";
echo "<td><input type='submit' name='submit' value='add'></td>";
echo "</table>";
echo "<input type='hidden' name='park' value='$park'>";
echo "<input type='hidden' name='manager_name' value='$manager_name'>";
echo "</form>";

}


















echo "</div></body></html>";

?>
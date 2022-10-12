<?php
//session_start();
//$manager=$tempID;
//echo "<br />manager=$manager<br />";

if($role_edit2 != 'y')
{

$query = "select park,role,tempid,beacnum,first_name,last_name,lead_superintendent
           from cash_handling_roles
		   where role='manager' and park='$park' and player_view='n' 
		   order by park,role,tempid asc";
$result = @mysqli_query($connection, $query);
$num=mysqli_num_rows($result);	
// $num=mysql_found_rows();
//echo "<br><br />$query<br />";//exit;
/*
echo "<table align='center'>";
echo "<tr><th>Records: <font color='red'>$num</font></th></tr><tr><th>Last Update: <font color='red'>5/21/17</font></th></tr>";
echo "</table>";
*/
//echo "<br />manager_count=$manager_count<br />";
//echo "<br />tempID=$tempID<br />";
//echo "<br />tempid=$tempid<br />";
echo "<table align='center' border='1' >";
//$header="<tr><th>first name</th><th>last name</th><th>Beacon<br />Posnum</th></tr>";
//echo "$header";

//$j=1;

echo "<tr><th colspan='5'>Managers";

//tammy dodd, tony bass
if($beacnum2=='60032781' or $beacnum2=='60032793')
{	
echo "<br /><a href='procedures_crj.php?park=$park&role_edit2=y'>Edit</a>";
}

// park superintendents only
//if($manager_role=='y' and $pasu_role=='y')
if($LS_role=='y')
{	
echo "<br /><a href='procedures_crj.php?park=$park&role_edit2=y'>Edit</a>";
}


echo "</th></tr>";
echo "<tr>";
echo "<th>First<br />Name</th>";
echo "<th>Last<br />Name</th>";
echo "<th>tempid</th>";
echo "<th>beacon<br />position#</th>";
echo "<th>role</th>";
echo "<th>LSuper</th>";
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
echo "<td align='center'>$lead_superintendent</td>";



echo "</tr>";
	}// end while


echo "</table>";
}


if($role_edit2 == 'y')
{

$query = "select park,role,tempid,beacnum,first_name,last_name,lead_superintendent,id
           from cash_handling_roles
		   where role='manager' and park='$park' and player_view='n' 
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
if($beacnum2=='60032781' or $beacnum2=='60032793')
{
echo "<th>LS Role</th>";
}


while($row = mysqli_fetch_array($result)){
extract($row);
//if(fmod($j,10)==0){echo "$header";}$j++;

//if($table_bg2==''){$table_bg2='cornsilk';}
//    if($c==''){$t=" bgcolor='$table_bg2' ";$c=1;}else{$t='';$c='';}

echo "<form action='managers_update.php' autocomplete='off'>";
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
if($role=='manager'){echo "<option selected='manager'>manager</option>";} else {echo "<option value='manager'>manager</option>";}
if($role=='none'){echo "<option selected='none'>none</option>";} else {echo "<option value='none'>none</option>";}
echo "</select>";
echo "</td>";
if($beacnum2=='60032781' or $beacnum2=='60032793')
{
echo "<td align='center'>";
echo "<select name='lead_superintendent'>";
if($lead_superintendent=='y'){echo "<option selected='y'>y</option>";} else {echo "<option value='y'>y</option>";}
if($lead_superintendent=='n'){echo "<option selected='n'>n</option>";} else {echo "<option value='n'>n</option>";}
echo "</select>";
echo "</td>";
}





echo "<td><input type='submit' name='submit' value='update'><input type='hidden' name='idS' value='$id'></td>";
echo "</tr>";
echo "<input type='hidden' name='park' value='$park'>";
echo "<input type='hidden' name='manager_name' value='$manager_name'>";
echo "</form>";

	}// end while
echo "<form action='managers_update.php' autocomplete='off'>";
echo "<tr>";
echo "<td><input type='text' name='first_name' size='10'></td>";
echo "<td><input type='text' name='last_name' size='10'></td>";
echo "<td><input type='text' name='tempid' size='10'></td>";
echo "<td><input type='text' name='beacnum' size='10'></td>";
echo "<td><input type='text' name='role' size='10' value='manager' readonly='readonly'></td>";
echo "<td><input type='submit' name='submit' value='add'></td>";
echo "</table>";
echo "<input type='hidden' name='park' value='$park'>";
echo "<input type='hidden' name='manager_name' value='$manager_name'>";
echo "</form>";

}













echo "</div></body></html>";

?>
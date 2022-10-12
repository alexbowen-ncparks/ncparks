<?php 
	
$database="divper";
include("../../../include/connectROOT.inc"); //echo "c=$connection";

extract($_REQUEST);
if($_POST['Lname']!=""){
		$sql="SELECT t1.Fname,t1.Lname, phone, work_cell, t2.tempID
		FROM divper.empinfo as t1
		LEFT JOIN divper.emplist as t2 on t2.tempID=t1.tempID
		where 1 and t1.Lname='$_POST[Lname]' and t2.currPark!='' and (t1.phone='' AND t1.work_cell='')"; //echo "$sql";
		 $result = MYSQL_QUERY($sql,$connection);
		while($row=mysql_fetch_assoc($result)){
			$names[]=$row;
		}
		$num=count($names);
		echo "<table align='center' cellpadding='7'>";
		
			if($num>0){
				foreach($names as $k=>$v){
					foreach($v as $fld=>$value){
						$person.=$fld."=".$value."&nbsp;&nbsp;&nbsp;&nbsp;";
						}
						
					echo "<form action='update_person.php' method='POST'><tr><td align='right'>$person</td>
					<td><==
					<input type='hidden' name='phone_type' value='$_POST[phone]'>
					<input type='hidden' name='phone_num' value='$pn'>
					<input type='hidden' name='tempID' value='$v[tempID]'>
					<input type='submit' name='submit' value='Update This Person'>
					</td>
					</tr></form>";$person="";
					}
					echo "</table><hr />";
			}
			ELSE
			{echo "<font color='red' size='+1'>No one was found using Last Name: $_POST[Lname]</font>";
			}
	}

echo "<table align='center' cellpadding='7'>
<tr><td>Associate the phone number <font color='green'>$pn</font> with either a person or a use:</td></tr>
<tr><td align='right'>This number is assigned to a person.</td></tr>
<tr><td></td><td><form method='POST'>Work Landline:<input type='radio' name='phone' value='land'> &nbsp;&nbsp;Work Cell:<input type='radio' name='phone' value='cell'></td></tr>
<tr><td></td><td>&nbsp;&nbsp;&nbsp;Last Name: <input type='text' name='Lname' value=''></td></tr>
<tr><td></td><td>
<input type='hidden' name='pn' value='$pn'>
<input type='submit' name='submit' value='Update'></form></td></tr>


<tr><td align='right'>This number is assigned to a use and/or location and NOT a person.</td></tr>

<tr><td></td><td><form action='update_use.php' method='POST'>Use and/or Location: <input type='text' name='location' value='' size='40'> </td></tr>
<tr><td></td><td>
<input type='hidden' name='pn' value='$pn'>
<input type='submit' name='submit' value='Update'></td></tr>
</table></form>";

?>
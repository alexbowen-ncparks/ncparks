<?php
session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
//header("location: /login_form.php?db=budget");
}

//echo "<br />beacnum2=$beacnum2<br />";

$query1="SELECT cy FROM `fiscal_year` WHERE `active_year` LIKE 'y'";

$result1=mysqli_query($connection, $query1) or die ("Couldn't execute query 1. $query1");

$row1=mysqli_fetch_array($result1);

extract($row1);

$query2="SELECT grand_total as 'imprest_cash'  FROM `cash_imprest_authorized_centers` WHERE `park`='$park' ";

$result2=mysqli_query($connection, $query2) or die ("Couldn't execute query 2. $query2");

$row2=mysqli_fetch_array($result2);

extract($row2);

if($imprestE!='y')
{
echo "<table>";
echo "<tr>";
echo "<td>";
echo "<font color='brown'>Authorized Imprest Cash (Fiscal Year $cy)</font>: <b>$imprest_cash</b> ";
echo "</td>";
// Budget Officer Dodd, Accounting Specialist Bass
if($beacnum2=='60032781' or $beacnum2=='60032793')
{
echo "<td>";
echo "<a href='procedures_crj.php?park=$park&imprestE=y'>Edit</a>";
echo "</td>";
}
echo "</tr>";
echo "</table>";
}


if($imprestE=='y')
{
echo "<table>";
echo "<tr>";
echo "<td>";
echo "<form action='imprest_cash_update.php' autocomplete='off' method='post'>";

echo "Authorized Imprest Cash (Fiscal Year $cy):<input type='text' name='imprest_cash' value='$imprest_cash' size='10'></td>";

echo "<td><input type='submit' name='submit' value='Update'></td>";

echo "<input type='hidden' name='park' value='$park'>";
echo "<input type='hidden' name='fiscal_year' value='$cy'>";

echo "</form>";
echo "</td>";
echo "</tr>";
echo "</table>";
}	


?>
<?php

//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;
session_start();
extract($_REQUEST);
//echo "<pre>";print_r($_REQUEST);echo "</pre>";//exit;

$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../../include/activity.php");// database connection parameters
echo "<html>";
echo "<head>
<style>
body { background-color: #FFF8DC; }
table { background-color: white; font-color: blue; font-size: 15;}
TH{font-family: Arial; font-size: 15pt;}
TD{font-family: Arial; font-size: 15pt;}
input{style=font-family: Arial; font-size:14.0pt}
</style>
</head>";

echo "<H1 ALIGN=LEFT > <font color=brown><i>$project_name-$step</font></i></H1>";

echo "<H2 ALIGN=center><font size=4><b><A href=/budget/admin/templates/main.php?project_category=$project_category&project_name=$project_name> Templates-HOME </A></font></H2>";

echo "<br />";
echo "<H3 ALIGN=LEFT > <font color=blue>$step_name</font></H1>";

$query1="select * from contacts where 1 limit 10";
$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");
while($row=mysqli_fetch_assoc($result1)){$ARRAY[]=$row;
}
echo "<pre>";print_r($ARRAY);echo "</pre>";//exit;
//Produces Header Row with field names-START
$skip=array("phone");
echo "<table border=1><tr>";
foreach($ARRAY[0] as $field=>$value){
if(in_array($field,$skip)){continue;}
echo "<th>$field </th>";
}
echo "</tr>";
//Produces Header Row with field names-END


//Produces Body Rows associated with Header-START
foreach($ARRAY as $index=>$row){echo "<tr>";
foreach($row as $field=>$value){
if(in_array($field,$skip)){continue;}
echo "<td>$value</td>";

}

echo "</tr>";
}
//Produces Body Rows associated with Header-END

echo "</table>";
echo "</html>";


?>


























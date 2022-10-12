<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>autocomplete demo</title>
    
</head>
<body>
 
<?php
extract($_REQUEST);

 $birthDate = "02/11/1954";
 $birthDate = "1954-02-11";
         //explode the date to get month, day and year
         $birthDate = explode("-", $birthDate);
         //get age from date or birthdate
         $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[1], $birthDate[2], $birthDate[0]))) > date("md") ? ((date("Y")-$birthDate[0])-1):(date("Y")-$birthDate[0]));
         echo "Age is:".$age;
?>
 
</body>
</html>
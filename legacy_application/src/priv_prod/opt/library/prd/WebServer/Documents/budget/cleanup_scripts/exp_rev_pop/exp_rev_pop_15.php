<?php$sql = "update pcard_extract_worksheet2set valid_record='n'where valid_record=''";//echo "$sql";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 14. $sql");$sql = "update pcard_extract_worksheet2set valid_record='y'where days_elapsed > '10' and days_elapsed <= '60'";//echo "$sql";$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 15. $sql");$step=15;?>
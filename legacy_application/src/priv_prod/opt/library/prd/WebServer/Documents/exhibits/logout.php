<?php
 session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
?>
 

<!--E&DM Graphic Title Header-->
<header id="header_title">
<img src="images/EDM_WorkOrderDatabase_DATABASE.png" width="80%" height="auto">
</header>

<?php
    echo "You have successfully logged out.";
    ?>
<?php// from index.htmlextract($_REQUEST);session_start();if($password=="mar123"){$_SESSION[auth]="yes";}if(strchr($Submit,"View") OR $button=="View"){header("Location: index.php");}if(strchr($Submit,"Report") OR $button=="Report"){header("Location: war_new.php");}if(strchr($Submit,"Edit") OR $button=="Edit"){header("Location: editSearch.php");}?>
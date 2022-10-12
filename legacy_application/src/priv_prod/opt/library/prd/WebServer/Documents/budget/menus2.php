<?php

echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>

  <head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' /> 
    <title>MoneyTracker</title>
	
    <link rel='stylesheet' type='text/css' href='/budget/home2.css' />";
	
	
echo "<script language='JavaScript' type='text/javascript'>
function popitup(url)
{   newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=400,width=400,menubar=1,toolbar=1');
        if (window.focus) {newwindow.focus()}
        return false;
}
</script>";	
	
	
	
	
echo "</head> 
  <body id='home'>
        <div id='page'>		
        <div id='header'>";
if($level < '3'){echo "<a href='/budget/menu.php?forum=blank'>";}
else
{echo "<a href='/budget/home.php'>";}

echo "<img width='50%' height='100%' src='/budget/nrid_logo.jpg' alt='roaring gap photos'></img>
		</a>
		</div>";

		
//if($level=='5'){include ("navigation_2.php");}		


       
?>	   
	   
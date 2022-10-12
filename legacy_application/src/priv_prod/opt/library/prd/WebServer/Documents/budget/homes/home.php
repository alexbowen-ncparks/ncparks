<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;


if(!$_SESSION["budget"]["tempID"]){
header("location: /login_form.php?db=budget");
}

//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitionalt//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
  <head>
    <title>Roaring Gap Homes</title>
    <link rel="stylesheet" type="text/css" href="home.css" />
  </head> 
  <body id="home">
  
  <div id="header">
		<a href="/budget/home.php">
		<img width="100%" height="100%" src="nrid_logo.jpg" alt="roaring gap photos"/></img>
		</a>
		</div>
  
  
  
  
  
  <div id="centeredmenu">
	<ul>
		<li><a href="#">Homes</a>
			<ul>
				<li><a href="admin_properties.php">Properties</a></li>
				<li><a href="admin_content.php">Content</a></li>
				<li><a href="#">Link three</a></li>
				<li><a href="#">Link four</a></li>
				<li><a href="#">Link five</a></li>
			</ul>
		</li>
<!--		<li class="active"><a href="#" class="active">Tab two</a>-->
		<li><a href="#" class="active">Tab two</a>
			<ul>
				<li><a href="#">Link one</a></li>
				<li><a href="#">Link two</a></li>
				<li><a href="#">Link three</a></li>
				<li><a href="#">Link four</a></li>
				<li><a href="#">Link five is a long link that wraps</a></li>
			</ul>
		</li>
		<li><a href="#">Long tab three</a>
			<ul>
				<li><a href="#">Link one</a></li>
				<li><a href="#">Link two</a></li>
				<li><a href="#">Link three</a></li>
				<li><a href="#">Link four</a></li>
				<li><a href="#">Link five</a></li>
			</ul>
		</li>
		<li><a href="#">Tab four</a>
			<ul>
				<li><a href="#">Link one</a></li>
				<li><a href="#">Link two</a></li>
				<li><a href="#">Link three</a></li>
				<li><a href="#">Link four</a></li>
				<li><a href="#">Link five</a></li>
			</ul>
		</li>
		
	</ul>	
		
</div>     
		
        <div class="column1of4">
<?php 
include 'homes_for_sale.php' 
//include 'reports_all_centers_summary_by_division.php' 

?>	
<!--		<h2>About Peggy</h2>
        <h3>Introduction</h3>-->
		</div>

        <div id="footer">footer</div>

      </div>

    </body>
</html>
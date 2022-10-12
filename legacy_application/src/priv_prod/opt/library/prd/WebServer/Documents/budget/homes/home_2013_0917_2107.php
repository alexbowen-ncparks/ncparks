<?php
session_start();
if (!$_SESSION["budget"]["tempID"]) {echo "Access denied";exit;}
//echo "<pre>";print_r($_SESSION);echo "</pre>";exit;

/*
if(!isset($tempID)){
header("location: /login_form.php?db=budget");
}
*/
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
        <div id="page">
		
        <div id="header">
		<img width="100%" height="100%" src="nrid_logo.jpg" alt="roaring gap photos"/>
		</div>
	



			
        <div id="navigation">
		   <nav>
	<ul>
		<li><a href="home.php" id="home_nav">Home</a></li>
		<li><a href="admin_properties.php" id="admin_nav">Admin</a>
<?php	
	
//			<ul>
//				<li><a href="#">admin_submenu1</a></li>
//				<li><a href="#">admin_submenu2</a></li>
//				<li><a href="#">admin_submenu3</a>
//					<ul>
//						<li><a href="#">admin_submenu3_a</a></li>
//						<li><a href="#">admin_submenu3_b</a></li>
//					</ul>
//				</li>
//			</ul>
?>

          </li>
		
		<li><a href="sell_home.php" id="sell_nav">Sell Your Home</a></li>
		<li><a href="buy_home.php" id="buy_nav">Home Buyers</a></li>
		<li><a href="about_peggy2.php" id="about_nav">About Peggy</a></li>
		
		
		
		<li><a href="contact.php" id="contact_nav">Contact Peggy</a>
		
<?php		
//			<ul>
//				<li><a href="#">contact_peggy_submenu1</a></li>
//				<li><a href="#">contact_peggy_submenu2</a></li>
//			</ul>
?>			
			
		</li>
		
	</ul>
</nav>
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
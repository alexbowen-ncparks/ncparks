<?php

ini_set('display_errors',1);
$database="trails";
include("../../include/auth.inc");
// echo "<pre>"; print_r($_SESSION); echo "</pre>"; // exit;
include("../../include/iConnect.inc");

mysqli_select_db($connection,$database);

include("../_base_top.php");

echo "
<html>
	
	<body>
<style>
.head {
font-size: 22px;
color: #999900;
}
</style>

<!--
		<div align='middle' style='background-color:#237B65'>
			<table width='100%' border='0' cellpadding='0' cellspacing='0'>
		  		<tr>
			  		<td align='center' valign='top'>
			  			<a href='http://ncparks.gov' target='_blank'>
			  				<img src='/inc/css/images/dpr_1.jpg'>
			  			</a>
					</td>
				</tr>
		  
		 		<tr bgcolor='purple' height='9'>
		 			<td>
		 			</td>
		 		</tr>
			</table>
			

  		</div>
 
 

		<div align='left'>
			<table style='background-color:#ABC578' cellpadding='3'>

		
			
				<tr>
					<td colspan='3' align='middle'>
						<a align='middle' style='font-size:30px'>
							Dashboards
						</a>
					</td>
				</tr>
			
				<tr>
					<td colspan='3' align='left'>
						<a href=''>
							
						</a>
					</td>
				</tr>
			
				<tr>
					<td colspan='3' align='left'>
						<a href=''>
							
						</a>
					</td>
				</tr>

				<tr>
					<td colspan='3' align='left'>
						<a href=''>
							
						</a>
					</td>
				</tr>
			</table>
		</div>
-->


<div align='middle'>
		
<script type='text/javascript' src='https://bi.nc.gov/javascripts/api/viz_v1.js'></script><div class='tableauPlaceholder' style='width: 1600px; height: 927px;'><object class='tableauViz' width='1600' height='927' style='display:none;'><param name='host_url' value='https%3A%2F%2Fbi.nc.gov%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='&#47;t&#47;NCParksandRec' /><param name='name' value='PreziDshbrd&#47;Dashboard1' /><param name='tabs' value='no' /><param name='toolbar' value='no' /><param name='showAppBanner' value='false' /></object></div>
</div>


";

include("footer.php");



?>
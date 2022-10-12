<?php

ini_set('display_errors',1);
$database="dpr_system";
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

<div align='right'>

<!--
<script type='text/javascript' src='https://tableau.nc.gov/javascripts/api/viz_v1.js'></script><div class='tableauPlaceholder' style='width: 1000px; height: 827px;'><object class='tableauViz' width='1000' height='827' style='display:none;'><param name='host_url' value='https%3A%2F%2Ftableau.nc.gov%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='&#47;t&#47;NCParksandRec' /><param name='name' value='Feb2021Request&#47;Dashboard1' /><param name='tabs' value='no' /><param name='toolbar' value='no' /><param name='showAppBanner' value='false' /></object></div>
-->


<!--Capital Improvement & Land Acquisitions Project Costs
-->
<div align='right'>
<h1 align='right'> Capital Improvements & Land Acquisitions Project Costs</h1>

<script type='text/javascript' src='https://bi.nc.gov/javascripts/api/viz_v1.js'></script><div class='tableauPlaceholder' style='width: 1000px; height: 827px;'><object class='tableauViz' width='1000' height='827' style='display:none;'><param name='host_url' value='https%3A%2F%2Fbi.nc.gov%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='&#47;t&#47;NCParksandRec' /><param name='name' value='Feb2021Request&#47;Dashboard1' /><param name='tabs' value='no' /><param name='toolbar' value='no' /><param name='showAppBanner' value='false' /></object></div>

<br/>
</div>


<!--Maintenance
-->
<div align='right'>
<h1 align='right'> Maintenance Project Costs</h1>

<script type='text/javascript' src='https://bi.nc.gov/javascripts/api/viz_v1.js'></script><div class='tableauPlaceholder' style='width: 1000px; height: 827px;'><object class='tableauViz' width='1000' height='827' style='display:none;'><param name='host_url' value='https%3A%2F%2Fbi.nc.gov%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='&#47;t&#47;NCParksandRec' /><param name='name' value='Feb2021RequestMaintOnly&#47;Dashboard1' /><param name='tabs' value='no' /><param name='toolbar' value='no' /><param name='showAppBanner' value='false' /></object></div>

<br/>
</div>


<!-- Capital Improvements, Land Acquisitions, & Maintenance
-->
<div align='right'>
<h1 align='right'> Capital Improvements, Land Acquisitions, & Maintenance Project Costs</h1>

<script type='text/javascript' src='https://bi.nc.gov/javascripts/api/viz_v1.js'></script><div class='tableauPlaceholder' style='width: 1000px; height: 827px;'><object class='tableauViz' width='1000' height='827' style='display:none;'><param name='host_url' value='https%3A%2F%2Fbi.nc.gov%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='&#47;t&#47;NCParksandRec' /><param name='name' value='Feb2021RequestAll&#47;Dashboard1' /><param name='tabs' value='no' /><param name='toolbar' value='no' /><param name='showAppBanner' value='false' /></object></div>

<br/>
</div>


<!--
<script type='text/javascript' src='https://bi.nc.gov/javascripts/api/viz_v1.js'></script><div class='tableauPlaceholder' style='width: 1000px; height: 827px;'><object class='tableauViz' width='1000' height='827' style='display:none;'><param name='host_url' value='https%3A%2F%2Fbi.nc.gov%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='&#47;t&#47;NCParksandRec' /><param name='name' value='Feb2021Request&#47;Dashboard1' /><param name='tabs' value='no' /><param name='toolbar' value='no' /><param name='showAppBanner' value='false' /></object></div>

</div>
-->



";

?>

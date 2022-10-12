
<?php

$database="job_fair";

error_reporting(-1);
ini_set('display_errors', true);

require($_SERVER['DOCUMENT_ROOT'] . "/job_fair/_common.php");

page_header("Job Fair applications home");



#echo "
# <br><br>
# Naturally Wonderful reports will be here as they become available.
# ";


echo "
<script type='text/javascript' src='https://tableau.nc.gov/javascripts/api/viz_v1.js'></script><div class='tableauPlaceholder' style='width: 1366px; height: 795px;'><object class='tableauViz' width='1366' height='795' style='display:none;'><param name='host_url' value='https%3A%2F%2Ftableau.nc.gov%2F' /> <param name='embed_code_version' value='3' /> <param name='site_root' value='&#47;t&#47;NCParksandRec' /><param name='name' value='job_fair_n_recruiting_published_dashboards&#47;Dashboard1' /><param name='tabs' value='no' /><param name='toolbar' value='yes' /><param name='filter' value='order=contentTypeOrder%3Aasc%2Cname%3Aasc' /><param name='showAppBanner' value='false' /><param name='filter' value='iframeSizedToWindow=true' /></object></div>
";

site_footer();

?>


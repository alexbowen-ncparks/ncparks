<?php//echo "<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.js'></script>";echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js' ></script>";echo "<script type='text/javascript'>$(document).ready(function(){		$('.flip').click(function(){		$('.panel').slideToggle('slow'); });});</script><style type='text/css'>div.panel{	margin:0px;	padding:5px;	text-align:left;	background: lightcyan;	border:solid 1px #c3c3c3;		color: brown;		font-size: 130%;}p.flip{	margin:0px;	padding:5px;	text-align:center;	background:lightcyan;	border:solid 1px #c3c3c3;		font-size: 130%;}div.panel{height:1300px;display:none;}</style>";//echo "<body>";$database="budget";$db="budget";include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parametersmysqli_select_db($connection, $database); // databaseinclude("../../../../include/activity.php");$query1="SELECT procedure_document as 'message' from procedures where pid='91' ";$result1 = mysqli_query($connection, $query1) or die ("Couldn't execute query 1.  $query1");$row1=mysqli_fetch_array($result1);extract($row1);//brings back max (end_date) as $end_date$message=str_replace('  ','&nbsp;&nbsp;',$message);$message=nl2br($message);//echo "date=$date";/*{$comment='y';$add_comment='y';$folder='community';$pid='61';include("procedures.php"); }*/echo "<div class='panel'>";echo "<p>$message</p>";//echo "<p><table><tr><th>$message</th></tr></table></p>";//echo "<p>At NCSU/CTU, you can Practice everything , in an accessible and handy format</p>";echo "</div>";echo "<p class='flip'><font color='brown'><b>Budget Instructions-Click me</b></font><img height='50' width='50' src='/budget/infotrack/icon_photos/info2.png' alt='reports icon' title='payroll_temporary_receipt Budget Instructions'></img>";if($level==5){echo "<a href='/budget/infotrack/procedures.php?comment=y&add_comment=y&folder=community&pid=91&editP=y' target='_blank'>Edit</a>";}echo "</p>";//echo "</body></html>";?>
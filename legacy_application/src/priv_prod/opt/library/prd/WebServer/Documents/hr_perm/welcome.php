<?php
ini_set('display_errors',1);
$database="hr_perm";
include("../../include/auth.inc");

include("../../include/iConnect.inc");
mysqli_select_db($connection,$database);
$sql="SELECT * from manage_menu order by sort_order"; //echo "$sql"; exit;
$result = mysqli_query($connection,$sql) or die();
while($row=mysqli_fetch_assoc($result))
	{
	
	$menu_array[$row['menu_item']][$row['menu_name']][$row['tab_name']]="";
	if($level<5 and $row['menu_item']=="admin"){continue;}
	$ARRAY[]=$row;
	$file_array[$row['menu_name']]=$row['menu_item'];
	}
// include("menu.php");
echo "<!DOCTYPE html><html><head><style>

html, body {
    margin-top: 20px;
    margin-left: 0px;
    padding:0;
    width:100%;
    height:100%;
    color: #ccfff5;
    background-color: #e6fffa;
}

.container {
    width:100%;
}

.column {
    width:33.33333333%;
    float:left;
}

p.welcome
	{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 28px;
	color: #800000;
	text-align: center;
	}
table.brass
	{
	width: 100%;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	color: #000000;
	}
td.brass
	{
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
	text-align: center;
	padding: 5px 30px 5px 80px;
	}
</style></head>";

// echo "<pre>"; print_r($ARRAY); echo "</pre>"; // exit;
foreach($ARRAY as $index=>$array)
	{
	if(in_array("welcome",$array))
		{
		$section_array[]=$array;
		}
	}
// echo "<pre>"; print_r($welcome_array); echo "</pre>"; // exit;
echo "<body>";

echo "<p align='center'><img src='../2013-DPR-logo-small-web.png'></p>";
echo "<p class='welcome'>Welcome to the DPR HR website for Hiring/Separating Permanent Staff.</p>";
echo "<table class='brass'><tr>";
       foreach($section_array as $index=>$array)
	{
	extract($array);
	if(in_array("Governor",$array))
		{
		echo "<td class='brass'>Governor <br /><strong>$tab_content</strong></td>";
		}
	if(in_array("Secretary DNCR",$array))
		{
		echo "<td class='brass'>Secretary DNCR <br /><strong>$tab_content</strong></td>";
		}
	if(in_array("DPR Director",$array))
		{
		echo "<td class='brass'>DPR Director <br /><strong>$tab_content</strong></td>";
		}
	if(in_array("DNCR HR Director",$array))
		{
		echo "<td class='brass'>DNCR HR Director <br /><strong>$tab_content</strong></td>";
		}
	if(in_array("DPR HR Manager",$array))
		{
		echo "<td class='brass'>DPR HR Manager <br /><strong>$tab_content</strong></td>";
		}
	}
echo "</tr></table><hr />";
echo "
 <div class='container'>
    <div class='column'>&nbsp;&nbsp;&nbsp;&nbsp;
       <img src='img_1.png'><br /><br /><br /><br /><br />
       &nbsp;&nbsp;&nbsp;&nbsp;<img src='img_3.png'>
    </div>
    <div class='column'>";
    
    foreach($file_array as $k=>$v)
		{
		if($k=="Admin Functions"){$target="target='_blank'";}else{$target="";}
		echo "<p><a href='menu_target.php?v=$v' $target>$k</a></p>";
		}
    
    
    echo "</div>
    <div class='column'>
       <img src='img_2.png'><br /><br /><br /><br /><br />
       <img src='img_4.png'>
    </div>
</div>
";

echo "</body></html>";
?>
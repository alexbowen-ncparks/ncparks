<?php
ini_set('display_errors',1);
date_default_timezone_set('America/New_York');

$database="photos";
include("../../include/auth.inc");
@$level=$_SESSION['photos']['level'];
	include("../../include/connectROOT.inc");
	mysql_select_db($database,$connection);
//print_r($_REQUEST);exit;
//print_r($_SESSION);
extract($_REQUEST);
$catArray=array("nrid"=>"NRID","scenic"=>"Scenic","activities"=>"Activities","visitor protection"=>"Visitor Protection","maintenance"=>"Maintenance","cultural"=>"Cultural/History","facility"=>"Facility","staff"=>"Staff","resource management"=>"Resource Management","people|groups"=>"People/Groups","geology"=>"Geology","exhibits"=>"Exhibits","other"=>"Other","park_visitor"=>"Park_Visitor","i_e"=>"I&E","vols"=>"Volunteers");  // also found in store.php
	$testCat=array("nrid","scen","acti","cult","visi","main","faci","staf","othe","reso","peop","geol","exhi","vols","i_e");

$subcatArray=array("kron"=>"Kron House","homesite"=>"Homesite","grave"=>"Graveyard","native"=>"Native American","ferry"=>"MOMO Ferry","still"=>"Liquor Still","road"=>"Roads","ccc"=>"CCC");  // also found in store.php
	$testsubCat=array("kron","home","grav","nati","ferr","stil","road","ccc");

if(@$signIn==1)
	{
	extract($_REQUEST);
	echo "Changing the Scientific Name requires Administrative level access. If you have such a level, click <a href='http://www.dpr.ncparks.gov/photos/portal.php?dbTable=images&pid=$pid'>here</a>.<br>Otherwise, click your Browser's Back button.";
	}
?>

<HTML>
<HEAD><TITLE>Edit photo in The ID</TITLE>
<script language="JavaScript">
<!-- THIS JUMP ONLY WORKS FOR FRAMES -->
<!--
function MM_jumpMenu(selObj,restore){ //v3.0
eval("parent.frames['mainFrame']"+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}

function popitup(url)
{   newwindow=window.open(url,'name','resizable=1,scrollbars=1,height=800,width=800,menubar=1,toolbar=1');
        if (window.focus) {newwindow.focus()}
        return false;
}

function toggle(){
	var div1 = document.getElementById('div1')
	if (div1.style.display == 'none') {
		div1.style.display = 'block'
	} else {
		div1.style.display = 'none'
	}
}
//-->
</script>

</HEAD>
<BODY><body bgcolor="#CCFFCC">
<?php 

// *******************************************
    // Show the form to edit a photo
if (@$submit == "Edit the Photo Info" || $submit == "Change species")
	{
	
	
mysql_select_db('dpr_system',$connection);
$sql = "SELECT park_code,park_name from parkcode_names where 1 order by park_code";
$result = @mysql_query($sql, $connection);
while($row=mysql_fetch_assoc($result))
	{
	$park_code_array[$row['park_code']]=$row['park_name'];
	}
	$park_code_array['BUOF']=$row['Budget Office'];
	
	@$keepMajorGroup=$majorGroup;
	
	mysql_select_db("photos",$connection);
	$sql="SELECT * from images
	where pid='$pid'";
//	echo "$sql";
	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
	$row = mysql_fetch_array($result);
	extract($row); //echo "<pre>"; print_r($row); echo "</pre>"; exit;
	
	$linkEdit=explode("/",$link);
	$link640="photos/".$linkEdit[1]."/".$linkEdit[2]."/ztn.".$pid.".jpg";
	
	mysql_select_db("nrid",$connection);
	$sql1="SELECT comName,family,authSp,authSsp from dprspp
	where sciName='$sciName'";
	$result1 = @mysql_query($sql1, $connection) or die("$sql1 Error 2#". mysql_errno() . ": " . mysql_error());
	$row1 = mysql_fetch_array($result1);
	@extract($row1);
	
	if($level>3){
	$employeeID="Employee ID (Lname1234): 
		<input type='text' name='personID' value='$personID' size='26'>";}
	else{$employeeID="";}
	if($submit=="Change species"){
	$com1=explode("*",urldecode($com));
	$comName=$com1[0];
	$sciName=trim($com1[1]);
	//echo "c=$comName s=$sciName";
	}
	
	if($cat){
		$b="CKED";
		foreach($testCat as $k=>$v){
			if(strpos($category, $v)>-1){${$v.$b}="checked";}			
			}
	}
	
	if($subcat){
		$b="CKED";
		foreach($testsubCat as $k=>$v){
			if(strpos($subcat, $v)>-1){${$v.$b}="checked";}			
			}
	}
	
	
	if($website){$webCKED="checked";}
	if($sys_plan){$sysCKED="checked";}
	if($fire_gallery){$fireCKED="checked";}
	
	if($date){$year=$date;}else{$year=date("Y-m-");}
	// $year=date("Y-m-");
		echo "Modify the appropriate info and then submit change(s).
	<hr>
	
	 <form method='post' name='editPhoto' action='edit.php' enctype='multipart/form-data'>";
		
	include("GroupArray.inc");
	
	$arrayNum = count($GroupArrayN);
	$i = 1;
	
	$file="listTest.php?pid=$pid&e=1&park=$park&majorGroup=";
	if(@$_SESSION['mg'])
		{
		$majorGroup=$_SESSION['mg'];
		$_SESSION['mg']="";}
	
	echo "When adding a NRID entry, select the Group <b>first.</b>
	<br>
	<select name=\"majorGroup\" onChange=\"MM_jumpMenu(this,0)\">\n";
	 echo "<option value=''>\n";
	 $i=1;
	while ($i <= $arrayNum) {
	if($majorGroup == $GroupArrayN[$i]){$ck="selected";}else{$ck="value";}
		 echo "<option $ck=\"$GroupArrayV[$i]\">$GroupArrayN[$i]\n";
		 $i++;
	}
	echo "</select>\n";
	if($sciName){$nridCKED="checked";}

	echo "Select Group (<font color='red'>required ONLY for NRID entry</font>)<br>";
	echo "<br>
	<b>Park:</b><select name='park'>";

	$parkC=$park;
	foreach($park_code_array as $k=>$v)
		{
		if($k==$parkC){$s="selected";}else{$s="value";}
			 echo "<option $s='$k'>$k\n";
		}
	echo "</select> (<font color='red'>required</font>)<br>
	<table border='1'><tr>";
	
	
	//$subcatArray  defined above
	$i=1;$b="CKED"; $subcat="";
	foreach($subcatArray as $key=>$val){
		$a=strtolower(substr($key,0,4));
		@$ck=${$a.$b};
		if(fmod($i,4)==0){@$br="<br />";}else{$br="";} $i++;
		$subcat.="<input type='checkbox' name='subcat[]' value='$key' $ck>$val$br";
		
		}
	
	//$catArray  defined above
	foreach($catArray as $k=>$v){
		$a=strtolower(substr($k,0,4)); 
		@$ck=${$a.$b};
		if($k=="resource management"){echo "</tr><tr>";}
		
		if($k=="cultural"){
		$v="$v<div id=\"topicTitle\" > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick=\"toggle('div1');\" href=\"javascript:void('')\">subcategories &#177</a></div>
		<div id=\"div1\" style=\"display: none\"> $subcat</div>";
		}
	
		echo "<td><input type='checkbox' name='cat[]' value='$k' $ck>$v</td>";
		}
	
	
	if(!isset($webCKED)){$webCKED="";}
	if(!isset($sysCKED)){$sysCKED="";}
	if(!isset($fireCKED)){$fireCKED="";}
	if(!isset($cd)){$cd="";}
	if(!isset($photoname)){$photoname="";}
	if(!isset($photog)){$photog="";}
	echo "</tr></table><br>
	<img src=$link640><br>
	Mark for DPR Website inclusion: <input type='checkbox' name='website' value='x' 
	$webCKED>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Mark for DPR Systemwide Plan inclusion: <input type='checkbox' name='sys_plan' value='x' $sysCKED>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	Mark for Fire Gallery inclusion: <input type='checkbox' name='fire_gallery' value='x' $fireCKED>
	 <br>
	 
	Name, or Number, of CD containing original photo: 
		<input type='text' name='cd' value='$cd' size='26'> (<font color='red'>required</font>)
	<br><br>
	Date of Photo: 
		<input type='text' name='datePhoto' value='$year' size='16'>
		$employeeID<br><br>";
	echo "Name of Photo: <input type='text' name='photoname' value=\"$photoname\" size='75'><br><br>
		Photographer(s)/Source: <input type='text' name='photog' value=\"$photog\" size='50'><br><br>";
	
	$sciName1=$sciName;
	
	if(@$authSp){$authSp1=" $authSp ";}
	
	$pos1=strpos($sciName,' var. ');
	if($pos1>0){$sciNameArray=explode(" var. ",$sciName);
	$sciName1=$sciNameArray[0]; $sciNameVar=" <i>var. ".$sciNameArray[1]."</i>";
	}
	$pos2=strpos($sciName,' var ');
	if($pos2>0){$sciNameArray=explode(" var ",$sciName);
	$sciName1=$sciNameArray[0]; $sciNameVar=" <i>var. ".$sciNameArray[1]."</i>";
	}
	$pos3=strpos($sciName,' ssp ');
	if($pos3>0){$sciNameArray=explode(" ssp ",$sciName);
	$sciName1=$sciNameArray[0]; $sciNameVar=" <i>ssp. ".$sciNameArray[1]."</i>";
	}
	$pos4=strpos($sciName,' ssp. ');
	if($pos4>0){$sciNameArray=explode(" ssp. ",$sciName);
	$sciName1=$sciNameArray[0]; $sciNameVar=" <i>ssp. ".$sciNameArray[1]."</i>";
	}
	
	
	
	if(!$sciName or $_SESSION['photos']['level']>2){
	$override=1;
	echo "<input type='text' name='sciName_form' value='$sciName'>";
	echo "<input type=\"button\" value=\"Get SciName\" onClick=\"return popitup('edit_ID_sciName.php')\">";
	}
	 
	 if(!isset($authSp1)){$authSp1="";}
	 if(!isset($authSp)){$authSp="";}
	 if(!isset($comName)){$comName="";}
	 if(!isset($sciName1)){$sciName1="";}
	 if(!isset($authSsp)){$authSsp="";}
	 if(!isset($sciNameVar)){$sciNameVar="";}
	if(!isset($comment)){$comment="";}
	if(!isset($lat)){$lat="";}
	if(!isset($lon)){$lon="";}
	if(!isset($override)){$override="";}
	echo "<br />SciName: <i>$sciName1</i> $authSp1 $sciNameVar $authSsp
		<br>
		ComName: <b>$comName</b>
		<br><br>
	Edit species authority: <input type='text' name='authSp' value='$authSp' size='25'>";
	echo " &nbsp;&nbsp; ssp./var. authority: <input type='text' name='authSsp' value='$authSsp' size='25'><br>";
	
	if(!isset($editSQL)){$editSQL="";}
	echo "Comment(s): <textarea cols='40' rows='5' name='comment'>$comment</textarea>
		<INPUT TYPE='hidden' name='pid' value='$pid'>
		<INPUT TYPE='hidden' name='editSQL' value='$editSQL'>";
		
	echo " &nbsp;&nbsp; latitude: <input type='text' name='lat' value='$lat' size='10'>&nbsp;&nbsp; longitude: <input type='text' name='lon' value='$lon' size='10'><hr>";
	
	if(!$override)
		{
		echo  "<INPUT TYPE='hidden' name='sciName_form' value='$sciName1'>";
		}
	
	 if(!isset($source)){$source="";}
	echo "<INPUT TYPE='hidden' name='comName' value='$comName'>
	<INPUT TYPE='hidden' name='source' value='$source'>";
		
	   echo "<input type='submit' name='submit' value='Submit any Edit'>
		</form>";
	
	echo "</BODY></HTML>";
	exit;
	}

    // UPDATE photo info
if ($submit == "Submit any Edit") 
	{
	//echo "<pre>"; print_r($_REQUEST); echo "</pre>";  //exit;
	  $sciName = $sciName_form;
	//if($sciName){$photoname=$comName;}

	  @$photoname = addslashes($photoname);
	  @$photog = addslashes($photog);
	   @$link = urldecode($link);
	   @$comment = addslashes($comment);
	   @$discus = urldecode($discus);
	   @$cd = urldecode($cd);
	   @$personID=str_replace("'","",$personID);// remove ' from O'Neal e.g.
   
	  for($i=0;$i<count($catArray);$i++)
		{
		@$category.=@$cat[$i].",";
		}
	   $category=trim($category,",");
   
	  for($i=0;$i<count($subcatArray);$i++)
		{
		@$subcategory.=@$subcat[$i].",";
		}
	   $subcategory=trim($subcategory,",");
   
	   $testCat=explode(',',$category);
	  if(!in_array("cultural",$testCat)){$subcategory="";}

	if(!isset($website)){$website="";}
	if(!isset($sys_plan)){$sys_plan="";}
	if(!isset($fire_gallery)){$fire_gallery="";}

	$sql = "UPDATE images set sciName='$sciName',majorGroup='$majorGroup',cat='$category',subcat='$subcategory',photoname='$photoname',cd='$cd',date='$datePhoto',photog='$photog',comment='$comment',park='$park',personID='$personID',website='$website',sys_plan='$sys_plan' ,lat='$lat' ,lon='$lon' ,fire_gallery='$fire_gallery' 
	where pid='$pid'";

	//echo "$sql<br>t=$test";exit;

	$result = @mysql_query($sql, $connection) or die("$sql Error 1#". mysql_errno() . ": " . mysql_error());
		MYSQL_CLOSE();

	if($authSp!="" || $authSsp!="")
		{
		mysql_select_db("nrid",$connection);
		$authSp = addslashes($authSp);
		$authSsp = addslashes($authSsp);
	
		$sql1 = "UPDATE dprspp set authSp='$authSp',authSsp='$authSsp'
		where sciName='$sciName'";
	
		$result1 = @mysql_query($sql1, $connection) or die("$sql1 Error 1#". mysql_errno() . ": " . mysql_error());
		MYSQL_CLOSE();
		}// end if $authSp or $authSsp

	$sql=$editSQL."Submit=1";
	if($editSQL)
		{
		header("Location: search.php?$sql");
		}
		else
		{
		header("Location: getData.php?pid=$pid&source=$source");
		}

	}

?>

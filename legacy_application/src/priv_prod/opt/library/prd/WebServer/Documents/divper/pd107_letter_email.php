<?php 
//$database="divper";
//include("../../include/connectROOT.inc"); // database connection parameters

extract($_REQUEST);
// Get Data
$sql = "SELECT * From vacant WHERE beacon_num='$beacon_num'";
$result = mysql_query($sql) or die ("Couldn't execute query. $sql");
while ($row=mysql_fetch_array($result))
{extract($row);}


		@$text.="E-MEMORANDUM%0A%0A%0A";
		
		$text.="DATE: ".date('Y-m-d');
		
		$text.="%0A%0ATO: ".$hireMan;
		
		$text.="%0A%0AFROM: Screening Team Chair";
		
		$text.="%0A%0ASUBJECT: Transmittal of Applications for Position # $beacon_num, $posTitle, $parkcode%0A%0A%0A";
		$subject="Transmittal of Applications for Position # $beacon_num, $posTitle, $parkcode";
		

$here="https://10.35.152.9/divper/pd107_upload.php?beacon_num=$beacon_num";
$here="https://10.35.152.9/divper/pd107_upload.php?beacon_num=$beacon_num";

$text.="The applicants in the alphabetical list below have been evaluated as Qualified based on the T and E Competencies (KSAs and behaviors) as advertised. The PD-107s are available for download at:%0A$here%0A%0AAll other applications and data have been sent to the Division of Human Resources Manager.%0A%0A";

$sql="Select *  From `pd107_uploads` where beacon_num='$beacon_num' order by tempID";
 $result = @MYSQL_QUERY($sql,$connection);
 
$i=1;
while($row=mysql_fetch_assoc($result)){
	extract($row);
	$text.=$i.".  ".$tempID."%0A";
	$i++;
	}
	
//$text.="%0A%0ASee attached portion of the QSC for hightly qualified.";
//	%0A%0A%0A%0AAttachments: Applications (Form PD-107)
	

$text.="%0A%0ASigned copy retained by $screen_name, $from";

?>
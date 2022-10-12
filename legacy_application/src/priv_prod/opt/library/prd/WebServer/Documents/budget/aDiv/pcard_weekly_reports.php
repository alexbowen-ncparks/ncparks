<?php
//session_start();

session_start();

if(!$_SESSION["budget"]["tempID"]){echo "access denied";exit;
}

//include("../../../include/authBUDGET.inc");
//echo "<br />Hello Line 10<br />";
$database="budget";
//$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
include("../../../include/activity.php");
//echo "<br />Hello line 15<br />";
//echo "<pre>";print_r($_SESSION);echo "</pre>";//exit;
//echo "<pre>";print_r($_SERVER);echo "</pre>";//exit;
//echo "<pre>";print_r($_REQUEST);echo "</pre>";  exit;
//$dbTable="partf_payments";
$tempid=$_SESSION['budget']['tempID'];


$file="pcard_weekly_reports.php";
$fileMenu="pcard_weekly_reports_menu.php";
$varQuery=$_SERVER[QUERY_STRING]; //ECHO "v=$varQuery";exit;

extract($_REQUEST);

if($admin_num){$parkcode=$admin_num;}
$distPark=strtoupper($parkcode);
$database="budget";
//$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

//echo "<br />b_ok=$b_ok<br />"; exit;

// ******** Edit/Update Status ***********

if($b_ok!=""){

	$query="UPDATE `pcard_unreconciled` 
	set budget_ok='$b_ok'
	WHERE admin_num='$admin' and report_date='$report_date'";
	//echo "$query<br>";exit;
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query 0. $query");

	if($b_ok=="y"){
		// ** CCOOPER if there's an issue with pulling pcards and you fall behind backdate here!  ex. $today="20220614";
		$today=date(Ymd);
		
		
		$query="UPDATE `pcard_unreconciled` 
		set budget2controllers='$today'
		WHERE admin_num='$admin' and report_date='$report_date'";

		$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");

		$query="UPDATE `pcard_report_dates_compliance` 
		set fs_approver='$tempid',fs_approver_date='$today',deadline_ok2='$de_ok2'
		WHERE admin_num='$admin' and report_date='$report_date'";

		$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");

	}

	if($b_ok=="n"){
	
		$query="UPDATE `pcard_unreconciled` 
		set budget2controllers='0000-00-00'
		WHERE admin_num='$admin' and report_date='$report_date'";

		$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");


		$query="UPDATE `pcard_report_dates_compliance` 
		set fs_approver='',fs_approver_date='0000-00-00',deadline_ok2=''
		WHERE admin_num='$admin' and report_date='$report_date'";

		$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
	}

	// till closing bracket represents code to update yearly pcard score passed to TABLE=mission_scores 
	$query="SELECT fiscal_year as 'pcard_year' from pcard_report_dates_compliance where 1 
        and admin_num='$admin' and report_date='$report_date' ";
	echo "<br />Line 88: query=$query<br />";
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
	$row=mysqli_fetch_array($result);
	extract($row);


	$query="SELECT count(id) as 'yes_deadline' from pcard_report_dates_compliance where 1 
	        and admin_num='$admin' and fiscal_year='$pcard_year'
			and deadline_ok2='y'";
	echo "<br />Line 97: query=$query<br />";		
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");

	$row=mysqli_fetch_array($result);
	extract($row);

	$query="SELECT count(id) as 'total_deadline' from pcard_report_dates_compliance where 1 
	        and admin_num='$admin' and fiscal_year='$pcard_year'
			and deadline_ok2 != '' ";
	echo "<br />Line 106: query=$query<br />";		
			
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");
	$row=mysqli_fetch_array($result);
	extract($row);

	//echo "<br />yes_deadline=$yes_deadline<br />";
	//echo "<br />total_deadline=$total_deadline<br />";
	$score=($yes_deadline/$total_deadline)*100;
	$score=number_format($score,2);


	//echo "<br />$admin score=$score<br />";

	$pcard_admin=$admin;
	if($pcard_admin=='WAHO'){$pcard_admin='WARE';}
	if($score=='0.00'){$score='0.01';}

	$query="update mission_scores set percomp='$score' where gid='17' and fyear='$pcard_year' and playstation='$pcard_admin' ";
	//echo "<br />query=$query<br />";
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query.  $query");

	//echo "$query<br>";exit;
// 06-17-2022: ccooper ending bracket for ($b_ok!="") ???
}// end for

//Approve all Reconcilements for one week for all Parks instead of approving 1 Park at the time

//echo "<br />approve_all=$approve_all<br />";

if($approve_all=='y')
{
	// ** CCOOPER if there's an issue with pulling pcards and you fall behind backdate here!  ex. $today="20220614";
		$today=date(Ymd);
	
	$query="UPDATE `pcard_unreconciled` 
	set budget2controllers='$today',budget_ok='y'
	WHERE report_date='$report_date'";

	//echo "<br />Line 138: query=$query<br />";

	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");


	$query="UPDATE `pcard_report_dates_compliance` 
	set fs_approver='$tempid',fs_approver_date='$today',deadline_ok2='y'
	WHERE  report_date='$report_date'";

	//echo "<br />Line 147: query=$query<br />";

	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
}


//scale down signature for a specific cashier
//echo "<br />scale_up=$scale_up | scale_down=$scale_down | cashier=$cashier | manager=$manager<br />";
if($scale_down=="y" and $cashier!='')
{
	$sig_scale3=$sig_scale2-.10;
		
	$query="UPDATE `cash_handling_roles` 
	set sig_scale='$sig_scale3'
	WHERE tempid='$cashier'";

	echo "<br />Query Line140: $query<br />";

	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");	
}

//scale up signature for a specific cashier
if($scale_up=="y" and $cashier!='')
{
	$sig_scale3=$sig_scale2+.10;
		
	$query="UPDATE `cash_handling_roles` 
	set sig_scale='$sig_scale3'
	WHERE tempid='$cashier'";

	echo "<br />Query Line157: $query<br />";

	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");	
}


//scale down signature a specific manager
if($scale_down=="y" and $manager!='')
{
	$sig_scale3=$sig_scale2-.10;
		
	$query="UPDATE `cash_handling_roles` 
	set sig_scale='$sig_scale3'
	WHERE tempid='$manager'";

	echo "<br />Query Line175: $query<br />";

	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");		
}

//scale up signature a specific manager
if($scale_up=="y" and $manager!='')
{
	$sig_scale3=$sig_scale2+.10;
		
	$query="UPDATE `cash_handling_roles` 
	set sig_scale='$sig_scale3'
	WHERE tempid='$manager'";

	echo "<br />Query Line192: $query<br />";

	$result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");		
}
//echo "<br />de_ok=$de_ok<br />";
if($de_ok!=""){

	$query="UPDATE `pcard_unreconciled` 
	set deadline_ok='$de_ok'
	WHERE admin_num='$admin' and report_date='$report_date'";
	//echo "$query<br>";exit;
	$result = mysqli_query($connection, $query) or die ("Couldn't execute query 0. $query");

}// end for



$varQuery="report_date=$report_date";
// ECHO "v=$varQuery";exit;
//header("Location: pcard_recon.php?$varQuery");exit;


// **************  Show Results ***************
//echo "<br />rep=$rep | report_date=$report_date | report_date2=$report_date2<br />";
if($rep=="excel"){
	$forceText="pc-";
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename=pcard_weekly_reports.xls');
}


// ******** Show Results ***********
//echo "<br />Hello line 262<br />";
//echo "<br />rep=$rep<br />";
if($rep==""){
	include("$fileMenu");
	//echo "<br />Hello line 265<br />";
	if($varQuery){
	echo "<a href='$file?$varQuery&rep=excel'>Excel Export</a>";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='/budget/acs/pcard_recon.php?xtnd_start=$xtnd_start&xtnd_end=$xtnd_end&admin_num=all&submit=Find'>ALL</a> Transactions";}
}
//echo "<br />Line 264<br />"; //exit;
if($report_date){
		/*
	include("../../../include/connectDIVPER.62.inc");
	$sql="SELECT parkcode,email from dprunit";
	   $result = @mysqli_query($connection, $sql,$connection);
	   while($row=mysqli_fetch_array($result)){
	   extract($row);
	   $emailArray[$parkcode]=$email;}
	   $_SESSION[budget][email]="exists";
	 */  
	   
	  // print_r($emailArray);//exit;
	include("../../../include/connectBUDGET.inc");
	$report_date2=str_replace("-","",$report_date);
	echo "<html><body>
	<table border='1' cellpadding='3' align='center'>";
	/*
	$query="update pcard_unreconciled,coa
	set pcard_unreconciled.travel='y'
	where pcard_unreconciled.ncasnum=coa.ncasnum
	and coa.budget_group='travel'
	and (pcard_unreconciled.ncasnum like '5327%' or pcard_unreconciled.ncasnum ='532930')";
	$result = @mysqli_query($connection, $query,$connection);
	*/

	$query="truncate table pcard_summary;";
	//   $result = @mysqli_query($connection, $query,$connection);
	     $result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");

	$query="insert into pcard_summary (report_date ,admin ,count_1656,count_1656_travel,count_1669,count_park_recon,budget_ok,budget2controllers,deadline_ok)
	select report_date,admin_num,'','','',count(admin_num),budget_ok,budget2controllers,deadline_ok
	from pcard_unreconciled
	where 1
	and report_date='$report_date'
	group by admin_num";
	  // $result = @mysqli_query($connection, $query,$connection);
	     $result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");
	/*
	$query="insert into pcard_summary (report_date ,admin ,count_1656,count_1656_travel,count_1669,count_park_recon,budget_ok,budget2controllers)
	select report_date,admin_num,count(xtnd_rundate),'','','','',''
	from pcard_unreconciled
	where 1 and location='1656'
	and travel !='y'
	and report_date='$report_date'
	group by admin_num";
	   $result = @mysqli_query($connection, $query,$connection);

	$query="insert into pcard_summary (report_date ,admin ,count_1656,count_1656_travel,count_1669,count_park_recon,budget_ok,budget2controllers)
	select report_date,admin_num,'',count(xtnd_rundate),'','','',''
	from pcard_unreconciled
	where 1 and location='1656'
	and travel ='y'
	and report_date='$report_date'
	group by admin_num;";
	 $result = @mysqli_query($connection, $query,$connection);

	$query="insert into pcard_summary (report_date ,admin ,count_1656,count_1656_travel,count_1669,count_park_recon,budget_ok,budget2controllers)
	select report_date,admin_num,'','',count(xtnd_rundate),'','',''
	from pcard_unreconciled
	where 1 and location='1669'
	and report_date='$report_date'
	group by admin_num";
	   $result = @mysqli_query($connection, $query,$connection);

	$query="insert into pcard_summary (report_date ,admin ,count_1656,count_1656_travel,count_1669,count_park_recon,budget_ok,budget2controllers)
	select report_date,admin_num,'','','',count(park_recondate),'',''
	from pcard_unreconciled
	where 1 and park_recondate != '0000-00-00'
	and report_date='$report_date'
	group by admin_num";
	$result = @mysqli_query($connection, $query,$connection);
	$report_date2=str_replace("-","",$report_date);
	*/


	$query="update budget.pcard_report_dates_compliance,photos.signature
	set budget.pcard_report_dates_compliance.cashier_sig_img=substring(photos.signature.link,-3)
	where budget.pcard_report_dates_compliance.cashier=photos.signature.personID";
	//$result = @mysqli_query($connection, $query,$connection);
	  $result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");



	$query="update budget.pcard_report_dates_compliance,photos.signature
	set budget.pcard_report_dates_compliance.manager_sig_img=substring(photos.signature.link,-3)
	where budget.pcard_report_dates_compliance.manager=photos.signature.personID";
	//$result = @mysqli_query($connection, $query,$connection);
	  $result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");


	$query="update budget.pcard_report_dates_compliance,budget.cash_handling_roles
	set budget.pcard_report_dates_compliance.cashier_sig_scale=cash_handling_roles.sig_scale
	where budget.pcard_report_dates_compliance.cashier=cash_handling_roles.tempid";
	//$result = @mysqli_query($connection, $query,$connection);
	  $result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");


	$query="update budget.pcard_report_dates_compliance,budget.cash_handling_roles
	set budget.pcard_report_dates_compliance.manager_sig_scale=cash_handling_roles.sig_scale
	where budget.pcard_report_dates_compliance.manager=cash_handling_roles.tempid";
	//$result = @mysqli_query($connection, $query,$connection);
	  $result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");


	if($report_date2 >= '20170518')
	{
		/*	
		 $query = "select pcard_summary.report_date,admin,pcard_report_dates_compliance.cashier_sig_img,cashier_sig_scale,manager_sig_img,manager_sig_scale,
		pcard_report_dates_compliance.cashier,pcard_report_dates_compliance.manager, 
		sum(count_1656) as 'count_1656',
		sum(count_1656_travel) as 'count_1656_travel',
		sum(count_1669) as 'count_1669',
		sum(count_1656+count_1656_travel+count_1669) as 'total_count',
		sum(count_park_recon) as 'park_reconciled_yes',
		sum(count_1656+count_1656_travel+count_1669-count_park_recon) as 'park_reconciled_no',budget_ok,budget2controllers,deadline_ok
		from pcard_summary
		left join pcard_report_dates_compliance on pcard_summary.report_date=pcard_report_dates_compliance.report_date 
		where 1
		and pcard_summary.admin=pcard_report_dates_compliance.admin_num
		group by admin
		order by admin";
		*/
		$query = "select pcard_summary.report_date,admin,pcard_report_dates_compliance.cashier_sig_img,cashier_sig_scale,manager_sig_img,manager_sig_scale,
		pcard_report_dates_compliance.cashier,pcard_report_dates_compliance.manager,pcard_report_dates_compliance.document_location, pcard_report_dates_compliance.document_location2,
		sum(count_park_recon) as 'park_count',
		budget_ok,budget2controllers,deadline_ok
		from pcard_summary
		left join pcard_report_dates_compliance on pcard_summary.report_date=pcard_report_dates_compliance.report_date 
		where 1
		and pcard_summary.admin=pcard_report_dates_compliance.admin_num
		group by admin
		order by admin";

		//echo "<br />Line 398: query=$query<br />";

	}

	if($report_date2 < '20170518')
	{
		$query = "select report_date,admin,
		sum(count_1656) as 'count_1656',
		sum(count_1656_travel) as 'count_1656_travel',
		sum(count_1669) as 'count_1669',
		sum(count_1656+count_1656_travel+count_1669) as 'total_count',
		sum(count_park_recon) as 'park_reconciled_yes',
		sum(count_1656+count_1656_travel+count_1669-count_park_recon) as 'park_reconciled_no',budget_ok,budget2controllers
		from pcard_summary
		where 1
		group by admin
		order by admin";
	}

	//$result = @mysqli_query($connection, $query,$connection);
	  $result = mysqli_query($connection, $query) or die ("Couldn't execute query. $query");

	// $num=mysql_found_rows();
	//echo "<br><br />Hello Line 428: $query<br />";//exit;

	if($report_date2 >= '20170518')
	{
			/*
		$header="<tr><th>admin</th><th>cashier/signature_size</th><th>manager/signature_size</th><th>count_1656</th><th>count_1656_travel</th><th>count_1669</th><th>total_count</th><th>park_reconciled_yes</th><th>park_reconciled_no</th><th>deadline_ok</th><th>budget_ok<br /><a href='pcard_weekly_reports.php?report_date=$report_date&approve_all=y'>Approve_All</a></th><th>budget2controllers</th></tr>";
		*/

		$header="<tr><th>admin</th><th>cashier/signature_size</th><th>manager/signature_size</th><th>regular<br />documents</th><th>travel<br />documents</th><th>total_count</th><th>deadline_ok</th><th>budget_ok<br /><a href='pcard_weekly_reports.php?report_date=$report_date&approve_all=y'>Approve_All</a></th><th>budget2controllers</th></tr>";
	}

	if($report_date2 < '20170518')
	{
	$header="<tr><th>admin</th><th>count_1656</th><th>count_1656_travel</th><th>count_1669</th><th>total_count</th><th>park_reconciled_yes</th><th>park_reconciled_no</th><th>budget_ok</th><th>budget2controllers</th></tr>";
	}

	$checkmark="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";

	echo "$header";

	$j=1;
	while($row = mysqli_fetch_array($result)){
		extract($row);
		//$cashier_sig_last3=substr($cashier_sig_img,-3);


		if($cashier_sig_img=='jpg' or $cashier_sig_img=='JPG'){
			$cashier_sigmark="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		} else {
			$cashier_sigmark="<img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of red x mark'></img>";
		}


		if($manager_sig_img=='jpg' or $manager_sig_img=='JPG'){
			$manager_sigmark="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		} else {
			$manager_sigmark="<img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of red x mark'></img>";
		}

		if(fmod($j,10)==0){
			echo "$header";
		}
		$j++;

		if($table_bg2==''){
			$table_bg2='cornsilk';
		}

		if($c==''){
			$t=" bgcolor='$table_bg2' ";
			$c=1;
		}else{
			$t='';
			$c='';
		}

		echo "<tr$t>";
		//$EMAIL=$emailArray[$admin];
		//$mail="<A HREF=\"mailto:$EMAIL?subject=PCARD Reconciliation is late for $report_date&body=Please reconcile all Pcard purchases using the online Budget database.&cc=tammy.dodd@ncmail.net\">$admin</A>
		//";
		$sum_parkcount+=$park_count;
		//$sum1656+=$count_1656;
		//$sum1656_travel+=$count_1656_travel;
		//$sum1669+=$count_1669;
		//$sumTotal+=$total_count;
		//$sumYes+=$park_reconciled_yes;
		//$sumNo+=$park_reconciled_no;
		$cashier2=substr($cashier,0,-2);
		$manager2=substr($manager,0,-2);

		echo "<td align='center'>$admin</td>";
		/*
		if($report_date2 >= '20170518')
		{
		echo "<td align='center'>$cashier2 $cashier_sigmark <a href='$PHP_SELF?$varQuery&cashier=$cashier&sig_scale2=$cashier_sig_scale&scale_down=y'><</a>$cashier_sig_scale<a href='$PHP_SELF?$varQuery&cashier=$cashier&sig_scale2=$cashier_sig_scale&scale_up=y'>></a></td>";
		//echo "<td align='center'>$cashier_sig_last3</td>";
		//echo "<td align='center'>$manager $manager_sigmark</td>";
		echo "<td align='center'>$manager2 $manager_sigmark <a href='$PHP_SELF?$varQuery&manager=$manager&sig_scale2=$manager_sig_scale&scale_down=y'><</a>$manager_sig_scale<a href='$PHP_SELF?$varQuery&manager=$manager&sig_scale2=$manager_sig_scale&scale_up=y'>></a></td>";
		}
		*/

		if($cashier2 != '')
		{
		$cashier_sigmark=$cashier_sigmark."<a href='$PHP_SELF?$varQuery&cashier=$cashier&sig_scale2=$cashier_sig_scale&scale_down=y'><</a>$cashier_sig_scale<a href='$PHP_SELF?$varQuery&cashier=$cashier&sig_scale2=$cashier_sig_scale&scale_up=y'>></a>";
		}
		else
		{
		$cashier_sigmark='';		
		}		


		if($manager2 != '')
		{
		$manager_sigmark=$manager_sigmark."<a href='$PHP_SELF?$varQuery&manager=$manager&sig_scale2=$manager_sig_scale&scale_down=y'><</a>$manager_sig_scale<a href='$PHP_SELF?$varQuery&manager=$manager&sig_scale2=$manager_sig_scale&scale_up=y'>></a>";
		}
		else
		{
		$manager_sigmark='';		
		}		

		if($report_date2 >= '20170518')
		{
			echo "<td align='center'>$cashier2 $cashier_sigmark</td>";
			//echo "<td align='center'>$cashier_sig_last3</td>";
			//echo "<td align='center'>$manager $manager_sigmark</td>";
			echo "<td align='center'>$manager2 $manager_sigmark</td>";
			
			if($document_location != ''){
				echo "<td><a href='$document_location' target='_blank'>VIEW $checkmark</a></td>";
			}
			
			if($document_location == ''){
				echo "<td></td>";
			}

			if($document_location2 != ''){
				echo "<td><a href='$document_location2' target='_blank'>VIEW $checkmark</a>";
				echo "<br /><a href='/budget/acs/pcard_document_add.php?report_date=$report_date&admin_num=$admin&xtnd_start=$xtnd_start&xtnd_end=$xtnd_end&travel=y&budget_office=y'>Re-Load Documents</a>";
				echo "</td>";
			}

			if($document_location2 == ''){
				echo "<td></td>";
			}
		}  // ccooper end if($report_date2 >= '20170518')

		echo "<td align='center'>$park_count</td>";
		//echo "<td align='center'>$count_1656</td>";
		//echo "<td align='center'>$count_1656_travel</td>";
		//echo "<td align='center'>$count_1669</td>";
		//echo "<td align='center'>$total_count</td>";
		//echo "<td align='center'>$park_reconciled_yes</td>";
		//echo "<td align='center'>$park_reconciled_no</td>";

		//$g1="<font color='green' class='cartRow'>";$g2="</font>";
		//$r1="<font color='red'>";$r2="</font>";
		//if($budget_ok=="y"){$ckY="checked";$ckN="";}else{$ckY="";$ckN="checked";}


		if($deadline_ok=='y'){
			$deadline_shadeY="class='cartRow'";$deadline_imgY="<img height='25' width='25' src='/budget/infotrack/icon_photos/green_checkmark1.png' alt='picture of green check mark'></img>";
		}
		
		if($deadline_ok=='n'){
			$deadline_shadeN="class='cartRow'";$deadline_imgN="<img height='25' width='25' src='/budget/infotrack/icon_photos/xmark1.png' alt='picture of red x mark'></img>";
		}

		$admin=urlencode($admin);

		if($deadline_ok=='y')
		{
			echo "<td align='center'>";
			echo "<a href='$PHP_SELF?$varQuery&admin=$admin&de_ok=n'>$deadline_imgY</a>";
			//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			echo "</td>";
		}

		if($deadline_ok=='n')
		{
			echo "<td align='center'>";
			echo "<a href='$PHP_SELF?$varQuery&admin=$admin&de_ok=y'>$deadline_imgN</a>";
			echo "</td>";
		}

		if($budget_ok=='y'){$shade_y="class='cartRow'";}
		if($budget_ok=='n'){$shade_n="class='cartRow'";}

		//$admin=urlencode($admin);

		echo "<td align='center'>";
		echo "<a href='$PHP_SELF?$varQuery&admin=$admin&b_ok=y&de_ok2=$deadline_ok'><font $shade_y>Y</font></a>";
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='$PHP_SELF?$varQuery&admin=$admin&b_ok=n'><font $shade_n>N</font></a>";
		echo "</td>";
		echo "<td align='center'>$budget2controllers</td></tr>";
		$shade_y="";
		$shade_n="";
		$deadline_shadeY="";
		$deadline_shadeN="";
		$deadline_imgY="";
		$deadline_imgN="";
	}// end while($row = mysqli_fetch_array($result))
} // end if report_date

echo "<tr>";
if($report_date2 >= '20170518')
{
	echo "<td align='center'></td>";
	echo "<td align='center'></td>";
}
echo "<td align='center'></td>";
echo "<td align='center'></td>";
echo "<td align='center'></td>";
echo "<td align='center'>$sum_parkcount</td>";
echo "<td align='center'></td>";
echo "<td align='center'></td>";
echo "<td align='center'></td>";

//echo "<td align='center'>$sum1656</td>";
//echo "<td align='center'>$sum1656_travel</td>";
//echo "<td align='center'>$sum1669</td>";
//echo "<td align='center'>$sumTotal</td>";
//echo "<td align='center'>$sumYes</td>";
//echo "<td align='center'>$sumNo</td>";
echo "</tr>";
echo "</div></body></html>";

?>
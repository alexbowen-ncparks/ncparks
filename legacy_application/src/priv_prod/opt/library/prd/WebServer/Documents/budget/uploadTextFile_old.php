<?php
//  Tom Howard - This was shamelessly borrowed from the phpmyadmin file: ldi_check.php
//Greatly simplified and customized
extract($_REQUEST);
include("menu.php");
//echo "<pre>";print_r($_REQUEST);echo "</pre>";exit;
//First make a copy of existing table
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

$yesterday=date("ymd",mktime(0,0,0,date("m"),date("d")-1,date("y")));

//$table_to_copy="budget.".$into_table."_".$yesterday;

$table_to_copy=$into_table."_".$yesterday;

// ************** Make BackUp Table ********************
//include("cleanup_scripts/table_defs.php");

if($into_table!="pcard_xtnd" and $into_table!="xtnd_ci_monthly")
	{
	// pcard_xtnd already backuped in project_account.php
	// xtnc_ci_monthly doesn't need backup. it was truncated in project_account.php
	include("makeTable.php");
	
	$sql="INSERT INTO $table_to_copy
	SELECT  * 
	FROM `budget` .`$into_table`";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query 2. $sql");
	}

if($into_table=="exp_rev_down")
	{
	//echo "This script is being worked on and is not complete.";
	//exit;
	//   Delete ALL records for this Fiscal Year. The exp_rev import is for the FY Year To Date and may contain back dated records
	$y1=date('Y');// This year
	$y0=$y1-1;// Prev year
	$y2=$y1+1;// Next year
	$y0sub=substr($y0,2,2);
	$y1sub=substr($y1,2,2);
	$y2sub=substr($y2,2,2);
	
	$m=date('n');// get month as single digit
	
	if($m<7)
		{
		$beginFiscalYear=$y0."0701";$fy=$y0sub.$y1sub;
		}
	else
		{
		$beginFiscalYear=$y1."0701";$fy=$y1sub.$y2sub;
		}
	
	session_start();
	$_SESSION['budget']['fy']=$fy;
	$sql =  "DELETE FROM  `exp_rev_down` where acctdate >= '$beginFiscalYear'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql"); 
	
	// Insert new F-year records into intermediate table
	$into_table="exp_rev_fyear";
	
	// First remove all existing records
	$sql =  "TRUNCATE TABLE `exp_rev_fyear`";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql"); 
	
	/* This happens later in another script.
	INSERT INTO exp_rev_down (invoice,pe,description,debit,credit,sys,acct,center,fund,acctdate,f_year)
	SELECT invoice,pe,description,debit,credit,sys,acct,center,fund,acctdate,f_year 
	FROM exp_rev_fyear;
	*/
	
	}

if($into_table=="pcard")
	{
	//   Delete ALL records for this Fiscal Year. The PCARD import is for the FY Year To Date
	$y1=date(Y);$y0=$y1-1;$y2=$y1+1;$m=date(m);
	if($m<7){$beginFiscalYear=$y0."0701";
	$y1=substr($y0,2,2);$y2=substr($y1,2,2);
	$fy=$y0.$y1;}
	else{$beginFiscalYear=$y1."0701";
	$y1=substr($y1,2,2);$y2=substr($y2,2,2);
	$fy=$y1.$y2;}
	session_start();
	$_SESSION[budget][fy]=$fy;
	$sql =  "DELETE FROM  `pcard` where newpostdate >= '$beginFiscalYear'";
	$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql");
	}


//echo "Test2 $textfile";exit;//works to here

//echo "Test1 Into_Table $into_table<br>";//exit;//check table

/**
 * Gets some core scripts
 */
 
//echo "Test1.0 Into_Table $into_table<br>";//exit;//check table

require_once('/opt/library/prd/phpMyAdmin/libraries/grab_globals.lib.php');// this works
//require_once('./libraries/grab_globals.lib.php');// this worked on 195
//require_once('./libraries/common.lib.php');

//echo "Test3 t=$textfile l=$local_textfile";exit;//for testing only

// Check parameters

// Disabled by teh
//PMA_checkParameters(array('db', 'table'));

// functions in the require_once grab_globals resets this var
// we need to re-reset
if($into_table=="exp_rev_down"){$into_table="exp_rev_fyear";}

//echo "Test1.1 Into_Table $into_table<br>";//exit;//check table

/**
 * If a file from UploadDir was submitted, use this file
 */
$unlink_local_textfile = false;
if (isset($btnLDI) && isset($local_textfile) && $local_textfile != '') {
    if (empty($DOCUMENT_ROOT)) {
        if (!empty($_SERVER) && isset($_SERVER['DOCUMENT_ROOT'])) {
            $DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
        }
        else if (!empty($_ENV) && isset($_ENV['DOCUMENT_ROOT'])) {
            $DOCUMENT_ROOT = $_ENV['DOCUMENT_ROOT'];
        }
        else if (@getenv('DOCUMENT_ROOT')) {
            $DOCUMENT_ROOT = getenv('DOCUMENT_ROOT');
        }
        else {
            $DOCUMENT_ROOT = '.';
        }
    } // end if

    if (substr($cfg['UploadDir'], -1) != '/') {
        $cfg['UploadDir'] .= '/';
    }
    
//echo "Test1.2 Into_Table $into_table<br>";//exit;//check table

    $textfile = $DOCUMENT_ROOT . dirname($PHP_SELF) . '/' . preg_replace('@^./@s', '', $cfg['UploadDir']) . preg_replace('@\.\.*@', '.', $local_textfile);


    if (file_exists($textfile)) {
        $open_basedir = @ini_get('open_basedir');

        // If we are on a server with open_basedir, we must move the file
        // before opening it. The doc explains how to create the "./tmp"
        // directory

        if (!empty($open_basedir)) {

            $tmp_subdir = (PMA_IS_WINDOWS ? '.\\tmp\\' : './tmp/');

            // function is_writeable() is valid on PHP3 and 4
            if (!is_writeable($tmp_subdir)) {
                echo $strWebServerUploadDirectoryError . ': ' . $tmp_subdir
                 . '<br />';
                exit();
            } else {
                $textfile_new = $tmp_subdir . basename($textfile);
                move_uploaded_file($textfile, $textfile_new);
                $textfile = $textfile_new;
                $unlink_local_textfile = true;
            }
        }
    }
}


//echo "Test1.3 Into_Table $into_table<br>";//exit;//check table

//echo "Test4 $textfile";exit;//for testing only

/**
 * The form used to define the query has been submitted -> do the work
 */
if (isset($btnLDI) && empty($textfile))
	{
		$js_to_run = '/opt/library/prd/phpMyAdmin/js/functions.js';
	//    $js_to_run = 'functions.js'; // worked on 195
		require_once('/opt/library/prd/phpMyAdmin/libraries/header.inc.php');
	//    require_once('./header.inc.php'); // worked on 195
		$message = $strMustSelectFile;
		require('./ldi_table.php');
	//    require('./ldi_table.php'); // worked on 195
	}
	elseif (isset($btnLDI) && ($textfile != 'none'))
	{
    if (!isset($replace)) {
        $replace = '';
    }

//echo "Test5 $textfile";exit;//for testing only

    // the error message does not correspond exactly to the error...
    if (!@chmod($textfile, 0644)) {
       echo $strFileCouldNotBeRead . ' ' . $textfile . '<br />';
    require_once('/opt/library/prd/phpMyAdmin/libraries/footer.inc.php');
//       require_once('./footer.inc.php'); // worked on 195
    }
/*
    // Convert the file's charset if necessary
    if ($cfg['AllowAnywhereRecoding'] && $allow_recoding
        && isset($charset_of_file) && $charset_of_file != $charset) {
        $textfile         = PMA_convert_file($charset_of_file, $convcharset, $textfile);
    }
*/
    // Formats the data posted to this script
    $textfile             = PMA_sqlAddslashes($textfile);
    $enclosed             = PMA_sqlAddslashes($enclosed);
    $escaped              = PMA_sqlAddslashes($escaped);
    $column_name          = PMA_sqlAddslashes($column_name);

    // (try to) make sure the file is readable:
    chmod($textfile, 0777);

    // Builds the query
    $sql_query     =  'LOAD DATA';

    if ($local_option == "1") {
        $sql_query     .= ' LOCAL';
    }

    $sql_query     .= ' INFILE \'' . $textfile . '\'';
    if (!empty($replace)) {
        $sql_query .= ' ' . $replace;
    }
    
//echo "Test2 Into_Table $into_table";//exit;//check table

    $sql_query     .= ' INTO TABLE ' . PMA_backquote($into_table);
    if (isset($field_terminater)) {
        $sql_query .= ' FIELDS TERMINATED BY \'' . $field_terminater . '\'';
    }
   
//echo "<br>Test3 Into_Table $into_table";exit;//check table

    if (isset($enclose_option) && strlen($enclose_option) > 0) {
        $sql_query .= ' OPTIONALLY';
    }
    if (strlen($enclosed) > 0) {
        $sql_query .= ' ENCLOSED BY \'' . $enclosed . '\'';
    }
    if (strlen($escaped) > 0) {
        $sql_query .= ' ESCAPED BY \'' . $escaped . '\'';
    }
    if (strlen($line_terminator) > 0){
        $sql_query .= ' LINES TERMINATED BY \'' . $line_terminator . '\'';
    }
    if (strlen($column_name) > 0) {
        $sql_query .= ' (';
        $tmp   = split(',( ?)', $column_name);
        $cnt_tmp = count($tmp);
        for ($i = 0; $i < $cnt_tmp; $i++) {
            if ($i > 0) {
                $sql_query .= ', ';
            }
            $sql_query     .= PMA_backquote(trim($tmp[$i]));
        } // end for
        $sql_query .= ')';
    }

    // We could rename the ldi* scripts to tbl_properties_ldi* to improve
    // consistency with the other sub-pages.
    //
    // The $goto in ldi_table.php is set to tbl_properties.php but maybe
    // if would be better to Browse the latest inserted data.
    
//echo "$sql_query";exit;// for testing

$result = mysqli_query($connection, $sql_query) or die ("Couldn't execute query. $sql_query<br />c=$connection");
$num=mysql_info();
list($one,$two)=explode(" D",$num);
   // echo "$one entered.";
    
if($into_table=="all_trans"){echo "<br><br>Click <a href='parseAcct.php'>link</a> to cleanup the imported data. This will take some seconds.
<BR><BR>
1. All non-transactional records are being deleted.<br>
2. The Account number is being parsed from the appropriate header row AND entered for all associated records. (This takes the most time.)<br>
3. Remaining header records are being deleted.<br>
4. Old table is being dropped and new table created from temporary database.<br>
5. Indices are being created for Center and Account.";
}

if($into_table=="partf_payments")
	{
	include("cleanPARTFpayments.php");
	echo "<br><br>Imported records have been cleaned:
	<BR><BR>
	1. Records are trimmed to remove leading and trailing spaces.<br>
	2. A new database friendly date is created and inserted into the \"datenew\" field which will be used in all date related queries.
	3. For records with a blank value for the \"charg_proj_num\" the value of \"na\" is inserted.
	4. Deletes any record that was a header row in original text file
	5. Removes any "+" in fund or center resulting from any unwanted conversion to  scientific notation, e.g., 4E+52";
	}

if($into_table=="cip_fund_bal")
	{
	echo "<br><br>Click <a href='clean_cip_fund_balance.php'>link</a> to cleanup the imported data.
	<BR><BR>
	1. Any blank records are deleted.<br>
	2. A new database friendly date is created and inserted into the \"datenew\" field which will be used in all date related queries.<br>
	3. Any header records left over from Excel deleted.";
	}

if($into_table=="partf_fund_trans")
	{
	echo "<br><br>Click <a href='clean_partf_fund_trans.php'>link</a> to cleanup the imported data.
	<BR><BR>
	1. --.<br>
	2. --.<br>
	3. --.";
	}

if($into_table=="pcard")
	{
	include("cleanup_scripts/completeParsePcard.php");
	 echo "$one entered.<br>";
	echo "<br><br>Imported records have been parsed and cleaned:
	<BR><BR>
	1. Delete ALL records where payst is blank.<br>
	2. Delete ALL records where vendor is VENDOR or NAME.<br>
	3. Delete ALL records where postdate is blank.<br>
	4. Delete ALL records where amt = 0.00<br>
	5. Update records by completing any blank lastname field<br>
	6. Update records by completing blank vendor.<br>
	7. OPTIMIZE  TABLE pcard";
	}

if($into_table=="vendor_payments")
	{
	include("cleanup_scripts/cleanVen_Pay.php");
	 echo "$one entered.<br>";
	echo "<br><br>Imported records have been parsed and cleaned:
	<BR><BR>
	1. Delete ALL records where datePost account amount OR checknum is blank.<br>
	2. Parse COMPANY from first field.<br>
	3. Parse FUND from first field.<br>
	4. Parse RCC from FUND field<br>
	5. Trim fields<br>
	6. Create db valid date.<br>
	7. OPTIMIZE  TABLE vendor_payments";
	}


if($into_table=="exp_rev_fyear")
	{// exp_rev_down intermediate table
	 echo "$one entered.<br><br>Click 
	 <a href='cleanup_scripts/completeParseREV-EXP.php?s=1'>here</a> to parse and clean raw records";
	}

if($into_table=="pcard_xtnd"||$into_table=="xtnd_ci_monthly")
	{
	session_start();
	$fy=$_SESSION[budget][statusFY];
	if($_SESSION[budget][step]=="A1a"){$_SESSION[budget][statusA1a]="x";}
	if($_SESSION[budget][step]=="A1b"){$_SESSION[budget][statusA1b]="x";}
	if($_SESSION[budget][step]=="A3"){$_SESSION[budget][statusA3]="x";}
	header("Location: /budget/accounting/project_account.php?fy=$fy");
	}

    if ($unlink_local_textfile) {
        unlink($textfile);
    }
    
exit;
}


/**
 * The form used to define the query hasn't been yet submitted -> loads it
 */
else {
    require('./ldi_table.php');
}

    function PMA_backquote($a_name, $do_it = TRUE)
    {
        if ($do_it
            && !empty($a_name) && $a_name != '*') {

            if (is_array($a_name)) {
                 $result = array();
                 foreach($a_name AS $key => $val) {
                     $result[$key] = '`' . $val . '`';
                 }
                 return $result;
            } else {
                return '`' . $a_name . '`';
            }
        } else {
            return $a_name;
        }
    } // end of the 'PMA_backquote()' function
    
    function PMA_sqlAddslashes($a_string = '', $is_like = FALSE, $crlf = FALSE)
    {
        if ($is_like) {
            $a_string = str_replace('\\', '\\\\\\\\', $a_string);
        } else {
            $a_string = str_replace('\\', '\\\\', $a_string);
        }

        if ($crlf) {
            $a_string = str_replace("\n", '\n', $a_string);
            $a_string = str_replace("\r", '\r', $a_string);
            $a_string = str_replace("\t", '\t', $a_string);
        }

        $a_string = str_replace('\'', '\\\'', $a_string);

        return $a_string;
    } // end of the 'PMA_sqlAddslashes()' function
	
	
	
?>
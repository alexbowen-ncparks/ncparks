<?php
//  Tom Howard - This was shamelessly borrowed from the phpmyadmin file: ldi_check.php
//Greatly simplified.
extract($_REQUEST);
include("menu.php");// database connection parameters

//First make a copy of existing table
include("../../include/connectBUDGET.inc");// database connection parameters

$yesterday=date("ymd",mktime(0,0,0,date("m"),date("d")-1,date("y")));

// ************** Tables ********************
// partf_fund_trans, cip_fund_bal, partf_payments, pcard

// Make daily backup if it doesn't already exist
$newName=$budget_table."_".$yesterday;
$sql="ALTER  TABLE `$budget_table`   RENAME `$newName`  ";
$result = mysqli_query($connection, $sql) or die ("Couldn't execute query. $sql<br>TABLE $budget_table may have already been created.");


/**
 * This file checks and builds the sql-string for
 * LOAD DATA INFILE 'file_name.txt' [REPLACE | IGNORE] INTO TABLE table_name
 *    [FIELDS
 *        [TERMINATED BY '\t']
 *        [OPTIONALLY] ENCLOSED BY "]
 *        [ESCAPED BY '\\' ]]
 *    [LINES TERMINATED BY '\n']
 *    [(column_name,...)]
 */


/**
 * Gets some core scripts
 */
 
//echo "Test2 $textfile";exit;//works to here

require_once('./libraries/grab_globals.lib.php');// this works
//require_once('./libraries/common.lib.php');

//echo "Test3 t=$textfile l=$local_textfile";exit;//for testing only

// Check parameters

// Disabled by teh
//PMA_checkParameters(array('db', 'table'));

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
    $textfile = $DOCUMENT_ROOT . dirname($PHP_SELF) . '/' . preg_replace('@^./@s', '', $cfg['UploadDir']) . preg_replace('@\.\.*@', '.', $local_textfile);

//echo "Test4 $textfile";exit;//for testing only

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

/**
 * The form used to define the query has been submitted -> do the work
 */
if (isset($btnLDI) && empty($textfile)) {
    $js_to_run = 'functions.js';
    require_once('./header.inc.php');
    $message = $strMustSelectFile;
    require('./ldi_table.php');
} elseif (isset($btnLDI) && ($textfile != 'none')) {
    if (!isset($replace)) {
        $replace = '';
    }

//echo "Test5 $textfile";exit;//for testing only

    // the error message does not correspond exactly to the error...
    if (!@chmod($textfile, 0644)) {
       echo $strFileCouldNotBeRead . ' ' . $textfile . '<br />';
       require_once('./footer.inc.php');
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
    $sql_query     .= ' INTO TABLE ' . PMA_backquote($into_table);
    if (isset($field_terminater)) {
        $sql_query .= ' FIELDS TERMINATED BY \'' . $field_terminater . '\'';
    }
   
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
    
 // echo "$sql_query";exit;// for testing

$result = mysqli_query($connection, $sql_query);
$num=mysql_info();
list($one,$two)=explode(" D",$num);
    echo "$one entered.";
    
if($budget_table=="all_trans"){echo "<br><br>Click <a href='parseAcct.php'>link</a> to cleanup the imported data. This will take some seconds.
<BR><BR>
1. All non-transactional records are being deleted.<br>
2. The Account number is being parsed from the appropriate header row AND entered for all associated records. (This takes the most time.)<br>
3. Remaining header records are being deleted.<br>
4. Old table is being dropped and new table created from temporary database.<br>
5. Indices are being created for Center and Account.";
}

if($budget_table=="partf_payments"){
include("cleanPARTFpayments.php");
echo "<br><br>Imported records have been cleaned:
<BR><BR>
1. Records are trimmed to remove leading and trailing spaces.<br>
2. A new database friendly date is created and inserted into the \"datenew\" field which will be used in all date related queries.
3. For records with a blank value for the \"charg_proj_num\" the value of \"na\" is inserted.
4. Deletes any record that was a header row in original text file
5. Removes any "+" in fund or center resulting from any unwanted conversion to  scientific notation, e.g., 4E+52";
}

if($budget_table=="cip_fund_bal"){echo "<br><br>Click <a href='clean_cip_fund_balance.php'>link</a> to cleanup the imported data.
<BR><BR>
1. Any blank records are deleted.<br>
2. A new database friendly date is created and inserted into the \"datenew\" field which will be used in all date related queries.<br>
3. Any header records left over from Excel deleted.";
}

if($budget_table=="pcard"){
include("cleanup_scripts/completeParsePcard.php");
echo "<br><br>Imported records have been parsed and cleaned:
<BR><BR>
1. Delete ALL records where payst is blank.<br>
2. Delete ALL records where vendor is VENDOR or NAME.
3. Delete ALL records where postdate is blank.
4. Delete ALL records where amt = 0.00
5. Update records by completing any blank lastname field
6. Update records by completing blank vendor.
7. OPTIMIZE  TABLE pcard";
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

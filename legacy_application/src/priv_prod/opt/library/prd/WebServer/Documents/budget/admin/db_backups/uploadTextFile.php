<?php
//  Tom Howard - This was shamelessly borrowed from the phpmyadmin file: ldi_check.php
//Greatly simplified and customized
extract($_POST);
//include("menu.php");

//First make a copy of existing table
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database

require_once('../../libraries/grab_globals.lib.php');// this works
//require_once('./libraries/common.lib.php');

//echo "Test3 t=$textfile l=$local_textfile";exit;//for testing only

// Check parameters

// Disabled by teh
//PMA_checkParameters(array('db', 'table'));

// functions in the require_once grab_globals resets this var
// we need to re-reset
//$into_table=$db;

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
if (isset($btnLDI) && empty($textfile)) {
    $js_to_run = 'functions.js';
    require_once('../../header.inc.php');
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
       require_once('../../footer.inc.php');
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
    
//echo "Test2 Into_Table $into_table";exit;//check table

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
$database="budget";
$db="budget";
include("/opt/library/prd/WebServer/include/iConnect.inc"); // connection parameters
mysqli_select_db($connection, $database); // database
$result = mysqli_query($connection, $sql_query) or die ("Couldn't execute query. $sql_query");;
$num=mysql_info();
list($one,$two)=explode(" D",$num);
   // echo "$one entered.";
    



if($into_table=="exp_rev_fyear"){// exp_rev_down intermediate table
 echo "$one entered.<br><br>Click  to parse and clean raw records";
}

if($into_table=="pcard_xtnd"||$into_table=="xtnd_ci_monthly"){
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

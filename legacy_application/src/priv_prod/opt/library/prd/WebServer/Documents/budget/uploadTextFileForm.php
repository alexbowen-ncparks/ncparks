<?php
//  Tom Howard - This was shamelessly borrowed from the phpmyadmin file: ldi_table.php
//Greatly simplified.
extract($_REQUEST);
//echo"Hello";exit;

if($db=="pcard_xtnd"||$db=="xtnd_ci_monthly")
	{
	session_start();
	$_SESSION['budget']['step']=$s;
	}

	
echo "<html><body>
<form action='uploadTextFile.php' method='post' enctype='multipart/form-data'>
    <table cellpadding='5' border='2'>
    <tr><td>Location of the textfile</td>
        <td colspan='2'><input type='file' name='textfile' />&nbsp;
        (Max: 30,720KB)    <input type='hidden' name='MAX_FILE_SIZE' value='31457280' /> </td> </tr>

    <tr> <td>Fields terminated by</td>";
if(@$sep=="c"){$selC="checked";$selT="";}else{$selT="checked";$selC="";}
echo "<td><input type='radio' name='field_terminater' value='\\t' $selT>Tab ";
echo "<input type='radio' name='field_terminater' value=',' $selC> Comma</td>";

echo "<td>The terminator of the fields. \\t = tab  or , = comma</td></tr>";

    
echo " <tr><td>Fields enclosed by</td>
            <td><input type=\"text\" name=\"enclosed\" size=\"1\" maxlength=\"1\" value=\"\" /></td></tr>";


echo "<tr><td>Lines terminated by</td>";
//<td><input type='text' name='line_terminator' size='8' value='\\r\\n' /></td>
echo "
<td><input type='text' name='line_terminator' size='8' value='\\r\\n' /></td>
        <td>Carriage return: \\r<br />Linefeed: \\n</td>
    </tr>
    
    <tr><td>LOAD method        </td>
        <td>
            <input type='radio' id='radio_local_option_0' name='local_option' value='0' checked='checked' /><label for='radio_local_option_0'>...DATA</label><br />
            <input type='radio' id='radio_local_option_1' name='local_option' value='1'  /><label for='radio_local_option_1'>...DATA LOCAL</label>
        </td>
        <td>The best method is checked by default, but you can change if it fails.        </td>
    </tr>
    <tr>
        <td colspan='3' align='center'>
            <input type='hidden' name='lang' value='en-iso-8859-1' />
<input type='hidden' name='server' value='1' />
<input type='hidden' name='db' value='budget' />
<input type='hidden' name='table' value='wholetemp' />
            <input type='hidden' name='zero_rows' value='The content of your file has been inserted.' />
            <input type='hidden' name='goto' value='tbl_properties.php' />
            <input type='hidden' name='back' value='ldi_table.php' />
            <input type='hidden' name='into_table' value='$db' />
            <input type='submit' name='btnLDI' value='Submit' />&nbsp;&nbsp;
            <input type='reset' value='Reset' /></table></form></body></html>";
?>
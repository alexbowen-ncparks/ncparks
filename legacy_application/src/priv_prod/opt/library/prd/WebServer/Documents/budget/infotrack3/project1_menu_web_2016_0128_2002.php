<?php
echo "hello world<br />";
echo "<div class='column1of4'>";
include ("report_header3.php");




if($comment=='')
{

if($folder=='community')
{
$query4="select project_note,weblink,embed_address,note_group,project_note_id,status from infotrack_projects_community4
         where 1 
         and project_category='$project_category'
		 and project_name='$project_name'
		 and note_group='$note_group'
		 and comment_id=''
         order by project_note_id desc";

//echo $query4;		 
$result4 = mysql_query($query4) or die ("Couldn't execute query 4.  $query4");
$num4=mysql_num_rows($result4);
echo "query4=$query4"; //exit;


}


if($add_record=='y' and $note_group=='web')
{
if($level=='5')
{
echo "<table>";
echo "<tr>";
echo "<th><font color='brown'>Title</font></th><th><font color='brown'>Page Address</font></th><th><font color='brown'>Embed Address</font></th>";
echo "</tr>";

//echo "<td></td>";
echo "<form method=post action=article_add2.php>";
echo "<tr>";
echo "<td><textarea name= 'project_note' rows='8' cols='20' ></textarea></td>            
      <td><textarea name= 'web_address' rows='8' cols='20'></textarea></td>";
      echo "<td><textarea name= 'embed_address' rows='8' cols='20'></textarea></td>";
	  if($folder=='personal'){echo "<td><input type=submit name=submit value=Add_WebPage></td>";}
	  if($folder=='community'){echo "<td><input type=submit name=submit value=Add_WebPage></td>";}
echo "</tr>";	  
	  echo "<input type='hidden' name='project_category' value='$project_category'>";	   
	 echo "<input type='hidden' name='project_name' value='$project_name'>";	   
	 echo "<input type='hidden' name='note_group' value='$note_group'>";	   
	 echo "<input type='hidden' name='folder' value='$folder'>";	   
	 echo "</form>";

	 
echo "</table>";
}
//echo "<br />";
echo "<br />";
}
echo "<table border=1>";



while ($row4=mysql_fetch_array($result4)){

// The extract function automatically creates individual variables from the array $row
//These individual variables are the names of the fields queried from MySQL
extract($row4);
$countid=number_format($countid,0);
$rank=$rank+1;
$rank2="(".$rank.")";
//if($c==''){$t=" bgcolor='$table_bg2'";$c=1;}else{$t='';$c='';}
if($status=='ip'){$t=" bgcolor='pink' ";}
if($status=='fi'){$t=" bgcolor='lightgreen' ";}


echo 

"<tr$t>"; 
echo "<td>$rank2</td>";  

 
 
 echo "<td><a href='project1_menu.php?comment=y&add_comment=y&folder=$folder&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&project_note_id=$project_note_id' >
 <img height='50' width='50' src='icon_photos/share1.png' alt='share icon' title='Share on MamaJo'>";
 if($embed_address==''){echo "$project_note";}
 if($embed_address!=''){echo "$project_note<br />$embed_address" ;} 
 echo "</img></a></td>"; 
 
 

	          
echo "</tr>";

}

 echo "</table>";
 }

 
 
if($comment=='y') 

 {

if($show_order==''){$order2="order by project_note_id desc";}
if($show_order=='newest'){$order2="order by project_note_id desc";}
if($show_order=='oldest'){$order2="order by project_note_id asc";}


if($folder=='community')
{

$query4a="select project_note,weblink,embed_address from infotrack_projects_community4 where project_note_id='$project_note_id' ";

	 
$result4a = mysql_query($query4a) or die ("Couldn't execute query 4a.  $query4a");
$num4a=mysql_num_rows($result4a);

//echo "query4a=$query4a<br />";


}
$row4a=mysql_fetch_array($result4a);
extract($row4a);

//echo "embed_address=$embed_address";
echo "<table>";
echo "<tr>";
echo "<td>";

if($embed_address=='')
{echo "<br /><br /><font color='brown'> $project_note</font> <br /><iframe width='900' height='700' src='$weblink' frameborder='0' allowfullscreen></iframe>";
}

if($embed_address!=''){echo "<br /><br /><font color='brown'>$project_note</font><br />$embed_address" ;} 
//echo "</font></a></td>";
echo "</td>";


echo "</tr>";
echo "</table>";
echo "<br />";
echo "</div>";
echo "<div class='column2of4'>";
if($add_comment=='y')
{
?>
<script language="javascript" type="text/javascript">
//document.getElementById("myForm2").reset();
<!-- 
//Browser Support Code
function ajaxFunction(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		
		var ajaxDisplay = document.getElementById("ajaxDiv");
			ajaxDisplay.innerHTML = ajaxRequest.responseText;	
		
	}
    var comment_note2 = document.getElementById("comment_note2").value;
	var project_category = document.getElementById("project_category").value;
	var project_name = document.getElementById("project_name").value;
	var note_group = document.getElementById("note_group").value;
	var project_note_id = document.getElementById("project_note_id").value;

    var queryString1 = "?comment_note2=" + comment_note2 + "&project_category=" + project_category + "&project_name=" + project_name + "&note_group=" + note_group + "&project_note_id=" + project_note_id;
	
	ajaxRequest.open("GET", "ajax_example_output7.php" + queryString1 , true);
	ajaxRequest.send(null); 

}

function ajaxFunction2(){
	var ajaxRequest;  // The variable that makes Ajax possible!
	
	try{
		// Opera 8.0+, Firefox, Safari
		ajaxRequest = new XMLHttpRequest();
	} catch (e){
		// Internet Explorer Browsers
		try{
			ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
			try{
				ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e){
				// Something went wrong
				alert("Your browser broke!");
				return false;
			}
		}
	}
	// Create a function that will receive data sent from the server
	ajaxRequest.onreadystatechange = function(){
		
		var ajaxDisplay = document.getElementById("ajaxDiv");
			ajaxDisplay.innerHTML = ajaxRequest.responseText;	
		
	}
	var comment_note2 = document.getElementById("comment_note2").value;
	var project_category = document.getElementById("project_category").value;
	var project_name = document.getElementById("project_name").value;
	var note_group = document.getElementById("note_group").value;
	var project_note_id = document.getElementById("project_note_id").value;
	
	
	var queryString2 = "?comment_note2=" + comment_note2 + "&project_category=" + project_category + "&project_name=" + project_name + "&note_group=" + note_group + "&project_note_id=" + project_note_id;
	ajaxRequest.open("GET", "ajax_example_input8_add.php" + queryString2, true);
	ajaxRequest.send(null); 
	
	
		

}




<?php
if($im==''){$im='n';}
if($im=='y'){echo "setInterval(ajaxFunction,5000);";}
?>


</script>


<script>
function submitForm() {
   var frm = document.getElementsByName('myForm2')[0];
   frm.submit(); // Submit
   frm.reset();  // Reset
   return false; // Prevent page refresh
}

</script>



<?php

echo "Instant Messenger
<a href='project1_menu.php?comment=y&add_comment=y&folder=community&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&project_note_id=$project_note_id&im=y'><b>ON&nbsp;&nbsp;</b></a>

<a href='project1_menu.php?comment=y&add_comment=y&folder=community&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&project_note_id=$project_note_id&im=n'><b>OFF&nbsp;&nbsp;</b></a>
";


//echo "project_category=$project_category";
//echo "<form name='myForm2'>";
echo "<form name='myForm2'>";
//echo "Name: <input type='text' id='comment_note2' />"; 
echo "$myusername Comment: <textarea rows='6' cols='40' name='comment_note' id='comment_note2'></textarea>"; 


/*
echo "Project Category: <input type='text' id='project_category' value='$project_category' readonly  />"; 
*/
//echo "<input type=submit name=submit value=Add Record>";
echo "<input type='hidden' name='project_category' id='project_category' value='$project_category'>";	   
	 echo "<input type='hidden' name='project_name' id='project_name' value='$project_name'>";	   
//	 echo "<input type='hidden' name='project_note' value='$project_note'>";	   
	 //echo "<input type='hidden' name='weblink' value='$weblink'>";	   
	 echo "<input type='hidden' name='note_group' id='note_group' value='$note_group'>";	   
//	 echo "<input type='hidden' name='folder' value='$folder'>";	   
//	 echo "<input type='hidden' name='im' value='$im'>";	   
	 echo "<input type='hidden' name='project_note_id' id='project_note_id' value='$project_note_id'>";	
//echo "Name: <input type='hidden' id='project_category' />"; 
echo "<input type='button' onclick='ajaxFunction2()' value='Add Record' />";
//echo "<input type='button' onclick='submitForm()' value='Reset' />";
echo "<script>";

echo "</script>";
echo "</form>";

echo "<br />";
/*
echo "Instant Messenger
<a href='project1_menu.php?comment=y&add_comment=y&folder=community&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&project_note_id=$project_note_id&im=y'><b>ON&nbsp;&nbsp;</b></a>
*/
echo "<a href='project1_menu.php?comment=y&add_comment=y&folder=community&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&project_note_id=$project_note_id&im=n&edit=y'><b>EDIT Notes&nbsp;&nbsp;</b></a>
";



echo "<div id='ajaxDiv'></div>";
if($im=='n')
{


if($delrec != '')
{
$delete_rec="update infotrack_projects_community4 set valid_record='n' where project_note_id='$delrec' ";
$delete_rec_result = mysql_query($delete_rec) or die ("Couldn't execute query delete_rec.  $delete_rec ");


}

if($edit_record != '')
{
//echo "Please Save Me on line 320";
$update_rec="update infotrack_projects_community4 set comment_note='$comment_note' where project_note_id='$edit_record' ";
$update_rec_result = mysql_query($update_rec) or die ("Couldn't execute query update_rec.  $update_rec ");
}



$query = "select user,project_note,comment_note,weblink,note_group,project_note_id as 'project_note_id2',comment_status from infotrack_projects_community4 where 1 and project_category='$project_category' and project_name='$project_name' and note_group='$note_group' and comment_id='$project_note_id' and valid_record='y' order by project_note_id asc ";	

$qry_result = mysql_query($query) or die(mysql_error());

//echo "query=$query<br />";

if($edit=='')
{
$display_string = "<table>";

while($row = mysql_fetch_array($qry_result)){

$comment_note=str_replace('  ','&nbsp;&nbsp;',$row[comment_note]);
$comment_note=nl2br($comment_note);

if($table_bg2==''){$table_bg2='burlywood';}
    if($color==''){$bgc=" bgcolor='$table_bg2' ";$color=1;}else{$bgc='';$color='';}

	

	$display_string .= "<tr$bgc>";
	//$display_string .= "<td><font color='brown'>$row[user]</font></td>";
	//$display_string .= "<td><font color='brown'>$row[project_note_id2]</font></td>";
	$display_string .= "<td><font color='brown'>$row[user]</font><br />$comment_note</td>";
	$display_string .= "</tr>";
	
}
//echo "Query: " . $query . "<br />";
$display_string .= "</table>";
echo $display_string;
}


if($edit=='y')
{
$display_string = "<table>";

while($row = mysql_fetch_array($qry_result)){

$comment_note=str_replace('  ','&nbsp;&nbsp;',$row[comment_note]);
//$comment_note=nl2br($comment_note);

if($table_bg2==''){$table_bg2='burlywood';}
    if($color==''){$bgc=" bgcolor='$table_bg2' ";$color=1;}else{$bgc='';$color='';}
	/*
	$comment_status2=$row[$comment_status];
	if($comment_status2=='y'){$bgc=" bgcolor='lightgreen' ";}
	if($comment_status2=='n')
	*/
	//$comment_status3=$row[comment_status];
	//if($comment_status3=='y'){$bgc=" bgcolor='lightgreen'";}
	/*
	if($comment_status3=='n')
	{
    if($color==''){$bgc=" bgcolor='$table_bg2' ";$color=1;}else{$bgc='';$color='';}
	}
    */
	

	$display_string .= "<tr$bgc>";
	//$display_string .= "<td><font color='brown'>$row[user]</font></td>";
	//$display_string .= "<td><font color='brown'>$row[project_note_id2]</font></td>";
	
		
	$edit_record=$row[project_note_id2];
	$display_string .= "<td><a href='project1_menu.php?comment=y&add_comment=y&folder=community&project_category=$project_category&category_selected=y&project_name=$project_name&name_selected=y&note_group=$note_group&project_note_id=$project_note_id&im=n&edit=y&delrec=$edit_record'><img height='30' width='30' src='/budget/infotrack/icon_photos/mission_icon_photos_216.png' alt='picture of green check mark'></img></font></a></td>";
	$display_string .= "<form action='project1_menu.php' method='post'><td><textarea rows='24' cols='40' name='comment_note' >$comment_note</textarea><input type='hidden' name='comment' value='y'><input type='hidden' name='project_note_id' value='$project_note_id'><input type='hidden' name='add_comment' value='y'><input type='hidden' name='folder' value='community'><input type='hidden' name='project_category' value='$project_category'><input type='hidden' name='category_selected' value='y'><input type='hidden' name='project_name' value='$project_name'><input type='hidden' name='name_selected' value='y'><input type='hidden' name='note_group' value='$note_group'><input type='hidden' name='im' value='n'><input type='hidden' name='edit' value='y'></td>";
	$display_string .= "<td><input type='hidden' name='edit_record' value='$edit_record'><input type='submit' value='Save'</td></form>";
	$display_string .= "</tr>";
	
}
//echo "Query: " . $query . "<br />";
$display_string .= "</table>";
echo $display_string;
}



}

}
//echo "<br />";
echo "</div>";

 }
 ?>
 
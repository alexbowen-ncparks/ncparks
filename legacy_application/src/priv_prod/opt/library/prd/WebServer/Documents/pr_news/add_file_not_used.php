<?php$database="div_cor";include("../../include/iConnect.inc");// database connection parameterssession_start();$level=$_SESSION['div_cor']['level'];//print_r($_SESSION);//exit;extract($_REQUEST);if ($submit == "Add File") {extract($_FILES);$size = $_FILES['file_upload']['size'];$type = $_FILES['file_upload']['type'];$file = $_FILES['file_upload']['name'];$mapName = $file;$ext = substr(strrchr($file, "."), 1);// find file extention, png e.g.//print_r($_FILES); print_r($_REQUEST);exit;if(!is_uploaded_file($file_upload[tmp_name])){print_r($_FILES);  print_r($_REQUEST);exit;} $ext = explode("/",$type);$uploaddir = "file_upload/"; // make sure www has r/w permissions on this folder$file=str_replace(",","_",$file);$uploadfile = $uploaddir.$file;move_uploaded_file($file_upload[tmp_name],$uploadfile);// create file on server  $sql = "UPDATE corre set file_link=concat_ws(',',file_link,'$uploadfile') where id='$id'";//  echo "$sql";exit;$result = @mysqli_query($connection,$sql) or die("$sql Error 1#". mysqli_errno($connection) . ": " . mysqli_error($connection));    MYSQLI_CLOSE($connection);header("Location: display_item.php");exit;	}?>
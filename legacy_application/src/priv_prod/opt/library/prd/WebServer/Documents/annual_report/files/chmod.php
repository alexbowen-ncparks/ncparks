<?php// make sure directory crs has global read/write/*    $folder = "/Library/WebServer/Documents/travel/uploads";chmod($folder,0777);if (!file_exists($folder)) {echo "None";mkdir ($folder, 0777);}if (file_exists($folder)) {echo "Exists!";mkdir ($folder, 0777);}$uploadfile = $folder."/".$file;move_uploaded_file($map['tmp_name'],$uploadfile);// create file on server    chmod($uploadfile,0777);*/    ?>
<?php
$sql="SELECT t1.*, t2.upload_id, t2.file_name, t2.file_link, t4.upload_id as image_id, t4.image_link, t4.image_name, 
		group_concat(t3.item_comment,' [',t3.comment_tempID,']' SEPARATOR '*') as prog_comments, t5.upload_id as thumb_id, t5.thumb_link,t5.thumb_name
		from `item` as t1 
		left join item_upload_file as t2 on t1.item_id=t2.item_id
		left join item_upload_image as t4 on t1.item_id=t4.item_id
		left join item_upload_thumb as t5 on t1.item_id=t5.item_id
		left join `comments` as t3 on t1.item_id=t3.item_id
		where t1.item_id='$item_id'
		group by t2.upload_id, t4.upload_id
		"; // no need to group on thumb_id since we will only be showing a single thumb
//		echo "$sql<br />";
		$result = mysqli_query($connection,$sql);
			unset($upload_id_array, $file_name_array, $file_link_array, $upload_image_array, $image_name_array, $image_link_array, $upload_thumb_array, $thumb_name_array, $thumb_link_array, $comment_array);
			while($row=mysqli_fetch_assoc($result))
				{
				extract($row); //echo "<pre>"; print_r($row); echo "</pre>"; // exit;
				$upload_id_array[]=$upload_id;
			
				$file_name_array[]=$file_name;
				$file_link_array[]=$file_link;
			
				$upload_image_array[]=$image_id;
				$image_name_array[]=$image_name;
				$image_link_array[]=$image_link;
			
				$upload_thumb_array[]=$thumb_id;
				$thumb_name_array[]=$thumb_name;
				$thumb_link_array[]=$thumb_link;
			
				$comment_array[]=$prog_comments;
				}
?>
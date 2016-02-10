<?php 
require_once dirname(__DIR__)."/includes/db_instance.php";

$exercise    = json_decode(file_get_contents("php://input"));
$title       = $exercise->title;
$content     = $exercise->content;
$user_create = $exercise->user_create;
$cat_id      = (int)$exercise->cat_id;
$tags		 = $exercise->tags;

$db  = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {
	$db->autocommit(FALSE);
	$error_arr = array();
	$insert_id = 0;

	// insert into `exercise` table
	if ($sql_cmd = $db->prepare("INSERT INTO `exercise`(`title`, `content`, `cat_id`, `user_create`) VALUES (?, ?, ?, ?)")) {
		$sql_cmd->bind_param("ssis", $title, $content, $cat_id, $user_create);

		if ($sql_cmd->execute()) {
			$insert_id = (int)$sql_cmd->insert_id;
		} else {
			$error_arr[] = "Can not insert into `exercise`".$sql_cmd->error;
		}

		$sql_cmd->close();
	} else {
		$error_arr[] = "Can not prepare command [insert exercise]";
	}

	// insert into `exercise_detail` table
	if($sql_cmd = $db->prepare("INSERT INTO `exercise_detail`(`id`) VALUES (?)")) {		
		$sql_cmd->bind_param("i", $insert_id);

		if (!$sql_cmd->execute()) {
			$error_arr[] = "Can not execute [insert exercise_detail]";
		} 

		$sql_cmd->close();
	} else {
		$error_arr[] = "Can not prepare command [insert exercise_detail]";
	}

	foreach ($tags as $tag) {
		// printf("Id: %d<br>Name: %s<br>", $tag_id, $tag_name);
		if ($tag->id == 0) { // new tag
			if($sql_cmd = $db->prepare("INSERT INTO `tag`(`name`) VALUES (?)")) {				
				$sql_cmd->bind_param("s", $tag->name);
				if (!$sql_cmd->execute()) {
					$error_arr[] = "Can not execute [insert tag]".$sql_cmd->error;
				} else {
					$tag->id = (int)$sql_cmd->insert_id;
				}

				$sql_cmd->close();
			} else {
				$error_arr[] = "Can not prepare command [insert tag]";		
			}			
		} 

		// insert into `exercise_tag` table
		if($sql_cmd = $db->prepare("INSERT INTO `exercise_tag`(`ex_id`, `tag_id`) VALUES (?, ?)")) {				
			$sql_cmd->bind_param("ii", $insert_id, $tag->id);
			if (!$sql_cmd->execute()) {
				$error_arr[] = "Can not execute [insert exercise_tag]".$sql_cmd->error;
			} 

			$sql_cmd->close();
		} else {
			$error_arr[] = "Can not prepare command [insert exercise_tag]";		
		}	

	}

	if (count($error_arr) > 0) {
		$db->rollback();
		print_r($error_arr);
	} else {
		$db->commit();
		echo "success";
	}
}
?>
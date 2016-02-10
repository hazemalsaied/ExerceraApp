<?php 
require_once dirname(__DIR__)."/includes/db_instance.php";

$id          = 100;
$title       = "How to insert data into database 1";
$content     = "I use MySql server. I would like to insert an object into a table.";
$user_create = 1;
$cat_id      = 1;

$db  = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {
	$db->autocommit(FALSE);
	$error_arr = array();

	if ($sql_cmd = $db->prepare("INSERT INTO `exercise`(`id`, `title`, `content`, `user_create`, `cat_id`) VALUES (?, ?, ?, ?, ?)")) {
		$sql_cmd->bind_param("issii", $id, $title, $content, $user_create, $cat_id);

		if ($sql_cmd->execute()) {
			if($sql_cmd2 = $db->prepare("INSERT INTO `exercise_detail`(`id`) VALUES (?)")) {
				$id = (int)$sql_cmd->insert_id;
				$sql_cmd2->bind_param("i", $id);
				if (!$sql_cmd2->execute()) {
					$error_arr[] = $sql_cmd2->error;
				}
			}
		} else {
			$error_arr[] = $sql_cmd->error;
		}

		$sql_cmd->close();
	} else {
		$error_arr[] = "Can not prepare command";
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
<?php 
require_once dirname(__DIR__)."/includes/db_instance.php";

// $exercise = json_decode(file_get_contents("php://input"));
$id       = 10;

$db = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {
	$db->autocommit(FALSE);
	$error_arr = array();

	// Delete review
	if ($sql_cmd = $db->prepare("DELETE FROM `comment` WHERE `ex_id` = ?")) {
		$sql_cmd->bind_param("i", $id);
		if (!$sql_cmd->execute()) {
			$error_arr[] = $sql_cmd->error;
		}
		$sql_cmd->close();
	} else {
		$error_arr[] = "Can not prepare command for deleting comment";
	}

	// Delete report
	if ($sql_cmd = $db->prepare("DELETE FROM `report` WHERE `ex_id` = ?")) {
		$sql_cmd->bind_param("i", $id);
		if (!$sql_cmd->execute()) {
			$error_arr[] = $sql_cmd->error;
		}
		$sql_cmd->close();
	} else {
		$error_arr[] = "Can not prepare command for deleting report";		
	}

	// Delete solution
	if ($sql_cmd = $db->prepare("DELETE FROM `solution` WHERE `ex_id` = ?")) {
		$sql_cmd->bind_param("i", $id);
		if (!$sql_cmd->execute()) {
			$error_arr[] = $sql_cmd->error;
		}
		$sql_cmd->close();
	} else {
		$error_arr[] = "Can not prepare command for deleting solution";		
	}

	// Delete exercise_detail
	if ($sql_cmd = $db->prepare("DELETE FROM `exercise_detail` WHERE `id` = ?")) {
		$sql_cmd->bind_param("i", $id);
		if (!$sql_cmd->execute()) {
			$error_arr[] = $sql_cmd->error;
		}
		$sql_cmd->close();
	} else {
		$error_arr[] = "Can not prepare command for deleting exercise_detail";		
	}

	// Delete exercise	
	if ($sql_cmd = $db->prepare("DELETE FROM `exercise` WHERE `id` = ?")) {
		$sql_cmd->bind_param("i", $id);
		if (!$sql_cmd->execute()) {
			$error_arr[] = $sql_cmd->error;
		}
		$sql_cmd->close();
	} else {
		$error_arr[] = "Can not prepare command for deleting exercise";		
	}

	if (count($error_arr) > 0) {
		$db->rollback();
		print_r($error_arr);
	} else {
		$db->commit();
		echo "success";
	}

	$db->close();
}
?>
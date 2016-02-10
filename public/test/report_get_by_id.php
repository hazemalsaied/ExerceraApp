<?php
require_once dirname(__DIR__)."/includes/db_instance.php";

$id  = 5;

$db = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("SELECT `id`, `content`, `ex_id`, `user_create` FROM `report` WHERE id = ?")) {
		$sql_cmd->bind_param("i", $id);
		if ($sql_cmd->execute()) {		
			$sql_cmd->bind_result($id, $content, $ex_id, $user_create);
			$sql_cmd->fetch();

			$report                = array();
			$report["id"]          = $id;
			$report["content"]     = $content;
			$report["ex_id"]       = $ex_id;
			$report["user_create"] = $user_create;

			echo json_encode($report);
		} else {
			echo $sql_cmd->error;
		}

		$sql_cmd->close();
	}

	$db->close();
}
?>
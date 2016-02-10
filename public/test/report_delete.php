<?php
require_once dirname(__DIR__)."/includes/db_instance.php";

$id = 1;
$db = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("DELETE FROM `report` WHERE `ex_id` = ?")) {
		$sql_cmd->bind_param("i", $id);
		
		if ($sql_cmd->execute()) {
			echo ($sql_cmd->affected_rows > 0) ? "success" : "No row deleted";
		} else {
			echo $sql_cmd->error;
		}

		$sql_cmd->close();
	}

	$db->close();
}
?>
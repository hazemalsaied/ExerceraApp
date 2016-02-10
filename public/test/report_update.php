<?php
require_once dirname(__DIR__)."/includes/db_instance.php";

$content = "This is the updated report";
$id      = 6;
$db      = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("UPDATE `report` SET `content` = ? WHERE `id` = ?")) {
		$sql_cmd->bind_param("si", $content, $id);
		
		if ($sql_cmd->execute()) {
			echo ($sql_cmd->affected_rows == 1) ? "success" : "No report updated";
		} else {
			echo $sql_cmd->error;
		}

		$sql_cmd->close();
	}

	$db->close();
}
?>
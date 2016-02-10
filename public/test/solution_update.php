<?php
require_once dirname(__DIR__)."/includes/db_instance.php";

$id          = 4;
$content     = "The number you are looking for is: 1/3";
$is_approved = 1;

$db          = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connection error: %s", $db->connect_error);
} else {
	if ($sql_cmd = $db->prepare("UPDATE `solution` SET `content` = ?, `is_approved` = ? WHERE `id` = ?")) {
		$sql_cmd->bind_param("sii", $content, $is_approved, $id);

		if ($sql_cmd->execute()) {
			echo ($sql_cmd->affected_rows == 1) ? "success" : "Warning: No solution updated";
		} else {
			printf("Command execution failed: %s", $sql_cmd->error);
		}

		$sql_cmd->close();
	} else {
		echo 'Can not prepare the command';
	}

	$db->close();
}
?>
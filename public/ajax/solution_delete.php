<?php
require_once dirname(__DIR__)."/includes/db_instance.php";

$solution = json_decode(file_get_contents("php://input"));
$id       = (int)$solution->id;
$db       = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s", $db->connect_error);
} else {
	if ($sql_cmd = $db->prepare("DELETE FROM `solution` WHERE `id` = ?")) {
		$sql_cmd->bind_param("i", $id);

		if ($sql_cmd->execute()) {
			echo ($sql_cmd->affected_rows == 1) ? 'success' : 'No solution deleted';
		} else {
			printf("Command execution failed: %s", $sql_cmd->error);
		}

		$sql_cmd->close();
	} else {
		echo "Can not prepare the command";
	}

	$db->close();
}
?>
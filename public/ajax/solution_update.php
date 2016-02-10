<?php
require_once dirname(__DIR__)."/includes/db_instance.php";

$solution    = json_decode(file_get_contents("php://input"));
$id          = (int)$solution->id;
$content     =      $solution->content;
$is_approved = (int)$solution->is_approved;

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
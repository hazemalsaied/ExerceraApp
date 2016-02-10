<?php
require_once dirname(__DIR__)."/includes/db_instance.php";

$comment = json_decode(file_get_contents("php://input"));
$content = 		$comment->content;
$id      = (int)$comment->ex_id;
$db      = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("UPDATE `comment` SET `content` = ? WHERE `id` = ?")) {
		$sql_cmd->bind_param("si", $content, $id);
		
		if ($sql_cmd->execute()) {
			echo ($sql_cmd->affected_rows == 1) ? "success" : "No comment updated";
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
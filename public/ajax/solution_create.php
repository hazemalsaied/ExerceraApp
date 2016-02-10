<?php
require_once dirname(__DIR__)."/includes/db_instance.php";
require_once dirname(__DIR__)."/includes/utf8_utils.php";

$solution    = json_decode(file_get_contents("php://input"));
$content     = $solution->content;
$user_create = $solution->user_create;
$ex_id       = (int)$solution->ex_id;
$db          = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s", $db->connect_error);
} else {
	if ($sql_cmd = $db->prepare("INSERT INTO `solution` (`content`, `ex_id`, `user_create`) VALUES (?, ?, ?)")) {
		$sql_cmd->bind_param("sii", $content, $ex_id, $user_create);

		if ($sql_cmd->execute()) {
			// echo ($sql_cmd->affected_rows == 1) ? 'success' : 'No solution inserted';
			$solution = array();
			$solution["id"] = $sql_cmd->insert_id;
			$solution["content"] = $content;
			$solution["user_create"] = $user_create;
			echo json_encode(utf8ize($solution), JSON_PRETTY_PRINT);
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
<?php
require_once dirname(__DIR__)."/includes/db_instance.php";
require_once dirname(__DIR__)."/includes/utf8_utils.php";

$comment     = json_decode(file_get_contents("php://input"));
$content     = $comment->content;
$user_create = $comment->user_create;
$ex_id       = (int)$comment->ex_id;

$db = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("INSERT INTO `comment`(`content`, `ex_id`, `user_create`) VALUES (?, ?, ?)")) {
		$sql_cmd->bind_param("sii", $content, $ex_id, $user_create);
		
		if ($sql_cmd->execute()) {
			// echo ($sql_cmd->affected_rows == 1) ? "success" : "No comment inserted";
			$comment              = array();
			$comment["id"]        = $sql_cmd->insert_id;
			$comment["content"]   = $content;
			$comment["user_name"] = $user_create;
			echo json_encode(utf8ize($comment), JSON_PRETTY_PRINT);
		} else {
			echo $sql_cmd->error;
		}

		$sql_cmd->close();
	} else {
		echo "Can not prepare the command";
	}

	$db->close();
}
?>
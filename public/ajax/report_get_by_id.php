<?php
require_once dirname(__DIR__)."/includes/db_instance.php";
require_once dirname(__DIR__)."/includes/utf8_utils.php";

$r  = json_decode(file_get_contents("php://input"));
$id = (int)$r->id;
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

			echo json_encode(utf8ize($report), JSON_PRETTY_PRINT);
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
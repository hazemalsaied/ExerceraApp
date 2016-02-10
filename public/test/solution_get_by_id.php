<?php
require_once dirname(__DIR__)."/includes/db_instance.php";
require_once dirname(__DIR__)."/includes/utf8_utils.php";

$id = 8;
$db = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("SELECT `content`, `user_create` FROM `solution` WHERE `id` = ? LIMIT 20")) {
		$sql_cmd->bind_param("i", $id);
		if ($sql_cmd->execute()) {		
			$sql_cmd->bind_result($content, $user_id);
			$solution = array();

		    while ($sql_cmd->fetch()) {		
				$solution["id"]      = $id;
				$solution["content"] = $content;
				$solution["user_id"] = $user_id;
		    }

			echo json_encode(utf8ize($solution));
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
<?php
require_once dirname(__DIR__)."/includes/db_instance.php";

$ex_id    = 1;
$db       = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("SELECT `id`, `content`, `user_create` FROM `solution` WHERE ex_id = ? LIMIT 20")) {
		$sql_cmd->bind_param("i", $ex_id);
		if ($sql_cmd->execute()) {		
			$sql_cmd->bind_result($id, $content, $user_id);
			$solutions = array();	

		    while ($sql_cmd->fetch()) {
				$solution            = array();
				$solution["id"]      = $id;
				$solution["content"] = $content;
				$solution["user_id"] = $user_id;
				$solutions[]         = $solution;
		    }

			echo json_encode($solutions);
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
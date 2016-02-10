<?php
require_once dirname(__DIR__)."/includes/db_instance.php";

$report      = json_decode(file_get_contents("php://input"));
$content     = $report->content;
$user_create = $report->user_create;
$ex_id       = (int)$report->ex_id;

$db = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("INSERT INTO `report`(`content`, `ex_id`, `user_create`) VALUES (?, ?, ?)")) {
		$sql_cmd->bind_param("sii", $content, $ex_id, $user_create);
		
		if ($sql_cmd->execute()) {
			echo ($sql_cmd->affected_rows == 1) ? "success" : "No row inserted";
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
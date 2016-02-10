<?php
require_once dirname(__DIR__)."/includes/db_instance.php";

$report  = json_decode(file_get_contents("php://input"));
$content = "This is not a good exercise";
$user_id = 1;
$ex_id   = 1;

$db = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("INSERT INTO `report`(`content`, `user_create`, `ex_id`) VALUES (?, ?, ?)")) {
		$sql_cmd->bind_param("sii", $content, $user_id, $ex_id);
		
		if ($sql_cmd->execute()) {
			echo ($sql_cmd->affected_rows == 1) ? "success" : "No row inserted";
		} else {
			echo $sql_cmd->error;
		}

		$sql_cmd->close();
	}

	$db->close();
}
?>
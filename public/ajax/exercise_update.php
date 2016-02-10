<?php 
require_once dirname(__DIR__)."/includes/db_instance.php";

$exercise = json_decode(file_get_contents("php://input"));
$id       = (int)$exercise->id;
$title    = $exercise->title;
$content  = $exercise->content;

$db = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("DELETE FROM `exercise` WHERE `id` = ?")) {
		$sql_cmd->bind_param("i", $id);

		if ($sql_cmd->execute()) {
			echo "success";
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
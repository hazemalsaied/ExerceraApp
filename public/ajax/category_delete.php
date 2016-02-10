<?php 
require_once dirname(__DIR__)."/includes/db_instance.php";

$category = json_decode(file_get_contents("php://input"));
$id       = $category->id;

$db = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("DELETE FROM `category` WHERE `id` = ?")) {
		$sql_cmd->bind_param("i", $id);

		if ($sql_cmd->execute()) {
			echo ($sql_cmd->affected_rows == 1) ? "success" : "No category deleted";
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
<?php 
require_once dirname(__DIR__)."/includes/db_instance.php";

echo "Delete category test<br>";
$id = 100;
$db = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("DELETE FROM `category` WHERE `id` = ?")) {
		$sql_cmd->bind_param("i", $id);

		if ($sql_cmd->execute()) {
			if ($sql_cmd->affected_rows == 1) 
				echo "Result: succeeded";
			else echo "Result: failed";
		} else {
			echo $sql_cmd->error;
		}

		$sql_cmd->close();
	}
	$db->close();
}
?>
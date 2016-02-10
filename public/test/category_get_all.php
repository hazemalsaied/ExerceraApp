<?php 
require_once dirname(__DIR__)."/includes/db_instance.php";

$db = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("SELECT `id`, `name` FROM `category` LIMIT 20")) {

		if ($sql_cmd->execute()) {
			$categories = array();			
			$sql_cmd->bind_result($id, $name);

		    while ($sql_cmd->fetch()) {
		        $categories[$id] = $name;
		    }

			echo json_encode($categories);
		} else {
			echo $sql_cmd->error;
		}

		$sql_cmd->close();
	}

	$db->close();
}
?>
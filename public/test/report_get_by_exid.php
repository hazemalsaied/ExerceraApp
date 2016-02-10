<?php
require_once dirname(__DIR__)."/includes/db_instance.php";

$ex_id = 1;
$db = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("SELECT `id`, `content` FROM `report` WHERE ex_id = ? LIMIT 20")) {
		$sql_cmd->bind_param("i", $ex_id);
		if ($sql_cmd->execute()) {
			$reports = array();			
			$sql_cmd->bind_result($id, $content);

		    while ($sql_cmd->fetch()) {
		        $reports[$id] = $content;
		    }

			echo json_encode($reports);
		} else {
			echo $sql_cmd->error;
		}

		$sql_cmd->close();
	}

	$db->close();
}
?>
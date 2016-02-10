<?php
require_once dirname(__DIR__)."/includes/db_instance.php";
require_once dirname(__DIR__)."/includes/utf8_utils.php";

$t   = json_decode(file_get_contents("php://input"));
$key = $t->key;
$key = "%{$key}%";
$db  = DbInstance::getInstance();

$tags = array();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("SELECT `id`, `name` FROM `tag` WHERE `name` LIKE ? LIMIT 5")) {
		$sql_cmd->bind_param("s", $key);
		if ($sql_cmd->execute()) {		
			$sql_cmd->bind_result($id, $name);

		    while ($sql_cmd->fetch()) {	
		    	$tag = array();	
				$tag["id"]   = $id;
				$tag["name"] = $name;
				$tags[]      = $tag;
		    }
		} else {
			printf("Command execution failed: %s", $sql_cmd->error);
		}

		$sql_cmd->close();
	} else {
		echo "Can not prepare the command get like";
	}

	echo json_encode(utf8ize($tags), JSON_PRETTY_PRINT);

	$db->close();
}
?>
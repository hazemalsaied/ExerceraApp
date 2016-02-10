<?php 
require_once dirname(__DIR__)."/includes/db_instance.php";
require_once dirname(__DIR__)."/includes/utf8_utils.php";

$db = DbInstance::getInstance();

$categories = array();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("SELECT `id`, `name` FROM `category` LIMIT 20")) {
		
		if ($sql_cmd->execute()) {
			$categories = array();			
			$sql_cmd->bind_result($id, $name);

		    while ($sql_cmd->fetch()) {
		    	$category = array();
		    	$category["id"] = $id;
		    	$category["name"] = $name;
		        $categories[] = $category;
		    }

			echo json_encode(utf8ize($categories), JSON_PRETTY_PRINT);
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
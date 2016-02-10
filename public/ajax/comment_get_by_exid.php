<?php
require_once dirname(__DIR__)."/includes/db_instance.php";
require_once dirname(__DIR__)."/includes/utf8_utils.php";

$comment = json_decode(file_get_contents("php://input"));
$ex_id  = (int)$comment->ex_id;

$db = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("SELECT `id`, `content` FROM `comment` WHERE ex_id = ? LIMIT 20")) {
		$sql_cmd->bind_param("i", $ex_id);
		if ($sql_cmd->execute()) {
			$comments = array();			
			$sql_cmd->bind_result($id, $content);

		    while ($sql_cmd->fetch()) {
		        $comments[$id] = $content;
		    }

			echo json_encode(utf8ize($comments), JSON_PRETTY_PRINT);
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
<?php
require_once dirname(__DIR__)."/includes/db_instance.php";
header('Content-Type: text/html;charset=utf-8');

function utf8ize($mixed) {
    if (is_array($mixed)) {
        foreach ($mixed as $key => $value) {
            $mixed[$key] = utf8ize($value);
        }
    } else if (is_string ($mixed)) {
        return utf8_encode($mixed);
    }
    return $mixed;
}

$user_id  = 2;
$db       = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("SELECT `id`, `content`, `ex_id` FROM `solution` WHERE `user_create` = ? LIMIT 20")) {
		$sql_cmd->bind_param("i", $user_id);
		if ($sql_cmd->execute()) {		
			$sql_cmd->bind_result($id, $content, $ex_id);
			$solutions = array();	

		    while ($sql_cmd->fetch()) {		        
				$solution            = array();
				$solution["id"]      = $id;
				$solution["content"] = $content;
				$solution["ex_id"]   = $ex_id;
				$solutions[]         = $solution;
		    }

		    // print_r($solutions);
			echo json_encode(utf8ize($solutions));
		} else {
			printf("Command execution failed: %s", $sql_cmd->error);
		}

		$sql_cmd->close();
	} else {
		echo "Can not prepare the command";
	}


	// $db->close();
}
?>
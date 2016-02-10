<?php
require_once dirname(__DIR__)."/includes/db_instance.php";
require_once dirname(__DIR__)."/includes/utf8_utils.php";

$cat_id = 1;

$db = DbInstance::getInstance();

$exercises = array();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("SELECT e.`id`, e.`title`, e.`content`, 
										e.`user_create`, e.`created_time`, 
										ed.`rating`, ed.`difficulty`, ed.`view_count`,
										c.`name`
								FROM `exercise` e 
								INNER JOIN
									`exercise_detail` ed ON e.`id` = ed.`id`
								INNER JOIN
									`category` c ON e.`cat_id` = c.`id`
								WHERE `cat_id` = ? LIMIT 10;")) {
		$sql_cmd->bind_param("i", $cat_id);
		if ($sql_cmd->execute()) {		
			$sql_cmd->bind_result($id, $title, $content, $user_name, $created_time, 
									$rating, $difficulty, $view_count, $cat_name);			

		    while ($sql_cmd->fetch()) {		        
				$exercise                 = array();
				$exercise["id"]           = $id;
				$exercise["title"]        = $title;
				$exercise["content"]      = $content;
				$exercise["user_name"]    = $user_name;
				$exercise["created_time"] = $created_time;
				$exercise["rating"]       = $rating;
				$exercise["difficulty"]   = $difficulty;
				$exercise["view_count"]   = $view_count;
				$exercise["cat_name"]	  = $cat_name;
				$exercises[]              = $exercise;
		    }

		} else {
			printf("Command execution failed: %s", $sql_cmd->error);
		}

		$sql_cmd->close();
	} else {
		echo "Can not prepare the command [get by catid]";
	}

	for ($i = 0; $i < count($exercises); $i++) {
		$ex_id = $exercises[$i]["id"];
		$exercises[$i]["tag"] = get_tag((int)$ex_id, $db);
	}

	$json = json_encode(utf8ize($exercises), JSON_PRETTY_PRINT);
	printf("<pre>%s</pre>", $json);

	$db->close();
}

function get_tag($id, $db) {
	$tags = array();

	if ($sql_cmd = $db->prepare("SELECT DISTINCT (t.`id`), t.`name`
								 FROM `tag` t
								 INNER JOIN `exercise_tag` et ON et.`tag_id` = t.`id`
								 WHERE et.`ex_id` = ?")) {
		$sql_cmd->bind_param("i", $id);

		if ($sql_cmd->execute()) {		
			$sql_cmd->bind_result($tag_id, $name);			

		    while ($sql_cmd->fetch()) {	
				$tag         = array();
				$tag["id"]   = $id;
				$tag["name"] = $name;
				$tags[]      = $tag;
		    }
		} else {
			printf("Command execution failed: %s", $sql_cmd->error);
		}

		$sql_cmd->close();
	} else {
		echo "Can not prepare the command [get tag]<br>";
		printf("Error detail: %s<br>", $db->error);
	}
	
	return $tags;
}
?>
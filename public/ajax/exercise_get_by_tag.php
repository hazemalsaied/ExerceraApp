<?php
require_once dirname(__DIR__)."/includes/db_instance.php";
require_once dirname(__DIR__)."/includes/utf8_utils.php";

$ex = json_decode(file_get_contents("php://input"));
$ex_tag   = $ex->tag;

$db = DbInstance::getInstance();		        
$exercises = array();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {

	// Get list of exercise ids according to tag name
	$ex_ids = array();
	if ($sql_cmd = $db->prepare("SELECT DISTINCT e.`id`
								FROM `tag` t
								INNER JOIN `exercise_tag` et ON et.`tag_id` = t.`id`
								INNER JOIN `exercise` e ON e.`id` = et.`ex_id`
								WHERE t.`name` = ?
								LIMIT 10;")) {
		$sql_cmd->bind_param("s", $ex_tag);
		if ($sql_cmd->execute()) {		
			$sql_cmd->bind_result($id);
		    while ($sql_cmd->fetch()) {	
				$ex_ids[] = $id;
			}
		 
		} else {
			printf("Command execution failed: %s", $sql_cmd->error);
		}

		$sql_cmd->close();
	} else {
		echo "Can not prepare the command [get list of exercise ids]";
	}
	$ex_ids = "(".implode(",", $ex_ids).")";

	// Get exercise detail
	if ($sql_cmd = $db->prepare("SELECT e.`id`, e.`title`, e.`content`, 
										e.`user_create`, e.`created_time`, 
										ed.`rating`, ed.`difficulty`, ed.`view_count`,
										c.`name`
								FROM `exercise` e 
								INNER JOIN
									`exercise_detail` ed ON e.`id` = ed.`id`
								INNER JOIN
									`category` c ON e.`cat_id` = c.`id`
								WHERE e.`id` IN {$ex_ids}
								ORDER BY ed.`view_count`
								LIMIT 10;")) {
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
		echo "Can not prepare the command [get exercise detail]";
	}

	for ($i = 0; $i < count($exercises); $i++) {
		$ex_id = $exercises[$i]["id"];
		$exercises[$i]["tag"] = get_tag((int)$ex_id, $db);
	}

	echo json_encode(utf8ize($exercises), JSON_PRETTY_PRINT);
	
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
				$tag["id"]   = $tag_id;
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
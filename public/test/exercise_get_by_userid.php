<?php
require_once dirname(__DIR__)."/includes/db_instance.php";
require_once dirname(__DIR__)."/includes/utf8_utils.php";

// $exercise = json_decode(file_get_contents("php://input"));
$user = '1';//(int)$exercise->id;

$db = DbInstance::getInstance();

get_by_user($user, $db);

function get_by_user($user, $db) {
	$exercises                  = array();
	$exercises["data"]          = '';
	$exercises["status"]        = 'failed';
	$exercises["error_message"] = '';

	if ($db->connect_errno) {
		$exercises["status"] = 'failed';
		$exercises["error_message"] = $db->connect_error;
	} else {
		if ($sql_cmd = $db->prepare("SELECT DISTINCT(e.`id`), e.`title`, e.`content`,
											e.`user_create`, e.`created_time`,
											ed.`rating`, ed.`difficulty`, ed.`view_count`,
											c.`name`
									 FROM `exercise` e
									 INNER JOIN `exercise_detail` ed ON ed.`id` = e.`id`
									 INNER JOIN `category` c ON c.`id` = e.`cat_id`
									 WHERE e.`user_create` = ?
									 ORDER BY ed.`view_count`
									 LIMIT 10")) {
			$sql_cmd->bind_param("s", $user);
			if ($sql_cmd->execute()) {
				$sql_cmd->bind_result($id, $title, $content, 
										$user_create, $created_time,
										$rating, $difficulty, $view_count, $cat_name);
				while ($sql_cmd->fetch()) {
					$exercise                 = array();
					$exercise["id"]           = $id;
					$exercise["title"]        = $title;
					$exercise["content"]      = $content;
					$exercise["user_create"]  = $user_create;
					$exercise["created_time"] = $created_time;
					$exercise["rating"]       = $rating;
					$exercise["difficulty"]   = $difficulty;
					$exercise["view_count"]   = $view_count;
					$exercise["cat_name"]     = $cat_name;
					$exercises["data"][]      = $exercise;
				}
			} else {
				$exercises["status"] = 'failed';
				$exercises["error_message"] = $sql_cmd->error;
			}

			$sql_cmd->close();
		} else {
			$exercises["status"] = 'failed';
			$exercises["error_message"] = $db->error;
		}

		get_tag($exercises, $db);
		$exercises["status"] = ($exercises["error_message"] == '')
								? 'success' : 'failed';

		echo json_encode(utf8ize($exercises['data']), JSON_PRETTY_PRINT);
		// printf("<pre>%s</pre>", $json);

		$db->close();
	}	
}

function get_tag(& $exercises, $db) {
	for ($i = 0; $i < count($exercises); $i++) {
		$ex_id = $exercises["data"][$i]["id"];
		
		$tags = array();

		if ($sql_cmd = $db->prepare("SELECT DISTINCT (t.`id`), t.`name`
									 FROM `tag` t
									 INNER JOIN `exercise_tag` et ON et.`tag_id` = t.`id`
									 WHERE et.`ex_id` = ?")) {
			$sql_cmd->bind_param("i", $ex_id);

			if ($sql_cmd->execute()) {		
				$sql_cmd->bind_result($tag_id, $name);			

			    while ($sql_cmd->fetch()) {	
					$tag         = array();
					$tag["id"]   = $tag_id;
					$tag["name"] = $name;
					$tags[]      = $tag;
			    }
			} else {
				$exercises["status"] = 'failed';
				$exercises["error_message"] = $sql_cmd->error;
			}

			$sql_cmd->close();
		} else {
			$exercises["status"] = 'failed';
			$exercises["error_message"] = $db->error;
		}

		$exercises["data"][$i]["tag"] = $tags;
	}
}
?>
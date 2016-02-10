<?php
require_once dirname(__DIR__)."/includes/db_instance.php";
require_once dirname(__DIR__)."/includes/utf8_utils.php";

$ex_id       = 2;

$db = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {		        
	$exercise = array();

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
								WHERE e.`id` = ?;")) {
		$sql_cmd->bind_param("i", $ex_id);
		if ($sql_cmd->execute()) {		
			$sql_cmd->bind_result($id, $title, $content, $user_name, $created_time, 
									$rating, $difficulty, $view_count, $cat_name);
			$exercises = array();	

		    while ($sql_cmd->fetch()) {	
				$exercise["id"]           = $id;
				$exercise["title"]        = $title;
				$exercise["content"]      = $content;
				$exercise["user_name"]    = $user_name;
				$exercise["created_time"] = $created_time;
				$exercise["rating"]       = $rating;
				$exercise["difficulty"]   = $difficulty;
				$exercise["view_count"]   = $view_count;
				$exercise["cat_name"]     = $cat_name;
		    }
		} else {
			printf("Command execution failed: %s", $sql_cmd->error);
		}

		$sql_cmd->close();
	} else {
		echo "Can not prepare the command [get exercise detail]";
	}

	// Get solutions
	if ($sql_cmd = $db->prepare("SELECT `id`, `content`, `is_approved`, `user_create`, `created_time`
								FROM `solution`
								WHERE `ex_id` = ?;")) {
		$sql_cmd->bind_param("i", $ex_id);
		if ($sql_cmd->execute()) {		
			$sql_cmd->bind_result($id, $content, $is_approved, $user_name, $created_time);
			$solutions = array();

		    while ($sql_cmd->fetch()) {	
				$solution                 = array();
				$solution["id"]           = $id;
				$solution["content"]      = $content;
				$solution["is_approved"]  = $is_approved;
				$solution["user_name"]    = $user_name;
				$solution["created_time"] = $created_time;
				$solutions[]              = $solution;
		    }

			$exercise["solutions"] = $solutions;
		} else {
			printf("Command execution failed: %s", $sql_cmd->error);
		}

		$sql_cmd->close();
	} else {
		echo "Can not prepare the command [get solution]";
	}

	// Get comments
	if ($sql_cmd = $db->prepare("SELECT `id`, `content`, `user_create`, `created_time`
								FROM `comment`
								WHERE `ex_id` = ?;")) {
		$sql_cmd->bind_param("i", $ex_id);
		if ($sql_cmd->execute()) {		
			$sql_cmd->bind_result($id, $content, $user_name, $created_time);
			$comments = array();

		    while ($sql_cmd->fetch()) {	
				$comment                 = array();
				$comment["id"]           = $id;
				$comment["content"]      = $content;
				$comment["is_approved"]  = $is_approved;
				$comment["user_name"]    = $user_name;
				$comment["created_time"] = $created_time;
				$comments[]              = $comment;
		    }

			$exercise["comments"] = $comments;
		} else {
			printf("Command execution failed: %s", $sql_cmd->error);
		}

		$sql_cmd->close();
	} else {
		echo "Can not prepare the command [get comment]";
	}

	// Get reports
	if ($sql_cmd = $db->prepare("SELECT `id`, `content`, `user_create`, `created_time`
								FROM `report`
								WHERE `ex_id` = ?;")) {
		$sql_cmd->bind_param("i", $ex_id);
		if ($sql_cmd->execute()) {		
			$sql_cmd->bind_result($id, $content, $user_name, $created_time);
			$reports = array();

		    while ($sql_cmd->fetch()) {	
				$report                 = array();
				$report["id"]           = $id;
				$report["content"]      = $content;
				$report["is_approved"]  = $is_approved;
				$report["user_name"]    = $user_name;
				$report["created_time"] = $created_time;
				$reports[]              = $report;
		    }

			$exercise["reports"] = $reports;
		} else {
			printf("Command execution failed: %s", $sql_cmd->error);
		}

		$sql_cmd->close();
	} else {
		echo "Can not prepare the command [get report]";
	}

	// Get tags
	if ($sql_cmd = $db->prepare("SELECT t.`id`, t.`name`
								FROM `tag` t
								INNER JOIN `exercise_tag` et ON et.`tag_id` = t.`id`
								WHERE et.`ex_id` = ?;")) {
		$sql_cmd->bind_param("i", $ex_id);
		if ($sql_cmd->execute()) {		
			$sql_cmd->bind_result($id, $name);
			$tags = array();

		    while ($sql_cmd->fetch()) {	
				$tag            = array();
				$tag["id"]      = $id;
				$tag["content"] = $name;
				$tags[]         = $tag;
		    }

			$exercise["tag"] = $tags;
		} else {
			printf("Command execution failed: %s", $sql_cmd->error);
		}

		$sql_cmd->close();
	} else {
		echo "Can not prepare the command [get solution]";
	}

	$json = json_encode(utf8ize($exercise), JSON_PRETTY_PRINT);
	printf("<pre>%s</pre>", $json);
	$db->close();
}
?>
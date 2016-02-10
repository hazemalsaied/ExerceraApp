<?php 
require_once dirname(__DIR__)."/includes/db_instance.php";

echo "Create new category test<br>";
echo "Create a category with id(100) name(Sample)<br>";
$id   = 100;
$name = "Sample";
$db   = DbInstance::getInstance();

if ($db->connect_errno) {
	printf("Connect failed: %s\n", $db->connect_error);
} else {	
	if ($sql_cmd = $db->prepare("INSERT INTO `category`(`id`, `name`) VALUES (?, ?)")) {
		$sql_cmd->bind_param("is", $id, $name);

		if ($sql_cmd->execute()) {
			if ($sql_cmd->insert_id == 100)
				echo "Result: succeeded";
			else
				echo "Result: failed";

		} else {
			echo $sql_cmd->error;
		}

		$sql_cmd->close();
	}

	$db->close();
}
?>
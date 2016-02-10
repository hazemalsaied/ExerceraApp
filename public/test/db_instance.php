<?php
require_once dirname(__DIR__)."/includes/db_instance.php";

$db = DbInstance::getInstance();

if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
} else {
	echo "Connection success";
	$db->close();
}
?>
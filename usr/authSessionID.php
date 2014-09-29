<?php include $_SERVER["DOCUMENT_ROOT"]."/lib/init.php";

if (!empty($_POST) && authUserSessionID($_POST["userID"], $_POST["sessionID"]))
	die("0");
die("1");

?>
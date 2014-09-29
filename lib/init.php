<?php
error_reporting(0);

ini_set("session.cookie_httponly", true);
session_start();
if (!isset($_SESSION["lastIP"]))
	$_SESSION["lastIP"] = $_SERVER["REMOTE_ADDR"];
if ($_SERVER["REMOTE_ADDR"] != $_SESSION["lastIP"]) {
	session_unset();
	session_destroy();
}

$root = $_SERVER["DOCUMENT_ROOT"];
require $root."/lib/utils.php";
require $root."/lib/dbConnect.php";
require $root."/lib/user.php";

if (userLoggedIn())
	$userInfo = getUserInfo($_SESSION["id"]);

ob_start();
?>
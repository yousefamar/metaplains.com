<?php

function home() {
	return "http://www.metaplains.com";
}

function sanitise($data) {
	if (get_magic_quotes_gpc())
		$data = stripslashes($data);
	return mysql_real_escape_string(htmlentities($data, ENT_COMPAT, "UTF-8"));
}

function encrypt($data, $salt = NULL) {
	$salt = is_null($salt)?bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM)):$salt;
	return $salt.hash("SHA256", $salt.$data);
}

function genUID() {
	return uniqid(rand(0, 9999).".", true);
}

function sendGenericEmail($to, $subject, $body) {
	mail($to, $subject, $body, "From: \"Metaplains Team\" <noreply@metaplains.com>");
}

function protectCurrentPage() {
	if (!userLoggedIn()) {
		header("Location: /protected.php");
		exit();
	}
}

function hideCurrentPageFromNonMembers() {
	if (!userLoggedIn()) {
		header("Location: /");
		exit();
	}
}

function hideCurrentPageFromMembers() {
	if (userLoggedIn()) {
		header("Location: /");
		exit();
	}
}

function displayError($msg) { //Because of the quotes.
	print "<script type='text/javascript'>alert('asdasda');</script>";
}

?>
<?php

function userExists($username) {
	$username = sanitise($username);
	return mysql_result(mysql_query("SELECT count(`id`) FROM `users` WHERE `username` = '$username'"), 0);
}

function emailExists($email) {
	$email = sanitise($email);
	return mysql_result(mysql_query("SELECT count(`id`) FROM `users` WHERE `email` = '$email'"), 0);
}

function userConfirmed($username) {
	$username = sanitise($username);
	return mysql_result(mysql_query("SELECT count(`id`) FROM `users` WHERE `username` = '$username' AND `state` != 0"), 0);
}

function getActiveUserCount() {
	return mysql_result(mysql_query("SELECT count(`id`) FROM `users` WHERE `state` != 0"), 0);
}

function getIDUser($username) {
	$username = sanitise($username);
	return mysql_result(mysql_query("SELECT `id` FROM `users` WHERE `username` = '$username'"), 0);
}

function setUserSessionID($userID, $sessionID) {
	$userID = (int) $userID;
	$sessionID = sanitise($sessionID);
	mysql_query("UPDATE `users` SET `sessionID` = '$sessionID', `lastLogin` = NOW() WHERE `id` = $userID");
}

function resetUserSessionID($userID) {
	$userID = (int) $userID;
	mysql_query("UPDATE `users` SET `sessionID` = '0' WHERE `id` = $userID");
}

function getUserSessionID($userID) {
	$userID = (int) $userID;
	return mysql_result(mysql_query("SELECT `sessionID` FROM `users` WHERE `id` = $userID"), 0);
}

function authUserSessionID($userID, $sessionID) {
	$dbSessionID = getUserSessionID($userID);
	if ($dbSessionID && sanitise($sessionID) == $dbSessionID) {
		resetUserSessionID($userID);
		return true;
	}
	return false;
}

function loginUser($username, $password) {
	if (empty($username) || empty($password))
		return 1;
	if (!credentialsCorrect($username, $password))
		return 2;
	if (!userConfirmed($username))
		return 3;

	$_SESSION["id"] = getIDUser($username);
	return 0;
}

function credentialsCorrect($username, $password) {
	if (!userExists($username))
		return false;

	$username = sanitise($username);
	$dbPassHash = mysql_result(mysql_query("SELECT `password` FROM `users` WHERE `username` = '$username'"), 0);
	return encrypt(sanitise($password), substr($dbPassHash, 0, 64)) == $dbPassHash;
}

function logout() {
	session_unset();
	session_destroy();
}

function userLoggedIn() {
	return isset($_SESSION["id"]);
}

function registerUser($registrationInfo) {
	foreach ($registrationInfo as $key => $value)
		$registrationInfo[$key] = sanitise($value);
	$registrationInfo["password"] = encrypt($registrationInfo["password"]);
	
	$fields = "`".implode("`, `", array_keys($registrationInfo))."`";
	$values = "'".implode("', '", $registrationInfo)."'";
	mysql_query("INSERT INTO `users` ($fields) VALUES ($values)");
	sendVerificationEmail($registrationInfo["email"], $registrationInfo["username"], $registrationInfo["randHash"]);
}

function sendVerificationEmail($email, $username, $hash) {
	sendGenericEmail($email, "Metaplains Account Verification", "Hello ".$username.",\n\nThank you for registering for Metaplains!\nIf you did not register with us, please ignore this email. To verify your email address and activate your account, please click the following link or copy it into the URL bar:\n\n".home()."/usr/activate.php?email=".$email."&hash=".$hash."\n\n~Metaplains Team");
}

function activateAccount($email, $hash) {
	$email = sanitise($email);
	$hash = sanitise($hash);

	if (!emailExists($email))
		return 1;
	if(mysql_result(mysql_query("SELECT count(`id`) FROM `users` WHERE `email` = '$email' AND `state` != 0"), 0))
		return 2;
	if (!mysql_result(mysql_query("SELECT count(`id`) FROM `users` WHERE `email` = '$email' AND `randHash` = '$hash' AND `state` = 0"), 0))
		return 3;
	
	mysql_query("UPDATE `users` SET `state` = 1 WHERE `email` = '$email' AND `randHash` = '$hash' AND `state` = 0");
	return 0;
}

function changeUserPassword($username, $newPass) {
	//TODO: Think about whether ids or usernames should be used for identification and how much info you need for this function.
	$username = sanitise($username); //Really though?
	$newPass = encrypt(sanitise($newPass));
	mysql_query("UPDATE `users` SET `password` = '$newPass' WHERE `username` = '$username'");
}

function setAccountState() {
	//TODO: Consider implementing this.
}

function setUserField($id, $field, $value) {
	//TODO: Think about this.
	$id = sanitise($id);
	$field = sanitise($field);
	$value = sanitise($value);
	mysql_query("UPDATE `users` SET `$field` = '$value' WHERE `id` = '$id'");
}

function getUserInfo($id) {
	return mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `id` = $id"));
}

?>
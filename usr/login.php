<?php include $_SERVER["DOCUMENT_ROOT"]."/lib/init.php";

if (empty($_POST)) {
	header("Location: /");
	exit();
}

//TODO: Look into facebook connect.
$error = loginUser($_POST["username"], $_POST["password"]);
if (!$error) {
	header("Location: /");
	exit();
} else {
	include $root."/gui/stdTop.php";
	print "<h2>Error</h2>";
	switch ($error) {
		case 1:
			print "<p>Please enter a username and password.</p>";
			break;
		case 2:
			print "<p>Incorrect username or password.<br><br>Forgotten your <a href='/usr/recoverInfo.php?info=username'>username</a>/<a href='/usr/recoverInfo.php?info=password'>password</a>?</p>";
			break;
		case 3:
			//TODO: Implement resending of verification email.
			print "<p>Please verify your email address to log in. <a href='/'>Resend verification email.</a>.</p>";
			break;
		default:
			print "<p>An unexpected error has occured.</p>";
			break;
	}
	include $root."/gui/stdBottom.php";
}
?>
<?php include $_SERVER["DOCUMENT_ROOT"]."/lib/init.php";

if (empty($_POST))
	die("-1:Missing login parameters.");

$error = loginUser($_POST["username"], $_POST["password"]);
if (!$error) {
	$id = $_SESSION["id"];
	$sessionID = genUID();
	setUserSessionID($id, $sessionID);
	die($_SESSION["id"].":".$sessionID);
} else {
	print "-1:";
	switch ($error) {
		case 1:
			die("Please enter a username and password.");
			break;
		case 2:
			//TODO: Refer to recovery page.
			die("Incorrect username or password.");
			break;
		case 3:
			//TODO: Refer to verification email resend.
			die("Please verify your email address to log in.");
			break;
		default:
			die("An unexpected error has occured.");
			break;
	}
}
?>
<?php include $_SERVER["DOCUMENT_ROOT"]."/lib/init.php";
hideCurrentPageFromMembers();

if (isset($_GET["success"])) {
	include $root."/gui/stdTop.php";
	print "<h2>Account activation successful!</h2>";
	print "<p>Congratulations, your account has been activated! You can now log in.</p>";
	include $root."/gui/stdBottom.php";
} else if (isset($_GET["email"], $_GET["hash"])) {
	$email = trim($_GET["email"]);
	$hash = trim($_GET["hash"]);

	$error = activateAccount($email, $hash);
	if (!$error) {
		header("Location: activate.php?success");
		exit();
	} else {
		include $root."/gui/stdTop.php";
		print "<h2>Error</h2>";
		switch ($error) {
			case 1:
				print "<p>No account has been registered under the email \"".htmlentities($email)."\".</p>";
				break;
			case 2:
				print "<p>The account registered under the email \"".htmlentities($email)."\" is already active.</p>";
				break;
			case 3:
				print "<p>The account registered under the email \"".htmlentities($email)."\" could not be activated. Please make sure you have copied the activation link correctly.</p>";
				break;
			default:
				print "<p>An unexpected error has occured.</p>";
				break;
		}
		include $root."/gui/stdBottom.php";
	}
} else {
	header("Location: /");
	exit();
}
?>
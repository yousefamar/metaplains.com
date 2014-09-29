<?php include $_SERVER["DOCUMENT_ROOT"]."/lib/init.php";

if (empty($_GET["username"])) {
	header("Location: /");
	exit();
}

include $root."/gui/stdTop.php";

if (!userExists($_GET["username"])) {
	print "<h2>Error</h2>";
	print "<p>Sorry, the user \"".htmlentities($_GET["username"])."\" does not exist!</p>";
} else {
	//include/require?
	$userInfo = getUserInfo(getIDUser($_GET["username"]));
	print_r($userInfo);
}

include $root."/gui/stdBottom.php"; ?>
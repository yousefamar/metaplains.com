<?php include $_SERVER["DOCUMENT_ROOT"]."/lib/init.php";
hideCurrentPageFromMembers();

$info = array("username", "password");
if (!isset($_GET["info"]) || !in_array($_GET["info"], $info)) {
	header("Location: /");
	exit();
}

include $root."/gui/stdTop.php";

if (!empty($_POST)) {
	if (emailExists($_POST["email"])) {
		print "<h2>Success</h2>";
		print "<p>Your ".$_GET["info"]." has been sent to \"".htmlentities($_POST["email"])."\".</p>";
	} else {
		print "<h2>Error</h2>";
		print "<p>No account has been registered under the email \"".htmlentities($_POST["email"])."\".</p>";
	}
} else {
	print "<h2>Recover ".ucfirst($_GET["info"])."</h2>";
	?>
	<form action="" method="POST">
		<p>
			Please enter your email address for your <?php print $_GET["info"]?> to be sent to you.<br><br>
			<input type="email" name="email" placeholder="Email">&nbsp;&nbsp;&nbsp;
			<input type="submit" value="Submit">
		</p>
	</form>
	<?php
}

include $root."/gui/stdBottom.php"; ?>
<?php include $_SERVER["DOCUMENT_ROOT"]."/lib/init.php";
hideCurrentPageFromNonMembers();

$errors = array();
if (!isset($_GET["success"]) && !empty($_POST)) {
	$requiredFields = array("currentPass", "newPass", "newPassConf");
	foreach ($_POST as $key => $value) {
		if (empty($value) && in_array($key, $requiredFields)) {
			$errors[] = "Please fill in all fields marked with an asterisk (required).";
			break 1;
		}
	}

	if (empty($errors)) {
		if (!credentialsCorrect($userInfo["username"], $_POST["currentPass"]))
			$errors[] = "Your current password is incorrect.";
		else if ($_POST["newPass"] == $_POST["currentPass"]) {
			$errors[] = "Your new password must differ from your current one.";
		} else {
			if (strlen($_POST["newPass"]) < 8)
				$errors[] = "Your new password must be at least 8 characters long.";
			if ($_POST["newPassConf"] != $_POST["newPass"])
				$errors[] = "Your new password confirmation does not match your password.";
		}
	}
	
	if (empty($errors)) {
		changeUserPassword($userInfo["username"], $_POST["newPass"]);
		header("Location: changePass.php?success");
		exit();
	}
}

include $root."/gui/stdTop.php";
?>

<h2>Change Password</h2>
<?php
if (isset($_GET["success"])) {
	print "<p><font size='3' color='green'>Your password has been successfully changed!</font></p>";
} else {
	if (!empty($errors)) {
		print "<p><font size='2' color='red'>";
		foreach ($errors as $key => $value)
			print $value."<br>";
		print "</font></p>";
	}
?>
	<form action="" method="POST">
		<p>
			<small>Current password*</small><br>
			<input type="password" name="currentPass"><br><br>
			<small>New password*</small><br>
			<input type="password" name="newPass"><br><br>
			<small>Confirm new password*</small><br>
			<input type="password" name="newPassConf"><br><br>
			<input type="submit" value="Save">
		</p>
	</form>
<?php
}

include $root."/gui/stdBottom.php"; ?>
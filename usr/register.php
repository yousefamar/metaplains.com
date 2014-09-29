<?php include $_SERVER["DOCUMENT_ROOT"]."/lib/init.php";
hideCurrentPageFromMembers();

$errors = array();
if (!isset($_GET["success"]) && !empty($_POST)) {
	$requiredFields = array("username", "password", "passwordConf", "email");
	foreach ($_POST as $key => $value) {
		if (empty($value) && in_array($key, $requiredFields)) {
			$errors[] = "Please fill in all fields marked with an asterisk (required).";
			break 1;
		}
	}

	if (empty($errors)) {
		//TODO: Implement support for foreign characters.
		if (strlen($_POST["username"]) > 16)
			$errors[] = "Your username may not be longer than 16 characters.";
		if (!preg_match("/^[a-zA-Z0-9_]+$/", $_POST["username"]))
			$errors[] = "Your username may only contain letters, numbers and underscores.";
		if (empty($errors) && userExists($_POST["username"]))
			$errors[] = "The username \"".htmlentities($_POST["username"])."\" is already taken. Please choose a different one.";

		if (strlen($_POST["password"]) < 8)
			$errors[] = "Your password must be at least 8 characters long.";
		if ($_POST["passwordConf"] != $_POST["password"])
			$errors[] = "Your password confirmation does not match your password.";

		if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
			$errors[] = "Please enter a valid email.";
		else if (emailExists($_POST["email"]))
			$errors[] = "An account has already been registered under the email \"".htmlentities($_POST["email"])."\". Please choose a different one.";
	}

	require_once($root."/lib/recaptchalib.php");
	if (!(recaptcha_check_answer ("6LeOwtMSAAAAABNE2lxNCmSbNSwCoIYmpZoQzZDY", $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"])->is_valid)) {
		$errors[] = "The reCAPTCHA was not entered correctly. Please try again to prove that you are human.";
	}
	
	if (empty($errors)) {
		$registrationInfo = array(
			"username" => $_POST["username"],
			"password" => $_POST["password"],
			"email" => $_POST["email"],
			"randHash" => md5(uniqid(rand(), true)));
		registerUser($registrationInfo);
		header("Location: register.php?success");
		exit();
	}
}

include $root."/gui/stdTop.php";
?>

<h2>Register</h2>
<?php
if (isset($_GET["success"])) {
	print "<p><font size='3' color='green'>Registration successful! Please check your email for a verification link.</font></p>";
} else {
	if (!empty($errors)) {
		print "<p><font size='2' color='red'>";
		foreach ($errors as $key => $value)
			print $value."<br>";
		print "</font></p>";
	}
	?>
	<script type="text/javascript"> var RecaptchaOptions = { theme: "clean" }; </script>
	<form action="" method="POST">
		<p>
			<small>Username*</small><br>
			<input type="text" name="username"><br><br>
			<small>Password*</small><br>
			<input type="password" name="password"><br><br>
			<small>Confirm password*</small><br>
			<input type="password" name="passwordConf"><br><br>
			<small>Email*</small><br>
			<input type="email" name="email">
		</p>
		<?php
		require_once($root."/lib/recaptchalib.php");
		print recaptcha_get_html("6LeOwtMSAAAAAJ-u-i8Z5TA813kUENmbiIy7w6Pm");
		?>
		<p><input type="submit" value="Submit"></p>
	</form>
	<?php
}

include $root."/gui/stdBottom.php"; ?>
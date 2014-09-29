<?php include "lib/init.php";

if (!isset($_GET["code"])) {
	header("Location: /");
	exit();
}

include "gui/stdTop.php";

print "<h2>Error</h2>";

switch ($_GET["code"]) {
	case 400:
		print "<p><strong>400 Bad Request:</strong> The request could not be fulfilled due to bad syntax.</p>";
		break;
	case 401:
		print "<p><strong>401 Unauthorized:</strong> Access denied due to invalid credentials.</p>";
		break;
	case 403:
		print "<p><strong>403 Forbidden:</strong> The request was legal, but the server is refusing to respond to it.</p>";
		break;
	case 404:
		print "<p><strong>404 Not Found:</strong> The requested resource could not be found.</p>";
		break;
	case 500:
		print "<p><strong>500 Internal Server Error:</strong> The server encountered an internal error or misconfiguration and was unable to complete your request.<br><br>\nPlease contact the server administrator, webmaster@4ytech.com, and inform them of the time the error occurred and anything you might have done that may have caused the error.</p>";
		break;
	default:
		print "<p>An unexpected error has occurred.</p>";
		break;
}

include "gui/stdBottom.php";
?>
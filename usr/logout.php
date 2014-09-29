<?php include $_SERVER["DOCUMENT_ROOT"]."/lib/init.php";
hideCurrentPageFromNonMembers();

logout();
header("Location: /");
?>
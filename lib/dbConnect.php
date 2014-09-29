<?php

$connect = mysql_connect("localhost","fouytech_std","standard") or die("Error: Could not connect to database.");
mysql_select_db("fouytech_users") or die("Error: Could not find user database.");

?>
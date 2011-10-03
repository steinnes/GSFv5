<?php
require("config.inc.php");
$_SESSION["logged_in"] = 0;
$_SESSION["username"] = "";
$_SESSION["user_id"] = "";
session_destroy();
header("Location: index.php");
?>

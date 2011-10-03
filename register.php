<?php
require("config.inc.php");
$db = new pgdbi("localhost", "gsf", "blah.blah.blah", "gsf");

if ($_POST['submit'])
{

	$user = pg_escape_string($_POST['user']);
	$pass = pg_escape_string($_POST['pass']);
	$insert = "insert into users (username, password) values('$user', md5('$pass'))";
	$db->query($insert);
}
header("Location: index.php");
?>

<?php
require("config.inc.php");
if ($_POST)
{
	$username = pg_escape_string($_POST["user"]);
	$password = pg_escape_string($_POST["pass"]);
	$login = "SELECT * FROM users WHERE username='$username' AND password=md5('$password')";
	$db->query($login);
	if ($db->num_rows() > 0)
	{
		$user_info = $db->farr();
		$_SESSION["logged_in"] = 1;
		$_SESSION["username"] = $user_info["username"];
		$_SESSION["user_id"] = $user_info["user_id"];
	}
	else
	{
		print "<h1>Vitlaust notendanafn/lykilorð</h1>";
		header("Refresh: 3; URL=index.php");
	}
}
header("Location: index.php");
?>

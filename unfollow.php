<?php
require("config.inc.php");

if (!$_SESSION["logged_in"])
{
	print "<h1>Villa: ekki innskráður</h1>";
	header("Refresh: 3;URL=login.html");
	exit(1);
}

$user = pg_escape_string($_REQUEST["user"]);
if ($user)
{
	$delete = "DELETE FROM follows WHERE user_id='" . $_SESSION["user_id"] . "' AND following in (SELECT user_id FROM users WHERE username='" . $user . "')";
	$db->query($delete);
	print "<h1>Þú ert ekki að fylgjast með skilaboðum $user</h1>";
	header("Refresh: 3;URL=home.php");	
}

?>

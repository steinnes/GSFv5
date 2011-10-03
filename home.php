<?php
require("config.inc.php");
if (!$_SESSION["logged_in"])
{
	print "<h1>Villa: ekki innskráður</h1>";
	header("Refresh: 3;URL=login.html");
	exit(1);
}
if ($_POST)
{
	// Bæta við message
	$message = pg_escape_string($_POST["message"]);
	$insert = "INSERT INTO messages (user_id,timestamp,message) VALUES ('" . $_SESSION["user_id"] . "',NOW(),'$message')";
	$db->query($insert);
}
?>
<html>
 <head>
  <title>GSF Verkefni 5 - Heimasvæði</title>
 </head>
 <body>
  <h1>GSF Verkefni 5</h1>
<?php include("menu.tpl"); ?>
  <h2>Heimasvæðið mitt</h2>
  <h2>Ný smáskilaboð</h2>
  <form method="post">
   <input type="text" name="message" style="width: 300px; height: 25px; font-size: 20px" />
   <input type="submit" value="Senda" />
  </form>
  <h2>Straumurinn minn</h2>
  <table border="0">
<?php
$db->query("
	SELECT
		username,
		message,
		timestamp,extract('epoch' from timestamp) as unixt
	FROM		 messages
	LEFT JOIN	follows
		ON	messages.user_id=follows.following
	LEFT JOIN	users
		ON	messages.user_id=users.user_id
	WHERE follows.user_id='" . $_SESSION["user_id"] . "' OR messages.user_id='" . $_SESSION["user_id"] . "'
	ORDER BY timestamp DESC
	LIMIT 50");
while ($row = $db->farr())
{
	print "<tr><td><a href=\"view.php?user=" . $row["username"] . "\">@".$row["username"]."</a></td>";
	print "<td>" . $row["message"] . "</td><td><small>fyrir " . time_elapsed($row["unixt"]) . "</small></td></tr>\n";
}
?>
  </table>
 </body>
</html>

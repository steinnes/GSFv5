<?php
require("config.inc.php");
?>
<html>
 <head>
  <title>GSF Verkefni 5</title>
 </head>
 <body>
  <h1>GSF Verkefni 5</h1>
  <p>
<?
if ($_SESSION["logged_in"])
{
	print "<strong>Þú ert innskráð(ur) sem notandinn: ". $_SESSION["username"]."</strong><br />";
	include("menu.tpl");
}
else
	print "Þú ert ekki innskráð(ur). <a href=\"login.html\">Innskráning</a>. <a href=\"register.html\">Nýskráning</a>.";
?>
  </p>
  <h2>Nýjustu smáskilaboð</h2>
<table border="0">
<?
$db->query("SELECT *,extract('epoch' from timestamp) as unixt FROM messages NATURAL JOIN users ORDER BY timestamp DESC limit 20");
while ($row = $db->farr())
{
	print "<tr><td><a href=\"view.php?user=" . $row["username"] . "\">@".$row["username"]."</a></td>";
	print "<td>" . $row["message"] . "</td><td><small>fyrir " . time_elapsed($row["unixt"]) . "</small></td></tr>\n";
}
?>
</table>
</body>
</html>

<?php
include("config.inc.php");

$user=pg_escape_string($_REQUEST["user"]);
if (!$user)
{
	print "<h1>Enginn notandi valinn!</h1>";
	header("Refresh: 3; URL=index.php");
	exit(1);
}
?>
<html>
 <head>
  <title>GSF Verkefni 5</title>
 </head>
 <body>
<?php
?>
<h1>GSF Verkefni 5</h1>
<h2>Skilaboðastraumur <?php echo $user; ?></h2>
<table border="0">
<?php
$db->query("select *,extract('epoch' from timestamp) as unixt from messages natural join users where username='$user' order by timestamp desc limit 50");
while($row = $db->farr())
{ //{print_r($row);}
	print "<tr><td><a href=\"view.php?user=" . $row["username"] . "\">@".$row["username"]."</a></td>";
	print "<td>" . $row["message"] . "</td><td><small>fyrir " . time_elapsed($row["unixt"]) . "</small></td></tr>\n";
}
?>
</table>
<?php
// gefum notanda möguleika á að "fylgjast með" eða "hætta að fylgjast með", eftir því hvað á við!
$db->query("SELECT * FROM follows WHERE user_id='" . $_SESSION["user_id"] . "' AND following=(SELECT user_id FROM users WHERE username='" . $user . "') LIMIT 1");
if ($db->num_rows() == 1) {
?>
<a href="unfollow.php?user=<?php echo $user; ?>">Hætta að fylgjast með <?php echo $user; ?></a>
<?php } else { ?>
<a href="follow.php?user=<?php echo $user; ?>">Fylgjast með <?php echo $user; ?></a>
<?php } ?>
</body>
</html>

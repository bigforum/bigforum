<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
page_header();
looking_page("online_view");
include("includes/function_forum.php");
include("includes/function_user.php");
$order = $_GET["ord"];

if($order == "")
{
  $order = "username";
}

$tauio = "900";
$dtime = time() - $tauio;
$online_data = mysql_query("SELECT * FROM eins_users WHERE last_log > '$dtime' ORDER BY '$order'");
$besucher_zahl = mysql_num_rows($online_data);
echo "<table bgcolor=#397BC6 width=90%><tr><td><font color=snow>Angezeigt werden alle Benutzer, die während der letzten ". date("i",$tauio) ." Minuten online waren. ($besucher_zahl Besucher online)</font></td></tr></table>
<table width=90%><tr style=font-weight:bold><td>Benutzername</td><td>Letzte Aktivität</td><td>Aufenthaltsort</td></tr>";
while($od = mysql_fetch_object($online_data))
{
  echo "<tr><td><a href=profil.php?id=$od->id>$od->username</a></td><td>". date("H:i", $od->last_log) ."</td><td>$od->last_site</td></tr>";
}
echo "</table>";
page_footer();
?>
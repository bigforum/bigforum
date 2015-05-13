<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
page_header();
looking_page("online_view");
include("includes/function_forum.php");
include_once("includes/function_user.php");
$order = $_GET["ord"];

if($order == "")
{
  $order = "username";
}
if($_GET["ip"] != "" AND (GROUP == "2" OR GROUP == "3"))
{
  $ip_auf =  gethostbyaddr($_GET["ip"]);
  echo "<table><tr class=normal><td><big>IP-Adressen auflösen</big></td></tr>
  <tr><td><b>IP-Adresse:</b> $_GET[ip]<br><b>Aufgelöst:</b> &nbsp; $ip_auf</td></tr></table>";
  page_footer();
}

$tauio = "900";
$dtime = time() - $tauio;
$online_data = mysql_query("SELECT * FROM users WHERE last_log > '$dtime' ORDER BY '$order'");
$besucher_zahl = mysql_num_rows($online_data);
echo "<table class=normal width=90%><tr><td><font color=snow>Angezeigt werden alle Benutzer, die während der letzten ". date("i",$tauio) ." Minuten online waren. ($besucher_zahl Besucher online)</font></td></tr></table>
<table width=90%><tr style=font-weight:bold><td>Benutzername</td><td>Letzte Aktivität</td><td>Aufenthaltsort</td>";
if(GROUP == "2" OR GROUP == "3")
{
  echo "<td>IP-Adresse</td>";
}
echo "</tr>";
while($od = mysql_fetch_object($online_data))
{
  echo "<tr><td><a href=profil.php?id=$od->id>$od->username</a></td><td>". date("H:i", $od->last_log) ."</td><td>$od->last_site</td>";
  if(GROUP == "2" OR GROUP == "3")
  {
    echo "<td><a href=online.php?ip=$od->last_ip title='IP-Adressen auflösen'>$od->last_ip</a></td>";
  }
  echo "</tr>";
}
echo "</table>";
page_footer();
?>
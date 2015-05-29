<?php
include("includes/functions.php");
connect_to_database();
if($_GET["aktion"] == "stat_po")
{
  $hoch_post = mysql_query("SELECT * FROM users ORDER BY posts DESC LIMIT 4");
  $x = "0";
  $color = array("schwarz","lila","gelb");
  while($hp = mysql_fetch_object($hoch_post))
  {
    if($x == "0")
	{
	  $data = "$hp->username:$hp->posts:rot";
	}
	else
	{
	  $data .= ", $hp->username:$hp->posts:$color[$x]";
	}
	$x++;
  }
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2adser2'");
  $con = mysql_fetch_object($config_wert);
  diagramm($con->wert1, 10, $data, "Beiträge", 350, 150);
  exit;
}
if($_GET["aktion"] == "stat_pr")
{
  $hoch_post = mysql_query("SELECT * FROM users ORDER BY provi DESC LIMIT 4");
  $b = "0";
  $colors = array("schwarz","lila","gelb");
  while($hp = mysql_fetch_object($hoch_post))
  {
    if($b == "0")
	{
	  $data = "$hp->username:$hp->provi:rot";
	}
	else
	{
	  $data .= ", $hp->username:$hp->provi:$colors[$b]";
	}
	$b++;
  }
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2adser2'");
  $con = mysql_fetch_object($config_wert);
  diagramm($con->wert1, 10, $data, "Besucher", 350, 150);
  exit;
}
if($_GET["aktion"] == "adser")
{
  $adda = mysql_query("SELECT * FROM adser WHERE id LIKE '$_GET[id]'");
  $ad = mysql_fetch_object($adda);
  mysql_query("UPDATE adser SET klicks = klicks+1 WHERE id LIKE '$_GET[id]'");
  header("Location: $ad->link");
  exit;
}
if($_GET["aktion"] == "show_stat")
{
  page_header();
  echo "In den folgenden Diagrammen siehst du Forenstatistiken, um welche es sich handelt ist drüber beschrieben:<br><br>
  <h2>Beiträge</h2><hr>
  <img src='misc.php?aktion=stat_po'><br><br>
  <h2>Profilbesucher</h2><hr>
  <img src='misc.php?aktion=stat_pr'>";
  page_footer();
}
?>
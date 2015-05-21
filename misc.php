<?php
include("includes/functions.php");
connect_to_database();
if($_GET["aktion"] == "adser")
{
  $adda = mysql_query("SELECT * FROM adser WHERE id LIKE '$_GET[id]'");
  $ad = mysql_fetch_object($adda);
  mysql_query("UPDATE adser SET klicks = klicks+1 WHERE id LIKE '$_GET[id]'");
  header("Location: $ad->link");
}
?>
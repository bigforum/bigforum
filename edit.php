<?php
//Wichtige Angaben f�r jede Datei!
include("includes/functions.php");
page_header();
looking_page("edit");
include("includes/function_forum.php");
if($_GET["id"] == "" OR GROUP < "2")
{
  erzeuge_error("Du kannst den Beitrag nicht �berarbeiten, antscheinend hast du nicht gen�gend Rechte.");
}
if($_GET["aktion"] != "")
{
  $time = time();
  $edi = mysql_query("SELECT * FROM beitrag WHERE id LIKE '$_GET[id]'");
  $ed = mysql_fetch_object($edi);
  mysql_query("UPDATE beitrag SET text = '$_POST[feld]', edit_by = '". USER ."', last_edit_dat = '$time' WHERE id LIKE '$_GET[id]'");
  echo "Danke, der Beitrag wurde �berarbeitet.<br><br><a href=thread.php?id=$ed->where_forum#$ed->id>Zur�ck zum Thema</a><br><br>";
  page_footer();
  exit;
}
$edi = mysql_query("SELECT * FROM beitrag WHERE id LIKE '$_GET[id]'");
$ed = mysql_fetch_object($edi);
editor("sign",$ed->text,"?id=$_GET[id]");
page_footer();
?>
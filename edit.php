<?php
//Wichtige Angaben f�r jede Datei!
include("includes/functions.php");
page_header();
login();
looking_page("edit");
include("includes/function_forum.php");
if($_GET["id"] == "")
{
  erzeuge_error("Leider wurde kein Beitrag zum �ndern angegeben.");
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
if(GROUP == "2" OR GROUP == "3" OR USER == $ed->verfas)
{
  editor("sign",$ed->text,"?id=$_GET[id]");
}
else
{
  erzeuge_error("Dir Fehlen die Rechte, um diesen Beitrag zu �berarbeiten.");
}
page_footer();
?>
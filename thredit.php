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
  $user_data = mysql_query("SELECT * FROM users WHERE username LIKE '". USER ."'");
  $ud = mysql_fetch_object($user_data);
  $time = time();
  $edi = mysql_query("SELECT * FROM thema WHERE id LIKE '$_GET[id]'");
  $ed = mysql_fetch_object($edi);
  if($ud->editrech == "2")
  {
    mysql_query("UPDATE thema SET text = '$_POST[feld]' WHERE id LIKE '$_GET[id]'");  
  }
  else
  {
    mysql_query("UPDATE thema SET text = '$_POST[feld]', edit_by = '". USER ."', last_edit_dat = '$time' WHERE id LIKE '$_GET[id]'");
  }
  echo "Danke, der Beitrag wurde �berarbeitet.<br><br><a href=thread.php?id=$ed->id>Zur�ck zum Thema</a><br><br>";
  page_footer();
  exit;
}
$edi = mysql_query("SELECT * FROM thema WHERE id LIKE '$_GET[id]'");
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
<?php
//Wichtige Angaben für jede Datei!
include_once("includes/functions.php");

$ac = $_GET["aktion"];
if($ac == "send")
{
  connect_to_database();
  include_once("includes/function_user.php");
  $time = time();
  $data_beit = mysql_query("SELECT * FROM eins_beitrag WHERE where_forum LIKE '$_GET[id]' ORDER BY id DESC LIMIT 1");
  $db = mysql_fetch_object($data_beit);
  if($db->verfas == USER)
  {
    mysql_query("UPDATE eins_beitrag SET text = '$db->text \n \n [b]UPDATE:[/b]\n $_POST[feld]', last_edit_dat = '$time', edit_by = '". USER ."' WHERE id LIKE '$db->id'");
  }
  else
  {
    $eintrag = mysql_query("INSERT INTO eins_beitrag (text, where_forum, verfas, post_dat, last_edit_dat, edit_by) VALUES ('$_POST[feld]', '$_GET[id]', '". USER ."', '$time', '', '')");
    mysql_query("UPDATE eins_users SET posts = posts+1 WHERE username LIKE '". USER ."'");
    mysql_query("UPDATE eins_thema SET last_post_time = '$time' WHERE id LIKE '$_GET[id]'");
  }
  header("Location: thread.php?id=$_GET[id]");
}
page_header();
looking_page("newreply");
include_once("includes/function_user.php");
include_once("includes/function_forum.php");

$thema_data = mysql_query("SELECT * FROM eins_thema WHERE id LIKE '$_GET[id]'");
$td = mysql_fetch_object($thema_data);

if($ac == "")
{
  if($td->close != "1")
  {
    editor("ant","","?id=$_GET[id]");
  }
  else
  {
   if(GROUP == "2" OR GROUP == "3")
   {
     editor("ant","","?id=$_GET[id]");
   }
   else
     erzeuge_error("Dieses Thema ist geschlossen. Du kannst nicht mehr antworten");
  }
}

page_footer()
?>
<?php
//Wichtige Angaben f¸r jede Datei!
include("includes/functions.php");

$ac = $_GET["aktion"];
if($ac == "send")
{
  connect_to_database();
  include("includes/function_user.php");
  $time = time();
  $data_beit = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$_GET[id]' AND dele = '' ORDER BY id DESC LIMIT 1");
  $db = mysql_fetch_object($data_beit);
  $rech = $time - $db->post_when;
  if($_POST["feld"] == "")
  {
     page_header();
	 erzeuge_error("Du kannst keinen leeren Text absenden.");  
	 page_footer();
  }
  $_POST["feld"] = str_replace("  ","",$_POST["feld"]);

  if(strlen($_POST["feld"]) <= 10)
  {
     page_header();
	 erzeuge_error("Du musst mindestens zehn Zeichen angeben.");  
	 page_footer();
  }


  if($db->verfas == USER)
  {
    mysql_query("UPDATE beitrag SET text = '$db->text \n \n [b]UPDATE:[/b]\n $_POST[feld]', last_edit_dat = '$time', edit_by = '". USER ."' WHERE id LIKE '$db->id'");
	if($_POST["close"] == "1")
	{
	  mysql_query("UPDATE thema SET close = '1' WHERE id LIKE '$_GET[id]'");
	}
	if($_POST["import"] == "1")
	{
	  mysql_query("UPDATE thema SET import = '1' WHERE id LIKE '$_GET[id]'");
	}
  }
  else
  {
    $eintrag = mysql_query("INSERT INTO beitrag (text, where_forum, verfas, post_dat, last_edit_dat, edit_by) VALUES ('$_POST[feld]', '$_GET[id]', '". USER ."', '$time', '', '')");
	$thema_data = mysql_query("SELECT * FROM thema WHERE id LIKE '$_GET[id]'");
    $td = mysql_fetch_object($thema_data);
    $fo_da = mysql_query("SELECT * FROM foren WHERE id LIKE '$td->where_forum'");
    $fd = mysql_fetch_object($fo_da);
	if($fd->beitrag_plus == "0")
	{
      mysql_query("UPDATE users SET posts = posts+1 WHERE username LIKE '". USER ."'");
	}  
    mysql_query("UPDATE thema SET last_post_time = '$time' WHERE id LIKE '$_GET[id]'");
	if($_POST["close"] == "1")
	{
	  mysql_query("UPDATE thema SET close = '1' WHERE id LIKE '$_GET[id]'");
	}
	if($_POST["import"] == "1")
	{
	  mysql_query("UPDATE thema SET import = '1' WHERE id LIKE '$_GET[id]'");
	}
  }
  header("Location: thread.php?id=$_GET[id]");
}
page_header();
looking_page("newreply");
include_once("includes/function_user.php");
include("includes/function_forum.php");

$thema_data = mysql_query("SELECT * FROM thema WHERE id LIKE '$_GET[id]'");
$td = mysql_fetch_object($thema_data);

if($ac == "" AND GROUP > 0)
{
  if($td->close != "1")
  {
    echo "
    <table width=70%><tr class=dark><td><font color=snow><b>Auf ein Thema antworten</b></font></td></tr></table><table width=70% class=editorbg><tr><td>";
    editor("ant","","?id=$_GET[id]");
    echo "</table><br>";
	$ant_sear = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$_GET[id]' ORDER BY id DESC LIMIT 5");
	$antwort = mysql_num_rows($ant_sear);
	/*echo "<table width=70%><tr class=dark><td><font color=snow><b>Letzten $antwort Antworten</b></font></td></tr></table>
	<table width=70% class=editorbg><tr><td class=editorbg><b>Username</b></td><td class=editorbg><b>Nachricht</b></td></tr>";*/
	while($aa = mysql_fetch_object($ant_sear))
	{
	 // echo "<tr><td class=editorbg>$aa->verfas</td><td class=editorbg>$aa->text</td></tr>";
	   text_ausgabe($aa->text, $aa->tit, $aa->verfas);
	}
	echo "</td></tr></table>";
  }
  else
  {
   if(GROUP == "2" OR GROUP == "3")
   {
     if($td->close == "1")
	 {
	   echo "<b>Information:</b> Dieses Thema ist geschloﬂen! Nur noch ein Moderator bzw. Administrator kann antworten.<br><br>";
	 }
    echo "
    <table width=70%><tr class=dark><td><font color=snow><b>Auf ein Thema antworten</b></font></td></tr></table><table width=70% class=editorbg><tr><td>";
    editor("ant","","?id=$_GET[id]");
    echo "</table><br>";    
	$ant_sear = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$_GET[id]' ORDER BY id DESC LIMIT 5");
	echo "<table width=70%><tr class=dark><td><font color=snow><b>Letzte Antworten</b></font></td></tr></table><table width=87%><tr><td>";
	while($aa = mysql_fetch_object($ant_sear))
	{
	   text_ausgabe($aa->text, $aa->tit, $aa->verfas);
	}
	echo "</td></tr></table>";
   }
   else
     erzeuge_error("Dieses Thema ist geschlossen. Du kannst nicht mehr antworten");
  }
}
else
{
  erzeuge_error("Du kannst auf dieses Thema nicht antworten. Bitte logge dich ein!");
}

page_footer()
?>
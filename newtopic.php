<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");

login();

$ac = $_GET["aktion"];
if($ac == "send")
{
  connect_to_database();
  include_once("includes/function_user.php");
  $time = time();
  check_data($_POST["bet"], "", "Bitte gebe einen Titel ein.", "leer");
  check_data($_POST["feld"], "", "Du hast keinen Text eingegeben.", "leer");
    $close = "0";
	$imp = "0";
  	if($_POST["close"] == "1")
	{
	  $close = "1";
	}
	if($_POST["import"] == "1")
	{
	  $imp = "1";
	}
  $eintrag = mysql_query("INSERT INTO thema (tit, text, verfas, last_edit, edit_from, post_when, where_forum, close, last_post_time,  import) VALUES ('$_POST[bet]', '$_POST[feld]', '". USER ."', '', '', '$time', '$_GET[id]', '$close', '$time', '$imp')");
  mysql_query("UPDATE users SET posts = posts+1 WHERE username LIKE '". USER ."'");
  header("Location: forum.php?id=$_GET[id]");
}
page_header();
looking_page("newtopic");
include_once("includes/function_user.php");
include("includes/function_forum.php");


if($ac == "")
{
  editor("ant","","?id=$_GET[id]");
}

page_footer()
?>
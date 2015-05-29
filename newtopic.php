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
  $_POST["bet"] = str_replace("  ","",$_POST["bet"]);
  if($_POST["bet"] == "" OR $_POST["bet"] == " ")
  {
    page_header();
	erzeuge_error("Du musst schon einen Titel angeben.");
  }
  $_POST["feld"] = str_replace("  ","",$_POST["feld"]);
  if($_POST["feld"] == "" OR $_POST["feld"] == " ")
  {
    page_header();
	erzeuge_error("Du hast keinen Text angegeben.");
  }
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
  $fo_da = mysql_query("SELECT * FROM foren WHERE id LIKE '$_GET[id]'");
  $fd = mysql_fetch_object($fo_da);
  if($da->beitrag_plus == "0")
  {
    mysql_query("UPDATE users SET posts = posts+1 WHERE username LIKE '". USER ."'");
  }
  header("Location: forum.php?id=$_GET[id]");
}
page_header();
looking_page("newtopic");
include_once("includes/function_user.php");
include("includes/function_forum.php");


if($ac == "")
{ 
  echo "
  <table width=70%><tr class=dark><td><font color=snow><b>Neues Thema erstellen</b></font></td></tr></table><table width=70% class=editorbg><tr><td>";
  editor("ant","","?id=$_GET[id]");
  echo "</table><br>";
}

page_footer()
?>
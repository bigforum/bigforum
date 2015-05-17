<?php
/* Ein Mod/Addon, der die Forenregeln ausgibt*/
  function admin()
  {
      //Verwaltungsmöglichkeiten für das Admincp
	  if($_GET["action"] == "change_rules")
	  {
	    $handle = fopen("../rules.txt","w");
	    fputs($handle,$_POST["regeln"]);
	    fclose($handle);
	    echo "Die Regeln wurden überarbeitet.<br><br>";
	    exit;
	  }
	  $handle = file_get_contents("../rules.txt","r+");
      echo "<form action=?do=mods&action=change_rules method=post>
	  <textarea name=regeln cols=70 rows=7>$handle</textarea><br><input type=submit value=Speichern></form><br><br>";
	  exit;
  }
if($_SERVER['REQUEST_URI'] == "/rules.php")
{
include("includes/functions.php");
page_header();
?>
<table class=bord><tr class="dark"><td><font color=snow>Die Regeln des Forums</font></td></tr>
<tr><td><?php
$ausgabe = file_get_contents("rules.txt");
$ausgabe = str_replace("\n","<br>",$ausgabe);
echo $ausgabe;
echo "</td></tr></table>";
page_footer();
}
?>
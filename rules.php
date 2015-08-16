<?php
/* Ein Mod/Addon, der die Forenregeln ausgibt*/
  function admin()
  {
    //Verwaltungsmöglichkeiten für das Admincp
    echo "Die Regeln können über rules.txt im Hauptverzeichnis leicht, und ohne HTML überarbeitet werden.";
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
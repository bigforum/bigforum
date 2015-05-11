<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
login();
page_header();
looking_page("search");
if($_GET["do"] == "send")
{
  $f;
  if($_GET["us"] != "" AND $_GET["action"] != "")
  {
    $f = "3";
	$aut = $_GET["us"];
	$sea = $_GET["action"];
	$lim = "50";
	if($sea == "thema")
      $search_res = mysql_query("SELECT * FROM thema WHERE verfas LIKE '$aut' ORDER BY id LIMIT $lim")or die(mysql_error());
    else
      $search_res = mysql_query("SELECT * FROM beitrag WHERE verfas LIKE '$aut' ORDER BY id LIMIT $lim")or die(mysql_error());
  }
  if(($_POST["auth"] == "" AND $_POST["schlu"] == "") AND $f != "3")
  {
    erzeuge_error("Du musst schon etwas eingeben!");
  }
  $lim = $_POST["number"];
  $fi = $_POST["first"];
  if($f != "3")
  {
    $sea = $_POST["search"];
	$aut = $_POST["auth"];
  }
  if($f != "3")
  {
    if($sea == "thema")
      $search_res = mysql_query("SELECT * FROM thema WHERE verfas LIKE '%$aut%' AND text LIKE '%$_POST[schlu]%' ORDER BY id $fi LIMIT $lim")or die(mysql_error());
    else
      $search_res = mysql_query("SELECT * FROM beitrag WHERE verfas LIKE '%$aut%' AND text LIKE '%$_POST[schlu]%' ORDER BY id $fi LIMIT $lim")or die(mysql_error());
  }
  echo "<table><tr class=normal style='font-weight:bold;'><td width=3%></td><td width=50% valign=center>Title</td><td width=20% valign=center>Autor</td></tr>";
 
  while($sr = mysql_fetch_object($search_res))
  {
    if($sea == "beitrag")
	{
	  $th_da = mysql_query("SELECT * FROM thema WHERE id LIKE '$sr->where_forum'");
	  $td = mysql_fetch_object($th_da);
	  if($td->close == "1")
      {
        $close = "<img src=images/th_close.png title='Thema ist geschlossen' width=80% height=80%>";
      }
      else
      {
        $close = "<img src=images/th_open.png title='Thema ist geöffnet' width=80% height=80%>";
      }
	  echo "<tr><td>$close</td><td>Forum:<a href=thread.php?id=$sr->where_forum#$sr->id>$td->tit</a></td><td>$sr->verfas</td></tr>";
	}
	else
	{
	  if($sr->close == "1")
      {
        $close = "<img src=images/th_close.png title='Thema ist geschlossen' width=80% height=80%>";
      }
      else
      {
        $close = "<img src=images/th_open.png title='Thema ist geöffnet' width=80% height=80%>";
      }
	  echo "<tr><td>$close</td><td><a href=thread.php?id=$sr->id>$sr->tit</a></td><td>$sr->verfas</td></tr>";	
	}
  }
  echo "</table>";
  page_footer();
  exit;
}

echo "<form action=?do=send method=post>
<fieldset>
<legend>Suchwörter</legend>
<table width=100%><tr><td width=50%>Author / Erstellen</td><td width=50%>Schlüßelwort</td></tr>
<tr><td><input type=text name=auth></td><td><input type=text name=schlu></td></table></fieldset><br>
<fieldset>
<legend>Einstellungen</legend><table width=100%><tr><td width=50%>
Suchen nach: <select name=search><option value=thema>Themen</option><option value=beitrag>Beiträgen</option></select></td><td>Zeige zuerst: <select name=first><option value=>ältesten Beitrag</option><option value=DESC>Neusten Beitrag</option></select></td></tr>
<tr><td> &nbsp </td><td> &nbsp; </td></tr>
<tr><td>Zeige <select name=number><option value=25>25</option><option value=50>50</option><option value=100>100</option><option value=250>250</option><option value=500>500</option></select> Ergebnisse</td></tr>
</table>
</fieldset><br>
<input type=submit value=Suchen>


</form>";

page_footer();
?>
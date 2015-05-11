<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
login();
page_header();
looking_page("search");
if($_GET["do"] == "send")
{
  $lim = $_POST["number"];
  $fi = $_POST["first"];
  if($_POST["search"] == "thema")
    $search_res = mysql_query("SELECT * FROM eins_thema WHERE verfas LIKE '%$_POST[auth]%' AND text LIKE '%$_POST[schlu]%' ORDER BY id $fi LIMIT $lim")or die(mysql_error());
  else
    $search_res = mysql_query("SELECT * FROM eins_beitrag WHERE verfas LIKE '%$_POST[auth]%' AND text LIKE '%$_POST[schlu]%' ORDER BY id $fi LIMIT $lim")or die(mysql_error());
echo "<table><tr bgcolor=#397bc6 style='font-weight:bold;'><td width=5%></td><td width=50% valign=center>Title</td><td width=20% valign=center>Autor</td></tr>";
 
  while($sr = mysql_fetch_object($search_res))
  {
    if($_POST["search"] == "beitrag")
	{
	  $th_da = mysql_query("SELECT * FROM eins_thema WHERE id LIKE '$sr->where_forum'");
	  $td = mysql_fetch_object($th_da);
	  echo "<tr><td></td><td><a href=thread.php?id=$sr->where_forum#$sr->id>Forum: $td->tit</a></td><td>$sr->verfas</td></tr>";
	}
	else
	{
	  echo "<tr><td></td><td><a href=thread.php?id=$sr->id>$sr->tit</a></td><td>$sr->verfas</td></tr>";	
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
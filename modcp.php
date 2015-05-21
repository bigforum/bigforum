<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
page_header();
looking_page("modcp");
$do = $_GET["do"];
$tab = "</td></tr></table>";
if(GROUP != "3" AND GROUP != "2")
{
  echo "Ein Zugriff auf das Moderatoren-Kontrollzentrum ist nur für Moderatoren möglich!";
}
?>
<table width="100%">
<tr><td valign="top" width="25%">
<!-- Navigation -->

<table width="100%">
<tr><td class=normal color="snow">
<b>Allgemeine Einstellungen</b></td></tr>
<tr><td><a href="?do=spe_us">Gesperrte Benutzer</a></td></tr>
<tr><td><a href="?do=ver_user">Benutzer suchen</a></td></tr>
<tr><td><a href="?do=mail_adr">eMail-Adressen raussuchen</a></td></tr>
<tr><td class=normal color="snow">
<b>IP-Adressen</b></td></tr>
<tr><td><a href="?do=ip_auf">IP-Adresse auflösen</a></td></tr>
</table>

</td>
<td valign="top">
<?
switch ($do) {
  case "":
  echo "Hallo ". USER .",<br> willkommen im Moderatoren-Kontrollzentrum.<br><br>";
  user_online(true);
  break;
  
  case "mail_adr":
  echo "<form action=?do=ma method=post>Gebe hier eine eMail-Adresse ein, und es werden dir alle Benutzer mit dieser eMail angezeigt.<br>
  <input type=text name=mail><input type=submit value=Prüfen></form>";
  break;
  
  
  case "ma":
  $maish = mysql_query("SELECT * FROM users WHERE mail LIKE '$_POST[mail]'");
  if(mysql_num_rows($maish) == "0")
  {
    echo "Zur angegebenen eMail Adresse wurde leider kein Treffer gefunden.";
	page_footer();
  }
  echo "Folgende Benutzer benutzen die Mail Adresse $_POST[mail]:<br><br>";
  while($ms = mysql_fetch_object($maish))
  {
    echo "<a href=profil.php?id=$ms->id>$ms->username</a><br>";
  }
  break;
  
  
  case "ip_auf":
  echo "<form action=online.php method=get><fieldset><legend>IP-Adresse auflösen</legend>Bitte gebe in das folgende Kästchen die IP-Adresse ein, welche du auflösen möchtest:<br>
  <input type=text name=ip><input type=submit value=Auflösen></fieldset>
  </form>";
  break;
  
  
  case "spe_us":
    $time = time();
  if($_GET["action"] == "del")
  {
    mysql_query("UPDATE users SET gesperrt = '0', sptime = '0' WHERE id LIKE '$_GET[id]'");
	echo "Die Sperre von diesem Benutzer (ID: $_GET[id]) wurde zurückgenommen.";
	echo "<br> $tab";
    page_footer();
	exit;
  }
  if($_GET["action"] == "new")
  {
    $u_da = mysql_query("SELECT * FROM users WHERE username LIKE '$_POST[ben]'");
	$ua = mysql_fetch_object($u_da);
	if($ua->group_id == "3" OR $ua->group_id == "2")
	{
	  echo "<b>Information:</b> Du kannst keine Administratoren bzw. Moderatoren sperren!";
	  echo "<br> $tab";
      page_footer();
	  exit;
	}
	if($ua->username == "")
	{
	  echo "<b>Information:</b> Dieser Benutzername exestiert nicht!<br><br>";
	  $vor = mysql_query("SELECT * FROM users WHERE username LIKE '%$_POST[ben]%' LIMIT 20");
	  $erg = mysql_num_rows($vor);
	  {
	    if($erg != "0")
		{
		  echo "<b>Vorschläge:</b><br>";
		}
	  }
	  while($vo = mysql_fetch_object($vor))
	  {
	    echo "$vo->username<br>";
	  }
	  echo "<br> $tab";
      page_footer();
	  exit;
	}
	$gesp = $time+$_POST["dauer"];
	$spertime = ceil($gesp/600)*600;  
	mysql_query("UPDATE users SET gesperrt = '1', sptime = '$spertime' WHERE username LIKE '$_POST[ben]'");
	echo "$_POST[ben] wurde nun vom Forum ausgeschlossen.";
	echo "<br> $tab";
    page_footer();
	exit;
  }

  $sperr_data = mysql_query("SELECT * FROM users WHERE gesperrt != '0' OR sptime > '$time'");
  $sp = "0";
  echo "<form action=?do=spe_us&action=new method=post><table>
  <tr><td>Benutzername: </td><td><input type=text name=ben></td></tr>
  <tr><td>Dauer:</td><td><select name=dauer>";
  for($v=0;$v<sizeof($warn_text);$v++)
  {
    echo "<option value=$warn_dauer[$v]>$warn_text[$v]</option>";
  }
  echo "</select></td></tr></table><input type=submit value='Benutzer sperren'></form><br><hr>";
  echo "<table>";
  while($sd = mysql_fetch_object($sperr_data))
  {
    $sp++;
	if($sp == "1")
	{
	  echo "<tr style=font-weight:bold><td>Benutzername</td><td>Läuft bis</td><td>Aktion</td></tr>";
	}
	echo "<tr><td>$sd->username</td><td>". date("d.m.Y - h:i", $sd->sptime) ."</td><td><a href=?do=spe_us&action=del&id=$sd->id>[ Sperre aufheben ]</a></td></tr>";
  }
  if($sp == "0")
  {
    echo "<tr><td> <b>Es gibt noch keine gesperrten Benutzer in diesem System</b> </td></tr>";
  }
  echo "</table>";
  break;
  
  
  case "ver_user":
  if($_GET["id"] == "1")
  {
    $my_us = mysql_query("SELECT * FROM users WHERE username LIKE '$_POST[benu]'");
	$mu = mysql_fetch_object($my_us);
	if($mu->username == "")
	{
	  echo "Dieses Benutzerprofil exestiert nicht. Bitte achte auf eine exakt richtige eingabe!";
	  echo "<br><br> $tab";
      page_footer();
      exit;
	}
	$text = $mu->sign;
    $text = strip_tags($text);
    $text = preg_replace('/\[b\](.*?)\[\/b\]/', '<b>$1</b>', $text);  
    $text = preg_replace('/\[k\](.*?)\[\/k\]/', '<i>$1</i>', $text);  
    $text = preg_replace('/\[u\](.*?)\[\/u\]/', '<u>$1</u>', $text);  
	$text = eregi_replace("\[url\]([^\[]+)\[/url\]","<a href=\"\\1\" target=\"_blank\">\\1</a>",$text);
    $text = str_replace("\n", "<br />", $text);
    $smilie_data = mysql_query("SELECT * FROM smilie WHERE packet = '1'");
    while($sd = mysql_fetch_object($smilie_data))
    {
      $text = str_replace($sd->abk1,"<img src=images/$sd->images_path width=25 height=25>", $text);
      $text = str_replace($sd->abk2,"<img src=images/$sd->images_path width=25 height=25>", $text);
    }
	echo "Da diese Abfrage aus dem Moderatoren-Kontrollzentrum kommt, werden die Benutzerdaten nur <b>angezeigt</b>.<br><br>
	<table>
	<tr><td>Benutzername:</td><td>$mu->username</td></tr>
	<tr><td>Beiträge:</td><td>$mu->posts</td></tr>
	<tr><td>Registrierungsdatum:</td><td>". date("d.m.Y - H:i", $mu->reg_dat) ."</td></tr>
	<tr><td>Registrierungs IP-Adresse:</td><td><a href=online.php?ip=$mu->reg_ip>$mu->reg_ip</a></td></tr>
	<tr><td>Letzte IP-Adresse:</td><td><a href=online.php?ip=$mu->last_ip>$mu->last_ip</a></td></tr>
	<tr><td>eMail-Adresse</td><td>$mu->mail</td></tr>
	<tr><td>Empfohlen von:</td><td>$mu->empfo</td></tr>
	<tr><td>Signatur</td><td>$text</td></tr></table>";
	echo "<br><br> $tab";
    page_footer();
  }
  echo "<form action=?do=ver_user&id=1 method=post>
  Benutzername: <input type=text name=benu size=40 value='$_GET[name]'><input type=submit value='Exakte Suche'></form>";
  break;
}
echo "<br><br> $tab";
page_footer();
?>
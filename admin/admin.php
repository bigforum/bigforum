<?php
session_start();
error_reporting(0);
include("../includes/functions.php");
include("admin_functions.php");
config("f2name2", false, "function_define");
$title = "Administrator-Kontrollzentrum";
looking_page("admin");
$do = $_GET["do"];
$seite = $_GET["seite"];
//Start des Admincp
if($do == "log_out")
{
  session_unset($_SESSION["admin_login"]);
  session_destroy();
  header("Location: ../index.php");
  exit;
}
if($_SESSION["admin_login"] != "login_true")
{
  insert_log("Fehlgeschlagene Administratoren-Anmeldung.");
  header("Location: index.php");
  exit;
}
echo "<head>

<title>$title</title>
<link rel='stylesheet' type='text/css' href='style.css'>

</head>";
?>
<script>
function info(text)
{
  document.getElementById('info').innerHTML = text;
}
try {
xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
} catch(e) {
try {
xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
} catch(e) {
xmlhttp=false;
}
}

if(!xmlhttp && typeof XMLHttpRequest != 'undefined') {
xmlhttp = new XMLHttpRequest();
}

 
 
 
function del(id) {
d = confirm("M�chtest du das Forum wirklich l�schen? Dieser Schritt ist nichtmehr r�ckg�nigmachbar. Alle Beitr�ge werden mitgel�scht!");
if(d == true)
{
  xmlhttp.open("GET", 'admin.php?do=ver_foren&action=del&id='+id);
  alert("Das Forum ist gel�scht");
}
xmlhttp.send(null);
}


function delkat(id) {
x = confirm("M�chtest du diese Kategorie wirklich l�schen? Beachte das dieses nur geht, wenn diese Kategorie keine Foren enth�lt.!");
if(x == true)
{
  xmlhttp.open("GET", 'admin.php?do=ver_foren&action=del_kat&id='+id);
  alert("Sollte die Kategorie keine Foren mehr enthalten haben, wurde sie nun gel�scht.");
}
xmlhttp.send(null);
}
<?php
  $admin_data = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2admin2'");
  $ad = mysql_fetch_object($admin_data);
  if($ad->zahl1 == "0")
  {
?>
function support(e){
if(e.which == "98")
{
  document.onkeypress=supportf;
}
}
function supportf(e){
if(e.which == "102")
{
  document.onkeypress=supports;
}
}
function supports(e){
if(e.which == "115")
{
  window.open("http://www.bigforum-support.de");

}
}
document.onkeypress=support;
<?php } ?>
</script>
<?php
echo "<div align='right'>
<b><font size=5>Administratoren-Kontrollzentrum</font></b><br>
<p><a href=?do=log_out>Aus Admin-Bereich ausloggen</a> | <a href='../index.php' target='_blank'>Foren-�bersicht</a></p>
</div>
<a href=\"admin.php\" class=menulink>Start</a> &nbsp; <a href=\"?do=ver_user\" class=menulink>Benutzer</a> &nbsp; <a href=\"?do=ver_foren\" class=menulink>Foren</a> &nbsp; <a href=\"?do=settings\" class=menulink>Einstellungen</a> &nbsp; <a href='?do=styles' class=menulink>Design</a>";
$add_data = mysql_query("SELECT * FROM addons WHERE admin_link != ''");
$ad = mysql_fetch_object($add_data);
if(mysql_num_rows($add_data) != "0")
{
  echo "&nbsp; <a href=?do=ver_mods class=menulink>Addons</a>";
}
$sons = array("?do=settings|Foren-Einstellungen","?do=settings_admincp|Kontrollzentrum-Einstellungen","?do=raenge|R�nge-Einstellungen","?do=mods|Mods/Addons Verwaltung","?do=new_warn|Verwarnungsgr�nde","?do=adser|Adserver");
$for = array("?do=new_foren|Neues Forum","?do=ver_foren|Verwalte Foren");
$user = array("?do=ver_user|Benutzer suchen","?do=sper_user|Gesperrte","?do=inaktiv|Inaktive Benutzer","?do=recht| Administratoren-Rechte","?do=zuruck|Rechte zur�cksetzen","?do=not_use|Benutzernamen / eMail-Adressen verbieten","?do=rundbrief| Rundbrief schreiben");
$start = array("admin.php|Start","?do=ver_check|Version-Check","?do=settings|Foren-Einstellungen","?do=look_logs|Log-Eintr�ge","?do=new_foren|Neues Forum erstellen","?do=ver_user|Benutzer verwalten");
$design = array("?do=styles|Styles","?do=insert_style|Style hinzuf�gen","?do=design|Header-Einstellungen");
switch ($do) {
  case "":
    left_table($start);
    admin_recht("1");
	$config_data = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2usearch2'");
    $cd = mysql_fetch_object($config_data);
	$adm_notice = $cd->wert1;
    echo "<table class=braun width=50%><tr class=besch><td><b>Willkommen im Administrator-Kontrollzentrum</b></td></tr><tr><td>
	Hallo ". USER .",<br>
	hier im bigforum Admin-Panel kannst du alles m�gliche verwalten. <br>Solltest du Hilfe mit dem Suchen bestimmter Funktionen haben,besuche doch mal die <a href=?do=help>kleine Administratoren Hilfe</a>.</td></tr></table><br><br>";
	if(file_exists("./install.php") OR file_exists("../install.php"))
	{
	echo "<table class=braun width=50%><tr class=besch><td><b>Warnung</b></td></tr><tr><td>
	Die Datei install.php exestiert noch. Bitte l�sche diese Datei.<br> Ansonsten kann jeder andere dieses Forum manipulieren!</td></tr></table><br><br>";

	}
	$pn_data = mysql_query("SELECT * FROM report_pn WHERE erledigt = '0'");
	$panzahl = mysql_num_rows($pn_data);
	if($panzahl != "0")
	{
	  	echo "<table class=braun width=50%><tr class=besch><td><b>Gemeldete Private Nachrichten</b></td></tr><tr><td>
	    Es wurden <a href=?do=reports_pn><b>$panzahl</b> Private Nachrichten</a> gemeldet, welche noch nicht kontrolliert wurden.</td></tr></table><br><br>";

	}
	echo "<br><br>
	<table class=braun width=50%><tr class=besch><td><b>Administratoren-Notizen (<a href=?do=change_notice>ver�ndern</a>)</b></td></tr><tr><td>$adm_notice</td></tr></table><br><br>";
	echo "<table class=braun width=50%><tr class=besch><td><b>Benutzer Statistik / Benutzer die online sind</b></td></tr><tr><td>";
    user_online(true);
	echo "</td></tr></table></td></tr></table><br><br>
	<table class=braun width=50%><tr class=besch><td><b>Detailsbeschreibung</b></td></tr><tr><td> <table><tr><td><b>Foren-Version:</b></td><td>". VERSION ."</td></tr><tr><td><b>Forenentwickler:</b></td><td><a href=http://www.potterfreaks.de>Potterfans</a></td></tr></table> </td></tr></table>";
  break;
  
  
  case "reports_pn":
    left_table($start);
	if(isset($_GET["id"]))
	{
	  mysql_query("UPDATE report_pn SET erledigt = '1' WHERE id LIKE '$_GET[id]'");
	  echo "Danke, die Meldung wurde nun gel�scht.";
	  exit;
	}
	$pn_data = mysql_query("SELECT * FROM report_pn WHERE erledigt = '0'");
	while($pd = mysql_fetch_object($pn_data))
	{
	  $pn_aus = mysql_query("SELECT * FROM prna WHERE id LIKE '$pd->pn_id'");
      $pr = mysql_fetch_object($pn_aus);
	  echo "<fieldset><legend>Informationen zur gemeldeten Nachricht <a href=?do=reports_pn&id=$pd->id>(erledigt)</a></legend>
	  <table><tr><td width=35%>
	  Absender: <a href=?do=ver_user&name=$pr->abse>$pr->abse</a><br>
	  Empf�nger: <a href=?do=ver_user&name=$pr->emp>$pr->emp</a><br>
	  Uhrzeit: ". date("d.m.Y - h:i", $pr->dat) ."<br><br>
	  <b>Betreff:</b> $pr->betreff
	  </td><td valign=top>
	  Gemeldet von: <a href=?do=ver_user&name=$pd->report_from>$pd->report_from</a><br>
	  Meldungsdatum: ". date("d.m.Y - h:i", $pd->report_time) ." <br>
	  Grund: $pd->grund
	  
	  </td></tr></table><br><br>$pr->mes
	  </fieldset><br><br>";
	}
  break;
  
  
  case "inaktiv":
    left_table($user);
	if($_GET["aktion"] == "errinerung")
	{
	  $user_datasz = mysql_query("SELECT * FROM users WHERE username = '". USER ."'");
	  $udsz = mysql_fetch_object($user_datasz);
	  $user_datas = mysql_query("SELECT * FROM users WHERE id = '$_GET[id]'");
	  $uds = mysql_fetch_object($user_datas);
	  $mail = "Hallo $uds->username, <br>
	  du bist im Forum (<a href=$_SERVER[HTTP_HOST]>$_SERVER[HTTP_HOST]</a>) angemeldet.<br>
	  Leider warst du seit l�ngerer Zeit nicht mehr aktiv.<br><br>
	  Das Foren-Team w�rde sich freuen wenn du dem Forum mal wieder ein Besuch abstatten w�rdest.<br><br>
	  Die Foren-Administration";
	  if($_GET["send"] == "true")
	  {
	    $from = "From: $udsz->mail\n";
        $from .= "Reply-To: $udsz->mail\n";
        $from .= "Content-Type: text/html\n";

	    mail($uds->mail, "Inaktivit�t im Forum", $mail,$from);
	    echo "Der Benutzer erh�lt nun eine Erinnerungsmail-eMail.";
	    exit;
	  }
	  echo "M�chtest du folgende Mail an den $uds->username ($uds->mail) schicken?<br><br>$mail<br><br><a href=?do=inaktiv&aktion=errinerung&id=$_GET[id]&send=true>Ja, Mail so an den Benutzer schicken</a>";
	  exit;
	}
	echo "<table class=braun width=50%><tr class=besch><td><b>Inaktive Benutzer (Letzter Login vor mehr als 30 Tagen)</b></td></tr><tr><td>
	    <table>
		<tr><td><b>Benutzername</b></td><td><b>Beitr�ge</b></td><td><b>Letzter Login</b></td><td><b>Aktion</b></td></tr>";
		$time = time() - 2678400;
		$user_data1 = mysql_query("SELECT * FROM users WHERE last_log < $time");
		while($ud1 = mysql_fetch_object($user_data1))
		{
		  echo "<tr><td>$ud1->username</td><td>$ud1->posts</td><td>". date("d.m.Y - h:i", $ud1->last_log) ."</td><td><a href=?do=inaktiv&aktion=errinerung&id=$ud1->id>Erinnerungsmail schicken</a></td></tr>";
		}
		echo "</table>
		</td></tr></table><br><br>
		<br><br>
		<table class=braun width=50%><tr class=besch><td><b>Inaktive Benutzer (Nullposter und letzter Login vor mehr als 2 Tagen)</b></td></tr><tr><td>
		<table>
		<tr><td><b>Benutzername</b></td><td><b>Beitr�ge</b></td><td><b>Letzter Login</b></td><td><b>Aktion</b></td></tr>";
		$time = time() - 172800;
		$user_data1 = mysql_query("SELECT * FROM users WHERE last_log < $time AND posts = 0");
		while($ud1 = mysql_fetch_object($user_data1))
		{
		  echo "<tr><td>$ud1->username</td><td>$ud1->posts</td><td>". date("d.m.Y - h:i", $ud1->last_log) ."</td><td><a href=?do=inaktiv&aktion=errinerung&id=$ud1->id>Erinnerungsmail schicken</a></td></tr>";
		}
	    echo "</td></tr></table><br><br>";
  break;
  
  
  case "ver_mods":
    $add_data = mysql_query("SELECT * FROM addons WHERE admin_link != ''");
	$mods = array();
	while($ad = mysql_fetch_object($add_data))
	{
	   $mods[] = "?do=ver_mods&id=$ad->admin_link|$ad->kurz";
	}
	left_table($mods);
    if($_GET["id"] != "")
	{
	  $path = "../includes/plugins/$_GET[id]";
	  include($path);
	  plugin_admin();
	  exit;
	}

	echo "Hier in diesem Bereich ist es m�glich Addons zu Verwalten.<br> um welche zu installieren musst du <a href=?do=mods>hier</a> klicken.<br><br>Addons findest du bspw. im <a href=http://www.bigforum-support.de target=_blank>Support-Forum</a>";
  break;
  
  
  case "mods":
  admin_recht("4");
  left_table($sons);
  //Mods die die funktion Admin beeinhalten
  if($_GET["aktion"] == "install")
  {
    $path = "../includes/plugins/$_GET[datei]";
    include($path);
    plugin_install($kurzc, $_GET["datei"]);
    echo "Danke, der Mod wurde erfolgreich installiert.";
    exit;
  }
  /*$mod = array("rules.php","last_posts.php","chat.php","addon_basic_modul.php");
  $laeng = count($mod);
  $x = "0";
  echo "Hier hast du eine Verwaltungsm�glichkeit, aller installierten Mods, dieses Systems. Sofern dieser Mod, es zul��t sich �ber das Admincp verwalten zu lassen.<br>Der Titel ist gleichzeitig der Dateiname.php<br><br>";
  for($i=0;$i<$laeng;$i++)
  {
    if(file_exists("../$mod[$i]"))
	{
    $include_path = "../$mod[$i]";
    include($include_path);
	$name = str_replace(".php","",$mod[$i]);
	echo "<fieldset><legend>$name</legend>";
	admin();
	echo "</fieldset>";
	$x = "5";
	}
  }*/
  $handle = opendir ("../includes/plugins");
  while ($datei = readdir ($handle)) {
    if($datei != "." AND $datei != ".." AND $datei != "...")
    {
	  $path = "../includes/plugins/$datei";
	  $short = str_replace(".php","",$datei);
	  include($path);
	  echo "<fieldset><legend>$name_plug</legend>
	  Bitte w�hle eine der folgende Aktion aus, was mit dem Addon passieren soll:<br><br>";
	  $add_data = mysql_query("SELECT * FROM addons WHERE kurz = '$kurzc'");
      $ad = mysql_fetch_object($add_data);
	  if(mysql_num_rows($add_data) == "0")
	  {
	    echo "<a href=?do=mods&aktion=install&datei=$datei>Aktivieren & installieren</a>";
	  }
	  else
	  {
	    echo "Plugin ist bereits aktiviert.";
	  }
	  echo "</fieldset>";
	  $x++;
    }
  }
  if($x == "0")
  {
    echo "Keine Mods installiert, oder keine unterst�tzten eine Verwaltung �ber das Admincp.";
  }
  break;
  
  
  case "design":
  left_table($design);
  admin_recht("3");
  if($_GET["action"] == "insert")
  {
    $config_data = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2closefs'");
    $cd = mysql_fetch_object($config_data);
	$hl = "$cd->wert2 | $_POST[link]";
    mysql_query("UPDATE config SET wert2 = '$hl' WHERE erkennungscode LIKE 'f2closefs'")or die(mysql_error());
	echo "<b>Information:</b> Der Header-Link wurde erfolgreich �berarbeitet.";
  }
  if($_GET["action"] == "noti")
  {
    mysql_query("UPDATE users SET notice = '$_POST[noti]'");
	echo "<b>Information:</b> Die Benutzernotizen wurden erfolgreich �berarbeitet."; 
  }
  if($_GET["action"] == "del_link")
  {
    $config_data = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2closefs'");
    $cd = mysql_fetch_object($config_data);
    $links = explode("|", $cd->wert2);
	$up = $cd->wert2;
    $up = str_replace($links[$_GET["id"]],"",$up);
	$up = str_replace(" |","", $up);
	mysql_query("UPDATE config SET wert2 = '$up' WHERE erkennungscode LIKE 'f2closefs'")or die(mysql_error());
    echo "Danke, wurde gel�scht.";
    exit;
  }
  $config_data = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2closefs'");
  $cd = mysql_fetch_object($config_data);
  // $cd->wert2 => NaviLinks
  echo "
  <script>
  function new_link()
  {
    x = prompt('Bitte gebe die Link-Adresse ein:','http://');
	y = prompt('Bitte gebe den Titel an:','');
	z = confirm('Soll es sich in einem neuem Fenster �ffnen (OK) oder in diesem bleiben (Abbrechen)','')
	a = '<a href=\"'+x+'\"'
	if(z == true)
	{
	  a += ' target=_blank';
	}
	a += '>'+y+'</a>'
	document.feld.link.value = a;
  }
  </script>
  <fieldset><legend>Link in die Navigation</legend>
  Hier kannst du einen neuen Link zur Navigation hinzuf�gen, bitte dr�cke dazu auf \"Link hinzuf�gen\". Bitte nur Links angeben und keine Tabellen etc. Pro 'Best�tigen Dr�cken' bitte nur einen Link. Dr�cke anschlie�end bitte best�tigen.<br>
  <form action=?do=design&action=insert method=post name=feld>
  <input type=text name='link' size=40><input type=submit value='Best�tigen'><input type=button onclick=new_link() value='Link hinzuf�gen'>
  </form>";
  $links = explode("|", $cd->wert2);
  for($c=0;$c<count($links);$c++)
  {
    if($links[$c] != "" AND $links[$c] != " ")
	{
      $l = $links[$c];
	  $l = str_replace("<td>","",$l);
      $l = str_replace("</td>","",$l);
	  $l = str_replace("<tr>","",$l);
      $l = str_replace("</tr>","",$l);
	  $l = str_replace("|","",$l);
      echo "$l <a href=?do=design&action=del_link&id=$c>(L�schen)</a><br>";
	}
  }
  echo "  </fieldset>
  
  
  <br>
  
  
  <fieldset><legend>Header-Anzeige</legend>Hier kannst du eine Nachricht eingeben, welche bei <u>allen</u> Benutzern angezeigt wird. Sollte ein User eine alte Header-Notiz haben, wird diese mit dieser �berschrieben.<br>
  Die Benutzer k�nnen die Header-Notiz, genauwie eine pers�nliche Notiz, �ber den Pers�nlichen Bereich ausbleden. Bei der Userverwaltung kannst Du sehen, was ein Benutzer im Header stehen hat.<br>
  <form action=?do=design&action=noti method=post>
  <input type=text size=40 name=noti><input type=submit value=Speichern></form>";
  break;
  
  
  case "help":
  admin_recht("1");
  left_table($start);
  echo "<table class=braun width=50%><tr class=besch><td><b>Die kleine Administratoren-Hilfe</b></td></tr><tr><td>
  Um �nderungen hier vorzunehmen, benutze bitte erst die obere Navigation (Oberbegriff) und dann die Navigation auf der linken Seite (konkrete �nderung).
  So kannst du dich hier im Administratoren-Kontrollzentrum zu Recht finden.
  <br><br><hr align=center width=15%><br>
  Auf der <b>Startseite</b> gibt es allgemeine Informationen so wie deine Aktuelle Version (". VERSION. "). Desweiteren hast du dort,
  genauso wie auf der Startseite ganz unten, eine Liste der Benutzer, die online sind. Als kleines Extra kannst du hier aber sehen,
  wie viele Benutzer es sind.<br><br><hr align=center width=15%><br>
  Hier hast du eine Liste, mit den wichtigsten Funktionen, die dieses Administrator-Kontrollzentrum zu bieten hat: <br><br>
  <li><a href=?do=phpver>PHP & MySQL �bersicht</a>
  <li><a href=?do=ver_user>Benutzer Verwaltung (Komplette Verwaltungsm�glichkeiten)</a>
  <li><a href=?do=look_logs>Log-Eintr�ge einsehen</a>
  <li><a href=?do=settings>Allgemeine Einstellungen (Private Nachrichten, Signatur etc.)</a>
  <li><a href=?do=ver_foren>Foren & Kategorien �ndern oder l�schen</a>
  <li><a href=?do=new_warn>Verwarnungen verwalten</a>
  <li><a href=?do=sper_user>�bersicht aller gesperrten Benutzer</a>
</td></tr></table>";
  break;
  

  case "phpver":
  left_table($start);
  admin_recht("6");
  echo "<table class=braun width=50%><tr class=besch><td><b>PHP & MySQL - Versionen</b></td></tr><tr><td>
  
  <table>
  <tr><td><b>PHP-Version:</b></td><td> ". phpversion() ."</td></tr>
  <tr><td><b>MySQL-Version:</b></td><td> ";
  mysqlVersion();
  echo "</td></tr>
  </table>
  
  </td></tr></tabel>";
  break;
  
  
  case "ver_user":
    left_table($user);
  admin_recht("5");
  echo "<table class=braun width=70%><tr class=besch><td><b>Benutzerverwaltung</b></td></tr><tr><td>
  Bitte gebe in das nachfolgenden Feld den Benutzernamen ein, den du verwalten willst.<br><br>
  <form action=?do=pro_user method=post>Benutzername: <input type=text name=username value=$_GET[name]><input type=submit value=Suchen></form>
  </td></tr></table>";
  break;
  
  
  case "ver_check":
  left_table($start);
  admin_recht("1");
  $akt_ver = file_get_contents(base64_decode("aHR0cDovL3d3dy5iZnMua2lsdS5kZS9taXNjLnBocD9ha3Rpb249c2hvd192ZXI="));
  if($akt_ver == VERSION)
  {
    echo "<font color=green><b>Herzlichen Gl�ckwunsch:</b> Dein Forum ist auf dem aktuellstem Stand!";
  }
  else
  {
    echo "<font color=red><b>Eine neuere Version von bigforum ist verf�gbar. Du kannst diese im <a href=http://www.bigforum-support.de/kb/>Kundenbereich</a> downloaden.";
  }
  echo "<br><br>
  <table>
  <tr><td><b>Deine Version:</b></td><td>". VERSION ."</td></tr>
  <tr><td><b>Aktuellste Version:</b></td><td>$akt_ver</td></tr></table>";
  break;
  
  
  case "pro_user":
    left_table($user);
    admin_recht("5");
     $user_datas = mysql_query("SELECT * FROM users WHERE username LIKE '$_POST[username]'");
	 $uds = mysql_fetch_object($user_datas);
	 if($uds->id == "")
	 {
	   echo "<table class=braun width=70%><tr class=besch><td><b>Fehler: Benutzername</b></td></tr><tr><td>
       Fehler, dieser Benutzername ist leider nicht vorhanden.<br> Bitte beachte, dass dieser Benutzername vorhanden sein soll.<br><br><a href=?do=ver_user>Nochmal suchen</a><br><br>";
	   $se_da = mysql_query("SELECT * FROM users WHERE username LIKE '%$_POST[username]%'");
	   if(mysql_num_rows($se_da) != "0")
	   {
	     echo "<b>Vorschl�ge:</b><br><br>";
	   }
	   while($sd = mysql_fetch_object($se_da))
	   {
	     echo "<a href=?do=ver_user&name=$sd->username>$sd->username</a><br>";
	   }
	   echo "</td></tr></table>";
	 }
	 else {
	   $gruppe = "Benutzer";
	   if($uds->group_id == "2")
	   {
	     $gruppe = "Moderator";
		 $mod_check = "checked";
	   }
	   if($uds->group_id == "3")
	   {
	     $gruppe = "Administrator";
		 $mod_check = "checked";
		 $adm_check = "checked";
		 if($uds->adm_recht == "6")
		 {
		   $adm_check = "checked disabled";
		 }
	   }
	   if($uds->group_id == "4")
	   {
	     $gruppe = "Gesperrter Benutzer";
	   }
	   if($uds->editrech == "2")
	   {
	     $editr = "checked";
	   }
	   else
	   {
	     $editf = "checked";
	   }
	   if($uds->htmlcan == "1")
	   {
	     $eeditr = "checked";
	   }
	   else
	   {
	     $eeditf = "checked";
	   }
	   if($uds->darf_pn == "0")
	   {
	     $pnr = "checked";
	   }
	   else
	   {
	     $pnf = "checked";
	   }
	   echo "<table><tr valign=top align=top><td><table class=braun width=100%><tr class=besch><td><b>Benutzerdaten - $uds->username</b></td></tr><tr><td>
	   <table><tr><td>
	   <form action=?do=save_userdatas method=post>
	   <b>Benutzername:</b> </td><td> <input type=text name=username value='$uds->username'></td></tr><tr><td>
	   <b>Rang-Titel:</b> </td><td> <input type=text name=rang value='$uds->rang'></td></tr><tr><td>
	   &nbsp; </td></tr>
	   <tr><td><b>Website:</b></td><td><input type=text name=web value='$uds->website'></td></tr>
	   <tr><td><b>Hobbys:</b></td><td><input type=text name=hob value='$uds->hob'></td></tr>
	   <tr><td> &nbsp; </td><td>&nbsp;</td></tr><tr><td>
	   <b>Beitr�ge:</b> </td><td> <input type=text name=bei value=$uds->posts></td></tr><tr><td>
	   <b>eMail:</b> </td><td> <input type=text name=emai value=$uds->mail></td></tr><tr><td>
	   <b>Registriert seit (UNIX!):</b> </td><td> <input type=text name=reg value=$uds->reg_dat> (". date("d.m.Y", $uds->reg_dat).")</td></tr>
	   <tr><td><b>Angezeigte Notiz:</b></td><td> <input type=text name=unot value='$uds->notice' </td></tr></table></td></tr></table>
	   </td><td><table class=braun width=100%><tr class=besch><td><b>Benutzerrechte - $uds->username</b></td></tr><tr><td>
	   <table>
	   <tr><td><b>Zeige Bearbeitet von... Bei Beitragsbearbeitung?</b></td><td width=40%><input type=radio name=editrech value=5 $editf>Ja <input type=radio name=editrech value=2 $editr> Nein</td></tr>
	   <tr><td><b>Darf das Private Nachrichten System nutzen?</b></td><td><input type=radio name=pncan value=0 $pnr>Ja <input type=radio name=pncan value=1 $pnf> Nein</td></tr>
	   <tr><td><b>Darf HTML in Beitr�gen benutzen</b></td><td> <input type=radio name=htmlcan value=1 $eeditr>Ja <input type=radio name=htmlcan value=2 $eeditf> Nein</td></tr>
	   <tr><td> &nbsp; </td><td> &nbsp; </td></tr>
	   <tr><td>	
       <b>Gruppenzugeh�rigkeit</b> </td><td>Super-Moderator: <input type=checkbox name=grup value=2 $mod_check><br>
											Administrator: <input type=checkbox name=grup value=3 $adm_check></td></tr><tr><td>
	   </td></tr>	   
	   </table></td></tr></table></td></tr></table>
	   <table class=braun width=100%><tr class=besch><td><b>Signatur �ndern</b></td></tr><tr><td><table><tr><td>
	   <textarea name=sign rows=6 cols=60>$uds->sign</textarea>
	   </td></tr>
	   </td></tr></table>  
       </td></tr></table>	   <input type=hidden value=$uds->id name=id>
	   <input type=submit value='Speichern'><input type=button value='Benutzer l�schen' onclick=\"window.location.href='?do=del_user&id=$uds->id'\">
	   </form>";
	 }
  break;
  
  case "del_user":
    left_table($user);
    admin_recht("5");
    if($_GET["aktion"] == "sure")
	{
	  mysql_query("DELETE FROM users WHERE id LIKE '$_GET[id]'");
	  echo "Der Benutzer wurde gel�scht.";
	  insert_log("Ein Benutzer (id: $_GET[id]) wurde gel�scht.");
	  exit;
	}
    echo "<b>M�chtest du diesen Benutzer wirklich l�schen? Dieser Schritt ist nichtmehr r�ckg�nig machbar!</b><br><br>
    <input type=button value='Ja, Benutzer l�schen' onclick=\"window.location.href='?do=del_user&aktion=sure&id=$_GET[id]'\">  <input type=button value='Nein, Benutzer nicht l�schen' onclick=\"window.location.href='admin.php'\">";
  break;
  
  case "zuruck":
    left_table($user);
  echo "W�hle aus, welche Recht du bei <b>allen</b> Benutzern zur�cksetzen m�chtest:<br><br>
  <li><a href=?do=change_htmlcan>HTML Benutzen => Alle auf \"nein\" setzen</a>
  <li><a href=?do=change_headern>Header-Notiz => Alle ausblenden</a>";
  break;
  
  case "change_headern":
  	insert_log("Notiz im Header wurde bei allen Benutzern gel�scht");
    left_table($user);
    mysql_query("UPDATE users SET notice = ''");
    echo "Es wird nun keinem Benutzer mehr eine Notiz im Header angezeigt.";
  break;
  
  case "change_htmlcan":
  	insert_log("Alle Benutzer d�rfen kein HTML mehr benutzen");
    left_table($user);
    mysql_query("UPDATE users SET htmlcan = '3'");
    echo "Es wurde nun allen Benutzern verboten HTML zu benutzen.";
  break;
  
  
  case "not_use":
      left_table($user);
	  if($_GET["action"] == "del")
	  {
	    mysql_query("DELETE FROM verbo WHERE id LIKE '$_GET[id]'");
	    echo "<b>Information:</b> Die angegebene Sache wurde gel�scht.<br><br>";
	  }
	  if($_GET["action"] == "insert")
	  {
	    $data = mysql_query("SELECT * FROM verbo WHERE name LIKE '$_POST[verbo]' AND benemail LIKE '$_POST[bemail]'");
		if(mysql_num_rows($data) == "0")
		{
	      mysql_query("INSERT INTO verbo (name, benemail) VALUES ('$_POST[verbo]','$_POST[bemail]')");
		  echo "Danke, $_POST[name] wurde hinzugef�gt.<br> <a href=?do=not_use>Zur�ck zur �bersicht</a>";
		}
		else
		{
		  echo "Dieser Benutzername bzw. diese Mail-Adresse exestiert bereits.";
		}
	    exit;
	  }
	  $verho = mysql_query("SELECT * FROM verbo");
	  echo "<table><tr><td><div style=\"overflow:auto;width:400px;height:300px;\">
	  <table><tr><td><b>Verbot</b></td><td><b>Eigenschaft</b></td><td><b>Aktion</b></td></tr>";
	  while($vh = mysql_fetch_object($verho))
	  {
	    if($vh->benemail == "1")
		{
		  $be = "eMail";
		}
		if($vh->benemail == "2")
		{
		  $be = "Benutzername";
		}
		echo "<tr><td>$vh->name</td><td>$be</td><td><a href=?do=not_use&action=del&id=$vh->id>L�schen</a></td>";
	  }
	  echo "</table></td></tr></table><hr>
	  <b>Neues Verbot von Benutzernamen / eMail-Adresse hinzuf�gen:<br><br>
	  <form action=?do=not_use&action=insert method=post><input type=text name=verbo><select name=bemail><option value=1>eMail-Adresse</option><option value=2>Benutzername</option></select><br><input type=submit value=Speichern></form>";
  break;
  
  
  case "save_userdatas":
    left_table($user);
       $user_datas = mysql_query("SELECT * FROM users WHERE id LIKE '$_POST[id]'");
	 $uds = mysql_fetch_object($user_datas);
  admin_recht("5");
  check_data($_POST["username"], "", "Bitte f�hle alle Felder aus (Benutzername!)", "leer");
  check_data($_POST["rang"], "", "Bitte f�hle alle Felder aus (Benutzerrang!)", "leer");
  check_data($_POST["bei"], "", "Bitte f�hle alle Felder aus (Beitr�ge!)", "leer");
  check_data($_POST["reg"], "", "Bitte f�hle alle Felder aus (Registrierungsdatum!). Denke bitte an die Unixtime.", "leer");  
  check_data($_POST["username"], "3", "Der angegebene Benutzername ist zu kurz!", "laenge");
  if($_POST["grup"] != "2" AND $_POST["grup"] != "3")
  {
    $_POST["grup"] = "1";
  }
  mysql_query("UPDATE users SET
            username  = '$_POST[username]',
			rang      = '$_POST[rang]',
			posts	  = '$_POST[bei]',
			reg_dat   = '$_POST[reg]',
			group_id  = '$_POST[grup]',
			notice    = '$_POST[unot]',
			sign      = '$_POST[sign]',
			mail      = '$_POST[emai]',
			website   = '$_POST[web]',
			hob       = '$_POST[hob]',
			editrech  = '$_POST[editrech]',
			htmlcan   = '$_POST[htmlcan]',
			darf_pn   = '$_POST[pncan]',
			adm_recht = '$uds->adm_recht' WHERE id LIKE '$_POST[id]'");
	insert_log("Profil von $_POST[username] wurde ge�ndert.");
  echo "Danke,<br> das Profil von $_POST[username] wurde erfolgreich �berarbeitet.<br><br><a href=admin.php>Zur�ck zur Administratorern-�bersicht</a>";
  break;
  
  
  case "look_logs":
  left_table($sons);
  admin_recht("2");
  if($_GET["action"] == "del")
  {
    $log_dat = mysql_query("SELECT * FROM admin_logs");
    while($ld = mysql_fetch_object($log_dat))
	{
	    if($_POST["$ld->id"] == "1")
		{
	      mysql_query("DELETE FROM admin_logs WHERE id LIKE '$ld->id'");
		}
	}
	echo "Die ausgew�hlten Log-Eintr�ge wurden gel�scht.";
  }
  if(!isset($seite))
  {
    $seite = "1";
  } 
  $eintraege_pro_seite = "30";
  $start = $seite * $eintraege_pro_seite - $eintraege_pro_seite;
  $eintraege = mysql_query("SELECT id FROM admin_logs");
  $menge = mysql_num_rows($eintraege); 
  $wieviel_seiten = $menge / $eintraege_pro_seite;

  echo "<table class=braun width=70%><tr class=besch><td><b>Log-Eintr�ge (<b>Seite:</b> ";
  for($a=0; $a < $wieviel_seiten; $a++)
   {
   $b = $a + 1;
   if($seite == $b)
      {
      echo "  <b>$b</b> ";
      }
   else
      {
      echo "  <a href=\"?do=look_logs&seite=$b\">$b</a> ";
      }


   } 
  echo ")</b></td></tr><tr><td>";
  $logs_hole = mysql_query("SELECT * FROM admin_logs ORDER BY id DESC LIMIT $start, $eintraege_pro_seite");
  echo "<form action=?do=look_logs&action=del method=post><table>
  <tr style=font-weight:bold><td>Benutzername</td><td>Zeitpunkt</td><td>Aktion</td><td>IP-Adresse</td><td></td></tr>";
  while($lh = mysql_fetch_object($logs_hole))
  {
    $datum = date("d.m.Y - H:i", $lh->time);
    echo "<tr><td> $lh->username </td><td> $datum </td><td> $lh->aktio </td><td> $lh->ipadr </td><td><input type=checkbox name=$lh->id value=1></td></tr>";
  }
  echo "<tr><td></td><td></td><td></td><td></td><td><input type=submit value=L�schen></td></tr></table>
  </form>
  </td></tr></table>";
  break;
  
  
  case "change_notice":
  admin_recht("3");
  left_table($start);
  if($_GET["aktion"] == "change")
  {
    mysql_query("UPDATE config SET wert1 = '$_POST[foren_notice]' WHERE erkennungscode LIKE 'f2usearch2'");
	echo "Die Administratoren-Notiz wurde erfolgreich ge�ndert.<br><br><a href=admin.php>Zur�ck zur Startseite</a>";
	insert_log("Administratoren-Notiz wurde ge�ndert.");
	fclose($datei);
    exit;
  }
  	$config_data = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2usearch2'");
    $cd = mysql_fetch_object($config_data);
	$adm_notice = $cd->wert1;
  echo "<table class=braun width=80%><tr class=besch><td><b>Administratoren-Notiz �ndern</b></td></tr><tr><td>
  <form action=?do=change_notice&aktion=change method=post><textarea maxlength=50000 cols=70 rows=7 name=foren_notice>$adm_notice</textarea><input type=submit value=Speichern></form>
  </td></tr></table>";
  break;
  
  
  case "settings_admincp":
  left_table($sons);
  admin_recht("3");
  $admin_data = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2admin2'");
  $ad = mysql_fetch_object($admin_data);
  if($_GET["aktion"] == "change")
  {
    mysql_query("UPDATE config SET zahl1 = $_POST[bfs] WHERE erkennungscode LIKE 'f2admin2'");
	echo "Danke, die Kontrollzentrum-Einstellungen wurden ge�ndert.";
	exit;
  }
  if($ad->zahl1 == "0")
  {
    $bfs = "checked";
  }
  else
  {
    $bfss = "checked";
  }
  echo "<table class=braun align=top valign=top><tr class=besch align=top valign=top><td><b>Kontrollzentrum-Einstellungen</b></td></tr><tr><td>
  <form action=?do=settings_admincp&aktion=change method=post>
  <table align=top valign=top>
  <tr><td>Bei bfs Automatisch zum Support-Forum?</td><td><input type=radio name=bfs value=0 $bfs>Ja <input type=radio name=bfs value=1 $bfss>Nein</td></tr></table><input type=submit value=Abschicken></form>";
  break;
  
  case "settings":
  left_table($sons);
  admin_recht("3");
  if($_GET["aktion"] == "change")
  {
    if($_POST["grafp"] == "pack1")
	{
	  $gpack = "images/no_posts.gif";
	  $gpackt = "images/posts.gif";
	  $number = "1";
	}
	if($_POST["grafp"] == "pack2")
	{
	  $gpack = "images/old_post.png";
	  $gpackt = "images/new_post.png";
	  $number = "2";
	}
	if($_POST["grafp"] == "pack3")
	{
	  $gpack = "images/old_1.png";
	  $gpackt = "images/new_1.png";
	  $number = "3";
	}
	if($_POST["grafp"] == "pack4")
	{
	  $gpack = "images/braun_alt.png";
	  $gpackt = "images/braun_neu.png";
	  $number = "4";
	}
	if($_POST["grafp"] == "pack5")
	{
	  $gpack = "images/old_red.png";
	  $gpackt = "images/new_green.png";
	  $number = "5";
	}
	$config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2laengfs'");
    $con = mysql_fetch_object($config_wert); 
	if($_POST["styl"] != $con->wert2)
	{
	  mysql_query("UPDATE users SET style = '$_POST[styl]'");
	}
	if($_POST["logo"] == "other")
	{
	  $_POST["logo"] = $_POST["logon"];
	}
    check_data($_POST["fn"], "", "Bitte gebe einen Forum-Name ein.", "leer");
	check_data($_POST["besch"], "", "Bitte gebe einen Foren-Beschreibung ein.", "leer");
	mysql_query("UPDATE config SET wert1 = '$_POST[diagr]' WHERE erkennungscode LIKE 'f2adser2'");
    mysql_query("UPDATE config SET wert1 = '$_POST[fn]', wert2 = '$_POST[besch]' WHERE erkennungscode LIKE 'f2name2'");
    mysql_query("UPDATE config SET wert2 = '$_POST[logo]', zahl1 = '$_POST[sign]', zahl2 = '$_POST[pn]' WHERE erkennungscode LIKE 'f2pnsignfs'");
    mysql_query("UPDATE config SET wert1 = '$gpack', wert2 = '$gpackt', zahl1 = '$number' WHERE erkennungscode LIKE 'f2imgadfs'");   
    mysql_query("UPDATE config SET wert1 = '$_POST[clos_text]', zahl1 = '$_POST[close]' WHERE erkennungscode LIKE 'f2closefs'");   
    mysql_query("UPDATE config SET zahl1 = '$_POST[fstat]', zahl2 = '$_POST[email]' WHERE erkennungscode LIKE 'f2mf2'");   //Forenstat/Mail
    mysql_query("UPDATE config SET wert1 = '$_POST[bfav]', wert2 = '$_POST[styl]', zahl1 = '7', zahl2 = '$_POST[smilie]' WHERE erkennungscode LIKE 'f2laengfs'");   
    mysql_query("UPDATE config SET wert1 = '$_POST[st]', zahl2 = '$_POST[pro]' WHERE erkennungscode LIKE 'f2profs'");   
	mysql_query("UPDATE config SET zahl1 = '$_POST[bmin]', zahl2 = '$_POST[bmax]' WHERE erkennungscode LIKE 'f2bl2'");   //Benutzername (minimal/maximal)
	mysql_query("UPDATE config SET zahl1 = '$_POST[bensuch]', zahl2 = '$_POST[rss]' WHERE erkennungscode LIKE 'f2usearch2'");   //Benutzersuche aktivieren

	echo "Danke, die Foreneinstellungen wurden ge�ndert!";
	insert_log("Die Foreneinstellungen wurden �berarbeitet.");
	exit;
  }
  set_tab("f2pnsignfs");
    echo "<table class=braun><tr class=besch><td><b>Allgemeine Foreneinstellungen festlegen.</b></td></tr><tr><td>
    <form action=?do=settings&aktion=change method=post>
	<table>
	<tr><td>Forum-Name</td><td><input type=text name=fn size=40 value='". SITENAME ."'></td></tr>
	<tr><td> &nbsp; </td><td><input type=hidden name=besch size=40 value='". BESCHREIBUNG ."'></td></tr>
	<tr><td>Signatur-Erlauben</td><td> Ja<input type=radio name=sign value=1  onclick=\"javascript:info('')\"";  if(ZAHLE == "1")
  {
    echo "checked";
  }echo" >  Nein<input type=radio name=sign value=2 onclick=\"javascript:info('Es werden keine Signaturen mehr angezeigt.')\"";  if(ZAHLE != "1")
  {
    echo "checked";
  }echo" ></td></tr>
	<tr><td>Private Nachrichten erlauben</td><td> Ja<input type=radio name=pn value=1 onclick=\"javascript:info('')\"";  if(ZAHLZ == "1")
  {
    echo "checked";
  }echo" >  Nein<input type=radio name=pn value=2 onclick=\"javascript:info('Komplette Nachrichtensystem ist deaktiviert.')\"";  if(ZAHLZ != "1")
  {
    echo "checked";
  }  

  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2imgadfs'");
  $con = mysql_fetch_object($config_wert);
  if($con->zahl1 == "1")
  {
    $pack = "<option value=pack1 >Packet 1 - Buchstaben</option><option value=pack5 >Packet 5 - Sprechblasen Gr�n/Rot</option><option value=pack2>Packet 2 - Runde Buttons</option><option value=pack3 >Packet 3 - Eckige Farbige Buttons</option><option value=pack4 >Packet 4 - Braune Eckige Buttons (Papier)</option>";
  }
  if($con->zahl1 == "2")
  {
    $pack = "<option value=pack2 >Packet 2 - Runde Buttons</option><option value=pack5 >Packet 5 - Sprechblasen Gr�n/Rot</option><option value=pack1 >Packet 1 - Buchstaben</option><option value=pack4 >Packet 4 - Braune Eckige Buttons (Papier)</option><option value=pack3 >Packet 3 - Eckige Farbige Buttons</option>";
  }
  if($con->zahl1 == "3")
  {
    $pack = "<option value=pack3 >Packet 3 - Eckige Farbige Buttons</option><option value=pack5 >Packet 5 - Sprechblasen Gr�n/Rot</option><option value=pack4 >Packet 4 - Braune Eckige Buttons (Papier)</option><option value=pack1 >Packet 1 - Buchstaben</option><option value=pack2 >Packet 2 - Runde Buttons</option>";
  }
  if($con->zahl1 == "4")
  {
    $pack = "<option value=pack4 >Packet 4 - Braune Eckige Buttons (Papier)</option><option value=pack5 >Packet 5 - Sprechblasen Gr�n/Rot</option><option value=pack3 >Packet 3 - Eckige Farbige Buttons</option><option value=pack1 >Packet 1 - Buchstaben</option><option value=pack2 >Packet 2 - Runde Buttons</option>";
  }
  if($con->zahl1 == "5")
  {
    $pack = "<option value=pack5 >Packet 5 - Sprechblasen Gr�n/Rot</option><option value=pack4 >Packet 4 - Braune Eckige Buttons (Papier)</option><option value=pack3 >Packet 3 - Eckige Farbige Buttons</option><option value=pack1 >Packet 1 - Buchstaben</option><option value=pack2 >Packet 2 - Runde Buttons</option>";
  }
  echo" ></td></tr>
  <tr><td>Information:</td><td> <span id=info></span> </td></tr>
  <tr><td> &nbsp; </td><td> &nbsp; </td></tr>
  <tr><td> Grafik-Packet auf der Startseite </td><td><select name=grafp>$pack</select></td></tr> ";
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2laengfs'");
  $con = mysql_fetch_object($config_wert); 
  $sp = $con->zahl2;
  if($sp == "1")
  {
    $packt = "<option value=1>Altes Packet</option><option value=2>Neues Packet</option>";
  }
  if($sp == "2")
  {
    $packt = "<option value=2>Neues Packet</option><option value=1>Altes Packet</option>";
  }
  echo "<tr><td>Smilie-Pack</td><td><select name=smilie>$packt</select>
  <tr><td> &nbsp; </td><td> &nbsp; </td></tr>";
  echo "<tr><td>Forum-Standart Style:</td><td><select name=styl>";
  	$style_data = mysql_query("SELECT * FROM style_all");
	while($sd = mysql_fetch_object($style_data))
	{
	  if($con->wert2 == $sd->sname)
	  {
	    echo "<option value='$sd->sname' selected=selected>$sd->sname</option>";
	  }
	  else
	  {
	  	echo "<option value='$sd->sname'>$sd->sname</option>";
	  }
	}
	if(WERTZ == "images/logo_new.png")
	{
	  $logo = "<input type=radio name=logo value=images/logo_new.png checked>Alternatives Logo<br>
	  <input type=radio name=logo value=images/bf_stars.png>Logo mit Sternen<br>
	  <input type=radio name=logo value=other>Anderer<br>
	  <input type=text name=logon value=''>";
	}
	if(WERTZ == "images/bf_stars.png")
	{
	  $logo = "<input type=radio name=logo value=images/logo_new.png>Alternatives Logo<br>
	  <input type=radio name=logo value=images/bf_stars.png checked>Logo mit Sternen<br>
	  <input type=radio name=logo value=other>Anderer<br>
	  <input type=text name=logon value=''>";
	}
	else
	{
	  $logo = "<input type=radio name=logo value=images/logo_new.png>Alternatives Logo<br>
	  <input type=radio name=logo value=images/bf_stars.png>Logo mit Sternen<br>
	  <input type=radio name=logo value=other checked>Anderer<br>
	  <input type=text name=logon value ='". WERTZ ."'>";
	}
  echo"</select>
  <tr><td> &nbsp; </td><td> &nbsp; </td></tr>  
  <tr><td> Bild-Adresse f�r Forum-Favicon </td><td> <input type=text name=bfav value=$con->wert1> </td></tr>  
  <tr><td> Bild-Adresse f�r Forum-Logo</td><td>$logo</td></tr>
  <tr><td> &nbsp; </td><td> &nbsp; </td></tr>  ";
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2profs'");
  $con = mysql_fetch_object($config_wert); 
  if($con->zahl2 == "1")
  {
    $prof_pack = "<input type=radio name=pro value=1 checked>Ja <input type=radio name=pro value=2>Nein";
  }
  if($con->zahl2 != "1")
  {
    $prof_pack = "<input type=radio name=pro value=1>Ja <input type=radio name=pro value=2 checked>Nein";
  }
  if($con->wert1 == "j")
  {
    $st = "<input type=radio name=st value=j checked>Ja <input type=radio name=st value=n>Nein";
  }
  if($con->wert1 != "j")
  {
    $st = "<input type=radio name=st value=j>Ja <input type=radio name=st value=n checked>Nein";
  }
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2adser2'");
  $con = mysql_fetch_object($config_wert); 
  if($con->wert1 == "kreis")
  {
    $stad = "<input type=radio name=diagr value=kreis checked>Kreisdiagramm <input type=radio name=diagr value=balken>Balkendiagramm ";
  }
  else
  {
      $stad = "<input type=radio name=diagr value=kreis>Kreisdiagramm <input type=radio name=diagr value=balken checked>Balkendiagramm ";
  }
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2mf2'");
  $con = mysql_fetch_object($config_wert); 
  if($con->zahl1 == "1")
  {
    $fstat = "<input type=radio name=fstat value=1 checked>Ja <input type=radio name=fstat value=0>Nein ";
  }
  else
  {
    $fstat = "<input type=radio name=fstat value=1>Ja <input type=radio name=fstat value=0 checked>Nein ";
  }
  if($con->zahl2 == "1")
  {
    $email = "<input type=radio name=email value=1 checked>Ja <input type=radio name=email value=0>Nein ";
  }
  else
  {
    $email = "<input type=radio name=email value=1>Ja <input type=radio name=email value=0 checked>Nein ";
  }
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2usearch2'");
  $con = mysql_fetch_object($config_wert); 
  if($con->zahl1 == "1")
  {
    $besu = "<input type=radio name=bensuch value=1 checked>Ja <input type=radio name=bensuch value=0>Nein ";
  }
  else
  {
    $besu = "<input type=radio name=bensuch value=1>Ja <input type=radio name=bensuch value=0 checked>Nein ";
  }
  if($con->zahl2 == "1")
  {
    $rss = "<input type=radio name=rss value=1 checked>Ja <input type=radio name=rss value=0>Nein ";
  }
  else
  {
    $rss = "<input type=radio name=rss value=1>Ja <input type=radio name=rss value=0 checked>Nein ";
  }
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2bl2'");
  $con = mysql_fetch_object($config_wert); 
  echo "
  <tr><td>G�ste d�rfen Profile sehen?</td><td>$prof_pack</td></tr>
  <tr><td>Zeige erweiterte Statistik auf der Startseite?</td><td>$st</td></tr>
  <tr><td> &nbsp; </td><td> &nbsp </td></tr>
  <tr><td>Benutzersuche aktivieren (Mitgliederliste)?</td><td>$besu</td></tr>
  <tr><td> &nbsp; </td><td> &nbsp </td></tr>
  <tr><td>Aktiviere RSS-Feed</td><td>$rss</td></tr>
  <tr><td> &nbsp; </td><td> &nbsp </td></tr>
  <tr><td> Minimale Benutzernamenl�nge </td><td> <input type=text name=bmin value='$con->zahl1'> </td></tr>
  <tr><td> Maximale Benutzernamenl�nge </td><td> <input type=text name=bmax value='$con->zahl2'> </td></tr>
  <tr><td> &nbsp; </td><td> &nbsp </td></tr>
  <tr><td>Anzeige der Statistik-Diagramme</td><td>$stad</td></tr>
  <tr><td> &nbsp; </td><td> &nbsp </td></tr>
  <tr><td>Anzeige der 'Du darfst..'-Regeln bei der Foren�bersicht</td><td>$fstat</td></tr>
  <tr><td>eMail-Versand vom Forum aus?</td><td>$email</td></tr>  <tr><td> &nbsp; </td><td> &nbsp </td></tr>";
  
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2closefs'");
  $con = mysql_fetch_object($config_wert); 
  echo"
  <tr><td> Forum geschlo�en </td><td> ";
  if($con->zahl1 == "0")
  {
    echo "<input type=radio name=close value=0 checked> Ja <input type=radio name=close value=1> Nein";
  }
  if($con->zahl1 == "1")
  {
    echo "<input type=radio name=close value=0> Ja <input type=radio name=close value=1 checked> Nein";
  }
  echo "</td></tr>  
  <tr><td> Text bei Schlie�ung </td><td> <input type=text name=clos_text value='$con->wert1' size=40> </td></tr>
  <tr><td><input type=submit value=Speichern></td><td></td></tr>
	</table>
	</form>
	</td></tr></table>";
  break;
  
  
  case "recht":
   left_table($user);
  admin_recht("6");
  if($_GET["aktion"] == "do")
  {
    $user_admin = mysql_query("SELECT * FROM users WHERE group_id LIKE '3'");
	while($uac = mysql_fetch_object($user_admin))
	{
	  if($uac->adm_recht == "6")
	  {
	    $rechte = "6";
	  }
	  else
	  {
	    $rechte = $_POST["$uac->username"];
	  }
	  mysql_query("UPDATE users SET adm_recht = '$rechte' WHERE username LIKE '$uac->username'");
	}
	insert_log("Administratoren-Rechte wurden �berarbeitet");
  }
  echo "<table class=braun width=80%><tr class=besch><td><b>Administratoren-Rechte festlegen</b></td></tr><tr><td>
  <form action=?do=recht&aktion=do method=post><table>
  <tr style=font-weight:bold><td>Benutzername</td><td>Darf Startseite sehen</td><td>... darf Log-Eintr�ge sehen</td><td>...darf Foreneinstellungen �ndern</td><td>... darf Foren verwalten</td><td>...darf Benutzer verwalten</td><td>Ist Gr�nder</td></tr>";
  $user_admin = mysql_query("SELECT * FROM users WHERE group_id LIKE '3'");
  while ($ua = mysql_fetch_object($user_admin))
  {
    echo "<tr>";
    for($i = "0"; $i < "7"; $i++)
	{
	  if($i == "0")
	  {
	    echo "<td>$ua->username</td>";
	  }
	  else
	  {
	    $checked = "";
		$dis     = "";
	    if($ua->adm_recht == $i)
	    {
	      $checked = "checked";
	    }
		if($ua->adm_recht == "6")
		{
		  $dis = "disabled";
		}
	    echo "<td><input type=radio name=$ua->username value=$i $checked $dis></td>";
	  }
	}
    echo "</tr>";
  }
  echo "</table><input type=submit value='Rechte speichern'>";
  echo "</form></td></tr></table><br><br>";
    echo "<table class=braun width=80%><tr class=besch><td><b>Rechte Hilfe</b></td></tr><tr><td>
	<b>Darf Startseite sehen:</b>Der Administrator darf lediglich die Startseite und die Administratoren-Hilfe sehen.<br><br>
	<b>Darf Log-Eintr�ge sehen:</b> Hat volle Rechte auf Log-Eintr�ge.<br><br>
	<b>Darf Foreneinstellungen �ndern:</b> Darf alle m�glichen Foreneinstellungen so wie den Foren-Titel, die Foren-Beschreibung usw. ver�ndern. Desweiteren darf auch die Administratoren-Notiz ab diesem Level ver�ndert werden.<br><br>
	<b>Darf Foren verwalten:</b> Darf bestehenden Foren bzw. Kategorien �ndern, neue hinzuf�gen und Rechte f�r diese ver�ndern. Ab dieser Stufe d�rfen auch Addons / Mods verwaltet werden.<br><br>
	<b>Darf Benutzer verwalten:</b> Darf Benutzer verwalten, d.h. diesen Gruppen zuordnen bzw. Rang-Titel oder Beitr�ge �ndern. Das Recht Benutzer zu verwarnen bzw. zu sperren haben auch Moderatoren!<br><br>
	<b>Ist Gr�nder:</b> Benutzer darf alles �ndern, d.h. Administratoren-Rechte vergeben und Serverseitige Funktionen einsehen,<br><br><br>
	
	Alle Rechte sind der gr��e nach sotiert, d.h. wer Benutzer verwalten darf, kann auch die Foreneinstellungen �ndern, und wer Foreneinstellungen sehen/�ndern kann, kann auch Logs einsehen!
	</td></tr></table>";
  break;
  
  
  case "new_foren":
  admin_recht("4");
    left_table($for);
    if($_GET["action"] == "insert")
	{
	  if($_POST["foka"] == "kate")
	  {
	    mysql_query("INSERT INTO kate (name, besch) VALUES ('$_POST[fname]', '$_POST[besch]')");
		echo "Die Kategorie wurde hinzugef�gt.";
		insert_log("Es wurde eine neue Kategorie hinzugef�gt");
	  }
	  else
	  {
	    mysql_query("INSERT INTO foren (name, besch, kate, guest_see, min_posts, admin_start_thema, user_posts, sort, beitrag_plus) VALUES ('$_POST[fname]', '$_POST[besch]', '$_POST[kat]', '$_POST[guest]', '$_POST[min_post]', '$_POST[admin]', '$_POST[ansus]', '$_POST[sort]', '$_POST[hoch]')") or die(mysql_error());
	    echo "Das Forum wurde hinzugef�gt.";
		insert_log("Es wurde ein neues Forum hinzugef�gt");
	  }
	  exit;
	}
    echo "<table class=braun width=80%><tr class=besch><td><b>Neues Forum erstellen</b></td></tr><tr><td>
	<form action=?do=new_foren&action=insert method=post>
	<table width=100%>
	<tr><td width=50%>Kategorie oder Forum?</td><td><select name=foka><option value=kate>Kategorie</option><option value=foren>Forum</option>select></td></tr>
	<tr><td>Name/Link-Text:</td><td><input type=text size=40 name=fname></td></tr>
	<tr><td>Beschreibung/Link-Adresse:</td><td><input type=text size=40 name=besch></td></tr>
	</table>
	<br><b>Nachfolgende Eingaben werden nur bei einer Foren-Erstellung ben�tigt.</b><br><br>
	<table width=100%>
	<tr><td>In welcher Kategorie?</td><td><select name=kat>";
	$kate_data = mysql_query("SELECT * FROM kate");
	while($kd = mysql_fetch_object($kate_data))
	{
	  echo "<option value=$kd->id>$kd->name</option>";
	}
	echo "</select></td></tr>
	<tr><td width=50%>Wer soll Zugriff auf das Forum haben?</td><td><select name=guest><option value=0>Alle d�rfen es sehen</option><option value=1>Nur angemeldete Mitglieder</option><option value=2>Nur Administratoren oder Moderatoren</option></td></tr>
	<tr><td>Nur Administratoren d�rfen Themen erstellen?</td><td><select name=admin><option value=1>Nein</option><option value=0>Ja</option><option value=2>Moderatoren und Administratoren</option></td></tr>
	<tr><td>D�rfen Benutzer/Moderatoren antworten?</td><td><select name=ansus><option value=0>Ja</option><option value=1>Nein</option></td></tr>
	<tr><td>Wie viele Beitr�ge muss man haben, um Zugriff auf das Forum zu bekommen?</td><td><input type=text name=min_post></td></tr>
	<tr><td>Sortierung, die Foren werden so geordnet, auf der Startseite</td><td><input type=text name=sort></td></tr>
	<tr><td>Beitragsz�hler wird bei Beitrag erh�ht?</td><td><input type=radio name=hoch value=0 checked>Ja <input type=radio name=hoch value=1> Nein</td></tr>
	</table><br>
	<input type=submit value='Forum erstellen'>
	</form>
	";
  break;
  
  
  case "new_warn":
  left_table($sons);
  admin_recht("5");
  if($_GET["action"] == "insert")
  {
    check_data($_POST["points"], "", "Bitte f�hle alle Felder aus (Verwarnpunkte)", "leer");
    check_data($_POST["dauer"], "", "Bitte f�hle alle Felder aus (Dauer)", "leer");
    mysql_query("INSERT INTO verwarn_gruend (grund, punkte, zeit) VALUES ('$_POST[grund]', '$_POST[points]', '$_POST[dauer]')");
    echo "Danke, Grund wurde hinzugef�gt und kann nun verwendet werden.<br><a href=admin.php?do=new_warn>Zur�ck</a>";
    insert_log("Verwarngrund wurde hinzugef�gt");
	exit;
  }
  if($_GET["action"] == "del")
  {
    mysql_query("DELETE FROM verwarn_gruend WHERE id LIKE '$_GET[id]'");
  }
  echo "<table class=braun width=80%><tr class=besch><td><b>Bestehende Gr�nde</b></td></tr><tr><td><table>
  <tr style=font-weight:bold><td>Grund</td><td>Punkte</td><td>Dauer</td><td>Aktion</td></tr>";
  $gr_ho = mysql_query("SELECT * FROM verwarn_gruend ORDER BY punkte");
  while($gh = mysql_fetch_object($gr_ho))
  {
    $zeit = $gh->zeit;
	$wl = sizeof ($warn_dauer);
    for($i=0;$i<$wl;$i++)
	{
	  if($zeit == $warn_dauer[$i])
	  {
	    $zeit = $warn_text[$i];
		echo "<tr><td>$gh->grund</td><td>$gh->punkte</td><td>$zeit</td><td><a href=?do=new_warn&action=del&id=$gh->id>L�schen</a></tr>";
	  }
	}

  }
  echo "</table></td></tr></table><br><br>
  <table class=braun width=80%><tr class=besch><td><b>Verwarngrund hinzuf�gen</b></td></tr><tr><td>
  <form action=?do=new_warn&action=insert method=post>
  <table>
  <tr><td>Grund:</td><td><input type=text name=grund></td></tr>
  <tr><td>Punkte:</td><td><input type=text size=5 name=points></td></tr>
  <tr><td>Dauer:</td><td><select name=dauer>";
  for($v=0;$v<sizeof($warn_text);$v++)
  {
    echo "<option value=$warn_dauer[$v]>$warn_text[$v]</option>";
  }
  echo "</select></td></tr></table>
  <input type=submit value=Speichern>
  </form>
  </td></tr></table>";
  
  
  
  break;
  
  
  case "sper_user":
  left_table($user);
  $time = time();
  if($_GET["action"] == "del")
  {
    insert_log("Sperre eines Benutzers wurde aufgehoben");
    mysql_query("UPDATE users SET gesperrt = '0', sptime = '0' WHERE id LIKE '$_GET[id]'");
	echo "Die Sperre von diesem Benutzer (ID: $_GET[id]) wurde zur�ckgenommen.";
	exit;
  }
  if($_GET["action"] == "new")
  {
    $u_da = mysql_query("SELECT * FROM users WHERE username LIKE '$_POST[ben]'");
	$ua = mysql_fetch_object($u_da);
	if($ua->group_id == "3")
	{
	  echo "<b>Information:</b> Du kannst keine Administratoren sperren!";
	  exit;
	}
	if($ua->username == "")
	{
	  echo "<b>Information:</b> Dieser Benutzername exestiert nicht!";
	  exit;
	}
	if($_POST["dauer"] == "other")
	{
	  insert_log("Ein Benutzer wurde gesperrt");
	  $dauer = mktime(0,0,0,$_POST["month"],$_POST["tag"],$_POST["year"]);
	  $spertime = ceil($dauer/600)*600;  
	  mysql_query("UPDATE users SET gesperrt = '1', sptime = '$spertime' WHERE username LIKE '$_POST[ben]'");
	  echo "$_POST[ben] wurde nun vom Forum ausgeschlossen. Er ist bis zum ". date("d.m.Y", $spertime) ." gesperrt.";
	  exit;
	}
	insert_log("Ein Benutzer wurde gesperrt");
	$spertime = $_POST["dauer"];
	mysql_query("UPDATE users SET gesperrt = '1', sptime = '$spertime' WHERE username LIKE '$_POST[ben]'");
	echo "$_POST[ben] wurde nun vom Forum ausgeschlossen.";
	exit;
  }

  $sperr_data = mysql_query("SELECT * FROM users WHERE sptime > '$time'");
  $sp = "0";
  echo "
  <script>
	function other(das) {
    document.getElementById(das).style.display='block';
    document.getElementById('zwei').style.display='block';
	}
	function nother(das) {
	document.getElementById(das).style.display='none';
    document.getElementById('zwei').style.display='none';
	}

	</script>
  <form action=?do=sper_user&action=new method=post><table>
  <tr><td>Benutzername: </td><td><input type=text name=ben></td></tr>
  <tr><td>Dauer:</td><td><select name=dauer>";
  for($v=0;$v<sizeof($warn_text);$v++)
  {
    $sperrtime = time()+$warn_dauer[$v];
	$st = ceil($sperrtime/600)*600;  
    echo "<option value=$st onclick=nother('eins')>$warn_text[$v] (". date("d.m.Y - H:i", $st) .")</option>";
  }
  echo "<option disabled>------</option><option onclick=other('eins') value=other>Andere L�nge</option></select></td></tr>
  <tr><td>  <div style='display: none;' id='eins'>
  Eigene L�nge: </div></td><td><div style='display: none;' id='zwei'><select name=tag>";
  for($i=1; $i<32; $i++){
  echo "<option value=$i>$i</option>";
  } 
  echo "</select>.<select name=month>";
  for($i=1; $i<13; $i++){
  echo "<option value=$i>$i</option>";
  } 
  echo "</select>.<select name=year>";
  for($i=date("Y"); $i<date("Y")+20; $i++){
  echo "<option value=$i>$i</option>";
  } 
  echo " </select>
  </div></td></tr></table><input type=submit value='Benutzer sperren'></form><br><hr>

  <table>";
  while($sd = mysql_fetch_object($sperr_data))
  {
    $sp++;
	if($sp == "1")
	{
	  echo "<tr style=font-weight:bold><td>Benutzername</td><td>L�uft bis</td><td>Aktion</td></tr>";
	}
	echo "<tr><td>$sd->username</td><td>". date("d.m.Y - H:i", $sd->sptime) ."</td><td><a href=?do=sper_user&action=del&id=$sd->id>[ Sperre aufheben ]</a></td></tr>";
  }
  if($sp == "0")
  {
    echo "<tr><td> <b>Es gibt noch keine gesperrten Benutzer in diesem System</b> </td></tr>";
  }
  echo "</table>";
  break;
  
  
  case "ver_foren":
  left_table($for);
  admin_recht("4");
  $ac = $_GET["action"];
  if($ac == "kate")
  {
    if($_GET["done"] == "save")
	{
	  mysql_query("UPDATE kate SET name = '$_POST[name]', besch = '$_POST[besch]', ordn = '$_POST[ordn]' WHERE id LIKE '$_GET[id]'");
	  echo "Die Kategorie wurde nun ge�ndert.<br><a href=?do=ver_foren>Zur�ck zur Foren-Verwaltung</a>";
	  exit;
	}
    $kat_dat = mysql_query("SELECT * FROM kate WHERE id LIKE '$_GET[id]'");
	$kd = mysql_fetch_object($kat_dat);
    echo "<table class=braun width=80%><tr class=besch><td><b>Kategorie verwalten - $kd->name</b></td></tr><tr><td>
	<form action=?do=ver_foren&action=kate&done=save&id=$_GET[id] method=post>
	<table>
	<tr><td>Name:</td><td><input type=text name=name value='$kd->name' size=40></td></tr>
	<tr><td>Beschreibung:</td><td><input type=text name=besch value='$kd->besch' size=40></td></tr>
	<tr><td>Ordnungsnummer:</td><td><input type=text name=ordn value='$kd->ordn'></td></tr>
	</table>
	<input type=submit value=Speichern>
	</form>
	</td></tr></table>";
	exit;
  }
  if($ac == "del")
  {
    insert_log("Ein Forum wurde gel�scht.");
    mysql_query("DELETE FROM foren WHERE id LIKE '$_GET[id]'");
  }
  if($ac == "del_kat")
  {
    $no_for = mysql_query("SELECT * FROM foren WHERE kate LIKE '$_GET[id]'");
	$me = mysql_num_rows($no_for);
	if($me == "0")
	{
	  insert_log("Eine Kategorie wurde gel�scht.");
      mysql_query("DELETE FROM kate WHERE id LIKE '$_GET[id]'");
	}
  }
  if($ac == "for")
  {
    if($_GET["done"] == "save")
	{
	  mysql_query("UPDATE foren SET name = '$_POST[name]', besch = '$_POST[besch]', kate = '$_POST[kate]', guest_see = '$_POST[guest]', admin_start_thema = '$_POST[admin]', user_posts = '$_POST[uspo]', min_posts = '$_POST[posts]', sort = '$_POST[sort]', beitrag_plus = '$_POST[hoch]' WHERE id LIKE '$_GET[id]'");
	  echo "Die Kategorie wurde nun ge�ndert.<br><a href=?do=ver_foren>Zur�ck zur Foren-Verwaltung</a>";
	  exit;
	}
    $for_dat = mysql_query("SELECT * FROM foren WHERE id LIKE '$_GET[id]'");
	$fd = mysql_fetch_object($for_dat);
	// 0 = G�ste d�rfen das Forum sehen, also Alle
	// 1 = G�ste d�rfen das Forum nicht sehen Benutzer aber
	// 2 = Nur Administratoren und Moderatoren
	if($fd->guest_see == "0")
	{
	  $gast = "<option value=0>Alle d�rfen es sehen</option><option value=1>Nur angemeldete Mitglieder</option><option value=2>Nur Administratoren oder Moderatoren</option>";
	}
	if($fd->guest_see == "1")
	{
	  $gast = "<option value=1>Nur angemeldete Mitglieder</option><option value=0>Alle d�rfen es sehen</option><option value=2>Nur Administratoren oder Moderatoren</option>";
	}
	if($fd->guest_see == "2")
	{
	  $gast = "<option value=2>Nur Administratoren oder Moderatoren</option><option value=1>Nur angemeldete Mitglieder</option><option value=0>Alle d�rfen es sehen</option>";
	}
	if($fd->admin_start_thema == "1")
	{
	  $admth = "<option value=1>Nein</option><option value=0>Ja</option><option value=2>Administratoren und Moderatoren</option>";
	}
	if($fd->admin_start_thema == "0")
	{
	  $admth = "<option value=0>Ja</option><option value=1>Nein</option><option value=2>Administratoren und Moderatoren</option>";
	}
	if($fd->admin_start_thema == "2")
	{
	  $admth = "<option value=2>Administratoren und Moderatoren</option><option value=0>Ja</option><option value=1>Nein</option>";
	}
	if($fd->user_posts == "1")
	{
	  $uspo = "<option value=1>Nein</option><option value=0>Ja</option>";
	}
	else
	{
	  $uspo = "<option value=0>Ja</option><option value=1>Nein</option>";
	}
	if($fd->beitrag_plus == "0")
	{
	  $up1 = "checked";
	}
	else
	{
	  $up2 = "checked";
	}
    echo "<table class=braun width=80%><tr class=besch><td><b>Forum verwalten - $fd->name</b></td></tr><tr><td>
	<form action=?do=ver_foren&action=for&done=save&id=$_GET[id] method=post>
	<table>
	<tr><td>Name:</td><td><input type=text name=name value='$fd->name' size=40></td></tr>
	<tr><td>Beschreibung:</td><td><input type=text name=besch value='$fd->besch' size=40></td></tr>
	<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
	<tr><td>In welcher Kategorie?</td><td><select name=kate>";
	$akt_kate = mysql_query("SELECT * FROM kate WHERE id LIKE '$fd->kate'");
	$ak = mysql_fetch_object($akt_kate);
	echo "<option value=$ak->id>$ak->name</option>";
	$other_kate = mysql_query("SELECT * FROM kate WHERE id != '$fd->kate'");
	while($ok = mysql_fetch_object($other_kate))
	{
	  echo "<option value=$ok->id>$ok->name</option>";
	}
	echo "</select></td></tr>
	<tr><td>Wer darf dieses Forum sehen?</td><td><select name=guest>$gast</select></td></tr>
	<tr><td>Nur Administratoren d�rfen Themen erstellen?</td><td><select name=admin>$admth</select></td></tr>
	<tr><td>D�rfen Benutzer/Moderatoren antworten</td><td><select name=uspo>$uspo</select></td></tr>
	<tr><td>Wie viele Beitr�ge muss man haben, um Zugriff auf das Forum zu bekommen?</td><td><input type=text name=posts value='$fd->min_posts'></td></tr>
	<tr><td>Sortierung, die Foren werden so geordnet, auf der Startseite</td><td><input type=text name=sort value='$fd->sort'></td></tr>
	<tr><td>Beitragsz�hler wird bei Beitrag erh�ht?</td><td><input type=radio name=hoch value=0 $up1>Ja <input type=radio name=hoch value=1 $up2>Nein</td></tr>
	</table>
	<input type=submit value=Speichern>
	</form>
	</td></tr></table>";
	exit;
  }
  $foren_data = mysql_query("SELECT * FROM kate ORDER BY ordn");
  echo "<table class=border border=0><tr><td><b><u>Name/Beschreibung</u></b></td><td><b><u>Ordnungsnummer</u></b></td><td><b><u>Aktion</u></b></td></tr>";
  while($fr = mysql_fetch_object($foren_data))
  {
    echo "<tr><td> &nbsp; </td></tr><tr><td><b>$fr->name</b><br>$fr->besch</td><td>$fr->ordn</td><td><a href=?do=ver_foren&action=kate&id=$fr->id>[ bearbeiten ]</a> <a href=javascript:delkat($fr->id)>[ l�schen ]</a></td></tr>";
	$for_date = mysql_query("SELECT * FROM foren WHERE kate = '$fr->id' ORDER BY sort");
    while($fd = mysql_fetch_object($for_date))
    {
	  echo "<tr><td>$fd->name<br><small>$fd->besch</small></td><td>$fd->sort</td><td>  <a href=?do=ver_foren&action=for&id=$fd->id>[ bearbeiten ]</a> <a href=javascript:del($fd->id)>[ l�schen ]</a></td></tr>";
	}
  }
  echo "</table>";
  break;
  
  
  
  case "adser":
  left_table($sons);
  admin_recht("3");
  $adal = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2adser2'");
  $aa = mysql_fetch_object($adal);
  if($_GET["aktion"] == "save")
  {
  	insert_log("AdServer-Einstellungen wurden ge�ndert.");
    mysql_query("UPDATE config SET wert1 = '$_POST[notsee]', zahl1 = '$_POST[akti]' WHERE erkennungscode LIKE 'f2adser2'");
	echo "Die AdServer-Einstellungen wurden ge�ndert.";
	exit;
  }
  if($_GET["aktion"] == "insert")
  {
    if($_POST["bannerli"] == "" OR $_POST["link"] == "")
	{
	  echo "Bitte f�lle die Bild-Adresse genauso wie die Link-Adresse aus.";
	  exit;
	}
    mysql_query("INSERT INTO adser (bannerad, link, klicks, see) VALUES ('$_POST[bannerli]', '$_POST[link]', '0', '0')");
	echo "Der Link wurde erfolgreich hinzugef�gt.";
	insert_log("Link im AdServer wurde hinzugef�gt");
    exit;
  }
  if($_GET["del"] != "")
  {
    mysql_query("DELETE  FROM adser WHERE id LIKE '$_GET[del]'");
    echo "Banner wurde erfolgreich gel�scht.";
	insert_log("Banner wurde aus dem AdServer entfernt.");
	exit;
  }
  if($aa->zahl1 == "1")
  {
    //Adserver ist aktiviert
	$akt = "checked";
    $dea = "";
  }
  else
  {
    //Adserver ist aktiviert
	$akt = "";
    $dea = "checked";
  }
  echo "<table class='braun'><tbody><tr class='besch'><td><b>AdServer Einstellungen festlegen.</b></td></tr><tr><td>
  <form action=?do=adser&aktion=save method=post>
  <table>
  <tr><td>AdServer ist aktiviert</td><td><input type=radio name=akti value=1 $akt>Ja <input type=radio name=akti value=0 $dea>Nein</td></tr>
  <tr><td>Trage in das folgende K�stchen die Benutzerid ein,<br>
  die den AdServer nicht sehen.<br>(Mit Komma Trennen ohne Leerzeichen! 2,5,9,7)</td><td><input type=text name=notsee value='$aa->wert1' size=40></td></tr>
  </table>
  <input type=submit value=Speichern>
  </form>
  </td></tr></table>
  
  <br>
  
  <table class='braun'><tbody><tr class='besch'><td><b>Links hinzuf�gen</b></td></tr><tr><td>
  <form action=?do=adser&aktion=insert method=post>
  <table>
  <tr><td> Gebe hier die Grafik-Adresse des Banners ein </td><td> <input type=text name=bannerli size=32> </td></tr>
  <tr><td> Gebe hier den Link ein, auf den der Banner verweisen soll: </td><td> <input type=text name=link size=32 value='http://'> </td></tr>
  </table>
  <input type=submit value=Speichern>
  </form>
  </td></tr></table>
  
  <br>
  <table class='braun'><tbody><tr class='besch'><td><b>Links im Adserver</b></td></tr><tr><td>
  <table>
  <tr><td>Link-Adresse</td><td>Gesehen</td><td>Klicks</td><td>Aktionen</td></tr>";
  $addaho = mysql_query("SELECT * FROM adser");
  while($adh = mysql_fetch_object($addaho))
  {
    echo "<tr><td>$adh->link</td><td>$adh->see</td><td>$adh->klicks</td><td><a href=?do=adser&del=$adh->id>L�schen</a></tr>";
  }
  
  echo "</table></td></tr></table>
  
  ";
  break;
  
  
  case "sendbrief":
    left_table($sons);
    admin_recht("2");
	check_data($_POST["tit"], "", "Bitte gebe einen Titel ein.<br><a href='javascript:history.back()'>Zur�ck</a>", "leer");
	check_data($_POST["mes"], "", "Bitte gebe eine Nachricht ein.<br><a href='javascript:history.back()'>Zur�ck</a>", "leer");
	$time = time() - $_POST["days"];
	$posts = $_POST["posts"];
	if($posts == "")
	{
	  $posts = "0";
	}
	if($_POST["all"] != "1")
	{
	  $data_hol = mysql_query("SELECT * FROM users WHERE $time < last_log AND posts >= $posts");
	}
	else
	{
	  $data_hol = mysql_query("SELECT * FROM users");
	}
	$usernamen = array("");
	$user_data = mysql_query("SELECT * FROM users WHERE username LIKE '". USER ."'");
    $ud = mysql_fetch_object($user_data);
	while($dh = mysql_fetch_object($data_hol))
	{
	  $time = time();
	  $mes = $_POST["mes"];
	  $mes = str_replace("[USERNAME]", $dh->username, $mes);
	  $mes = str_replace("[BEITRAEGE]", $dh->posts, $mes);
	  $tit = $_POST["tit"];
	  $tit = str_replace("[USERNAME]", $dh->username, $tit);
	  $tit = str_replace("[BEITRAEGE]", $dh->posts, $tit);
	  if($_POST["send_by"] == "pn")
	  {
	    mysql_query("INSERT INTO prna (abse, emp, dat, betreff, mes, gel) VALUES ('". USER . "', '$dh->username', '$time', '$tit', '$mes', '0')")or die(mysql_error());
	  }
	  elseif($_POST["send_by"] == "mail")
	  {
	    $mail_empfaenger= $dh->mail;
        $mail_absender= $ud->mail;
        $betreff= $tit;
        $header  = "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
        $header .= "From: $mail_absender\r\n";
        $header .= "Reply-To: $mail_empfaenger\r\n";
        $text = $mes;
        mail($mail_empfaenger, $betreff, $text, $header);
	  }
	  $usernamen[] = $dh->username;
	}
	$user = count($usernamen);
	$user--;
	echo "Danke, dieser Rundbrief wurde an $user Benutzer verschickt:<br><br>";
	for($r=0;$r<count($usernamen);$r++)
	{
	  echo "$usernamen[$r]<br>";
	}
	insert_log("Rundbrief wurde an $user Benutzer versendet.");
  break;
  
  case "rundbrief":
    left_table($user);
    admin_recht("2");
	echo "<script>
	function show(das) {
    document.getElementById(das).style.display='block';
	}
	function nshow(das) {
	document.getElementById(das).style.display='none';
	}

	</script>
	<table class='braun'><tbody><tr class='besch'><td><b>Rundbrief verfassen</b></td></tr><tr><td>
	Mit den folgenden Feldern kannst du einen Rundbrief, also einen Brief an alle aktiven Mitglieder verfassen.<br>Um Datenbank-belastung auszuschlie�en, werden inaktive Benutzer von der Rundmail ausgeschlossen.<br>
	<b>Variablen-Ersetzung:</b>
	<table>
	<tr><td>[USERNAME]</td><td>Zeigt den jeweiligen Benutzernamen an</td></tr>
	<tr><td>[BEITRAEGE]</td><td>Zeigt die Beitr�ge des Benutzers an</td></tr>
	</table><br><br>
	<form action=?do=sendbrief method=post>
	<small>Senden per:</small><br>
	<select name=send_by><option value=pn onclick=nshow('eins')>Privaten Nachricht</option>";
	$config_datad = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2mf2'");
    $cdd = mysql_fetch_object($config_datad);
    if($cdd->zahl2 == "1")
    {
	  echo "<option value=mail onclick=show('eins')>eMail</option>";
	}
	echo "</select><br><small>Titel:</small><br>
	<input type=text name=tit size=50><br><br>
	<small>Nachricht:</small><br>
	<textarea rows=5 cols=50 name=mes></textarea><br><br>
	<fieldset><legend>Einstellungen</legend><table><tr><td>
	<small>Benutzer muss aktiv in den letzten</small><br>
	<select name=days><option value=172800>2</option><option value=432000>5</option><option value=604800>7</option><option value=864000>10</option><option value=1209600>14</option><option value=1814400>21</option></select>Tagen sein.</td><td>
	<small>...und muss mindestens</small><br>
	<input type=text name=posts value=0 size=3 maxlength=6> Beitr�ge haben.<br>


	</td></tr></table>	<div style='display: none;' id='eins'>
    <input type=checkbox name=all value=1> An alle Benutzer schicken (Angaben oben werden ignoriert)
    </div></fieldset><br><br>
	<input type=submit value='Nachrichten verschicken'>
	</form>
	";
  break;
  
  
  case "styles":
    left_table($design);
    echo "<table class='braun'><tbody><tr class='besch'><td><b>Style-Verwaltung</b></td></tr><tr><td>
	<table>
	<tr><td><b>Style-Name</b></td><td><b>Stylelink</b></td><td><b>Aktion</b></td></tr>";
    $style_data = mysql_query("SELECT * FROM style_all");
	while($sd = mysql_fetch_object($style_data))
	{
	  echo "<tr><td>$sd->sname</td><td>$sd->link_style</td><td><a href=?do=del_style&id=$sd->id>L�schen</a></tr>";
	}
    echo "</table>
    </td></tr></table>";
  break;
  
  
  case "del_style":
    left_table($design);
    admin_recht("3");
    $style_data = mysql_query("SELECT * FROM style_all WHERE id LIKE '$_GET[id]'");
	$sd = mysql_fetch_object($style_data);
    if($_GET["aktion"] == "del")
	{
	  mysql_Query("DELETE FROM style_all WHERE id LIKE '$_GET[id]'");
	  unlink("../style/$sd->link_style");
	  echo "Style wurde erfolgreich gel�scht.";
	  exit;
	}
    echo "M�chtest du dieses Style wirklich l�schen? Das System l�scht die *.css Datei automatisch mit, damit es nicht zu Fehlern f�hren kann.<br>
	Wirklich l�schen?<br><br>
	<a href=?do=del_style&aktion=del&id=$_GET[id]>Ja, Style und Datei l�schen</a> &nbsp; &nbsp; <a href=?do=styles>Nein, zur�ck zur �bersicht</a>";
  break;
  
  
  case "insert_style":
    left_table($design);
	if($_GET["aktion"] == "insert")
	{
	  $check_style = mysql_query("SELECT * FROM style_all WHERE sname LIKE '$_POST[sname]' OR link_style LIKE '$_POST[link]'");
	  if(mysql_num_rows($check_style) > 0)
	  {
	    echo "<b>Speicherung Fehlgeschlagen:</b> Entweder exestiert dieser Name schon, oder der Style zu der CSS-Datei ist schon vorhanden.";
		exit;
	  }
	  $style_link = "../style/$_POST[link]";
	  if(!file_exists($style_link))
	  {
	    echo "Bevor du dieses Style erstellst, schiebe bitte zuerst die .css Datei in den Ordner \"Style\". Dieses verhindert Probleme!";
		exit;
	  }
	  mysql_query("INSERT INTO style_all (sname, link_style) VALUES ('$_POST[sname]','$_POST[link]')");
	  echo "Danke, dieser Style wurde erfolgreich hinzugef�gt und kann nun verwendet werden.";
	  exit;
	}
	echo "<table class='braun'><tbody><tr class='besch'><td><b>Style-Verwaltung</b></td></tr><tr><td>
    Hier kannst du einen Style hinzuf�gen. Bitte beachte, dass diese .css Datei exestieren muss!<br><br>
	<form action=?do=insert_style&aktion=insert method=post>
	<table>
	<tr><td>Name des Styles:</td><td><input type=text name=sname></td></tr>
	<tr><td>Link zum Style:</td><td>". $_SERVER["SERVER_NAME"] ."/style/<input type=text name=link value='.css'></td></tr>
	</table>
	<input type=submit value=Hinzuf�gen>
	</form>
    </td></tr></table>";
  break;
  
  
  case "raenge":
    left_table($sons);
	if($_GET["aktion"] == "insert")
	{
	  if($_POST["name"] != "" AND $_POST["mpz"] != "")
	  {
	    mysql_query("INSERT INTO range (name, min_post) VALUES ('$_POST[name]', '$_POST[mpz]')");
	    echo "Danke, der neue Rang wurde hinzugef�gt und ist nun verf�gbar.";
	  }
	  else
	  {
	    echo "Bitte gebe sowohl einen Rangnamen als auch die Mindestpostzahl an.";
	  }
	  exit;
	}
	if($_GET["delete"] != "")
	{
	  mysql_query("DELETE FROM range WHERE id LIKE '$_GET[delete]'");
	  echo "Der Rang wurde erfolgreich gel�scht.";
	  exit;
	}
	if($_GET["edit"] != "")
	{
	  if($_GET["edit"] == "insert")
	  {
	  	if($_POST["name"] != "" AND $_POST["mpz"] != "")
	    {
	      mysql_query("UPDATE range SET name = '$_POST[name]', min_post = '$_POST[mpz]' WHERE id LIKE '$_GET[rid]'");
	      echo "Danke, der Rang wurde ge�ndert.";
	    }
	    else
	    {
	      echo "Bitte gebe sowohl einen Rangnamen als auch die Mindestpostzahl an.";
	    }
	  exit;
	  }
	  $rang_data = mysql_query("SELECT * FROM range WHERE id LIKE '$_GET[edit]'");
	  $rd = mysql_fetch_object($rang_data);
	  echo "<table class='braun' width=90%><tbody><tr class='besch'><td><b>Rang �ndern</b></td></tr><tr><td>
      Hier kannst Du R�nge hinzuf�gen, gebe bitte den Rangnamen und die Mindestpostzahl an.<br><br>
	  <form action=?do=raenge&edit=insert&rid=$rd->id method=post>
	  <table>
	  <tr><td>Rangname:</td><td><input type=text name=name value='$rd->name'></td></tr>
	  <tr><td>Mindestpostzahl:</td><td><input type=text name=mpz value='$rd->min_post'></td></tr>
	  </table>
	  <input type=submit value=�ndern>
	  </form>
      </td></tr></table>";
	  exit;
	}
	echo "<table class='braun' width=90%><tbody><tr class='besch'><td><b>Rang hinzuf�gen</b></td></tr><tr><td>
    Hier kannst Du R�nge hinzuf�gen, gebe bitte den Rangnamen und die Mindestpostzahl an.<br><br>
	<form action=?do=raenge&aktion=insert method=post>
	<table>
	<tr><td>Rangname:</td><td><input type=text name=name></td></tr>
	<tr><td>Mindestpostzahl:</td><td><input type=text name=mpz></td></tr>
	</table>
	<input type=submit value=Hinzuf�gen>
	</form>
    </td></tr></table><br><br>
	<table class='braun' width=90%><tbody><tr class='besch'><td><b>R�nge-Verwaltung</b></td></tr><tr><td>
    <table><tr><td width=10%><b>Name</b></td><td width=5%><b>Beitr�ge</b></td><td width=5%><b>Aktion</b></td></tr>";
	$rang_data = mysql_query("SELECT * FROM range ORDER BY min_post");
	while($rg = mysql_fetch_object($rang_data))
	{
	  echo "<tr><td>$rg->name</td><td>$rg->min_post</td><td><a href=?do=raenge&delete=$rg->id><img src=kreuz.gif border=0 title=L�schen></a> <a href=?do=raenge&edit=$rg->id><img src=stift.gif border=0 title=�ndern></td></tr>";
	}
	echo "</table>
    </td></tr></table>";
  break;
}
?>
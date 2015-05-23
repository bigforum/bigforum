<?php
session_start();
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
echo "<title>$title</title>
<style>
body{
background: #f2f2e5
}
.besch
{
  background: #DE8418;
}
.braun{
  border: 1px solid #C37B18;
}
a:link
{
	color: #363636;
}
a:visited
{
	color: #363636;
}
a:hover, a:active
{
	color: #767676;
}
.navi
{
  background: #DE9C39;
}
.border
{
  border: 1px solid #DE9C39;
}
</style>";
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
d = confirm("Möchtest du das Forum wirklich löschen? Dieser Schritt ist nichtmehr rückgänigmachbar. Alle Beiträge werden mitgelöscht!");
if(d == true)
{
  xmlhttp.open("GET", 'admin.php?do=ver_foren&action=del&id='+id);
  alert("Das Forum ist gelöscht");
}
xmlhttp.send(null);
}


function delkat(id) {
x = confirm("Möchtest du diese Kategorie wirklich löschen? Beachte das dieses nur geht, wenn diese Kategorie keine Foren enthält.!");
if(x == true)
{
  xmlhttp.open("GET", 'admin.php?do=ver_foren&action=del_kat&id='+id);
  alert("Sollte die Kategorie keine Foren mehr enthalten haben, wurde sie nun gelöscht.");
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
  window.open("http://www.bfs.kilu.de");

}
}
document.onkeypress=support;
<?php } ?>
</script>
<?php
echo "<table background=\"bgoben.png\" width=100%><tr><td><a href=?do=log_out>Aus Admin-Bereich ausloggen</a> | <a href='../index.php' target='_blank'>Foren-Übersicht</a><br>
<center><h4><a href=\"admin.php\">Start</a> &nbsp; <a href=\"?do=ver_user\">Benutzer</a> &nbsp; <a href=\"?do=ver_foren\">Foren</a> &nbsp; <a href=\"?do=settings\">Einstellungen</a> &nbsp; <a href=?do=styles>Design</a></td></tr></table>";
$sons = array("?do=settings|Foren-Einstellungen","?do=settings_admincp|Kontrollzentrum-Einstellungen","?do=look_logs|Log-Einträge","?do=mods|Mods/Addons Verwaltung","?do=new_warn|Verwarnungsgründe","?do=adser|Adserver","?do=not_use|Benutzernamen / eMail-Adressen verbieten", "?do=rundbrief| Rundbrief schreiben");
$for = array("?do=new_foren|Neues Forum","?do=ver_foren|Verwalte Foren");
$user = array("?do=sper_user|Gesperrte","?do=ver_user|Benutzer suchen","?do=recht| Administratoren-Rechte","?do=zuruck|Rechte zurücksetzen");
$start = array("admin.php|Start","?do=ver_check|Version-Check","?do=settings|Foren-Einstellungen","?do=look_logs|Log-Einträge ansehen","?do=new_foren|Neues Forum erstellen","?do=ver_user|Benutzer verwalten");
$design = array("?do=styles|Styles","?do=insert_style|Style hinzufügen","?do=design|Header-Einstellungen");
switch ($do) {
  case "":
    left_table($start);
    admin_recht("1");
    $adm_notice = file_get_contents("adm_notice.txt");
	$adm_notice = str_replace("\n","<br>", $adm_notice);
	$adm_notice = base64_decode($adm_notice);
    echo "<table class=braun width=50%><tr class=besch><td><b>Willkommen im Administrator-Kontrollzentrum</b></td></tr><tr><td>
	Hallo ". USER .",<br>
	hier im bigforum Admin-Panel kannst du alles mögliche verwalten. <br>Solltest du Hilfe mit dem Suchen bestimmter Funktionen haben,besuche doch mal die <a href=?do=help>kleine Administratoren Hilfe</a>.</td></tr></table><br><br>";
	if(file_exists("./install.php") OR file_exists("../install.php"))
	{
	echo "<table class=braun width=50%><tr class=besch><td><b>Warnung</b></td></tr><tr><td>
	Die Datei install.php exestiert noch. Bitte lösche diese Datei.<br> Ansonsten kann jeder andere dieses Forum manipulieren!</td></tr></table><br><br>";

	}
	echo "<br><br>
	<table class=braun width=50%><tr class=besch><td><b>Administratoren-Notizen (<a href=?do=change_notice>verändern)</b></td></tr><tr><td>$adm_notice</td></tr></table><br><br>";
	echo "<table class=braun width=50%><tr class=besch><td><b>Benutzer Statistik / Benutzer die online sind</b></td></tr><tr><td>";
    user_online(true);
	echo "</td></tr></table></td></tr></table><br><br>
	<table class=braun width=50%><tr class=besch><td><b>Detailsbeschreibung</b></td></tr><tr><td> <table><tr><td><b>Foren-Version:</b></td><td>". VERSION ."</td></tr><tr><td><b>Forenentwickler:</b></td><td><a href=http://www.potterfreaks.de>Potterfans</a></td></tr></table> </td></tr></table>";
  break;
  
  
  case "mods":
  admin_recht("4");
  left_table($sons);
  //Mods die die funktion Admin beeinhalten
  $mod = array("rules.php","last_posts.php","chat.php","addon_basic_modul.php");
  $laeng = count($mod);
  $x = "0";
  echo "Hier hast du eine Verwaltungsmöglichkeit, aller installierten Mods, dieses Systems. Sofern dieser Mod, es zuläßt sich über das Admincp verwalten zu lassen.<br>Der Titel ist gleichzeitig der Dateiname.php<br><br>";
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
  }
  if($x == "0")
  {
    echo "Keine Mods installiert, oder keine unterstützten eine Verwaltung über das Admincp.";
  }
  break;
  
  
  case "design":
  left_table($design);
  admin_recht("3");
  if($_GET["action"] == "insert")
  {
    mysql_query("UPDATE config SET wert2 = '$_POST[link]' WHERE erkennungscode LIKE 'f2closefs'");
	echo "<b>Information:</b> Der Header-Link wurde erfolgreich überarbeitet.";
  }
  if($_GET["action"] == "noti")
  {
    mysql_query("UPDATE users SET notice = '$_POST[noti]'");
	echo "<b>Information:</b> Die Benutzernotizen wurden erfolgreich überarbeitet."; 
  }
  $config_data = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2closefs'");
  $cd = mysql_fetch_object($config_data);
  echo "<fieldset><legend>Link in die Navigation</legend>
  Hier kannst du einen weiteren individuellen Link in der Navigation hinzufügen, ob fett, ob in einem neuem Fenster, es steht alles frei. Du kannst nur diesen Link in die Navi machen, d.h. wenn das Textfeld leer ist, wird auch kein Link angezeigt. Bitte verwende HTML, also:<br> <i>&#60;a href=http://blablabla.de target=_blank&#62;Angezeigter Text&#60;/a&#62;</i>:<br>
  <form action=?do=design&action=insert method=post name=feld>
  <input type=text name=link value='$cd->wert2' size=40><input type=submit value=Bestätigen><input type=button value='Textfeld leeren' onclick=\"feld.link.value=''\">
  </form>
  </fieldset>
  <br>
  <fieldset><legend>Header-Anzeige</legend>Hier kannst du eine Nachricht eingeben, welche bei <u>allen</u> Benutzern angezeigt wird. Sollte ein User eine alte Header-Notiz haben, wird diese mit dieser überschrieben.<br>
  Die Benutzer können die Header-Notiz, genauwie eine persönliche Notiz, über den Persönlichen Bereich ausbleden. Bei der Userverwaltung kannst Du sehen, was ein Benutzer im Header stehen hat.<br>
  <form action=?do=design&action=noti method=post>
  <input type=text size=40 name=noti><input type=submit value=Speichern></form>";
  break;
  
  
  case "help":
  admin_recht("1");
  echo "<table class=braun width=50%><tr class=besch><td><b>Die kleine Administratoren-Hilfe</b></td></tr><tr><td>
  Um Bereiche hier aufzurufen, benutze dafür die obere \"Selectbox\". Wähle da einfach dein Bereich aus, raufklicken und du wirst
  automatisch zu dem Bereich weitergeleitet. <br>Weiter unten gibt es eine Liste, mit einer Übersicht wichtiger Funktionen.<br><br><hr align=center width=15%><br>
  Auf der <b>Startseite</b> gibt es allgemeine Informationen so wie deine Aktuelle Version (". VERSION. "). Desweiteren hast du dort,
  genauso wie auf der Startseite ganz unten, eine Liste der Benutzer, die online sind. Als kleines Extra kannst du hier aber sehen,
  wie viele Benutzer es sind.<br><br><hr align=center width=15%><br>
  Hier hast du eine Liste, mit den wichtigsten Funktionen, die dieses Administrator-Kontrollzentrum zu bieten hat: <br><br>
  <li><a href=?do=phpver>PHP & MySQL Übersicht</a>
  <li><a href=?do=ver_user>Benutzer Verwaltung (Komplette Verwaltungsmöglichkeiten)</a>
  <li><a href=?do=look_logs>Log-Einträge einsehen</a>
  <li><a href=?do=settings>Allgemeine Einstellungen (Private Nachrichten, Signatur etc.)</a>
  <li><a href=?do=ver_foren>Foren & Kategorien ändern oder löschen</a>
  <li><a href=?do=new_warn>Verwarnungen verwalten</a>
  <li><a href=?do=sper_user>Übersicht aller gesperrten Benutzer</a>
</td></tr></table>";
  break;
  

  case "phpver":
  admin_recht("6");
  echo "<table class=braun width=50%><tr class=besch><td><b>PHP & MySQL - Informationen</b></td></tr><tr><td>
  
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
    echo "<font color=green><b>Herzlichen Glückwunsch:</b> Dein Forum ist auf dem aktuellstem Stand!";
  }
  else
  {
    echo "<font color=red><b>Eine neuere Version von bigforum ist verfügbar. Du kannst diese im <a href=http://www.bfs.kilu.de/kb/>Kundenbereich</a> downloaden.";
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
	     echo "<b>Vorschläge:</b><br><br>";
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
	   <b>Beiträge:</b> </td><td> <input type=text name=bei value=$uds->posts></td></tr><tr><td>
	   <b>Registriert seit (UNIX!):</b> </td><td> <input type=text name=reg value=$uds->reg_dat> (". date("d.m.Y", $uds->reg_dat).")</td></tr>
	   <tr><td><b>Angezeigte Notiz:</b></td><td> <input type=text name=unot value='$uds->notice' </td></tr></table></td></tr></table>
	   </td><td><table class=braun width=100%><tr class=besch><td><b>Benutzerrechte - $uds->username</b></td></tr><tr><td>
	   <table>
	   <tr><td><b>Zeige Bearbeitet von... Bei Beitragsbearbeitung?</b></td><td width=40%><input type=radio name=editrech value=5 $editf>Ja <input type=radio name=editrech value=2 $editr> Nein</td></tr>
	   <tr><td><b>Darf das Private Nachrichten System nutzen?</b></td><td><input type=radio name=pncan value=0 $pnr>Ja <input type=radio name=pncan value=1 $pnf> Nein</td></tr>
	   <tr><td><b>Darf HTML in Beiträgen benutzen</b></td><td> <input type=radio name=htmlcan value=1 $eeditr>Ja <input type=radio name=htmlcan value=2 $eeditf> Nein</td></tr>
	   <tr><td> &nbsp; </td><td> &nbsp; </td></tr>
	   <tr><td>	
       <b>Gruppenzugehörigkeit</b> </td><td>Super-Moderator: <input type=checkbox name=grup value=2 $mod_check><br>
											Administrator: <input type=checkbox name=grup value=3 $adm_check></td></tr><tr><td>
	   </td></tr>	   
	   </table></td></tr></table></td></tr></table>
	   <table class=braun width=100%><tr class=besch><td><b>Signatur ändern</b></td></tr><tr><td><table><tr><td>
	   <textarea name=sign rows=6 cols=60>$uds->sign</textarea>
	   </td></tr>
	   </td></tr></table>  
       </td></tr></table>	   <input type=hidden value=$uds->id name=id>
	   <input type=submit value='Speichern'><input type=button value='Benutzer löschen' onclick=\"window.location.href='?do=del_user&id=$uds->id'\">
	   </form>";
	 }
  break;
  
  case "del_user":
    left_table($user);
    admin_recht("5");
    if($_GET["aktion"] == "sure")
	{
	  mysql_query("DELETE FROM users WHERE id LIKE '$_GET[id]'");
	  echo "Der Benutzer wurde gelöscht.";
	  insert_log("Ein Benutzer (id: $_GET[id]) wurde gelöscht.");
	  exit;
	}
    echo "<b>Möchtest du diesen Benutzer wirklich löschen? Dieser Schritt ist nichtmehr rückgänig machbar!</b><br><br>
    <input type=button value='Ja, Benutzer löschen' onclick=\"window.location.href='?do=del_user&aktion=sure&id=$_GET[id]'\">  <input type=button value='Nein, Benutzer nicht löschen' onclick=\"window.location.href='admin.php'\">";
  break;
  
  case "zuruck":
    left_table($user);
  echo "Wähle aus, welche Recht du bei <b>allen</b> Benutzern zurücksetzen möchtest:<br><br>
  <li><a href=?do=change_htmlcan>HTML Benutzen => Alle auf \"nein\" setzen</a>
  <li><a href=?do=change_headern>Header-Notiz => Alle ausblenden</a>";
  break;
  
  case "change_headern":
  	insert_log("Notiz im Header wurde bei allen Benutzern gelöscht");
    left_table($user);
    mysql_query("UPDATE users SET notice = ''");
    echo "Es wird nun keinem Benutzer mehr eine Notiz im Header angezeigt.";
  break;
  
  case "change_htmlcan":
  	insert_log("Alle Benutzer dürfen kein HTML mehr benutzen");
    left_table($user);
    mysql_query("UPDATE users SET htmlcan = '3'");
    echo "Es wurde nun allen Benutzern verboten HTML zu benutzen.";
  break;
  
  
  case "not_use":
      left_table($sons);
	  if($_GET["action"] == "del")
	  {
	    mysql_query("DELETE FROM verbo WHERE id LIKE '$_GET[id]'");
	    echo "<b>Information:</b> Die angegebene Sache wurde gelöscht.<br><br>";
	  }
	  if($_GET["action"] == "insert")
	  {
	    $data = mysql_query("SELECT * FROM verbo WHERE name LIKE '$_POST[verbo]' AND benemail LIKE '$_POST[bemail]'");
		if(mysql_num_rows($data) == "0")
		{
	      mysql_query("INSERT INTO verbo (name, benemail) VALUES ('$_POST[verbo]','$_POST[bemail]')");
		  echo "Danke, $_POST[name] wurde hinzugefügt.<br> <a href=?do=not_use>Zurück zur Übersicht</a>";
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
		echo "<tr><td>$vh->name</td><td>$be</td><td><a href=?do=not_use&action=del&id=$vh->id>Löschen</a></td>";
	  }
	  echo "</table></td></tr></table><hr>
	  <b>Neues Verbot von Benutzernamen / eMail-Adrsse hinzufügen:<br><br>
	  <form action=?do=not_use&action=insert method=post><input type=text name=verbo><select name=bemail><option value=1>eMail-Adresse</option><option value=2>Benutzername</option></select><br><input type=submit value=Speichern></form>";
  break;
  
  
  case "save_userdatas":
    left_table($user);
       $user_datas = mysql_query("SELECT * FROM users WHERE id LIKE '$_POST[id]'");
	 $uds = mysql_fetch_object($user_datas);
  admin_recht("5");
  check_data($_POST["username"], "", "Bitte fühle alle Felder aus (Benutzername!)", "leer");
  check_data($_POST["rang"], "", "Bitte fühle alle Felder aus (Benutzerrang!)", "leer");
  check_data($_POST["bei"], "", "Bitte fühle alle Felder aus (Beiträge!)", "leer");
  check_data($_POST["reg"], "", "Bitte fühle alle Felder aus (Registrierungsdatum!). Denke bitte an die Unixtime.", "leer");  
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
			website   = '$_POST[web]',
			hob       = '$_POST[hob]',
			editrech  = '$_POST[editrech]',
			htmlcan   = '$_POST[htmlcan]',
			darf_pn   = '$_POST[pncan]',
			adm_recht = '$uds->adm_recht' WHERE id LIKE '$_POST[id]'");
	insert_log("Profil von $_POST[username] wurde geändert.");
  echo "Danke,<br> das Profil von $_POST[username] wurde erfolgreich überarbeitet.<br><br><a href=admin.php>Zurück zur Administratorern-Übersicht</a>";
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
	echo "Die ausgewählten Log-Einträge wurden gelöscht.";
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

  echo "<table class=braun width=70%><tr class=besch><td><b>Log-Einträge (<b>Seite:</b> ";
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
  echo "<tr><td></td><td></td><td></td><td></td><td><input type=submit value=Löschen></td></tr></table>
  </form>
  </td></tr></table>";
  break;
  
  
  case "change_notice":
  admin_recht("3");
  left_table($start);
  if($_GET["aktion"] == "change")
  {
    $datei = fopen("adm_notice.txt","w+");
	$_POST["foren_notice"] = str_replace("<br>","\n", $_POST["foren_notice"]);
	$_POST["foren_notice"] = base64_encode($_POST["foren_notice"]);
	fwrite($datei, $_POST["foren_notice"]);
	echo "Die Administratoren-Notiz wurde erfolgreich geändert.<br><br><a href=?do=>Zurück zur Startseite</a>";
	insert_log("Administratoren-Notiz wurde geändert.");
	fclose($datei);
    exit;
  }
    $adm_notice = file_get_contents("adm_notice.txt");
	$adm_notice = base64_decode($adm_notice);
  echo "<table class=braun width=80%><tr class=besch><td><b>Administratoren-Notiz ändern</b></td></tr><tr><td>
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
	echo "Danke, die Kontrollzentrum-Einstellungen wurden geändert.";
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
	$config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2laengfs'");
    $con = mysql_fetch_object($config_wert); 
	if($_POST["styl"] != $con->wert2)
	{
	  mysql_query("UPDATE users SET style = '$_POST[styl]'");
	}
    check_data($_POST["fn"], "", "Bitte gebe einen Forum-Name ein.", "leer");
	check_data($_POST["besch"], "", "Bitte gebe einen Foren-Beschreibung ein.", "leer");
    mysql_query("UPDATE config SET wert1 = '$_POST[fn]', wert2 = '$_POST[besch]' WHERE erkennungscode LIKE 'f2name2'");
    mysql_query("UPDATE config SET wert2 = '$_POST[logo]', zahl1 = '$_POST[sign]', zahl2 = '$_POST[pn]' WHERE erkennungscode LIKE 'f2pnsignfs'");
    mysql_query("UPDATE config SET wert1 = '$gpack', wert2 = '$gpackt', zahl1 = '$number' WHERE erkennungscode LIKE 'f2imgadfs'");   
    mysql_query("UPDATE config SET wert1 = '$_POST[clos_text]', zahl1 = '$_POST[close]' WHERE erkennungscode LIKE 'f2closefs'");   
    mysql_query("UPDATE config SET wert1 = '$_POST[bfav]', wert2 = '$_POST[styl]', zahl1 = '7', zahl2 = '$_POST[smilie]' WHERE erkennungscode LIKE 'f2laengfs'");   
    mysql_query("UPDATE config SET wert1 = '$_POST[st]', zahl2 = '$_POST[pro]' WHERE erkennungscode LIKE 'f2profs'");   
	echo "Danke, die Foreneinstellungen wurden geändert!";
	insert_log("Die Foreneinstellungen wurden überarbeitet.");
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
    $pack = "<option value=pack1 >Packet 1 - Buchstaben</option><option value=pack2>Packet 2 - Runde Buttons</option><option value=pack3 >Packet 3 - Eckige Farbige Buttons</option><option value=pack4 >Packet 4 - Braune Eckige Buttons (Papier)</option>";
  }
  if($con->zahl1 == "2")
  {
    $pack = "<option value=pack2 >Packet 2 - Runde Buttons</option><option value=pack1 >Packet 1 - Buchstaben</option><option value=pack4 >Packet 4 - Braune Eckige Buttons (Papier)</option><option value=pack3 >Packet 3 - Eckige Farbige Buttons</option>";
  }
  if($con->zahl1 == "3")
  {
    $pack = "<option value=pack3 >Packet 3 - Eckige Farbige Buttons</option><option value=pack4 >Packet 4 - Braune Eckige Buttons (Papier)</option><option value=pack1 >Packet 1 - Buchstaben</option><option value=pack2 >Packet 2 - Runde Buttons</option>";
  }
  if($con->zahl1 == "4")
  {
    $pack = "<option value=pack4 >Packet 4 - Braune Eckige Buttons (Papier)</option><option value=pack3 >Packet 3 - Eckige Farbige Buttons</option><option value=pack1 >Packet 1 - Buchstaben</option><option value=pack2 >Packet 2 - Runde Buttons</option>";
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
  echo"</select>
  <tr><td> &nbsp; </td><td> &nbsp; </td></tr>  
  <tr><td> Bild-Adresse für Forum-Favicon </td><td> <input type=text name=bfav value=$con->wert1> </td></tr>  
  <tr><td> Bild-Adresse für Forum-Logo</td><td><input type=text name=logo value='". WERTZ ."'></td></tr>
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
  echo "
  <tr><td>Gäste dürfen Profile sehen?</td><td>$prof_pack</td></tr>
  <tr><td>Zeige erweiterte Statistik auf der Startseite?</td><td>$st</td></tr>
  <tr><td> &nbsp; </td><td> &nbsp </td></tr>";
  
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2closefs'");
  $con = mysql_fetch_object($config_wert); 
  echo"
  <tr><td> Forum geschloßen </td><td> ";
  if($con->zahl1 == "0")
  {
    echo "<input type=radio name=close value=0 checked> Ja <input type=radio name=close value=1> Nein";
  }
  if($con->zahl1 == "1")
  {
    echo "<input type=radio name=close value=0> Ja <input type=radio name=close value=1 checked> Nein";
  }
  echo "</td></tr>  
  <tr><td> Text bei Schließung </td><td> <input type=text name=clos_text value='$con->wert1' size=40> </td></tr>
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
	insert_log("Administratoren-Rechte wurden überarbeitet");
  }
  echo "<table class=braun width=80%><tr class=besch><td><b>Administratoren-Rechte festlegen</b></td></tr><tr><td>
  <form action=?do=recht&aktion=do method=post><table>
  <tr style=font-weight:bold><td>Benutzername</td><td>Darf Startseite sehen</td><td>... darf Log-Einträge sehen</td><td>...darf Foreneinstellungen ändern</td><td>... darf Foren verwalten</td><td>...darf Benutzer verwalten</td><td>Ist Gründer</td></tr>";
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
	<b>Darf Startseite sehen:</b>Der Administrator darf lediglich die Startseite und die Administratoren-Hilfe sehen<br><br>
	<b>Darf Log-Einträge sehen:</b> Hat volle Rechte auf Log-Einträge.<br><br>
	<b>Darf Foreneinstellungen ändern:</b> Darf alle möglichen Foreneinstellungen s.w. den Foren-Titel, Foren beschreibun usw. verändern. Desweiteren darf auch die Administratoren-Notiz ab diesem Level verändert werden.<br><br>
	<b>Darf Foren verwalten:</b> Darf bestehenden Foren bzw. Kategorien ändern, neue hinzufügen und Rechte für diese verändern. Ab dieser Stufe dürfen auch Addons / Mods verwaltet werden.<br><br>
	<b>Darf Benutzer verwalten:</b> Darf Benutzer verwalten, d.h. diesen Gruppen zuordnen bzw. Rang-Titel oder Beiträge ändern. Das Recht Benutzer zu verwarnen bzw. zu sperren haben auch Moderatoren!<br><br>
	<b>Ist Gründer:</b> Benutzer darf alles ändern, d.h. Administratoren-Rechte vergeben und Serverseitige Funktionen einsehen,<br><br><br>
	
	Alle Rechte sind der größe nach sotiert, d.h. wer Benutzer verwalten darf, kann auch die Foreneinstellungen ändern, und wer Foreneinstellungen sehen/ändern kann, kann auch Logs einsehen!
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
		echo "Die Kategorie wurde hinzugefügt.";
		insert_log("Es wurde eine neue Kategorie hinzugefügt");
	  }
	  else
	  {
	    mysql_query("INSERT INTO foren (name, besch, kate, guest_see, min_posts, admin_start_thema, user_posts, sort, beitrag_plus) VALUES ('$_POST[fname]', '$_POST[besch]', '$_POST[kat]', '$_POST[guest]', '$_POST[min_post]', '$_POST[admin]', '$_POST[ansus]', '$_POST[sort]', '$_POST[hoch])");
	    echo "Das Forum wurde hinzugefügt.";
		insert_log("Es wurde ein neues Forum hinzugefügt");
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
	<br><b>Nachfolgende Eingaben werden nur bei einer Foren-Erstellung benötigt.</b><br><br>
	<table width=100%>
	<tr><td>In welcher Kategorie?</td><td><select name=kat>";
	$kate_data = mysql_query("SELECT * FROM kate");
	while($kd = mysql_fetch_object($kate_data))
	{
	  echo "<option value=$kd->id>$kd->name</option>";
	}
	echo "</select></td></tr>
	<tr><td width=50%>Wer soll Zugriff auf das Forum haben?</td><td><select name=guest><option value=0>Alle dürfen es sehen</option><option value=1>Nur angemeldete Mitglieder</option><option value=2>Nur Administratoren oder Moderatoren</option></td></tr>
	<tr><td>Nur Administratoren dürfen Themen erstellen?</td><td><select name=admin><option value=1>Nein</option><option value=0>Ja</option><option value=2>Moderatoren und Administratoren</option></td></tr>
	<tr><td>Dürfen Benutzer/Moderatoren antworten?</td><td><select name=ansus><option value=0>Ja</option><option value=1>Nein</option></td></tr>
	<tr><td>Wie viele Beiträge muss man haben, um Zugriff auf das Forum zu bekommen?</td><td><input type=text name=min_post></td></tr>
	<tr><td>Sortierung, die Foren werden so geordnet, auf der Startseite</td><td><input type=text name=sort></td></tr>
	<tr><td>Beitragszähler wird bei Beitrag erhöht?</td><td><input type=radio name=hoch value=0 checked>Ja <input type=radio name=hoch value=1> Nein</td></tr>
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
    check_data($_POST["points"], "", "Bitte fühle alle Felder aus (Verwarnpunkte)", "leer");
    check_data($_POST["dauer"], "", "Bitte fühle alle Felder aus (Dauer)", "leer");
    mysql_query("INSERT INTO verwarn_gruend (grund, punkte, zeit) VALUES ('$_POST[grund]', '$_POST[points]', '$_POST[dauer]')");
    echo "Danke, Grund wurde hinzugefügt und kann nun verwendet werden.<br><a href=admin.php?do=new_warn>Zurück</a>";
    insert_log("Verwarngrund wurde hinzugefügt");
	exit;
  }
  if($_GET["action"] == "del")
  {
    mysql_query("DELETE FROM verwarn_gruend WHERE id LIKE '$_GET[id]'");
  }
  echo "<table class=braun width=80%><tr class=besch><td><b>Bestehende Gründe</b></td></tr><tr><td><table>
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
		echo "<tr><td>$gh->grund</td><td>$gh->punkte</td><td>$zeit</td><td><a href=?do=new_warn&action=del&id=$gh->id>Löschen</a></tr>";
	  }
	}

  }
  echo "</table></td></tr></table><br><br>
  <table class=braun width=80%><tr class=besch><td><b>Verwarngrund hinzufügen</b></td></tr><tr><td>
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
	echo "Die Sperre von diesem Benutzer (ID: $_GET[id]) wurde zurückgenommen.";
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
	insert_log("Ein Benutzer wurde gesperrt");
	$gesp = $time+$_POST["dauer"];
	$spertime = ceil($gesp/600)*600;  
	mysql_query("UPDATE users SET gesperrt = '1', sptime = '$spertime' WHERE username LIKE '$_POST[ben]'");
	echo "$_POST[ben] wurde nun vom Forum ausgeschlossen.";
	exit;
  }

  $sperr_data = mysql_query("SELECT * FROM users WHERE gesperrt != '0' OR sptime > '$time'");
  $sp = "0";
  echo "<form action=?do=sper_user&action=new method=post><table>
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
	echo "<tr><td>$sd->username</td><td>". date("d.m.Y - h:i", $sd->sptime) ."</td><td><a href=?do=sper_user&action=del&id=$sd->id>[ Sperre aufheben ]</a></td></tr>";
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
	  echo "Die Kategorie wurde nun geändert.<br><a href=?do=ver_foren>Zurück zur Foren-Verwaltung</a>";
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
    insert_log("Ein Forum wurde gelöscht.");
    mysql_query("DELETE FROM foren WHERE id LIKE '$_GET[id]'");
  }
  if($ac == "del_kat")
  {
    $no_for = mysql_query("SELECT * FROM foren WHERE kate LIKE '$_GET[id]'");
	$me = mysql_num_rows($no_for);
	if($me == "0")
	{
	  insert_log("Eine Kategorie wurde gelöscht.");
      mysql_query("DELETE FROM kate WHERE id LIKE '$_GET[id]'");
	}
  }
  if($ac == "for")
  {
    if($_GET["done"] == "save")
	{
	  mysql_query("UPDATE foren SET name = '$_POST[name]', besch = '$_POST[besch]', kate = '$_POST[kate]', guest_see = '$_POST[guest]', admin_start_thema = '$_POST[admin]', user_posts = '$_POST[uspo]', min_posts = '$_POST[posts]', sort = '$_POST[sort]', beitrag_plus = '$_POST[hoch]' WHERE id LIKE '$_GET[id]'");
	  echo "Die Kategorie wurde nun geändert.<br><a href=?do=ver_foren>Zurück zur Foren-Verwaltung</a>";
	  exit;
	}
    $for_dat = mysql_query("SELECT * FROM foren WHERE id LIKE '$_GET[id]'");
	$fd = mysql_fetch_object($for_dat);
	// 0 = Gäste dürfen das Forum sehen, also Alle
	// 1 = Gäste dürfen das Forum nicht sehen Benutzer aber
	// 2 = Nur Administratoren und Moderatoren
	if($fd->guest_see == "0")
	{
	  $gast = "<option value=0>Alle dürfen es sehen</option><option value=1>Nur angemeldete Mitglieder</option><option value=2>Nur Administratoren oder Moderatoren</option>";
	}
	if($fd->guest_see == "1")
	{
	  $gast = "<option value=1>Nur angemeldete Mitglieder</option><option value=0>Alle dürfen es sehen</option><option value=2>Nur Administratoren oder Moderatoren</option>";
	}
	if($fd->guest_see == "2")
	{
	  $gast = "<option value=2>Nur Administratoren oder Moderatoren</option><option value=1>Nur angemeldete Mitglieder</option><option value=0>Alle dürfen es sehen</option>";
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
	<tr><td>Nur Administratoren dürfen Themen erstellen?</td><td><select name=admin>$admth</select></td></tr>
	<tr><td>Dürfen Benutzer/Moderatoren antworten</td><td><select name=uspo>$uspo</select></td></tr>
	<tr><td>Wie viele Beiträge muss man haben, um Zugriff auf das Forum zu bekommen?</td><td><input type=text name=posts value='$fd->min_posts'></td></tr>
	<tr><td>Sortierung, die Foren werden so geordnet, auf der Startseite</td><td><input type=text name=sort value='$fd->sort'></td></tr>
	<tr><td>Beitragszähler wird bei Beitrag erhöht?</td><td><input type=radio name=hoch value=0 $up1>Ja <input type=radio name=hoch value=1 $up2>Nein</td></tr>
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
    echo "<tr><td> &nbsp; </td></tr><tr><td><b>$fr->name</b><br>$fr->besch</td><td>$fr->ordn</td><td><a href=?do=ver_foren&action=kate&id=$fr->id>[ bearbeiten ]</a> <a href=javascript:delkat($fr->id)>[ löschen ]</a></td></tr>";
	$for_date = mysql_query("SELECT * FROM foren WHERE kate = '$fr->id' ORDER BY sort");
    while($fd = mysql_fetch_object($for_date))
    {
	  echo "<tr><td>$fd->name<br><small>$fd->besch</small></td><td>$fd->sort</td><td>  <a href=?do=ver_foren&action=for&id=$fd->id>[ bearbeiten ]</a> <a href=javascript:del($fd->id)>[ löschen ]</a></td></tr>";
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
  	insert_log("AdServer-Einstellungen wurden geändert.");
    mysql_query("UPDATE config SET wert1 = '$_POST[notsee]', zahl1 = '$_POST[akti]' WHERE erkennungscode LIKE 'f2adser2'");
	echo "Die AdServer-Einstellungen wurden geändert.";
	exit;
  }
  if($_GET["aktion"] == "insert")
  {
    if($_POST["bannerli"] == "" OR $_POST["link"] == "")
	{
	  echo "Bitte fülle die Bild-Adresse genauso wie die Link-Adresse aus.";
	  exit;
	}
    mysql_query("INSERT INTO adser (bannerad, link, klicks, see) VALUES ('$_POST[bannerli]', '$_POST[link]', '0', '0')");
	echo "Der Link wurde erfolgreich hinzugefügt.";
	insert_log("Link im AdServer wurde hinzugefügt");
    exit;
  }
  if($_GET["del"] != "")
  {
    mysql_query("DELETE  FROM adser WHERE id LIKE '$_GET[del]'");
    echo "Banner wurde erfolgreich gelöscht.";
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
  <tr><td>Trage in das folgende Kästchen die Benutzerid ein,<br>
  die den AdServer nicht sehen.<br>(Mit Komma Trennen ohne Leerzeichen! 2,5,9,7)</td><td><input type=text name=notsee value='$aa->wert1' size=40></td></tr>
  </table>
  <input type=submit value=Speichern>
  </form>
  </td></tr></table>
  
  <br>
  
  <table class='braun'><tbody><tr class='besch'><td><b>Links hinzufügen</b></td></tr><tr><td>
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
    echo "<tr><td>$adh->link</td><td>$adh->see</td><td>$adh->klicks</td><td><a href=?do=adser&del=$adh->id>Löschen</a></tr>";
  }
  
  echo "</table></td></tr></table>
  
  ";
  break;
  
  
  case "sendbrief":
    left_table($sons);
    admin_recht("2");
	check_data($_POST["tit"], "", "Bitte gebe einen Titel ein.<br><a href='javascript:history.back()'>Zurück</a>", "leer");
	check_data($_POST["mes"], "", "Bitte gebe eine Nachricht ein.<br><a href='javascript:history.back()'>Zurück</a>", "leer");
	$time = time() - $_POST["days"];
	$posts = $_POST["posts"];
	if($posts == "")
	{
	  $posts = "0";
	}
	$data_hol = mysql_query("SELECT * FROM users WHERE $time < last_log AND posts >= $posts");
	$usernamen = array("");
	while($dh = mysql_fetch_object($data_hol))
	{
	  $time = time();
	  $mes = $_POST["mes"];
	  $mes = str_replace("[USERNAME]", $dh->username, $mes);
	  $mes = str_replace("[BEITRAEGE]", $dh->posts, $mes);
	  $tit = $_POST["tit"];
	  $tit = str_replace("[USERNAME]", $dh->username, $tit);
	  $tit = str_replace("[BEITRAEGE]", $dh->posts, $tit);
	  mysql_query("INSERT INTO prna (abse, emp, dat, betreff, mes, gel) VALUES ('". USER . "', '$dh->username', '$time', '$tit', '$mes', '0')")or die(mysql_error());
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
    left_table($sons);
    admin_recht("2");
	echo "<table class='braun'><tbody><tr class='besch'><td><b>Rundbrief verfassen</b></td></tr><tr><td>
	Mit den folgenden Feldern kannst du einen Rundbrief, also einen Brief an alle aktiven Mitglieder verfassen.<br>Um Datenbank-belastung auszuschließen, werden inaktive Benutzer von der Rundmail ausgeschlossen.<br>
	<b>Variablen-Ersetzung:</b>
	<table>
	<tr><td>[USERNAME]</td><td>Zeigt den jeweiligen Benutzernamen an</td></tr>
	<tr><td>[BEITRAEGE]</td><td>Zeigt die Beiträge des Benutzers an</td></tr>
	</table><br><br>
	<form action=?do=sendbrief method=post>
	<small>Titel:</small><br>
	<input type=text name=tit size=50><br><br>
	<small>Nachricht:</small><br>
	<textarea rows=5 cols=50 name=mes></textarea><br><br>
	<fieldset><legend>Einstellungen</legend><table><tr><td>
	<small>Benutzer muss aktiv in den letzten</small><br>
	<select name=days><option value=172800>2</option><option value=432000>5</option><option value=604800>7</option><option value=864000>10</option><option value=1209600>14</option><option value=1814400>21</option></select>Tagen sein.</td><td>
	<small>...und muss mindestens</small><br>
	<input type=text name=posts value=0 size=3 maxlength=6> Beiträge haben.<br>
	</td></tr></table></fieldset><br><br>
	<input type=submit value='Nachrichten verschicken'>
	</form>
	";
  break;
  
  
  case "styles":
    left_table($design);
    echo "<table class='braun'><tbody><tr class='besch'><td><b>Style-Verwaltung</b></td></tr><tr><td>
	<table>
	<tr><td><b>Style-Name</b></td><td><b>Stylelink</b></td><td><b>Aktion></b></td></tr>";
    $style_data = mysql_query("SELECT * FROM style_all");
	while($sd = mysql_fetch_object($style_data))
	{
	  echo "<tr><td>$sd->sname</td><td>$sd->link_style</td><td><a href=?do=del_style&id=$sd->id>Löschen</a></tr>";
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
	  echo "Style wurde erfolgreich gelöscht.";
	  exit;
	}
    echo "Möchtest du dieses Style wirklich löschen? Das System löscht die *.css Datei automatisch mit, damit es nicht zu Fehlern führen kann.<br>
	Wirklich löschen?<br><br>
	<a href=?do=del_style&aktion=del&id=$_GET[id]>Ja, Style und Datei löschen</a> &nbsp; &nbsp; <a href=?do=styles>Nein, zurück zur Übersicht</a>";
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
	  echo "Danke, dieser Style wurde erfolgreich hinzugefügt und kann nun verwendet werden.";
	  exit;
	}
	echo "<table class='braun'><tbody><tr class='besch'><td><b>Style-Verwaltung</b></td></tr><tr><td>
    Hier kannst du einen Style hinzufügen. Bitte beachte, dass diese .css Datei exestieren muss!<br><br>
	<form action=?do=insert_style&aktion=insert method=post>
	<table>
	<tr><td>Name des Styles:</td><td><input type=text name=sname></td></tr>
	<tr><td>Link zum Style:</td><td>". $_SERVER["SERVER_NAME"] ."/style/<input type=text name=link value='.css'></td></tr>
	</table>
	<input type=submit value=Hinzufügen>
	</form>
    </td></tr></table>";
  break;
}
?>
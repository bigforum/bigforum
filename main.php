<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
login();
looking_page("main");
page_header();
include("includes/function_user.php");
$do = $_GET["do"];
$ac = $_GET["aktion"];
$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2pnsignfs'");
$cd = mysql_fetch_object($config_datas);
if($cd->zahl2 == "1")
{
  $pn_anzeige = '<tr><td><a href="?do=pn_ein">Eingang</a></td></tr>
<tr><td><a href="?do=pn_aus">Ausgang</a></td></tr>
<tr><td><a href="?do=make_pn">Verfassen</a></td></tr>';
  $pn_deakt = false;
}
else {
  $pn_anzeige = '<tr><td>Eingang</td></tr>
<tr><td>Ausgang</td></tr>
<tr><td>Verfassen</td></tr>';
  $pn_deakt = true;
}
if($cd->zahl1 == "1")
{
  $sign = '<tr><td><a href="?do=sign">Signatur ändern</a></td></tr>';
}
else
{
  $sign = '<tr><td><span title="Signatur deaktiviert">Signatur ändern</span></td></tr>';
}
?>
<table width="100%">
<tr><td valign="top" width="25%">
<!-- Navigation -->

<table width="100%">
<tr><td bgcolor="#397BC6" color="snow">
<b>Allgemeine Einstellungen</b></td></tr>
<tr><td><a href="?do=change_pw">Passwort ändern</a></td></tr>
<tr><td><a href="?do=set">Sonstige Einstellungen</a></td></tr>
<tr><td bgcolor="#397BC6" color="snow">
<b><a href="profil.php?id=<? echo $ud->id;?>"><font color=black>Profil</font></a></b></td></tr>
<tr><td><a href="?do=profil">Mein Profil</a></td></tr>
<tr><td><a href="?do=ava">Avatar</a></td></tr>
<?php echo $sign; ?>
<tr><td bgcolor="#397BC6" color="snow"><b>Private Nachricht</b></td></tr>
<? echo $pn_anzeige; ?>
</table>

</td>
<td valign="top">
<!-- Inhalt -->
<?php
if($do == ""){ 
echo"Hallo ".USER." ,<br>
willkommen in deinem Bereich. Hier ist es möglich deine Einstellungen so wie deine Profil-Daten zu ändern.<br><br>";
page_close_table();
}
if($do == "sign") {
if($cd->zahl1 != "1")
{
  echo "<b>Info:</b>Die Signaturen wurden von einem Administrator gesperrt.";
  page_close_table();
}
if($ac == "send"){
mysql_query("UPDATE users SET sign = '$_POST[feld]' WHERE username LIKE '".USER."'");
echo "Danke, deine Signatur wurde geändert.";
page_close_table();
}
echo "<fieldset><legend>Signatur ändern</legend>";
editor("sign", $ud->sign, "?do=sign");
echo "</fieldset><br>";
if($ud->sign != "")
{
  $text = $ud->sign;
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
  echo "<fieldset><legend>Deine Signatur</legend>$text</fieldset>";
}
page_close_table();
}
if($do == "ava"){
if($ac == "send")
{
$dateityp = GetImageSize($_FILES['datei']['tmp_name']);
if($dateityp[3] != 0)   {
     echo "Bitte verwende ein anderes Format, dein Format ist nicht erlaubt";
	 page_close_table();
	}
   if($_FILES['datei']['size'] <  102400)
      {
      move_uploaded_file($_FILES['datei']['tmp_name'], "images/avatar/".$_FILES['datei']['name']);
      echo "Danke, dein Avatar wurde hochgeladen, es wird nun angezeigt.";
	  $pfad = $_FILES['datei']['name'];
	  mysql_query("UPDATE users SET ava_link = 'images/avatar/$pfad' WHERE username LIKE '". USER ."'");
      }
   else
      {
         echo "Das Bild darf nicht größer als 100 kb sein ";
      }

}
?>
<fieldset>
<legend>Avatar hochladen</legend>
Hier kannst du dir dein eigenes Avatar hochladen. Bitte beachte, dass dein Avatar nicht zu groß sein sollte.<br>
Beachte das egal wie groß dein Avatar ist, es automatisch in 100x100 px  umgewandelt wird (Kann Abweichungen geben).
<form action="?do=ava&aktion=send" method="post" enctype="multipart/form-data">
<input type="file" name="datei"><br>
<input type="submit" value="Hochladen">
</form>
</fieldset>
<?
if($ud->ava_link != "")
{
  echo "<fieldset><legend>Dein Avatar</legend><img src=$ud->ava_link title=\"Dein Avatar\" width=100 height=100>";
}
page_close_table();
}


if($do == "set")
{   
    if($ac == "insert")
	{
	  if($_POST["pn_weiter"] == "1")
	  {
	    $eintrag = mysql_query("UPDATE users SET pn_weiter = '1' WHERE username LIKE '". USER ."'");
	  }
	  else
	  {
	    $eintrag = mysql_query("UPDATE users SET pn_weiter = '0' WHERE username LIKE '". USER ."'");
	  }
	  speicherung($eintrag, "Deine Einstellungen wurden überarbeitet.", "<b>Fehler:</b> Es gab einen Fehler bei der Speicherung der Einstellungen <a href=history.back()>Zurück</a>");
      page_close_table();
	}
    include("includes/function_user.php");
    $checked = "";
    if($ud->pn_weiter == "1")
	{
	  $checked = "checked";
	}
    echo "<table width=100%><tr bgcolor=#397BC6><td><big><b>Allgemeine Einstellungen » Sonstige Einstellungen » </b> ".USER." </big></td></tr></table><br>
	<fieldset><legend>Private Nachrichten</legend>
	<form action=?do=set&aktion=insert method=post>
	<table>
	<tr><td>Automatische Weiterleitung zu dem Posteingang, beim Mauskontakt, des blinkenden Textes \"Neue Nachrichten\" oben über deiner Navigationsliste.</td><td width=40%>
	<input type=checkbox name=pn_weiter value=1 $checked></td></tr></table>
	</fieldset><br>";
	if($ud->notice != "" AND $ud->notice != "0")
	{
	  ?>
	  <script>
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

 
 
 
      function delnotice() {
        d = confirm("Wurde die Notiz zur Kentniss genommen, und kann nun gelöscht werden?");
        if(d == true)
        {
          xmlhttp.open("GET", 'main.php?do=del_notice');
          alert("Die Notiz wurde gelöscht.");
		  document.getElementById("notice").innerHTML = "";
        }
        xmlhttp.send(null);
      }


     </script>
<span id="notice"><fieldset><legend>Sonstige Einstellungen</legend>
	  <a href="javascript:delnotice();">Notiz, die im Header angezeigt wird, ausbleden</a></fieldset><br></span>
<?php
	}
	echo "<input type=submit value=Speichern>";
	page_close_table();


}
if($do == "del_notice")
{
  mysql_query("UPDATE users SET notice = '' WHERE username LIKE '". USER ."'");
}
if($do == "pn_ein")
{
  if($pn_deakt == true)
  {
    echo "Das Private Nachrichten System wurde von einem Administrator gesperrt!";
    page_close_table();
  }
  looking_page("look_pn");
    echo "<table width=100%><tr bgcolor=#397BC6><td><big><b>Private Nachrichten » Eingang » </b> ".USER." </big></td></tr></table><br>";
  $pn_data = mysql_query("SELECT * FROM prna WHERE emp LIKE '". USER ."' ORDER BY dat DESC");
  echo "<table width=100%><tr style=font-weight:bold;  bgcolor=#e1e4f9><td width=70%>Betreff / Absenden</td><td>Datum</td></tr>";
  while($pr = mysql_fetch_object($pn_data))
  {
    $betreff_pn = strip_tags($pr->betreff);
    $datum = date("d.m.Y",$pr->dat);
    $uhrzeit = date("H:i",$pr->dat);
	if($pr->gel == "0")
	{
      echo "<tr><td width=70%><b> <a href=?do=read_pn&aktion=$pr->id>$betreff_pn</a> </b><br>$pr->abse</td><td>$datum<br>$uhrzeit</td></tr>";
	}
	else 
	{
      echo "<tr><td> <a href=?do=read_pn&aktion=$pr->id>$betreff_pn</a><br>$pr->abse</td><td>$datum<br>$uhrzeit</td></tr>";	
	}
  }
  echo "</table>";
}
if($do == "read_pn" AND $ac != "")
{
  if($pn_deakt == true)
  {
    echo "Das Private Nachrichten System wurde von einem Administrator gesperrt!";
    page_close_table();
  }
  looking_page("read_pn");
  $pn_aus = mysql_query("SELECT * FROM prna WHERE id LIKE '$ac'");
  $pr = mysql_fetch_object($pn_aus);
  if($pr->mes == "" OR ($pr->abse != USER AND $pr->emp != USER))
  {
    echo "<b>Fehler:</b>Dir fehlen die Berechtigungen!";
  }
  if($pr->emp == USER)
  {
    mysql_query("UPDATE prna SET gel = '1' WHERE id LIKE '$ac'");
  }
  $text = $pr->mes;
  $betreff = strip_tags($pr->betreff);
  $from = $pr->abse;
  $datum = date("d.m.Y",$pr->dat);
  $uhrzeit = date("H:i",$pr->dat);
  echo "<table width=81%><tr background='images/dark_table.png'><td><font color=snow>$datum, $uhrzeit</font></td></tr></table>";
  text_ausgabe($text, $betreff, $from);
  $betreff = str_replace(" ", "_", $betreff);
  echo "<table width=81%><tr><td align=right><a href=main.php?do=make_pn&to=$from&bet=$betreff><img src=images/answer.png border=0 width=95 height=50></a>";
}
if($do == "pn_aus")
{
  if($pn_deakt == true)
  {
    echo "Das Private Nachrichten System wurde von einem Administrator gesperrt!";
    page_close_table();
  }
  looking_page("look_pn");
    echo "<table width=100%><tr bgcolor=#397BC6><td><big><b>Private Nachrichten » Eingang » </b> ".USER." </big></td></tr></table><br>";
  $pn_data = mysql_query("SELECT * FROM prna WHERE abse LIKE '". USER ."' ORDER BY dat DESC");
  echo "<table width=100%><tr style=font-weight:bold;  bgcolor=#e1e4f9><td width=70%>Betreff / Empfänger</td><td>Datum</td></tr>";
  while($pr = mysql_fetch_object($pn_data))
  {
    $datum = date("d.m.Y",$pr->dat);
    $uhrzeit = date("H:i",$pr->dat);
    echo "<tr><td> <a href=?do=read_pn&aktion=$pr->id>$pr->betreff</a><br>$pr->emp</td><td>$datum<br>$uhrzeit</td></tr>";	
  }
  echo "</table>";
}
if($do == "make_pn")
{
looking_page("create_pn");
if($pn_deakt == true)
{
  echo "Das Private Nachrichten System wurde von einem Administrator gesperrt!";
  page_close_table();
}
if($ac == "change")
{
error_reporting(E_ALL);
  $to = $_POST["to"];
  $text = $_POST["feld"];

  check_data($text, "", "Du hast vergessen etwas anzugeben", "leer");
  check_data($_POST["bet"], "", "Du hast vergessen etwas anzugeben", "leer");
   check_data($to, "", "Du hast keinen Empfänger angegeben", "leer");
  check_data($text, "10", "Der angegebene Text ist zu kurz!", "laenge");
  $time = time();
  $eintrag = mysql_query("INSERT INTO prna (abse, emp, dat, betreff, mes, gel) VALUES ('". USER . "', '$to', '$time', '$_POST[bet]', '$_POST[feld]', '0')")or die(mysql_error());
  speicherung($eintrag, "Danke, deine Nachricht wurde versendet.", "<b>Fehler:</b> Es gab einen Fehler bei der Speicherung.");
  page_close_table();
  }
editor("pn", $_GET["to"], $_GET["bet"]);
page_close_table();

}
if($do == "change_pw") {
echo "<table width=100%><tr bgcolor=#397BC6><td><big><b>Allgemeine Einstellungen » Passwort ändern » </b> ".USER." </big></td></tr></table><br>";
if($ac == ""){
echo "<form action=?do=change_pw&aktion=change method=post>
Bitte gebe zuerst dein aktuelles Passwort ein.<br>
<input type=password name=old_pw>
<fieldset>
<legend>Passwort ändern</legend>
Bitte gebe in den folgenden Feldern dein neues Passwort und die Wiederholung davon ein.<br>
<br>
<table><tr><td>Neues Passwort</td><td>Neues Passwort (wiederholung)</td></tr>
<tr><td><input type=password name=pw1></td><td><input type=password name=pw2></td></tr></table>
</fieldset>
<input type=submit value=Bestätigen>
</form>
";
page_close_table();
}
if($ac == "change")
{
  //Wegen Benutzer-Datenbankabfragen noch die wichtige Datei dafür herhohlen:
  include("includes/function_user.php");
  $old_pw = md5($_POST["old_pw"]);
  $pw1 = md5($_POST["pw1"]);
  $pw2 = md5($_POST["pw2"]);
  check_data($pw1, $pw2, "Die Passwörter stimmen nicht überein!", "gleich");
  check_data($old_pw, $ud->pw, "Dein altes Passwort ist falsch!", "gleich2");
  check_data($pw1, "", "Du musst schon ein Passwort eingeben", "leer");
  $eintrag = mysql_query("UPDATE users SET pw = '$pw1' WHERE username LIKE '". USER ."'");
  speicherung($eintrag, "Danke, dein Passwort wurde erfolgreich übernommen", "<b>Fehler:</b> Es gab einen Fehler bei der Speicherung des Passwortes.<br>Versuche es nochmal! <a href=history.back()>Zurück</a>");
  page_close_table();

}
}
if($do == "profil")
{
  echo "<table width=100%><tr bgcolor=#397BC6><td><big><b>Profil » Mein Profil » </b> ".USER." </big></td></tr></table><br>";
  if($ac == "")
  {
    include("includes/function_user.php");
    echo "<form action=?do=profil&aktion=change method=post>
	<fieldset><legend>Profil bearbeiten</legend>
	Hier kannst du deine Website, sowie deine Hobbys angeben. Diese werden dann im Profil zu finden sein.<br>
	<table><tr><td>Hobbys</td><td>Website</td></tr>
	<td><input type=text name=hob value=\"$ud->hob\" size=40  maxlength=160></td><td><input type=text name=website value=\"$ud->website\" size=40 maxlength=110></td></tr></table>
	</fieldset><input type=submit value=Bearbeiten>";
	page_close_table();
  }
  if($ac == "change")
  {
    $web = $_POST["website"];
	$web = str_replace("http://","",$web);
    $eintrag = mysql_query("UPDATE users SET hob = '$_POST[hob]', website = '$web' WHERE username LIKE '". USER ."'");
	speicherung($eintrag, "Danke, dein Profil wurde erfolgreich übernommen", "<b>Fehler:</b> Es gab einen Fehler bei der Speicherung des Profils.<br>Versuche es nochmal! <a href=history.back()>Zurück</a>");
    page_close_table();
  }
}
?>
</td>
</tr>
</table>
<?
//Wichtige Datein für den Footer
page_footer();
?>
<?php
include("includes/functions.php");
page_header();
if($_GET["do"] =="")
{
?>
<script type="text/javascript">
function anzeigen() {
  document.getElementById("eins").style.display='none';
  document.getElementById("zwei").style.display='block';
}
</script>

<div style="display: block;" id="eins">


Bitte stimme den Nutzungsbedingungen des Forums zu, um einen Foren-Account zu erstellen:<br><br>
<textarea cols=70 rows=7><?php
$ausgabe = file_get_contents("rules.txt");
echo $ausgabe;
?></textarea><br>
<input type=button value="Ich halte mich an die Regeln" onclick="javascript:anzeigen();"> <input type=button value="Ich bin mit den Regeln nicht einverstanden" onclick="window.location.href='index.php'">
</div>
<div style="display: none;" id="zwei">
<form action="?do=reg" method=post>
<b>Benutzernamen:</b><br>
<input type=text name=user>
<fieldset>
<legend>Passwort</legend>
<table><tr><td>Bitte geben Sie in den folgenden Feldern ihr Passwort und die Wiederholung des Passwortes ein.<br>Es wird auf Groß-/Kleinschreibung geachtet.</td></tr></table>
<table><tr><td>Passwort</td><td>Passwort Wiederholung</td></tr>
<tr><td><input type=password name="pw1"></td><td><input type=password name="pw2"></td></tr>
</table>
</fieldset>
<fieldset>
<legend>eMail-Adresse</legend>
<table><tr><td>Bitte geben Sie in dem folgendem Feld eine gültige eMail-Adresse an.</td></tr></table>
<table><tr><td>eMail-Adresse</td></tr>
<tr><td><input type=text name="mail"></td></tr>
</table>
</fieldset>
<fieldset>
<legend>Empfohlen von.. (optional)</legend>
<table><tr><td>Du kannst im folgendem Feld angeben, wer dich geworben hat.</td></tr></table>
<table><tr><td>Empfohlen von:</td></tr>
<tr><td><input type=text name="empfo"></td></tr>
</table>
</fieldset>
<input type=submit value="Registrierung Abschicken">
</form>
</div>
<?
exit;
}
if($_GET["do"] == "reg")
{
  $_POST["user"] = strip_tags($_POST["user"]);
  $_POST["user"] = str_replace("  ","",$_POST["user"]);
  check_data($_POST["pw1"], "", "Du musst schon ein Passwort eingeben", "leer");
  check_data($_POST["pw1"], $_POST["pw2"], "Die Passwörter stimmen nicht überein!", "gleich");
  check_data($_POST["mail"], "", "Die angegebene eMail Adresse ist ungültig!", "mail");
  check_data($_POST["user"], "3", "Der angegebene Benutzername ist zu kurz!", "laenge");
  $user_data_akt = mysql_query("SELECT * FROM users WHERE username LIKE '$_POST[user]'");
  $row = mysql_num_rows($user_data_akt);
  check_data($row, "", "Dieser Benutzername exestiert bereits", "null");
  $ben_verb = mysql_query("SELECT * FROM verbo WHERE benemail LIKE '2'");
  while($bv = mysql_fetch_object($ben_verb))
  {
    if($bv->name == $_POST["user"])
	{
	  $verb = true;
	}
  }
  if($verb == true)
  {
    erzeuge_error("Leider wurde dieser Benutzername von einem Administrator als \"Verboten\" eingestuft. Du kannst diesen somit nicht verwenden.");
    page_footer();
  }
  $em_verb = mysql_query("SELECT * FROM verbo WHERE benemail LIKE '1'");
  while($ev = mysql_fetch_object($em_verb))
  {
    if($ev->name == $_POST["mail"])
	{
	  $veb = true;
	}
  }
  if($veb == true)
  {
    erzeuge_error("Leider wurde diese eMail-Adresse von einem Administrator als \"Verboten\" eingestuft. Du kannst diesen somit nicht verwenden.");
    page_footer();
  }
  $pw = md5($_POST["pw1"]);
  $time = time();
  $eintrag = mysql_query("INSERT INTO users (username, posts, reg_dat, last_log, reg_ip, sign, group_id, pw, mail, rang, last_site, gesperrt, pn_weiter, ava_link, empfo) VALUES ('$_POST[user]', '0', '$time', '', '$_SERVER[REMOTE_ADDR]', '', '1', '$pw', '$_POST[mail]', 'Benutzer', '', '0', '1','','$_POST[empfo]')");
  speicherung($eintrag, "Danke, dein Benutzername wurde erfolgreich gespeichert.<br><a href=login.php>Nun aber einloggen</a>", "<b>Fehler:</b> Es gab einen Fehler bei der Speicherung des Benutzernamen.<br>Versuche es nochmal! <a href=javascript:history.back()>Zurück</a>");
}
page_footer();
?>
<?php
include("includes/functions.php");
if($_GET["do"] == "login")
{
  connect_to_database();
  $data = mysql_query("SELECT * FROM users WHERE username LIKE '$_POST[user]'");
  $dr = mysql_fetch_object($data);
  $pw = md5($_POST["pw"]);
  if($dr->pw == $pw)
  {
    setcookie ("username", $dr->username, time() +60*60*24*365);  
	setcookie ("passwort", $pw, time() +60*60*24*365);  
	setcookie ("last_login", "1", time() + 3600);
	header("Location: index.php");
  }
}
if($_GET["do"] == "logout")
{
  setcookie('username', '', time()-3600);
  header("Location: index.php");
}  
//Wichtige Angaben für jede Datei!

page_header();
if($_GET["do"] == "")
{
?>
<form action="?do=login" method=post name="login">
<table style="border:solid 1px #914400;" width="70%" cellspacing='0' cellpadding='0'><tr bgcolor="#F5EBC6"><td style="border-bottom:solid 1px #914400;"><center>Anmelden</center></b></td></tr><tr><td>
<br>Durch eine Anmeldung im unterem Teil, kannst Du das Forum im vollen Umfang zu nutzen.<br> Solltest du hier noch keinen Account haben kannst du dich <a href=reg.php>hier registrieren</a>.<br>
<?php
$config_data = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2mf2'");
$cd = mysql_fetch_object($config_data);
if($cd->zahl2 == "1")
{
?>
Solltest du dein <a href="misc.php?aktion=lost_pw">Passwort vergessen</a> haben, kannst du gerne eine neues Anfodern.
<?php 
}?>
<p>
<hr width="101%" color="#914400">
<table>
<tr><td width=50%>
	  Benutzername:</td><td><input type=text name=user>
	</td>
  </tr>
  <tr>
	<td>
	  Passwort:</td><td><input type=password name=pw>
    </td>
  </tr>
</table>
<br>
</td></tr></table>
<table width="70%"><tr><td align=right>
<input type=submit value="Login" style="font-weight: bold;font-size: 11px;padding: 0px;background-color:#e3d1a5;border:solid 1px black;height:25px;width:50px;">
<input type=button onclick="javascript:document.login.user.value=''; document.login.pw.value='';" value="Felder zurücksetzen" style="font-weight: bold;font-size: 11px;padding: 0px;background-color:#e3d1a5;border:solid 1px black;height:25px;width:125px;">

</form></td></tr></table>

	  <br>
	  <br>
	  <br>
	  <br>
	  <br>
	  <br>
<?php
}
if($_GET["do"] == "login")
{
  $data = mysql_query("SELECT * FROM users WHERE username LIKE '$_POST[user]'");
  $dr = mysql_fetch_object($data);
  $pw = md5($_POST["pw"]);
  if($dr->pw == $pw)
  {
    $time = time();
    mysql_query("UPDATE users SET last_log = '$time' WHERE username LIKE '$dr->username'");
    echo "Erfolgreich eingeloggt.<br><a href=index.php>Zur Startseite</a>";
  }
  else
  {
    echo "Leider stimmen die Daten nicht überein.";
  }
}
//Wichtige Datein für den Footer
page_footer();
?>
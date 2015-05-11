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
<form action="?do=login" method=post>
<table>
  <tr>
    <td>
	  Benutzername:</td><td><input type=text name=user>
	</td>
  </tr>
  <tr>
	<td>
	  Passwort:</td><td><input type=password name=pw>
	</td>
  </tr>
</table>
<input type=submit value="Einloggen">
</form>
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
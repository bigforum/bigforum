<?php
session_start();
include("admin_functions.php");
if($_SESSION["admin_login"] == "login_true")
{

  header("Location: admin.php");
}
//Besondere Anweisungen für den Administrator-Kontrollzentrum
include("../includes/functions.php");
config("f2name2", false, "function_define");
can_view_admincp();
if($_GET["do"] == "login")
{
  if(MDPW == md5($_POST["pw"]))
  {  
    insert_log("Erfolgreiche Administratoren-Anmeldung.");
    $_SESSION["admin_login"] = "login_true";
    header("Location: admin.php");
  }
  else
  {
    echo "<title>Fehlgeschlagene Anmeldung - Administrator-Kontrollzentrum</title>
	Leider stimmt dein Passwort nicht. <a href=index.php>Zurück</a>";
	exit;
  }
}
echo "<style>
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
</style>
<a href=../index.php>Foren-Übersicht</a> | <a href=../login.php?do=logout>Abmelden</a><br>";
echo "<title> ". SITENAME ." - Administrator Kontrollzentrum - Login</title><br>";
echo "  <table class=braun width=80%><tr class=besch><td><b>Administratoren-Kontrollzentrum - Login</b></td></tr><tr><td>
Hallo ".USER.",<br>um die Anmeldung für das Administrator-Kontrollzentrum zu bestätigen, benötigen wir dein Passwort.<br><br><form action=?do=login method=post>Passwort: <input type=password name=pw><br><input type=submit value=Einloggen></form></td></tr></table>";
?>
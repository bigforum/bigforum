<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
page_header();
looking_page("kontakt");
login();
$user_data = mysql_query("SELECT * FROM users WHERE username LIKE '". USER ."'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
$ud = mysql_fetch_object($user_data);
$config_data = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2mf2'");
$cd = mysql_fetch_object($config_data);
if($cd->zahl2 != "1")
{
  erzeuge_error("Das Kontaktformular steht in diesem Forum leider nicht zur Verfügung.");
}
if($_GET["do"] == "send")
{
  $admin_data = mysql_query("SELECT * FROM users WHERE group_id = '3'");
  while($ad = mysql_fetch_object($admin_data))
  {
    $mail_empfaenger= $ad->mail;
    $mail_absender= $ud->mail;
    $betreff= $_POST["betr"];
    $header  = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $header .= "From: $mail_absender\r\n";
    $header .= "Reply-To: $mail_empfaenger\r\n";
    $text= "Hallo $ad->username,<br><br>
	Du hast im Forum über das Kontaktformular eine Nachricht erhalten:<br><br>
	Nachricht von $ud->username:<br>
	----------------------------------------<br>
	$_POST[mes]<br>
	----------------------------------------<br><br>
	Diese Nachricht wurde an alle Administratoren geschickt.";
    mail($mail_empfaenger, $betreff, $text, $header);
  }	
  echo "Danke, diese Nachricht wurde an alle Administratoren dieses Forums geschickt.";
  exit;
}
echo "<form action=?do=send method=post><small>Betreff:</small><br>
<select name=betr><option value='Fehler im Forum'>Fehler im Forum</option><option value='Feedback'>Feedback</option><option value='Hilfe'>Benötige Hilfe</option><option value='Sonstiges'>Sonstiges</option></select><br><br>
<small>Nachricht:</small><br>
<textarea cols=70 rows=7 name=mes></textarea><br><input type=submit value='Nachricht senden'></form>";
page_footer();
?>
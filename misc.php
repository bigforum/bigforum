<?php
include("includes/functions.php");
connect_to_database();
if($_GET["aktion"] == "show_ver")
{
  echo VERSION;
}
if($_GET["aktion"] == "lost_pw")
{
  page_header();
  echo "Bitte gebe im folgendem Feld deine eMail-Adresse ein, um ein neues Passwort anzufordern:<br><br>
  <form action=?aktion=lp method=post>
  eMail-Adresse: <input type=text name=mail><br>
  <input type=submit value='Passwort anfordern'>
  </form>";
  page_footer();
}
if($_GET["aktion"] == "lp")
{
  $mail_get = mysql_query("SELECT * FROM users WHERE mail LIKE '$_POST[mail]' LIMIT 1");
  if(mysql_num_rows($mail_get) == "0")
  {
    page_header();
    erzeuge_error("Leider ist diese eMail-Adresse nicht verfügbar, bitte achte darauf das du dich nicht vertippt hattest.<br><br>
	Deine eingetippte eMail-Adresse war: <i> $_POST[mail]");
	page_footer();
  }
  else
  {
    config("f2name2", true, "function_define");
    $max=1;
    $arr=strtoupper(substr(md5(mt_rand(1,1000000)),0,6));
    $pw = $arr;
    $link = "$_SERVER[SERVER_NAME]/misc.php?aktion=change_pw&mail=$_POST[mail]&pw=$pw";
    $mail_empfaenger= $_POST["mail"];
	$am = str_replace("http://","", $_SERVER["SERVER_NAME"]);
    $am = str_replace("www.","", $_SERVER["SERVER_NAME"]);
    $mail_absender= "noreply@$am";
    $betreff= "Neues Passwort - ". SITENAME ."";
	$header  = "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $header .= "From: $mail_absender\r\n";
    $header .= "Reply-To: $mail_empfaenger\r\n";
	$time = time();
    mysql_query("INSERT INTO passwort_verg (mail, time, passwort) VALUE ('$_POST[mail]', '$time', '$pw')");
    $text= "Hallo,<br>
	Du hast ein neues Passwort angefordert.<br>
    Dein neues Passwort lautet: $pw<br>
    Bitte bestätige mit dem untengennantem Link dein Passwort:<br><br>
	<a href=$link>$link</a><br><br>
	Solltest du kein neues Passwort angefordert haben, kannst du diese Mail ignorieren.<br><br>
	Mit freundlichen Grüßen,<br>
	Das Forum-Team";
    mail($mail_empfaenger, $betreff, $text,$header);
	page_header();
	echo "Passwort wurde verschickt.<br>Bitte überprüfe nun deinen Posteingang.";
	page_footer();
  }
}
if($_GET["aktion"] == "change_pw")
{
  $ho_pw = mysql_query("SELECT * FROM passwort_verg WHERE mail LIKE '$_GET[mail]' ORDER BY id DESC LIMIT 1");
  $hp = mysql_fetch_object($ho_pw);
  if($hp->passwort == $_GET["pw"])
  {
    page_header();
	$pw = md5($_GET["pw"]);
	echo "Danke, dein Passwort wurde geändert. Du kannst es gleich nach dem ersten Login ändern.";
	mysql_query("UPDATE users SET pw = '$pw' WHERE mail LIKE '$_GET[mail]'");
	page_footer();
  }
  else
  {
    page_header();
	erzeuge_error("Bitte rufe genau den Link auf, der in der Mail steht.");
	page_footer();
  }
}
if($_GET["aktion"] == "stat_po")
{
  $hoch_post = mysql_query("SELECT * FROM users ORDER BY posts DESC LIMIT 4");
  $x = "0";
  $color = array("schwarz","lila","gelb");
  while($hp = mysql_fetch_object($hoch_post))
  {
    if($x == "0")
	{
	  $data = "$hp->username:$hp->posts:rot";
	}
	else
	{
	  $data .= ", $hp->username:$hp->posts:$color[$x]";
	}
	$x++;
  }
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2adser2'");
  $con = mysql_fetch_object($config_wert);
  diagramm($con->wert1, 10, $data, "Beiträge", 550, 150);
  exit;
}
if($_GET["aktion"] == "stat_pr")
{
  $hoch_post = mysql_query("SELECT * FROM users ORDER BY provi DESC LIMIT 4");
  $b = "0";
  $colors = array("schwarz","lila","gelb");
  while($hp = mysql_fetch_object($hoch_post))
  {
    if($b == "0")
	{
	  $data = "$hp->username:$hp->provi:rot";
	}
	else
	{
	  $data .= ", $hp->username:$hp->provi:$colors[$b]";
	}
	$b++;
  }
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2adser2'");
  $con = mysql_fetch_object($config_wert);
  diagramm($con->wert1, 10, $data, "Besucher", 550, 150);
  exit;
}
if($_GET["aktion"] == "adser")
{
  $adda = mysql_query("SELECT * FROM adser WHERE id LIKE '$_GET[id]'");
  $ad = mysql_fetch_object($adda);
  mysql_query("UPDATE adser SET klicks = klicks+1 WHERE id LIKE '$_GET[id]'");
  header("Location: $ad->link");
  exit;
}
if($_GET["aktion"] == "show_stat")
{
  page_header();
  echo "In den folgenden Diagrammen siehst du Forenstatistiken, um welche es sich handelt ist drüber beschrieben:<br><br>
  <h2>Beiträge</h2><hr>
  <img src='misc.php?aktion=stat_po'><br><br>
  <h2>Profilbesucher</h2><hr>
  <img src='misc.php?aktion=stat_pr'>";
  page_footer();
}
?>
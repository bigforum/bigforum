<?php
include("includes/functions.php");
if($_GET["do"] == "send")
{
  setcookie("Quiz", time(), time()+60*60*3);
}
login();
page_header();
/*
(c) by Potterfans
Gemacht f¸r Bigforen
Um eine Weitere Frage hinzuzuf¸gen, bitte ¸berall ,"" vor der Klammer machen. 
Nicht die Antworten vergessen
*/
$quest = array("Wie lautet die Abk¸rzung f¸r Bigforum?","Wer ist der Gr¸nder von Bigforum? (Nicknamen)","Welcher Planet wird auch 'Roter Planet' genannt?","Und welcher wird blauer Planet genannt?","Wie viele Olympische Ringe gibt es?","Hauptstadt von Ecuador?","Gegenteil von Postausgang");
$answ = array("bf","Potterfans","Mars","Erde","f¸nf","Quito","Posteingang"); //Mˆgliche Antworten
$answe = array("bf","potterfans","Mars","Welt","5","Quito","posteingang");//Bei manchen ist auch eine andere Antwort richtig, diese kommt hier hin, ansonsten bitte die erste nochmal hinschreiben
if($_GET["do"] == "send")
{
  $r = "0";
  for($i=0;$i<count($quest);$i++)
  {
	if($_POST[$i] == $answ[$i] OR $_POST[$i] == $answe[$i])
	{
	  $r++;
	}
  }
  $pro = $r*100/count($quest);
  $pro = round($pro,2);
  echo "Du hast $r von ". count($quest) ." Fragen richtig.<br><br>Das heiﬂt, du hast exakt $pro% richtig.<br>";
  $time = time();
  $users_data = mysql_query("SELECT * FROM quiz_high WHERE username LIKE '". USER ."' ORDER BY punkte DESC LIMIT 1");
  $usd = mysql_fetch_object($users_data);
  $punktee = $usd->punkte;
  $punktee = str_replace("998",",",$usd->punkte);
  $punktee = str_replace("998",".",$usd->punkte);
  if($punktee < $pro)
  {
    $pro = str_replace(",","998",$pro);
    $pro = str_replace(".","998",$pro);
    mysql_query("INSERT INTO quiz_high (username, datum, punkte) VALUES ('". USER ."', '$time', '$pro')");
	echo "Dieses ist deine bisher hˆchste Punktzahl. Sie wurde erfolgreich hinzugef¸gt.";
  }
  else
  {
    echo "Zu einem anderem Zeitpunkt hattest du mehr Punkte. Deine Punktzahl wurde nicht hinzugef¸gt.";
  }
  echo "<br><br><a href=?do=highscore>Zur Highscore</a>";
  page_footer();
}
if($_GET["do"] == "highscore")
{
  $p = "0";
  echo "<h2>Highscore - Top Ten</h2><hr>
  <table>
  <tr><td>Platz</td><td>Username</td><td>Punkte (in %)</td><td>Datum</td></tr>";
  $high_data = mysql_query("SELECT * FROM quiz_high ORDER BY punkte LIMIT 10");
  while($hd = mysql_fetch_object($high_data))
  {
    $p++;
	$punkte = $hd->punkte;
	$punkte = str_replace("998",",",$punkte);
	$punkte = str_replace("998",".",$punkte);
	echo "<tr><td>$p</td><td>$hd->username</td><td>$punkte %</td><td>". date("d.m.Y - H:i", $hd->datum) ."</td></tr>";
  }
  echo "</table>";
  page_footer();
}
if(isset($_COOKIE["Quiz"]))
{
  echo "Leider hattest du heute (". date("H:i", $_COOKIE["Quiz"]) ." Uhr) schon am Quiz teilgenommen.<br>
  <br>Daher kannst du leider erst in wenigen Stunden nochmal das Quiz starten.";
  page_footer();
}
if($_GET["do"] == "start"){
  echo "<form action=?do=send method=post>";
  for($i=0;$i<count($quest);$i++)
  {
    echo "$quest[$i]<br><input type=text name=$i><br><br>";
  }
  echo "<input type=submit value='Antworten'></form>";
  page_footer();
}
// Hier wird die Tabelle erstellt, damit die Highscore auch gespeichert wird.
	  mysql_query("CREATE TABLE IF NOT EXISTS quiz_high ( 

      id INT(20) NOT NULL auto_increment,
      username varchar(500) NOT NULL,
      datum varchar(800) NOT NULL,
      punkte int(80) NOT NULL,
      PRIMARY KEY (id) );

      "); 

echo "Herzlich Willkommen beim ".SITENAME." - Quiz.<br>
Du musst hier einfach nur ". count($quest) ." Fragen beantworten und dann schaffst du es vielleicht in die Highscore.<br><br>
<a href=?do=start>Zum Quiz</a>";
page_footer();
?>
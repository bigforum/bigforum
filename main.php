<?php
//Wichtige Angaben f�r jede Datei!
include_once("includes/functions.php");
page_header();
login();
looking_page("main");
include_once("includes/function_user.php");

//Wichtige MySQL Abfrage, da bei manchen Anbietern ansonsten fehler kommen.
$user_data = mysql_query("SELECT * FROM users WHERE username LIKE '". USER ."'");
$ud = mysql_fetch_object($user_data);

$do = $_GET["do"];
$ac = $_GET["aktion"];
$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2pnsignfs'");
$cd = mysql_fetch_object($config_datas);
if($cd->zahl2 == "1" AND $ud->darf_pn == "0")
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
  $sign = '<tr><td><a href="?do=sign">Signatur �ndern</a></td></tr>';
}
else
{
  $sign = '<tr><td><span title="Signatur deaktiviert">Signatur �ndern</span></td></tr>';
}
?>
<table width="100%">
<tr><td valign="top" width="25%">
<!-- Navigation -->

<table width="100%">
<tr><td class=normal color="snow">
<b>Allgemeine Einstellungen</b></td></tr>
<tr><td><a href="?do=change_pw">Passwort �ndern</a></td></tr>
<tr><td><a href="?do=set">Sonstige Einstellungen</a></td></tr>
<tr><td class=normal color="snow">
<b><a href="profil.php?id=<? echo $ud->id;?>"><font color=black>Profil</font></a></b></td></tr>
<tr><td><a href="?do=profil">Mein Profil</a></td></tr>
<tr><td><a href="?do=friends">Meine Freunde/Kontakte</a></td></tr>
<tr><td><a href="?do=ava">Avatar</a></td></tr>
<?php echo $sign; ?>
<tr><td class=normal color="snow"><b>Private Nachricht</b></td></tr>
<? echo $pn_anzeige; ?>
</table>

</td>
<td valign="top">
<!-- Inhalt -->
<?php
if($do == ""){ 
echo"Hallo ".USER." ,<br>
willkommen in deinem Bereich. Hier ist es m�glich deine Einstellungen so wie deine Profil-Daten zu �ndern.<br><br>";
$time = time();
$us_ver = mysql_query("SELECT * FROM user_verwarn WHERE user_id LIKE '$ud->id' AND dauer > '$time'");
$akt = "0";
while($uv = mysql_fetch_object($us_ver))
{
  if($akt == "0")
  {
    echo "<table width=100%><tr class=normal><td align=left valign=left><b>Aktive Verwarnungen</b></td></tr></table><table width=100%><tr><td align=left valign=left><b>Grund</b></td><td align=left valign=left><b>Punkte</b></td><td align=left valign=left><b>L�uft aus...</b></td></tr>";
  }
  $dauer = date("d.m.Y - H:m", $uv->dauer);
  echo "<tr align=center><td align=left valign=left>$uv->grund</td><td align=left valign=left>$uv->punkte</td><td align=left valign=left>$dauer</td></tr>";
  $akt++;
}
if($akt != "0")
{
  echo "</table>";
}
page_close_table();
}
if($do == "del_ava")
{
  mysql_query("UPDATE users SET ava_link = '' WHERE username LIKE '". USER ."'");
  echo "Es wird nun kein Avatar mehr in Beitr�gen angezeigt.";
}
if($do == "sign") {
if($cd->zahl1 != "1")
{
  echo "<b>Info:</b>Die Signaturen wurden von einem Administrator gesperrt.";
  page_close_table();
}
if($ac == "send"){
mysql_query("UPDATE users SET sign = '$_POST[feld]' WHERE username LIKE '".USER."'");
echo "Danke, deine Signatur wurde ge�ndert.";
page_close_table();
}

$user_data = mysql_query("SELECT * FROM users WHERE username LIKE '". USER ."'");
$ud = mysql_fetch_object($user_data);

echo "<fieldset><legend>Signatur �ndern</legend>";
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
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2laengfs'");
  $con = mysql_fetch_object($config_wert); 
  $smilie_data = mysql_query("SELECT * FROM smilie WHERE packet = '$con->zahl2'");
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
if(str_replace(".php","", $_FILES['datei']['name']) AND str_replace(".html","", $_FILES['datei']['name']))   {
     echo "Bitte verwende ein anderes Format, dein Format ist nicht erlaubt.";
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
         echo "Das Bild darf nicht gr��er als 100 kb sein ";
      }

}
?>
<fieldset>
<legend>Avatar hochladen</legend>
Hier kannst du dir dein eigenes Avatar hochladen. Bitte beachte, dass dein Avatar nicht zu gro� sein sollte.<br>
Beachte das egal wie gro� dein Avatar ist, es automatisch in 100x100 px  umgewandelt wird (Kann Abweichungen geben).
<form action="?do=ava&aktion=send" method="post" enctype="multipart/form-data">
<input type="file" name="datei"><br>
<input type="submit" value="Hochladen"><input type=button value="Bestehendes Avatar l�schen" onclick="location.href='?do=del_ava'">
</form>
</fieldset>
<?
if($ud->ava_link != "")
{
  echo "<fieldset><legend>Dein Avatar</legend><img src=$ud->ava_link title=\"Dein Avatar\" width=100 height=100>";
}
page_close_table();
}

if($do == "friends")
{
  if($_GET["action"] == "del" AND is_numeric($_GET["id"]))
  {
    mysql_query("DELETE FROM kontakt WHERE user_id = '$ud->id' AND friend_id = '$_GET[id]'");
	echo "Der Kontakt wurde erfolgreich gel�scht.";
  }
  elseif(!is_numeric($_GET["id"]) AND $_GET["action"] == "del")
  {
    erzeuge_error_safe();
  }
  if($_GET["action"] == "add")
  {
    $fr_da = mysql_query("SELECT * FROM users WHERE username LIKE '$_POST[user]'");
	if(mysql_num_rows($fr_da) == "0")
	{
	  echo "Leider ist dieser Benutzername nicht vorhanden; bitte �berpr�fe deine Eingabe.";
	  page_close_table();
	}
	$fd = mysql_fetch_object($fr_da);
	$time = time();
	mysql_query("INSERT INTO kontakt (user_id, friend_id, when_time) VALUES ('$ud->id', '$fd->id', '$time')");
	echo "Deine Freundes-/ Kontaktliste wurde erfolgreich �berarbeitet.";
    page_close_table();
  }
  $friends_hol = mysql_query("SELECT * FROM kontakt WHERE user_id LIKE '$ud->id'");
  if(mysql_num_rows($friends_hol) == "0")
  {
    echo "Du hast noch keine Kontakte. Im unterem Feld kannst du welche hinzuf�gen.";
  }
  else
  {
    echo "<table><tr><td><b>Username</b></td><td><b>Kontakt</b></td><td><b>Aktion</b></td><td><b>Status</b></tr>";
	while($fh = mysql_fetch_object($friends_hol))
	{
	  $users_ids = mysql_query("SELECT * FROM users WHERE id LIKE '$fh->friend_id'");
	  $usi = mysql_fetch_object($users_ids);
	  echo "<tr><td><a href=profil.php?id=$usi->id>$usi->username</a></td><td>";
	  $config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2pnsignfs'");
      $cd = mysql_fetch_object($config_datas);
      if($usi->darf_pn == "0" AND $cd->zahl2 == "1")
      {
        echo "<a href=main.php?do=make_pn&to=$usi->username><img src=images/pn.png border=0 width=60px height=32px alt=\"$usi->username eine Private Nachricht schreiben\"></a></td><td>";
      }
	  else
	  {
	    echo "</td><td>";
	  }
	  echo "<a href=?do=friends&action=del&id=$usi->id>L�schen</a></td><td>";
	  show_online($usi->last_log, $usi->username);
	  echo "</td></tr>";
	}
    echo "</table>";
  }
  echo "<br><br><fieldset><legend>Neuen Kontakt hinzuf�gen</legend>
  <form action=?do=friends&action=add method=post>Benutzername: <input type=text name=user><input type=submit value=Hinzuf�gen></fieldset>";
  page_close_table();
}
if($do == "set")
{   
    if($ac == "insert")
	{
	  if($_POST["pn_weiter"] == "1")
	  {
	    $eintrag = mysql_query("UPDATE users SET pn_weiter = '1', onlyadm = '$_POST[am]' WHERE username LIKE '". USER ."'");
	  }
	  else
	  {
	    $eintrag = mysql_query("UPDATE users SET pn_weiter = '0', onlyadm = '$_POST[am]' WHERE username LIKE '". USER ."'");
	  }
	  $eintrag = mysql_query("UPDATE users SET style = '$_POST[sty]', erlaube_prona = '$_POST[prona]' WHERE username LIKE '". USER ."'");
	  speicherung($eintrag, "Deine Einstellungen wurden �berarbeitet.", "<b>Fehler:</b> Es gab einen Fehler bei der Speicherung der Einstellungen.<br> <a href=javascript:history.back()>Zur�ck</a>");
      page_close_table();
	}
	if($ac == "insert_bd")
	{
	  if($_POST["year"] > date("Y", time()))
	  {
	    echo "Dein Geburtsdatum kann doch nicht in der Zukunft liegen ;)<br><br>";
		page_close_table();
	  }
	  if($_POST["month"] == "0" OR $_POST["day"] == "0")
	  {
	    $time = "0";
	  }
     else
     {	 
	    if($_POST["year"] == "")
	    {
	      $_POST["year"] = "2037";
	    }
	    $time = mktime(0, 0, 0, $_POST["month"], $_POST["day"], $_POST["year"]);
	 }
	  mysql_query("UPDATE users SET birthday = '$time' WHERE username LIKE '". USER ."'");
	  echo "Deine Daten wurden erfolgreich gespeichert.";
      page_close_table();
	}
    include_once("includes/function_user.php");
    $checked = "";
    if($ud->pn_weiter == "1")
	{
	  $checked = "checked";
	}
	if($ud->onlyadm == "2")
	{
	  $pnj = "checked";
	}
	else
	{
	  $pnn = "checked";
	}
    echo "<table width=100%><tr class=normal><td><big><b>Allgemeine Einstellungen � Sonstige Einstellungen � </b> ".USER." </big></td></tr></table><br>
	<fieldset><legend>Private Nachrichten</legend>
	<form action=?do=set&aktion=insert method=post>
	<table>
	<tr><td>Automatische Weiterleitung zu dem Posteingang, beim Mauskontakt, des blinkenden Textes \"Neue Nachrichten\" oben �ber deiner Navigationsliste.</td><td width=40%>
	<input type=checkbox name=pn_weiter value=1 $checked></td></tr>
	<tr><td>Private Nachrichten nur von Administratoren und Moderatoren empfangen?</td><td><input type=radio name=am value=2 $pnj>Ja <input type=radio name=am value=5 $pnn>Nein</td></tr>
	</table> </fieldset><br>
	<fieldset><legend>Design</legend>
	<table><tr><td>
    W�hle bitte das Design vom Forum aus:</td><td><select name=sty>";
	$style_data = mysql_query("SELECT * FROM style_all");
	while($sd = mysql_fetch_object($style_data))
	{
	  if($ud->style == $sd->sname)
	  {
	    echo "<option value='$sd->sname' selected=selected>$sd->sname</option>";
	  }
	  else
	  {
	  	echo "<option value='$sd->sname'>$sd->sname</option>";
	  }
	}
	if($ud->erlaube_prona == "0")
	{
	  $profil_nachrichten = "<input type=radio name=prona value=0 checked>Ja <input type=radio name=prona value=1>Nein";
	}
	if($ud->erlaube_prona == "1")
	{
	  $profil_nachrichten = "<input type=radio name=prona value=0>Ja <input type=radio name=prona value=1 checked>Nein";
	}
	echo "</select></td></tr></table></fieldset>
	<br>
	<fieldset><legend>Profilnachrichten</legend>
	<table><tr><td>Erlaube Profilnachrichten:</td><td>$profil_nachrichten</td></tr></table></fieldset>";
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
        d = confirm("Wurde die Notiz zur Kentniss genommen, und kann nun gel�scht werden?");
        if(d == true)
        {
          xmlhttp.open("GET", 'main.php?do=del_notice');
          alert("Die Notiz wurde gel�scht.");
		  document.getElementById("notice").innerHTML = "";
        }
        xmlhttp.send(null);
      }


     </script>
<span id="notice"><fieldset><legend>Sonstige Einstellungen</legend>
	  <a href="javascript:delnotice();">Notiz, die im Header angezeigt wird, ausbleden</a></fieldset><br></span>
<?php
	}
	echo "<input type=submit value=Speichern></form>";
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
  if($_GET["action"] == "del")
  {
    $idda = mysql_query("SELECT * FROM prna WHERE id LIKE '$_GET[id]'");
	$idd = mysql_fetch_object($idda);
	if($idd->emp == USER)
	{
      mysql_query("UPDATE prna SET emp = '$idd->emp|del' WHERE id LIKE '$_GET[id]'");
      echo "Die Private Nachricht wurde gel�scht.";
	}
	else
	{
	  erzeuge_error("Du hast keine Rechte diese Private Nachricht zu l�schen");
	}
    exit;
  }
  looking_page("look_pn");
  $seite = $_GET["page"];
  if(!isset($seite) OR $seite == "0")
  {
    $seite = 1;
  } 
  $eps = "8";
  
  $start = $seite * $eps - $eps;
  
  
  echo "<table width=100%><tr class=normal><td><big><b>Private Nachrichten � Eingang � </b> ".USER." </big></td></tr></table><br>";
  $pn_data = mysql_query("SELECT * FROM prna WHERE emp LIKE '". USER ."' ORDER BY dat DESC LIMIT $start, $eps");
  $pn_dataz = mysql_query("SELECT * FROM prna WHERE emp LIKE '". USER ."'");


  echo "<table width=100%><tr style=font-weight:bold;  class=normal><td width=70%>Betreff / Absender</td><td>Datum</td><td>L�schen</td></tr>";
  while($pr = mysql_fetch_object($pn_data))
  {
    $d = explode("|", $pr->emp);
	if($d[1] != "del")
	{
      $betreff_pn = strip_tags($pr->betreff);
      $datum = date("d.m.Y",$pr->dat);
      $uhrzeit = date("H:i",$pr->dat);
	  $abse = $pr->abse;
	  $abse = str_replace("|del","", $abse);
	  if($pr->gel == "0")
	  {
        echo "<tr><td width=70%><b> <a href=?do=read_pn&aktion=$pr->id>$betreff_pn</a> </b><br>$abse</td><td>$datum<br>$uhrzeit</td><td><a href=?do=pn_ein&action=del&id=$pr->id>L�schen</a></td></tr>";
	  }
	  else 
	  {
        echo "<tr><td> <a href=?do=read_pn&aktion=$pr->id>$betreff_pn</a><br>$abse</td><td>$datum<br>$uhrzeit</td><td><a href=?do=pn_ein&action=del&id=$pr->id>L�schen</a></td></tr>";	
	  }
	}
	else
	{
	  $menge--;
	}
  }

  $menge = mysql_num_rows($pn_dataz);
  $wieviel = $menge / $eps;
  $ws = ceil($wieviel);
  echo "</table>";
    if($ws > "1")
{
$up = $seite - 1;
$down = $seite + 1;
if($ws == $seite)
{
  $down--;
}
echo "<table width=80%><tr><td align=right valign=right><table class=navi><tr><td>";
echo "<font color=snow>Seite $seite von $ws &nbsp <a href=?do=pn_ein&page=$up><</a>";
//Welche Seiten sollen angezeigt werden?
$seiten = "0,1,2,3,5,10,25,50,100,150,250,500,750";
$pa = array();
//


$z = explode(",", $seiten);
for($a=0; $a < $wieviel; $a++)
{
  $b = $a + 1;
  $q = "0";
    while($q < count($z))
	{
	  $pa[] = $b;
	  if($z[$q] == $b OR $seite == $b)
	  {

        if($seite == $b AND $q == "0")
        {
		  $min = $b - 1;
		  $plu = $b + 1;
		  if(!in_array($min,$z) AND $q == "0")
		  {
		    echo "  <a href=\"?do=pn_ein&page=$min\">$min</a> ";
		  }
          echo " <b>$b</b> </font>";
		  if(!in_array($plu,$z) AND $q == "0" AND $ws != $seite)
		  {
		    echo "  <a href=\"?do=pn_ein&page=$plu\">$plu</a> ";
		  }
        }
        else
        {
		  if($seite != $b)
		  {
            echo "  <a href=\"?do=pn_ein&page=$b\">$b</a> ";
		  }
        }
	  }
	$q++;
	}
}
echo " <a href=?do=pn_ein&page=$down>></a></td></tr></table></td></tr></table>"; 
}
page_close_table();
}
if($do == "report_pn")
{
  if($_GET["aktion"] == "insert")
  {
    $config_data = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2mf2'");
    $cd = mysql_fetch_object($config_data);
    if($cd->zahl2 == "1")
    {
    $admin_data = mysql_query("SELECT * FROM users WHERE group_id = '3'");
    while($ad = mysql_fetch_object($admin_data))
    {
      $mail_empfaenger= $ad->mail;
      $mail_absender= $ud->mail;
      $betreff= "Gemeldete Private Nachricht";
      $header  = "MIME-Version: 1.0\r\n";
      $header .= "Content-type: text/html; charset=iso-8859-1\r\n";
      $header .= "From: $mail_absender\r\n";
      $header .= "Reply-To: $mail_empfaenger\r\n";
      $text= "Hallo $ad->username,<br>im Forum wurde eine Private Nachricht gemeldet.<br><br>Du kannst diese Private Nachricht inkl. dem Grund im Administratoren-Kontrollzentrum einsehen.<br><br>";
      mail($mail_empfaenger, $betreff, $text, $header);
    }	
	}
    $time = time();
    mysql_query("INSERT INTO report_pn (pn_id, report_from, report_time, grund) VALUES ('$_GET[id]', '". USER ."', '$time', '$_POST[grund]')");
    echo "Danke, Private Nachricht wurde erfolgreich gemeldet.";
    exit;
  }
  echo "<fieldset><legend>Private Nachricht melden</legend>
  <form action=?do=report_pn&id=$_GET[id]&aktion=insert method=post>
  Bitte gebe den Grund daf�r an, warum Du diese Nachricht melden m�chtest. Dieser Grund sollte exakt und m�glichst sehr zutreffend sein.<br>
  Grund: <input type=text name=grund size=40><input type=submit value='Nachricht melden'>
  </form>
  </fieldset>";
  exit;
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
    erzeuge_error("Angegebene Nachricht exestiert leider nicht. Bitte �berpr�fe, ob du einen richtigen Link angegeben hast.");
  }
  if(strtolower($pr->emp) == strtolower(USER))
  {
    mysql_query("UPDATE prna SET gel = '1' WHERE id LIKE '$ac'");
  }
  $text = $pr->mes;
  $betreff = strip_tags($pr->betreff);
  $from = $pr->abse;
  $datum = date("d.m.Y",$pr->dat);
  $uhrzeit = date("H:i",$pr->dat);
  echo "<table width=81%><tr class=normal><td><font color=snow>$datum, $uhrzeit (<a href=?do=report_pn&id=$pr->id><font color=snow>Nachricht melden</font></a>)</font></td></tr></table>";
  text_ausgabe($text, $betreff, $from);
  $betreff = str_replace(" ", "_", $betreff);
  $betreff = str_replace("AW:_","", $betreff);
  $betreff = "AW:_$betreff";
  echo "<table width=81%><tr><td align=right><a href=main.php?do=make_pn&to=$from&bet=$betreff><img src=images/answer.png border=0 width=95 height=50></a></td></tr></table>";
  page_close_table();
}
if($do == "pn_aus")
{
  if($pn_deakt == true)
  {
    echo "Das Private Nachrichten System wurde von einem Administrator gesperrt!";
    page_close_table();
  }
  if($_GET["action"] == "del")
  {
    $idda = mysql_query("SELECT * FROM prna WHERE id LIKE '$_GET[id]'");
	$idd = mysql_fetch_object($idda);
	if($idd->abse == USER)
	{
      mysql_query("UPDATE prna SET abse = '$idd->abse|del' WHERE id LIKE '$_GET[id]'");
      echo "Die Private Nachricht wurde gel�scht.";
	}
	else
	{
	  erzeuge_error("Du hast keine Rechte diese Private Nachricht zu l�schen.");
	}
    exit;
  }
  $seite = $_GET["page"];
  if(!isset($seite) OR $seite == "0")
  {
    $seite = 1;
  } 
  $eps = "8";

  $start = $seite * $eps - $eps;
  looking_page("look_pn");
  echo "<table width=100%><tr class=normal><td><big><b>Private Nachrichten � Eingang � </b> ".USER." </big></td></tr></table><br>";
  $pn_data = mysql_query("SELECT * FROM prna WHERE abse LIKE '". USER ."' ORDER BY dat DESC  LIMIT $start, $eps");
  $pn_dataz = mysql_query("SELECT * FROM prna WHERE abse LIKE '". USER ."'");
  $menge = mysql_num_rows($pn_dataz);
  $wieviel = $menge / $eps;
  $ws = ceil($wieviel);
  echo "<table width=100%><tr style=font-weight:bold;  class=normal><td width=70%>Betreff / Empf�nger</td><td>Datum</td><td>L�schen</td></tr>";
  while($pr = mysql_fetch_object($pn_data))
  {
    $datum = date("d.m.Y",$pr->dat);
    $uhrzeit = date("H:i",$pr->dat);
	$emp = $pr->emp;
	$emp = str_replace("|del","",$emp);
    echo "<tr><td> <a href=?do=read_pn&aktion=$pr->id>$pr->betreff</a><br>$emp</td><td>$datum<br>$uhrzeit</td><td><a href=?do=pn_aus&action=del&id=$pr->id>L�schen</a></tr>";	
  }
  echo "</table>";
  if($ws > "1")
{
$up = $seite - 1;
$down = $seite + 1;
if($ws == $seite)
{
  $down--;
}
echo "<table width=80%><tr><td align=right valign=right><table class=navi><tr><td>";
echo "<font color=snow>Seite $seite von $ws &nbsp <a href=?do=pn_aus&page=$up><</a>";
//Welche Seiten sollen angezeigt werden?
$seiten = "0,1,2,3,5,10,25,50,100,150,250,500,750";
$pa = array();
//


$z = explode(",", $seiten);
for($a=0; $a < $wieviel; $a++)
{
  $b = $a + 1;
  $q = "0";
    while($q < count($z))
	{
	  $pa[] = $b;
	  if($z[$q] == $b OR $seite == $b)
	  {

        if($seite == $b AND $q == "0")
        {
		  $min = $b - 1;
		  $plu = $b + 1;
		  if(!in_array($min,$z) AND $q == "0")
		  {
		    echo "  <a href=\"?do=pn_aus&page=$min\">$min</a> ";
		  }
          echo " <b>$b</b> </font>";
		  if(!in_array($plu,$z) AND $q == "0" AND $ws != $seite)
		  {
		    echo "  <a href=\"?do=pn_aus&page=$plu\">$plu</a> ";
		  }
        }
        else
        {
		  if($seite != $b)
		  {
            echo "  <a href=\"?do=pn_aus&page=$b\">$b</a> ";
		  }
        }
	  }
	$q++;
	}
}
echo " <a href=?do=pn_aus&page=$down>></a></td></tr></table></td></tr></table>"; 
}
page_close_table();
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
  $to_ho = mysql_query("SELECT * FROM users WHERE username LIKE '$_POST[to]'");
  $th = mysql_fetch_object($to_ho);
  if($th->onlyadm == "2")
  {
    if(GROUP != "2" AND GROUP != "3")
	{
	    erzeuge_error("Dieser Benutzer hat angegeben Private Nachrichten nur von  Administratoren bzw. Moderatoren zu empfangen.");
	}	
  }
  if($th->darf_pn != "0")
  {
    erzeuge_error("F�r diesen Benutzer wurde das Private Nachrichten System deaktiviert.</td></tr></table> ");
  }
  error_reporting(E_ALL);
  $to = $_POST["to"];
  $text = $_POST["feld"];
  if(USER == $to)
  {
    erzeuge_error("Du kannst dir nicht selber eine Nachricht senden, dieses w�rde nur zu Problemen f�hren.</td></tr></table>");
  }
  $_POST["bet"] = str_replace(" ","",$_POST["bet"]);
  check_data($text, "", "Du hast vergessen etwas anzugeben", "leer");
  check_data($_POST["bet"], "", "Du hast vergessen etwas anzugeben", "leer");
  check_data($to, "", "Du hast keinen Empf�nger angegeben", "leer");
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
echo "<table width=100%><tr class=normal><td><big><b>Allgemeine Einstellungen � Passwort �ndern � </b> ".USER." </big></td></tr></table><br>";
if($ac == ""){
echo "<form action=?do=change_pw&aktion=change method=post>
Bitte gebe zuerst dein aktuelles Passwort ein.<br>
<input type=password name=old_pw>
<fieldset>
<legend>Passwort �ndern</legend>
Bitte gebe in den folgenden Feldern dein neues Passwort und die Wiederholung davon ein.<br>
<br>
<table><tr><td>Neues Passwort</td><td>Neues Passwort (Wiederholung)</td></tr>
<tr><td><input type=password name=pw1></td><td><input type=password name=pw2></td></tr></table>
</fieldset>
<input type=submit value=Best�tigen>
</form>
";
page_close_table();
}
if($ac == "change")
{
  //Wegen Benutzer-Datenbankabfragen noch die wichtige Datei daf�r herhohlen:
  include_once("includes/function_user.php");
  $old_pw = md5($_POST["old_pw"]);
  $pw1 = md5($_POST["pw1"]);
  $pw2 = md5($_POST["pw2"]);
  check_data($pw1, $pw2, "Die Passw�rter stimmen nicht �berein!", "gleich");
  check_data($old_pw, $ud->pw, "Dein altes Passwort ist falsch!", "gleich2");
  check_data($pw1, "", "Du musst schon ein Passwort eingeben", "leer");
  $eintrag = mysql_query("UPDATE users SET pw = '$pw1' WHERE username LIKE '". USER ."'");
  speicherung($eintrag, "Danke, dein Passwort wurde erfolgreich �bernommen", "<b>Fehler:</b> Es gab einen Fehler bei der Speicherung des Passwortes.<br>Versuche es nochmal! <a href=history.back()>Zur�ck</a>");
  page_close_table();

}
}
if($do == "profil")
{
  echo "<table width=100%><tr class=normal><td><big><b>Profil � Mein Profil � </b> ".USER." </big></td></tr></table><br>";
  if($ac == "")
  {
    include_once("includes/function_user.php");
	if($ud->show_mail == "0")
	{
	  $showing_mail = "<input type=radio value=0 name=se checked>Ja <input type=radio value=1 name=se>Nein";
	}
	else
	{
	  $showing_mail = "<input type=radio value=0 name=se>Ja <input type=radio value=1 name=se checked>Nein";
	}
    echo "<form action=?do=profil&aktion=change method=post>
	<fieldset><legend>Profil bearbeiten</legend>
	Hier kannst du deine Website, sowie deine Hobbys angeben. Diese werden dann im Profil zu finden sein.<br>
	<table><tr><td>Hobbys</td><td>Website</td></tr>
	<td><input type=text name=hob value=\"$ud->hob\" size=40  maxlength=160></td><td><input type=text name=website value=\"$ud->website\" size=40 maxlength=110></td></tr></table>	<input type=submit value='Speichern'>
  </fieldset><br>
	<fieldset><legend>Einstellungen</legend>
	<table>
	<tr><td>Zeige eMail-Adresse im Profil</td><td>$showing_mail</td></tr>
	</table>
	<input type=submit value='Speichern'>
	</fieldset>
</form><fieldset><legend>Geburtstag</legend>
	<form action=main.php?do=set&aktion=insert_bd method=post>
	<table>
	<tr><td>Bitte gebe deinen Geburtstag ein:</td><td width=50%><select name=day><option value=0></option>";
	$birthday_d = date("d", $ud->birthday);
	$birthday_m = date("m", $ud->birthday);
	for($tag = 1; $tag < 32; $tag++)
	{
	  if($tag == $birthday_d AND $ud->birthday != "0")
	    echo "<option value=$tag selected=selected>$tag</option>";
	  else	
	  echo "<option value=$tag>$tag</option>";
	}
	$mo = "0";
	$mona = "Januar,Februar,M�rz,April,Mai,Juni,Juli,August,September,Oktober,November,Dezember";
	$monaex = explode(",", $mona);
	echo "</select><select name=month><option value=0></option>";
	for($i = 1; $i < count($monaex)+1; $i++)
	{
	  $x = $i-1;
	  if($i == $birthday_m AND $ud->birthday != "0")
	    echo "<option value=$i selected=selected>$monaex[$x]</option>";
	  echo "<option value=$i>$monaex[$x]</option>";
	} 
	if($ud->birthday != "0" AND date("Y", $ud->birthday) != "2037") 
	  $y = date("Y", $ud->birthday);
	echo "</select><input type=text name=year size=2 maxlength=4 value='$y'><a href=# onmouseover=\"Tip('Wenn du nicht m�chtest, dass jemand dein Alter sieht, dann lasse dieses Feld (das letzte) einfach leer.')\" onmouseout='UnTip()'>[?]</a></b></td></tr>
	</table>
    <input type=submit value=Speichern></form>
	</fieldset><br>";
	page_close_table();
  }
  if($ac == "change")
  {
    $web = $_POST["website"];
	$web = str_replace("http://","",$web);
    $eintrag = mysql_query("UPDATE users SET hob = '$_POST[hob]', website = '$web', show_mail = '$_POST[se]' WHERE username LIKE '". USER ."'");
	speicherung($eintrag, "Danke, dein Profil wurde erfolgreich �bernommen", "<b>Fehler:</b> Es gab einen Fehler bei der Speicherung des Profils.<br>Versuche es nochmal! <a href=history.back()>Zur�ck</a>");
    page_close_table();
  }
}
?>
</td>
</tr>
</table>
<?
//Wichtige Datein f�r den Footer
page_footer();
?>
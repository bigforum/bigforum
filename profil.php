<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
connect_to_database();
$con_pro = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2profs'");
$cp = mysql_fetch_object($con_pro);
if($cp->zahl2 != "1")
{
  login();
}
//Folgende Zeile behebt mögliche Fehler:
page_header();
include_once("includes/function_user.php");

//Wichtige MySQL Abfrage, da bei manchen Anbietern ansonsten fehler kommen.
$user_data = mysql_query("SELECT * FROM users WHERE username LIKE '". USER ."'");
$ud = mysql_fetch_object($user_data);

$ac = $_GET["action"];

  // Start Verwarnungen
  if($ac == "no_warn")
  {
    if(GROUP == "2" OR GROUP == "3")
	{
      echo "Bist du dir sicher, dass du die Verwarnung zurücknehmen willst? Dieser Schritt ist nicht rückgängig machbar!<br>
	  <br><input type=Button value='Ja, Verwarnung zurücknehmen' onclick=\"window.location.href='?action=back_warn&id=$_GET[id]'\"> <input type=button value='Nein, Verwarnung bestehen lassen' onclick='history.back()><br>";
    }
	page_footer();
  }
  if($ac == "back_warn")
  {
    if(GROUP == "2" OR GROUP == "3")
	{
      mysql_query("UPDATE user_verwarn SET dauer = '100' WHERE id LIKE '$_GET[id]'");
	  echo "Die Verwarnung wurde zurückgenommen.<br>
	  <a href=index.php>Foren-Übersicht</a>";
	}
	page_footer();
  }
  // Ende
  if($_GET["id"] != "")
{
  $user_data_profile = mysql_query("SELECT * FROM users WHERE id LIKE '$_GET[id]'");
  $udp = mysql_fetch_object($user_data_profile);
  check_data($udp->username, "", "Dieses Benutzerprofil exestiert nicht.", "leer");
  gruppen_aufteilungen($udp->group_id);
  if($ac == "warn")
  {
    if((GROUP == "2" OR GROUP == "3") AND $ud->adm_recht >= $udp->adm_recht)
	{
	  if($ud->id == $_GET["id"])
	  {
	  	
	  echo "<b>Fehler:</b> Du kannst dich nicht selber verwarnen!";
	  page_footer();
	
	  }
    if($_GET["do"] == "insert")
	{
	  check_data($_POST["warn"], "", "Bitte gebe einen allgemeinen Warngrund an", "leer");
	  check_data($_POST["spgr"], "", "Bitte gebe einen speziellen Warngrund an", "leer");
	  $gru_ho = mysql_query("SELECT * FROM verwarn_gruend WHERE id LIKE '$_POST[warn]'");
	  $gho = mysql_fetch_object($gru_ho);
	  $dauer = time() + $gho->zeit;
	  $time = time();
	  $text = "Hallo $udp->username
	  
	  Sie haben im Forum eine Verwarnung erhalten. Ihrem Verwarn-Konto wurde(n) $gho->punkte Punkt(e) hinzugefügt.
	  
	  Grund der Verwarnung:
	  $_POST[spgr]
	  
	  
	  Bis diese Verwarnung abläuft, könnte es sein, dass Sie nichtmehr alle Funktionen des Forum nutzen können.
	  
	  
	  Mit freundlichen Grüßen
	  Das Foren-Team";
	  mysql_query("INSERT INTO user_verwarn (user_id, grund, punkte, dauer, grundpn, von, wann) VALUE ('$_GET[id]', '$gho->grund', '$gho->punkte', '$dauer' ,'$_POST[spgr]', '". USER ."', '$time')")or die(mysql_error());
	  mysql_query("INSERT INTO prna (abse, emp, dat, betreff, mes, gel) VALUES ('". USER . "', '$udp->username', '$time', 'Sie haben eine Verwarnung erhalten', '$text', '0')")or die(mysql_error());
      echo "<meta http-equiv='refresh' content='1; URL=profil.php?id=$_GET[id]'>Dem Benutzer wurde(n) $gho->punkte Punkt(e) hinzugefügt.<br><br>Sollte die Weiterleitung nicht funktionieren <a href=profil.php?id=$_GET[id]>klicke hier</a><br><br><br>";
	  page_footer();
	}
    echo "  <table width=100%><tr class=dark><td>
  <b><big><font color=snow>$udp->username verwarnen </font></big></b></td></tr>
    <tr><td>
	
    <form action=?id=$_GET[id]&action=warn&do=insert method=post>
    <fieldset>
	<legend>Allgemeinen Grund ausgeben</legend>
	
	<table width=100%><tr style=font-weight:bold>
	<td></td><td>Grund</td><td>Punkte</td><td>Dauer</td></tr>";
	$gr_ho = mysql_query("SELECT * FROM verwarn_gruend ORDER BY punkte DESC");
    while($gh = mysql_fetch_object($gr_ho))
    {
      $zeit = $gh->zeit;
	  $wl = sizeof ($warn_dauer);
      for($i=0;$i<$wl;$i++)
	  {
	    if($zeit == $warn_dauer[$i])
	    {
	      $zeit = $warn_text[$i];
		  echo "<tr><td><input type=radio name=warn value=$gh->id></td><td>$gh->grund</td><td>$gh->punkte</td><td>$zeit</td></tr>";
	    }
	  }

    }
	echo "</table></fieldset><br>
	<fieldset>
	<legend>Speziellen Grund</legend>
	Eingabe des Speziellen Grunds: <input type=text name=spgr size=40></fieldset><br>
	<input type=submit value='Benutzer Verwarnen'>
	</form>";
	page_footer();
    exit;
    }
  }
  ?>
  <table class="bord" width="100%"><tr class="dark"><td>
  <b><big><font color="snow">Benutzerprofil von <?php echo $udp->username; ?></font></big></b></td></tr>
  <tr><td>
  <center><b><?php echo $udp->username; echo "</b>  ";
  show_online($udp->last_log, $udp->username);
  ?><br><?php echo $udp->rang; ?></center>
  
  <table width="100%" valign="top"><tr><td width="65%">
  <?php
  $rech = $udp->last_log - time();
  $datum = date("d.m.Y",$udp->last_log);
  $uhrzeit = date("H:i",$udp->last_log);
  if($rech > "-901")
  {
  ?>
  <b>Jetzt online:</b> <?php echo $udp->last_site; }
  else{ 
  $now = date("d.m.Y", time());
  if($now == $datum)
  {
    $datum = "Heute";
  }

  echo "<b>Letzte Aktivität:</b> $datum um $uhrzeit"; }?><br>
  <b>Registriert am:</b> <?php   
  $datum = date("d.m.Y",$udp->reg_dat);
  $uhrzeit = date("H:i",$udp->reg_dat);
  echo "$datum";?><br><br>
  <b>Beiträge:</b> <?php echo $udp->posts; ?><br>
  <b>&#216; Beiträge/Tag:</b> <? 
  $tag = time() - $udp->reg_dat;
  $da = $tag/84600;
  $da = round($da);
  if($udp->posts != "0")
  {
    $bei_tag = $udp->posts/$da;
    echo round($bei_tag, 2);
  }
  else { echo "0"; }  ?><br>
  <br>
  <b>Suche nach:</b> <a href="search.php?do=send&us=<?php echo $udp->username; ?>&action=beitrag">Allen Beiträgen</a> | <a href="search.php?do=send&us=<?php echo $udp->username; ?>&action=thema">Allen Themen</a>
  </td><td valign=top>
  <b>Website:</b> <a href="<? if(str_replace("http://www.", "www.", $udp->website))echo "http://$udp->website";  else echo $udp->website;?>" target="_blank"><? echo $udp->website; ?></a><br>
  <b>Hobbys:</b> <? echo $udp->hob; ?><br><br>
  <b>Kontakt:</b> <a href="main.php?do=make_pn&amp;to=<?php echo $udp->username;?>"><img src="images/pn.png" alt="<?php echo $udp->username;?> eine Private Nachricht schreiben" border="0" height="32px" width="60px"></a></td>
  
  </tr>
  </table>
  
  </td></tr></table>
  <?
  if($udp->sign != "")
  {
    $text = $udp->sign;
    $text = strip_tags($text);
    $text = preg_replace('/\[b\](.*?)\[\/b\]/', '<b>$1</b>', $text);  
    $text = preg_replace('/\[k\](.*?)\[\/k\]/', '<i>$1</i>', $text);  
    $text = preg_replace('/\[u\](.*?)\[\/u\]/', '<u>$1</u>', $text);  
	$text = eregi_replace("\[url\]([^\[]+)\[/url\]","<a href=\"\\1\" target=\"_blank\">\\1</a>",$text);
    $text = str_replace("\n", "<br />", $text);
	$config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2laengfs'");
    $con = mysql_fetch_object($config_wert); 
    $smilie_data = mysql_query("SELECT * FROM smilie WHERE packet = $con->zahl2");
    while($sd = mysql_fetch_object($smilie_data))
    {
      $text = str_replace($sd->abk1,"<img src=images/$sd->images_path width=25 height=25>", $text);
      $text = str_replace($sd->abk2,"<img src=images/$sd->images_path width=25 height=25>", $text);
    }
    echo"<table class=bord width=100%><tr><td>$text</td></tr></table>";
  }
}
if((GROUP == "2" OR GROUP == "3") AND $ud->adm_recht >= $udp->adm_recht)
{
?><br>
  <table class="bord" width="100%"><tr class="dark"><td>
  <table width=100%><tr><td><b><font color="snow">Verwarnungen</font></b></td><td align=right><a href="profil.php?id=<?php echo $_GET["id"];?>&action=warn"><font color=snow>Benutzer verwarnen</font></a></td></tr></table></td></tr>
  <tr><td>
  <table width=100%><tr align=center style=font-weight:bold><td width=30%>Grund</td><td width=30%>Verwarnt von / Datum</td><td width=10%>Punkte</td><td width=20%>Läuft aus</td><td><?php if($_GET["id"] != $ud->id) echo "Aktionen"; ?></td></tr>
  <?php
  $us_ver = mysql_query("SELECT * FROM user_verwarn WHERE user_id LIKE '$_GET[id]'");
  while($uv = mysql_fetch_object($us_ver))
  {
    $dauer = $uv->dauer;
	if($dauer < time())
	{
	  if($dauer == "100")
	  {
	    $dauer = "Zurückgenommen";
	  }
	  else {
	    $dauer = "Abgelaufen";
	  }
	}
	else
	{
	    $dauer = date("d.m.Y - H:m", $dauer);
	  	}
    echo "<tr align=center><td>$uv->grund</td><td>$uv->von / ". date("d.m.Y - H:m", $uv->wann) ."</td><td>$uv->punkte</td><td>$dauer</td><td><a href=?action=no_warn&id=$uv->id>";
	if($_GET["id"] != $ud->id AND $dauer != "Abgelaufen" AND $dauer != "Zurückgenommen")
	  echo "Zurücknehmen</a>";
	else
	  echo "</a>Zurücknehmen";
	echo "</td></tr>";
  }
  ?>
  </table>
  </td></tr></table>
<?
}
//Wichtige Datein für den Footer
looking_page("profil");
page_footer();
?>
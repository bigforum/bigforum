<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
connect_to_database();
if($_COOKIE[$_GET["id"]] != $_GET["id"])
{
  mysql_query("UPDATE users SET provi = provi+1 WHERE id LIKE '$_GET[id]'");
}
setcookie($_GET["id"], $_GET["id"], time()+7200);
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
	  $gru = $gho->grund;
	  $punk = $gho->punkte;
	  if($_POST["warn"] == "own")
	  {
	    $lange = $_POST["day"] * $_POST["laen"];
		$dauer = time() + $lange;
		$gru = $_POST["grund"];
		$punk = $_POST["punkt"];
	  }
	  $time = time();
	  $text = "Hallo $udp->username
	  
	  Sie haben im Forum eine Verwarnung erhalten. Ihrem Verwarn-Konto wurde(n) $punk Punkt(e) hinzugefügt.
	  
	  Grund der Verwarnung:
	  $_POST[spgr]
	  
	  
	  Bis diese Verwarnung abläuft, könnte es sein, dass Sie nicht mehr alle Funktionen des Forum nutzen können.
	  
	  
	  Mit freundlichen Grüßen
	  Das Foren-Team";
	  mysql_query("INSERT INTO user_verwarn (user_id, grund, punkte, dauer, grund_pn, von, wann) VALUE ('$_GET[id]', '$gru', '$punk', '$dauer' ,'$_POST[spgr]', '". USER ."', '$time')")or die(mysql_error());
	  mysql_query("INSERT INTO prna (abse, emp, dat, betreff, mes, gel) VALUES ('". USER . "', '$udp->username', '$time', 'Sie haben eine Verwarnung erhalten', '$text', '0')")or die(mysql_error());
      echo "<meta http-equiv='refresh' content='1; URL=profil.php?id=$_GET[id]'>Dem Benutzer wurde(n) $punk Punkt(e) hinzugefügt.<br><br>Sollte die Weiterleitung nicht funktionieren <a href=profil.php?id=$_GET[id]>klicke hier</a><br><br><br>";
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
	if(GROUP == "3")
	{
	  //Administratoren dürfen auch eigene Gründe angeben.
	  echo "<tr><td><input type=radio name=warn value=own></td><td><input type=text name=grund></td><td><input type=text name=punkt size=1 maxlength=3></td><td><input type=text name=day size=2> <select name=laen><option value=86400>Tage</option><option value=604800>Wochen</option><option value=2678400>Monate</option><option value=31536000>Jahre</option></select></td></tr>";
	}
	echo "</table></fieldset><br>
	<fieldset>
	<legend>Speziellen Grund</legend>
	Eingabe des Speziellen Grunds: <input type=text name=spgr size=40></fieldset><br>
	<input type=submit value='Benutzer Verwarnen'>
	</form>";
	page_close_table();
    exit;
    }
  }
  ?>
  <table width="100%"><tr><td class="bord" width="30%" valign=top style="padding: 5px">
  <b><?php echo $udp->username; echo "</b>  ";
  show_online($udp->last_log, $udp->username);
  ?><br><?php echo $udp->rang; ?><br>
  <?if($udp->ava_link != "")
  {
    echo "<img src=$udp->ava_link title=\"$udp->username's Avatar\" width=100 height=100>";
  }?>
  
  <br><br>
  <?php
  if($udp->onlyadm == "2")
  {
    if(GROUP == "2" OR GROUP == "3")
	{
	    echo "<a href=\"main.php?do=make_pn&amp;to=$udp->username;\"><img src=\"images/pn.png\" border='0' height='16px' width='30px'> Private Nachricht schicken</a>";
	}
  }
  else
  {
    echo "<a href=\"main.php?do=make_pn&amp;to=$udp->username;\"><img src=\"images/pn.png\" border='0' height='16px' width='30px'> Private Nachricht schicken</a>";
  }
  ?>
  <br>
  <br>
  <table width="100%" valign="top"><tr><td width="65%">
   <a href="search.php?do=send&us=<?php echo $udp->username; ?>&action=beitrag">Alle Beiträge</a> <br> <a href="search.php?do=send&us=<?php echo $udp->username; ?>&action=thema">Alle Themen</a>
  </td>
  </tr>
  </table>
  
  </td><td><table><tr><td><b>Beiträge</b></td></tr>
  <tr><td width="40%">Beiträge:</td><td><?php echo $udp->posts; ?></td></tr>
  <tr><td width="40%">&#216; Beiträge/Tag:</td><td><? 
  $tag = time() - $udp->reg_dat;
  $da = $tag/84600;
  $da = round($da);
  if($udp->posts != "0" AND $da != "0")
  {
    $bei_tag = $udp->posts/$da;
    echo round($bei_tag, 2);
  }
  else { echo "0"; }  ?></td></tr><tr><td>
  <b>Über <? echo $udp->username; ?></b></td></tr>
  <tr><td width="40%">Hobbys:</td><td> <? echo $udp->hob; ?></td></tr>
  <tr><td width="40%">Website:</td><td><a href="<? if(str_replace("http://www.", "www.", $udp->website))echo "http://$udp->website";  else echo $udp->website;?>" target="_blank"><? echo $udp->website; ?></a></td></tr>
  <tr><td>
  <b>Andere Informationen</b></td></tr>
    <?php
  $rech = $udp->last_log - time();
  $datum = date("d.m.Y",$udp->last_log);
  $uhrzeit = date("H:i",$udp->last_log);
  if($rech > "-901")
  {
  ?>
  <tr><td width="40%">Jetzt online:</td><td width="60%"> <?php echo $udp->last_site; }
  else{ 
  $now = date("d.m.Y", time());
  if($now == $datum)
  {
    $datum = "Heute";
  }
  if($datum == "01.01.1970")
  {
    $login = array(
	         "login" => "Noch nie eingeloggt");
  }
  else
  {
    $login = array(
			 "login" => "$datum um $uhrzeit");
  }

  echo "<tr><td width='40%'>Letzte Aktivität: </td><td> $login[login]"; }?></td></tr>
  <tr><td width="40%">Registriert am:</td><td> <?php   
  $datum = date("d.m.Y",$udp->reg_dat);
  $uhrzeit = date("H:i",$udp->reg_dat);
  echo "$datum";?></td></tr>
  <tr><td>Empfehlungen:</td><td> <?php $empfh = mysql_query("SELECT * FROM users WHERE empfo LIKE '$udp->username'"); echo mysql_num_rows($empfh); ?> </td></tr>
  <tr><td>Profilbesucher:</td><td> <?php echo $udp->provi; ?></td></tr>
  <?php
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
    echo"<tr><td><b>Signatur</b></td></tr><tr><td></td><td>$text</td></tr>";
  }
  ?>
  
  </table><br><br>
  <br>
  </td></tr></table>
  <?php
}
if((GROUP == "2" OR GROUP == "3") AND $ud->adm_recht >= $udp->adm_recht)
{
?><br>
  <table class="bord" width="100%"><tr class="dark"><td>
  <table width=100%><tr><td><b><font color="snow">Verwarnungen</font></b></td><td align=right><a href="profil.php?id=<?php echo $_GET["id"];?>&action=warn"><font color=snow>Benutzer verwarnen</font></a></td></tr></table></td></tr>
  <tr><td>
 <?php
  $us_ver = mysql_query("SELECT * FROM user_verwarn WHERE user_id LIKE '$_GET[id]'");
  $ttt = "0";
  while($uv = mysql_fetch_object($us_ver))
  {
    $ttt++;
	if($ttt == "1")
	{
	  $akt = "";
	  if($_GET["id"] != $ud->id)
	  {
	    $akt = "Aktionen";
	  }
	  echo "  <table width=100%><tr style=font-weight:bold><td width=30%>Grund</td><td width=30%>Verwarnt von / Datum</td><td width=10%>Punkte</td><td width=20%>Läuft aus</td><td>$akt</td></tr>";
	}
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
    echo "<tr align=center><td align=left valign=left>$uv->grund</td><td align=left valign=left>$uv->von / ". date("d.m.Y - H:m", $uv->wann) ."</td><td align=left valign=left>$uv->punkte</td><td align=left valign=left>$dauer</td><td align=left valign=left><a href=?action=no_warn&id=$uv->id>";
	if($_GET["id"] != $ud->id AND $dauer != "Abgelaufen" AND $dauer != "Zurückgenommen")
	  echo "Zurücknehmen</a>";
	else
	  echo "</a>Zurücknehmen";
	echo "</td></tr>";
  }
  if($ttt == "0")
  {
    echo "<table>";
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
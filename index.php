<?php
//Wichtige Angaben f�r jede Datei!
include("includes/functions.php");
page_header();
looking_page("index");
$stat_them = "0";
$stat_bei = "0";
$user_data = mysql_query("SELECT * FROM users WHERE username LIKE '". USER ."'");
$ud = mysql_fetch_object($user_data);
$foren_data = mysql_query("SELECT * FROM kate");
  echo "<table color=snow width=100% class=dark><tr><td width=70%><font color=snow>Name</font></td><td><font color=snow>Letzter Beitrag</font></td><td width=5%><font color=snow>Themen</font></td><td width=5%><font color=snow>Beitr�ge</font></td></tr></table>";
while($fr = mysql_fetch_object($foren_data))
{
  echo "<table color=snow class=hell width=100%><tr width=100%><td width=100%><b>$fr->name</b><br>$fr->besch</td></tr></table>";
  $for_date = mysql_query("SELECT * FROM foren WHERE kate = '$fr->id' ORDER BY sort");
  while($fd = mysql_fetch_object($for_date))
  {
    $look_see = "0";
    $them_dat = mysql_query("SELECT * FROM thema WHERE where_forum LIKE '$fd->id'");
	while($tda = mysql_fetch_object($them_dat))
	{
	  $data = mysql_query("SELECT * FROM read_all WHERE uname LIKE '". USER ."' AND thema_id LIKE '$tda->id'");
      $da = mysql_fetch_object($data);
	  
	  $datas = mysql_query("SELECT * FROM read_all WHERE uname LIKE '". USER ."' AND thema_id LIKE '0' ORDER BY id DESC LIMIT 1");
      $das = mysql_fetch_object($datas);
	  
	  if($da->when_look == "")
      {
        $da->when_look = "0";
      }
      if($da->when_look < $tda->last_post_time AND $das->when_look < $tda->last_post_time)
      {
        $look_see++;
	  }
	}
	$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2imgadfs'");
    $cd = mysql_fetch_object($config_datas);
	if($cd->wert1 == "") { $cd->wert1 = "images/old_1.png"; }
    if($cd->wert2 == "") { $cd->wert2 = "images/new_1.png"; }
	if($look_see == "0")
	{
	  $forum_stat = "<img src='$cd->wert1' title='Keine neuen Beitr�ge' width=50 height=50>";
	}
	else
	{
	  $forum_stat = "<img src='$cd->wert2' title='Neue Beitr�ge' width=50 height=50>";
	}
    $beit = "0";
	$zahl_themen = "0";
    $th_dat = mysql_query("SELECT * FROM thema WHERE where_forum LIKE '$fd->id'");
	while($tda = mysql_fetch_object($th_dat))
	{
	  $zahl_themen++;
	  $bei_dat = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$tda->id'");
	  while($bed = mysql_fetch_object($bei_dat))
	  {
	    $beit++;
	  }
	}
	
	$thema_dat = mysql_query("SELECT * FROM thema WHERE where_forum LIKE '$fd->id' ORDER BY last_post_time DESC LIMIT 1");
	$thd = mysql_fetch_object($thema_dat);
	$beitrag_dat = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$thd->id' ORDER BY id DESC LIMIT 1");
	$bd = mysql_fetch_object($beitrag_dat);
	
	$beisq = $thd->tit;
    $substr = substr($beisq, 0, 20);
    $tioh = strlen($beisq);
    if($tioh > "20")
    {
      $tit = $substr." ..."; 
    }
    else
    {
      $tit = $beisq;
    }
	if($fd->min_posts > $ud->posts)
	{
	  $last_beitrag = "Keine Beitr�ge";
	}	
	else{
	if($bd->verfas == "")
	{
	  $bd->verfas = $thd->verfas;
	}
	if($bd->verfas != "" OR $thd->verfas != "")
	{
	  $thd->tit = strip_tags($thd->tit);
	  $anz = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$thd->id'");
	  $anza = mysql_num_rows($anz);
	  $rech = ceil($anza/10);
	  $last_beitrag = "<a href=thread.php?id=$thd->id&page=$rech#$bd->id title='$thd->tit'>$tit</a><br><small>von $bd->verfas</small>";
	}

	if($bd->verfas == "" AND $thd->verfas == "")
	{
	  $last_beitrag = "Keine Beitr�ge";
	}
	}

    if($fd->guest_see == "0")
    {
	  $stat_them = $stat_them + $zahl_themen;
	  $stat_bei = $stat_bei + $beit;
      echo "<table width=100% bgcolor=#F2F2E5><tr><td width=70%><table><tr><td> $forum_stat &nbsp; </td><td><a href=forum.php?id=$fd->id><b>$fd->name</b></a><br><font size=2px>$fd->besch</font></td></tr></table></td><td>$last_beitrag</td><td width=5%>$zahl_themen</td><td width=5%>$beit</td></tr></table>";
	}
	else
	{
	  if(USER != "")
	  {
	  	$stat_them = $stat_them + $zahl_themen;
		$stat_bei = $stat_bei + $beit;
        echo "<table width=100% bgcolor=#F2F2E5><tr><td width=70%><table><tr><td> $forum_stat &nbsp; </td><td><a href=forum.php?id=$fd->id><b>$fd->name</b></a></b><br><font size=2px>$fd->besch</font></td></tr></table></td><td>$last_beitrag</td><td width=5%>$zahl_themen</td><td width=5%>$beit</td></tr></table>";
	  }
	}
  }
}
echo"<table width=100% class=navi><tr><td style=font-weight:bold;><center><a href=?do=marks>Alle Themen als gelesen markieren</a> | <a href=member.php?do=groups>Forum-Team</a></center></td></table><br>";

//Statistiken auf der Startseite
$tabelle = "onlineuser";
$online_time = "900";
$uid = md5(uniqid(microtime()));
$ip = $_SERVER['REMOTE_ADDR'];
$dummy = "";  
$dtime = time() - $online_time;
@mysql_query("DELETE FROM " . $tabelle . " WHERE TIME < " . $dtime);  

$result = mysql_query("SELECT ip FROM " . $tabelle." WHERE IP = '" . $ip . "'") or die(mysql_error());
$time = time();
if (mysql_num_rows($result) == 0) {
    mysql_query("INSERT INTO onlineuser (uid, ip, time) VALUES ('$uid', '$ip', '$time')");
}  
$result = mysql_query("SELECT COUNT(IP) as total FROM " . $tabelle); 
list($user_online) = mysql_fetch_array($result); 

$time_as_useris_online = "900";
$ergtime = time() - $time_as_useris_online;
$online_data = mysql_query("SELECT * FROM users WHERE last_log > '$ergtime' ORDER BY username");
$meno = mysql_num_rows($online_data);

$guest = $user_online - $meno;
if($guest < 0)
{
  $guest = "0";
  $user_online--;
}

$online_all = $meno + $guest;

echo "<br><table width=100% class=normal><tr><td><b><a href=online.php><font color=black>Wer ist online?</font></a></b> Es sind $online_all Besucher online ($meno Eingeloggte und $guest ";
if($guest == "1")
{
  echo "Gast";
}
else
{
  echo "G�ste";
}
echo")</td></tr></table>";
user_online(false);
echo "</td></tr></table><br>";

//Abfragen f�r die Statistik
$time = time();
$user_dat = mysql_query("SELECT * FROM users WHERE sptime < '$time'");
$stat_use = mysql_num_rows($user_dat);

$last_use = mysql_query("SELECT * FROM users WHERE gesperrt = '0' ORDER BY id DESC LIMIT 1");
$last_use = mysql_fetch_object($last_use);

$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2imgadfs'");
$cd = mysql_fetch_object($config_datas);

if($cd->wert1 == "") { $cd->wert1 = "images/old_1.png"; }
if($cd->wert2 == "") { $cd->wert2 = "images/new_1.png"; }
	
echo "<table width=100% class=normal><tr><td><b>Statistiken.</td></tr></table>";
echo "<table width=100% bgcolor=#F2F2E5><tr><td><b>Themen:</b> $stat_them <b>Beit�ge:</b> $stat_bei <b>Benutzer:</b> $stat_use<br>Wir begr��en unser neustes Mitglied: <a href=profil.php?id=$last_use->id>$last_use->username</a></td></tr></table><br>
<center><img src=$cd->wert1 width=40 height=40> <small>Keine neuen Beitr�ge</small>  &nbsp; &nbsp; <img src=$cd->wert2 width=40 height=40> <small>Neue Beitr�ge</small></center><br>";
if($_GET["do"] == "marks")
{
  if(USER != "")
  {
    $time = time();
	mysql_query("INSERT INTO read_all (uname, thema_id, when_look) VALUES ('". USER ."', '0', '$time')")or die(mysql_error());
 
  }
  else
  {
    echo "<script>alert('Leider ist diese Funktion im Gast-Zugang nicht m�glich. Registriere dich oder logge dich ein!')</script>";
  }
}
//Wichtige Datein f�r den Footer
page_footer();
?>
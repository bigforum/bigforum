<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
page_header();
$userdata = mysql_query("SELECT * FROM users WHERE username LIKE '". USER ."'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
$ud = mysql_fetch_object($userdata);
$ausgabe = "";
looking_page("onekat");
if($_GET["do"] == "show_one")
{
//Nur eine Kategorie
$foren_data = mysql_query("SELECT * FROM kate WHERE id LIKE '$_GET[id]'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
while($fr = mysql_fetch_object($foren_data))
{
  $ausgabe .= "<table color=snow class=hell width=100% style='-moz-border-radius:8px;-khtml-border-radius:8px;'><tr width=100%><td width=100%><b>$fr->name</b><br>$fr->besch</td></tr></table>";
  $for_date = mysql_query("SELECT * FROM foren WHERE kate = '$fr->id' ORDER BY sort");
  while($fd = mysql_fetch_object($for_date))
  {
    $look_see = "0";
    $them_dat = mysql_query("SELECT * FROM thema WHERE where_forum LIKE '$fd->id'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
	while($tda = mysql_fetch_object($them_dat))
	{
	  $data = mysql_query("SELECT * FROM read_all WHERE uname LIKE '". USER ."' AND thema_id LIKE '$tda->id'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
      $da = mysql_fetch_object($data);
	  
	  $datas = mysql_query("SELECT * FROM read_all WHERE uname LIKE '". USER ."' AND thema_id LIKE '0' ORDER BY id DESC LIMIT 1") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
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
	$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2imgadfs'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
    $cd = mysql_fetch_object($config_datas);
	if($cd->wert1 == "") { $cd->wert1 = "images/old_1.png"; }
    if($cd->wert2 == "") { $cd->wert2 = "images/new_1.png"; }
	if($look_see == "0")
	{
	  $forum_stat = "<img src='$cd->wert1' title='Keine neuen Beiträge' width=50 height=50>";
	}
	else
	{
	  $forum_stat = "<img src='$cd->wert2' title='Neue Beiträge' width=50 height=50>";
	}
    $beit = "0";
	$zahl_themen = "0";
    $th_dat = mysql_query("SELECT * FROM thema WHERE where_forum LIKE '$fd->id'");
	while($tda = mysql_fetch_object($th_dat))
	{
	  $zahl_themen++;
	  $bei_dat = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$tda->id'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
	  while($bed = mysql_fetch_object($bei_dat))
	  {
	    $beit++;
	  }
	}
	
	$thema_dat = mysql_query("SELECT * FROM thema WHERE where_forum LIKE '$fd->id' ORDER BY last_post_time DESC LIMIT 1") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
	$thd = mysql_fetch_object($thema_dat);
	$beitrag_dat = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$thd->id' ORDER BY id DESC LIMIT 1") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
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
	  $last_beitrag = "Keine Beiträge";
	}	
	else{
	if($bd->verfas == "")
	{
	  $bd->verfas = $thd->verfas;
	}
	if($bd->verfas != "" OR $thd->verfas != "")
	{
	  $thd->tit = strip_tags($thd->tit);
	  $anz = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$thd->id'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
	  $anza = mysql_num_rows($anz);
	  $rech = ceil($anza/10);
	  $last_beitrag = "<a href=thread.php?id=$thd->id&page=$rech#$bd->id title='$thd->tit'>$tit</a><br><small>von $bd->verfas</small>";
	}

	if($bd->verfas == "" AND $thd->verfas == "")
	{
	  $last_beitrag = "Keine Beiträge";
	}
	}
	
	$user_see_forum = mysql_query("SELECT * FROM users WHERE last_site LIKE \"Befindet sich im Forum $fd->name\"") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
	$usf = mysql_num_rows($user_see_forum);
	$bes = "";
	if($usf > "0")
	{
	  $bes = "($usf Betrachter)";
	}

    if($fd->guest_see == "0")
    {
	  $stat_them = $stat_them + $zahl_themen;
	  $stat_bei = $stat_bei + $beit;
      $ausgabe .= "<table width=100% class='forenbg'><tr><td width=70%><table><tr><td> $forum_stat &nbsp; </td><td><a href=forum.php?id=$fd->id><b>$fd->name</b></a> $bes<br><font size=2px>$fd->besch</font></td></tr></table></td><td>$last_beitrag</td><td width=5%>$zahl_themen</td><td width=5%>$beit</td></tr></table>";
	}
	if($fd->guest_see == "1")
	{
	  if(USER != "")
	  {
	  	$stat_them = $stat_them + $zahl_themen;
		$stat_bei = $stat_bei + $beit;
        $ausgabe .= "<table width=100% class='forenbg'><tr><td width=70%><table><tr><td> $forum_stat &nbsp; </td><td><a href=forum.php?id=$fd->id><b>$fd->name</b></a> $bes<br><font size=2px>$fd->besch</font></td></tr></table></td><td>$last_beitrag</td><td width=5%>$zahl_themen</td><td width=5%>$beit</td></tr></table>";
	  }
	}
	if($fd->guest_see == "2")
	{
	  if(GROUP == 2 OR GROUP == 3)
	  {
	  	$stat_them = $stat_them + $zahl_themen;
		$stat_bei = $stat_bei + $beit;
        $ausgabe .= "<table width=100% class='forenbg'><tr><td width=70%><table><tr><td> $forum_stat &nbsp; </td><td><a href=forum.php?id=$fd->id><b>$fd->name</b></a> $bes<br><font size=2px>$fd->besch</font></td></tr></table></td><td>$last_beitrag</td><td width=5%>$zahl_themen</td><td width=5%>$beit</td></tr></table>";
	  }
	}
	
  }
}
echo $ausgabe;
page_footer();
exit;
//Nur eine Kategorie!
}

looking_page("index"); //Ausgabe wo man sich befindet

if(USER != "")
{
//Wenn der Benutzer eingeloggt ist, für Gäste ist die Funktion sinnlos, kann er die untere Statiistik ausblenden
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

 

 
function ss() {
xmlhttp.open("GET", 'index.php?do=ss');
 if (document.getElementById("zwei").style.display=='none') {
  document.getElementById("zwei").style.display='block';
  }
 else {
  document.getElementById("zwei").style.display='none';
 }
 document.getElementById("statistik").innerHTML = "<span id=statistik><a href=\"javascript:ds()\">ausblenden</a></span>";
 xmlhttp.open("GET", 'index.php?do=ss');
xmlhttp.send(null);
}
function ds() {
 if (document.getElementById("zwei").style.display=='none') {
  document.getElementById("zwei").style.display='block';
 }
 else {
  document.getElementById("zwei").style.display='none';
 }
 document.getElementById("statistik").innerHTML = "<span id=statistik><a href=\"javascript:ss()\">einblenden</a></span>";
xmlhttp.open("GET", 'index.php?do=ds');
xmlhttp.send(null);
}

</script>
<?php
if($_GET["do"] == "ss")
{
  mysql_query("UPDATE users SET statshow = '0' WHERE username LIKE '". USER ."'");
}
if($_GET["do"] == "ds")
{
  mysql_query("UPDATE users SET statshow = '1' WHERE username LIKE '". USER ."'");
}
}
$stat_them = "0";
$stat_bei = "0";
$user_data = mysql_query("SELECT * FROM users WHERE username LIKE '". USER ."'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
$ud = mysql_fetch_object($user_data);
$foren_data = mysql_query("SELECT * FROM kate") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
$ausgabe .= "<table color=snow width=100% class=dark><tr><td width=70%><font color=snow>Name</font></td><td><font color=snow>Letzter Beitrag</font></td><td width=5%><font color=snow>Themen</font></td><td width=5%><font color=snow>Beiträge</font></td></tr></table>";

while($fr = mysql_fetch_object($foren_data))
{
  $ausgabe .= "<table color=snow class=hell width=100% style='-moz-border-radius:8px;-khtml-border-radius:8px; text-decoration: none;'><tr width=100%><td width=100%><b><span style=\"cursor: pointer;\" onclick=\"window.location.href='?do=show_one&id=$fr->id'\">$fr->name</span></b><br>$fr->besch</td></tr></table>";
  $for_date = mysql_query("SELECT * FROM foren WHERE kate = '$fr->id' ORDER BY sort");
  while($fd = mysql_fetch_object($for_date))
  {
    $look_see = "0";
    $them_dat = mysql_query("SELECT * FROM thema WHERE where_forum LIKE '$fd->id'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
	while($tda = mysql_fetch_object($them_dat))
	{
	  $data = mysql_query("SELECT * FROM read_all WHERE uname LIKE '". USER ."' AND thema_id LIKE '$tda->id'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
      $da = mysql_fetch_object($data);
	  
	  $datas = mysql_query("SELECT * FROM read_all WHERE uname LIKE '". USER ."' AND thema_id LIKE '0' ORDER BY id DESC LIMIT 1") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
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
	$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2imgadfs'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
    $cd = mysql_fetch_object($config_datas);
	if($cd->wert1 == "") { $cd->wert1 = "images/old_1.png"; }
    if($cd->wert2 == "") { $cd->wert2 = "images/new_1.png"; }
	if($look_see == "0")
	{
	  $forum_stat = "<img src='$cd->wert1' title='Keine neuen Beiträge' width=50 height=50>";
	}
	else
	{
	  $forum_stat = "<img src='$cd->wert2' title='Neue Beiträge' width=50 height=50>";
	}
    $beit = "0";
	$zahl_themen = "0";
    $th_dat = mysql_query("SELECT * FROM thema WHERE where_forum LIKE '$fd->id'");
	while($tda = mysql_fetch_object($th_dat))
	{
	  $zahl_themen++;
	  $bei_dat = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$tda->id'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
	  while($bed = mysql_fetch_object($bei_dat))
	  {
	    $beit++;
	  }
	}
	
	$thema_dat = mysql_query("SELECT * FROM thema WHERE where_forum LIKE '$fd->id' ORDER BY last_post_time DESC LIMIT 1") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
	$thd = mysql_fetch_object($thema_dat);
	$beitrag_dat = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$thd->id' ORDER BY id DESC LIMIT 1") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
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
	  $last_beitrag = "Keine Beiträge";
	}	
	else{
	if($bd->verfas == "")
	{
	  $bd->verfas = $thd->verfas;
	}
	if($bd->verfas != "" OR $thd->verfas != "")
	{
	  $thd->tit = strip_tags($thd->tit);
	  $anz = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$thd->id'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
	  $anza = mysql_num_rows($anz);
	  $rech = ceil($anza/10);
	  $last_beitrag = "<a href=thread.php?id=$thd->id&page=$rech#$bd->id title='$thd->tit'>$tit</a><br><small>von $bd->verfas</small>";
	}

	if($bd->verfas == "" AND $thd->verfas == "")
	{
	  $last_beitrag = "Keine Beiträge";
	}
	}
	$dtime = time() - 900;
	$user_see_forum = mysql_query("SELECT * FROM users WHERE last_site LIKE \"Befindet sich im Forum $fd->name\" AND last_log > '$dtime' ") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
	$usf = mysql_num_rows($user_see_forum);
	$bes = "";
	if($usf > "0")
	{
	  $bes = "($usf Betrachter)";
	}

    if($fd->guest_see == "0")
    {
	  $stat_them = $stat_them + $zahl_themen;
	  $stat_bei = $stat_bei + $beit;
      $ausgabe .= "<table width=100% class=forenbg><tr><td width=70%><table><tr><td> $forum_stat &nbsp; </td><td><a href=forum.php?id=$fd->id><b>$fd->name</b></a> $bes<br><font size=2px>$fd->besch</font></td></tr></table></td><td>$last_beitrag</td><td width=5%>$zahl_themen</td><td width=5%>$beit</td></tr></table>";
	}
	if($fd->guest_see == "1")
	{
	  if(USER != "")
	  {
	  	$stat_them = $stat_them + $zahl_themen;
		$stat_bei = $stat_bei + $beit;
        $ausgabe .= "<table width=100% class=forenbg><tr><td width=70%><table><tr><td> $forum_stat &nbsp; </td><td><a href=forum.php?id=$fd->id><b>$fd->name</b></a> $bes<br><font size=2px>$fd->besch</font></td></tr></table></td><td>$last_beitrag</td><td width=5%>$zahl_themen</td><td width=5%>$beit</td></tr></table>";
	  }
	}
	if($fd->guest_see == "2")
	{
	  if(GROUP == 2 OR GROUP == 3)
	  {
	  	$stat_them = $stat_them + $zahl_themen;
		$stat_bei = $stat_bei + $beit;
        $ausgabe .= "<table width=100% class=forenbg><tr><td width=70%><table><tr><td> $forum_stat &nbsp; </td><td><a href=forum.php?id=$fd->id><b>$fd->name</b></a> $bes<br><font size=2px>$fd->besch</font></td></tr></table></td><td>$last_beitrag</td><td width=5%>$zahl_themen</td><td width=5%>$beit</td></tr></table>";
	  }
	}
	
  }
}
$ausgabe .= "<table width=100% class=navi><tr><td style=font-weight:bold;><center><a href=?do=marks>Alle Themen als gelesen markieren</a> | <a href=member.php?do=groups>Forum-Team</a></center></td></table><br>";

//Statistiken auf der Startseite
$tabelle = "onlineuser";
$online_time = "900";
$uid = md5(uniqid(microtime()));
$ip = $_SERVER['REMOTE_ADDR'];
$dummy = "";  
$dtime = time() - $online_time;
@mysql_query("DELETE FROM " . $tabelle . " WHERE TIME < " . $dtime);  

$result = mysql_query("SELECT ip FROM " . $tabelle." WHERE IP = '" . $ip . "'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
$time = time();
if (mysql_num_rows($result) == 0) {
    mysql_query("INSERT INTO onlineuser (uid, ip, time) VALUES ('$uid', '$ip', '$time')");
}  
$result = mysql_query("SELECT COUNT(IP) as total FROM " . $tabelle) or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));; 
list($user_online) = mysql_fetch_array($result); 

$time_as_useris_online = "900";
$ergtime = time() - $time_as_useris_online;
$online_data = mysql_query("SELECT * FROM users WHERE last_log > '$ergtime' ORDER BY username") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
$meno = mysql_num_rows($online_data);

$guest = $user_online - $meno;
if($guest < 0)
{
  $guest = "0";
  $user_online--;
}

$online_all = $meno + $guest;

$ausgabe .= "<br><table width=100% class=normal><tr><td><b><a href=online.php><font color=black>Wer ist online?</font></a></b> Es sind $online_all Besucher online ($meno Eingeloggte und $guest ";
if($guest == "1")
{
  $ausgabe .= "Gast";
}
else
{
  $ausgabe .= "Gäste";
}
//Abfragen für die Statistik
$time = time();
$user_dat = mysql_query("SELECT * FROM users WHERE sptime < '$time'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
$stat_use = mysql_num_rows($user_dat);
$ausgabe .=")</td></tr></table>";
echo $ausgabe;
$ausgabe = "";
user_online(false);
echo "</td></tr></table><br>";



$time = time();

$last_use = mysql_query("SELECT * FROM users WHERE sptime < '$time' ORDER BY id DESC LIMIT 1");
$last_use = mysql_fetch_object($last_use);

$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2imgadfs'");
$cd = mysql_fetch_object($config_datas);

if($cd->wert1 == "") { $cd->wert1 = "images/old_1.png"; }
if($cd->wert2 == "") { $cd->wert2 = "images/new_1.png"; }
$userdata = mysql_query("SELECT * FROM users WHERE username LIKE '". USER ."'");
$ud = mysql_fetch_object($userdata);
echo "<table width=100% class=normal><tr><td><b>Statistiken</td></tr></table>";
echo "<table width=100% class=forenbg><tr><td><b>Themen:</b> $stat_them <b>Beiträge:</b> $stat_bei <b>Benutzer:</b> $stat_use<br>Wir begrüßen unser neustes Mitglied: <a href=profil.php?id=$last_use->id>$last_use->username</a></td></tr></table><br>";
if($ud->statshow == "0")
{
  $show = "<span id=statistik><a href=\"javascript:ds()\">ausblenden</a></span>";
  $einb = "n";
}
else
{
  $show = "<span id=statistik><a href=\"javascript:ss()\">einblenden</a></span>";
  $einb = "j";
}
$stat = "";
$conda = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2profs'");
$codd = mysql_fetch_object($conda);
if($codd->wert1 == "j")
{
  echo "<table width=100% class=normal><tr><td><b>Weitere Statistiken ($show)</td></tr></table>";
  if($ud->statshow == "0" OR $ud->username == "")
  {
    if($einb != "j")
    {
      show_stat("j");
    }
  }
  elseif($einb == "j")
  {
    echo "<div style=\"display: none;\" id=\"zwei\">";
    show_stat("n");
    echo "</div>";
  }
  echo "<br>";
}
echo "<center><img src=$cd->wert1 width=40 height=40> <small>Keine neuen Beiträge</small>  &nbsp; &nbsp; <img src=$cd->wert2 width=40 height=40> <small>Neue Beiträge</small></center><br>";

if($_GET["do"] == "marks")
{
  if(USER != "")
  {
    $time = time();
	mysql_query("INSERT INTO read_all (uname, thema_id, when_look) VALUES ('". USER ."', '0', '$time')")or die(mysql_error());
 
  }
  else
  {
    echo "<script>alert('Leider ist diese Funktion im Gast-Zugang nicht möglich. Registriere dich oder logge dich ein!')</script>";
  }
}
echo $ausgabe;
//Wichtige Datein für den Footer
page_footer();
?>
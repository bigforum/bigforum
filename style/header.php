<html>

<head>
<title><?php echo SITENAME;  if($username == "Gast"){ echo " - Gastzugang"; }?></title>
<meta name="generator" content="bigforum <?php echo VERSION; ?>" />
<meta name="description" content="<?php echo SITENAME. " - ". BESCHREIBUNG; 
$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2laengfs'"); $cd = mysql_fetch_object($config_datas);?>" />
<link rel="shortcut icon" href="<?php echo $cd->wert1;?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="style/<?php
$user_data = mysql_query("SELECT * FROM users WHERE username LIKE '". USER ."'");
$ud = mysql_fetch_object($user_data);
$style_data = mysql_query("SELECT * FROM style_all WHERE sname LIKE '$ud->style'");
$sd = mysql_fetch_object($style_data);
if($ud->style == "")
{
  $style_data = mysql_query("SELECT * FROM style_all WHERE sname LIKE '$cd->wert2'");
  $sd = mysql_fetch_object($style_data);
  if($sd->link_style != "")
  {
    echo $sd->link_style;
  }
  else
  {
    $style_data = mysql_query("SELECT * FROM style_all LIMIT 1");
    $sd = mysql_fetch_object($style_data);
	echo $sd->link_style;
  }
}
else
{
  echo $sd->link_style;
}
?>" />


</head>

<body onLoad="uhrzeit('jetzt'); setInterval('uhrzeit()', 1000)">
<script type="text/javascript" src="style/wz_tooltip.js"></script>
<script type="text/javascript" src="style/script.js"></script>
<table class="bgt" width="100%" height="*">
  <tr valign="top">
    <td  style="padding-left:5px">
<!-- Start des Inhaltes -->
<?php
$time = time();
if($ud->gesperrt == "1" AND $ud->sptime > $time)
{
  ?>
  <center><table class=bord height="50%" width="50%">  
<tbody><tr class=normal><td><font color="snow"><b>Fehler</b></font></td></tr>
	<tr><td align="center">Du wurdest aus diesem Forum ausgeschloßen. Dieses kann mehrere Gründe haben.<br>Deine Sperre läuft bis zum <?php echo date("d.m.Y - h:i", $ud->sptime); ?> </td></tr></tbody></table></center>
	<?php
  exit;
}
$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2closefs'");
$cd = mysql_fetch_object($config_datas);
if($cd->zahl1 == "0" AND $ud->adm_recht <= "5" AND $_SERVER['REQUEST_URI'] != "/login.php")
{?>
  <center><table class=bord height="50%" width="50%">  
<tbody><tr class=normal><td><font color="snow"><b>Forum geschlossen</b></font></td></tr>
	<tr><td align="center">Dieses Forum ist zur Zeit geschlossen und kann somit nicht benutzt werden. Lediglich ein Administrator hat Zugriff auf das Forum, dieser kann sich <a href="login.php">hier</a> einloggen.<br><br><b>Angegebener Grund für die Schließung:</b> <?php echo $cd->wert1; ?></td></tr></tbody></table></center>
<?php
  exit;
}
?>
<table class="tabelbor" width="100%" height="8%"><tr><td width="70%">
<?php
$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2pnsignfs'");
$cd = mysql_fetch_object($config_datas);
echo "<a href=index.php><img src='$cd->wert2' border=0 title='". SITENAME ."' height=70%></a>";
?></td>
<td class="tab1" width="30%" valign="top">
<?php if($username == "Gast" OR USER == ""){?>
Willkommen, <span style="cursor: pointer;" onclick="window.location.href='profil.php?id=<?php echo $ud->id; ?>'"><?php echo USER; ?></span>
<p></p><form action="login.php?do=login" method="post"><table>
<tr><td>Benutzername:</td><td><input type="text" name="user"></td></tr>
<tr><td>Passwort:</td><td><input type="password" name="pw"></td></tr>
</table><input type=submit value="Login"></form><?php 
}

 else {

  echo "<b>Notiz: (<a href=# onmouseover=\"Tip('Dies ist eine Information, die von einem Administrator erstellt wurde. <br> Du kannst diese im Persönlichem Bereich unter \'Einstellungen\' ausblenden lassen.')\" onmouseout=\"UnTip()\">Info</a>)</b><br>";
  if($ud->notice != "" AND $ud->notice != "0")
  { 
    echo "$ud->notice";
  }
  else
  {
    echo "Keine Notiz vorhanden.";
  }
  $time = time();
  $us_ver = mysql_query("SELECT * FROM user_verwarn WHERE user_id LIKE '$ud->id' AND dauer > '$time'");
  echo "<br><br><b>Aktive Verwarnungen:</b> ". mysql_num_rows($us_ver) ."";
$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2pnsignfs'");
$cd = mysql_fetch_object($config_datas);
 }
?>
<br><br>

</td></tr></table>

<table width="100%" class="navi"><tr width="100%">
<td><a href="index.php">Startseite</a></td>
<?php if(USER == "") { ?>
<td><a href="login.php">Login</a></td>
<td><a href="reg.php">Registrieren</a></td>
<?php } else { ?>
<td><a href="main.php">Persönlicher Bereich</a></td>
<td><a href="member.php">Benutzerliste</a></td>
<?php } ?>
<td><a href="search.php">Suche</a></td>
<?php
$config_data = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2closefs'");
$cd = mysql_fetch_object($config_data);
if($cd->wert2 != "")
{
  echo "<td>$cd->wert2</td>";
}
if(GROUP == "3") echo "<td><a href=admin/><b>Administrator-Kontrollzentrum</b></a></td>"; 

echo "</tr></table><table class=hell width=30%><tr><td>";
$da = $_SERVER["SCRIPT_NAME"];
$da = preg_replace ('#\/.*?\/#m' , '' , $da);  
$da =  "/$da";
$da = str_replace("//","/", $da);
$id = $_GET["id"];
//Aufenthalt ermitteln
$seite = array(
  "/index.php"     => "Startseite",
  "/modcp.php"     => "Moderatoren-Kontrollzentrum",
  "/member.php"    => "Mitglieder",
  "/search.php"    => "Foren-Suche",
  "/main.php"      => "Persönlicher-Bereich",
  "/online.php"    => "Wer ist online?",
  "/newreply.php"  => "Beitrag schreiben",
  "/newtopic.php"  => "Thema verfassen",
  "/edit.php"      => "Beitrag ändern",
  "/login.php"	   => "Einloggen",
  "/reg.php"       => "Registrieren",
);
if($da == "/reg.php" OR $da == "/login.php" OR $da == "/index.php" OR $da == "/modcp.php" OR $da == "/member.php" OR $da == "/search.php" OR $da == "/main.php" OR $da == "/online.php" OR $da == "/newreply.php" OR $da == "/newtopic.php" Or $da == "/edit.php")
{
  echo "<a href=index.php> ".SITENAME." </a><br><b>> $seite[$da]</b>";
  $status = true;
}
if($da == "/thread.php")
{ 
  $thema_data = mysql_query("SELECT * FROM thema WHERE id LIKE '$id'");
  $td = mysql_fetch_object($thema_data); 
  $forum_data = mysql_query("SELECT * FROM foren WHERE id LIKE '$td->where_forum'");
  $fd = mysql_fetch_object($forum_data);
 
  echo "<a href=index.php> ".SITENAME." </a> > <a href=forum.php?id=$fd->id>$fd->name</a><br>
  <b>$td->tit</b>";
    $status = true;
}
if($da == "/profil.php")
{ 
  $prof_data = mysql_query("SELECT * FROM users WHERE id LIKE '$id'");
  $pd = mysql_fetch_object($prof_data);
 
  echo "<a href=index.php> ".SITENAME." </a> > <a href=member.php>Mitglieder</a><br>
  <b>Profil von $pd->username</b>";
    $status = true;
}
if($da == "/forum.php")
{ 
  $forum_data = mysql_query("SELECT * FROM foren WHERE id LIKE '$id'");
  $fd = mysql_fetch_object($forum_data);
  $kat_data = mysql_query("SELECT * FROM kate WHERE id LIKE '$fd->kate'");
  $kd = mysql_fetch_object($kat_data);
  echo "<a href=index.php> ".SITENAME." </a> > <a href=index.php?do=show_one&id=$kd->id>$kd->name</a><br>
  <b>$fd->name</b>";
    $status = true;
}
if($status != true)
{
  echo "<a href=index.php> ".SITENAME." </a>";
}
//Ende
echo "</td></tr></table><br>";
if(USER != "")
{
  echo "<table class=titl width=100%><tr><td><table width=100%><tr><td>Hallo ". USER ." (<a href=\"javascript:logout()\">Abmelden</a>).<br> <b>Private Nachrichten:</b> ";


  pn_zahl("header");
  echo "</td><td valign=right align=right>";
  $datum = date("d.m.Y");
  $uhrzeit = date("H:i");
  echo $datum," - ",$uhrzeit," Uhr"; 
  echo "</td></tr></table></td></tr></table>";
}
//AdServer
$adal = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2adser2'");
$aa = mysql_fetch_object($adal);
$out = "0";
$no = explode(",",$aa->wert1);
for($i=0;$i<count($no);$i++)
{
  if($no[$i] == $ud->id)
  {
    $out = "1";
  }
}
if($aa->zahl1 == "1" AND $out == "0")
{
  $adhol = mysql_query("SELECT * FROM adser ORDER BY rand() LIMIT 1");
  $ah = mysql_fetch_object($adhol);
  mysql_query("UPDATE adser SET see = see+1 WHERE id LIKE '$ah->id'");
  echo "<br><center><a href=misc.php?aktion=adser&id=$ah->id target=_blank><img src=$ah->bannerad border=0></a></center><br>";
}
// Ende AdServer
?>
<br>
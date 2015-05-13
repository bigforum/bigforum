<html>

<head>
<title><?php echo SITENAME;  if($username == "Gast"){ echo " - Gastzugang"; }?></title>
<meta name="generator" content="bigforum <?php echo VERSION; ?>" />
<meta name="description" content="<?php echo SITENAME. " - ". BESCHREIBUNG; 
$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2laengfs'"); $cd = mysql_fetch_object($config_datas);?>" />
<link rel="shortcut icon" href="<?php echo $cd->wert1;?>" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="style/<? 
$user_data = mysql_query("SELECT * FROM users WHERE username LIKE '". USER ."'");
$ud = mysql_fetch_object($user_data);
if($ud->style == "")
echo $cd->wert2;
else
echo $ud->style;
?>style.css" />


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
	<?
  exit;
}
$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2closefs'");
$cd = mysql_fetch_object($config_datas);
if($cd->zahl1 == "0" AND $ud->adm_recht <= "5" AND $_SERVER['REQUEST_URI'] != "/login.php")
{?>
  <center><table class=bord height="50%" width="50%">  
<tbody><tr class=normal><td><font color="snow"><b>Forum geschlossen</b></font></td></tr>
	<tr><td align="center">Dieses Forum ist zur Zeit geschlossen und kann somit nicht benutzt werden. Lediglich ein Administrator hat Zugriff auf das Forum, dieser kann sich <a href="login.php">hier</a> einloggen.<br><br><b>Angegebener Grund für die Schließung:</b> <? echo $cd->wert1; ?></td></tr></tbody></table></center>
<?
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

Willkommen, <span style="cursor: pointer;" onclick="window.location.href='profil.php?id=<?php echo $ud->id; ?>'"><?php echo USER; ?></span><?php if($username == "Gast"){?>
<p></p><form action="login.php?do=login" method="post"><table>
<tr><td>Benutzername:</td><td><input type="text" name="user"></td></tr>
<tr><td>Passwort:</td><td><input type="password" name="pw"></td></tr>
</table><input type=submit value="Login"></form><? } else {
$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2pnsignfs'");
$cd = mysql_fetch_object($config_datas);
pn_zahl("header"); }
?>
<br><br>

</td></tr></table>

<table width="100%" class="navi"><tr width="100%">
<td><a href="index.php">Startseite</a></td>
<?php if($username == "Gast") { ?>
<td><a href="login.php">Login</a></td>
<td><a href="reg.php">Registrieren</a></td>
<? } else { ?>
<td><a href="main.php">Persönlicher Bereich</a></td>
<td><a href="member.php">Benutzerliste</a></td>
<td><a href="javascript:logout()"><b>Abmelden</b></a></td>
<? } ?>
<td><a href="search.php">Suche</a></td>
<?php
$config_data = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2closefs'");
$cd = mysql_fetch_object($config_data);
if($cd->wert2 != "")
{
  echo "<td>$cd->wert2</td>";
}
if(GROUP == "3") echo "<td><a href=admin/><b>Administrator-Kontrollzentrum</b></a></td>"; 
?>
</tr></table>
<?php
if($ud->notice != "" AND $ud->notice != "0")
{
  echo "<br><table class=titl width=100%><tr><td><center> $ud->notice (<a href=# onmouseover=\"Tip('Dies ist eine Information, die von einem Administrator erstellt wurde. <br> Du kannst diese im Persönlichem Bereich unter \'Einstellungen\' ausblenden lassen.')\" onmouseout=\"UnTip()\">Info</a>)</center></td></tr></table>";
}
?>
<br>
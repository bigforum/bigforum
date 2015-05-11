<title><?php echo SITENAME; ?> - Eingeloggt als <?php echo $username; ?></title>
<body onLoad="uhrzeit('jetzt'); setInterval('uhrzeit()', 1000)">
<link rel="shortcut icon" href="images/bfav.ico" type="image/x-icon">
<style>
body {
background: #909090;

}
.bgt{
background: snow;
text: black;
}
a:link
{
	color: #22229C;
}
a:visited
{
	color: #22229C;
}
a:hover, a:active
{
	color: #FF4400;
}
.navi
{
  background: #397BC6;
  border: 1px solid #000050;
}
.navi a:link
{
	color: #FFFFFF;
	text-decoration: none;
}
.navi a:visited
{
	color: #FFFFFF;
	text-decoration: none;
}
.navi a:hover, a:active
{
	color: #FFFFFF;
	text-decoration: underline;
}
.tab1
{
	background: #E1E4F2;
	color: #000000;
}
.tab
{
    display: block;
	border: 1px;
	background: #EAEAEA;
	color: black;
	width: 100%;
	height: 7%;
	text-decoration: none;
}
.tab:hover
{
	background: #F0F0F0;
	color: darkblue;
	border-width: 75%;
	border-height: 20%;
	text-decoration: none;
}

.tabelbor
{
  border: 1px solid #000050;
}
legend
{
	color: #22229C;
	font-size: 12px;
    font-weight: bold;
}
fieldset
{
  border: 1px solid #22229C;
}
</style>
<script>
function logout()
{
  x = confirm("Möchtest du dich wirklich ausloggen?");
  if(x == true)
  {
    window.location.href="login.php?do=logout";
  }
}
function uhrzeit(showe) {
 Heute = new Date();
 Sekunde = Heute.getSeconds();
 if (Heute.getSeconds() == 0 || showe == "jetzt") {
  Stunde  = Heute.getHours();
  Minute  = Heute.getMinutes();
  document.getElementById("uhr").innerHTML=Stunde+":"+Minute+" Uhr";
 }
}
</script>
<table class="bgt" width="100%" height="*">
  <tr valign="top">
    <td  style="padding-left:5px">
<!-- Start des Inhaltes -->
<?php
$time = time();
if($ud->gesperrt == "1" AND $ud->sptime > $time)
{
  ?>
  <center><table style="border: 1px solid rgb(0, 0, 80);" height="50%" width="50%">  
<tbody><tr bgcolor="#397bc6"><td><font color="snow"><b>Fehler</b></font></td></tr>
	<tr><td align="center">Du wurdest aus diesem Forum ausgeschloßen. Dieses kann mehrere Gründe haben.<br>Deine Sperre läuft bis zum <?php echo date("d.m.Y - h:i", $ud->sptime); ?> </td></tr></tbody></table></center>
	<?
  exit;
}
$config_datas = mysql_query("SELECT * FROM eins_config WHERE erkennungscode LIKE 'f2closefs'");
$cd = mysql_fetch_object($config_datas);
if($cd->zahl1 == "0" AND $ud->adm_recht <= "5")
{?>
  <center><table style="border: 1px solid rgb(0, 0, 80);" height="50%" width="50%">  
<tbody><tr bgcolor="#397bc6"><td><font color="snow"><b>Fehler</b></font></td></tr>
	<tr><td align="center">Dieses Board wurde von einem Administrator geschloßen.<br><br>Grund für die Schließung: <? echo $cd->wert1; ?></td></tr></tbody></table></center>
<?
  exit;
}
?>
<table class="tabelbor" width="100%" height="20%"><tr><td width="70%">
<big><b>&nbsp;<?php echo SITENAME; ?></b><br>&nbsp;<?php echo BESCHREIBUNG; ?></big></td>
<td class="tab1" width="30%" valign="top">

Willkommen, <span style="cursor: pointer;" onclick="window.location.href='profil.php?id=<?php echo $ud->id; ?>'"><?php echo $username; ?></span><?php if($username == "Gast"){?>
<p></p><? } else {
$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2pnsignfs'");
$cd = mysql_fetch_object($config_datas);
pn_zahl("header"); }
?>
<br><br>

</td></tr></table>

<table class="navi" width="100%"><tr width="100%">
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
<? if(GROUP == "3") echo "<td><a href=admin/><b>Administrator-Kontrollzentrum</b></a></td>"; ?>
</tr></table>
<br>
<html>

<head>
<title><?php echo SITENAME;  if($username == "Gast"){ echo " - Gastzugang"; }?></title>
<meta name="generator" content="bigforum <?php echo VERSION; ?>" />
<meta name="description" content="<?php echo SITENAME. " - ". BESCHREIBUNG; 
$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2laengfs'"); $cd = mysql_fetch_object($config_datas);?>" />
<link rel="shortcut icon" href="<?php echo $cd->wert1;?>" type="image/x-icon">
<?php
$ccd = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2usearch2'");
$ccr = mysql_fetch_object($ccd);
if($ccr->zahl2 == "1")
{
?>
<link rel="alternate" type="application/rss+xml" title="<?php echo SITENAME. "- Feed";?>" href="rss.php" />
<?php
}
?>
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
<table class="obenbraun" width=100%><tr><td>
<?php
$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2pnsignfs'");
$cd = mysql_fetch_object($config_datas);
echo "<table width=100%><tr><td><a href=index.php><img src='$cd->wert2' border=0 title='". SITENAME ."' height=70%></a>";
if($username == "Gast" OR USER == ""){?></td><td valign=top align=right>
<table><tr><td class=navioben style="padding: 5px; -moz-border-radius-bottomright:15px; -moz-border-radius-bottomleft:15px;-khtml-border-radius-bottomright:15px;-khtml-border-radius-bottomleft:15px;">
<form action="login.php?do=login" method="post">
<input type="text" name="user" value="Benutzername" style="font-family:Comic;height:18px" onblur="if(this.value=='')this.value='Benutzername'" onfocus="if(this.value=='Benutzername') this.value=''">
<input type="password" name="pw" value="Passwort" onfocus="if(this.value=='Passwort') this.value=''" onblur="if(this.value=='')this.value='Passwort'" style="font-family:Comic;height:18px">
<input type=submit value="Login" style="font-size: 11px;padding: 0px;background-color:#e3d1a5;border:solid 1px black;height:18px;">
</form>
</td></tr></table>
</td><td width=20% valign=top align=left><table width=45%><tr><td align=center valign=top class=navioben style="padding: 5px; -moz-border-radius-bottomright:15px; -moz-border-radius-bottomleft:15px;-khtml-border-radius-bottomright:15px;-khtml-border-radius-bottomleft:15px;">
<a href="reg.php">Registrieren</a> 
</td></tr></table>


<?php
}
 else {
    echo "</td><td valign=top>Hallo ". USER ." (<a href=\"javascript:logout()\">Abmelden</a>)<br>";
	if($ud->darf_pn == "0"){
    echo"<b>Private Nachrichten:</b> ";
    pn_zahl("header");
    }
	$time = time();
    $us_ver = mysql_query("SELECT * FROM user_verwarn WHERE user_id LIKE '$ud->id' AND dauer > '$time'");
    if(mysql_num_rows($us_ver) != "0")
    {
      echo "<br><br><b>Aktive Verwarnungen:</b> ". mysql_num_rows($us_ver) ."";
    }
    echo "</td>";
 } 
 echo "</td></tr></table>";
?>
</td></tr>
<tr><td>
<table width="100%" height="*"><tr width="100%"><td class=navi>
<a href="index.php">Startseite</a>
<?php if(USER == "") { ?>
<a href="login.php">Login</a>
<?php } else { ?>
<a href="member.php">Benutzerliste</a>
<?php } ?>
<a href="search.php">Suche</a>
<?php
$config_data = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2closefs'");
$cd = mysql_fetch_object($config_data);
if($cd->wert2 != "")
{
  $links = $cd->wert2;
  $links = str_replace("||","",$links);
  $links = str_replace("|","",$links);
  echo "$links";
}
?>
</td>
</tr></table>
<div class="littlenavi">
<?php
if(USER != "")
{
  echo "<a href=main.php>Persönlicher Bereich</a> ";
}
?>
<a href=help.php>Hilfe</a> 
<?php
if(GROUP == 3)
{
  echo "<a href=admin/>Administratoren-Kontrollzentrum</a>";
}
?>
</div>
<br>
</td></tr>
</table>
<br>

<table class="bgt" width="100%" height="*">
  <tr valign="top">
    <td  style="padding-left:5px">

<table>
<?php
echo "<table><tr><td><small>";
$da = $_SERVER["SCRIPT_NAME"];
$da = preg_replace ('#\/.*?\/#m' , '' , $da);  
$da =  "/$da";
$da = str_replace("//","/", $da);
if(isset($_GET["id"]))
{
  $id = $_GET["id"];
}
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
  "/help.php"      => "Hilfe",
);
if($da == "/help.php" OR $da == "/reg.php" OR $da == "/login.php" OR $da == "/index.php" OR $da == "/modcp.php" OR $da == "/member.php" OR $da == "/search.php" OR $da == "/main.php" OR $da == "/online.php" OR $da == "/newreply.php" OR $da == "/newtopic.php" Or $da == "/edit.php")
{
  echo "<a href=index.php> ".SITENAME." </a>  > $seite[$da]";
  $status = true;
}
if($da == "/thread.php")
{ 
  $thema_data = mysql_query("SELECT * FROM thema WHERE id LIKE '$id'");
  $td = mysql_fetch_object($thema_data); 
  $forum_data = mysql_query("SELECT * FROM foren WHERE id LIKE '$td->where_forum'");
  $fd = mysql_fetch_object($forum_data);
 
  echo "<a href=index.php> ".SITENAME." </a> > <a href=forum.php?id=$fd->id>$fd->name</a> >  $td->tit";

    $status = true;
}
if($da == "/profil.php")
{ 
  $prof_data = mysql_query("SELECT * FROM users WHERE id LIKE '$id'");
  $pd = mysql_fetch_object($prof_data);
 
  echo "<a href=index.php> ".SITENAME." </a> > <a href=member.php>Mitglieder</a> >  Profil von $pd->username";

    $status = true;
}
if($da == "/forum.php")
{ 
  $forum_data = mysql_query("SELECT * FROM foren WHERE id LIKE '$id'");
  $fd = mysql_fetch_object($forum_data);
  $kat_data = mysql_query("SELECT * FROM kate WHERE id LIKE '$fd->kate'");
  $kd = mysql_fetch_object($kat_data);
  echo "<a href=index.php> ".SITENAME." </a> > <a href=index.php?do=show_one&id=$kd->id>$kd->name</a> > $fd->name";
    $status = true;
}
if($status != true)
{
  echo "<a href=index.php> ".SITENAME." </a>";
}
//Ende
echo "</small></td></tr></table><br>";
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
<?php
if(USER != "" AND $ud->notice != "" AND $ud->notice != "0")
{
  echo "<table class=titl width=100%><tbody><tr><td>
  $ud->notice</td></tr></table><br>";
}
?>  

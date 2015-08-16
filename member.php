<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
login();
page_header();
if($_GET["do"] == "groups")
{
  looking_page("foren_helfer");
  echo "<table width=100%><tr class=normal><td width=2%></td><td style=font-weight:bold width=70%><font color=snow>Administratoren</font></td><td><font color=snow>Kontakt</font></td></tr>";
  $adm_da = mysql_query("SELECT * FROM users WHERE group_id LIKE '3' ORDER BY username");
  while($ad = mysql_fetch_object($adm_da))
  {
    $adm = "3";
    echo "<tr><td>";
	show_online($ad->last_log, $ad->username);
	echo "</td><td><a href=profil.php?id=$ad->id>$ad->username</a></td><td><a href=main.php?do=make_pn&to=$ad->username><img src=images/pn.png border=0 width=60px height=32px title=\"$ad->username eine Private Nachricht schreiben\"></a></td></tr>";
  }
  if($adm != "3")
  {
    echo "<tr><td></td><td>Dieses Board hat keine Administratoren</td></tr>";
  }
  echo "</table>";
  echo "<table width=100%><tr class=normal><td width=2%></td><td style=font-weight:bold width=70%><font color=snow>Moderatoren</font></td><td><font color=snow>Kontakt</font></td></tr>";
  $adm_da = mysql_query("SELECT * FROM users WHERE group_id LIKE '2'");
  while($ad = mysql_fetch_object($adm_da))
  {
    $mod = "2";
    echo "<tr><td>";
	show_online($ad->last_log, $ad->username);	
	echo "</td><td><a href=profil.php?id=$ad->id>$ad->username</a></td><td><a href=main.php?do=make_pn&to=$ad->username><img src=images/pn.png border=0 width=60px height=32px title=\"$ad->username eine Private Nachricht schreiben\"></a></td></tr>";
  }
  if($mod != "2")
  {
    echo "<tr><td></td><td>Dieses Board hat keine Moderatoren</td></tr>";
  }
  echo "</table>";
  page_footer();
}
if($_GET["username"] != "")
{
  check_data($_GET["username"], "3", "Bitte gebe mehr als drei Buchstaben an.", "laenge");
}
$id = $_GET["id"];
$seite = $_GET["page"];
if(!isset($seite) OR $seite == "0")
{
  $seite = 1;
} 
$eps = "10";
$time = time();
$start = $seite * $eps - $eps;
$cou = mysql_query("SELECT * FROM users WHERE sptime < '$time'");
$menge = mysql_num_rows($cou);
$wieviel = $menge / $eps;
$ws = ceil($wieviel);
looking_page("list_member");
$config_wertt = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2usearch2'");
$cont = mysql_fetch_object($config_wertt); 
if($cont->zahl1 == "1")
{
?>
<form action="member.php">
<table width="90%"><tr><td align=right>Benutzernamensuche: <input type=text name=username size=20></td></tr></table>
</form><br>
<?php
}
?>
<table width="100%">
<tr class=dark color=snow>
<td color=snow>
<b><font color="snow">Benutzerliste - Die Benutzer des Forums</font></b>
</td></tr></table><table width="100%" class=bord>
<?php
if($_GET["username"] == "")
{
?>
<tr bgcolor="#E1E4F9" style="font-weight: bold;"><td> # </td><td><a href="?ord=user&page=<?php echo $seite;?>">Benutzername</a></td><td><a href="?ord=posts&page=<?php echo $seite;?>">Beiträge</a></td><td><a href="?ord=reg&page=<?php echo $seite;?>">Registrierungsdatum</a></td><td>Sonstiges</td></tr>
<?php
}
else
{
?>
<tr bgcolor="#E1E4F9" style="font-weight: bold;"><td> # </td><td><a href="?ord=user&page=<?php echo $seite;?>&username=<?php echo $_GET["username"]; ?>">Benutzername</a></td><td><a href="?ord=posts&page=<?php echo $seite;?>&username=<?php echo $_GET["username"]; ?>">Beiträge</a></td><td><a href="?ord=reg&page=<?php echo $seite;?>&username=<?php echo $_GET["username"]; ?>">Registrierungsdatum</a></td><td>Sonstiges</td></tr>

<?php
}
$ord = $_GET["ord"];
$xs = "0";
if($ord == "posts")
{
  $xs = "1";
  $users = mysql_query("SELECT * FROM users WHERE sptime < '$time' AND username LIKE '%$_GET[username]%' ORDER BY posts DESC LIMIT $start, $eps");
}
if($ord == "reg")
{
  $xs = "1";
  $users = mysql_query("SELECT * FROM users WHERE sptime < '$time' AND username LIKE '%$_GET[username]%' ORDER BY reg_dat LIMIT $start, $eps");
}
if($ord == "user")
{
  $xs = "1";
  $users = mysql_query("SELECT * FROM users WHERE sptime < '$time' AND username LIKE '%$_GET[username]%' ORDER BY username LIMIT $start, $eps");
}
if($xs == "0")
{
  $users = mysql_query("SELECT * FROM users WHERE sptime < '$time' AND username LIKE '%$_GET[username]%' ORDER BY id LIMIT $start, $eps");
}
$numbers = "0";
$num = "0";
while($ur = mysql_fetch_object($users))
{
  $datum = date("d.m.Y",$ur->reg_dat);
  $website = "";
  $ten = "0";
  $numbers++;
  $ten = $seite - 1;
  $ten = $ten * 10;
  $number = $numbers + $ten;
  if($ur->website != "")
  {
    $website = "<a href=http://$ur->website target=_blank><img src=images/hp.png border=0 width=60px height=35px></a>";
  }
  $bg;
  if($num == "1")
  {
    $num = "-1";
	$bg = "bgcolor='#F4F4F4'";
  }
  echo "<tr $bg><td> $number </td><td><a href=profil.php?id=$ur->id>$ur->username</a><br><small>";
  show_rang($ur->posts, $ur->rang); 
  echo "</small></td><td>$ur->posts</td><td>$datum</td><td>$website";
  $config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2pnsignfs'");
  $cd = mysql_fetch_object($config_datas);
  if($ur->darf_pn == "0" AND $cd->zahl2 == "1")
  {
    echo "<a href=main.php?do=make_pn&to=$ur->username><img src=images/pn.png border=0 width=60px height=32px alt=\"$ur->username eine Private Nachricht schreiben\"></a>";
  }
  echo "</td></tr>
";
  $bg = "";
  $num++;
}
if($ws > "1")
{
$up = $seite - 1;
$down = $seite + 1;
if($ws == $seite)
{
  $down--;
}
//Welche Seiten sollen angezeigt werden?
$seiten = "0,1,2,3,5,10,25,50,100,150,250,500,750";
$pa = array();
//


$z = explode(",", $seiten);
echo "<table width=80%><tr><td align=right valign=right><table class=navi><tr><td>";
echo "<font color=snow>Seite $seite von $ws &nbsp <a href=?page=$up><</a>";
$wvpe = $wieviel+1;
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
		    echo "  <a href=\"?page=$min\">$min</a> ";
		  }
          echo " <b>$b</b> </font>";
		  if(!in_array($plu,$z) AND $q == "0" AND $ws != $seite)
		  {
		    echo "  <a href=\"?page=$plu\">$plu</a> ";
		  }
        }
        else
        {
		  if($seite != $b)
		  {
            echo "  <a href=\"?page=$b\">$b</a> ";
		  }
        }
	  }
	$q++;
	}
}
echo " <a href=?page=$down>></a></td></tr></table></td></tr></table>"; 
}
?>
</table>
<?
//Wichtige Datein für den Footer
page_footer();
?>
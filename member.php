<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
page_header();
login();
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
    echo "<tr><td></td><td>Dieses Board hat keine Moderatorn</td></tr>";
  }
  echo "</table>";
  page_footer();
}
looking_page("list_member");
?>
<table width="100%">
<tr class=dark color=snow>
<td color=snow>
<b><font color="snow">Benutzerliste - Die Benutzer des Forums</font></b>
</td></tr></table><table width="100%" class=bord>
<tr bgcolor="#E1E4F9" style="font-weight: bold;"><td> # </td><td><a href="?ord=user">Benutzername</a></td><td><a href="?ord=posts">Beiträge</a></td><td><a href="?ord=reg">Registrierungsdatum</a></td><td>Sonstiges</td></tr>
<?php
$ord = $_GET["ord"];
$xs = "0";
$time = time();
if($ord == "posts")
{
  $xs = "1";
  $users = mysql_query("SELECT * FROM users WHERE sptime < '$time' ORDER BY posts DESC");
}
if($ord == "reg")
{
  $xs = "1";
  $users = mysql_query("SELECT * FROM users WHERE sptime < '$time' ORDER BY reg_dat");
}
if($ord == "user")
{
  $xs = "1";
  $users = mysql_query("SELECT * FROM users WHERE sptime < '$time' ORDER BY username");
}
if($xs == "0")
{
  $users = mysql_query("SELECT * FROM users WHERE sptime < '$time' ORDER BY id");
}

$number = "0";
$num = "0";
while($ur = mysql_fetch_object($users))
{
  $datum = date("d.m.Y",$ur->reg_dat);
  $website = "";
  $number++;
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
  echo "<tr $bg><td> $number </td><td><a href=profil.php?id=$ur->id>$ur->username</a><br><small>$ur->rang</small></td><td>$ur->posts</td><td>$datum</td><td>$website <a href=main.php?do=make_pn&to=$ur->username><img src=images/pn.png border=0 width=60px height=32px alt=\"$ur->username eine Private Nachricht schreiben\"></a></td></tr>
";
  $bg = "";
  $num++;
}
?>
</table>
<?
//Wichtige Datein für den Footer
page_footer();
?>
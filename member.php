<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
login();
page_header();
if($_GET["do"] == "groups")
{
  looking_page("foren_helfer");
  echo "<table width=100%><tr bgcolor=#397bc6><td style=font-weight:bold width=70%><font color=snow>Administratoren</font></td><td><font color=snow>Kontakt</font></td></tr>";
  $adm_da = mysql_query("SELECT * FROM eins_users WHERE group_id LIKE '3' ORDER BY username");
  while($ad = mysql_fetch_object($adm_da))
  {
    $adm = "3";
    echo "<tr><td><a href=profil.php?id=$ad->id>$ad->username</a></td><td><a href=main.php?do=make_pn&to=$ad->username><img src=images/pn.png border=0 width=60px height=32px title=\"$ad->username eine Private Nachricht schreiben\"></a></td></tr>";
  }
  if($adm != "3")
  {
    echo "<tr><td>Dieses Board hat keine Administratoren</td></tr>";
  }
  echo "</table>";
  echo "<table width=100%><tr bgcolor=#397bc6><td style=font-weight:bold width=70%><font color=snow>Moderatoren</font></td><td><font color=snow>Kontakt</font></td></tr>";
  $adm_da = mysql_query("SELECT * FROM eins_users WHERE group_id LIKE '2'");
  while($ad = mysql_fetch_object($adm_da))
  {
    $mod = "2";
    echo "<tr><td><a href=profil.php?id=$ad->id>$ad->username</a></td><td><a href=main.php?do=make_pn&to=$ad->username><img src=images/pn.png border=0 width=60px height=32px title=\"$ad->username eine Private Nachricht schreiben\"></a></td></tr>";
  }
  if($mod != "2")
  {
    echo "<tr><td>Dieses Board hat keine Moderatorn</td></tr>";
  }
  echo "</table>";
  page_footer();
}
looking_page("list_member");
?>
<table width="100%">
<tr bgcolor="#000050" color=snow>
<td color=snow>
<b><font color="snow">Benutzerliste - Die Benutzer des Forums</font></b>
</td></tr></table><table width="100%" style="border: 1px solid #000050;">
<tr bgcolor="#E1E4F9" style="font-weight: bold;"><td> # </td><td>Benutzername</td><td>Beiträge</td><td>Registrierungsdatum</td><td>Sonstiges</td></tr>
<?php
$time = time();
$users = mysql_query("SELECT * FROM eins_users WHERE sptime < '$time' ORDER BY id");
$number = "0";
while($ur = mysql_fetch_object($users))
{
  $datum = date("d.m.Y",$ur->reg_dat);
  $website = "";
  $number++;
  if($ur->website != "")
  {
    $website = "<a href=http://$ur->website target=_blank><img src=images/hp.png border=0 width=60px height=35px></a>";
  }
  echo "<tr><td> $number </td><td><a href=profil.php?id=$ur->id>$ur->username</a><br><small>$ur->rang</small></td><td>$ur->posts</td><td>$datum</td><td>$website <a href=main.php?do=make_pn&to=$ur->username><img src=images/pn.png border=0 width=60px height=32px alt=\"$ur->username eine Private Nachricht schreiben\"></a></td></tr>
";
}
?>
</table>
<?
//Wichtige Datein für den Footer
page_footer();
?>
<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
page_header();
$stat_them = "0";
$stat_bei = "0";
$foren_data = mysql_query("SELECT * FROM eins_kate");
  echo "<table width=100% bgcolor=#000050 color=snow><tr font-weight:bold;><td width=70%><font color=snow>Name</font></td><td><font color=snow>Themen</font></td><td><font color=snow>Beiträge</font></td></tr></table>";
while($fr = mysql_fetch_object($foren_data))
{
  echo "<table width=100% bgcolor=#397BC6 color=snow><tr><td><b>$fr->name</b><br>$fr->besch</td></tr></table>";
  $for_date = mysql_query("SELECT * FROM eins_foren WHERE kate = '$fr->id'");
  while($fd = mysql_fetch_object($for_date))
  {
    $look_see = "0";
    $them_dat = mysql_query("SELECT * FROM eins_thema WHERE where_forum LIKE '$fd->id'");
	while($tda = mysql_fetch_object($them_dat))
	{
	  $data = mysql_query("SELECT * FROM eins_read_all WHERE uname LIKE '". USER ."' AND thema_id LIKE '$tda->id'");
      $da = mysql_fetch_object($data);
	  
	  $datas = mysql_query("SELECT * FROM eins_read_all WHERE uname LIKE '". USER ."' AND thema_id LIKE '0' ORDER BY id DESC LIMIT 1");
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
	$config_datas = mysql_query("SELECT * FROM eins_config WHERE erkennungscode LIKE 'f2imgadfs'");
    $cd = mysql_fetch_object($config_datas);
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
    $th_dat = mysql_query("SELECT * FROM eins_thema WHERE where_forum LIKE '$fd->id'");
	while($tda = mysql_fetch_object($th_dat))
	{
	  $zahl_themen++;
	  $bei_dat = mysql_query("SELECT * FROM eins_beitrag WHERE where_forum LIKE '$tda->id'");
	  while($bed = mysql_fetch_object($bei_dat))
	  {
	    $beit++;
	  }
	}
    if($fd->guest_see == "0")
    {
	  $stat_them = $stat_them + $zahl_themen;
	  $stat_bei = $stat_bei + $beit;
      echo "<table width=100% bgcolor=#F2F2E5><tr><td width=70%><table><tr><td> $forum_stat &nbsp; </td><td><a href=forum.php?id=$fd->id><b>$fd->name</b></a><br>$fd->besch</td></tr></table></td><td>$zahl_themen</td><td>$beit</td></tr></table>";
	}
	else
	{
	  if(USER != "")
	  {
	  	$stat_them = $stat_them + $zahl_themen;
		$stat_bei = $stat_bei + $beit;
        echo "<table width=100% bgcolor=#F2F2E5><tr><td width=70%><table><tr><td> $forum_stat &nbsp; </td><td><a href=forum.php?id=$fd->id><b>$fd->name</b></a></b><br>$fd->besch</td></tr></table></td><td>$zahl_themen</td><td>$beit</td></tr></table>";
	  }
	}
  }
}
echo"<table width=100% class=navi><tr><td style=font-weight:bold;><center><a href=?do=marks>Alle Themen als gelesen markieren</a> | <a href=member.php?do=groups>Forum-Team</a></center></td></table><br>";

//Statistiken auf der Startseite
echo "<br><table width=100% bgcolor=#397BC6 color=snow><tr><td><b><a href=online.php><font color=black>Wer ist online?</font></a></b> Angaben der letzten 15 Minuten.</td></tr></table>";
user_online(false);
echo "</td></tr></table><br>";

//Abfragen für die Statistik
$user_dat = mysql_query("SELECT * FROM eins_users WHERE gesperrt = '0'");
$stat_use = mysql_num_rows($user_dat);

$last_use = mysql_query("SELECT * FROM eins_users WHERE gesperrt = '0' ORDER BY id DESC LIMIT 1");
$last_use = mysql_fetch_object($last_use);

echo "<table width=100% bgcolor=#397BC6 color=snow><tr><td><b>Statistiken.</td></tr></table>";
echo "<table width=100% bgcolor=#F2F2E5><tr><td><b>Themen:</b> $stat_them <b>Beitäge:</b> $stat_bei <b>Benutzer:</b> $stat_use<br>Wir begrüßen unser neustes Mitglied: <a href=profil.php?id=$last_use->id>$last_use->username</a></td></tr></table><br>
<center><img src=$cd->wert1 width=40 height=40> <small>Keine neuen Beiträge</small>  &nbsp; &nbsp; <img src=$cd->wert2 width=40 height=40> <small>Neue Beiträge</small></center><br>";
if($_GET["do"] == "marks")
{
  if(USER != "")
  {
    $time = time();
	mysql_query("INSERT INTO eins_read_all (uname, thema_id, when_look) VALUES ('". USER ."', '0', '$time')")or die(mysql_error());
 
  }
  else
  {
    echo "<script>alert('Leider ist diese Funktion im Gast-Zugang nicht möglich. Registriere dich oder logge dich ein!')</script>";
  }
}
//Wichtige Datein für den Footer
looking_page("index");
page_footer();
?>
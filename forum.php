<?php
//Wichtige Angaben f�r jede Datei!
include("includes/functions.php");
page_header();
looking_page("forum-view");
include_once("includes/function_forum.php");
include_once("includes/function_user.php");

//Wichtige MySQL Abfrage, da bei manchen Anbietern ansonsten fehler kommen.
$user_data = mysql_query("SELECT * FROM users WHERE username LIKE '". USER ."'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
$ud = mysql_fetch_object($user_data);

error();
$id = $_GET["id"];
$seite = $_GET["page"];
if(!isset($seite) OR $seite == "0")
{
 $seite = 1;
} 
$topics = "0";
$eps = "10";
$start = $seite * $eps - $eps;  
if($id == "")
{
  erzeuge_error("Dieses Forum exestiert nicht.");
}
if($_GET["do"] == "change")
{
  if($_POST["dw"] == "close")
  {
    $log_dat = mysql_query("SELECT * FROM thema");
    while($ld = mysql_fetch_object($log_dat))
	{
	    if($_POST["$ld->id"] == "1")
		{
	      mysql_query("UPDATE thema SET close = '1' WHERE id LIKE '$ld->id'");
		}
	}
  }
  if($_POST["dw"] == "open")
  {
    $log_dat = mysql_query("SELECT * FROM thema");
    while($ld = mysql_fetch_object($log_dat))
	{
	    if($_POST["$ld->id"] == "1")
		{
	      mysql_query("UPDATE thema SET close = '0' WHERE id LIKE '$ld->id'");
		}
	}
  }
  if($_POST["dw"] == "import")
  {
    $log_dat = mysql_query("SELECT * FROM thema");
    while($ld = mysql_fetch_object($log_dat))
	{
	    if($_POST["$ld->id"] == "1")
		{
	      mysql_query("UPDATE thema SET import = '1' WHERE id LIKE '$ld->id'");
		}
	}
  }
  if($_POST["dw"] == "zusam")
  {
    $log_dat = mysql_query("SELECT * FROM thema");
	$x = "0";
    while($ld = mysql_fetch_object($log_dat))
	{
	    if($_POST["$ld->id"] == "1")
		{
	      $x++;
		}
	}
	if($x != "2")
	{
	  echo "<b>Fehler:</b> Bitte gebe exakt 2 Themen an!";
	  page_footer();
	}
	else
	{
	  $themen_name = array();
	  $log_dat = mysql_query("SELECT * FROM thema");
	  while($ld = mysql_fetch_object($log_dat))
	  {
	    if($_POST["$ld->id"] == "1")
		{
	      $themen_name[] = $ld->id;
		}
	  }
	  $eins = mysql_query("SELECT * FROM thema WHERE id LIKE '$themen_name[0]' LIMIT 1") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
	  $zwei = mysql_query("SELECT * FROM thema WHERE id LIKE '$themen_name[1]' LIMIT 1") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
	  $ein = mysql_fetch_object($eins);
	  $zwe = mysql_fetch_object($zwei);
	  $time = $zwe->post_when;
	  mysql_query("INSERT INTO beitrag (text, where_forum, verfas, post_dat, last_edit_dat, edit_by) VALUES ('$zwe->text', '$ein->id', '$zwe->verfas', '$time', '', '')");
	  mysql_query("DELETE FROM thema WHERE id LIKE '$zwe->id'");
	  echo "Danke, \"$zwe->tit\" wird nun als Beitrag in \"$ein->tit\" angezeigt.";
	  page_footer();
	}
  }
  if($_POST["dw"] == "not_import")
  {
    $log_dat = mysql_query("SELECT * FROM thema");
    while($ld = mysql_fetch_object($log_dat))
	{
	    if($_POST["$ld->id"] == "1")
		{
	      mysql_query("UPDATE thema SET import = '0' WHERE id LIKE '$ld->id'");
		}
	}
  }
}

$for_dat = mysql_query("SELECT * FROM foren WHERE id LIKE '$id'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
$fd = mysql_fetch_object($for_dat);
if($fd->guest_see == "1")
{
  if(USER == "")
  {
    erzeuge_error("Dieses Forum existiert nicht, oder du hast keine Rechte!");
  }
}
if($fd->guest_see == "2")
{
  if(GROUP != 2 AND GROUP != 3)
  {
    erzeuge_error("Dieses Forum existiert nicht, oder du hast keine Rechte!");   
  }
}
if($fd->min_posts != "0")
{
  if(USER != "")
  {
    if($fd->min_posts >= $ud->posts)
    {
      $how = $fd->min_posts - $ud->posts;
      erzeuge_error("Leider hast du nicht gen�gend Beitr�ge. Dir fehlen noch $how Beitr�ge, um Zugriff auf das Forum zu bekommen.");
    }
  }
  else
  {
    erzeuge_error("Dieses Forum existiert nicht, oder du hast keine Rechte!");
  }
}
$them_dat = mysql_query("SELECT * FROM thema WHERE where_forum LIKE '$id' ORDER BY import DESC, last_post_time DESC LIMIT $start, $eps ") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
$them_meng = mysql_query("SELECT id FROM thema WHERE where_forum LIKE '$id'");
$menge = mysql_num_rows($them_meng); 
$wieviel_seiten = $menge / $eps; 
if(GROUP == "2" OR GROUP == "3")
{
?>
<script type="text/javascript">
function feld(x,i)
{
  y = prompt("Bitte Gebe einen neuen Titel ein:",x);
  if(y != "")
  {
    if(y != null)
	{
      window.open("?id=<?php echo $_GET["id"];?>&do=change_title&title="+y+"&idd="+i+"","_self");
	}
  }
}
</script>
<?
}
if($_GET["do"] == "change_title")
{
  if(GROUP == "2" OR GROUP == "3")
  {
    mysql_query("UPDATE thema SET tit = '$_GET[title]' WHERE id LIKE '$_GET[idd]'");
	echo "<script>window.location.href='forum.php?id=$_GET[id]';</script>";
  }
}
if($fd->admin_start_thema == "2")
{
  if(GROUP == "2" OR GROUP == "3")
  {
    echo "<a href=newtopic.php?id=$fd->id><img src=images/newtopic.png border=0 title=\"Neues Thema\" width=105 height=60></a>";
  }
}
else
{
  if($fd->admin_start_thema == "0")
  {
    if(GROUP == "3")
    {
      echo "<a href=newtopic.php?id=$fd->id><img src=images/newtopic.png border=0 title=\"Neues Thema\" width=105 height=60></a>";
    }
  }
  else
  {
    echo "<a href=newtopic.php?id=$fd->id><img src=images/newtopic.png border=0 title=\"Neues Thema\" width=105 height=60></a>";
  }
}

echo "<table width=73% height=10% border=0 cellpadding=6 cellspacing=0><tr class=dark height=10%><td height=10%><font color=snow> <center> <b><big>$fd->name</big> - Themen�bersicht</b> </center> </font></td></tr></table>";

echo "<form method=post action=?id=$id&do=change><table width=73%><tr class=normal style='font-weight:bold;'><td width=3%></td><td width=40% valign=center>Title</td><td width=20% valign=center>Letzter Beitrag</td><td width=10% valign=center>Antworten</td></tr>";

while($thd = mysql_fetch_object($them_dat))
{
  $topics++;
  $answers = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$thd->id'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
  $zahl = mysql_num_rows($answers);
  
  $datas = mysql_query("SELECT * FROM read_all WHERE uname LIKE '". USER ."' AND thema_id LIKE '0' ORDER BY id DESC LIMIT 1") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
  $das = mysql_fetch_object($datas);
  
  $data = mysql_query("SELECT * FROM read_all WHERE uname LIKE '". USER ."' AND thema_id LIKE '$thd->id'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
  $da = mysql_fetch_object($data);
  
  $thd->tit = strip_tags($thd->tit);
  
  if($da->when_look == "")
  {
     $da->when_look = "0";
  }
  if($thd->import == "1")
  {
    $wich = "Wichtig:";
  }
  else
  {
    $wich = "";
  }
  if($thd->close == "1")
  {
    $close = "<img src=images/th_close.png title='Thema ist geschlossen' width=80% height=80%>";
  }
  else
  {
    $close = "<img src=images/th_open.png title='Thema ist ge�ffnet' width=80% height=80%>";
  }
  if(GROUP > 2 AND GROUP != "4")
  {
    $span = "<span id='$thd->id' ondblclick=\"now('$thd->tit')\">";
	$spane = "</span>";
  }  
  else
  {
    $span = "";
	$spane = ""; 
  }
  $verfas_dat = mysql_query("SELECT * FROM users WHERE username LIKE '$thd->verfas'");
  $vd = mysql_fetch_object($verfas_dat);
  
  $anz = mysql_query("SELECT * FROM thema WHERE where_forum LIKE '$id'");
  //  $anz = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$thd->id'");
  $anza = mysql_num_rows($anz);
  $rech = ceil($anza/10);
  $menge = $anza;
  $wieviel = $anza / $eps;
  $ws = $rech;
  
  $anzzz = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$thd->id'");
  $anzazz = mysql_num_rows($anzzz);
  $rechnung = ceil($anzazz/10);
  if($rechnung == "0")
  {
    $rechnung = "1";
  }
  $last_beitr = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$thd->id' ORDER BY post_dat DESC LIMIT 1")or die(mysql_error());
  $lb = mysql_fetch_object($last_beitr);
  if($lb->post_dat != "")
  {
    $time_last = date("d.m.Y - H:i", $lb->post_dat);
    $last_answer = "$time_last<br><small>von $lb->verfas</small>";
  }
  else
  {
    $time_last = date("d.m.Y - H:i", $thd->post_when);
    $last_answer = "$time_last<br><small>von $thd->verfas</small>"; 
  }
  if(GROUP == 2 OR GROUP == 3)
  {
    $checkd = "<td><input type=checkbox name=$thd->id value=1></td>";
  }
  
  if($da->when_look < $thd->last_post_time AND $das->when_look < $thd->last_post_time)
  {
    echo "<tr><td width=3%><span id=text ondblclick=\"feld('$thd->tit','$thd->id')\">$close</span></td><td width=50%><b><span id=text ondblclick=\"feld('$thd->tit','$thd->id')\">$wich <a href=thread.php?id=$thd->id&page=$rechnung>$thd->tit</a></span></b><br><span style=\"cursor: pointer;\" onclick=\"window.location.href='profil.php?id=$vd->id'\"><small>$thd->verfas</small></span></td><td width=20%>$last_answer</td><td width=10%>$zahl</td><td align=left>$checkd</td></tr>";
  }
  else
    echo "<tr><td width=3%><span id=text ondblclick=\"feld('$thd->tit','$thd->id')\">$close</span></td><td width=50%><span id=text ondblclick=\"feld('$thd->tit','$thd->id')\">$wich <a href=thread.php?id=$thd->id&page=$rechnung>$thd->tit</a></span><br><span style=\"cursor: pointer;\" onclick=\"window.location.href='profil.php?id=$vd->id'\"><small>$thd->verfas</small></span></td><td width=20%>$last_answer</td><td width=10%>$zahl</td><td align=left>$checkd</td></tr>";
}
echo "</table>";
if($topics == "0")
{
  echo "<br><br><br><br><br><br><table><tr><td></td><td><b>Information:</b> In diesem Forum gibt es noch keine Themen. Du kannst der erste sein!</td></tr></table><br><br><br><br><br><br>";
}
if((GROUP == 2 OR GROUP == 3) AND $topics > 0)
{
  echo "<table width=64%><tr><td align=right valign=right><b>Auswahl:</b><select name=dw onchange=submit()><option></option><option value=close>Schlie�en</option><option value=open>�ffnen</option><option value=import>Als Wichtig makieren</option><option value=not_import>Als unwichtig makieren</option><option value=zusam>Themen zusammenlegen</option></td></tr></table></form>";
}
$ws = ceil($wieviel_seiten);

if($ws > "1")
{$up = $seite - 1;
$down = $seite + 1;
if($ws == $seite)
{
  $down--;
}
//Welche Seiten sollen angezeigt werden?
$seiten = "0,1,2,3,5,10,25,50,100,150,250,500,750";
$pa = array();
//


echo "<table width=73%><tr><td align=right valign=right><table class=navi><tr><td>";
echo "<font color=snow>Seite $seite von $ws &nbsp <a href=?id=$_GET[id]&page=$up><</a>";
$z = explode(",", $seiten);
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
		    echo "  <a href=\"?id=$_GET[id]&page=$min\">$min</a> ";
		  }
          echo " <b>$b</b> </font>";
		  if(!in_array($plu,$z) AND $q == "0")
		  {
		      echo $plu;
		      echo "  <a href=\"?id=$_GET[id]&page=$plu\">$plu</a> ";
		  }
        }
        else
        {
		  if($seite != $b)
		  {
            echo "  <a href=\"?id=$_GET[id]&page=$b\">$b</a> ";
		  }
        }
	  }
	$q++;
	}
}
echo " <a href=?id=$_GET[id]&page=$down>></a></td></tr></table></td></tr></table>"; 
}
if($fd->admin_start_thema == "2")
{
  if(GROUP == "2" OR GROUP == "3")
  {
    echo "<a href=newtopic.php?id=$fd->id><img src=images/newtopic.png border=0 title=\"Neues Thema\" width=105 height=60></a>";
  }
}
else
{
  if($fd->admin_start_thema == "0")
  {
    if(GROUP == "3")
    {
      echo "<a href=newtopic.php?id=$fd->id><img src=images/newtopic.png border=0 title=\"Neues Thema\" width=105 height=60></a>";
    }
  }
  else
  {
    echo "<a href=newtopic.php?id=$fd->id><img src=images/newtopic.png border=0 title=\"Neues Thema\" width=105 height=60></a>";
  }
}

//Wichtige Datein f�r den Footer
page_footer();
?>
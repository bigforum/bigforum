<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
page_header();
looking_page("readthema");
include("includes/function_forum.php");
include_once("includes/function_user.php");

//Wichtige MySQL Abfrage, da bei manchen Anbietern ansonsten Fehler kommen.
$user_data = mysql_query("SELECT * FROM users WHERE username LIKE '". USER ."'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
$ud = mysql_fetch_object($user_data);


$id = $_GET["id"];
$seite = $_GET["page"];
if(!isset($seite) OR $seite == "0")
{
  $seite = 1;
} 
$eps = "10";

$start = $seite * $eps - $eps;

if(GROUP == "2" OR GROUP == "3")
{
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


function anzeigen(das) {
 if (document.getElementById(das).style.display=='none') {
  document.getElementById(das).style.display='block';
  document.getElementById("anzeige"+das).style.display='none';
 }
 else {
  document.getElementById(das).style.display='none';
  document.getElementById("anzeige"+das).style.display='block';
 }
}

 
function del(id) {
d = confirm("Möchtest du diesen Beitrag wirklich löschen?");
if(d == true)
{
  xmlhttp.open("GET", 'thread.php?do=del&bid='+id);
  document.getElementById(id).innerHTML = "";
  alert("Der Beitrag wurde gelöscht!");
}
xmlhttp.send(null);
}

</script>

<?php
}
if($_GET["do"] == "del_post")
{
	  echo "<fieldset>
	  <legend>Beitrag löschen</legend>
	  Möchtest du den Beitrag wirklich löschen?<br>
	  <form action=?id=$_GET[id]&do=del&bid=$_GET[bid] method=post>
	  <input type=radio name=del value=1 checked>Beitrag wiederherstellbar löschen";
	  if(GROUP == 3)
	  {
	    echo "<br><input type=radio name=del value=2>Beitrag endgültig löschen";
	  }
	  echo "<br><input type=submit value='Beitrag löschen'></form>
	  </fieldset>";
	  page_footer();
}
if($_GET["do"] == "del")
{
  $beitrag_data = mysql_query("SELECT * FROM beitrag WHERE id LIKE '$_GET[bid]'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));
  $bed = mysql_fetch_object($beitrag_data);
  $thema_data = mysql_query("SELECT * FROM thema WHERE id LIKE '$id'");
  $td = mysql_fetch_object($thema_data);  
  $forum_data = mysql_query("SELECT * FROM foren WHERE id LIKE '$td->where_forum'");
  $fd = mysql_fetch_object($forum_data);
  if($fd->beitrag_plus == "0")
  {
    mysql_query("UPDATE users SET posts = posts-1 WHERE username LIKE '$bed->verfas'");
  }
  if($_POST["del"] == "1")
  {
    mysql_query("UPDATE beitrag SET dele = '" . USER . "' WHERE id LIKE '$_GET[bid]'");
  }
  if($_POST["del"] == "2")
  {
    mysql_query("DELETE FROM beitrag WHERE id LIKE '$_GET[bid]'");
  }
}
if($id != "")
{
  $time = time();
  if(USER != "")
  {
    $data = mysql_query("SELECT * FROM read_all WHERE uname LIKE '". USER ."' AND thema_id LIKE '$id'") or die(mysql_fehler(mysql_error(), __LINE__, $_SERVER["PHP_SELF"]));;
	$da = mysql_fetch_object($data);
	if($da->id == "")
	{
      mysql_query("INSERT INTO read_all (uname, thema_id, when_look) VALUES ('". USER ."', '$id', '$time')")or die(mysql_error());
    }
	else{
	mysql_query("UPDATE read_all SET when_look = '$time' WHERE id LIKE '$da->id'");
	}
  }
  if($_GET["do"] == "resbeitrag")
  {
    mysql_query("UPDATE beitrag SET dele = '' WHERE id LIKE '$_GET[bid]'");
	$poster_beitrag = mysql_query("SELECT * FROM beitrag WHERE id LIKE '$_GET[bid]'");
	$pb = mysql_fetch_object($poster_beitrag);
    $thema_data = mysql_query("SELECT * FROM thema WHERE id LIKE '$id'");
    $td = mysql_fetch_object($thema_data);  
    $forum_data = mysql_query("SELECT * FROM foren WHERE id LIKE '$td->where_forum'");
    $fd = mysql_fetch_object($forum_data);
    if($fd->beitrag_plus == "0")
    {
	  mysql_query("UPDATE users SET posts = posts+1 WHERE username LIKE '$pb->verfas'");
    }
  }	
  $thema_data = mysql_query("SELECT * FROM thema WHERE id LIKE '$id'");
  $td = mysql_fetch_object($thema_data);  
  if($td->text == "" AND $td->tit == "")
  {
    erzeuge_error("Dieses Thema exestiert nicht.<br> Solltest du einem Link gefolgt sein, so wende dich bitte an den Administrator.");
  }

  
  if($_GET["do"] == "change")
  {
    if($_GET["action"] == "schob")
	{
	  mysql_query("UPDATE thema SET where_forum = '$_POST[schob]' WHERE id LIKE '$id'");
	  echo "<script>alert('Das Thema wurde verschoben.')</script>";
      $thema_data = mysql_query("SELECT * FROM thema WHERE id LIKE '$id'");
      $td = mysql_fetch_object($thema_data);  
  	}
	if($_GET["action"] == "del")
	{
		mysql_query("UPDATE thema SET dele = '". USER . "' WHERE id LIKE '$id'");
		mysql_query("UPDATE beitrag SET dele = '". USER . "' WHERE where_forum LIKE '$id'");
	  	echo "<script>alert('Das Thema wurde gelöscht! Du wirst zur Forenübersicht weitergeleitet...'); location.href='forum.php?id=$td->where_forum';</script>";
		page_footer();
	}
	if($_GET["action"] == "del_end" AND GROUP == "3")
	{
	
		mysql_query("DELETE FROM thema WHERE id LIKE '$id'");
		mysql_query("DELETE FROM beitrag WHERE where_forum LIKE '$id'");
	  	echo "<script>alert('Das Thema wurde endgültig gelöscht! Du wirst zur Forenübersicht weitergeleitet...'); location.href='forum.php?id=$td->where_forum';</script>";
		page_footer();
	}
    if($_POST["fu"] == "schieb")
	{
	  echo "<fieldset>
	  <legend>Thema verschieben</legend>
	  Bitte wähle ein Forum aus, in welches du das Thema '$td->tit' verschieben möchtest.<br>
	  <form action=?id=$_GET[id]&do=change&action=schob method=post><select name=schob>";
	  $for_dat = mysql_query("SELECT * FROM foren ORDER BY kate");
	  while($fod = mysql_fetch_object($for_dat))
	  {
	    echo "<option value=$fod->id>$fod->name</option>";
	  }
	  echo "</select><input type=submit value='Thema verschieben'></form>
	  </fieldset>";
	  page_footer();
	}
    if($_POST["fu"] == "close")
    {
	  if($td->close == "0")
	  {
	    mysql_query("UPDATE thema SET close = '1' WHERE id LIKE '$id'");
        echo "<script>alert('Thema ist geschlossen')</script>";
	  }
	  else
	  {
	    echo "<script>alert('Thema ist bereits geschlossen')</script>";
	  }
    }
	if($_POST["fu"] == "marknew")
    {
	  $time = time();
	  mysql_query("UPDATE thema SET last_post_time = '$time' WHERE id LIKE '$id'");
	  echo "<script>alert('Das Thema wurde als \'Noch nicht gelesen\' gekenntzeichnet.')</script>";
    }
	if($_POST["fu"] == "open")
	{
	  if($td->close == "1")
	  {
	    mysql_query("UPDATE thema SET close = '0' WHERE id LIKE '$id'");
	  	echo "<script>alert('Thema wurde wieder geöffnet.')</script>";
	  }
	  else
	  {
	    echo "<script>alert('Thema ist bereits offen.')</script>";
	  }
	}
	if($_POST["fu"] == "delete")
	{
	  echo "<fieldset><legend>Thema löschen</legend>Möchtest du wirklich dieses Thema und alle Beiträge löschen?<br><br>
      <a href=?id=$id&do=change&action=del>Ja, Thema und alle Beiträge löschen</a>  &nbsp;&nbsp;&nbsp;   <a href=?id=$id>Nein, Thema auf keinen Fall löschen</a></fieldset><br><br>";
	  if(GROUP == "3")
	  {
   	    echo "<fieldset><legend>Thema endgültig löschen</legend>Möchtest du wirklich dieses Thema und alle Beiträge <b>endgültig</b> löschen?<br><br>
        <a href=?id=$id&do=change&action=del_end>Ja, Thema und alle Beiträge endgültig löschen</a></fieldset><br><br>";
	  }
 
	  page_footer();
	}
	if($_POST["fu"] == "wich")
	{
	  if($td->import != "0")
	  {
	    echo "<script>alert('Das Thema wurde bereits als wichtig makiert, die Makierung wurde nun aufgehoben.')</script>";	 
	    mysql_query("UPDATE thema SET import = '0' WHERE id LIKE '$id'");		
	  }
	  else
	  {
	    mysql_query("UPDATE thema SET import = '1' WHERE id LIKE '$id'");
	    echo "<script>alert('Das Thema wurde als wichtig makiert!')</script>";
	  }
	}
  }
  
  
$forum_data = mysql_query("SELECT * FROM foren WHERE id LIKE '$td->where_forum'");
$fd = mysql_fetch_object($forum_data);
if($ud->posts == "")
{
  $ud->posts = "0";
}
if($fd->min_posts > $ud->posts)
{
  erzeuge_error("Du hast keine Berechtigungen auf dieses Thema. Dies kann mehrere Gründe haben.");
}


if($fd->guest_see == "1")
{
  if(USER == "")
  {
    erzeuge_error("Entweder du hast keine Rechte dieses Forum zu sehen, oder das Forum ist gelöscht.");
  }
}
if($td->dele != "" AND GROUP != "2" AND GROUP != "3")
{
  erzeuge_error("Entweder du hast keine Rechte dieses Forum zu sehen, oder das Forum ist gelöscht.");
}
if($fd->guest_see == "2" AND (GROUP != 2 AND GROUP != 3))
{
  erzeuge_error("Entweder du hast keine Rechte dieses Forum zu sehen, oder das Forum ist gelöscht.");
}
$cou = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$id'");
$menge = mysql_num_rows($cou);
$wieviel = $menge / $eps;
$ws = ceil($wieviel);
$modffunk = "";
if(GROUP == "2" OR GROUP == "3" OR USER == $td->verfas)
{
  $modffunk = "<td></td>";
}
//Folgender Code wurde rausgenommen, da dieses mit der Version 4.0 eh wegfällt.
/*echo "<table class=titl width=100%><tr><td><table><tr><td>Du bist hier:</td><td><a href='index.php'>". SITENAME ."</a> > <a href='forum.php?id=$fd->id'>$fd->name</a></td></tr><tr><td></td><td><big><b>$td->tit</b></big></td></tr></table></td></tr></table><br>";*/
if($td->dele == "")
  answer_button($fd->user_posts, GROUP, $id, $td->close);
if($ws > "1")
{
$up = $seite - 1;
$down = $seite + 1;
if($ws == $seite)
{
  $down--;
}
echo "<table width=80%><tr>$modffunk<td align=right valign=right><table class=seiten_navi><tr><td>";
echo "<font color=snow>Seite $seite von $ws &nbsp <a href=?id=$_GET[id]&page=$up><</a>";
//Welche Seiten sollen angezeigt werden?
$seiten = "0,1,2,3,5,10,25,50,100,150,250,500,750";
$pa = array();
//


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
		  if(!in_array($plu,$z) AND $q == "0" AND $ws != $seite)
		  {
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
echo " <a href=?id=$_GET[id]&page=$down>></a></td></tr></table></td></tr>"; 
}
if($td->edit_from != "")
{
  $now = date("d.m.Y", time());
  $datum = date("d.m.Y",$td->last_edit);
  $uhrzeit = date("H:i",$td->last_edit);
  if($now == $datum)
  {
    $datum = "Heute um";
  }
  else{
    $datum = $datum.",";
  }
  $edit = " &nbsp; &nbsp; &nbsp;Zuletzt bearbeitet von $td->edit_from ($datum $uhrzeit)";
}
    $datum = date("d.m.Y",$td->post_when);
    $uhrzeit = date("H:i",$td->post_when);
if($seite <= "1")
{
  if($ws <= "1")
    echo "<table width=80% class=dark>";
  $modfunk = "";
  if(GROUP == "2" OR GROUP == "3" OR USER == $td->verfas)
  {
    if($td->dele == "")
	{
      $modfunk = "<td align=right valign=right class=dark><a href=thredit.php?id=$td->id><img src='images/edit.png' width=13% height=6% border=0 /></a></td>";
	}
  }
  echo "<tr class=dark><td><font color=snow><b>$datum, $uhrzeit</b> $edit</font></td>$modfunk</tr></table>";
  text_ausgabe($td->text, $td->tit, $td->verfas);
}

$bei_dat = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$id' ORDER BY post_dat LIMIT $start, $eps");
while($bd = mysql_fetch_object($bei_dat))
{
  if(($bd->dele != "" AND GROUP > 1 AND GROUP < 4) OR $bd->dele == "")
  {
    $edit = "";
    if($bd->edit_by != "")
    {
     $now = date("d.m.Y", time());
     $datum = date("d.m.Y",$bd->last_edit_dat);
     $uhrzeit = date("H:i",$bd->last_edit_dat);
      if($now == $datum)
      {
        $datum = "Heute um";
      }
      else{
        $datum = $datum.",";
      }
      $edit = " &nbsp; &nbsp; &nbsp;Zuletzt bearbeitet von $bd->edit_by ($datum $uhrzeit)";
    }
    $datum = date("d.m.Y",$bd->post_dat);
    $uhrzeit = date("H:i",$bd->post_dat);
    $mod_funk = "";
    if(GROUP == "2" OR GROUP == "3" OR USER == $bd->verfas)
    {
      if($td->dele == "" AND $bd->dele == "")
      {
        $mod_funk = "<td align=right valign=right><a href=edit.php?id=$bd->id><img src=images/edit.png width=30% height=50% border=0></a><a href=?id=$_GET[id]&do=del_post&bid=$bd->id><img src=images/del.png width=30% height=50% border=0></a></td>";
      }
    }
	if($bd->dele != "")
	{
	  $edit = "</td><td align=right><font color=snow>(<a href=\"javascript:anzeigen('text_$bd->id');\"><font color=snow>Anzeigen</font></a>) (<a href=\"?id=$_GET[id]&do=resbeitrag&bid=$bd->id\"><font color=snow>Wiederherstellen</font></a>)</font>";
	}
    echo "<br><span id='$bd->id'><table width=80% height=10%><tr class=dark><td><table width=100% height=100%><tr><td width=75%><font color=snow><b>$datum, $uhrzeit</b> $edit</font></td>$mod_funk</tr></table></td></tr></table>";
     echo "<a name=$bd->id>";
	 if($bd->dele != "")
	 {
	   $verfas_data = mysql_query("SELECT * FROM users WHERE username LIKE '$bd->verfas'");
	   $vd = mysql_fetch_object($verfas_data);
	   if($vd->id != "")
	   {
	     $verfasser = "<a href=profil.php?id=$vd->id>$bd->verfas</a>";
	   }
	   else
	   {
	     $verfasser = $bd->verfas;
	   }
	   echo "<div style='display: block;' id='anzeigetext_$bd->id'><table border=1 width=80% class=post><tr><td>$verfasser<br>Gelöscht von $bd->dele</td></tr></table></div>";
	   echo "<div style='display: none;' id='text_$bd->id'>";
	 }
     text_ausgabe($bd->text, $td->tit, $bd->verfas);
	 if($bd->dele != "")
	   echo "</div>";
     echo "</span></a>";
  }
}
if($ws > "1")
{
echo "<table width=80%><tr><td align=right valign=right><table class=seiten_navi><tr><td>";
echo "<font color=snow>Seite $seite von $ws &nbsp <a href=?id=$_GET[id]&page=$up><</a>";
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
		    echo "  <a href=\"?id=$_GET[id]&page=$min\">$min</a> ";
		  }
          echo " <b>$b</b> </font>";
		  if(!in_array($plu,$z) AND $q == "0" AND $ws != $seite)
		  {
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
if($td->dele == "")
  answer_button($fd->user_posts, GROUP, $id, $td->close);


}
else
{
  forum_error("Dieses Thema existiert nicht");
}
page_footer();
?>
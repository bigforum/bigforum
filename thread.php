<?php
//Wichtige Angaben für jede Datei!
include("includes/functions.php");
page_header();
looking_page("readthema");
include("includes/function_forum.php");
include("includes/function_user.php");
$id = $_GET["id"];
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

 
 
 
function del(id) {
d = confirm("Möchtest du diesen Beitrag wirklich löschen? Dieser Schritt ist nichtmehr rückgänigmachbar!");
if(d == true)
{
  xmlhttp.open("GET", 'thread.php?do=del&bid='+id);
  alert("Der Beitrag wurde gelöscht!");
}
xmlhttp.send(null);
}

</script>

<?
}
if($_GET["do"] == "del")
{
  mysql_query("DELETE FROM eins_beitrag WHERE id LIKE '$_GET[bid]'");
}
if($id != "")
{
  $time = time();
  if(USER != "")
  {
    $data = mysql_query("SELECT * FROM eins_read_all WHERE uname LIKE '". USER ."' AND thema_id LIKE '$id'");
	$da = mysql_fetch_object($data);
	if($da->id == "")
	{
      mysql_query("INSERT INTO eins_read_all (uname, thema_id, when_look) VALUES ('". USER ."', '$id', '$time')")or die(mysql_error());
    }
	else{
	mysql_query("UPDATE eins_read_all SET when_look = '$time' WHERE id LIKE '$da->id'");
	}
  }

  $thema_data = mysql_query("SELECT * FROM eins_thema WHERE id LIKE '$id'");
  $td = mysql_fetch_object($thema_data);
  $forum_data = mysql_query("SELECT * FROM eins_foren WHERE id LIKE '$td->where_forum'");
  $fd = mysql_fetch_object($forum_data);
  
  
  if($_GET["do"] == "change")
  {
    if($_POST["fu"] == "close")
    {
	  if($td->close == "0")
	  {
	    mysql_query("UPDATE eins_thema SET close = '1' WHERE id LIKE '$id'");
        echo "<script>alert('Thema ist geschloßen')</script>";
	  }
	  else
	  {
	    echo "<script>alert('Thema ist bereits geschloßen')</script>";
	  }
    }
	if($_POST["fu"] == "open")
	{
	  if($td->close == "1")
	  {
	    mysql_query("UPDATE eins_thema SET close = '0' WHERE id LIKE '$id'");
	  	echo "<script>alert('Thema wurde wieder geöffnet.')</script>";
	  }
	  else
	  {
	    echo "<script>alert('Thema ist bereits offen.')</script>";
	  }
	}
	if($_POST["fu"] == "delete")
	{
	  if($ud->group_id == "3")
	  {
	    mysql_query("DELETE FROM eins_thema WHERE id LIKE '$id'");
	  	echo "<script>alert('Das Thema wurde gelöscht! Du wirst zur Forenübersicht weitergeleitet...'); location.href='forum.php?id=$td->where_forum';</script>";
	  }
	  else
	  {
	    echo "<script>alert('Nur ein Administrator kann ein Thema löschen!')</script>";
	  }
	}
	if($_POST["fu"] == "wich")
	{
	  if($td->import != "0")
	  {
	    echo "<script>alert('Das Thema wurde bereits als wichtig makiert!')</script>";	  
	  }
	  else
	  {
	    mysql_query("UPDATE eins_thema SET import = '1' WHERE id LIKE '$id'");
	    echo "<script>alert('Das Thema wurde als wichtig makiert!')</script>";
	  }
	}
  }
  
  
answer_button($fd->user_posts, $ud->group_id, $id, $td->close);
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
echo "<table width=80%><tr bgcolor=#000050><td><font color=snow><b>$datum, $uhrzeit</b> $edit</font></td></tr></table>";
text_ausgabe($td->text, $td->tit, $td->verfas);

$bei_dat = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$id'");
while($bd = mysql_fetch_object($bei_dat))
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
if(GROUP == "2" OR GROUP == "3")
{
  $mod_funk = "<td align=right valign=right><a href=javascript:del($bd->id)><img src=images/del.png width=15% height=0% border=0></a></td>";
}
echo "<br><table bgcolor=#000050 width=80%><tr><td><table width=100%><tr bgcolor=#000050><td><font color=snow><b>$datum, $uhrzeit</b> $edit</font></td>$mod_funk</tr></table></td></tr></table>";
echo "<a name=$bd->id>";
text_ausgabe($bd->text, $td->tit, $bd->verfas);
echo "</a>";
}

answer_button($fd->user_posts, $ud->group_id, $id, $td->close);


}
else
{
  forum_error("Dieses Thema exestiert nicht");
}
page_footer();
?>
<?php
function can_view_admincp()
{
  if(GROUP != "3")
  {
    echo "<center>Hallo ". USER .",<br>du hast leider <b>keine</b> Berechtigungen das Administrator-Kontrollzentrum zu benutzen.";
    exit;
  }
}
function page_header()
{
  config("f2name2", true, "function_define");
  include("includes/function_user.php");
  include("style/header.php");   
}
function page_close_table()
{
  echo "</td></tr></table>";
  page_footer();
}
function page_footer()
{
  include("style/footer.php");
  exit;
}
function check_text()
{
  $text = preg_replace('/\[b\](.*?)\[\/b\]/', '<b>$1</b>', $text);  
  $text = preg_replace('/\[k\](.*?)\[\/k\]/', '<i>$1</i>', $text);  
  $text = preg_replace('/\[u\](.*?)\[\/u\]/', '<u>$1</u>', $text);  
  $text = eregi_replace("\[url\]([^\[]+)\[/url\]","<a href=\"\\1\" target=\"_blank\">\\1</a>",$text);
  $text = str_replace("\n", "<br />", $text);
  $text = strip_tags($text);
}
function editor($di, $value, $extra)
{
if($di == "ant" OR $di == "sign")
{
  echo "
  <script>
  function smilie(sm)
  {
    document.feld.feld.value += sm
  }
  </script>
<form action=$extra&aktion=send method=post name=feld>";
if($di == "ant")
{
  echo "Betreff:<br>
  <input type=text name=bet><br><br>
  Nachricht:";
}
echo "<table bgcolor=silver><tr><td>
<input type=button style='background-color:silver;font-weight:bold' value=b onclick=\"document.feld.feld.value += '[b][/b]'\"><input type=button style=\"background-color:silver;text-decoration:underline\" value=u onclick=\"document.feld.feld.value += '[u][/u]'\"><input type=button style=\"background-color:silver;font-style:italic\" value=k onclick=\"document.feld.feld.value += '[k][/k]'\">
<input type=button style='background-color:silver;' value=Link onclick=\"document.feld.feld.value += '[url][/url]'\"><input type=button style='background-color:silver;' value=Code onclick=\"document.feld.feld.value += '[code][/code]'\"><input type=button style='background-color:silver;' value=Bild onclick=\"document.feld.feld.value += '[img][/img]'\"><br>
<textarea cols=70 rows=7 name=feld>";
if($di == "sign")
{
  echo $value;
}
echo "</textarea><br>
<input type=submit value=Absenden style=background-color:silver;></td><td valign=top><br>";
$drei = "0";
$config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2laengfs'");
$con = mysql_fetch_object($config_wert); 
$smilie_data = mysql_query("SELECT * FROM smilie WHERE packet = '$con->zahl2'");
while($sd = mysql_fetch_object($smilie_data))
{
  $drei++;
  echo "<a href=javascript:smilie('$sd->abk1')><img src=images/$sd->images_path width=25 height=25 border=0></a>";
  if($drei == "3")
  {
    $drei = "0";
	echo "<br>";
  }
}
echo "<br>
</td></tr></table>";
}
if($di == "pn")
{
if($extra != "")
{
  $extra = str_replace("_", " ", $extra);
  $extra = "AW: ". $extra;
}
  echo "
<form action=?do=make_pn&aktion=change method=post name=feld>
An:<br>
<input type=text name=to value='$value'><br><br>
Betreff:<br>
<input type=text name=bet value='$extra'><br><br>
Nachricht:
<table bgcolor=silver><tr><td>
<input type=button style='background-color:silver;font-weight:bold' value=b onclick=\"document.feld.feld.value += '[b][/b]'\"><input type=button style=\"background-color:silver;text-decoration:underline\" value=u onclick=\"document.feld.feld.value += '[u][/u]'\"><input type=button style=\"background-color:silver;font-style:italic\" value=k onclick=\"document.feld.feld.value += '[k][/k]'\">
<input type=button style='background-color:silver;' value=Link onclick=\"document.feld.feld.value += '[url][/url]'\"><input type=button style='background-color:silver;' value=Code onclick=\"document.feld.feld.value += '[code][/code]'\"><input type=button style='background-color:silver;' value=Bild onclick=\"document.feld.feld.value += '[img][/img]'\"><br>
<textarea cols=70 rows=7 name=feld></textarea><br>
<input type=submit value=Absenden style=background-color:silver;>
</tr></td></table>";
}
}
function mysqlVersion() {
    
    $sql = 'SELECT VERSION( ) AS versionsinfo';

    $result = @mysql_query($sql);

    $version = @mysql_result( $result, 0, "versionsinfo" );
    
    
    echo $version;

    return $vers;

} 
function user_online($anz)
{
$time_as_useris_online = "900";
$dtime = time() - $time_as_useris_online;
$x = "0";
$anzahl = "0";
$online_data = mysql_query("SELECT * FROM users WHERE last_log > '$dtime' ORDER BY username");
echo "<table width=100% bgcolor=#F2F2E5><tr><td>";
while($ond = mysql_fetch_object($online_data))
{
 $link = "profil.php?id=$ond->id";
  if($anz == true)
  {
  $link = "?do=ver_user&name=$ond->username";
  } 
 $anzahl++;
 $x++;
 if($x != "1")
 {
   echo ", ";
 }
 echo "<a href=$link>$ond->username</a>";
 if($anz == true)
 {
   echo " (". date("H:i", $ond->last_log) .")";
 }
}
if($anz == true)
{
  echo "<br>Benutzer online: $anzahl";
}
}
function looking_page($wo)
{
  if($wo == "index")
  {
    $page = "index.php";
	$text = "Betrachtet die Forenübersicht";
  }
  if($wo == "profil")
  {
    $page = "profil.php";
	$text = "Betrachtet ein Benutzerprofil";
  }
  if($wo == "main")
  {
    $page = "main.php";
	$text = "Befindet sich im Persönlichem Bereich";
  }
  if($wo == "list_member")
  {
    $page = "member.php";
	$text = "Betrachtet die Liste der Benutzer";
  }
    if($wo == "create_pn")
  {
    $page = "main.php";
	$text = "Erstellt eine Private Nachricht";
  }
  if($wo == "read_pn")
  {
    $page = "main.php";
	$text = "Ließt eine Private Nachricht";
  }
  if($wo == "look_pn")
  {
    $page = "member.php";
	$text = "Betrachtet die Privaten Nachrichten";
  }
  if($wo == "forum-view")
  {
    $page = "forum.php";
	$text = "Betrachtet ein Forum";
  }
  if($wo == "newtopic")
  {
    $page = "newtopic.php";
	$text = "Erstellt ein Thema";
  }
  if($wo == "readthema")
  {
    $page = "thread.php";
	$text = "Betrachtet ein Thema";
  }
  if($wo == "newreply")
  {
    $page = "newreply.php";
	$text = "Erstellt einen Beitrag";
  }
  if($wo == "foren_helfer")
  {
    $page = "member.php";
	$text = "Betrachtet die Liste der Foren-Mitarbeiter";
  }
  if($wo == "admin_mel")
  {
    $page = "admin/";
	$text = "Meldet sich im Administrator-Kontrollzentrum an";
  }
  if($wo == "admin_mel")
  {
    $page = "search.php";
	$text = "Durchsucht die Foren";
  }
  if($wo == "admin")
  {
    $page = "admin/admin.php";
	$text = "Administrator-Kontrollzentrum";
  }
  if($wo == "online_view")
  {
    $page = "online.php";
	$text = "Betrachtet die Liste, der Benutzer die online sind";
  }
  if($wo == "modcp")
  {
    $page = "modcp.php";
	$text = "Moderatoren-Kontrollzentrum";
  }
  if(USER != "")
  {
    if($wo != ""){
      $time = time();
      mysql_query("UPDATE users SET last_site = '$text', last_log = '$time' WHERE username LIKE '$_COOKIE[username]'");
	}
  }
}
function erzeuge_error($text)
{
  echo "<center><table style='border: 1px solid #000050;' width=50% height=50%>  
<tr bgcolor=#397BC6><td><font color=snow><b>". SITENAME ." - Fehlermeldung</b></td></tr>
	<tr><td align=center>$text</td></tr></table></center>";
  page_footer();
}
function connect_to_database()
{
  include("./config.php");
  include("includes/function_define.php");

  mysql_connect($HOST,$USER,$PW)or die(mysql_error());
  mysql_select_db($DB)or die(mysql_error());
}
function config($erken, $clude_true, $what)
{
  if($clude_true == false)
  {
    include("../config.php");
  }
  else
  {
    include("./config.php");
  }

  mysql_connect($HOST,$USER,$PW)or die(mysql_error());
  mysql_select_db($DB)or die(mysql_error());
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE '$erken'");
  $con = mysql_fetch_object($config_wert);
  $daten = array ("wert1" => $con->wert1, 
				  "wert2" => $con->wert2, 
				  "zahl1" => $con->zahl1, 
				  "zahl2" => $con->zahl2);
  if($what != "")
  {
    $clude_path = "$what.php";
    include($clude_path);
  }
  if($clude_true == false)
  {
    include("../includes/function_user.php");
  }
}
function check_data($wert1, $wert2, $fehlertext, $method)
{
  if($method == "leer")
  {
    if($wert1 == "")
	{
	  echo "<b>Fehler:</b> $fehlertext";
	  page_footer();
	}
  }
  if($method == "gleich")
  {
    if($wert1 != $wert2)
    {
      echo "<b>Fehler:</b> $fehlertext";
	  page_footer();
    }
  }
  if($method == "gleich2")
  {
    if($wert1 != $wert2)
    {
      echo "<b>Fehler:</b> $fehlertext";
	  page_footer();
    }
  }
  if($method == "mail")
  {
    if(!eregi("^[a-z0-9\._-]+@+[a-z0-9\._-]+\.+[a-z]{2,4}$", $wert1)) 
	{
	  echo "<b>Fehler:</b> $fehlertext";
	  page_footer();
	}	
  }
  if($method == "laenge")
  {
    if(strlen($wert1) <= $wert2)
	{
	  echo "<b>Fehler:</b> $fehlertext";
	  page_footer();
	}
  }
  if($method == "null")
  {
    if($wert1 != 0)
	{
	  echo "<b>Fehler:</b> $fehlertext";
	  page_footer();
	}
  }
}
function speicherung($wert, $er_text, $fe_text)
{
  if($wert == true)
    echo $er_text;
  else
    echo $fe_text;
}
function login()
{
  //Aufruf dieser Funktion, vor dem Aufruf page_header() Ansonsten Design-Fehler
  config("f2name2", true, "function_define");
  include("function_user.php");
  if(USER == "")
  {
    include("login.php");
    exit;
  }
}
function error()
{
  //Zeige Administratoren, in bestimmeten Datein alle Fehler
  if($ud->group_id == "3")
  {
    error_reporting(E_ALL);
  }
}
function text_ausgabe($text, $betreff, $from)
{
  $from_data = mysql_query("SELECT * FROM users WHERE username LIKE '$from'");
  $fd = mysql_fetch_object($from_data);
  $datum = date("d.m.Y",$fd->reg_dat);
  $text = htmlspecialchars($text);
  $text = preg_replace('/\[b\](.*?)\[\/b\]/', '<b>$1</b>', $text);  
  $text = preg_replace('/\[k\](.*?)\[\/k\]/', '<i>$1</i>', $text);  
  $text = preg_replace('/\[u\](.*?)\[\/u\]/', '<u>$1</u>', $text);  
  $text = preg_replace('/\[code\](.*?)\[\/code\]/', "<small>Code:</small><table width=80% bgcolor=snow><tr><td>$1</td></tr></table>", $text);  
  $text = eregi_replace("\[url\]([^\[]+)\[/url\]","<a href=\"\\1\" target=\"_blank\">\\1</a>",$text);
  $text = eregi_replace("\[img\]([^\[]+)\[/img\]","<img src=\"\\1\" border=0>",$text);
  $text = str_replace("\n", "<br />", $text);
  $betreff = strip_tags($betreff);
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2laengfs'");
  $con = mysql_fetch_object($config_wert); 
  $smilie_data = mysql_query("SELECT * FROM smilie WHERE packet = '$con->zahl2'");
  while($sd = mysql_fetch_object($smilie_data))
  {
    $text = str_replace($sd->abk1,"<img src=images/$sd->images_path width=25 height=25>", $text);
    $text = str_replace($sd->abk2,"<img src=images/$sd->images_path width=25 height=25>", $text);
  }
  
  $ava = "";
  if($fd->ava_link != "")
  {
    $ava = "<img src=$fd->ava_link title=\"$fd->username's Avatar\" width=100 height=100>";
  }
  echo "<table border=1  width=80% bgcolor=#E1E4F9>
<tr>
<td width=29% valign=top>
<table>
<tr><td>$ava</td><td>
<b><span style=\"cursor: pointer;\" onclick=\"window.location.href='profil.php?id=$fd->id'\">$from</b><br>
$fd->rang</br><br>
</td></tr></table>

<b>Beiträge:</b> $fd->posts<br>
<b>Registriert seit:</b> $datum<br><br><br>
</td>
<td valign=top width=51%>
<b>$betreff</b><hr>
$text";
$config_datas = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2pnsignfs'");
$cd = mysql_fetch_object($config_datas);
if($fd->sign != "" AND $cd->zahl1 == "1")
{
  $text = $fd->sign;
  $text = strip_tags($text);
  $text = preg_replace('/\[b\](.*?)\[\/b\]/', '<b>$1</b>', $text);  
  $text = preg_replace('/\[k\](.*?)\[\/k\]/', '<i>$1</i>', $text);  
  $text = preg_replace('/\[u\](.*?)\[\/u\]/', '<u>$1</u>', $text);  
  $text = eregi_replace("\[url\]([^\[]+)\[/url\]","<a href=\"\\1\" target=\"_blank\">\\1</a>",$text);
  $text = str_replace("\n", "<br />", $text);
  $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2laengfs'");
  $con = mysql_fetch_object($config_wert); 
  $smilie_data = mysql_query("SELECT * FROM smilie WHERE packet = '$con->zahl2'");
  while($sd = mysql_fetch_object($smilie_data))
  {
    $text = str_replace($sd->abk1,"<img src=images/$sd->images_path width=25 height=25>", $text);
    $text = str_replace($sd->abk2,"<img src=images/$sd->images_path width=25 height=25>", $text);
  }
  echo "<hr>$text";
}
echo "</td></tr></table>";

}
function today($datum)
{
  $now = date("d.m.Y", time());
  if($datum == $now)
  {
    $datum = "Heute";
  }
}
// Ende der Funktionen, Abrufe wichtiger Arrays!
$warn_dauer = Array("86400","172800","432000","604800","864000","1209600","2678400","5097600","15638400","31536000","63072000");
$warn_text = Array("1 Tag","2 Tage","5 Tage","7 Tage","10 Tage","2 Wochen","1 Monat","2 Monate","6 Monate","1 Jahr","2 Jahre");
?>
<?php
error_reporting(0);
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
  include_once("includes/function_user.php");
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
  $text = preg_replace('/\[b\](.*?)\[\/b\]/s', '<b>$1</b>', $text);  
  $text = preg_replace('/\[k\](.*?)\[\/k\]/s', '<i>$1</i>', $text);  
  $text = preg_replace('/\[u\](.*?)\[\/u\]/s', '<u>$1</u>', $text);  
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
echo "<table class=editorbgc><tr><td>
<input type=button class=editorbgco style='font-weight:bold' value=b onclick=\"insert('[b]', '[/b]')\"><input type=button class=editorbgco style=\"text-decoration:underline\" value=u onclick=\"insert('[u]', '[/u]')\"><input type=button class=editorbgco style=\"font-style:italic\" value=k onclick=\"insert('[k]', '[/k]')\">
<input type=button  class=editorbgco value=Link onclick=\"insert('[url]', '[/url]')\"><input type=button  class=editorbgco value=Code onclick=\"insert('[code]', '[/code]')\"><input type=button class=editorbgco value=Bild onclick=\"insert('[img]', '[/img]')\"><input type=button class=editorbgco value='Zitat' onclick=\"u = prompt('Welchen Benutzer mˆchtest du zitieren?'); insert('[zitat='+u+']', '[/zitat]')\"><br>
<textarea cols=70 rows=7 name=feld>";
if($di == "sign")
{
  echo $value;
}
echo "</textarea><br>
<input type=submit value=Absenden  class=editorbgco>";
if((GROUP > "1" AND GROUP != "4") AND $di == "ant")
{
  echo "<br><br><fieldset><legend>Moderator-Optionen</legend>
  <input type=checkbox value=1 name=close> Thema nach abschicken, schlieﬂen<br>
  <input type=checkbox value=1 name=import> Thema nach abschicken, als wichtig makieren</fieldset>
";
}
echo "</td><td valign=top><br>";
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
}
  echo "<script>
  function smilie(sm)
  {
    document.feld.feld.value += sm
  }
  </script>
<form action=?do=make_pn&aktion=change method=post name=feld>
An:<br>
<input type=text name=to value='$value'><br><br>
Betreff:<br>
<input type=text name=bet value='$extra'><br><br>
Nachricht:
<table class=editorbgc><tr><td>
<input type=button class=editorbgco style='font-weight:bold' value=b onclick=\"document.feld.feld.value += '[b][/b]'\"><input type=button class=editorbgco style=\"text-decoration:underline\" value=u onclick=\"document.feld.feld.value += '[u][/u]'\"><input type=button class=editorbgco style=\"font-style:italic\" value=k onclick=\"document.feld.feld.value += '[k][/k]'\">
<input type=button class=editorbgco value=Link onclick=\"document.feld.feld.value += '[url][/url]'\"><input type=button class=editorbgco value=Code onclick=\"document.feld.feld.value += '[code][/code]'\"><input type=button class=editorbgco value=Bild onclick=\"document.feld.feld.value += '[img][/img]'\"><br>
<textarea cols=70 rows=7 name=feld></textarea><br>
<input type=submit value=Absenden class=editorbgco>
</td><td valign=top><br>";
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
$mos_dat = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2name2'");
$md = mysql_fetch_object($mos_dat);
$online_data = mysql_query("SELECT * FROM users WHERE last_log > '$dtime' ORDER BY username");
$meno = mysql_num_rows($online_data);
$result = mysql_query("SELECT ip FROM onlineuser"); 
$user_online = mysql_num_rows($result);
$meno = $user_online;
if($meno > $md->zahl1)
{
  $time = time();
  mysql_query("UPDATE config SET zahl1 = '$meno', zahl2 = '$time' WHERE erkennungscode LIKE 'f2name2'");
}
echo "<table width=100% class=forenbg><tr><td>";
echo "<small>Der Besucherrekord liegt bei $md->zahl1 Besuchern, die Gleichzeitig am ". date("d.m.Y", $md->zahl2) ." um ". date("H:i", $md->zahl2) ." online waren.</small><br>";
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
	$text = "Betrachtet die Startseite";
  }
  if($wo == "profil")
  {
    $proid = mysql_query("SELECT * FROM users WHERE id LIKE '$_GET[id]'");
	$pi = mysql_fetch_object($proid);
    $page = "profil.php";
	$text = "Betrachtet das Benutzerprofil von $pi->username";
  }
  if($wo == "main")
  {
    $page = "main.php";
	$text = "Befindet sich im Persˆnlichem Bereich";
  }
  if($wo == "list_member")
  {
    $page = "member.php";
	$text = "Betrachtet die Benutzerliste";
  }
    if($wo == "create_pn")
  {
    $page = "main.php";
	$text = "Erstellt eine Private Nachricht";
  }
  if($wo == "read_pn")
  {
    $pn_data = mysql_query("SELECT * FROM prna WHERE id LIKE '$_GET[aktion]'");
	$pd = mysql_fetch_object($pn_data);
    $page = "main.php";
	/*if(GROUP == "2" OR GROUP == "3")
	{
	  $text = "Liest eine Private Nachricht von $pd->abse";
	}
	else
	{*/
	  $text = "Liest eine Private Nachricht";
//	}
  }
  if($wo == "look_pn")
  {
    $page = "member.php";
	$text = "Betrachtet die Privaten Nachrichten";
  }
  if($wo == "forum-view")
  {
    $foda = mysql_query("SELECT * FROM foren WHERE id LIKE '$_GET[id]'");
	$fd = mysql_fetch_object($foda);
    $page = "forum.php";
	$text = "Befindet sich im Forum $fd->name";
  }
  if($wo == "newtopic")
  {
    $foda = mysql_query("SELECT * FROM foren WHERE id LIKE '$_GET[id]'");
	$fd = mysql_fetch_object($foda);
    $page = "newtopic.php";
	$text = "Erstellt ein Thema: $fd->name";
  }
  if($wo == "kontakt")
  {
    $foda = mysql_query("SELECT * FROM foren WHERE id LIKE '$_GET[id]'");
	$fd = mysql_fetch_object($foda);
    $page = "kontakt.php";
	$text = "Benutzt das Kontaktformular";
  }
  if($wo == "readthema")
  {
    $them_dat = mysql_query("SELECT * FROM thema WHERE id LIKE '$_GET[id]'");
	$td = mysql_fetch_object($them_dat);
	if(isset($td->guest_see))
	{
	  if($td->guest_see == "1")
      {
        if(USER == "")
        {
          $page = "thread.php";
	      $text = "Liest ein Thema";
        }
      }
	}
	if(isset($fd->guest_see))
	{
	  if($fd->guest_see == "2")
      {
          $page = "thread.php";
	      $text = "Liest ein Thema";
      }
	}
	if(isset($td->dele))
	{
	  if($td->dele == "")
	  {
        $page = "thread.php";
	    $text = "Liest ein Thema: $td->tit";
	  }
	}
  }
  if($wo == "newreply")
  {
    $them_dat = mysql_query("SELECT * FROM thema WHERE id LIKE '$_GET[id]'");
	$td = mysql_fetch_object($them_dat);
    $page = "newreply.php";
	$text = "Antwortet auf $td->tit";
  }
  if($wo == "onekat")
  {
    if(isset($_GET["do"]))
	{
      $get_id = $_GET["id"];
	}
	else
	{
	  $get_id = "";
	}
    $them_dat = mysql_query("SELECT * FROM kate WHERE id LIKE '$get_id'");
	$td = mysql_fetch_object($them_dat);
	if(!empty($td->id) AND !empty($td->name))
	{
      $page = "index.php?do=show_one&id=$td->id";
	  $text = "Betrachtet die Foren einer Kategorie $td->name";
	}
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
  if($wo == "search")
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
	$text = "Betrachtet die Liste der Benutzer, die online sind";
  }
  if($wo == "modcp")
  {
    $page = "modcp.php";
	$text = "Moderatoren-Kontrollzentrum";
  }
  if($wo == "edit")
  {
    $page = "edit.php";
	$text = "Bearbeitet einen Beitrag";
  }
  if(USER != "")
  {
    if($wo != ""){
      $time = time();
	  $ip = $_SERVER["REMOTE_ADDR"];
	  if(isset($text))
	  {
        mysql_query("UPDATE users SET last_site = '$text', last_log = '$time', last_ip = '$ip' WHERE username LIKE '$_COOKIE[username]'");
	  }
	}
  }
}
function erzeuge_error($text)
{
  echo "<center><table class=bord width=50% height=50%>  
  <tr class=normal><td><font color=snow><b>". SITENAME ." - Fehlermeldung</b></td></tr>
  <tr><td align=center>$text";
  $config_data = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE 'f2mf2'");
  $cd = mysql_fetch_object($config_data);
  if($cd->zahl2 == "1")
  {
    echo "<br><br><a href=kontakt.php>Kontaktformular</a>";
  }
  echo "</td></tr></table></center><br><br>";
  page_footer();
}
function erzeuge_mysql_error($text)
{
  echo "<center><table class=bord width=50% height=50%>  
<tr class=normal><td><font color=snow><b>". SITENAME ." - Datenbank-Fehler</b></td></tr>
	<tr><td align=center>$text</td></tr></table></center><br><br>";
}
function connect_to_database()
{

  include("includes/function_define.php");
  include("config.php");

  mysql_connect($HOST,$USER,$PW)or die(mysql_error());
  mysql_select_db($DB)or die(mysql_error());
}
function backup()
{
  include("../config.php");
  $time = date("dMY", time());
  system(" -u$USER -p$PW -h $HOST $DB > ".dirname(__FILE__)."/backup_$time.sql", $fp); 
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
    if(strlen($wert1) < $wert2)
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
  include_once("function_user.php");
  if(USER == "")
  {
    include("login.php");
    exit;
  }
}
function error()
{

}
function show_online($zeit, $user)
{
  $rech = $zeit - time();
  if($rech > "-901")
  {
    echo " <img src=images/green.png border=0 title='$user ist online' height=18px>";
  }
  else
  {
    echo " <img src=images/rot.png border=0 title='$user ist offline' height=18px>";
  }
}
function text_ausgabe($text, $betreff, $from)
{
  $from_data = mysql_query("SELECT * FROM users WHERE username LIKE '$from'");
  $fd = mysql_fetch_object($from_data);
  $datum = date("d.m.Y",$fd->reg_dat);
  if($fd->htmlcan != "1")
  {
    // Wenn der Benutzer laut Admincp HTML benutzen darf, wird es in Beitr‰gen deaktiviert. Funktion wird nur Administratoren empfohlen, die dieses wirklich brauchen!
    $text = htmlspecialchars($text);
  }
  $text = preg_replace('/\[b\](.*?)\[\/b\]/s', '<b>$1</b>', $text);  
  $text = preg_replace('/\[k\](.*?)\[\/k\]/s', '<i>$1</i>', $text);  
  $text = preg_replace('/\[u\](.*?)\[\/u\]/s', '<u>$1</u>', $text);  
  $text = preg_replace('/\[code\](.*?)\[\/code\]/s', "<small style='display:block;'>Code:</small><table width=80% bgcolor=snow><tr><td>$1</td></tr></table>", $text);  
  $text = eregi_replace("\[url\]([^\[]+)\[/url\]","<a href=\"http://\\1\" target=\"_blank\">\\1</a>",$text);
  $text = preg_replace('/\[url=([^ ]+).*\](.*)\[\/url\]/', '<a href="http://$1" target=\"_blank\">$2</a>', $text);  
  $text = eregi_replace("\[img\]([^\[]+)\[/img\]","<img src=\"\\1\" border=0>",$text);
  $text = preg_replace("/\[color=(.*)\](.*)\[\/color\]/Usi", "<font color=\"\\1\">\\2</font>", $text); 
  $text = preg_replace("/\[size=(.*)\](.*)\[\/size\]/Usi", "<font size=\"\\1\">\\2</font>", $text); 
  $text = preg_replace("/\[zitat=(.*)\](.*)\[\/zitat\]/Usi", "<small style='display:block;'>Zitat von \\1:</small><table width=80% bgcolor=snow><tr><td>\\2</td></tr></table>", $text);
  $text = str_replace("http://http://" ,"http://", $text);
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
  if(mysql_num_rows($from_data) > 0)
  {
    $linkeins = "<span style=\"cursor: pointer;\" onclick=\"window.location.href='profil.php?id=$fd->id'\">";
	$rang = $fd->rang;
	$beitr = "<b>Beitr‰ge:</b> $fd->posts<br>";
	$datum = "<b>Registriert seit:</b> $datum<br><br><br>";
  }
  else
  {
     $linkeins = "";
	 $rang = "Gast";
	 $beitr = "";
	 $datum = "";
  }
  echo "<table border=1  width=80% class=post>
<tr>
<td width=29% valign=top>
<table>
<tr><td>$ava</td><td>
<b>$linkeins$from</b>";
if(mysql_num_rows($from_data) > 0)
{
  show_online($fd->last_log, $fd->username);
}
echo "<br>
";
show_rang($fd->posts, $fd->rang);
echo"</br><br>
</td></tr></table>

$beitr
$datum
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
  $text = preg_replace('/\[b\](.*?)\[\/b\]/s', '<b>$1</b>', $text);  
  $text = preg_replace('/\[k\](.*?)\[\/k\]/s', '<i>$1</i>', $text);  
  $text = preg_replace('/\[u\](.*?)\[\/u\]/s', '<u>$1</u>', $text);  
  $text = eregi_replace("\[url\]([^\[]+)\[/url\]","<a href=\"http://\\1\" target=\"_blank\">\\1</a>",$text);
  $text = preg_replace('/\[url=([^ ]+).*\](.*)\[\/url\]/', '<a href="http://$1" target=\"_blank\">$2</a>', $text);  
  $text = str_replace("\n", "<br />", $text);
  $text = str_replace("http://http://" ,"http://", $text);
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
function mysql_fehler($fehler, $line, $datei)
{
  $err = 'Hallo,
  
  soben trat beim Absender dieser Privaten Nachricht folgende Fehlermeldung auf:
	  
  [FEHLER]
	  
  Der Fehler befindet sich in der Zeile [LINE] und in der Datei [DATEI].
	  
  Dieses ist eine automatische Private Nachricht, welche vom Forum aus verschickt wurde.';
  
  $error = $fehler;
  
  $pn_nach = mysql_query("SELECT * FROM users WHERE group_id = 3 AND adm_recht = 6");
  while($dh = mysql_fetch_object($pn_nach))
  { 
    $error = str_replace(' ','_u_',$error);
	$error = str_replace("'",'"',$error);
    $err = str_replace('[LINE]',$line,$err);
    $err = str_replace('[DATEI]',$datei,$err);
    $err = str_replace('[FEHLER]',$error,$err);
	$err = str_replace('_u_',' ',$err);
    $time = time();
    mysql_query("INSERT INTO prna (abse, emp, dat, betreff, mes, gel) VALUES ('$_COOKIE[username]', '$dh->username', '$time', 'Datenbank-Fehlermeldung', '$err', '0')");
  }
  
  erzeuge_mysql_error("<table>
  <tr><td>Zeile:</td><td>$line</td></tr>
  <tr><td>Datei:</td><td>$datei</td></tr>
  <tr><td valign=top>Erweiterte Fehlerausgabe:</td><td>$fehler</td></tr>
  <tr><td>Sonstiges:</td><td>Ein Administrator wurde informiert.</td></tr></table>");

  
  page_footer();

}
function show_stat($s)
{
  //Statistik anzeige
  $time = time();
  $most_user_posts = mysql_query("SELECT * FROM users ORDER BY posts DESC LIMIT 5");
  $new_user = mysql_query("SELECT * FROM users ORDER BY reg_dat DESC LIMIT 5");
  $new_them = mysql_query("SELECT * FROM thema WHERE dele = '' ORDER BY last_post_time DESC");
  $last_akt = mysql_query("SELECT * FROM users ORDER BY last_log DESC LIMIT 5");
  if($s == "j")
  {
    echo "<div style=\"display: block;\" id=\"zwei\">";
  }
  echo "<table class=bord><tr><td class=normal>Meiste Beitr‰ge</td><td class=normal>Neue Benutzer</td><td class=normal>Letzte Antworten</td><td class=normal>Letzte Aktuallisierungen</td></tr>
  <tr><td><table>";
  while($mup = mysql_fetch_object($most_user_posts))
  {
    $time = time();
    if($mup->sptime > $time)
	{
	  $usan = "<s>$mup->username</s>";
	}
	else
	{
      $usan = $mup->username;
	}
    echo "<tr><td><a href=profil.php?id=$mup->id>$usan</a></td><td>$mup->posts</td></tr>";
  }
  echo "</table></td><td><table>";
  while($nu = mysql_fetch_object($new_user))
  {
    $dat = date("d.m.Y - H:i",$nu->reg_dat);
    $time = time();
    if($nu->sptime > $time)
	{
	  $usan = "<s>$nu->username</s>";
	}
	else
	{
      $usan = $nu->username;
	}
    echo "<tr><td><a href=profil.php?id=$nu->id>$usan</a></td><td>$dat</td></tr>";
  } 
  echo "</table></td><td><table>";
  $x = "0";
  while($nt = mysql_fetch_object($new_them) AND $x != 5)
  {

	  $anz = mysql_query("SELECT * FROM beitrag WHERE where_forum LIKE '$nt->id' AND dele = ''");
	  $anza = mysql_num_rows($anz);
	  $forum_data = mysql_query("SELECT * FROM foren WHERE id LIKE '$nt->where_forum'");
      $fd = mysql_fetch_object($forum_data);
	  $rech = ceil($anza/10);
	  $dat = date("d.m.Y - H:i", $nt->last_post_time);
	  if($fd->guest_see == "2" AND (GROUP == 2 OR GROUP == 3))
      {
        $x++;
	    echo "<tr><td><a href=thread.php?id=$nt->id&page=$rech>$nt->tit</a></td><td>$dat</td></tr>";
	  }
	  elseif($fd->guest_see != "2")
	  {
	    $x++;
	    echo "<tr><td><a href=thread.php?id=$nt->id&page=$rech>$nt->tit</a></td><td>$dat</td></tr>";
	  }
  }
  echo "</table></td><td><table>";
  while($la = mysql_fetch_object($last_akt))
  {
    $dat = date("d.m.Y - H:i",$la->last_log);
    $time = time();
    if($la->sptime > $time)
	{
	  $usan = "<s>$la->username</s>";
	}
	else
	{
      $usan = $la->username;
	}
    echo "<tr><td><a href=profil.php?id=$la->id>$usan</a></td><td>$dat</td></tr>";
  }
  echo "</table></td></tr></table>";
  if($s == "j")
  {
    echo "</div>";
  }
}
function diagramm($typ, $abstand, $daten, $einheit, $breite, $hoehe) {

  $schrift = 3;
  $legende_abstand = 10;

  $daten = explode(", ", $daten);
  $werte = array();
  $bezeichnungen = array();
  $farben = array();

  for($i=0; $i<sizeof($daten); $i++) {
    $temp = explode(":", $daten[$i]);
    array_push($bezeichnungen, $temp[0]);
    array_push($werte, $temp[1]);
    array_push($farben, $temp[2]);
    if($abstand_text < imagefontwidth($schrift)
* strlen($temp[0])) $abstand_text = imagefontwidth($schrift) *
strlen($temp[0]);
  }
    $abstand_text_h = imagefontheight($schrift);

  $bild = imagecreatetruecolor($breite, $hoehe);

  $farbe_hintergrund = imagecolorexact($bild, 245, 245, 245);
  $farbe_hintergrund = imagecolortransparent($bild,$farbe_hintergrund);
  $farbe_text = imagecolorexact($bild, 0, 0, 0);
  $farbe_zwischen = imagecolorexact($bild, 220, 220, 220);

  $farbe_rot = imagecolorexact($bild, 255, 0, 0);
  $farbe_gruen = imagecolorexact($bild, 0, 255, 0);
  $farbe_schwarz = imagecolorexact($bild, 0, 0, 0);
  $farbe_gelb = imagecolorexact($bild, 255, 255, 0);
  $farbe_lila = imagecolorexact($bild, 255, 0, 255);

  imagefill($bild, 0, 0, $farbe_hintergrund);
    if($typ == "kreis") { //!//

    $diagramm_durchmesser = $hoehe - 2 * $abstand;
    $diagramm_x = $diagramm_durchmesser / 2 +
$abstand;
    $diagramm_y = $diagramm_x;
    $diagramm_winkel1 = 0;

    $legende_x = $diagramm_durchmesser + 3 *
$abstand;
    $legende_y = $hoehe - $abstand -
$legende_abstand;
    $legende_b = $legende_x + $legende_abstand;
    $legende_h = $legende_y + $legende_abstand;
    $legende_versatz = 0;
	    for($i=0; $i<sizeof($werte); $i++) {

      $prozent = 100 / array_sum($werte)
* $werte[$i];
      $grad = 360 / 100 * $prozent;
      $diagramm_winkel2 = $grad +
$diagramm_winkel1;

      $wert = $werte[$i]." ".$einheit;

      $farbe = "farbe_".$farben[$i];

      imagefilledarc($bild, $diagramm_x,
$diagramm_y, $diagramm_durchmesser, $diagramm_durchmesser,
$diagramm_winkel1, $diagramm_winkel2, ${$farbe}, IMG_ARC_PIE);

      imagefilledrectangle($bild,
$legende_x, $legende_y - $legende_versatz, $legende_b, $legende_h -
$legende_versatz, ${$farbe});
      imagestring($bild, $schrift,
$legende_x + 2 * $legende_abstand, $legende_y - $legende_versatz,
$bezeichnungen[$i], $farbe_text);
      imagestring($bild, $schrift,
$legende_x + 3 * $legende_abstand + $abstand_text, $legende_y -
$legende_versatz, $wert, $farbe_text);

      $diagramm_winkel1 =
$diagramm_winkel1 + $grad;
      $legende_versatz = $legende_versatz
+ 2 * $legende_abstand;

    }



 } else if($typ == "balken") {  //!//

    $balken_x = $abstand;
    $balken_y = $hoehe - $abstand;
    $balken_b = 2 * $abstand;
    $diagramm_h = $hoehe - 2 * $abstand;
    $balken_versatz = 0;

    $legende_x = $balken_x + sizeof($werte) *
$balken_b + (sizeof($werte) - 1) * $abstand + 2 * $abstand;
    $legende_y = $hoehe - $abstand -
$legende_abstand;
    $legende_b = $legende_x + $legende_abstand;
    $legende_h = $legende_y + $legende_abstand;
    $legende_versatz = 0;

    for($i=0; $i<sizeof($werte); $i++) {

      $prozent = 100 / array_sum($werte)
* $werte[$i];
      $balken_h = $diagramm_h / 100 *
$prozent;

      $wert = $werte[$i]." ".$einheit;

      $farbe = "farbe_".$farben[$i];

      imagefilledrectangle($bild,
$balken_x + $balken_versatz, $abstand, $balken_x + $balken_versatz +
$balken_b, $hoehe - $abstand, $farbe_zwischen);
      imagefilledrectangle($bild,
$balken_x + $balken_versatz, $balken_y - $balken_h, $balken_x +
$balken_versatz + $balken_b, $balken_y, ${$farbe});
      imagestring($bild, $schrift,
$balken_x + $balken_versatz + 2, $balken_y - $balken_h -
$abstand_text_h, $werte[$i], $farbe_text);

      imagefilledrectangle($bild,
$legende_x, $legende_y - $legende_versatz, $legende_b, $legende_h -
$legende_versatz, ${$farbe});
      imagestring($bild, $schrift,
$legende_x + 2 * $legende_abstand, $legende_y - $legende_versatz,
$bezeichnungen[$i], $farbe_text);
      imagestring($bild, $schrift,
$legende_x + 3 * $legende_abstand + $abstand_text, $legende_y -
$legende_versatz, $wert, $farbe_text);

      $balken_versatz = $balken_versatz +
3 * $abstand;
      $legende_versatz = $legende_versatz
+ 2 * $legende_abstand;

    }
	  } else if($typ == "verlauf") { //!//

    $linie_x = $abstand;
    $linie_b = ($breite - 2 * $abstand) /
(sizeof($werte) - 1);
    $linie_h = $hoehe - 2 * $abstand;
    $linie_versatz = 0;

    $punkte = array();

    for($i=0; $i<sizeof($werte); $i++) {

      $hoechstwert = $werte;
      rsort($hoechstwert, SORT_NUMERIC);
      $hoechstwert = $hoechstwert[0];

      $prozent = 100 / $hoechstwert *
$werte[$i];
      $linie_y = $linie_h / 100 *
$prozent;

      $farbe = "farbe_".$farben[$i];

      array_push($punkte, $linie_x +
$linie_versatz, $linie_h - $linie_y + $abstand);

      $linie_versatz = $linie_versatz +
$linie_b;

    }

    array_push($punkte, $breite - $abstand, $hoehe
- $abstand, $abstand, $hoehe - $abstand);

    $farbe = "farbe_".$farben[0];
    imagefilledpolygon($bild, $punkte,
sizeof($punkte) / 2, ${$farbe});

    imageline($bild, $abstand, $abstand, $abstand,
$hoehe - $abstand, $farbe_text);
    imageline($bild, $abstand, $hoehe - $abstand,
$breite - $abstand, $hoehe - $abstand, $farbe_text);
    imagestring($bild, $schrift, $abstand + 4,
$abstand, $einheit, $farbe_text);

    for($i=100; $i>=0; $i=$i-10) {
      $prozent = 100 / $hoechstwert * $i;
      $y = $linie_h - round($linie_h /
100 * $prozent);
      imageline($bild, $abstand, $abstand
+ $y, $abstand + 10, $abstand + $y, $farbe_text);
    }

    $linie_versatz = 0;

    for($i=0; $i<sizeof($werte); $i++) {
      imageline($bild, $linie_x +
$linie_versatz, $hoehe - $abstand - 10, $linie_x + $linie_versatz,
$hoehe - $abstand, $farbe_text);
      if($i < sizeof($werte) - 1)
imagestring($bild, $schrift, $linie_x + $linie_versatz + 2, $hoehe -
$abstand - 10 - 2, $bezeichnungen[$i], $farbe_text);
      $linie_versatz = $linie_versatz +
$linie_b;
    }

  }
  header("Content-type: image/gif");
  imagegif($bild);
}
function show_rang($post, $user_rang)
{
  if($user_rang != "Benutzer")
  {
    echo $user_rang;
  }
  else
  {
     $rang_hol =  mysql_query("SELECT * FROM range WHERE min_post <= '$post' ORDER BY min_post DESC LIMIT 1") or die(mysql_error());
	 $rh = mysql_fetch_object($rang_hol);
	 echo $rh->name;
  }
}
// Ende der Funktionen, Abrufe wichtiger Arrays!
$warn_dauer = Array("86400","172800","432000","604800","864000","1209600","2678400","5097600","15638400","31536000","63072000");
$warn_text = Array("1 Tag","2 Tage","5 Tage","7 Tage","10 Tage","2 Wochen","1 Monat","2 Monate","6 Monate","1 Jahr","2 Jahre");
?>

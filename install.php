<?
/*
Installations Datei

Änderungen an dieser Datei vermeiden, dieses könnte die installation fehlerhaft machen!
*/
?>
<title>bigforum - Installation</title>
<style>
body
{
	background: #E1E4F2;
	color: #000000;
}
</style>
<script>
function schr(s)
{
  document.getElementById("schritt").innerHTML = s;
}
</script>
<table width="100%"><tr><td width="90%"><b>Bigforum - Installationsassistent Schritt <span id=schritt></span>/6</b></td><td><b>Version: 2.3</b></td></tr></table>
<hr><br><br>
<?php
$do = $_GET["do"];
$s = $_GET["s"];
function schr($s)
{
  echo "<script>schr('$s')</script>";
}
switch($do){
  case "":
  schr("1");
  echo "Vielen dank, dass du bigforum installieren bzw. updaten möchtest.<br>Die Installation ist ganz einfach, dir wird ganz genau erklärt, was zu tun ist. Wenn du das Forum updaten willst, musst du die letzte Version haben.<br> Sprünge beim Update führen zu fehlern. <br>Das Update ist bereits nach einem Schritt fertig.<br><br>Sobald du das Forum installiert bzw. geupdatet hast, lösche die Datei install.php.<br><br>
  <input type=button value='Forum installieren' onclick=\"location.href='?do=install&s=1'\"> &nbsp; &nbsp; &nbsp; <input type=button value='Forum updaten' onclick=\"location.href='?do=update'\">";
  break;
  
  case "update":
    schr("6");
	include("config.php");

    mysql_connect($HOST,$USER,$PW)or die(mysql_error());
    mysql_select_db($DB)or die(mysql_error());
	//MySQL - Datenbank änderungen	
	//Ende
    echo "Danke, das Forum wurde nun auf den neusten Stand gebracht.<br>Bitte lösche diese Datei, ansonsten kann jeder dieses Forum beschädigen!";
  break;
  
  
  case "install":
  
    switch($s){
	
	case "1":
	  schr("2");
      echo "Viel dank, dass du bigforum installieren willst. Als erstes benötigen wir deine Datenbank-Daten:
	  <br><br>
	  <form action=?do=install&s=2 method=post>
	  <table>
	  <tr><td>Host</td><td><input type=text name=host value='meistens localhost'></td></tr>
	  <tr><td>Datenbank-Name</td><td><input type=text name=dbn></td></tr>
	  <tr><td>Benutzername</td><td><input type=text name=benu></td></tr>
	  <tr><td>Passwort</td><td><input type=password name=pw1></td></tr>
	  <tr><td>Passwort (wiederholung)</td><td><input type=password name=pw2></td></tr>
	  </table>
	  <input type=submit value='Verbindung prüfen'>
	  </form>
	  ";	  
	break;
	
	
	case "2":
	  schr("3");
	  if($_POST["pw1"] != $_POST["pw2"])
	  {
	    echo "Die Passwörter stimmen nicht überein.<br><br>
		<a href=?do=install&s=1>Zurück zu Schritt 2</a>";
		exit;
	  }
      $check_ver = mysql_connect($_POST["host"], $_POST["benu"], $_POST["pw1"]) or die ("<font color=red>Es ist keine Verbindung zur Datenbank möglich. Bitte achte darauf, dass alle Daten richtig eingegeben sind!</font><br><br><a href=?do=install&s=1>Zurück zu Schritt 2</a>");
      mysql_select_db($_POST["dbn"], $check_ver);
	  echo "<font color=green>Verbindung zur Datenbank erfolgreich.</font><br><br>
	  <a href=?do=install&s=3>Zum nächstem Schritt</a>";
	  $fp = fopen("config.php","w+");
      $HOST = '$HOST';
      $USER = '$USER';
      $PW = '$PW';
      $DB = '$DB';
      $daten = "<?php 
      //Bitte keine Änderungen an dieser Datei vornehmen!
      $HOST = '$_POST[host]'; 
      $USER = '$_POST[benu]'; 
      $PW = '$_POST[pw1]'; 
      $DB = '$_POST[dbn]'; 
      ?>";
      fwrite($fp,$daten);
	break;
	
	
	case "3":
	  schr("4");
	  echo "Es werden nun die Tabellen erstellt. Dieser Vorgang kann einige Momente dauern!";
	  include("config.php");

      mysql_connect($HOST,$USER,$PW)or die(mysql_error());
      mysql_select_db($DB)or die(mysql_error());
	  //Ab hier werden die MySQL Tabellen erstellt
	  mysql_query("CREATE TABLE IF NOT EXISTS admin_logs ( 

      id INT(20) NOT NULL auto_increment,
      username varchar(500) NOT NULL,
      time int(200) NOT NULL,
      aktio varchar(800) NOT NULL,
      ipadr varchar(200) NOT NULL,
      PRIMARY KEY (id) );

      "); 
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS onlineuser (
      id INT(11) NOT NULL auto_increment,
      uid varchar(32) NOT NULL,
      ip varchar(30) NOT NULL,
      time INT(11) NOT NULL,
      PRIMARY KEY (id)
      );");
	  
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS beitrag ( 

      id INT(20) NOT NULL auto_increment,
      text text NOT NULL,
      where_forum int(20) NOT NULL,
      verfas varchar(800) NOT NULL,
      post_dat varchar(25) NOT NULL,
      last_edit_dat varchar(30) NOT NULL,
	  edit_by varchar(800) NOT NULL,
      PRIMARY KEY (id) );

      "); 
	  
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS config ( 

      erkennungscode varchar(300) NOT NULL,
      wert1 varchar(1000) NOT NULL,
      wert2 varchar(1000) NOT NULL,
      zahl1 int(50) NOT NULL,
      zahl2 int(50) NOT NULL
	  );

      "); 
	  
	  
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS foren ( 

      id INT(20) NOT NULL auto_increment,
      name varchar(500) NOT NULL,
      besch varchar(800) NOT NULL,
      kate int(8) NOT NULL,
      guest_see int(5) NOT NULL,
      min_posts int(8) NOT NULL,
	  admin_start_thema int(10) NOT NULL,
	  user_posts int(8) NOT NULL,
	  sort int(50) NOT NULL,
      PRIMARY KEY (id) );

      "); 
	  
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS kate ( 

      id INT(20) NOT NULL auto_increment,
      name varchar(500) NOT NULL,
      besch varchar(800) NOT NULL,
      PRIMARY KEY (id) );

      "); 
	  
	  
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS prna ( 

      id INT(20) NOT NULL auto_increment,
      abse varchar(500) NOT NULL,
      emp varchar(800) NOT NULL,
      dat varchar(90) NOT NULL,
      betreff varchar(900) NOT NULL,
      mes text NOT NULL,
	  gel int(10) NOT NULL,
      PRIMARY KEY (id) );

      "); 
	  
	  
	  
	 mysql_query("CREATE TABLE IF NOT EXISTS read_all ( 

      id INT(20) NOT NULL auto_increment,
      uname varchar(500) NOT NULL,
      thema_id int(10) NOT NULL,
      when_look int(5) NOT NULL,
      PRIMARY KEY (id) );

      "); 
	  
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS smilie ( 

      packet int(20) NOT NULL,
      images_path varchar(200) NOT NULL,
      abk1 varchar(80) NOT NULL,
      abk2 varchar(80) NOT NULL);

      "); 
	  
	  
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS thema ( 

      id INT(20) NOT NULL auto_increment,
      tit varchar(500) NOT NULL,
      text text NOT NULL,
      verfas text NOT NULL,
      last_edit int(100) NOT NULL,
      edit_from varchar(500) NOT NULL,
	  post_when int(100) NOT NULL,
	  where_forum int(9) NOT NULL,
	  close int(3) NOT NULL,
	  last_post_time int(50) NOT NULL,
	  import int(5) NOT NULL,
      PRIMARY KEY (id) );

      "); 
	  
	  
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS users ( 

      id INT(20) NOT NULL auto_increment,
      username varchar(500) NOT NULL,
      posts int(8) NOT NULL,
      reg_dat int(20) NOT NULL,
      last_log int(50) NOT NULL,
      reg_ip varchar(200) NOT NULL,
	  sign text NOT NULL,
	  group_id int(9) NOT NULL,
	  pw varchar(100) NOT NULL,
	  mail varchar(100) NOT NULL,
	  sptime int(209) NOT NULL,
	  rang varchar(500) NOT NULL,
	  last_site varchar(150) NOT NULL,
	  gesperrt int(5) NOT NULL,
	  hob varchar(500) NOT NULL,
	  website varchar(300) NOT NULL,
	  pn_weiter int(2) NOT NULL,
	  ava_link varchar(500) NOT NULL,
	  adm_recht int(5) NOT NULL,
	  notice varchar(100) NOT NULL,
	  style varchar(50) NOT NULL,
	  last_ip varchar(80) NOT NULL,
	  empfo varchar(150) NOT NULL,
	  statshow int(3) NOT NULL,
      PRIMARY KEY (id) );

      "); 
	  
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS user_verwarn ( 

      id INT(20) NOT NULL auto_increment,
      user_id int(10) NOT NULL,
      grund varchar(700) NOT NULL,
      punkte int(6) NOT NULL,
      dauer int(150) NOT NULL,
      grund_pn varchar(1000) NOT NULL,
	  von varchar(800) NOT NULL,
	  wann int(250) NOT NULL,
      PRIMARY KEY (id) );

      "); 
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS verwarn_gruend ( 

      id INT(20) NOT NULL auto_increment,
      grund varchar(500) NOT NULL,
      punkte int(9) NOT NULL,
      zeit int(100) NOT NULL,
      PRIMARY KEY (id) );

      "); 
	  
	  //Ende
	  //Einfügen in Tabellen
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2profs', 'j', '', '0', '1')");
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2name2', 'Bigforum', 'Das Forum', '0', '0')");
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2pnsignfs', 'images/logo_new.png', '', '1', '1')");
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2closefs', 'Allgemeine Arbeiten', '', '1', '0')");
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2imgadfs', 'images/old_post.png', 'images/new_post.png', '3', '0')");
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2laengfs', 'images/bfav.ico', 'brown', '10', '1')");
	  mysql_query("INSERT INTO smilie (packet, images_path, abk1, abk2) VALUES ('1', 'brille.png', '8-)', '8)')");
	  mysql_query("INSERT INTO smilie (packet, images_path, abk1, abk2) VALUES ('1', 'grine.png', ':)', ':-)')");
	  mysql_query("INSERT INTO smilie (packet, images_path, abk1, abk2) VALUES ('1', 'lache.png', ':D', ':-D')");
	  mysql_query("INSERT INTO smilie (packet, images_path, abk1, abk2) VALUES ('1', 'lw.png', ':|', ':-|')");
	  mysql_query("INSERT INTO smilie (packet, images_path, abk1, abk2) VALUES ('1', 'muede.png', ':-o', ':o')");
	  mysql_query("INSERT INTO smilie (packet, images_path, abk1, abk2) VALUES ('1', 'schock.png', '8O', '8-O')");
	  mysql_query("INSERT INTO smilie (packet, images_path, abk1, abk2) VALUES ('1', 'traurig.png', ':-(', ':(')");
	  //Neues Smilie-Packet
	  mysql_query("INSERT INTO smilie (packet, images_path, abk1, abk2) VALUES ('2', 'cool.png', '8-)', '8)')");
	  mysql_query("INSERT INTO smilie (packet, images_path, abk1, abk2) VALUES ('2', 'grins.png', ':)', ':-)')");
	  mysql_query("INSERT INTO smilie (packet, images_path, abk1, abk2) VALUES ('2', 'lach.png', ':D', ':-D')");
	  mysql_query("INSERT INTO smilie (packet, images_path, abk1, abk2) VALUES ('2', 'say-not-klein.png', ':|', ':-|')");
	  mysql_query("INSERT INTO smilie (packet, images_path, abk1, abk2) VALUES ('2', 'staun.png', ':-o', ':o')");
	  mysql_query("INSERT INTO smilie (packet, images_path, abk1, abk2) VALUES ('2', 'iws.png', '8O', '8-O')");
	  mysql_query("INSERT INTO smilie (packet, images_path, abk1, abk2) VALUES ('2', 'hmmm.png', ':-(', ':(')");
	  
	  echo "<br><br>Erfolgreich installiert!<br><br><br>Sollte im oberem Teil keine Fehlermeldung kommen, so geht es nun weiter zum nächstem Schritt.<br><a href=?do=install&s=4>Zum nächsten Schritt</a>";
	break;
	
	
	case "4":
	  schr("5");
	  echo "Als nächsten und letzten Schritt brauchen wir deine Administrator-Gründer Daten:<br><br>
	  <form action=?do=install&s=5 method=post>
	  <table>
	  <tr><td>Benutzername:</td><td><input type=text name=name></td></tr>
	  <tr><td>Passwort:</td><td><input type=password name=pw1></td></tr>
	  <tr><td>Passwort (wiederholung)</td><td><input type=password name=pw2></td></tr>
	  <tr><td>eMail-Adresse</td><td><input type=text name=mail></td></tr>
	  </table>
	  <input type=submit value='Administratoren Daten speichern'>
	  </table>
	  </form>";
	break;
	
	
	case "5":
	  schr("6");
	  include("config.php");

      mysql_connect($HOST,$USER,$PW)or die(mysql_error());
      mysql_select_db($DB)or die(mysql_error());
	  if($_POST["pw1"] != $_POST["pw2"])
	  {
	    echo "Die Passwörter stimmen nicht überein!<br>";
		exit;
	  }
	  $pw = md5($_POST["pw1"]);
      $time = time();
      $eintrag = mysql_query("INSERT INTO users (username, posts, reg_dat, last_log, reg_ip, sign, group_id, pw, mail, rang, last_site, gesperrt, pn_weiter, ava_link, adm_recht) VALUES ('$_POST[name]', '0', '$time', '', '$_SERVER[REMOTE_ADDR]', '', '3', '$pw', '$_POST[mail]', 'Administrator', '', '0', '1','','6')");
      echo "Danke $_POST[name], das du bigforum installiert hast.<br><br>Bitte lösche diese Datei nun, anderfalls kann jeder andere dieses Forum beschädigen.";
	break;
	
	}
	
  break;

}
?>
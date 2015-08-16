<?php
/*
Installations Datei

Änderungen an dieser Datei vermeiden, dieses könnte die installation fehlerhaft machen!
*/
?>
<title>bigforum - Installation</title>
<style>
body
{
	background: #FFFFFF;
	color: #000000;
}
.install
{
     background: #E1E4F2;
}
input.install_button {
	border: 4px double #0F5C8E;
	background: #ffffff
	color: #black;
	font-weight: bold;
}
</style>
<img src="images/install.jpg" border="0" width="25%" height="15%">
<table class="install" width="100%" height="100%"><tr><td valign=top align=top>
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
  echo "Vielen dank, dass Du dich für bigforum als Foren-Software entschieden hast.<br><br>Du kannst hier in <b>nur ca. 5 Minuten</b> das Forum installieren. Dank des Installations-Assistenten wird dir alles genau erklärt.<br><br><br><br>
  <input type=button class=install_button value='Komplettinstalation' onclick=\"location.href='?do=install&s=1'\"> &nbsp; &nbsp; &nbsp; <input type=button class=install_button value='Forum updaten' onclick=\"location.href='?do=update'\">";
  break;
  
  case "update":
    //Auswahl wie man updaten möchte
    echo "Bitte wähle aus, welche Version du hast, also von welcher du auf die neuste Updaten möchtest.<br><br>
	<form action=?do=update_query method=post>
	<select name=vers><option value=1>Von 5.5 oder 5.6 auf 6.0 </option></select>
	<br><br>
	<input type=submit class=install_button value='Forum updaten'><br><br><br>
	* <b>Wichtig:</b> Bei Sprüngen bei den Updates müssen die Datein hochgeladen werden, die Installation macht lediglich die Eintragungen in die Datenbank. Oder man lädt sich die Komplettversion der aktuellsten Version hoch, ganz wichtig aber, ohne die <i> config.php </i>.
	</form>";
  break;	
  
  case "update_query":
    schr("6");
	include("config.php");
    $schritte = "0";
    mysql_connect($HOST,$USER,$PW)or die(mysql_error());
    mysql_select_db($DB)or die(mysql_error());

	  mysql_query("CREATE TABLE IF NOT EXISTS profilnachricht ( 
      id INT(20) NOT NULL auto_increment,
      time INT(50) NOT NULL,
      post_by INT(50) NOT NULL,
      post_von INT(50) NOT NULL,
      dele INT(5) NOT NULL,
	  text varchar(12500) NOT NULL,  
	  PRIMARY KEY (id)
	  );

      ")or die(mysql_error()); 
	  
	  mysql_query("ALTER table users add erlaube_prona INT(2) NOT NULL");
	
	$schritte++;
	if($schritte == $_POST["vers"])
	{
      echo "Danke, du hast das Forum erfolgreich geupdatet..<br><br>
	  Sollten Fragen und/oder Probleme auftreten, bitte im <a href=www.bigforum-support.de>Support-Forum</a> nachfragen.<br><br>Die Installations-Datei wurde gelöscht.";
	  unlink("install.php");
	}
	else
	{
	  echo "<b>Fehler bei der Installation</b><br>Um den Fehler zu beheben schreibe bitte alle Fehlermeldungen, Schritte etc. im <a href=http://www.bfs.kilu.de target=_blank>Support-Forum</a>. Dort sollte dir geholfen werden.";
	}
  break;
  
  
  case "install":
  
    switch($s){
	
	case "1":
	  schr("2");
      echo "Viel dank, dass du bigforum installieren willst. Als erstes benötigen wir deine Datenbank-Daten:
	  <br><br>
	  <form action=?do=install&s=2 method=post>
	  <table>
	  <tr><td>Host (meistens localhost)</td><td><input type=text name=host value='localhost'></td></tr>
	  <tr><td>Datenbank-Name</td><td><input type=text name=dbn></td></tr>
	  <tr><td>Benutzername</td><td><input type=text name=benu></td></tr>
	  <tr><td>Passwort</td><td><input type=password name=pw1></td></tr>
	  <tr><td>Passwort (wiederholung)</td><td><input type=password name=pw2></td></tr>
	  </table>
	  <input type=submit value='Verbindung prüfen' class=install_button>
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
	  dele varchar(500) NOT NULL,
      PRIMARY KEY (id) );

      "); 
	  
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS passwort_verg ( 
      id INT(20) NOT NULL auto_increment,
      mail varchar(500) NOT NULL,
      time int(100) NOT NULL,
      passwort varchar(500) NOT NULL,
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
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS profilnachricht ( 
      id INT(20) NOT NULL auto_increment,
      time INT(50) NOT NULL,
      post_by INT(50) NOT NULL,
      post_von INT(50) NOT NULL,
      dele INT(5) NOT NULL,
	  text varchar(12500) NOT NULL,  
	  PRIMARY KEY (id)
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
	  beitrag_plus int(2) NOT NULL,
      PRIMARY KEY (id) );

      "); 
	  
	  	  mysql_query("CREATE TABLE IF NOT EXISTS addons ( 
      id INT(20) NOT NULL auto_increment,
      kurz varchar(300) NOT NULL,
      admin_link varchar(1000) NOT NULL,
      wert1 varchar(1000) NOT NULL,
      wert2 varchar(1000) NOT NULL,
	  wert3 varchar(1000) NOT NULL,
	  wert4 varchar(1000) NOT NULL,
      zahl1 int(50) NOT NULL,
      zahl2 int(50) NOT NULL,
      zahl3 int(50) NOT NULL,
      zahl4 int(50) NOT NULL,	  
	  PRIMARY KEY (id)
	  );

      "); 
	  
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS kate ( 

      id INT(20) NOT NULL auto_increment,
      name varchar(500) NOT NULL,
      besch varchar(800) NOT NULL,
	  ordn INT(12) NOT NULL,
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
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS adser ( 

      id INT(20) NOT NULL auto_increment,
      bannerad varchar(150) NOT NULL,
      link varchar(200) NOT NULL,
      klicks int(7) NOT NULL,
	  see int(9) NOT NULL,
      PRIMARY KEY (id) );

      "); 
	  
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS smilie ( 

      packet int(20) NOT NULL,
      images_path varchar(200) NOT NULL,
      abk1 varchar(80) NOT NULL,
      abk2 varchar(80) NOT NULL);

      "); 
	  
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS kontakt ( 
      id INT(20) NOT NULL auto_increment,
      user_id int(10) NOT NULL,
      friend_id int(10) NOT NULL,
      when_time int(50) NOT NULL,
      PRIMARY KEY (id) );
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
	  dele varchar(500) NOT NULL,
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
	  provi int(50) Not NULL,
	  editrech int(2) NOT NULL,
	  htmlcan int(2) NOT NULL,
	  darf_pn int(5) NOT NULL,
	  show_mail int(2) NOT NULL,
	  birthday int(140) NOT NULL,
	  erlaube_prona int(2) NOT NULL,
      PRIMARY KEY (id) );

      ");


	  mysql_query("CREATE TABLE IF NOT EXISTS verbo ( 

      id INT(20) NOT NULL auto_increment,
      name varchar(1000) NOT NULL,
      benemail int(7) NOT NULL,
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
	  
	   	 mysql_query("CREATE TABLE IF NOT EXISTS style_all ( 

      id INT(20) NOT NULL auto_increment,
      sname varchar(500) NOT NULL,
      link_style varchar(500) NOT NULL,
      PRIMARY KEY (id) );

      "); 
	  
	  
	  mysql_query("CREATE TABLE IF NOT EXISTS range ( 
      id INT(20) NOT NULL auto_increment,
      name varchar(300) NOT NULL,
      min_post INT(20) NOT NULL,
	  PRIMARY KEY (id)
	  );

      "); 


	//Ende
	  
	  //Ende
	  //Einfügen in Tabellen
	  mysql_query("INSERT INTO style_all (sname, link_style) VALUES ('brown', 'brownstyle.css')");
	  mysql_query("INSERT INTO style_all (sname, link_style) VALUES ('green', 'greenstyle.css')");
	  mysql_query("INSERT INTO style_all (sname, link_style) VALUES ('blue', 'bluestyle.css')");
	  mysql_query("INSERT INTO style_all (sname, link_style) VALUES ('red', 'redstyle.css')");
	  mysql_query("INSERT INTO range (name, min_post) VALUES ('Benutzer', '0')");
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2profs', 'j', '', '0', '1')");
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2name2', 'Bigforum', 'Das Forum', '0', '0')");
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2admin2', '', '', '0', '0')");
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2pnsignfs', 'images/logo_new.png', '', '1', '1')");
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2closefs', 'Allgemeine Arbeiten', '', '1', '0')");
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2imgadfs', 'images/old_post.png', 'images/new_post.png', '3', '0')");
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2laengfs', 'images/bfav.ico', 'brown', '10', '1')");
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2adser2', 'kreis', '', '0', '0')");
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2mf2', '', '', '1', '0')"); // Für Forenstatistik, und ob das Forum(z1) den eMail-Versand(z2) unterstüzt. 1=Ja 0 = Nein
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2bl2', '', '', '3', '20')"); // Benutzernamenlänge (w1) = Minimale Länge (w2) Maximale Länge
	  mysql_query("INSERT INTO config (erkennungscode, wert1, wert2, zahl1, zahl2) VALUES ('f2usearch2', '', '', '1', '0')"); //Wert1 Administratoren-Notiz //Zahl1 für Benutzersuche (1=aktiviert) // Zahl2 für RSS
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
	  echo "Als letzten Schritt benötigen wir deine Administratoren-Daten:<br><br>
	  <form action=?do=install&s=5 method=post>
	  <table>
	  <tr><td>Benutzername:</td><td><input type=text name=name></td></tr>
	  <tr><td>Passwort:</td><td><input type=password name=pw1></td></tr>
	  <tr><td>Passwort (Wiederholung)</td><td><input type=password name=pw2></td></tr>
	  <tr><td>eMail-Adresse</td><td><input type=text name=mail></td></tr>
	  </table>
	  <input type=submit value='Speichern' class=install_button>
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
      echo "Danke $_POST[name], dass du bigforum installiert hast.<br><br>Bitte lösche diese Datei nun, anderfalls kann jeder andere dieses Forum beschädigen.";
	break;
	
	}
	
  break;

}
?>
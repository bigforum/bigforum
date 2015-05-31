<?php
  //define - Tables
  if(file_exists("config.php"))
  {
    include("config.php");
  }
  else
  {
    if(file_exists("./config.php"))
	{
      include("./config.php");
	}
	else
	{
	  include("../config.php");
	}
  }
  mysql_connect($HOST,$USER,$PW)or die(mysql_error());
  mysql_select_db($DB)or die(mysql_error());
  $safty_login = mysql_query("SELECT * FROM users WHERE username LIKE '$_COOKIE[username]'");
  $sl = mysql_fetch_object($safty_login);
  if($sl->pw == $_COOKIE["passwort"] AND $sl->pw != "")
  {
    define("USER", $_COOKIE["username"]);
  }
  else
  {
     define("USER", "");
  }  
  define("HAUPT", "");
  define("MYSQLUSER", $USER);
  define("HOST", $HOST);
  define("MYSQLPASSWORT", $PW);
  define("MYSQLDB", $DB);
  if($daten["wert1"] == "")
    $daten["wert1"] = "Forum";
  define("SITENAME", $daten["wert1"]);
  define("BESCHREIBUNG", $daten['wert2']);
  define("VERSION", "5.2");
  
  //Ersetzte manche in Variablen
  $root = HAUPT;
?>
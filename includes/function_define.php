<?php
  //Aufrufung wichtiger Funktionen!
  
  //define - Tables
  define("USER", $_COOKIE["username"]);
  define("HAUPT", "");
  define("MYSQLUSER", $USER);
  define("HOST", $HOST);
  define("MYSQLPASSWORT", $PW);
  define("MYSQLDB", $DB);
  if($daten["wert1"] == "")
    $daten["wert1"] = "Forum";
  define("SITENAME", $daten["wert1"]);
  define("BESCHREIBUNG", $daten['wert2']);
  define("VERSION", "2.2");
  
  //Ersetzte manche in Variablen
  $root = HAUPT;
?>
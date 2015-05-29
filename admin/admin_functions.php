<?php
function insert_log($text)
{
  $time = time();
  $ip = $_SERVER["REMOTE_ADDR"];
  mysql_query("INSERT INTO admin_logs (username, time, aktio, ipadr) VALUE ('$_COOKIE[username]', '$time', '$text', '$ip')");
}
function admin_recht($zahl)
{
  $uac = mysql_query("SELECT * FROM users WHERE username LIKE '$_COOKIE[username]'");
  $ac = mysql_fetch_object($uac);
  if($ac->adm_recht < $zahl)
  {
    echo "<b>Info:</b> Du hast leider keine oder nicht genügend Rechte, diese Seite zu betreten.<br>Nur ein Gründer kann die Rechtevergabe ändern.";
	exit;
  }
}
function set_tab($code)
{
    $config_wert = mysql_query("SELECT * FROM config WHERE erkennungscode LIKE '$code'");
    $con = mysql_fetch_object($config_wert);
	define("WERTE", $con->wert1);
	define("WERTZ", $con->wert2);
	define("ZAHLE", $con->zahl1);
	define("ZAHLZ", $con->zahl2);
}
function left_table($an)
{
  echo "<table valign=top align=top bgcolor=#d8b284 width=100%><tr><td valign=top align=top width=20%>";
  for($i=0;$i<count($an);$i++)
  {
    $e = explode("|",$an[$i]);
    echo "<a href=$e[0]>$e[1]</a><br>";
  }
  echo "</td><td width=80% style=\"border-left:3px solid #ae8b61\">";
}
?>
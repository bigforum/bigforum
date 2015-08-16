<?php
if(USER == "")
{
  $username = "Gast";
}
else{
  $user_data = mysql_query("SELECT * FROM users WHERE username LIKE '$_COOKIE[username]'");
  $ud = mysql_fetch_object($user_data);
  $username = $_COOKIE["username"];
  gruppen_aufteilungen($ud->group_id);
  define("GROUP", $ud->group_id);
  define("MDPW", $ud->pw);
  
}
function pn_zahl($where)
{
  if(!empty($_COOKIE["username"])) // USER != GAST
  {
    $postein = "0";
	$postaus = "0";
	$gele = "0";
    $pn_zahl = mysql_query("SELECT * FROM prna WHERE abse LIKE '$_COOKIE[username]'");
	while($zahle = mysql_fetch_object($pn_zahl))
	{
	  $dd = explode("|", $zahle->abse);
/*if(isset($dd[1])) {
	  if($dd[1] != "del")
	  {*/
	    if($zahle->emp != $_COOKIE["username"])
	    {
	      $postaus++;	  
	    }
	//  }
	//}
}
	$pn_zahls = mysql_query("SELECT * FROM prna WHERE emp LIKE '$_COOKIE[username]'");
	while($zahles = mysql_fetch_object($pn_zahls))
	{

	  $d = explode("|", $zahles->emp);
/*if(isset($d[1])) {
	  if($d[1] != "del")
	  {*/
	    $postein++;	
        if($zahles->gel == "0")
        {  
	      $gele++;
        }	  
	  //}
	//}
}
	if($where == "header")
	{
	  //Nochmal eine MySQL - Abfrage, um sicherzugehen, das der Benutzer auch wirklich eine Nachricht hat
	  $user_data = mysql_query("SELECT * FROM users WHERE username LIKE '$_COOKIE[username]'");
      $ud = mysql_fetch_object($user_data);
	  
	  $zeichen = "";
	  $zeichen2 = "";
	  
	  if($ud->pn_weiter == "1")
	  {
	    $zeichen = "<span onmouseover=location.href='main.php?do=pn_ein'>";
		$zeichen2 = "</span>";
	  }
	  else
	  {
	    $zeichen = "<span style='cursor: pointer;' onclick=\"window.location.href='main.php?do=pn_ein'\">";
		$zeichen2 = "</span>";
	  }
	  $gesammt = $postein + $postaus;
	  if($gele == "0")
	    echo " <span style='cursor: pointer;' onclick=\"window.location.href='main.php?do=pn_ein'\">Posteingang: $postein Postausgang: $postaus Gesamt: $gesammt.</span>";
	  else
	    echo " <blink><font color=red>$zeichen Posteingang: $postein Postausgang: $postaus Gesamt: $gesammt. $zeichen2</font></blink>";
	}
  }
}
function gruppen_aufteilungen($wert)
{
  if($wert == "1")
  {
    $gruppe = "Benutzer";
  }
  if($wert == "2")
  {
    $gruppe = "Moderator";
  }
  if($wert == "3")
  {
    $gruppe = "Administrator";
  }

  if($wert == "4")
  {
    $gruppe = "Gesperrt";
  }
}
?>

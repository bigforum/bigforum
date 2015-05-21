<?php
function forum_error($text)
{
  echo "<b>Fehler: </b> $text";
  page_footer();
}
function load_function($id, $adm)
{
  echo "<form method=post action=?id=$id&do=change><select name=fu onchange=submit()><option value=> </option><option value=close>Thema schließen</option><option value=open>Themen öffnen</option><option value=wich>Als wichtig makieren</option><option value=wich>Makierung aufheben</option><option value=marknew>Thema als neu makieren</option><option value=delete>Thema löschen</option><option value=schieb>Thema verschieben</option></select></form>";
}
function answer_button($recht, $check_adm, $id, $close)
{
  if($close == "1")
  {
    $sta = "closed";
  }
  else
  {
    $sta = "answer";
  }
  if($recht == "1")
  {
    if($check_adm == "3")
    {
      echo "<table width=80%><tr><td><a href=newreply.php?id=$id><img src=images/$sta.png border=0 title=\"Antworten\" width=105 height=60></a></td><td align=right><b>Optionen:</b>";
	  load_function($id, $check_adm);
	  echo "</td></tr></table>";
    }
  }
  else
  {
    echo "<table width=80%><tr><td><a href=newreply.php?id=$id><img src=images/$sta.png border=0 title=\"Antworten\" width=105 height=60></a>";
	  if($check_adm == "3" OR $check_adm == "2")
	  {
	    echo "</td><td align=right><b>Optionen:</b>";
		load_function($id, $check_adm);
	  }
	echo "</td></tr></table>";
  }
}
?>
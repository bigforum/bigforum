<?php

/* Ein Mod/Addon, der einen Kalender ausgibt
Script by Potterfans
www.potterfans.npage.de
Version 1.1
*/
  function admin()
  {
    //Für diesen Mod sind Verwaltungen über das Admincp deaktiviert, da keine Benötigt werden.

  }
if($_SERVER['REQUEST_URI'] == "/cal.php")
{
include("includes/functions.php");
page_header();
          $today = date(d);
          $days = date(t);
          $month = date(m);
          $year = date(y);
          $firstday = mktime(0,0,1,$month,1,$year);
          $lastday = mktime(0,0,1,$month,$days,$year);
          $first = date(w,$firstday);
          $last = date(w,$lastday);
          $diff = 7-$last;
          $jahr = date(Y);

          $months = array("Januar", "Februar", "März", "April", "Mai", "Juni",
          "Juli", "August", "September", "Oktober", "November", "Dezember");
          $monat = $months[date("n", time())-1];

          if($first == 0) $first = 7;
          if($last == 0) $last = 7;
          
          for($i=1;$i<$first;$i++) {
          $begin.= "<td></td>";
          }

          for($i=0;$i<$diff;$i++) {
          $end.= "<td></td>";
          }
          
          echo "<table border= '0' cellspacing= '0 ' cellpadding= '0 '>
          <colgroup>
          <col width= '42 '>
          <col width= '42 '>
          <col width= '42 '>
          <col width= '42 '>
          <col width= '42 '>
          <col width= '42 '>
          <col width= '42 '>
          </colgroup>
          <tr class=navi>
          <th>Mo</th>
          <th>Di</th>
          <th>Mi</th>
          <th>Do</th>
          <th>Fr</th>
          <th>Sa</th>
          <th>So</th>
          </tr><tr>
          $begin";
          
          for($i=1;$i<($days+1);$i++) {
		  $x = $i;
		  //Festlegung festlicher Tage im Jahr
		  // Nur auflistung die Jährlich am selben Tag sind
		  if($i == "24" AND $monat == "Dezember")
		    $x = "<span title='Heiligabend'>$i</span>";
		  if($i == "25" AND $monat == "Dezember")
		    $x = "<span title='1. Weihnachtstag'><font color=red>$i</font></span>";
		  if($i == "26" AND $monat == "Dezember")
		    $x = "<span title='2. Weihnachtstag'><font color=red>$i</font></span>";
		  if($i == "31" AND $monat == "Dezember")
		    $x = "<span title='Silvester'>$i</span>";
		  if($i == "6" AND $monat == "Dezember")
		    $x = "<span title='Nikolaus'>$i</span>";
		  if($i == "1" AND $monat == "Januar")
		    $x = "<span title='Neujahr'><font color=red>$i</font></span>";
		  if($i == "6" AND $monat == "Januar")
		    $x = "<span title='Heilige drei Könige'>$i</span>";
		  if($i == "14" AND $monat == "Februar")
		    $x = "<span title='Valentinstag'>$i</span>";
		  if($i == "1" AND $monat == "Mai")
		    $x = "<span title='Maifeiertag'><font color=red>$i</font></span>";
		  if($i == "8" AND $monat == "August")
		    $x = "<span title='Friedensfest'>$i</span>";
		  if($i == "3" AND $monat == "Oktober")
		    $x = "<span title='Tag der deutschen Einheit'><font color=red>$i</font></span>";
		  if($i == "31" AND $monat == "Oktober")
		    $x = "<span title='Halloween / Reformationstag'>$i</span>";
		  if($i == "1" AND $monat == "November")
		    $x = "<span title='Allerheiligen'>$i</span>";
          if($first==0):
          echo "<tr>";endif;
          
		  if($first == 7)
		  {
		    $y = "<font color=red>$x</font>";
		  }
		  else
		  {
		    $y = $x;
		  }
		  
          if($i == $today) {
          echo "<td align='center'><b>$y</b></td>";
          }
          else {
          echo "<td align='center'>$y</td>";
          }
          
          if($first==7):
          echo "</tr>";
          $first=0;
          endif;
          
          $first++; 
          
          }
          
          echo "$end</tr>";
          echo "<tr class=navi><td colspan='7' align='center'><b>$monat $jahr</b></td></tr>";
          echo "</table>";
          
page_footer();
}
?>
<?php
$name_plug = "Header-Links l�scher";  //Name des Addons
$ref  = "25fe52550"; //Zufallskombination aus Zahlen und Buchstaben => Bitte bei jedem Mod anders. Die l�nge ist egal.
$kurzc = "Header-Links l�scher"; // Name wie er im Admincp angezeigt wird.
function plugin_install($kurzc, $datei)
{
  /*
  Die Tabelle von addons verf�gt �ber 3 Abfragen f�r Werte , wo texte eingef�gt werden k�nnen, und drei f�r zahlen.
  Wenn mehr ben�tigt werden, kann man diese hier einfach mit installieren.
  Wenn im untengennanten die Spalte "admin_link" keine Eingabe erh�lt, wird der Mod im Adminbereich nicht verkn�pft, auch wenn die Funktion plugin_admin vorhanden ist.
  */
  mysql_query("INSERT INTO addons (kurz, admin_link) VALUES ('$kurzc', '$datei')") or die(mysql_error());
}
function plugin_admin()
{
  // Hier in diesem Bereich wird der komplette Bereich f�r den Adminbereich programmiert. Es wird genauso angezeigt, wie hier eingegeben.
  echo "Willkommen im Addon-Bereich dieses Addons. Dieser Addon ist nicht wirklich sehr n�tzlich, er soll jedoch nur die Aufgabe, und die Funktionsweise der Addons beweisen.<br>
  <form action='' method=post name=d><input type=hidden value='' name='header'><input type=submit value='Alle Header Nachrichten ausbelden' onclick=\"d.header.value='ja'\"></form>";
  if(!empty($_POST["header"]))
  {
    mysql_query("UPDATE config SET wert2 = '' WHERE erkennungscode LIKE 'f2closefs'")or die(mysql_error());
    echo "Danke, es wurden alle Header-Links gel�scht.";
  }
}
?>
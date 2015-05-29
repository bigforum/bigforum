<?php
$name_plug = "Header-Links löscher";  //Name des Addons
$ref  = "25fe52550"; //Zufallskombination aus Zahlen und Buchstaben => Bitte bei jedem Mod anders. Die länge ist egal.
$kurzc = "Header-Links löscher"; // Name wie er im Admincp angezeigt wird.
function plugin_install($kurzc, $datei)
{
  /*
  Die Tabelle von addons verfügt über 3 Abfragen für Werte , wo texte eingefügt werden können, und drei für zahlen.
  Wenn mehr benötigt werden, kann man diese hier einfach mit installieren.
  Wenn im untengennanten die Spalte "admin_link" keine Eingabe erhält, wird der Mod im Adminbereich nicht verknüpft, auch wenn die Funktion plugin_admin vorhanden ist.
  */
  mysql_query("INSERT INTO addons (kurz, admin_link) VALUES ('$kurzc', '$datei')") or die(mysql_error());
}
function plugin_admin()
{
  // Hier in diesem Bereich wird der komplette Bereich für den Adminbereich programmiert. Es wird genauso angezeigt, wie hier eingegeben.
  echo "Willkommen im Addon-Bereich dieses Addons. Dieser Addon ist nicht wirklich sehr nützlich, er soll jedoch nur die Aufgabe, und die Funktionsweise der Addons beweisen.<br>
  <form action='' method=post name=d><input type=hidden value='' name='header'><input type=submit value='Alle Header Nachrichten ausbelden' onclick=\"d.header.value='ja'\"></form>";
  if(!empty($_POST["header"]))
  {
    mysql_query("UPDATE config SET wert2 = '' WHERE erkennungscode LIKE 'f2closefs'")or die(mysql_error());
    echo "Danke, es wurden alle Header-Links gelöscht.";
  }
}
?>
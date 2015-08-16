<?php
include_once("includes/functions.php"); 
include_once("includes/function_user.php");
page_header();
looking_page("help");
$do = $_GET['do'];

echo '<table width="100%">
<tr><td valign="top" width="25%">
<!-- Navigation -->

<table width="100%">
<tr><td class=normal color="snow"><b>Allgemein</b></td></tr><ul>
<tr><td><li><a href="?do=admins" target="_self">Administratoren u. Moderatoren</a></li></td></tr>
<tr><td><li><a href="?do=addons" target="_self">Modifikationen und Addons</a></li></td></tr>
<tr><td><li><a href="?do=rss" target="_self">RSS-Feed</a></li></td></tr>
<tr><td><li><a href="?do=pw_forgot" target="_self">Passwort vergessen</a></li></td></tr>
<tr><td><li><a href="?do=warn_sperre" target="_self">Verwarnungen / Gesperrt</a></li></td></tr>

<tr><td class=normal color="snow"><b>Foren, Themen und Beitr�ge</b></li></td></tr>
<tr><td><li><a href="?do=no_create" target="_self">Erstellungsprobleme</a></li></td></tr>
<tr><td><li><a href="?do=beitraege" target="_self">Beit�ge</a></li></td></tr>
<tr><td><li><a href="?do=important_thema" target="_self">Wichtige Themen</a></li></td></tr>

<tr><td class=normal color="snow"><b>Pers�nliche Einstellungen</b></li></td></tr>
<tr><td><li><a href="?do=per_allgemein" target="_self">Allgemein / Profil</a></li></td></tr>
<tr><td><li><a href="?do=profilnachrichten" target="_self">Profilnachrichten</a></li></td></tr>
<tr><td><li><a href="?do=per_desing" target="_self">Desing</a></li></td></tr>
<tr><td><li><a href="?do=pns" target="_self">Private Nachrichten</a></li></td></tr>
</ul></table></td><td width="1%"></td><td valign=top>';

if($do == "") { echo ' Willkommen, in der Hilfe. Sie finden hier einige Informationen zu den Forum-Funktionen wie sie u.a. funktionieren. Rechts finden sie eine Navigation mit der sie sich in der Hilfe zurecht finden.'; }

if($do == "admins") { echo "<h3>Administratoren und Moderatoren</h3>
<b>Was sind Administratoren und was machen sie?</b><br>
	Administratoren haben die meisten Rechte und verwalten das Forum. 
<br><br><b>Was sind Moderatoren?</b><br>
	Moderatoren haben mehr Rechte als ein Benutzer und weniger Rechte als Administratoren. Moderatoren leiten das Forum und helfen so den Administratoren.
"; }
if($do == "addons") { echo "<h3>Modifikationen und Addons</h3>
<b>Was sind Modifikationen bzw. Addons?</b><br>
	Modifikationen und Addons passen das Forum an und erweitern es mit neuen Funktionen.
"; }
if($do == "rss") { echo "<h3>RSS-Feed</h3>
<b>Was ist ein RSS-Feed?</b><br>
	Ein RSS-Feed ist eine Art Nachrichtenticker der �ber neue Geschehnisse informiert. In den Forum RSS-Feed stehen immer die neusten 10 Themen, allerdings muss der Feed aktiviert sein.
"; }
if($do == "pw_forgot") { echo "<h3>Passwort vergessen</h3>
<b>Ich habe mein Passwort vergessen was nun?</b><br>
   Sie k�nnen sich <a href='misc.php?aktion=lost_pw' target='_blank'>hier</a> ein neues Passwort zuschicken lassen, beachten sie bitte das dies nur funktioniert wenn der E-Mail Versand im Forum aktiviert ist. Sollte der E-mail Versand deaktiviert sein wenden sie sich bitte an einen Administrator.
"; }
if($do == "warn_sperre") { echo "<h3>Verwarnungen / Sperre</h3>
<b>Was ist eine Verwarnung?</b><br>
	Eine Verwarnung bekommen sie wenn sie sich nicht an den Foren-Regeln halten.
<br><br><b>Ich habe eine Verwarnung erhalten was nun?</b><br>
	Bei einer Verwarnung werden sie noch nicht gleich gesperrt also keine Panik. Es sei den sie haben einen sehr schweren Versto� gegen den Regeln gemacht, dann kann es eventuell passieren das sie sofort gesperrt werden. Nach einer bestimmten Zeit verfallen die Verwarnungen, wann das ist sehen sie bei ihren Verwarnungen falls sie welche haben.
<br><br><b>Was passiert bei einer Sperre?</b><br>
	Bei einer Sperre k�nnen sie keine Funktionen des Forums mehr nutzen, das einzige was sie in diesen Zustand noch k�nnen ist im ausgeloggten Zustand die Themen und Beitr�ge lesen. Wann die Sperre verf�llt sehen sie wenn sie eingeloggt sind.
"; }
if($do == "no_create") { echo "<h3>Erstellungsproblemen von Themen und Beitr�ge</h3>
<b>Wieso kann ich keine Themen erstellen?</b><br>
	Administratoren k�nnen das erstellen von Themen in einen Forum f�r Benutzer und Moderatoren verbieten. K�nnen sie in keinen Forum Themen erstellen wenden sie sich an einen Administrator.
<br><br><b>Wieso kann ich keine Beitr�ge erstellen?</b><br>
	Auch hier k�nnen Administratoren das verfassen von Beitr�gen f�r Benutzer und Moderatoren verbieten. Wurde das jeweilige Thema geschlossen k�nnen sie auch nicht mehr antworten.
"; }
if($do == "beitraege") { echo "<h3>Beitr�ge</h3>
<b>Wieso wird mein Beitr�gez�hler nicht erh�ht wenn ich einen Beitrag schreibe?</b><br>
	Administratoren k�nnen f�r Foren ausw�hlen ob der Beitragsz�hler erh�ht werden soll.
<br><br><b>Kann ich meinen Beitrag bearbeiten?</b><br>
	Selbstverst�ndlichen k�nnen sie ihre Beitr�ge mit klick auf den Button <img src='images/edit.png' height='22px' alt=''> bearbeiten.
<br><br><b>Wie kann ich meinen Beitrag l�schen?</b><br>
	Sie k�nnen ihren Beitrag l�schen in dem sie auf den Button <img src='images/del.png' height='22px' alt=''> neben den Bearbeitungsbutton klicken.
"; }
if($do == "important_thema") { echo "<h3>Wichtige Themen</h3>
<b>Was sind wichtige Themen?</b><br>
	Die Forum-Leitung kann Themen als wichtig markieren damit wollen sie auf das Thema besonders hinweisen. In den meisten F�llen sollten sie sich solche Themen durch lesen.
"; }
if($do == "per_allgemein") { echo "<h3>Allgemeine pers�nliche Einstellungen</h3>
<b>Passwort</b><br>
	Das Passwort k�nnen sie im Pers�nlichen Bereich unter 'Passwort �ndern' �ndern.
<br><br><b>Was sind Avatare?</b><br>
	Avatare sind kleine Bilder die ihn ihren Profil und bei Beitr�gen im Forum neben ihren Benutzernamen angezeigt werden.
<br><br><b>Wie �ndere ich mein Avatar?</b><br>
	Sie k�nnen im Pers�nlichen Bereich unter 'Avatar' ein neues Bild hochladen.
<br><br><b>Was ist eine Signatur?</b><br>
	Eine Signatur ist ein Anhang der Standart m�ssig an jeden Beitrag von ihnen angeh�ngt wird, ausserdem ist ihre Signatur auch in ihren Profil zu finden. In ihrer Signatur k�nnen sie BB-Codes zur Formatierung verwenden. Ihre Signatur k�nnen sie im Pers�nlichen Bereich �ndern.
<br><br><b>Wie kann ich mein Profil bearbeiten?</b><br>
	Dein Avatar und deine Signatur sind ein Teil deines Profiles weitere Angaben sind dein Geburtstag deine Hobbys und deine Webseite. Diese Angaben kannst du im Pers�nlichen Bereich unter 'Mein Profil' bearbeiten.
"; }
if($do == "profilnachrichten") { echo "<h3>Profilnachrichten</h3>
<b>Was sind Profilnachrichten?</b><br>
	Profilnachrichten sich �ffentliche Nachrichten an einen Benutzer die in seinen Profil angezeigt werden. Jeder der das Profil des Benutzer sehen kann an den die Profilnachricht geht, kann auch die Profilnachrichten lesen.
<br><br><b>Wie erstelle ich eine Profilnachrichten?</b><br>
	Rufen sie das Profil des Benutzers auf an den sie eine Profilnachricht schreiben wollen. Klicken sie auf den Tab 'Profilnachrichten' und anschlie�end auf 'Benutzerxyz eine Profilnachricht schreiben'.
"; }
if($do == "per_desing") { echo "<h3>Einstellen des Desings</h3>
<b>Wie kann ich das Desing des Forums ver�ndern?</b><br>
	Falls dieses Forum mehrere Desings bereit stellt k�nnen sie das Desing im Pers�nlichen Bereich unter 'Sonstige Einstellungen' �ndern.
"; }
if($do == "pns") { echo "<h3>Private Nachrichten</h3>
<b>Wie funktioniert das Private Nachrichten System?</b><br>
	Das Private Nachrichten System kann von Administratoren f�r alle und f�r einzelle Benutzer deaktiviert werden. Ausserdem k�nnen alle Benutzer einstellen von wenn sie Private Nachrichten erhalten m�chten, dies ist im Pers�nlichen Bereich unter 'Sonstige Einstellungen' m�glich.
"; }

?>
</td>
</tr></table>

<?php
page_footer ();
?>
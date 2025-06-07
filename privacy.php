<?php
include 'inc/lang.php';
if (file_exists('settings.php')) {
    include 'settings.php';
} else {
    include 'settings.php.bak';
}
include 'navbar.php';
?>
<div class="container py-4">
  <h1>Datenschutz</h1>
  <p>Der Schutz deiner Daten ist uns wichtig. Nachfolgend erkl&auml;ren wir, welche Informationen wir im Rahmen der Nutzung von Rankify verarbeiten und zu welchem Zweck dies geschieht.</p>

  <h3>Verantwortliche Stelle</h3>
  <p><?=htmlspecialchars($ADMIN_NAME)?><br><?=nl2br(htmlspecialchars($ADMIN_ADDRESS))?><br>E-Mail: <a href="mailto:<?=htmlspecialchars($ADMIN_EMAIL)?>"><?=htmlspecialchars($ADMIN_EMAIL)?></a></p>

  <h3>Nutzungsdaten</h3>
  <p>Beim Aufruf dieser Webseite werden technisch bedingt Daten wie IP-Adresse und Zeitpunkt in Server-Logfiles gespeichert. Diese Daten ben&ouml;tigen wir, um den Dienst bereitzustellen und Angriffe abzuwehren. Eine Zusammenf&uuml;hrung mit anderen Daten erfolgt nicht.</p>

  <h3>Sitzungsdaten</h3>
  <p>Die Vergleiche, die du im Rahmen eines Kartensets vornimmst, werden vor&uuml;bergehend in einer Server-Session gespeichert. Dadurch kannst du ein begonnenes Set fortsetzen. Nach Abschluss oder L&ouml;schung der Session werden die Daten automatisch gel&ouml;scht.</p>

  <h3>Cookies und lokale Speicherung</h3>
  <ul>
    <li><strong>rankify_history</strong>: speichert deine letzten Ergebnisse lokal im Browser, damit du sie im Profil einsehen kannst.</li>
    <li><strong>lang</strong>: merkt sich die von dir gew&auml;hlte Sprache.</li>
    <li><strong>rankifmy_demografie</strong>: optional von dir angegebene demografische Informationen zur Verbesserung der Vergleichswerte.</li>
  </ul>
  <p>Dar&uuml;ber hinaus speichern wir deine Musikeinstellungen im LocalStorage deines Browsers.</p>

  <h3>Kontaktaufnahme</h3>
  <p>Wenn du uns &uuml;ber das Kontaktformular schreibst, werden deine Angaben zur Bearbeitung der Anfrage verwendet. Eine Weitergabe an Dritte findet nicht statt.</p>

  <h3>Deine Rechte</h3>
  <p>Du hast das Recht auf Auskunft, Berichtigung, L&ouml;schung und Einschr&auml;nkung der Verarbeitung deiner personenbezogenen Daten. Kontaktiere uns dazu &uuml;ber die oben genannten Kontaktdaten.</p>

  <h3>Zweck der Datenverarbeitung</h3>
  <p>Alle erhobenen Daten dienen ausschlie&szlig;lich dazu, dir die Nutzung von Rankify zu erm&ouml;glichen und den Dienst weiter zu verbessern. Wir verfolgen kein kommerzielles Interesse und f&uuml;hren keine Nutzerprofile zusammen.</p>

  <h3>Speicherdauer</h3>
  <p>Sitzungsdaten werden automatisch entfernt, sobald du das Browserfenster schlie&szlig;t oder das Set zur&uuml;cksetzt. Cookies bleiben bis zu einem Jahr gespeichert, k&ouml;nnen aber jederzeit von dir gel&ouml;scht werden.</p>

  <p>Bei Fragen erreichst du uns unter <a href="mailto:<?=htmlspecialchars($ADMIN_EMAIL)?>"><?=htmlspecialchars($ADMIN_EMAIL)?></a>.</p>
</div>
<?php include 'footer.php'; ?>
</body>
</html>

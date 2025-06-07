<?php
include 'inc/lang.php';
include 'navbar.php';
?>
<div class="container py-4">
  <h1>H&auml;ufige Fragen</h1>
  <p class="lead">Hier findest du Antworten auf die wichtigsten Fragen rund um Rankify und die zugrunde liegenden Methoden.</p>
  <div class="accordion" id="faqList">
      <div class="accordion-item">
        <h2 class="accordion-header" id="q1"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#a1">Was ist Rankify?</button></h2>
        <div id="a1" class="accordion-collapse collapse show" data-bs-parent="#faqList">
          <div class="accordion-body">Rankify hilft dir, Priorit&auml;ten transparent zu machen. Durch Paarvergleiche ermittelst du spielerisch eine Rangfolge deiner Optionen.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q2"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a2">Wie funktioniert die Methode?</button></h2>
        <div id="a2" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body">Unsere Berechnung orientiert sich an etablierten psychologischen Modellen des Paarvergleichs und nutzt Algorithmen wie Thurstone oder Bradley&ndash;Terry.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q3"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a3">Sind meine Daten sicher?</button></h2>
        <div id="a3" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body">Ja. Es werden nur anonyme Daten gespeichert, um dir und anderen bessere Vergleiche zu erm&ouml;glichen. Details findest du in unserer Datenschutzerkl&auml;rung.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q4"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a4">Welche psychologischen Hintergr&uuml;nde gibt es?</button></h2>
        <div id="a4" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body">Paarvergleiche werden seit &uuml;ber hundert Jahren genutzt, um subjektive Bewertungen messbar zu machen. Sie stammen aus der Psychologie der Entscheidungsforschung und helfen dabei, latente Vorlieben sichtbar zu machen.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q5"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a5">Was hat das mit Mathematik zu tun?</button></h2>
        <div id="a5" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body">Hinter den Ranglisten stecken statistische Modelle. Wir berechnen aus deinen Entscheidungen Punktwerte und Wahrscheinlichkeiten, um eine stabile Reihenfolge zu sch&auml;tzen. Mehr dazu findest du in der Literatur zu Thurstone und Bradley&ndash;Terry.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q6"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a6">Warum ist das p&auml;dagogisch sinnvoll?</button></h2>
        <div id="a6" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body">Durch bewusstes Vergleichen reflektierst du deine Werte. Diese Selbstreflexion f&ouml;rdert eigenverantwortliche Entscheidungen und kann z.&nbsp;B. in der Bildungsarbeit oder Beratung eingesetzt werden.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q7"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a7">Was bedeutet Ranking neuropsychologisch?</button></h2>
        <div id="a7" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body">Beim Priorisieren werden Belohnungs- und Bewertungssysteme im Gehirn aktiviert. Indem du Alternativen gegeneinander abw&auml;gst, trainierst du die F&auml;higkeit zur Selbstregulation.</div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q8"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a8">Welches Ziel hat diese Seite?</button></h2>
        <div id="a8" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body">Rankify soll dir einen einfachen Zugang zu Methoden bieten, mit denen du pers&ouml;nliche Priorit&auml;ten erkennen und mit anderen diskutieren kannst. Alle Funktionen sind frei nutzbar und sollen vor allem zum Nachdenken anregen.</div>
        </div>
      </div>
  </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>

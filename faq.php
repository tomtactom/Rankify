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
  </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>

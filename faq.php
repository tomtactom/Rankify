<?php
include 'inc/lang.php';
include 'navbar.php';
?>
<div class="container py-4">
  <h1><?=t('faq_title')?></h1>
  <p class="lead"><?=t('faq_intro')?></p>
  <div class="accordion" id="faqList">
      <div class="accordion-item">
        <h2 class="accordion-header" id="q1"><button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#a1"><?=t('faq_q1')?></button></h2>
        <div id="a1" class="accordion-collapse collapse show" data-bs-parent="#faqList">
          <div class="accordion-body"><?=t('faq_a1')?></div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q2"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a2"><?=t('faq_q2')?></button></h2>
        <div id="a2" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body"><?=t('faq_a2')?></div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q3"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a3"><?=t('faq_q3')?></button></h2>
        <div id="a3" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body"><?=t('faq_a3')?></div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q4"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a4"><?=t('faq_q4')?></button></h2>
        <div id="a4" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body"><?=t('faq_a4')?></div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q5"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a5"><?=t('faq_q5')?></button></h2>
        <div id="a5" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body"><?=t('faq_a5')?></div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q6"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a6"><?=t('faq_q6')?></button></h2>
        <div id="a6" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body"><?=t('faq_a6')?></div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q7"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a7"><?=t('faq_q7')?></button></h2>
        <div id="a7" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body"><?=t('faq_a7')?></div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q8"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a8"><?=t('faq_q8')?></button></h2>
        <div id="a8" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body"><?=t('faq_a8')?></div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q9"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a9"><?=t('faq_q9')?></button></h2>
        <div id="a9" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body"><?=t('faq_a9')?></div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="q10"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#a10"><?=t('faq_q10')?></button></h2>
        <div id="a10" class="accordion-collapse collapse" data-bs-parent="#faqList">
          <div class="accordion-body"><?=t('faq_a10')?></div>
        </div>
      </div>
  </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>

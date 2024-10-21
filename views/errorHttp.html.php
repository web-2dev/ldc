<?php pr($_SERVER["REQUEST_URI"]); ?>
<h1>Erreur <?= $code ?> : <?= $msg ?></h1>

<a href="/" class="btn btn-secondary">
    <span class="bi-skip-backward"></span>
</a>
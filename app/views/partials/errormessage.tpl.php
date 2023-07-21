<?php if (! empty($errorList)) : ?>
            <div class="alert alert-danger" role="alert">
                <?php foreach ($errorList as $currentError) : ?>
                    <div><?= $currentError; ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>


 
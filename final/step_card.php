<div class="<?php echo $sectionClass; ?>">
    <?php if ($isOdd): ?>
        <div class="<?php echo $textClass; ?>">
            <h2>Step <?php echo $stepCount; ?></h2>
            <p><?php echo nl2br(htmlspecialchars($step)); ?></p>
        </div>
        
        <img class="recipe-step-img" src="<?php echo $stepImg; ?>" alt="Step <?php echo $stepCount; ?>">

    <?php else: ?>
        <img class="recipe-step-img" src="<?php echo $stepImg; ?>" alt="Step <?php echo $stepCount; ?>">

        <div class="<?php echo $textClass; ?>">
            <h2>Step <?php echo $stepCount; ?></h2>
            <p><?php echo nl2br(htmlspecialchars($step)); ?></p>
        </div>
    <?php endif; ?>
</div>
<?php
require_once 'config.php';

// 1. Get Recipe ID
$recipeId = $_GET['id'] ?? 0;
$stmt = $connection->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->bind_param("i", $recipeId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $recipeFound = false;
} else {
    $recipeFound = true;
    $recipe = $result->fetch_assoc();

    $imagesArray = explode(",", $recipe['images']);
    $imagesArray = array_map('trim', $imagesArray);

    $ingredientsList = explode("\n", $recipe['ingredients']);
    $ingredientsList = array_filter($ingredientsList, 'trim'); // Remove empty lines
    
    $totalIngs = count($ingredientsList);
    $half = ceil($totalIngs / 2);
    $ingCol1 = array_slice($ingredientsList, 0, $half);
    $ingCol2 = array_slice($ingredientsList, $half);

    $toolsList       = explode("\n", $recipe['tools']); 
    $toolDescription = $recipe['tool_description'];

    $stepsList = explode("*", $recipe['steps']);
    $stepsList = array_map('trim', $stepsList);
    $stepsList = array_filter($stepsList); 

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $recipeFound ? htmlspecialchars($recipe['name']) : 'Not Found'; ?> | Sizzle</title>
    <link rel="stylesheet" href="styles.css"> 
</head>
<body>

<?php 
    if (!$recipeFound) {
        echo "<h1>Recipe not found</h1>";
        exit;
    }
    include '_header.php'; 
?>

    <section class="pesto-sandwich">
        <div class="hero-pesto">
            <img src="<?php echo $imagesArray[0]; ?>" alt="Hero Image">
            <div class="pesto-text">
                <h2><?php echo htmlspecialchars($recipe['name']); ?></h2>
                <p><?php echo nl2br(htmlspecialchars($recipe['description'])); ?></p>
            </div>
        </div>
    </section>

    <section class="pesto-sandwich" style="margin-bottom: 2rem;">
        <h2 style="text-align: center; margin-bottom: 1rem;">Ingredients</h2>
        <div class="ingredients-columns" style="justify-content: center;">
            <ul style="list-style: none; text-align: left;">
                <?php foreach ($ingCol1 as $ing): ?>
                    <li style="margin-bottom: 0.5rem;"><?php echo htmlspecialchars($ing); ?></li>
                <?php endforeach; ?>
            </ul>
            <ul style="list-style: none; text-align: left;">
                <?php foreach ($ingCol2 as $ing): ?>
                    <li style="margin-bottom: 0.5rem;"><?php echo htmlspecialchars($ing); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <?php if (!empty($recipe['tools'])): ?>
    <section class="tools-pesto">
        <div class="pesto-text">
            <h2>Tool: <?php echo htmlspecialchars(implode(", ", $toolsList)); ?></h2>
            <p><?php echo nl2br(htmlspecialchars($toolDescription)); ?></p>
        </div>
        <img src="<?php echo $imagesArray[1] ?? ''; ?>" alt="Kitchen Tool">
    </section>
    <?php endif; ?>

    <?php 
    $stepCount = 1;
    $imageIndex = 2; 

    foreach ($stepsList as $step): 
        if(empty(trim($step))) continue;

        $cleanStepText = preg_replace('/^Step\s+\d+:\s*/i', '', $step);

        $isOdd = ($stepCount % 2 != 0);
        $sectionClass = $isOdd ? 'pesto-1-dark' : 'tools-pesto'; 
        
        $titleClass   = $isOdd ? 'large' : 'large-light';
        $textClass    = $isOdd ? 'pesto-1-text' : 'pesto-text';
        $imgClass     = $isOdd ? 'pesto-img' : '';
        $stepImg      = $imagesArray[$imageIndex] ?? $imagesArray[0];
        
        $step = $cleanStepText; 

        include 'step_card.php';

        $stepCount++;
        $imageIndex++;
    endforeach; 
    ?>

    <?php $connection->close(); ?>
</body>
</html>
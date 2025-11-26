<?php
require_once 'config.php';

$recipeId = $_GET['id'] ?? 0;

$stmt = $connection->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->bind_param("i", $recipeId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Recipe not found.";
    exit;
}

$recipe = $result->fetch_assoc();

$imagesArray = explode(",", $recipe['images']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($recipe['name']); ?> | Sizzle</title>
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="normalize.css">
<link rel="icon" href="icon.png">
</head>
<body>

<?php include '_header.php'; ?>

<section class="recipe-detail">
    <h1><?php echo htmlspecialchars($recipe['name']); ?></h1>
    <p><?php echo htmlspecialchars($recipe['description']); ?></p>

    <div class="recipe-images">
        <?php foreach ($imagesArray as $img): ?>
            <img src="<?php echo trim($img); ?>" alt="<?php echo htmlspecialchars($recipe['name']); ?>">
        <?php endforeach; ?>
    </div>
</section>

<?php $connection->close(); ?>
</body>
</html>

<?php
// 1. Connect to the database
require_once 'config.php';

// 2. Search Logic (Safe Prepared Statement)
$searchTerm = isset($_GET['search']) ? trim($_GET['search']) : '';

if (!empty($searchTerm)) {
    $sql = "SELECT * FROM recipes WHERE name LIKE ? OR description LIKE ? OR ingredients LIKE ?";
    $stmt = $connection->prepare($sql);
    $likeTerm = "%" . $searchTerm . "%";
    $stmt->bind_param("sss", $likeTerm, $likeTerm, $likeTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM recipes";
    $result = $connection->query($sql);
}

function getRecipeTags($row) {
    $tags = [];
    $text = strtolower($row['name'] . ' ' . $row['description']);
    if (strpos($text, 'chicken') !== false) $tags[] = 'Chicken';
    if (strpos($text, 'pork') !== false || strpos($text, 'chorizo') !== false || strpos($text, 'sausage') !== false) $tags[] = 'Pork';
    if (strpos($text, 'shrimp') !== false || strpos($text, 'fish') !== false || strpos($text, 'salmon') !== false || strpos($text, 'tilapia') !== false) $tags[] = 'Seafood';
    if (strpos($text, 'eggs') !== false || strpos($text, 'quiche') !== false || strpos($text, ' egg') !== false) {
        $tags[] = 'Egg';
    }
    if (strpos($text, 'pasta') !== false || strpos($text, 'spaghetti') !== false || strpos($text, 'bucatini') !== false || strpos($text, 'fregola') !== false) $tags[] = 'Pasta';
    if (strpos($text, 'sandwich') !== false || strpos($text, 'burger') !== false) $tags[] = 'Sandwich';
    if (strpos($text, 'salad') !== false) $tags[] = 'Salad';
    if (strpos($text, 'taco') !== false) $tags[] = 'Tacos';
    if (strpos($text, 'vegetarian') !== false || strpos($text, 'meatless') !== false) {
        $tags[] = 'Vegetarian';
    }

    return array_unique($tags);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sizzle | Recipes</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="normalize.css">
    <link rel="icon" href="icon.png">
</head>
<body>

    <?php include '_header.php'; ?>

    <section class="recipes-main">

        <div class="search">
            <button id="show-all" class="active">Show All</button>
            <button class="filter-chicken">Chicken</button>
            <button class="filter-pork">Pork</button>
            <button class="filter-seafood">Seafood</button>
            <button class="filter-vegetarian">Vegetarian</button>
            <button class="filter-pasta">Pasta</button>
            <button class="filter-sandwich">Sandwich</button>
            <button class="filter-salad">Salad</button>
            <button class="filter-egg">Egg</button>
            <button class="filter-tacos">Tacos</button>
        </div>

        <div class="recipes">
            <div id="no-results-message" style="display: none;">
                <h3>Sorry, no recipes match your filters!</h3>
                <p>Try removing a filter to see more options.</p>
            </div>

            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $imagesArray = explode(",", $row['images']);
                    $mainImage = trim($imagesArray[0]);
                    
                    $tags = getRecipeTags($row);
                    ?>

                    <div class="recipe-card">
                        <a href="recipe.php?id=<?php echo $row['id'];?>" class="recipe-hover">
                            <img src="<?php echo $mainImage; ?>" alt="<?php echo $row['name']; ?>">
                        </a>
                        
                        <div class="recipe-info">
                            <h3 class="recipe-title">
                                <a href="recipe.php?id=<?php echo $row['id'];?>"><?php echo $row['name']; ?></a>
                            </h3>

                            <ul class="recipe-tags" style="display:none;"> 
                                <?php foreach ($tags as $tag): ?>
                                    <li><?php echo $tag; ?></li>
                                <?php endforeach; ?>
                            </ul>

                            <p class="recipe-description">
                                <?php echo $row['description']; ?>
                            </p>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p style='text-align:center; width:100%;'>No recipes found in the database.</p>";
            }
            ?>

        </div>
    </section>

    <?php $connection->close(); ?>

    <script src="filter.js" defer></script>
</body>
</html>
<?php
// 1. Connect to the database
require_once 'config.php';

// 2. Get recipes from the database
$sql = "SELECT * FROM recipes";
$result = $connection->query($sql);
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
            <button class="filter-beef">Beef</button>
            <button class="filter-chicken">Chicken</button>
            <button class="filter-vegetarian">Vegetarian</button>
            <button class="filter-pasta">Pasta</button>
            <button class="filter-sandwich">Sandwich</button>
            </div>

        <div class="recipes">
            <div id="no-results-message" style="display: none;">
                <h3>Sorry, no recipes match your filters!</h3>
                <p>Try removing a filter to see more options.</p>
            </div>

            <?php
            // 4. Check if there are recipes
            if ($result->num_rows > 0) {
                // 5. Loop through each recipe in the database
                while($row = $result->fetch_assoc()) {
                    ?>

                    <div class="recipe-card">
                        <a href="pesto.html" class="recipe-hover">
                            <img src="<?php echo $row['images']; ?>" alt="<?php echo $row['name']; ?>">
                        </a>
                        
                        <div class="recipe-info">
                            <h3 class="recipe-title">
                                <a href="pesto.html"><?php echo $row['name']; ?></a>
                            </h3>

                            <ul class="recipe-tags">
                                <?php
                                // We are assuming you might add a 'tags' column to your DB later.
                                // For now, let's just display the Main Name as a tag, 
                                // or you can use the 'ingredients' column if you prefer.
                                echo '<li>' . $row['name'] . '</li>'; 
                                ?>
                            </ul>

                            <p class="recipe-description">
                                <?php echo $row['description']; ?>
                            </p>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No recipes found in the database.</p>";
            }
            ?>

        </div>
    </section>

    <?php $connection->close(); ?>

    <script src="filter.js" defer></script>
</body>
</html>
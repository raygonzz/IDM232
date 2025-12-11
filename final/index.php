<?php
require_once 'config.php';
// We don't strictly need to query the database here yet because 
// the homepage currently just shows static categories.
// But we keep the config require to ensure the session/connection is ready.
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sizzle | Home</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="normalize.css">
    <link rel="icon" href="icon.png">
</head>
<body>

    <?php include '_header.php'; ?>

    <section class="main">
        <div class="Dinner-section"> 
            <div class="dinner-images">

                <a href="recipes.php?filter=chicken" class="dinner-hover">
                    <img src="Graphics/Recipe_Ancho-Orange_Chicken_with_Kale_Rice_Roasted_Carrots/finish.jpg" alt="Ancho-Orange Chicken">
                    <span class="image-title">Chicken</span>
                </a> 
                
                <a href="recipes.php?filter=tacos" class="dinner-hover">
                    <img src="Graphics/Recipe_Mushroom_Potato_Tacos_with_Romaine_Orange_Salad/finish.jpg" alt="Mushroom Tacos">
                    <span class="image-title">Tacos</span>
                </a>
                
                <a href="recipes.php?filter=pork" class="dinner-hover">
                    <img src="Graphics/Recipe_Pork_Chorizo_Tacos_with_Cheesy_Roasted_Potatoes/finish.jpg" alt="Pork Tacos">
                    <span class="image-title">Pork</span>
                </a>
                
                <a href="recipes.php?filter=seafood" class="dinner-hover">
                    <img src="Graphics/Recipe_Crispy_Fish_Sandwiches_with_Tartar_Sauce_Roasted_Sweet_Potato_Wedges/finish.jpg" alt="Fish Sandwiches">
                    <span class="image-title">Seafood</span>
                </a>

                <a href="recipes.php?filter=salad" class="dinner-hover">
                    <img src="Graphics/Recipe_Roasted_Cauliflower_Salad_with_Caper_Brown_Butter_Parmesan_Breadcrumbs/finish.jpg" alt="Roasted Cauliflower Salad">
                    <span class="image-title">Salad</span>
                </a>

                <a href="recipes.php?filter=sandwich" class="dinner-hover">
                    <img src="Graphics/Recipe_Pimento_Cheeseburgers_with_Sweet_Potato_Oven_Fries/finish.jpg" alt="Pimento Cheese Burger">
                    <span class="image-title">Sandwich</span>
                </a>

                <a href="recipes.php?filter=vegetarian" class="dinner-hover">
                    <img src="Graphics/Recipe_Cheesy_Enchiladas_Rojas_with_Mushrooms_Kale/finish.jpg" alt="Cheesy Enchiladas">
                    <span class="image-title">Vegetarian</span>
                </a>

                <a href="recipes.php?filter=egg" class="dinner-hover">
                    <img src="Graphics/Recipe_Kale_Ricotta_Quiche_with_Romaine_Apple_Almond_Salad/finish.jpg" alt="Kale Quiche">
                    <span class="image-title">Egg</span>
                </a>

                <a href="recipes.php?filter=pasta" class="dinner-hover">
                    <img src="Graphics/Recipe_Bucatini_Tomato_Sauce_with_Roasted_Broccoli/finish.jpg" alt="Bucatini Pasta">
                    <span class="image-title">Pasta</span>
                </a>

            </div>
        </div>
    </section>

    <?php $connection->close(); ?>

</body>
</html>
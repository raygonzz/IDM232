<?php
require_once 'config.php';

$sql = "SELECT * FROM recipes";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <?php include '_header.php'; ?>

    <?php
    if ($result->num_rows >0) :
    ?>

        <table>
            <tr>
                <th>name</th>
                <th>name_pt2</th>
                <th>description</th>
                <th>ingredients</th>
                <th>tools</th>
                <th>tool_description</th>
                <th>steps</th>
                <th>images</th>
            </tr>
            <?php
            while($row = $result->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['name_pt2']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['ingredients']; ?></td>
                <td><?php echo $row['tools']; ?></td>
                <td><?php echo $row['tool_description']; ?></td>
                <td><?php echo $row['steps']; ?></td>
                <td><img src="<?php echo $row['images']; ?>" alt="Image" width="100"></td>
            </tr>
            <?php endwhile; ?>
        </table>

    <?php

    endif;
    $connection->close();
    ?>

</body>
</html>
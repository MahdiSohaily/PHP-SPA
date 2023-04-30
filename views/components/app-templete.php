<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php
        if (isset($title)) {
            echo $title;
        } else {
            echo 'Yadak shop';
        }
        ?>
    </title>
</head>

<body>
    <?php
    require_once 'header.php';
    ?>
    <main>
        <?php
        require_once $body;
        ?>
    </main>
</body>

</html>
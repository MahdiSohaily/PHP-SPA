<nav style="direction: rtl;">
    <div class="logo">یدک شاپ</div>
    <input type="checkbox" id="checkbox">
    <label for="checkbox" id="icon">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </label>
    <ul>
        <li><a href="#" class="active">صحفه اصلی</a></li>
        <li><a href="#">درباره ما</a></li>
    </ul>
</nav>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="This is a simple CMS for tracing goods based on thier serail or part number.">
    <meta name="author" content="Mahdi Rezaei">
    <link rel="shortcut icon" href="<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/img/YadakShop.png">
    <title>
        <?php
        if (isset($title)) {
            echo $title;
        } else {
            echo 'Yadak shop';
        }
        ?>
    </title>

    <!-- css -->
    <link rel="stylesheet" href="<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/css/styles.css?v=2.3">
    <link rel="stylesheet" href="<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/css/partials/header.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- js -->
    <script src="<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/js/jquery.js"></script>
    <script src="<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/js/axios.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
</head>

<body>
    <?php
    require_once 'navigation.php';
    ?>
    <main>
        <?php
        if (isset($body)) {
            require_once $body;
        } else {
            require_once 'relation.php';
        }
        ?>
    </main>
</body>

</html>
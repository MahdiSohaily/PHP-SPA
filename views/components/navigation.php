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
    <main>
        <section class='relation' style="direction: rtl;">
            <div class="section serial-form">
                <form class="center" method="post">
                    <input class="serial-input" type="text" name="serial" id="serial" placeholder="کد قطعه فنی را وارد کنید ..." onkeyup="search(this.value)">
                </form>
                <section id="match" style="direction: rtl;">
                    <div id="s-result" class="list-group">
                        <!-- The searched data is going to be added here -->
                    </div>
                </section>
            </div>
            <div class="section">
                <section id="selected" style="direction: rtl;">
                    <h2>موارد انتخاب شده:</h2>
                    <!-- selected items are going to be appended here -->
                </section>
            </div>
            <div class="section">
                <form class='add-relation' action="#" method="post" onsubmit="event.preventDefault(); send()">
                    <input class="r-input" type="text" name="mode" value="create" hidden required>

                    <input class="r-input" placeholder="نام" type="text" name="name" id="name" required>
                    <select id="car_id" class="r-input" name="car_id" required>
                        <?php
                        if ($cars) {
                            foreach ($cars as $car) {
                                echo '<option id="c-' . $car['id'] . '" value="' . $car['id'] . '">' . $car['name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <select name="status" id="status" class="r-input" required>
                        <option value="1">نو</option>
                        <option value="2">در حد نو</option>
                        <option value="5">کارکرده</option>
                    </select>
                    <input class="r-input bg-green" value="ثبت" type="submit" name="submit">
                </form>
            </div>
        </section>
    </main>
</body>

</html>
<?php
require_once './php/function.php';

global $con;
$con = mysqli_connect('localhost', 'root', '', 'callcenter');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}
mysqli_set_charset($con, "utf8");
require_once './php/jdf.php';

$title = '';

switch (basename($_SERVER['PHP_SELF'])) {
    case 'cartable.php':
        $title = "کارتابل";
        break;
    case 'cartable-personal.php':
        $title = "کارتابل شخصی";
        break;
    case 'shomarefaktor.php':
        $title = "شماره فاکتور";
        break;
    case 'main.php':
        $title = "اطلاعات مشتری";
        break;
    case 'customer-list.php':
        $title = "لیست مشتریان";
        break;
    case 'last-calling-time.php':
        $title = "آخرین مکالمات";
        break;
    case 'index.php':
        $title = "صفحه اصلی";
        break;
    case 'inquery-list.php':
        $title = "قیمت های داده شده";
        break;
    case 'tv.php':
        $title = "تلویزیون";
        break;

    default:
        $title = "صفحه اصلی";
        break;
}
echo "<title>$title</title>";
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/jquery.tagselect.css?v=<?php echo (rand()) ?>" type="text/css" media="all" />
    <link rel="stylesheet" href="css/jquery.tagselect2.css?v=<?php echo (rand()) ?>" type="text/css" media="all" />
    <link type="text/css" rel="stylesheet" href="css/persianDatepicker.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="css/style.css?v=<?php echo (rand()) ?>" type="text/css" media="all" />
    <script src="js/jquery.min.js?v=<?php echo (rand()) ?>"></script>
    <script src="js/save.js?v=<?php echo (rand()) ?>"></script>
    <script src="js/my.js?v=<?php echo (rand()) ?>"></script>
    <script src="js/jquery.tagselect.js?v=<?php echo (rand()) ?>"></script>
    <script src="js/jquery.tagselect2.js?v=<?php echo (rand()) ?>"></script>
    <script src="js/font.min.js"></script>
    <script src="js/copy.js"></script>
    <script src="js/persianDatepicker.min.js"></script>

    <script>
        history.scrollRestoration = "manual"
    </script>

    <style>
        .custome-tooltip {
            position: absolute;
            display: none;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px;
            border-radius: 5px;
            background-color: seagreen;
            width: 200px;
            z-index: 100000000;
        }

        .custom-table td {
            vertical-align: super;
        }

        .custome-alert {
            color: white !important;
            position: fixed;
            bottom: -100px;
            right: 50%;
            transform: translateX(-50%);
            transition: all 1s ease;
            padding: 10px;
        }

        .custome-alert.success {
            background-color: green;
        }

        .custome-alert.error {
            background-color: red;
        }

        .notify {
            position: relative;
            animation-name: wave;
            animation-duration: 0.5s;
            animation-iteration-count: infinite;
            color: red;
        }

        @keyframes wave {
            0% {
                transform: rotate(-20deg);
            }

            50% {
                transform: rotate(20deg);
            }

            100% {
                transform: rotate(-20deg);
            }

        }
    </style>
    <?php


    echo   "<link rel='stylesheet' href='css/tv.css?v=543' type='text/css' media='all' /> ";

    ?>
</head>

<body>
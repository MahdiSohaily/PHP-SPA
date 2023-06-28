<?php
session_start();
require_once './config/config.php';
require_once './database/connect.php';
date_default_timezone_set("Asia/Tehran");
$_SESSION["user_id"] = $_SESSION["id"];
?>
<!DOCTYPE html>
<html lang="fe">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./public/img/YadakShop.png">
    <meta name="description" content="This is a simple CMS for tracing goods based on thier serail or part number.">
    <meta name="author" content="Mahdi Rezaei">

    <title inertia>Yadak Shop</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="./public/js/index.js"></script>
    <link rel="stylesheet" href="./public/css/styles.css">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <style>
        .custome-tooltip {
            position: absolute;
            display: none;
            top: 100%;
            left: 0% !important;
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
            transform: translateX(50%);
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

        .multiSelect {
            width: 300px;
            position: relative;
        }

        .multiSelect *,
        .multiSelect *::before,
        .multiSelect *::after {
            box-sizing: border-box;
        }

        .multiSelect_dropdown {
            font-size: 14px;
            min-height: 35px;
            line-height: 35px;
            border-radius: 4px;
            box-shadow: none;
            outline: none;
            background-color: #fff;
            color: #444f5b;
            border: 1px solid #d9dbde;
            font-weight: 400;
            padding: 0.5px 13px;
            margin: 0;
            transition: .1s border-color ease-in-out;
            cursor: pointer;
        }

        .multiSelect_dropdown.-hasValue {
            padding: 5px 30px 5px 5px;
            cursor: default;
        }

        .multiSelect_dropdown.-open {
            box-shadow: none;
            outline: none;
            padding: 4.5px 29.5px 4.5px 4.5px;
            border: 1.5px solid #4073FF;
        }

        .multiSelect_arrow::before,
        .multiSelect_arrow::after {
            content: '';
            position: absolute;
            display: block;
            width: 2px;
            height: 8px;
            border-radius: 20px;
            border-bottom: 8px solid #99A3BA;
            top: 40%;
            transition: all .15s ease;
        }

        .multiSelect_arrow::before {
            right: 18px;
            -webkit-transform: rotate(-50deg);
            transform: rotate(-50deg);
        }

        .multiSelect_arrow::after {
            right: 13px;
            -webkit-transform: rotate(50deg);
            transform: rotate(50deg);
        }

        .multiSelect_list {
            margin: 0;
            margin-bottom: 25px;
            padding: 0;
            list-style: none;
            opacity: 0;
            visibility: hidden;
            position: absolute;
            max-height: calc(10 * 31px);
            top: 28px;
            left: 0;
            z-index: 9999;
            right: 0;
            background: #fff;
            border-radius: 4px;
            overflow-x: hidden;
            overflow-y: auto;
            -webkit-transform-origin: 0 0;
            transform-origin: 0 0;
            transition: opacity 0.1s ease, visibility 0.1s ease, -webkit-transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32);
            transition: opacity 0.1s ease, visibility 0.1s ease, transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32);
            transition: opacity 0.1s ease, visibility 0.1s ease, transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32), -webkit-transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32);
            -webkit-transform: scale(0.8) translate(0, 4px);
            transform: scale(0.8) translate(0, 4px);
            border: 1px solid #d9dbde;
            box-shadow: 0px 10px 20px 0px rgba(0, 0, 0, 0.12);
        }

        .multiSelect_option {
            margin: 0;
            padding: 0;
            opacity: 0;
            -webkit-transform: translate(6px, 0);
            transform: translate(6px, 0);
            transition: all .15s ease;
        }

        .multiSelect_option.-selected {
            display: none;
        }

        .multiSelect_option:hover .multiSelect_text {
            color: #fff;
            background: #4d84fe;
        }

        .multiSelect_text {
            cursor: pointer;
            display: block;
            padding: 5px 13px;
            color: #525c67;
            font-size: 14px;
            text-decoration: none;
            outline: none;
            position: relative;
            transition: all .15s ease;
        }

        .multiSelect_list.-open {
            opacity: 1;
            visibility: visible;
            -webkit-transform: scale(1) translate(0, 12px);
            transform: scale(1) translate(0, 12px);
            transition: opacity 0.15s ease, visibility 0.15s ease, -webkit-transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32);
            transition: opacity 0.15s ease, visibility 0.15s ease, transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32);
            transition: opacity 0.15s ease, visibility 0.15s ease, transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32), -webkit-transform 0.15s cubic-bezier(0.4, 0.6, 0.5, 1.32);
        }

        .multiSelect_list.-open+.multiSelect_arrow::before {
            -webkit-transform: rotate(-130deg);
            transform: rotate(-130deg);
        }

        .multiSelect_list.-open+.multiSelect_arrow::after {
            -webkit-transform: rotate(130deg);
            transform: rotate(130deg);
        }

        .multiSelect_list.-open .multiSelect_option {
            opacity: 1;
            -webkit-transform: translate(0, 0);
            transform: translate(0, 0);
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(1) {
            transition-delay: 10ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(2) {
            transition-delay: 20ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(3) {
            transition-delay: 30ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(4) {
            transition-delay: 40ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(5) {
            transition-delay: 50ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(6) {
            transition-delay: 60ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(7) {
            transition-delay: 70ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(8) {
            transition-delay: 80ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(9) {
            transition-delay: 90ms;
        }

        .multiSelect_list.-open .multiSelect_option:nth-child(10) {
            transition-delay: 100ms;
        }

        .multiSelect_choice {
            background: rgba(77, 132, 254, 0.1);
            color: #444f5b;
            padding: 4px 8px;
            line-height: 17px;
            margin: 5px;
            display: inline-block;
            font-size: 13px;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 500;
        }

        .multiSelect_deselect {
            width: 12px;
            height: 12px;
            display: inline-block;
            stroke: #b2bac3;
            stroke-width: 4px;
            margin-top: -1px;
            margin-left: 2px;
            vertical-align: middle;
        }

        .multiSelect_choice:hover .multiSelect_deselect {
            stroke: #a1a8b1;
        }

        .multiSelect_noselections {
            text-align: center;
            padding: 7px;
            color: #b2bac3;
            font-weight: 450;
            margin: 0;
        }

        .multiSelect_placeholder {
            position: absolute;
            left: 20px;
            font-size: 14px;
            top: 8px;
            padding: 0 4px;
            background-color: #fff;
            color: #b8bcbf;
            pointer-events: none;
            transition: all .1s ease;
        }

        .multiSelect_dropdown.-open+.multiSelect_placeholder,
        .multiSelect_dropdown.-open.-hasValue+.multiSelect_placeholder {
            top: -11px;
            left: 17px;
            color: #4073FF;
            font-size: 13px;
        }

        .multiSelect_dropdown.-hasValue+.multiSelect_placeholder {
            top: -11px;
            left: 17px;
            color: #6e7277;
            font-size: 13px;
        }
    </style>
    <script>
        const seekExist = (e) => {
            const element = e;
            if (element.hasAttribute("data-key")) {
                const partNumber = element.getAttribute('data-key');
                const brand = element.getAttribute('data-brand');

                const target = document.getElementById(partNumber + '-' + brand)
                target.style.display = 'block';
            }
        }

        const closeSeekExist = (e) => {
            const element = e;
            if (element.hasAttribute("data-key")) {
                const partNumber = element.getAttribute('data-key');
                const brand = element.getAttribute('data-brand');

                const target = document.getElementById(partNumber + '-' + brand)
                target.style.display = 'none';
            }

        }
    </script>
</head>

<body class="font-sans antialiased">
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav id="nav" ref="nav" class="main-nav bg-white shadow-lg flex flex-col justify-between">
                <i id="close" onclick="toggleNav()" class="material-icons absolute m-3 left-0 hover:cursor-pointer">close</i>
                <ul class="rtl flex flex-col pt-5">
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out" href="./index.php">
                        <i class="px-2 material-icons hover:cursor-pointer">search</i>
                        جستجوی اجناس
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out" href="./showGoods.php">
                        <i class="px-2 material-icons hover:cursor-pointer">local_mall</i>
                        اجناس
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out" href="./showRates.php">
                        <i class="px-2 material-icons hover:cursor-pointer">show_chart</i>
                        نرخ های ارز
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out" href="./relationships.php">
                        <i class="px-2 material-icons hover:cursor-pointer">sync</i>
                        تعریف رابطه اجناس
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out" href="./givePrice.php">
                        <i class="px-2 material-icons hover:cursor-pointer">receipt</i>
                        قیمت دهی
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out" href="../main.php">
                        <i class="px-2 material-icons hover:cursor-pointer">call</i>
                        مرکز تماس
                    </a>
                </ul>
                <!-- Authentication -->
                <a class="rtl cursor-pointer inline-flex items-center py-3 pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out" href="../../1402/logout.php">
                    <i class="px-2 material-icons hover:cursor-pointer">power_settings_new</i>
                    خروج از حساب
                </a>
            </nav>
            <!-- Page Content -->
            <main>
                <div class="flex">
                    <i class="p-2 right-0 material-icons hover:cursor-pointer fixed" onclick="toggleNav()">menu</i>

                    <div class=" flex items-top p-2">
                        <a id="active" class="hidden" href="./notification.php">
                            <i class="material-icons hover:cursor-pointer notify ">notifications_active</i>
                        </a>
                        <a id="deactive" class="" href="./notification.php">
                            <i class="material-icons hover:cursor-pointer text-indigo-500">notifications</i>
                        </a>
                        <p class="px-2"> <?php echo $_SESSION['username'] ?></p>
                    </div>
                </div>
                <script>
                    const active = document.getElementById('active');
                    const deactive = document.getElementById('deactive');

                    setInterval(() => {
                        const params = new URLSearchParams();
                        params.append('check_notification', 'check_notification');
                        axios
                            .post("./app/Controllers/notificationAjaxController.php", params)
                            .then(function(response) {
                                console.log(response.data);
                                if (response.data > 0) {
                                    active.classList.remove('hidden');
                                    deactive.classList.add('hidden');
                                } else {
                                    deactive.classList.remove('hidden');
                                    active.classList.add('hidden');
                                }
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                    }, 30000);
                </script>
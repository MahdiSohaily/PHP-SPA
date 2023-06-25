<?php
require_once './config/config.php';
require_once './database/connect.php';
date_default_timezone_set("Asia/Tehran");
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./public/css/styles.css">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <style>
        .custome-tooltip {
            position: absolute;
            display: none;
            bottom: 100%;
            padding: 10px;
            border-radius: 5px;
            background-color: seagreen;
            width: 200px;
            z-index: 100000;
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

        const calculateMobies = (price, rate) => {
            return Math.round(
                Math.round((price * 110) / 243.5) *
                rate *
                1.25 *
                1.3
            )
        }

        const calculateRegular = (price, rate) => {

            return Math.round(
                Math.round((price * 110) / 243.5) *
                rate *
                1.2 *
                1.2 *
                1.3
            )
        }
    </script>
</head>

<body class="font-sans antialiased">
    <div>

        <Head :title="title" />
        <Banner />
        <div class="min-h-screen bg-gray-100">
            <nav id="nav" ref="nav" class="main-nav bg-white shadow-lg flex flex-col justify-between">
                <i id="close" onclick="toggleNav()" class="material-icons absolute m-3 left-0 hover:cursor-pointer">close</i>
                <ul class="rtl flex flex-col pt-5">
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out" href="/">
                        <i class="px-2 material-icons hover:cursor-pointer">search</i>
                        جستجوی اجناس
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out" href="../../showGoods.php">
                        <i class="px-2 material-icons hover:cursor-pointer">local_mall</i>
                        اجناس
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out" href="../../showRates.php">
                        <i class="px-2 material-icons hover:cursor-pointer">show_chart</i>
                        نرخ های ارز
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out" href="../../relationships.php">
                        <i class="px-2 material-icons hover:cursor-pointer">sync</i>
                        تعریف رابطه اجناس
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out" href="../../givePrice.php">
                        <i class="px-2 material-icons hover:cursor-pointer">receipt</i>
                        قیمت دهی
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out" href="route('profile.show')">
                        <i class="px-2 material-icons hover:cursor-pointer">portrait</i>
                        حساب کاربری
                    </a>
                </ul>
                <!-- Authentication -->
                <form @submit.prevent="logout">
                    <button type="submit" class="rtl inline-flex items-end py-3 pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 w-full hover:text-white focus:outline-none transition duration-150 ease-in-out">
                        <i class="px-2 material-icons hover:cursor-pointer">power_settings_new</i>
                        خروج از حساب
                    </button>
                </form>
            </nav>
            <!-- Page Content -->
            <main>
                <div class="flex justify-between">
                    <i class="p-2 right-0 material-icons hover:cursor-pointer fixed" onclick="toggleNav()">menu</i>

                    <Link v-if="hasNotification" :href="route('notification.get')">
                    <i class="p-2 material-icons hover:cursor-pointer notify ">notifications_active</i>
                    </Link>
                    <Link v-else :href="route('notification.get')">
                    <i class="p-2 material-icons hover:cursor-pointer text-indigo-500">notifications</i>
                    </Link>
                </div>
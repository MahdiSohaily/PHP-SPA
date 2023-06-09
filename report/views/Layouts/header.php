<?php
session_start();
if (!isset($_SESSION["id"])) {
    // Redirect to a new URL
    header("Location: ../../index.php");
    exit();
}
require_once './config/config.php';
require_once './database/connect.php';

date_default_timezone_set("Asia/Tehran");
$_SESSION["user_id"] = $_SESSION["id"];

switch (basename($_SERVER['PHP_SELF'])) {
    case 'index.php':
        $title = "جستجوی اجناس";
        break;
    case 'GivenPriceHistory.php':
        $title = "تاریخچه";
        break;
    case 'givePrice.php':
        $title = "قیمت دهی دستوری";
        break;
    case 'showGoods.php':
        $title = "لیست اجناس";
        break;
    case 'showRates.php':
        $title = "لیست نرخ های ارز";
        break;
    case 'relationships.php':
        $title = "تعریف رابطه اجناس";
        break;
    case 'notification.php':
        $title = "نوتیفیکشن ها";
        break;
    case 'giveOrderedPrice.php':
        $title = "قیمت دستوری";
        break;
    case 'showPriceReports.php':
        $title = "اطلاعات کد فنی";
        break;


    default:
        $title = "سامانه یدک شاپ";
        break;
}
?>
<!DOCTYPE html>
<html lang="fe">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="./public/img/YadakShop.png">
    <meta name="description" content="This is a simple CMS for tracing goods based on thier serail or part number.">
    <meta name="author" content="Mahdi Rezaei">

    <title><?php echo $title ?></title>
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
    <link rel="stylesheet" href="./public/css/select2.css">
    <script src="./public/js/select2.js"></script>
    <script src="./public/js/copy.js"></script>
    <style>
        .custome-tooltip {
            position: absolute;
            display: none;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px;
            border-radius: 5px;
            width: 300px;
            z-index: 100000000;
            background-color: #9899ef;
        }

        .custome-tooltip::after {
            content: " ";
            position: absolute;
            bottom: 100%;
            /* At the top of the tooltip */
            left: 50%;
            margin-left: -10px;
            border-width: 10px;
            border-style: solid;
            border-color: transparent transparent #9899ef transparent;
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

        .shake {
            animation-name: shake;
            animation-duration: 1s;
            animation-iteration-count: infinite;
        }

        @keyframes shake {
            0% {
                transform: translate(1px, 1px) rotate(0);
            }

            10% {
                transform: translate(-1px, -2px) rotate(-1deg);
            }

            20% {
                transform: translate(-3px, 0) rotate(1deg);
            }

            30% {
                transform: translate(3px, 2px) rotate(0);
            }

            40% {
                transform: translate(1px, -1px) rotate(1deg);
            }

            50% {
                transform: translate(-1px, 2px) rotate(-1deg);
            }

            60% {
                transform: translate(-3px, 1px) rotate(0);
            }

            70% {
                transform: translate(3px, 1px) rotate(-1deg);
            }

            80% {
                transform: translate(-1px, -1px) rotate(1deg);
            }

            90% {
                transform: translate(1px, 2px) rotate(0);
            }

            100% {
                transform: translate(1px, -2px) rotate(-1deg);
            }
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

        .userImage {
            border-radius: 50%;
            width: 30px;
            height: 30px;
        }

        .custome-tooltip-2 {
            position: absolute;
            display: none;
            top: 15%;
            left: 90%;
            transform: translateX(-50%);
            padding: 10px;
            border-radius: 5px;
            background-color: transparent;
            width: 100px;
            z-index: 100000000;
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

        function showToolTip(element) {
            partnumber = element.getAttribute('data-part');
            targetElement = document.getElementById(partnumber + '-google');

            targetElement.style.display = 'flex';
            targetElement.style.gap = '5px';
        }

        function hideToolTip(element) {
            partnumber = element.getAttribute('data-part');
            targetElement = document.getElementById(partnumber + '-google');

            targetElement.style.display = 'none';
            targetElement.style.gap = '5px';
        }
    </script>
</head>

<body class="font-sans antialiased">
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav id="nav" ref="nav" class="main-nav bg-white shadow-lg flex flex-col justify-between">
                <i id="close" onclick="toggleNav()" class="material-icons absolute m-3 left-0 hover:cursor-pointer">close</i>
                <ul class="rtl flex flex-col pt-5 ">
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm font-medium 
                    leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none
                     transition duration-150 ease-in-out" href="../index.php">
                        <i class="px-2 material-icons hover:cursor-pointer">account_balance</i>
                        صفحه اصلی
                    </a>
                    <a class="cursor-pointer inline-flex 
                    items-center py-3 pr-6 text-sm font-medium leading-5 
                    text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none
                     transition duration-150 ease-in-out" href="../../1402/">
                        <i class="px-2 material-icons hover:cursor-pointer">attach_money</i>
                        سامانه قیمت
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 
                    pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 
                    hover:text-white focus:outline-none transition duration-150 ease-in-out" href="../cartable-personal.php">
                        <i class="px-2 material-icons hover:cursor-pointer">assignment_ind</i>
                        کارتابل شخصی
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm 
                    font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white 
                    focus:outline-none transition duration-150 ease-in-out" href="../customer-list.php">
                        <i class="px-2 material-icons hover:cursor-pointer">assignment</i>
                        لیست مشتریان
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm 
                    font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white 
                    focus:outline-none transition duration-150 ease-in-out" href="../last-calling-time.php">
                        <i class="px-2 material-icons hover:cursor-pointer">call_end</i>
                        آخرین مکالمات
                    </a>

                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm 
                    font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white 
                    focus:outline-none transition duration-150 ease-in-out" href="./index.php">
                        <i class="px-2 material-icons hover:cursor-pointer">search</i>
                        جستجوی اجناس
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm 
                    font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white 
                    focus:outline-none transition duration-150 ease-in-out" href="./showGoods.php">
                        <i class="px-2 material-icons hover:cursor-pointer">local_mall</i>
                        اجناس
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm
                     font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white 
                     focus:outline-none transition duration-150 ease-in-out" href="./showRates.php">
                        <i class="px-2 material-icons hover:cursor-pointer">show_chart</i>
                        نرخ های ارز
                    </a>
                    <a class="cursor-pointer inline-flex items-center py-3 pr-6 text-sm 
                    font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white
                     focus:outline-none transition duration-150 ease-in-out" href="./relationships.php">
                        <i class="px-2 material-icons hover:cursor-pointer">sync</i>
                        تعریف رابطه اجناس
                    </a>
                </ul>
                <!-- Authentication -->
                <a class="rtl cursor-pointer inline-flex items-center py-3 pr-6 text-sm font-medium leading-5 text-gray-500 hover:bg-indigo-500 hover:text-white focus:outline-none transition duration-150 ease-in-out" href="../../1402/logout.php">
                    <i class="px-2 material-icons hover:cursor-pointer">power_settings_new</i>
                    خروج از حساب
                </a>
            </nav>
            <!-- Page Content -->
            <main class="pt-14">
                <div class="rtl flex justify-between bg-gray-200 fixed w-full shadow-lg" style="top: 0; z-index:100">
                    <i class="p-2 right-0 material-icons hover:cursor-pointer fixed" onclick="toggleNav()">menu</i>
                    <ul class="flex mr-20 py-3">
                        <li>
                            <a class="px-4 py-2 bg-violet-600 ml-2 rounded-md text-white text-xs" href="../cartable.php">
                                <i class="fas fa-layer-group"></i>
                                کارتابل
                            </a>
                        </li>
                        <li>
                            <a class="px-4 py-2 bg-violet-600 ml-2 rounded-md text-white text-xs" href="../bazar.php">
                                <i class="fas fa-phone-volume"></i>
                                تماس عمومی
                            </a>
                        </li>
                        <li><a class="px-4 py-2 bg-violet-600 ml-2 rounded-md text-white text-xs" href="../bazar2.php">
                                <i class="fas fa-phone-volume"></i>
                                تماس با بازار
                            </a>
                        </li>
                        <li>
                            <a class="px-4 py-2 bg-violet-600 ml-2 rounded-md text-white text-xs" href="../estelam-list.php">
                                <i class="fas fa-arrow-down"></i>
                                <i class="fas fa-dollar-sign"></i>
                                قیمت های گرفته شده
                            </a>
                        </li>
                        <li>
                            <a class="px-4 py-2 bg-violet-600 ml-2 rounded-md text-white text-xs" href="../shomarefaktor.php">
                                <i class="fas fa-feather-alt"></i>
                                شماره فاکتور
                            </a>
                        </li>
                        <li>
                            <a target="_blank" class="px-4 py-2 bg-violet-600 ml-2 rounded-md text-white text-xs" href="./givePrice.php">
                                <i class="fas fa-feather-alt"></i>
                                قیمت دهی دستوری
                            </a>
                        </li>
                        <li>
                            <a class="px-4 py-2 bg-violet-600 ml-2 rounded-md text-white text-xs" target="_blank" href="./GivenPriceHistory.php">
                                <i class="fas fa-history"></i>
                                تاریخچه
                            </a>
                        </li>
                    </ul>

                    <div class=" flex items-top p-2">
                        <img class="userImage mx-2" src="../../userimg/<?php echo $_SESSION['id'] ?>.jpg" alt="userimage">
                        <a id="active" class="hidden" href="./notification.php">
                            <i class="material-icons hover:cursor-pointer notify ">notifications_active</i>
                        </a>
                        <a id="deactive" class="" href="./notification.php">
                            <i class="material-icons hover:cursor-pointer text-indigo-500">notifications</i>
                        </a>
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
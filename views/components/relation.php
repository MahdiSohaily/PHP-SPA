<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="This is a simple CMS for tracing goods based on their serial or part number.">
    <meta name="author" content="Mahdi Rezaei">
    <link rel="shortcut icon" href="<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/img/YadakShop.png">
    <title>Yadak Shop</title>

    <!-- css -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/css/styles.css?v=2.3">
    <link rel="stylesheet" href="<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/css/partials/header.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- js -->
    <script src="<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/js/jquery.js"></script>
    <script src="<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/js/axios.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <style>
        .banner {
            display: flex;
            justify-content: space-between;
        }

        .del-btn {
            border: none;
            background-color: red;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
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
                <section style="direction: rtl;">
                    <div class="banner">
                        <h2>موارد انتخاب شده:</h2>
                        <button class="del-btn" onclick="deleteAll()">حذف همه</button>
                    </div>
                    <div id="selected">
                        <!-- selected items are going to be appended here -->
                    </div>

                </section>
            </div>
            <div class="section">
                <form class='add-relation' action="#" method="post">
                    <input class="r-input" type="text" id="serialNumber" name="serialNumber" value="" hidden required>
                    <input class="r-input" type="text" id="mode" name="mode" value="create" hidden required>
                    <input class="r-input" placeholder="نام" type="text" name="name" id="name" required>
                    <select class="r-input" id="car_id" name="car_id" required>
                        <?php
                        if ($cars) {
                            foreach ($cars as $car) {
                                echo '<option id="x-' . $car['id'] . '" value="' . $car['id'] . '">' . $car['name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <select name="status" id="status" class="r-input" required>
                        <option value="1">نو</option>
                        <option value="2">در حد نو</option>
                        <option value="5">کارکرده</option>
                    </select>
                    <div id="relation-form"></div>
                    <input class="r-input bg-green btn" value="ثبت" type="submit" name="submit">
                    <?php if ($message) echo $message ?>
                </form>
            </div>
        </section>
    </main>
    <script>
        // Enable search option for select elements
        // $(document).ready(function() {
        //     //change select boxes to select mode to be searchable
        //     $("select").select2();
        // });

        // A function for searching goods base on serial number
        function search(val) {
            const resultBox = document.getElementById("s-result");
            const serialNumber = document.getElementById("serialNumber");

            if (val.length > 6) {
                serialNumber.value = val;
                resultBox.innerHTML =
                    "<img id='loading' src='<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/img/loading.gif' alt=''>";
                axios
                    .get("getData/" + val)
                    .then((response) => {
                        resultBox.innerHTML = response.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            } else {
                resultBox.innerHTML = "";
                selected.innerHTML = "";
            }
        }

        // A function to add a good to the relation box
        function add(event) {
            const id = event.target.getAttribute("data-id");
            const remove = document.getElementById(id);

            const partnumber = event.target.getAttribute("data-partnumber");
            const price = event.target.getAttribute("data-price");
            const mobis = event.target.getAttribute("data-mobis");

            const result = document.getElementById("s-result");
            const selected = document.getElementById("selected");

            result.removeChild(remove);

            const item =
                `<div class='matched-item' id='m-` +
                id +
                `'>
            <p>` +
                partnumber +
                `</p>
            <i class='material-icons remove' onclick='remove(` +
                id +
                `)'>do_not_disturb_on</i>
            </div>`;

            selected.innerHTML += item;

            const relation_form = document.getElementById("relation-form");

            const input =
                ` <input id='c-` +
                id +
                `' type='checkbox' name='value[]' value='` +
                id +
                `' hidden checked>`;
            relation_form.innerHTML += input;
        }

        // A function to load data a good to the relation box
        function load(event, pattern_id) {
            const id = event.target.getAttribute("data-id");
            const remove = document.getElementById(id);

            const result = document.getElementById("s-result");
            const selected = document.getElementById("selected");

            const mode = document.getElementById("mode");
            mode.value = "update-" + pattern_id;

            result.removeChild(remove);

            if (id) {
                selected.innerHTML =
                    "<img id='loading' src='<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/img/loading.gif' alt=''>";
                axios
                    .get("loadData/" + id)
                    .then((response) => {
                        setData(response.data);
                        axios
                            .get("loadDescription/" + id)
                            .then((response) => {
                                setValue(response.data);
                            })
                            .catch((error) => {
                                console.log(error);
                            });
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }

        // a function to set data
        function setData(items) {
            const selected = document.getElementById("selected");
            const relation_form = document.getElementById("relation-form");

            selected.innerHTML = "";

            for (item of items) {
                selected.innerHTML +=
                    `<div class='matched-item' id='m-` +
                    item.id +
                    `'>
            <p>` +
                    item.partnumber +
                    ` </p>
            <i class='material-icons remove' onclick='remove(` +
                    item.id +
                    `)'>do_not_disturb_on</i>
            </div>`;
                const input =
                    ` <input id='c-` +
                    item.id +
                    `' type='checkbox' name='value[]' value='` +
                    item.id +
                    `' hidden checked>`;
                relation_form.innerHTML += input;
            }
        }

        // A function to remove added goods from relation box
        function remove(id) {
            const item = document.getElementById("m-" + id);
            const remove_checkbox = document.getElementById("c-" + id);

            remove_checkbox.remove();
            item.remove();
        }

        function deleteAll() {
            const parent = document.getElementById('relation-form');
            const selected = document.getElementById('selected');

            removeAllChildNodes(parent);
            removeAllChildNodes(selected);
        }

        function removeAllChildNodes(parent) {
            while (parent.firstChild) {
                parent.removeChild(parent.firstChild);
            }
        }


        // Get the selected input value to send data;
        function setValue(data) {
            const name = document.getElementById("name");
            const car_id = document.getElementById("car_id");
            const status = document.getElementById("status");

            name.value = data.name;
            $("#car_id").val(data.name);
            $("#car_id").select2().trigger("change");
            car_id.value = data.car;
            $("#status").val(data.name);
            $("#status").select2().trigger("change");
            status.value = data.status;
        }

        // A function to handle the form submission
        function send() {
            const data = [index, name, car_id, status];

            axios
                .post("/saveRelation", {
                    firstName: "Finn",
                    lastName: "Williams",
                })
                .then(
                    (response) => {
                        console.log(response);
                    },
                    (error) => {
                        console.log(error);
                    }
                );
        }
    </script>
</body>

</html>
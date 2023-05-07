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
    <script>
        // All the needed variables for building relations
        let index = [];
        let name = '';
        let car_id = '';
        let status = '';

        // A function for searching goods base on serial number
        function search(val) {
            const resultBox = document.getElementById('s-result');
            const selected = document.getElementById('selected');

            if (val.length > 6) {
                resultBox.innerHTML =
                    "<img id='loading' src='<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/img/loading.gif' alt=''>";
                axios.get('getdata/' + val)
                    .then(response => {
                        resultBox.innerHTML = response.data;
                    }).catch(error => {
                        console.log(error);
                    })
            } else {
                resultBox.innerHTML = "";
                selected.innerHTML = "";
            }
        }

        // Enable search option for select elements
        $(document).ready(function() {
            //change select boxes to select mode to be searchable
            $("select").select2();
        });

        // A function to add a good to the relation box
        function add(event) {
            const id = event.target.getAttribute("data-id");
            const remove = document.getElementById(id);

            const partnumber = event.target.getAttribute("data-partnumber");
            const price = event.target.getAttribute("data-price");
            const mobis = event.target.getAttribute("data-mobis");

            const result = document.getElementById('s-result');
            const selected = document.getElementById('selected');

            result.removeChild(remove);

            const item = `<div class='matched-item' id='` + id + `'>
                    <p>` + partnumber + `</p>
                    <i class='material-icons remove' onclick='remove(` + id + `)'>do_not_disturb_on</i>
                    </div>`;

            selected.innerHTML += (item);
            index.push(id);
        }

        // A function to load data a good to the relation box
        function load(event) {
            const id = event.target.getAttribute("data-id");
            const remove = document.getElementById(id);

            const result = document.getElementById('s-result');
            const selected = document.getElementById('selected');

            result.removeChild(remove);

            if (id) {
                selected.innerHTML =
                    "<img id='loading' src='<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/img/loading.gif' alt=''>";
                axios.get('loadData/' + id)
                    .then(response => {
                        selected.innerHTML = response.data;
                        axios.get('loadDescription/' + id)
                            .then(response => {
                                setValue(response.data);
                            }).catch(error => {
                                console.log(error);
                            })
                    }).catch(error => {
                        console.log(error);
                    })
            } else {
                selected.innerHTML = "";
            }
        }

        // A function to remove added goods from relation box
        function remove(id) {
            const item = document.getElementById(id);
            const selected = document.getElementById('selected');

            selected.removeChild(item);

            const r_id = index.indexOf(id);
            index.splice(r_id, 1);
        }

        // Get the selected input value to send data;
        function setValue(data) {
            const name = document.getElementById('name');
            const car_id = document.getElementById('car_id');
            const status = document.getElementById('status');

            name.value = data.name;
            $('#car_id').val(data.name);
            $('#car_id').select2().trigger('change');
            car_id.value = data.car;
            $('#status').val(data.name);
            $('#status').select2().trigger('change');
            status.value = data.status;


        }

        // A function to handle the form submission
        function send() {
            const data = [index, name, car_id, status];

            axios.post('/saveRelation', {
                    firstName: 'Finn',
                    lastName: 'Williams'
                })
                .then((response) => {
                    console.log(response);
                }, (error) => {
                    console.log(error);
                });
        }
    </script>
</body>

</html>
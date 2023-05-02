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
        <form class='add-relation' action="#" method="post" onsubmit=" event.preventDefault(); submit()">
            <input class="r-input" placeholder="نام" type="text" name="name" id="name" required>
            <select class="r-input" required>
                <?php
                if ($cars){
                    foreach ($cars as $car){
                        echo '<option value="'. $car['id']. '">'. $car['name']. '</option>';
                    }
                }
                ?>
            </select>
            <select class="r-input" onchange="getStatus(this.value)">
                <option value="" disabled selected> وضعیت کالای کورد نظر را انتخاب کنید</option>
                <option value="نو">نو</option>
                <option value="در حد نو">در حد نو</option>
                <option value="کارکرده">کارکرده</option>
            </select>
            <input class="r-input bg-green" value="ثبت" type="submit" name="submit">
        </form>
    </div>
</section>

<script>
    $(document).ready(function() {
        //change selectboxes to selectize mode to be searchable
        $("select").select2();
    });
    let index = [];
    let name = '';
    let car_id = '';
    let status = '';
    const container = document.getElementById('result_list');

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

    function getId(id) {
        car_id = id;
        container.style.display = "none";
    }

    function getStatus(value) {
        alert(value);
    }

    function remove(id) {
        const item = document.getElementById(id);
        const selected = document.getElementById('selected');

        selected.removeChild(item);

        const r_id = index.indexOf(id);
        index.splice(r_id, 1);
    }

    function search(val) {
        let supermode = 0;
        const resultBox = document.getElementById('s-result')


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
        }
    }

    function submit() {
        const data = [index, name, car_id, status];
        axios.get('saveRelation/' + data)
            .then(response => {
                container.innerHTML = response.data;
            }).catch(error => {
                console.log(error);
            })
    }

    function searchCar(value) {
        if (value.length > 0) {
            container.style.display = "block";
            container.innerHTML =
                "<img style='width:50px; height:50px' src='<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/img/loading.gif' alt=''>";
            axios.get('getCars/' + value)
                .then(response => {
                    container.innerHTML = response.data;
                }).catch(error => {
                    console.log(error);
                })
        } else {
            container.innerHTML = "";
        }

    }
</script>
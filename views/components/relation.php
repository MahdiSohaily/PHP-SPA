<section class='relation'>
    <div class="section serial-form">
        <form class="center" action="#" method="post">
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
            <div class="matched-item">
                <p>33کد فنی قطعه</p>
                <i class='material-icons remove'>do_not_disturb_on</i>
            </div>
            <div class="matched-item">
                <p>کد فنی قطعه</p>
                <i class='material-icons remove'>do_not_disturb_on</i>
            </div>
            <div class="matched-item">
                <p>کد فنی قطعه</p>
                <i class='material-icons remove'>do_not_disturb_on</i>
            </div>
            <div class="matched-item">
                <p>کد فنی قطعه</p>
                <i class='material-icons remove'>do_not_disturb_on</i>
            </div>
            <div class="matched-item">
                <p>کد فنی قطعه</p>
                <i class='material-icons remove'>do_not_disturb_on</i>
            </div>
            <div class="matched-item">
                <p>کد فنی قطعه</p>
                <i class='material-icons remove'>do_not_disturb_on</i>
            </div>
        </section>
    </div>
    <div class="section">
        <form action="#" method="post">
            <input type="text" name="name" id="name" required>
            <input type="text" name="car" id="car" required>
            <input type="text" name="state" id="state" required>
        </form>
    </div>
</section>

<script>
    function myFunction(event) {
        const id = event.target.getAttribute("data-id");
        const partnumber = event.target.getAttribute("data-partnumber");
        const price = event.target.getAttribute("data-price");
        const mobis = event.target.getAttribute("data-mobis");

        const selected = document.getElementById('selected');

        const item = `<div class='matched-item'>
                    <p>` + partnumber + `</p>
                    <p>` + price + `</p>
                    <p>` + mobis + `</p>d
                    <i class='material-icons remove'>do_not_disturb_on</i>
                    </div>`;

        selected.innerHTML += (item);
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
            resultBox.innerHTML =
                "<img id='loading' src='<?php echo URL_ROOT . URL_SUBFOLDER ?>/public/img/loading.gif' alt=''>";
        }
    }
</script>
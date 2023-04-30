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
        <section id="selected">
            <div class="matched-item">
                <i class='material-icons remove'>do_not_disturb_on</i>
                <p>33کد فنی قطعه</p>
            </div>
            <div class="matched-item">
                <i class='material-icons remove'>do_not_disturb_on</i>
                <p>کد فنی قطعه</p>
            </div>
            <div class="matched-item">
                <i class='material-icons remove'>do_not_disturb_on</i>
                <p>کد فنی قطعه</p>
            </div>
            <div class="matched-item">
                <i class='material-icons remove'>do_not_disturb_on</i>
                <p>کد فنی قطعه</p>
            </div>
            <div class="matched-item">
                <i class='material-icons remove'>do_not_disturb_on</i>
                <p>کد فنی قطعه</p>
            </div>
            <div class="matched-item">
                <i class='material-icons remove'>do_not_disturb_on</i>
                <p>کد فنی قطعه</p>
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
                    <i
                    data-id='" . $id . "' class='material-icons add'>add_circle_outline</i>
                    <p>$partnumber</p>
                    <p>$price</p>
                    <p>$mobis</p>
                    </div>`;

        selected.appendChild(item);
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
<?php require_once './layout/heroHeader.php'; ?>
<div class="estelam-table-top">
    <input id="myInput" type="text" placeholder="سرچ کنید ...">

    <a href="#" class="hyundaimobisshow">هیوندای موبیز</a>
    <a href="#" class="kiamobisshow">کیا موبیز</a>
    <a href="#" class="mobisshow">موبیز</a>
    <a href="#" class="kiashow">کیا</a>
    <a href="#" class="hyundaishow">هیوندای</a>
</div>
<table class="estelam-table">
    <tr>
        <td>معرفی</td>
        <td>وضعیت</td>

        <td>فروشگاه</td>

        <td>شماره تماس</td>
        <td>توضیحات</td>
    </tr>
    <?php

    $sql = "SELECT * FROM seller WHERE view IS NULL ORDER  BY sortestelam DESC";
    $result = mysqli_query(dbconnect2(), $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $sellerid = $row['id'];
            $sellername = $row['name'];
            $sellerphone = $row['phone'];

            $sellerphone = "<span>" . str_replace("\n", "</span><span>", $sellerphone) . "</span>";
            $sellerwhois = $row['whois'];
            $sellerkind = $row['kind'];
            $sellerdes = $row['des'];
    ?>
            <tr>

                <td class="sellerwhois"><?php echo $sellerwhois ?></td>
                <td class="<?php echo $sellerkind ?> sellerkind">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>

                </td>
                <td class="sellername" tableid="<?php echo $sellerid ?>"><?php echo $sellername ?></td>

                <td class="sellerphone"><?php echo $sellerphone ?></td>
                <td class="sellerdes"><?php echo $sellerdes ?></td>



            </tr>

    <?php
        }
    }

    ?>

</table>


<div class="bazar-click-to-cancell" href="">قطع تماس جاری</div>
<form class="estelam-form" action="php/estelam-form-save.php" method="get" autocomplete="off">
    <div class="input-keeper">
        <input type="text" name="code[]" class="estelam-form-code" placeholder="کد فنی">
        <input type="text" name="price[]" class="estelam-form-price" placeholder="قیمت">
        <a class="remove-from-estelam-form" href="#">X</a>
    </div>
    <div class="estelam-form-box">
        <input type="text" class="sellername-input" placeholder="فروشنده">
        <input type="text" name="sellerid" class="sellerid-input" hidden>


        <input class="save-estelam-form" type="submit" value="ذخیره استعلام ها">
        <a class="add-to-estelam-form" href="#">افزودن</a>

    </div>
</form>







<script>
    $(document).ready(function() {



        $(".hyundaimobisshow").click(function() {

            $("tr").hide();
            $(".h.m").parent().show();

        });


        $(".kiamobisshow").click(function() {

            $("tr").hide();
            $(".k.m").parent().show();

        });

        $(".mobisshow").click(function() {

            $("tr").hide();
            $(".m").parent().show();

        });

        $(".kiashow").click(function() {

            $("tr").hide();
            $(".k").parent().show();

        });

        $(".hyundaishow").click(function() {

            $("tr").hide();
            $(".h").parent().show();

        });


        $(".save-estelam-form").prop('disabled', true);



        $(".estelam-table .sellerphone span").click(function() {



            $(this).addClass("called-tel");


            $(".sellername-input").val($(this).parent().prev().text());
            $(".sellerid-input").val($(this).parent().prev().attr("tableid"));
            $(".save-estelam-form").prop('disabled', false);



            if (confirm($(this).parent().prev().text() + "\n" + "شماره تماس : " + $(this).text())) {


                window.open('http://admin:1028400NRa@<?php echo getip($_SESSION["id"]) ?>/servlet?key=number=' + $(this).text() + '&outgoing_uri=@192.168.9.10', 'برقراری تماس', 'width=200,height=200')


            }

        });

        $(".bazar-click-to-cancell").click(function() {



            window.open('http://admin:1028400NRa@<?php echo getip($_SESSION["id"]) ?>/servlet?key=CALLEND', 'برقراری تماس', 'width=200,height=200')


        });

        $(".add-to-estelam-form").click(function() {


            $(".estelam-form").prepend('<div class="input-keeper"> <input type="text" name="code[]" class="estelam-form-code" placeholder="کد فنی"> <input type="text" name="price[]" class="estelam-form-price" placeholder="قیمت"> <a class="remove-from-estelam-form" href="#">X</a> </div>')

        });





        $(".estelam-form").on("click", ".remove-from-estelam-form", function() {

            $(this).parent().remove();
        });







    });









    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".estelam-table tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
<?php
require_once './layout/heroFooter.php';

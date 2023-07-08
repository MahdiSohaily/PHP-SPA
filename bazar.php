 <?php
    require_once './layout/heroHeader.php';
    $phone = "09123612779";
    ?>
 <div class="box">
     <table class="bazar-list">
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>نیایش</td>
             <td>09123612779</td>
         </tr>
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>بابک</td>
             <td>09127204134</td>
         </tr>
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>آقای پیران</td>
             <td>09121773985</td>
         </tr>
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>آقای امیردوست</td>
             <td>09100493873</td>
         </tr>
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>آقای عباسی</td>
             <td>09195597992</td>
         </tr>
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>ساسان</td>
             <td>09903870946</td>
         </tr>
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>خانم رحیمی</td>
             <td>09125805827</td>
         </tr>
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>خانم صادقی</td>
             <td>09106815460</td>
         </tr>
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>خانم خزایی</td>
             <td>09183371939</td>
         </tr>
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>حسابداری</td>
             <td>36870452</td>
         </tr>
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>موبایل و تلگرام حسابداری</td>
             <td>09930703612</td>
         </tr>
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>حامد انبار</td>
             <td>09385141911</td>
         </tr>
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>علی انبار</td>
             <td>09355187071</td>
         </tr>
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>نیایش 2</td>
             <td>09357884727</td>
         </tr>
         <tr>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td></td>
             <td>نیایش 3</td>
             <td>09120465969</td>
         </tr>
     </table>
     <div class="bazar-click-to-cancell" href="">قطع تماس جاری</div>
 </div>

 <div class="space"></div>

 <script>
     $(document).ready(function() {
         $(".bazar-list td:nth-child(n+8)").click(function() {
             $(this).addClass("called-tel")

             if (confirm($(this).parent().children().eq(6).text() + "\n" + "شماره تماس : " + $(this).text())) {

                 window.open('http://admin:1028400NRa@<?php echo getip($_SESSION["id"]) ?>/servlet?key=number=' + $(this).text() + '&outgoing_uri=@192.168.9.10', 'برقراری تماس', 'width=200,height=200')
             }
         });

         $(".bazar-click-to-cancell").click(function() {
             window.open('http://admin:1028400NRa@<?php echo getip($_SESSION["id"]) ?>/servlet?key=CALLEND', 'برقراری تماس', 'width=200,height=200')
         });
     });
 </script>
 <?php
    require_once './layout/heroFooter.php';

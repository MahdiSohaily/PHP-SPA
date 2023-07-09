 <?php
    require_once './layout/heroHeader.php';
    require_once './php/function.php';
    require_once './php/jdf.php';
    require_once './config/database.php';
    if (isset($_GET['user'])) {
        $user = $_GET['user'];
    } else {
        $user  = getinternal($_SESSION["id"]);
    }
    ?>

    <p class="test-error">We have an error</p>
 
 <!-- <script>
     /* Get the element you want displayed in fullscreen mode (a video in this example): */
     var elem = document.getElementById("fullpage");

     /* When the openFullscreen() function is executed, open the video in fullscreen.
     Note that we must include prefixes for different browsers, as they don't support the requestFullscreen method yet */
     function openFullscreen() {
         if (elem.requestFullscreen) {
             elem.requestFullscreen();
         } else if (elem.webkitRequestFullscreen) {
             /* Safari */
             elem.webkitRequestFullscreen();
         } else if (elem.msRequestFullscreen) {
             /* IE11 */
             elem.msRequestFullscreen();
         }
     }

     function closeFullscreen() {
         if (document.exitFullscreen) {
             document.exitFullscreen();
         } else if (document.webkitExitFullscreen) {
             /* Safari */
             document.webkitExitFullscreen();
         } else if (document.msExitFullscreen) {
             /* IE11 */
             document.msExitFullscreen();
         }
     }

     setInterval(() => {
         var params = new URLSearchParams();
         params.append('historyAjax', 'historyAjax');

         axios.post("./tvAjax.php", params)
             .then(function(response) {
                 console.log(response);
                 elem.innerHTML = response.data;
             })
             .catch(function(error) {
                 console.log(error);
             });
     }, 7000);
 </script> -->
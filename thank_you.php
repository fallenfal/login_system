<?php
include_once "init.php";
include_once "f_includes/header.php";
if(isset($_SESSION['registration_form']) && $_SESSION['registration_form'] === true){
?>

    <div class="container">
        <div class="row">
            <div class="col-md-12" style="text-align: center;padding-top:90px">

                <h1>Thank you for registering.</h1>
                <h3>Check your email for the confirmation email</h3>
                <br><br>
                <div class="progress" style="width:70%;margin: 0 auto">
                    <div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" ></div>
                </div>

            </div>
        </div>
    </div>



    <script>
        var timeleft = 9;
        var downloadTimer = setInterval(function(){
            if(timeleft <= 0){
                clearInterval(downloadTimer);
            }
            document.getElementById("progressBar").value = 10 - timeleft;
            document.getElementById("progressBar").style.width = 10 - timeleft+ "0%";
            timeleft -= 1;
        }, 1000);

        function pageRedirect() {
            window.location.replace("login.php");
        }
        setTimeout("pageRedirect()", 10000);

    </script>
















<?php
} else {
    ?>

<?php
}
?>



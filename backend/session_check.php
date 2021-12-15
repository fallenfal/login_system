<?php
global $session;
if($session->isSignedIn()){
    unset($_SESSION['userLogged']['password']);


    if(!empty($session_message)){

        ?>
        <div style="border-radius:4px;margin-left: auto;margin-right: auto;left: 0;right: 0;height:auto;background-color:#636e72;text-align: center;position:absolute;top:30px;min-height: 30px;border:1px solid #2d3436" class="container session-message">

            <?php echo $session_message; ?>
            <div class="close-icon" style="position:absolute;top:0;right:0;padding:5px;font-size:15px;cursor: pointer;">&times;</div>
        </div>

        <script>
            let sessionElement = document.getElementsByClassName('session-message') ;
            let closeSession = document.getElementsByClassName('close-icon');
            setTimeout(function () {
                sessionElement[0].style.display='none';
            }, 25000);
            closeSession[0].addEventListener('click', function(){
                sessionElement[0].style.display='none';
            });

        </script>


        <?php

    }
} else{
    Main::redirect('../../login.php');
}
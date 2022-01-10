<?php
include  "b_includes/footer.php";
global $session;
if($session->isSignedIn()){
    unset($_SESSION['userLogged']['password']);


    if(!empty($session_message)){

        ?>


        <script>
            $(document).ready(function() {
                $(".toast").toast('show');
            });
            </script>

        <div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true" style="margin:5px;position: absolute;">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo $session_message; ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>



        <?php
    }
} else{
    Main::redirect('../../login.php');
}

?>

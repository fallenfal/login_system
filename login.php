<?php include_once "init.php"; ?>
<!-- Header include - css,scripts and head -->
<?php include_once "f_includes/header.php"; ?>


<?php
$register = new Login();
 if(!empty($session_message)){
        ?>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

     <script>
         $(document).ready(function() {
             $(".toast").toast('show');
         });
     </script>

     <div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true" style="margin:5px;position: absolute;top:0">
         <div class="d-flex">
             <div class="toast-body">
                 <?php echo $session_message; ?>
             </div>
             <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
         </div>
     </div>
        <?php
 }
?>

<div class="container login-page">
    <div class="row">
        <div class="col-md-6 login-image-wrapper">
            <div class="login-image">
                <div class="login-image-text">
                    <h1>Build something amazing!</h1>
                </div>
            </div>

        </div>
        <div class="col-md-6 login-form-wrapper">
            <?php $register->login(); ?>
            <h2>Login Form</h2>
            <form method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                </div>

                <button type="submit" name="login" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>


































<!-- Footer include - js and bottom scripts-->
<?php include_once "f_includes/footer.php"; ?>

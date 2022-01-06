<!-- Header include - css,scripts and head -->
<?php include_once "f_includes/header.php"; ?>
<?php include_once "init.php"; ?>

<?php
$register = new Login();
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
?>
<h1 class="lead">Registration Form</h1>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-3">
            <?php $register->login(); ?>
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

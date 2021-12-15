<!-- Header include - css,scripts and head -->
<?php include_once "f_includes/header.php"; ?>
<?php include_once "init.php"; ?>

<?php
$register = new Login();

?>
<h1 class="lead">Registration Form</h1>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-3">
            <?php $register->register(); ?>
            <form method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstName">
                </div>
                <div class="mb-3">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="lastName">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword2" class="form-label">Password</label>
                    <input type="password" class="form-control" name="repeatPassword" id="exampleInputPassword2">
                </div>

                <button type="submit" name="register" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>


































<!-- Footer include - js and bottom scripts-->
<?php include_once "f_includes/footer.php"; ?>

<?php include_once "../../init.php"; ?>
<!-- Header include - css,scripts and head -->
<?php include_once "../b_includes/header.php"; ?>
<?php include_once "../b_includes/menu.php"; ?>
<?php include_once "../session_check.php" ?>


<?php
$user = New User();
?>


<h1 class="lead">change password Form</h1>
<?php  var_dump($_SESSION["userLogged"]); ?>
<div class="container">
    <div class="row">
        <div class="col-md-6 offset-3">
            <?php $user->changePassword() ?>
            <form method="post">

                <div class="mb-3">
                    <label for="oldPassword" class="form-label">First Name</label>
                    <input type="password" class="form-control" name="old_password" id="oldPassword">
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label">Last Name</label>
                    <input type="password" class="form-control" name="new_password" id="newPassword">
                </div>
                <div class="mb-3">
                    <label for="repeatPass" class="form-label">Password</label>
                    <input type="password" class="form-control" name="repeat_pass" id="repeatPass">
                </div>
                <button type="submit" name="change_password" class="btn btn-primary">change</button>
            </form>
        </div>
    </div>
</div>


























<!-- Footer include - js and bottom scripts-->
<?php include_once "../b_includes/footer.php"; ?>



<?php include_once "init.php"; ?>
<!-- Header include - css,scripts and head -->
<?php include_once "f_includes/header.php"; ?>


<?php
$register = new User();

?>
<h1 class="lead">Change Forgotten Password Form</h1>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-3">
            <?php $register->changeForgottenPassword(); ?>
            <form method="post">
                <div class="mb-3">
                    <label for="new_password" class="form-label">New password</label>
                    <input type="password" class="form-control" name="new_password" id="new_password">
                </div>

                <button type="submit" name="change" class="btn btn-primary">ChangePass</button>
            </form>
        </div>
    </div>
</div>


































<!-- Footer include - js and bottom scripts-->
<?php include_once "f_includes/footer.php"; ?>

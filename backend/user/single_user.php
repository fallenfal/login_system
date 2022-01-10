<?php include_once "../../init.php"; ?>

<!-- Header include - css,scripts and head -->
<?php include_once "../b_includes/header.php"; ?>
<?php include_once "../session_check.php" ?>


<?php

    $user = New User();

?>
<h1 class="lead">Upload image</h1>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <?php $user->editUser() ?>
            <form method="post" enctype="multipart/form-data">
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
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div class="mb-3">
                    <label for="picture" class="form-label">Image</label>
                    <input type="file" class="form-control" name="picture" id="picture">
                </div>
                <button type="submit" name="editUser" class="btn btn-primary">Edit User</button>
            </form>
        </div>
        <div class="col-md-6">
            <div class="card mb-3 text-flat-orange bg-primary">
                <img src="../user_images/<?php echo $_SESSION['userLogged']['user_image'] ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $_SESSION['userLogged']['firstname'] ?> <?php echo $_SESSION['userLogged']['lastname'] ?></h5>
                    <p><strong>Email: </strong><?php echo $_SESSION['userLogged']['email'] ?></p>
                    <p><strong>Role: </strong><?php echo $_SESSION['userLogged']['role'] ?></p>
                    <p><strong>User since: </strong><?php echo $_SESSION['userLogged']['created_at'] ?></p>

                </div>
            </div>
        </div>
    </div>
</div>






























<!-- Footer include - js and bottom scripts-->
<?php include_once "../b_includes/footer.php"; ?>


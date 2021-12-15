<!-- Header include - css,scripts and head -->
<?php include_once "f_includes/header.php"; ?>
<?php include_once "init.php"; ?>


<?php

$registration = new Login();
$registration->completeRegistration();

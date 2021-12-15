<!-- Header include - css,scripts and head -->
<?php include_once "f_includes/header.php"; ?>
<?php include_once "init.php"; ?>

<?php

$test = new Main();
$login = new Login();
?>

<h1 class="lead">Login System</h1>

<?php
$query = "SELECT * FROM users";
$user = $test->select($query);

var_dump($user);
echo "<br><br>";


echo date('Y-m-d H:i:s');
?>


































<!-- Footer include - js and bottom scripts-->
<?php include_once "f_includes/footer.php"; ?>

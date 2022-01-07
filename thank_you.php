<?php
include_once "init.php";
echo "before if";
if(isset($_SESSION['registration_form']) && $_SESSION['registration_form'] === true){

    echo "Check your mail to receive the activation mail!";

}
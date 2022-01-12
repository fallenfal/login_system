<?php include_once "../../init.php"; ?>
<!-- Header include - css,scripts and head -->
<?php include_once "../b_includes/header.php"; ?>
<?php include_once "../b_includes/menu.php"; ?>

<?php include_once "../session_check.php" ?>

<div class="container dashboard">
    <div class="row">
        <div class="col-md-12 headings">
            <h1>Hello Traveler</h1>
            <h4>build by Alex Lapos &copy;</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 description">
            <p><strong>Welcome to my simple login system.</strong><br>
                This is a small program build with PHP without any frameworks , only vanilla PHP , it's easily implemented in any web project.<br>
                Works with only a mysql table but can be expanded.
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 database">
            <h3>Database design!</h3>
            <p>Working with only a single table , below you will see the code to create it.</p>
            <code>
                create table users (<br>
                &nbsp;	&nbsp;	&nbsp;user_id         int auto_increment primary key,<br>
                &nbsp;	&nbsp;	&nbsp;firstname       varchar(255) null,<br>
                &nbsp;	&nbsp;	&nbsp;lastname        varchar(255) null,<br>
                &nbsp;	&nbsp;	&nbsp;email           varchar(255) null,<br>
                &nbsp;	&nbsp;	&nbsp;user_password   text         null,<br>
                &nbsp;	&nbsp;	&nbsp;username        varchar(255) null,<br>
                &nbsp;	&nbsp;	&nbsp;image           varchar(255) null,<br>
                &nbsp;	&nbsp;	&nbsp;active          tinyint      null,<br>
                &nbsp;	&nbsp;	&nbsp;activation_code text         null,<br>
                &nbsp;	&nbsp;	&nbsp;role            varchar(255) null,<br>
                &nbsp;	&nbsp;	&nbsp;created_at      datetime     null,<br>
                &nbsp;	&nbsp;	&nbsp;updated_at      datetime     null,<br>
                &nbsp;	&nbsp;	&nbsp;deleted_at      datetime     null,<br>
                &nbsp;	&nbsp;	&nbsp;user_image      text         null<br>
                );
            </code>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 instructions">
            <p><strong>A bit of instructions</strong><br>
            <ul>
                <li>You will need a valid email address to create accounts</li>
                <li>It uses PHPMailer and emails are sent thru gmail and you will need a mail app from your google account and you need to a secret password,
                    ofc you can use other email providers or domain name email but you will need to input your password</li>
                <li>The mail sending function can be found in Main.php</li>
                <li>Remember to put your credentials from your hosting provider for database connection, this can be found in Database.php</li>

            </ul>
            </p>
            <p><strong>The code can be found at Github: <a href="https://github.com/fallenfal/login_system">Login System</a></strong>
            <br>
            <i>https://github.com/fallenfal/login_system</i><br>
                if you have any questions , i can be found at <strong>fallenfal.alex@gmail.com</strong>
            </p>
        </div>
    </div>
</div>

































<!-- Footer include - js and bottom scripts-->
<?php include_once "../b_includes/footer.php"; ?>


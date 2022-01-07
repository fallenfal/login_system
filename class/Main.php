<?php
require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/Exception.php";
require_once "PHPMailer/SMTP.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Main{

    public static array $errors = [];
    public static array $warnings = [];

    public static function clean($string){
        return htmlentities(trim($string),ENT_QUOTES);
    }

    public static function redirect($location){
        header("Location: $location");
    }

    public function setToken(){
        $string = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        return substr(str_shuffle($string), 0, 16);
    }

    protected function passwordHash($password){
        $pass = self::clean($password);
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    protected function passwordVerify($password,$hash){
        if (password_verify($password,$hash)) {
            return true;
        } else {
            self::$errors[] = "Password is not correct";
        }
    }

    protected function notEmpty($argument){
        if(empty($argument)){
            self::$warnings[] = "Field cannot be empty";
            return false;
        } else {
            return $argument;
        }
    }

    protected function minLen($argument){
        if (strlen($argument) < 3){
            self::$warnings[] = "Length must me grater than 3 - $argument";
            return false;
        } else if (strlen($argument) > 30) {
            self::$warnings[] = "Length must me lower than 30 - $argument";
            return false;
        } else {
            return $argument;
        }
    }

    protected function emailRegex($email){
        if (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) {
            self::$warnings[] = "Email must valid";
            return false;
        } else {
            return $email;
        }
    }

    protected function passwordRegex($password){
        if (!preg_match("^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^", $password)) {
            self::$warnings[] = "Password dosent meet requirements";
            return false;
        } else {
            return $password;
        }
    }

    protected function passwordMatch($password,$repeatPassword){
        if($password != $repeatPassword){
            self::$warnings[] = "Passwords does not match!";
            return false;
        } else {
            return $password;
        }
    }


    public static function displayErrors($err){
        if(!empty($err)){
            if(is_array($err)){
                echo "<ul class='alert-danger'>";
                foreach ($err as $item){
                    echo "<li>$item</li>";
                }
                echo "</ul>";
            } else {
                echo "<ul class='alert-danger'>
                    <li>$err</li>
                  </ul>";
            }
        }
    }

    public static function displayWarnings($err){
        if(!empty($err)){
            if(is_array($err)){
                echo "<ul class='alert-warning'>";
                foreach ($err as $item){
                    echo "<li>$item</li>";
                }
                echo "</ul>";
            } else {
                echo "<ul class='alert-danger'>
                    <li>$err</li>
                  </ul>";
            }
        }
    }

    // functions matchKeys() and matchValues() work together, they match the number of keys with the number of the values in the mysql query
    // so you wont get an error if some fields are missing
    protected function matchKeys($array){
        $keys_params = [];

        foreach ($array as $key => $value){
            $keys_params[] = $key;
        }
        return implode(",", $keys_params);

    }
    protected function matchValues($array){

        $values = [];
        foreach ($array as $key => $value){
            $new = ":".$key;
            $values[] = $new;
        }
        return implode(",", $values);
    }


    protected function setAttributesForUpdate($params){
        // filter the array for null values or false or empty
        $f_params = array_filter($params,"strlen");

        // create part of the SQL query ex: name=:name, title=:title
        $keys_values = [];
        foreach ($f_params as $key => $param){
            $keys_values[] = $key. " = :".$key;
        }
        return $keys = implode(",", $keys_values);
    }


    public function sentEmail($email, $subject, $msg,$name = null,$headers = null){

        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->SMTPDebug = 1; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
        $mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
        $mail->Port = 587; // TLS only
        $mail->SMTPSecure = 'tls'; // ssl is depracated
        $mail->SMTPAuth = true;
        $mail->Username = "fallenfal.alex@gmail.com";
        $mail->Password = "isbmbfsjvnulfsrf";
        $mail->setFrom("no-reply@simple-login-system.com", $subject);
        $mail->addAddress($email, $name);
        $mail->Subject = $subject;
        $mail->msgHTML($msg); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
        $mail->AltBody = 'HTML messaging not supported';
        // $mail->addAttachment('images/phpmailer_mini.png'); //Attach an image file
        if(!$mail->send()){
            return $this->errors = $mail->ErrorInfo;
        }else{
            return true;
        }
    }




    private function executeStatement($query,$params = ''){
        try{
            global $database;
            $stmt = $database->connection->prepare($query);
            if(is_array($params)){
                foreach($params as $key => $value){
                    $value = trim($value);
                    $value = htmlentities($value, ENT_QUOTES);
                    $stmt->bindValue(":$key", $value);
                }
                $stmt->execute();
                return $stmt;
            } else {
                $stmt->execute();
                return $stmt;
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }

    }

    public function insert( $query ,array $params){
        try{
            global $database;
            $this->executeStatement( $query , $params );
            return $database->connection->lastInsertId();

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function update($query, $params){
        try{
            global $database;
            $result = $this->executeStatement( $query, $params );
            return $result->rowCount();
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function delete($query,$params=''){
        try{
            global $database;
            return $this->executeStatement( $query,$params);
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    public function select($query,$params=''){
        try {
            $result = $this->executeStatement($query,$params='');
            return $result->fetchAll();
        } catch (Exception $e){
            throw new Exception($e->getMessage());
        }
    }
}
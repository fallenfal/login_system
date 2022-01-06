<?php

class User extends Main {


    protected string $password;
    protected string $repeatPass;
    private string $table = "users";

    public function changePassword(){
        $oldPassword = $_SESSION['userLogged']['user_password'];
        $email = $_SESSION['userLogged']['email'];

        if (isset($_POST['change_password'])){

            $tempOldPass = Main::clean($_POST['old_password']);
            $this->password = Main::clean($_POST['new_password']);
            $this->repeatPass = Main::clean($_POST['repeat_pass']);

            $tempOldPass = $this->notEmpty($tempOldPass);
            $tempOldPass = $this->passwordRegex($tempOldPass);

            $this->password = $this->notEmpty($this->password);
            $this->password = $this->passwordRegex($this->password);

            $this->repeatPass = $this->notEmpty($this->repeatPass);
            $this->repeatPass = $this->passwordRegex($this->repeatPass);

            if (!$this->passwordMatch($this->password,$this->repeatPass)){
                Main::$errors[] = "New password and repeat password dont match..$this->password,$this->repeatPass";
            }


            if(!empty(Main::$warnings) OR !empty(Main::$errors)){
                Main::displayWarnings(Main::$warnings);
                Main::displayErrors(Main::$errors);
            } else {
                if ($this->passwordVerify($this->password,$oldPassword)){
                    $this->password = $this->passwordHash($this->password);
                    $params = [
                        "user_password" => $this->password,
                        "updated_at" => date('Y-m-d H:i:s')
                    ];

                    $query = "UPDATE " . $this->table . " SET ". $this->setAttributesForUpdate($params) . " WHERE email = '". $email ."' ";

                    $this->update($query,$params);
                }
                else {
                    Main::$errors[] = "Something went wrong! Check the email again!";
                    Main::displayErrors(Main::$errors);
                }
            }
        }


    }


    public function forgotPassword(){
        if(isset($_POST['forgot'])){
            $this->email = Main::clean($_POST['email']);
            $this->firstname = Main::clean($_POST['firstname']);
            $this->lastname = Main::clean($_POST['lastname']);


            $this->email = $this->notEmpty($this->email);
            $this->email = $this->emailRegex($this->email);

            $this->firstname = $this->notEmpty($this->firstname);
            $this->firstname = $this->minLen($this->firstname);
            $this->lastname = $this->notEmpty($this->lastname);
            $this->lastname = $this->minLen($this->lastname);



            if(!empty(Main::$warnings) OR !empty(Main::$errors)){
                Main::displayWarnings(Main::$warnings);
                Main::displayErrors(Main::$errors);
            } else {

                $query = "SELECT * FROM " . $this->table . " WHERE email = '". $this->email ."'";

                $result = $this->select($query);
                if(!$result or !empty($result)){
                    $params = [
                        "activation_code" => $this->setToken(),
                        "active" => 0
                    ];
                    $subject = "Forgot your password";
                    $message = "
                    Did you forgot your password?!<br>
                    To activate your account visit : domain.com/pass_change.php?activationCode={$params["activation_code"]}&email={$result[0]['email']}<br>
                    ";
                    $email = $result[0]['email'];
                    if($this->sentEmail($email,$subject,$message)){
                        $query = "UPDATE ". $this->table ." SET ". $this->setAttributesForUpdate($params) ." WHERE email = '". $result[0]['email'] ."'";
                        if($this->update($query,$params)){
                            global $session;
                            $session->message("Check your mail for your password!");
                            Main::redirect("login.php");
                        }
                    }
                } else {
                    Main::$errors[] = "Something went wrong! Try again changing your password !";
                    Main::displayErrors(Main::$errors);
                }


            }




        }
    }

    public function changeForgottenPassword(){
        if(isset($_POST['change'])){
            $urlEmail = $_GET['email'];
            $urlActivationCode = $_GET['activationCode'];

            $query = "SELECT * FROM ". $this->table ." WHERE email = '". $urlEmail ."'";
            $result = $this->select($query);
            if(!$result or empty($result)){
                Main::$errors[] = "Email it seems dosent exist";
            }

            $this->password = Main::clean($_POST['new_password']);

            $this->password = $this->notEmpty($this->password);
            $this->password = $this->passwordRegex($this->password);
            if(!empty(Main::$warnings) OR !empty(Main::$errors)){
                Main::displayWarnings(Main::$warnings);
                Main::displayErrors(Main::$errors);
            } else {
                if($urlEmail == $result[0]['email'] and $urlActivationCode == $result[0]['activation_code']){
                    $this->password = $this->passwordHash($this->password);
                    $params = [
                        "user_password" => $this->password,
                        "activation_code" => 0,
                        "active" => 1
                    ];

                    $query = "UPDATE ". $this->table ." SET ". $this->setAttributesForUpdate($params) ." WHERE email = '". $result[0]['email'] ."'";
                    if ($this->update($query,$params)){
                        global $session;
                        $session->message("Password has been changed , you can login now");
                        Main::redirect("login.php");
                    } else {
                        Main::$errors[] = "Something went wrong! We couldn t update your password !";
                        Main::displayErrors(Main::$errors);
                    }
                } else {
                    Main::$errors[] = "Something went wrong! Info dosent match!";
                    Main::displayErrors(Main::$errors);
                }
            }

        }
    }


    private function checkEmailWithException($email){
        global $session;
        $loggedEmail = $session->userLogged['email'];
        $query = "SELECT email FROM ". $this->table ." WHERE  NOT  email = '". $loggedEmail ."'";

        $result = $this->select($query);
        $emails = [];
        foreach ($result as $item){
            $emails[] = $item['email'];
        }
        if(in_array($email, $emails)){
            Main::$errors[] = "Email already in use";
        }
    }

    public function editUser(){
        if(isset($_POST['editUser'])){
            $this->email = Main::clean($_POST['email']);
            $this->firstname = Main::clean($_POST['firstname']);
            $this->lastname = Main::clean($_POST['lastname']);
            $this->username = Main::clean($_POST['username']);
            $this->image = $this->uploadSingleImage($_FILES['picture']);

            $this->checkEmailWithException($this->email);

            $this->email = $this->notEmpty($this->email);
            $this->email = $this->emailRegex($this->email);

            $this->firstname = $this->notEmpty($this->firstname);
            $this->firstname = $this->minLen($this->firstname);
            $this->lastname = $this->notEmpty($this->lastname);
            $this->lastname = $this->minLen($this->lastname);




            if(!empty(Main::$warnings) OR !empty(Main::$errors)){
                Main::displayWarnings(Main::$warnings);
                Main::displayErrors(Main::$errors);
            } else {
                global $session;
                $params = [
                    "email" => $this->email,
                    "firstname" => $this->firstname,
                    "lastname" => $this->lastname,
                    "username" => $this->username,
                    "image" => $this->image
                ];

                $query = "UPDATE " . $this->table . " SET " . $this->setAttributesForUpdate($params) ." WHERE email = '". $session->userLogged['email'] ."'";

                if($this->update($query,$params)){
                    $session->message("User has been updated");
                    Main::redirect("single_user.php");
                }

            }

        }
    }



    public function uploadSingleImage($image){

            $errors = array();
            $file_name = $image['name'];
            $file_size = $image['size'];
            $file_tmp = $image['tmp_name'];
            $file_type = $image['type'];
            $exploded_file_type = explode('.', $file_name);
            $file_ext = strtolower(end($exploded_file_type));

            $extensions = array("jpeg", "jpg", "png");

            if (in_array($file_ext, $extensions) === false) {
                $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
            }

            if ($file_size > 4097152) {
                $errors[] = 'File size must be excately 4 MB';
            }
            $new_file_name = $exploded_file_type[0].$this->setToken().rand(0,10000).".".$file_ext;
            if (empty($errors) == true) {
                move_uploaded_file($file_tmp, "../user_images/" . $new_file_name);
                return $new_file_name;
            } else {
                foreach ($errors as $er){
                    Main::$errors[] = $er;
                }

            }
    }


    public function wtf_git(){

    }


    public function wtf_git2(){

    }





}
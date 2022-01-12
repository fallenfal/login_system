<?php

class Login extends Main
{
    public string $email;
    public string $firstname;
    public string $lastname;
    public string $password;
    public string $repeatPassword;
    public string $created_at;
    public string $activationCode;
    public string $active = "0";
    public string $role = "subscriber";
    public string $userImage = "placeholder.png";
    private string $table = "users";

    // get email to check if exists
    // return bool value
    private function doesEmailExists($email){
        $query = "SELECT email FROM ". $this->table . " WHERE email='".Main::clean($email)."'";
        $result = $this->select($query);

        if (empty($result)){
            return False;
        } else {
            return True;
        }
    }

    public function register(){
        if (isset($_POST['register'])){
            $params = [];

            $this->email = Main::clean($_POST['email']);
            $this->firstname = Main::clean($_POST['firstname']);
            $this->lastname = Main::clean($_POST['lastname']);
            $this->password = Main::clean($_POST['password']);
            $this->repeatPassword = Main::clean($_POST['repeatPassword']);
            $this->created_at = date('Y-m-d H:i:s');

            $this->email = $this->notEmpty($this->email);
            $this->email = $this->emailRegex($this->email);

            if($this->doesEmailExists($this->email)){
                Main::$errors[] = "Email already exists.";
            }

            $this->firstname = $this->notEmpty($this->firstname);
            $this->firstname = $this->minLen($this->firstname);
            $this->lastname = $this->notEmpty($this->lastname);
            $this->lastname = $this->minLen($this->lastname);

            $this->password = $this->notEmpty($this->password);
            $this->password = $this->passwordRegex($this->password);
            $this->password = $this->passwordMatch($this->password, $this->repeatPassword);
            $this->password = $this->passwordHash($this->password);


            if(!empty(Main::$warnings) OR !empty(Main::$errors)){
                Main::displayWarnings(Main::$warnings);
                Main::displayErrors(Main::$errors);
            } else {
                $params = [
                    "email" => $this->email,
                    "firstname" => $this->firstname,
                    "lastname" => $this->lastname,
                    "user_password" => $this->password,
                    "role" => $this->role,
                    "active" => $this->active,
                    "activation_code" => $this->setToken(),
                    "created_at" => $this->created_at,
                    "user_image" => $this->userImage,
                ];


                $query = "INSERT INTO ". $this->table . " (" . $this->matchKeys($params). ") VALUES (". $this->matchValues($params) .")";

                $subject = "Account registration";
                $message = "
                    Thank you for registering!<br>
                    To activate your account visit :<a href='{$_SERVER['SERVER_NAME']}/activate_account.php?activationCode={$params["activation_code"]}&email={$params["email"]}'>{$_SERVER['SERVER_NAME']}/activate_account.php?activationCode={$params["activation_code"]}&email={$params["email"]}</a> <br>
                ";


                if($this->insert($query, $params)){
                    if($this->sentEmail($this->email,$subject,$message)){
                        $_SESSION['registration_form'] = true;
                        Main::redirect("thank_you.php");
                    } else {
                        global $session;
                        $session->message("Mail was not sent");
                    }

                }
            }

        }


    }


    public function login(){
        if (isset($_POST['login'])){
            $params = [];

            $this->email = Main::clean($_POST['email']);
            $this->password = Main::clean($_POST['password']);

            $this->email = $this->notEmpty($this->email);
            $this->email = $this->emailRegex($this->email);


            $this->password = $this->notEmpty($this->password);
            $this->password = $this->passwordRegex($this->password);


            if(!empty(Main::$warnings) OR !empty(Main::$errors)){
                Main::displayWarnings(Main::$warnings);
                Main::displayErrors(Main::$errors);
            } else {

                $query = "SELECT * FROM " . $this->table . " WHERE email='". $this->email ."'";
                $result = $this->select($query);

                if(!empty($result)){
                    if ($this->passwordVerify($this->password, $result[0]["user_password"])){
                        if($result[0]['active'] == '0'){
                            Main::$errors[] = "User is not activated , please check your email";
                            Main::displayErrors(Main::$errors);
                        } else {
                            global $session;
                            $session->login($result[0]);

                            $session->message("You are now logged in, welcome {$session->userLogged['firstname']}" );
                            Main::redirect("backend/home/dashboard.php");
                        }
                    } else {
                        Main::$errors[] = "Password is not valid";
                        Main::displayErrors(Main::$errors);
                    }
                } else {
                    Main::$errors[] = "The email is not registered";
                    Main::displayErrors(Main::$errors);
                }


            }

        }
    }


    public function completeRegistration(){

        $urlActivationCode = Main::clean($_GET['activationCode']);
        $urlEmail = Main::clean($_GET['email']);

        $query = "SELECT email,activation_code FROM ". $this->table ." WHERE email='".$urlEmail."'";
        $result = $this->select($query);

        if ($urlActivationCode == $result[0]['activation_code'] AND $urlEmail == $result[0]['email']){
            $params = [
                "activation_code" => 0,
                "active" => 1,
                "updated_at" => date('Y-m-d H:i:s')
            ];

            $query = "UPDATE " . $this->table . " SET " . $this->setAttributesForUpdate($params) ." WHERE email = '". $result[0]['email'] ."'";

            if($this->update($query,$params)){
                global $session;
                $session->message("Your Account has been activated .please login" );
                Main::redirect("login.php");
            }



        } else {
            Main::$errors[] = "Something went wrong! Check the email again!";
            Main::displayErrors(Main::$errors);
        }

    }










} // end of class
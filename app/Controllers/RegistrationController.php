<?php

namespace app\Controllers;

use app\Controllers\MainController;
use app\Models\Database;
use app\Models\Registration;

class RegistrationController extends MainController
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function pageRegistration()
    {
        $this->loadView("registration");
    }

    public function registerUser()
    {
        if (isset($_POST['send'])) {
            $firstname = $_POST['name'];
            $lastname = $_POST['lastname'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $error = [];

            $nameReg = "/[A-Z]{1}[a-z]+/";
            $usernameReg = "/^[a-z]+(\w+[!@#$%^&*]+|[!@#$%^&*]+\w+)[\w!@#$%^&*]/";
            $passwordReq = "/[a-z0-9A-Z]+[!@#$%^&*]{1}[a-z0-9A-Z]+/";
            $emailReg = "/^[\w\.]+@(gmail\.com|yahoo\.com|ict\.edu\.rs)/";


            if (!preg_match($nameReg, $firstname)) {
                array_push($error, "Ime nije ok");
            }
            if (!preg_match($nameReg, $lastname)) {
                array_push($error, "Prezime nije ok");
            }
            if (!preg_match($usernameReg, $username)) {
                array_push($error, "Username nije ok");
            }
            if (!preg_match($passwordReq, $password)) {
                array_push($error, "Password nije ok");
            }
            if (!preg_match($emailReg, $email)) {
                array_push($error, "Email nije ok");
            }
            if (count($error) != 0) {
                $this->json(422, $error);
            } else {
                try {
                    $modelRegistration = new Registration($this->db);
                    $usernameTest = $modelRegistration->chechUsername($username);
                    if ($usernameTest) {
                        $this->json(409, ["message" => "Username postoji u bazi"]);
                    } else {
                        // upis u bazu
                        $modelRegistration->insertUser($firstname, $lastname, $username, $email, md5($password));
                        $this->json(201, ["message" => "Uspesno ste se registrovali"]);
                    }
                } catch (\PDOException $ex) {
                    $this->json(500, ["message" => "Greska, pokusajte ponovo"]);
                    $this->errorLog(__FUNCTION__, $ex->getMessage());
                }
            }
        } else {
            $this->redirect("index.php?page=registration");
        }
    }
}

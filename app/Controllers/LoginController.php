<?php

namespace app\Controllers;

use app\Models\DataBase;
use app\Models\Login;
use app\Controllers\MainController;

class LoginController extends MainController
{

    private $db;

    public function __construct(DataBase $db)
    {
        $this->db = $db;
    }

    public function pageLogin()
    {
        $this->loadView("login");
    }

    public function loginUser()
    {
        if (isset($_POST['send'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $error = [];
            $usernameReg = "/^[a-z]+(\w+[!@#$%^&*]+|[!@#$%^&*]+\w+)[\w!@#$%^&*]/";
            $passwordReq = "/[a-z0-9A-Z]+[!@#$%^&*]{1}[a-z0-9A-Z]+/";

            if (!preg_match($usernameReg, $username)) {
                array_push($error, "Username nije ok");
            }
            if (!preg_match($passwordReq, $password)) {
                array_push($error, "Password nije ok");
            }

            if (count($error) != 0) {
                $this->json(422, $error);
            } else {
                // zahtev bazi
                $loginUser = new Login($this->db);
                try {
                    $user = $loginUser->checkUser($username, md5($password));
                    if ($user) {
                        $this->userOnline($user, $loginUser);
                        http_response_code(202);
                        echo json_encode(["message" => "Prijavlen"]);
                    } else {
                        $this->json(409, ["message" => "Korisnik ne postoji"]);
                    }
                } catch (\PDOException $ex) {
                    $this->errorLog(__FUNCTION__, $ex->getMessage());
                }
            }
        } else {
            header("Location: index.php?page=login");
        }
    }

    public function logout()
    {
        try {
            $modelLogin = new Login($this->db);
        } catch (\PDOException $ex) {
            $this->errorLog(__FUNCTION__, $ex->getMessage());
        }
        $modelLogin->setStatusOfline($_SESSION['user']->id_user);
        unset($_SESSION['user']);
        \session_destroy();
        $this->redirect("index.php");
    }


    // public function userOfline()
    // {
    //     $modelLogin = new Login($this->db);
    //     $modelLogin->setStatusOfline($_SESSION['user']->id_user);
    // }


    public function userOnline($user, $loginUser)
    {
        // var_dump($user);
        // global $loginUser;
        // var_dump($loginUser);
        try {
            $_SESSION['user'] = $user;
            $loginUser->setStatusOnline($user->id_user);
            $this->redirect("index.php");
        } catch (\PDOException $ex) {
            $this->errorLog(__FUNCTION__, $ex->getMessage());
        }
    }


    public function idUser()
    {
        if (isset($_SESSION['user'])) {
            $idUser = $_SESSION['user']->id_user;
        } else {
            $idUser = "Niste registrovani";
        }
        $this->json(202, ["message" => $idUser]);
    }
}

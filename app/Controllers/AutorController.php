<?php

namespace app\Controllers;

use app\Controllers\MainController;
use app\Models\Autor;

class AutorController extends MainController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function loadForm()
    {
        $this->loadViewAdmin("add_autor");
    }


    public function insert()
    {
        if (isset($_POST['send'])) {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $nameReg = "/^[A-Z][a-z]+$/";
            $error = [];

            if (!preg_match($nameReg, $firstName)) {
                array_push($error, "Ime nije ok");
            }

            if (!preg_match($nameReg, $lastName)) {
                array_push($error, "Prezime nije ok");
            }


            if (count($error) != 0) {
                $this->json(422, ["message" => $error]);
            } else {
                try {
                    $modelAutor = new Autor($this->db);
                    $modelAutor->insertAutor($firstName, $lastName);
                    $this->json(204);
                } catch (\PDOException $ex) {
                    $this->errorLog(__FUNCTION__, $ex->getMessage());
                }
            }
        } else {
            \http_response_code(404);
        }
    }


    public function autors()
    {
        try {
            $model = new Autor($this->db);
            $autors  = $model->getAutors();
            $this->loadViewAdmin("autors", ["autors" => $autors]);
        } catch (\PDOException $ex) {
            $this->errorLog(__FUNCTION__, $ex->getMessage());
        }
    }


    public function getAutor()
    {
        if (isset($_POST['id'])) {
            try {
                $model = new Autor($this->db);
                $autor = $model->getOneAutor($_POST['id']);
                \http_response_code(200);
                echo json_encode($autor);
            } catch (\PDOException $ex) {
                $this->errorLog(__FUNCTION__, $ex->getMessage());
            }
        }
    }


    public function editAutor()
    {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $firstName = $_POST['firstName'];
            $nameReg = "/^[A-Z][a-z]+$/";
            $error = [];
            $lastName = $_POST['lastName'];


            if (!preg_match($nameReg, $firstName)) {
                array_push($error, "Ime nije ok");
            }

            if (!preg_match($nameReg, $lastName)) {
                array_push($error, "Prezime nije ok");
            }

            if (count($error) != 0) {
                $this->json(422, ["message" => $error]);
            } else {
                try {
                    $model = new Autor($this->db);
                    $model->editAutor([$firstName, $lastName, $id]);
                    \http_response_code(204);
                } catch (\PDOException $ex) {
                    $this->errorLog(__FUNCTION__, $ex->getMessage());
                }
            }
        }
    }



    public function getAutors()
    {
        try {
            $model = new Autor($this->db);
            $autors = $model->getAutors();
            $this->json(202, $autors);
        } catch (\PDOException $ex) {
            $this->errorLog(__FUNCTION__, $ex->getMessage());
        }
    }


    public function removeAutor()
    {
        if (isset($_POST['id'])) {
            try {
                $model = new Autor($this->db);
                $model->deleteAutor($_POST['id']);
                \http_response_code(204);
            } catch (\PDOException $ex) {
                $this->errorLog(__FUNCTION__, $ex->getMessage());
            }
        }
    }
}

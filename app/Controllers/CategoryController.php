<?php

namespace app\Controllers;

use app\Controllers\MainController;
use app\Models\Category;

class CategoryController extends MainController
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function loadForm()
    {
        $this->loadViewAdmin("add_category");
    }


    public function insert()
    {

        if (isset($_POST['name'])) {
            $categoryName = $_POST['name'];
            $nameReg = "/^[A-Z][a-z]+$/";
            $error = [];

            if (!preg_match($nameReg, $categoryName)) {
                array_push($error, "Ime nije ok");
            }

            if (count($error) != 0) {
                $this->json(422, ["message" => $error]);
            } else {
                try {
                    $categoryModel = new Category($this->db);
                    $categoryModel->insertCategory($categoryName);
                    $this->json(204);
                } catch (\PDOException $ex) {
                    $this->errorLog(__FUNCTION__, $ex->getMessage());
                }
            }
        } else {
            \http_response_code(404);
        }
    }


    public function categories()
    {
        try {
            $categories = new Category($this->db);
            $data = $categories->getCategory();
            $this->loadViewAdmin("categories", ["categories" => $data]);
        } catch (\PDOException $ex) {
            $this->errorLog(__FUNCTION__, $ex->getMessage());
        }
    }


    public function getCategories()
    {
        try {
            $categories = new Category($this->db);
            $data = $categories->getCategory();
            $this->json(202, $data);
        } catch (\PDOException $ex) {
            $this->errorLog(__FUNCTION__, $ex->getMessage());
        }
    }


    public function getOneCategory()
    {
        if (isset($_GET['id'])) {
            try {
                $categoryModel = new Category($this->db);
                $category = $categoryModel->getCategoryWhere($_GET['id']);
                $this->json(202, $category);
            } catch (\PDOException $ex) {
                $this->errorLog(__FUNCTION__, $ex->getMessage());
            }
        }
    }


    public function editCategory()
    {
        if (isset($_POST['idCategory'])) {
            $idCategory = $_POST['idCategory'];
            $name = $_POST['name'];
            //regularni
            $categoryName = $_POST['name'];
            $nameReg = "/^[A-Z][a-z]+$/";
            $error = [];

            if (!preg_match($nameReg, $categoryName)) {
                array_push($error, "Ime nije ok");
            }

            if (count($error) != 0) {
                $this->json(422, ["message" => $error]);
            } else {
                try {
                    $categoryModel = new Category($this->db);
                    $categoryModel->editCategory([$name, $idCategory]);
                    $this->json(204);
                } catch (\PDOException $ex) {
                    $this->json(500, ["message" => "Greska, pokusajte ponovo"]);
                    $this->errorLog(__FUNCTION__, $ex->getMessage());
                }
            }
        }
    }


    public function removeCategory()
    {

        if (isset($_POST['id'])) {
            $idCategory = $_POST['id'];

            try {
                $categoryModel = new Category($this->db);
                $categoryModel->delete($idCategory);
                $this->json(204);
            } catch (\PDOException $ex) {
                $this->json(500, ["message" => "Greska, pokusajte ponovo"]);
                $this->errorLog(__FUNCTION__, $ex->getMessage());
            }
        }
    }
}

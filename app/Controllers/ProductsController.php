<?php

namespace app\Controllers;

use app\Controllers\MainController;
use app\Models\Autor;
use app\Models\Book;
use app\Models\Category;

class ProductsController extends MainController
{
    private $db;


    public function __construct($db)
    {
        $this->db = $db;
    }


    public function pageProducts()
    {
        $books = $this->products();
        $categories = $this->categories();
        $autors = $this->autors();
        $this->loadView("products", ["books" => $books, "categories" => $categories, "autors" => $autors]);
    }

    public function products()
    {
        $modelBook = new Book($this->db);
        return $modelBook->getBooks();
    }

    public function categories()
    {
        $modelCategory = new Category($this->db);
        return $modelCategory->getCategory();
    }


    public function autors()
    {
        $modelAutor = new Autor($this->db);
        return $modelAutor->getAutors();
    }


    public function pageShop()
    {
        $this->loadView("shop");
    }
}

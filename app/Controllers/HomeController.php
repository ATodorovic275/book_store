<?php

namespace app\Controllers;

use app\Controllers\MainController;
use app\Models\Book;

class HomeController extends MainController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function pageHome()
    {
        $modelBook = new Book($this->db);
        $books = $modelBook->getBooks();
        $this->loadView("home", ["books" => $books]);
    }
}

<?php

namespace app\Models;

use app\Models\Database;

class Book
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }


    public function insertImage($src, $alt)
    {
        // upis slike`
        return $this->db->insert2("INSERT INTO image VALUES(NULL, ?, ?)", [$src, $alt]);
    }

    public function insertBook($title, $price, $autor)
    {
        return $this->db->insert2("INSERT INTO book VALUES(NULL, ?, ?, ?)", [$title, $price, $autor]);
    }

    public function insertBookCategory($idBook, $categories)
    {
        // var_dump($categories);
        // "INSERT INTO book_category VALUES(NULL, ?, ?), (NULL, ?, ?)";
        $string = "";
        $newArray = [];
        echo "</br>";
        $lenght = count($categories);
        $j = 0;
        for ($i = 0; $i < $lenght; $i++) {
            $string .= "(NULL, ?, ?), ";
            array_push($newArray, $idBook, $categories[$j]);
            // array_push($newArray, $categories[$j]);
            $j++;
        }

        // echo $string;
        // echo "</br>";
        // var_dump($newArray);

        // INSERT INTO `book_category` (`id_book_category`, `id_book`, `id_category`) VALUES (NULL, '1', '2'), (NULL, '1', '6');
        // echo $string;
        // substr($string, 0, -1)
        return $this->db->insert("INSERT INTO book_category VALUES " . substr($string, 0, -2), $newArray);
    }


    public function getBooks()
    {

        return $this->db->executeQuery("SELECT b.id_book, b.title, b.price, i.* FROM book b INNER JOIN book_image bi ON b.id_book=bi.id_book INNER JOIN image i ON bi.id_image=i.id_image limit 8");

        // SELECT b.*, a.first_name, a.last_name, i.src, i.alt FROM book b INNER JOIN autor a on b.id_autor = a.id_autor INNER JOIN book_image bi ON b.id_book = bi.id_book INNER JOIN image i ON bi.id_image = i.id_image
    }

    public function getBooksAutors()
    {
        return $this->db->executeQuery("SELECT b.*, a.first_name, a.last_name, i.src, i.alt FROM book b INNER JOIN autor a on b.id_autor = a.id_autor INNER JOIN book_image bi ON b.id_book = bi.id_book INNER JOIN image i ON bi.id_image = i.id_image");
        // return $this->db->executeQuery("SELECT b.*, a.first_name, a.last_name FROM book b INNER JOIN autor a on b.id_autor = a.id_autor");
    }


    public function getBookCategories($idBook)
    {
        return $this->db->executeQueryWhere("SELECT c.name FROM book b INNER JOIN book_category bc on b.id_book = bc.id_book INNER JOIN category c on bc.id_category = c.id_category WHERE b.id_book = ?", [$idBook]);
    }


    public function insertBookImage($idBook, $idImage)
    {
        return $this->db->insert("INSERT INTO book_image VALUES(NULL, ?, ?)", [$idBook, $idImage]);
    }


    public function shopBooks($string, $params)
    {
        return $this->db->executeQueryWhere("SELECT * FROM book WHERE id_book in ($string)", $params);
    }
}

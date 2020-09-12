<?php

namespace app\Controllers;

use app\Models\Fetch;

class FetchBooks
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function fetchProduct()
    {

        if (isset($_POST["fetch"])) {
            $query = "SELECT DISTINCT b.id_book, b.title, b.price, i.*, a.* FROM book b INNER JOIN book_image bi ON b.id_book=bi.id_book INNER JOIN image i ON bi.id_image=i.id_image INNER JOIN book_category bc ON b.id_book = bc.id_book INNER JOIN category c ON bc.id_category = c.id_category
            INNER JOIN autor a ON b.id_autor = a.id_autor WHERE 1 = 1 ";
            $data = [];

            if (isset($_POST['categories'])) {
                // array_push($data, $_POST['categories']);
                $categoriesLenght = count($_POST['categories']);
                $params = "";
                // var_dump($categoriesLenght);
                $temp = [];

                for ($i = 0; $i < $categoriesLenght; $i++) {
                    array_push($temp, "?");
                    $params = implode(", ", $temp);
                    array_push($data, $_POST['categories'][$i]);
                }

                // var_dump($temp);
                // var_dump($params);
                // var_dump($categories);
                // $categoriesString = implode(", ", $_POST['categories']); ne traba
                // var_dump($categoriesString); 
                $query .= " AND c.id_category IN($params)";
                // var_dump($query);
            }
            if (isset($_POST['autor'])) {
                $autor = $_POST['autor'];
                array_push($data, $autor);
                $query .= " AND a.id_autor = ?";
            }
            if (isset($_POST['search'])) {
                $query .= " AND b.title LIKE ?";
                array_push($data, "%" . $_POST['search'] . "%");
            }
            // var_dump($data);

            // var_dump($query);

            $modelFetch = new Fetch($this->db);
            $podaci = $modelFetch->fetch($query, $data);
            // var_dump($podaci);
            http_response_code(202);
            echo json_encode($podaci);
        }
    }
}

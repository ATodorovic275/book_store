<?php

namespace app\Controllers;

use app\Controllers\MainController;
use app\Models\Order;

class OrderController extends MainController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function insertOrder()
    {
        // insert into cart values(?, iduser, default)
        if (isset($_POST['send'])) {
            $idUser = $_POST['idUser'];
            $idBooks = $_POST['idBooks']; //array
            $quantity = $_POST['quantity']; //array
            $length = count($idBooks);
            // var_dump($idBooks);
            // var_dump($quantity);

            try {
                $modelOrder = new Order($this->db);
                $idOrder = $modelOrder->insert($idUser);
                $string = [];
                $params = [];
                for ($i = 0; $i < $length; $i++) {
                    array_push($string, "(NULL, ?, ?, ?)");
                    array_push($params, $idOrder, $idBooks[$i], $quantity[$i]);
                }
                $string2 = implode(", ", $string);
                // var_dump($params);

                $modelOrder->insertOrderDetails($string2, $params);
                $this->json(202, ["message" => "Uspesno izvrsena narudzbina"]);
            } catch (\PDOException $ex) {
                $this->json(500, ["message" => "Doslo je do greske"]);
                $this->errorLog(__FUNCTION__, $ex->getMessage());
            }
        }
    }
}

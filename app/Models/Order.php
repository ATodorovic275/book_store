<?php

namespace app\Models;

class Order
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function insert($param)
    {
        return $this->db->insert2("INSERT INTO cart VALUES(NULL, ?, DEFAULT)", [$param]);
    }


    public function insertOrderDetails($string, $params)
    {
        return $this->db->insert("INSERT INTO order_details VALUES $string", $params);
    }
}

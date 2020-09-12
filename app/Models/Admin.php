<?php

namespace app\Models;

class Admin
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllOrders()
    {
        return $this->db->executeQuery("SELECT u.first_name, u.last_name, u.id_user, c.date, c.id_cart FROM cart c INNER JOIN user u ON c.id_user = u.id_user");
    }

    public function getOrderDetails($param)
    {
        return $this->db->executeQueryWhere("SELECT b.title, o.quantity FROM order_details o INNER JOIN cart c ON o.id_order = c.id_cart INNER JOIN book b ON b.id_book = o.id_book WHERE c.id_cart = ?", [$param]);
    }
}

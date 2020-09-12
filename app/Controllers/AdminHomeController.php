<?php

namespace app\Controllers;

use app\Controllers\MainController;
use app\Models\Admin;
use app\models\Login;

class AdminHomeController extends MainController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function pageAdmin()
    {
        $orders = $this->getAllOrders();
        $errorLogs = $this->printErroLog();
        $activityLogs = $this->printActivityLog();
        $onlineUsers = $this->onlineUsers();
        $this->loadViewAdmin("index", ["orders" => $orders, "errors" => $errorLogs, "activity" => $activityLogs, "online" => $onlineUsers]);
    }


    public function getAllOrders()
    {
        try {
            $modelAdmin = new Admin($this->db);
            $orders = $modelAdmin->getAllOrders();
            foreach ($orders as $order) {
                // var_dump($order);
                $ordDetails = $this->orderDetailsForOrder($order->id_cart);
                $order->details = $ordDetails;
            }
            return $orders;
        } catch (\PDOException $ex) {
            $this->errorLog(__FUNCTION__, $ex->getMessage());
        }

        // var_dump($orders);
    }


    public function orderDetailsForOrder($idOrder)
    {
        try {
            $modelAdmin = new Admin($this->db);
            return $modelAdmin->getOrderDetails($idOrder);
        } catch (\PDOException $ex) {
            $this->errorLog(__FUNCTION__, $ex->getMessage());
        }
    }

    public function onlineUsers()
    {
        try {
            $modelLogin = new Login($this->db);
            $numberOnline = $modelLogin->numberOfOnlineUsers();
            return $numberOnline;
        } catch (\PDOException $ex) {
            $this->errorLog(__FUNCTION__, $ex->getMessage());
        }
    }


    public function printErroLog()
    {
        $fajlPutanja = "assets/data/error.txt";
        $podaci = file($fajlPutanja);
        return $podaci;
    }


    public function printActivityLog()
    {
        $path = "assets/data/activity.txt";
        $data = file($path);
        return $data;
    }
}

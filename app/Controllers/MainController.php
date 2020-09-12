<?php

namespace app\Controllers;

class MainController
{


    protected function loadView($page, $data  = null)
    {
        if (isset($data)) {
            extract($data);
        }
        include "app/views/fixed/head.php";
        include "app/views/fixed/navigation.php";
        include "app/views/pages/$page.php";
        include "app/views/fixed/footer.php";
    }


    public function loadViewAdmin($page, $data = [])
    {
        extract($data);
        if (isset($_SESSION['user']) && $_SESSION['user']->id_role == 2) {
            include "app/views/admin/head.php";
            include "app/views/admin/left.php";
            include "app/views/admin/nav.php";
            include "app/views/admin/$page.php";
            include "app/views/admin/footer.php";
        } else {
            header("Location: index.php");
        }
    }


    protected function redirect($page)
    {
        header("Location: $page");
    }


    public function redirectAdmin($page)
    {
        header("Location: index.php?page=admin&param=$page");
    }

    public function errorLog($function, $errMessage)
    {
        $file = BASE_URL . "/bookstore1-master/assets/data/error.txt";
        $veza = fopen($file, "a");
        $string = basename($_SERVER['REQUEST_URI']) . "\t Function: " . $function . "\t Error: " . $errMessage . "\t" . date("d.m.Y H:i:s") . "\n";
        fwrite($veza, $string);
        fclose($veza);
        \http_response_code(500);
    }


    public function json($status, $data = null)
    {
        header("Content-type: application/json");
        \http_response_code($status);
        echo json_encode($data);
    }


    public function activityLog()
    {
        $string = basename($_SERVER['REQUEST_URI']) . "\t User: not logged in \t" .  date("d.m.Y H:i:s") . "\n";
        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $string = basename($_SERVER['REQUEST_URI']) . "\t User: $user->username \t" .  date("d.m.Y H:i:s") . "\n";
        }

        $file = BASE_URL . "/bookstore1-master/assets/data/activity.txt";
        $veza = fopen($file, "a");
        fwrite($veza, $string);
        fclose($veza);
    }
}

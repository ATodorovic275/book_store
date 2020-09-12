<?php

namespace app\models;

class Login
{
    private $db;

    public function __construct(DataBase $db)
    {
        $this->db = $db;
    }

    public function checkUser($username, $password)
    {
        return $this->db->executeOneRow("SELECT * FROM user WHERE username = ? AND password = ?", [$username, $password]);
    }

    public function setStatusOnline($idUser)
    {
        return $this->db->update("UPDATE user SET online_status = 1 where id_user = ?", [$idUser]);
    }

    public function setStatusOfline($idUser)
    {
        return $this->db->update("UPDATE user SET online_status = 0 where id_user = ?", [$idUser]);
    }


    public function numberOfOnlineUsers()
    {
        return $this->db->executeOneRow("SELECT COUNT(*) AS online_numb FROM user WHERE online_status = ?", [1]);
    }
}

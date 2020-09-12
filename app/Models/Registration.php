<?php

namespace app\Models;

class Registration
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }


    public function insertUser($firstname, $lastname, $username, $email, $password)
    {
        return $this->db->insert("INSERT INTO user VALUES(NULL,?,?,?,?,?, DEFAULT, DEFAULT)", [$firstname, $lastname, $username, $email, $password]);
    }


    public function chechUsername($username)
    {
        return $this->db->executeOneRow("select * from user where username = ?", [$username]);
    }
}

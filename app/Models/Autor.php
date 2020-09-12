<?php

namespace app\Models;

class Autor
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function insertAutor($firstName, $lastName)
    {
        return $this->db->insert("INSERT INTO autor VALUES(NULL, ?, ?)", [$firstName, $lastName]);
    }


    public function getAutors()
    {
        return $this->db->executeQuery("SELECT * FROM autor");
    }


    public function getOneAutor($param)
    {
        return $this->db->executeOne("SELECT * FROM autor WHERE id_autor = ?", [$param]);
    }


    public function editAutor($params)
    {
        return $this->db->update("UPDATE autor SET first_name = ?, last_name = ? WHERE id_autor = ?", $params);
    }


    public function deleteAutor($param)
    {
        $this->db->delete("DELETE FROM autor WHERE id_autor = ?", [$param]);
    }
}

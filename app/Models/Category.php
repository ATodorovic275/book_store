<?php

namespace app\Models;

use app\Controllers\MainController;

class Category extends MainController
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }




    public function insertCategory($name)
    {
        return $this->db->insert("INSERT INTO category VALUES(NULL, ?)", [$name]);
    }

    public function getCategory()
    {
        return $this->db->executeQuery("SELECT * FROM category");
    }


    public function getCategoryWhere($param)
    {
        return $this->db->executeOne("SELECT * FROM category WHERE id_category = ?", [$param]);
    }

    public function editCategory($params)
    {
        return $this->db->update("UPDATE category SET name = ? WHERE id_category = ?", $params);
    }


    public function delete($param)
    {
        return $this->db->delete("DELETE FROM category WHERE id_category = ?", [$param]);
    }
}

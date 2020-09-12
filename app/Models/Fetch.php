<?php

namespace app\Models;

class Fetch
{

    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function fetch($query, $params)
    {
        return $this->db->executeQueryWhere($query, $params);
    }
}

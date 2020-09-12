<?php

namespace app\Models;


class Database
{
    private $connection;

    public function __construct($server, $db, $user, $password)
    {
        try {
            $this->connection = new \PDO("mysql:host=" . $server . ";dbname=" . $db .  ";charset=utf8", $user, $password);
            $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $ex) {
            echo $ex->getMessage();
            // $error = new ExceptionController();
            // $error->saveError($ex->getMessage());
        }
    }


    public function executeQuery(string $query)
    {
        return $this->connection->query($query)->fetchAll();
    }

    public function executeOneRow(string $query, array $param)
    {
        $prepare = $this->connection->prepare($query);
        $prepare->execute($param);
        return $prepare->fetch();
    }


    public function executeQueryWhere(string $query, array $param)
    {
        $prepare = $this->connection->prepare($query);
        $prepare->execute($param);
        return $prepare->fetchAll();
    }



    public function executeOne(string $query, array $param)
    {
        $prepare = $this->connection->prepare($query);
        $prepare->execute($param);
        return $prepare->fetch();
    }



    public function insert($query, $params)
    {
        $prepare = $this->connection->prepare($query);
        return $prepare->execute($params);
    }

    public function insert2($query, $params)
    {

        $prepare = $this->connection->prepare($query);
        $prepare->execute($params);
        return $this->connection->lastInsertId();
    }


    public function update($query, $params)
    {
        $prepare = $this->connection->prepare($query);
        return $prepare->execute($params);
    }


    public function delete($query, $params)
    {
        $prepare = $this->connection->prepare($query);
        return $prepare->execute($params);
    }
}

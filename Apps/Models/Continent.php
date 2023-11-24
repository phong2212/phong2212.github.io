<?php

namespace Apps\Models;


class Continent
{
    private $db;

    private $ContinentID;
    private $Name;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function fillData(array $row)
    {
        [
            'ContinentID' => $this->ContinentID,
            'Name' => $this->Name
        ] = $row;
        return $this;
    }

    public function getContinentID()
    {
        return $this->ContinentID;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function getAll()
    {
        $conts = [];

        $statement = $this->db->prepare('SELECT * FROM Continents ORDER BY ContinentID');

        $statement->execute();

        while ($row = $statement->fetch()) {
            $cont = new Continent('');
            $cont->fillData($row);
            $conts[] = $cont;
        }
        return $conts;
    }
}
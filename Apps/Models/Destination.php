<?php

namespace Apps\Models;


class Destination
{
    private $db;

    private $DestinationID;
    private $Name;
    private $Description;
    private $Location;
    private $ContinentID;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function fillData(array $row)
    {
        [
            'DestinationID' => $this->DestinationID,
            'Name' => $this->Name,
            'Description' => $this->Description,
            'Location' => $this->Location,
            'ContinentID' => $this->ContinentID
        ] = $row;
        return $this;
    }

    public function getDestinationID()
    {
        return $this->DestinationID;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function getDescription()
    {
        return $this->Description;
    }

    public function getLocation()
    {
        return $this->Location;
    }

    public function getContinentID()
    {
        return $this->ContinentID;
    }


    public function getAll()
    {
        $dests = [];

        $statement = $this->db->prepare('SELECT * FROM Destinations ORDER BY DestinationID');

        $statement->execute();

        while ($row = $statement->fetch()) {
            $dest = new Destination('');
            $dest->fillData($row);
            $dests[] = $dest;
        }
        return $dests;
    }

    public function findDestination($DestinationID)
    {
        $statement = $this->db->prepare('SELECT * FROM Destinations WHERE DestinationID = :DestinationID');

        $statement->execute(['DestinationID' => $DestinationID]);

        $row = $statement->fetch();

        $this->fillData($row);
        return $this;
    }

    public function delete($DestinationID)
    {
        $statement = $this->db->prepare('DELETE FROM Destinations WHERE DestinationID = :DestinationID');

        $result = $statement->execute(['DestinationID' => $DestinationID]);

        return $result;
    }

    public function add($Name, $Description, $Location, $ContinentID)
    {
        $statement = $this->db->prepare("INSERT INTO Destinations (Name, Description, Location, ContinentID) VALUES (:Name, :Description, :Location, :ContinentID);");
        $result = $statement->execute([
            "Name" => $Name,
            "Description" => $Description,
            "Location" => $Location,
            "ContinentID" => $ContinentID
        ]);

        if ($result) {
            return $this->db->lastInsertId();
        } else {
            return 0;
        }
    }

    public function edit($Name, $Description, $Location, $ContinentID, $DestinationID)
    {
        $statement = $this->db->prepare("UPDATE Destinations SET Name=:Name, Description=:Description, Location=:Location, ContinentID=:ContinentID WHERE DestinationID=:DestinationID");
        $result = $statement->execute([
            "Name" => $Name,
            "Description" => $Description,
            "Location" => $Location,
            "ContinentID" => $ContinentID,
            'DestinationID' => $DestinationID
        ]);

        if ($result) {
            return $this->db->lastInsertId();
        } else {
            return 0;
        }
    }

    public function findAllDestinationsByContinent($continentID)
    {
        $dests = [];

        $statement = $this->db->prepare('SELECT * FROM Destinations WHERE ContinentID = :ContinentID');

        $statement->execute(['ContinentID' => $continentID]);

        while ($row = $statement->fetch()) {
            $dest = new Destination('');
            $dest->fillData($row);
            $dests[] = $dest;
        }
        return $dests;
    }

    public function findRandomDestinations()
    {
        $dests = [];

        $statement = $this->db->prepare('SELECT * FROM Destinations ORDER BY RAND() LIMIT 9');

        $statement->execute();

        while ($row = $statement->fetch()) {
            $dest = new Destination('');
            $dest->fillData($row);
            $dests[] = $dest;
        }
        return $dests;
    }

    public function searchName($name)
    {
        $destinations = [];

        $statement = $this->db->prepare('SELECT * FROM Destinations WHERE Name LIKE :Name');

        $queryName = '%' . $name . '%';

        $statement->execute(['Name' => $queryName]);

        while ($row = $statement->fetch()) {
            $result = [
                'DestinationID' => $row['DestinationID'],
                'Name' => $row['Name'],
                'Description' => $row['Description'],
                'Location' => $row['Location'],
                'ContinentID' => $row['ContinentID'],
            ];

            $destinations[] = $result;
        }

        return $destinations;
    }
}

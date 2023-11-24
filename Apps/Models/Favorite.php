<?php

namespace Apps\Models;


class Favorite
{
    private $db;

    private $UserID;
    private $DestinationID;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function fillData(array $row)
    {
        [
            'UserID' => $this->UserID,
            'DestinationID' => $this->DestinationID
        ] = $row;
        return $this;
    }

    public function getUserID()
    {
        return $this->UserID;
    }

    public function getDestinationID()
    {
        return $this->DestinationID;
    }

    public function getAll()
    {
        $favs = [];

        $statement = $this->db->prepare('SELECT * FROM Favorites ORDER BY UserID');

        $statement->execute();

        while ($row = $statement->fetch()) {
            $fav = new Favorite('');
            $fav->fillData($row);
            $favs[] = $fav;
        }
        return $favs;
    }

    public function addFav($UserID, $DestinationID)
    {
        $statement = $this->db->prepare("INSERT INTO Favorites (UserID, DestinationID) VALUES (:UserID, :DestinationID);");
        $result = $statement->execute([
            "UserID" => $UserID,
            "DestinationID" => $DestinationID
        ]);

        if ($result) {
            return $this->db->lastInsertId();
        } else {
            return 0;
        }
    }

    public function getAllFavoritesByUserID($UserID)
    {
        $favs = [];

        $statement = $this->db->prepare("SELECT * FROM Favorites WHERE UserID = :UserID;");
        $statement->execute(["UserID" => $UserID]);

        while ($row = $statement->fetch()) {
            $fav = new Favorite('');
            $fav->fillData($row);
            $favs[] = $fav;
        }
        return $favs;
    }

    public function deleteFav($UserID, $DestinationID)
    {
        $statement = $this->db->prepare("DELETE FROM Favorites WHERE UserID = :UserID AND DestinationID = :DestinationID;");
        $result = $statement->execute([
            "UserID" => $UserID,
            "DestinationID" => $DestinationID
        ]);

        return $result;
    }

    public function getTopDestinationsByFrequency()
    {
        $topDestinations = [];

        $query = "SELECT d.*, COUNT(f.DestinationID) AS frequency
              FROM Destinations d
              LEFT JOIN Favorites f ON d.DestinationID = f.DestinationID
              GROUP BY d.DestinationID
              ORDER BY frequency DESC
              LIMIT 6";

        $statement = $this->db->prepare($query);
        $statement->execute();

        while ($row = $statement->fetch()) {
            $destination = new Destination($this->db);
            $destination->fillData($row);
            $topDestinations[] = $destination;
        }

        return $topDestinations;
    }
}

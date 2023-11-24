<?php

namespace Apps\Models;


class Blog
{
    private $db;

    private $BlogID;
    private $UserID;
    private $Title;
    private $Content;
    private $CreatedAt;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function fillData(array $row)
    {
        [
            'BlogID' => $this->BlogID,
            'UserID' => $this->UserID,
            'Title' => $this->Title,
            'Content' => $this->Content,
            'CreatedAt' => $this->CreatedAt
        ] = $row;
        return $this;
    }

    public function getBlogID()
    {
        return $this->BlogID;
    }

    public function getUserID()
    {
        return $this->UserID;
    }

    public function getTitle()
    {
        return $this->Title;
    }

    public function getContent()
    {
        return $this->Content;
    }

    public function getCreatedAt()
    {
        return $this->CreatedAt;
    }

    public function getAll()
    {
        $blogs = [];

        $statement = $this->db->prepare('SELECT * FROM Blogs ORDER BY BlogID DESC');

        $statement->execute();

        while ($row = $statement->fetch()) {
            $blog = new Blog('');
            $blog->fillData($row);
            $blogs[] = $blog;
        }
        return $blogs;
    }

    public function delete($BlogID)
    {
        $statement = $this->db->prepare('DELETE FROM Blogs WHERE BlogID = :BlogID');

        $statement->execute(['BlogID' => $BlogID]);

        if ($statement) {
            echo "Xóa thành công";
        } else {
            echo "Xóa thất bại";
        }
    }

    public function findLatestBlogs()
    {
        $latestBlogs = [];

        $statement = $this->db->prepare('SELECT * FROM Blogs ORDER BY CreatedAt DESC LIMIT 4');
        $statement->execute();

        while ($row = $statement->fetch()) {
            $blog = new Blog('');
            $blog->fillData($row);
            $latestBlogs[] = $blog;
        }

        return $latestBlogs;
    }

    public function findBlog($BlogID)
    {
        $statement = $this->db->prepare('SELECT * FROM Blogs WHERE BlogID = :BlogID');

        $statement->execute(['BlogID' => $BlogID]);

        $row = $statement->fetch();

        $this->fillData($row);
        return $this;
    }

    public function add($UserID, $Title, $Content)
    {
        $statement = $this->db->prepare("INSERT INTO Blogs (UserID, Title, Content) VALUES (:UserID, :Title, :Content);");
        $result = $statement->execute([
            "UserID" => $UserID,
            "Title" => $Title,
            "Content" => $Content
        ]);

        if ($result) {
            return $this->db->lastInsertId();
        } else {
            return 0;
        }
    }
    public function edit($Title, $Content, $BlogID)
    {
        $statement = $this->db->prepare("UPDATE Blogs SET Title=:Title, Content=:Content WHERE BlogID=:BlogID");
        $result = $statement->execute([
            "Title" => $Title,
            "Content" => $Content,
            "BlogID" => $BlogID
        ]);

        return $result;
    }

    public function searchTitle($title)
    {
        $blogs = [];

        $statement = $this->db->prepare('SELECT * FROM Blogs WHERE Title LIKE :Title');

        $queryTitle = '%' . $title . '%';

        $statement->execute(['Title' => $queryTitle]);

        while ($row = $statement->fetch()) {
            $result = [
                'BlogID' => $row['BlogID'],
                'UserID' => $row['UserID'],
                'Title' => $row['Title'],
                'Content' => $row['Content'],
                'CreatedAt' => $row['CreatedAt'],
            ];

            $blogs[] = $result;
        }

        return $blogs;
    }
}

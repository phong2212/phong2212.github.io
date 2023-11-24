<?php

namespace Apps\Models;

use ErrorException;

class User
{
    private $db;

    private $UserID;
    private $Username;
    private $Password;
    private $isAdmin;


    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function checkUser($username, $pass)
    {
        $statement = $this->db->prepare("SELECT * FROM Users WHERE Username = :username");
        $statement->execute(['username' => $username]);


        $user = $statement->fetch();

        if (!$user) {
            return 0;
        }

        $Password = $user['Password'];

        if (md5($pass) == $Password) {
            return 1;
        } else {
            return 0;
        }
    }

    public function checkUserName($username)
    {

        $statement = $this->db->prepare("SELECT * FROM users WHERE Username = :username");
        $statement->execute(['username' => $username]);


        if ($statement->rowCount() == 0) {
            return 0;
        }
        return 1;
    }

    public function getUserID()
    {
        return $this->UserID;
    }

    public function getUsername()
    {
        return $this->Username;
    }

    public function fillData(array $row)
    {
        [
            'UserID' => $this->UserID,
            'Username' => $this->Username,
            'IsAdmin' => $this->isAdmin
        ] = $row;
        return $this;
    }

    public function checkAdmin($username)
    {
        $statement = $this->db->prepare("SELECT IsAdmin FROM users WHERE Username = :username");

        $statement->execute(['username' => $username]);

        if ($statement->rowCount() == 0) {
            return $error = "Không có người dùng này";
        } else {
            $row = $statement->fetch();
            return $row['IsAdmin'];
        }
    }

    public function register($username, $password, $email)
    {
        $password = md5($password);
        $statement = $this->db->prepare("INSERT INTO Users (Username, Password) VALUES (:username, :password)");
        $result = $statement->execute(['username' => $username, 'password' => $password]);

        if ($result) {
            $userID = $this->db->lastInsertId();
            $statement = $this->db->prepare("INSERT INTO UserProfiles (UserID, Email) VALUES (:userID, :email)");
            $result = $statement->execute(['userID' => $userID, 'email' => $email]);
        }

        return $result;
    }

    public function changePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user'])) {
            if ($this->checkUser($_SESSION['user'], $_POST['oldPassword'])) {
                if ($_POST['newPassword']) {
                    $password = md5($_POST['newPassword']);
                    $statement = $this->db->prepare("UPDATE users SET Password = :password  WHERE Username = :username");
                    if ($statement) {

                        $statement->execute(['password' => $password, 'username' => $_SESSION['user']]);
                        echo "<h6 class='text-success'> Đổi mật khẩu thành công </h6>";
                    } else {
                        echo "<h6 class='text-danger'> Có lỗi truy xuất </h6>";
                    }
                }
            } else {
                echo "<h6 class='text-danger'> Sai mật khẩu cũ </h6>";
            }
        } else {

            throw new ErrorException("Truy cập không đúng hoặc bạn chưa đăng nhập");
        }
    }

    public function getAll()
    {
        $users = [];

        $statement = $this->db->prepare('SELECT * FROM users ORDER BY UserID');


        $statement->execute();

        while ($row = $statement->fetch()) {
            $user = new User('');
            $user->fillData($row);
            $users[] = $user;
        }
        return $users;
    }

    public function delete($UserID) {
        $statementBlogs = $this->db->prepare('DELETE FROM Blogs WHERE UserID = :UserID');
        $statementBlogs->execute(['UserID' => $UserID]);

        $statementUserProfiles = $this->db->prepare('DELETE FROM UserProfiles WHERE UserID = :UserID');
        $statementUserProfiles->execute(['UserID' => $UserID]);
  
        $statementUsers = $this->db->prepare('DELETE FROM users WHERE UserID = :UserID');
        $statementUsers->execute(['UserID' => $UserID]);

        if ($statementBlogs && $statementUserProfiles && $statementUsers) {
            echo "Xóa thành công";
        } else {
            echo "Xóa thất bại";
        }
    }

    public function findUser($UserID)
{
    $statement = $this->db->prepare('SELECT * FROM users WHERE UserID = :UserID');

    $statement->execute(['UserID' => $UserID]);

    $row = $statement->fetch();

    $this->fillData($row);
    return $this;
}

}

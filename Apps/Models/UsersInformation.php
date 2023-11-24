<?php

namespace Apps\Models;

class UsersInformation
{
    private $db;

    private $UserID;
    private $Email;
    private $Fullname;
    private $Address;
    private $Phone;

    public function __construct($pdo)
    {
        $this->db = $pdo;
    }

    public function fillData(array $row)
    {
        [
            'UserID' => $this->UserID,
            'Email' => $this->Email,
            'Fullname' => $this->Fullname,
            'Address' => $this->Address,
            'Phone' => $this->Phone
        ] = $row;
        return $this;
    }

    public function getUserID()
    {
        return $this->UserID;
    }

    public function getEmail()
    {
        return $this->Email;
    }

    public function getFullname()
    {
        return $this->Fullname;
    }

    public function getAddress()
    {
        return $this->Address;
    }

    public function getPhone()
    {
        return $this->Phone;
    }

    public function getUser($username)
    {
        $statement = $this->db->prepare("SELECT Users.*, UserProfiles.*
        FROM Users
        JOIN UserProfiles ON Users.UserID = UserProfiles.UserID
        WHERE Users.Username = :username;
        ");

        $statement->execute(['username' => $username]);

        if ($statement->rowCount() == 0) {
            return $error = "Không có người dùng này";
        } else {
            $row = $statement->fetch();
            $this->fillData($row);
            return $this;
        }
    }

    public function changeInfor()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user'])) {
            if (isset($_POST['Email']) && filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)) {
                if (isset($_POST['Phone']) && preg_match('/^[0-9]{10}$/', $_POST['Phone'])) {
                    $statement = $this->db->prepare("UPDATE UserProfiles SET Email = :Email, Fullname = :Fullname, Address = :Address, Phone = :Phone WHERE UserID IN (SELECT UserID FROM Users WHERE Username = :Username);");
                    if ($statement) {

                        $statement->execute(['Email' => $_POST['Email'], 'Fullname' => $_POST['Fullname'], 'Address' => $_POST['Address'], 'Phone' => $_POST['Phone'], 'Username' => $_SESSION['user']]);
                        echo "<h6 class='text-success'> Thay đổi thông tin chi tiết thành công </h6>";
                    } else {

                        echo "<h6 class='text-danger'> Có lỗi truy vấn xảy ra </h6>";
                    }
                } else {
                    echo "<h6 class='text-danger'> Số điện thoại không hợp lệ </h6>";
                }
            } else {
                echo "<h6 class='text-danger'> Địa chỉ Email không hợp lệ </h6>";
            }
        }
    }

    public function getAll()
    {
        $users = [];

        $statement = $this->db->prepare('SELECT * FROM userprofiles ORDER BY UserID ASC ');

        $statement->execute();

        while ($row = $statement->fetch()) {
            $user = new UsersInformation('');
            $user->fillData($row);
            $users[] = $user;
        }
        return $users;
    }
}

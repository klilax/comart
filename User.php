<?php
require_once('db.php');

class User {
    private $id;
    private $username;
    private $email;
    private $role;
    private $status;
    private static $conn;

    function __construct($userInfo) {
//        if (array_key_exists('id', $userInfo))
            $this->id = $userInfo['id'];
//        if (array_key_exists('username', $userInfo))
            $this->username = $userInfo['username'];
//        if (array_key_exists('email', $userInfo))
            $this->email = $userInfo['email'];
//        if (array_key_exists('role', $userInfo))
            $this->role = $userInfo['role'];
//        if (array_key_exists('status', $userInfo))
            $this->status = $userInfo['status'];
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public static function setConn($conn) {
        self::$conn = $conn;
    }

    public static function isNewUser($username) {
        $sql = "SELECT * FROM user WHERE username = :username LIMIT 1";
        $stmt = self::$conn ->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->rowCount() == 0;
    }

    public static function auth($username, $password) {
        $sql = "SELECT * FROM user WHERE username = :username LIMIT 1";
        $stmt = self::$conn ->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch();
        if (password_verify($password, $row['password'])) {
            if ($row['status'] == 1) {
                session_start();
                $_SESSION['user'] = serialize(new User($row));
                $_SESSION['role'] = $row['role'];
                if ($row['role'] == 'vendor') {
                    header('location: vendor/index.php');
                } elseif ($row['role'] == 'buyer') {
                    header('location: shop/index.php');
                }
            } else {
                echo 'Account not active';
            }
        } else {
            echo 'error password or username';
        }
    }

    public static function fetchId($username) {
        $sql = "SELECT id FROM user WHERE username = :username LIMIT 1";
        $stmt = self::$conn ->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        if ($stmt->rowCount() != 0) {
            $row = $stmt->fetch();
            return  $row['id'];
        } else {
            return -1;
        }
    }

    public static function saveUserInfo($userInfo) {
        if (self::isNewUser($userInfo['username'])) {
            $sql = "INSERT INTO user (username, email, password, role, status) VALUE 
                (:username, :email, :password, :role, :status)";
            $stmt = self::$conn ->prepare($sql);
            $stmt->bindParam(':username', $userInfo['username']);
            $stmt->bindParam(':email',  $userInfo['email']);
            $userInfo['password'] = password_hash($userInfo['password'], PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $userInfo['password']);
            $stmt->bindParam(':role', $userInfo['role']);
            if ($userInfo['role'] == 'vendor') {
                $userInfo['status'] = 0;
            } else {
                $userInfo['status'] = 1;
            }
            $stmt->bindParam(':status', $userInfo['status']);
            $stmt->execute();
        }
    }

    public static function saveVendorInfo($userInfo) {
        $userId = self::fetchId($userInfo['username']);
        if ($userId != -1) {
            $sql = "INSERT INTO vendor (userId, vendorName, tinNumber) VALUE 
                (:id, :vendorName, :tinNumber)";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':id',$userId);
            $stmt->bindParam(':vendorName',$userInfo['vendorName']);
            $stmt->bindParam(':tinNumber',$userInfo['tinNumber']);
            $stmt->execute();
        }
    }

    public static function saveBuyerInfo($userInfo) {
        $userId = self::fetchId($userInfo['username']);
        if ($userId != -1) {
            $sql = "INSERT INTO buyer (userId, firstname, lastname, tinNumber) VALUE 
                    (:id, :firstName, :lastName, :tinNumber)";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':id',$userId);
            $stmt->bindParam(':firstName',$userInfo['firstName']);
            $stmt->bindParam(':lastName',$userInfo['lastName']);
            $stmt->bindParam(':tinNumber',$userInfo['tinNumber']);
            $stmt->execute();
        }
    }

    public static function saveAdminInfo($userInfo) {
        $userId = self::fetchId($userInfo['username']);
        if ($userId != -1) {
            $sql = "INSERT INTO admin (userId, firstname, lastname) VALUE 
                    (:id, :firstName, :lastName)";
            $stmt = self::$conn->prepare($sql);
            $stmt->bindParam(':id',$userId);
            $stmt->bindParam(':firstName',$userInfo['firstName']);
            $stmt->bindParam(':lastName',$userInfo['lastName']);
            $stmt->execute();
        }
    }

    public static function register($userInfo) {
        self::saveUserInfo($userInfo);
        if ($userInfo['role'] == 'vendor') {
            self::saveVendorInfo($userInfo);
        } elseif ($userInfo['role'] == 'buyer') {
            self::saveBuyerInfo($userInfo);
        } elseif ($userInfo['role'] == 'admin') {
            self::saveAdminInfo($userInfo);
        }
    }
}

User::setConn(getConnection());
?>
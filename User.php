<?php
require_once('db.php');

class user {
    private $id;
    private $username;
    private $email;
    private $password;
    private $role;
    private $status;
    private static $conn;

    function __construct($userInfo) {
        self::$conn = getConnection();
        if (array_key_exists('id', $userInfo))
            $this->id = $userInfo['id'];
        if (array_key_exists('username', $userInfo))
            $this->username = $userInfo['username'];
        if (array_key_exists('email', $userInfo))
            $this->email = $userInfo['email'];
        if (array_key_exists('password', $userInfo))
            $this->password = password_hash($userInfo['password'], PASSWORD_DEFAULT);
        if (array_key_exists('role', $userInfo))
            $this->role = $userInfo['role'];
        if ($this->role == 'vendor')
            $this->status = 0;
        else
            $this->status = 1;
    }

    public function getId() {
        return $this->id;
    }

    public function __toString()
    {
        // TODO: Implement __toString() method.
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

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
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

    public function isNewUser() {
//        $sql = "SELECT * FROM user WHERE username = {$this->username} LIMIT 1";
        $sql = "SELECT * FROM user WHERE username = :username LIMIT 1";
        $stmt = self::$conn ->prepare($sql);
        $stmt->bindParam(':username', $this->username);
        $stmt->execute();
        return $stmt-> rowCount() == 0;
    }

    public function save() {
        if ($this->isNewUser()) {
            $sql = "INSERT INTO user (username, email, password, role, status) VALUE
                    (:username, :email, :password, :role, :status);";
            $stmt = self::$conn ->prepare($sql);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':role', $this->role);
            $stmt->bindParam(':status', $this->status);
            $stmt->execute();
        }
    }
}

?>
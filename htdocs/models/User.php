<?php

class User {
    private $id;
    private $names;
    private $lastnames;
    private $username;
    private $email;
    private $password;
    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
    }
    public function getNames() {
        return $this->names;
    }
    public function setNames($names) {
        $this->$names = $names;
    }
    public function getLastNames() {
        return $this->lastnames;
    }
    public function setLastNames($lastnames) {
        $this->lastnames = $lastnames;
    }
    public function getUsername () {
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
    public function __construct($names, $lastnames,$username,$email,$password) {
        $this->names = $names;
        $this->lastnames = $lastnames;
        $this->username = $username;
        $this->email = $email; 
        $this->password = $password;
    }
    static public function parseJson($json) {
        $user =  new User(
            isset($json["names"]) ? $json["names"] : "",
            isset($json["lastnames"]) ? $json["lastnames"] : "",
            isset($json["username"]) ? $json["username"] : "",
            isset($json["email"]) ? $json["email"] : "",
            isset($json["password"]) ? $json["password"] : ""
        );
        if(isset($json["id"]))
            $user->setId((int)$json["id"]);
        return $user;
    }
    public function save($mysqli) {
        $sql = "INSERT INTO users (names, lastnames, username, email, password) VALUES (?,?,?,?,?)";
        $stmt= $mysqli->prepare($sql);
        $stmt->bind_param("sssss", $this->names, $this->lastnames, $this->username, $this->email,$this->password);
        $stmt->execute();
        $this->id = (int)$stmt->insert_id;
    }
    public static function findUserByUsername($mysqli, $username, $password) {
        $sql = "SELECT id, names, lastnames, username, email FROM users WHERE  username = ? AND password = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss",$username, $password);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $user = $result->fetch_assoc();
        return $user ? User::parseJson($user) : NULL;
    }
    public static function findUserById($mysqli, $id) {
        $sql = "SELECT id, names, lastnames, username, email FROM users WHERE  id = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $user = $result->fetch_assoc();
        return $user ? User::parseJson($user) : NULL;
    }
    public function toJSON() {
        return get_object_vars($this);
    }
}
<?php

class Usuario {
    private $idUsuario;
    private $Nombre_Usuario;
    private $Apellido_Paterno_Usuario;
    private $Apellido_Materno_Usuario;
    private $Correo_Usuario;
    private $Contrasenia_Usuario;
    private $Username;
    private $Foto_Perfil;
    private $Estado_Usuario;
    private $Rol_User;
    private $Genero;
    private $Fecha_Nacimiento;
    private $Fecha_Registro;
    private $Fecha_Modificacion;
    private $Intentos_Fallidos;
    public $mensaje;

    public function getId() {
        return $this->idUsuario;
    }
    public function setId($idUsuario) {
        $this->idUsuario = $idUsuario;
    }
    public function getNames() {
        return $this->Nombre_Usuario;
    }
    public function setNames($Nombre_Usuario) {
        $this->$Nombre_Usuario = $Nombre_Usuario;
    }
        public function getSecondName() {
        return $this->Apellido_Paterno_Usuario;
    }
    public function setSecondName($Apellido_Paterno_Usuario) {
        $this->Apellido_Paterno_Usuario = $Apellido_Paterno_Usuario;
    }
    public function getLastName() {
        return $this->Apellido_Materno_Usuario;
    }
    public function setLastName($Apellido_Materno_Usuario) {
        $this->Apellido_Materno_Usuario = $Apellido_Materno_Usuario;
    }
    public function getEmail() {
        return $this->Correo_Usuario;
    }
    public function setEmail($Correo_Usuario) {
        $this->Correo_Usuario = $Correo_Usuario;
    }
    public function getPassword() {
        return $this->Contrasenia_Usuario;
    }
    public function setPassword($Contrasenia_Usuario) {
        $this->Contrasenia_Usuario = $Contrasenia_Usuario;
    }
    public function getUsername () {
        return $this->Username;
    }
    public function setUsername($Username) {
        $this->Username = $Username;
    }
    public function getPhoto () {
        return $this->Foto_Perfil;
    }
    public function setPhoto($Foto_Perfil) {
        $this->Foto_Perfil = $Foto_Perfil;
    }
    public function getUserState () {
        return $this->Estado_Usuario;
    }
    public function setUserState($Estado_Usuario) {
        $this->Estado_Usuario = $Estado_Usuario;
    }
    public function getRoleUser () {
        return $this->Rol_User;
    }
    public function setRoleUser($Rol_User) {
        $this->Rol_User = $Rol_User;
    }
    public function getIntentos_Fallidos () {
        return $this->Intentos_Fallidos;
    }
    public function setIntentos_Fallidos($Intentos_Fallidos) {
        $this->Intentos_Fallidos = $Intentos_Fallidos;
    }

    public function __construct($Nombre_Usuario, $Apellido_Paterno_Usuario,$Apellido_Materno_Usuario,$Correo_Usuario,$Contrasenia_Usuario,$Username,$Estado_Usuario,$Rol_User,$Genero,$Fecha_Nacimiento) {
        $this->Nombre_Usuario = $Nombre_Usuario;
        $this->Apellido_Paterno_Usuario = $Apellido_Paterno_Usuario;
        $this->Apellido_Materno_Usuario = $Apellido_Materno_Usuario;
        $this->Correo_Usuario = $Correo_Usuario;
        $this->Contrasenia_Usuario = $Contrasenia_Usuario;
        $this->Username = $Username;
        $this->Estado_Usuario = $Estado_Usuario;
        $this->Rol_User = $Rol_User;
        $this->Genero = $Genero;
        $this->Fecha_Nacimiento = $Fecha_Nacimiento;
    }
    static public function parseJson($json) {
        $user =  new Usuario(
            isset($json["Nombre_Usuario"]) ? $json["Nombre_Usuario"] : "",
            isset($json["Apellido_Paterno_Usuario"]) ? $json["Apellido_Paterno_Usuario"] : "",
            isset($json["Apellido_Materno_Usuario"]) ? $json["Apellido_Materno_Usuario"] : "",
            isset($json["Correo_Usuario"]) ? $json["Correo_Usuario"] : "",
            isset($json["Contrasenia_Usuario"]) ? $json["Contrasenia_Usuario"] : "" ,
            isset($json["Username"]) ? $json["Username"] : "",
            isset($json["Estado_Usuario"]) ? $json["Estado_Usuario"] : "",
            isset($json["Rol_User"]) ? $json["Rol_User"] : "",
            isset($json["Genero"]) ? $json["Genero"] : "",
            isset($json["Fecha_Nacimiento"]) ? $json["Fecha_Nacimiento"] : ""
        );
        if(isset($json["idUsuario"]))
            $user->setId((int)$json["idUsuario"]);

        if(isset($json["Intentos_Fallidos"]))
            $user->setIntentos_Fallidos((int)$json["Intentos_Fallidos"]);

        return $user;

    }
    public function saveUser($mysqli) {
        $id;

        //$sql = "INSERT INTO Usuario (Nombre_Usuario, Apellido_Paterno_Usuario, Apellido_Materno_Usuario, Correo_Usuario, Contrasenia_Usuario, Username, Foto_Perfil, Estado_Usuario, Rol_User) VALUES(?,?,?,?,?,?,?,?,?)";

        $sql = "CALL SP_RegUsuario(?,?,?,?,?,?,?,?,?)";

        $this->mensaje='';
        $stmt= $mysqli->prepare($sql);


        //$stmt->bind_param("sssssssss", $this->Nombre_Usuario, $this->Apellido_Paterno_Usuario, $this->Apellido_Materno_Usuario, $this->Correo_Usuario, $this->Contrasenia_Usuario, $this->Username, $this->Foto_Perfil, $this->Rol_User, $this->Rol_User);
        
        $stmt->bind_param("ssssssiis", $this->Nombre_Usuario, $this->Apellido_Paterno_Usuario, $this->Apellido_Materno_Usuario, $this->Correo_Usuario, $this->Contrasenia_Usuario, $this->Username, $this->Rol_User, $this->Genero, 
            $this->Fecha_Nacimiento);
        
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        $msg = $result->fetch_assoc();
        
        $this->mensaje = isset($msg["mensaje"]) ? $msg["mensaje"] : "";
        $this->idUsuario = (int)$stmt->insert_id;
    }



    public function editUser($mysqli) {
        $id;

        $sql = "CALL SP_EditUsuario(?,?,?,?,?,?,?,?,?,?)";

        $this->mensaje='';
        $stmt= $mysqli->prepare($sql);
        
        $stmt->bind_param("sssssssiis", $this->idUsuario, $this->Nombre_Usuario, $this->Apellido_Paterno_Usuario, $this->Apellido_Materno_Usuario, $this->Correo_Usuario, $this->Contrasenia_Usuario, $this->Username, $this->Rol_User, $this->Genero, $this->Fecha_Nacimiento);
        
        $stmt->execute(); 
        
        $this->idUsuario = (int)$stmt->insert_id;
    }

    public static function findUserByUsername($mysqli, $username, $password) {
        $sql = "SELECT * FROM Usuario WHERE Username = ? AND Contrasenia_Usuario = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ss",$username, $password);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $user = $result->fetch_assoc();
        return $user ? Usuario::parseJson($user) : NULL;
    }
    public static function findUserById($mysqli, $id) {
        $sql = "SELECT Rol_User FROM Usuario WHERE idUsuario = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $user = $result->fetch_assoc();
        return $user ? Usuario::parseJson($user) : NULL;
    }
     public static function findRolUserById($mysqli, $id) {
        $sql = "SELECT * FROM Usuario WHERE idUsuario = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $user = $result->fetch_assoc();
        return $user ? Usuario::parseJson($user) : NULL;
    }
    public static function findUserByUsernameOnlyUsername($mysqli, $username) {
        $sql = "SELECT * FROM Usuario WHERE Username = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $user = $result->fetch_assoc();
        return $user ? Usuario::parseJson($user) : NULL;
    }
    public function updateLoginFallidos($mysqli, $username) {
        $sql = "SELECT Intentos_Fallidos FROM Usuario WHERE Username = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        $msg = $result->fetch_assoc();
        $this->Intentos_Fallidos = isset($msg["Intentos_Fallidos"]) ? $msg["Intentos_Fallidos"] : "";

        $sql = " ";
        if($this->Intentos_Fallidos + 1 >= 3){
            $sql = "UPDATE Usuario SET Intentos_Fallidos = ?, Estado_Usuario = 0 WHERE Username = ? LIMIT 1";
        }
        else{
            $sql = "UPDATE Usuario SET Intentos_Fallidos = ? WHERE Username = ? LIMIT 1";
        }
        $this->Intentos_Fallidos=$this->Intentos_Fallidos +1;
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("is",$this->Intentos_Fallidos, $username);
        $stmt->execute();
        $result = $stmt->get_result(); 
    }
    public static function findEstadoByUsername($mysqli, $username) {
        $sql = "SELECT Estado_Usuario FROM Usuario WHERE Username = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $user = $result->fetch_assoc();
        return $user ? Usuario::parseJson($user) : NULL;
    }
    public function RestablecerIntentos($mysqli, $username) {
        $sql = "UPDATE Usuario SET Intentos_Fallidos = 0 WHERE Username = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result(); 
    }
    public function toJSON() {
        return get_object_vars($this);
    }
}
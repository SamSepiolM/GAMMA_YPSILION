<?php

class Capitulo {
    private $IdCapitulo;
    private $TituloCapitulo;
    private $VideoCapitulo;
    private $Descripcion;
    private $FechaRegCap;
    private $CategoriasCapitulo;
    private $Curso;
    private $Gratis;
    public $mensaje;

    public function getId() {
        return $this->IdCapitulo;
    }
    public function setId($IdCapitulo) {
        $this->IdCapitulo = $IdCapitulo;
    }
    public function getTitle() {
        return $this->TituloCapitulo;
    }
    public function setTitle($TituloCapitulo) {
        $this->$TituloCapitulo = $TituloCapitulo;
    }
    public function getVideoCapitulo() {
        return $this->VideoCapitulo;
    }
    public function setVideoCapitulo($VideoCapitulo) {
        $this->$VideoCapitulo = $VideoCapitulo;
    }
    public function getDescription() {
        return $this->Descripcion;
    }
    public function setDescription($Descripcion) {
        $this->Descripcion = $Descripcion;
    }
    public function getFechaRegistro() {
        return $this->FechaRegCap;
    }
    public function setFechaRegistro($FechaRegCap) {
        $this->FechaRegCap = $FechaRegCap;
    }
    public function getCategoria() {
        return $this->CategoriasCapitulo;
    }
    public function setCategoria($CategoriasCapitulo) {
        $this->CategoriasCapitulo = $CategoriasCapitulo;
    }
    public function getCurso() {
        return $this->Curso;
    }
    public function setCurso($Curso) {
        $this->Curso = $Curso;
    }
    public function getGratis() {
        return $this->Gratis;
    }
    public function setGratis($Gratis) {
        $this->Gratis = $Gratis;
    }


    public function __construct($TituloCapitulo, $Descripcion,$Curso) {
        $this->TituloCapitulo = $TituloCapitulo;
        $this->Descripcion = $Descripcion;
        $this->Curso = $Curso;
    }
    static public function parseJson($json) {
        $curso =  new Capitulo(
            isset($json["TituloCapitulo"]) ? $json["TituloCapitulo"] : "",
            isset($json["Descripcion"]) ? $json["Descripcion"] : "",
            isset($json["Curso"]) ? $json["Curso"] : "",
        );

        if(isset($json["Gratis"])){
            $curso->setGratis((int)$json["Gratis"]);
        }

        if(isset($json["IdCapitulo"])){
            $curso->setId((int)$json["IdCapitulo"]);
        }

        

        if(isset($json["VideoCapitulo"])){
            $curso->setVideoCapitulo((string)$json["VideoCapitulo"]);
        }
            

        return $curso;

    }
    public function saveCapitulo($mysqli) {
        $id;

        $sql = "INSERT INTO Capitulo (TituloCapitulo, Descripcion, Curso, Gratis) VALUES(?,?,?,?)";

        //$sql = "CALL SP_RegUsuario(?,?,?,?,?,?,?,?,?,?,?,?)";

        $this->mensaje='';
        $stmt= $mysqli->prepare($sql);


        //$stmt->bind_param("sssssssss", $this->Nombre_Usuario, $this->Apellido_Paterno_Usuario, $this->Apellido_Materno_Usuario, $this->Correo_Usuario, $this->Contrasenia_Usuario, $this->Username, $this->Foto_Perfil, $this->Rol_User, $this->Rol_User);
        
    $stmt->bind_param("ssii", $this->TituloCapitulo, $this->Descripcion, $this->Curso, $this->Gratis);
        
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        //$msg = $result->fetch_assoc();
        
        //$this->mensaje = isset($msg["mensaje"]) ? $msg["mensaje"] : "";
        $this->IdCapitulo = (int)$stmt->insert_id;
    }



    public function editCapitulo($mysqli) {
        $id;

        //$sql = "CALL SP_EditUsuario(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql = "UPDATE Capitulo SET TituloCapitulo = ?, Descripcion = ?, Curso = ?, Gratis = ? WHERE IdCapitulo=?;";

        $this->mensaje='';
        $stmt= $mysqli->prepare($sql);

        $stmt->bind_param("ssiii", $this->TituloCapitulo, $this->Descripcion, $this->Curso, $this->Gratis, $this->IdCapitulo);
        
        //$stmt->bind_param("ssssssssiisis", $this->idUsuario, $this->Nombre_Usuario, $this->Apellido_Paterno_Usuario, $this->Apellido_Materno_Usuario, $this->Correo_Usuario, $this->Contrasenia_Usuario, $this->Username, $this->Foto_Perfil, $this->Rol_User, $this->Genero, $this->Fecha_Nacimiento, $id, $this->mensaje);
        
        $stmt->execute(); 
        
        $this->idCurso = (int)$stmt->insert_id;
    }

    public function deleteCurso($mysqli) {
        $id;

        //$sql = "CALL SP_EditUsuario(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql = "UPDATE Curso SET EstadoCurso = ? WHERE idCurso = ?;";

        $this->mensaje='';
        $stmt= $mysqli->prepare($sql);

        $stmt->bind_param("si", $this->Estado_Curso, $this->idCurso);
        
        //$stmt->bind_param("ssssssssiisis", $this->idUsuario, $this->Nombre_Usuario, $this->Apellido_Paterno_Usuario, $this->Apellido_Materno_Usuario, $this->Correo_Usuario, $this->Contrasenia_Usuario, $this->Username, $this->Foto_Perfil, $this->Rol_User, $this->Genero, $this->Fecha_Nacimiento, $id, $this->mensaje);
        
        $stmt->execute(); 
        
        $this->idCurso = (int)$stmt->insert_id;
    }

    public static function findCursoByTitle($mysqli, $titulo) {
        $sql = "SELECT * FROM Curso WHERE Titulo_Curso = ? AND EstadoCurso = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("si",$titulo, 1);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $curso = $result->fetch_assoc();
        return $curso ? Curso::parseJson($curso) : NULL;
    }
    public static function findCursoById($mysqli, $id) {
        $sql = "SELECT * FROM Curso WHERE idCurso = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $curso = $result->fetch_assoc();
        return $curso ? Curso::parseJson($curso) : NULL;
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
    public function toJSON() {
        return get_object_vars($this);
    }
}
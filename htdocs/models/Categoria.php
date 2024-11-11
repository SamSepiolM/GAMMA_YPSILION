<?php

class Categoria {
    private $idCategoria;
    private $Nombre_categoria;
    private $Descripcion_categoria;
    private $Creador_categoria;
    private $Fecha_Creacion_categoria;
    private $EstadoCategoria;
    
    public $mensaje;

    public function getId() {
        return $this->idCategoria;
    }
    public function setId($idCategoria) {
        $this->idCategoria = $idCategoria;
    }
    public function getTitle() {
        return $this->Nombre_categoria;
    }
    public function setTitle($Nombre_categoria) {
        $this->$Nombre_categoria = $Nombre_categoria;
    }
    public function getDescription() {
        return $this->Descripcion_categoria;
    }
    public function setDescription($Descripcion_categoria) {
        $this->Descripcion_categoria = $Descripcion_categoria;
    }
    public function getFechaRegistro() {
        return $this->Fecha_Creacion_categoria;
    }
    public function setFechaRegistro($Fecha_Creacion_categoria) {
        $this->Fecha_Creacion_categoria = $Fecha_Creacion_categoria;
    }
    public function getCreador() {
        return $this->Creador_categoria;
    }
    public function setCreador($Creador_categoria) {
        $this->Creador_categoria = $Creador_categoria;
    }
    public function getEstadoCategoria() {
        return $this->EstadoCategoria;
    }
    public function setEstadoCategoria($EstadoCategoria) {
        $this->EstadoCategoria = $EstadoCategoria;
    }



    public function __construct($Nombre_categoria) {
        $this->Nombre_categoria = $Nombre_categoria;
    }
    static public function parseJson($json) {
        $categoria =  new Categoria(
            isset($json["Nombre_categoria"]) ? $json["Nombre_categoria"] : "",
        );

        if(isset($json["Descripcion_categoria"])){
            $categoria->setDescription((string)$json["Descripcion_categoria"]);
        }

        if(isset($json["idCategoria"])){
            $categoria->setId((int)$json["idCategoria"]);
        }

        if(isset($json["Creador_categoria"])){
            $categoria->setCreador((int)$json["Creador_categoria"]);
        }

        if(isset($json["EstadoCategoria"])){
            $categoria->setEstadoCategoria((int)$json["EstadoCategoria"]);
        }

        
            

        return $categoria;

    }
    public function saveCategoria($mysqli) {
        $id;

        //$sql = "INSERT INTO Categoria (Nombre_categoria, Descripcion_categoria, Creador_categoria) VALUES(?,?,?)";

        $sql = "CALL SP_RegCategoria(?,?,?)";

        $this->mensaje='';
        $stmt= $mysqli->prepare($sql);


        //$stmt->bind_param("sssssssss", $this->Nombre_Usuario, $this->Apellido_Paterno_Usuario, $this->Apellido_Materno_Usuario, $this->Correo_Usuario, $this->Contrasenia_Usuario, $this->Username, $this->Foto_Perfil, $this->Rol_User, $this->Rol_User);
        
    $stmt->bind_param("ssi", $this->Nombre_categoria, $this->Descripcion_categoria, $this->Creador_categoria);
        
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        //$msg = $result->fetch_assoc();
        
        //$this->mensaje = isset($msg["mensaje"]) ? $msg["mensaje"] : "";
        $this->idCategoria = (int)$stmt->insert_id;
    }



    public function editCategoria($mysqli) {
        $id;

        $sql = "CALL SP_EditCategoria(?,?,?)";
        //$sql = "UPDATE Categoria SET Nombre_categoria = ?, Descripcion_categoria = ? WHERE idCategoria=?;";

        $this->mensaje='';
        $stmt= $mysqli->prepare($sql);

        $stmt->bind_param("ssi", $this->Nombre_categoria, $this->Descripcion_categoria, $this->idCategoria);
        
        //$stmt->bind_param("ssssssssiisis", $this->idUsuario, $this->Nombre_Usuario, $this->Apellido_Paterno_Usuario, $this->Apellido_Materno_Usuario, $this->Correo_Usuario, $this->Contrasenia_Usuario, $this->Username, $this->Foto_Perfil, $this->Rol_User, $this->Genero, $this->Fecha_Nacimiento, $id, $this->mensaje);
        
        $stmt->execute(); 
        
        $this->idCategoria = (int)$stmt->insert_id;
    }

    public function deleteCategoria($mysqli) {
        $id;

        $sql = "CALL SP_EliminLogCategoria(?,?)";
        //$sql = "UPDATE Categoria SET EstadoCategoria = ? WHERE idCategoria = ?;";

        $this->mensaje='';
        $stmt= $mysqli->prepare($sql);

        $stmt->bind_param("ii", $this->EstadoCategoria, $this->idCategoria);
        
        //$stmt->bind_param("ssssssssiisis", $this->idUsuario, $this->Nombre_Usuario, $this->Apellido_Paterno_Usuario, $this->Apellido_Materno_Usuario, $this->Correo_Usuario, $this->Contrasenia_Usuario, $this->Username, $this->Foto_Perfil, $this->Rol_User, $this->Genero, $this->Fecha_Nacimiento, $id, $this->mensaje);
        
        $stmt->execute(); 
        
        $this->idCategoria = (int)$stmt->insert_id;
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
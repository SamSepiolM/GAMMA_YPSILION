<?php

class Curso {
    private $idCurso;
    private $idUser;
    private $Titulo_Curso;
    private $Descripcion_Curso;
    private $Grado_Curso;
    private $Precio_Curso;
    private $Categoria_Curso;
    private $Creador_Curso;
    private $Estado_Curso;
    private $Fecha_Registro_Curso;
    private $Calificacion;
    private $Comentario;
    private $PrecioPagado;
    private $FormaPago;
    public $mensaje;

    public function getId() {
        return $this->idCurso;
    }
    public function setId($idCurso) {
        $this->idCurso = $idCurso;
    }
    public function getTitle() {
        return $this->Titulo_Curso;
    }
    public function setTitle($Titulo_Curso) {
        $this->$Titulo_Curso = $Titulo_Curso;
    }
    public function getDescription() {
        return $this->Descripcion_Curso;
    }
    public function setDescription($Descripcion_Curso) {
        $this->Descripcion_Curso = $Descripcion_Curso;
    }
    public function getGrado() {
        return $this->Grado_Curso;
    }
    public function setGrado($Grado_Curso) {
        $this->Grado_Curso = $Grado_Curso;
    }
    public function getFechaRegistro() {
        return $this->Fecha_Registro_Curso;
    }
    public function setFechaRegistro($Fecha_Registro_Curso) {
        $this->Fecha_Registro_Curso = $Fecha_Registro_Curso;
    }
    public function getEstado() {
        return $this->Estado_Curso;
    }
    public function setEstado($Estado_Curso) {
        $this->Estado_Curso = $Estado_Curso;
    }
    public function getPrecio() {
        return $this->Precio_Curso;
    }
    public function setPrecio($Precio_Curso) {
        $this->Precio_Curso = $Precio_Curso;
    }
    public function getUserCreador() {
        return $this->Creador_Curso;
    }
    public function setUserCreador($Creador_Curso) {
        $this->Creador_Curso = $Creador_Curso;
    }
    public function getCategoria() {
        return $this->Categoria_Curso;
    }
    public function setCategoria($Categoria_Curso) {
        $this->Categoria_Curso = $Categoria_Curso;
    }
    public function getCalificacion() {
        return $this->Calificacion;
    }
    public function setCalificacion($Calificacion) {
        $this->Calificacion = $Calificacion;
    }
    public function getComentario() {
        return $this->Comentario;
    }
    public function setComentario($Comentario) {
        $this->Comentario = $Comentario;
    }
    public function getPrecioPagado() {
        return $this->PrecioPagado;
    }
    public function setPrecioPagado($PrecioPagado) {
        $this->PrecioPagado = $PrecioPagado;
    }

    public function getFormaPago() {
        return $this->FormaPago;
    }
    public function setFormaPago($FormaPago) {
        $this->FormaPago = $FormaPago;
    }


    public function __construct($idCurso, $idUser) {
        $this->idCurso = $idCurso;
        $this->idUser = $idUser;
    }

    static public function parseJson($json) {
        $curso =  new Curso(
            isset($json["idCurso"]) ? $json["idCurso"] : "",
            isset($json["idUser"]) ? $json["idUser"] : "",
        );

        if(isset($json["Nombre_calificacion"])){
            $curso->setCalificacion((string)$json["Nombre_calificacion"]);
        }

        if(isset($json["Comentario"])){
            $curso->setComentario((string)$json["Comentario"]);
        }

        
        return $curso;

    }

    static public function parseJson2($json) {
        $curso =  new Curso(
            isset($json["idCurso"]) ? $json["idCurso"] : "",
            isset($json["idUser"]) ? $json["idUser"] : "",
        );

        if(isset($json["Calificacion"])){
            $curso->setCalificacion((int)$json["Calificacion"]);
        }

        if(isset($json["FormaPago"])){
            $curso->setFormaPago((int)$json["FormaPago"]);
        }

        if(isset($json["PrecioPagado"])){
            $curso->setPrecioPagado((string)$json["PrecioPagado"]);
        }
            

        return $curso;

    }

    public function saveCurso($mysqli) {
        $id;

        $sql = "INSERT INTO Curso (Titulo_Curso, Descripcion_Curso, GradoCurso, EstadoCurso, PrecioCurso, Creador_Curso, Categoria) VALUES(?,?,?,?,?,?,?)";

        //$sql = "CALL SP_RegUsuario(?,?,?,?,?,?,?,?,?,?,?,?)";

        $this->mensaje='';
        $stmt= $mysqli->prepare($sql);


        //$stmt->bind_param("sssssssss", $this->Nombre_Usuario, $this->Apellido_Paterno_Usuario, $this->Apellido_Materno_Usuario, $this->Correo_Usuario, $this->Contrasenia_Usuario, $this->Username, $this->Foto_Perfil, $this->Rol_User, $this->Rol_User);
        
    $stmt->bind_param("sssssii", $this->Titulo_Curso, $this->Descripcion_Curso, $this->Grado_Curso, $this->Estado_Curso, $this->Precio_Curso, $this->Creador_Curso, $this->Categoria_Curso);
        
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        //$msg = $result->fetch_assoc();
        
        //$this->mensaje = isset($msg["mensaje"]) ? $msg["mensaje"] : "";
        $this->idCurso = (int)$stmt->insert_id;
    }

    public function comprarCurso($mysqli) {
        $id;

        $sql = "INSERT INTO CursoComprado (idCurso, idUser, Comprado_Completo, PrecioPagado, FormaPago) VALUES(?,?,1,?,?)";

        $this->mensaje='';
        $stmt= $mysqli->prepare($sql);
        
        $stmt->bind_param("iisi", $this->idCurso, $this->idUser, $this->PrecioPagado, $this->FormaPago);
        
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        //$msg = $result->fetch_assoc();
        
        //$this->mensaje = isset($msg["mensaje"]) ? $msg["mensaje"] : "";
        $this->idCurso = (int)$stmt->insert_id;
    }

    public function calificarCurso($mysqli) {
        $id;

        $sql = "UPDATE CursoComprado SET Calificacion = ? WHERE IdCursoComprado = ?;";

        $this->mensaje='';
        $stmt= $mysqli->prepare($sql);
        
        $stmt->bind_param("ii", $this->Calificacion, $this->idCurso);
        
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        //$msg = $result->fetch_assoc();
        
        //$this->mensaje = isset($msg["mensaje"]) ? $msg["mensaje"] : "";
        $this->idCurso = (int)$stmt->insert_id;
    }

    public function comentarCurso($mysqli) {
        $id;

        $sql = "INSERT INTO Calificacion (Nombre_calificacion, Comentario, Usuario_calificador, Curso_Calificado) VALUES(?,?,?,?)";

        $this->mensaje='';
        $stmt= $mysqli->prepare($sql);
        
        $stmt->bind_param("ssii", $this->Calificacion, $this->Comentario, $this->idUser, $this->idCurso);
        
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        //$msg = $result->fetch_assoc();
        
        //$this->mensaje = isset($msg["mensaje"]) ? $msg["mensaje"] : "";
        $this->idCurso = (int)$stmt->insert_id;
    }



    public function editCurso($mysqli) {
        $id;

        //$sql = "CALL SP_EditUsuario(?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $sql = "UPDATE Curso SET Titulo_Curso = ?, Descripcion_Curso = ?, GradoCurso = ?, EstadoCurso = ?, 
		Precio_Curso = ?, Categoria = ? WHERE idCurso = ?;";

        $this->mensaje='';
        $stmt= $mysqli->prepare($sql);

        $stmt->bind_param("sssssii", $this->Titulo_Curso, $this->Descripcion_Curso, $this->Grado_Curso, $this->Estado_Curso, $this->Precio_Curso, $this->Categoria_Curso, $this->idCurso);
        
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
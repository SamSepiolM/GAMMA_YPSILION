<?php
class Mensajes {
    	private $idMensajes;
        private $Emisor;
        private $Receptor;
        private $Mensaje;
        private $Fecha_envio;
        public $msje;

        public function getId() {
            return $this->idMensajes;
        }
        public function setId($idMensajes) {
            $this->idMensajes = $idMensajes;
        }

        public function getEmisor() {
            return $this->Emisor;
        }
        public function setEmisor($Emisor) {
            $this->Emisor = $Emisor;
        }

        public function getReceptor() {
            return $this->Receptor;
        }
        public function setReceptor($Receptor) {
            $this->Receptor = $Receptor;
        }

        public function getTitle() {
            return $this->Mensaje;
        }
        public function setTitle($Mensaje) {
            $this->Mensaje = $Mensaje;
        }

        public function getFecha_envio() {
            return $this->Fecha_envio;
        }
        public function setFecha_envio($Fecha_envio) {
            $this->Fecha_envio = $Fecha_envio;
        }

        public function __construct($Emisor, $Receptor, $Mensaje){
    		$this->Emisor = $Emisor;
    		$this->Receptor = $Receptor;
    		$this->Mensaje = $Mensaje;
        }


        static public function parseJson($json) {
            $mensajes =  new Mensajes(

                isset($json["Emisor"]) ? $json["Emisor"] : "",
                isset($json["Receptor"]) ? $json["Receptor"] : "",
                isset($json["Mensaje"]) ? $json["Mensaje"] : ""
            );

            if(isset($json["idMensajes"])){
                $mensajes->setId((int)$json["idMensajes"]);
            }
 

            return $mensajes;
        }


        public function saveMensajes($mysqli) {
        $id;
        $sql = "INSERT INTO Mensajes (Mensaje, Emisor, Receptor) VALUES (?,?,?)";

        $this->mensaje='';
        $stmt= $mysqli->prepare($sql);


        $stmt->bind_param("sii", $this->Mensaje ,$this->Emisor ,$this->Receptor);
            $stmt->execute(); 
            $result = $stmt->get_result(); 
            
        $this->idMensajes = (int)$stmt->insert_id;
        }
    }
?>
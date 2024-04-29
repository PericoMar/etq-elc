<?php
class ConexionBD {
    private $servername = "localhost";
    private $username = "gestor";
    private $password = "gestorGESTOR2";
    private $dbname = "etiquetas";
    private $conn;

    // Constructor para establecer la conexión
    public function __construct() {
        $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
        // Configurar PDO para que lance excepciones en caso de errores
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Método para obtener la conexión
    public function getConexion() {
        return $this->conn;
    }
}
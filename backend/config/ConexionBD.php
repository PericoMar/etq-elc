<?php
class ConexionBD {
    private $servername = "85.215.191.245";
    private $username = "Hugo";
    private $password = "SQLKong1972.";
    private $dbname = "ETIQUETAS_ELECTRONICAS";
    private $conn;

    // Constructor para establecer la conexión
    public function __construct() {
        $dsn = "sqlsrv:Server=$this->servername;Database=$this->dbname";
        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
            // Configurar PDO para que lance excepciones en caso de errores
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }
    }

    // Método para obtener la conexión
    public function getConexion() {
        return $this->conn;
    }
}
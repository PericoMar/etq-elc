<?php

class Diseño {
    private $conexionBD;
    private $idPlantilla;
    private $tiendaId;
    private $categoria;
    private $tipo;
    private $foto;
    private $tamano;

   // Constructor
    public function __construct($conexionBD, $idPlantilla, $tiendaId = null, $categoria = null, $tipo = null, $foto = null, $tamano = null) {
        $this->conexionBD = $conexionBD;
        $this->idPlantilla = $idPlantilla;
        if ($tiendaId !== null) {
            $this->tiendaId = $tiendaId;
        }
        if ($categoria !== null) {
            $this->categoria = $categoria;
        }
        if ($tipo !== null) {
            $this->tipo = $tipo;
        }
        if ($foto !== null) {
            $this->foto = $foto;
        }
        if ($tamano !== null) {
            $this->tamano = $tamano;
        }
    }



    public static function getDiseniosPorTienda($conexionBD, $tiendaId){
        try {

            $conn = $conexionBD->getConexion();
        
            // Sentencia SQL para obtener todas las tiendas con los nombres de los usuarios asociados
            $sql = "SELECT id_plantilla FROM Diseños_Tiendas WHERE store_id = :tienda
            ";
        
            // Preparar y ejecutar la consulta
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':tienda' , $tiendaId);
            $stmt->execute();
        
            // Obtener los resultados de la consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        } catch(PDOException $e) {
            echo "Error: ". $e;
            return false;
        }
    }
    // Métodos getters y setters para acceder y modificar los atributos

    public function getIdPlantilla() {
        return $this->idPlantilla;
    }

    public function setIdPlantilla($idPlantilla) {
        $this->idPlantilla = $idPlantilla;
    }

    public function getTiendaId() {
        return $this->tiendaId;
    }

    public function setTiendaId($tiendaId) {
        $this->tiendaId = $tiendaId;
    }

    public static function getCategoriaBD($idPlantilla) {
        try {
            $conexionBD = new ConexionBD();
            $conn = $conexionBD->getConexion();
    
            // Preparar la consulta SQL para insertar un nuevo usuario
            $query = "SELECT categoria FROM Diseños WHERE id_plantilla = :idPlantilla;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':idPlantilla', $idPlantilla);

            $stmt->execute();

            $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $usuario[0]['categoria'];
    
        } catch (PDOException $e) {
            // Manejar cualquier excepción de PDO
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    public static function getTipoBD($idPlantilla) {
        try {
            $conexionBD = new ConexionBD();
            $conn = $conexionBD->getConexion();
    
            // Preparar la consulta SQL para insertar un nuevo usuario
            $query = "SELECT tipo FROM Diseños WHERE id_plantilla = :idPlantilla;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':idPlantilla', $idPlantilla);

            $stmt->execute();

            $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $usuario[0]['tipo'];
    
        } catch (PDOException $e) {
            // Manejar cualquier excepción de PDO
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function getTamano() {
        return $this->tamano;
    }

    public function setTamano($tamano) {
        $this->tamano = $tamano;
    }

    // Otros métodos de la clase Diseño, como métodos para validar datos, realizar operaciones específicas, etc.
}

?>

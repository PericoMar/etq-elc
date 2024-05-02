<?php

class Tienda {
    private $id;
    private $usuarioNombre;
    private ConexionBD $conexionBD;

    // Constructor
    public function __construct($conexionBD, $id, $usuarioNombre = null) {
        $this->conexionBD = $conexionBD;
        $this->id = $id;
        if($usuarioNombre != null){
            $this->usuarioNombre = $usuarioNombre;
        }
    }

    public static function ArrayIdsToNombresTiendas($arrayDeIds , $conexionBD) {
        try {
            $conn = $conexionBD->getConexion();
            

            // Array para almacenar los nombres de las tiendas
            $nombresTiendas = array();
            
            // Obtener el nombre de la tienda para cada ID de tienda en el array
            foreach ($arrayDeIds as $id) {
                // Consulta SQL para obtener el nombre de la tienda correspondiente al ID de tienda
                $sql = "SELECT nombre_tienda FROM Tiendas WHERE store_id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':id', $id);
                $stmt->execute();
                $nombre = $stmt->fetch(PDO::FETCH_COLUMN);
                if ($nombre) {
                    // Agregar el nombre de la tienda al array de nombres de tiendas
                    $nombresTiendas[] = $nombre;
                }
            }
            
            return $nombresTiendas;
            
        } catch(PDOException $e) {
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public static function idToNombreTienda($id, $conexionBD){
        try {
            $conn = $conexionBD->getConexion();
            
            
            // Consulta SQL para obtener el nombre de la tienda correspondiente al ID de tienda
            $sql = "SELECT nombre_tienda FROM Tiendas WHERE store_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $nombre = $stmt->fetch(PDO::FETCH_COLUMN);
            if ($nombre) {
                // Agregar el nombre de la tienda al array de nombres de tiendas
                $nombreTienda = $nombre;
            }
            
            return $nombreTienda;
            
        } catch(PDOException $e) {
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function tieneArticulosAsociadas(){
        try {
            $conn = $this->conexionBD->getConexion();
    
            // Consulta SQL para verificar si hay artículos asociados a la tienda con etiquetas asignadas
            $sql = "SELECT codigo_barras FROM Articulos WHERE store_id = :id;";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $this->id);
            $stmt->execute();
            $count = $stmt->fetchColumn();
    
            // Si se encontraron artículos con etiquetas asociadas, devolver true, de lo contrario false
            return $count > 0;
        } catch(PDOException $e) {
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    

    // Métodos getters y setters para acceder y modificar los atributos

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getUsuarioNombre() {
        return $this->usuarioNombre;
    }

    public function setUsuarioNombre($usuarioNombre) {
        $this->usuarioNombre = $usuarioNombre;
    }

    // Otros métodos de la clase Tienda, como métodos para validar datos, realizar operaciones específicas, etc.
}

?>

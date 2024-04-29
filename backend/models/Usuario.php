<?php

class Usuario {
    private $nombre;
    private $passwd;
    private $email;
    private $rol;
    private $conexionDB;

    // Constructor
    public function __construct($conexionBD ,$nombre, $passwd = null, $rol = null, $email = null) {
        $this->nombre = $nombre;
        if($passwd != null){
            $this->passwd = $passwd;
        }
        if($rol != null){
            $this->rol = $rol;
        }
        if($email != null){
            $this->email = $email;
        }
        $this->conexionBD = $conexionBD;
    }

    public static function cambiarPermisos($conexionBD, $admin , $nombre, $rol, $tiendasSeleccionadas){
        try {
            $conn = $conexionBD->getConexion();
    
            // Comenzamos una transacción
            $conn->beginTransaction();
    
            // Eliminar todos los permisos existentes del usuario
            $queryDelete = "DELETE FROM Usuarios_Tiendas WHERE usuario_nombre = :nombre AND store_id IN 
            (SELECT store_id FROM Usuarios_Tiendas WHERE usuario_nombre = :nombreAdmin);";
            $stmtDelete = $conn->prepare($queryDelete);
            $stmtDelete->bindParam(':nombre', $nombre);
            $stmtDelete->bindParam(':nombreAdmin', $admin);
            $stmtDelete->execute();
    
            // Insertar los nuevos permisos seleccionados
            foreach ($tiendasSeleccionadas as $tienda) {
                $queryInsert = "INSERT INTO Usuarios_Tiendas (usuario_nombre, store_id) VALUES (:nombre, :tienda)";
                $stmtInsert = $conn->prepare($queryInsert);
                $stmtInsert->bindParam(':nombre', $nombre);
                $stmtInsert->bindParam(':tienda', $tienda);
                $stmtInsert->execute();
            }
    
            // Actualizar el rol del usuario
            $queryUpdate = "UPDATE Usuarios SET rol = :rol WHERE nombre = :nombre";
            $stmtUpdate = $conn->prepare($queryUpdate);
            $stmtUpdate->bindParam(':rol', $rol);
            $stmtUpdate->bindParam(':nombre', $nombre);
            $stmtUpdate->execute();
    
            // Confirmar la transacción
            $conn->commit();
    
            return true; // Éxito
        } catch (PDOException $e) {
            // Si hay algún error, revertimos la transacción
            $conn->rollBack();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function usuarioExiste(){
        try {

            $conn = $this->conexionBD->getConexion();

            // Preparar la consulta SQL para verificar las credenciales
            $query = "SELECT nombre FROM Usuarios WHERE nombre = :nombre";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->execute();

            // Obtener el resultado de la consulta
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Manejar cualquier excepción de PDO
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function credencialesValidas(){
        try {

            $conn = $this->conexionBD->getConexion();

            // Preparar la consulta SQL para verificar las credenciales
            $query = "SELECT nombre FROM Usuarios WHERE nombre = :nombre AND passwd = :passwd";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':passwd', $this->passwd);
            $stmt->execute();

            // Obtener el resultado de la consulta
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Manejar cualquier excepción de PDO
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getTiendasPorUsuario(){
        try {

            $conn = $this->conexionBD->getConexion();
        
            // Sentencia SQL para obtener todas las tiendas con los nombres de los usuarios asociados
            $sql = "SELECT Tiendas.nombre_tienda AS nombre_tienda, Tiendas.store_id AS tienda_id
            FROM Usuarios_Tiendas
            JOIN Tiendas ON Usuarios_Tiendas.store_id = Tiendas.store_id
            WHERE Usuarios_Tiendas.usuario_nombre = :nombre;
            ";
        
            // Preparar y ejecutar la consulta
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre' , $this->nombre);
            $stmt->execute();
        
            // Obtener los resultados de la consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        } catch(PDOException $e) {
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getUsuariosPorUsuario(){
        try {

            $conn = $this->conexionBD->getConexion();
        
            // Sentencia SQL para obtener todas las tiendas con los nombres de los usuarios asociados
            $sql = "SELECT DISTINCT usuario_nombre as nombre_usuario FROM Usuarios_Tiendas WHERE store_id IN
            (SELECT store_id FROM Usuarios_Tiendas WHERE usuario_nombre = :nombre) AND usuario_nombre != :nombre;
            ";
        
            // Preparar y ejecutar la consulta
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre' , $this->nombre);
            $stmt->execute();
        
            $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($usuarios as &$usuario){
                $user = new Usuario($this->conexionBD,$usuario['nombre_usuario']);
                $usuario['rol_usuario'] = $user->getRol();
                $usuario['tiendas'] = $this->getCoincidenciasTiendas($usuario['nombre_usuario']);
            }

            // Obtener los resultados de la consulta
            return $usuarios;
        
        } catch(PDOException $e) {
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }   
    }
    
    public function getCoincidenciasTiendas($otroUsuario) {
        try {
            $conn = $this->conexionBD->getConexion();
            
            // Sentencia SQL para obtener todas las tiendas asociadas al usuario de la instancia actual
            $sql = "SELECT store_id FROM Usuarios_Tiendas WHERE usuario_nombre = :usuario";
            
            // Preparar y ejecutar la consulta para el usuario de la instancia actual
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':usuario', $this->nombre);
            $stmt->execute();
            
            // Obtener los store_id de las tiendas asociadas al usuario de la instancia actual
            $tiendasUsuarioActual = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
            // Sentencia SQL para obtener los store_id de las tiendas asociadas al usuario pasado como parámetro
            $sql = "SELECT store_id FROM Usuarios_Tiendas WHERE usuario_nombre = :otroUsuario";
            
            // Preparar y ejecutar la consulta para el usuario pasado como parámetro
            $stmt = $conn->prepare($sql);   
            $stmt->bindParam(':otroUsuario', $otroUsuario);
            $stmt->execute();
            
            // Obtener los store_id de las tiendas asociadas al usuario pasado como parámetro
            $tiendasOtroUsuario = $stmt->fetchAll(PDO::FETCH_COLUMN);
            
            // Calcular la intersección de los store_id entre el usuario de la instancia actual y el usuario pasado como parámetro
            $storeIdCoinciden = array_intersect($tiendasUsuarioActual, $tiendasOtroUsuario);
            
            // Array para almacenar los nombres de las tiendas coincidentes
            $tiendasCoincidentes = array();
    
            // Iterar sobre los store_id coincidentes y obtener los nombres de las tiendas
            foreach ($storeIdCoinciden as $storeId) {
                // Consulta SQL para obtener el nombre de la tienda correspondiente al store_id
                $sql = "SELECT nombre_tienda FROM Tiendas WHERE store_id = :storeId";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':storeId', $storeId);
                $stmt->execute();
                $nombreTienda = $stmt->fetch(PDO::FETCH_COLUMN);
                if ($nombreTienda) {
                    // Agregar el nombre de la tienda al array de tiendas coincidentes
                    $tiendasCoincidentes[] = $nombreTienda;
                }
            }
            
            return $tiendasCoincidentes;
            
        } catch(PDOException $e) {
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    public function meterEnTienda($tienda){
        try {

            $conn = $this->conexionBD->getConexion();
        
            // Sentencia SQL para obtener todas las tiendas con los nombres de los usuarios asociados
            $sql = "INSERT INTO Usuarios_Tiendas (usuario_nombre , store_id) VALUES (:nombre, :tienda) ";
        
            // Preparar y ejecutar la consulta
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre' , $this->nombre);
            $stmt->bindParam(':tienda' , $tienda);
            $stmt->execute();
            return true;
        
        } catch(PDOException $e) {
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }
    }   

    public function tiendaValida($tienda){
        try {

            $conn = $this->conexionBD->getConexion();
        
            // Sentencia SQL para obtener todas las tiendas con los nombres de los usuarios asociados
            $sql = "SELECT Tiendas.nombre_tienda AS tienda_id
            FROM Usuarios_Tiendas
            JOIN Tiendas ON Usuarios_Tiendas.store_id = Tiendas.store_id
            WHERE Usuarios_Tiendas.usuario_nombre = :nombre; AND nombre_tienda = :tienda";
        
            // Preparar y ejecutar la consulta
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nombre' , $this->nombre);
            $stmt->bindParam(':tienda' , $tienda);
            $stmt->execute();
        
            // Obtener los resultados de la consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        } catch(PDOException $e) {
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function aniadirUsuario(){
        try {
            $conn = $this->conexionBD->getConexion();
    
            // Preparar la consulta SQL para insertar un nuevo usuario
            $query = "INSERT INTO Usuarios (nombre, passwd, rol) VALUES (:nombre, :passwd, :rol)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':passwd', $this->passwd);
            $stmt->bindParam(':rol', $this->rol);

            $stmt->execute();
    
            // Verificar si se insertó correctamente
            if ($stmt->rowCount() > 0) {
                return true; // Usuario añadido correctamente
            } else {
                return false; // Fallo al añadir el usuario
            }
        } catch (PDOException $e) {
            // Manejar cualquier excepción de PDO
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    public static function eliminarUsuario($conexionBD, $nombreUsuario){
        try {
            // Obtener la conexión a la base de datos
            $conn = $conexionBD->getConexion();
            
            // Comenzar una transacción para asegurar la integridad de los datos
            $conn->beginTransaction();
            
            // Eliminar al usuario de la tabla Usuarios_Tiendas
            $sqlDeleteUsuarioTiendas = "DELETE FROM Usuarios_Tiendas WHERE usuario_nombre = :nombreUsuario";
            $stmtDeleteUsuarioTiendas = $conn->prepare($sqlDeleteUsuarioTiendas);
            $stmtDeleteUsuarioTiendas->bindParam(':nombreUsuario', $nombreUsuario);
            $stmtDeleteUsuarioTiendas->execute();
            
            // Eliminar al usuario de la tabla Usuarios
            $sqlDeleteUsuario = "DELETE FROM Usuarios WHERE nombre = :nombreUsuario";
            $stmtDeleteUsuario = $conn->prepare($sqlDeleteUsuario);
            $stmtDeleteUsuario->bindParam(':nombreUsuario', $nombreUsuario);
            $stmtDeleteUsuario->execute();
            
            // Confirmar la transacción
            $conn->commit();
            
            return true; // Éxito: el usuario ha sido eliminado correctamente
            
        } catch(PDOException $e) {
            // Si ocurre un error, deshacer la transacción y manejar el error
            $conn->rollBack();
            echo "Error: " . $e->getMessage();
            return false; // Fallo: no se pudo eliminar al usuario
        }
    }
    

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getRol() {
        try {
            $conn = $this->conexionBD->getConexion();
    
            // Preparar la consulta SQL para insertar un nuevo usuario
            $query = "SELECT rol FROM Usuarios WHERE nombre = :nombre;";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':nombre', $this->nombre);

            $stmt->execute();

            $usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $usuario[0]['rol'];
    
        } catch (PDOException $e) {
            // Manejar cualquier excepción de PDO
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    // Otros métodos de la clase Usuario, como 
}
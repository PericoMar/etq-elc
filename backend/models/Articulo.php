<?php

include_once('backend/models/Diseño.php');

class Articulo {
    private $codigoBarras;
    private $tiendaId;
    private $disenoId;
    private $codigoProducto;
    private $nombreCorto;
    private $nombreArticulo;
    private $precioInicial;
    private $precioVenta;
    private $etiqueta;
    private $familia;
    private $infoExtra;

    // Constructor
    public function __construct($codigoBarras, $tiendaId, $disenoId, $codigoProducto, $nombreCorto, $nombreArticulo, $precioInicial, $precioVenta,$etiqueta,$familia,  $infoExtra) {
        $this->codigoBarras = $codigoBarras;
        $this->tiendaId = $tiendaId;
        $this->disenoId = $disenoId;
        $this->codigoProducto = $codigoProducto;
        $this->nombreCorto = $nombreCorto;
        $this->nombreArticulo = $nombreArticulo;
        $this->precioInicial = $precioInicial;
        $this->precioVenta = $precioVenta;
        $this->etiqueta = $etiqueta;
        $this->familia = $familia;
        $this->infoExtra = $infoExtra;
    }
    
    public static function getArticulosPorTienda($conexionBD, $tienda){
        try {

            $conn = $conexionBD->getConexion();
        
            // Sentencia SQL para obtener todas las tiendas con los nombres de los usuarios asociados
            $sql = "SELECT * FROM Articulos WHERE store_id = :tienda";
        
            // Preparar y ejecutar la consulta
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':tienda' , $tienda);
            $stmt->execute();
        
            // Obtener los resultados de la consulta
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        } catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
            return false;
        }
    }

    public function articuloExiste(){
        try{
            $conexionBD = new ConexionBD();
            $conn = $conexionBD->getConexion();

            $sql = "SELECT codigo_barras FROM Articulos WHERE codigo_barras = :codigo_barras";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':codigo_barras', $this->codigoBarras);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch(PDOException $e){
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public static function procesarProductos(&$productos , $tienda, $disenioPredeterminado){
        $informe = [
            'editados' => 0,
            'añadidos' => 0,
            'errores' => 0
        ];
    
        $disenios = Diseño::getDiseniosPorTienda(new ConexionBD() , $tienda);
        $disenios = array_column($disenios, 'id_plantilla');
        
        try {
            $productosArrayLength = count($productos);
            // Utilizar un bucle for en lugar de un bucle foreach para tener acceso a $key
            for ($i = 0; $i < $productosArrayLength ; $i++) {
                $producto = $productos[$i]; // Obtener el producto en la posición $i
    
                $disenioExcel = $producto->getDisenoId();
                // Comprueba si el diseño existe en nuestro array de diseños, sino pone uno por defecto.
                if(!in_array($disenioExcel, $disenios)){
                    $producto->setDisenoId($disenioPredeterminado);
                }
                
                if($producto->etiquetaEnUso()){
                    $informe['errores']++;
                    unset($productos[$i]); // Eliminar el producto del array
                } else {
                    // Verificar si el producto ya existe en la base de datos
                    if ($producto->articuloExiste()) {
                        // Actualizar el producto existente
                        $producto->editarArticulo();
    
                        // Añadir el código de barras al informe de productos editados
                        $informe['editados']++;
                    } else {
                        $producto->aniadirArticulo();
                        // Añadir el código de barras al informe de productos añadidos
                        $informe['añadidos']++;
                    }
                }
            }
    
            return $informe;
    
        } catch(PDOException $e) {
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public static function procesarProductosPorFuerza(&$productos , $tienda, $disenioPredeterminado){
        $informe = [
            'editados' => 0,
            'añadidos' => 0,
            'errores' => 0
        ];
    
        $disenios = Diseño::getDiseniosPorTienda(new ConexionBD() , $tienda);
        $disenios = array_column($disenios, 'id_plantilla');
        
        try {
            $productosArrayLength = count($productos);
            // Utilizar un bucle for en lugar de un bucle foreach para tener acceso a $key
            for ($i = 0; $i < $productosArrayLength ; $i++) {
                $producto = $productos[$i]; // Obtener el producto en la posición $i
    
                $disenioExcel = $producto->getDisenoId();
                // Comprueba si el diseño existe en nuestro array de diseños, sino pone uno por defecto.
                if(!in_array($disenioExcel, $disenios)){
                    $producto->setDisenoId($disenioPredeterminado);
                }
                
                // Verificar si el producto ya existe en la base de datos
                if ($producto->articuloExiste()) {
                    // Actualizar el producto existente
                    $producto->editarArticulo();

                    // Añadir el código de barras al informe de productos editados
                    $informe['editados']++;
                } else {
                    $producto->aniadirArticulo();
                    // Añadir el código de barras al informe de productos añadidos
                    $informe['añadidos']++;
                }

            }
    
            return $informe;
    
        } catch(PDOException $e) {
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    public function aniadirArticulo(){
        try {
            if(!$this->articuloExiste()){
                $conexionBD = new ConexionBD();
                $conn = $conexionBD->getConexion();
                
                // Sentencia SQL para insertar un nuevo artículo
                $sql = "INSERT INTO Articulos (codigo_barras, store_id, id_plantilla, codigo_producto, nombre_corto, nombre_articulo, precio_inicial, precio_venta, etiqueta, familia, info_extra) 
                        VALUES (:codigo_barras, :tienda_id, :diseno_id, :codigo_producto, :nombre_corto, :nombre_articulo, :precio_inicial, :precio_venta,:etiqueta, :familia,  :info_extra)";

                // Preparar y ejecutar la consulta
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':codigo_barras', $this->codigoBarras);
                $stmt->bindParam(':tienda_id', $this->tiendaId);
                $stmt->bindParam(':diseno_id', $this->disenoId);
                $stmt->bindParam(':codigo_producto', $this->codigoProducto);
                $stmt->bindParam(':nombre_corto', $this->nombreCorto);
                $stmt->bindParam(':nombre_articulo', $this->nombreArticulo);
                $stmt->bindParam(':precio_inicial', $this->precioInicial);
                $stmt->bindParam(':precio_venta', $this->precioVenta);
                $stmt->bindParam(':etiqueta' , $this->etiqueta);
                $stmt->bindParam(':familia' , $this->familia);
                $stmt->bindParam(':info_extra', $this->infoExtra);
                $stmt->execute();
            
                // Devolver verdadero si se insertó correctamente
                return true;
            } else {
                return false;
            }
        } catch(PDOException $e) {
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    
    public function editarArticulo(){
        try {
            if($this->articuloExiste()) {
                $conexionBD = new ConexionBD();
                $conn = $conexionBD->getConexion();
    
                // Sentencia SQL para actualizar un artículo existente
                $sql = "UPDATE Articulos SET store_id = :tienda_id, id_plantilla = :diseno_id, codigo_producto = :codigo_producto,
                        nombre_corto = :nombre_corto, nombre_articulo = :nombre_articulo, precio_inicial = :precio_inicial,
                        precio_venta = :precio_venta, etiqueta = :etiqueta, familia = :familia ,info_extra = :info_extra WHERE codigo_barras = :codigo_barras";
    
                // Preparar y ejecutar la consulta
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':tienda_id', $this->tiendaId);
                $stmt->bindParam(':diseno_id', $this->disenoId);
                $stmt->bindParam(':codigo_producto', $this->codigoProducto);
                $stmt->bindParam(':nombre_corto', $this->nombreCorto);
                $stmt->bindParam(':nombre_articulo', $this->nombreArticulo);
                $stmt->bindParam(':precio_inicial', $this->precioInicial);
                $stmt->bindParam(':precio_venta', $this->precioVenta);
                $stmt->bindParam(':etiqueta' , $this->etiqueta);
                $stmt->bindParam(':info_extra', $this->infoExtra);
                $stmt->bindParam(':familia' , $this->familia);
                $stmt->bindParam(':codigo_barras', $this->codigoBarras);
                $stmt->execute();
    
                // Devolver verdadero si se actualizó correctamente
                return true;
            } else {
                return false;
            }
        } catch(PDOException $e) {
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public static function borrarArticulo($codigo_barras){
        try {
            $conexionBD = new ConexionBD();
            $conn = $conexionBD->getConexion();
        
            // Sentencia SQL para eliminar el artículo con el código de barras especificado
            $sql = "DELETE FROM Articulos WHERE codigo_barras = :codigo_barras";
        
            // Preparar y ejecutar la consulta
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':codigo_barras', $codigo_barras);
            $stmt->execute();
        
            // Devolver verdadero si se eliminó correctamente
            return true;
        } catch(PDOException $e) {
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
    

    // Métodos getters y setters para acceder y modificar los atributos

    public function getArrayArticulo(){
        $arrayArticulo = array(
            "attrCategory" => Diseño::getCategoriaBD($this->disenoId),
            "attrName" => Diseño::getTipoBD($this->disenoId),
            "barCode" => $this->getCodigoBarras(),
            "productCode" => $this->codigoProducto,
            "itemTitle" => $this->nombreArticulo,
            "shortTitle" => $this->nombreCorto,
            "originalPrice" => floatval($this->precioInicial) * 100,
            "price" => floatval($this->precioVenta) * 100,
            "custFeature1" => $this->infoExtra
        );

        return $arrayArticulo;
    }

    public function etiquetaEnUso(){
        try{
            $conexionBD = new ConexionBD();
            $conn = $conexionBD->getConexion();

            $sql = "SELECT codigo_barras FROM Articulos WHERE etiqueta = :etiqueta";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':etiqueta', $this->etiqueta);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch(PDOException $e){
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public static function getPriceTagFromBarCode($codigo_barras){
        try{
            $conexionBD = new ConexionBD();
            $conn = $conexionBD->getConexion();
    
            $sql = "SELECT etiqueta FROM Articulos WHERE codigo_barras = :codigo_barras";
    
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':codigo_barras', $codigo_barras);
            $stmt->execute();
    
            // Verificar si hay resultados
            if ($stmt->rowCount() > 0) {
                // Devolver solo la etiqueta del primer resultado
                $resultado =  $stmt->fetch(PDO::FETCH_ASSOC);
                return $resultado['etiqueta'];
            } else {
                // No se encontraron resultados, manejar el caso aquí
                return null;
            }
    
        } catch(PDOException $e){
            // Manejar errores de la conexión o de la consulta
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function getPriceTag(){
        return $this->etiqueta;
    }

    public function getCodigoBarras() {
        return $this->codigoBarras;
    }

    public function setCodigoBarras($codigoBarras) {
        $this->codigoBarras = $codigoBarras;
    }

    public function getTiendaId() {
        return $this->tiendaId;
    }

    public function setTiendaId($tiendaId) {
        $this->tiendaId = $tiendaId;
    }

    public function getDisenoId(){
        return $this->disenoId;
    }

    public function setDisenoId($disenoId){
        $this->disenoId = $disenoId;
    }

    // Implementa los getters y setters para los demás atributos...

    // Otros métodos de la clase Articulo, como métodos para validar datos, realizar operaciones específicas, etc.
}

?>

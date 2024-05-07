<?php

include_once('backend/services/Excel/ServicioExcel.php');
include_once('backend/services/API/ServicioAPI.php');
include_once('backend/config/ConexionBD.php');
include_once('backend/models/Articulo.php');
include_once('backend/models/Diseño.php');
include_once('backend/models/Tienda.php');
include_once('backend/models/Usuario.php');

class MainController {
    // Define las rutas de los archivos CSS y scripts JS
    private ConexionBD $conexionBD;
    private $baseUrl = "/etq-elc";
    private $cssRoutes = [
        'login' => '/etq-elc/public/css/login.css',
        'tiendas' => '/etq-elc/public/css/shopSelection.css',
        'gestionTienda' => '/etq-elc/public/css/shopManagement.css',
        'gestionProductos' => '/etq-elc/public/css/products.css',
        'gestionUsuarios' => '/etq-elc/public/css/staffManager.css'
    ];

    private $jsRoutes = [
        'login' => '/etq-elc/public/js/login.js',
        'gestionTienda' => '/etq-elc/public/js/shopManagement.js',
        'gestionProductos' => '/etq-elc/public/js/products.js',
        'gestionUsuarios' => '/etq-elc/public/js/staffManager.js'
    ];

    public function __construct(ConexionBD $conexionBD) {
        $this->conexionBD = $conexionBD;
    }

    public function login() {

        if(isset($_SESSION['username'])){
            unset($_SESSION['username']);
            unset($_SESSION['shop']);
            header('Location: /etq-elc/');
            exit();
        }

        

        // Verifica si se ha enviado el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtén los datos del formulario
            $nombreUsuario = $_POST['username'];
            $passwd = $_POST['passwd'];

            // Crea un nuevo objeto Usuario
            $usuario = new Usuario($this->conexionBD, $nombreUsuario, $passwd);
            // Verifica si el usuario existe en la base de datos
            if ($usuario->credencialesValidas()) {
                // El usuario existe, redirige a la página de inicio
                $_SESSION['username'] = $usuario->getNombre();
                header('Location: /etq-elc/seleccion-tienda/');
                exit(); // Asegúrate de detener la ejecución después de redirigir
            } else {
                
                $mensaje = "Credenciales incorrectas";

            }
        }

        $script = $this->getJSRoute('login');
        // Obtén la ruta del CSS
        $paginaCSS = $this->getCSSRoute('login');
        $content = 'backend/views/login.php';
        include 'backend/views/layout.php';
    }

    public function tiendas() {
        // Dependiendo del rol del usuario puedo enseñar un tipo de pagina u otra.
        if(!isset($_SESSION['username'])){
            header('Location: /etq-elc/seleccion-tienda/ ');
            exit();
        }
        
        $usuario = new Usuario($this->conexionBD, $_SESSION['username']);

        $tiendas = $usuario->getTiendasPorUsuario();

        if (count($tiendas) === 1) {
            // Si solo hay una tienda asociada al usuario, guarda la tienda en la sesión y redirige a la página de gestión
            $_SESSION['shop'] = $tiendas[0]['tienda_id'];
            header('Location: /etq-elc/gestion/');
            exit(); // Asegúrate de detener la ejecución después de redirigir
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtén los datos del formulario
            $tienda = $_POST['tienda'];

            // Verifica si ela tienda es valida
            if ($usuario->tiendaValida($tienda)) {
                // El usuario existe, redirige a la página de inicio
                $_SESSION['shop'] = $tienda;

                header('Location: /etq-elc/gestion/');
                exit(); // Asegúrate de detener la ejecución después de redirigir
            } else {
                
                $mensaje = "No tienes ninguna tienda con ese nombre.";

            }
        }


        // Obtén la ruta del CSS
        $paginaCSS = $this->getCSSRoute('tiendas');
        $content = 'backend/views/shopSelection.php';
        include 'backend/views/layout.php';
    }

    public function gestionTienda(){

        if(!isset($_SESSION['username'])){
            header('Location: /etq-elc/');
            exit();
        }

        if(!isset($_SESSION['shop'])){
            header('Location: /etq-elc/seleccion-tienda/ ');
            exit();
        }

        // Dependiendo del rol del usuario puedo enseñar un tipo de pagina u otra.
        $usuario = new Usuario($this->conexionBD, $_SESSION['username']);

        $nombreTienda = Tienda::idToNombreTienda($_SESSION['shop'], $this->conexionBD);

        // Obtén la ruta del CSS y del JS
        $paginaCSS = $this->getCSSRoute('gestionTienda');
        $script = $this->getJSRoute('gestionTienda');
        $content = 'backend/views/shopManagement.php';
        include 'backend/views/layout.php';
    }

    public function gestionProductos(){
        $components = array(
            'first-import-modal' => 'backend/views/components/productsPage/firstImportModal.php',
            'inform-modal' => 'backend/views/components/productsPage/informModal.php',
            'inform-add-modal' => 'backend/views/components/productsPage/informAddModal.php',
            'inform-edit' => 'backend/views/components/productsPage/informEdit.php',
            'inform-delete' => 'backend/views/components/productsPage/informDelete.php',
            'filter-modal' => 'backend/views/components/productsPage/filterModal.php',
            'add-modal' => 'backend/views/components/productsPage/addModal.php',
            'add-excel-modal' => 'backend/views/components/productsPage/addExcelModal.php',
            'edit-modal' => 'backend/views/components/productsPage/editModal.php',
            'delete-modal' => 'backend/views/components/productsPage/deleteModal.php',
            'footer-paginacion' => 'backend/views/components/paginacion.php',
            // Agrega más componentes según sea necesario
        );


        if(!isset($_SESSION['username'])){
            header('Location: /etq-elc/');
            exit();
        }

        if(!isset($_SESSION['shop'])){
            header('Location: /etq-elc/seleccion-tienda/ ');
            exit();
        }

        if(isset($_SESSION['informe'])){
            $informe= $_SESSION['informe'];
            unset($_SESSION['informe']);
        }

        if(isset($_SESSION['informDelete'])){
            $informeDelete= $_SESSION['informDelete'];
            unset($_SESSION['informDelete']);
        }

        if(isset($_SESSION['informEdit'])){
            $informeEdit = $_SESSION['informEdit'];
            unset($_SESSION['informEdit']);
        }
        

        // Dependiendo del rol del usuario le pido todos los datos del producto u otros.
        $usuario = new Usuario($this->conexionBD, $_SESSION['username']);

        $tiendaId = $_SESSION['shop']; 

        $tienda = new Tienda($this->conexionBD, $tiendaId);

        $hayEtiquetasAsociadas = $tienda->tieneArticulosAsociados();

        $productos = Articulo::getArticulosPorTienda($this->conexionBD, $_SESSION['shop']);

        $disenios = Diseño::getDiseniosPorTienda($this->conexionBD, $_SESSION['shop']);

        // Llamar al servicio Excel para procesar el archivo.
        $excelService = new ExcelService();

        // Servicio API para gestionar los productos con la API.
        $apiService = new ServicioAPI();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['add'])){
                if (!empty($_POST['codigo_barras']) && !empty($_POST['disenio_asociado']) && !empty($_POST['etiqueta'])) {
                    // Obtiene los datos del formulario
                    $codigoBarras = $_POST['codigo_barras'];
                    $disenoId = $_POST['disenio_asociado'];
                    $codigoProducto = isset($_POST['codigo_producto']) ? $_POST['codigo_producto'] : '';
                    $nombreCorto = isset($_POST['nombre_corto']) ? $_POST['nombre_corto'] : '';
                    $nombreArticulo = isset($_POST['nombre_articulo']) ? $_POST['nombre_articulo'] : '';
                    $precioInicial = isset($_POST['precio-inicial']) ? $_POST['precio-inicial'] : 0;
                    $precioVenta = isset($_POST['precio-venta']) ? $_POST['precio-venta'] : 0;
                    $etiqueta = isset($_POST['etiqueta']) ? $_POST['etiqueta'] : '';
                    $familia = isset($_POST['familia']) ? $_POST['familia'] : '';
                    $infoExtra = isset($_POST['info_extra']) ? $_POST['info_extra'] : '';
                    
                    $articulo = new Articulo($codigoBarras, $tiendaId, $disenoId, $codigoProducto, $nombreCorto, $nombreArticulo, $precioInicial, $precioVenta, $etiqueta,$familia,  $infoExtra);

                    if($articulo->articuloExiste()){

                        $mensaje = "Ya existe un artículo con ese codigo de barras.";

                    } else if($articulo->etiquetaEnUso()){

                        $mensaje = "La etiqueta ya está en uso. Bórrala o edítala.";    

                    } else {
                    
                        $apiService->importProduct($articulo, $tiendaId);

                        $response = $apiService->bindPriceTag($articulo, $tiendaId);

                        // En este array meteré las etiquetas que no esten disponibles.
                        // Si el array está vacio el informe confirmará que se añadió el producto.
                        $informeAdd = [];

                        $responseArray = json_decode($response, true);

                        if($responseArray['success']){

                            $articulo->aniadirArticulo();

                            $response = $apiService->updatePriceTagByBarCode($articulo->getCodigoBarras(), $tiendaId);

                        } else {
                            // Si la petición no ha sido exitosa se cogen las etiquetas no disponibles.
                            preg_match_all('/\[(.*?)\]/', $responseArray['originalMessage'], $matches);

                            // Verificar si se encontraron coincidencias
                            if (!empty($matches[1])) {
                                // Los valores entre corchetes se encuentran en $matches[1]
                                $valoresEntreCorchetes = $matches[1];
                                foreach ($valoresEntreCorchetes as $valor) {
                                    $informeAdd[] = $valor;
                                }
                            }
                        }
                    }
                }
            }
            
            // Con JS se pone una pantalla de carga cuando se le da click al boton de "Cargar":
            if(isset($_POST['carga-excel']) || isset($_POST['primer-import'])){
                
                if(isset($_FILES['archivoExcel'])) {

                    try{
                        // Obtener la información del archivo
                        $nombreArchivo = $_FILES['archivoExcel']['name'];
                        $tipoArchivo = $_FILES['archivoExcel']['type'];
                        $rutaTemporal = $_FILES['archivoExcel']['tmp_name'];
                        $tamañoArchivo = $_FILES['archivoExcel']['size'];
                        $errorArchivo = $_FILES['archivoExcel']['error'];

                        // Diseño predeterminado por el cliente.
                        $disenioPredeterminado = $_POST['disenio_predeterminado'];

                        // Verificar si no hubo errores al subir el archivo
                        if ($errorArchivo === UPLOAD_ERR_OK) {

                            // procesarArchivoExcel devuelve falso si el formato es incorrecto:
                            $productosExcel = $excelService->getProductosArchivoExcel($rutaTemporal, $tiendaId);
                            if($productosExcel){
                                
                                if(isset($_POST['importacionForzada'])){
                                    $informeNuevo = Articulo::procesarProductosPorFuerza($productosExcel, $tiendaId, $disenioPredeterminado);    
                                } else {
                                    $informeNuevo = Articulo::procesarProductos($productosExcel, $tiendaId, $disenioPredeterminado);    
                                }

                                // $response = $apiService->batchBindInBatches($productosExcel , $tiendaId);
                                $apiService->importProducts($productosExcel, $tiendaId);

                                $response = $apiService->bindPriceTags($productosExcel, $tiendaId);

                                $responseArray = json_decode($response, true);

                                if($responseArray['originalMessage']){
                                    preg_match_all('/\[(.*?)\]/', $responseArray['originalMessage'], $matches);

                                    // Verificar si se encontraron coincidencias
                                    if (!empty($matches[1])) {
                                        // Los valores entre corchetes se encuentran en $matches[1]
                                        $valoresEntreCorchetes = $matches[1];
                                        foreach ($valoresEntreCorchetes as $valor) {
                                            $informeNuevo['etiquetas'][] = $valor;
                                            $informeNuevo['errores']++;
                                        }
                                    }
                                }
                                
                                $response = $apiService->updatePriceTagsByBarCode($productosExcel, $tiendaId);

                                $_SESSION['informe'] = $informeNuevo;

                                // Cuando se han procesado todos los productos se redirige a la pagina gestion-productos.
                                header("Location: /etq-elc/gestion-productos/");
                                exit();
                            } else {
                                $mensaje = "Archivo vacío.";
                            }
                            
                    
                        } else {
                            $mensaje = "Error al leer el archivo.";
                        }
                    } catch(Exception $e){
                        $mensaje = "Se ha producido un error con la lectura del archivo.";
                    }
                    
                }
            }
     
            if(isset($_POST['confirma-eliminar'])){
                $codigo_barras = $_POST['codigo-barras'];
                $etiqueta = $_POST['etiqueta'];
                Articulo::borrarArticulo($codigo_barras);

                $response= $apiService->unbindPriceTag($etiqueta, $tiendaId);

                $response = $apiService->deleteProduct($codigo_barras, $tiendaId);

                $_SESSION['informDelete'] = true;

                header("Location: /etq-elc/gestion-productos/");
                exit();
                // No se si puedo reiniciar la etiqueta porque ya no esta conectada a un BarCode.
                // $response = $apiService->updatePriceTagByBarCode($articulo->getCodigoBarras(), $tiendaId);
            }

            if(isset($_POST['confirma-editar'])){
                // Obtiene los datos del formulario
                $codigoBarras = $_POST['codigo_barras'];
                $disenoId = $_POST['disenio_asociado'];
                $codigoProducto = isset($_POST['codigo_producto']) ? $_POST['codigo_producto'] : '';
                $nombreCorto = isset($_POST['nombre_corto']) ? $_POST['nombre_corto'] : '';
                $nombreArticulo = isset($_POST['nombre_articulo']) ? $_POST['nombre_articulo'] : '';
                $precioInicial = isset($_POST['precio-inicial']) ? $_POST['precio-inicial'] : 0;
                $precioVenta = isset($_POST['precio-venta']) ? $_POST['precio-venta'] : 0;
                $etiqueta = isset($_POST['etiqueta']) ? $_POST['etiqueta'] : 0;
                $familia = isset($_POST['familia']) ? $_POST['familia'] : '';
                $infoExtra = isset($_POST['info_extra']) ? $_POST['info_extra'] : '';

                $anteriorCodBarras = $_POST['anterior_cod_barras'];
                
                $articulo = new Articulo($codigoBarras, $tiendaId, $disenoId, $codigoProducto, $nombreCorto, $nombreArticulo, $precioInicial, $precioVenta, $etiqueta,$familia, $infoExtra);
                if($articulo->etiquetaEnUso() && $etiqueta != $articulo->getPriceTag()){
                    $mensaje = "La etiqueta ya está en uso. Bórrala o edítala.";
                } else {
                    // Si se ha cambiado el CodBarras, tengo que comprobar si el nuevo CodBarras estaba en uso.
                    if($anteriorCodBarras !== $codigoBarras){
                        // Si no estaba en uso, se edita el articulo.
                        if(!$articulo->articuloExiste()){
                            Articulo::borrarArticulo($anteriorCodBarras);
                            $articulo->aniadirArticulo();

                            $response = $apiService->importProduct($articulo, $tiendaId);

                            $response = $apiService->bindPriceTag($articulo, $tiendaId);

                            $response = $apiService->updatePriceTagByBarCode($articulo->getCodigoBarras(), $tiendaId);

                            $_SESSION['informEdit'] = true;

                            header("Location: /etq-elc/gestion-productos/");
                            exit();

                        } else {
                            $mensaje = "Ya existe un articulo con ese codigo de barras.";
                        }
                    // Si el Cod. Barras era el mismo se cambia directamente.
                    } else {
                        Articulo::borrarArticulo($anteriorCodBarras);
                        $articulo->aniadirArticulo();
    
                        $response = $apiService->importProduct($articulo, $tiendaId);
    
                        $response = $apiService->bindPriceTag($articulo, $tiendaId);

                        $response = $apiService->updatePriceTagByBarCode($articulo->getCodigoBarras(), $tiendaId);

                        $_SESSION['informEdit'] = true;

                        header("Location: /etq-elc/gestion-productos/");
                        exit();
                    }
                }
                
                
            }

            // Volver a coger los productos despues de realizar los cambios pertinentes.
            $productosFiltrados = Articulo::getArticulosPorTienda($this->conexionBD, $_SESSION['shop']);

        } else {
            $productosFiltrados = $productos;
        }

        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            if(isset($_GET['filtro'])){
                $productosFiltrados = $this->productosFiltrados($productos);
                if(empty($productosFiltrados)){
                    $mensaje = "No hay productos con esas características.";
                    $productosFiltrados = $productos;
                }
            }
        }
        
        $resultadosPorPagina = 10; // Número de productos por página

        // Paginación
        $totalResultados = count($productosFiltrados);
        $totalPaginas = ceil($totalResultados / $resultadosPorPagina);

        // Obtener el número de página actual
        $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

        // Calcular el índice de inicio y fin para la página actual
        $indiceInicio = ($paginaActual - 1) * $resultadosPorPagina;
        $indiceFin = $paginaActual * $resultadosPorPagina;

        // Obtener los productos de la página actual
        $productosPagina = array_slice($productosFiltrados, $indiceInicio, $resultadosPorPagina);

        // Obtén la ruta del CSS
        $paginaCSS = $this->getCSSRoute('gestionProductos');
        $script = $this->getJSRoute('gestionProductos');
        $content = 'backend/views/products.php';
        include 'backend/views/layout.php';
    }

    public function gestionUsuarios(){
        $components = array(
            'footer-paginacion' => 'backend/views/components/paginacion.php',
        );

        if(!isset($_SESSION['username'])){
            header('Location: /etq-elc/');
            exit();
        }

        if(!isset($_SESSION['shop'])){
            header('Location: /etq-elc/seleccion-tienda/ ');
            exit();
        }

        $usuario = new Usuario($this->conexionBD, $_SESSION['username']);

        $tiendasMainUsuario = $usuario->getTiendasPorUsuario();

        $tienda = $_SESSION['shop']; 

        $usuarios = $usuario->getUsuariosPorUsuario();

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $nombreUsuario = isset($_POST['nombre_usuario']) ? $_POST['nombre_usuario'] : '';
            $contrasenaUsuario = isset($_POST['pwd_usuario']) ? $_POST['pwd_usuario'] : '';
            $rolUsuario = isset($_POST['rol']) ? $_POST['rol'] : '';
            $tiendasSeleccionadas = isset($_POST['checkboxes']) ? $_POST['checkboxes'] : []; // Esto será un array de las tiendas seleccionadas

            if(isset($_POST['add'])){
                if(!empty($nombreUsuario)){
                    $nuevoUsuario = new Usuario($this->conexionBD, $nombreUsuario, $contrasenaUsuario, $rolUsuario);
                    if(!$nuevoUsuario->usuarioExiste()){
                        $nuevoUsuario->aniadirUsuario();
                        foreach($tiendasSeleccionadas as $tienda){
                            $nuevoUsuario->meterEnTienda($tienda);
                        }
                    } else {
                        $mensaje = "Ya existe un usuario con ese nombre, por favor use otro.";
                    }
                    $usuariosFiltrados = $usuario->getUsuariosPorUsuario();
                }
            }

            if(isset($_POST['confirma-eliminar'])){
                $nombreUsuario = $_POST['nombre-user-hidden'];
                Usuario::eliminarUsuario($this->conexionBD, $nombreUsuario);
                $usuariosFiltrados = $usuario->getUsuariosPorUsuario();
            }

            if(isset($_POST['confirma-editar'])){
                Usuario::cambiarPermisos($this->conexionBD, $usuario->getNombre() ,$nombreUsuario, $rolUsuario, $tiendasSeleccionadas);
                $usuariosFiltrados = $usuario->getUsuariosPorUsuario();
            }

        } else {
            $usuariosFiltrados = $usuarios;
        }

        if($_SERVER['REQUEST_METHOD'] === 'GET'){
            if(isset($_GET['filtro'])){
                $usuariosFiltrados = $this->usuariosFiltrados($usuarios);
                if(empty($usuariosFiltrados)){
                    $mensaje = "No existen usuarios con esas características.";
                    $usuariosFiltrados = $usuarios;
                } 
            }
        }

        $resultadosPorPagina = 5; // Número de productos por página

        // Paginación
        $totalResultados = count($usuariosFiltrados);
        $totalPaginas = ceil($totalResultados / $resultadosPorPagina);

        // Obtener el número de página actual
        $paginaActual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;

        // Calcular el índice de inicio y fin para la página actual
        $indiceInicio = ($paginaActual - 1) * $resultadosPorPagina;
        $indiceFin = $paginaActual * $resultadosPorPagina;

        // Obtener los productos de la página actual
        $usuariosPagina = array_slice($usuariosFiltrados, $indiceInicio, $resultadosPorPagina);

         // Obtén la ruta del CSS y del JS
         $paginaCSS = $this->getCSSRoute('gestionUsuarios');
         $script = $this->getJSRoute('gestionUsuarios');
         $content = 'backend/views/staffManager.php';
         include 'backend/views/layout.php';
    }

    private function productosFiltrados($productos){
        $max_price = 9999999;
        $etiqueta = isset($_GET['etiqueta']) ? $_GET['etiqueta'] : '';
        $familia = isset($_GET['familia']) ? $_GET['familia'] : '';
        $codigo_barras = isset($_GET['codigo_barras']) ? $_GET['codigo_barras'] : '';
        $codigo_producto = isset($_GET['codigo_producto']) ? $_GET['codigo_producto'] : '';
        $nombre_corto = isset($_GET['nombre_corto']) ? $_GET['nombre_corto'] : '';
        $nombre_articulo = isset($_GET['nombre_articulo']) ? $_GET['nombre_articulo'] : '';
        $disenioAsociado = isset($_GET['disenio_asociado']) ? $_GET['disenio_asociado'] : '';
        $precio_inicial_min = isset($_GET['precio-inicial-desde']) ? floatval($_GET['precio-inicial-desde']) : 0;
        $precio_inicial_max = isset($_GET['precio-inicial-hasta']) && $_GET['precio-inicial-hasta'] != "" ? floatval($_GET['precio-inicial-hasta']) : $max_price;
        $precio_venta_min = isset($_GET['precio-venta-desde']) ? floatval($_GET['precio-venta-desde']) : 0;
        $precio_venta_max = isset($_GET['precio-venta-hasta']) && $_GET['precio-venta-hasta'] != "" ? floatval($_GET['precio-venta-hasta']) : $max_price;
        $info_extra = isset($_GET['info_extra']) ? $_GET['info_extra'] : '';
        $productos_filtrados = [];

        // Filtrar los productos
        foreach ($productos as $producto) {
            if (
                stripos($producto['familia'], $familia) !== false &&
                stripos($producto['etiqueta'], $etiqueta) !== false &&
                stripos($producto['codigo_barras'], $codigo_barras) !== false &&
                stripos($producto['codigo_producto'], $codigo_producto) !== false &&
                stripos($producto['nombre_corto'], $nombre_corto) !== false &&
                stripos($producto['nombre_articulo'], $nombre_articulo) !== false &&
                stripos($producto['id_plantilla'], $disenioAsociado) !== false &&
                $producto['precio_venta'] >= $precio_venta_min &&
                $producto['precio_venta'] <= $precio_venta_max &&
                $producto['precio_inicial'] >= $precio_inicial_min &&
                $producto['precio_inicial'] <= $precio_inicial_max &&
                stripos($producto['info_extra'], $info_extra) !== false
            ) {
                // El producto cumple con todos los criterios de filtrado
                $productos_filtrados[] = $producto;
            }
        }
        return $productos_filtrados;
    }

    private function usuariosFiltrados($usuarios) {
        $usuariosFiltrados = [];

        // Obtener datos del formulario
        $nombreUsuario = isset($_GET['nombre_usuario']) ? $_GET['nombre_usuario'] : '';
        $rolUsuario = isset($_GET['rol']) ? $_GET['rol'] : '';
        $tiendasSeleccionadas = isset($_GET['tiendas']) ? $_GET['tiendas'] : [];

        // Filtrar los usuarios
        foreach ($usuarios as $usuario) {
            $tiendasSeleccionadas = isset($_GET['tiendas']) ? $_GET['tiendas'] : [];
            $cumpleCriterios = true;

            // Verificar nombre de usuario
            if ($nombreUsuario !== '' && stripos($usuario['nombre_usuario'], $nombreUsuario) === false) {
                $cumpleCriterios = false;
            }

            // Verificar rol de usuario
            if ($rolUsuario !== '' && $usuario['rol_usuario'] !== $rolUsuario) {
                $cumpleCriterios = false;
            }

            // Verificar tiendas seleccionadas
            if (!empty($tiendasSeleccionadas)) {
                $tiendasUsuario = isset($usuario['tiendas']) ? $usuario['tiendas'] : [];
                $tiendasSeleccionadas = Tienda::ArrayIdsToNombresTiendas($tiendasSeleccionadas, $this->conexionBD);
            
                // Si $tiendasSeleccionadas es un string (un solo valor)
                if (is_string($tiendasSeleccionadas)) {
                    // Convertir la cadena CSV en un array
                    $tiendasSeleccionadas = explode(',', $tiendasSeleccionadas);
                }
            
                // Verificar si al menos una tienda seleccionada coincide con las tiendas del usuario
                $tiendasCoinciden = array_intersect($tiendasUsuario, $tiendasSeleccionadas);
                if (empty($tiendasCoinciden)) {
                    $cumpleCriterios = false;
                }
            }
            

            if ($cumpleCriterios) {
                $usuariosFiltrados[] = $usuario;
            }
        }

        return $usuariosFiltrados;
    }   

    // Método para obtener la ruta del CSS según el nombre del método
    private function getCSSRoute($method) {
        return isset($this->cssRoutes[$method]) ? $this->cssRoutes[$method] : '';
    }

    // Método para obtener la ruta del JS según el nombre del método
    private function getJSRoute($method) {
        return isset($this->jsRoutes[$method]) ? $this->jsRoutes[$method] : '';
    }
}


<?php

// Importa el controlador principal
include_once('backend/config/ConexionBD.php');
require_once 'backend/controllers/MainController.php';

// Define las rutas y los métodos del controlador a invocar
$routes = [
    '' => 'login',
    'index.php' => 'login',      // Método login para la página de inicio de sesión
    'seleccion-tienda' => 'tiendas',      // Método index para la página de inicio (una vez que el usuario ha iniciado sesión)
    'gestion' => 'gestionTienda',    // Método tiendas para la página de tiendas
    'gestion-productos' => 'gestionProductos',
    'gestion-usuarios' => 'gestionUsuarios'
    // Puedes agregar más rutas y métodos según sea necesario
];

// Obtiene la ruta actual del usuario
$currentRoute = $_SERVER['REQUEST_URI'];

// Obtiene la parte de la URL correspondiente al directorio base de la aplicación
// TENGO QUE PONER LA PARTE DE LA URL QUE QUIERA REEMPLAZAR
$baseUrl = "/etq-elc";

// Elimina la parte del directorio base de la URL
$currentRoute = str_replace($baseUrl, '', $currentRoute);

// Elimina la barra inicial (/) de la ruta
$currentRoute = ltrim($currentRoute, '/');

// Divide la ruta en partes si hay más de una
$parts = preg_split('/[\/?]/', $currentRoute);

// La primera parte de la ruta es la acción a realizar
$action = isset($parts[0]) ? $parts[0] : '';

// Instancia el controlador
$controller = new MainController(new ConexionBD());

// Comprueba si la acción está definida en las rutas
if (array_key_exists($action, $routes)) {
    // Obtiene el método asociado a la acción
    $methodName = $routes[$action];
   
    // Llama al método asociado a la acción
    $controller->$methodName();
} else {
    // Si la acción no está definida, muestra un mensaje de error o redirige a una página de error
    $controller->login();
}








    

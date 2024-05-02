<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Etiquetas Electrónicas</title>
    <!-- Ruta absoluta desde la raíz del sitio -->
    <link rel="stylesheet" type="text/css" href="/etq-elc/public/css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $paginaCSS; ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">

</head>
<body>
    <header class=nav-bar>
        <!-- Barra de navegación -->
        <img src="<?php echo $this->baseUrl ?>/public/img/LogoKC.png" alt="Kong Consulting" class=logo>

        <nav>
            <ul>
                <li><a href="<?php echo $this->baseUrl ?>/seleccion-tienda/" class="nav-link">Tiendas</a></li>
                <li><a href="<?php echo $this->baseUrl ?>/gestion-productos/" class="nav-link">Productos</a></li>
                <li><a href="<?php echo $this->baseUrl ?>/gestion-usuarios/" class="nav-link">Usuarios</a></li>
                <li><a href="<?php echo $this->baseUrl ?>/" class="nav-link">Cerrar Sesión</a></li>
                <!-- Puedes agregar más enlaces según tus necesidades -->
            </ul>
            <div class=header-opts>
                <svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16" id="menu-icon">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                </svg>
            </div>
        </nav>
    </header>
    <nav class="displayed-header-opts" id="displayed-header-opts">
        <ul>
            <li><a href="<?php echo $this->baseUrl ?>/seleccion-tienda/" class="nav-link">Tiendas</a></li>
            <li><a href="<?php echo $this->baseUrl ?>/gestion-productos/" class="nav-link">Productos</a></li>
            <li><a href="<?php echo $this->baseUrl ?>/gestion-usuarios/" class="nav-link">Usuarios</a></li>
            <li><a href="<?php echo $this->baseUrl ?>/" class="nav-link">Cerrar Sesión</a></li>
        </ul>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg close-header-opts" viewBox="0 0 16 16" id=close-header-opts>
            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
        </svg>  
    </nav>
    <main>
        <header class="principal-title">
            <h1>Etiquetas Electrónicas</h1>
        </header>
        <!-- Contenido dinámico -->
        <?php include $content; ?>
    </main>
    <footer class="main-footer">
        <!-- Pie de página -->
        Derechos de autor © 2024 Kong Consulting
    </footer>

    <script src="<?php echo $this->baseUrl ?>/public/js/main.js"></script>

    <?php
        if(isset($script)){
            ?>
                <script src="<?php echo $script ?>"></script>
            <?php
        }
    ?>
</body>
</html>
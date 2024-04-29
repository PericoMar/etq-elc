<footer class="footer-paginacion">
    <?php if ($totalPaginas > 1) : ?>
    <div class="paginacion">
        <?php if ($paginaActual > 1) : ?>
            <a class="btn-paginacion" href="?pagina=<?php echo ($paginaActual - 1); ?><?php echo buildQueryString(); ?>">Anterior</a>
        <?php endif; ?>

        <?php 
        // Seleccionar el rango de páginas a mostrar
        $rangoInicio = max(1, $paginaActual - 1); // Iniciar el rango desde la página actual - 2
        $rangoFin = min($totalPaginas, $paginaActual + 1); // Terminar el rango en la página actual + 2
        
        // Mostrar la primera página si no está en el rango
        if ($rangoInicio > 1) : ?>
            <a href="?pagina=1<?php echo buildQueryString(); ?>" class="btn-paginacion">1</a>
            <?php if ($rangoInicio > 2) : ?>
                <a class="btn-paginacion" href="?pagina=<?php echo ($paginaActual - 2); ?><?php echo buildQueryString(); ?>">...</a>
            <?php endif;
        endif;

        // Mostrar las páginas dentro del rango
        for ($i = $rangoInicio; $i <= $rangoFin; $i++) : ?>
            <a href="?pagina=<?php echo $i; ?><?php echo buildQueryString(); ?>" <?php echo ($i == $paginaActual) ? 'class="btn-paginacion active"' : 'class="btn-paginacion"';?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php 
        // Mostrar la última página si no está en el rango
        if ($rangoFin < $totalPaginas) : 
            if ($rangoFin < $totalPaginas - 1) : ?>
                <a class="btn-paginacion" href="?pagina=<?php echo ($paginaActual + 2); ?><?php echo buildQueryString(); ?>">...</a>
            <?php endif; ?>
            <a href="?pagina=<?php echo $totalPaginas; ?><?php echo buildQueryString(); ?>" class="btn-paginacion"><?php echo $totalPaginas; ?></a>
        <?php endif;

        if ($paginaActual < $totalPaginas) : ?>
            <a class="btn-paginacion" href="?pagina=<?php echo ($paginaActual + 1); ?><?php echo buildQueryString(); ?>">Siguiente</a>
        <?php endif; ?>

    </div>
    <?php endif; ?>
</footer>
<?php
function buildQueryString() {
    $queryParams = array();
    $allowedParams = array('codigo_barras', 'precio-inicial-desde', 'precio-inicial-hasta', 'precio-venta-desde', 'precio-venta-hasta', 'info_extra');

    foreach ($_GET as $key => $value) {
        if (in_array($key, $allowedParams) && !empty($value)) {
            $queryParams[] = urlencode($key) . '=' . urlencode($value);
        }
    }

    if (!empty($queryParams)) {
        return '&filtro&' . implode('&', $queryParams);
    } else {
        return '';
    }
}
?>
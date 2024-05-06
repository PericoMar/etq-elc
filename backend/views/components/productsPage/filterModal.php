<dialog id="filter" class="modal">
    <div class="modal-content" id="modal-content-filter">
        <header class="modal-header">
            <h3>Rellene los campos por los que quiere filtrar:</h3>
            <span class="close" data-modal="filter">&times;</span>
        </header>
        <form action="<?php echo $this->baseUrl?>/gestion-productos/" method="get" id="filterForm" class="modal-form">
            <div class="filtro-campo" id="div_etiqueta_filter">
                <label for="etiqueta_filter">Etiqueta asociada: </label>
                <input type="text" id="etiqueta_filter" name="etiqueta" placeholder="Ej: 803907294">
            </div>

            <div class="filtro-campo" id="div_codigo_barras_filter">
                <label for="codigo_barras_filter">Código de barras:</label>
                <input type="text" id="codigo_barras_filter" name="codigo_barras" placeholder="Ej: 8412345678905">
            </div>

            <div class="filtro-campo" id="div_codigo_producto_filter" style="display: none;">
                <label for="codigo_producto_filter">Código de producto:</label>
                <input type="text" id="codigo_producto_filter" name="codigo_producto" placeholder="Ej: 111">
            </div>

            <div class="filtro-campo" id="div_nombre_corto_filter" style="display: none;">
                <label for="nombre_corto_filter">Nombre corto:</label>
                <input type="text" id="nombre_corto_filter" name="nombre_corto" placeholder="Ej: Hacendado azucar blanquilla">
            </div>

            <div class="filtro-campo" id="div_nombre_articulo_filter" style="display: none;">
                <label for="nombre_articulo_filter">Nombre del artículo:</label>
                <input type="text" id="nombre_articulo_filter" name="nombre_articulo" placeholder="Ej: Hacendado azucar blanquilla 1Kg">
            </div>

            <div class="filtro-campo" id="div_disenio_asociado_filter" style="display: none;">
                <label for="disenio_asociado_filter">Diseño asociado: <span class="campo-obligatorio">*</span></label>
                <select id="disenio_asociado_filter" name="disenio_asociado">
                    <option value="">Selecciona uno...</option>
                    <?php foreach ($disenios as $disenio) : ?>
                        <option value='<?php echo $disenio['id_plantilla'] ?>'><?php echo $disenio['id_plantilla'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filtro-campo" id="div_precio-inicial_filter" style="display: none;">
                <p>Rango precio inicial</p>
                <label for="precio-inicial-desde_filter">Desde:</label>
                <input type="number" id="precio-inicial-desde_filter" name="precio-inicial-desde" placeholder="Valor por defecto: 0">
                <label for="precio-inicial-hasta_filter" class="hasta">Hasta:</label>
                <input type="number" id="precio-inicial-hasta_filter" name="precio-inicial-hasta" placeholder="Ej: 10">
            </div>

            <div class="filtro-campo" id="div_precio-venta_filter" style="display: none;">
                <p>Rango precio de venta</p>
                <label for="precio-venta-desde_filter">Desde:</label>
                <input type="number" id="precio-venta-desde_filter" name="precio-venta-desde" placeholder="Valor por defecto: 0">
                <label for="precio-venta-hasta_filter" class="hasta">Hasta:</label>
                <input type="number" id="precio-venta-hasta_filter" name="precio-venta-hasta" placeholder="Ej: 10">
            </div>
            
            <div class="filtro-campo" id="div_familia_filter" style="display: none;">
                <label for="familia_filter">Familia:</label>
                <input type="text" id="familia_filter" name="familia" placeholder="Ej: Bebidas">
            </div>

            <div class="filtro-campo" id="div_info_extra_filter" style="display: none;">
                <label for="info_extra_filter">Información extra:</label>
                <input type="text" id="info_extra_filter" name="info_extra" placeholder="Ej: Paquete color blanco">
            </div>

            <label for="nuevo_filtro" id="label-nuevo-filtro">Nuevo campo para filtrar:</label>
            <div id="add-filter" class="add-filter">
                <select name="nuevo_filtro" id="nuevo_filtro">
                    <option value="codigo_producto">Código de producto</option>
                    <option value="nombre_corto">Nombre corto</option>
                    <option value="nombre_articulo">Nombre del artículo</option>
                    <option value="precio-inicial">Rango precio inicial</option>
                    <option value="precio-venta">Rango precio venta</option>
                    <option value="disenio_asociado">Diseño asociado</option>
                    <option value="familia">Familia</option>
                    <option value="info_extra">Información extra</option>
                    <!-- Agrega más opciones según tus necesidades -->
                </select>
                <button type="button" id="agregarFiltroBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2"/>
                    </svg>
                </button>
            </div>

            <footer class="modal-footer">
                <button data-modal="filter" class="btn-cancel" type=button>Cancelar</button>
                <button class="confirm-btn" name="filtro">
                    Filtrar 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                    </svg>
                </button>
            </footer>
        </form>
    </div>
</dialog>
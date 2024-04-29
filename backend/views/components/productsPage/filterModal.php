<dialog id="filter" class="modal">
                <div class="modal-content" id="modal-content-filter">
                    <header class="modal-header">
                        <h3>Rellene los campos por los que quieras filtrar:</h3>
                        <span class="close" data-modal="filter">&times;</span>
                    </header>
                    <form action="<?php echo $this->baseUrl?>/gestion-productos/" method="get" id="filterForm" class="modal-form">
                        <label for="codigo_barras_filter">Código de barras:</label>
                        <input type="text" id="codigo_barras_filter" name="codigo_barras" placeholder="Ej: 8412345678905">

                        <label for="codigo_producto_filter">Código de producto:</label>
                        <input type="text" id="codigo_producto_filter" name="codigo_producto" placeholder="Ej: 111">

                        <label for="nombre_corto_filter">Nombre corto:</label>
                        <input type="text" id="nombre_corto_filter" name="nombre_corto" placeholder="Ej: Hacendado azucar blanquilla">

                        <label for="nombre_articulo_filter">Nombre del artículo:</label>
                        <input type="text" id="nombre_articulo_filter" name="nombre_articulo" placeholder="Ej: Hacendado azucar blanquilla 1Kg">

                        <label for="disenio_asociado_filter">Diseño asociado: <span class="campo-obligatorio">*</span></label>
                        <select id="disenio_asociado_filter" name="disenio_asociado">
                        <?php
                        // Suponiendo que $disenios es un array de IDs de diseños obtenidos de la base de datos
                        foreach ($disenios as $disenio) {
                            ?><option value='<?php echo $disenio['id_plantilla'] ?>'><?php echo $disenio['id_plantilla'] ?></option>";
                        <?php
                        }
                        ?>
                        </select>

                        Rango precio inicial:
                        <div class="rango-precio" id="precio-inicial">
                            <label for="precio-inicial-desde_filter">Desde:</label>
                            <input type="number" id="precio-inicial-desde_filter" name="precio-inicial-desde" placeholder="Valor por defecto: 0" >
                            <label for="precio-inicial-hasta_filter" class="hasta">Hasta:</label>
                            <input type="number" id=precio-inicial-hasta_filter name="precio-inicial-hasta" placeholder="Ej: 10">
                        </div>

                        Rango precio de venta:
                        <div class="rango-precio">
                            <label for="precio-venta-desde_filter">Desde:</label>
                            <input type="number" id="precio-venta-desde_filter" name="precio-venta-desde" placeholder="Valor por defecto: 0" >
                            <label for="precio-venta-hasta_filter" class="hasta">Hasta:</label>
                            <input type="number" id=precio-venta-hasta_filter name="precio-venta-hasta" placeholder="Ej: 10">
                        </div>

                        <label for="info_extra_filter">Información extra:</label>
                        <input type="text" id="info_extra_filter" name="info_extra" placeholder="Ej: Paquete color blanco">

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
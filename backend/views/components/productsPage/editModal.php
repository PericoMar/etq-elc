<dialog id="edit" class="modal">
    <div class="modal-content edit-modal">
        <header class="modal-header">
            <h3>Editar producto</h3>
            <span class="close" data-modal="edit">&times;</span>
        </header>
        <main class="modal-body">
            <form action="<?php echo $this->baseUrl?>/gestion-productos/" method="post" id="filterForm" class="modal-form">
                <label for="etiqueta_edit">Etiqueta asociada: <span class="campo-obligatorio">*</span></label>
                <input type="text" id="etiqueta_edit" name="etiqueta" placeholder="Ej: 803907294">

                <label for="codigo_barras_edit">Código de barras: <span class="campo-obligatorio">*</span></label>
                <input type="text" id="codigo_barras_edit" name="codigo_barras" placeholder="Ej: 8412345678905">

                <label for="codigo_producto_edit">Código de producto:</label>
                <input type="text" id="codigo_producto_edit" name="codigo_producto" placeholder="Ej: 111">

                <label for="nombre_corto_edit">Nombre corto:</label>
                <input type="text" id="nombre_corto_edit" name="nombre_corto" placeholder="Ej: Hacendado azucar blanquilla">

                <label for="nombre_articulo_edit">Nombre del artículo:</label>
                <input type="text" id="nombre_articulo_edit" name="nombre_articulo" placeholder="Ej: Hacendado azucar blanquilla 1Kg">

                <label for="disenio_asociado_edit">Diseño asociado: <span class="campo-obligatorio">*</span></label>
                <select id="disenio_asociado_edit" name="disenio_asociado">
                <?php
                // Suponiendo que $disenios es un array de IDs de diseños obtenidos de la base de datos
                foreach ($disenios as $disenio) {
                    ?><option value='<?php echo $disenio['id_plantilla'] ?>'><?php echo $disenio['id_plantilla'] ?></option>";
                <?php
                }
                ?>
                </select>


                <label for="precio_inicial_edit">Precio inicial:</label>
                <input type="text" id="precio_inicial_edit" name="precio-inicial" placeholder="Ej: 10.00" pattern="\d+([,.]\d{1,2})?|^$">

                <label for="precio_venta_edit">Precio venta:</label>
                <input type="text" id="precio_venta_edit" name="precio-venta" placeholder="Ej: 8.00" pattern="\d+([,.]\d{1,2})?|^$">

                <label for="familia_edit">Familia:</label>
                <input type="text" id="familia_edit" name="familia" placeholder="Ej: Bebidas">

                <label for="info_extra_edit">Información extra:</label>
                <input type="text" id="info_extra_edit" name="info_extra" placeholder="Ej: Paquete color blanco">

                <input type="hidden" value="" name="anterior_cod_barras" id=anterior-cod-barras>
                <footer class="modal-footer">
                    <small class="alert-msg small" id="alert-msg-edit">Los campos obligatorios deben estar rellenos. *</small>
                    <button data-modal="edit" class="btn-cancel" type=button>Cancelar</button>
                    <button id="edit-confirm-btn" class="btn-confirm" name="confirma-editar">Editar</button>
                </footer>
            </form>
        </main>
    </div>
</dialog>
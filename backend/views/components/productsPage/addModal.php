<dialog id="add" class="modal">
                <div class="modal-content" id="modal-content-add">
                    <header class="modal-header">
                        <h3>Añadir producto</h3>
                        <span data-modal="add" class="close">&times;</span>
                    </header>
                    <form action="<?php echo $this->baseUrl?>/gestion-productos/" method="post" id="filterForm" class="modal-form">
                        <label for="etiqueta_add">Etiqueta asociada: <span class="campo-obligatorio">*</span></label>
                        <input type="text" id="etiqueta_add" name="etiqueta" placeholder="Ej: 803907294" id="etiqueta_add">

                        <label for="codigo_barras_add">Código de barras: <span class="campo-obligatorio">*</span></label>
                        <input type="text" id="codigo_barras_add" name="codigo_barras" placeholder="Ej: 8412345678905">

                        <label for="disenio_asociado_add">Diseño asociado: <span class="campo-obligatorio">*</span></label>
                        <select id="disenio_asociado_add" name="disenio_asociado">
                        <?php
                        // Suponiendo que $disenios es un array de IDs de diseños obtenidos de la base de datos
                        foreach ($disenios as $disenio) {
                            ?><option value='<?php echo $disenio['id_plantilla'] ?>'><?php echo $disenio['id_plantilla'] ?></option>";
                        <?php
                        }
                        ?>
                        </select>

                        <label for="codigo_producto_add">Código de producto:</label>
                        <input type="text" id="codigo_producto_add" name="codigo_producto" placeholder="Ej: 111">

                        <label for="nombre_corto_add">Nombre corto:</label>
                        <input type="text" id="nombre_corto_add" name="nombre_corto" placeholder="Ej: Hacendado azucar blanquilla">

                        <label for="nombre_articulo_add">Nombre del artículo:</label>
                        <input type="text" id="nombre_articulo_add" name="nombre_articulo" placeholder="Ej: Hacendado azucar blanquilla 1Kg">

                        <label for="precio-inicial_add">Precio inicial:</label>
                        <input type="text" id="precio-inicial_add" name="precio-inicial" placeholder="Ej: 10.00" pattern="\d+([,.]\d{1,2})?|^$">

                        <label for="precio-venta_add">Precio venta:</label>
                        <input type="text" id="precio-venta_add" name="precio-venta" placeholder="Ej: 8.00" pattern="\d+([,.]\d{1,2})?|^$">

                        <label for="info_extra_add">Información extra:</label>
                        <input type="text" id="info_extra_add" name="info_extra" placeholder="Ej: Paquete color blanco">

                        <footer class="modal-footer">
                            <small class="alert-msg small" id="alert-msg-add">Debe rellenar los campos obligatorios. *</small>
                            <button data-modal="add" class="btn-cancel" type=button>Cancelar</button>
                            <button class="confirm-btn" name="add" id="add-confirm-btn">
                                Añadir 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                                </svg>
                            </button>
                        </footer>
                    </form>
                </div>
            </dialog>
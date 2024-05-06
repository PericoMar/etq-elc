<dialog id="delete" class="modal">
    <div class="modal-content confirmation-modal">
        <header class="modal-header">
            <h3>Confirmación de eliminación</h3>
            <span class="close" data-modal="delete">&times;</span>
        </header>
        <main class="modal-body">
            <p>¿Estas seguro que quieres eliminar el siguiente producto?</p>
            <p>Cod. barras: <span id="cod-barras"></span></p>
            <p>Etiqueta: <span id="etiqueta"></span></p>
            <p>Nombre articulo: <span id="nombre-articulo"></span></p>
        </main>
        <footer class="modal-footer">
            <form action="<?php echo $this->baseUrl ?>/gestion-productos/" method=post>
                <button data-modal="delete" class="btn-cancel" type=button>Cancelar</button>
                <button id="confirmationDelete" class="btn-confirm" name="confirma-eliminar">Confirmar</button>
                <input id="input-cod-barras-hidden" type="hidden" name="codigo-barras" value="">
                <input id="input-etiqueta-hidden" type="hidden" name="etiqueta" value="">
            </form>
        </footer>
    </div>
</dialog>
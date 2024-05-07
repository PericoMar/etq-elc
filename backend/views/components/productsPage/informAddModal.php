<dialog id="inform" class="modal inform-modal" style="display:block;">
    <div class="modal-content inform-modal">
        <header class="modal-header">
            <h3>Informe de importación.</h3>
            <span class="close" data-modal="inform">&times;</span>
        </header>
        <main class="modal-body">
            <?php if(empty($informeAdd)){ ?>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-all" viewBox="0 0 16 16">
                    <path d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486z"/>
                </svg>
                Importación completada con éxito.
            <?php } else { ?>
                <div class="error-msg">
                    <p>Error en la importación </p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>   
                    </svg>
                </div>
                <p>
                    <?php if(count($informeAdd) == 1): ?>
                        <span>La siguiente etiqueta no está disponible:</span>
                    <?php else: ?>
                        <span>Las siguientes etiquetas no están disponibles:</span>
                    <?php endif; ?>
                </p>
                <ul>
                    <?php foreach($informeAdd as $etiqueta): ?>
                        <li><?php echo $etiqueta; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php } ?>
        </main>
        <footer class="modal-footer">
            <form action="<?php echo $this->baseUrl ?>/gestion-productos/" method=post>
                <button data-modal="inform" class="btn-cancel" type=button>Cerrar</button>
            </form>
        </footer>
    </div>
</dialog>
<dialog id="inform" class="modal inform-modal" style="display:block;">
    <div class="modal-content inform-modal">
        <header class="modal-header">
            <h3>Informe de importación.</h3>
            <span class="close" data-modal="inform">&times;</span>
        </header>
        <main class="modal-body">
            <p>Se han añadido <?php echo $informe['añadidos'] ?> productos.</p>
            <p>Se han editado <?php echo $informe['editados'] ?> productos.</p>
            <p>Han ocurrido <?php echo $informe['errores'] ?> errores. </p>
            <?php 
                if($informe['errores'] > 0){
                    ?><p>Posiblemente debido a etiquetas que ya estaban en uso o no están disponibles.</p><?php
                }
            ?>
            <?php if(!empty($informe['etiquetas'])){ ?>
                <p>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>   
                </svg>
                    <?php if(count($informe['etiquetas']) == 1): ?>
                        <span>La siguiente etiqueta no está disponible:</span>
                    <?php else: ?>
                        <span>Las siguientes etiquetas no están disponibles:</span>
                    <?php endif; ?>
                </p>
                <ul>
                    <?php foreach($informe['etiquetas'] as $etiqueta): ?>
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
<dialog id="inform" class="modal inform-modal" style="display:block;">
    <div class="modal-content inform-modal">
        <header class="modal-header">
            <h3>Informe de importación.</h3>
            <span class="close" data-modal="inform">&times;</span>
        </header>
        <main class="modal-body">
            <p>Se han añadido <?php echo $informe['añadidos'] ?> productos.</p>
            <p>Se han editado <?php echo $informe['editados'] ?> productos.</p>
            <p>Han ocurrido <?php echo $informe['errores'] ?> errores. 
            <?php 
                if($informe['errores'] > 0){
                    ?><span>Posiblemente debido a etiquetas repetidas</span><?php
                }
            ?>
            </p>
        </main>
        <footer class="modal-footer">
            <form action="<?php echo $this->baseUrl ?>/gestion-productos/" method=post>
                <button data-modal="inform" class="btn-cancel" type=button>Cerrar</button>
            </form>
        </footer>
    </div>
</dialog>
<dialog id="inform" class="modal inform-modal" style="display:block;">
    <div class="modal-content inform-modal">
        <header class="modal-header">
            <h3>Informe edición.</h3>
            <span class="close" data-modal="inform">&times;</span>
        </header>
        <main class="modal-body">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-all" viewBox="0 0 16 16">
            <path d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486z"/>
        </svg>
            El producto se ha editado correctamente.
        </main>
        <footer class="modal-footer">
            <form action="<?php echo $this->baseUrl ?>/gestion-productos/" method=post>
                <button data-modal="inform" class="btn-cancel" type=button>Cerrar</button>
            </form>
        </footer>
    </div>
</dialog>
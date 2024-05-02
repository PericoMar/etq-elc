<section class="staffManager">
    <header>
        <img src="<?php echo $this->baseUrl ?>/public/img/person-vcard.svg" alt="Productos" class="cart">
        <h1>Gestión de usuarios</h1>
    </header>
    <main>    
        <header class="options">
            <button class="table-opt add-product" id="btn-add">
                Añadir Usuario
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                </svg>
            </button>
            <dialog id="add" class="modal">
                <div class="modal-content" id="modal-content-add">
                    <header class="modal-header">
                        <h3>Añadir nuevo usuario:</h3>
                        <span data-modal="add" class="close">&times;</span>
                    </header>
                    <form action="<?php echo $this->baseUrl?>/gestion-usuarios/" method="post" id="addForm" class="modal-form">
                        <label for="nombre_add">Nombre usuario: <span class="campo-obligatorio">*</span></label>
                        <input type="text" id="nombre_add" name="nombre_usuario" placeholder="user1">

                        <label for="pwd_add">Contraseña:  <span class="campo-obligatorio">*</span></label>
                        <input type="text" id="pwd_add" name="pwd_usuario" placeholder="*****">

                        <fieldset>
                            <legend>Rol:  <span class="campo-obligatorio">*</span></legend>
                            <input type="radio" id="rolChoiceAdd1" name="rol" value="Usuario" checked/>
                            <label for="rolChoiceAdd1">Usuario</label>

                            <input type="radio" id="rolChoiceAdd2" name="rol" value="Gestor" />
                            <label for="rolChoiceAdd2">Gestor</label>

                            <input type="radio" id="rolChoiceAdd3" name="rol" value="Administrador" />
                            <label for="rolChoiceAdd3">Administrador</label>
                        </fieldset>

                        <fieldset>
                        <legend>Tienda/s: <span class="campo-obligatorio">*</span></legend>

                        <div class="checkboxes">
                        <?php
                        // Suponiendo que $disenios es un array de IDs de diseños obtenidos de la base de datos
                        foreach ($tiendasMainUsuario as $tienda) {
                             ?>
                             <div>
                                <label><input class="checkbox" type="checkbox" value='<?php echo $tienda['tienda_id']?>' name="checkboxes[]">
                             <?php echo $tienda['nombre_tienda']?></label>
                             </div>
                        <?php
                        }
                        ?>
                        </div>
                        </fieldset>

                        <footer class="modal-footer">
                            <small class="alert-msg small" id="alert-msg">Debe rellenar los campos obligatorios. *</small>
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
            <div class="filter-opt">
                <form action="<?php echo $this->baseUrl ?>/gestion-usuarios/">
                    <button class="table-opt delete-filter">
                        Quitar filtro
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                        </svg>  
                    </button> 
                </form>
             <button class="table-opt filter" id="btn-filter">
                Filtrar 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                </svg>
            </button> 
            </div>
            <dialog id="filter" class="modal">
                <div class="modal-content" id="modal-content-filter">
                    <header class="modal-header">
                        <h3>Rellene los campos por los que quieras filtrar:</h3>
                        <span class="close" data-modal="filter">&times;</span>
                    </header>
                    <form action="<?php echo $this->baseUrl?>/gestion-usuarios/" method="get" id="filterForm" class="modal-form">
                        <label for="nombre_filter">Nombre usuario:</label>
                        <input type="text" id="nombre_filter" name="nombre_usuario" placeholder="user1">

                        <fieldset>
                            <legend>Rol: </legend>
                            <input type="radio" id="rolChoiceFilter1" name="rol" value="Usuario" />
                            <label for="rolChoiceFilter1">Usuario</label>

                            <input type="radio" id="rolChoiceFilter2" name="rol" value="Gestor" />
                            <label for="rolChoiceFilter2">Gestor</label>

                            <input type="radio" id="rolChoiceFilter3" name="rol" value="Administrador" />
                            <label for="rolChoiceFilter3">Administrador</label>
                        </fieldset>

                        <fieldset>
                        <legend>Tienda/s:</legend>

                        <div class="checkboxes">
                        <?php
                        // Suponiendo que $disenios es un array de IDs de diseños obtenidos de la base de datos
                        foreach ($tiendasMainUsuario as $tienda) {
                             ?>
                             <div>
                                <label><input class="checkbox" type="checkbox" value='<?php echo $tienda['tienda_id']?>' name="tiendas[]">
                             <?php echo $tienda['nombre_tienda']?></label>
                             </div>
                        <?php
                        }
                        ?>
                        </div>
                        </fieldset>
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
        </header>
        <?php
            if(isset($mensaje)){
                ?>
                <small class="alert-msg"><?php echo $mensaje ?></small>
                <?php
            }
        ?>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Rol</th>
                    <th>Tiendas relacionadas</th>
                    <th class="acciones-columna">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($usuariosPagina as $usuario) : ?>
                    <tr>
                        <td><?php echo $usuario['nombre_usuario']; ?></td>
                        <td><?php echo $usuario['rol_usuario']; ?></td>
                        <td>
                            <ul class="tiendas-usuario"><?php foreach($usuario['tiendas'] as $tienda){
                            ?><li>
                            <?php
                            echo $tienda;
                            }?></li>
                            </ul>
                        </td>
                        <td class="acciones-columna">
                            <button class="btn-editar product-opt">Cambiar permisos</button>
                            <button class="btn-eliminar product-opt" data-nombre-usuario="<?php echo $usuario['nombre_usuario']; ?>" data-rol-usuario="<?php echo $usuario['rol_usuario']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <dialog id="delete" class="modal">
            <div class="modal-content confirmation-modal">
                <header class="modal-header">
                    <h3>Confirmación de eliminación</h3>
                    <span class="close" data-modal="delete">&times;</span>
                </header>
                <main class="modal-body">
                    <p>¿Estas seguro que quieres eliminar al siguiente usuario?</p>
                    <p>Nombre Usuario:<span id="nombre-usuario"></span></p>
                    <p>Rol: <span id="rol-usuario"></span></p>
                </main>
                <footer class="modal-footer">
                    <form action="<?php echo $this->baseUrl ?>/gestion-usuarios/" method=post>
                        <button data-modal="delete" class="btn-cancel" type=button>Cancelar</button>
                        <button id="confirmationDelete" class="btn-confirm" name="confirma-eliminar">Confirmar</button>
                        <input id="input-nombre-user-hidden" type="hidden" name="nombre-user-hidden" value="">
                    </form>
                </footer>
            </div>
        </dialog>
        <dialog id="edit" class="modal">
            <div class="modal-content edit-modal">
                <header class="modal-header">
                    <h3>Cambiar permisos de <span class="nombre-usuario-edit"></span>: </h3>
                    <span class="close" data-modal="edit">&times;</span>
                </header>
                <main class="modal-body">
                    <form action="<?php echo $this->baseUrl?>/gestion-usuarios/" method="post" id="editForm" class="modal-form">
                        <input type="hidden" name="nombre_usuario" value="" id=nombre_usuario_edit>
                        <fieldset>
                            <legend>Rol: <span class="campo-obligatorio">*</span></legend>
                            <input type="radio" id="rolChoiceEdit1" name="rol" value="Usuario" />
                            <label for="rolChoiceEdit1">Usuario</label>

                            <input type="radio" id="rolChoiceEdit2" name="rol" value="Gestor" />
                            <label for="rolChoiceEdit2">Gestor</label>

                            <input type="radio" id="rolChoiceEdit3" name="rol" value="Administrador" />
                            <label for="rolChoiceEdit3">Administrador</label>
                        </fieldset>

                        <fieldset>
                        <legend>Tienda/s: <span class="campo-obligatorio">*</span></legend>

                        <div class="checkboxes-edit">
                        <?php
                        foreach ($tiendasMainUsuario as $tienda) {
                             ?>
                             <div>
                                <label><input class="checkbox-edit" type="checkbox" value='<?php echo $tienda['tienda_id']?>' name="checkboxes[]">
                             <?php echo $tienda['nombre_tienda']?></label>
                             </div>
                        <?php
                        }
                        ?>
                        </div>
                        </fieldset>
                        <footer class="modal-footer">
                            <small class="alert-msg small" id="alertMsgEdit">Los campos obligatorios deben estar rellenos. *</small>
                            <button data-modal="edit" class="btn-cancel" type=button>Cancelar</button>
                            <button id="edit-confirm-btn" class="btn-confirm" name="confirma-editar">Editar</button>
                        </footer>
                    </form>
                </main>
            </div>
        </dialog>
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
            $allowedParams = array('nombre_usuario', 'rol', 'tiendas');
        
            foreach ($_GET as $key => $value) {
                if (in_array($key, $allowedParams) && !empty($value)) {
                    // Si el parámetro es 'tiendas', convierte el array en una cadena CSV
                    if ($key === 'tiendas' && is_array($value)) {
                        $value = implode(',', $value);
                    }
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

    </main>
</section>
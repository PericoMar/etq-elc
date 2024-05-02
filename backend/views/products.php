<section class="products">
    <header>
        <img src="<?php echo $this->baseUrl ?>/public/img/cart4.svg" alt="Productos" class="cart">
        <h1>Gestión de productos</h1>
    </header>
    <main>
        <?php 
            if(!$hayEtiquetasAsociadas){
                include $components['first-import-modal'];
            } 
        ?>
        <header class="options">
            <div class="add-opts">
                <button class="table-opt add-product" id="btn-add">
                    Añadir Producto
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                    </svg>
                </button>
                <button class="table-opt add-product add-excel" id="btn-add-excel">
                    Importar productos con Excel
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-excel" viewBox="0 0 16 16">
                        <path d="M5.884 6.68a.5.5 0 1 0-.768.64L7.349 10l-2.233 2.68a.5.5 0 0 0 .768.64L8 10.781l2.116 2.54a.5.5 0 0 0 .768-.641L8.651 10l2.233-2.68a.5.5 0 0 0-.768-.64L8 9.219l-2.116-2.54z"/>
                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                    </svg>
                </button>
            </div>
            <?php include $components['add-modal'] ?>
            <?php include $components['add-excel-modal'] ?>
            <?php
                if(isset($informe)){
                    ?>
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
                                            ?><span>Posiblemente debido a productos sin cod. de barras</span><?php
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
                    <?php
                }
            ?>
            
            <div class="filter-opt">
                <form action="<?php echo $this->baseUrl ?>/gestion-productos/" style="margin: 0px;">
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
            <?php include $components['filter-modal'] ?>
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
                    <th>Cod. de barras</th>
                    <th>Cod. de producto</th>
                    <th>Nombre corto</th>
                    <th>Nombre del artículo</th>
                    <th>Diseño etiqueta</th>
                    <th>Precio inicial</th>
                    <th>Precio venta</th>
                    <th>Etiqueta</th>
                    <th>Información extra</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productosPagina as $producto) : ?>
                    <tr>
                        <td><?php echo $producto['codigo_barras']; ?></td>
                        <td><?php echo $producto['codigo_producto']; ?></td>
                        <td><?php echo $producto['nombre_corto']; ?></td>
                        <td><?php echo $producto['nombre_articulo']; ?></td>
                        <td><?php echo $producto['id_plantilla']?></td>
                        <td><?php echo $producto['precio_inicial']; ?></td>
                        <td><?php echo $producto['precio_venta']; ?></td>
                        <td><?php echo $producto['etiqueta'] ?></td>
                        <td><?php echo $producto['info_extra']; ?></td>
                        <td class="acciones">
                            <button class="btn-editar product-opt">Editar</button>
                            <button class="btn-eliminar product-opt" data-codigo-barras="<?php echo $producto['codigo_barras']; ?>" data-nombre-articulo="<?php echo $producto['nombre_articulo']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php include $components['delete-modal']; ?>
        <?php include $components['edit-modal']; ?>
        <?php include $components['footer-paginacion']; ?>
    </main>
</section>
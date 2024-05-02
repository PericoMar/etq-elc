<dialog id="first-import" class="modal">
    <form action="<?php echo $this->baseUrl ?>/gestion-productos/" class="modal-content confirmation-modal excel-modal" method=post enctype="multipart/form-data" accept=".xls,.xlsx" id="first-import-form">
        <header class="modal-header">
            <h3>Primera carga a partir de archivo Excel:</h3>
        </header>
        <main class="modal-body">
            <p>La primera carga nos permite conocer las etiquetas que tienes a tu disposición, además puedes hacer la conexion entre estas y tus productos.</p>
            <p>Recuerda seguir el <b>formato</b> indicado a continuación:</p>
            <table>
                <tr class="column-letters">
                    <th></th> <!-- Celda vacía para la esquina superior izquierda -->
                    <th>A</th>
                    <th>B</th>
                    <th>C</th>
                    <th>D</th>
                    <th>E</th>
                    <th>F</th>
                    <th>G</th>
                    <th>H</th>
                    <th>I</th>
                </tr>
                <tr>
                    <th>1</th>
                    <th>Etiqueta</th>
                    <th>Código de Barras</th>
                    <th>Código de Producto</th>
                    <th>Nombre Corto</th>
                    <th>Nombre del Artículo</th>
                    <th>Diseño de Etiqueta</th>
                    <th>Precio Inicial</th>
                    <th>Precio de Venta</th>
                    <th>Información Extra</th>
                </tr>
                <tr>
                    <th>2</th>
                    <td>803907294</td>
                    <td>1234567890123</td>
                    <td>PROD001</td>
                    <td>Camiseta</td>
                    <td>Camiseta de Algodón</td>
                    <td>1</td>
                    <td>15.99</td>
                    <td>24.99</td>
                    <td>Color: Rojo</td>
                </tr>
                <tr>
                    <th>3</th>
                    <td>805250802</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>4</th>
                    <td>802650313</td>
                    <td>1337252321332</td>
                    <td>PROD003</td>
                    <td>HUGO BOSS</td>
                    <td>HUGO BOSS 60ML</td>
                    <td>1</td>
                    <td>99.99</td>
                    <td>124.99</td>
                    <td></td>
                </tr>
                <!-- Agrega más filas según sea necesario -->
            </table>
            <p>Si hay alguna fila sin codigo de etiqueta se ignorará.</p>
            <p>Nota: La primera fila se ignorará durante la importación.</p>
                <input type="file" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} archivos seleccionados" name="archivoExcel" accept=".xls,.xlsx" required/>
                <label for="file-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="currentColor" class="bi bi-file-earmark-arrow-up" viewBox="0 0 16 16">
                    <path d="M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707z"/>
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                </svg>
                <span class="iborrainputfile">Seleccionar archivo</span>
            </label>
        </main>
        <footer class="first-import-footer">
            <button id="cargaExcel" class="btn-confirm" name="primer-import">Cargar</button>
        </footer>
    </form>
</dialog>
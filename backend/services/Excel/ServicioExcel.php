<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelService
{
    private $tamañoMaximo = 50 * 1024 * 1024; //50MB de tamaño maximo.

    // Variables para almacenar los índices de las columnas
    private $indiceEtiqueta = 0;
    private $indiceCodigoBarras = 1;
    private $indiceCodigoProducto = 2;
    private $indiceNombreCorto = 3;
    private $indiceNombreArticulo = 4;
    private $indiceDisenoEtiqueta = 5;
    private $indicePrecioInicial = 6;
    private $indicePrecioVenta = 7;
    private $indiceInformacionExtra = 8;

    public function getProductosArchivoExcel($archivo, $tienda)
    {
        // Ruta de destino para mover el archivo
        $rutaDestino = 'backend/uploads/' . basename($archivo);

        // Verificar tamaño del archivo
        if (filesize($archivo) > $this->tamañoMaximo) {
            die("El archivo es demasiado grande. El tamaño máximo permitido es de 50 MB.");
        }

        // Mover el archivo a la ruta destino
        if (move_uploaded_file($archivo, $rutaDestino)) {
            // Procesar el archivo Excel
            $spreadsheet = IOFactory::load($rutaDestino);
            $sheet = $spreadsheet->getActiveSheet();
        
            // Obtener todos los datos de la hoja activa como un array bidimensional
            $data = $sheet->toArray();
        
            $productos = [];
            foreach ($data as $key => $rowData) {
                // Saltar la primera fila (encabezados)
                if ($key === 0) {
                    continue;
                }

                if ($rowData[0] === null || $rowData[0] === '') {
                    continue;
                } else {
                    // Crear objeto Articulo
                    $producto = new Articulo(
                        $rowData[$this->indiceCodigoBarras],
                        $tienda, // Aquí deberías proporcionar el valor adecuado para tiendaId
                        $rowData[$this->indiceDisenoEtiqueta],
                        $rowData[$this->indiceCodigoProducto],
                        $rowData[$this->indiceNombreCorto],
                        $rowData[$this->indiceNombreArticulo],
                        $rowData[$this->indicePrecioInicial],
                        $rowData[$this->indicePrecioVenta],
                        $rowData[$this->indiceEtiqueta],
                        $rowData[$this->indiceInformacionExtra]
                    );

                    // Añadir el producto al array de productos
                    $productos[] = $producto;
                }
        }

        } else {
            die("Error al mover el archivo.");
        }

        unlink($rutaDestino);

        // Devolver los productos
        return $productos;
        
    }

}
?>

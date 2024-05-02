<?php

include_once('backend/models/Articulo.php');

class ServicioAPI {
    private $baseUrl = "http://esl-eu.zkong.com/zk";
    private $contentType = 'application/json;charset=utf-8';
    private $language = 'Language: es';

    private $accountName = 'dsstienda';
    private $password = 'Dsspos2020';

    public function importProduct(Articulo $producto, $tiendaID){
        $endpoint = "/item/batchImportItem";
        $url = $this->baseUrl . $endpoint;
    
        $loginCredentials = $this->getLoginCredentials();
    
        // Encabezados personalizados
        $headers = array(
            'Authorization: ' . $loginCredentials['token'], // Encabezado de autorización.
            'Content-type: ' . $this->contentType, // Tipo de contenido.
            $this->language
        );
    
        // Datos a enviar.
        $data = array(
            "agencyId" => $loginCredentials['agencyId'],
            "merchantId" => $loginCredentials['merchantId'],
            "storeId" => $tiendaID,
            "unitName" => 0,
            "itemList" => [$producto->getArrayArticulo()] // Convertir el producto a un array y colocarlo en una lista
        );
    
        // Inicializar cURL
        $ch = curl_init($url);
    
        // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Especificar el tipo de solicitud (POST en este ejemplo)
        curl_setopt($ch, CURLOPT_POST, true);
    
        // Configurar los datos a enviar (si es una solicitud POST)
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
        // Establecer los encabezados personalizados
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
    
        // Cerrar la conexión cURL
        curl_close($ch);
    
        return $response;
    }
    

    public function importProducts(array $productos , $tiendaID){
        $endpoint = "/item/batchImportItem";
        $url = $this->baseUrl . $endpoint;

        $loginCrendentials = $this->getLoginCredentials();

        // Encabezados personalizados
        $headers = array(
            'Authorization: ' . $loginCrendentials['token'], // Encabezado de autorización.
            'Content-type: ' . $this->contentType, // Tipo de contenido.
            $this->language
        );

        $itemList = [];

        foreach($productos as $producto){
            $itemList[] = $producto->getArrayArticulo();    
        }

        // Datos a enviar.
        $data = array(
            "agencyId" => $loginCrendentials['agencyId'],
            "merchantId" => $loginCrendentials['merchantId'],
            "storeId" => $tiendaID,
            "unitName" => 0,
            "itemList" => $itemList
        );

        // Inicializar cURL
        $ch = curl_init($url);

        // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Especificar el tipo de solicitud (POST en este ejemplo)
        curl_setopt($ch, CURLOPT_POST, true);

        // Configurar los datos a enviar (si es una solicitud POST)
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Establecer los encabezados personalizados
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);

        
        // Cerrar la conexión cURL
        curl_close($ch);

        return $response;
    }

    public function batchBind($producto , $tiendaID){
        $endpoint = "/erp/esl/batchBind";
        $url = $this->baseUrl . $endpoint;

        $loginCrendentials = $this->getLoginCredentials();

        // Encabezados personalizados
        $headers = array(
            'Authorization: ' . $loginCrendentials['token'], // Encabezado de autorización.
            'Content-type: ' . $this->contentType, // Tipo de contenido.
            $this->language
        );

        $itemList = [];

        $bindList[] = array(
            "eslBarCode" => $producto->getPriceTag(),
            "item" => $producto->getArrayArticulo()
        );


        // Datos a enviar.
        $data = array(
            "storeId" => $tiendaID,
            "unitName" => 0,
            "bindList" => $bindList
        );

        // Inicializar cURL
        $ch = curl_init($url);

        // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Especificar el tipo de solicitud (POST en este ejemplo)
        curl_setopt($ch, CURLOPT_POST, true);

        // Configurar los datos a enviar (si es una solicitud POST)
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Establecer los encabezados personalizados
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);

        
        // Cerrar la conexión cURL
        curl_close($ch);

        return $response;
    }

    public function batchBindInBatches(array $productos , $tiendaID){
        $endpoint = "/erp/esl/batchBind";
        $url = $this->baseUrl . $endpoint;

        $loginCrendentials = $this->getLoginCredentials();

        // Encabezados personalizados
        $headers = array(
            'Authorization: ' . $loginCrendentials['token'], // Encabezado de autorización.
            'Content-type: ' . $this->contentType, // Tipo de contenido.
            $this->language
        );

        $itemList = [];

        foreach($productos as $producto){
            $bindList[] = array(
                "eslBarCode" => $producto->getPriceTag(),
                "item" => $producto->getArrayArticulo()
            );
        }

        // Datos a enviar.
        $data = array(
            "storeId" => $tiendaID,
            "unitName" => 0,
            "bindList" => $bindList
        );

        // Inicializar cURL
        $ch = curl_init($url);

        // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Especificar el tipo de solicitud (POST en este ejemplo)
        curl_setopt($ch, CURLOPT_POST, true);

        // Configurar los datos a enviar (si es una solicitud POST)
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Establecer los encabezados personalizados
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);

        
        // Cerrar la conexión cURL
        curl_close($ch);

        return $response;
    }


    public function deleteProduct($codBarrasProducto , $tiendaID){
        $endpoint = "/item/batchDeleteItem";
        $url = $this->baseUrl . $endpoint;
    
        $loginCredentials = $this->getLoginCredentials();
        
        // Encabezados personalizados
        $headers = array(
            'Authorization: ' . $loginCredentials['token'], // Encabezado de autorización.
            'Content-Type: ' . $this->contentType, // Tipo de contenido.
            $this->language
        );
    
        // Datos a enviar en el cuerpo de la solicitud
        $data = array(
            "storeId" => "", // El string vacio en storeId hace que lo borre de la mercancia.
            "list" => [$codBarrasProducto]
        );
    
        // Inicializar cURL
        $ch = curl_init($url);
    
        // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); // Especificar que es una solicitud DELETE
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Establecer el cuerpo de la solicitud
    
        // Establecer los encabezados personalizados
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
    
        // Cerrar la conexión cURL
        curl_close($ch);

        return $response;

    }

    public function unbindPriceTag($producto){
        $endpoint = "/item/batchImportItem";
        $url = $this->baseUrl . $endpoint;

        $loginCrendentials = $this->getLoginCredentials();

        // Encabezados personalizados
        $headers = array(
            'Authorization: ' . $loginCrendentials['token'], // Encabezado de autorización.
            'Content-type: ' . $this->contentType, // Tipo de contenido.
            $this->language
        );

        // Datos a enviar.
        $data = array(
            "storeId" => $tiendaID,
            "itemList" => [$producto->getPriceTag()] 
        );

        // Inicializar cURL
        $ch = curl_init($url);

        // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Especificar el tipo de solicitud (POST en este ejemplo)
        curl_setopt($ch, CURLOPT_POST, true);

        // Configurar los datos a enviar (si es una solicitud POST)
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Establecer los encabezados personalizados
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);

        
        // Cerrar la conexión cURL
        curl_close($ch);

        return $response;
    }
    
    public function getLoginCredentials(){
        $endpoint = "/user/login";
        $url = $this->baseUrl . $endpoint;


        $encryptedPasswd = $this->encryptByPublicKey($this->password);

    
        // Datos a enviar (si es necesario)
        $data = array(
            'account' => $this->accountName,
            'loginType' => 3,
            'password' => $encryptedPasswd
        );
    
        // Encabezados personalizados
        $headers = array(
            'Content-Type: ' . $this->contentType, // Tipo de contenido (si estás enviando datos en formato JSON)
            'Language: ' . $this->language
        );
    
        // Inicializar cURL
        $ch = curl_init($url);
    
        // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Especificar el tipo de solicitud (POST en este ejemplo)
        curl_setopt($ch, CURLOPT_POST, true);
    
        // Configurar los datos a enviar (si es una solicitud POST)
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
        // Establecer los encabezados personalizados
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
    
        // Cerrar la conexión cURL
        curl_close($ch);
    
        $response_array = json_decode($response, true);
    
        if($response_array['success']){
            $token = $response_array['data']['token'];
            $merchantId = $response_array['data']['currentUser']['merchantId'];
            $agencyId = $response_array['data']['currentUser']['agencyId'];

            // Devolver los datos como un array
            return array(
                'token' => $token,
                'merchantId' => $merchantId,
                'agencyId' => $agencyId
            );
        } else {
            return false; // Lanzar excepcion.
        }
    }

    private function encryptByPublicKey($password) {
        $beginPublicKey = '-----BEGIN PUBLIC KEY-----';
        $endPublicKey = '-----END PUBLIC KEY-----';
        
        // La clave pública codificada en base64
        $publicKeyBase64 = $this->getPublicKey();

        // Construir la clave pública en el formato correcto
        $publicKeyText = $beginPublicKey . PHP_EOL . $publicKeyBase64 . PHP_EOL . $endPublicKey;
        // Decodificar la clave pública de texto base64
        $publicKey = openssl_pkey_get_public($publicKeyText);
        
        // Verificar si se pudo obtener la clave pública
        if ($publicKey === false) {
            throw new Exception('No se pudo obtener la clave pública');
        }
    
        // Encriptar el texto con la clave pública
        $encrypted = '';
        $success = openssl_public_encrypt($password, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING);
    
        // Verificar si la encriptación fue exitosa
        if ($success === false) {
            throw new Exception('Error al encriptar con la clave pública');
        }
    
        // Codificar el resultado en base64 y retornarlo
        return base64_encode($encrypted);
    }

    private function getPublicKey(){
        $endpoint = '/user/getErpPublicKey';
        $url = $this->baseUrl . $endpoint;
    
        // Inicializar cURL
        $ch = curl_init($url);
    
        // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
    
        // Cerrar la conexión cURL
        curl_close($ch);
    
        // Decodificar la respuesta JSON
        $responseData = json_decode($response, true);
    
        // Verificar si la decodificación fue exitosa y si existe el campo "data"
        if ($responseData && isset($responseData['data'])) {
            // Devolver solo el valor del campo "data"
            return $responseData['data'];
        } else {
            // En caso de que no se pueda obtener el campo "data", devolver nulo o manejar el error según sea necesario
            return null;
        }
    }
    
}
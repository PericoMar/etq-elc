    -- CREAR BASE DE DATOS
    CREATE DATABASE ETIQUETAS_ELECTRONICAS;
    USE etiquetas;

    -- CREAR USUARIO
    CREATE USER 'gestor' IDENTIFIED BY 'gestorGESTOR2';
    GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, ALTER, EXECUTE ON *.* TO 'gestor'@'%';

CREATE TABLE Usuarios (
    nombre VARCHAR(255) PRIMARY KEY,
    pass VARCHAR(255), 
    email VARCHAR(255),
    rol VARCHAR(50) CHECK (rol IN ('Administrador', 'Gestor', 'Usuario'))
);

CREATE TABLE Tiendas (
    store_id VARCHAR(50) PRIMARY KEY,
    nombre_tienda VARCHAR(50)
);

CREATE TABLE Usuarios_Tiendas (
    usuario_nombre VARCHAR(255),
    store_id VARCHAR(50),
    PRIMARY KEY (usuario_nombre, store_id),
    FOREIGN KEY (usuario_nombre) REFERENCES Usuarios(nombre),
    FOREIGN KEY (store_id) REFERENCES Tiendas(store_id)
);

CREATE TABLE Diseños (
    id_plantilla VARCHAR(50) PRIMARY KEY,
    nombre VARCHAR(50), 
    categoria VARCHAR(50),
    tipo VARCHAR(50),
    foto VARCHAR(255),
    tamano VARCHAR(10) CHECK (tamano IN ('1.54"', '1.8"', '2.13"', '2.2"', '2.4"', '2.6"', '2.7"', '2.9"', '3.0"', '3.5"', '3.7"', '4.2"', '4.3"', '4.4"', '5.56"', '5.79"', '5.8"', '7.3"', '7.5"', '8.2"', '9.7"', '10.2"', '11.6"', '13.3"'))
);

CREATE TABLE Diseños_Tiendas (
    id_plantilla VARCHAR(50),
    store_id VARCHAR(50),
    PRIMARY KEY (id_plantilla, store_id),
    FOREIGN KEY (id_plantilla) REFERENCES Diseños(id_plantilla),
    FOREIGN KEY (store_id) REFERENCES Tiendas(store_id)
);

CREATE TABLE Articulos (
    codigo_barras VARCHAR(50),
    store_id VARCHAR(50),
    id_plantilla VARCHAR(50),
    codigo_producto VARCHAR(50),
    nombre_corto VARCHAR(100),
    nombre_articulo VARCHAR(255),
    precio_inicial DECIMAL(10, 2),
    precio_venta DECIMAL(10, 2),
    etiqueta VARCHAR(50),
    familia VARCHAR(50),
    info_extra TEXT,
    PRIMARY KEY (codigo_barras, store_id),
    FOREIGN KEY (store_id) REFERENCES Tiendas(store_id),
    FOREIGN KEY (id_plantilla) REFERENCES Diseños(id_plantilla)
);


    -- Insertar datos en la tabla Usuarios
    INSERT INTO Usuarios (nombre, pass , email, rol)
    VALUES
        ('usuario1', 'contraseña1', 'usuario1@example.com', 'Usuario'),
        ('usuario2', 'contraseña2', 'usuario2@example.com', 'Usuario'),
        ('usuario3', 'contraseña3', 'usuario3@example.com', 'Usuario'),
        ('gestor1', 'contraseña4', 'gestor1@example.com', 'Gestor'),
        ('gestor2', 'contraseña5', 'gestor2@example.com', 'Gestor'),
        ('admin1', 'contraseña6', 'admin1@example.com', 'Administrador');

    -- Insertar datos en la tabla Tiendas   
    INSERT INTO Tiendas (store_id, nombre_tienda)
    VALUES
        ('1618198065591', 'SALA DEMO'),
        ('1618198065592', 'tienda2');

    -- Insertar diseño
    INSERT INTO Diseños (id_plantilla,categoria, tipo, foto, tamano) VALUES
    (3, 'default', 'default', 'ruta/foto.jpg', '1.8"');


    -- Insertar datos en la tabla Usuarios_Tiendas
    -- Establecer las relaciones entre usuarios y tiendas
    INSERT INTO Usuarios_Tiendas (usuario_nombre, store_id)
    VALUES
        ('usuario1', '1618198065591'),
        ('admin1', '1618198065591');


    INSERT INTO Diseños_Tiendas (store_id, id_plantilla)
    VALUES 
    ('1618198065591', 3);

    -- Insertar artículos
    INSERT INTO Articulos (codigo_barras,store_id,  id_plantilla, codigo_producto, nombre_corto, nombre_articulo, precio_inicial, precio_venta,etiqueta, info_extra) VALUES
    ('C1', '1618198065591', 2, 'PROD001', 'Camiseta 001', 'Camiseta de algodón', 10.00, 15.00, '1' , 'Descripción del artículo 1'),
    ('C2', '1618198065591', 2, 'PROD002', 'Camiseta 002', 'Camiseta de poliéster', 12.00, 18.00, '1' , 'Descripción del artículo 2'),
    ('C3', '1618198065591', 2, 'PROD003', 'Camiseta 003', 'Camiseta de manga larga', 15.00, 20.00, '1' , 'Descripción del artículo 3'),
    ('C4', '1618198065591', 2, 'PROD004', 'Camiseta 004', 'Camiseta deportiva', 20.00, 25.00, '1' , 'Descripción del artículo 4'),
    ('C5', '1618198065591', 2, 'PROD005', 'Camiseta 005', 'Camiseta de verano', 18.00, 22.00, '1' , 'Descripción del artículo 5');



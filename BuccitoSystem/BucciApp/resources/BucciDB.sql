-- Crear la base de datos
Create DATABASE bucci;

-- Usar la base de datos creada
USE bucci;

-- Tabla: tbl_roles
CREATE TABLE tbl_roles (
    id_rol INT PRIMARY KEY AUTO_INCREMENT,
    nombre_rol VARCHAR(50) NOT NULL
);

INSERT INTO tbl_roles (nombre_rol) VALUES ('administrador'), ('empleado');

-- Tabla: tbl_usuarios
CREATE TABLE tbl_usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL,
    clave VARCHAR(255) NOT NULL,
    id_rol INT,
    FOREIGN KEY (id_rol) REFERENCES tbl_roles(id_rol)
);

INSERT INTO tbl_usuarios (nombre, usuario, clave, id_rol)
VALUES 
('Admin', 'admin', '$2b$12$/DU5/JfI68JNrFcuY4kmI.kUu5v2tTlWfiCR6bfp7bN7hL0jOXgzy', 1);

INSERT INTO tbl_usuarios (nombre, usuario, clave, id_rol)
VALUES 
('Empleado', 'empleado', '$2b$12$/DU5/JfI68JNrFcuY4kmI.kUu5v2tTlWfiCR6bfp7bN7hL0jOXgzy', 2);

-- Tabla: tbl_productos
CREATE TABLE tbl_productos (
    id_producto INT PRIMARY KEY AUTO_INCREMENT,
    nombreProducto VARCHAR(100) NOT NULL,
    descripcion VARCHAR(100),
    precioUnitario DECIMAL(10, 2) NOT NULL
);

-- Tabla: tbl_inventario
CREATE TABLE tbl_inventario (
    id_inventario INT PRIMARY KEY AUTO_INCREMENT,
    id_producto INT,
    existencias_actuales INT NOT NULL DEFAULT 0,
    descripcion VARCHAR(100),
    precio DECIMAL(10, 2),
    ultima_transaccion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tipo_ultima_transaccion ENUM('entrada', 'salida') DEFAULT 'entrada',
    FOREIGN KEY (id_producto) REFERENCES tbl_productos(id_producto)
);

-- Tabla: tbl_compras
CREATE TABLE tbl_compras (
    id_compra INT PRIMARY KEY AUTO_INCREMENT,
    producto VARCHAR(50),
    cantidad INT NOT NULL,
    fecha_compra TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_producto INT,
    FOREIGN KEY (id_producto) REFERENCES tbl_productos(id_producto)
);

-- Tabla: tbl_ventas
CREATE TABLE tbl_ventas (
    id_venta INT PRIMARY KEY AUTO_INCREMENT,
    fecha_venta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10, 2) NOT NULL
);

-- Tabla: tbl_detalle_ventas
CREATE TABLE tbl_detalle_ventas (
    id_detalle INT PRIMARY KEY AUTO_INCREMENT,
    id_venta INT,
    id_producto INT,
    cantidad INT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) AS (cantidad * precio) STORED,
    FOREIGN KEY (id_venta) REFERENCES tbl_ventas(id_venta),
    FOREIGN KEY (id_producto) REFERENCES tbl_productos(id_producto)
);



DELIMITER $$

-- Trigger para cuando se actualiza el precio en productos
CREATE TRIGGER trg_after_update_product_price
AFTER UPDATE ON tbl_productos
FOR EACH ROW
BEGIN
    IF NEW.precioUnitario != OLD.precioUnitario THEN
        UPDATE tbl_inventario 
        SET precio = NEW.precioUnitario
        WHERE id_producto = NEW.id_producto;
    END IF;
END $$

-- Trigger para cuando se inserta una compra
DROP TRIGGER IF EXISTS trg_after_insert_compra$$
CREATE TRIGGER trg_after_insert_compra
AFTER INSERT ON tbl_compras
FOR EACH ROW
BEGIN
    UPDATE tbl_inventario 
    SET existencias_actuales = existencias_actuales + NEW.cantidad,
        ultima_transaccion = NEW.fecha_compra,
        tipo_ultima_transaccion = 'entrada'
    WHERE id_producto = NEW.id_producto;
END $$

-- Trigger para cuando se inserta una venta
CREATE TRIGGER trg_after_insert_venta
AFTER INSERT ON tbl_detalle_ventas
FOR EACH ROW
BEGIN
    -- Restamos la cantidad vendida del inventario
    UPDATE tbl_inventario 
    SET existencias_actuales = existencias_actuales - NEW.cantidad,
        ultima_transaccion = CURRENT_TIMESTAMP,
        tipo_ultima_transaccion = 'salida'
    WHERE id_producto = NEW.id_producto;
END $$

-- Trigger para cuando se inserta un nuevo producto
CREATE TRIGGER trg_after_insert_product
AFTER INSERT ON tbl_productos
FOR EACH ROW
BEGIN
    -- Insertar automáticamente en tbl_inventario cuando se crea un producto
    INSERT INTO tbl_inventario (
        id_producto, 
        existencias_actuales,
        descripcion,
        precio,
        ultima_transaccion,
        tipo_ultima_transaccion
    )
    VALUES (
        NEW.id_producto, 
        0,
        NEW.descripcion,
        NEW.precioUnitario,
        CURRENT_TIMESTAMP,
        'entrada'
    );
END $$

DELIMITER ;

DELIMITER $$

-- Trigger para actualizar el inventario cuando se modifica una cantidad en compras
CREATE TRIGGER trg_after_update_compra
AFTER UPDATE ON tbl_compras
FOR EACH ROW
BEGIN
    -- Solo actualizamos la diferencia en el inventario
    UPDATE tbl_inventario 
    SET existencias_actuales = existencias_actuales - OLD.cantidad + NEW.cantidad,
        ultima_transaccion = CURRENT_TIMESTAMP,
        tipo_ultima_transaccion = 'entrada'
    WHERE id_producto = NEW.id_producto;
END$$

-- Trigger para cuando se elimina una compra
CREATE TRIGGER trg_after_delete_compra
AFTER DELETE ON tbl_compras
FOR EACH ROW
BEGIN
    -- Restamos la cantidad del inventario
    UPDATE tbl_inventario 
    SET existencias_actuales = existencias_actuales - OLD.cantidad,
        ultima_transaccion = CURRENT_TIMESTAMP,
        tipo_ultima_transaccion = 'entrada'
    WHERE id_producto = OLD.id_producto;
END$$

DELIMITER ;

-- Datos de ejemplo para productos
INSERT INTO tbl_productos (nombreProducto, descripcion, precioUnitario)
VALUES 
    ('Camiseta Básica', 'Camiseta de algodón unisex', 15.50),
    ('Jeans Skinny', 'Jeans ajustados para mujer', 29.99),
    ('Chaqueta de Cuero', 'Chaqueta de cuero sintético para hombre', 55.00),
    ('Tenis Deportivos', 'Tenis ligeros para entrenamiento', 42.75),
    ('Botas de Invierno', 'Botas impermeables para mujer', 65.90);
    
    -- Primero eliminamos las llaves foráneas existentes
ALTER TABLE tbl_inventario
DROP FOREIGN KEY tbl_inventario_ibfk_1;

ALTER TABLE tbl_compras
DROP FOREIGN KEY tbl_compras_ibfk_1;

ALTER TABLE tbl_detalle_ventas
DROP FOREIGN KEY tbl_detalle_ventas_ibfk_2;

-- Luego las volvemos a crear con ON DELETE CASCADE
ALTER TABLE tbl_inventario
ADD CONSTRAINT tbl_inventario_ibfk_1
FOREIGN KEY (id_producto) 
REFERENCES tbl_productos(id_producto)
ON DELETE CASCADE;

ALTER TABLE tbl_compras
ADD CONSTRAINT tbl_compras_ibfk_1
FOREIGN KEY (id_producto) 
REFERENCES tbl_productos(id_producto)
ON DELETE CASCADE;

ALTER TABLE tbl_detalle_ventas
ADD CONSTRAINT tbl_detalle_ventas_ibfk_2
FOREIGN KEY (id_producto) 
REFERENCES tbl_productos(id_producto)
ON DELETE CASCADE;

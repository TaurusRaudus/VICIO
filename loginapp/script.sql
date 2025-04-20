-- 1. Crear la base de datos si no existe
--CREATE DATABASE visiobd;

-- Usar la base de datos recién creada
--\c visiobd;

-- 2. Crear la tabla de administradores
CREATE TABLE administradores (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contraseña VARCHAR(100) NOT NULL
);

-- 3. Crear la tabla de usuarios (si se usan en otras funciones)
CREATE TABLE usuarios (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    correo VARCHAR(100) UNIQUE NOT NULL,
    contraseña VARCHAR(100) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Crear la tabla de categorías
CREATE TABLE categorias (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);

-- 5. Crear la tabla de contenidos
CREATE TABLE contenidos (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descripcion TEXT,
    autor VARCHAR(150) NOT NULL, -- Se añade el campo para el autor
    tipo VARCHAR(50), -- imagen, sonido, video
    url TEXT NOT NULL,
    precio NUMERIC(10, 2) NOT NULL,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_admins INT REFERENCES administradores(id) ON DELETE CASCADE -- Relación con administradores
);

-- 6. Crear la tabla de descargas
CREATE TABLE descargas (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    id_usuario INT REFERENCES usuarios(id) ON DELETE CASCADE,
    id_contenido INT REFERENCES contenidos(id) ON DELETE CASCADE,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 7. Crear la tabla historial de descargas
CREATE TABLE historial_descargas (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    id_usuario INT REFERENCES usuarios(id),
    id_contenido INT REFERENCES contenidos(id),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 8. Crear la tabla de promociones
CREATE TABLE promociones (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    codigo VARCHAR(50) UNIQUE NOT NULL,
    descripcion TEXT,
    descuento NUMERIC(5, 2), -- Ej: 10.00 = 10%
    fecha_inicio DATE,
    fecha_fin DATE,
    activo BOOLEAN DEFAULT TRUE
);

-- 9. Crear la tabla de regalos entre usuarios
CREATE TABLE regalos (
    id INT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
    id_remitente INT REFERENCES usuarios(id),
    id_destinatario INT REFERENCES usuarios(id),
    id_contenido INT REFERENCES contenidos(id),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 10. Insertar un administrador predeterminado
INSERT INTO administradores (nombre, correo, contraseña)
VALUES ('admin', 'admin@admin.com', 'admin123');

-- 11. Insertar algunas categorías predeterminadas
INSERT INTO categorias (nombre)
VALUES ('Categoría 1'), ('Categoría 2'), ('Categoría 3');

-- Opcional: Verificar inserciones
SELECT * FROM administradores;
SELECT * FROM categorias;
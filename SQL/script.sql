CREATE DATABASE deportes_usuarios;

USE deportes_usuarios;

/*Se crea administrador, un usuario con todos los permisos, para gestionar la app*/
CREATE USER 'admin_deportes'@'localhost' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON deportes_usuarios.* TO 'admin_deportes'@'localhost';

CREATE TABLE deportes(
    idDeporte tinyint unsigned AUTO_INCREMENT PRIMARY KEY,
    nombreDep varchar(15) NOT NULL
)

CREATE TABLE usuarios(
    idUsuario tinyint unsigned AUTO_INCREMENT PRIMARY KEY,
    nombreUsuario varchar(30) UNIQUE,
    apeNombre varchar(60) NOT NULL,
    password varchar(100) NOT NULL,
    correo varchar(60) NOT NULL,
    telefono char(9) NULL,
    perfil char(1) NOT NULL CHECK(perfil="c" or perfil="u")
)

CREATE TABLE usuarios_deportes(
    idDeporte tinyint unsigned, 
    idUsuario tinyint unsigned,
    PRIMARY KEY (idDeporte, idUsuario),
    CONSTRAINT FK_deportes FOREIGN KEY (idDeporte) REFERENCES deportes(idDeporte) ON DELETE CASCADE,
    CONSTRAINT FK_usuario FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario) ON DELETE CASCADE
)

INSERT INTO deportes (nombreDep) VALUES 
('Fútbol'),
('Baloncesto'),
('Tenis');

/*Para actualizar la tabla deportes y poder guardar imagenes.
Esta columna a null para que no interfiera con los datos que ya habian*/
ALTER TABLE deportes ADD COLUMN imagen VARCHAR(255) NULL;


/*Usuario que utiliza la app*/
CREATE USER 'usuarioUD'@'localhost' IDENTIFIED BY '123456789';

GRANT SELECT, INSERT, UPDATE, DELETE ON deportes_usuarios.* TO 'usuarioUD'@'localhost';

FLUSH PRIVILEGES;

/**/

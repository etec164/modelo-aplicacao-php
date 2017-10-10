CREATE DATABASE forum;

USE forum;

CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha CHAR(64) NOT NULL,
    administrador BOOLEAN DEFAULT FALSE
);

INSERT INTO usuarios(id, email, senha, administrador) VALUES
    (1, 'admin@admin.com', SHA2('admin', 256), TRUE),
    (2, 'user@user.com', SHA2('user', 256), FALSE);


CREATE TABLE topicos(
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    texto TEXT NOT NULL,
    id_usuario INT NOT NULL REFERENCES usuarios(id)
);

CREATE TABLE comentarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    texto TEXT NOT NULL,
    id_topico INT NOT NULL REFERENCES topicos(id),
    id_usuario INT NOT NULL REFERENCES usuarios(id)
);
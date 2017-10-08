CREATE DATABASE esqueleto_aplicacao;

USE esqueleto_aplicacao;

CREATE TABLE usuarios(
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha CHAR(64) NOT NULL,
    administrador BOOLEAN DEFAULT FALSE
);

INSERT INTO usuarios(id, email, senha, administrador) VALUES
    (1, 'admin@admin.com', SHA2('admin', 256), TRUE),
    (2, 'user@user.com', SHA2('user', 256), FALSE);

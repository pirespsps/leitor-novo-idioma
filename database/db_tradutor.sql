CREATE DATABASE db_tradutor;

USE db_tradutor;

CREATE TABLE tbDocumento(
id INT AUTO_INCREMENT,
titulo VARCHAR(255),
alinhamento ENUM('left','center'),
idioma VARCHAR(2),
pathArquivo VARCHAR(255),
pagina INT,
paginasTotais INT,

updated_at DATETIME,
created_at DATETIME,

CONSTRAINT pk_tbDocumento PRIMARY KEY (id)
);

CREATE TABLE tbPalavra(
id INT AUTO_INCREMENT,
palavraOriginal VARCHAR(255),
significado VARCHAR(255),
idioma VARCHAR(2),

updated_at DATETIME,
created_at DATETIME,

CONSTRAINT pk_tbPalavra PRIMARY KEY (id)
);

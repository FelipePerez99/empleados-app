-- Esquema base según diccionario del PDF
CREATE DATABASE IF NOT EXISTS empleados_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE empleados_db;

CREATE TABLE areas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE roles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE empleados (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,              
  correo VARCHAR(255) NOT NULL,              
  sexo CHAR(1) NOT NULL,                     
  area_id INT NOT NULL,                      
  boletin TINYINT(1) NOT NULL DEFAULT 0,     
  descripcion TEXT NOT NULL,                 
  CONSTRAINT chk_sexo CHECK (sexo IN ('M','F')),
  CONSTRAINT fk_empleado_area FOREIGN KEY (area_id) REFERENCES areas(id)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  INDEX idx_empleados_correo (correo)
) ENGINE=InnoDB;

CREATE TABLE empleado_rol (
  empleado_id INT NOT NULL,
  rol_id INT NOT NULL,
  PRIMARY KEY (empleado_id, rol_id),
  CONSTRAINT fk_er_emp FOREIGN KEY (empleado_id) REFERENCES empleados(id)
    ON DELETE CASCADE,
  CONSTRAINT fk_er_rol FOREIGN KEY (rol_id) REFERENCES roles(id)
    ON DELETE RESTRICT
) ENGINE=InnoDB;

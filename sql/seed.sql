USE empleados_db;

-- Áreas (según el documento: Ventas, Calidad, Producción)
INSERT INTO areas (nombre) VALUES 
('Ventas'),
('Calidad'),
('Producción');

-- Roles (según prototipo de formulario)
INSERT INTO roles (nombre) VALUES
('Profesional de proyectos - Desarrollador'),
('Gerente estratégico'),
('Auxiliar administrativo');

-- Empleados de ejemplo (según prototipo de listar)
INSERT INTO empleados (nombre, correo, sexo, area_id, boletin, descripcion)
VALUES 
('Gladys Fernández', 'gfernandez@example.com', 'F', 1, 1, 'Profesional de proyectos en área de ventas'),
('Felipe Gómez', 'fgomez@example.com', 'M', 2, 1, 'Ingeniero de calidad con 5 años de experiencia'),
('Adriana Lozada', 'alozada@example.com', 'F', 3, 0, 'Analista de producción y soporte');

-- Asignación de roles (según prototipo)
INSERT INTO empleado_rol (empleado_id, rol_id) VALUES
(1, 1), 
(2, 2), 
(3, 3); 

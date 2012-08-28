/*
ELIMINAR CAMPOS EN DESUSO
*/

ALTER TABLE planes DROP COLUMN sector;
ALTER TABLE planes DROP COLUMN sector_id;
ALTER TABLE planes DROP COLUMN subsector_id;
ALTER TABLE instits DROP COLUMN depto;
ALTER TABLE instits DROP COLUMN localidad;
ALTER TABLE instits DROP COLUMN fecha_mod;
ALTER TABLE instits DROP COLUMN actualizacion;
ALTER TABLE planes DROP COLUMN old_item;
ALTER TABLE anios DROP COLUMN old_item;
ALTER TABLE planes DROP COLUMN ciclo_mod;
DROP TABLE logs;

/*
CORRECCIÓN DE ROLES HARCODEADOS
*/
update users set role='invitados' where role like 'invitado';
update users set role='administradores' where role like 'admin';
update users set role='desarrolladores' where role like 'desarrollo';
update users set role='editores' where role like 'editor';

/*
AUTORIDADES
*/

CREATE TABLE autoridades (
    id serial NOT NULL PRIMARY KEY,
    jurisdiccion_id integer,
    nombre character varying(100) DEFAULT ''::character varying NOT NULL,
    apellido character varying(100) DEFAULT ''::character varying NOT NULL,
    fecha_asuncion date,
    titulo character varying(50) DEFAULT '',
    telefono_personal character varying(50) DEFAULT '',
    telefono_institucional character varying(50) DEFAULT '',
    email_personal character varying(100) DEFAULT '',
    email_institucional character varying(100) DEFAULT '',
    direccion character varying(100) DEFAULT '',
    localidad_id integer,
    departamento_id integer
);

CREATE TABLE cargos (
    id serial NOT NULL PRIMARY KEY,
    nombre character varying(100) DEFAULT ''::character varying NOT NULL,
    rango integer
);

CREATE TABLE autoridades_cargos (
    id serial NOT NULL PRIMARY KEY,
    autoridad_id integer,
    cargo_id integer
);

/*
BORRAR CAMPOS DE AUTORIDAD DE JURISDICCION
*/
ALTER TABLE "public"."jurisdicciones" DROP COLUMN "autoridad_cargo";
ALTER TABLE "public"."jurisdicciones" DROP COLUMN "autoridad_nombre";
ALTER TABLE "public"."jurisdicciones" DROP COLUMN "autoridad_fecha_asuncion";

/*
CARGOS
*/

INSERT INTO cargos (nombre, rango)
VALUES ('Ministro de Educación', 1);
INSERT INTO cargos (nombre, rango)
VALUES ('Ministro de Educación, Ciencia y Tecnología', 1);
INSERT INTO cargos (nombre, rango)
VALUES ('Presidente del Consejo General de Educación', 1);
INSERT INTO cargos (nombre, rango)
VALUES ('Secretario de Estado de Educación, Cultura y Deporte', 1);
INSERT INTO cargos (nombre, rango)
VALUES ('Director General de Cultura y Educación', 1);
INSERT INTO cargos (nombre, rango)
VALUES ('Ministro de Educación y Cultura', 1);
INSERT INTO cargos (nombre, rango)
VALUES ('Ministro de Educación, Cultura, Ciencia y Tecnología', 1);
INSERT INTO cargos (nombre, rango)
VALUES ('Director General de Escuelas', 1);
INSERT INTO cargos (nombre, rango)
VALUES ('Ministro de Cultura y Educación', 1);
INSERT INTO cargos (nombre, rango)
VALUES ('Presidente del Consejo Provincial de Educación', 1);
INSERT INTO cargos (nombre, rango)
VALUES ('Referente Jurisdiccional (Titular)', 2);
INSERT INTO cargos (nombre, rango)
VALUES ('Referente Jurisdiccional (Suplente)', 3);
INSERT INTO cargos (nombre, rango)
VALUES ('Referente de Educación Secundaria', 4);
INSERT INTO cargos (nombre, rango)
VALUES ('Referente de Educación Superior', 4);
INSERT INTO cargos (nombre, rango)
VALUES ('Referente de Formación Profesional', 4);
INSERT INTO cargos (nombre, rango)
VALUES ('Unidad Ejecutora Jurisdiccional', 4);

/*
AUTORIDADES y AUTORIDADES_CARGOS
*/

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES (10,'Lic.', 'Mario Alberto', 'Perna', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(1,2);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(22,'Prof.', 'Neri Francisco Enrique', 'Romero', '2009-10-09');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(2,2);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(26,'Prof.', 'Haydee Mirta', 'Romero', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(3,1);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(2,'Lic.', 'Esteban', 'Bullrich', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(4,1);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(14,'Prof.', 'Walter', 'Grahovac', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(5,1);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(18,'Dr.', 'Orlando', 'Macció', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(6,6);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(30,'Prof.', 'Graciela Yolanda', 'Bar', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(7,3);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(34,'Lic.', 'Olga Isabel', 'Comello', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(8,9);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(6,'Prof.', 'Mario N.', 'Oporto', '2007-12-01');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(9,5);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(38,'Prof.', 'Liliana Josefina', 'Dominguez', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(10,1);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(42,'Prof.', 'Néstor Anselmo', 'Torres', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(11,9);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(46,'Lic.', 'Rafael Walter', 'Flores', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(12,1);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(50,'Cdor.', 'Carlos Lopez', 'Puelle', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(13,8);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(54,'Ing.', 'Luis Jacobo', 'Jacobo', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(14,9);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(58,'Dn.', 'José Ernesto', 'Seguel', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(15,4);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(62,'Dn.', 'Cesar', 'Barbeito', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(16,1);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(66,'Lic.', 'Leopoldo', 'Van Cauwlaert', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(17,1);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(70,'Prof.', 'María Cristina', 'Díaz', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(18,1);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(74,'Lic.', 'Fernando', 'Salino', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(19,1);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(78,'Prof.', 'Roberto', 'Borselli', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(20,10);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(82,'Lic.', 'Elida', 'Rasino', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(21,1);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(86,'Dra.', 'María Fernanda', 'Gómez Macedo', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(22,1);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(94,'Prof.', 'Amanda', 'del Corro', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(23,7);

INSERT INTO autoridades ( jurisdiccion_id, titulo, nombre, apellido, fecha_asuncion)
VALUES(90,'Lic.', 'Silvia', 'Rojkés de Temkin', '2010-07-14');
INSERT INTO autoridades_cargos (autoridad_id, cargo_id)
VALUES(24,1);





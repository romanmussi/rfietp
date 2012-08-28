
ALTER TABLE users ADD COLUMN jurisdiccion_id integer NOT NULL DEFAULT 0;
ALTER TABLE users ADD COLUMN created timestamp without time zone ;	
ALTER TABLE users ADD COLUMN modified timestamp without time zone ;

ALTER TABLE lineas_de_acciones ADD COLUMN formulario character varying(20) DEFAULT ''::character varying;
ALTER TABLE lineas_de_acciones ADD COLUMN referencia character varying(60) DEFAULT ''::character varying;
ALTER TABLE lineas_de_acciones ADD COLUMN orden integer NOT NULL DEFAULT 0;	

UPDATE lineas_de_acciones SET 
       name = 'F01', 
       description = 'F01 - Formación continua de docentes de ETP', 
       formulario = 'F01', referencia = 'Res. CFE 62/08'
       WHERE id = 1;
UPDATE lineas_de_acciones SET 
       name =  'F02A',
       description = 'F02A - Igualdad de oportunidades - Tutores - Jurisdiccional', 
       formulario = 'F02A', referencia ='Res. CFE 62/08'
       WHERE id = 2;
UPDATE lineas_de_acciones SET 
       name =  'F02B',
       description = 'F02B - Igualdad de oportunidades - Jurisdiccional', 
       formulario = 'F02B', referencia ='Res. CFE 62/08'
       WHERE id = 3;
UPDATE lineas_de_acciones SET 
       name =  'F02C',
       description = 'F02C - Igualdad de oportunidades - Institucional', 
       formulario = 'F02C', referencia ='Res. CFE 62/08'
       WHERE id = 4;
UPDATE lineas_de_acciones SET 
       name =  'F03A',
       description = 'F03A - Vinculación con ciencia y tecnología', 
       formulario = 'F03A', referencia ='Res. CFE 62/08'
       WHERE id = 5;
UPDATE lineas_de_acciones SET 
       name =  'F03B',
       description = 'F03B - Vinculación con sector socio productivo', 
       formulario = 'F03B', referencia ='Res. CFE 62/08'
       WHERE id = 6;
UPDATE lineas_de_acciones SET 
       name =  'F04', 
       description='F04 - Prácticas profesionalizantes', 
       formulario = 'F04', referencia ='Res. CFE 62/08'
       WHERE id = 7;
UPDATE lineas_de_acciones SET 
       name =  'F05', description='F05 - Equipamiento de talleres, laboratorios y espacios productivos', 
       formulario = 'F05', referencia ='Res. CFE 62/08'
       WHERE id = 8;
UPDATE lineas_de_acciones SET 
       name =  'F06A',
       description = 'F06A - Seguridad e higiene - Asesoramiento profesional', 
       formulario = 'F06A', referencia ='Res. CFE 62/08'
       WHERE id = 9;
UPDATE lineas_de_acciones SET 
       name =  'F06B',
       description = 'F06B - Seguridad e higiene - Protección personal', 
       formulario = 'F06B', referencia ='Res. CFE 62/08'
       WHERE id = 10;
UPDATE lineas_de_acciones SET 
       name =  'F06C',
       description = 'F06C - Seguridad e higiene - Protección de equipos', 
       formulario = 'F06C',referencia = 'Res. CFE 62/08'
       WHERE id = 11;
UPDATE lineas_de_acciones SET 
       name =  'F07A',
       description = 'F07A - Acondicionamiento edilicio (Estructuras existentes)', 
       formulario = 'F07A', referencia ='Res. CFE 62/08'
       WHERE id = 12;
UPDATE lineas_de_acciones SET 
       name =  'F07B',
       description = 'F07B - Acondicionamiento edilicio (Seguridad e higiene)', 
       formulario = 'F07B', referencia ='Res. CFE 62/08'
       WHERE id = 13;
UPDATE lineas_de_acciones SET 
       name =  'F07C',
       description = 'F07C - Acondicionamiento edilicio (Construcciones nuevas)', 
       formulario = 'F07C', referencia ='Res. CFE 62/08'
       WHERE id = 14;
UPDATE lineas_de_acciones SET 
       name =  'F08',
       description = 'F08 - Conexión a internet', 
       formulario = 'F08', referencia ='Res. CFE 62/08'
       WHERE id = 15;
UPDATE lineas_de_acciones SET 
       name =  'F09',
       description = 'F09 - Bibliotecas técnicas especializadas', 
       formulario = 'F09', referencia ='Res. CFE 62/08'
       WHERE id = 16;
UPDATE lineas_de_acciones SET 
       name =  'F10',description='F10 - Apoyo al Programa "Una computadora para cada alumno"', 
       formulario = 'F10', referencia ='Res. CFE 82/09'
       WHERE id = 17;
UPDATE lineas_de_acciones SET 
       name = 'equipinf', description='Informatización del último año', 
       formulario = 'F05A',referencia = 'Res. CFE 62/08'
       WHERE id = 18;
UPDATE lineas_de_acciones SET 
       name = 'refaccion',
       description = 'Refacción integral de edificios', 
       formulario = '', referencia ='Res. CFE 62/08
Res. CFE 51/08'
       WHERE id = 19;


-- tabla para sugerencias
CREATE TABLE sugerencias
(
  id serial,
  asunto character varying(100),
  mensaje text,
  remitente character varying(100),
  email character varying(100),
  "IP" character varying(15),
  created timestamp without time zone,
  leido integer DEFAULT 0,
  CONSTRAINT sugerencias_pkey PRIMARY KEY (id)
)
WITH (OIDS=FALSE);
-- Datos de Autoridad
ALTER TABLE jurisdicciones ADD COLUMN autoridad_cargo character varying(60) DEFAULT ''::character varying;
ALTER TABLE jurisdicciones ADD COLUMN autoridad_nombre character varying(60) DEFAULT ''::character varying;
ALTER TABLE jurisdicciones ADD COLUMN autoridad_fecha_asuncion date;
-- Datos del Ministerio
ALTER TABLE jurisdicciones ADD COLUMN ministerio_nombre character varying(60) DEFAULT ''::character varying;
ALTER TABLE jurisdicciones ADD COLUMN ministerio_direccion  character varying(200) DEFAULT ''::character varying;
ALTER TABLE jurisdicciones ADD COLUMN ministerio_codigo_postal  character varying(60) DEFAULT ''::character varying;
ALTER TABLE jurisdicciones ADD COLUMN ministerio_telefono character varying(60) DEFAULT ''::character varying;
ALTER TABLE jurisdicciones ADD COLUMN ministerio_mail  character varying(150) DEFAULT ''::character varying;
ALTER TABLE jurisdicciones ADD COLUMN ministerio_localidad_id  integer NOT NULL DEFAULT 0;
ALTER TABLE jurisdicciones ADD COLUMN modified timestamp without time zone;
ALTER TABLE jurisdicciones ADD COLUMN updated timestamp without time zone;

TRUNCATE TABLE jurisdicciones ;

INSERT INTO jurisdicciones VALUES (10, 'Catamarca', 'Ministro de Educación, Ciencia y Tecnología', 'Lic. Mario Alberto Perna', '2010-07-14', 'Ministerio de Educación, Ciencia y Tecnología', 'Sarmiento 603', '4700', '(03833) 437550/437552/437895', 'meccyt_secpriv@catamarca.gov.ar', 312, '2010-07-14 11:52:49', NULL);
INSERT INTO jurisdicciones VALUES (22, 'Chaco', 'Ministro de Educación, Ciencia y Tecnología', 'Prof. Neri Francisco Enrique Romero', '2009-10-09', 'Ministerio de Educación, Ciencia y Tecnología', 'Gobernador Bosch Nº 99', '3500', '(03722) 423637 directo - 453017/16 - 448014 - 53001/02', 'ministerio.educacion@ecomchaco.com.ar', 548, '2010-07-14 10:57:24', NULL);
INSERT INTO jurisdicciones VALUES (26, 'Chubut', 'Sra. Ministra de Educación', 'Prof. Haydee Mirta Romero ', '2010-07-14', 'Ministerio de Educación', '9 de Julio 24', '9103', '(02965) 482221 - 482341/344 int. 101 o 102', 'ministro@chubut.edu.ar', 1015, '2010-07-14 11:01:51', NULL);
INSERT INTO jurisdicciones VALUES (2, 'Ciudad de Bs. As.', 'Ministro de Educación', 'Lic. Esteban Bullrich', '2010-07-14', 'Ministerio de Educación', 'Av. Paseo Colón 255 P.B.', '1084', '(011) 4339-7735/7605', 'meducacion@buenosaires.gov.ar', 1512, '2010-07-14 11:03:38', NULL);
INSERT INTO jurisdicciones VALUES (14, 'Córdoba', 'Ministro de Educación', 'Prof. Walter Grahovac', '2010-07-14', 'Ministerio de Educación', 'Chacabuco 1300 ', '5000', '(0351) 4333431 - 4333432 DIRECTO 4334534 ', 'ministerio.educacion@cba.gov.ar', 336, '2010-07-14 11:06:43', NULL);
INSERT INTO jurisdicciones VALUES (18, 'Corrientes', 'Ministro de Educación y Cultura', 'Dr. Orlando Macció', '2010-07-14', 'Ministerio de Educación y Cultura', 'La Rioja 663', '3400', '(03783) 424264 - 474078', 'meducacionctes@gigared.com', 491, '2010-07-14 11:13:54', NULL);
INSERT INTO jurisdicciones VALUES (30, 'Entre Ríos', 'Presidente del Consejo General de Educación', 'Prof. Graciela Yolanda Bar', '2010-07-14', 'Consejo General de Educación', 'Córdoba y Laprida', '3100', '(0343) 4209333/34/35/36', 'consejogeneraleducacion@yahoo.com.ar', 612, '2010-07-14 11:19:32', NULL);
INSERT INTO jurisdicciones VALUES (34, 'Formosa', 'Ministra de Cultura y Educación', 'Lic. Olga Isabel Comello', '2010-07-14', 'Ministerio de Cultura y Educación', '25 de Mayo 58', '3600', '(03717) 431540 - 420717', 'ministraculturayeducacion@formosa.gov.ar', 638, '2010-07-14 11:22:13', NULL);
INSERT INTO jurisdicciones VALUES (6, 'Buenos Aires', 'Director General de Cultura y Educación', 'Prof. Mario N. Oporto', '2007-12-01', 'Dirección General de Cultura y Educación', 'Calle 13 E/56 y 57', '1900', '(0221) 4297600 - 4297642 - 4297641', 'gral_priv@ed.gba.gov.ar', 139, '2010-07-14 11:23:26', NULL);
INSERT INTO jurisdicciones VALUES (38, 'Jujuy', 'Ministra de Educación ', 'Prof. Liliana Josefina Dominguez', '2010-07-14', 'Ministerio de Educación', 'Güemes 1092 1° Piso', '4600', '(0388) 4221348/47/46', 'mebernal@jujuy.gov.ar', 676, '2010-07-14 11:26:00', NULL);
INSERT INTO jurisdicciones VALUES (42, 'La Pampa', 'Ministro de Cultura y Educación', 'Prof. Néstor Anselmo Torres', '2010-07-14', 'Ministerio de Cultura y Educación', 'Centro Cívico 2° Piso', '6300', '(02954) 4452738 - 452600 conmut.', 'mce@mce.lapampa.gov.ar', 1453, '2010-07-14 11:27:20', NULL);
INSERT INTO jurisdicciones VALUES (46, 'La Rioja', 'Ministro de Educación', 'Lic. Rafael Walter Flores', '2010-07-14', 'Ministro de Educación', 'Catamarca 65', '5300', '(03822) 453290', 'wflores@larioja.gov.ar', 724, '2010-07-14 11:32:46', NULL);
INSERT INTO jurisdicciones VALUES (50, 'Mendoza', 'Director General de Escuelas', 'Cdor. Carlos Lopez Puelle', '2010-07-14', 'Dirección General de Escuelas', 'Peltier 351 1° Piso - Cuerpo Central ', '5500', '(0261) 4492785 - 4492754 - 4492755', 'iml.dge@mendoza.gov.ar', 750, '2010-07-14 11:34:38', NULL);
INSERT INTO jurisdicciones VALUES (54, 'Misiones', 'Ministro de Cultura y Educación', 'Ing. Luis Jacobo', '2010-07-14', 'Ministerio de Cultura y Educación', 'Chacra 172 Centro Cívico Edificio 3 - 3° Piso', '3300', '(03752) 447360 directo - 447367 - 447731 - 447352', 'ministro@me.misiones.gov.ar', 842, '2010-07-14 11:35:47', NULL);
INSERT INTO jurisdicciones VALUES (58, 'Neuquén', 'Secretario de Estado de Educación, Cultura y Deporte', 'Dn. José Ernesto Seguel', '2010-07-14', 'Secretaría de Estado de Educación, Cultura y Deporte', 'Rioja y Roca', '8300', '(0299) 449-5412', 'mperassi@neuquen.gov.ar', 884, '2010-07-14 11:37:30', NULL);
INSERT INTO jurisdicciones VALUES (62, 'Rio Negro', 'Ministro de Educación', 'Dn. Cesar Barbeito', '2010-07-14', 'Ministerio de Educación', 'Alvaro Barros 439', '8500', '(02920) 421134', 'secministerio@educacion.rionegro.gov.ar', 901, '2010-07-14 11:38:50', NULL);
INSERT INTO jurisdicciones VALUES (66, 'Salta', 'Ministro de Educación', 'Lic. Leopoldo Van Cauwlaert', '2010-07-14', 'Ministerio de Educación', 'Centro Cívico Gran Bourg', '4400', '(0387) 4360408 directo - 4360990', 'ministro@edusalta.gov.ar', 1429, '2010-07-14 11:40:40', NULL);
INSERT INTO jurisdicciones VALUES (70, 'San Juan', 'Ministra de Educación', 'Prof. María Cristina Díaz', '2010-07-14', 'Ministerio de Educación', 'Av. del Libertador Gral. San Martín 750 - 2ª piso - Centro C', '5400', '(0264) 4305900 - 4305707/5848', 'educacionsanjuan@hotmail.com', 986, '2010-07-14 11:42:36', NULL);
INSERT INTO jurisdicciones VALUES (74, 'San Luis', 'Ministro de Educación', 'Lic. Fernando Salino', '2010-07-14', 'Ministerio de Educación', '9 de Julio 934 P.B.', '5700', '(02652) 451041/42', 'minieduc@sanluis.gov.ar', 1056, '2010-07-14 11:43:55', NULL);
INSERT INTO jurisdicciones VALUES (78, 'Santa Cruz', 'Presidente del Consejo Provincial de Educación', 'Prof. Roberto Borselli', '2010-07-14', 'Consejo Provincial de Educación', 'Av. Julio A. Roca 1381 ', '9400', '(02966) 426743 - 437658 directo', 'educacion@santacruz.gov.ar', 1061, '2010-07-14 11:47:23', NULL);
INSERT INTO jurisdicciones VALUES (82, 'Santa Fe', 'Ministra de Educación', 'Lic. Elida Rasino', '2010-07-14', 'Ministerio de Educación', 'Arturo Illia 1153 5° Piso', '3000', '(0342) 4506819 - 4506818 - 4506820', 'sprivada_educ@santafe.gov.ar', 1340, '2010-07-14 11:48:22', NULL);
INSERT INTO jurisdicciones VALUES (86, 'Santiago del Estero', 'Ministra de Educación', 'Dra. María Fernanda Gómez Macedo', '2010-07-14', 'Ministerio de Educación', 'Absalón Rojas Nº 572 (altos) - 1º Piso', '4200', '(0385) 4213188/5252 - 4215240 - 4242240', 'minise@me.gov.ar', 1221, '2010-07-14 11:49:25', NULL);
INSERT INTO jurisdicciones VALUES (94, 'Tierra del Fuego', 'Ministra de Educación, Cultura, Ciencia y Tecnología', 'Prof. Amanda del Corro', '2010-07-14', 'Ministerio de Educación, Cultura, Ciencia y Tecnología', 'Patagonia 416 Tira 10 Casa 52', '9410', '(02901) 441403', 'educacion@tierradelfuego.gov.ar', 1299, '2010-07-14 11:50:45', NULL);
INSERT INTO jurisdicciones VALUES (90, 'Tucumán', 'Ministra de Educación', 'Lic. Silvia Rojkés de Temkin', '2010-07-14', 'Ministerio de Educación', '25 de Mayo 90 1° Piso', '4000', '(0381) 4844000 - Int. 527/485/511', 'secedutuc@tucuman.gov.ar', 1254, '2010-07-14 11:51:56', NULL);
--
-- PostgreSQL database dump
--

SET client_encoding = 'LATIN1';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: acos; Type: TABLE; Schema: public; Owner: www; Tablespace: 
--

CREATE TABLE acos (
    id integer NOT NULL,
    parent_id integer,
    model character varying(255) DEFAULT ''::character varying,
    foreign_key integer,
    alias character varying(255) DEFAULT ''::character varying,
    lft integer,
    rght integer
);


ALTER TABLE public.acos OWNER TO www;

--
-- Name: acos_id_seq; Type: SEQUENCE; Schema: public; Owner: www
--

CREATE SEQUENCE acos_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.acos_id_seq OWNER TO www;

--
-- Name: acos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: www
--

ALTER SEQUENCE acos_id_seq OWNED BY acos.id;


--
-- Name: acos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: www
--

SELECT pg_catalog.setval('acos_id_seq', 376, true);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: www
--

ALTER TABLE acos ALTER COLUMN id SET DEFAULT nextval('acos_id_seq'::regclass);


--
-- Data for Name: acos; Type: TABLE DATA; Schema: public; Owner: www
--

INSERT INTO acos VALUES (36, 35, NULL, NULL, 'index', 69, 70);
INSERT INTO acos VALUES (60, 42, NULL, NULL, 'isAuthorized2', 117, 118);
INSERT INTO acos VALUES (3, 2, NULL, NULL, 'display', 3, 4);
INSERT INTO acos VALUES (37, 35, NULL, NULL, 'view', 71, 72);
INSERT INTO acos VALUES (4, 2, NULL, NULL, 'isAuthorized2', 5, 6);
INSERT INTO acos VALUES (42, 1, NULL, NULL, 'FondoTemporales', 82, 121);
INSERT INTO acos VALUES (5, 2, NULL, NULL, 'add', 7, 8);
INSERT INTO acos VALUES (38, 35, NULL, NULL, 'add', 73, 74);
INSERT INTO acos VALUES (6, 2, NULL, NULL, 'edit', 9, 10);
INSERT INTO acos VALUES (61, 42, NULL, NULL, 'add', 119, 120);
INSERT INTO acos VALUES (7, 2, NULL, NULL, 'index', 11, 12);
INSERT INTO acos VALUES (39, 35, NULL, NULL, 'edit', 75, 76);
INSERT INTO acos VALUES (8, 2, NULL, NULL, 'view', 13, 14);
INSERT INTO acos VALUES (92, 87, NULL, NULL, 'delete', 181, 182);
INSERT INTO acos VALUES (2, 1, NULL, NULL, 'Pages', 2, 17);
INSERT INTO acos VALUES (9, 2, NULL, NULL, 'delete', 15, 16);
INSERT INTO acos VALUES (69, 1, NULL, NULL, 'Queries', 136, 157);
INSERT INTO acos VALUES (40, 35, NULL, NULL, 'delete', 77, 78);
INSERT INTO acos VALUES (11, 10, NULL, NULL, 'agregar_sectores', 19, 20);
INSERT INTO acos VALUES (35, 1, NULL, NULL, 'Anios', 68, 81);
INSERT INTO acos VALUES (41, 35, NULL, NULL, 'isAuthorized2', 79, 80);
INSERT INTO acos VALUES (12, 10, NULL, NULL, 'deptoyloc', 21, 22);
INSERT INTO acos VALUES (79, 69, NULL, NULL, 'isAuthorized2', 155, 156);
INSERT INTO acos VALUES (13, 10, NULL, NULL, 'tipoinstits', 23, 24);
INSERT INTO acos VALUES (14, 10, NULL, NULL, 'sectores', 25, 26);
INSERT INTO acos VALUES (63, 62, NULL, NULL, 'index', 123, 124);
INSERT INTO acos VALUES (15, 10, NULL, NULL, 'clases_y_etp', 27, 28);
INSERT INTO acos VALUES (43, 42, NULL, NULL, 'index', 83, 84);
INSERT INTO acos VALUES (16, 10, NULL, NULL, 'sectores_por_sectores', 29, 30);
INSERT INTO acos VALUES (101, 95, NULL, NULL, 'isAuthorized2', 199, 200);
INSERT INTO acos VALUES (17, 10, NULL, NULL, 'depurar_similares', 31, 32);
INSERT INTO acos VALUES (44, 42, NULL, NULL, 'checked_instits', 85, 86);
INSERT INTO acos VALUES (18, 10, NULL, NULL, 'depurar_orientacion', 33, 34);
INSERT INTO acos VALUES (64, 62, NULL, NULL, 'view', 125, 126);
INSERT INTO acos VALUES (19, 10, NULL, NULL, 'depurar_titulos', 35, 36);
INSERT INTO acos VALUES (45, 42, NULL, NULL, 'error_report', 87, 88);
INSERT INTO acos VALUES (20, 10, NULL, NULL, 'isAuthorized2', 37, 38);
INSERT INTO acos VALUES (21, 10, NULL, NULL, 'add', 39, 40);
INSERT INTO acos VALUES (46, 42, NULL, NULL, 'error_report_cvs', 89, 90);
INSERT INTO acos VALUES (22, 10, NULL, NULL, 'edit', 41, 42);
INSERT INTO acos VALUES (65, 62, NULL, NULL, 'add', 127, 128);
INSERT INTO acos VALUES (23, 10, NULL, NULL, 'index', 43, 44);
INSERT INTO acos VALUES (47, 42, NULL, NULL, 'error_report_txt', 91, 92);
INSERT INTO acos VALUES (24, 10, NULL, NULL, 'view', 45, 46);
INSERT INTO acos VALUES (93, 87, NULL, NULL, 'dame_ciclos', 183, 184);
INSERT INTO acos VALUES (10, 1, NULL, NULL, 'Depuradores', 18, 49);
INSERT INTO acos VALUES (25, 10, NULL, NULL, 'delete', 47, 48);
INSERT INTO acos VALUES (81, 80, NULL, NULL, 'index', 159, 160);
INSERT INTO acos VALUES (48, 42, NULL, NULL, 'observacion_report', 93, 94);
INSERT INTO acos VALUES (66, 62, NULL, NULL, 'edit', 129, 130);
INSERT INTO acos VALUES (27, 26, NULL, NULL, 'index', 51, 52);
INSERT INTO acos VALUES (49, 42, NULL, NULL, 'view', 95, 96);
INSERT INTO acos VALUES (28, 26, NULL, NULL, 'view', 53, 54);
INSERT INTO acos VALUES (29, 26, NULL, NULL, 'add', 55, 56);
INSERT INTO acos VALUES (50, 42, NULL, NULL, 'edit', 97, 98);
INSERT INTO acos VALUES (30, 26, NULL, NULL, 'edit', 57, 58);
INSERT INTO acos VALUES (67, 62, NULL, NULL, 'delete', 131, 132);
INSERT INTO acos VALUES (31, 26, NULL, NULL, 'delete', 59, 60);
INSERT INTO acos VALUES (51, 42, NULL, NULL, 'edit_cue', 99, 100);
INSERT INTO acos VALUES (32, 26, NULL, NULL, 'listado', 61, 62);
INSERT INTO acos VALUES (108, 102, NULL, NULL, 'ajax_select_form_por_jurisdiccion', 213, 214);
INSERT INTO acos VALUES (33, 26, NULL, NULL, 'get_name', 63, 64);
INSERT INTO acos VALUES (62, 1, NULL, NULL, 'Logs', 122, 135);
INSERT INTO acos VALUES (26, 1, NULL, NULL, 'Jurisdicciones', 50, 67);
INSERT INTO acos VALUES (34, 26, NULL, NULL, 'isAuthorized2', 65, 66);
INSERT INTO acos VALUES (52, 42, NULL, NULL, 'search_instits', 101, 102);
INSERT INTO acos VALUES (68, 62, NULL, NULL, 'isAuthorized2', 133, 134);
INSERT INTO acos VALUES (82, 80, NULL, NULL, 'view', 161, 162);
INSERT INTO acos VALUES (53, 42, NULL, NULL, 'uncheckInstit', 103, 104);
INSERT INTO acos VALUES (87, 1, NULL, NULL, 'Ciclos', 172, 187);
INSERT INTO acos VALUES (54, 42, NULL, NULL, 'checkInstit', 105, 106);
INSERT INTO acos VALUES (94, 87, NULL, NULL, 'isAuthorized2', 185, 186);
INSERT INTO acos VALUES (70, 69, NULL, NULL, 'index', 137, 138);
INSERT INTO acos VALUES (55, 42, NULL, NULL, 'uncheckTotals', 107, 108);
INSERT INTO acos VALUES (83, 80, NULL, NULL, 'add', 163, 164);
INSERT INTO acos VALUES (56, 42, NULL, NULL, 'checkTotals', 109, 110);
INSERT INTO acos VALUES (71, 69, NULL, NULL, 'view', 139, 140);
INSERT INTO acos VALUES (57, 42, NULL, NULL, 'delete', 111, 112);
INSERT INTO acos VALUES (58, 42, NULL, NULL, 'validar_instits', 113, 114);
INSERT INTO acos VALUES (72, 69, NULL, NULL, 'add', 141, 142);
INSERT INTO acos VALUES (59, 42, NULL, NULL, 'validar_totales', 115, 116);
INSERT INTO acos VALUES (84, 80, NULL, NULL, 'edit', 165, 166);
INSERT INTO acos VALUES (73, 69, NULL, NULL, 'edit', 143, 144);
INSERT INTO acos VALUES (85, 80, NULL, NULL, 'delete', 167, 168);
INSERT INTO acos VALUES (74, 69, NULL, NULL, 'delete', 145, 146);
INSERT INTO acos VALUES (113, 111, NULL, NULL, 'add', 223, 224);
INSERT INTO acos VALUES (80, 1, NULL, NULL, 'Referentes', 158, 171);
INSERT INTO acos VALUES (75, 69, NULL, NULL, 'descargar_queries', 147, 148);
INSERT INTO acos VALUES (86, 80, NULL, NULL, 'isAuthorized2', 169, 170);
INSERT INTO acos VALUES (76, 69, NULL, NULL, 'contruye_excel', 149, 150);
INSERT INTO acos VALUES (96, 95, NULL, NULL, 'index', 189, 190);
INSERT INTO acos VALUES (77, 69, NULL, NULL, 'listado_categorias', 151, 152);
INSERT INTO acos VALUES (103, 102, NULL, NULL, 'index', 203, 204);
INSERT INTO acos VALUES (78, 69, NULL, NULL, 'list_view', 153, 154);
INSERT INTO acos VALUES (97, 95, NULL, NULL, 'view', 191, 192);
INSERT INTO acos VALUES (88, 87, NULL, NULL, 'index', 173, 174);
INSERT INTO acos VALUES (109, 102, NULL, NULL, 'get_name', 215, 216);
INSERT INTO acos VALUES (89, 87, NULL, NULL, 'view', 175, 176);
INSERT INTO acos VALUES (98, 95, NULL, NULL, 'add', 193, 194);
INSERT INTO acos VALUES (90, 87, NULL, NULL, 'add', 177, 178);
INSERT INTO acos VALUES (104, 102, NULL, NULL, 'view', 205, 206);
INSERT INTO acos VALUES (91, 87, NULL, NULL, 'edit', 179, 180);
INSERT INTO acos VALUES (102, 1, NULL, NULL, 'Tipoinstits', 202, 219);
INSERT INTO acos VALUES (99, 95, NULL, NULL, 'edit', 195, 196);
INSERT INTO acos VALUES (105, 102, NULL, NULL, 'add', 207, 208);
INSERT INTO acos VALUES (100, 95, NULL, NULL, 'delete', 197, 198);
INSERT INTO acos VALUES (110, 102, NULL, NULL, 'isAuthorized2', 217, 218);
INSERT INTO acos VALUES (95, 1, NULL, NULL, 'LineasDeAcciones', 188, 201);
INSERT INTO acos VALUES (119, 118, NULL, NULL, 'index', 235, 236);
INSERT INTO acos VALUES (106, 102, NULL, NULL, 'edit', 209, 210);
INSERT INTO acos VALUES (114, 111, NULL, NULL, 'edit', 225, 226);
INSERT INTO acos VALUES (107, 102, NULL, NULL, 'delete', 211, 212);
INSERT INTO acos VALUES (111, 1, NULL, NULL, 'EtpEstados', 220, 233);
INSERT INTO acos VALUES (117, 111, NULL, NULL, 'delete', 231, 232);
INSERT INTO acos VALUES (115, 111, NULL, NULL, 'index', 227, 228);
INSERT INTO acos VALUES (112, 111, NULL, NULL, 'isAuthorized2', 221, 222);
INSERT INTO acos VALUES (121, 118, NULL, NULL, 'add', 239, 240);
INSERT INTO acos VALUES (116, 111, NULL, NULL, 'view', 229, 230);
INSERT INTO acos VALUES (120, 118, NULL, NULL, 'view', 237, 238);
INSERT INTO acos VALUES (125, 118, NULL, NULL, 'isAuthorized2', 247, 248);
INSERT INTO acos VALUES (124, 118, NULL, NULL, 'ajax_select_subsector_form_por_sector', 245, 246);
INSERT INTO acos VALUES (122, 118, NULL, NULL, 'edit', 241, 242);
INSERT INTO acos VALUES (123, 118, NULL, NULL, 'delete', 243, 244);
INSERT INTO acos VALUES (127, 126, NULL, NULL, 'index', 251, 252);
INSERT INTO acos VALUES (118, 1, NULL, NULL, 'Subsectores', 234, 249);
INSERT INTO acos VALUES (128, 126, NULL, NULL, 'view', 253, 254);
INSERT INTO acos VALUES (129, 126, NULL, NULL, 'add', 255, 256);
INSERT INTO acos VALUES (130, 126, NULL, NULL, 'edit', 257, 258);
INSERT INTO acos VALUES (131, 126, NULL, NULL, 'delete', 259, 260);
INSERT INTO acos VALUES (132, 126, NULL, NULL, 'isAuthorized2', 261, 262);
INSERT INTO acos VALUES (126, 1, NULL, NULL, 'Gestiones', 250, 263);
INSERT INTO acos VALUES (134, 133, NULL, NULL, 'index_x_instit', 265, 266);
INSERT INTO acos VALUES (135, 133, NULL, NULL, 'index_x_jurisdiccion', 267, 268);
INSERT INTO acos VALUES (136, 133, NULL, NULL, 'index', 269, 270);
INSERT INTO acos VALUES (137, 133, NULL, NULL, 'add', 271, 272);
INSERT INTO acos VALUES (133, 1, NULL, NULL, 'Fondos', 264, 281);
INSERT INTO acos VALUES (173, 166, NULL, NULL, 'view', 343, 344);
INSERT INTO acos VALUES (138, 133, NULL, NULL, 'edit', 273, 274);
INSERT INTO acos VALUES (139, 133, NULL, NULL, 'delete', 275, 276);
INSERT INTO acos VALUES (249, 244, NULL, NULL, 'delete', 495, 496);
INSERT INTO acos VALUES (140, 133, NULL, NULL, 'isAuthorized2', 277, 278);
INSERT INTO acos VALUES (166, 1, NULL, NULL, 'Migraciones', 330, 347);
INSERT INTO acos VALUES (141, 133, NULL, NULL, 'view', 279, 280);
INSERT INTO acos VALUES (174, 166, NULL, NULL, 'delete', 345, 346);
INSERT INTO acos VALUES (198, 193, NULL, NULL, 'delete', 393, 394);
INSERT INTO acos VALUES (143, 142, NULL, NULL, 'index', 283, 284);
INSERT INTO acos VALUES (144, 142, NULL, NULL, 'view', 285, 286);
INSERT INTO acos VALUES (216, 211, NULL, NULL, 'edit', 429, 430);
INSERT INTO acos VALUES (176, 175, NULL, NULL, 'index', 349, 350);
INSERT INTO acos VALUES (145, 142, NULL, NULL, 'add', 287, 288);
INSERT INTO acos VALUES (193, 1, NULL, NULL, 'Planes', 384, 397);
INSERT INTO acos VALUES (146, 142, NULL, NULL, 'edit', 289, 290);
INSERT INTO acos VALUES (199, 193, NULL, NULL, 'isAuthorized2', 395, 396);
INSERT INTO acos VALUES (177, 175, NULL, NULL, 'view', 351, 352);
INSERT INTO acos VALUES (147, 142, NULL, NULL, 'delete', 291, 292);
INSERT INTO acos VALUES (142, 1, NULL, NULL, 'Dependencias', 282, 295);
INSERT INTO acos VALUES (148, 142, NULL, NULL, 'isAuthorized2', 293, 294);
INSERT INTO acos VALUES (178, 175, NULL, NULL, 'add', 353, 354);
INSERT INTO acos VALUES (150, 149, NULL, NULL, 'index', 297, 298);
INSERT INTO acos VALUES (151, 149, NULL, NULL, 'list_por_oferta_id', 299, 300);
INSERT INTO acos VALUES (179, 175, NULL, NULL, 'edit', 355, 356);
INSERT INTO acos VALUES (152, 149, NULL, NULL, 'view', 301, 302);
INSERT INTO acos VALUES (217, 211, NULL, NULL, 'delete', 431, 432);
INSERT INTO acos VALUES (153, 149, NULL, NULL, 'add_and_give_me_select_options', 303, 304);
INSERT INTO acos VALUES (180, 175, NULL, NULL, 'delete', 357, 358);
INSERT INTO acos VALUES (154, 149, NULL, NULL, 'add', 305, 306);
INSERT INTO acos VALUES (201, 200, NULL, NULL, 'buildAcos', 399, 400);
INSERT INTO acos VALUES (175, 1, NULL, NULL, 'Sectores', 348, 361);
INSERT INTO acos VALUES (155, 149, NULL, NULL, 'edit', 307, 308);
INSERT INTO acos VALUES (181, 175, NULL, NULL, 'isAuthorized2', 359, 360);
INSERT INTO acos VALUES (156, 149, NULL, NULL, 'delete', 309, 310);
INSERT INTO acos VALUES (149, 1, NULL, NULL, 'Titulos', 296, 313);
INSERT INTO acos VALUES (157, 149, NULL, NULL, 'isAuthorized2', 311, 312);
INSERT INTO acos VALUES (229, 228, NULL, NULL, 'index', 455, 456);
INSERT INTO acos VALUES (202, 200, NULL, NULL, 'buildAros', 401, 402);
INSERT INTO acos VALUES (159, 158, NULL, NULL, 'migrator', 315, 316);
INSERT INTO acos VALUES (183, 182, NULL, NULL, 'index', 363, 364);
INSERT INTO acos VALUES (160, 158, NULL, NULL, 'isAuthorized2', 317, 318);
INSERT INTO acos VALUES (161, 158, NULL, NULL, 'add', 319, 320);
INSERT INTO acos VALUES (184, 182, NULL, NULL, 'ver', 365, 366);
INSERT INTO acos VALUES (162, 158, NULL, NULL, 'edit', 321, 322);
INSERT INTO acos VALUES (218, 211, NULL, NULL, 'old_search_form', 433, 434);
INSERT INTO acos VALUES (203, 200, NULL, NULL, 'assignPermissions', 403, 404);
INSERT INTO acos VALUES (163, 158, NULL, NULL, 'index', 323, 324);
INSERT INTO acos VALUES (185, 182, NULL, NULL, 'view', 367, 368);
INSERT INTO acos VALUES (164, 158, NULL, NULL, 'view', 325, 326);
INSERT INTO acos VALUES (158, 1, NULL, NULL, 'ZFondoWorks', 314, 329);
INSERT INTO acos VALUES (165, 158, NULL, NULL, 'delete', 327, 328);
INSERT INTO acos VALUES (186, 182, NULL, NULL, 'add', 369, 370);
INSERT INTO acos VALUES (167, 166, NULL, NULL, 'actualizador', 331, 332);
INSERT INTO acos VALUES (204, 200, NULL, NULL, 'checkPermissions', 405, 406);
INSERT INTO acos VALUES (187, 182, NULL, NULL, 'edit', 371, 372);
INSERT INTO acos VALUES (168, 166, NULL, NULL, 'test', 333, 334);
INSERT INTO acos VALUES (169, 166, NULL, NULL, 'isAuthorized2', 335, 336);
INSERT INTO acos VALUES (238, 237, NULL, NULL, 'isAuthorized2', 473, 474);
INSERT INTO acos VALUES (188, 182, NULL, NULL, 'delete', 373, 374);
INSERT INTO acos VALUES (170, 166, NULL, NULL, 'add', 337, 338);
INSERT INTO acos VALUES (219, 211, NULL, NULL, 'search_form', 435, 436);
INSERT INTO acos VALUES (171, 166, NULL, NULL, 'edit', 339, 340);
INSERT INTO acos VALUES (205, 200, NULL, NULL, 'isAuthorized2', 407, 408);
INSERT INTO acos VALUES (189, 182, NULL, NULL, 'ajax_select_localidades_form_por_jurisdiccion', 375, 376);
INSERT INTO acos VALUES (172, 166, NULL, NULL, 'index', 341, 342);
INSERT INTO acos VALUES (230, 228, NULL, NULL, 'add', 457, 458);
INSERT INTO acos VALUES (206, 200, NULL, NULL, 'add', 409, 410);
INSERT INTO acos VALUES (190, 182, NULL, NULL, 'ajax_select_localidades_form_por_departamento', 377, 378);
INSERT INTO acos VALUES (191, 182, NULL, NULL, 'ajax_search_localidades', 379, 380);
INSERT INTO acos VALUES (220, 211, NULL, NULL, 'advanced_search_form', 437, 438);
INSERT INTO acos VALUES (182, 1, NULL, NULL, 'Localidades', 362, 383);
INSERT INTO acos VALUES (192, 182, NULL, NULL, 'isAuthorized2', 381, 382);
INSERT INTO acos VALUES (207, 200, NULL, NULL, 'edit', 411, 412);
INSERT INTO acos VALUES (194, 193, NULL, NULL, 'index', 385, 386);
INSERT INTO acos VALUES (208, 200, NULL, NULL, 'index', 413, 414);
INSERT INTO acos VALUES (195, 193, NULL, NULL, 'view', 387, 388);
INSERT INTO acos VALUES (221, 211, NULL, NULL, 'simpleSearch', 439, 440);
INSERT INTO acos VALUES (196, 193, NULL, NULL, 'add', 389, 390);
INSERT INTO acos VALUES (231, 228, NULL, NULL, 'edit', 459, 460);
INSERT INTO acos VALUES (197, 193, NULL, NULL, 'edit', 391, 392);
INSERT INTO acos VALUES (209, 200, NULL, NULL, 'view', 415, 416);
INSERT INTO acos VALUES (200, 1, NULL, NULL, 'Aclprep', 398, 419);
INSERT INTO acos VALUES (210, 200, NULL, NULL, 'delete', 417, 418);
INSERT INTO acos VALUES (222, 211, NULL, NULL, 'search', 441, 442);
INSERT INTO acos VALUES (255, 253, NULL, NULL, 'view', 507, 508);
INSERT INTO acos VALUES (239, 237, NULL, NULL, 'add', 475, 476);
INSERT INTO acos VALUES (212, 211, NULL, NULL, 'test', 421, 422);
INSERT INTO acos VALUES (223, 211, NULL, NULL, 'ajax_search', 443, 444);
INSERT INTO acos VALUES (213, 211, NULL, NULL, 'index', 423, 424);
INSERT INTO acos VALUES (232, 228, NULL, NULL, 'delete', 461, 462);
INSERT INTO acos VALUES (214, 211, NULL, NULL, 'view', 425, 426);
INSERT INTO acos VALUES (245, 244, NULL, NULL, 'index', 487, 488);
INSERT INTO acos VALUES (215, 211, NULL, NULL, 'add', 427, 428);
INSERT INTO acos VALUES (224, 211, NULL, NULL, 'planes_relacionados', 445, 446);
INSERT INTO acos VALUES (233, 228, NULL, NULL, 'search_form', 463, 464);
INSERT INTO acos VALUES (225, 211, NULL, NULL, 'depurar', 447, 448);
INSERT INTO acos VALUES (240, 237, NULL, NULL, 'edit', 477, 478);
INSERT INTO acos VALUES (226, 211, NULL, NULL, 'prueba', 449, 450);
INSERT INTO acos VALUES (234, 228, NULL, NULL, 'search', 465, 466);
INSERT INTO acos VALUES (211, 1, NULL, NULL, 'Instits', 420, 453);
INSERT INTO acos VALUES (227, 211, NULL, NULL, 'isAuthorized2', 451, 452);
INSERT INTO acos VALUES (250, 244, NULL, NULL, 'dame_nombre', 497, 498);
INSERT INTO acos VALUES (235, 228, NULL, NULL, 'isAuthorized2', 467, 468);
INSERT INTO acos VALUES (228, 1, NULL, NULL, 'HistorialCues', 454, 471);
INSERT INTO acos VALUES (241, 237, NULL, NULL, 'index', 479, 480);
INSERT INTO acos VALUES (236, 228, NULL, NULL, 'view', 469, 470);
INSERT INTO acos VALUES (246, 244, NULL, NULL, 'view', 489, 490);
INSERT INTO acos VALUES (242, 237, NULL, NULL, 'view', 481, 482);
INSERT INTO acos VALUES (237, 1, NULL, NULL, 'Claseinstits', 472, 485);
INSERT INTO acos VALUES (243, 237, NULL, NULL, 'delete', 483, 484);
INSERT INTO acos VALUES (251, 244, NULL, NULL, 'dame_abrev', 499, 500);
INSERT INTO acos VALUES (247, 244, NULL, NULL, 'add', 491, 492);
INSERT INTO acos VALUES (257, 253, NULL, NULL, 'edit', 511, 512);
INSERT INTO acos VALUES (248, 244, NULL, NULL, 'edit', 493, 494);
INSERT INTO acos VALUES (256, 253, NULL, NULL, 'add', 509, 510);
INSERT INTO acos VALUES (244, 1, NULL, NULL, 'Ofertas', 486, 503);
INSERT INTO acos VALUES (252, 244, NULL, NULL, 'isAuthorized2', 501, 502);
INSERT INTO acos VALUES (254, 253, NULL, NULL, 'listadoUsuarios', 505, 506);
INSERT INTO acos VALUES (261, 253, NULL, NULL, 'self_user_edit', 519, 520);
INSERT INTO acos VALUES (260, 253, NULL, NULL, 'logout', 517, 518);
INSERT INTO acos VALUES (258, 253, NULL, NULL, 'delete', 513, 514);
INSERT INTO acos VALUES (259, 253, NULL, NULL, 'login', 515, 516);
INSERT INTO acos VALUES (262, 253, NULL, NULL, 'cambiar_password', 521, 522);
INSERT INTO acos VALUES (263, 253, NULL, NULL, 'isAuthorized2', 523, 524);
INSERT INTO acos VALUES (264, 253, NULL, NULL, 'index', 525, 526);
INSERT INTO acos VALUES (266, 265, NULL, NULL, 'index', 529, 530);
INSERT INTO acos VALUES (253, 1, NULL, NULL, 'Users', 504, 527);
INSERT INTO acos VALUES (267, 265, NULL, NULL, 'view', 531, 532);
INSERT INTO acos VALUES (268, 265, NULL, NULL, 'add', 533, 534);
INSERT INTO acos VALUES (269, 265, NULL, NULL, 'edit', 535, 536);
INSERT INTO acos VALUES (270, 265, NULL, NULL, 'delete', 537, 538);
INSERT INTO acos VALUES (271, 265, NULL, NULL, 'provincias_pendientes', 539, 540);
INSERT INTO acos VALUES (272, 265, NULL, NULL, 'isAuthorized2', 541, 542);
INSERT INTO acos VALUES (265, 1, NULL, NULL, 'Tickets', 528, 543);
INSERT INTO acos VALUES (274, 273, NULL, NULL, 'total_instits_por_ambito_de_gestion', 545, 546);
INSERT INTO acos VALUES (358, 352, NULL, NULL, 'test', 712, 713);
INSERT INTO acos VALUES (275, 273, NULL, NULL, 'total_instits_por_tipo_de_etp', 547, 548);
INSERT INTO acos VALUES (309, 305, NULL, NULL, 'add', 615, 616);
INSERT INTO acos VALUES (276, 273, NULL, NULL, 'isAuthorized2', 549, 550);
INSERT INTO acos VALUES (332, 325, NULL, NULL, 'isAuthorized2', 660, 661);
INSERT INTO acos VALUES (277, 273, NULL, NULL, 'add', 551, 552);
INSERT INTO acos VALUES (310, 305, NULL, NULL, 'edit', 617, 618);
INSERT INTO acos VALUES (278, 273, NULL, NULL, 'edit', 553, 554);
INSERT INTO acos VALUES (279, 273, NULL, NULL, 'index', 555, 556);
INSERT INTO acos VALUES (311, 305, NULL, NULL, 'delete', 619, 620);
INSERT INTO acos VALUES (280, 273, NULL, NULL, 'view', 557, 558);
INSERT INTO acos VALUES (273, 1, NULL, NULL, 'Cuadros', 544, 561);
INSERT INTO acos VALUES (347, 338, NULL, NULL, 'add', 690, 691);
INSERT INTO acos VALUES (281, 273, NULL, NULL, 'delete', 559, 560);
INSERT INTO acos VALUES (312, 305, NULL, NULL, 'ajax_select_departamento_form_por_jurisdiccion', 621, 622);
INSERT INTO acos VALUES (333, 325, NULL, NULL, 'add', 662, 663);
INSERT INTO acos VALUES (283, 282, NULL, NULL, 'index', 563, 564);
INSERT INTO acos VALUES (313, 305, NULL, NULL, 'ajax_buscar_departamento', 623, 624);
INSERT INTO acos VALUES (284, 282, NULL, NULL, 'view', 565, 566);
INSERT INTO acos VALUES (285, 282, NULL, NULL, 'add', 567, 568);
INSERT INTO acos VALUES (314, 305, NULL, NULL, 'search_departamentos', 625, 626);
INSERT INTO acos VALUES (286, 282, NULL, NULL, 'edit', 569, 570);
INSERT INTO acos VALUES (359, 352, NULL, NULL, 'success', 714, 715);
INSERT INTO acos VALUES (287, 282, NULL, NULL, 'delete', 571, 572);
INSERT INTO acos VALUES (305, 1, NULL, NULL, 'Departamentos', 608, 629);
INSERT INTO acos VALUES (315, 305, NULL, NULL, 'isAuthorized2', 627, 628);
INSERT INTO acos VALUES (288, 282, NULL, NULL, 'tipodoc_nombre', 573, 574);
INSERT INTO acos VALUES (334, 325, NULL, NULL, 'edit', 664, 665);
INSERT INTO acos VALUES (289, 282, NULL, NULL, 'dame_tipodocs', 575, 576);
INSERT INTO acos VALUES (282, 1, NULL, NULL, 'Tipodocs', 562, 579);
INSERT INTO acos VALUES (290, 282, NULL, NULL, 'isAuthorized2', 577, 578);
INSERT INTO acos VALUES (348, 338, NULL, NULL, 'edit', 692, 693);
INSERT INTO acos VALUES (317, 316, NULL, NULL, 'index', 631, 632);
INSERT INTO acos VALUES (292, 291, NULL, NULL, 'index', 581, 582);
INSERT INTO acos VALUES (293, 291, NULL, NULL, 'view', 583, 584);
INSERT INTO acos VALUES (335, 325, NULL, NULL, 'index', 666, 667);
INSERT INTO acos VALUES (318, 316, NULL, NULL, 'view', 633, 634);
INSERT INTO acos VALUES (294, 291, NULL, NULL, 'add', 585, 586);
INSERT INTO acos VALUES (295, 291, NULL, NULL, 'edit', 587, 588);
INSERT INTO acos VALUES (368, 365, NULL, NULL, 'children', 732, 733);
INSERT INTO acos VALUES (319, 316, NULL, NULL, 'add', 635, 636);
INSERT INTO acos VALUES (296, 291, NULL, NULL, 'delete', 589, 590);
INSERT INTO acos VALUES (291, 1, NULL, NULL, 'FondosLineasDeAcciones', 580, 593);
INSERT INTO acos VALUES (297, 291, NULL, NULL, 'isAuthorized2', 591, 592);
INSERT INTO acos VALUES (349, 338, NULL, NULL, 'index', 694, 695);
INSERT INTO acos VALUES (320, 316, NULL, NULL, 'edit', 637, 638);
INSERT INTO acos VALUES (299, 298, NULL, NULL, 'index', 595, 596);
INSERT INTO acos VALUES (336, 325, NULL, NULL, 'view', 668, 669);
INSERT INTO acos VALUES (300, 298, NULL, NULL, 'view', 597, 598);
INSERT INTO acos VALUES (321, 316, NULL, NULL, 'delete', 639, 640);
INSERT INTO acos VALUES (301, 298, NULL, NULL, 'add', 599, 600);
INSERT INTO acos VALUES (375, 365, NULL, NULL, 'index', 746, 747);
INSERT INTO acos VALUES (302, 298, NULL, NULL, 'edit', 601, 602);
INSERT INTO acos VALUES (322, 316, NULL, NULL, 'dame_nombre', 641, 642);
INSERT INTO acos VALUES (303, 298, NULL, NULL, 'delete', 603, 604);
INSERT INTO acos VALUES (325, 324, NULL, NULL, 'Acl', 647, 672);
INSERT INTO acos VALUES (298, 1, NULL, NULL, 'Orientaciones', 594, 607);
INSERT INTO acos VALUES (304, 298, NULL, NULL, 'isAuthorized2', 605, 606);
INSERT INTO acos VALUES (316, 1, NULL, NULL, 'Etapas', 630, 645);
INSERT INTO acos VALUES (323, 316, NULL, NULL, 'isAuthorized2', 643, 644);
INSERT INTO acos VALUES (337, 325, NULL, NULL, 'delete', 670, 671);
INSERT INTO acos VALUES (306, 305, NULL, NULL, 'index', 609, 610);
INSERT INTO acos VALUES (307, 305, NULL, NULL, 'ver', 611, 612);
INSERT INTO acos VALUES (360, 352, NULL, NULL, 'failure', 716, 717);
INSERT INTO acos VALUES (308, 305, NULL, NULL, 'view', 613, 614);
INSERT INTO acos VALUES (350, 338, NULL, NULL, 'view', 696, 697);
INSERT INTO acos VALUES (1, NULL, NULL, NULL, 'controllers', 1, 752);
INSERT INTO acos VALUES (339, 338, NULL, NULL, 'exists', 674, 675);
INSERT INTO acos VALUES (326, 325, NULL, NULL, 'admin_index', 648, 649);
INSERT INTO acos VALUES (338, 324, NULL, NULL, 'AclPermissions', 673, 700);
INSERT INTO acos VALUES (351, 338, NULL, NULL, 'delete', 698, 699);
INSERT INTO acos VALUES (327, 325, NULL, NULL, 'admin_aros', 650, 651);
INSERT INTO acos VALUES (340, 338, NULL, NULL, 'create', 676, 677);
INSERT INTO acos VALUES (328, 325, NULL, NULL, 'admin_acos', 652, 653);
INSERT INTO acos VALUES (369, 365, NULL, NULL, 'add', 734, 735);
INSERT INTO acos VALUES (361, 352, NULL, NULL, 'isAuthorized2', 718, 719);
INSERT INTO acos VALUES (329, 325, NULL, NULL, 'admin_permissions', 654, 655);
INSERT INTO acos VALUES (341, 338, NULL, NULL, 'aros', 678, 679);
INSERT INTO acos VALUES (330, 325, NULL, NULL, 'success', 656, 657);
INSERT INTO acos VALUES (324, 1, NULL, NULL, 'Acl', 646, 751);
INSERT INTO acos VALUES (365, 324, NULL, NULL, 'AclAcos', 727, 750);
INSERT INTO acos VALUES (331, 325, NULL, NULL, 'failure', 658, 659);
INSERT INTO acos VALUES (353, 352, NULL, NULL, 'load', 702, 703);
INSERT INTO acos VALUES (342, 338, NULL, NULL, 'acos', 680, 681);
INSERT INTO acos VALUES (362, 352, NULL, NULL, 'edit', 720, 721);
INSERT INTO acos VALUES (376, 365, NULL, NULL, 'view', 748, 749);
INSERT INTO acos VALUES (343, 338, NULL, NULL, 'revoke', 682, 683);
INSERT INTO acos VALUES (354, 352, NULL, NULL, 'delete', 704, 705);
INSERT INTO acos VALUES (370, 365, NULL, NULL, 'update', 736, 737);
INSERT INTO acos VALUES (344, 338, NULL, NULL, 'success', 684, 685);
INSERT INTO acos VALUES (363, 352, NULL, NULL, 'index', 722, 723);
INSERT INTO acos VALUES (355, 352, NULL, NULL, 'children', 706, 707);
INSERT INTO acos VALUES (345, 338, NULL, NULL, 'failure', 686, 687);
INSERT INTO acos VALUES (346, 338, NULL, NULL, 'isAuthorized2', 688, 689);
INSERT INTO acos VALUES (352, 324, NULL, NULL, 'AclAros', 701, 726);
INSERT INTO acos VALUES (364, 352, NULL, NULL, 'view', 724, 725);
INSERT INTO acos VALUES (356, 352, NULL, NULL, 'add', 708, 709);
INSERT INTO acos VALUES (371, 365, NULL, NULL, 'success', 738, 739);
INSERT INTO acos VALUES (357, 352, NULL, NULL, 'update', 710, 711);
INSERT INTO acos VALUES (372, 365, NULL, NULL, 'failure', 740, 741);
INSERT INTO acos VALUES (366, 365, NULL, NULL, 'load', 728, 729);
INSERT INTO acos VALUES (367, 365, NULL, NULL, 'delete', 730, 731);
INSERT INTO acos VALUES (373, 365, NULL, NULL, 'isAuthorized2', 742, 743);
INSERT INTO acos VALUES (374, 365, NULL, NULL, 'edit', 744, 745);


--
-- Name: acos_pkey; Type: CONSTRAINT; Schema: public; Owner: www; Tablespace: 
--

ALTER TABLE ONLY acos
    ADD CONSTRAINT acos_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

--
-- PostgreSQL database dump
--

SET client_encoding = 'LATIN1';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: aros; Type: TABLE; Schema: public; Owner: www; Tablespace: 
--

CREATE TABLE aros (
    id integer NOT NULL,
    parent_id integer,
    model character varying(255) DEFAULT ''::character varying,
    foreign_key integer,
    alias character varying(255) DEFAULT ''::character varying,
    lft integer,
    rght integer
);


ALTER TABLE public.aros OWNER TO www;

--
-- Name: aros_id_seq; Type: SEQUENCE; Schema: public; Owner: www
--

CREATE SEQUENCE aros_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.aros_id_seq OWNER TO www;

--
-- Name: aros_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: www
--

ALTER SEQUENCE aros_id_seq OWNED BY aros.id;


--
-- Name: aros_id_seq; Type: SEQUENCE SET; Schema: public; Owner: www
--

SELECT pg_catalog.setval('aros_id_seq', 91, true);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: www
--

ALTER TABLE aros ALTER COLUMN id SET DEFAULT nextval('aros_id_seq'::regclass);


--
-- Data for Name: aros; Type: TABLE DATA; Schema: public; Owner: www
--

INSERT INTO aros VALUES (17, 2, 'User', 118, 'hvalle', 3, 4);
INSERT INTO aros VALUES (1, NULL, '', NULL, 'usuarios', 1, 182);
INSERT INTO aros VALUES (54, 2, 'User', 57, 'avilar', 5, 6);
INSERT INTO aros VALUES (2, 1, '', NULL, 'desarrolladores', 2, 13);
INSERT INTO aros VALUES (43, 4, 'User', 64, 'jpirillo', 23, 24);
INSERT INTO aros VALUES (44, 4, 'User', 69, 'pgerez', 25, 26);
INSERT INTO aros VALUES (3, 1, '', NULL, 'administradores', 14, 19);
INSERT INTO aros VALUES (7, 4, 'User', 67, 'asanchez', 21, 22);
INSERT INTO aros VALUES (31, 3, 'User', 62, 'amakon', 17, 18);
INSERT INTO aros VALUES (45, 5, 'User', 122, 'graciela', 95, 96);
INSERT INTO aros VALUES (46, 5, 'User', 123, 'proyectocatalogo', 97, 98);
INSERT INTO aros VALUES (47, 5, 'User', 97, 'avilarconsulta', 99, 100);
INSERT INTO aros VALUES (48, 5, 'User', 59, 'mgarcia', 101, 102);
INSERT INTO aros VALUES (49, 5, 'User', 112, 'jsanchez', 103, 104);
INSERT INTO aros VALUES (41, 5, 'User', 107, 'peltzer', 91, 92);
INSERT INTO aros VALUES (18, 5, 'User', 84, 'mfrankel', 47, 48);
INSERT INTO aros VALUES (19, 5, 'User', 74, 'vsanchez', 49, 50);
INSERT INTO aros VALUES (20, 5, 'User', 65, 'mmartinez', 51, 52);
INSERT INTO aros VALUES (21, 5, 'User', 114, 'obracchetti', 53, 54);
INSERT INTO aros VALUES (22, 5, 'User', 120, 'gcarrasco', 55, 56);
INSERT INTO aros VALUES (23, 5, 'User', 63, 'cmarzioni', 57, 58);
INSERT INTO aros VALUES (24, 5, 'User', 76, 'dszlechter', 59, 60);
INSERT INTO aros VALUES (25, 5, 'User', 86, 'algacio', 61, 62);
INSERT INTO aros VALUES (26, 5, 'User', 115, 'mdavila', 63, 64);
INSERT INTO aros VALUES (27, 5, 'User', 81, 'efontenla', 65, 66);
INSERT INTO aros VALUES (28, 5, 'User', 75, 'castrefezza', 67, 68);
INSERT INTO aros VALUES (29, 5, 'User', 82, 'aalvarez', 69, 70);
INSERT INTO aros VALUES (30, 5, 'User', 83, 'afrankel', 71, 72);
INSERT INTO aros VALUES (8, 5, 'User', 103, 'mgomez', 31, 32);
INSERT INTO aros VALUES (73, 4, 'User', 135, 'avilareditor', 27, 28);
INSERT INTO aros VALUES (13, 3, 'User', 72, 'rmartinez', 15, 16);
INSERT INTO aros VALUES (4, 1, '', NULL, 'editores', 20, 29);
INSERT INTO aros VALUES (10, 5, 'User', 89, 'jbarbacci', 35, 36);
INSERT INTO aros VALUES (11, 5, 'User', 77, 'atapia', 37, 38);
INSERT INTO aros VALUES (12, 5, 'User', 106, 'nilda', 39, 40);
INSERT INTO aros VALUES (14, 5, 'User', 80, 'calfonso', 41, 42);
INSERT INTO aros VALUES (15, 5, 'User', 96, 'mfederico', 43, 44);
INSERT INTO aros VALUES (16, 5, 'User', 116, 'nbuks', 45, 46);
INSERT INTO aros VALUES (42, 5, 'User', 105, 'rdiaz', 93, 94);
INSERT INTO aros VALUES (32, 5, 'User', 87, 'vparisi', 73, 74);
INSERT INTO aros VALUES (33, 5, 'User', 66, 'lmazzota', 75, 76);
INSERT INTO aros VALUES (34, 5, 'User', 79, 'pfinkelberg', 77, 78);
INSERT INTO aros VALUES (35, 5, 'User', 71, 'mmutti', 79, 80);
INSERT INTO aros VALUES (36, 5, 'User', 90, 'ibarnij', 81, 82);
INSERT INTO aros VALUES (37, 5, 'User', 85, 'agacio', 83, 84);
INSERT INTO aros VALUES (83, 2, 'User', 129, 'romanmussi', 7, 8);
INSERT INTO aros VALUES (87, 2, 'User', 153, 'pbrudnick', 9, 10);
INSERT INTO aros VALUES (88, 2, 'User', 152, 'hgigena', 11, 12);
INSERT INTO aros VALUES (5, 1, '', NULL, 'invitados', 30, 179);
INSERT INTO aros VALUES (6, 1, '', NULL, 'referentes', 180, 181);
INSERT INTO aros VALUES (38, 5, 'User', 111, 'pcaruso', 85, 86);
INSERT INTO aros VALUES (50, 5, 'User', 92, 'fcabana', 105, 106);
INSERT INTO aros VALUES (39, 5, 'User', 68, 'smigliorisi', 87, 88);
INSERT INTO aros VALUES (40, 5, 'User', 94, 'ccorazza', 89, 90);
INSERT INTO aros VALUES (51, 5, 'User', 113, 'vbarreda', 107, 108);
INSERT INTO aros VALUES (52, 5, 'User', 110, 'lliguori', 109, 110);
INSERT INTO aros VALUES (53, 5, 'User', 93, 'gcanzani', 111, 112);
INSERT INTO aros VALUES (69, 5, 'User', 131, 'ogrillo', 141, 142);
INSERT INTO aros VALUES (55, 5, 'User', 125, 'imalamud', 113, 114);
INSERT INTO aros VALUES (56, 5, 'User', 60, 'mngarcia', 115, 116);
INSERT INTO aros VALUES (9, 5, 'User', 104, 'rdiaz', 33, 34);
INSERT INTO aros VALUES (84, 5, 'User', 149, 'apodeley', 167, 168);
INSERT INTO aros VALUES (85, 5, 'User', 150, 'gcoscarella', 169, 170);
INSERT INTO aros VALUES (86, 5, 'User', 151, 'gcorti', 171, 172);
INSERT INTO aros VALUES (70, 5, 'User', 132, 'soltriano', 143, 144);
INSERT INTO aros VALUES (57, 5, 'User', 127, 'mtysco', 117, 118);
INSERT INTO aros VALUES (58, 5, 'User', 95, 'jjcosentino', 119, 120);
INSERT INTO aros VALUES (71, 5, 'User', 133, 'prosa', 145, 146);
INSERT INTO aros VALUES (59, 5, 'User', 73, 'mpelegrino', 121, 122);
INSERT INTO aros VALUES (72, 5, 'User', 119, 'cgutierrez', 147, 148);
INSERT INTO aros VALUES (60, 5, 'User', 108, 'sbraumuller', 123, 124);
INSERT INTO aros VALUES (61, 5, 'User', 61, 'tghilarducci', 125, 126);
INSERT INTO aros VALUES (62, 5, 'User', 109, 'mralmandoz', 127, 128);
INSERT INTO aros VALUES (63, 5, 'User', 121, 'azucena', 129, 130);
INSERT INTO aros VALUES (64, 5, 'User', 128, 'mtomaselli', 131, 132);
INSERT INTO aros VALUES (65, 5, 'User', 70, 'jmomeño', 133, 134);
INSERT INTO aros VALUES (66, 5, 'User', 91, 'gbramuglia', 135, 136);
INSERT INTO aros VALUES (67, 5, 'User', 58, 'nicokiva', 137, 138);
INSERT INTO aros VALUES (68, 5, 'User', 130, 'aobarrio', 139, 140);
INSERT INTO aros VALUES (74, 5, 'User', 136, 'imonzani', 149, 150);
INSERT INTO aros VALUES (75, 5, 'User', 124, 'cramunno', 151, 152);
INSERT INTO aros VALUES (76, 5, 'User', 137, 'cdcaputo', 153, 154);
INSERT INTO aros VALUES (77, 5, 'User', 143, 'emargiotta', 155, 156);
INSERT INTO aros VALUES (78, 5, 'User', 126, 'mtysco', 157, 158);
INSERT INTO aros VALUES (80, 5, 'User', 147, 'egresados', 161, 162);
INSERT INTO aros VALUES (79, 5, 'User', 146, 'romanconsulta', 159, 160);
INSERT INTO aros VALUES (81, 5, 'User', 134, 'grodriguez', 163, 164);
INSERT INTO aros VALUES (82, 5, 'User', 88, 'agaray', 165, 166);
INSERT INTO aros VALUES (89, 5, 'User', 117, 'ofalabella', 173, 174);
INSERT INTO aros VALUES (90, 5, 'User', 138, 'vbravo', 175, 176);
INSERT INTO aros VALUES (91, 5, 'User', 154, 'mpereyra', 177, 178);


--
-- Name: aros_pkey; Type: CONSTRAINT; Schema: public; Owner: www; Tablespace: 
--

ALTER TABLE ONLY aros
    ADD CONSTRAINT aros_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

--
-- PostgreSQL database dump
--

SET client_encoding = 'LATIN1';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: aros_acos; Type: TABLE; Schema: public; Owner: www; Tablespace: 
--

CREATE TABLE aros_acos (
    id integer NOT NULL,
    aro_id integer NOT NULL,
    aco_id integer NOT NULL,
    _create character(2) DEFAULT 0 NOT NULL,
    _read character(2) DEFAULT 0 NOT NULL,
    _update character(2) DEFAULT 0 NOT NULL,
    _delete character(2) DEFAULT 0 NOT NULL
);


ALTER TABLE public.aros_acos OWNER TO www;

--
-- Name: aros_acos_id_seq; Type: SEQUENCE; Schema: public; Owner: www
--

CREATE SEQUENCE aros_acos_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.aros_acos_id_seq OWNER TO www;

--
-- Name: aros_acos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: www
--

ALTER SEQUENCE aros_acos_id_seq OWNED BY aros_acos.id;


--
-- Name: aros_acos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: www
--

SELECT pg_catalog.setval('aros_acos_id_seq', 62, true);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: www
--

ALTER TABLE aros_acos ALTER COLUMN id SET DEFAULT nextval('aros_acos_id_seq'::regclass);


--
-- Data for Name: aros_acos; Type: TABLE DATA; Schema: public; Owner: www
--

INSERT INTO aros_acos VALUES (1, 2, 1, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (2, 3, 1, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (3, 3, 136, '-1', '-1', '-1', '-1');
INSERT INTO aros_acos VALUES (4, 3, 42, '-1', '-1', '-1', '-1');
INSERT INTO aros_acos VALUES (5, 3, 256, '-1', '-1', '-1', '-1');
INSERT INTO aros_acos VALUES (6, 3, 257, '-1', '-1', '-1', '-1');
INSERT INTO aros_acos VALUES (7, 3, 258, '-1', '-1', '-1', '-1');
INSERT INTO aros_acos VALUES (8, 3, 325, '-1', '-1', '-1', '-1');
INSERT INTO aros_acos VALUES (9, 3, 200, '-1', '-1', '-1', '-1');
INSERT INTO aros_acos VALUES (10, 4, 215, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (11, 4, 216, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (12, 4, 224, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (13, 4, 225, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (14, 4, 196, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (15, 4, 197, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (16, 4, 198, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (17, 4, 38, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (18, 4, 39, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (19, 4, 40, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (20, 4, 75, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (21, 4, 76, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (22, 4, 78, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (23, 4, 10, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (24, 4, 175, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (25, 4, 268, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (26, 4, 269, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (27, 4, 271, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (28, 4, 149, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (29, 1, 222, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (30, 1, 223, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (31, 1, 219, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (32, 1, 218, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (33, 1, 220, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (34, 1, 214, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (35, 1, 194, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (36, 1, 195, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (37, 1, 233, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (38, 1, 234, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (39, 1, 266, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (40, 1, 267, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (41, 1, 262, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (42, 1, 261, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (43, 1, 134, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (44, 1, 135, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (45, 1, 273, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (46, 1, 93, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (47, 1, 322, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (48, 1, 33, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (49, 1, 32, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (50, 1, 28, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (51, 1, 250, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (52, 1, 251, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (53, 1, 288, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (54, 1, 289, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (55, 1, 109, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (56, 1, 108, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (57, 1, 312, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (58, 1, 190, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (59, 1, 189, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (60, 1, 191, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (61, 1, 124, '1 ', '1 ', '1 ', '1 ');
INSERT INTO aros_acos VALUES (62, 1, 153, '1 ', '1 ', '1 ', '1 ');


--
-- Name: aros_acos_pkey; Type: CONSTRAINT; Schema: public; Owner: www; Tablespace: 
--

ALTER TABLE ONLY aros_acos
    ADD CONSTRAINT aros_acos_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--


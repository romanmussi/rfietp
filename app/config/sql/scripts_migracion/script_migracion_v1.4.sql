CREATE TABLE orientaciones (
    id integer NOT NULL PRIMARY KEY,
    name character varying(100) DEFAULT ''::character varying NOT NULL
);



ALTER TABLE public.orientaciones OWNER TO www;

--
-- Name: orientaciones_id_seq; Type: SEQUENCE; Schema: public; Owner: www
--

CREATE SEQUENCE orientaciones_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.orientaciones_id_seq OWNER TO www;

--
-- Name: orientaciones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: www
--

ALTER SEQUENCE orientaciones_id_seq OWNED BY orientaciones.id;


--
-- Name: orientaciones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: www
--

SELECT pg_catalog.setval('orientaciones_id_seq', 3, true);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: www
--

ALTER TABLE orientaciones ALTER COLUMN id SET DEFAULT nextval('orientaciones_id_seq'::regclass);


--
-- Data for Name: orientaciones; Type: TABLE DATA; Schema: public; Owner: www
--

INSERT INTO orientaciones VALUES (1, 'AGROPECUARIA');
INSERT INTO orientaciones VALUES (2, 'INDUSTRIAL');
INSERT INTO orientaciones VALUES (3, 'OTROS');

ALTER TABLE instits  ADD COLUMN orientacion_id integer NOT NULL DEFAULT 0;
ALTER TABLE sectores  ADD COLUMN orientacion_id integer NOT NULL DEFAULT 0;


UPDATE sectores SET orientacion_id = 0 WHERE id = 5;
UPDATE sectores SET orientacion_id = 0 WHERE id = 38;
UPDATE sectores SET orientacion_id = 0 WHERE id = 39;
UPDATE sectores SET orientacion_id = 3 WHERE id = 4;
UPDATE sectores SET orientacion_id = 1 WHERE id = 3;
UPDATE sectores SET orientacion_id = 3 WHERE id = 1;

UPDATE sectores SET orientacion_id = 2 WHERE id = 2;
UPDATE sectores SET orientacion_id = 2 WHERE id = 6;
UPDATE sectores SET orientacion_id = 2 WHERE id = 7;
UPDATE sectores SET orientacion_id = 2 WHERE id = 11;
UPDATE sectores SET orientacion_id = 2 WHERE id = 9;
UPDATE sectores SET orientacion_id = 2 WHERE id = 12;

UPDATE sectores SET orientacion_id = 3 WHERE id = 14;
UPDATE sectores SET orientacion_id = 2 WHERE id = 15;
UPDATE sectores SET orientacion_id = 3 WHERE id = 16;
UPDATE sectores SET orientacion_id = 2 WHERE id = 17;
UPDATE sectores SET orientacion_id = 2 WHERE id = 20;

UPDATE sectores SET orientacion_id = 2 WHERE id = 18;
UPDATE sectores SET orientacion_id = 3 WHERE id = 25;
UPDATE sectores SET orientacion_id = 3 WHERE id = 24;
UPDATE sectores SET orientacion_id = 3 WHERE id = 30;
UPDATE sectores SET orientacion_id = 2 WHERE id = 31;

UPDATE sectores SET orientacion_id = 3 WHERE id = 33;
UPDATE sectores SET orientacion_id = 3 WHERE id = 34;
UPDATE sectores SET orientacion_id = 2 WHERE id = 19;
UPDATE sectores SET orientacion_id = 3 WHERE id = 37;

UPDATE sectores SET orientacion_id = 3 WHERE id = 10;
UPDATE sectores SET orientacion_id = 3 WHERE id = 27;
UPDATE sectores SET orientacion_id = 2 WHERE id = 8;
UPDATE sectores SET orientacion_id = 1 WHERE id = 22;


--
-- PostgreSQL database dump
--

SET client_encoding = 'LATIN1';
--
-- Name: titulos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--


CREATE TABLE titulos (
    id integer NOT NULL PRIMARY KEY,
    name character varying(200) NOT NULL,
    marco_ref boolean DEFAULT false NOT NULL,
    oferta_id integer NOT NULL
);

CREATE SEQUENCE titulos_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
    
ALTER SEQUENCE titulos_id_seq OWNED BY titulos.id;
SELECT pg_catalog.setval('titulos_id_seq', 34, true);
ALTER TABLE titulos ALTER COLUMN id SET DEFAULT nextval('titulos_id_seq'::regclass);

INSERT INTO titulos VALUES (1, 'T�cnico en Producci�n Agropecuaria', true, 3);
INSERT INTO titulos VALUES (2, 'Maestro Mayor de Obras', true, 3);
INSERT INTO titulos VALUES (3, 'T�cnico en Electr�nica', true, 3);
INSERT INTO titulos VALUES (4, 'T�cnico en Electricidad', true, 3);
INSERT INTO titulos VALUES (5, 'T�cnico en Equipos e Instalaciones Electromec�nicas', true, 3);
INSERT INTO titulos VALUES (6, 'T�cnico en Energ�as Renovables', true, 3);
INSERT INTO titulos VALUES (7, 'T�cnico Mec�nico', true, 3);
INSERT INTO titulos VALUES (8, 'T�cnico en Mecanizaci�n Agropecuaria', true, 3);
INSERT INTO titulos VALUES (9, 'T�cnico en Automotores', true, 3);
INSERT INTO titulos VALUES (10, 'T�cnico en Aeron�utica', true, 3);
INSERT INTO titulos VALUES (11, 'T�cnico Avi�nico', true, 3);
INSERT INTO titulos VALUES (12, 'T�cnico en Aerofotogrametr�a', true, 3);
INSERT INTO titulos VALUES (13, 'T�cnico Qu�mico', true, 3);
INSERT INTO titulos VALUES (14, 'T�cnico en Industrias de Procesos', true, 3);
INSERT INTO titulos VALUES (15, 'T�cnico Minero', true, 3);
INSERT INTO titulos VALUES (16, 'T�cnico en Inform�tica Profesional y Personal', true, 3);
INSERT INTO titulos VALUES (17, 'T�cnico en Tecnolog�a de los Alimentos', true, 3);

INSERT INTO titulos VALUES (18, 'T�cnico Superior en Medicina Nuclear', true, 4);
INSERT INTO titulos VALUES (19, 'T�cnico Superior en Hemoterapia', true, 4);
INSERT INTO titulos VALUES (20, 'T�cnico Superior en Instrumentaci�n Quir�rgica', true, 4);
INSERT INTO titulos VALUES (21, 'T�cnico Superior en Esterilizaci�n', true, 4);
INSERT INTO titulos VALUES (22, 'T�cnico Superior en Gesti�n de la Producci�n Agropecuaria', true, 4);

INSERT INTO titulos VALUES (23, 'Apicultor', true, 1);
INSERT INTO titulos VALUES (24, 'Asistente Ap�cola', true, 1);
INSERT INTO titulos VALUES (25, 'Operario Ap�cola', true, 1);
INSERT INTO titulos VALUES (26, 'Auxiliar Mec�nico de Motores Nafteros', true, 1);
INSERT INTO titulos VALUES (27, 'Auxiliar Mec�nico de Motores Diesel', true, 1);
INSERT INTO titulos VALUES (28, 'Operador de Inform�tica para Administraci�n y Gesti�n', true, 1);
INSERT INTO titulos VALUES (29, 'Mec�nico de Sistemas de Frenos', true, 1);
INSERT INTO titulos VALUES (30, 'Mec�nico de Sistemas de Encendido y Alimentaci�n', true, 1);
INSERT INTO titulos VALUES (31, 'Mec�nico de Sistemas de Inyecci�n Diesel', true, 1);
INSERT INTO titulos VALUES (32, 'Tornero', true, 1);
INSERT INTO titulos VALUES (33, 'Fresador', true, 1);
INSERT INTO titulos VALUES (34, 'Curso de Capacitaci�n para Construcciones Sismorresistentes en Mamposter�a', true, 1);


-- En la tabla planes coloco otra columna
ALTER TABLE "public"."planes" ADD COLUMN "titulo_id" integer NOT NULL DEFAULT 0




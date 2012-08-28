ALTER TABLE queries
    ALTER COLUMN name TYPE varchar(70) ,
    ADD COLUMN categoria varchar(64) ,
    ADD COLUMN ver_online boolean  ,
    ALTER COLUMN name SET DEFAULT ''  ,
    ALTER COLUMN categoria SET DEFAULT ''   ,
    ALTER COLUMN ver_online SET DEFAULT false ,
    ALTER COLUMN name SET DEFAULT NOT NULL ,
    ALTER COLUMN categoria SET DEFAULT NOT NULL  ,
    ALTER COLUMN ver_online SET DEFAULT NOT NULL  ;

ALTER TABLE instits ADD COLUMN etp_estado_id integer NOT NULL DEFAULT 0;
ALTER TABLE instits ADD COLUMN claseinstit_id integer NOT NULL DEFAULT 0;

ALTER TABLE instits ALTER COLUMN "departamento_id" SET NOT NULL, ALTER COLUMN "departamento_id" SET DEFAULT 0;
ALTER TABLE instits ALTER COLUMN "localidad_id" SET NOT NULL, ALTER COLUMN "localidad_id" SET DEFAULT 0 ;
ALTER TABLE instits ALTER COLUMN "telefono_alternativo" SET NOT NULL ,ALTER COLUMN "telefono_alternativo" SET DEFAULT '';
ALTER TABLE instits ALTER COLUMN "mail_alternativo" SET NOT NULL , ALTER COLUMN "mail_alternativo" SET DEFAULT '';
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
-- Name: etp_estados; Type: TABLE; Schema: public; Owner: www; Tablespace: 
--

CREATE TABLE etp_estados (
    id integer NOT NULL,
    name character varying(60) DEFAULT ''::character varying NOT NULL
);


ALTER TABLE public.etp_estados OWNER TO www;

--
-- Name: etp_estados_id_seq; Type: SEQUENCE; Schema: public; Owner: www
--

CREATE SEQUENCE etp_estados_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.etp_estados_id_seq OWNER TO www;

--
-- Name: etp_estados_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: www
--

ALTER SEQUENCE etp_estados_id_seq OWNED BY etp_estados.id;


--
-- Name: etp_estados_id_seq; Type: SEQUENCE SET; Schema: public; Owner: www
--

SELECT pg_catalog.setval('etp_estados_id_seq', 2, true);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: www
--

ALTER TABLE etp_estados ALTER COLUMN id SET DEFAULT nextval('etp_estados_id_seq'::regclass);


--
-- Data for Name: etp_estados; Type: TABLE DATA; Schema: public; Owner: www
--

INSERT INTO etp_estados VALUES (1, 'Institución con programa de ETP');
INSERT INTO etp_estados VALUES (2, 'Institución de ETP');


--
-- Name: etp_estados_pkey; Type: CONSTRAINT; Schema: public; Owner: www; Tablespace: 
--

ALTER TABLE ONLY etp_estados
    ADD CONSTRAINT etp_estados_pkey PRIMARY KEY (id);


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
-- Name: claseinstits; Type: TABLE; Schema: public; Owner: www; Tablespace: 
--

CREATE TABLE claseinstits (
    id integer NOT NULL,
    name character varying(60) DEFAULT ''::character varying NOT NULL
);


ALTER TABLE public.claseinstits OWNER TO www;

--
-- Name: claseinstits_id_seq; Type: SEQUENCE; Schema: public; Owner: www
--

CREATE SEQUENCE claseinstits_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.claseinstits_id_seq OWNER TO www;

--
-- Name: claseinstits_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: www
--

ALTER SEQUENCE claseinstits_id_seq OWNED BY claseinstits.id;


--
-- Name: claseinstits_id_seq; Type: SEQUENCE SET; Schema: public; Owner: www
--

SELECT pg_catalog.setval('claseinstits_id_seq', 4, true);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: www
--

ALTER TABLE claseinstits ALTER COLUMN id SET DEFAULT nextval('claseinstits_id_seq'::regclass);


--
-- Data for Name: claseinstits; Type: TABLE DATA; Schema: public; Owner: www
--
INSERT INTO claseinstits VALUES (1, 'Formación Profesional');
INSERT INTO claseinstits VALUES (2, 'con Itinerario Formativo');
INSERT INTO claseinstits VALUES (3, 'Secundario');
INSERT INTO claseinstits VALUES (4, 'Superior');


--
-- Name: claseinstits_pkey; Type: CONSTRAINT; Schema: public; Owner: www; Tablespace: 
--

ALTER TABLE ONLY claseinstits
    ADD CONSTRAINT claseinstits_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--

-- IT = 276

UPDATE instits 
SET    etp_estado_id  = 1
      ,claseinstit_id = 2
WHERE  activo = 1
AND    EXISTS (SELECT 1
               FROM   planes 
               WHERE  planes.instit_id = instits.id
               AND    planes.oferta_id = 2)
AND    NOT EXISTS               
		(SELECT 1
		 FROM   planes 
                 WHERE  planes.instit_id = instits.id
                 AND    planes.oferta_id <> 2);

-- FP = 1037

UPDATE instits 
SET    claseinstit_id = 1
WHERE  activo = 1
AND    EXISTS (SELECT 1
               FROM   planes 
               WHERE  planes.instit_id = instits.id
               AND    planes.oferta_id = 1)
AND    NOT EXISTS               
		(SELECT 1
		 FROM   planes 
                 WHERE  planes.instit_id = instits.id
                 AND    planes.oferta_id <> 1);

-- SEC TEC = 1321

UPDATE instits 
SET    claseinstit_id = 3
WHERE  activo = 1
AND    EXISTS (SELECT 1
               FROM   planes 
               WHERE  planes.instit_id = instits.id
               AND    planes.oferta_id = 3)
AND    NOT EXISTS               
		(SELECT 1
		 FROM   planes 
                 WHERE  planes.instit_id = instits.id
                 AND    planes.oferta_id <> 3);

-- SUP TEC = 672

UPDATE instits 
SET    claseinstit_id = 4
WHERE  activo = 1
AND    EXISTS (SELECT 1
               FROM   planes 
               WHERE  planes.instit_id = instits.id
               AND    planes.oferta_id = 4)
AND    NOT EXISTS               
		(SELECT 1
		 FROM   planes 
                 WHERE  planes.instit_id = instits.id
                 AND    planes.oferta_id <> 4);

-- SEC TEC y IT --> SEC TEC

UPDATE instits 
SET    claseinstit_id = 3 -- de Nivel secundario
WHERE  activo = 1
AND    EXISTS (SELECT 1
               FROM   planes 
               WHERE  planes.instit_id = instits.id
               AND    planes.oferta_id = 3) -- Secundario Tecnico
AND    EXISTS (SELECT 1
               FROM   planes 
               WHERE  planes.instit_id = instits.id
               AND    planes.oferta_id = 2) -- Itinerario
AND    NOT EXISTS               
		(SELECT 1
		 FROM   planes 
                 WHERE  planes.instit_id = instits.id
                 AND    planes.oferta_id <> 3
                 AND    planes.oferta_id <> 2);

UPDATE instits
SET    etp_estado_id = 1
      ,observacion = replace(observacion, 'INSTITUCIÓN CON PROGRAMA DE ETP.', '')
WHERE upper(observacion) LIKE '%INSTITUCIÓN CON PROGRAMA DE ETP.%';

UPDATE instits
SET    etp_estado_id = 1
      ,observacion = replace(observacion, 'INSTITUCIÓN CON PROGRAMA DE ETP', '')
WHERE upper(observacion) LIKE '%INSTITUCIÓN CON PROGRAMA DE ETP%';



-- SUP TEC y IT --> SUP TEC

UPDATE instits 
SET    claseinstit_id = 4 -- Nivel Superior
WHERE  activo = 1
AND    EXISTS (SELECT 1
               FROM   planes 
               WHERE  planes.instit_id = instits.id
               AND    planes.oferta_id = 4) -- Superior Tecnico
AND    EXISTS (SELECT 1
               FROM   planes 
               WHERE  planes.instit_id = instits.id
               AND    planes.oferta_id = 2) -- Itinerario
AND    NOT EXISTS               
		(SELECT 1
		 FROM   planes 
                 WHERE  planes.instit_id = instits.id
                 AND    planes.oferta_id <> 4
                 AND    planes.oferta_id <> 2);


DROP TABLE z_depuracion_deptoyloc;
DROP TABLE z_depura_nroinstit;

-- SE HABILITO NULL EN LA TABLA PLANES EN EL CAMPO SECTOR YA QUE SE ENCUENTRA FUERA DE USO
-- Posiblemente en el futuro el campo sector se borre.
-- ALTER TABLE planes ALTER COLUMN sector DROP NOT NULL;


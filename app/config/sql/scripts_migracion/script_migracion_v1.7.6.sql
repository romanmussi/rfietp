CREATE TABLE modalidades
(
  id serial NOT NULL,
  "name" character varying(64) NOT NULL,
  CONSTRAINT modalidad_id PRIMARY KEY (id)
)
WITH (
  OIDS=FALSE
);

/* carga registros */
INSERT INTO modalidades(id, "name") VALUES (1, 'Educación Técnico Profesional');
INSERT INTO modalidades(id, "name") VALUES (2, 'Educación Artística');
INSERT INTO modalidades(id, "name") VALUES (3, 'Educación Especial');
INSERT INTO modalidades(id, "name") VALUES (4, 'Educación Permanente de Jóvenes y Adultos');
INSERT INTO modalidades(id, "name") VALUES (5, 'Educación Rural');
INSERT INTO modalidades(id, "name") VALUES (6, 'Educación Intercultural Bilingüe');
INSERT INTO modalidades(id, "name") VALUES (7, 'Educación en Contextos de Privación de Libertad');
INSERT INTO modalidades(id, "name") VALUES (8, 'Educación Domiciliaria y Hospitalaria');
INSERT INTO modalidades(id, "name") VALUES (9, 'No Corresponde');


ALTER TABLE instits ADD COLUMN modalidad_id integer DEFAULT 0;

/* Para todas las instituciones de ETP asignar modalidad ETP */
update instits set modalidad_id=1 where etp_estado_id=2;


ALTER TABLE instits
   ADD COLUMN observacion_oferta text;
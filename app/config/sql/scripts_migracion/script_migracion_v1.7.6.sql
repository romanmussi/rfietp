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
INSERT INTO modalidades(id, "name") VALUES (1, 'Educaci�n T�cnico Profesional');
INSERT INTO modalidades(id, "name") VALUES (2, 'Educaci�n Art�stica');
INSERT INTO modalidades(id, "name") VALUES (3, 'Educaci�n Especial');
INSERT INTO modalidades(id, "name") VALUES (4, 'Educaci�n Permanente de J�venes y Adultos');
INSERT INTO modalidades(id, "name") VALUES (5, 'Educaci�n Rural');
INSERT INTO modalidades(id, "name") VALUES (6, 'Educaci�n Intercultural Biling�e');
INSERT INTO modalidades(id, "name") VALUES (7, 'Educaci�n en Contextos de Privaci�n de Libertad');
INSERT INTO modalidades(id, "name") VALUES (8, 'Educaci�n Domiciliaria y Hospitalaria');
INSERT INTO modalidades(id, "name") VALUES (9, 'No Corresponde');


ALTER TABLE instits ADD COLUMN modalidad_id integer DEFAULT 0;

/* Para todas las instituciones de ETP asignar modalidad ETP */
update instits set modalidad_id=1 where etp_estado_id=2;


ALTER TABLE instits
   ADD COLUMN observacion_oferta text;
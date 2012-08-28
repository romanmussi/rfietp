/********************** QUERIES ****************************************/
/*
DESCARGAS
*/
CREATE TABLE "public"."pquery_categories" ("id" SERIAL, "name" character varying(64) NOT NULL DEFAULT '', "created" timestamp without time zone, "modified" timestamp without time zone, PRIMARY KEY ("id")) WITHOUT OIDS;

ALTER TABLE "public"."queries" ADD COLUMN "pquery_category_id" integer NOT NULL DEFAULT 0;
ALTER TABLE "public"."queries" DROP COLUMN "categoria";
ALTER TABLE "public"."queries" ADD COLUMN "expiration_time" timestamp without time zone;
ALTER TABLE "public"."queries" ADD COLUMN "columns" text;

/*Categorias*/
INSERT INTO pquery_categories ("name")
VALUES('Habituales');

INSERT INTO pquery_categories ("name")
VALUES('Temporales');

/*Habituales*/
UPDATE queries
SET pquery_category_id = 1
WHERE id in (45,44,48,23,6,5,8,7,27,25);

UPDATE queries
SET name = 'Depuración de Sectores y Titulos'
WHERE id = 45;

UPDATE queries
SET name = 'Todos los Planes sin Repetir'
WHERE id = 44;

UPDATE queries
SET name = 'Titulos de Superior'
WHERE id = 48;

UPDATE queries
SET name = 'Instituciones por Año de Actualización'
WHERE id = 23;

UPDATE queries
SET name = 'Nómina Secundario Técnico'
WHERE id = 6;

UPDATE queries
SET name = 'Nómina Superior Técnico'
WHERE id = 5;

UPDATE queries
SET name = 'Nómina Itinerario'
WHERE id = 8;

UPDATE queries
SET name = 'Nómina Formación Profesional'
WHERE id = 7;

UPDATE queries
SET name = 'Instituciones por Tipo de ETP'
WHERE id = 27;

UPDATE queries
SET name = 'Instituciones por Ámbito de Gestión según Jurisdicción'
WHERE id = 25;

/*Borrar*/
DELETE FROM queries
WHERE id not in (45,44,48,23,6,5,8,7,27,25);

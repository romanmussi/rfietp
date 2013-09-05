INSERT INTO lineas_de_acciones ( id, name, description, orden )
VALUES(21, 'C1', 'C1 - Igualdad de oportunidades', 0);

INSERT INTO lineas_de_acciones ( id, name, description, orden )
VALUES(22, 'C2', 'C2 - Formación de formadores. Inicial y continua', 0);

INSERT INTO lineas_de_acciones ( id, name, description, orden )
VALUES(23, 'C3', 'C3 - Entornos formativos. Vinculación, prácticas y recursos', 0);

INSERT INTO lineas_de_acciones ( id, name, description, orden )
VALUES(24, 'C4', 'C4 - Piso tecnológico TICs', 0);

INSERT INTO lineas_de_acciones ( id, name, description, orden )
VALUES(25, 'C5', 'C5 - Infraestructura edilicia, seguridad e higiene', 0);

ALTER TABLE "z_fondo_work" ADD COLUMN "obs" character varying;
ALTER TABLE "z_fondo_work" ADD COLUMN "c1" double precision DEFAULT 0;
ALTER TABLE "z_fondo_work" ADD COLUMN "c2" double precision DEFAULT 0;
ALTER TABLE "z_fondo_work" ADD COLUMN "c3" double precision DEFAULT 0;
ALTER TABLE "z_fondo_work" ADD COLUMN "c4" double precision DEFAULT 0;
ALTER TABLE "z_fondo_work" ADD COLUMN "c5" double precision DEFAULT 0;

ALTER TABLE "fondos" ADD COLUMN "obs" text;
ALTER TABLE queries ADD COLUMN filename character varying(70);

CREATE TABLE plan_estados
(
  id serial NOT NULL,
  nombre character varying(200),
  CONSTRAINT plan_estados_pkey PRIMARY KEY (id )
);
CREATE TABLE plan_turnos
(
  id serial NOT NULL,
  nombre character varying(200),
  CONSTRAINT plan_turnos_pkey PRIMARY KEY (id )
);

GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE plan_turnos TO www;
GRANT SELECT,INSERT,DELETE,UPDATE ON TABLE plan_estados TO www;


ALTER TABLE planes ADD COLUMN plan_turno_id integer NOT NULL DEFAULT 0;
ALTER TABLE planes ADD COLUMN plan_estado_id integer NOT NULL DEFAULT 0;

INSERT INTO plan_estados (nombre) VALUES ('Activo'),('Residual'),('Inactivo');
INSERT INTO plan_turnos (nombre) VALUES ('Diurno'),('Vespertino'),('Nocturno');

update planes set plan_turno_id = (select id from plan_turnos where nombre = 'Diurno' LIMIT 1);
update planes set plan_estado_id = (select id from plan_estados where nombre = 'Activo' LIMIT 1);


update planes 
	set nombre=regexp_replace(nombre, '\s*residual\s*', '', 'i'),
		plan_estado_id = (select id from plan_estados where nombre = 'Residual' LIMIT 1)
where nombre ilike '%residual%';

update planes 
	set nombre=regexp_replace(nombre, '\s*vespertino\s*', '', 'i'),
	plan_turno_id = (select id from plan_turnos where nombre = 'Vespertino' LIMIT 1)
where nombre ilike '%vespert%' and not nombre ilike '%diurn%' and not nombre like '%noct%';

update planes 
	set nombre=regexp_replace(nombre, '\s*nocturno\s*', '', 'i'),
	plan_turno_id = (select id from plan_turnos where nombre = 'Nocturno' LIMIT 1)
where nombre ilike '%noct%' and not nombre ilike '%diurn%' and not nombre like '%vespert%';

update planes 
	set plan_estado_id = (select id from plan_estados where nombre = 'Residual' LIMIT 1)
where observacion ilike '%residual%';

update planes 
	set plan_turno_id = (select id from plan_turnos where nombre = 'Nocturno' LIMIT 1)
where not observacion ilike '%vespert%' and observacion ilike '%nocturn%' and not observacion ilike '%diurn%';

update planes 
	set plan_turno_id = (select id from plan_turnos where nombre = 'Vespertino' LIMIT 1)
where observacion ilike '%vespert%' and not observacion ilike '%nocturn%' and not observacion ilike '%diurn%';

update planes 
	set nombre=regexp_replace(nombre, '\s*\(\s*-?\s*(plan)?\s*(diurno)?\s*-?\s*\)\s*', '', 'i')
where nombre SIMILAR TO  '%\(%\)%' escape '\';


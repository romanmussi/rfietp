CREATE OR REPLACE FUNCTION nombre_instit (
	tipo character varying, 
	nro character varying, 
	nombre character varying
	) RETURNS character varying AS $$
	DECLARE
		ret text := '';
	BEGIN
		IF tipo IS NOT NULL AND tipo <> ''THEN
			ret := ret || tipo;
			IF nro IS NOT NULL AND nro <> '' THEN
				ret := ret ||' N° '||nro;
			END IF;
		END IF;
		IF nombre IS NOT NULL AND nombre <> '' THEN
			ret := ret || ' "'|| nombre || '"';
		END IF;

		return ret;
	END;
$$ LANGUAGE plpgsql;
ALTER TABLE "public"."etapas" ADD COLUMN "orden" integer;


/** Corrector de estructuras anios colgados **/
-- Estructuras que contienen errores: 1, 2, 3, 4, 5, 6, 7, 8, 13, 15, 17, 18, 20, 21, 22
-- Debe actualizar 2121 filas

UPDATE Anios SET estructura_planes_anio_id=212 WHERE estructura_planes_anio_id=143;
UPDATE Anios SET estructura_planes_anio_id=213 WHERE estructura_planes_anio_id=144;
UPDATE Anios SET estructura_planes_anio_id=214 WHERE estructura_planes_anio_id=145;
UPDATE Anios SET estructura_planes_anio_id=178 WHERE estructura_planes_anio_id=19;
UPDATE Anios SET estructura_planes_anio_id=179 WHERE estructura_planes_anio_id=20;
UPDATE Anios SET estructura_planes_anio_id=180 WHERE estructura_planes_anio_id=21;
UPDATE Anios SET estructura_planes_anio_id=181 WHERE estructura_planes_anio_id=15;
UPDATE Anios SET estructura_planes_anio_id=182 WHERE estructura_planes_anio_id=16;
UPDATE Anios SET estructura_planes_anio_id=183 WHERE estructura_planes_anio_id=17;
UPDATE Anios SET estructura_planes_anio_id=184 WHERE estructura_planes_anio_id=18;
UPDATE Anios SET estructura_planes_anio_id=251 WHERE estructura_planes_anio_id=27;
UPDATE Anios SET estructura_planes_anio_id=252 WHERE estructura_planes_anio_id=28;
UPDATE Anios SET estructura_planes_anio_id=253 WHERE estructura_planes_anio_id=29;
UPDATE Anios SET estructura_planes_anio_id=188 WHERE estructura_planes_anio_id=37;
UPDATE Anios SET estructura_planes_anio_id=189 WHERE estructura_planes_anio_id=38;
UPDATE Anios SET estructura_planes_anio_id=190 WHERE estructura_planes_anio_id=39;
UPDATE Anios SET estructura_planes_anio_id=191 WHERE estructura_planes_anio_id=40;
UPDATE Anios SET estructura_planes_anio_id=224 WHERE estructura_planes_anio_id=30;
UPDATE Anios SET estructura_planes_anio_id=225 WHERE estructura_planes_anio_id=31;
UPDATE Anios SET estructura_planes_anio_id=226 WHERE estructura_planes_anio_id=32;
UPDATE Anios SET estructura_planes_anio_id=244 WHERE estructura_planes_anio_id=134;
UPDATE Anios SET estructura_planes_anio_id=245 WHERE estructura_planes_anio_id=135;
UPDATE Anios SET estructura_planes_anio_id=246 WHERE estructura_planes_anio_id=136;
UPDATE Anios SET estructura_planes_anio_id=247 WHERE estructura_planes_anio_id=137;
UPDATE Anios SET estructura_planes_anio_id=202 WHERE estructura_planes_anio_id=89;
UPDATE Anios SET estructura_planes_anio_id=203 WHERE estructura_planes_anio_id=90;
UPDATE Anios SET estructura_planes_anio_id=204 WHERE estructura_planes_anio_id=91;
UPDATE Anios SET estructura_planes_anio_id=227 WHERE estructura_planes_anio_id=95;
UPDATE Anios SET estructura_planes_anio_id=228 WHERE estructura_planes_anio_id=96;
UPDATE Anios SET estructura_planes_anio_id=229 WHERE estructura_planes_anio_id=97;
UPDATE Anios SET estructura_planes_anio_id=198 WHERE estructura_planes_anio_id=85;
UPDATE Anios SET estructura_planes_anio_id=205 WHERE estructura_planes_anio_id=92;
UPDATE Anios SET estructura_planes_anio_id=206 WHERE estructura_planes_anio_id=93;
UPDATE Anios SET estructura_planes_anio_id=207 WHERE estructura_planes_anio_id=94;
UPDATE Anios SET estructura_planes_anio_id=238 WHERE estructura_planes_anio_id=102;
UPDATE Anios SET estructura_planes_anio_id=239 WHERE estructura_planes_anio_id=103;
UPDATE Anios SET estructura_planes_anio_id=240 WHERE estructura_planes_anio_id=104;
UPDATE Anios SET estructura_planes_anio_id=208 WHERE estructura_planes_anio_id=121;
UPDATE Anios SET estructura_planes_anio_id=209 WHERE estructura_planes_anio_id=122;
UPDATE Anios SET estructura_planes_anio_id=241 WHERE estructura_planes_anio_id=123;
UPDATE Anios SET estructura_planes_anio_id=242 WHERE estructura_planes_anio_id=124;
UPDATE Anios SET estructura_planes_anio_id=243 WHERE estructura_planes_anio_id=125;
UPDATE Anios SET estructura_planes_anio_id=215 WHERE estructura_planes_anio_id=148;
UPDATE Anios SET estructura_planes_anio_id=216 WHERE estructura_planes_anio_id=149;

-- quedan 143 filas para actualizar
-- otra actualizacion que se hizo backup del 20/09/10
UPDATE Anios SET estructura_planes_anio_id=224 WHERE estructura_planes_anio_id=154;
UPDATE Anios SET estructura_planes_anio_id=225 WHERE estructura_planes_anio_id=155;
UPDATE Anios SET estructura_planes_anio_id=226 WHERE estructura_planes_anio_id=156;

UPDATE Anios SET estructura_planes_anio_id=227 WHERE estructura_planes_anio_id=157;
UPDATE Anios SET estructura_planes_anio_id=228 WHERE estructura_planes_anio_id=158;
UPDATE Anios SET estructura_planes_anio_id=229 WHERE estructura_planes_anio_id=159;

UPDATE Anios SET estructura_planes_anio_id=238 WHERE estructura_planes_anio_id=168;
UPDATE Anios SET estructura_planes_anio_id=239 WHERE estructura_planes_anio_id=169;
UPDATE Anios SET estructura_planes_anio_id=240 WHERE estructura_planes_anio_id=170;

UPDATE Anios SET estructura_planes_anio_id=241 WHERE estructura_planes_anio_id=171;
UPDATE Anios SET estructura_planes_anio_id=242 WHERE estructura_planes_anio_id=172;
UPDATE Anios SET estructura_planes_anio_id=243 WHERE estructura_planes_anio_id=173;

UPDATE Anios SET estructura_planes_anio_id=244 WHERE estructura_planes_anio_id=174;
UPDATE Anios SET estructura_planes_anio_id=245 WHERE estructura_planes_anio_id=175;
UPDATE Anios SET estructura_planes_anio_id=246 WHERE estructura_planes_anio_id=176;
UPDATE Anios SET estructura_planes_anio_id=247 WHERE estructura_planes_anio_id=177;

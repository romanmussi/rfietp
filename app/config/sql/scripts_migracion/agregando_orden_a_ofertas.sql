ALTER TABLE ofertas ADD COLUMN "order" integer;
ALTER TABLE ofertas ALTER COLUMN "order" SET DEFAULT 0;

update ofertas set "order" = 1 where id = 3;
update ofertas set "order" = 2 where id = 4;
update ofertas set "order" = 3 where id = 1;
update ofertas set "order" = 4 where id = 2;
update ofertas set "order" = 5 where id = 5;
update ofertas set "order" = 6 where id = 6;
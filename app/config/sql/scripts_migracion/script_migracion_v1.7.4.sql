ALTER TABLE instits ADD COLUMN depurar_tipoinstit integer DEFAULT 0;

ALTER TABLE users   ADD COLUMN password_reset_token character varying(24);

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
-- Name: user_logins; Type: TABLE; Schema: public; Owner: www; Tablespace: 
--

CREATE TABLE user_logins (
    id integer NOT NULL,
    user_id integer NOT NULL,
    created timestamp without time zone
);


ALTER TABLE public.user_logins OWNER TO www;

--
-- Name: user_logins_id_seq; Type: SEQUENCE; Schema: public; Owner: www
--

CREATE SEQUENCE user_logins_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.user_logins_id_seq OWNER TO www;

--
-- Name: user_logins_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: www
--

ALTER SEQUENCE user_logins_id_seq OWNED BY user_logins.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: www
--

ALTER TABLE user_logins ALTER COLUMN id SET DEFAULT nextval('user_logins_id_seq'::regclass);


--
-- Name: user_logins_pkey; Type: CONSTRAINT; Schema: public; Owner: www; Tablespace: 
--

ALTER TABLE ONLY user_logins
    ADD CONSTRAINT user_logins_pkey PRIMARY KEY (id);


--
-- PostgreSQL database dump complete
--


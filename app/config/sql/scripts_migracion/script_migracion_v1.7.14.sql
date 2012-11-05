--
-- Name: version_id_seq; Type: SEQUENCE; Schema: public; Owner: www
--

CREATE SEQUENCE version_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.version_id_seq OWNER TO www;

--
-- Name: version; Type: TABLE; Schema: public; Owner: www; Tablespace: 
--

CREATE TABLE version (
    id INTEGER DEFAULT nextval('version_id_seq'::regclass) NOT NULL,
    version character varying(5) NOT NULL,
    fecha date,
    CONSTRAINT version_pkey PRIMARY KEY (id)
);

ALTER TABLE public.version OWNER TO www;

--
-- Name: version_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: www
--

ALTER SEQUENCE version_id_seq OWNED BY version.id;
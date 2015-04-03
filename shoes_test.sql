--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: brands; Type: TABLE; Schema: public; Owner: brian; Tablespace: 
--

CREATE TABLE brands (
    id integer NOT NULL,
    style character varying
);


ALTER TABLE public.brands OWNER TO brian;

--
-- Name: brands_id_seq; Type: SEQUENCE; Schema: public; Owner: brian
--

CREATE SEQUENCE brands_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.brands_id_seq OWNER TO brian;

--
-- Name: brands_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: brian
--

ALTER SEQUENCE brands_id_seq OWNED BY brands.id;


--
-- Name: brands_stores; Type: TABLE; Schema: public; Owner: brian; Tablespace: 
--

CREATE TABLE brands_stores (
    id integer NOT NULL,
    brand_id integer,
    store_id integer
);


ALTER TABLE public.brands_stores OWNER TO brian;

--
-- Name: brands_stores_id_seq; Type: SEQUENCE; Schema: public; Owner: brian
--

CREATE SEQUENCE brands_stores_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.brands_stores_id_seq OWNER TO brian;

--
-- Name: brands_stores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: brian
--

ALTER SEQUENCE brands_stores_id_seq OWNED BY brands_stores.id;


--
-- Name: stores; Type: TABLE; Schema: public; Owner: brian; Tablespace: 
--

CREATE TABLE stores (
    id integer NOT NULL,
    name character varying
);


ALTER TABLE public.stores OWNER TO brian;

--
-- Name: stores_id_seq; Type: SEQUENCE; Schema: public; Owner: brian
--

CREATE SEQUENCE stores_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.stores_id_seq OWNER TO brian;

--
-- Name: stores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: brian
--

ALTER SEQUENCE stores_id_seq OWNED BY stores.id;


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: brian
--

ALTER TABLE ONLY brands ALTER COLUMN id SET DEFAULT nextval('brands_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: brian
--

ALTER TABLE ONLY brands_stores ALTER COLUMN id SET DEFAULT nextval('brands_stores_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: brian
--

ALTER TABLE ONLY stores ALTER COLUMN id SET DEFAULT nextval('stores_id_seq'::regclass);


--
-- Data for Name: brands; Type: TABLE DATA; Schema: public; Owner: brian
--

COPY brands (id, style) FROM stdin;
21	Adidas
22	Levi
23	Nike
\.


--
-- Name: brands_id_seq; Type: SEQUENCE SET; Schema: public; Owner: brian
--

SELECT pg_catalog.setval('brands_id_seq', 23, true);


--
-- Data for Name: brands_stores; Type: TABLE DATA; Schema: public; Owner: brian
--

COPY brands_stores (id, brand_id, store_id) FROM stdin;
1	1	1
2	11	60
3	11	60
4	11	60
5	11	60
6	11	60
7	11	60
8	11	60
9	11	60
10	11	60
11	11	65
12	11	65
13	11	65
14	11	65
15	11	65
16	16	68
17	19	68
18	19	69
19	19	68
20	19	70
21	23	70
\.


--
-- Name: brands_stores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: brian
--

SELECT pg_catalog.setval('brands_stores_id_seq', 21, true);


--
-- Data for Name: stores; Type: TABLE DATA; Schema: public; Owner: brian
--

COPY stores (id, name) FROM stdin;
68	John
69	Tom
70	Shady
\.


--
-- Name: stores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: brian
--

SELECT pg_catalog.setval('stores_id_seq', 70, true);


--
-- Name: brands_pkey; Type: CONSTRAINT; Schema: public; Owner: brian; Tablespace: 
--

ALTER TABLE ONLY brands
    ADD CONSTRAINT brands_pkey PRIMARY KEY (id);


--
-- Name: brands_stores_pkey; Type: CONSTRAINT; Schema: public; Owner: brian; Tablespace: 
--

ALTER TABLE ONLY brands_stores
    ADD CONSTRAINT brands_stores_pkey PRIMARY KEY (id);


--
-- Name: stores_pkey; Type: CONSTRAINT; Schema: public; Owner: brian; Tablespace: 
--

ALTER TABLE ONLY stores
    ADD CONSTRAINT stores_pkey PRIMARY KEY (id);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--


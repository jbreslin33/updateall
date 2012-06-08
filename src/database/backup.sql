--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
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
-- Name: math_count_levels; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE math_count_levels (
    id integer NOT NULL,
    start_number integer NOT NULL,
    score_needed integer DEFAULT 10 NOT NULL,
    count_by integer DEFAULT 1 NOT NULL,
    end_number integer DEFAULT 0,
    level integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.math_count_levels OWNER TO postgres;

--
-- Name: math_games_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE math_games_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.math_games_id_seq OWNER TO postgres;

--
-- Name: math_games_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE math_games_id_seq OWNED BY math_count_levels.id;


--
-- Name: math_games_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('math_games_id_seq', 91, true);


--
-- Name: english_levels; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE english_levels (
    id integer DEFAULT nextval('math_games_id_seq'::regclass) NOT NULL,
    skill text NOT NULL,
    level integer DEFAULT 0 NOT NULL,
    next_level integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.english_levels OWNER TO postgres;

--
-- Name: math_add_levels; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE math_add_levels (
    id integer DEFAULT nextval('math_games_id_seq'::regclass) NOT NULL,
    score_needed integer DEFAULT 10 NOT NULL,
    level integer DEFAULT 0 NOT NULL,
    addend_min integer DEFAULT 0 NOT NULL,
    addend_max integer DEFAULT 0 NOT NULL,
    number_of_addends integer DEFAULT 2 NOT NULL
);


ALTER TABLE public.math_add_levels OWNER TO postgres;

--
-- Name: math_games; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE math_games (
    id integer DEFAULT nextval('math_games_id_seq'::regclass) NOT NULL,
    level integer DEFAULT 0 NOT NULL,
    url text,
    name text
);


ALTER TABLE public.math_games OWNER TO postgres;

--
-- Name: math_levels; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE math_levels (
    id integer DEFAULT nextval('math_games_id_seq'::regclass) NOT NULL,
    skill text NOT NULL,
    level integer DEFAULT 0 NOT NULL,
    next_level integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.math_levels OWNER TO postgres;

--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE users (
    username text NOT NULL,
    password text NOT NULL,
    id integer NOT NULL,
    math_level integer DEFAULT 100 NOT NULL,
    english_level integer DEFAULT 0 NOT NULL
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE users_id_seq OWNED BY users.id;


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('users_id_seq', 109, true);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY math_count_levels ALTER COLUMN id SET DEFAULT nextval('math_games_id_seq'::regclass);


--
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);


--
-- Data for Name: english_levels; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY english_levels (id, skill, level, next_level) FROM stdin;
\.


--
-- Data for Name: math_add_levels; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY math_add_levels (id, score_needed, level, addend_min, addend_max, number_of_addends) FROM stdin;
48	10	100	0	1	2
49	10	101	0	2	2
51	10	102	0	3	2
52	10	103	0	4	2
84	10	104	0	5	2
85	10	105	0	6	2
86	10	106	0	7	2
87	10	107	0	8	2
88	10	108	0	9	2
89	10	109	0	10	2
90	10	110	0	11	2
91	10	111	0	12	2
\.


--
-- Data for Name: math_count_levels; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY math_count_levels (id, start_number, score_needed, count_by, end_number, level) FROM stdin;
1	0	10	1	10	0
2	10	10	1	20	1
3	20	10	1	30	3
4	30	10	1	40	4
5	40	10	1	50	5
6	50	10	1	60	6
7	60	10	1	70	7
8	70	10	1	80	8
9	80	10	1	90	9
10	90	10	1	100	10
11	0	10	10	100	11
12	3	10	1	13	12
14	0	20	1	20	13
15	0	10	1	9	14
21	0	10	2	9	15
\.


--
-- Data for Name: math_games; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY math_games (id, level, url, name) FROM stdin;
55	0	../../template/math/count/count.php	count from 0 to 10.
46	100	../../template/math/add/add_simple.php	Dungeon Add
53	101	../../template/math/add/add_simple.php	Dungeon Add
54	101	../../template/math/add/add_helicopter.php	Helicopter Rescue
47	100	../../template/math/add/add_helicopter.php	Helicopter Rescue
56	1	../../template/math/count/count.php	Count from 10 to 20.
57	2	../../template/math/count/count.php	Count from 20 to 30
58	3	../../template/math/count/count.php	Count from 30 to 40.
59	4	../../template/math/count/count.php	Count from 40 to 50.
60	5	../../template/math/count/count.php	Count from 50 to 60.
61	6	../../template/math/count/count.php	Count from 60 to 70.
62	7	../../template/math/count/count.php	Count from 70 to 80.
63	8	../../template/math/count/count.php	Count from 80 to 90.
64	9	../../template/math/count/count.php	Count from 90 to 100.
65	102	../../template/math/add/add_simple.php	Dungeon Add.
66	103	../../template/math/add/add_simple.php	Dungeon Add.
67	104	../../template/math/add/add_simple.php	Dungeon Add
68	105	../../template/math/add/add_simple.php	Dungeon Add.
69	106	../../template/math/add/add_simple.php	Dungeon Add
70	107	../../template/math/add/add_simple.php	Dungeon Add.
71	108	../../template/math/add/add_simple.php	Dungeon Add.
72	109	../../template/math/add/add_simple.php	Dungeon Add.
73	110	../../template/math/add/add_simple.php	Dungeon Add.
\.


--
-- Data for Name: math_levels; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY math_levels (id, skill, level, next_level) FROM stdin;
30	Adding 2 addends from 0 to 1.	100	101
31	Adding 2 addends from 0 to 2.	101	102
32	Adding 2 addends from 0 to 3.	102	103
33	Adding 2 addends from 0 to 4.	103	104
16	Count from 0 to 10.	0	1
17	Count from 10 to 20.	1	2
18	Count from 20 to 30.	2	3
19	Count from 30 to 40.	3	4
24	Count from 40 to 50 by ones.	4	5
25	Count from 50 to 60 by ones.	5	6
26	Count from 60 to 70 by ones.	6	7
27	Count from 70 to 80 by ones.	7	8
28	Count from 80 to 90 by ones.	8	9
29	Count from 90 to 100 by ones.	9	100
77	Adding 2 addends from 0 to 5.	104	105
78	Adding 2 addends from 0 to 6.	105	106
79	Adding 2 addends from 0 to 7.	106	107
80	Adding 2 addends from 0 to 8.	107	108
81	Adding 2 addends from 0 to 9.	108	109
82	Adding 2 addends from 0 to 10.	109	110
83	Adding 2 addends from 0 to 11.	110	111
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY users (username, password, id, math_level, english_level) FROM stdin;
v2022	p	91	100	0
v2024	p	93	100	0
v2028	p	97	100	0
v2023	p	92	100	0
v2020	p	89	100	0
v2021	p	90	100	0
dbyrne	p	109	100	0
v2004	p	73	100	0
v2007	p	76	100	0
v2014	p	83	100	0
v2015	p	84	100	0
v2017	p	86	100	0
v2018	p	87	100	0
v2025	p	94	100	0
v2027	p	96	100	0
v2029	p	98	100	0
v2026	p	95	100	0
v2003	p	72	100	0
v2005	p	74	100	0
v2008	p	77	100	0
v2013	p	82	100	0
v2030	p	99	100	0
v2031	p	100	100	0
v2032	p	101	100	0
v2033	p	102	100	0
v2034	p	103	100	0
v2035	p	104	100	0
v2036	p	105	100	0
jbreslin	p	106	100	0
v2010	p	79	100	0
v2016	p	85	100	0
v2012	p	81	100	0
v2019	p	88	100	0
v2009	p	78	100	0
v2006	p	75	100	0
v2002	p	71	101	0
v2001	p	70	111	0
v2011	p	80	103	0
		107	1	0
\.


--
-- Name: english_levels_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY english_levels
    ADD CONSTRAINT english_levels_pkey PRIMARY KEY (id);


--
-- Name: levels_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY math_levels
    ADD CONSTRAINT levels_pkey PRIMARY KEY (id);


--
-- Name: math_add_games_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY math_add_levels
    ADD CONSTRAINT math_add_games_pkey PRIMARY KEY (id);


--
-- Name: math_add_levels_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY math_games
    ADD CONSTRAINT math_add_levels_pkey PRIMARY KEY (id);


--
-- Name: math_games_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY math_count_levels
    ADD CONSTRAINT math_games_pkey PRIMARY KEY (id);


--
-- Name: users_username_key; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY users
    ADD CONSTRAINT users_username_key UNIQUE (username);


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


--
-- PostgreSQL database dump
--

DROP TABLE counting;
DROP TABLE addition;
DROP TABLE subtraction;
DROP TABLE levels;
DROP TABLE games;
DROP TABLE subjects;
DROP TABLE users;
DROP TABLE roles;

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;




--------------------roles---------------------------------------
CREATE TABLE roles (
    id integer NOT NULL PRIMARY KEY,
    role text NOT NULL UNIQUE
);
ALTER TABLE public.roles OWNER TO postgres;

CREATE SEQUENCE roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE public.roles_id_seq OWNER TO postgres;

ALTER SEQUENCE roles_id_seq OWNED BY roles.id;
ALTER TABLE ONLY roles ALTER COLUMN id SET DEFAULT nextval('roles_id_seq'::regclass);

insert into roles (role) values ('Administrator'); 
insert into roles (role) values ('Teacher'); 
insert into roles (role) values ('Student'); 
insert into roles (role) values ('Guest'); 

--------------------users---------------------------------------
CREATE TABLE users (
    id integer NOT NULL PRIMARY KEY,
    username text NOT NULL UNIQUE,
    password text NOT NULL,
    first_name text,
    last_name text,
    math_level integer DEFAULT 1 NOT NULL,
    math_teacher_id integer,
    english_level integer DEFAULT 1 NOT NULL,
    english_teacher_id integer,
    role_id integer NOT NULL,
    admin_id integer,
    teacher_id integer,
    FOREIGN KEY (math_teacher_id) REFERENCES users(id),
    FOREIGN KEY (english_teacher_id) REFERENCES users(id),
    FOREIGN KEY (role_id) REFERENCES roles(id),
    FOREIGN KEY (admin_id) REFERENCES users(id),
    FOREIGN KEY (teacher_id) REFERENCES users(id)
);

ALTER TABLE public.users OWNER TO postgres;

CREATE SEQUENCE users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE public.users_id_seq OWNER TO postgres;

ALTER SEQUENCE users_id_seq OWNED BY users.id;
ALTER TABLE ONLY users ALTER COLUMN id SET DEFAULT nextval('users_id_seq'::regclass);

--admin=1,teacher=2,student=3,guest=4
--create admin anselm 
insert into users (username,password,first_name,last_name,role_id) values ('anselm','p','Father','Foley',1); 
--create admin vis 
insert into users (username,password,first_name,last_name,role_id) values ('vis','p','Dolores','Egner',1); 

--create teachers anselm 
insert into users (username,password,first_name,last_name,role_id,admin_id) values ('kmary.anselm','p','Sally','Berg',2,1); 
--create teachers vis 
insert into users (username,password,first_name,last_name,role_id,admin_id) values ('jroache.vis','p','James','Roache',2,2); 

--create students anselm 
insert into users (username,password,first_name,last_name,english_teacher_id,math_teacher_id,role_id,admin_id,teacher_id) values ('1.anselm','p','Willard','Lackman',3,3,3,1,3); 
--create students vis 
insert into users (username,password,first_name,last_name,english_teacher_id,math_teacher_id,role_id,admin_id,teacher_id) values ('1.vis','p','Luke','Breslin',4,4,3,2,4); 

--create guest
insert into users (username,password,role_id) values ('guest','p',4); 



--------------------subjects---------------------------------------
CREATE TABLE subjects (
    id integer NOT NULL PRIMARY KEY,
    subject text NOT NULL UNIQUE
);
ALTER TABLE public.subjects OWNER TO postgres;

CREATE SEQUENCE subjects_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE public.subjects_id_seq OWNER TO postgres;

ALTER SEQUENCE subjects_id_seq OWNED BY users.id;
ALTER TABLE ONLY subjects ALTER COLUMN id SET DEFAULT nextval('subjects_id_seq'::regclass);

insert into subjects (subject) values ('Math');
insert into subjects (subject) values ('English');

--------------------levels---------------------------------------
CREATE TABLE levels (
    id integer NOT NULL,
    level integer NOT NULL,
    next_level integer NOT NULL,
    skill text NOT NULL,
    subject_id integer NOT NULL,
    PRIMARY KEY (level,subject_id),
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);
ALTER TABLE public.levels OWNER TO postgres;

CREATE SEQUENCE levels_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER TABLE public.levels_id_seq OWNER TO postgres;

ALTER SEQUENCE levels_id_seq OWNED BY users.id;
ALTER TABLE ONLY levels ALTER COLUMN id SET DEFAULT nextval('levels_id_seq'::regclass);

--math
insert into levels(level,next_level,skill,subject_id) values (1,2,'Count from 0 to 10',1);       
insert into levels(level,next_level,skill,subject_id) values (2,3,'Count from 10 to 20',1);       
insert into levels(level,next_level,skill,subject_id) values (3,4,'Count from 20 to 30',1);       
insert into levels(level,next_level,skill,subject_id) values (4,5,'Count from 30 to 40',1);       
insert into levels(level,next_level,skill,subject_id) values (5,6,'Count from 40 to 50',1);       
insert into levels(level,next_level,skill,subject_id) values (6,7,'Count from 50 to 60',1);       
insert into levels(level,next_level,skill,subject_id) values (7,8,'Count from 60 to 70',1);       
insert into levels(level,next_level,skill,subject_id) values (8,9,'Count from 70 to 80',1);       
insert into levels(level,next_level,skill,subject_id) values (9,10,'Count from 80 to 90',1);       
insert into levels(level,next_level,skill,subject_id) values (10,11,'Count from 90 to 100',1);       
--english
insert into levels(level,next_level,skill,subject_id) values (1,2,'Recognize and A',2);       


--------------------games---------------------------------------
CREATE TABLE games (
    id integer NOT NULL PRIMARY KEY,
    level integer NOT NULL,
    name text NOT NULL,
    url text NOT NULL,
    subject_id integer NOT NULL,
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);
ALTER TABLE public.games OWNER TO postgres;

--auto key
CREATE SEQUENCE games_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.games_id_seq OWNER TO postgres;
ALTER SEQUENCE games_id_seq OWNED BY users.id;
ALTER TABLE ONLY games ALTER COLUMN id SET DEFAULT nextval('games_id_seq'::regclass);

insert into games (level,name,url,subject_id) values (1,'Dungeon Count','../../template/math/count/count.php',1);
insert into games (level,name,url,subject_id) values (1,'Racing Count','../../template/math/count/count.php',1);
insert into games (level,name,url,subject_id) values (2,'Count','../../template/math/count/count.php',1);
insert into games (level,name,url,subject_id) values (3,'Count','../../template/math/count/count.php',1);
insert into games (level,name,url,subject_id) values (4,'Count','../../template/math/count/count.php',1);
insert into games (level,name,url,subject_id) values (5,'Count','../../template/math/count/count.php',1);
insert into games (level,name,url,subject_id) values (6,'Count','../../template/math/count/count.php',1);
insert into games (level,name,url,subject_id) values (7,'Count','../../template/math/count/count.php',1);
insert into games (level,name,url,subject_id) values (8,'Count','../../template/math/count/count.php',1);
insert into games (level,name,url,subject_id) values (9,'Count','../../template/math/count/count.php',1);
insert into games (level,name,url,subject_id) values (10,'Count','../../template/math/count/count.php',1);


--------------------counting---------------------------------------
CREATE TABLE counting (
    id integer NOT NULL PRIMARY KEY,
    level integer NOT NULL,
    score_needed integer DEFAULT 10 NOT NULL,
    start_number integer NOT NULL,
    end_number integer NOT NULL,
    count_by integer DEFAULT 1 NOT NULL,
    subject_id integer NOT NULL,
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);
ALTER TABLE public.counting OWNER TO postgres;

--auto key
CREATE SEQUENCE counting_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.counting_id_seq OWNER TO postgres;
ALTER SEQUENCE counting_id_seq OWNED BY counting.id;
ALTER TABLE ONLY counting ALTER COLUMN id SET DEFAULT nextval('counting_id_seq'::regclass);

insert into counting (level,score_needed,start_number,end_number,count_by,subject_id) values (1,10,0,10,1,1);
insert into counting (level,score_needed,start_number,end_number,count_by,subject_id) values (2,10,10,20,1,1);
insert into counting (level,score_needed,start_number,end_number,count_by,subject_id) values (3,10,20,30,1,1);
insert into counting (level,score_needed,start_number,end_number,count_by,subject_id) values (4,10,30,40,1,1);
insert into counting (level,score_needed,start_number,end_number,count_by,subject_id) values (5,10,40,50,1,1);
insert into counting (level,score_needed,start_number,end_number,count_by,subject_id) values (6,10,50,60,1,1);
insert into counting (level,score_needed,start_number,end_number,count_by,subject_id) values (7,10,60,70,1,1);
insert into counting (level,score_needed,start_number,end_number,count_by,subject_id) values (8,10,70,80,1,1);
insert into counting (level,score_needed,start_number,end_number,count_by,subject_id) values (9,10,80,90,1,1);
insert into counting (level,score_needed,start_number,end_number,count_by,subject_id) values (10,10,90,100,1,1);


--------------------addition---------------------------------------
CREATE TABLE addition (
    id integer NOT NULL PRIMARY KEY,
    level integer NOT NULL,
    score_needed integer DEFAULT 10 NOT NULL,
    addend_min integer NOT NULL,
    addend_max integer NOT NULL,
    number_of_addends integer DEFAULT 2 NOT NULL
);
ALTER TABLE public.addition OWNER TO postgres;

--auto key
CREATE SEQUENCE addition_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.addition_id_seq OWNER TO postgres;
ALTER SEQUENCE addition_id_seq OWNED BY users.id;
ALTER TABLE ONLY addition ALTER COLUMN id SET DEFAULT nextval('addition_id_seq'::regclass);

--------------------subtraction---------------------------------------
CREATE TABLE subtraction (
    id integer NOT NULL PRIMARY KEY,
    level integer NOT NULL,
    score_needed integer DEFAULT 10 NOT NULL,
    minuend_min integer NOT NULL,
    minuend_max integer NOT NULL,
    subtrahend_min integer NOT NULL,
    subtrahend_max integer NOT NULL,
    number_of_subtrahends integer DEFAULT 1 NOT NULL,
    negative_difference boolean DEFAULT false NOT NULL
);
ALTER TABLE public.subtraction OWNER TO postgres;

--auto key
CREATE SEQUENCE subtraction_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.subtraction_id_seq OWNER TO postgres;
ALTER SEQUENCE subtraction_id_seq OWNED BY subtraction.id;
ALTER TABLE ONLY subtraction ALTER COLUMN id SET DEFAULT nextval('subtraction_id_seq'::regclass);

--------------------REVOKE AND GRANT---------------------------------------
REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

